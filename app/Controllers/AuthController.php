<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;
use CodeIgniter\Database\BaseConnection;

class AuthController extends BaseController
{
    protected UserModel      $userModel;
    protected AuditLogModel  $auditModel;
    protected BaseConnection $db;

    public function __construct()
    {
        $this->userModel  = new UserModel();
        $this->auditModel = new AuditLogModel();
        $this->db         = \Config\Database::connect();
    }

    // ─── GET /login ──────────────────────────────────────────────
    public function login(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }

        return view('auth/login', ['title' => 'Login']);
    }

    // ─── POST /login ─────────────────────────────────────────────
    public function loginPost(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        $password = $this->request->getPost('password');

        // ✅ Direct db query — avoids CI4 4.7.x BaseBuilder::setBind() TypeError
        $user = $this->db->table('users')
            ->select('users.user_id, users.full_name, users.email, users.password, users.status, users.role_id, roles.role_name')
            ->join('roles', 'roles.role_id = users.role_id', 'left')
            ->where('users.email', $email)
            ->get()
            ->getRowArray();

        // Wrong credentials
        if (! $user || ! password_verify($password, $user['password'])) {
            $this->logAudit(null, 'LOGIN_FAILED', "Failed login attempt for: {$email}");

            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        // Inactive account
        if ($user['status'] !== 'active') {
            $this->logAudit($user['user_id'], 'LOGIN_BLOCKED', "Inactive account login attempt: {$email}");

            return redirect()->back()
                ->withInput()
                ->with('error', 'Your account is inactive. Please contact the administrator.');
        }

        // ✅ Set session
        session()->set([
            'user_id'    => $user['user_id'],
            'full_name'  => $user['full_name'],
            'email'      => $user['email'],
            'role_id'    => $user['role_id'],
            'role_name'  => $user['role_name'],
            'isLoggedIn' => true,
        ]);

        $this->logAudit($user['user_id'], 'LOGIN', "User {$user['full_name']} logged in.");

        return $this->redirectByRole();
    }

    // ─── GET /logout ─────────────────────────────────────────────
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = session()->get('user_id');
        $name   = session()->get('full_name') ?? 'Unknown';

        $this->logAudit($userId, 'LOGOUT', "User {$name} logged out.");

        session()->destroy();

        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }

    // ─── Helpers ─────────────────────────────────────────────────

    /**
     * Redirect based on role after login.
     */
    private function redirectByRole(): \CodeIgniter\HTTP\RedirectResponse
    {
        $role = session()->get('role_name');

        return match ($role) {
            'Admin'   => redirect()->to('/admin/dashboard'),
            'Manager' => redirect()->to('/manager/dashboard'),
            default   => redirect()->to('/staff/dashboard'),
        };
    }

    /**
     * Safe audit log wrapper.
     */
    private function logAudit(?int $userId, string $action, string $description): void
    {
        try {
            $this->auditModel->insert([
                'user_id'     => $userId,
                'action'      => $action,
                'description' => $description,
                'ip_address'  => $this->request->getIPAddress(),
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', "Audit log failed: {$e->getMessage()}");
        }
    }
}
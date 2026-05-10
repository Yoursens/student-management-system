<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\AuditLogModel;

class UserController extends BaseController
{
    protected UserModel    $userModel;
    protected RoleModel    $roleModel;
    protected AuditLogModel $auditModel;

    public function __construct()
    {
        $this->userModel  = new UserModel();
        $this->roleModel  = new RoleModel();
        $this->auditModel = new AuditLogModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Manage Users',
            'users' => $this->userModel->getAllWithRoles(),
        ];
        return view('admin/users/index', $data);
    }

    public function create(): string
    {
        return view('admin/users/create', [
            'title' => 'Add User',
            'roles' => $this->roleModel->findAll(),
        ]);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]',
            'role_id'   => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'full_name' => esc($this->request->getPost('full_name')),
            'email'     => esc($this->request->getPost('email')),
            'password'  => $this->request->getPost('password'), // Model hashes it
            'role_id'   => (int) $this->request->getPost('role_id'),
            'status'    => 'active',
        ]);

        $email = esc($this->request->getPost('email'));
        $this->auditModel->log('CREATE_USER', "Created user: {$email}");
        return redirect()->to('/admin/users')->with('success', 'User created successfully.');
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        return view('admin/users/edit', [
            'title' => 'Edit User',
            'user'  => $user,
            'roles' => $this->roleModel->findAll(),
        ]);
    }

    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email'     => "required|valid_email|is_unique[users.email,user_id,{$id}]",
            'role_id'   => 'required|integer',
            'status'    => 'required|in_list[active,inactive]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'full_name' => esc($this->request->getPost('full_name')),
            'email'     => esc($this->request->getPost('email')),
            'role_id'   => (int) $this->request->getPost('role_id'),
            'status'    => $this->request->getPost('status'),
        ];

        $newPassword = $this->request->getPost('password');
        if (! empty($newPassword)) {
            $updateData['password'] = $newPassword; // Model hashes it
        }

        $this->userModel->update($id, $updateData);
        $this->auditModel->log('UPDATE_USER', "Updated user ID #{$id}");
        return redirect()->to('/admin/users')->with('success', 'User updated.');
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        // Prevent self-deletion
        if ($id === (int) session()->get('user_id')) {
            return redirect()->back()->with('error', 'Cannot delete your own account.');
        }

        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $this->userModel->delete($id);
        $this->auditModel->log('DELETE_USER', "Deleted user: {$user['email']}");
        return redirect()->to('/admin/users')->with('success', 'User deleted.');
    }
}

<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ─── Not logged in → redirect to login ───────────────
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        // ─── Role-based access control ────────────────────────
        if ($arguments) {
            $allowedRoles = $arguments;
            $userRole     = session()->get('role_name');

            if (! in_array($userRole, $allowedRoles)) {
                if ($userRole === 'Admin') {
                    return redirect()->to('/admin/dashboard')
                        ->with('error', 'Access denied.');
                }
                return redirect()->to('/staff/dashboard')
                    ->with('error', 'Access denied. Insufficient privileges.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Frame-Options', 'DENY');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
    }
}
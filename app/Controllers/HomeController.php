<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function landing(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        // If already logged in, skip landing page
        if (session()->get('isLoggedIn')) {
            $role = session()->get('role_name');

            return match ($role) {
                'Admin'   => redirect()->to('/admin/dashboard'),
                'Manager' => redirect()->to('/manager/dashboard'),
                default   => redirect()->to('/staff/dashboard'),
            };
        }

        return view('landing', ['title' => 'Welcome']);
    }
}
<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\AuditLogModel;

class AdminController extends BaseController
{
    protected StudentModel  $studentModel;
    protected UserModel     $userModel;
    protected AuditLogModel $auditModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel    = new UserModel();
        $this->auditModel   = new AuditLogModel();
    }

    public function dashboard(): string
    {
        $data = [
            'title'          => 'Admin Dashboard',
            'totalStudents'  => $this->studentModel->countAll(),
            'totalUsers'     => $this->userModel->countAll(),
            'recentStudents' => $this->studentModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recentLogs'     => $this->auditModel->select('audit_logs.*, users.full_name')
                                    ->join('users', 'users.user_id = audit_logs.user_id', 'left')
                                    ->orderBy('created_at', 'DESC')
                                    ->limit(8)
                                    ->findAll(),
        ];
        return view('admin/dashboard', $data);
    }

    public function auditLogs(): string
    {
        $data = [
            'title'  => 'Audit Logs',
            'logs'   => $this->auditModel->getLogsWithUsers(15),
            'pager'  => $this->auditModel->pager,
        ];
        return view('admin/audit_logs', $data);
    }
}

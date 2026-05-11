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

    // ─── Dashboard ────────────────────────────────────────────────
    public function dashboard(): string
    {
        $data = [
            'title'          => 'Admin Dashboard',
            'totalStudents'  => $this->studentModel->countAll(),
            'totalUsers'     => $this->userModel->countAll(),
            'recentStudents' => $this->studentModel
                                    ->orderBy('created_at', 'DESC')
                                    ->limit(5)
                                    ->findAll(),
            'recentLogs'     => $this->auditModel->getLogsWithUsers(8),
        ];
        return view('admin/dashboard', $data);
    }

    // ─── Audit Logs ───────────────────────────────────────────────
    public function auditLogs(): string
    {
        $data = [
            'title' => 'Audit Logs',
            'logs'  => $this->auditModel->getLogsWithUsers(15),
            'pager' => $this->auditModel->pager,
        ];
        return view('admin/audit_logs', $data);
    }
}
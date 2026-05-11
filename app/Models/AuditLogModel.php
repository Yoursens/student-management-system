<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'log_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = ['user_id', 'action', 'description'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    public function log(string $action, string $description): void
    {
        $this->insert([
            'user_id'     => session()->get('user_id') ?? null,
            'action'      => $action,
            'description' => $description,
        ]);
    }

    public function getLogsWithUsers(int $perPage = 20): array
    {
        return $this->select('audit_logs.*, users.full_name')
            ->join('users', 'users.user_id = audit_logs.user_id', 'left')
            ->orderBy('audit_logs.created_at', 'DESC')
            ->paginate($perPage);
    }
}
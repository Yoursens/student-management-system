<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'full_name', 'email', 'password', 'role_id', 'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ✅ FIXED: is_unique now explicitly references user_id column
    // so CI4 doesn't fall back to a numeric index (which breaks PHP 8.x)
    protected $validationRules = [
        'full_name' => 'required|min_length[2]|max_length[100]',
        'email'     => 'required|valid_email|is_unique[users.email,user_id,0]',
        'role_id'   => 'required|integer',
    ];

    protected $validationMessages = [
        'full_name' => [
            'required'   => 'Full name is required.',
            'min_length' => 'Full name must be at least 2 characters.',
            'max_length' => 'Full name must not exceed 100 characters.',
        ],
        'email' => [
            'required'    => 'Email address is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique'   => 'This email address is already registered.',
        ],
        'role_id' => [
            'required' => 'A role must be assigned.',
            'integer'  => 'Invalid role selected.',
        ],
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password']) && ! empty($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'],
                PASSWORD_BCRYPT,
                ['cost' => 12]
            );
        } elseif (isset($data['data']['password'])) {
            // Remove empty password field so it doesn't overwrite existing hash
            unset($data['data']['password']);
        }

        return $data;
    }

    /**
     * Find a user by ID, joined with their role name.
     */
    public function getUserWithRole(int $userId): ?array
    {
        return $this->db->table('users')
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.role_id = users.role_id')
            ->where('users.user_id', $userId)
            ->get()
            ->getRowArray();
    }

    /**
     * Find a user by email, joined with their role name.
     * Used for login authentication.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->db->table('users')
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.role_id = users.role_id')
            ->where('users.email', $email)
            ->get()
            ->getRowArray();
    }

    /**
     * Get all users joined with their role names.
     */
    public function getAllWithRoles(): array
    {
        return $this->db->table('users')
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.role_id = users.role_id')
            ->orderBy('users.full_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Update validation rules at runtime to skip the current user's
     * own email when editing (prevents false "already taken" error).
     *
     * Usage: $userModel->setUpdateValidation($userId)->save($data);
     */
    public function setUpdateValidation(int $userId): static
    {
        $this->validationRules['email'] =
            "required|valid_email|is_unique[users.email,user_id,{$userId}]";

        return $this;
    }
}
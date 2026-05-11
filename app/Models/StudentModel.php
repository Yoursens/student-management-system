<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'student_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'student_no', 'first_name', 'last_name', 'middle_name',
        'sex', 'birthdate', 'program', 'year_level', 'section',
        'email', 'contact_no', 'address', 'photo', 'created_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ─── Search + paginate with creator name ──────────────────────
    public function getStudentsWithCreator(string $search = '', int $perPage = 10): array
    {
        $builder = $this->select('students.*, users.full_name AS created_by_name')
            ->join('users', 'users.user_id = students.created_by', 'left');

        if ($search !== '') {
            $builder->groupStart()
                ->like('students.first_name', $search)
                ->orLike('students.last_name', $search)
                ->orLike('students.student_no', $search)
                ->orLike('students.program', $search)
                ->orLike('students.section', $search)
                ->groupEnd();
        }

        return $builder->orderBy('students.created_at', 'DESC')
                       ->paginate($perPage);
    }

    // ─── Count for search total ───────────────────────────────────
    public function countSearch(string $search = ''): int
    {
        $builder = $this->db->table('students');

        if ($search !== '') {
            $builder->groupStart()
                ->like('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('student_no', $search)
                ->orLike('program', $search)
                ->orLike('section', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    // ─── API: full list ordered by last name ──────────────────────
    public function getAllForApi(): array
    {
        return $this->select('student_id, student_no, first_name, last_name, middle_name, sex, birthdate, program, year_level, section, email, contact_no, created_at')
            ->orderBy('last_name', 'ASC')
            ->findAll();
    }
}
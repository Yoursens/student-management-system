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

    protected $validationRules = [
        'student_no' => 'required|max_length[30]|is_unique[students.student_no,student_id,{student_id}]',
        'first_name' => 'required|max_length[50]',
        'last_name'  => 'required|max_length[50]',
        'sex'        => 'required|in_list[Male,Female,Other]',
        'program'    => 'required',
        'year_level' => 'required|integer|greater_than[0]|less_than[7]',
        'email'      => 'permit_empty|valid_email',
    ];

    public function getStudentsWithCreator(string $search = '', int $perPage = 10): array
    {
        $builder = $this->select('students.*, users.full_name AS created_by_name')
            ->join('users', 'users.user_id = students.created_by', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('students.first_name', $search)
                ->orLike('students.last_name', $search)
                ->orLike('students.student_no', $search)
                ->orLike('students.program', $search)
                ->orLike('students.section', $search)
                ->groupEnd();
        }

        $builder->orderBy('students.created_at', 'DESC');
        return $builder->paginate($perPage);
    }

    public function countSearch(string $search = ''): int
    {
        $builder = $this->builder();
        if ($search) {
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

    public function getAllForApi(): array
    {
        return $this->select('student_id, student_no, first_name, last_name, middle_name, sex, birthdate, program, year_level, section, email, contact_no, created_at')
            ->orderBy('last_name', 'ASC')
            ->findAll();
    }
}

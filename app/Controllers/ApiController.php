<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    protected StudentModel $studentModel;
    protected UserModel    $userModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel    = new UserModel();
    }

    /**
     * GET /api/students
     * Returns paginated list of all students
     */
    public function students(): ResponseInterface
    {
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);
        $search  = $this->request->getGet('search') ?? '';

        // Clamp
        $perPage = min(max($perPage, 1), 100);
        $page    = max($page, 1);

        $builder = $this->studentModel
            ->select('student_id, student_no, first_name, last_name, middle_name, sex, birthdate, program, year_level, section, email, contact_no, created_at');

        if ($search) {
            $builder->groupStart()
                ->like('first_name', esc($search))
                ->orLike('last_name', esc($search))
                ->orLike('student_no', esc($search))
                ->orLike('program', esc($search))
                ->groupEnd();
        }

        $total    = $builder->countAllResults(false);
        $students = $builder->orderBy('last_name', 'ASC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->findAll();

        return $this->response->setStatusCode(200)->setJSON([
            'status'  => 'success',
            'page'    => $page,
            'per_page'=> $perPage,
            'total'   => $total,
            'pages'   => (int) ceil($total / $perPage),
            'data'    => $students,
        ]);
    }

    /**
     * GET /api/students/{id}
     * Returns a single student by ID
     */
    public function studentById(int $id): ResponseInterface
    {
        $student = $this->studentModel
            ->select('student_id, student_no, first_name, last_name, middle_name, sex, birthdate, program, year_level, section, email, contact_no, address, created_at, updated_at')
            ->find($id);

        if (! $student) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Student not found.',
            ]);
        }

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'data'   => $student,
        ]);
    }

    /**
     * GET /api/users
     * Returns list of users (admin only — role checked in filter)
     */
    public function users(): ResponseInterface
    {
        $users = $this->userModel
            ->select('users.user_id, users.full_name, users.email, users.status, roles.role_name, users.created_at')
            ->join('roles', 'roles.role_id = users.role_id')
            ->orderBy('users.full_name', 'ASC')
            ->findAll();

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'total'  => count($users),
            'data'   => $users,
        ]);
    }

    /**
     * GET /api/stats
     * Summary statistics
     */
    public function stats(): ResponseInterface
    {
        $totalStudents = $this->studentModel->countAll();
        $totalUsers    = $this->userModel->countAll();

        // Students per program
        $byProgram = $this->studentModel
            ->select('program, COUNT(*) as count')
            ->groupBy('program')
            ->orderBy('count', 'DESC')
            ->findAll();

        // Students per year level
        $byYear = $this->studentModel
            ->select('year_level, COUNT(*) as count')
            ->groupBy('year_level')
            ->orderBy('year_level', 'ASC')
            ->findAll();

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'data'   => [
                'total_students'       => $totalStudents,
                'total_users'          => $totalUsers,
                'students_by_program'  => $byProgram,
                'students_by_year'     => $byYear,
            ],
        ]);
    }
}

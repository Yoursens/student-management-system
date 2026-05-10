<?php

namespace App\Controllers;

use App\Models\StudentModel;

class StaffController extends BaseController
{
    protected StudentModel $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    public function dashboard(): string
    {
        $data = [
            'title'         => 'Staff Dashboard',
            'totalStudents' => $this->studentModel->countAll(),
            'myStudents'    => $this->studentModel
                                ->where('created_by', session()->get('user_id'))
                                ->countAllResults(),
            'recentStudents'=> $this->studentModel
                                ->orderBy('created_at', 'DESC')
                                ->limit(5)
                                ->findAll(),
        ];
        return view('staff/dashboard', $data);
    }
}

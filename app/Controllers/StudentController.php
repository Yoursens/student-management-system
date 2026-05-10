<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\AuditLogModel;

class StudentController extends BaseController
{
    protected StudentModel  $studentModel;
    protected AuditLogModel $auditModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->auditModel   = new AuditLogModel();
    }

    // ─── Admin: list with search & pagination ─────────────────────
    public function index(): string
    {
        $search  = $this->request->getGet('search') ?? '';
        $perPage = 10;

        $data = [
            'title'    => 'Manage Students',
            'students' => $this->studentModel->getStudentsWithCreator(esc($search), $perPage),
            'pager'    => $this->studentModel->pager,
            'search'   => esc($search),
            'total'    => $this->studentModel->countSearch($search),
        ];
        return view('admin/students/index', $data);
    }

    // ─── Staff: read-only list ─────────────────────────────────────
    public function indexStaff(): string
    {
        $search  = $this->request->getGet('search') ?? '';
        $perPage = 10;

        $data = [
            'title'    => 'Students',
            'students' => $this->studentModel->getStudentsWithCreator(esc($search), $perPage),
            'pager'    => $this->studentModel->pager,
            'search'   => esc($search),
            'total'    => $this->studentModel->countSearch($search),
        ];
        return view('staff/students', $data);
    }

    // ─── View single student ──────────────────────────────────────
    public function view(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $student = $this->studentModel->find($id);
        if (! $student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        return view('admin/students/view', ['title' => 'Student Details', 'student' => $student]);
    }

    // ─── Create form ──────────────────────────────────────────────
    public function create(): string
    {
        return view('admin/students/create', ['title' => 'Add Student']);
    }

    // ─── Store ────────────────────────────────────────────────────
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'student_no' => 'required|max_length[30]|is_unique[students.student_no]',
            'first_name' => 'required|max_length[50]|alpha_space',
            'last_name'  => 'required|max_length[50]|alpha_space',
            'sex'        => 'required|in_list[Male,Female,Other]',
            'program'    => 'required|max_length[100]',
            'year_level' => 'required|integer|greater_than[0]|less_than[7]',
            'email'      => 'permit_empty|valid_email|max_length[100]',
            'contact_no' => 'permit_empty|max_length[20]',
            'birthdate'  => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $photoName = null;
        $photo     = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && ! $photo->hasMoved()) {
            if (! in_array($photo->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid photo format.');
            }
            if ($photo->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Photo too large (max 2MB).');
            }
            $photoName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/students', $photoName);
        }

        $this->studentModel->insert([
            'student_no'  => esc($this->request->getPost('student_no')),
            'first_name'  => esc($this->request->getPost('first_name')),
            'last_name'   => esc($this->request->getPost('last_name')),
            'middle_name' => esc($this->request->getPost('middle_name')),
            'sex'         => $this->request->getPost('sex'),
            'birthdate'   => $this->request->getPost('birthdate') ?: null,
            'program'     => esc($this->request->getPost('program')),
            'year_level'  => (int) $this->request->getPost('year_level'),
            'section'     => esc($this->request->getPost('section')),
            'email'       => esc($this->request->getPost('email')),
            'contact_no'  => esc($this->request->getPost('contact_no')),
            'address'     => esc($this->request->getPost('address')),
            'photo'       => $photoName,
            'created_by'  => session()->get('user_id'),
        ]);

        $sno = esc($this->request->getPost('student_no'));
        $this->auditModel->log('CREATE_STUDENT', "Added student #{$sno}");

        return redirect()->to('/admin/students')->with('success', 'Student added successfully.');
    }

    // ─── Edit form ────────────────────────────────────────────────
    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $student = $this->studentModel->find($id);
        if (! $student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        return view('admin/students/edit', ['title' => 'Edit Student', 'student' => $student]);
    }

    // ─── Update ───────────────────────────────────────────────────
    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $student = $this->studentModel->find($id);
        if (! $student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $rules = [
            'student_no' => "required|max_length[30]|is_unique[students.student_no,student_id,{$id}]",
            'first_name' => 'required|max_length[50]|alpha_space',
            'last_name'  => 'required|max_length[50]|alpha_space',
            'sex'        => 'required|in_list[Male,Female,Other]',
            'program'    => 'required|max_length[100]',
            'year_level' => 'required|integer|greater_than[0]|less_than[7]',
            'email'      => 'permit_empty|valid_email|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $photoName = $student['photo'];
        $photo     = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && ! $photo->hasMoved()) {
            if (! in_array($photo->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid photo format.');
            }
            $photoName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/students', $photoName);
        }

        $this->studentModel->update($id, [
            'student_no'  => esc($this->request->getPost('student_no')),
            'first_name'  => esc($this->request->getPost('first_name')),
            'last_name'   => esc($this->request->getPost('last_name')),
            'middle_name' => esc($this->request->getPost('middle_name')),
            'sex'         => $this->request->getPost('sex'),
            'birthdate'   => $this->request->getPost('birthdate') ?: null,
            'program'     => esc($this->request->getPost('program')),
            'year_level'  => (int) $this->request->getPost('year_level'),
            'section'     => esc($this->request->getPost('section')),
            'email'       => esc($this->request->getPost('email')),
            'contact_no'  => esc($this->request->getPost('contact_no')),
            'address'     => esc($this->request->getPost('address')),
            'photo'       => $photoName,
        ]);

        $this->auditModel->log('UPDATE_STUDENT', "Updated student ID #{$id}");
        return redirect()->to('/admin/students')->with('success', 'Student updated successfully.');
    }

    // ─── Delete ───────────────────────────────────────────────────
    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $student = $this->studentModel->find($id);
        if (! $student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $this->studentModel->delete($id);
        $this->auditModel->log('DELETE_STUDENT', "Deleted student {$student['first_name']} {$student['last_name']} (#{$student['student_no']})");

        return redirect()->to('/admin/students')->with('success', 'Student deleted.');
    }
}

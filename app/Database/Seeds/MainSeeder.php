<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles ──────────────────────────────────────────
        $this->db->table('roles')->truncate();
        $this->db->table('roles')->insertBatch([
            ['role_name' => 'Admin'],
            ['role_name' => 'Staff'],
        ]);

        // ── Users ──────────────────────────────────────────
        $this->db->table('users')->truncate();
        $this->db->table('users')->insertBatch([
            [
                'full_name'  => 'System Admin',
                'email'      => 'admin@studentsys.com',
                'password'   => password_hash('Admin@1234', PASSWORD_BCRYPT, ['cost' => 12]),
                'role_id'    => 1,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'full_name'  => 'Registrar Staff',
                'email'      => 'staff@studentsys.com',
                'password'   => password_hash('Staff@1234', PASSWORD_BCRYPT, ['cost' => 12]),
                'role_id'    => 2,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // ── Sample Students ────────────────────────────────
        $this->db->table('students')->truncate();

        $programs = ['BS Computer Science', 'BS Information Technology', 'BS Computer Engineering', 'BS Information Systems'];
        $sections = ['A', 'B', 'C'];
        $students = [
            ['2024-0001', 'Maria',   'Santos',     'Cruz',      'Female', '2002-03-15', 3],
            ['2024-0002', 'Juan',    'Dela Cruz',  'Reyes',     'Male',   '2001-07-22', 4],
            ['2024-0003', 'Ana',     'Garcia',     'Lopez',     'Female', '2003-01-10', 2],
            ['2024-0004', 'Pedro',   'Reyes',      'Santos',    'Male',   '2002-11-05', 3],
            ['2024-0005', 'Luz',     'Flores',     'Mendoza',   'Female', '2001-09-18', 4],
            ['2024-0006', 'Carlo',   'Mendoza',    'Bautista',  'Male',   '2003-04-25', 2],
            ['2024-0007', 'Rosa',    'Bautista',   'Torres',    'Female', '2002-06-12', 3],
            ['2024-0008', 'Jose',    'Torres',     'Villanueva','Male',   '2001-12-30', 4],
            ['2024-0009', 'Elena',   'Villanueva', 'Espinosa',  'Female', '2003-08-07', 1],
            ['2024-0010', 'Miguel',  'Espinosa',   'Ramos',     'Male',   '2002-02-14', 2],
            ['2024-0011', 'Cathy',   'Ramos',      'De Leon',   'Female', '2003-05-19', 1],
            ['2024-0012', 'Rafael',  'De Leon',    'Castillo',  'Male',   '2001-10-08', 4],
        ];

        foreach ($students as $i => $s) {
            $this->db->table('students')->insert([
                'student_no'  => $s[0],
                'first_name'  => $s[1],
                'last_name'   => $s[2],
                'middle_name' => $s[3],
                'sex'         => $s[4],
                'birthdate'   => $s[5],
                'program'     => $programs[$i % count($programs)],
                'year_level'  => $s[6],
                'section'     => $sections[$i % count($sections)],
                'email'       => strtolower($s[1]) . '@student.edu.ph',
                'contact_no'  => '0917' . str_pad($i + 1, 7, '0', STR_PAD_LEFT),
                'created_by'  => ($i % 2 === 0) ? 1 : 2,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        echo "✅  Seeded: roles, users, students.\n";
        echo "   Admin login : admin@studentsys.com / Admin@1234\n";
        echo "   Staff login : staff@studentsys.com / Staff@1234\n";
    }
}

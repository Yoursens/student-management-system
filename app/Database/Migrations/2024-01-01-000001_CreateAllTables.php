<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAllTables extends Migration
{
    public function up(): void
    {
        // ── roles ─────────────────────────────────────────────
        $this->db->disableForeignKeyChecks();

        if (! $this->db->tableExists('roles')) {
            $this->forge->addField([
                'role_id'   => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
                'role_name' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false, 'unique' => true],
            ]);
            $this->forge->addPrimaryKey('role_id');
            $this->forge->createTable('roles');
        }

        // ── users ─────────────────────────────────────────────
        if (! $this->db->tableExists('users')) {
            $this->forge->addField([
                'user_id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
                'full_name'  => ['type' => 'VARCHAR', 'constraint' => 100],
                'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
                'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
                'role_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'status'     => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
                'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
                'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
            ]);
            $this->forge->addPrimaryKey('user_id');
            $this->forge->addForeignKey('role_id', 'roles', 'role_id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('users');
        }

        // ── students ──────────────────────────────────────────
        if (! $this->db->tableExists('students')) {
            $this->forge->addField([
                'student_id'  => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
                'student_no'  => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
                'first_name'  => ['type' => 'VARCHAR', 'constraint' => 50],
                'last_name'   => ['type' => 'VARCHAR', 'constraint' => 50],
                'middle_name' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
                'sex'         => ['type' => 'ENUM', 'constraint' => ['Male', 'Female', 'Other']],
                'birthdate'   => ['type' => 'DATE', 'null' => true],
                'program'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'year_level'  => ['type' => 'INT', 'constraint' => 1, 'null' => true],
                'section'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
                'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'contact_no'  => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
                'address'     => ['type' => 'TEXT', 'null' => true],
                'photo'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'created_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'created_at'  => ['type' => 'TIMESTAMP', 'null' => true],
                'updated_at'  => ['type' => 'TIMESTAMP', 'null' => true],
            ]);
            $this->forge->addPrimaryKey('student_id');
            $this->forge->addForeignKey('created_by', 'users', 'user_id', 'SET NULL', 'SET NULL');
            $this->forge->createTable('students');
        }

        // ── audit_logs ────────────────────────────────────────
        if (! $this->db->tableExists('audit_logs')) {
            $this->forge->addField([
                'log_id'      => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
                'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'action'      => ['type' => 'VARCHAR', 'constraint' => 100],
                'description' => ['type' => 'TEXT', 'null' => true],
                'created_at'  => ['type' => 'TIMESTAMP', 'null' => true],
            ]);
            $this->forge->addPrimaryKey('log_id');
            $this->forge->addForeignKey('user_id', 'users', 'user_id', 'SET NULL', 'SET NULL');
            $this->forge->createTable('audit_logs');
        }

        $this->db->enableForeignKeyChecks();
    }

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('audit_logs', true);
        $this->forge->dropTable('students', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('roles', true);
        $this->db->enableForeignKeyChecks();
    }
}

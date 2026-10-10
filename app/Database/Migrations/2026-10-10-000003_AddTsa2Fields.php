<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTsa2Fields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tasks', [
            'is_archived' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'status',
            ],
        ]);

        $this->forge->addColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => '',
                'null'       => false,
                'after'      => 'email',
            ],
        ]);

        $this->db->table('users')->update([
            'password' => password_hash('Password123!', PASSWORD_DEFAULT),
        ]);

        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tasks', 'is_archived');
        $this->forge->dropColumn('users', 'password');
    }
}

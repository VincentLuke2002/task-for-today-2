<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateTimeImmutable;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $today = new DateTimeImmutable('today');
        $createdAt = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $tasks = [
            ['title' => 'Review project brief and success criteria', 'status' => 'completed', 'task_date' => $today->modify('-2 days')->format('Y-m-d')],
            ['title' => 'Sketch the dashboard information hierarchy', 'status' => 'completed', 'task_date' => $today->modify('-2 days')->format('Y-m-d')],
            ['title' => 'Prepare the task and user migrations', 'status' => 'in_progress', 'task_date' => $today->modify('-1 day')->format('Y-m-d')],
            ['title' => 'Connect models to the shared data layer', 'status' => 'pending', 'task_date' => $today->modify('-1 day')->format('Y-m-d')],
            ['title' => 'Check the daily priorities with the team', 'status' => 'in_progress', 'task_date' => $today->format('Y-m-d')],
            ['title' => 'Finish the responsive task dashboard', 'status' => 'pending', 'task_date' => $today->format('Y-m-d')],
            ['title' => 'Validate every application route', 'status' => 'pending', 'task_date' => $today->format('Y-m-d')],
            ['title' => 'Write the setup guide for the repository', 'status' => 'pending', 'task_date' => $today->modify('+1 day')->format('Y-m-d')],
            ['title' => 'Run a final mobile layout review', 'status' => 'pending', 'task_date' => $today->modify('+1 day')->format('Y-m-d')],
            ['title' => 'Prepare the hosted demonstration', 'status' => 'pending', 'task_date' => $today->modify('+2 days')->format('Y-m-d')],
        ];

        foreach ($tasks as &$task) {
            $task['created_at'] = $createdAt;
            $task['is_archived'] = 0;
        }
        unset($task);

        $this->db->table('tasks')->insertBatch($tasks);
        $this->db->table('users')->insert([
            'username'   => 'demo.user',
            'full_name'  => 'Vincent Luke Elpedez',
            'email'      => 'elpedezvincent@gmail.com',
            'password'   => password_hash('Password123!', PASSWORD_DEFAULT),
            'created_at' => $createdAt,
        ]);
    }
}

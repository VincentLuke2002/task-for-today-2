<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Tasks extends BaseController
{
    public function index(): string
    {
        $tasks = (new TaskModel())->allByDate();
        $groups = [];

        foreach ($tasks as $task) {
            $groups[$task['task_date']][] = $task;
        }

        return view('tasks/index', [
            'title'  => 'Task List',
            'active' => 'tasks',
            'groups' => $groups,
            'total'  => count($tasks),
        ]);
    }

    public function new(): string
    {
        return view('tasks/form', [
            'title'      => 'New Task',
            'active'     => 'tasks',
            'heading'    => 'Create a new task.',
            'formAction' => site_url('tasks'),
            'task'       => [],
            'isEdit'     => false,
        ]);
    }

    public function create(): RedirectResponse
    {
        $data = $this->taskData();

        if (! $this->validateData($data, $this->taskRules())) {
            return redirect()->to(site_url('tasks/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['is_archived'] = 0;
        (new TaskModel())->insert($data);

        return redirect()->to(site_url('tasks'))->with('message', 'Task created successfully.');
    }

    public function edit(int $id): string
    {
        $task = $this->findActiveTask($id);

        return view('tasks/form', [
            'title'      => 'Edit Task',
            'active'     => 'tasks',
            'heading'    => 'Update this task.',
            'formAction' => site_url("tasks/{$id}"),
            'task'       => $task,
            'isEdit'     => true,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $this->findActiveTask($id);
        $data = $this->taskData();

        if (! $this->validateData($data, $this->taskRules())) {
            return redirect()->to(site_url("tasks/{$id}/edit"))->withInput()->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->update($id, $data);

        return redirect()->to(site_url('tasks'))->with('message', 'Task updated successfully.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $task = $this->findActiveTask($id);
        $isCompleted = $task['status'] === 'completed';
        $newStatus = $isCompleted ? 'pending' : 'completed';
        (new TaskModel())->update($id, ['status' => $newStatus]);

        $message = $isCompleted
            ? 'Task reopened and moved back to pending.'
            : 'Task completed. Nice work.';

        $returnTo = $this->request->getPost('return_to') === 'today' ? '/' : '/tasks';

        return redirect()->to(site_url($returnTo))->with('message', $message);
    }

    public function delete(int $id): RedirectResponse
    {
        $this->findActiveTask($id);
        (new TaskModel())->update($id, ['is_archived' => 1]);

        return redirect()->to(site_url('tasks'))->with('message', 'Task archived successfully.');
    }

    private function taskData(): array
    {
        return [
            'title'     => trim((string) $this->request->getPost('title')),
            'task_date' => trim((string) $this->request->getPost('task_date')),
            'status'    => trim((string) $this->request->getPost('status')),
        ];
    }

    private function taskRules(): array
    {
        return [
            'title' => [
                'label'  => 'Title',
                'rules'  => 'required|max_length[150]',
                'errors' => ['required' => 'Task title is required.'],
            ],
            'task_date' => [
                'label'  => 'Task date',
                'rules'  => 'required|valid_date[Y-m-d]',
                'errors' => ['required' => 'Task date is required.'],
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[pending,in_progress,completed]',
            ],
        ];
    }

    private function findActiveTask(int $id): array
    {
        $task = (new TaskModel())->where('is_archived', 0)->find($id);

        if ($task === null) {
            throw PageNotFoundException::forPageNotFound('Task not found.');
        }

        return $task;
    }
}

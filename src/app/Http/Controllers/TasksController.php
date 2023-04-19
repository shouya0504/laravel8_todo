<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Http\Requests\TasksRequest;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('updated_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function show($id)
    {
        $task = Task::find($id);
        return view('tasks.show', compact('task'));
    }

    public function add()
    {
        return view('tasks.add');
    }

    public function store(TasksRequest $request)
    {
        // tasksテーブルにフォームで入力した値を挿入する
        $result = Task::create([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        // タスク一覧画面にリダイレクト
        return redirect()->route('tasks.index');
    }

    /**
     * タスク編集画面
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(TasksRequest $request, $id)
    {
        // idを条件にtasksテーブルからレコードを取得
        $task = Task::find($id);
        // 更新処理
        $task->fill([
            'name' => $request->name,
            'content' => $request->content,
        ])
        ->save();

        // タスク一覧画面にリダイレクト
        return redirect()->route('tasks.index');
    }

    /**
     * タスク削除処理
     */
    public function delete($id)
    {
        // idを条件にtasksテーブルから該当レコードを削除
        $task = Task::destroy($id);

        // タスク一覧画面にリダイレクト
        return redirect()->route('tasks.index');
    }


}

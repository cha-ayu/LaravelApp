<?php

namespace App\Http\Controllers;

// クラスのインポート
use App\Folder;                         // フォルダクラス
use App\Task;                           // タスククラス
use App\Http\Requests\CreateTask;       // FormRequestクラス
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // インデックスメソッド: {id}と定義→ $id で受け取る
    public function index(int $id)
    {
        // Folderモデルのallクラスメソッドで全てのフォルダデータをDBから取得
        $folders = Folder::all();

        // 選ばれたフォルダを取得
        // フォルダテーブルからIDカラムが一致するデータを返す
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得
        // whereメソッドでデータ取得し、getメソッドでSQLをDBに発行した結果を取得
        $tasks = $current_folder->tasks()->get();

        // 1.取得したデータをテンプレートに渡した結果を返している（テンプレファイル名, [渡すデータ]配列）
        // 2.テンプレをレンダリングした結果のHTMLがブラウザにレスポンスされる
        // 3.選択されたフォルダのidをテンプレに渡す
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
     */
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    // createメソッド
    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        // リレーションによりデータ保存
        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }
}

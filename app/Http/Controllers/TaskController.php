<?php

namespace App\Http\Controllers;

use App\Folder;     //add
use App\Task;       //add
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // {id}と定義→ $id で受け取る
    public function index(int $id)
    {
        //Folderモデルのallクラスメソッドで全てのフォルダデータをDBから取得
        $folders = Folder::all();

        //選ばれたフォルダを取得
        //フォルダテーブルからIDカラムが一致するデータを返す
        $current_folder = Folder::find($id);

        //選ばれたフォルダに紐づくタスクを取得
        //whereメソッドでデータ取得し、getメソッドでSQLをDBに発行した結果を取得
        $tasks = $current_folder->tasks()->get();

        //1.取得したデータをテンプレートに渡した結果を返している（テンプレファイル名, [渡すデータ]配列）
        //2.テンプレをレンダリングした結果のHTMLがブラウザにレスポンスされる
        //3.選択されたフォルダのidをテンプレに渡す
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }
}

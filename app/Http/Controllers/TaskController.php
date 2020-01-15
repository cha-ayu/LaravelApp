<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // {id}と定義→ $id で受け取る
    public function index(int $id)
    {
        //Folderモデルのallクラスメソッドで全てのフォルダデータをDBから取得
        $folders = Folder::all();

        //1.取得したデータをテンプレートに渡した結果を返している（テンプレファイル名, [渡すデータ]配列）
        //2.テンプレをレンダリングした結果のHTMLがブラウザにレスポンスされる
        //3.選択されたフォルダのidをテンプレに渡す
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
        ]);
    }
}

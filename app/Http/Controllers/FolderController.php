<?php

namespace App\Http\Controllers;

//クラスのインポート
use App\Folder;                         //add
use App\Http\Requests\CreateFolder;     //add
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    //引数にインポートしたRequestクラスをいれる(FormRequestのクラスを指定)
    public function create(CreateFolder $request)
    {
        // 1.モデルクラスのインスタンスを作成する: フォルダモデルのインスタンス作成
        $folder = new Folder();
        // 2.インスタンスのプロパティに値を代入する: タイトルに入力値を代入
        $folder->title = $request->title;
        // 3.saveメソッドを呼び出す: インスタンスの状態をデータベースに書き込む
        $folder->save();

        //viewではなくredirectメソッドで画面遷移
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    
}

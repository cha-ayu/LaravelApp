<?php

namespace App\Http\Controllers;

// クラスのインポート
use App\User;                           // ユーザークラス
use App\Folder;                         // フォルダクラス
use App\Http\Requests\CreateFolder;     // FormRequestクラス
use Illuminate\Support\Facades\Auth;
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
        // モデルクラスのインスタンスを作成する: フォルダモデルのインスタンス作成
        $folder = new Folder();
        // インスタンスのプロパティに値を代入する: タイトルに入力値を代入
        $folder->title = $request->title;
        // ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder);

        //viewではなくredirectメソッドで画面遷移
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    
}

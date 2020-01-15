<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{

    //hasMany: テーブル間の関連性をモデルクラスで表現
    //この場合、第二・第三引数は省略可
    public function tasks()
    {
        return $this->hasMany('App\Task', 'folder_id', 'id');
    }
}

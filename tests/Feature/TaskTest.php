<?php

namespace Tests\Feature;

// クラスのインポート
use App\Http\Requests\CreateTask;           // FormRequestクラス
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TaskTest extends TestCase
{
    // テストケースごとにDBをリフレッシュしてマイグレーションを再実行
    use RefreshDatabase;

    /**
     * 各テストメソッドの実行前に呼ばれる
     */
    public function setUp() :void       // <- テストでエラーになるため追記
    {
        parent::setUp();

        // テストケース実行前にフォルダデータを作成する（タスク作成にはフォルダデータ必要）
        $this->seed('FoldersTableSeeder');
    }

    /**
     * 期限日が日付ではない場合はバリデーションエラー
     * @test
     */
    public function due_date_should_be_date()
    {
        // postメソッドでタスク作成ルートへアクセス（URL, 入力値）
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => 123, // 不正なデータ（数値や文字列）
        ]);

        // エラーがあることの確認
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力してください。',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラー
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'), // 不正なデータ（昨日の日付）
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

}

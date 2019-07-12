<?php

use App\Task;
use Illuminate\Http\Request; // 下記のRequestの部分と一致

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ルーターから受け取った
Route::get('/', function () { // ::=static
    // タスクをデータベースから持ってくる orderBy=並べ換え
    $tasks = Task::orderBy('created_at', 'asc')->get();

    // データベースから取ってきた値をtasksに格納
    return view('tasks', [
        // tasksという名前で持ってきたtasksの値を渡す
        'tasks' => $tasks
    ]);
});

// タスクを追加した時にデータを送る処理
// ::=static post=関数 /task=http://サーバー名/task 名前を受け取る処理　サーバーからデータを受け取る処理＝リクエスト　＄＝変数名
Route::post('/task', function (Request $request) {
    // validator=入力データをチェックする仕組み []=配列
    $validator = Validator::make($request->all(), [
        // nameをチェック　reqired= max:3=255文字まで打てる
        'name' => 'required|max:255',
    ]);

    // validator=インスタンス化(イメージのまま使うことができる機能)

    // 上記の処理が失敗した時
    if ($validator->fails()) {
        return redirect('/')
            ->withInput() // 入力データの処理を返す
            ->withErrors($validator); // エラー実行
    }

    // タスク作成…
    $task = new Task(); // インスタンス化
    $task->name = $request->name;
    // タスクの値をデータベースに登録
    $task->save();

    // Route::getの処理に戻る
    return redirect('/');
});

<?php
///////////////////////////////////////
// ユーザーデータを処理
///////////////////////////////////////
 
/**
 * ユーザーを作成
 *
 * @param array $data
 * @return bool
 */
function createUser(array $data)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); //new mysqliはMYSQLにせず属する際のオブジェクト型の書き方。もう一つは手続き型(mysqli_connect)だが移行のため用意しているもので、基本オブジェクト型を使えばよい。
    // 接続チェック
    if ($mysqli->connect_errno) {//DBに接続できなかったときエラー番号を返す。
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit; //DBに接続出来なかったら何もできないので強制終了
    }
 
    // 新規登録のSQLを作成
    //　? はプレースホルダーといい、後から値を指定するもの
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';
    //プリペアドステートメントはＳＱＬインジェクション対策。もしユーザー入力値にSQL構文が入っていてもエスケープして実行されないようにできる。
    $statement = $mysqli->prepare($query);
 
    // パスワードをハッシュ値に変換して解読不能にする。
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
 
    // ? の部分にセットする内容
    // 第一引数のsは変数の型を指定(s=string)
    $statement->bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password']);
 
    // 処理を実行
    $response = $statement->execute();
    if ($response === false) {
        echo 'エラーメッセージ：' . $mysqli->error . "\n";
    }
 
    // 接続を解放
    $statement->close();
    $mysqli->close();
 
    return $response;
}
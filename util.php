<?php
///////////////////////////////////////////////
// 便利な関数
///////////////////////////////////////////////

/**
 * 画像ファイル名から画像のURLを生成
 * @param string $name 画像ファイル名
 * @param string $type ユーザー画像かツイート画像
 * @return string
 */
function buildImagePath(string $name = null, string $type)  //stiringで引数を文字型列に指定することで、指定以外のデータが入力された場合ミスに気付ける//
{
    if ($type === 'user' && !isset($name)) {   // ユーザーアイコンがアップロードされてないとみなしデフォルト画像を返す
        return HOME_URL . '/Views/img/icon-default-user.svg';
    }

    return HOME_URL . '/Views/img_uploaded/'. $type . '/' .htmlspecialchars($name);
}
 

/** 
*指定した日時からどれだけ経過したかを取得
*
* @param string $datetime　日時
* @return string
*/

function convertToDayTimeAgo(string $datetime)
{
    $unix = strtotime($datetime);   //1970/1/1から指定した日時までの経過秒数
    $now = time();                  //1970/1/1から現在までの経過秒数
    $diff_sec = $now - $unix;

    if ($diff_sec < 60) {
        $time = $diff_sec;
        $unit = '秒前';
    } elseif ($diff_sec < 3600){  //3600秒=60分
        $time = $diff_sec / 60;
        $unit = '分前';
    } elseif ($diff_sec < 86400){//86400=24時間
        $time = $diff_sec / 3600;
        $unit = '時間前'; 
    } elseif ($diff_sec < 2764800){ //2764800秒=32日
        $time = $diff_sec / 86400;
        $unit = '日前';
    } else {
        if (date('Y') != date('Y', $unix)) {  //現在の年と投稿したときの年が一致しなければ
            $time = date('Y年n月j日', $unix); //何年何月何日かを返す
        } else {
            $time = date('n月j日', $unix); //年をのぞいて、何月何日かを返す
        }
        return $time;
    }

    return (int) $time . $unit; //割り算で余った秒数を削除
}

/**
 * ユーザー情報をセッションに保存
 *
 * @param array $user
 * @return void
 */
function saveUserSession(array $user)
{
    // セッションを開始していない場合
    if (session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
 
    $_SESSION['USER'] = $user;
}
 
/**
 * ユーザー情報をセッションから削除
 *
 * @return void
 */
function deleteUserSession()
{
    // セッションを開始していない場合
    if (session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
 
    // セッションのユーザー情報を削除
    unset($_SESSION['USER']);
}
 
/**
 * セッションのユーザー情報を取得
 *
 * @return array|false
 */
function getUserSession()
{
    // セッションを開始していない場合
    if (session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
 
    if (!isset($_SESSION['USER'])) {
        // セッションにユーザー情報がない
        return false;
    }
 
    $user = $_SESSION['USER'];
 
    // 画像のファイル名からファイルのURLを取得
    if (!isset($user['image_name'])) {
        $user['image_name'] = null;
    }
    $user['image_path'] = buildImagePath($user['image_name'], 'user');
 
    return $user;
}

 /**
 * 画像をアップロード
 *
 * @param array $user
 * @param array $file
 * @param string $type
 * @return string 画像のファイル名
 */
function uploadImage(array $user, array $file, string $type)
{
    // 画像のファイル名から拡張子を取得（例：.png）
    $image_extension = strrchr($file['name'], '.');
 
    // 画像のファイル名を作成（YmdHis 例: 20210607231201）
    $image_name = $user['id'] . '_' . date('YmdHis') . $image_extension;
 
    // 保存先のディレクトリ
    $directory = '../Views/img_uploaded/' . $type . '/';
 
    // 画像のパス
    $image_path = $directory . $image_name;
 
    // 画像を設置
    move_uploaded_file($file['tmp_name'], $image_path);
 
    // 画像ファイルかチェック
    if (exif_imagetype($image_path)) {
        return $image_name;
    }
 
    // 画像ファイル以外の場合
    echo '選択されたファイルが画像ではないため処理を停止しました。';
    exit;
}
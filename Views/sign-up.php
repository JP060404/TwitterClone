<?php
// 設定関連を読み込む。includeは他のファイルの記述を取り込むときに使う。include_onceは同じファイルは2回includeされていても1回しか実行しない。
include_once('../config.php'); 
// 便利な関数を読み込む
include_once('../util.php');
?>

<!DOCTYPE html>
<html lang="ja">
 
<head>
    <?php include_once('..\Views\common\head.php'); ?>
 
    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">
</head>
 
<body class="signup text-center">    <!-- text-centerは中央寄せされるbootstrapのクラス -->
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="/TwitterClone/Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1>
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus><!-- form-control classはformをきれいに表示するbooststrapクラス。autofocusは最初から一つ目のフォームがフォーカスされた状態にする -->
            <input type="text" class="form-control" name="name" placeholder="ユーザー名、例)techis132" maxlength="50" required>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required>
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="4" maxlength="128" required>
            <button class="w-100 btn btn-lg" type="submit">登録する</button>  <!-- w-100はwidth100%、btn-lgは大きいボタンを表示するbootstrapのクラス -->
            <!-- 以下それぞれbootstrapのクラス -->
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p>
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p>　<!-- &copy;は🄫を表示する -->
        </form>
    </main>
    <?php include_once('..\Views\common\foot.php'); ?>
</body>
 
</html>
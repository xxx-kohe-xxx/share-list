<?php
// 共通変数・関数ファイルの読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログアウトページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

debug('ログアウトします。');
// セッションを削除する(ログアウトする)
session_destroy();
debug('ログインページへ遷移します。');
// ログインページへ遷移
header("Location:login.php");
?>
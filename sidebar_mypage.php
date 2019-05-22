<?php
// 共通変数・関数の呼び出し
// require('function.php');
debug('========== サイドバー ==========');
debugLogStart();

// // ========== 画面処理 ==========
if(!empty($_SESSION)){ // セッション変数があるかどうか?(ログインしてるかどうか)
  $u_id = $_SESSION['user_id'];
  debug('ユーザー情報:'.print_r($u_id,true));
  $profpic = getProfpic($u_id);
  // debug('getProfpic中身:'.print_r(getProfpic($u_id),true));
  
}else{ 
  // ログインしていない場合はノーイメージの画像を表示
  $profpic['profpic'] = 'img/sample-img.png';
}
// debug('クエリ結果:'.print_r($profpic,true));


?>

<section id="sidebar">
  <img src="<?php  echo $profpic['profpic']; ?>" alt="プロフィール画像">
  <a href="registList.php">リストを投稿する</a>
  <a href="profEdit.php">プロフィール編集</a>
  <a href="passEdit.php">パスワード変更</a>
  <a href="withdraw.php">退会</a>
</section>

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
  $userName = $_SESSION['username'];
}else{ 
  // ログインしていない場合はノーイメージの画像を表示
  $profpic['profpic'] = 'img/sample-img.png';
}
// debug('クエリ結果:'.print_r($profpic,true));


?>

<section id="sidebar">
  <img src="<?php if (!empty($profpic['profpic'])) {echo $profpic['profpic'];}else{echo 'img/sample-img.png';}  ?>" alt="プロフィール画像">
  <p><?php if(!empty($userName)) echo $userName; ?></p>
  <a href="registList.php">リストを投稿する</a>
  <a href="profEdit.php">プロフィール編集</a>
  <a href="passEdit.php">パスワード変更</a>
  <a href="withdraw.php">退会</a>
</section>

<?php
// 共通変数・関数の読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード変更ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

// ========================================
// 画面処理
// ========================================
// DBからユーザーデータを取得
$userData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報:'.print_r($userData, true));

// ポスト送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報:'.print_r($_POST, true));

	// 変数にユーザー情報を代入
	$pass_old = $_POST['pass_old'];
	$pass_new = $_POST['pass_new'];
	$pass_new_re = $_POST['pass_new_re'];

	validRequired($pass_old, 'pass_old');
	validRequired($pass_new, 'pass_new');
	validRequired($pass_new_re, 'pass_new_re');

	if(empty($err_msg)){
		debug('未入力チェックOK');

		// 古いパスワードのチェック
		validPass($pass_old, 'pass_old');
		// 新しいパスワードのチェック
		validPass($pass_new, 'pass_new');

		// 古いパスワードとDBのパスワードを照合
		if(!password_verify($pass_old,$userData['password'])){
		// if($pass_old !== $userData['password']){
			$err_msg['pass_old'] = MSG10;
		}
		debug(print_r($err_msg,true));
		// 新しいパスワードと古いパスワードが同じかチェック
		if($pass_old === $pass_new){
			$err_msg['pass_new'] = MSG11;
		}
		validMatch($pass_new, $pass_new_re ,'pass_new_re');

		if(empty($err_msg)){
			debug('バリデーションOK');

			// 例外処理
			try {
				// DBと接続
				$dbh = dbconnect();
				// SQL文作成
				$sql = 'UPDATE users SET password = :pass WHERE user_id = :id';
				$data = array(':id' => $_SESSION['user_id'], ':pass' => password_hash($pass_new, PASSWORD_DEFAULT));
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);

				if($stmt){
					$_SESSION['msg_success'] = SUC01;

					// メール送信
					$username = ($userData['username']) ? $userData['username'] : '名無し';
					$from = 'info@sharelist.dekitablog.com';
					$to = $userData['email'];
					$subject = 'パスワード変更通知 | SHARE-LIST';
					$comment = <<<EOT
{$username}さん
パスワードが変更されました。

===============================
SHARE-LIST 運営
URL https://sharelist.dekitablog.com/
E-mail info@sharelist.dekitablog.com
===============================
EOT;
					sendMail($from, $to, $subject, $comment);
					header('Location:mypage.php');
				}
			} catch(Exception $e){
				error_log('エラー発生:'.$e->getMessage());
				$err_msg['common'] = MSG07;
			}
		}
	}
}else{
	debug('POST送信がありません。');
}

?>

<?php
$siteTitle = 'パスワード変更';
require('head.php');
?>

<body class="page-passEdit page-2colum page-logined">

	<!-- メニュー -->
	<?php
	require('header.php');
	?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">
		<h1 class="page-title">パスワード変更</h1>

		<!-- メイン -->
		<section class="" id="main">
			<div class="form-container">
				<form action="" method="post" class="form">
					<div class="area-msg">
						<?php
							echo getErrMsg('common');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass_old'])) echo 'err'; ?>">
						古いパスワード
						<input type="password" name="pass_old" value="<?php echo getFormData('pass_old'); ?>">
					</label>
					<div class="area-msg">
						<?php
							echo getErrMsg('pass_old');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass_new'])) echo 'err'; ?>">
						新しいパスワード
						<input type="password" name="pass_new" value="<?php echo getFormData('pass_new'); ?>">
					</label>
					<div class="area-msg">
						<?php
							echo getErrMsg('pass_new');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass_new_re'])) echo 'err'; ?>">
						新しいパスワード(再入力)
						<input type="password" name="pass_new_re" value="<?php echo getFormData('pass_new_re'); ?>">
					</label>
					<div class="area-msg">
						<?php
							echo getErrMsg('pass_new_re');
						?>
					</div>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="変更する">
					</div>
				</form>
			</div>
		</section>



		<!-- サイドバー -->
		<?php
		require('sidebar_mypage.php');
		?>
	</div>

	<!-- フッター -->
	<?php
	require('footer.php');
	?>

</body>
</html>

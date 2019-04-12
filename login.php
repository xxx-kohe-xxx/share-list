<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

// ========================================
// ログイン画面処理
// ========================================
if(!empty($_POST)){
	debug('POST送信があります。');

	// 変数にユーザー情報を代入
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_save = (!empty($_POST['pass_save'])) ? true:false;

	// バリデーションチェック
	// Email形式チェック
	validEmail($email, 'email');
	// 最大文字数チェック
	validMaxLen($email, 'email');

	// passの半角英数字チェック
	validhalf($pass, 'pass');
	// passの最大文字数チェック
	validMaxLen($pass, 'pass');
	// passの最小文字数チェック
	validMinLen($pass, 'pass');

	// 未入力チェック
	validRequired($email, 'email');
	validRequired($pass, 'pass');

	if(empty($err_msg)){
		debug('バリデーションOKです。');

		// 例外処理
		try {
			// DBへ接続
			$dbh = dbConnect();
			// SQL文作成 Emailを条件として、usersテーブルからpasswordとidを取得
			$sql = 'SELECT password,user_id FROM users WHERE email = :email AND del_flg = 0';
			$data = array(':email' => $email);
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
			// クエリ結果の値を取得
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			debug('クエリ結果の中身:'.print_r($result,true));

			if(!empty($result) && password_verify($pass, array_shift($result))){
			// if(!empty($result) && $pass === array_shift($result)){
				debug('パスワードがマッチしました。');

				// ログイン有効期限(デフォルトを1時間とする)
				$sesLimit = 60*60;
				// 最終ログイン日時を現在日時に更新
				$_SESSION['login_date'] = time();

				if($pass_save){
					debug('ログイン保持にチェックがあります。');
					// ログイン有効期限を延長 有効期限を30日にしてセット
					$_SESSION['login_limit'] = $sesLimit * 24 * 30;
				}else{
					debug('ログイン保持にチェックがありません。');
					// ログイン保持にチェックがないのでデフォルトの1時間を有効期限にセット
					$_SESSION['login_limit'] = $sesLimit;
				}

				// ユーザーIDを格納
				$_SESSION['user_id'] = $result['user_id'];

				debug('セッション変数の中身:'.print_r($_SESSION,true));
				debug('マイページへ遷移します。');
				header("Location:mypage.php");
			}else{
				debug('パスワードがアンマッチです。');
				$err_msg['common'] = MSG09;
			}
			
		} catch (Exception $e) {
			error_log('エラー発生:'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}
}
debug('画面表示処理終了
<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

?>



<!--
	========================================
	以下画面表示
	========================================
-->
<?php 
$siteTitle = 'ログイン';
require('head.php');
?>

<body class="page-login page-1colum">

	<!-- メニュー -->
	<?php
	require('header.php');
	?>
	<p id="js-show-msg" style="display: none;" class="msg-slide">
		<?php echo getSessionFlash('msg_success'); ?>
	</p>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">

			<div class="form-container">
				<form action="" method="post" class="form">
					<h2 class="title">ログイン</h2>
					<div class="area-msg">
					<?php 
						if(!empty($err_msg['common'])) echo $err_msg['common'];
					?>
					</div>
					<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
						メールアドレス
						<input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
					</label>
					<div class="area-msg">
					<?php 
						if(!empty($err_msg['email'])) echo $err_msg['email'];
					?>
					</div>
					<label class=<?php if(!empty($err_msg['pass'])) echo 'err'; ?>>
						パスワード
						<input type="password" name="pass" value="">
					</label>
					<div class="area-msg">
					<?php 
						if(!empty($err_msg['pass'])) echo $err_msg['pass'];
					?>
					</div>
					<label>
						<input type="checkbox" name="pass_save">
						次回ログインを省略する
					</label>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="ログイン">	
					</div>
					パスワードを忘れた方は<a href="passRemindSend.php">こちら</a>
				</form>
			</div>

	</div>

<?php
require('footer.php');
?>

</body>
</html>

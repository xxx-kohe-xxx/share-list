<?php
// 共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　プロフィール編集ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

// ========================================
// 画面処理
// ========================================
// DBからユーザーデータを取得
$dbFormData = getUser($_SESSION['user_id']);

debug('取得したユーザー情報:'.print_r($dbFormData,true));

if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報:'.print_r($_POST,true));
	
	// 変数にユーザー情報を代入
	$username = $_POST['username'];
	$email = $_POST['email'];
	
	// DBの情報と入力情報が異なる場合にバリデーションを行う
	if($dbFormData['username'] !== $username ){
		debug('ユーザーネームが変更されました');
		// 名前の最大文字数チェック
		validMaxLen($username, 'username');
		// 空欄チェック
		validRequired($username, 'username');
	}
	if($dbFormData['email'] !== $email){
		debug('emailが変更されました');
		// emailの最大文字数チェック
		validMaxLen($email, 'email');
		if(empty($err_msg['email'])){
			debug('重複チェックをします');
			// emailの重複チェック
			validEmailDup($email);
		}
		// emailの形式チェック
		validEmail($email, 'email');
		// emailの未入力チェック
		validRequired($email, 'email');
	}
	
	if(empty($err_msg)){
		debug('バリデーションOKです。');
		
		// 例外処理
		try {
			// DBへ接続
			$dbh = dbconnect();
			// SQL文作成
			$sql = 'UPDATE users SET username = :u_name, email = :email WHERE user_id = :u_id';
			$data = array(':u_name' => $username, ':email' => $email, ':u_id' => $dbFormData['user_id']);
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
			
			// クエリ成功の場合
			if($stmt){
				debug('クエリ成功');
				debug('マイページへ遷移します。');
				header('Location:mypage.php');
			}else{
				debug('クエリに失敗しました。');
				$err_msg['common'] = MSG08;
			}
		} catch(Exception $e){
			error_log('エラー発生:'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}
}
debug('画面表示処理終了
<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<?php
$siteTitle = 'プロフィール編集';
require('head.php');
?>

<body class="page-profEdit page-2colum page-logined">

	<!-- メニュー -->
	<?php
	require('header.php');
	?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">
		<h1 class="page-title">プロフィール編集</h1>

		<!-- メイン -->
		<section class="" id="main">
			<div class="form-container">
				<form action="" method="post" class="form">
					<div class="area-msg">
					<?php
					if(!empty($err_msg['common'])) echo $err_msg['common'];
					?>
					</div>
					<label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
						名前
						<input type="text" name="username" value="<?php echo getFormData('username'); ?>">
					</label>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['username'])) echo $err_msg['username'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
						E-mail
						<input type="text" name="email" value="<?php echo getFormData('email'); ?>">
					</label>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['email'])) echo $err_msg['email'];
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

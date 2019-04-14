<?php
// 共通変数・関数の読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再発行認証キー入力ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// Sessionに認証キーが入っているか確認。入っていない場合リダイレクト
if(empty($_SESSION['auth_key'])){
	header("Location:passRemindSend.php"); // 認証キー発行ページへ
}

// ========================================
// 画面処理
// ========================================
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報:'.print_r($_POST,true));
	
	// 変数に認証キーを代入
	$auth_key = $_POST['token'];
	
	// 未入力チェック
	validRequired($auth_key, 'token');

	if(empty($err_msg)){
		debug('未入力チェックOK');

		// 固定長チェック
		validLength($auth_key, 'token');

		// 半角チェック
		validHalf($auth_key, 'token');

		if(empty($err_msg)){
			debug('バリデーションOK');
			
			// 認証キー照合
			if($auth_key !== $_SESSION['auth_key']){
				$err_msg['common'] = MSG13;
			}
			// 有効期限のチェック
			if(time() > $_SESSION['auth_key_limit']){
				$err_msg['common'] = MSG14;
			}

			if(empty($err_msg)){
				debug('認証OK');
				
				// パスワード生成
				$pass = makeRandKey();

				// 例外処理
				try {
					// DB接続
					$dbh = dbconnect();
					// SQL文作成
					$sql = 'UPDATE users SET password = :pass WHERE email = :email AND del_flg = 0';
					$data = array(':email' => $_SESSION['auth_email'], ':pass' => password_hash($pass,PASSWORD_DEFAULT));
					// クエリ実行
					$stmt = queryPost($dbh, $sql, $data);

					// クエリ成功の場合
					if($stmt){
						// debug('クエリ成功。');

						// 	メール送信
						$from = 'info@webukatu.com';
						$to = $_SESSION['auth_email'];
						$subject = '【パスワード再発行完了】| SHARE-LIST';
						$comment = <<<EOT
本メールアドレス宛にパスワードの再発行を致しました。
下記のURLにて再発行パスワードをご入力頂き、ログインください。

ログインページ：http://localhost/list_share/login.php
再発行パスワード：{$pass}
※ログイン後、パスワードのご変更をお願い致します

////////////////////////////////////////
SHARE-LIST 運営
URL  http://webukatu.com/
E-mail info@webukatu.com
////////////////////////////////////////
EOT;
						debug($pass);
						sendMail($from, $to, $subject, $comment);

						// 	セッション削除
						session_unset();
						$_SESSION['msg_success'] = SUC03;
						debug('セッション変数の中身:'.print_r($_SESSION,true));
						// 	ログインページへ遷移
						header("Location:login.php");
					// }else{
					// 	debug('クエリが失敗しました。');
					// 	$err_msg['common'] = MSG07;
					}
				} catch (Exception $e){
					error_log('エラー発生:'.$e->getMessage());
					$err_msg['common'] = MSG07;
				}
			}
		}else{
			debug('バリデーションNG');
		}
	}
}else{
	debug('POST送信がありません。');
}

?>

<!--
	========================================
	以下画面表示
	========================================
-->
<?php
$siteTitle = 'パスワード再発行';
require('head.php');
?>

<body class="page-signup page-1colum">

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
					<p>ご指定のメールアドレス宛にお送りした【パスワード再発行認証メール】内にある「認証キー」をご入力ください。</p>
					<div class="area-msg">
						<?php
						echo getErrMsg('common');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['token'])){ echo 'err';} ?>">
						認証キー
						<input type="text" name="token" valie="<?php echo getFormData('token'); ?>">
					</label>
					<div class="area-msg">
						<?php
						echo getErrMsg('token');
						?>
					</div>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="再発行する">	
					</div>
				</form>
			</div>
					<a href="passRemindSend.php">&lt; パスワード再発行メールを再度送信する</a>
		</section>	
	</div>

	<?php
	require('footer.php');
	?>

</body>
</html>

<?php 
// 共通変数・関数の読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再発行メール送信ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ========================================
// 画面処理
// ========================================
// POSTされていた場合
if(!empty($_POST)){
	debug('post送信があります。');
	debug('post情報:'.print_r($_POST,true));

	// 変数にPOST情報を代入
	$email = $_POST['email'];

	// 未入力チェック
	validRequired($email, 'email');

	if(empty($err_msg)){
		debug('未入力チェックOK');

		// emailの形式チェック
		validEmail($email, 'email');
		// emailの最大文字数チェック
		validMaxLen($email, 'email');

		if(empty($err_msg)){
			debug('バリデーションOK');
			
			// 例外処理
			try {
				// DBへ接続
				$dbh = dbConnect();
				// SQL文作成
				$sql = 'SELECT count(*) FROM users WHERE email = :email AND del_flg = 0';
				$data = array(':email' => $email);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// クエリ結果の値を取得
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				// emailがDBに登録されている場合
				if($stmt && array_shift($result)){
					debug('クエリ成功。DBに登録あり');
					
					$_SESSION['msg_success'] = SUC03;

					// 認証キー生成
					$auth_key = makeRandKey();

					// メール送信
					$from = 'info@sharelist.dekitablog.com';
					$to = $email;
					$subject = '【パスワード再発行認証】| SHARE-LIST';
					$comment = <<<EOT
本メールアドレス宛にパスワード再発行のご依頼がありました。
下記のURLにて認証キーをご入力頂くとパスワードが再発行されます。

パスワード再発行認証キー入力ページ：https://sharelist.dekitablog.com/passRemindRecieve.php
認証キー：{$auth_key}
※認証キーの有効期限は30分となります

認証キーを再発行されたい場合は下記ページより再度再発行をお願い致します。
http://localhost/list_share/passRemindSend.php

////////////////////////////////////////
SHARE-LIST 運営
URL  https://sharelist.dekitablog.com/
E-mail info@sharelist.dekitablog.com
////////////////////////////////////////
EOT;
					sendMail($from, $to, $subject, $comment);

					// 認証に必要な情報をセッションへ保存
					$_SESSION['auth_key'] = $auth_key;
					$_SESSION['auth_email'] = $email;
					$_SESSION['auth_key_limit'] = time()+(60*30); // 現在時刻＋30分後のUnixタイムスタンプをいれる
					debug('セッション変数の中身:'.print_r($_SESSION,true));

					// 認証キー入力ページへ
					header("Location:passRemindRecieve.php");

				}else{
					debug('クエリに失敗したかDBに登録のないEmailが入力されました。');
					$err_msg['common'] = MSG07;
				}
			}catch (Exception $e){
				error_log('エラー発生:'.$e->getMessage());
				$err_msg['common'] = MSG07;
			}
		}
	}
}else{
	debug('post送信がありません。');
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

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">
			<div class="form-container">
				<form action="" method="post" class="form">
					<p>ご指定のメールアドレス宛にパスワード再発行用のURLと認証キーをお送りいたします。</p>
					<label>
						Email
						<input type="text" name="email">
					</label>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="送信する">	
					</div>
				</form>
			</div>
					<a href="mypage.php">&lt; マイページに戻る</a>

	</div>

	<?php
	require('footer.php');
	?>

</body>
</html>

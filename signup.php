<?php

require('function.php');

//POST送信されているか確認
if(!empty($_POST)){
	//ポスト送信されている場合
	// 変数にユーザー情報を代入
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	// 未入力チェック
	validRequired($email, 'email');
	validRequired($pass, 'pass');
	validRequired($pass_re, 'pass_re');

	if(empty($err_msg)){
		// すべてのフォームが空欄じゃなかったとき ＝ $err_msgが空

		// Emailの形式チェック
		validEmail($email, 'email');
		// Emailの最大文字数チェック
		validMaxLen($email, 'email');
		// Emailの重複チェック
		validEmailDup($email, 'email');
		
		// パスワードの半角英数字チェック
		validHalf($pass, 'pass');
		// パスワードの最大文字数チェック
		validMaxLen($pass, 'pass');
		// パスワードの最小文字数チェック
		validMinLen($pass, 'pass');

		// パスワード(再入力)の最大文字数チェック
		// validMaxLen($pass_re, 'pass_re');
		// パスワード(再入力)の最小文字数チェック
		// validMinLen($pass_re, 'pass_re');

		if(empty($err_msg)){
			// パスワードとパスワード(再入力)が一致しているかチェック
			validMatch($pass, $pass_re, 'pass_re');

			if(empty($err_msg)){
				// 例外処理
				try {
					// DBへ接続
					$dbh = dbConnect();
					// SQL文作成
					$sql = 'INSERT INTO users (email,password,login_time,create_date) VALUES(:email,:pass,:login_time,:create_date)';
					$data = array(
						':email' => $email, 
						':pass' => password_hash($pass,PASSWORD_DEFAULT), 
						':login_time' => date('Y-m-d H:i:s'),
						':create_date' => date('Y-m-d H:i:s')
					);
					// クエリ実行
					queryPost($dbh, $sql, $data);
					// マイページへ遷移
					header("Location:mypage.html");
				} catch (Exception $e) {
					error_log('エラー発生:' . $e->getMessage());
					$err_msg['common'] = MSG07;
				}
			}
		}
	}
}
	
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
	<title>ユーザー登録 | SHARE-LIST</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="'http://fonts.googleapis.com/css?family=Montserrat:400,700'">
</head>
<body class="page-signup page-1colum">

	<!-- メニュー -->
	<header>
		<div class="site-width">
			<h1><a href="index.html">SHARE-LIST</a></h1>
			<nav id="top-nav">
				<ul>
					<li><a href="signup.php" class="btn btn-primary">ユーザー登録</a></li>
					<li><a href="login.php">ログイン</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">

			<div class="form-container">
				<form action="" method="POST" class="form">
					<h2 class="title">ユーザー登録</h2>
					<div class="area-msg">
						<?php
							if(!empty($err_msg['common'])) echo $err_msg['common'];//$err_msgが空じゃない場合、中身を出力する
						?>
					</div>
					<label class="<?php if (!empty($err_msg['emali'])) echo 'err'; ?>">
						Email
						<input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
					</label>
					<div class="area-msg">
						<?php
							if(!empty($err_msg['email'])) echo $err_msg['email'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
						パスワード <span style="font-size:12px">※英数字6文字以上</span>
						<input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
					</label>
					<div class="area-msg"><!-- パスワードのバリデーションチェック エラーメッセージ -->
						<?php
							if(!empty($err_msg['pass'])) echo $err_msg['pass'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass_re'])) echo 'err';?>">
						パスワード(再入力)
						<input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re'] ?>">
					</label>
					<div class="area-msg"><!-- パスワード再入力のバリデーションチェック エラーメッセージ -->
						<?php
							if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re'];
						?>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="登録する">	
					</div>
				</form>
			</div>

	</div>

	<footer>
		Copyright
		<a href="">SHARE-LIST</a>
		. All Rights Reserved.
	</footer>

</body>
</html>

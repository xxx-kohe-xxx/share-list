<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
	<title>パスワード再発行 | SHARE-LIST</title>
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
					<li><a href="signup.html" class="btn btn-primary">パスワード再発行メール送信</a></li>
					<li><a href="login.html">ログイン</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">
			<div class="form-container">
				<form action="passRemindRecieve.html" class="form">
					<p>ご指定のメールアドレス宛にパスワード再発行用のURLと認証キーをお送りいたします。</p>
					<lavel>
						Email
						<input type="text" name="email">
					</lavel>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="送信する">	
					</div>
				</form>
			</div>
					<a href="mypage.html">&lt; マイページに戻る</a>

	</div>

	<footer>
		Copyright
		<a href="">SHARE-LIST</a>
		. All Rights Reserved.
	</footer>

</body>
</html>

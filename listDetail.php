<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
	<title>リスト詳細 | SHARE-LIST</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="'http://fonts.googleapis.com/css?family=Montserrat:400,700'">
	<style>

	</style>
</head>
<body class="page-listDetail page-2colum page-logined">

	<!-- メニュー -->
	<header>
		<div class="site-width">
			<h1><a href="index.html">SHARE-LIST</a></h1>
			<nav id="top-nav">
				<ul>
					<li><a href="signup.html" class="btn btn-primary">ユーザー登録</a></li>
					<li><a href="login.html">ログイン</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">
			<!-- リストの詳細 -->
			<div class="listDetail">
				<div class="listDetail-head">
					<h2>リスト名</h2>
					<h3>カテゴリー名</h3>
				</div>
				<div class="listDetail-content">
					<ul>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
					</ul>
				</div>
			</div>
			<!-- コメント -->
			<div class="comment">
				<h2>コメント</h2>
				<div class="area-comment" id="js-scroll-bottom">
					<div class="msg-cnt msg-left">
						<div class="avatar">
							<img src="img/ch_thumb_cuddles.gif" alt="cuddles">
						</div>
						<p class="msg-inrTxt">
							<span class="triangle"></span>
							サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
						</p>
					</div>
					<div class="msg-cnt msg-right">
						<div class="avatar">
							<img src="img/ch_thumb_nutty.gif" alt="nutty">
						</div>
						<p class="msg-inrTxt">
							<span class="triangle"></span>
							サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
						</p>
					</div>
				</div>
				<div class="area-send-msg">
					<textarea name="" id="" cols="30" rows="3"></textarea>
					<input type="submit" name="" id="" value="送信" class="btn btn-send">
				</div>
			</div>
				
			</section>
		
		<script>
			$(function(){
				$('#js-scroll-bottom').animate({scrollTop:$('#js-scroll-bottom')[0].scrollHeight},'fast');
			});
		</script>

		<!-- サイドバー -->
		<section id="sidebar">
			<img src="" alt="プロフィール画像">
			<a href="">リストを投稿する</a>
			<a href="">リスト一覧を見る</a>
			<a href="">プロフィール編集</a>
			<a href="">パスワード変更</a>
			<a href="">退会</a>
		</section>

	</div>

	<footer>
		Copyright
		<a href="">SHARE-LIST</a>
		. All Rights Reserved.
	</footer>

</body>
</html>

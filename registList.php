<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
	<title>リスト投稿 | SHARE-LIST</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="'http://fonts.googleapis.com/css?family=Montserrat:400,700'">
	<style>
	</style>
</head>
<body class="page-registList page-2colum page-logined">

	<!-- メニュー -->
	<header>
		<div class="site-width">
			<h1><a href="index.html">SHARE-LIST</a></h1>
			<nav id="top-nav">
				<ul>
					<li><a href="mypage.html">マイページ</a></li>
					<li><a href="">ログアウト</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">
		<h1 class="page-title">リストを投稿する</h1>

		<!-- メイン -->
		<section class="" id="main">
			<div class="form-container">
				<form action="" class="form">
					<div class="area-msg">
						リスト名が長すぎます<br>
						詳細は500文字までです
					</div>
					<label>
						リスト名
						<input type="text" name="listname">
					</label>
					<label>
						カテゴリ
						<select  name="category" id="">
							<option value="1">持ち物リスト</option>
							<option value="2">備忘録</option>
						</select>
					</label>
					<label>
							リスト内容
							<input type="text" name="listcontent">
							<input type="text" name="listcontent">
							<input type="text" name="listcontent">
							<input type="text" name="listcontent">
							<input type="text" name="listcontent">
					</label>
					
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="投稿する">
					</div>
				</form>
			</div>
		</section>



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

	<!-- フッター -->
	<footer>
		Copyright
		<a href="">SHARE-LIST</a>
		. All Rights Reserved.
	</footer>

</body>
</html>

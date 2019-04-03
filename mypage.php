<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
	<title>マイページ | SHARE-LIST</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="'http://fonts.googleapis.com/css?family=Montserrat:400,700'">
	<style>
		#main {
			border: none;
		}
	</style>
</head>
<body class="page-mypage page-2colum page-logined">

	<!-- メニュー -->
<?php
require('header.php');
?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<h1 class="page-title">MYPAGE</h1>

		<!-- メイン -->
		<section id="main">
			<section class="list panel-list">
				<h2 class="title">
					リスト 一覧
				</h2>
				<a href="listDetail.html" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト1</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト2</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト3</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト4</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
			</section>

			<section class="list panel-list">
				<h2 class="title">
					お気に入り一覧
				</h2>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト1</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト2</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト3</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<a href="" class="panel">
					<div class="panel-head">
						<p class="panel-title">リスト4</p>
					</div>
					<div class="panel-body">
						<ul>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
			</section>

			<div class="pagination">
				<ul class="pagination-list">
					<li class="list-item"><a href="">&lt;</a></li>
					<li class="list-item active"><a href="">1</a></li>
					<li class="list-item "><a href="">2</a></li>
					<li class="list-item "><a href="">3</a></li>
					<li class="list-item "><a href="">4</a></li>
					<li class="list-item "><a href="">5</a></li>
					<li class="list-item "><a href="">&gt;</a></li>
				</ul>
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
<?php
require('footer.php');
?>
</body>
</html>

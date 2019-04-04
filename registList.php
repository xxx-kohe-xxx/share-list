<?php
$siteTitle = 'リスト投稿';
require('head.php');
?>

<body class="page-registList page-2colum page-logined">

	<!-- メニュー -->
	<?php
	require('header.php');
	?>

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
	<?php
	require('footer.php');
	?>

</body>
</html>

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
				<form action="" class="form">
					<div class="area-msg">
						E-mailの形式で入力してください
						そのE-mailは既に登録されています
					</div>
					<label>
						名前
						<input type="text" name="username">
					</label>
					<label>
						E-mail
						<input type="text" name="email" id="">
					</label>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="変更する">
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

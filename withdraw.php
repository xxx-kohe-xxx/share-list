<?php
$siteTitle = '退会';
require('head.php');
?>

<body class="page-login page-1colum">

	<style>
	.form .btn {
		float: none;
	}
	.form {
		text-align: center;
	}
	</style>

	<!-- メニュー -->
	<?php
	require('header.php');
	?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">
			<div class="form-container">
				<form action="" class="form">
					<h2 class="title">退会</h2>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="退会する">	
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

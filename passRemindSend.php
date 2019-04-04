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
				<form action="passRemindRecieve.html" class="form">
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
					<a href="mypage.html">&lt; マイページに戻る</a>

	</div>

	<?php
	require('footer.php');
	?>

</body>
</html>

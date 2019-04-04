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
					<p>ご指定のメールアドレス宛にお送りした【パスワード再発行認証メール】内にある「認証キー」をご入力ください。</p>
					<div class="area-msg">
						認証キーが違います
					</div>
					<label>
						認証キー
						<input type="text" name="token">
					</label>
					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="変更画面へ">	
					</div>
				</form>
			</div>
					<a href="mypage.html">&lt; パスワード再発行メールを再度送信する</a>

	</div>

	<?php
	require('footer.php');
	?>

</body>
</html>

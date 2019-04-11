<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　マイページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

?>
<?php
$siteTitle = 'マイページ';
require('head.php');
?>

<body class="page-mypage page-2colum page-logined">

	<!-- メニュー -->
<?php
require('header.php');
?>

<p id="js-show-msg" style="display:none;" class="msg-slide">
	<?php echo getSessionFlash('msg_success'); ?>
</p>

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
		<?php
		require('sidebar_mypage.php');
		?>
		</div>

	<!-- フッター -->

<?php
require('footer.php');
?>

</body>
</html>

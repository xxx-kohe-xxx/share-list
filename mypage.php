<?php
// 共通変数・関数ファイル読み込み
require('function.php');

debug('========== マイページ ==========');
debugLogStart();


// ========================================
// 画面処理
// ========================================
// ログイン認証
require('auth.php');

// 画面表示用データ取得
// ========================================
$u_id = $_SESSION['user_id'];
// DBからリストデータを取得
$listData = getMyList($u_id);
debug('リスト情報($listData): '.print_r($listData,true));
// DBからお気に入りデータを取得
$likeData = getMyLike($u_id);
debug('お気に入り情報($likeData): '.print_r($likeData,true));

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
				<h2 class="title">リスト 一覧</h2>
				<?php
					if(!empty($listData)):
						foreach($listData as $key => $val):
				?>
				<a href="listDetail.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&l_id='.$val['list_id'] : '?l_id='.$val['list_id']; ?>" class="panel">
					<div class="panel-head">
						<p class="panel-title"><?php echo sanitize($val['listname']); ?></p>
					</div>
					<div class="panel-body">
						<ul>
							<li><?php echo sanitize($val['content1']) ?></li>
							<li><?php echo sanitize($val['content2']) ?></li>
							<li><?php echo sanitize($val['content3']) ?></li>
							<li><?php echo sanitize($val['content4']) ?></li>
							<li><?php echo sanitize($val['content5']) ?></li>
						</ul>
					</div>
				</a>
				<?php
						endforeach;
					endif;
				?>
			</section>

			<section class="list panel-list">
				<h2 class="title">お気に入り一覧</h2>
				<?php
				if(!empty($likeData)):
					foreach($likeData as $key => $val):
				?>
				<a href="listDetail.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&l_id='.$val['list_id'] : '?l_id='.$val['list_id']; ?>" class="panel">
					<div class="panel-head">
						<p class="panel-title"><?php echo sanitize($val['listname']); ?></p>
					</div>
					<div class="panel-body">
						<ul>
						<li><?php echo sanitize($val['content1']) ?></li>
						<li><?php echo sanitize($val['content2']) ?></li>
						<li><?php echo sanitize($val['content3']) ?></li>
						<li><?php echo sanitize($val['content4']) ?></li>
						<li><?php echo sanitize($val['content5']) ?></li>
						</ul>
					</div>
				</a>
				<?php
					endforeach;
				endif;				
				?>
			</section>

			<!-- ページネーション -->
			<!-- <div class="pagination">  -->
				<!-- <ul class="pagination-list">
					<?php
						// pagenation($currentPageNum, $totalPageNum, $link = '', $pageColNum = 5);
					?> -->
			
					<!-- <li class="list-item"><a href="">&lt;</a></li>
					<li class="list-item active"><a href="">1</a></li>
					<li class="list-item "><a href="">2</a></li>
					<li class="list-item "><a href="">3</a></li>
					<li class="list-item "><a href="">4</a></li>
					<li class="list-item "><a href="">5</a></li>
					<li class="list-item "><a href="">&gt;</a></li> -->
				<!-- </ul> -->
			<!-- </div> -->
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

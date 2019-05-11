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
	foreach($listData as $key => $val){
		$viewContentData[] = getListContent($val['list_id']);
	}
	debug('リストコンテンツ情報($viewContentData):'.print_r($viewContentData,true));

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
			<!-- リスト一覧 -->
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
							<?php 
							// foreach($viewContentData as $key => $val):
							// 	$ContentData = array($val[0], $val[1], $val[2], $val[3], $val[4]);
							// 	debug('$ContentData:'.print_r($ContentData,true));
							?>
							<li><?php echo sanitize($val); ?></li>
							<?php // endforeach; ?>
						</ul>
					</div>
				</a>
				<?php
						endforeach;
					endif;
				?>
			</section>
			<!-- お気に入り一覧 -->
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
							<li><?php echo sanitize($val['listcontent']); ?></li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
							<li>テキストテキスト</li>
						</ul>
					</div>
				</a>
				<?php
					endforeach;
				endif;				
				?>
			</section>
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

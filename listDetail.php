<?php
// 共通変数・関数の読み込み
require('function.php');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　リスト詳細ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ========================================
// 画面処理
// ========================================

// 画面表示用データの取得
// ========================================
// リストIDのGETパラメータを取得
$l_id = (!empty($_GET['l_id'])) ? $_GET['l_id'] : '';
// DBから商品データを取得
$viewData = getListOne($l_id);
// パラメータに不正な値が入っているかチェック
if(empty($viewData)){
	error_log('エラー発生:指定ページに不正な値が入りました。');
	header("Location:index.php");
}
debug('取得したDBデータ:'.print_r($viewData,true));


?>

<?php
$siteTitle = 'リスト詳細';
require('head.php');
?>

<body class="page-listDetail page-2colum page-logined">

	<!-- メニュー -->
<?php
require('header.php');
?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">
			<!-- リストの詳細 -->
			<div class="listDetail">
				<div class="listDetail-head">
					<h2>リスト名: <?php echo sanitize($viewData['listname']); ?></h2>
					<h3>カテゴリー名: <?php echo sanitize($viewData['categoryname']); ?></h3>
				</div>
				<div class="listDetail-content">
					<ul>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
						<li>テキストテキスト</li>
					</ul>
				</div>
				<a href="index.php<?php appendGetParam(array('l_id')); ?>">&lt; リスト一覧に戻る</a>
			</div>
			<!-- コメント -->
			<div class="comment">
				<h2>コメント</h2>
				<div class="area-comment" id="js-scroll-bottom">
					<div class="msg-cnt msg-left">
						<div class="avatar">
							<img src="img/ch_thumb_cuddles.gif" alt="cuddles">
						</div>
						<p class="msg-inrTxt">
							<span class="triangle"></span>
							サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
						</p>
					</div>
					<div class="msg-cnt msg-right">
						<div class="avatar">
							<img src="img/ch_thumb_nutty.gif" alt="nutty">
						</div>
						<p class="msg-inrTxt">
							<span class="triangle"></span>
							サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
						</p>
					</div>
				</div>
				<div class="area-send-msg">
					<textarea name="" id="" cols="30" rows="3"></textarea>
					<input type="submit" name="" id="" value="送信" class="btn btn-send">
				</div>
			</div>
				
			</section>
		
		<script>
			$(function(){
				$('#js-scroll-bottom').animate({scrollTop:$('#js-scroll-bottom')[0].scrollHeight},'fast');
			});
		</script>

		<!-- サイドバー -->
		<?php
		require('sidebar_mypage.php');
		?>

	</div>

<?php
require('footer.php');
?>

</body>
</html>

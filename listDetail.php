<?php
// 共通変数・関数の読み込み
require('function.php');
debug('==========リスト詳細ページ==========');
debugLogStart();

// ========================================
// 画面処理
// ========================================

// 画面表示用データの取得
// ========================================
// リストIDのGETパラメータを取得
$l_id = (!empty($_GET['l_id'])) ? $_GET['l_id'] : '';
debug('$l_id中身:'.$l_id);
// DBからリストデータを取得
$viewData = getListOne($l_id);
// パラメータに不正な値が入っているかチェック
if(empty($viewData)){
	error_log('エラー発生:指定ページに不正な値が入りました。');
	// header("Location:index.php");
}
debug('取得したDBデータ($viewData)'.print_r($viewData,true));

debug('========== ここまではOK ==========');

// DBからリストのコンテンツデータを取得する
$viewContentData = getListContent($l_id);
// debug('$viewContentData中身:'.print_r($viewContentData,true));


// コメント機能
// -------------------------------------
$partnerUserId = '';
$partnerUserInfo = '';
$myUserInfo = '';
$listInfo = '';

// GETパラメータを取得
$l_id = (!empty($_GET['l_id'])) ? $_GET['l_id'] : '';
$commentData = getComments($l_id);
debug('取得したDBデータ($commentData)'.print_r($commentData,true));
// パラメータに不正な値が入っているかチェック
// if(empty($commentData)){
// 	error_log('エラー発生:指定ページに不正な値が入りました。');
// 	header("Location:mypage.php");
// }
$listInfo = getListOne($commentData[0]['list_id']);
debug('取得したDBデータ($listInfo):'.print_r($listInfo,true));
// リスト情報が入っているかチェック
// if(empty($listInfo)){
// 	error_log('エラー発生:リスト情報が取得できませんでした');
// 	header("Location:mypage.php");
// }
// リスト投稿主か判断
debug('セッション情報:'.print_r($_SESSION,true));
debug('セッションのユーザーID: '.$_SESSION['user_id']);
debug('セッションのユーザーID: '.$listInfo['user_id']);
// if($listInfo['user_id'] === $_SESSION['user_id']){
// 	debug('match');
// }else{
// 	debug('unmatch');
// }
$u_id = getUser($_SESSION['user_id']);
debug('ユーザー情報:'.print_r($u_id,true));

// post送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');

	// ログイン認証
	require('auth.php');

	// バリデーションチェック
	$comment = (isset($_POST['comment'])) ? $_POST['comment'] : '';
	// 最大文字数チェック最大文字数チェック
	validMaxLen($comment, 'comment', 500);
	// 未入力チェック
	validRequired($comment, 'comment');

	debug(print_r($err_msg,true));
	if(empty($err_msg)){
		debug('バリデーションOKです。');
	
		// 例外処理
		try {
			// DB接続
			$dbh = dbConnect();
			// SQL文作成
			$sql = 'INSERT INTO comments (list_id, user_id, comment, del_flg, create_date) VALUES (:l_id, :u_id, :comment, :del_flg, :date)';
			$data = array(':l_id' => $l_id, ':u_id' => $u_id['user_id'], ':comment' => $_POST['comment'], ':del_flg' => 0, ':date' => date('Y-m-d H:i:s'));
			debug('$dataの中身:'.print_r($data,true));
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);

			// クエリ成功の場合
			if($stmt){
				$_POST = array(); 
				debug('コメント成功');
				debug($_SERVER['PHP_SELF']);
				header("Location: ".$_SERVER['PHP_SELF'].'?l_id='.$l_id);
			}
		} catch (Exception $e){
			error_log('エラー発生:'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}else{
		debug('バリデーションNGです。');
	}
}else{
	debug('POST送信がありません。');
}
debug('==========画面表示処理終了==========');

?>

<?php
$siteTitle = 'リスト詳細';
require('head.php');
?>

<body class="page-listDetail page-2colum page-logined">
	<style>
		/* ========================================
			お気に入りアイコン
		======================================== */
		.icn-like {
			float: left;
			color: #ddd;
		}
		.icn-like:hover {
			cursor: pointer;
		}
		.icn-like.active{
			float: left;
			color: #eeee00;
		}
	</style>

	<!-- メニュー -->
<?php
require('header.php');
?>

<p id="js-show-msg" style="display: none;" class="msg-slide">
	<?php echo getSessionFlash('msg_success'); ?>
</p>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- メイン -->
		<section id="main">
			<!-- リストの詳細 -->
			<div class="listDetail">
				<div class="listDetail-head">
					<i class="fas fa-star icn-like js-click-like <?php if(isLike($_SESSION['user_id'], $l_id)){echo 'active'; } ?>" aria-hidden="true" data-listid="<?php echo sanitize($l_id); ?>"></i>
					<h2>リスト名: <?php echo sanitize($viewData['listname']); ?></h2>
					<h3>カテゴリー名: <?php echo sanitize($viewData['categoryname']); ?></h3>
				</div>
				<div class="listDetail-content">
					<ul>
						<li><?php echo sanitize($viewContentData[0]); ?></li>
						<li><?php echo sanitize($viewContentData[1]); ?></li>
						<li><?php echo sanitize($viewContentData[2]); ?></li>
						<li><?php echo sanitize($viewContentData[3]); ?></li>
						<li><?php echo sanitize($viewContentData[4]); ?></li>
					</ul>
				</div>
				<a href="index.php<?php echo appendGetParam(array('l_id')); ?>">&lt; リスト一覧に戻る</a>
			</div>
			<!-- コメント -->
			<div class="comment">
				<h2>コメント</h2>
				<div class="area-comment" id="js-scroll-bottom">
					<?php 
						if(!empty($commentData)){
							foreach($commentData as $key => $val){
								if(!empty($val['user_id']) && $val['user_id'] != $_SESSION['user_id']){
					?>
								<div class="msg-cnt msg-left">
									<div class="avatar">
										<img src="img/ch_thumb_cuddles.gif" alt="cuddles">
									</div>
									<p class="msg-inrTxt">
										<span class="triangle"></span>
										<?php echo sanitize($val['comment']); ?>
									</p>
								</div>
					<?php
								}else{
					?>
									<div class="msg-cnt msg-right">
										<div class="avatar">
											<img src="img/ch_thumb_nutty.gif" alt="nutty">
										</div>
										<p class="msg-inrTxt">
											<span class="triangle"></span>
											<?php echo sanitize($val['comment']); ?>
										</p>
									</div>
					<?php 
								}
							}
						}else{
					?>
						<p style="text-aline:center; line-height:20;">コメント投稿はまだありません</p>
					<?php
						}
					?>
				</div>
				<div class="area-send-msg">
					<form action="" method="post">
						<textarea name="comment" id="" cols="30" rows="3"></textarea>
						<input type="submit" name="" id="" value="送信" class="btn btn-send">
					</form>
				</div>
			</div>
				
		</section>
		
		<!-- <script>
			$(function(){
				$('#js-scroll-bottom').animate({scrollTop:$('#js-scroll-bottom')[0].scrollHeight},'fast');
			});
		</script> -->

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

<?php
// 共通変数・関数の読み込み
require('function.php');
debug('========== リスト登録ページ ==========');
debugLogStart();

// ログイン認証
require('auth.php');

// ========================================
// 画面処理
// ========================================

// 画面表示用データ取得
// ========================================
// GETデータを格納
$l_id = (!empty($_GET['l_id'])) ? $_GET['l_id'] : '';
// DBから商品データを取得
$dbFormData = (!empty($l_id)) ? getList($_SESSION['user_id'], $l_id) : '';
// 新規登録画面か編集画面か判別用フラグ
$edit_flg = (empty($dbFormData)) ? false : true;
// DBからカテゴリデータを取得
$dbCategoryData = getCategory();
debug('リストID($l_id):'.$l_id);
debug('フォーム用DBデータ($dbFormData):'.print_r($dbFormData,true));
// debug('カテゴリデータ($dbCategoryData):'.print_r($dbCategoryData,true));

// パラメータ改ざんチェック
// ========================================
// GETパラメータはあるが、改ざんされている場合、正しいリストデータが取れないのでマイページへ遷移させる
if(!empty($_GET['l_id']) && empty($dbFormData)){
	debug('GETパラメータのリストIDが違います。マイページへ遷移します。');
	header("Location:mypage.php");
}

// POST送信時処理
// ========================================
if(!empty($_POST)){
	debug('post送信があります。');
	debug('POST情報:'.print_r($_POST,true));

	// 変数にユーザー情報を代入
	$listname = $_POST['listname'];
	$category = $_POST['category_id'];
	$content = $_POST['listcontent'];
	debug('リストコンテンツ($content):'.print_r($content,true));

	// 更新の場合はDBの情報と入力情報が異なる場合にバリデーションを行う
	if(empty($dbFormData)){
		// 未入力チェック
		validRequired($listname, 'listname');
		// 最大文字数チェック(名前)
		validMaxLen($listname, 'listname');
		// セレクトボックスチェック
		validSelect($category, 'category_id');
		// 最大文字数チェック(コメント)
		foreach($content as $key => $val){
			validMaxLen($val, 'listcontent', 100);
		}
	}else{
		if($dbFormData['listname'] !== $listname){
			// 未入力チェック
			validRequired($listname, 'listname');
			// 最大文字数チェック
			validMaxLen($listname, 'listname');
		}
		if($dbFormData['category_id'] !== $category){
			// セレクトボックスチェック
			validSelect($category, 'category_id');
		}
		if($dbFormData['listcontent'] !== $content){
			// 最大文字数チェック
			validMaxLen($content, 'listcontent', 100);
		}
	}

	if(empty($err_msg)){
		debug('バリデーションOKです。');

		// 例外処理
		try {
			// DB接続
			$dbh = dbConnect();
			// SQL文作成
			// 編集の場合はUPDATE文、新規登録の場合はINSERT文を生成
			if($edit_flg){
				debug('DB更新です。');
				$sql = 'UPDATE lists SET listname = :listname, category_id = :category, listcontent = :content WHERE user_id = :u_id AND list_id = :l_id';
				$data = array(':listname' => $listname, ':category' => $category, ':content' => $content, ':u_id' => $_SESSION['user_id'], ':l_id' => $l_id);
			}else{
				debug('DB新規登録です。');
				$sql = 'INSERT INTO lists (listname, category_id, content1, content2, content3, content4, content5, user_id, create_date) VALUES (:listname, :category, :content1, :content2, :content3, :content4, :content5, :u_id, :date)';
				
				$data = array(':listname' => $listname, ':category' => $category, ':content1' => $content[0], ':content2' => $content[1], ':content3' => $content[2], ':content4' => $content[3], ':content5' => $content[4], ':u_id' => $_SESSION['user_id'], ':date' => date('Y-m-d H:i:s'));
			}
			debug('SQL:'.$sql);
			debug('流し込みデータ:'.print_r($data,true));
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);

			// クエリ成功の場合
			if($stmt){
				$_SESSION['msg_success'] = SUC04;
				debug('マイページへ遷移します。');
				header("Location:mypage.php");
			}
		}catch(Exepsion $e){
			error_log('エラー発生:'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}else{
		debug('バリデーションNG');
		debug('エラー内容:'.print_r($err_msg,true));
	}
}
debug('========== 画面表示処理終了 ==========');

?>

<?php
$siteTitle = ($edit_flg) ? 'リスト編集' : 'リスト投稿';
require('head.php');
?>

<body class="page-registList page-2colum page-logined">

	<!-- メニュー -->
	<?php
	require('header.php');
	?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">
		<h1 class="page-title"><?php echo ($edit_flg) ? 'リストを編集' : 'リストを投稿する'; ?></h1>

		<!-- メイン -->
		<section class="" id="main">
			<div class="form-container">
				<form action="" method="post" class="form">
					<div class="area-msg">
						<?php 
							echo getErrMsg('common');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['listname'])) echo 'err'; ?>">
						リスト名<span class="label-require">必須</span>
						<input type="text" name="listname" value="<?php echo getFormData('listname'); ?>">
					</label>
					<div class="area-msg">
						<?php 
							echo getErrMsg('listname');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['category_id'])) echo 'err'; ?>">
						カテゴリ<span class="label-require">必須</span>
						<select  name="category_id" id="">
							<option value="0" <?php if(getFormData('category_id') == 0){ echo 'selected';} ?>>選択してください</option>
							<?php
								foreach($dbCategoryData as $key => $val){
							?>
							<option value="<?php echo $val['category_id'] ?>" <?php if(getFormData('category_id') == $val['category_id'] ){echo 'selected'; } ?> >
							<?php echo $val['categoryname']; ?>
						</option>
						<?php
							}
						?>
						</select>
					</label>
					<div class="area-msg">
						<?php 
							echo getErrMsg('category_id');
						?>
					</div>
					<label class="<?php if(!empty($err_msg['listcontent'])) echo 'err'; ?>">
							リスト内容
							<input type="text" name="listcontent[]" value="<?php echo $_POST['listcontent'][0]; ?>">
							<input type="text" name="listcontent[]" value="<?php echo $_POST['listcontent'][1]; ?>">
							<input type="text" name="listcontent[]" value="<?php echo $_POST['listcontent'][2]; ?>">
							<input type="text" name="listcontent[]" value="<?php echo $_POST['listcontent'][3]; ?>">
							<input type="text" name="listcontent[]" value="<?php echo $_POST['listcontent'][4]; ?>">
							
					</label>
					<div class="area-msg">
						<?php 
							echo getErrMsg('listcontent');
						?>
					</div>
					<!-- <p class="counter-text"><span id="js-count-view">0</span>/100文字</p> -->

					<div class="btn-container">
						<input type="submit" class="btn btn-mid" value="<?php echo (!$edit_flg) ? '投稿する' : '更新する'; ?>">
					</div>
				</form>
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

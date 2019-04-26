<?php
// 共通変数・関数の読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// =====================================
// 画面処理
// =====================================

// 画面表示用データ取得
// =====================================
// 検索機能
// -------------------------------------
// 現在のページ
$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1 ;// デフォルトは1ページ目
// カテゴリ
$category = (!empty($_GET['c_id'])) ? $_GET['c_id'] : '';
// パラメータに不正な値が入っているかチェック
if(!is_int((int)$currentPageNum)){ // $currentPageNumをint型にキャストしてる
	error_log('エラー発生:指定ページに不正な値が入りました。');
	header("Location:index.php");
}
// 表示件数
$listSpan = 12;
// 現在の表示レコード先頭を算出
$currentMinNum = (($currentPageNum-1)*$listSpan);// ex. 1ページ目 (1-1)*20 = 0、2ページ目 (2-1)*20 = 20
// DBからリストデータを取得
$dbListData = getListList($currentMinNum, $category);
// DBからカテゴリデータを取得
$dbCategoryData = getCategory();
debug('現在のページ:'.$currentPageNum);
// debug('フォーム用DBデータ:'.print_r($dbFormData,true));
// debug('カテゴリデータ:'.print_r($dbCategoryData,true));
debug('リストデータ:'.print_r($dbListData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

?>


<?php
$siteTitle = 'TOP';
require('head.php');
?>

<body class="page-passEdit page-2colum page-logined">

	<!-- メニュー -->
<?php
require('header.php');
?>

	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">

		<!-- サイドバー -->
		<section id="sidebar">
			<form action="" method="get">
				<h1 class="title">カテゴリー</h1>
				<div class="selectbox">
					<span class="icn_select"></span>
					<select name="c_id" id="">
						<option value="0"<?php if(getFormData('c_id', true) == 0 ){ echo 'selected'; } ?>>選択してください</option>
						<?php
							foreach($dbCategoryData as $key => $val){
						?>
							<option value="<?php echo $val['category_id'] ?>" <?php if(getFormData('c_id', true) == $val['category_id']){ echo 'selected';} ?>>
								<?php echo $val['categoryname']; ?>
							</option>
						<?php
							}
						?>
					</select>
				</div>
				<input type="submit" value="検索">
			</form>
		</section>

		<!-- メイン -->
		<section id="main">
			<div class="search-title">
				<div class="search-left">
					<span class="total-num"><?php echo sanitize($dbListData['total']); ?></span>件のリストが見つかりました
				</div>
				<div class="search-right">
					<span class="num"><?php echo (!empty($dbListData['data'])) ? $currentMinNum + 1 : 0; ?></span> - <span class="num"><?php echo $currentMinNum + count($dbListData['data']); ?></span>件/ <span class="num"><?php echo sanitize($dbListData['total']); ?></span>件中
				</div>
			</div>
			<div class="panel-list">
				<?php
					foreach($dbListData['data'] as $key => $val):
				?>
				<a href="listDetail.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&l_id='.$val['list_id'] : '?l_id='.$val['list_id']; ?>
				<?php // echo appendGetParam().'&l_id='.$val['list_id'];// '?l_id='.$val['list_id']; ?>" class="panel">
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
				?>
			</div>
			
			<?php
				pagenation($currentPageNum, $dbListData['total_page'], $_GET['c_id']);
			?>
		</section>

	</div>

<?php
require('footer.php');
?>

</body>
</html>

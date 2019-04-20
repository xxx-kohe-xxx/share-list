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
// 現在のページのGETパラメータを取得
$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1 ;// デフォルトは1ページ目
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
$dbListData = getListList($currentMinNum);
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
			<form action="">
				<h1 class="title">カテゴリー</h1>
				<div class="selectbox">
					<span class="icn_select"></span>
					<select name="category" id="">
						<option value="1">持ち物リスト</option>
						<option value="2">備忘録</option>
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
					<span class="num"><?php echo $currentMinNum + 1; ?></span> - <span class="num"><?php echo $currentMinNum + $listSpan; ?></span>件/ <span class="num"><?php echo sanitize($dbListData['total']); ?></span>件中
				</div>
			</div>
			<div class="panel-list">
				<?php
					foreach($dbListData['data'] as $key => $val):
				?>
				<a href="listDetail.php?l_id=<?php echo $val['list_id']; ?>" class="panel">
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

			<div class="pagination">
				<ul class="pagination-list">
					<?php
						$pageColNum = 5; // ページ項目を何項目だすか?
						$totalPageNum = $dbListData['total_page'];
						// 現在のページが総ページ数と同じかつ、総ページ数がページ項目数以上の場合
						if($currentPageNum == $totalPageNum && $totalPageNum >= $pageColNum){
							$minPageNum = $currentPageNum - 4;
							$maxPageNum = $currentPageNum;
						// 現在のページが総ページ数の1ページ前の場合
						}elseif($currentPageNum == ($totalPageNum - 1) && $totalPageNum >= $pageColNum){
							$minPageNum = $currentPageNum - 3;
							$maxPageNum = $currentPageNum + 1;
						// 現在のページが2の場合
						}elseif($currentPageNum == 2 && $totalPageNum >= $pageColNum){
							$minPageNum = $currentPageNum - 1;
							$maxPageNum = $currentPageNum + 3;
						// 現在のページが1の場合
						}elseif($currentPageNum == 1 && $totalPageNum >= $pageColNum){
							$minPageNum = $currentPageNum;
							$maxPageNum = 5;
						// 総ページ数がページ項目数より少ない場合
						}elseif($totalPageNum < $pageColNum){
							$minPageNum = 1;
							$maxPageNum = $totalPageNum;
						// それ以外の場合
						}else{
							$minPageNum = $currentPageNum - 2;
							$maxPageNum = $currentPageNum + 2;
						}
					?>
					<?php if($currentPageNum != 1): ?>
						<li class="list-item"><a href="?p=1">&lt;</a></li>
					<?php endif; ?>
					<?php
						for($i = $minPageNum; $i <= $maxPageNum; $i++):
					?>
					<li class="list-item <?php if($currentPageNum == $i) echo 'active'; ?>">
							<a href="?p=<?php echo $i; ?>"><?php echo $i; ?></a>
					</li>
					<?php
						endfor;
					?>
					<?php if($currentPageNum != $maxPageNum): ?>
						<li class="list-item"><a href="?p=<?php echo $maxPageNum; ?>">&gt;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</section>

	</div>

<?php
require('footer.php');
?>

</body>
</html>

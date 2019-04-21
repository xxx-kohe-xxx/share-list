<?php 
// ========================================
// ログ
// ========================================
//ログを取るか
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');

// ========================================
// デバッグ
// ========================================
// デバッグフラグ
$debug_flg = true;
// デバッグログ関数
function debug($str){
  global $debug_flg;
  if(!empty($debug_flg)){
    error_log('デバッグ: '.$str);
  }
}

// ========================================
// セッション準備・セッション有効期限延ばす
// ========================================
// セッションファイルの置き場を変更する(/var/tmp/以下に置くと30日は削除されない)
session_save_path("/var/tmp/");
// ガーベージコレクションが削除するセッションの有効期限を設定(30日以上たっているものに対してだけ100分の1の確率で削除)
ini_set('session.gc_maxlifetime', 60*60*24*30);
// ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60*60*24*30);
// セッションを使う
session_start();
// 現在のセッションIDを新しく生成したものと置き換える(なりすましのセキュリティ対策)
session_regenerate_id();

// ========================================
// 画面表示処理開始ログ吐き出し関数
// ========================================
function debugLogStart(){
  debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
  debug('セッションID: '.session_id());
  debug('セッション変数の中身: '.print_r($_SESSION,true));
  debug('現在日時タイムスタンプ: '.time());
  if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
    debug('ログイン期限日時タイムスタンプ: '.($_SESSION['login_date'] + $_SESSION['login_limit']));
  }
}

// ========================================
// 定数
// ========================================
//メッセージを定数に設定

define('MSG01','入力必須です');//入力項目が空欄のとき
define('MSG02','Emailの形式で入力してください');//Emailの正規表現と異なるとき
define('MSG03','パスワード(再入力)が合っていません'); //passとpass_reが一致しないとき
define('MSG04','英数字のみご利用いただけます'); //英数字以外が入力されたとき
define('MSG05','6文字以上で入力してください'); //6文字以下のとき
define('MSG06','255文字以内で入力してください'); //255文字以上入力されたとき
define('MSG07','エラーが発生しました。しばらくたってからやり直してください');//例外的なエラーが発生したとき。サーバーが止まった時とか？
define('MSG08','そのEmailはすでに登録されています'); //Emailが重複で登録されたとき
define('MSG09','メールアドレスまたはパスワードが違います');// パスワードが一致しないとき
define('MSG10','古いパスワードが違います'); // パスワードが一致しないとき
define('MSG11','古いパスワードと同じです'); // パスワードが古いパスと一致したとき
define('MSG12','文字で入力してください'); // 固定長長さ以外で入力したとき
define('MSG13','認証キーが間違っています'); // 認証キーが一致しないとき
define('MSG14','有効期限が切れています'); // 有効期限切れ
define('MSG15','半角数字のみご利用できます');
define('MSG16','正しくありません');
define('SUC01','パスワードを変更しました');
define('SUC02','プロフィールを変更しました');
define('SUC03','メールを送信しました');
define('SUC04','登録しました');


// ========================================
// グローバル変数
// ========================================
//エラーメッセージ格納用の配列
$err_msg = array(); //define~~で定義した定数を格納するのに使う

// ========================================
// バリデーションチェック関数
// ========================================
// バリデーション関数(未入力チェック)
function validRequired($str, $key){
	if($str === ''){
		global $err_msg; //関数外の変数を使うという宣言
		$err_msg[$key] = MSG01;
	}else{
		debug('未入力チェックOK');
	}
}
//バリデーションチェック関数(Email形式チェック)
function validEmail($str,$key){
	if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",$str)){
		global $err_msg;
		$err_msg[$key] = MSG02;
	}else{
		debug('Email形式チェックOK');
	}
}
// バリデーションチェック関数(Email重複チェック)
function validEmailDup($email){
	global $err_msg;
	try {
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT count(*) FROM users WHERE email = :email AND del_flg = 0';
		$data = array(':email' => $email);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ結果の値を取得
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		// array_shift関数は配列の先頭を取り出す関数。クエリ結果は配列形式で入っているので、array_shiftで1つ目だけを取りだして判定する
		if(!empty(array_shift($result))){
			$err_msg['email'] = MSG08;
		}
	} catch (Exception $e) {
		error_log('エラー発生:'. $e->getMessage());
		$err_msg['common'] = MSG07;
	}
}
// バリデーションチェック関数(同値チェック)
function validMatch($str1, $str2, $key){
	if($str1 !== $str2){
		global $err_msg;
		$err_msg[$key] = MSG03;
	}
}
// バリデーションチェック関数(最小文字数チェック)
function validMinLen($str, $key, $min = 6){
	if(mb_strlen($str) < $min){
		global $err_msg;
		$err_msg[$key] = MSG05;
	}else{
		debug('最小文字数チェックOK');
	}
}
// バリデーションチェック関数(最大文字数チェック)
function validMaxLen($str, $key, $max = 255){
	if(mb_strlen($str) > $max){
		global $err_msg;
		$err_msg[$key] = $max.MSG12;
	}else{
		debug('最大文字数チェックOK');
	}
}
// バリデーションチェック関数(半角チェック)
function validHalf($str, $key){
	if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG04;
	}else{
		debug('半角チェックOK');
	}
}
// 固定長チェック
function validLength($str, $key, $len = 8){
	if(mb_strlen($str) !== $len){
		global $err_msg;
		$err_msg[$key] = $len.MSG12;
	}else{
		debug('固定長チェックOK');
	}
}
// パスワードチェック関数
function validPass($str, $key){
	global $err_msg;
	// 半角英数字チェック
	validHalf($str, $key);
	// 最大文字数チェック
	validMaxLen($str, $key);
	// 最小文字数チェック
	validMinLen($str, $key);
	if(empty($err_msg)){
		debug('パスワードチェックOK');
	}
}
// selectboxチェック
function validSelect($str, $key){
	if(!preg_match("/^[0-9]+$/",$str)){
		global $err_msg;
		$err_msg[$key] = MSG16;
	}
}
// エラーメッセージ表示
function getErrMsg($key){
	global $err_msg;
	if(!empty($err_msg[$key])){
		return $err_msg[$key];
	}
}

// ========================================
// データベース
// ========================================
// DB接続関数
function dbConnect(){
	// DBへの接続準備
	$dsn = 'mysql:dbname=share_list;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$options = array(
		// SQL実行失敗時にはエラーコードのみ設定
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		// デフォルトフェッチモードを連想配列形式に設定
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		// バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
		// SELECTで得た結果にたいしてもrowCountメソッドを使えるようにする
		PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
	);
	// PDOオブジェクト生成(DBへ接続)
	$dbh = new PDO($dsn, $user, $password, $options);
	return $dbh;
}
// SQL実行関数
function queryPost($dbh, $sql, $data){
	// クエリ作成
	$stmt = $dbh->prepare($sql);
	// プレースホルダに値をセットし、SQL文を実行
	if(!$stmt->execute($data)){
		debug('クエリに失敗しました。');
		debug('失敗したSQL:'.print_r($stmt,true));
		$err_msg['common'] = MSG07;
		return 0;
	}
	debug('クエリ成功。');
	return $stmt;
}
// ユーザーデータ取得関数
function getUser($u_id){
	debug('ユーザー情報を取得します。');
	// 例外処理
	try {
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT * FROM users WHERE user_id = :u_id AND del_flg = 0';
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
	} catch(Exception $e){
		error_log('エラー発生:'.$e->getMessage());
	}
	// クエリデータを返す
	// return $stmt->fetch(PDO::FETCH_ASSOC);
}
// リストデータを取得
function getList($u_id, $l_id){
	debug('リスト情報を取得します。');
	debug('ユーザーID:'.$u_id);
	debug('リストID:'.$l_id);
	// 例外処理
	try {

		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT * FROM lists WHERE user_id = :u_id AND list_id = :l_id AND del_flg = 0';
		$data = array(':u_id' => $u_id, ':l_id' => $l_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		
		if($stmt){
			// クエリ結果のデータを1レコード返却
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
	}	catch(Exception $e){ 
		error_log('エラー発生:'.$e->getMessage());
	}
}
// リスト一覧のデータを取得
function getListList($currentMinNum = 1, $span =12){
	debug('リスト情報を取得します。');
	// 例外処理
	try {
		// DBと接続
		$dbh = dbConnect();
		// 件数用のSQL文作成
		$sql = 'SELECT list_id FROM lists';
		$data = array();
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$rst['total'] = $stmt->rowCount(); // 総レコード数
		$rst['total_page'] = ceil($rst['total']/$span); // 総ページ数
		if(!$stmt){
			return false;
		}
		
		// ページング用のSQL文作成
		$sql  = 'SELECT * FROM lists';
		$sql .= ' LIMIT '.$span.' OFFSET '.$currentMinNum;
		$data = array();
		debug('SQL:'.$sql);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		if($stmt){
			// クエリ結果のデータの全レコードを格納
			$rst['data'] = $stmt->fetchAll();
			return $rst;
		}else{
			return false;
		}
	} catch (Execption $e){
		error_log('エラー発生:'.$e->getMessage());
	}
}
// リスト情報を取得
function getListOne($l_id){
	debug('リスト情報を取得します。');
	debug('リストID:'.$l_id);
	// 例外処理
	try {
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT list_id, listname, l.category_id, user_id, listcontent, l.create_date, l.update_date, categoryname
		FROM lists AS l LEFT JOIN category AS c ON l.category_id = c.category_id
		WHERE list_id = :l_id AND l.del_flg = 0 AND c.del_flg = 0';
		$data = array(':l_id' => $l_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			// クエリ結果のデータを1レコード返却
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
	} catch(Execption $e){
		error_log('エラー発生:'.$e->getMessage());
	}
}
// カテゴリーデータを取得
function getCategory(){
	debug('カテゴリー情報を取得します。');
	// 例外処理
	try {
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT * FROM category';
		$data = array();
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			// クエリの全データを返却
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch(Exception $e){
		error_log('エラー発生:'.$e->getMessage());
	}
}

// ========================================
// メール送信
// ========================================
function sendMail($from, $to, $subject, $comment){
	if(!empty($to) && !empty($subject) && !empty($comment)){
		// 文字化けしないように設定(お決まりパターン)
		mb_language("japanese"); // 現在使っている言語の設定
		mb_internal_encoding("UTF-8"); // 内部の日本語をどうエンコーディングするかを設定

		// メールを送信(結果がTRUEかFALSEで返ってくる)
		$result = mb_send_mail($to, $subject, $comment, "from:".$from);
		// 送信結果を判定
		if($result){
			debug('メール送信しました');
		}else{
			debug('【エラー発生】メール送信に失敗しました。');
		}
	}
}

// ========================================
// その他
// ========================================
// サニタイズ
function sanitize($str){
	return htmlspecialchars($str,ENT_QUOTES);
}
// フォーム入力保持
function getFormData($str){
	global $dbFormData;
	// ユーザーデータがある場合
	if(!empty($dbFormData)){
		// フォームのエラーがある場合
		if(!empty($err_msg[$str])){
			// POSTにデータがある場合
			if(isset($_POST[$str])){
				return $_POST[$str];
			}else{
				// ない場合(フォームにエラーがある=POSTされているはずなのでまずありえない)はDBの情報を表示
				return $dbFormData[$str];
			}
		}else{
			// POSTにデータがあり、DBの情報と違う場合(このフォームも変更していてエラーはないが、ほかのフォームで引っかかっている状態)
			if(isset($_POST[$str]) && $_POST[$str] !== $dbFormData[$str]){
				return $_POST[$str];
			}else{
				// 変更なし
				return $dbFormData[$str];
			}
		}
	}else{
		if(isset($_POST[$str])){
			return $_POST[$str];
		}
	}
}
// セッションを一回だけ取得できる
function getSessionFlash($key){
	if(!empty($_SESSION[$key])){
		$data = $_SESSION[$key];
		$_SESSION[$key] = '';
		return $data;
	}
}
// ランダム文字(8文字)生成関数
function makeRandKey($length = 8){
	static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
	$str = '';
	for ($i = 0; $i < $length; ++$i){
		$str .= $chars[mt_rand(0,61)];
	}
	return $str;
}
// ページング
// $currentPageNum: 現在のページ
// $totalPageNum: 総ページ数
// $link: 検索用GETパラメータリンク
// $pageColNum: 表示ページ項目数
function pagenation($currentPageNum, $totalPageNum, $link = '', $pageColNum = 5){
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

	echo '<div class="pagination">';
		echo '<ul class="pagination-list">';
		if($currentPageNum != 1){
			echo '<li class="list-item"><a href="?p=1">&lt;</a></li>';
		}
		for($i = $minPageNum; $i <= $maxPageNum; $i++){
			echo '<li class="list-item ';
			if($currentPageNum == $i){ echo 'active';}
			echo '"><a href="?p='.$i.$link.'">'.$i.'</a></li>';
		}
		if($currentPageNum != $maxPageNum){
			echo '<li class="list-item"><a href="?p='.$maxPageNum.$link.'">&gt;</a></li>';
		}
		echo '</ul>';
	echo '</div>';
}
// GETパラメータ付与
// $del_key: 付与から取り除きたいGETパラメータのキー
function appendGetParam($arr_del_key){
	if(!empty($_GET)){
		$str = '?';
		debug('GETパラメータ:'.print_r($_GET,true));
		foreach($_GET as $key => $val){
			debug('key:'.print_r($key, true));
			debug('val:'.print_r($val, true));
			debug('arr_del_key:'.print_r($arr_del_key,true));
			if(!in_array($key, $arr_del_key, true)){
				$str .= $key .'='.$val.'&';
			}
		}
		$str = mb_substr($str, 0, -1, "UTF-8");
		echo $str;
	}
}
?>
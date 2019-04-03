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
//エラーメッセージを定数に設定

//入力項目が空欄のとき
define('MSG01','入力必須です');

//Emailの正規表現と異なるとき
define('MSG02','Emailの形式で入力してください');

//passとpass_reが一致しないとき
define('MSG03','パスワード(再入力)が合っていません'); 

//英数字以外が入力されたとき
define('MSG04','英数字のみご利用いただけます'); 

//6文字以下のとき
define('MSG05','6文字以上で入力してください'); 

//255文字以上入力されたとき
define('MSG06','255文字以内で入力してください'); 

//例外的なエラーが発生したとき。サーバーが止まった時とか？
define('MSG07','エラーが発生しました。しばらくたってからやり直してください');

//Emailが重複で登録されたとき
define('MSG08','そのEmailはすでに登録されています'); 

// パスワードが一致しないとき
define('MSG09', 'メールアドレスまたはパスワードが違います');

// ========================================
// バリデーションチェック関数
// ========================================

//エラーメッセージ格納用の配列
$err_msg = array(); //define~~で定義した定数を格納するのに使う

// バリデーション関数(未入力チェック)
function validRequired($str, $key){
	if(empty($str)){
		global $err_msg; //関数外の変数を使うという宣言
		$err_msg[$key] = MSG01;
	}
}

//バリデーションチェック関数(Email形式チェック)
function validEmail($str,$key){
	if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",$str)){
		global $err_msg;
		$err_msg[$key] = MSG02;
	}
}

// バリデーションチェック関数(Email重複チェック)
function validEmailDup($email){
	global $err_msg;
	try {
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT count(*) FROM users WHERE email = :email';
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
	}
}

// バリデーションチェック関数(最大文字数チェック)
function validMaxLen($str, $key, $max = 255){
	if(mb_strlen($str) > $max){
		global $err_msg;
		$err_msg[$key] = MSG06;
	}
}

// バリデーションチェック関数(半角チェック)
function validHalf($str, $key){
	if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG04;
	}
}

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
	$stmt->execute($data);
	return $stmt;
}

?>
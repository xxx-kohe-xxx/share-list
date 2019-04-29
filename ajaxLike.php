<?php
// 共通変数・関数の読み込み
require('function.php');

debug('==========Ajax==========');
debugLogStart();

// ========================================
// Ajax処理
// ========================================

// POSTがあり、ユーザーIDがあり、ログインしている場合
if(isset($_POST['listId']) && isset($_SESSION['user_id']) && isLogin()){
  debug('POST送信があります。');
  $l_id = $_POST['listId'];
  debug('リストID: '.$l_id);

  // 例外処理
  try{
    // DB接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT list_id, user_id FROM likes WHERE list_id = :l_id AND user_id = :u_id';
		$data = array(':l_id' => $l_id, ':u_id' => $_SESSION['user_id']);
		// クエリ実行
    $stmt = queryPost($dbh, $sql, $data);
    $resultCount = $stmt->rowCount();
    debug('レコード数: '.$resultCount);
    // レコードが1件でもある場合
    if(!empty($resultCount)){
      // レコードを削除する
      $sql = 'DELETE FROM likes WHERE list_id = :l_id AND user_id = :u_id';
      $data = array(':l_id' => $l_id, ':u_id' => $_SESSION['user_id']);
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);
    }else{
      // レコードを挿入する
      $sql = 'INSERT INTO likes (list_id, user_id, create_date) VALUES (:l_id, :u_id, :date)';
      $data = array(':l_id' => $l_id, ':u_id' => $_SESSION['user_id'], ':date' => date('Y-m-d H:i:s'));
      // クエリ実行 
      $stmt = queryPost($dbh, $sql, $data);
    }

  }catch(Exception $e){
    error_log('エラー発生: '.$e->getMessage());
  }
}
debug('========== Ajax処理終了 ==========');
?>

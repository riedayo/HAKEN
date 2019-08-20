<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　店舗マイページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

$tenpo_id = $_SESSION['tenpo_id'];

//例外処理
try{
  //DB接続
  $dbh = dbConnect();
  //SQL文作成
  //編集画面の場合はUPDATE、新規登録画面の場合はINSERT文を作成
  if($tenpo_id){
    debug('案件を編集したようです');
    $sql = 'SELECT * FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id WHERE a.tenpo_id = :id';
    $data = array(':id' => $tenpo_id);
  }
  debug('SQL:'.$sql);
  debug('流し込みデータ:'.print_r($data,true));

  //クエリ実行
  $stmt = queryPost($dbh,$sql,$data);
  //var_dump($stmt->fetch(PDO::FETCH_ASSOC));

  //クエリ成功の場合

}catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  $err_msg['common'] = MSG07;
}

 ?>

<?php
$siteTitle = '店舗マイページ';
require('head.php');
 ?>

  <body class="page-login page-2colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>

     <p id="js-show-msg" style="display:none;" class="msg-slide">
       <?php echo getSessionFlash('msg_success'); ?>
     </p>

    <!-- メインコンテンツ -->
    <h2>募集した案件一覧</h2>
    <div id="contents" class="site-width">





      <?php
      require('tenpo_mypage_sidebar.php');
       ?>


      <!-- Main -->
      <?php
      require('allAnken.php');
       ?>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>

<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　index　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();


//例外処理
try{
  //DB接続
  $dbh = dbConnect();
  //SQL文作成
  //編集画面の場合はUPDATE、新規登録画面の場合はINSERT文を作成
    debug('全案件をSQLで取得開始します');
    $sql = 'SELECT * FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id order by a.id desc';
    $data = array();

  debug('SQL:'.$sql);
  debug('流し込みデータ:'.print_r($data,true));

  //クエリ実行
  $stmt = queryPost($dbh,$sql,$data);
  //var_dump($stmt->fetch(PDO::FETCH_ASSOC));
  //$rst['data'] = $stmt->fetch(PDO::FETCH_ASSOC);

  //クエリ成功の場合

}catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  $err_msg['common'] = MSG07;
}

 ?>


<?php
$siteTitle = 'トップページ';
require('head.php');
 ?>

  <body class="page-login page-2colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <h2>お仕事一覧</h2>
    <div id="contents" class="site-width">





      <!-- サイドバー -->
      <section id="sidebar">
        <form class="search-bar" action="index.php" method="get">
          <label class="calendar-label">

          <input type="date" name="date" value="">
          <i class="fas fa-calendar-alt fa-lg calendar"></i>
          </label>
          <label class="search">
            <h1 class="title">時給</h1>
            <div class="selectbox">
              <span class="icn-select"></span>
              <select class="sidebar-select" name="pay">
                <option value="" selected>選択してください</option>
                <option value="">2000円</option>
                <option value="">2500円</option>
                <option value="">3000円</option>
                <option value="">3500円</option>
                <option value="">4000円</option>
                <option value="">4500円</option>
                <option value="">5000円</option>
              </select>
            </div>

          </label>
          <label class="search">
            <h1 class="title">業種</h1>
            <div class="selectbox">
              <span class="icn-select"></span>
              <select class="sidebar-select" name="category">
                <option value="" selected>選択してください</option>
                <option value="">キャバクラ</option>
                <option value="">ガールズバー</option>
                <option value="">クラブ</option>
                <option value="">スナック</option>
                <option value="">昼キャバ</option>
              </select>
            </div>

          </label>
          <label class="search">
            <h1 class="title">最寄駅</h1>
            <div class="selectbox">
              <span class="icn-select"></span>
              <select class="sidebar-select" name="station">
                <option value="" selected>選択してください</option>
                <option value="">渋谷</option>
                <option value="">恵比寿</option>
                <option value="">六本木</option>
                <option value="">横浜</option>
                <option value="">町田</option>
              </select>
            </div>
          </label>
          <input type="submit" name="" value="検索">
        </form>

      </section>


      <!-- Main -->

      <?php
      require('allAnken.php');
       ?>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>

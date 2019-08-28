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
    $sql = 'SELECT a.id  , `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, a.delete_flg, a.create_date, a.update_date ,   `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, t.login_time, t.delete_flg, t.create_date, t.update_date FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id order by a.id desc';
    $data = array();

    // `id`, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, `delete_flg`, `create_date`, `update_date` , `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, `login_time`, `delete_flg`, `create_date`, `update_date`

  debug('SQL:'.$sql);
  debug('流し込みデータ:'.print_r($data,true));


  //クエリ実行
  $stmt = queryPost($dbh,$sql,$data);
  
  debug('$stmtの中身：'.print_r($stmt->fetch(PDO::FETCH_ASSOC),true));
 
  //var_dump($stmt->fetch(PDO::FETCH_ASSOC));
  $rst = $stmt->fetchAll();
  //var_dump($rst,true);

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

      <section id="main">
  <table>
    <thead>
      <tr>
        <th style="width: 200px;">日付</th>
        <th>最寄り駅</th>
        <th>店名</th>
        <th>時給</th>
        <th>時間</th>
        <th></th>
      </tr>
    </thead>

      <?php

      foreach ($rst as $key => $val):
       ?>
    <tbody>
      <td><?php echo date('Y年m月d日', strtotime($val['anken_date'])).week($val['anken_date']);  ?></td>
      <td><?php echo $val['station']; ?></td>
      <td><?php echo $val['tenpo_name']; ?></td>
      <td><?php echo $val['salary']; ?>円</td>
      <td><?php echo substr($val['start_time'],0,5); ?></td>
      <td><a href="ankenDetail.php?a_id=<?php echo $val['id']; ?>">詳細</a></td>

      </tbody>
      <?php
      endforeach;
      ?>



  
  </table>


</section>


    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>

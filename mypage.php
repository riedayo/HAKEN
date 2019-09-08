<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　マイページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

$user_id = $_SESSION['user_id'];

//全案件を取ってくる
try{
  //DB接続
  $dbh = dbConnect();
  //SQL文作成
  //編集画面の場合はUPDATE、新規登録画面の場合はINSERT文を作成
    debug('全案件をSQLで取得開始します');
    $sql = 'SELECT a.id, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, a.delete_flg, a.create_date, a.update_date , `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, t.login_time, t.delete_flg, t.create_date, t.update_date FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id  WHERE simekiri_flg = 0 order by a.id desc';
    $data = array();

    // `id`, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, `delete_flg`, `create_date`, `update_date` , `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, `login_time`, `delete_flg`, `create_date`, `update_date`

  debug('SQL:'.$sql);
  debug('流し込みデータ:'.print_r($data,true));


  //クエリ実行
  $stmt = queryPost($dbh,$sql,$data);

  debug('$stmtの中身：'.print_r($stmt->fetch(PDO::FETCH_ASSOC),true));

  $rst = $stmt->fetchAll();
  debug('$rstの中身：'.print_r($rst,true));

  //var_dump($stmt->fetch(PDO::FETCH_ASSOC));
  //$rst['data'] = $stmt->fetch(PDO::FETCH_ASSOC);

  //クエリ成功の場合

}catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  $err_msg['common'] = MSG07;
}





 ?>

<?php
$siteTitle = 'マイページ';
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
    <h2>募集中のお仕事</h2>
    <div id="contents" class="site-width">





      <?php
      require('sort_sidebar.php');
       ?>

        <section id="sidebar" style="position: absolute; top: 450px;">
        <nav class="stroke">
          <ul>
            <li><a href="mypage.php">募集中のお仕事</a></li>
            <li><a href="oubo.php">応募済のお仕事</a></li>
            <li><a href="myprofEdit.php">プロフィール変更</a></li>
            <li><a href="passEdit.php">パスワード変更</a></li>
            <li><a href="withdrow.php">退会</a></li>
          </ul>
        </nav>
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

    <div class="tbody-container">
      <?php

      foreach ($rst as $key => $val):
       ?>
    <tbody>
      <td><?php echo date('Y年m月d日', strtotime($val['anken_date'])).week($val['anken_date']); ?></td>
      <td><?php echo $val['station']; ?></td>
      <td><?php echo $val['tenpo_name']; ?></td>
      <td><?php echo $val['salary']; ?>円</td>
      <td><?php echo substr($val['start_time'],0,5); ?></td>
      <td><a href="ankenDetail.php?a_id=<?php echo $val['id']; ?>">詳細</a></td>

      </tbody>
      <?php
      endforeach;
      ?>

      </div>

  
  </table>


</section>
    </div>


    <!-- footer -->
    <?php
    require('footer.php');
    ?>
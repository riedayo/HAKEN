<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　応募済みお仕事　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

$user_id = $_SESSION['user_id'];

//例外処理
try{
  //DB接続
  $dbh = dbConnect();
  //SQL文作成
  //編集画面の場合はUPDATE、新規登録画面の場合はINSERT文を作成
    debug('全案件をSQLで取得開始します');
    $sql = 'SELECT a.id, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, a.delete_flg, a.create_date, a.update_date , 
    `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, t.login_time, t.delete_flg, t.create_date, t.update_date,
    o.anken_id, o.user_id , o.delete_flg, o.create_date 
     FROM (anken AS a) LEFT JOIN tenpo AS t ON (a.tenpo_id = t.id) LEFT JOIN oubo AS o ON (a.id = o.anken_id) WHERE o.user_id = :user_id order by anken_date desc';
    $data = array(':user_id' => $user_id);

    //'.anken_id, o.user_id FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t'

  debug('SQL:'.$sql);
  debug('流し込みデータ:'.print_r($data,true));


  //クエリ実行
  $stmt = queryPost($dbh,$sql,$data);
  
  $rst = $stmt->fetchAll();
  //var_dump($rst,true);
  //debug('$stmtの中身：'.print_r($stmt->fetch(PDO::FETCH_ASSOC),true));
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
    <h2>応募済みのお仕事</h2>
    <div id="contents" class="site-width">





      <?php
      require('sidebar_mypage.php');
       ?>


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
        debug('$rstの中身：'.print_r($rst,true));
       ?>
    <tbody>
      <td><?php echo date('Y年m月d日', strtotime($val['anken_date'])).week($val['anken_date']);  ?></td>
      <td><?php if(isset($val['station'])) echo $val['station']; ?></td>
      <td><?php if(isset($val['tenpo_name'])) echo $val['tenpo_name']; ?></td>
      <td><?php if(isset($val['salary'])) echo $val['salary']; ?>円</td>
      <td><?php echo substr($val['start_time'],0,5); ?></td>
      <td><a href="ankenDetail.php?a_id=<?php if(isset($val['id'])) echo $val['id']; ?>">詳細</a></td>

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

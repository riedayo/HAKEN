<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　店舗マイページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

$tenpo_id = $_SESSION['tenpo_id'];

//例外処理
try{
  //DB接続
  $dbh = dbConnect();
  //SQL文作成
  
  if($tenpo_id){
    debug('案件情報を一覧にするために取得しています');
    $sql1 = 'SELECT a.id AS anken_id, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, a.delete_flg, a.create_date, a.update_date  , `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, t.login_time, t.delete_flg, t.create_date, t.update_date  FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id  WHERE a.tenpo_id = :id';


    $data = array(':id' => $tenpo_id);
  }
  debug('SQL:'.$sql1);
  debug('流し込みデータ(店舗id):'.print_r($data,true));

  //クエリ実行
  $stmt = queryPost($dbh,$sql1,$data);
  $rst = $stmt->fetchAll();
  
  // var_dump($rst,true);
  debug('$rstの多次元配列：'.print_r($rst,true));
  //debug('$rst['anken_id']の中身：'.print_r($rst['anken_id'],true));

  //クエリ成功の場合

}catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  $err_msg['common'] = MSG07;
}


//例外処理
try{
  //DB接続
  $dbh = dbConnect();
  //SQL文作成
  
 
  debug('応募人数を取得しています。');

  $id_column = array_column($rst,"anken_id");//案件idだけが入ってる
  $bosyu_column = array_column($rst,"bosyu");//募集人数だけが入ってる

  debug('$id_columnの中身：'.print_r($id_column,true));
  debug('$bosyu_columnの中身：'.print_r($bosyu_column,true));


  $oubo_kensu = array();

  foreach ($rst as $key => $val) {
    debug('$val[anken_id]の中身：'.print_r($val['anken_id'],true));


       $sql2 = 'SELECT COUNT(anken_id) AS anken_result FROM oubo WHERE anken_id = :anken_id';

       $data = array(':anken_id' => $val['anken_id']);
 
       debug('SQL:'.$sql2);
       debug('流し込みデータ:'.print_r($data,true));
    
      //クエリ実行
      $stmt2 = queryPost($dbh,$sql2,$data);
    
      $stmt2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      debug('$stmt2の中身：'.print_r($stmt2,true));//レコード数

      if(empty($oubo_kensu)){

        $oubo_kensu = array($val['anken_id'] => $stmt2['anken_result']);
        debug('$oubo_kensuの中身(1週目)：'.print_r($oubo_kensu,true));//レコード数

      }else{
        debug('$stmt2[anken_result]の中身(2週目)：'.print_r($stmt2['anken_result'],true));//レコード数

        $oubo_kensu_sub = array($val['anken_id'] => $stmt2['anken_result']);
    
        $oubo_kensu = $oubo_kensu + $oubo_kensu_sub;
        debug('$oubo_kensuの中身(2週目)：'.print_r($oubo_kensu,true));//レコード数


      }


      


    }   

    debug('$oubo_kensuの中身：'.print_r($oubo_kensu,true));//レコード数

  
  // debug('SQL:'.$sql2);
  // debug('流し込みデータ:'.print_r($data,true));

  // //クエリ実行
  // $stmt2 = queryPost($dbh,$sql2,$data);

  // $stmt2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      


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
    require('tenpo_header.php');
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
      <section id="main">
  <table>
    <thead>
      <tr>
        <th style="width: 200px;">日付</th>
        <th>時給</th>
        <th>時間</th>
        <th style="color:red;">応募</th>
        <th>募集</th>
        <th></th>
      </tr>
    </thead>



      <?php
      foreach ($rst as $key => $val){
       ?>
       <tbody>

      <td><?php echo date('Y年m月d日', strtotime($val['anken_date'])).' '.week($val['anken_date']);  ?></td>
      <td><?php echo $val['salary']; ?>円</td>
      <td><?php echo substr($val['start_time'],0,5); ?></td>
      <td><?php echo $oubo_kensu[$val['anken_id']];?></td>

      <td><?php echo $val['bosyu'];?></td>
      <td><a href="tenpo_ankenEdit.php?a_id=<?php echo $val['anken_id']; ?>">編集</a></td>
    
      
      </tbody>
      <?php
      }
      ?>



  
  </table>


</section>


    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>

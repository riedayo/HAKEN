<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ankenDetail　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//案件idのGETパラメータを取得
$a_id = $_GET['a_id'];

//ユーザー情報を代入
if(array_key_exists('user_id',$_SESSION)){
  $user_id = $_SESSION['user_id'];
}



//DBから案件データを取得する
$viewData = getAnkenOne($a_id);
debug('$viewDataの中身：'.print_r($viewData,true));

if(empty($viewData)){
  error_log('エラー発生:指定ページに不正な値が入りました');
  header("Location:index.php"); //トップページへ
}
debug('取得したDBデータ：'.print_r($viewData,true));


    //例外処理
    try{
      //DB接続
      $dbh = dbConnect();

      $sql = 'SELECT COUNT(anken_id) AS anken_result FROM oubo WHERE anken_id = :anken_id ';

      $data = array(':anken_id'=> $a_id);


      //クエリ実行
      $stmt = queryPost($dbh,$sql,$data);
      debug('$stmtの中身：'.print_r($stmt,true));
    
      $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
      debug('$stmtの中身：'.print_r($stmt,true));
      

      $anken_result = $stmt['anken_result'];


    //COUNTクエリ成功の場合
      if($anken_result >= $viewData['bosyu']){
        debug('$anken_resultの中身：'.print_r($anken_result,true));
        debug('$viewData[bosyu]の中身：'.print_r($viewData['bosyu'],true));
        
        $finish_flg = true;
        debug('$finish_flg変数の中身：'.print_r($finish_flg,true));     


        }

        }catch(Exception $e){
        error_log('エラー発生：'. $e->getMessage());

        $err_msg['common'] = MSG07;

    }






    if(!empty($_POST)){
      debug('POST送信があります。');

        //変数に案件情報とユーザー情報を代入
        $user_id = $_SESSION['user_id'];


          //例外処理
          try{
            //DB接続
            $dbh = dbConnect();
            $sql1 = 'INSERT INTO oubo (anken_id , user_id , create_date) VALUES (:anken_id, :user_id, :create_date )';

            $data = array(':anken_id'=> $a_id, ':user_id' => $user_id, ':create_date' => date('Y-m-d H:i:s'));


            //クエリ実行
            $stmt1 = queryPost($dbh,$sql1,$data);

          }catch(Exception $e){
            error_log('エラー発生：'. $e->getMessage());

            $err_msg['common'] = MSG07;

        }


            try{
              //DB接続
              $dbh = dbConnect();
              $sql2 = 'SELECT COUNT(anken_id) AS anken_result FROM oubo WHERE anken_id = :anken_id ';
        
              $data = array(':anken_id'=> $a_id);
        
        
              //クエリ実行
              $stmt2 = queryPost($dbh,$sql2,$data);
            
              $stmt2 = $stmt2->fetch(PDO::FETCH_ASSOC);
              
        
              $anken_result = $stmt2['anken_result'];
        
        
            //COUNTクエリ成功の場合
              if($anken_result >= $viewData['bosyu']){
                debug('$anken_resultの中身：'.print_r($anken_result,true));
                debug('$viewData[bosyu]の中身：'.print_r($viewData['bosyu'],true));
                
        
        
                //締切フラグを立てる！
                  $dbh = dbConnect();
        
                  $sql3 = 'UPDATE anken SET simekiri_flg = 1 WHERE id = :id';
        
                  $data = array(':id' => $a_id);
            
                  debug('SQL:'.$sql2);
                  debug('流し込みデータ:'.print_r($data,true));
                
                  //クエリ実行
                  $stmt3 = queryPost($dbh,$sql3,$data);          
        
        
                }

          

            //INSERTクエリ成功の場合
            if($stmt1){
              
              $_SESSION['msg_success'] = SUC06;
              debug('セッション変数の中身：'.print_r($_SESSION,true));

              debug('マイページへ遷移します');
              header("Location:mypage.php");//マイページへ

              }


              }catch(Exception $e){
              error_log('エラー発生：'. $e->getMessage());

              $err_msg['common'] = MSG07;

          }
        }
      






debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
 ?>


<?php
$siteTitle = '案件詳細';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
<?php
require('header.php');
 ?>
    <!-- メインコンテンツ -->
    <h2>お仕事詳細</h2>
    <div id="contents" class="site-width">






      <!-- Main -->
      <section id="main">
        <div class="anken-detail">
        <form class="" action="" method="post">
          <table >
          <tr>
              <th>日付</th>
              
              <td><?php echo date('Y年m月d日', strtotime($viewData['anken_date'])).week($viewData['anken_date']); ?></td>
            </tr>
            <tr>
              <th>店舗名</th>
              <td><?php echo $viewData['tenpo_name']; ?></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td><?php echo $viewData['tel'];?></td>
            </tr>
            <tr>
              <th>住所</th>
              <td><?php echo $viewData['pref'];?><?php echo $viewData['addr'];?></td>
            </tr>
            <tr>
              <th>最寄駅</th>
              <td><?php echo $viewData['station'];?></td>
            </tr>
            <tr>
              <th>時給</th>
              <td><?php echo $viewData['salary'];?>円</td>
            </tr>
            <tr>
              <th>業種</th>
              <td><?php echo $viewData['category_name'];?></td>
            </tr>
            <tr>
              <th>勤務開始時間</th>
              <td><?php echo substr($viewData['start_time'],0,5);?>〜ラスト</td>
            </tr>
            <tr>
              <th>到着時間</th>
              <td>勤務時間の<?php echo $viewData['arrival_time'];?>分前</td>
            </tr>
            <tr>
              <th>派遣到着時間（２回目以降）</th>
              <td>勤務時間の<?php echo $viewData['arrival_time_re'];?>分前</td>
            </tr>
            <tr>
              <th>税金</th>
              <td><?php echo $viewData['tax'];?></td>
            </tr>
            <tr>
              <th>厚生費</th>
              <td><?php echo $viewData['kouseihi'];?>円</td>
            </tr>
            <tr>
              <th>貸衣装</th>
              <td><?php echo $viewData['dress'];?>円</td>
            </tr>
            <tr>
              <th>送迎代</th>
              <td><?php echo $viewData['car'];?>円</td>
            </tr><tr>
              <th>送迎範囲</th>
              <td><?php echo $viewData['car_hani'];?></td>
            </tr>
            <tr>
              <th>注意事項</th>
              <td><?php echo $viewData['comment'];?></td>
            </tr>
            <tr>
              <th>店内写真</th>

              <td><img src="<?php echo $viewData['pic'];?>" alt="" style="width:90%;"></td>
            </tr>

          </table>

              <input type="hidden" name="oubo_btn" value="submit">

              <?php if(!empty($_SESSION['user_id']) && empty($finish_flg)){?>

              <div class="big-btn">
                <input type="submit" name="" value="応募する">
              </div>

              <?php }else{?>

                <div></div>

              <?php } ?>

          </form>
        </div>

      </section>

    </div>




    <!-- footer -->
<?php
require('footer.php');
 ?>

<?php

//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　案件作成画面　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//================================
// 画面処理
//================================

// 画面表示用データ取得
//================================
// GETデータを格納
$a_id = (!empty($_GET['a_id'])) ? $_GET['a_id'] : '';
//var_dump($a_id);
//DBから案件データを取得
$dbFormData = (!empty($a_id)) ? getAnken($_SESSION['tenpo_id'],$a_id) : '';
//新規登録画面か編集画面か判別用フラグ
$edit_flg = (empty($dbFormData)) ? false : true;

// パラメータ改ざんチェック
//================================
// GETパラメータはあるが、改ざんされている（URLをいじくった）場合、正しい商品データが取れないのでマイページへ遷移させる
if(!empty($a_id) && empty($dbFormData)){
  debug('GETパラメータの商品IDが違います');
  header("Location:tenpo_mypage.php"); //マイページへ
}

if(!$edit_flg){

  //DBからユーザーデータを取得
  $dbFormData = getTenpo($_SESSION['tenpo_id']);

}



debug('取得したユーザー情報：'.print_r($dbFormData,true));


    //POST送信されていた場合は以下の処理が走るぞ！
    if(!empty($_POST)){
      debug('POST送信があります。');
      debug('POST情報：'.print_r($_POST,true));
      debug('FILE情報：'.print_r($_FILES,true));

      //変数にユーザー情報を代入
      $anken_date = $_POST['anken_date'];
      $salary = $_POST['salary'];
      $bosyu = $_POST['bosyu'];
      $start_time = $_POST['start_time'];
      $comment = $_POST['comment'];
      //画像をアップロードし、パスを格納
      $pic = ( !empty($_FILES['pic']['name']) ) ? uploadImg($_FILES['pic'],'pic') : '';
      //画像をPOSTしていないがすでにDBに登録されている場合、DBのパスを入れる(POSTには反映されないので)
      $pic = ( empty($pic) && !empty($dbFormData['pic']) ) ? $dbFormData['pic'] : $pic;

      //更新の場合はDBの情報と入力情報が異なる場合にバリデーションを行う
      //未入力チェック
      if(empty($dbFormData)){
      validRequired($anken_date,'anken_date');
      validRequired($salary,'salary');
      validNumber($salary,'salary');
      validRequired($bosyu,'bosyu');
      validRequired($start_time,'start_time');
      validMaxLen($comment,'comment',200);
      validRequired($pic,'pic');
    }else {
      if(array_key_exists('anken_date', $dbFormData) && $dbFormData['anken_date'] !== $anken_date){
        validRequired($anken_date,'anken_date');
      }
      if(array_key_exists('salary', $dbFormData) && $dbFormData['salary'] !== $salary){
        validRequired($salary,'salary');
        validNumber($salary,'salary');
      }
      if(array_key_exists('bosyu', $dbFormData) && $dbFormData['bosyu'] !== $bosyu){
        validRequired($bosyu,'bosyu');
        validNumber($bosyu,'bosyu');
      }
      if(array_key_exists('start_time', $dbFormData) && $dbFormData['start_time'] !== $start_time){
        validRequired($start_time,'start_time');
      }
      if(array_key_exists('comment', $dbFormData) && $dbFormData['comment'] !== $comment){
        validMaxLen($comment,'comment',200);
      }
      if(array_key_exists('pic', $dbFormData) && $dbFormData['pic'] !== $pic){
        validRequired($pic,'pic');
      }
    }

      if(empty($err_msg)){
        debug('バリデーションおk');

        //例外処理
        try{
          //DB接続
          $dbh = dbConnect();
          //SQL文作成
          //編集画面の場合はUPDATE、新規登録画面の場合はINSERT文を作成
          if($edit_flg){
            debug('案件を編集したようです');
            $sql = 'UPDATE anken SET anken_date = :anken_date, salary = :salary, bosyu = :bosyu, start_time = :start_time, comment = :comment, pic = :pic WHERE tenpo_id = :t_id AND id = :a_id';
            $data = array(':anken_date' => $anken_date, ':salary' => $salary, ':bosyu' => $bpsyu, ':start_time' => $start_time, ':comment' => $comment, ':pic' => $pic, ':t_id' => $_SESSION['tenpo_id'], ':a_id' => $a_id);
          }else{
            debug('案件を新規登録したようです');
            $sql = 'INSERT INTO anken (anken_date, salary, bosyu, start_time, comment, pic,tenpo_id, create_date) VALUES(:anken_date, :salary, :bosyu, :start_time, :comment, :pic, :t_id, :date)';
            $data = array(':anken_date' => $anken_date, ':salary' => $salary, ':bosyu' => $bosyu, ':start_time' => $start_time, ':comment' => $comment, ':pic' => $pic, ':t_id' => $_SESSION['tenpo_id'], ':date' => date('Y-m-d H:i:s'));
          }
          debug('SQL:'.$sql);
          debug('流し込みデータ:'.print_r($data,true));

          //クエリ実行
          $stmt = queryPost($dbh,$sql,$data);

          //クエリ成功の場合
          if($stmt){
            $_SESSION['msg_success'] = SUC05;
            debug('店舗マイページに遷移します');
            header("Location:tenpo_mypage.php");
          }
        }catch (Exception $e){
          error_log('エラー発生:' . $e->getMessage());
          $err_msg['common'] = MSG07;
        }
      }
    }



 ?>

<?php
$siteTitle = '案件編集';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
<?php
require('header.php');
 ?>
    <!-- メインコンテンツ -->
    <h2>お仕事を登録</h2>
    <div id="contents" class="site-width">






      <!-- Main -->
      <section id="main">
        <div class="anken-detail">
          <form class="anken-form" action="" method="post" enctype="multipart/form-data">


          <table>
            <tr>
              <th>依頼日 ※必須</th>
              <td><input type="date" name="anken_date" value="<?php if(!empty($_POST['anken_date'])) echo $_POST['anken_date']; ?>"></td>
            </tr>
            <tr>
              <th>店舗名</th>
              <td><?php echo getFormData('tenpo_name'); ?></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td><?php echo getFormData('tel'); ?></td>
            </tr>
            <tr>
              <th>住所</th>
              <td><?php echo getFormData('pref'); ?><?php echo getFormData('addr'); ?></td>
            </tr>
            <tr>
              <th>最寄駅</th>
              <td><?php echo getFormData('station'); ?></td>
            </tr>
            <tr>
              <th>時給　※必須</th>
              <td><input type="text" name="salary" placeholder="3500" value="<?php echo getFormData('salary'); ?>">円</td>
            </tr>
              <tr>
                <th>募集人数　※必須</th>
                <td><input type="text" name="bosyu" placeholder="3" value="<?php if(!empty($_POST['bosyu'])) echo $_POST['bosyu']; ?>">人</td>
              </tr>
              <tr>
              <th>業種</th>
              <td><?php echo getFormData('category'); ?></td>
            </tr>
            <tr>
              <th>勤務開始時間　※必須</th>
              <td>
              <select class="time" name="start_time">
                <option value="" disabled style="display:none;" <?php if(empty($_POST['start_time'])) echo 'selected'; ?>>選択してください</option>
                <option value="19:00" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '19:00' ? 'selected' : ''; ?>>19:00</option>
                <option value="19:30" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '19:30' ? 'selected' : ''; ?>>19:30</option>
                <option value="20:00" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '20:00' ? 'selected' : ''; ?>>20:00</option>
                <option value="20:30" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '20:30' ? 'selected' : ''; ?>>20:30</option>
                <option value="21:00" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '21:00' ? 'selected' : ''; ?>>21:00</option>
                <option value="21:30" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '21:30' ? 'selected' : ''; ?>>21:30</option>
                <option value="22:00" <?php echo array_key_exists('start_time', $_POST) && $_POST['start_time'] == '22:00' ? 'selected' : ''; ?>>22:00</option>
              </select>
              </td>
            </tr>
            <tr>
              <th>到着時間</th>
              <td>勤務開始の<?php echo getFormData('arrival_time'); ?>分前</td>
            </tr>
            <tr>
              <th>派遣到着時間（２回目以降）</th>
              <td>勤務開始の<?php echo getFormData('arrival_time_re'); ?>分前</td>
            </tr>
            <tr>
              <th>税金</th>
              <td><?php echo getFormData('tax'); ?>円</td>
            </tr>
            <tr>
              <th>厚生費</th>
              <td><?php echo getFormData('kouseihi'); ?>円</td>
            </tr>
            <tr>
              <th>貸衣装</th>
              <td><?php echo getFormData('dress'); ?></td>
            </tr>
            <tr>
              <th>送迎代</th>
              <td><?php echo getFormData('car'); ?>円</td>
            </tr>
            <tr>
              <th>送迎範囲</th>
              <td><?php echo getFormData('car_hani'); ?></td>
            </tr>
            <tr>
              <tr>
                <th>身分証明書</th>
                <td><?php echo getFormData('syorui'); ?></td>
              </tr>
              <tr>
              <th>注意事項　（任意）</th>
              <td><textarea type="text" name="comment" placeholder="(例)黒ドレスは禁止でお願いします。勤務中のストールはOK" style="background:white;"><?php if(!empty($_POST['comment'])) echo $_POST['comment']; ?></textarea>
            </tr>
          <tr>
          <th>店舗写真　※必須</th>
          <td>
          <div style="overflow:hideen;">
            <label class="area-drop <?php if(!empty($err_msg['pic'])) echo 'err'; ?>>">
            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
            <input type="file" name="pic" class="input-file">
            <img src="<?php echo getFormData('pic'); ?>" alt="" class="prev-img" style="<?php if(empty(getFormData('pic'))) echo 'display:none;' ?>">
            ドラッグ&ドロップ
          </label>
          
          <div>
          <?php if(!empty($err_msg['pic'])) echo $err_msg['pic']; ?>
          </div>
          </div>
          </td>
          </tr>

          </table>

          <div class="big-btn">
            <input type="submit" name="" value="登録する">
          </div>
            </form>
        </div>

      </section>

    </div>




    <!-- footer -->
<?php
require('footer.php');
 ?>

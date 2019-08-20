<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　index　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//案件idのGETパラメータを取得
$a_id = $_GET['a_id'];
//DBから案件データを取得する
$viewData = getAnkenOne($a_id);
debug('$viewDataの中身：'.print_r($viewData,true));

if(empty($viewData)){
  error_log('エラー発生:指定ページに不正な値が入りました');
  header("Location:index.php"); //トップページへ
}
debug('取得したDBデータ：'.print_r($viewData,true));




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
          <table>
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
              <td><?php echo $viewData['salary'];?></td>
            </tr>
            <tr>
              <th>業種</th>
              <td><?php echo $viewData['category'];?></td>
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
        </div>

      </section>

    </div>
    <div class="big-btn">
      <input type="submit" name="" value="応募する">
    </div>



    <!-- footer -->
<?php
require('footer.php');
 ?>

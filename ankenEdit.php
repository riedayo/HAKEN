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
    <h2>お仕事を登録</h2>
    <div id="contents" class="site-width">






      <!-- Main -->
      <section id="main">
        <div class="anken-detail">
          <form class="" action="" method="post">


          <table>
            <tr>
              <th>店舗名</th>
              <td></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td></td>
            </tr>
            <tr>
              <th>住所</th>
              <td></td>
            </tr>
            <tr>
              <th>最寄駅</th>
              <td></td>
            </tr>
            <tr>
              <th>時給</th>
              <td><input type="text" name="" value="3500"></td>
            </tr>
            <tr>
              <th>業種</th>
              <td></td>
            </tr>
            <tr>
              <th>勤務開始時間</th>
              <td>
              <select class="shukin" name="" style="width: 80%; margin: 0 auto; background: white;">
                <option value="1">19:00</option>
                <option value="1">19:30</option>
                <option value="1">20:00</option>
                <option value="1">20:30</option>
                <option value="1">21:00</option>
                <option value="1">21:30</option>
                <option value="1">22:00</option>
              </select>
              </td>
            </tr>
            <tr>
              <th>到着時間</th>
              <td></td>
            </tr>
            <tr>
              <th>派遣到着時間（２回目以降）</th>
              <td></td>
            </tr>
            <tr>
              <th>税金</th>
              <td></td>
            </tr>
            <tr>
              <th>厚生費</th>
              <td></td>
            </tr>
            <tr>
              <th>貸衣装</th>
              <td></td>
            </tr>
            <tr>
              <th>送迎代</th>
              <td></td>
            </tr><tr>
              <th>送迎範囲</th>
              <td></td>
            </tr>
            <tr>
              <th>注意事項</th>
              <td><input type="text" placeholder="黒ドレスは禁止でお願いします。勤務中のストールはOK"></td>
            </tr>

          </table>

          <div class="big-btn">
            <input type="submit" name="" value="応募する">
          </div>
            </form>
        </div>

      </section>

    </div>




    <!-- footer -->
<?php
require('footer.php');
 ?>

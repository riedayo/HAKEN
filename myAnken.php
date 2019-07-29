<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　マイ案件ページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');
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
    <h2>お仕事予定</h2>
    <div id="contents" class="site-width">





      <?php
      require('sidebar_mypage.php');
       ?>


      <!-- Main -->
      <section id="main">
        <table>
          <thead>
            <tr>
              <th>日付</th>
              <th>場所</th>
              <th>店名</th>
              <th>時給</th>
              <th>時間</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>
          <tbody>
            <td>2019.5.5(金)</td>
            <td>恵比寿</td>
            <td>スピッツ</td>
            <td>3,500円</td>
            <td>21:00</td>
            <td>詳細</td>
          </tbody>

        </table>

        <div class="pagination">
                  <ul class="pagination-list">
                    <li class="list-item"><a href="">&lt;</a></li>
                    <li class="list-item"><a href="">1</a></li>
                    <li class="list-item"><a href="">2</a></li>
                    <li class="list-item active"><a href="">3</a></li>
                    <li class="list-item"><a href="">4</a></li>
                    <li class="list-item"><a href="">5</a></li>
                    <li class="list-item"><a href="">&gt;</a></li>
                  </ul>
        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>

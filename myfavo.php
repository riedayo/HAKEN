<?php
$siteTitle = 'お気に入りページ';
require('head.php');
 ?>

  <body class="page-login page-2colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <h2>お気に入り店舗</h2>
    <div id="contents" class="site-width">





      <!-- サイドバー -->
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
            <tr>
              <td>2019.5.5(金)</td>
              <td>恵比寿</td>
              <td>スピッツ</td>
              <td>3,500円</td>
              <td>21:00</td>
              <td>詳細</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>2019.5.5(金)</td>
              <td>恵比寿</td>
              <td>スピッツ</td>
              <td>3,500円</td>
              <td>21:00</td>
              <td>詳細</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>2019.5.5(金)</td>
              <td>恵比寿</td>
              <td>スピッツ</td>
              <td>3,500円</td>
              <td>21:00</td>
              <td>詳細</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>2019.5.5(金)</td>
              <td>恵比寿</td>
              <td>スピッツ</td>
              <td>3,500円</td>
              <td>21:00</td>
              <td>詳細</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>2019.5.5(金)</td>
              <td>恵比寿</td>
              <td>スピッツ</td>
              <td>3,500円</td>
              <td>21:00</td>
              <td>詳細</td>
            </tr>
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

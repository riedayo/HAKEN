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

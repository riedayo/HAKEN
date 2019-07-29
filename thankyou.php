<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ありがとうページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();


?>


<?php
$siteTitle = 'ありがとうございました！';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">



      <h2>ありがとうございました！</h2>


      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="">



              <p class="note" style="text-align: center;">
                今までありがとうございました！<br>
                本当にお疲れ様でした。<br>
                また待っています。

              </p>

              <div class="big-btn">
                <a href="index.php">&lt; TOPに戻る</a>
              </div>
          </form>

        </div>


      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>

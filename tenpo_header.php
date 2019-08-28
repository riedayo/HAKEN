<header style="background:#808080;">
  <div class="site-width">


    <h1><a href="index.php" style="font-size:30px;">HAKEN(店舗用)</a></h1>
      <nav id="top-nav" >
        <ul class="flexbox">

          <?php
            if(empty($_SESSION['tenpo_id'])){
          ?>

          <li><a href="tenpo_login.php">ログイン</a></li>
          <li><a href="tenpo_signup.php">新規登録</a></li>
          
          <?php 
            }else{
          ?>

          <li><a href="tenpo_mypage.php">マイページ</a></li>
          <li><a href="logout.php">ログアウト</a></li>

            <?php } ?>


        </ul>
      </nav>

  </div>
</header>
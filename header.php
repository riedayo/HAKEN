<header>
  <div class="site-width">


    <h1><a href="index.php">HAKEN</a></h1>
      <nav id="top-nav" >
        <ul class="flexbox">
          <?php
            if(empty($_SESSION['user_id'])){
          ?>
          <li><a href="login.php">ログイン</a></li>
          <li><a href="signup.php">新規登録</a></li>
          <li><a href="tenpo_login.php">店舗ログイン</a></li>
          <li><a href="tenpo_signup.php">店舗新規登録</a></li>

          <?php
        }else{
          ?>

          <li><a href="myAnken.php">マイページ</a></li>
          <li><a href="logout.php">ログアウト</a></li>

          <?php
           }
           ?>

        </ul>
      </nav>

  </div>
</header>

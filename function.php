<?php
//=================================
//ログ
//=================================
//ログをとるか
ini_set('log_errors', 'on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');

//=================================
//デバッグ
//=================================

//デバッグフラグ(リリースするときはfalseにする)
$debug_flg = true;
//デバッグログ関数
function debug($str){
  global $debug_flg;
  if(!empty($debug_flg)){
    error_log('デバッグ：'.$str);
  }
}

//=================================
//セッション準備・セッション有効期限を延ばす
//=================================

//セッションファイルの置き場所を変更する(/var/tmp/以下に置くと３０日間は削除されないから便利！)
session_save_path( "/var/tmp/");
//ガーベージコレクションが削除するセッションの有効期限をここで設定（30日以上経っているものに対してだけ100分の１の確率で削除）
ini_set('session.gc_maxlifetime', 60*60*24*30);
//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60*60*24*30);
//セッションを使う
session_start();
//現在のセッションIDを新しく生成したものと入れ替える（なりすましのセキュリティ対策）
session_regenerate_id();

//=================================
//画面表示開始ログを吐き出すための関数
//=================================
 function debugLogStart(){
   debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>画面表示処理開始');
   debug('セッションID：'.session_id());
   debug('セッション変数の中身：'.print_r($_SESSION,true));
   debug('現在日時スタンプ：'.time());
   if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
     debug('ログイン期限日時タイムスタンプ：'.($_SESSION['login_date'] + $_SESSION['login_limit'] ) );
   }
 }

 //=================================
 //定数
 //=================================
//エラーメッセージを定数に設定
 define('MSG01','入力必須です');
 define('MSG02','Emailの形式で入力してください');
 define('MSG03','パスワード（再入力）が合っていません');
 define('MSG04','半角英数字のみご利用いただけます');
 define('MSG05','6文字以上で入力してください');
 define('MSG06','256文字以内で入力してください');
 define('MSG07','エラーが発生しました。しばらく経ってからやり直してください');
 define('MSG08','そのEmailはすでに登録されています');
 define('MSG09','メールアドレスまたはパスワードが違います');
 define('MSG10','電話番号の形式が違います');
 define('MSG12','古いパスワードが違います');
 define('MSG13','古いパスワードと同じです');
 define('MSG14','文字で入力してください');
 define('MSG15','正しくありません');
 define('MSG16','有効期限がきれています');
 define('MSG17','半角英数字のみご利用いただけます。');
 define('SUC01','パスワードを変更しました！');
 define('SUC02','プロフィールを変更しました！');
 define('SUC03','認証コードをメールで送信しました！');
 define('SUC04','新しいパスワードをメールで送信しました！');
 define('SUC05','案件を登録しました！');
 define('SUC06','応募が確定しました！お仕事頑張って！');


 //=================================
 //バリデーション関数
 //=================================
 $err_msg = array();

 //バリデーション関数(未入力チェック)
 function validRequired($str, $key){
   if($str === ''){
     global $err_msg;
     $err_msg[$key] = MSG01;
   }
 }

 //バリデーション関数（Email形式チェック）
 function validEmail($str, $key){
   if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
     global $err_msg;
     $err_msg[$key] = MSG02;
   }
 }

 //バリデーション関数（Email重複チェック）
 function validEmailDup($email){
   global $err_msg;
   //例外処理
   try{
     //DBへ接続
     $dbh = dbConnect();
     //SQL文作成
     $sql = 'SELECT email FROM users WHERE email = :email AND delete_flg = 0';
     $data = array(':email' => $email);
     //クエリ実行
     $stmt = queryPost($dbh, $sql, $data);
     //クエリの結果の値を取得
     $result = $stmt->fetch(PDO::FETCH_ASSOC);

     //array_shift関数は配列の先頭を取り出す関数。クエリ結果は配列形式で入っているから、array_shiftで1つ目だけ取り出して判定する。
     if(!empty($result)) {
       $err_msg['email'] = MSG08;
     }
   }catch(Exception $e){
     error_log('エラー発生：'. $e->getMessage());
     $err_msg['common'] = MSG07;
   }
 }

 //バリデーション関数（同値チェック）
 function validMatch($str1, $str2, $key){
   if($str1 !== $str2){
     global $err_msg;
     $err_msg[$key] = MSG03;
   }
 }

 //バリデーション関数（最大文字数チェック）
 function validMaxLen($str, $key, $max = 256){
   if(mb_strlen($str) > $max){
     global $err_msg;
     $err_msg[$key] = MSG06;
   }
 }

 //バリデーション関数（最小文字数チェック）
 function validMinLen($str, $key, $min = 6){
   if(mb_strlen($str) < 6 ){
     global $err_msg;
     $err_msg[$key] = MSG05;
   }
 }

 //バリデーション関数（半角チェック)
 function validHalf($str, $key){
   if (!preg_match("/^[a-zA-Z0-9]+$/", $str)) {
     global $err_msg;
     $err_msg[$key] = MSG04;
   }
 }

//電話番号チェック
 function validTel($str, $key){
  if(!preg_match("/0\d{1,4}\d{1,4}\d{4}/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG10;
  }
}
//郵便番号形式チェック（使ってない）
function vilidzip($str, $key){
  if (!preg_match("/^\d{7}$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG11;
  }
}
//半角数字チェック（使ってない）
function validNumber($str,$key){
  if(!preg_match("/^[0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG17;
  }
}

//固定長チェック（ある固定の文字数チェック）
function validLength($str, $key, $len = 8){
  if( mb_strlen($str) !== $len){
    global $err_msg;
    $err_msg[$key] = $len . MSG14;
  }
}

//パスワードチェック
function validPass($str,$key){
  //半角英数字チェック
  validHalf($str,$key);
  //最大文字数チェック
  validMaxLen($str,$key);
  //最小文字数チェック
  validMinLen($str,$key);
}

//selectboxチェック
function validSelect($str, $key){
  if(!preg_match("/^[0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG15;
  }
}
//エラーメッセージ表示
function getErrMsg($key){
  global $err_msg;
  if(!empty($err_msg[$key])){
    return $err_msg[$key];
  }
}

 //=================================
 //データベース接続関数
 //=================================

 //DB接続関数
 function dbConnect(){
   //DBへの接続準備
   $dsn = 'mysql:dbname=kyabahaken;host=localhost;charset=utf8';
   $user = 'root';
   $password = 'root';
   $options = array(
     // SQL実行失敗時にはエラーコードのみ設定
     PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
     // デフォルトフェッチモードを連想配列形式に設定
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
     // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
     PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
   );
   // PDOオブジェクト生成（DBへ接続）
   $dbh = new PDO($dsn, $user, $password, $options);
   return $dbh;
 }

 //SQL実行関数
 function queryPost($dbh, $sql, $data){
   //クエリー作成
   $stmt = $dbh->prepare($sql);
   //プレースホルダに値をセットし、SQL文を実行
   if(!$stmt->execute($data)){
     debug('クエリに失敗しました');
     debug('SQLエラー'.print_r($stmt->errorInfo(),true));
     $err_msg['common'] = MSG07;
     return 0;
   }else{
     debug('クエリ成功！');
     return $stmt;
   }

 }

 function getUser($u_id){
   debug('ユーザー情報を取得します');
   //例外処理
   try{
     //DBへ接続
     $dbh = dbConnect();
     $sql = 'SELECT * FROM users WHERE id = :u_id AND delete_flg = 0';
     $data = array(':u_id' => $u_id);
     //クエリ実行
     $stmt = queryPost($dbh, $sql, $data);

     //クエリ成功の場合
    // if($stmt){
    //   debug('クエリ成功しました！');
    // }else{
    //   debug('クエリ失敗。。。');
     //}

     //クエリ結果のデータを１レコード返却
     if($stmt){
       return $stmt->fetch(PDO::FETCH_ASSOC);
     }else{
       return false;
     }

   }catch(Exception $e){
     error_log('エラー発生：' .$e->getMessage());
   }
   //クエリ結果のデータを返却
   return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 function getTenpo($t_id){
   debug('ユーザー情報を取得します');
   //例外処理
   try{
     //DBへ接続
     $dbh = dbConnect();
     $sql = 'SELECT * FROM tenpo WHERE id = :t_id AND delete_flg = 0';
     $data = array(':t_id' => $t_id);
     //クエリ実行
     $stmt = queryPost($dbh, $sql, $data);

     //クエリ成功の場合
    // if($stmt){
    //   debug('クエリ成功しました！');
    // }else{
    //   debug('クエリ失敗。。。');
     //}

     //クエリ結果のデータを１レコード返却
     if($stmt){
       return $stmt->fetch(PDO::FETCH_ASSOC);
     }else{
       return false;
     }

   }catch(Exception $e){
     error_log('エラー発生：' .$e->getMessage());
   }
   //クエリ結果のデータを返却
   return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 function getAnken($t_id,$a_id){
   debug('案件情報を取得します');
   debug('店舗ID：'.$t_id);
   debug('案件ID：'.$a_id);

   //例外処理
   try{
     //DB接続
     $dbh = dbConnect();
     $sql = 'SELECT * FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id WHERE a.tenpo_id = :t_id AND a.id = :a_id AND a.delete_flg = 0 AND t.delete_flg = 0';
     $data = array('t_id' => $t_id, 'a_id' => $a_id);
     //クエリ実行
     $stmt = queryPost($dbh,$sql,$data);

     if($stmt){
       //クエリ結果のデータを１レコード返却
       return $stmt->fetch(PDO::FETCH_ASSOC);
     }else{
       return false;
     }

   }catch(Exception $e){
     error_log('エラー発生：'. $e->getMessage());
   }
 }

 function getAnkenOne($a_id){
  debug('商品情報を取得します。');
  debug('案件ID：'.$a_id);
  //例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT a.id, `anken_date`, `salary`, `bosyu`, `start_time`, `comment`, `pic`, `tenpo_id`, a.delete_flg, a.create_date, a.update_date , `email`, `pass`, `tenpo_name`, `owner_name`, `tel`, `pref`, `addr`, `station`, `category`, `hair`, `arrival_time`, `arrival_time_re`, `tax`, `kouseihi`, `dress`, `car`, `car_hani`, `syorui`, t.login_time, t.delete_flg, t.create_date, t.update_date , category_name FROM anken as a LEFT JOIN tenpo as t ON a.tenpo_id = t.id LEFT JOIN category AS c ON t.category = c.id WHERE a.id = :id';

    $data = array(':id' => $a_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    if($stmt){
      // クエリ結果のデータを１レコード返却
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
}

 function getCategory(){
  debug('カテゴリー情報を取得します。');
  //例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT category FROM tenpo';
    $data = array();
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    if($stmt){
      // クエリ結果の全データを返却
      return $stmt->fetchAll();
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
}


 //==========================
 //メール送信
 //==========================

function sendMail($from,$to,$subject,$comment){
  if(!empty($to) && !empty($subject) && !empty($comment)){
    //文字化けしないように設定（お決まりパターン）
    mb_language( "japanese");
    mb_internal_encoding( "UTF-8");

    //メールを送信(送信結果はtrueかfalseで帰ってくる)
    $result = mb_send_mail($to,$subject,$comment,"FROM:".$from);
    //送信結果を判定
    if($result){
      debug('メールを送信しました。');
    }else{
      debug('【エラー発生】メールの送信に失敗しました');
    }
  }
}

//==========================
//その他
//==========================

//  //フォーム入力保持
//  function getFormData($str){
//    global $dbFormData;
//    //ユーザーデータがDBにある場合
//    if(isset($dbFormData)){
//      //ユーザーデータがDBにあり、かつフォームのエラーがある場合
//      if(!empty($err_msg[$str])){
//        //POSTされている場合(フォームにエラーがあるならPOSTされてて当然だが)
//        if(isset($_POST[$str])){
//          return $_POST[$str];
//        }else{
//          //POSTされていない場合（エラーがあるならポストされていて当然なのであり得ないが）
//          return $dbFormData[$str];
//        }
//      }else{
//        //POSTされていてDBの情報と違う場合(フォームが変更されていてエラーは無し。けど他でエラーがあり引っかかってるとき)
//        if(isset($_POST[$str]) && $_POST[$str] !== $dbFormData[$str]){
//          return $_POST[$str];
//        }else{//そもそも変更していない時
//          return $dbFormData[$str];
//        }
//      }
//    }else{//DBにユーザーデータがまるっきりない場合
//      if(isset($_POST[$str])){
//        return $_POST[$str];
//      }
//    }
//  }

// サニタイズ
function sanitize($str){
  return htmlspecialchars($str,ENT_QUOTES);
}
// フォーム入力保持
function getFormData($str, $flg = false){
  if($flg){
    $method = $_GET;
  }else{
    $method = $_POST;
  }
  global $dbFormData;
  debug(strlen($dbFormData));

  // ユーザーデータがある場合
  if(!empty($dbFormData)){
    //フォームのエラーがある場合
    debug('############ if(!empty($dbFormData)) ############');
    if(!empty($err_msg[$str])){
      debug('############ if(!empty($err_msg[$str])) ############');
      //POSTにデータがある場合
      if(isset($method[$str])){
        return sanitize($method[$str]);
      }else{
        //ない場合（基本ありえない）はDBの情報を表示
        return sanitize($dbFormData[$str]);
      }
    }else{
      //POSTにデータがあり、DBの情報と違う場合
      debug('############ isset($method[$str]) && $method[$str] !== $dbFormData[$str] ############');
      if(isset($method[$str]) && $method[$str] !== $dbFormData[$str]){
        return sanitize($method[$str]);
      }else{
        debug('############ return sanitize($dbFormData[$str] ############');
        return sanitize($dbFormData[$str]);
      }
    }
  }else{
    debug('############ if(!$method[$str]) ############');
    if(isset($method[$str])){
      debug('############ isset(method[$str]) is true ############');
      return sanitize($method[$str]);
    }
  }
}




 //sessionを１回だけ取得する関数。（「変更しました！」とかのメッセージはマイページ表示した時１回だけ表示させればいいものだから、１回使ったキーを自動で削除してくれるようにしたい。）
 function getSessionFlash($key){
   if(!empty($_SESSION[$key])){
     $data = $_SESSION[$key];
     $_SESSION[$key] = '';
     return $data;
   }
 }

 //パスワード変更の時の認証キーを生成
 function makeRandKey($length = 8){
   static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
   $str = '';
   for ($i = 0; $i < $length; ++$i){
        $str .=$chars[mt_rand(0, 61)];
   }
   return $str;
 }

 //GETパラメータ付与
 // $del_key : 付与から取り除きたいGETパラメータのキー
 function appendGetParam($arr_del_key = array()){
  if(!empty($_GET)){
    $str = '?';
    debug('$_GET変数の中身：'.print_r($_GET,true));

    foreach($_GET as $key => $val){
      debug('$key変数の中身：'.print_r($key,true));
      debug('$val変数の中身：'.print_r($val,true));
      if(!in_array($key,$arr_del_key,true)){ //取り除きたいパラメータじゃない場合にurlにくっつけるパラメータを生成
        $str .= $key.'='.$val.'&';
      }
    }
    $str = mb_substr($str, 0, -1, "UTF-8");
    return $str;
  }
}

 //画像処理
 function uploadImg($file, $key){
   debug('画像アップロード処理開始');
   debug('FILE情報：'.print_r($file,true));

   if(isset($file['error']) && is_int($file['error'])) {
     try{
       //バリデーション
       //$file['error']の値を確認。配列の中には「UPLOAD_ERR_OK」などの定数が入っている.
       //「UPLOAD_ERR_OK」などの定数はPHPでファイルアップロードじに自動的に定義される。定数には値として0や１などの数値が入っている。
       switch($file['error']){
         case UPLOAD_ERR_OK; //OK
         break;
         case UPLOAD_ERR_NO_FILE; //ファイル未選択の場合
         throw new RuntimeException('ファイルが選択されていません');
         case UPLOAD_ERR_INI_SIZE; // php.ini定義の最大サイズが超過した場合
         case UPLOAD_ERR_FORM_SIZE; //フォーム定義の最大サイズが超過した場合
         throw new RuntimeException('ファイルサイズが大きすぎます');
         default; //そのほかの場合
         throw new RuntimeException('そのほかのエラーが発生しました');
       }

       //file['mine']の値はブラウザ側で偽装可能なので、MINEタイプを自前でチェックする
       //exif_imgatetype関すは「IMAFETYPE_GIF」「IMAGETYPE_JPEG」などの定義を返す
       $type = @exif_imagetype($file['tmp_name']);
       if(!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)){//第三引数にはtrueを設定すると厳密にチェックしてくれるので必ずつける
         throw new RuntimeException('画像形式が未対応です');
       }

       //ファイルデータからSHA-1ハッシュをとってファイル名を決定し、ファイルを保存する
       //ハッシュ化しておかないと、アップロードされたファイル名のままで保存してしまう。すると同じファイル名がアップロードされる可能性があり、DBにパスを保存した場合、どっちの画像パスなのか判断がつかなくなる。
       //image_type_to_extension関数はファイルの拡張子を取得するもの
       $path = 'uploads/'.sha1_file($file['tmp_name']).image_type_to_extension($type);

       if (!move_uploaded_file($file['tmp_name'] ,$path)){//ファイルを移動する
         throw new RuntimeException('ファイル保存時にエラーが発生しました');
       }
       //保存したファイルパスのパーミッション（権限）を変更する
       chmod($path, 0644);

       debug('ファイルは正常にアップロードされました');
       debug('ファイルパス：'.$path);
       return $path;

     }catch (RuntimeException $e){

       debug($e->getMessage());
       global $err_msg;
       $err_msg[$key] = $e->getMessage();
     }
   }
 }

//datetimeから曜日を取ってくる関数

function week($anken_date){

	$date = $anken_date;
	$datetime = new DateTime($date);
	$weekList = array("日", "月", "火", "水", "木", "金", "土");
	$w = (int)$datetime->format('w');
	return '('.$weekList[$w].')';

}

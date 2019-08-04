<footer id="footer">
  Copyright <a href="index.php">HAKEN</a> All Rights Reserved.
</footer>

<script src="js/jquery-3.4.1.min.js"></script>
<script>
  $(function(){
    var $ftr = $('#footer');
    if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
      $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
    }

    //マイページのメッセージ表示用
    var $jsShowMsg = $('#js-show-msg');
    var msg = $jsShowMsg.text();
    if(msg.replace(/^[\s　]+|[\s　]+$/g, "").length){
      $jsShowMsg.slideToggle('slow');
      setTimeout(function(){ $jsShowMsg.slideToggle('slow'); }, 3000 );
    }

    //画像ライブプレビュー
    var $dropArea = $('.area-drop');
    var $fileInput = $('input-file');
    $dropArea.on('click', fanction(e){
      e.stopPropagation();
      e.preventDefault();
      $(this).css('border', '3px #ccc dashed');
    });
    $dropArea.on('click', fanction(e){
      e.stopPropagation();
      e.preventDefault();
      $(this).css('border', 'none');
    });
    $fileInput.on('change', function(e){
      $dropArea.css('border','none');
      var file = this.files[0],           //2.failes配列にファイルが入っています
      $img = $(this).siblings('.prev-img'),  //3.jQueryのsiblingsメソッドで兄弟のimgを取得
      fileReader = new FileReader();        //4.ファイルを読み込むFileReaderオブジェクト

      //5.読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
      fileReader.onload = funtion(event){
        //読み込んだデータをimgに設定
        img.attr('src', event.target.result).show();
      };

      //6.画像読み込み
      fileReader.readAsDataURL(file);

    });


  });
</script>


</body>
</html>

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

  });
</script>


</body>
</html>

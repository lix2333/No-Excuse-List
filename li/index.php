<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <?php
    include_once("../includes/functions.php");
    $url = mysql_real_escape_string($_REQUEST['url']);
    // Grab url information
      $query = mysql_query("SELECT * FROM links WHERE link='$url'");
      $r = mysql_fetch_array($query);
      $id = $r['id'];
      $title = $r['title'];
      $loves = $r['loves'];
      $icons = array('normal','recommended','paid');
      $type = $icons[$r['type']];
      $cat = strtolower(categoryName($r['category']));
  ?>
  <head>
    <title></title>
    <style>
      html, body {width:100%; height:100%; overflow:hidden; font:normal normal 12px Verdana, sans-serif}
      .left {float:left}
      .right {float:right}
      #bar {width:100%; height:24px; display:block; background:#333 url(../img/bg.jpg) top left repeat-x; position:absolute; top:0; left:0; z-index:2}
        #center {width:1000px; margin:0 auto; position:relative; overflow:visible}
        #logo {width:41px; height:48px; display:block; background:url(../img/logo_sm.png) top left no-repeat; float:left}
        #bar p {float:left; color:#fff; margin:0; padding:4px 0 0}
        .heart {width:20px; height:10px; margin:3px 0 0 5px; display:block; float:left; background:url(../img/heart_sm.png) top center no-repeat}
          a.heart:hover, a.heart.loved {background-position:bottom center}
        .title {float:left}
        .icon {width:15px; height:15px; display:block; float:left; margin-left:5px}
          .paid {background:url(../img/paid.png) top left no-repeat}
          .recommended {background:url(../img/recommended.png) top left no-repeat}
        #bar a {color:#eee}
          #bar a:hover {color:#fff}
        #social {position:absolute; top:4px; right:16px}
          .fb_share_button {width:16px; height:16px; display:block; background:url(../img/fb.png) top left no-repeat; float:left; margin-right:8px}
          #twitter_button {width:16px; height:16px; display:block; background:url(../img/twitter.png) top left no-repeat; float:left; margin-right:8px}
          #google_plus {width:16px; height:16px; display:block; background:url(../img/google_plus.png) top left no-repeat; float:left; margin-right:8px}
		.pin-it-button {width:16px; height:16px; display:block; background:url(../img/pinterest.png) top left no-repeat; float:left}
        .close {color:#fff; text-decoration:none; position:relative; top:4px}
      iframe {width:100%; height:100%; position:absolute; top:24px; left:0; z-index:1; border:none}
    </style>
  </head>
  <body>
    <div id='bar'>
      <div id='center'>
        <a href='<?php echo $base_url; ?>' id='logo'></a>
        <p class='left'>
          <?php if(isset($_SESSION['username'])){ ?>
            <a href='#<?php echo $id; ?>' class='heart<?php if(checkLove($id)){echo " loved";}; ?>'> </a>
          <?php } else { ?>
            <span class='heart'></span>
          <?php } ?>
          <span class='left count'><?php echo $loves; ?> | </span>
          <?php if(empty($_SESSION['user_id'])){ ?>
            <span class='left' id='login' style='margin:0 5px'><a href='<?php echo $base_url; ?>forum/entry/signin?Target=discussions'>Login</a> | </span>
          <?php } ?>
          <span class='left' style='margin:0 5px'> <a href='<?php echo $base_url; ?>forum/categories/<?php echo $cat; ?>'>Discuss</a> | </span>
          <span class='title'><?php echo $title; ?></span>
          <span class='icon <?php echo $type; ?>'></span>
          <span id='social'>
            <a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php echo "{$base_url}li/?url=$url"?>" class="fb_share_button" onclick="return fbs_click()" target="_blank"></a>
            <script>
              function fbs_click() {
                u=location.href;t=document.title;
                window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
            </script>
            <a href="https://twitter.com/share?url=<?php echo "{$base_url}li/?url=$url"?>" id='twitter_button' target="_blank"></a>
            <a href="http://plus.google.com/share?url=<?php echo "{$base_url}li/?url=$url"?>" id='google_plus' target="_blank"></a>
        <a href="http://pinterest.com/pin/create/button/?url=<?php echo "{$base_url}li/?url=$url"?>&media=<?php echo $base_url; ?>%2Fimg%2Flogo.png&description=<?php echo $title; ?>" class="pin-it-button" target="_blank"></a>
          </span>
        </p>
        <a href='<?php echo $_REQUEST['url']; ?>' class='right close' target='_top'>x</a>
      </div>
    </div>
    <iframe src='<?php echo $url; ?>'></iframe>
  </body>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script>
    var h = $(window).height()-24;
    $('iframe').height(h+'px');

    $('span.heart')
      .click(
        function(){
          var href = $('span#login a').attr('href');
          $('span#login').html("Please <a href='"+href+"'>Login</a> to love a link. | ");
          return false;
        }
      )

    $('a.heart')
      .click(
        function(){
          var id = $(this).attr('href');
            id = id.replace("#","");
          $.ajax({
            url: "../includes/functions.php",
            data: {func:'love',id:id},
            success: function(data){
              if($('.heart').hasClass('loved')){
                $('.heart').removeClass('loved');
              } else {
                $('.heart').addClass('loved');
              }
              $('.count').text(data+' | ');
            }
          })
          return false;
        }
      )
  </script>
</html>
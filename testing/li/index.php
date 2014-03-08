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
    
      iframe {width:100%; height:100%; position:absolute; top:24px; left:0; z-index:1; border:none}
    </style>
  </head>
  <body>

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

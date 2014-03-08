<?php
  session_start();
  $title="home";
  include_once("header.php");
  
  $icons = array('normal','recommended','paid');
  // Grab categories
    $query = mysql_query("SELECT * FROM categories ORDER BY title");
    while($r = mysql_fetch_array($query)){
      $id = $r['id'];
      $title = $r['title'];
      $all .= "<div class='box small-12 large-4 columns' style=''>
		<div class='list small-12'>
        
        <ul  class=\"pricing-table\"><li class=\"title\">$title</li>";
        // Grab the links in the category
          $q = mysql_query("SELECT * FROM links WHERE category='$id' ORDER BY linkOrder ASC, loves DESC");
          while($l = mysql_fetch_array($q)){
            $linkID = $l['id'];
            $cat = strtolower(categoryName($id));
            $linkTitle = $l['title'];
            $link = $l['link'];
            $love = $l['loves'];
            $type = $icons[$l['type']];
            $desc = $l['description'];
            $comments = comments($id,0);
            $all .= "<li class='bullet-item' id='$linkID'>
                      <a href='$link' title='$desc' data-tooltip class='has-tip'>$linkTitle</a> <span class='icon $type'></span><a href='#' data-reveal-id='modal_login' class='loves'><span></span>$love</a>
                     </li>";
          }
      $cat = str_replace("+","plus",str_replace(" ","-",$cat));
      $all .= "<li class='bullet-item discussionLink'><a href='forum/categories/$cat' class='' style='text-align: center'>$title Forum</a></li></ul></div></div>";
    }
?>

  
 
		<div class="row text-center" style="margin-bottom: 10px; font-size: 0.75rem;"><div style="padding: 0px 10px;display:inline-block;"><img src="img/gray_heart.png" alt="" title="" />Number of users who "Loved" this link </div><div style="padding: 0px 10px;display:inline-block;"><img src="img/recommended.png" alt="" title="" /> Admin recommended link </div><div style="padding: 0px 10px;display:inline-block;"><img src="img/paid.png" alt="" title="" /> Paid content</div></div>
  <div class="row">
	  
    
    <div id="container" class="large-12 columns">
    
    <?php echo $all; ?>
  
</div><!--/container --> 
  </div>

<?php include_once("footer.php"); ?>
<?php include_once("analyticstracking.php") ?>

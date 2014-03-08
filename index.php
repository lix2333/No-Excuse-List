<?php
  session_start();
  $title="home";
  include_once("header.php");

  $user_id = $_SESSION['user_id'];
  $icons = array('normal','recommended','paid');
  // Grab categories
    $query = mysql_query("SELECT * FROM categories ORDER BY title");
    $myresult = mysql_query("SELECT * FROM links
                        INNER JOIN user_loves
                        ON links.id = user_loves.link_id
                        WHERE user_loves.user_id='$user_id'");    
                        
                        $results = array();
    while($array = mysql_fetch_array($myresult)){
		$mytest = $array['id'];
		$results[] = $mytest;
	}
    while($r = mysql_fetch_array($query)){
      $id = $r['id'];
      $title = $r['title'];
      $all .= "<div class='box small-12 large-4 columns' style=''>
		<div class='list small-12'>
        
        <ul  class=\"pricing-table\"><li class=\"title\">$title</li>";
        // Grab the links in the category
          $q = mysql_query("SELECT * FROM links WHERE category='$id' ORDER BY linkOrder ASC, loves DESC ");
          while($l = mysql_fetch_array($q)){
            $linkID = $l['id'];
            $cat = strtolower(categoryName($id));
            $linkTitle = $l['title'];
            $link = $l['link'];
            $loves = $l['loves'];
            if (in_array("$linkID", $results))
  {
  $classes = 'loves loved';
  }
else
  {
  $classes = 'loves';
  }
            $type = $icons[$l['type']];
            $desc = $l['description'];
            $comments = comments($id,0);
            $all .= "<li class='bullet-item' id='$linkID'>
                      <a href='$link' title='$desc' data-tooltip class='has-tip'>$linkTitle</a> <span class='icon $type'></span><a href='#$linkID' class='$classes'><span></span>$loves $mytest</a>
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
<?php echo $results[1]; ?>
<?php include_once("footer.php"); ?>
<?php include_once("analyticstracking.php") ?>

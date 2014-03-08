<?php
// set additional variable for the next/previous links
      $addtLink = '&v=2';

$title="loves";
// Grab links that users have loved
  $icons = array('normal','recommended','paid');
  $list = "
    <ul id='results' class='full top'>";
  $query = mysql_query("SELECT * FROM links
                        INNER JOIN user_loves
                        ON links.id = user_loves.link_id
                        WHERE user_loves.user_id='$user_id'");
  $count = mysql_num_rows($query);

  // display 10 at a time
    if(empty($_REQUEST['start'])){
      $start = 0;
    } else {
      $start = mysql_real_escape_string($_REQUEST['start']);
    }
  $query = mysql_query("SELECT * FROM links
                        INNER JOIN user_loves
                        ON links.id = user_loves.link_id
                        WHERE user_loves.user_id='$user_id'
                        LIMIT $start,10")or die(mysql_error());
  if($count > 10){
    $end = $start+10;
    if($end > $count){
      $end = $count;
    }
    $start++;
    $subTitle = "Showing $start-$end of $count Loves";
  } else {
    $end = 10;
    $subTitle = "Showing All Loves";
  }
  if($count > 0){
    while($r = mysql_fetch_array($query)){
      $linkID = $r['id'];
      $linkTitle = $r['title'];
      $blurb = substr($r['description'],0,100);
      $link = $r['link'];
      $love = $r['loves'];
      $type = $icons[$r['type']];
      $catID = $r['category'];
      $comments = comments($catID,0);
      $cat = strtolower(categoryName($catID));
      $list .= "<li class='result' rel='$linkTitle' id='$linkID'>
                <a href='#' class='love'><span></span>$love</a>
                <h4><span class='left'><a href='li/?url=$link'>$linkTitle</a></span> <span class='icon $type'></span></h4>
                <p class='blurb'>$blurb</p>
                <p class='details'>
                  <a href='forum/categories/$cat' class='faded'>$comments</a>
                </p>
              </li>";
    }
  } else {
    $list = "<h3>You have not loved any links yet. <a href='$base_url' class='red'>Get to spreading some love!</a></h3>";
  }
?>
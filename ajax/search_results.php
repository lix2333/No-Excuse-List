<?php

  if(isset($_REQUEST['s'])){
    include_once("../includes/functions.php");
    $s = mysql_real_escape_string($_REQUEST['s']);

    // put together links results
      $links = "";
      $linkIDs = "";
      $icons = array('normal','recommended','paid');
      $query = mysql_query("SELECT * FROM tag_assoc
													INNER JOIN tags
													ON tag_assoc.tag_id = tags.id
													WHERE tags.tag LIKE '%$s%'")or die(mysql_error());
      $count = mysql_num_rows($query);
      $query = mysql_query("SELECT * FROM links WHERE title LIKE '%$s%' OR description LIKE '%$s%' ORDER BY linkOrder ASC, loves DESC LIMIT 0,3")or die(mysql_error());
      if($count>0){
        if($count < 4){
          $links .= "<h3 class='red'><span>Showing all results</span></h3>";
        } else {
          $links .= "<h3 class='red'><span>Showing 3 of <a href='results?s=$s'>$count</a> results</span></h3>";
        }
        while($r = mysql_fetch_array($query)){
          $id = $r['id'];
          $title = $r['title'];
          $blurb = $r['description'];
          if(strlen($blurb)>70){
            $blurb = substr($blurb,0,70)."...";
          }
          $link = $r['link'];
          $love = $r['loves'];
          $type = $icons[$r['type']];
          $catID = $r['category'];
          $comments = comments($catID,0);
          $cat = strtolower(categoryName($catID));
          $links .= "<li class='result' id='$id'>
                        <a href='#' class='love'><span></span>$love</a>
                        <h4><span class='left'><a href='li/?url=$link'>$title</a></span> <span class='icon $type'></span></h4>
                        <p class='small'>$blurb</p>
                      </li>";
          $linkIDs .= "tag_assoc.link_id=$id OR ";
        }
      } else {
        $links .= "<h3 class='red'><span>No links found for search \"$s\"</span></h3>";
      }

    // put together tags from links
      if($count > 0){
        $linkIDs = substr($linkIDs,0,strlen($linkIDs)-4);
        $query = mysql_query("SELECT * FROM tag_assoc
                              INNER JOIN tags
                              ON tag_assoc.tag_id = tags.id
                              WHERE $linkIDs")or die(mysql_error());
        $count = mysql_num_rows($query);
        if($count > 0){
          $tags = "<h3 class='red'><span>Related tags</span></h3>";
          $tagID = array();
          while($r = mysql_fetch_array($query)){
            $id = $r['tag_id'];
            if(!in_array($id,$tagID)){
              $tag = $r['tag'];
              $tags .= "<a href='results?t=$id'>$tag</a>";
              array_push($tagID,$id);
            }
          }
        } else {
          $tags = "<h3 class='red'><span>No related tags found</span></h3>";
        }
      }
  }

  echo $links;
?>

<li class='tags'>
  <?php echo $tags; ?>
</li>
<?php
  session_start();
  include_once("header.php");

  if(empty($_REQUEST['s']) && empty($_REQUEST['t'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }

  if(isset($_REQUEST['s'])){
		$resultsID = array();
    // Show full results for a search term
    $s = mysql_real_escape_string($_REQUEST['s']);
    $icons = array('normal','recommended','paid');
    $all = "
      <ul id='results' class='full'>
      <h3 class='red'><span>Showing all results for $s</span></h3>";
			// Search for regular links
				$q = mysql_query("SELECT * FROM links
													WHERE title LIKE '%$s%' OR description LIKE '%$s%' OR category LIKE '%$s%'
													ORDER BY linkOrder ASC, loves DESC");
				while($r = mysql_fetch_array($q)){
					$id = $r['id'];
					if(!in_array($id,$resultsID)){
						array_push($resultsID,$id);
						$title = $r['title'];
						$blurb = $r['description'];
						$link = $r['link'];
						$love = $r['loves'];
						$type = $icons[$r['type']];
						$catID = $r['category'];
						$comments = comments($catID,0);
						$cat = strtolower(categoryName($catID));
						$all .= "<li class='result row' id='$id'>
											<div class='small-12 columns'><a href='#' data-reveal-id='modal_login' class='love'><span></span>$love</a>
											<h4><span class='left'><a href='$link'>$title</a></span> <span class='icon $type'></span></h4></div>
											<div class='small-12 columns'><p class='blurb'>$blurb</p></div>
										</li><hr/>";
					}
			}

			// Search for tagged links
				$q = mysql_query("SELECT * FROM tag_assoc
													INNER JOIN tags
													ON tag_assoc.tag_id = tags.id
													WHERE tags.tag LIKE '%$s%'");
				while($r = mysql_fetch_array($q)){
					$id = $r['link_id'];
					if(!in_array($id,$resultsID)){
						array_push($resultsID,$id);
						$linkInfo = mysql_query("SELECT title,description,link,loves,type,category FROM links WHERE id='$id'");
						$l = mysql_fetch_array($linkInfo);
						$title = $l['title'];
						$blurb = $l['description'];
						$link = $l['link'];
						$love = $l['loves'];
						$type = $icons[$l['type']];
						$catID = $l['category'];
						$comments = comments($catID,0);
						$cat = strtolower(categoryName($catID));
						$all .= "<li class='result row' id='$id'>
											<div class='small-12 columns'><a href='#' data-reveal-id='modal_login' class='love'><span></span>$love</a>
											<h4><span class='left'><a href='$link'>$title</a></span> <span class='icon $type'></span></h4></div>
											<div class='small-12 columns'><p class='blurb'>$blurb</p></div>
										</li><hr/>";
					}
			}
    $all .= "</ul>";
  } else {
    // Show full results for a tag association
    $t = mysql_real_escape_string($_REQUEST['t']);
    $icons = array('normal','recommended','paid');
    $tagName = tagName($t);
    $all = "
      <ul id='results' class='full'>
      <h3 class='red'><span>Showing all results for tag \"$tagName\"</span></h3>";
        $q = mysql_query("SELECT * FROM links
                          INNER JOIN tag_assoc
                          ON links.id = tag_assoc.link_id
                          WHERE tag_assoc.tag_id='$t'
                          ORDER BY loves DESC, clicks DESC");
        while($r = mysql_fetch_array($q)){
          $id = $r['id'];
          $title = $r['title'];
          $blurb = $r['description'];
          $link = $r['link'];
          $love = $r['loves'];
          $type = $icons[$r['type']];
          $catID = $r['category'];
          $comments = comments($catID,0);
          $cat = strtolower(categoryName($catID));
          $all .= "<li class='result row' id='$id'>
                    <div class='small-12 columns'><a href='#' class='love'><span></span>$love</a>
                    <h4><span class='left'><a href='$link'>$title</a></span> <span class='icon $type'></span></h4></div>
                    <div class='small-12 columns'><p class='blurb'>$blurb</p></div>
                  </li><hr/>";
        }
    $all .= "</ul>";
  }
?>
<div class="row">
	<div class="small-12 columns">
  <div id='container'>
    <?php echo $all; ?>
  </div>
  </div>
  </div>

<?php include_once("footer.php"); ?>

<?php
  session_start();
  $title="account";
  include_once("header.php");
  if(empty($_SESSION['user_id'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }
  $user_id = $_SESSION['user_id'];

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
              </li>";
    }
  } else {
    $list = "<h3>You have not loved any links yet. <a href='$base_url' class='red'>Get to spreading some love!</a></h3>";
  }
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <h3 class='red'><span><?php echo $subTitle; ?></span></h3>

    <div id='comments'>
      <?php echo $list; ?>
      <div class='small pages'>
      <?php
        // add a previous button
          if($start > 1){
            $start = $start-11;
            if($start == 0){
              echo "<a href='loves' class='button'>Previous Page</a>";
            } else {
              echo "<a href='loves?start=$start' class='button'>Previous Page</a>";
            }
          }
        // add a next button
          if($end < $count){
            echo "<a href='loves?start=$end' class='button'>Next Page</a>";
          }
      ?>
      </div>
    </div>
  </div>

<?php include_once("footer.php"); ?>
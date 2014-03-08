<?php
  session_start();
  $title="discussions";
  $userProfile=true;
  include_once("header.php");

  if(isset($_REQUEST['id'])){
    $user_id = mysql_real_escape_string($_REQUEST['id']);
  } else {
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }

  if(empty($_REQUEST['v'])){
    include_once("includes/account-disccusions.php");
  }

  if($_REQUEST['v']==1){
    include_once("includes/account-comments.php");
  }

  if($_REQUEST['v']==2){
    include_once("includes/account-loves.php");
  }
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <h3 class='red'><span><?php echo $subTitle; ?></span></h3>

    <div id='comments'>
      <?php echo $list; ?>
      <div class='small pages'>
      <?php
        if(isset($userProfile)){
          $link = "user?id=$user_id";
          if($start<2){
            $link .= "&";
          }
        } else {
          $link = "account?";
        }
        // add a previous button
          if($start > 1){
            $start = $start-11;
            if($start == 0){
              if(isset($addtLink)){
                $addtLink = str_replace("&","?",$addtLink);
              }
              echo "<a href='$link{$addtLink}' class='button'>Previous Page</a>";
            } else {
              echo "<a href='{$link}start=$start{$addtLink}' class='button'>Previous Page</a>";
            }
          }
        // add a next button
          if($end < $count){
            echo "<a href='{$link}start=$end{$addtLink}' class='button'>Next Page</a>";
          }
      ?>
      </div>
    </div>
  </div>

<?php include_once("footer.php"); ?>
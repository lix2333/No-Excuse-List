<?php
  session_start();
  $title="account";
  include_once("header.php");
  if(empty($_SESSION['user_id'])){
    header("Location:$base_url");
    exit();
  }
  $user_id = $_SESSION['user_id'];

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
        // add a previous button
          if($start > 1){
            $start = $start-11;
            if($start == 0){
              if(isset($addtLink)){
                $addtLink = str_replace("&","?",$addtLink);
              }
              echo "<a href='account{$addtLink}' class='button'>Previous Page</a>";
            } else {
              echo "<a href='account?start=$start{$addtLink}' class='button'>Previous Page</a>";
            }
          }
        // add a next button
          if($end < $count){
            echo "<a href='account?start=$end{$addtLink}' class='button'>Next Page</a>";
          }
      ?>
      </div>
    </div>
  </div>

<?php include_once("footer.php"); ?>
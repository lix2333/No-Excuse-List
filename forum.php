<?php
  session_start();
  $title = 'forum';
  include_once("header.php");

  if(isset($_POST['title']) && $_POST['spamChecker']==''){
    $title = mysql_real_escape_string($_POST['title']);
    if($title==''){
      $_SESSION['error'] = "Please post a title.";
      header("Location: forum?s=1");
      exit();
    }
    $description = mysql_real_escape_string($_POST['description']);
    $user_id = $_SESSION['user_id'];
    $date = time();
    mysql_query("INSERT INTO forum (user_id,title,description,date) VALUES ('$user_id','$title','$description','$date')");
    $_SESSION['success'] = "Your discussion, \"$title\" was created.";
    header("Location: forum");
    exit();
  }

  if(empty($_REQUEST['s'])){
    // get total count
      $query = mysql_query("SELECT id FROM forum");
      $count = mysql_num_rows($query);
    // display 10 at a time
      if(empty($_REQUEST['start'])){
        $start = 0;
      } else {
        $start = mysql_real_escape_string($_REQUEST['start']);
      }
      $query = mysql_query("SELECT * FROM forum ORDER BY date DESC LIMIT $start,10");
      if($count > 10){
        $end = $start+10;
        if($end > $count){
          $end = $count;
        }
        $start++;
        $subTitle = "Showing $start-$end of $count Discussions";
      } else {
        $end = 10;
        $subTitle = "Showing All Discussions";
      }
      while($r = mysql_fetch_array($query)){
        $id = $r['id'];
        $threadTitle = $r['title'];
        $username = username($r['user_id']);
        $date = cuteTime($r['date']);
        $threads .= "<li class='result'><h2><a href='discuss?i=$id&t=1'>$threadTitle</a></h2>
                      <p>$username started this thread $date</p>
                      <div id='small'>";
        if(isset($_SESSION['username'])){
          $threads .= "<a href='discuss?i=$id&t=1' class='small faded'>".comments($id,1)."</a>";
        } else {
          $threads .= "";
        }
        $treads .= "</div></li>";
      }
  }
?>

  <div id='container'>
    <div id='subLinks'>
      <a href='forum' <?php if(empty($_REQUEST['s'])){echo "id='current'";}; ?>>Active Discussions</a>
      <a href='forum?s=1' <?php if($_REQUEST['s']==1){echo "id='current'";}; ?>>Start a Discussion</a>
      <!-- a href='forum?s=2' <?php if($_REQUEST['s']==2){echo "id='current'";}; ?>>Search</a -->
    </div>
    <?php include("includes/alert.php"); ?>

    <?php // Show discussions if "s" is empty ?>
      <?php if(empty($_REQUEST['s'])){ ?>
        <h3 class='red'><span><?php echo $subTitle; ?></span></h3>
        <div id='comments'>
          <?php echo $threads; ?>
        </div>
        <div class='small pages'>
        <?php
          // add a previous button
            if($start > 1){
              $start = $start-11;
              if($start == 0){
                echo "<a href='forum' class='button'>Previous Page</a>";
              } else {
                echo "<a href='forum?start=$start' class='button'>Previous Page</a>";
              }
            }
          // add a next button
            if($end < $count){
              echo "<a href='forum?start=$end' class='button'>Next Page</a>";
            }
        ?>
        </div>
      <?php } ?>

    <?php // Start a discussion is "s" equals 1 ?>
      <?php if(isset($_SESSION['username']) && $_REQUEST['s']==1){ ?>
        <form action='forum' method='post' class='startThread' id='form'>
          <input type='text' name='spamChecker' value='' class='spamChecker' />
          <label>Title</label>
          <input type='text' name='title' class='inputtext' />
          <label>Description</label>
          <textarea name='description' class='textarea'></textarea>
          <label>&nbsp;</label>
          <input type='submit' value='Start Discussion' class='button small' />
        </form>
      <?php } ?>
  </div>

<?php include_once("footer.php"); ?>
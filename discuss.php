<?php
  session_start();
  include_once("header.php");

  if(empty($_REQUEST['i'])){
    header("Location:$base_url");
    exit();
  }
  $linkID = mysql_real_escape_string($_REQUEST['i']);
  $cType = 0;
  // If discussion is on a link
    $icons = array('normal','recommended','paid');
    $query = mysql_query("SELECT * FROM links WHERE id='$linkID'")or die(mysql_error());
    $r = mysql_fetch_array($query);
    $title = $r['title'];
    $desc = $r['description'];
    $link = $r['link'];
    $love = $r['loves'];
    $type = $icons[$r['type']];
    if(checkLove($linkID)){
      $loveClass = "love loved";
    } else {
      $loveClass = "love";
    }
    $linkHeader = "<div class='result' id='resultTitle'>";
    if(isset($_SESSION['username'])){
      $linkHeader .= "<a href='#$linkID' class='$loveClass'><span></span>$love</a>";
    } else {
      $linkHeader .= "<span class='$loveClass'><span></span>$love</span>";
    }
    $linkHeader .= "<h4><span class='left'><a href='li/?url=$link'>$title</a></span> <span class='icon $type'></span></h4>
                    <p class='blurb'>$desc</p>
                  </div>";

  // Pull all of the comments to display
  function grabComments($linkID,$type,$parentID){
    if($parentID==0){
      $query = mysql_query("SELECT * FROM discussion WHERE link_id='$linkID' && type='$type' && parent_id='$parentID'");
    } else {
      $query = mysql_query("SELECT * FROM discussion WHERE type='$type' && parent_id='$parentID'");
    }
    if(mysql_num_rows($query)>0){
      while($r = mysql_fetch_array($query)){
        $commentID = $r['id'];
        if($parentID==0){
          $thread .= "<ul class='top'>";
        }
        $user_id = $r['user_id'];
        $username = username($user_id);
        $time = $r['date'];
          $time = cuteTime($time);
        $comment = $r['comment'];
          if($comment==''){
            $comment = "<span class='faded'>[comment deleted]</span>";
          }
        $thread .= "<li><div class='details'>";
        if(hasChildren($commentID)){
          $thread .= "<a href='#' class='collapse small faded'>[-]</a> ";
        }
        $thread .= "<span class='red'>$username<span> <span class='faded'>posted $time</span></div>
                      <div class='comment' rel='$commentID'>$comment</div>";
        if(isset($_SESSION['user_id'])){
          $thread .= "<div class='tools'><a href='#' class='reply small faded' id='$linkID' rel='$commentID' type='$type'>reply</a>";
          // allow a user to delete their comment
            if($_SESSION['user_id'] == $user_id && $comment != "<span class='faded'>[comment deleted]</span>"){
              $thread .= " <a href='#' class='deleteComment small faded' rel='$commentID'>delete</a>";
              $delete = true;
            }
          // allow a moderator to remove a comment
            if(isset($_SESSION['superuser']) && $comment != "<span class='faded'>[comment deleted]</span>" && empty($delete)){
              $thread .= " <a href='#' class='deleteComment small faded' rel='$commentID'>delete</a>";
            }
          $thread .= "</div></li>";
        } else {
          $thread .= "<div class='tools noPad'><a href='login' class='small faded'>Login</a> <span class='small'>or</span> <a href='register' class='small faded'>register</a> <span class='small'>to join the discussion.</span></div></li>";
        }
        if(grabComments($linkID,$type,$commentID)){
          $thread .= "<ul id='comment_$commentID'>".grabComments($linkID,$type,$commentID)."</ul>";
        }
        if($parentID==0){
          $thread .= "</ul>";
        }
      }
      return $thread;
    } else {
      return false;
    }
  }

  $comments = grabComments($linkID,$cType,0);
  if($comments == ""){
    $comments = "<p id='noComments'>There are no comments on this link yet.</p>";
  }
?>

  <div id='container'>
    <?php echo $linkHeader; ?>

    <?php if(isset($_SESSION['username'])){ ?>
      <form action='discuss' method='post' class='addComment'>
        <input type='hidden' name='linkID' value='<?php echo $linkID; ?>' />
        <input type='hidden' name='parentID' value='0' />
        <input type='hidden' name='type' value='<?php echo $cType; ?>' />
        <input type='text' name='spamChecker' value='' class='spamChecker' />
        <textarea name='comment' class='textarea'></textarea><br />
        <input type='submit' value='Add Comment' class='button small commentSubmit' />
      </form>
    <?php } ?>

    <div id='comments'>
      <?php echo $comments; ?>
    </div>
  </div>

<?php include_once("footer.php"); ?>
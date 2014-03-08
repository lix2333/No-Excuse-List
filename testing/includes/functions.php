<?php
  session_start();
  include_once("base.php");

  // Check if the username is already registered
    function checkUser($user){
      $query = mysql_query("SELECT username FROM users WHERE username='$user'");
      $count = mysql_num_rows($query);
      if($count == 0){
        return false;
      } else {
        return true;
      }
    }

  // User information
    function email($id){
      $query = mysql_query("SELECT email FROM users WHERE id='$id'");
      $r = mysql_fetch_array($query);
      return $r['email'];
    }

  // User username
    function username($id){
      $query = mysql_query("SELECT id,username FROM users WHERE id='$id'");
      $r = mysql_fetch_array($query);
      return "<a href='user?id=$r[id]'>$r[username]</a>";
    }

  // Check if user/password is correct
    function checkUserPass($pass){
      $id = $_SESSION['user_id'];
      $query = mysql_query("SELECT * FROM users WHERE id='$id' AND password='$pass'");
      if(mysql_num_rows($query) == 0){
        return false;
      } else {
        return true;
      }
    }

  // Add a click to the clicks column of a link
    if($_REQUEST['func']=='addClick'){
      $id = mysql_real_escape_string($_REQUEST['id']);
      $query = mysql_query("SELECT clicks FROM links WHERE id='$id'")or die(mysql_error());
      $r = mysql_fetch_array($query);
      $clicks = $r['clicks']+1;
      mysql_query("UPDATE links SET clicks='$clicks' WHERE id='$id'")or die(mysql_error());
      exit();
    }

  // Check for link love
    function checkLove($id){
      $user_id = $_SESSION['user_id'];
      $query = mysql_query("SELECT * FROM user_loves WHERE user_id='$user_id' AND link_id='$id'");
      if(mysql_num_rows($query) == 0){
        return false;
      } else {
        return true;
      }
    }

  // Add a some love to a link
    if($_REQUEST['func']=='love'){
      $id = mysql_real_escape_string($_REQUEST['id']);
      $user_id = $_SESSION['user_id'];
      $now = time();
      $query = mysql_query("SELECT loves FROM links WHERE id='$id'")or die(mysql_error());
      $r = mysql_fetch_array($query);
      if(!checkLove($id)){
        $loves = $r['loves']+1;
        mysql_query("INSERT INTO user_loves (user_id,link_id,date) VALUES ($user_id,$id,$now)");
      } else {
        $loves = $r['loves']-1;
        mysql_query("DELETE FROM user_loves WHERE user_id='$user_id' AND link_id='$id'");
      }
      mysql_query("UPDATE links SET loves='$loves' WHERE id='$id'")or die(mysql_error());
      echo $loves;
      exit();
    }

  // Get category name
    function categoryName($id){
      $query = mysql_query("SELECT * FROM categories WHERE id='$id'");
      $r = mysql_fetch_array($query);
      return $r['title'];
    }

  // Get tag id
    function tagID($text){
      $text = strtolower($text);
      $query = mysql_query("SELECT * FROM tags WHERE tag='$text'");
      if(mysql_num_rows($query)==0){
        return false;
      } else {
        $r = mysql_fetch_array($query);
        return $r['id'];
      }
    }

  // Get tag name
    function tagName($id){
      $query = mysql_query("SELECT * FROM tags WHERE id='$id'");
      $r = mysql_fetch_array($query);
      return $r['tag'];
    }

  // Get link or forum title
    function title($type,$id){
      $query = mysql_query("SELECT * FROM $type WHERE id='$id'");
      $r = mysql_fetch_array($query);
      return $r['title'];
    }

  // Link to forum category
    function comments($id,$type){
      $query = mysql_query("SELECT * FROM GDN_Discussion WHERE CategoryID='$id'");
      $count = mysql_num_rows($query);
      if($count == 0){
        return "Start a Discussion";
      } else {
        if($count == 1){
          return "1 Discussion Started";
        } else {
          return "$count Discussions Started";
        }
      }
    }

  /* Add a comment
    if($_REQUEST['func'] == 'addComment'){
      $id = mysql_real_escape_string($_REQUEST['id']);
      $user_id = $_SESSION['user_id'];
      $parent = mysql_real_escape_string($_REQUEST['parent']);
      $type = mysql_real_escape_string($_REQUEST['type']);
      $comment = mysql_real_escape_string($_REQUEST['comment']);
      $date = time();
      mysql_query("INSERT INTO discussion (link_id,type,user_id,parent_id,date,comment) VALUES ('$id','$type','$user_id','$parent','$date','$comment')");
      $commentID = mysql_insert_id();
      $username = username($user_id);
      $comment = stripslashes($comment);
      $time = cuteTime($date);
      if($parent==0){
        echo "<ul class='top'>";
      }
      echo "<li><div class='details'><span class='red'>$username<span> <span class='faded'>posted $time</span></div>
              <div class='comment' rel='$commentID'>$comment</div>";
      if(isset($_SESSION['user_id'])){
        echo "<div class='tools'><a href='#' class='reply small faded' id='$id' rel='$commentID' type='$type'>reply</a>";
        // allow a user to delete their comment
          if($_SESSION['user_id'] == $user_id && $comment != "<span class='faded'>[comment deleted]</span>"){
            echo " <a href='#' class='deleteComment small faded' rel='$commentID'>delete</a>";
            $delete = true;
          }
        // allow a moderator to remove a comment
          if(isset($_SESSION['superuser']) && $comment != "<span class='faded'>[comment deleted]</span>" && empty($delete)){
            echo " <a href='#' class='deleteComment small faded' rel='$commentID'>delete</a>";
          }
        echo "</div></li>";
      } else {
        echo "<div class='tools noPad'><a href='login' class='small faded'>Login</a> <span class='small'>or</span> <a href='register' class='small faded'>register</a> <span class='small'>to join the discussion.</span></div></li>";
      }
      if($parent==0){
        echo "</ul>";
      }
      exit();
    }

  // Delete a comment
    if($_REQUEST['func'] == 'deleteComment'){
      $id = mysql_real_escape_string($_REQUEST['id']);
      $text = mysql_real_escape_string($_REQUEST['t']);
      mysql_query("UPDATE discussion SET comment='$text' WHERE id='$id'");
      exit();
    }

  // Check if a comment has children
    function hasChildren($id){
      $query = mysql_query("SELECT * FROM discussion WHERE parent_id='$id'");
      if(mysql_num_rows($query)==0){
        return false;
      } else {
        return true;
      }
    }

  // CUTE TIME
    function cuteTime($date){
      $now = time();
      $diff = $now - $date;
      $dayDiff = floor($diff / 86400);

      if(is_nan($dayDiff) || $dayDiff < 0) {
        return '';
      }

      if($dayDiff == 0) {
        if($diff < 60) {
          return 'Just now';
        } elseif($diff < 120) {
          return '1 minute ago';
        } elseif($diff < 3600) {
          return floor($diff/60) . ' minutes ago';
        } elseif($diff < 7200) {
          return '1 hour ago';
        } elseif($diff < 86400) {
          return floor($diff/3600) . ' hours ago';
        }
      } elseif($dayDiff == 1) {
        return 'Yesterday';
      } elseif($dayDiff < 7) {
        return $dayDiff . ' days ago';
      } elseif($dayDiff == 7) {
        return '1 week ago';
      } elseif($dayDiff < (7*6)) { // Modifications Start Here
        // 6 weeks at most
        return ceil($dayDiff/7) . ' weeks ago';
      } elseif($dayDiff < 365) {
        return ceil($dayDiff/(365/12)) . ' months ago';
      } else {
        $years = round($dayDiff/365);
        return $years . ' year' . ($years != 1 ? 's' : '') . ' ago';
      }
    } */
?>
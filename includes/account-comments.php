<?php
  // Show comments the user has left
  $title="comments";
  // get total count
    $query = mysql_query("SELECT id FROM discussion WHERE user_id='$user_id'");
    $count = mysql_num_rows($query);
  // display 10 at a time
    if(empty($_REQUEST['start'])){
      $start = 0;
    } else {
      $start = mysql_real_escape_string($_REQUEST['start']);
    }
    $query = mysql_query("SELECT * FROM discussion WHERE user_id='$user_id' ORDER BY date DESC LIMIT $start,10");
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
      if($r['type']==0){
        $threadTitle = title('links',$r['link_id']);
      } else {
        $threadTitle = title('forum',$r['link_id']);
      }
      $discussLink = "discuss?i=".$r['link_id']."&t=".$r['type'];
      $comment = $r['comment'];
      $username = username($r['user_id']);
      $date = cuteTime($r['date']);
      $list .= "<li class='result'><h2><a href='$discussLink'>$threadTitle</a></h2>
                    <p class='small'>$username posted on $date</p>
                    <div id='small'>$comment</div></li>";
    }
?>
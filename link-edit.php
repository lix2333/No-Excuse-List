<?php
  session_start();
  $title="link management";
  include_once("header.php");
  if(empty($_SESSION['superuser'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }

  if(isset($_POST['linkID'])){
    $cat = mysql_real_escape_string($_POST['cat']);
    $linkID = mysql_real_escape_string($_POST['linkID']);
    $linkTitle = mysql_real_escape_string($_POST['title']);
    $link = mysql_real_escape_string($_POST['link']);
    $description = mysql_real_escape_string($_POST['description']);
    $type = mysql_real_escape_string($_POST['type']);
    mysql_query("UPDATE links SET title='$linkTitle', description='$description', link='$link', type='$type' WHERE id='$linkID'");

    $tags = mysql_real_escape_string($_POST['tags']);
      $boom = explode(",",$tags);
      mysql_query("DELETE FROM tag_assoc WHERE link_id='$linkID'");
      foreach($boom as $x){
        $x = trim($x);
        if(tagID($x)){
          $tagID = tagID($x);
        } else {
          mysql_query("INSERT INTO tags (tag) VALUES('$x')");
          $tagID = mysql_insert_id();
        }
        $insertTags .= "('$tagID','$linkID'),";
      }
      $insertTags = substr($insertTags,0,strlen($insertTags)-1);
      mysql_query("INSERT INTO tag_assoc (tag_id,link_id) VALUES $insertTags")or die(mysql_error());
    echo "<script>window.location = 'link-edit?cat=$cat&link=$linkID'</script>";
    exit();
  }

  if(isset($_REQUEST['delete'])){
    $cat = mysql_real_escape_string($_REQUEST['cat']);
    $linkID = mysql_real_escape_string($_REQUEST['link']);
    mysql_query("DELETE FROM links WHERE id='$linkID'");
    echo "<script>window.location = 'category?cat=$cat'</script>";
    exit();
  }

  $cat = mysql_real_escape_string($_REQUEST['cat']);
  $catName = categoryName($cat);
  $linkID = mysql_real_escape_string($_REQUEST['link']);
  $query = mysql_query("SELECT * FROM links WHERE id='$linkID'");
  $r = mysql_fetch_array($query);
  $linkTitle = $r['title'];
  $desc = $r['description'];
  $link = $r['link'];
  $clicks = $r['clicks'];
  $loves = $r['loves'];
  $type = $r['type'];

  $query = mysql_query("SELECT * FROM tags
                        INNER JOIN tag_assoc
                        ON tags.id = tag_assoc.tag_id
                        WHERE tag_assoc.link_id=$linkID
                        ORDER BY tags.TAG ASC")or die(mysql_error());
  while($r = mysql_fetch_array($query)){
    $tags .= $r['tag'].", ";
  }
  $tags = substr($tags,0,strlen($tags)-2);
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <form action='link-edit' method='post' id='form'>
      <h2 class='red' style='padding-bottom:20px'>Edit Link "<?php echo $linkTitle; ?>"</h2>
      <input type='hidden' name='linkID' value="<?php echo $linkID; ?>" />
      <input type='hidden' name='cat' value="<?php echo $cat; ?>" />
      <label>Title:</label>
      <input type='text' class='inputtext' name='title' value="<?php echo $linkTitle; ?>" />
      <label>Link:</label>
      <input type='text' class='inputtext' name='link' value="<?php echo $link; ?>" />
      <label style='height:107px'>Description:</label>
      <textarea name='description' class='textarea'><?php echo $desc; ?></textarea>
      <label>Clicks:</label>
      <input type='text' class='inputtext disabled' name='clicks' disabled='disabled' value='<?php echo $clicks; ?>' />
      <label>Loves:</label>
      <input type='text' class='inputtext disabled' name='loves' disabled='disabled' value='<?php echo $loves; ?>' />
      <label>Type:</label>
      <select name='type' class='inputtext' style='width:269px'>
        <?php
          $types = array("Normal","Recommended","Paid Content");
          $i=0;
          foreach($types as $t){
            echo "<option value='$i'";
            if($type==$i){
              echo " SELECTED";
            }
            echo ">$t</option>";
            $i++;
          }
        ?>
      </select>
      <label>Tags:<span>separate with commas</span></label>
      <input type='text' class='inputtext' name='tags' value='<?php echo $tags; ?>' />
      <label>&nbsp;</label>
      <input type='submit' class='button' value='Update Link' />
      <p class='left' style='padding:6px 0 0 5px'>or <a href='link-edit?cat=<?php echo $cat; ?>&link=<?php echo $linkID; ?>&delete=yes'>delete</a>.</p>
    </form>
    <p class='small' id='loginSubtext'><a href='category?cat=<?php echo $cat; ?>' class='red'>Go Back</a> to the Links in the "<?php echo $catName; ?>" Category</p>
  </div>

<?php include_once("footer.php"); ?>
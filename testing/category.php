<?php

  if($_REQUEST['func']=='sortIt'){
    include_once("includes/base.php");
    $sorting = $_REQUEST['order'];
    $i=0;
    foreach($sorting as $id){
      mysql_query("UPDATE links SET linkOrder='$i' WHERE id='$id'");
      $i++;
    }
    exit();
  }
  session_start();
  $title="category";
  include_once("header.php");
  if(empty($_SESSION['superuser'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }

  if(isset($_POST['cat'])){
    $cat = mysql_real_escape_string($_POST['cat']);
    $title = mysql_real_escape_string($_POST['title']);
    $link = mysql_real_escape_string($_POST['link']);
    $description = mysql_real_escape_string($_POST['description']);
    $type = mysql_real_escape_string($_POST['type']);
    mysql_query("INSERT INTO links (category,title,description,link,type) VALUES('$cat','$title','$description','$link','$type')");
    echo "<script>window.location = 'category?cat=$cat'</script>";
    exit();
  }

  $id = $_SESSION['user_id'];
  $cat = mysql_real_escape_string($_REQUEST['cat']);
  $catName = categoryName($cat);
  $icons = array('normal','recommended','paid');
  // Grab categories
    $q = mysql_query("SELECT * FROM links WHERE category='$cat' ORDER BY linkOrder ASC, loves DESC");
    while($l = mysql_fetch_array($q)){
      $linkID = $l['id'];
      $linkTitle = $l['title'];
      $linkURL = $l['link'];
      $type = $icons[$l['type']];
      $links .= "<li rel='$link' id='$linkID'>
                  <a href='link-edit?cat=$cat&link=$linkID' class='left faded'>edit</a>
                  <span class='left' style='margin:0 5px 0 10px'>$linkTitle ($linkURL)</span>
                  <span class='icon inline $type'></span>
                </li>";
    }
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <h2 class='red'>Showing Links for Category "<?php echo $catName; ?>"</h2>
    <ul id='sortableLinks'>
      <?php echo $links; ?>
    </ul>
    <form action='category' method='post' id='form' class='clearForm'>
      <input type='hidden' name='cat' value="<?php echo $cat; ?>" />
      <div style='width:600px; display:block'>
        <label>Title:</label>
        <input type='text' class='inputtext' name='title' />
        <label>Link:</label>
        <input type='text' class='inputtext' name='link' />
        <label style='height:107px'>Description:</label>
        <textarea name='description' class='textarea'></textarea>
        <label>Type:</label>
        <select name='type'>
          <?php
            $types = array("Normal","Recommended","Paid Content");
            $i=0;
            foreach($types as $t){
              echo "<option value='$i'>$t</option>";
              $i++;
            }
          ?>
        </select>
        <label>&nbsp;</label>
        <input type='submit' class='button' value='Add Link' />
      </div>
    </form>
  </div>

<?php include_once("footer.php"); ?>
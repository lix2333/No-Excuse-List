<?php
  session_start();
  $title="link management";
  include_once("header.php");
  if(empty($_SESSION['superuser'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }

  /* mysql_query("ALTER TABLE links
              ADD COLUMN linkOrder INT(11)")or die(mysql_error());
  exit(); */

  if(isset($_POST['title'])){
    $title = mysql_real_escape_string($_POST['title']);
    $url = str_replace(" ","-",strtolower($title));
    $query = mysql_query("SELECT TreeLeft,TreeRight FROM gdn_category ORDER BY CategoryID DESC LIMIT 0,1");
    $r = mysql_fetch_array($query);
    $tL = $r['TreeLeft']+2;
    $tR = $r['TreeRight']+2;
    mysql_query("INSERT INTO gdn_category (ParentCategoryID,TreeLeft,TreeRight,Name,UrlCode) VALUES ('-1','$tL','$tR','$title','$url')");
    mysql_query("INSERT INTO categories (title) VALUES ('$title')");
    echo "<script>window.location = 'link-management'</script>";
    exit();
  }

  // Grab categories
    $query = mysql_query("SELECT * FROM categories");
    while($r = mysql_fetch_array($query)){
      $id = $r['id'];
      $catTitle = $r['title'];
      $categories .= "<li>
                        <a href='category-edit?cat=$id' class='left faded' style='margin-right:10px'>edit</a>
                        <a href='category?cat=$id'>$catTitle</a>
                      </li>";
    }
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <h2 class='red'><span>Categories</span></h2>
    <ul>
      <?php echo $categories; ?>
    </ul>
    <form action='link-management' method='post' id='form' class='clearForm'>
      <label>Category Title:</label>
      <input type='text' class='inputtext' name='title' autocomplete='off' />
      <input type='submit' class='button' value='Add Category' />
    </form>
  </div>

<?php include_once("footer.php"); ?>
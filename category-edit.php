<?php
  session_start();
  $title="link management";
  include_once("header.php");
  if(empty($_SESSION['superuser'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }

  if(isset($_POST['cat'])){
    $cat = mysql_real_escape_string($_POST['cat']);
    $title = mysql_real_escape_string($_POST['title']);
    mysql_query("UPDATE categories SET title='$title' WHERE id='$cat'");
    echo "<script>window.location = 'category-edit?cat=$cat'</script>";
    exit();
  }

  if(isset($_REQUEST['delete'])){
    $cat = mysql_real_escape_string($_REQUEST['cat']);
    mysql_query("DELETE FROM categories WHERE id='$cat'");
    echo "<script>window.location = 'link-management'</script>";
    exit();
  }

  $cat = mysql_real_escape_string($_REQUEST['cat']);
  $catName = categoryName($cat);
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <form action='category-edit' method='post' id='form'>
      <h2 class='red' style='padding-bottom:20px'>Edit Category "<?php echo $catName; ?>"</h2>
      <input type='hidden' name='cat' value="<?php echo $cat; ?>" />
      <label>Title:</label>
      <input type='text' class='inputtext' name='title' value="<?php echo $catName; ?>" />
      <label>&nbsp;</label>
      <input type='submit' class='button' value='Update Category Title' />
      <p class='left' style='padding:6px 0 0 5px'>or <a href='category-edit?cat=<?php echo $cat; ?>&delete=yes'>delete</a>.</p>
    </form>
    <p class='small' id='loginSubtext'><a href='link-management'>Go Back</a> to All Catgories</p>
  </div>

<?php include_once("footer.php"); ?>
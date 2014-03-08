<div id='subLinks'>
  <a href='<?php echo $base_url; ?>forum/profile/<?php echo $_SESSION['username']; ?>' <?php if($title=='settings'){echo "id='current'";}; ?>>Settings</a>
  <a href='loves' <?php if($title=='loves'){echo "id='current'";}; ?>>Loves</a>
  <?php if($_SESSION['user_id']<2){ ?>
    <a href='link-management' <?php if($title=='link management'){echo "id='current'";}; ?>>Link Management</a>
  <?php } ?>
</div>
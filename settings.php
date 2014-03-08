<?php
  session_start();
  $title="settings";
  include_once("header.php");
  if(empty($_SESSION['user_id'])){
    echo "<script>window.location = '$base_url'</script>";
    exit();
  }
  $id = $_SESSION['user_id'];
  $username = $_SESSION['username'];
  $email = email($id);

  if(isset($_POST['updateAccount'])){
    $email = mysql_real_escape_string($_POST['email']);
    if($_POST['oldPass'] != ""){
      $oldPass = mysql_real_escape_string($_POST['oldPass']);
        $oldPass = md5($oldPass);
        if(checkUserPass($oldPass)){
          $newPass = mysql_real_escape_string($_POST['newPass']);
          if($newPass == ""){
            $_SESSION['error'] = "You must enter a new password.";
          } else {
            $confirmPass = mysql_real_escape_string($_POST['confirmPass']);
            if($newPass == $confirmPass){
              $newPass = md5($newPass);
              mysql_query("UPDATE users SET password='$newPass' WHERE id='$id'");
              $_SESSION['success'] = "Your password has been reset.";
            } else {
              $_SESSION['error'] = "The new and confirmation password do not match.";
            }
          }
        } else {
          $_SESSION['error'] = "The old password provided is incorrect.";
        }
      header("Location:account");
      exit();
    }
  }
?>

  <div id='container'>
    <?php include_once("includes/account-sublinks.php"); ?>
    <?php include("includes/alert.php"); ?>
    <form action='account' method='post' id='form'>
      <input type='hidden' name='updateAccount' value='1' />
      <label>Username:</label>
      <input type='text' class='inputtext disabled' name='user' value='<?php echo $username; ?>' disabled='disabled' />
      <label>Email (optional):</label>
      <input type='text' class='inputtext' name='email' value='<?php echo $email; ?>' />
      <label>Old Password:<span>required to update password</span></label>
      <input type='password' class='inputtext' name='oldPass' autocomplete='off' />
      <label>New Password:</label>
      <input type='password' class='inputtext' name='newPass' autocomplete='off' />
      <label>Confirm Password:</label>
      <input type='password' class='inputtext' name='confirmPass' autocomplete='off' />
      <label>&nbsp;</label>
      <input type='submit' class='button' value='Update Account' />
    </form>
  </div>

<?php include_once("footer.php"); ?>
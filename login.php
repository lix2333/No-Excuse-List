<?php
  session_start();
  $title="login";
  include_once("header.php");

  if(isset($_POST['user'])){
    $user = mysql_real_escape_string($_POST['user']);
    $pass = mysql_real_escape_string($_POST['pass']);
      $pass = md5($pass);
    $query = mysql_query("SELECT * FROM users WHERE username='$user' AND password='$pass'")or die(mysql_error());
    if(mysql_num_rows($query) > 0){
      $r = mysql_fetch_array($query);
      $_SESSION['user_id'] = $r['id'];
      $_SESSION['username'] = $user;
      if($r['level'] == 1){
        $_SESSION['superuser'] = true;
      }
      header("Location:$base_url");
      exit();
    } else {
      $_SESSION['error'] = "The username/password combo is not found.";
      header("Location:login");
      exit();
    }
  }
?>

  <div id='container'>
    <?php
      if(isset($_SESSION['error'])){
        echo "<p class='error alert'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']);
      }
      if(isset($_SESSION['success'])){
        echo "<p class='success alert'>".$_SESSION['success']."</p>";
        unset($_SESSION['success']);
      }
    ?>
    <form action='login' method='post' id='form'>
      <input type='text' class='inputtext' name='user' />
      <input type='password' class='inputtext' name='pass' />
      <input type='submit' class='button' value='Login' />
    </form>
    <p class='small' id='loginSubtext'>Not registerd? <a href='register' class='red'>Click here to register today.</a></p>
  </div>

<?php include_once("footer.php"); ?>
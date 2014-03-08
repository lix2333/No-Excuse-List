<?php
  session_start();
  $title="register";
  include_once("header.php");

  if(isset($_POST['user'])){
    $user = mysql_real_escape_string($_POST['user']);
    $email = mysql_real_escape_string($_POST['email']);
    $pass = mysql_real_escape_string($_POST['pass']);
    if($user != "" && $pass != ""){
      if(checkUser($user)){
        $_SESSION['error'] = "Username is already in use.";
        header("Location:register");
        exit();
      } else {
        $pass = md5($pass);
        $date = time();
        mysql_query("INSERT INTO users (username,email,password,registerDate) VALUES ('$user','$email','$pass','$date')");
        $_SESSION['success'] = "You have successfully registered. Please login below.";
        header("Location:login");
        exit();
      }
    } else {
      $_SESSION['error'] = "Please select a username and password.";
      header("Location:register");
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
    ?>
    <form action='register' method='post' id='form'>
      <label>Username:</label>
      <input type='text' class='inputtext' name='user' />
      <label>Email (optional):</label>
      <input type='text' class='inputtext' name='email' />
      <label>Password:</label>
      <input type='password' class='inputtext' name='pass' />
      <label>&nbsp;</label>
      <input type='submit' class='button' id='register' value='Register' />
    </form>
    <p class='small' id='loginSubtext'>Already registered? <a href='login' class='red'>Click here to login.</a></p>
  </div>

<?php include_once("footer.php"); ?>
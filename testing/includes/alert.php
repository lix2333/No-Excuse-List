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
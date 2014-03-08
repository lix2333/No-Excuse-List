<?php
  session_start();
  session_destroy();
  include_once("header.php");
  header("Location:$base_url");
  exit();
?>
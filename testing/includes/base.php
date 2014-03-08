<?php
  session_start();
  // Establish a db connection
    // $con = mysql_connect("localhost","root","");
    $con = mysql_connect("localhost","theoriginal_nel","cEW2aWrA");
    if (!$con){die('Could not connect: ' . mysql_error());}
    mysql_select_db("theoriginal_nel", $con);

  // Set the base_url
    // $base_url = "http://127.0.0.1/Dropbox/noexuselist/";
    $base_url = "http://noexcuselist.com/testing/";
?>

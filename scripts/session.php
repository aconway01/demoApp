<?php
  //creates a session for storing data across pages
  session_start();

  if($_SESSION['logged_in'] != true)
  {
    header("location: login.php");
  }

  else
  {
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $todo = $_SESSION['todo'];
    $user_id = $_SESSION['user_id'];
  }
?>

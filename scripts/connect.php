<?php

  $servername = "localhost";
  $username = "root";
  $password = "";

  // Create connection
  $mysqli = new mysqli($servername, $username, $password);

  // Check connection
  if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error);
  }

  mysqli_select_db($mysqli,"demoApp");

?>﻿

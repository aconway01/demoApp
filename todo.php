<!DOCTYPE html>
<html>
  <head>
    <title>Demo App</title>

    <link rel="stylesheet" type="text/css" href="./style/demoStyle.css">

    <?php

    include './scripts/connect.php';
    include './scripts/session.php';

    function test_input($mysqli,$data)
    {
      //$data = $mysqli->escape_string($data);
      //$data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }


    $updateErr = "";

    if(!empty($_POST))
    {

      $list = test_input($mysqli,$_POST['mylist']);

      $sql = "UPDATE users SET todo='$list' WHERE user_id='$user_id';";

      $result = $mysqli->query($sql);

      if($result)
      {
        //update session variables

        $_SESSION['todo'] = $list;
        header("location: todo.php");
      }

      else
      {
        $updateErr = "Error updating To-Do list";
      }

      $mysqli->close();
    }
    ?>
  </head>
  <body>

    <h1>Demo App</h1>

    <ul>
      <li>
        <a href="index.php"> Home </a>
      </li>
      <li>
        <a href="profile.php"> Profile Info </a>
      </li>
      <li>
        <a href="todo.php"> To-Do List </a>
      </li>
      <li>
        <a href="login.php"> Log Out </a>
      </li>
    </ul>

    <h2> To-Do List </h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      To-Do List:<br>
      <textarea cols="75" rows="20" maxlength="65535" name="mylist"><?php echo $todo;?></textarea>
      <br>

      <input type="submit" name="submit" value="Submit">
      <span class="error"><?php echo $updateErr;?></span>

    </form>

  </body>
</html>

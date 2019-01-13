<!DOCTYPE html>
<html>
  <head>
    <title>Demo App</title>

    <link rel="stylesheet" type="text/css" href="./style/demoStyle.css">

    <?php
      include './scripts/connect.php';
      include './scripts/session.php';
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

    <h2> Profile Info </h2>

    <p><?php echo 'First name: ' . $first_name;?></p>
    <p><?php echo 'Last name: ' . $last_name;?></p>
    <p><?php echo 'Email: ' . $email;?></p>

  </body>
</html>

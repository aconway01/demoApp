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
        <a href="login.php"> Log Out </a>
      </li>
    </ul>

    <h2> Home </h2>

    <p><?php echo 'Hello, ' . $first_name . ' ' . $last_name; ?></p>

  </body>
</html>

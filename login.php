<!DOCTYPE html>

<html>

  <head>
    <title>Demo App</title>

    <link rel="stylesheet" type="text/css" href="./style/demoStyle.css">

    <style>
    .error {color: #FF0000;}
    </style>

    <?php

    include './scripts/connect.php';

    function test_input($mysqli,$data)
    {
      $data = $mysqli->escape_string($data);
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    session_start();
    session_unset();
    session_destroy();

    $email = $password = "";
    $emailErr = $passwordErr = "";

    if(!empty($_POST))
    {
      session_start();

      $email = test_input($mysqli,$_POST["email"]);
      $email = strtolower($email);

      $password = test_input($mysqli,$_POST['password']);

      $result = $mysqli->query("SELECT salt FROM users WHERE email='$email'");
      $row = $result->fetch_assoc();
      $salt_val = $row['salt'];

      $hashpassword = hash ( "sha256", $password . $salt_val );

      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = $mysqli->query($sql);

      if($result->num_rows == 0)
      {
        $emailErr = " *Email not associated with any account";
      }

      else
      {
        $row = $result->fetch_assoc();
        if($hashpassword === $row['password'])
        {
          //create session global variables
          $_SESSION['first_name'] = $row['first_name'];
          $_SESSION['last_name'] = $row['last_name'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['logged_in'] = true;
          //redirect to the main page
          header("location: index.php");
        }

        else
        {
          $passwordErr = " *Password is incorrect";
        }
      }

      //Close the connection
      $mysqli->close();
    }
    ?>

  </head>

  <body>

    <h2>Login</h2>

    <form method= "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Email:
      <input type="email" name="email" placeholder="Enter email" value="<?php echo $email;?>">
      <span class="error"><?php echo $emailErr;?></span>
      <br><br>

      Password:
      <input type="password" name="password" placeholder="Enter password" value="<?php echo $password;?>">
      <span class="error"><?php echo $passwordErr;?></span>
      <br><br>
      <input type="submit" name="submit" value="Login">
    </form>

    <p>Or <a href="register.php">Create an Account</a></p>

  </body>

</html>

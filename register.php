<!DOCTYPE html>

<html>

  <head>
    <title>Demo App</title>

    <link rel="stylesheet" type="text/css" href="./style/demoStyle.css">

    <?php
    include './scripts/connect.php';

    function test_input($mysqli, $data)
    {
      $data = $mysqli->escape_string($data);
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
      $keyspace = str_shuffle($keyspace );
      $pieces = [];
      $max = mb_strlen($keyspace, '8bit') - 1;
      for ($i = 0; $i < $length; ++$i) {
          $pieces []= $keyspace[random_int(0, $max)];
      }
      return implode('', $pieces);
    }

    $firstname = $lastname = $email = $password = $confirmpass = "";
    $firstnameErr = $lastnameErr = $emailErr = $passwordErr = $confirmpassErr = $registerErr = "";

    $submitReady = 1;

    if(!empty($_POST))
    {
      if (empty($_POST['firstname']))
      {
        $firstnameErr = "required";
        $submitReady = 0;
      }
      else
      {
        $firstname = test_input($mysqli,$_POST['firstname']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$firstname))
        {
          $firstnameErr = "Only letters and white space allowed";
          $submitReady = 0;
        }
      }

      if (empty($_POST['lastname']))
      {
        $lastnameErr = "required";
        $submitReady = 0;
      }
      else
      {
        $lastname = test_input($mysqli,$_POST['lastname']);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$lastname))
        {
          $lastnameErr = "Only letters and white space allowed";
          $submitReady = 0;
        }
      }

      if (empty($_POST["email"]))
      {
        $emailErr = "required";
        $submitReady = 0;
      }
      else
      {
        $email = test_input($mysqli,$_POST["email"]);
        $email = strtolower($email);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          $emailErr = "Invalid email format";
          $submitReady = 0;
        }
      }

      if (empty($_POST["password"]))
      {
        $passwordErr = "required";
        $submitReady = 0;
      }
      else
      {
        $password = test_input($mysqli,$_POST["password"]);

        if (strlen($_POST["password"]) <= 8)
        {
            $passwordErr = "Password must contain at least 8 characters";
            $submitReady = 0;
        }
        elseif(!preg_match("#[0-9]+#",$password))
        {
            $passwordErr = "Password must contain at least 1 number";
            $submitReady = 0;
        }
        elseif(!preg_match("#[A-Z]+#",$password))
        {
            $passwordErr = "Password must contain at least 1 capital letter";
            $submitReady = 0;
        }
        elseif(!preg_match("#[a-z]+#",$password))
        {
            $passwordErr = "Password must contain at least 1 lowercase letter";
            $submitReady = 0;
        }
      }

      if (empty($_POST["confirmpassword"]))
      {
        $confirmpassErr = "required";
        $submitReady = 0;
      }
      else
      {
        $confirmpass = test_input($mysqli,$_POST["confirmpassword"]);

        if ($_POST["password"] != $_POST["confirmpassword"])
        {
          $confirmpassErr = "Passwords do not match";
          $submitReady = 0;
        }
      }

      $salt_val = random_str(128);
      $hashpassword = hash ( "sha256", $password . $salt_val );

      $user_exist_query = $mysqli->query("SELECT * FROM users WHERE email='$email'");

      if($user_exist_query->num_rows != 0)
      {
        $emailErr = "A user with this email already exists";
        $submitReady = 0;
      }

      if ($submitReady == 1)
      {
        // Create the sql query
        $sql = "INSERT INTO users(first_name, last_name, email, todo, salt, password)
        VALUES ('$firstname', '$lastname', '$email', '', '$salt_val', '$hashpassword');";

        // Add the user
        $result = $mysqli->query($sql);

        // If success, redirect to login
        if($result)
        {
          header("location: login.php");
        }
        else
        {
          $registerErr = "Error creating account";
        }
      }
    $mysqli->close();
    }
    ?>

  </head>

  <body>

    <h2>Create an account</h2>
    <p><span class="error">* required field</span></p>
    <form method= "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
      First name: <input type="text" name="firstname" placeholder="Enter first name" value="<?php echo $firstname;?>">
      <span class="error">* <?php echo $firstnameErr;?></span>
      <br><br>

      Last name: <input type="text" name="lastname" placeholder="Enter last name" value="<?php echo $lastname;?>">
      <span class="error">* <?php echo $lastnameErr;?></span>
      <br><br>

      Email: <input type="email" name="email" placeholder="Enter email" value="<?php echo $email;?>">
      <span class="error">* <?php echo $emailErr;?></span>
      <br><br>

      Password: <input type="password" name="password" placeholder="Enter password" value="<?php echo $password;?>">
      <span class="error">* <?php echo $passwordErr;?></span>
      <br><br>

      Confirm Password: <input type="password" name="confirmpassword" placeholder="Retype password" value="<?php echo $confirmpass;?>">
      <span class="error">* <?php echo $confirmpassErr;?></span>
      <br><br>

      <input type="submit" name="submit" value="Register">
      <span class="error"><?php echo $registerErr;?></span>
    </form>

    <p>Already have account? <a href="login.php">Log In</a></p>

  </body>

</html>

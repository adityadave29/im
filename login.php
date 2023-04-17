<?php
  session_start();
  $error_message ='';

  if($_POST){
    
    include('database/connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = 'Select * FROM users WHERE users.email="'.$username.'" AND users.password="'.$password.'"';

    $stmt = $conn->prepare($query);
    $stmt->execute();

    if($stmt->rowCount()>0){
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $user = $stmt->fetchAll()[0];
      $_SESSION['user'] = $user;

      header('Location: dashboard.php');

    }else $error_message = 'Invalid username or password';

    var_dump($stmt->rowCount());
    die;
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LoginPage - IM</title>
    <link rel="stylesheet" type="text/css" href="./css/login.css" />
</head>

<body>
    <?php if(!empty($error_message)){ ?>
    <div id="errorMessage">
        <p>Error: <?= $error_message ?></p>
    </div>
    <?php } ?>
    <div class="container">
        <div class="loginHeader">
            <h1>IM Login Page</h1>
        </div>
        <div class="loginBody">
            <form action="login.php" method="POST">
                <div class="loginInputsContainer">
                    <label for="">Username</label>
                    <input placeholder="username" name="username" type="text" />
                </div>
                <div class="loginInputsContainer">
                    <label for="">Password</label>
                    <input placeholder="password" name="password" type="password" />
                </div>
                <div class="loginButtonContainer">
                    <button>Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
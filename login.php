<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            margin-bottom: 20px;
        }

        .input-form {
            width: 100%;
            padding: 12px;
            border: 1px solid #cedad0;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease; 
        }

        h3{
             color: purple;
        }

        .btn{
            background-color: purple;
        }

        .btn:hover {
            background-color: #b30095; /* Darker blue on hover */
        }
         .notif {
            position: fixed;
            bottom: 20px; /* Adjust as needed */
            right: 20px; /* Adjust as needed */
            z-index: 9999;
            color: white;
            padding: 10px;
            background-color: #b35353;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $username = $_POST["username"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }else{
                    echo "<div class='notif'>Incorrect Password</div>";
                }
            }else{
                echo "<div class='notif'>User does not exist</div>";
            }
        }
        ?>
       <h3>Login</h3>
      <form action="login.php" method="post">
        <div class="form-container">
            <input type="text" placeholder="Username:" name="username" class="input-form">
        </div>
        <div class="form-container">
            <input type="password" placeholder="Password:" name="password" class="input-form">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn">
        </div>
      </form>
     <div><p>Not registered yet? <a href="signup.php">Signup Here</a></p></div>
    </div>
</body>
</html>
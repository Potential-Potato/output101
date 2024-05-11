<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
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
            background-color: #b30095; 
        }

        .notification-container{
            position: fixed;
            bottom: 20px; 
            right: 20px; 
            z-index: 9999;
            color: white;
        }

        .notif {
            padding: 10px;
            background-color: #b35353;
            border-radius: 5px;
        }

        .notif-s{
            padding: 10px;
            color: white;
            background-color: #4cae5e;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Signup</h3>
        <div class="notification-container">
            <?php
            if (isset($_POST["submit"])) {
               $fullName = $_POST["fullname"];
               $email = $_POST["email"];
               $password = $_POST["password"];
               $passwordRepeat = $_POST["repeat_password"];

               $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                //checks if yes
               if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                   echo "<div class='notif'>All fields are required</div>";
               } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                   echo "<div class='notif'>Email is not valid</div>";
               } elseif (strlen($password) < 6) {
                   echo "<div class='notif'>Password must be at least 5 characters!</div>";
               } elseif ($password !== $passwordRepeat) {
                   echo "<div class='notif'>Password do not match</div>";
               } else {
                   require_once "database.php";
                   $sql = "SELECT * FROM users WHERE email = '$email'";
                   $result = mysqli_query($conn, $sql);
                   $checkemail = mysqli_num_rows($result);
                   if ($checkemail > 0) {
                       echo "<div class='notif'>Email already exists!</div>";
                   } else {
                       $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                       $stmt = mysqli_stmt_init($conn); 
                       $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                       if ($prepareStmt) {
                           mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                           mysqli_stmt_execute($stmt);
                           echo "<div class='notif-s'>Registered successfully.</div>";
                       } else {
                           echo "<div class='notif'>Something went wrong</div>";
                       }
                   }
               }
            }
            ?>
        </div>
        <form action="signup.php" method="post">
            <div class="form-container">
                <input type="text" class="input-form" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-container">
                <input type="email" class="input-form" name="email" placeholder="Email:">
            </div>
            <div class="form-container">
                <input type="password" class="input-form" name="password" placeholder="Password:">
            </div>
            <div class="form-container">
                <input type="password" class="input-form" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn" value="Sign Up" name="submit">
            </div>
        </form>
        <div>
            <p>Already Registered? <a href="login.php">Login Here</a></p>
        </div>
    </div>
</body>
</html>

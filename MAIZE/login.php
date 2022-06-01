<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> User | Login Page </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="images/TTU-Logo.png">
    <style>
        Body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
        }

        button {
            background-color: #4CAF50;
            width: 100%;
            color: black;
            padding: 15px;
            font-size: 20px;
            margin: 10px 0px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            margin-top: 30px;
        }


        input[type=text],
        input[type=password] {
            width: 100%;
            margin: 8px 0;
            padding: 12px 20px;
            display: inline-block;
            border: 2px solid green;
            box-sizing: border-box;
            border-radius: 10px;
        }

        button:hover {
            opacity: 0.7;
            border-radius: 8px;
        }

        .login-form {
            top: 20%;
            left: 35%;
            position: absolute;
            box-sizing: border-box;
            width: 400px;
            height: 450px;
            transform: translate(-50% -50%);

        }

        input[type=text] {
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .container {
            padding: 10px;
            background: #5F9EA0;
            border: 1px solid #B0C4DE;
            border-radius: 8px;

        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            position: absolute;
            left: calc(50% - 50px);
            top: -50px;
        }

        h1 {
            margin-top: 40px;
        }

        a {
            text-decoration: none;
            float: right;
            padding-right: 30px;
            padding-left: 20px;
            width: 80px;
            text-align: center;
            height: 30px;
        }

        a:hover {
            background-color: green;
            border-radius: 20px;
            color: orange;
            opacity: 1.0;
        }

        @media only screen and (max-width: 900px) {
            Body {
                width: 100%;
                height: 700px;
                font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                background-color: white;
                padding: 0px;
                margin: 0px;
            }

            .login-form {
                position: fixed;
                box-sizing: border-box;
                width: 100%;
                height: 450px;
                transform: translate(-50% -50%);
                padding: 0px;
                margin: 0px;
                align-content: center;
                left: 0%;
                top: 10%;


            }

            .container {
                background-color: lightblue;
                border-radius: 8px;
                box-shadow: none;
                display: flex;
                flex-direction: column;
                padding-top: 10px;
                text-align: center;

            }

            button {
                background-color: #4CAF50;
                width: 90%;
                color: orange;
                border: none;
                cursor: pointer;
            }


            input[type=text],
            input[type=password] {
                width: 90%;
                border: 2px solid green;
                box-sizing: border-box;
                border-radius: 10px;
                align-content: center;
            }

        }
    </style>
</head>

<body>
    <div class="login-form">

        <form action="" method="POST" enctype="multipart/form-data">
            <img src="images/avatar.png" alt="avatar image " class="avatar">
            <div class="container">
                <center>
                    <h1> Login Form </h1>
                </center>
                <label>Username : </label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required>
                <label>Password : </label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>
                <button type="submit" name="submit">Login</button>
                <h3>Do you have account? <a href="signup.php">SignUp</a></h3>
            </div>
        </form>
    </div>
    <?php

    $con = mysqli_connect("localhost", "root", "", "project");
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    /*
    $user=filter_input(INPUT_POST,'user');
    $user1=filter_input(INPUT_POST,'teacher');
    */
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);
    if (isset($_POST['submit'])) {


        $sql = "SELECT *FROM user where username = '$username' && password = '$password'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
    ?>
            <script type="text/javascript">
                alert("Login Successfull.");
                window.location = "homePage.php";
            </script>
        <?php
        } else {
        ?>
            <script type="text/javascript">
                alert("Login failed. Email or Password invalid!!.");
            </script>
    <?php
        }
    }
    ?>
</body>

</html>
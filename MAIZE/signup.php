<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Regestration Form</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="icon" href="images/TTU-Logo.png">

</head>

<body>
    <div class="signup-form">
        <h1>Registration From</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <br>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>
            <br>
            <label for="password">Password:</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <br>
            <label for="">Gender:</label>
            <br>
            <input type="radio" value="Male" name="gen" id="gen" required>Male <br><input type="radio" value="Female" name="gen" id="gen" required>Female
            <br>
            <label for="date of birth">Date of Birth:</label>
            <br>
            <input type="date" placeholder="Enter DOB" name="dob" id="dob" required>
            <br>
            <label for="user">User_Type:</label>
            <br>
            <select name="user" id="user">
                <option value="1" hidden>.....User Type....</option>
                <option value="2" name="user" id="user">User</option>
                <option value="3" name="user" id="user">Teacher</option>

            </select>
            <br>
            <button type="submit" name="submit" id="sbt">Register</button>
        </form>
    </div>
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    session_start();
 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $users = array('2' => 'User', '3' => 'Teacher');
        $username =  ($_REQUEST['username']);
        $password = ($_REQUEST['password']);
        $gender =  ($_REQUEST['gen']);
        $dob = ($_REQUEST['dob']);
        $user_type = ($users[$_REQUEST['user']]);

        // Performing insert query execution
        // here our table name is college
        if (isset($_POST['submit'])) {


            $sql = "INSERT INTO user VALUES ('$username','$password','$gender','$dob','$user_type')";
            $result = mysqli_query($conn, $sql);

            if ($result == 1) {
    ?>
                <script type="text/javascript">
                    alert("Registration Successfull.");
                    window.location = "login.php";
                </script>
            <?php
            } else {
            ?>
                <script type="text/javascript">
                    alert("Registration unsuccessfu..!!.");
                </script>
    <?php
            }
        }
    }
    session_destroy();
    ?>

</body>

</html>
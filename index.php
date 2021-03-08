
<html>
    <head>
        <title>Fully</title>

    </head>

    <body> 

        <h1 class="logo">Fully</h1>

        <h2 class="register">Register</h2>
        <form method="post" name="register" action="index.php">
            <input class="input" type="text" name="fname" pattern="[a-zA-z\s]{1,100}" title="Must be between 2 and 100 chars" placeholder="First Name" required><br>
            <input class="input" type="text" name="lname" pattern="[a-zA-z\s]{1,100}" title="Must be between 2 and 100 chars" placeholder="Last Name" required><br>
            <input class="input" type="email" name="email" placeholder="Email" required><br>
            <input class="input" type="password" name="pass" placeholder="Password"
                pattern="{6,16}" title="Must be between 6 and 16 chars" required><br>
            <input class="input" type="password" name="passConfirm" placeholder="Confirm Password"
                pattern="{6,16}" title="Must be between 6 and 16 chars" required><br>
            <input class="submitButton" type="submit" value="Register">
        </form>

        <button type="button" class="button" onClick="location.href='login.php'">
            Log In
        </button>
</html>

<?php

    if (isset($_POST['email'])) {

        session_start();

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            header( "Location: home.php" );
        }

        include ("serverConfig.php");
        $conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
        if ($conn -> connect_error) {
            die("Connection failed:" .$conn -> connect_error);
        }

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $hashedPass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (fname, lname, email, password)
        VALUES ('{$fname}', '{$lname}', '{$email}', '{$hashedPass}')";

        if ($conn->query($sql) === TRUE) {
            
            $sql = "select * from Users where email=\"{$email}\";";
            $result = $conn -> query($sql);
            $row = $result->fetch_assoc();
            $userID = $row["userID"];

            $_SESSION['user'] = $userID;
            $_SESSION['fname'] = $fname;
            $_SESSION['loggedin'] = true;
            header( "Location: home.php" );

        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            header( "Location: index.php" );
            
        }

        $conn->close();
    }
?>

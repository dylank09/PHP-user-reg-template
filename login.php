<html>
    <head>
        <title>Fully</title>
        
    </head>

    <body>
        <h1 class="logo">Fully</h1>
        <form method="post" action="login.php">
            <input class="input" type="email" name="email" placeholder="Email" required><br>
            <input class="input" type="password" name="pass" placeholder="Password" required><br>
            <input class="submitButton" type="submit" value="Login">
        </form>

        <button type="button" class="button" onClick="location.href='index.php'">
            Sign Up
        </button>
    </body>
</html>
<?php

    if(isset($_POST['email'])) {

        include ("serverConfig.php");
        $conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
        if ($conn -> connect_error) {
            die("Connection failed:" .$conn -> connect_error);
        }

        session_start();

        $email = $_POST['email'];
        $password = $_POST['pass'];
        
        $sql = "select * from Users where email=\"{$email}\";";
        $result = $conn -> query($sql);
        $row = $result->fetch_assoc();
        $userID = $row["userID"];
        $sqlEmail = $row["email"];
        $sqlPass = $row["password"];

        function emailMatches ($inputEmail, $DBEmail) {
            return strcasecmp($inputEmail, $DBEmail) == 0;
        }

        if(emailMatches($email, $sqlEmail)) {
            
            $_SESSION['user'] = $userID;
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            header( "Location: home.php" );
        }
        else {
            header( "Location: login.html" );
        }

        $conn->close(); 
    }
?>
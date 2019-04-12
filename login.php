<html>
    <!--Create a login page for users' purchasing

    Author: Benjamin Liang & Laila Abella
Class: ITM 352
Project: Assignment 2

This is the login page.
    In case the registration did not go through, use:
Testing username:itm352
testing password:grader
    OR
Group member1 username: benjamin
Group member1 password: testing
    OR
Group member2 username: laila1
Group member2 password: laila1

    "Redirects ONLY when login was successful, not when login failed"
    - when login is successful, will be redirected to the invoice -
    
    "Note: it should be impossible to get to the Invoice Display Page without first logging in!"
    - after registering, you must log in first -
    
Description: Create a website for products with a login, registration, and invoice and use persistent data
-->
    <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    </head>
    <style>
        body{
            background-image: url(soft.jpg);
            background-size: cover;
        }
        h1 {
            font-family: "Snell Roundhand", cursive;
            font-size: 60px;
            font-variant: small-caps;
            line-height: 10px;
            color: #DCB414;
        }
        h2 {
            font-family: "Snell Roundhand", cursive;
            font-size: 30px;
            line-height: 10px;
        }
        h3 {
            font-family: "Snell Roundhand", cursive;
            font-size: 20px;
            line-height: 10px;
        }
    </style>
    <body>
    <center>
    <?php session_start(); ?>
    <form action = '<?php echo $_SERVER['PHP_SELF'] ?>' method = 'POST'>
    
        <h2> Welcome to</h2><P><h1>Pandora's Box</h1><P>
        <h3>Please Login for purchasing!</h3><br>
    New user? <a href = 'registration.php'> Apply Now</a> <br><br>

    <label for="username">Username:</label>
    <input type='text' name='username'><br><br>
    <label for="password">Password:</label>
    <input type='password' name='password'> <br>
    <br>
    <input type='submit' name='login_button' value='login'> <br> <br>
    

        <?php
        //Check if the user typed in a username and password, otherwise print error message and die.
        $username = TRUE;
        $password = TRUE;
        
        if (array_key_exists ('login_button', $_POST) && empty($_POST['username'])) {
        $username = FALSE;
        }if (array_key_exists ('login_button', $_POST) && empty($_POST['password'])) {
        $password = FALSE;
        }if ($username === FALSE){
            echo "<span style = 'color:red'> Error: Please enter a valid username.";
            die();
        }if ($password === FALSE){
            echo "<span style = 'color:red'> Error: Please enter a valid password.";
            die();
        }
        //Assign user_data.txt file to a variable
        $userdata = "user_data.txt";
        //Unserialize user_data.txt file and place into an array
        function arrayfile_to_array($filepath){
            $fsize = filesize($filepath);
            if ($fsize > 0) {
                $fp = fopen($filepath, "r");
                $encoded = fread($fp, $fsize);
                fclose($fp);
                return unserialize($encoded);
            }
        }
    //Save all the user information from the file into $users variable
    $users = arrayfile_to_array ($userdata);    
    //Initialize errors array
    $errors = array();
    //Check login information after login button is clicked
    if (array_key_exists('login_button', $_POST)) { 
    // Make username case insensitive    
        $username = strtolower($_POST['username']);
        for ($x = 0; $x < count($users); $x++){
            // Redirect to header if login information is correct, set session to true
                if ($username  == $users[$x]['username'] &&  $_POST['password'] == $users[$x]['password']){
                    $name = $_POST['username'];
                    if (!isset($_COOKIE["name"])) {
                        //credit: gary for sharing.
                        //it's what we learned on 4/4/2019
                        setcookie("name", $name, time() + 1800);
                    }
                        $_SESSION["logged_in"] = true;
                        header("Location: invoice.php");
                    } else {
                    $errors[]=0;
                    }
        }
    // Print error message if error is found
            if (!empty($errors)){
                echo "<center><span style = 'color:red'> Incorrect username and/or password. Please check and try again.</center>";
            }
    }
        
        ?>

    </form>
    </center>
    </body>
</html>

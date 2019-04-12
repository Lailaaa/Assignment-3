<!DOCTYPE html>
<!--This page is registration form
credit: Gary for sharing the function coding.

Author: Benjamin Liang & Laila Abella
Class: ITM 352
Project: Assignment 2

"Redirects ONLY when registration was successful, not when registration failed"
- when registration is successful, it will say so. Then it will ask to go to login (for security purposes) -
- you must login after registering if you are new. Then you will be redirected to the invoice -

"Note: it should be impossible to get to the Invoice Display Page without first logging in!"
- after registering, you must log in first -

Description: Create a website for products with a login, registration, and invoice and use persistent data
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registration Form</title>
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
        <h3>Welcome to </h3>
        <h2>Registration Form</h2>
         <?php
        function display_form()
        {
        ?><form action = '<?php echo $_SERVER['PHP_SELF'] ?>' method = 'post'><?php    
        print "Username: <br><input type='text' name='username'><br>";
        print "Please Enter a Username that is 4-11 Characters <br><br>";
        print "Password:<br><input type='password' name='password'> <br>";
        print "Please Enter a Password that is Minimum of 6 Characters <br><br>";
        print "Confirm Password:<br><input type='password' name='confirm_password'> <br><br>";
        print "Email:<br><input type='text' name='email'> <br><br>";
        print "<input type='submit' name='submit_button' value='Register'>";
        print "</form></center>";
        }
        
        
        function display_sticky_form($errors)
        {
        ?><form action = '<?php echo $_SERVER['PHP_SELF'] ?>' method = 'post'><?php    
        print " Username: <input type='text' value='{$_POST['username']}' name='username'> <br>";
        print "Please Enter a Username that is 4-11 Characters <br>";
        if (array_key_exists('username_short', $errors)){
        echo "<font color='red'>{$errors['username_short']}</font>";
        echo "<br>";
        }
        if (array_key_exists('username_long', $errors)){
        echo "<font color='red'>{$errors['username_long']}</font>";
        echo "<br>";
        }
        if (array_key_exists('username_exists', $errors)){
        echo "<font color='red'>{$errors['username_exists']}</font>";
        echo "<br>";
        }
        if (array_key_exists('username_format', $errors)){
        echo "<font color='red'>{$errors['username_format']}</font>";
        echo "<br>";
        }
        if (array_key_exists('empty_username', $errors)){
        echo "<font color='red'>{$errors['empty_username']}</font>";
        echo "<br>";
        }
        print "Password:<input type='password' name='password'> <br>";
        print "Please Enter a Password that is Minimum of 6 Characters <br>";
        if (array_key_exists('password_short', $errors)){
        echo "<font color='red'>{$errors['password_short']}</font>";
        echo "<br>";
        }
        if (array_key_exists('empty_password', $errors)){
        echo "<font color='red'>{$errors['empty_password']}</font>";
        echo "<br>";
        }
        print "Confirm Password: <input type = 'password' name = 'confirm_password'> <br>";
        if (array_key_exists('unconfirmed_password', $errors)){
        echo "<font color='red'>{$errors['unconfirmed_password']}</font>";
        echo "<br>";
        }
        if (array_key_exists('empty_confirm_password', $errors)){
        echo "<font color='red'>{$errors['empty_confirm_password']}</font>";
        echo "<br>";
        }
        print "Email: <input type='text' value='{$_POST['email']}' name='email'> <br>";
        if (array_key_exists('email_invalid', $errors)){
        echo "<font color='red'>{$errors['email_invalid']}</font>";
        echo "<br>";
        }
        if (array_key_exists('empty_email', $errors)){
        echo "<font color='red'>{$errors['empty_email']}</font>";
        echo "<br>";
        }
        if (array_key_exists('email_exists', $errors)){
        echo "<font color='red'>{$errors['email_exists']}</font>";
        echo "<br>";
        }
        print "<input type='submit' name='submit_button' value='Continue'>";
        print "</form></center>";
        
        
        }
        
        // This is assigning the TXT file into a variable
        //having an error of Notice: unserialize(): Error at offset 0 of 1 bytes 
        //sulution: adds base64_decode():
        $userdata = "user_data.txt";
        
        // arrayfile_to_array function (copied from File I/O Powerpoint)
        function arrayfile_to_array($filepath)
        {
        $fsize = filesize($filepath);
        if ($fsize > 0) {
        $fp = fopen($filepath, "r");
        $encoded = fread($fp, $fsize);
        fclose($fp);
        return unserialize($encoded);
        }
        }
        // array_to_arrayfile function (copied from File I/O Powerpoint)
        function array_to_arrayfile($theArray, $filepath)
        {
        if($fp = fopen($filepath, "w+")) 
        {
        $encoded = serialize($theArray);
        fwrite($fp, $encoded);
        fclose($fp);
        }
        }
        ?>
        <?php
        
        //This is a function created that holds all of the data validation for the registration
        function data_validation ($username, $password, $confirm_password, $email, $errors,$users)
        {
        //This defines that the password is a minimum of at least 6 Characters
 
                if (strlen($password) < 6)
                    $errors['password_short']= ' Please Enter a Password that is at least 6 characters';
        // This defines that the username is a minimum of at least 4 Characters 
        
                if (strlen($username) < 4)
                    $errors['username_short'] = 'Please Enter a Username that is at least 4 characters';
        // This defines that the username is a maximum of 11 Characters   
       
                if (strlen($username) > 11)
                    $errors['username_long'] = 'Please Enter a Username that is less than 11 characters';
        // This is a statement that determines whether or not a username has already been used  
           for ($i=0; $i < count($users);$i++){          
           if (($users[$i]['username']) == strtolower ($username)){
           $errors['username_exists'] = "This Username Already Exists";
           }
           }
        // This is a statement that the username only contains letters and numbers 
           $pattern = "/^[a-z0-9]/";
                if (!preg_match($pattern, $username)){
                $errors['username_format'] = "Username must contain only letters and numbers";}
        //This is a statement that determines whether or not the password matches with the confirmed password
                if ($_POST['password'] !== $_POST['confirm_password']){
           $errors['unconfirmed_password'] = "This Password Does Not Match";   
        }
        // This is the statement that confirms whether or not the email is valid 
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
           $errors['email_invalid'] = "Email address not valid";
        }
        for ($i=0; $i < count($users);$i++){          
           if (($users[$i]['email']) == strtolower ($email)){
           $errors['email_exists'] = "This Email Already Exists";
           }
           }
        // This is returning the error messages 
         return $errors;
        }
        
 
       // This is the array for any errors  
       $errors=array();
       
       // This function read the information from the user_data.txt file which holds all the users 
       $users = arrayfile_to_array ($userdata);
       
       // This is the if statement that will collect all of the information that is inputted in the form
       if (!array_key_exists('submit_button', $_POST)){
       
       // This is displaying the non-sticky form when the page is originally pulled up
           display_form();
       }
       // This is the else function that will input the user information into the POST array
       else{            
       $username = $_POST['username'];
       $password = $_POST['password'];
       $confirm_password = $_POST ['confirm_password'];
       $email = $_POST['email'];
       
       //This is a foreach function that is assigning the text boxes that are empty a name to be put into the POST array
       foreach ($_POST as $key => $value)
        {
        if(($_POST[$key])== NULL)   
        {
        $errors["empty_$key"]= 'Please Enter Valid Entry';    
        }
        }
       // This is using the function that was used earlier to process the data validation 
       $errors = data_validation($username, $password, $confirm_password, $email, $errors,$users);
       
       // This is the if function that will determine whether or not there is anything in the $errors array
       if (!empty ($errors)){
       
       // if there are $errors, it will display the sticky form
           display_sticky_form($errors);
       }   
       else{
           
       // This is accumulating the information inputted into the POST array into its own array
       $users[]= array('username' => strtolower($username),'password' => $password, 'email' => strtolower($email));
           
       //This is putting the arrays from the $users array into the TXT file
       array_to_arrayfile($users, $userdata);
       
       // This is to display the user has registered and display the link to login
       echo "<center> <br><font color = 'red'> You Are Now Successfully Registered </font><br></center>";
       echo 'Click <a href="login.php"> HERE</a> to Login';
       }    
       }
       ?>
        </center>
    </body>
</html>
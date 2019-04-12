<!DOCTYPE html>
<!--
Author: Benjamin Liang & Laila Abella
Class: ITM 352
Project: Assignment 2

In case, if the register is not working.
Testing username:itm352
testing password:grader

Description: Create a website for products with a login, registration, and invoice and use persistent data
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Assignment2</title>
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
        img {
            width: 300px;
            display: block;
        }
        table, td {
            border: 1.5px solid black;
            font-family: "Courier New", monospace;
            border-collapse: collapse;
            text-align: center;
        }
        tr:hover {
            background-color: #EAF5FE;
        }
        th {
            background-color: black;
            color: white;
        }
    </style>
    <body>
    <center>
       <H2>Welcome to</H2><P><H1>Pandora's Box</H1></P>
       <H3>where every special moment is saved in Pandora's Box<BR></H3>
    <!--Create a form -->
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <?php
    function array_to_arrayfile($theArray, $filepath){
            if($fp = fopen($filepath, 'w+')){
                $encoded = serialize($theArray);
                fwrite($fp, $encoded);
                fclose($fp);
            }else{
                echo "Unable to write array to $filepath";
            }
        }
        //open the file, read save data
        $filename = "products_ordered.txt";
        $fp = fopen($filename, "r");
        $size = filesize($filename);
        fclose($fp);
        
        //Create an array to store product images
        $image = array(
            "<img src='1 Arrow.jpg'>",
            "<img src='2 Key.jpg'>",
            "<img src='3 Bow.jpg'>",
            "<img src='4 Feather.jpg'>",
            "<img src='5 Circles.jpg'>",
        );
        //Create arrays to store product info.
        $product1 = array('Image' => $image[0], 
                           'Type' => 'Sparkling Arrow Necklace, <BR> Clear CZ',
                           'Price'=> 75.00);
        $product2 = array('Image' => $image[1], 
                           'Type' => 'Regal Key Necklace, <BR> Sterling Silver',
                           'Price'=> 100.00);
        $product3 = array('Image' => $image[2], 
                           'Type' => 'Brilliant Bow Necklace, <BR> Clear CZ',
                           'Price'=> 100.00);
        $product4 = array('Image' => $image[3], 
                           'Type' => 'Black Leather Choker<BR>Necklace & Feather Pendant, <BR> Clear CZ',
                           'Price'=> 55.00);
        $product5 = array('Image' => $image[4], 
                           'Type' => 'Contemporary Pearl Necklace, <BR> Freshwater Cultured Pearl',
                           'Price'=> 255.00);
        //Create a function to serializes an array in $theArray and saves it
        
    ?>
        <!-- create a table-->
        <table>
            <!--create headers-->
            <tr>
                <th>Image</th>
                <th>Necklace Type</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
<?php
    // create a  multi-dimensional array
     $products = array ($product1, $product2, $product3, $product4, $product5);
     //Use for loop to print out all products
     for ($i = 0; $i < sizeof ($products); $i++){
         echo "<tr><td>" .$products[$i]['Image']. "</td>";
         echo "<td>" .$products[$i]['Type']. "</td>";
         echo "<td>$" .$products[$i]['Price']. "</td>";
         //create a input for quantity
         echo "<td><input type='text' name='qty_entered[]' value='0' size='3' maxlength='3'></td></tr>";
     }
?>
            </table>
        <!-- Create a submit button -->
        <br>
        <input type="submit" name="submit_button" value="purchase">
<?php
    //create a varible $sumbit as false
    //use if else to check if submit button is pressed before proccessing page
    // if the subit button is prssed before proccessing page, then use die() to stop it
    $submit = false;
    
    if(array_key_exists('submit_button', $_POST)){
        $submit = true;
    }else{
        die();
    }
    //Check to ensure quantity entered is a positive numbner
    //set $quantity0~4 as false in varibles
    $quatity0 = false;
    $quatity1 = false;
    $quatity2 = false;
    $quatity3 = false;
    $quatity4 = false;
    //set a variable $error as false
    $error = false;
    //use if statement to check if the user inputed positive quantities
    if($_POST['qty_entered'][0] >0){
        $quatity0 = true;
    }if($_POST['qty_entered'][1] >0){
        $quatity1 = true;
    }if($_POST['qty_entered'][2] >0){
        $quatity2 = true;
    }if($_POST['qty_entered'][3] >0){
        $quatity3 = true;
    }if($_POST['qty_entered'][4] >0){
        $quatity4 = true;
    }
    //Set varibles for $qty0~4
    $qty0 = 0;
    $qty1 = 0;
    $qty2 = 0;
    $qty3 = 0;
    $qty4 = 0;
    //restore the quatities the user has input
    if(array_key_exists('submit_button', $_POST)){
        $qty0 = $_POST['qty_entered'][0];
        $qty1 = $_POST['qty_entered'][1];
        $qty2 = $_POST['qty_entered'][2];
        $qty3 = $_POST['qty_entered'][3];
        $qty4 = $_POST['qty_entered'][4];
    }
    //Save quantites entered into an array
    $items = array($qty0, $qty1, $qty2, $qty3, $qty4);
    
    
    //check if the user has input an interger
    //credit:https://stackoverflow.com/questions/3502854/is-int-and-get-or-post
    if(ctype_digit($qty0) && ctype_digit($qty1) && ctype_digit($qty2) && ctype_digit($qty3) && ctype_digit($qty4)){
        $error = false;
    }else{
        $error = true;
    }
    
    //check if user entered a quantity for each items
    if($quatity0 === false && $quatity1 === false && $quatity2 === false && $quatity3 === false && $quatity4 === false){
        $error = true;
        
    }
    //Stop the script and print error messages if an error is found
    if($error === true){
        echo "<h2>Error: Invalid or no quantities entered, Please enter a postive for integer for quantiy</h2>";
        die();
    }
    //if sumbit button is clicked and no error found,then it takes to login page
    if (array_key_exists('submit_button', $_POST) && $error === false){
        array_to_arrayfile($items, 'products_ordered.txt');
        header("Location:login.php");
}else{
        echo "Error found";
    }
    //calulation Extend price
    $ep0 = $_POST['qty_entered'][0] * $product1['Price'];
    $ep1 = $_POST['qty_entered'][1] * $product2['Price'];
    $ep2 = $_POST['qty_entered'][2] * $product3['Price'];
    $ep3 = $_POST['qty_entered'][3] * $product4['Price'];
    $ep4 = $_POST['qty_entered'][4] * $product5['Price'];
?>
    </form>
    </center>
    </body>
</html>
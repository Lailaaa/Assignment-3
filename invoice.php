<!--
Author: Benjamin Liang & Laila Abella
Class: ITM 352
Project: Assignment 2

This is the invoice page,
If there are no errors found, (it shouldn't go here if there were any)
then it'll show the user's product info - invoice

Description: Create a website for products with a login, registration, and invoice and use persistent data
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Invoice Page</title>
    </head>
    <center>
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
        <?php
        
        //Check if user is logged in, otherwise send to index page for security
        //Session code got from https://stackoverflow.com/questions/1545357/how-to-check-if-a-user-is-logged-in-in-php
        session_start();
        if (!$_SESSION["logged_in"]) {
            header("Location: index.php");
        }


        //Assign products_ordered.txt file to a variable
        $orderdata = "products_ordered.txt";
        
        //Unserialize user_data.txt file and place into an array
        //Copied directly from File I/O powerpoint
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

    //Save all the user information from the file into $users variable
        
    $order = arrayfile_to_array ($orderdata);
    
    // Print Invoice if valid quantity is entered              
                   
    print "<br><br><P><H1>Pandora's Box</H1></P>
            <br><h2>Invoice</h2> <table>
        
            <!-- create header use <th> -->
            <tr>
                <th>Necklace Ordered</th>
                <th>Quantity Ordered</th>
                <th>Price<br>(each)</th>
                <th>Extended Price</th>
            </tr>";
    
    // Print table rows if valid quantities are entered, round $ep to 2 decimals
    // Round code copied from Mini Assignment 2
    
        // Calculate extended prices
    $ep0 = $order[0] * 75.00;
    $ep1 = $order[1] * 100.00;
    $ep2 = $order[2] * 100.00;
    $ep3 = $order[3] * 55.00;
    $ep4 = $order[4] * 255.00;
    
    if ($order[0] > 0) {
        print "<tr><td>Sparkling Arrow Necklace, <BR> Clear CZ</td>
              <td>$order[0]</td>
              <td>$75.00</td>
              <td>$" . sprintf ('%0.2f', round ($ep0, 2)) . "</td></tr>";
    }if ($order[1] > 0) {
        print "<tr><td>Regal Key Necklace, <BR> Sterling Silver</td>
              <td>$order[1]</td>
              <td>$100.00</td>
              <td>$" . sprintf ('%0.2f', round ($ep1, 2)) . "</td></tr>";
    }if ($order[2] > 0) {
        print "<tr><td>Brilliant Bow Necklace, <BR> Clear CZ</td>
              <td>$order[2]</td>
              <td>$100.00</td>
              <td>$" . sprintf ('%0.2f', round ($ep2, 2)) . "</td></tr>";
    }if ($order[3] > 0) {
        print "<tr><td>Black Leather Choker<BR>Necklace & Feather Pendant, <BR> Clear CZ</td>
              <td>$order[3]</td>
              <td>$55.00</td>
              <td>$" . sprintf ('%0.2f', round ($ep3, 2)) . "</td></tr>";
    }if ($order[4] > 0) {
        print "<tr><td>Contemporary Pearl Necklace, <BR> Freshwater Cultured Pearl</td>
              <td>$order[4]</td>
              <td>$255.00</td>
              <td>$" . sprintf ('%0.2f', round ($ep4, 2)) . "</td></tr>";
    }
    // Calculate subtotal
    $subtotal = $ep0 + $ep1 + $ep2 + $ep3 + $ep4;
    // Print subtotal, round to 2 decimals
    print "<tr><td colspan='3' text-align: 'left' >Subtotal</td><td>$" . sprintf ('%0.2f', round ($subtotal, 2)) . "</tr>";
    // Calculate shipping fees 
    $itemcount = $order[0] + $order[1] + $order[2] + $order[3] + $order[4];
    $shipping_fee = $itemcount * 5;
    // Print shipping fee, round to 2 decimals
    print "<tr><td colspan='3'>Shipping fee $5 per item @ " . $itemcount . " item(s)</td><td>$" . sprintf ('%0.2f', round ($shipping_fee, 2)) . "</tr>";
    // Calculate tax @ 5%
    $tax_rate = 0.05;
    $tax = ($subtotal + $shipping_fee) * $tax_rate; 
    // Print tax, round to 2 decimals
    print "<tr><td colspan='3'>Sales Tax @ 5% </td><td>$" . sprintf ('%0.2f', round ($tax, 2)) . "</tr>";
    // Calculate Total
    $total = $subtotal + $tax;

    // Print total, round to 2 decimals
       print "<tr><td colspan='3'><b>Total</b></td><td><b>$" . sprintf ('%0.2f', round ($total, 2)) . "</b></tr></table><br>";
 
    // Confirm order received and thank customer for purchase   
       print "<h3>Thank you for your purchase,";
       if (isset($_COOKIE["name"])) {
           echo " {$_COOKIE['name']}!</h3>";
           
        }    
        print "<br><p><h3>Your order(s) will be shipped as soon as possible!</h3></p>";
    ?>
    </body>
    </center>
</html>
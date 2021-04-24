<!DOCTYPE HTML>
<html lang="en">

<!-- Page Structure: Outline is taken from my Assignment 1 in index.html This covers header, footer, and head section-->
<!--The class wrapper is taken from Assignment 1 which refers back to a prior tutorial-->
    
<!-- BEGIN: Header Area: Source my assignment 1 submission -->
<head>
    <meta http-equiv="Index" content="text/html; charset=utf-8">
    <meta name="schedule" content="Payment Index">
    <meta name="keywords" content="Payments, Index, COMP30680">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Schedule</title>
    
    <link rel="stylesheet" type="text/css" href="my_sched.css">
    <link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
</head>
<!-- END: Header Area -->

<!-- BEGIN: Body Area -->
<body>
<div class="main-body" id="main-body">

    <!-- BEGIN: Page Header -->
    <header>
        <div class="wrapper">
            <div class='web-header'>
                <h1 id='header-title'>Payments</h1>
            </div>
        </div>
        <?php include("navbar.php")?>
    </header>
    <!-- END: Page Header -->

    <!-- BEGIN: Section Area-->
    <section>
        <table>
        <h2>Most Recent Payments</h2>
        <thead>
            <tr>
                <td>Customer Number</td>
                <td>Cheque</td>
                <td>Payment Date</td>
                <td>Cheque Amount</td>
            </tr>
        </thead>
        <tbody>
        <?php

            /*
             Source: P9 Select and Display Final Piece (table)
            */
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "classicmodels";

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT 
                        customerNumber
                        ,checkNumber
                        ,paymentDate
                        ,amount 
                    FROM 
                        payments 

                    ORDER BY 
                        paymentDate 
                    DESC

                    LIMIT 
                        20";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                    <td><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                                    <input type="submit" name="more_info" class="more_info" id="<?php echo $row['customerNumber']?>" value="<?php echo $row['customerNumber']?>">
                                </form></td>
                    <td><?php echo $row['checkNumber']?></td>
                    <td><?php echo $row['paymentDate']?></td>
                    <td><?php echo $row['amount']?></td>
                </tr>
                <?php
                }
            } else {
                echo "0 results";
            }

            mysqli_close($conn);
            ?>
        </tbody>
        </table>
    </section>
    <!-- END: Section Area-->

        <?php
                /*
                Source: P9 Select and Display Final Piece (table)
                */
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "classicmodels";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $customer = $_POST["more_info"];
                  ?>

                <!-- BEGIN: Section Bottom Area-->

                <section id='customerarea'>
                    <table>
                    <h2>Customer Info</h2>
                    <thead>
                        <tr>
                            <td>Customer Number</td>
                            <td>Phone Number</td>
                            <td>Sales Rep</td>
                            <td>Credit Limit</td>
                            <td>Total Amount</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Create connection
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        // Check connection
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT
                                    txn.customerNumber
                                    ,ROUND(txn.amount,2) as amount
                                    ,cst.phone
                                    ,cst.creditLimit
                                    ,cst.salesRepEmployeeNumber
                                FROM 
                                    (SELECT 
                                        customerNumber
                                        ,SUM(amount) as amount
                                    FROM 
                                        payments 
                                    WHERE
                                        customerNumber='$customer'
                                    GROUP BY
                                        customerNumber) txn

                                INNER JOIN
                                    (SELECT
                                        phone
                                        ,customerNumber as crm
                                        ,creditLimit
                                        ,salesRepEmployeeNumber
                                     from 
                                        customers
                                    WHERE
                                        customerNumber='$customer') cst
                                ON
                                    txn.customerNumber=cst.crm
                                        ;";

                        $resultn = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($resultn) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($resultn)) {
                                ?>
                                <tr>

                                    <td>
                                    <?php echo $row['customerNumber']?>
                                    </td>

                                    <td>
                                        <?php echo $row['phone']?>
                                    </td>

                                    <td>
                                    <?php echo $row['salesRepEmployeeNumber']?>
                                    </td>

                                    
                                    <td>
                                        <?php echo $row['creditLimit']?>
                                    </td>

                                    <td>
                                        <?php echo $row['amount']?>
                                    </td>

                            </tr>
                            <?php
                            }
                        } else {
                            echo "0 results";
                        }

                        mysqli_close($conn);?>
                        </tbody>
                    </table>
                        </section>

                        <?php 
                                       /*
                Source: P9 Select and Display Final Piece (table)
                */
                    $customer = $_POST["more_info"]; ?>

                    <section id='paymentarea'>
                        <table>
                        <h2>Customer History</h2>
                        <thead>
                            <tr>
                                <td>Customer Number</td>
                                <td>Cheque Number</td>
                                <td>Payment Date</td>
                                <td>Amount</td>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                  
                        // Create connection
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        // Check connection
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT 
                                    customerNumber
                                    ,checkNumber
                                    ,paymentDate
                                    ,amount 
                                FROM 
                                    payments 
                                WHERE
                                    customerNumber='$customer'
                                ORDER BY 
                                    paymentDate 
                                DESC;";

                        $resultq = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($resultq) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($resultq)) {
                                ?>
                                <tr>

                                    <td>
                                    <?php echo $row['customerNumber']?>
                                    </td>

                                    <td>
                                        <?php echo $row['checkNumber']?>
                                    </td>


                                    <td>
                                    <?php echo $row['paymentDate']?>
                                    </td>

                                    <td>
                                        <?php echo $row['amount']?>
                                    </td>

                            </tr>
                            <?php
                            }
                        } else {
                            echo "0 results";
                        }

                        mysqli_close($conn);?>
                                </tbody>
                    </table>
    </section>
    <?php
                    }
                    else{

                    }
                    
                ?>


    <!-- END: Section Bottom Area-->

    </div>

<!-- END: Body Area -->


<?php include("footer.php") ?>
</body>

</html>


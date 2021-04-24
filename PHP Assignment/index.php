<!DOCTYPE HTML>
<html lang="en">

<!-- Page Structure: Outline is taken from my Assignment 1 in index.html This covers header, footer, and head section-->
<!--The class wrapper is taken from Assignment 1 which refers back to a prior tutorial-->
    
<!-- BEGIN: Header Area: Source my assignment 1 submission -->
<head>
    <meta http-equiv="Index" content="text/html; charset=utf-8">
    <meta name="schedule" content="Product Index">
    <meta name="keywords" content="Product, Index, COMP30680">
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
                <h1 id='header-title'>Product Lines</h1>
            </div>
        </div>

    <?php include("navbar.php")?>
    </header>
    <!-- END: Page Header -->

    <!-- BEGIN: Section Area-->
    <section>
    <h2>Product Lines</h2>
        <table>
        <thead>
            <tr>
                <td>Product Line</td>
                <td>Product Description</td>
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
                            productLine
                            ,textDescription 
                        FROM 
                            productlines";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>

                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                                    <input type="submit" name="more_info" class="more_info" id="<?php echo $row['productLine']?>" value="<?php echo $row['productLine']?>">
                                </form>
                            </td>

                            <td>
                                <?php echo $row['textDescription']?>
                            </td>

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

    <!-- END: Section: Top Area-->
        <?php
                /*
                Source: P9 Select and Display Final Piece (table)
                */
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "classicmodels";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST["more_info"];

                    ?>

            <!-- BEGIN: Section Bottom Area-->
                <section id='productlinearea'>
                    <table>
                    <h2>Product Line SKUs</h2>
                    <thead>
                        <tr>
                            <td>Product Code</td>
                            <td>Product Name</td>
                            <td>Product Line</td>
                            <td>Product Scale</td>
                            <td>Product Vendor</td>
                            <td>Product Description</td>
                            <td>Quantity Stocked</td>
                            <td>Buy Price</td>
                            <td>MSRP</td>
                        </tr>
                    </thead>
                    <tbody>
                  
                    <?
                        // Create connection
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        // Check connection
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT 
                                    productCode
                                    ,productName
                                    ,productLine
                                    ,productScale
                                    ,productVendor
                                    ,productDescription
                                    ,quantityInStock
                                    ,buyPrice
                                    ,MSRP 
                                FROM 
                                    products
                                WHERE
                                    productLine='$name'";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>

                                    <td>
                                    <?php echo $row['productCode']?>
                                    </td>

                                    <td>
                                        <?php echo $row['productName']?>
                                    </td>


                                    <td>
                                    <?php echo $row['productLine']?>
                                    </td>

                                    <td>
                                        <?php echo $row['productScale']?>
                                    </td>

                                    <td>
                                    <?php echo $row['productVendor']?>
                                    </td>

                                    <td>
                                        <?php echo $row['productDescription']?>
                                    </td>


                                    <td>
                                        <?php echo $row['quantityInStock']?>
                                    </td>

                                    <td>
                                        <?php echo $row['buyPrice']?>
                                    </td>

                                    <td>
                                        <?php echo $row['MSRP']?>
                                    </td>

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
                    <?php
                    }
                    else
                    {
                        
                    }
                ?>


    <!-- END: Section Bottom Area-->

                </div>

<!-- END: Body Area-->

<?php include("footer.php") ?>
</body>
</html>
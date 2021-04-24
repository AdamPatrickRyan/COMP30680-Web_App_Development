<!DOCTYPE HTML>
<html lang="en">

<!-- Page Structure: Outline is taken from my Assignment 1 in index.html This covers header, footer, and head section-->
<!--The class wrapper is taken from Assignment 1 which refers back to a prior tutorial-->
    
<!-- BEGIN: Header Area: Source my assignment 1 submission -->
<head>
    <meta http-equiv="Index" content="text/html; charset=utf-8">
    <meta name="schedule" content="Office Index">
    <meta name="keywords" content="Office, Index, COMP30680">
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
                <h1 id='header-title'>Offices</h1>
            </div>
        </div>
        <?php include("navbar.php")?>
    </header>
    <!-- END: Page Header -->

    <!-- BEGIN: Section Area-->
    <section id='top'>
        <table>
        <h2>Office List</h2>
        <thead>
            <tr>
                <td>City</td>
                <td>Address</td>
                <td>Phone Number</td>
                <td>More Info</td>
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
                            officeCode
                            ,city
                            ,phone
                            ,addressLine1
                            ,addressLine2
                            ,state
                            ,country
                            ,postalCode
                            ,territory
                        FROM 
                            offices";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>

                            <td>
                                <?php echo $row['city']?>
                            </td>

                            <td>
                                <?php echo $row['addressLine1']?>, <?php echo $row['addressLine2']?>, <?php echo $row['country']?>, <?php echo $row['postalCode']?>
                            </td>
                            
                            <td>
                                <?php echo $row['phone']?>
                            </td>
                            
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                                    <input type="submit" name="more_info" class="more_info" id="<?php echo $row['officeCode']?>" value="<?php echo $row['officeCode']?>">
                                </form>
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
                    $office = $_POST["more_info"];

                    ?>

                <!-- BEGIN: Section Bottom Area-->
                    <section id='officedetailarea'>
                        <table>
                        <h2>Employee List</h2>
                        <thead>
                            <tr>
                                <td>Job Title</td>
                                <td>Employee Number</td>
                                <td>Employee Name</td>
                                <td>Employee Email</td>
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
                                    jobTitle
                                    ,employeeNumber
                                    ,firstName
                                    ,lastName
                                    ,email
                                FROM 
                                    employees
                                WHERE
                                    officeCode='$office'
                                ORDER BY
                                    jobTitle
                                desc";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>

                                    <td>
                                    <?php echo $row['jobTitle']?>
                                    </td>

                                    <td>
                                        <?php echo $row['employeeNumber']?>
                                    </td>


                                    <td>
                                    <?php echo $row['firstName']?> <?php echo $row['lastName']?>
                                    </td>

                                    <td>
                                        <?php echo $row['email']?>
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
            else {

            }
            ?>


    <!-- END: Section Bottom Area-->
        </div>

<!-- END: Body Area -->


<?php include("footer.php") ?>
</body>
</html>
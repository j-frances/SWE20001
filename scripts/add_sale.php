<?php
    // Ensure User Is Authenticated To Access Page
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != "true") {
        header("location: ../index.php");
        exit;
    }

    // Connect To Database
    $mysqli = include("../connect.php");

    // Error While Connecting To Database
    if ($mysqli -> connect_errno) {
        echo "<p style='color: #ff0000;'><strong>Error while connecting to the database.</strong></p>";
        header("location: ../home.php");
        exit();
    }

    // Preparing Data For Sale Insertion
    $date_created = date("Y-m-d H:i:s");
    $member_id = $_POST["select_member"];
    $sale_insert = "INSERT INTO `Sales` (`Member_ID`, `Datetime_Created`) VALUES (\"$member_id\",\"$date_created\")";

    // Sale Insert Failed
    if ($mysqli->query($sale_insert) === FALSE) {
        echo "<p style='color: #ff0000'><strong>Error while inserting into database.</strong></p>";
        header("location: ../home.php");
        exit();
    }

    // Preparing Data For Sale Item Insertions
    $sale_id = $mysqli->insert_id;
    $products_count = ((sizeof($_POST)-1)/2);
    for ($i = 0; $i < $products_count; $i++) {
        $prod_id = $_POST["prod" . $i];
        $prod_qty = $_POST["prodQty" . $i];
        $sale_item_insert = "INSERT INTO `Sale_Items` (`Sale_ID`, `Product_ID`, `Quantity`) VALUES (\"$sale_id\", \"$prod_id\", \"$prod_qty\")";

        // Sale Item Insert Failed
        if ($mysqli->query($sale_item_insert) === FALSE) {
            echo "<p style='color: #ff0000'><strong>Error while inserting into database.</strong></p>";
            header("location: ../home.php");
            exit();
        }

        // Decrement Quantity When Sale Item Added
        $decrement_qty = "UPDATE `Products` SET `Quantity` = `Quantity` - $prod_qty WHERE `ID` = \"$prod_id\"";

        // Decrement Quantity Failed
        if ($mysqli->query($decrement_qty) === FALSE) {
            echo "<p style='color: #ff0000'><strong>Error while inserting into database.</strong></p>";
            header("location: ../home.php");
            exit();
        }
    }

    // Success
    $_SESSION["saleSuccess"] = true;
    header("location: ../new_sale.php");
?>

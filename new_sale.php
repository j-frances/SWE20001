<?php
    // Ensure User Is Authenticated To Access Page
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != "true") {
        header("location: index.php");
        exit;
    }

    // Connect To Database
    $mysqli = include("connect.php");

    // Error While Connecting To Database
    if ($mysqli -> connect_errno) {
        echo "<p style='color: #ff0000;'><strong>Error while connecting to the database.</strong></p>";
        header("location: home.php");
        exit();
    }

    // Get Auxiliary Information Required For Sales Entry
    $members_query = "SELECT ID, Name FROM Members";
    $members_result = $mysqli->query($members_query);
    $products_query = "SELECT * FROM Products";
    $products_result = $mysqli->query($products_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Document Metadata -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Document Title -->
    <title>New Sale | GoToGro Management Portal</title>

    <!-- Styling -->
    <link href="stylesheet.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap" />
</head>
<body class="sales_entry">
    <!-- Header -->
    <header>
        <a id="logo" href="https://gotogro.000webhostapp.com">GoToGro<sup>TM</sup></a>
    </header>

    <!-- New Sales Entry Form -->
    <div class="wrapper">
        <h1>New Sales Entry</h1>
        <form action="" method="POST">
            <!-- Select Member -->
            <label for="select_member">Choose a member:</label>
            <select name="select_member" id="select_member" required>
                <option selected disabled hidden></option>
                <?php
                    while ($member = $members_result->fetch_assoc())
                        echo "<option value='" . $member["ID"] . "'>" . $member["ID"] . ": " . $member["Name"] . "</option>";
                ?>
            </select>

            <!-- Select Producs (Dynamically Rendered) -->
            <div id="productsField"></div>
            <span class="reactiveText" onclick="addProduct()">+ Add Another Product</span>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-block btn-large">Add Sales Entry</button>
        </form>
    </div>

    <!-- Driver For Dynamically Renderning Form -->
    <script>
        // Get Products In Stock From Database To JavaScript
        let productList = [];
        <?php
            while ($product = $products_result->fetch_assoc())
                if (intval($product["Quantity"]) > 0)
                    echo  "productList.push({id:" . $product["ID"] .
                        ", name:'" . $product["ProductName"] . "'" .
                        ", qty:" . $product["Quantity"] .
                        ", price:" . $product["Price"] . "}); ";
        ?>

        // Keep Count Of Products
        let productsCount = 0;
        // Get Reference To DOM Element
        let productsField = document.getElementById("productsField");

        // Add New Product To DOM Field
        function addProduct() {
            // Create Label For Product Select Element
            let newProdElemLabel = document.createElement("label");
            newProdElemLabel.textContent = "Select a product: ";
            newProdElemLabel.setAttribute("for", ("prod" + productsCount.toString()));
            productsField.appendChild(newProdElemLabel);

            // Create Product Select Element
            let newProdElem = document.createElement("select");
            newProdElem.setAttribute("name", ("prod" + productsCount.toString()));
            newProdElem.setAttribute("id", ("prod" + productsCount.toString()));
            newProdElem.required = true;
            productsField.appendChild(newProdElem);

            // Create Label For Quantity Input Element
            let newQtyElemLabel = document.createElement("label");
            newQtyElemLabel.textContent = "Quantity: ";
            newQtyElemLabel.setAttribute("for", ("prodQty" + productsCount.toString()));
            productsField.appendChild(newQtyElemLabel);

            // Create Quantity Input Element
            let newQtyElem = document.createElement("input");
            newQtyElem.setAttribute("name", ("prodQty" + productsCount.toString()));
            newQtyElem.setAttribute("id", ("prodQty" + productsCount.toString()));
            newQtyElem.setAttribute("type", "number");
            newQtyElem.setAttribute("min", 1);
            newQtyElem.setAttribute("max", 10);
            newQtyElem.setAttribute("value", 1);
            newQtyElem.required = true;
            productsField.appendChild(newQtyElem);

            // Enter New Line
            let br = document.createElement("br");
            productsField.appendChild(br);

            // Add Default Option To Select Element
            let defaultOption = document.createElement("option");
            defaultOption.textContent = "";
            defaultOption.selected = true;
            defaultOption.disabled = true;
            defaultOption.hidden = true;
            newProdElem.appendChild(defaultOption);

            // Add Options From Product List To Select Element
            for (let i = 0; i < productList.length;  i++) {
                let option = document.createElement("option");
                option.textContent = productList[i].name;
                option.value = productList[i].id;
                newProdElem.appendChild(option);
            }

            productsCount++;
        }

        window.onload = addProduct;
    </script>
</body>
</html>

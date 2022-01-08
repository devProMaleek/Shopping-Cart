<?php

// Start session
session_start();

require_once('./Php/component.php');
require_once('./Php/CreateDB.php');

// Create instance of CreateDB class.
$database = new CreateDB('Shopping_Cart', 'product_tbl', 'localhost', 'root', '');
if (isset($_POST['add'])){
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'], 'product_id');
        if (in_array($_POST['product_id'], $item_array_id)){
            echo "<script>alert('Product is already added to your cart')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }else{
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id']
            );
            $_SESSION['cart'][$count] = $item_array;


        }
    }else{
        $item_array = array(
                'product_id' => $_POST['product_id']
        );
        // Create a new session variable
        $_SESSION['cart'][0] = $item_array;
    }
};
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
<body>
<?php require_once("php/header.php"); ?>
<div class="container">
<!-- Adding a new row with padding.-->
    <?php
        // Columns must be a factor of 12 (1, 2, 3, 4, 6, 12)
        $numsOfCols = 4;
        $rowCount = 0;
    ?>
    <div class="row text-center py-5">
        <?php
        $result = $database->getData();
        while ($row = mysqli_fetch_assoc($result)) {
            component($row['productName'], $row['productPrice'], $row['productDiscountPrice'], $row['productImg'], $row['productSummary'], $row['productID']);
            $rowCount++;
            if ($rowCount % $numsOfCols == 0) {
                echo '</div><div class="row text-center py-5">';
            }
        }
        ?></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>

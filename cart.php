<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<?php
session_start();
require_once('php/header.php');
require_once('php/CreateDB.php');
require_once('php/component.php');

$DB = new CreateDB('Shopping_cart', 'product_tbl');

if (isset($_POST['remove'])){
    if($_GET['action'] == 'remove'){
        foreach ($_SESSION['cart'] as $key => $value){
            if ($value["product_id"] == $_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo "<script>alert('Product has been Removed!')</script>";
                echo "<script>window.location = 'cart.php'</script>";
            };
        };
    };
};
?>
<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>My Cart</h6>
                <hr>

                <?php
                $total = 0;
                if (isset($_SESSION['cart'])){
                    $product_id = array_column($_SESSION['cart'], 'product_id');

                    $result = $DB->getData();
                    while ($row = mysqli_fetch_assoc($result)){
                        foreach ($product_id as $id){
                            if ($row['productID'] == $id){
                                cartElement($row['productImg'], $row['productName'], $row['sellerName'], $row['productPrice'], $row['productID']);
                                $total = $total + (int)$row['productPrice'];
                            }
                        }
                    }
                }else{
                    echo "<h5>Cart is Empty</h5>";
                }


                ?>

            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        if (isset($_SESSION['cart'])){
                            $count = count($_SESSION['cart']);
                            echo "<h6>Price($count items)</h6>";
                        }else{
                            echo "<h6>Price(0 items)</h6>";
                        }

                        ?>
                        <h6>Delivery Charges</h6>
                        <hr>
                        <h6>Amount Payable</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>&#8358;<?php echo $total; ?></h6>
                        <h6 class="text-success">FREE</h6>
                        <hr>
                        <h6>&#8358;<?php echo $total; ?></h6>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    function incrementValue(e){
        if (e.target.nodeName === 'BUTTON'){
            e.target.parentElement.children[1].value++;
        }else {
            e.target.parentElement.parentElement.children[1].value++;
        }

    };

    function decrementValue(e){
        if (e.target.nodeName === 'BUTTON'){
            if (e.target.parentElement.children[1].value > 1){
                e.target.parentElement.children[1].value--;
            }
        }else {
            if (e.target.parentElement.parentElement.children[1].value > 1){
                e.target.parentElement.parentElement.children[1].value--;
            }
        }
    };
</script>
</body>
</html>
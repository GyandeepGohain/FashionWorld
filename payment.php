<?php require_once('header.php'); ?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
if(!isset($_SESSION['customer'])) {
    header('location: login.php');
    exit;
}

$final_total = 0;
if(isset($_POST['final_total'])) {
    $final_total = $_POST['final_total'];
} else {
    $table_total_price = 0;
    $i=0;
    foreach($_SESSION['cart_p_id'] as $key => $value) {
        $i++;
        $arr_cart_p_id[$i] = $value;
    }
    $i=0;
    foreach($_SESSION['cart_p_qty'] as $key => $value) {
        $i++;
        $arr_cart_p_qty[$i] = $value;
    }
    $i=0;
    foreach($_SESSION['cart_p_price'] as $key => $value) {
        $i++;
        $arr_cart_p_price[$i] = $value;
    }
    for($i=1;$i<=count($_SESSION['cart_p_id']);$i++) {
        $row_total_price = (float)$_SESSION['cart_p_price'][$i] * (int)$_SESSION['cart_p_qty'][$i];
        $table_total_price = $table_total_price + $row_total_price;
    }
    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
    $statement->execute(array($_SESSION['customer']['cust_country']));
    $total = $statement->rowCount();
    if($total) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $shipping_cost = $row['amount'];
        }
    } else {
        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $shipping_cost = $row['amount'];
        }
    }
    $final_total = $table_total_price + $shipping_cost;
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="special">Payment Method</h3>
                <div class="cart">
                    <table class="table table-responsive">
                        <tr>
                            <th class="total-text">Order Total</th>
                            <th class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $final_total; ?></th>
                        </tr>
                    </table>
                </div>
                <form action="payment/cod/init.php" method="post">
                    <?php $csrf->echoInputField(); ?>
                    <div class="form-group">
                        <label for="payment_method">Select Payment Method *</label>
                        <select name="payment_method" class="form-control select2" id="advFieldsStatus">
                            <option value="COD">Cash on Delivery (COD)</option>
                        </select>
                    </div>
                    <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Place Order" name="form_cod">
                    </div>
                    <div class="form-group">
                        <a href="checkout.php" class="btn btn-default">Back to Checkout</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

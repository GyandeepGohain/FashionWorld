<?php
ob_start();
session_start();
include('../../admin/inc/config.php');
include('../../admin/inc/functions.php');
include('../../admin/inc/CSRF_Protect.php');
$csrf = new CSRF_Protect();

if(!isset($_SESSION['customer'])) {
    header('location: ../../login.php');
    exit;
}

if(!isset($_SESSION['cart_p_id'])) {
    header('location: ../../cart.php');
    exit;
}

$payment_method = 'COD';
$payment_status = 'Pending';
$payment_id = time();

$statement = $pdo->prepare("INSERT INTO tbl_payment (customer_id, customer_name, customer_email, payment_date, txnid, paid_amount, card_number, card_cvv, card_month, card_year, bank_transaction_info, payment_method, payment_status, shipping_status, payment_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$statement->execute(array(
    $_SESSION['customer']['cust_id'],
    $_SESSION['customer']['cust_name'],
    $_SESSION['customer']['cust_email'],
    date('Y-m-d H:i:s'),
    '',
    $_POST['amount'],
    '',
    '',
    '',
    '',
    '',
    $payment_method,
    $payment_status,
    'Pending',
    $payment_id
));

$i=0;
foreach($_SESSION['cart_p_id'] as $key => $value) {
    $i++;
    $statement = $pdo->prepare("INSERT INTO tbl_order (product_id, product_name, size, color, quantity, unit_price, payment_id) VALUES (?,?,?,?,?,?,?)");
    $statement->execute(array(
        $_SESSION['cart_p_id'][$key],
        $_SESSION['cart_p_name'][$key],
        $_SESSION['cart_size_name'][$key],
        $_SESSION['cart_color_name'][$key],
        $_SESSION['cart_p_qty'][$key],
        $_SESSION['cart_p_price'][$key],
        $payment_id
    ));

    $statement1 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
    $statement1->execute(array($_SESSION['cart_p_id'][$key]));
    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result1 as $row1) {
        $new_qty = $row1['p_qty'] - $_SESSION['cart_p_qty'][$key];
        $statement2 = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
        $statement2->execute(array($new_qty, $_SESSION['cart_p_id'][$key]));
    }
}

unset($_SESSION['cart_p_id']);
unset($_SESSION['cart_size_id']);
unset($_SESSION['cart_size_name']);
unset($_SESSION['cart_color_id']);
unset($_SESSION['cart_color_name']);
unset($_SESSION['cart_p_qty']);
unset($_SESSION['cart_p_price']);
unset($_SESSION['cart_p_name']);
unset($_SESSION['cart_p_featured_photo']);

header('location: ../../payment_success.php');

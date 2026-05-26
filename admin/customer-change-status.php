<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$cust_status = $row['cust_status'];
		}
	}
}
?>

<?php
if($cust_status == 0) {$final = 1;} else {$final = 0;}
$statement = $pdo->prepare("UPDATE tbl_customer SET cust_status=? WHERE cust_id=?");
$statement->execute(array($final,$_REQUEST['id']));

if ($final == 1) {
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $cust_email = $row['cust_email'];
        $cust_name = $row['cust_name'];
    }

    $subject = 'Account Activated - FashionWorld';
    $message = '
<html><body>
<h3>Hello ' . $cust_name . ',</h3>
<p>Your FashionWorld account has been successfully activated by the admin. You can now log in and shop on our website.</p>
<br>
<p>Thank you,<br>FashionWorld Team</p>
</body></html>
';

    send_email($cust_email, $subject, $message);
}

header('location: customer.php');
?>
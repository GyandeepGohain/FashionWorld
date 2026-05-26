<?php require_once('header.php'); ?>

<?php
if (isset($_REQUEST['email']) && isset($_REQUEST['token']))
{
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
    $statement->execute(array($_REQUEST['email']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($_REQUEST['token'] != $row['cust_token']) {
            header('location: '.BASE_URL);
            exit;
        }
    }

    $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?, cust_status=? WHERE cust_email=?");
    $statement->execute(array('', 1, $_GET['email']));

    $success_message = '<p style="color:green;">Your email is verified successfully. You can now login to our website.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';
}
elseif (isset($_REQUEST['email']) && isset($_REQUEST['key']))
{
    $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=? AND subs_hash=?");
    $statement->execute(array($_REQUEST['email'], $_REQUEST['key']));
    $total = $statement->rowCount();

    if ($total == 0) {
        header('location: '.BASE_URL);
        exit;
    }

    $statement = $pdo->prepare("UPDATE tbl_subscriber SET subs_active=1 WHERE subs_email=? AND subs_hash=?");
    $statement->execute(array($_GET['email'], $_GET['key']));

    $success_message = '<p style="color:green;">Your email subscription is confirmed successfully. Thank you!</p>';
}
else
{
    header('location: '.BASE_URL);
    exit;
}
?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1>Registration Successful</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php 
                        echo $error_message;
                        echo $success_message;
                    ?>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
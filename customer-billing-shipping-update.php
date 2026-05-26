<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
$error_message = '';

if (isset($_POST['form1'])) {

    $required_billing = ['cust_b_name', 'cust_b_phone', 'cust_b_country', 'cust_b_address', 'cust_b_city', 'cust_b_state', 'cust_b_zip'];
    $required_shipping = ['cust_s_name', 'cust_s_phone', 'cust_s_country', 'cust_s_address', 'cust_s_city', 'cust_s_state', 'cust_s_zip'];

    $billing_valid = true;
    foreach ($required_billing as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $billing_valid = false;
            break;
        }
    }

    $shipping_valid = true;
    foreach ($required_shipping as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $shipping_valid = false;
            break;
        }
    }

    if (!$billing_valid) {
        $error_message = 'Please fill in all required Billing fields.';
    } elseif (!$shipping_valid) {
        $error_message = 'Please fill in all required Shipping fields.';
    }

    if ($error_message == '') {
        $statement = $pdo->prepare("UPDATE tbl_customer SET 
                                cust_b_name=?, 
                                cust_b_cname=?, 
                                cust_b_phone=?, 
                                cust_b_country=?, 
                                cust_b_address=?, 
                                cust_b_city=?, 
                                cust_b_state=?, 
                                cust_b_zip=?,
                                cust_s_name=?, 
                                cust_s_cname=?, 
                                cust_s_phone=?, 
                                cust_s_country=?, 
                                cust_s_address=?, 
                                cust_s_city=?, 
                                cust_s_state=?, 
                                cust_s_zip=? 

                                WHERE cust_id=?");
        $statement->execute(array(
                                strip_tags($_POST['cust_b_name']),
                                strip_tags($_POST['cust_b_cname']),
                                strip_tags($_POST['cust_b_phone']),
                                strip_tags($_POST['cust_b_country']),
                                strip_tags($_POST['cust_b_address']),
                                strip_tags($_POST['cust_b_city']),
                                strip_tags($_POST['cust_b_state']),
                                strip_tags($_POST['cust_b_zip']),
                                strip_tags($_POST['cust_s_name']),
                                strip_tags($_POST['cust_s_cname']),
                                strip_tags($_POST['cust_s_phone']),
                                strip_tags($_POST['cust_s_country']),
                                strip_tags($_POST['cust_s_address']),
                                strip_tags($_POST['cust_s_city']),
                                strip_tags($_POST['cust_s_state']),
                                strip_tags($_POST['cust_s_zip']),
                                $_SESSION['customer']['cust_id']
                            ));  

        $success_message = LANG_VALUE_122;

        $_SESSION['customer']['cust_b_name'] = strip_tags($_POST['cust_b_name']);
        $_SESSION['customer']['cust_b_cname'] = strip_tags($_POST['cust_b_cname']);
        $_SESSION['customer']['cust_b_phone'] = strip_tags($_POST['cust_b_phone']);
        $_SESSION['customer']['cust_b_country'] = strip_tags($_POST['cust_b_country']);
        $_SESSION['customer']['cust_b_address'] = strip_tags($_POST['cust_b_address']);
        $_SESSION['customer']['cust_b_city'] = strip_tags($_POST['cust_b_city']);
        $_SESSION['customer']['cust_b_state'] = strip_tags($_POST['cust_b_state']);
        $_SESSION['customer']['cust_b_zip'] = strip_tags($_POST['cust_b_zip']);
        $_SESSION['customer']['cust_s_name'] = strip_tags($_POST['cust_s_name']);
        $_SESSION['customer']['cust_s_cname'] = strip_tags($_POST['cust_s_cname']);
        $_SESSION['customer']['cust_s_phone'] = strip_tags($_POST['cust_s_phone']);
        $_SESSION['customer']['cust_s_country'] = strip_tags($_POST['cust_s_country']);
        $_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
        $_SESSION['customer']['cust_s_city'] = strip_tags($_POST['cust_s_city']);
        $_SESSION['customer']['cust_s_state'] = strip_tags($_POST['cust_s_state']);
        $_SESSION['customer']['cust_s_zip'] = strip_tags($_POST['cust_s_zip']);

        header('location: checkout.php');
        exit;
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12"> 
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <?php
                    if($error_message != '') {
                        echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                    }
                    if($success_message != '') {
                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                    }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h3><?php echo LANG_VALUE_86; ?></h3>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_102; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_b_name" value="<?php echo $_SESSION['customer']['cust_b_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_103; ?></label>
                                    <input type="text" class="form-control" name="cust_b_cname" value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_b_phone" value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_106; ?> <span style="color:red;">*</span></label>
                                    <select name="cust_b_country" class="form-control" required>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_b_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_105; ?> <span style="color:red;">*</span></label>
                                    <textarea name="cust_b_address" class="form-control" cols="30" rows="10" style="height:100px;" required><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_107; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_b_city" value="<?php echo $_SESSION['customer']['cust_b_city']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_108; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_b_state" value="<?php echo $_SESSION['customer']['cust_b_state']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_109; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_b_zip" value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3><?php echo LANG_VALUE_87; ?> <label style="font-weight:400;font-size:14px;margin-left:10px;cursor:pointer;"><input type="checkbox" id="same_as_billing"> Same as Billing Address</label></h3>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_102; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_s_name" value="<?php echo $_SESSION['customer']['cust_s_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_103; ?></label>
                                    <input type="text" class="form-control" name="cust_s_cname" value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_s_phone" value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_106; ?> <span style="color:red;">*</span></label>
                                    <select name="cust_s_country" class="form-control" required>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_s_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_105; ?> <span style="color:red;">*</span></label>
                                    <textarea name="cust_s_address" class="form-control" cols="30" rows="10" style="height:100px;" required><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_107; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_s_city" value="<?php echo $_SESSION['customer']['cust_s_city']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_108; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_s_state" value="<?php echo $_SESSION['customer']['cust_s_state']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_109; ?> <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="cust_s_zip" value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update" name="form1">
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<style>
.same-as-billing {
    background-color: #e9ecef;
    cursor: default;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('same_as_billing');
    const billingFields = {
        name: document.querySelector('input[name="cust_b_name"]'),
        cname: document.querySelector('input[name="cust_b_cname"]'),
        phone: document.querySelector('input[name="cust_b_phone"]'),
        country: document.querySelector('select[name="cust_b_country"]'),
        address: document.querySelector('textarea[name="cust_b_address"]'),
        city: document.querySelector('input[name="cust_b_city"]'),
        state: document.querySelector('input[name="cust_b_state"]'),
        zip: document.querySelector('input[name="cust_b_zip"]')
    };
    const shippingFields = {
        name: document.querySelector('input[name="cust_s_name"]'),
        cname: document.querySelector('input[name="cust_s_cname"]'),
        phone: document.querySelector('input[name="cust_s_phone"]'),
        country: document.querySelector('select[name="cust_s_country"]'),
        address: document.querySelector('textarea[name="cust_s_address"]'),
        city: document.querySelector('input[name="cust_s_city"]'),
        state: document.querySelector('input[name="cust_s_state"]'),
        zip: document.querySelector('input[name="cust_s_zip"]')
    };

    function copyBillingToShipping() {
        shippingFields.name.value = billingFields.name.value;
        shippingFields.cname.value = billingFields.cname.value;
        shippingFields.phone.value = billingFields.phone.value;
        shippingFields.country.value = billingFields.country.value;
        shippingFields.address.value = billingFields.address.value;
        shippingFields.city.value = billingFields.city.value;
        shippingFields.state.value = billingFields.state.value;
        shippingFields.zip.value = billingFields.zip.value;
    }

    checkbox.addEventListener('change', function() {
        var checked = this.checked;
        if (checked) {
            copyBillingToShipping();
        }
        Object.values(shippingFields).forEach(function(el) {
            el.classList.toggle('same-as-billing', checked);
        });
    });

    Object.values(billingFields).forEach(function(el) {
        el.addEventListener('input', function() {
            if (checkbox.checked) {
                copyBillingToShipping();
            }
        });
        el.addEventListener('change', function() {
            if (checkbox.checked) {
                copyBillingToShipping();
            }
        });
    });

    document.querySelector('form').addEventListener('submit', function() {
        if (checkbox.checked) {
            copyBillingToShipping();
        }
    });
});
</script>

<?php require_once('footer.php'); ?>
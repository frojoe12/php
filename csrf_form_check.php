<?php
session_start();
$errors = [];
// debug check

if (isset($_POST['csrf_token']) && $_POST['csrf_token']!==$_SESSION['csrf_token']) {
    $errors[]='Invalid CSRF token.';
}
if (isset($_POST['name']) && $_POST['name']!=false && !isset($_POST['csrf_token'])) {
    echo "ATTACKER! 2<br />";
}

// form success check
if (isset($_POST['csrf_token']) && $_POST['csrf_token']===$_SESSION['csrf_token']) {
    $max_time = 60*60; // 1 hour
    if(isset($_SESSION['csrf_token_time'])) {
        if ($max_time + $_SESSION['csrf_token_time'] >=time()) {
            echo "success";
        } else {
            $errors[]='Expired CSRF token.';
        }
    }
}
$token = md5(uniqid(rand(),true));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();

if (count($errors)>0) {
    foreach ($errors as $error) {
        echo "<p class='error'>".$error."</p>";
    }
}
?>
<form action="" method="post">
    Name:
    <input type='text' name='name' />
    <input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
    <br />
    <input type='submit' value='Submit' />
</form>

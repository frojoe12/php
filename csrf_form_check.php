<?php
session_start();

if (isset($_POST['name']) && $_POST['name']!=false ) {
    echo "Name: ".$_POST['name'] . '<br />';
}
if (isset($_POST['csrf_token']) && $_POST['csrf_token']!==$_SESSION['csrf_token']) {
    echo "ATTACKER! 1<br />";
}
if (isset($_POST['name']) && $_POST['name']!=false && !isset($_POST['csrf_token'])) {
    echo "ATTACKER! 2<br />";
}

if (isset($_POST['csrf_token']) && $_POST['csrf_token']===$_SESSION['csrf_token']) {
    $max_time = 60*60*24; // 1 day
    if(isset($_SESSION['csrf_token_time'])) {
        $token_time = $_SESSION['csrf_token_time'];
    }
    if ($max_time + $_SESSION['csrf_token_time'] >=time()) {
        echo "success";
    } else {
        echo "timeout";
    }
}
$token = md5(uniqid(rand(),true));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();

echo $_SESSION['csrf_token'];

?>
<form action="" method="post">
    Name:
    <input type='text' name='name' />
    <input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
    <br />
    <input type='submit' value='Submit' />
</form>

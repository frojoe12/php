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
$token = md5(uniqid(rand(),true));
$_SESSION['csrf_token'] = $token;

echo $_SESSION['csrf_token'];

?>
<form action="" method="post">
    Name:
    <input type='text' name='name' />
    <input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
    <br />
    <input type='submit' value='Submit' />
</form>

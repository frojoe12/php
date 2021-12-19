<?php
$password = 'Pass';
$attempt1 = 'wrong';
$attempt2 = 'Pass';

$password_hash = password_hash($password, PASSWORD_DEFAULT);

echo "Attempt 1: ";
if (password_verify($attempt1,$password_hash)) {
    echo "password ok<br />";
} else {
    echo "INCORRECT<br />";
}

echo "Attempt 2: ";
if (password_verify($attempt2,$password_hash)) {
    echo "password ok<br />";
} else {
    echo "INCORRECT<br />";
}

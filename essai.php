<?php
$a = "idontknow";
$password_hash = password_hash($a, PASSWORD_DEFAULT);
echo $password_hash;
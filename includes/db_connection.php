<?php
$db_host = 'localhost';
$db_name = 'garrettf_FfF';
$db_user = 'garrettf_BigBoi';
$db_pass = 'G@}_6UL;8%%6uuZa';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_error()){
    echo mysqli_connect_error();
    exit;
}

?>
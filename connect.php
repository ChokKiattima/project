<?php
$base_url ="http://localhost/project/little/";

$db_host ="localhost";
$db_user="root";
$db_pass="";
$db_name="datadb";

$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

define('WP','mylogin2024');
<?php

$con = mysqli_connect("localhost", "root", "","admin_db");
if (!$con) {
    die("<script>alert('Connection Failed.')</script>");
}

?>
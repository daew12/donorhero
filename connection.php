<?php
$con=mysqli_connect("localhost","root","","donorhero_db");
if(mysqli_connect_error()){
    echo"<script>Cannot connect to database</script>";
    exit();
}
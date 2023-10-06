<?php
    if( isset($_GET["id"])){
        $id =$_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "customerdb";

    //create connection
    $connection = new mysqli($servername,$username,$password,$database);

    $sql = "DELETE FROM clients WHERE id= $id";
    $connection -> query($sql);

    }
    //redirect customer to index.php 
    header("location: /Customer_Info/index.php");
    exit;
?>
<?php
    $servername = 'localhost:3308';
    $username = 'root';
    $password = '';

    try{
        $conn = new PDO("mysql:host=$servername;dbname=inventoryt",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected";
    }catch(\Exception $e){
        $error_message = $e->getMessage();
    }

?>
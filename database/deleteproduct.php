<?php
    $data = $_POST;
    $id = (int)$data['id'];
    $table = $data['table'];
    

    try{
        $command = "DELETE FROM products WHERE id={$id}";
        include('connection.php');
        $conn->exec($command);

        return json_encode([
            'success' => true,
            'message'=> 'Successfully deleted'
        ]);
    }
    catch(Exception $e){

        return json_encode([
            'success' => false,
            'message'=> $e->getMessage()
        ]);
        
    }
?>
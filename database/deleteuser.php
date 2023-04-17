<?php
    $data = $_POST;
    $user_id = (int)$data['user_id'];
    

    try{
        $command = "DELETE FROM users WHERE id={$user_id}";
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
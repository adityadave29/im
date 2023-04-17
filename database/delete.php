<?php
    $data = $_POST;
    $id = (int)$data['id'];
    $table = $data['table'];

    try{

        include('connection.php');

        if($table === 'suppliers'){
            $supplier_id = $id;
            $command = "DELETE FROM productsuppliers WHERE supplier={$id}";
            $conn->exec($command);
        }

        if($table === 'products'){
            $product_id = $id;
            $command = "DELETE FROM productsuppliers WHERE product={$id}";
            $conn->exec($command);
        }

        $command = "DELETE FROM $table WHERE id={$id}";
        // include('connection.php');
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
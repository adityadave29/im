<?php

    $purchase_orders = $_POST['payload'];
    include('connection.php');

    try{
        foreach($purchase_orders as $po){
            $received = (int) $po['qtyReceived'];
            $status = $po['status'];
            $row_id = $po['id'];
            $qty_ordered = (int) $po['qtyOrdered'];

            $qty_remaining = $qty_ordered - $received;

            $sql = "UPDATE order_product
                            SET 
                            quantity_received=?, status=?, quantity_remaining=?
                            WHERE id=?";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([$received, $status,$qty_remaining, $row_id]);

            $response =[
                'success' => true,
                'message' => ' Successfully added.'
                ];
        }
    }
    catch (\Exception $e){
        $response =[
            'success' => false,
            'message' => ' Successfully Not added.'
            ];
    }

    echo json_encode($response);
?>
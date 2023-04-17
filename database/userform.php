<?php
    session_start();


    include('tablecolumns.php');


    $table_name = $_SESSION['table'];
    // $_SESSION['table'] ='';
    $columns = $table_columns_mapping[$table_name];

    $db_arr = [];
    $user = $_SESSION['user'];
    foreach ($columns as $column){
        if(in_array($column,['created_at','updated_at'])) $value = date('Y-m-d H:i:s');
        else if($column=='created_at') $value = $user['id'];
        else if($column == 'password') $value = password_hash($_POST[$column],PASSWORD_DEFAULT);
        else if ($column == 'img'){
            $target_dir = "../uploads/products/";
            $file_data = $_FILES[$column];
            
            $value = NULL;
            $file_data = $_FILES['img'];

            if($file_data['tmp_name'] !== ''){
                $file_name = $file_data['name'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $file_name = 'product-' . time() . '.' . $file_name;



                $check = getimagesize($file_data['tmp_name']);
                


                if($check){
                    if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)){
                        $value = $file_name;
                    }
                }
            }
        }
        else $value = isset($_POST[$column])? $_POST[$column]:'';

        $db_arr[$column] = $value;
    }
    $table_properties = implode(', ',array_keys($db_arr));
    $table_placeholders = ':' . implode(', :',array_keys($db_arr));

    try{
        $sql = "INSERT INTO
                            $table_name($table_properties)
                        VALUES
                            ($table_placeholders)";

    include('connection.php');

    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr);

    $product_id = $conn->lastInsertId();

    if($table_name === 'products'){
        $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
        if($suppliers){
            foreach($suppliers as $supplier){
                $supplier_data = [
                    'supplier_id'=> $supplier,
                    'product_id' => $product_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $sql = "INSERT INTO productsuppliers 
                                (supplier , product , updated_at , created_at )
                        VALUES
                            (:supplier_id, :product_id, :updated_at, :created_at)";
                            

                $stmt = $conn->prepare($sql);
                $stmt->execute($supplier_data);
            }
            
        }
    }

    $response =[
        'success' => true,
        'message' => ' Successfully added.'
    ];
    }
    catch(Exception $e){
        $response=[    
        'success' => false,
        'message' => $e->getMessage()
        ];
    }
    $_SESSION['response'] = $response;
    header('location: ../'.$_SESSION['redirect_to']);


?>
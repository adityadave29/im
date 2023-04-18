<?php
  session_start();
  if(!isset($_SESSION['user'])) header('Location: login.php');
  
  $show_table = 'products';
//   $product = $_SESSION['product'];
  $products = include('database/show.php');   
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IMS DeskBoard</title>
    <link rel="stylesheet" type="text/css" href="./css/usersadd.css" />
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css"
        integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>



</head>

<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar -->
        <?php include('sidebar/appsidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('sidebar/apptopbar.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">

                        <div class="column column-20">
                            <h1 class="sectionheader">
                                List of Products
                            </h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Stock</th>
                                                <th>Description</th>
                                                <th>Suppliers</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $index => $product) { ?>
                                            <tr>
                                                <td><?= $index+1 ?></td>
                                                <td class="firstName"><img class="productImages"
                                                        src="uploads/products/<?= $product['img']?>"></td>
                                                <td class="lastName"><?= $product['product_name'] ?></td>
                                                <td class="lastName"><?= number_format($product['stock'])?></td>
                                                <td class="email"><?= $product['description'] ?></td>
                                                <td class="email">
                                                    <?php
                                                        $supplier_list = '-';
                                                        $pid = $product['id'];
                                                        
                                                        $stmt = $conn->prepare("SELECT supplier_name FROM suppliers,productsuppliers WHERE productsuppliers.product=$pid AND productsuppliers.supplier=suppliers.id");

                                                        $stmt->execute();
                                                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if($row){
                                                            $supplier_arr = array_column($row,'supplier_name');
                                                            $supplier_list = '<li>'.implode("</li><li>",$supplier_arr); 
                                                        }
                                                        echo $supplier_list;
                                                        ?>
                                                </td>



                                                <td>

                                                    <?php
                                                        $uid = $product['created_by'];
                                                        
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        // var_dump($row);
                                                        $created_by_name = $row['first_name'].' '.$row['last_name'];
                                                        echo $created_by_name;  
                                                    ?>
                                                </td>



                                                <td><?= date('F d,Y @ h A', strtotime($product['created_at'])) ?></td>
                                                <td><?= date('F d,Y @ h A', strtotime($product['updated_at'])) ?></td>
                                                <td>
                                                    <a href="" class="updateproduct" data-pid="<?= $product['id'] ?>"><i
                                                            class="fa fa-pencil"></i> Edit</a>

                                                    <a href="" class="deleteproduct"
                                                        data-name="<?= $product['product_name'] ?>"
                                                        data-pid="<?= $product['id'] ?>"><i class="fa fa-trash"></i>
                                                        Delete</a>
                                                </td>
                                            </tr>
                                            <?php }  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="./js/jquery-3.5.1.min.js"></script>
    <?php
        // $_SESSION['table']='suppliers';
        $show_table = 'suppliers';
        $suppliers = include('database/show.php');
        // var_dump($suppliers);

        $suppliers_arr = [];
        foreach($suppliers as $supplier){
            $suppliers_arr[$supplier['id']] = $supplier['supplier_name'];
            // "<option value=' " . $supplier['id'] ."'>" . $supplier['supplier_name'] . "</option>";
        }

        $suppliers_arr = json_encode($suppliers_arr);
    ?>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js"
        integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <script>
    
        var suppliersList = <?= $suppliers_arr ?>;
        // console.log(suppliersList);
        
        function script() {

            var vm = this;
            this.registerEvents = function() {
                    document.addEventListener('click', function(e) {
                        targetElement = e.target;
                        classList = targetElement.classList;
                        // console.log(classList);
                        if (classList.contains('deleteproduct')) {
                            e.preventDefault();
                            // console.log(targetElement);
                            // return;
                            // console.log('found');

                            pId = targetElement.dataset.pid;
                            pName = targetElement.dataset.name;

                            // console.log(pId, pName);
                            // return false;
                            // console.log(userId);
                            if (window.confirm('Are you sure you want to delete')) {
                                // console.log('will delete');  
                                // alert('hi');
                                $.ajax({
                                    method: 'POST',
                                    data: {
                                        id: pId,
                                        table: 'products'
                                    },
                                    url: './database/delete.php',
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.success) {
                                            if (window.confirm(data.message)) {
                                                location.reload();
                                            }
                                        } else {
                                            window.alert(data.message);
                                        }
                                    }
                                })
                            } else {
                                console.log('will not delete');
                            }
                        }

                        if (classList.contains('updateproduct')) {
                            e.preventDefault();

                            pId = targetElement.dataset.pid;

                            vm.showEditDialog(pId);

                        }
                    });


                    document.addEventListener('submit', function(e) {
                        e.preventDefault();
                        targetElement = e.target;

                        if (targetElement.id === 'editProductForm') {
                            vm.saveUpdateData(targetElement);
                        }
                    })

                },

                this.saveUpdateData = function(form) {
                    $.ajax({
                        method: 'POST',
                        data: new FormData(form),
                        url: 'database/updateproduct.php',
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(data) {

                            BootstrapDialog.alert({
                                type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                message : data.message,
                                callback:function(){
                                    if(data.success) location.reload();
                                }
                            });
                        }

                    });

                },

                vm.showEditDialog = function(id) {

                    $.get('database/getproduct.php', {
                        id: id
                    }, function(productDetails) {
                        
                        let curSuppliers = productDetails['suppliers'];
                        let supplierOption  = '';

                        console.log(suppliersList,curSuppliers);
                        
                        for(const [supId,supName] of Object.entries(suppliersList)) {
                            selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                            supplierOption += "<option " + selected + " value='" + supId + "'>" + supName +"</option>";
                            // supplierOption += "<option value='" + id + "'>" + supName +"</option>";
                        }

                        BootstrapDialog.confirm({
                            title: 'Update ' + productDetails.product_name,
                            message: '\
                                <form action="database/userform.php" method="POST" enctype="multipart/form-data" id="editProductForm"><div class="appFormInputContainer">\
                                    <label for="product_name">Product Name</label>\
                                    <input type="text" id="product_name" value="' + productDetails.product_name +
                                '" name="product_name" placeholder="product name" class="appFormInput">\
                                </div>\
                                <div class="appFormInputContainer">\
                                    <label for="description">Description</label>\
                                </div>\
                                    <textarea class="appFormInput productTextAreaInput"   id="description" name="description" rows="5" cols="95">' +
                                productDetails.description + '</textarea>\
                                <div class="appFormInputContainer">\
                                    <label for="description">Supplier</label>\
                                    <select name="suppliers[]" id="suppliersSelect" multiple="">\
                                        <option value="">Select Supplier</option>\
                                        '+ supplierOption +'\
                                    </select></div>\
                                <div class="appFormInputContainer">\
                                    <label for="img"> Product Image</label>\
                                    <input type="file" name="img">\
                                </div>\
                                <input type="hidden" name="pid" value="'+productDetails.id+'"/>\
                                <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden">\
                                </form>\
                            ',
                            // message: 'Hey',
                            callback: function(isUpdate) {
                                if (isUpdate) {

                                    document.getElementById('editProductSubmitBtn').click();


                                }
                            }

                        });
                    }, 'json');


                }

            this.initialize = function() {
                this.registerEvents();
            }

        }
        var script = new script;
        script.initialize();
    </script>
</body>

</html>
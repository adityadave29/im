<?php
  session_start();
  if(!isset($_SESSION['user'])) header('Location: login.php');
  
  $show_table = 'suppliers';
//   $product = $_SESSION['product'];
  $suppliers = include('database/show.php');   
  
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
                                List of Suppliers
                            </h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier Name</th>
                                                <th>Supplier Location</th>
                                                <th>Email</th>
                                                <th>Products</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($suppliers as $index => $supplier) { ?>
                                            <tr>
                                                <td><?= $index+1 ?></td>
                                                <td>
                                                    <?= $supplier['supplier_name'] ?>
                                                </td>
                                                <td>
                                                    <?= $supplier['supplier_location'] ?>
                                                </td>
                                                <td>
                                                    <?= $supplier['email'] ?>
                                                </td>
                                                <td>
                                                <?php
                                                    $product_list = '-';
                                                    $sid = $supplier['id'];
                                                    
                                                    $stmt = $conn->prepare("SELECT product_name FROM products,productsuppliers WHERE productsuppliers.supplier=$sid AND productsuppliers.product=products.id");

                                                    $stmt->execute();
                                                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    if($row){
                                                        $product_arr = array_column($row,'product_name');
                                                        $product_list = '<li>'.implode("</li><li>",$product_arr); 
                                                    }
                                                    echo $product_list;
                                                    ?>
                                                </td>
                                                



                                                <td>

                                                    <?php
                                                        $uid = $supplier['created_by'];
                                                        
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        // var_dump($row);
                                                        $created_by_name = $row['first_name'].' '.$row['last_name'];
                                                        echo $created_by_name;  
                                                    ?>
                                                </td>



                                                <td><?= date('F d,Y @ h A', strtotime($supplier['created_at'])) ?></td>
                                                <td><?= date('F d,Y @ h A', strtotime($supplier['updated_at'])) ?></td>
                                                <td>
                                                    <a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>"><i
                                                            class="fa fa-pencil"></i> Edit</a>

                                                    <a href="" class="deleteSupplier"
                                                        data-name="<?= $supplier['supplier_name'] ?>"
                                                        data-sid="<?= $supplier['id'] ?>"><i class="fa fa-trash"></i>
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
        $show_table = 'products';
        $products = include('database/show.php');
        // var_dump($suppliers);

        $products_arr = [];
        foreach($products as $product){
            $products_arr[$product['id']] = $product['product_name'];
            // "<option value=' " . $supplier['id'] ."'>" . $supplier['supplier_name'] . "</option>";
        }

        $products_arr = json_encode($products_arr);
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
    
        var productsList = <?= $products_arr ?>;
        // console.log(suppliersList);
        
        function script() {

            var vm = this;
            this.registerEvents = function() {
                    document.addEventListener('click', function(e) {
                        targetElement = e.target;
                        classList = targetElement.classList;
                        if (classList.contains('deleteSupplier')) {
                            e.preventDefault();

                            sId = targetElement.dataset.sid;
                            supplierName = targetElement.dataset.name;

                            if (window.confirm('Are you sure you want to delete')) {
                                $.ajax({
                                    method: 'POST',
                                    data: {
                                        id: sId,
                                        table: 'suppliers'
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

                        if (classList.contains('updateSupplier')) {
                            e.preventDefault();

                            sId = targetElement.dataset.sid;

                            vm.showEditDialog(sId);

                        }
                    });


                    document.addEventListener('submit', function(e) {
                        e.preventDefault();
                        targetElement = e.target;

                        if (targetElement.id === 'editSupplierForm') {
                            vm.saveUpdateData(targetElement);
                        }
                    })

                },

                this.saveUpdateData = function(form) {
                    $.ajax({
                        method: 'POST',
                        data:{
                            supplier_name : document.getElementById('supplier_name').value,
                            supplier_location : document.getElementById('supplier_location').value,
                            email : document.getElementById('email').value,
                            products : $('#products').val(),
                            sid : document.getElementById('sid').value

                        },
                        url: 'database/updatesupplier.php',
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

                    $.get('./database/getsupplier.php', {
                        id: id
                    }, function(supplierDetails) {
                        
                        let curProducts = supplierDetails['products'];
                        let productOptions  = '';
                        
                        for(const [pId,pName] of Object.entries(productsList)) {
                            selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
                            productOptions += "<option " + selected + " value='" + pId + "'>" + pName +"</option>";
                            // supplierOption += "<option value='" + id + "'>" + supName +"</option>";
                        }

                        BootstrapDialog.confirm({
                            title: 'Update ' + supplierDetails.supplier_name,
                            message: '\
                                <form action="database/userform.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\
                                <div class="appFormInputContainer">\
                                        <label for="supplier_name">Supplier Name</label>\
                                        <input type="text" id="supplier_name" name="supplier_name"\
                                           value="'+ supplierDetails.supplier_name+'" placeholder="supplier name" class="appFormInput">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="supplier_location">Location</label>\
                                        <input type="text" id="supplier_location" name="supplier_location"\
                                        value="'+ supplierDetails.supplier_location+'" placeholder="supplier location name" class="appFormInput">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="email">Email</label>\
                                        <input type="text" id="email" name="email"\
                                        value="'+ supplierDetails.email+'"placeholder="email" class="appFormInput">\
                                    </div>\
                                <div class="appFormInputContainer">\
                                    <label for="products">Select Products</label>\
                                    <select name="products[]" id="products" multiple="">\
                                        <option value="">Products</option>\
                                        '+ productOptions +'\
                                    </select></div>\
                                </div>\
                                <input type="hidden" name="sid" id="sid" value="'+supplierDetails.id+'"/>\
                                <input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden">\
                                </form>\
                            ',
                            // message: 'Hey',
                            callback: function(isUpdate) {
                                if (isUpdate) {

                                    document.getElementById('editSupplierSubmitBtn').click();


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
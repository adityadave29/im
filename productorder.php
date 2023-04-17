<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

//   $users = include('database/showusers.php');

$show_table = 'products';
$products = include 'database/show.php';
$products = json_encode($products);
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
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>

<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar -->
        <?php include 'sidebar/appsidebar.php'?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include 'sidebar/apptopbar.php'?>
            <div class="dashboard_content">

                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <div>
                                <form action="database/saveorder.php" method="POST">
                                     <div class="alignRight">
                                        <button type="button" class="orderBtn orderProductBtn" id="orderProductBtn">Add New Product Order</button>
                                    </div>
                                    <div id="orderProductLists">
                                        <p id="noData" style="color: #9f9f9f;">No Products selected</p >
                                    </div>
                                
                                    </div>
                                    <div class="alignRight">
                                        <button type="submit" class="orderBtn submitorderProductBtn">Submit Order</button>
                                    </div>  
                            </form>
                            <?php if(isset($_SESSION['response'])){ 
                            $response_message = $_SESSION['response']['message'];
                            $is_success = $_SESSION['response']['success'];
                        ?>
                                <div class="responseMessage">
                                    <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                        <?= $response_message?>

                                    </p>
                                </div>
                                <?php unset($_SESSION['response']); } ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script>
        var products = <?=$products?>;
        var counter = 0;

        function script(){

            var vm = this;


            let productOptions ='\
                <div>\
                    <label for="product_name"> Product Name</label>\
                        <Select name="products[]" class="productNameSelect" id="product_name" />\
                        <option value=""> Select Product</option>\
                        INSERTPRODUCTHERE\
                        </select>\
                        <button class="removeOrderBtn">remove</button>\
                </div>\
                ';

            this.initialize = function(){
                this.registerEvents();
                this.renderProductOptions();
            },

            this.renderProductOptions = function(){
                // console.log(products);
                let optionHtml='';
                products.forEach((product) => {
                    optionHtml+= '<option value="'+product.id+'">'+product.product_name+'</option>';
                })
                console.log(optionHtml);
                productOptions = productOptions.replace('INSERTPRODUCTHERE',optionHtml);
            },


            this.registerEvents = function(){
                document.addEventListener('click', function(e) {
                    targetElement = e.target;
                    classList = targetElement.classList;


                    if (targetElement.id === 'orderProductBtn') {
                        // e.preventDefault();
                        document.getElementById('noData').style.display = 'none';
                        let orderProductListsContainer = document.getElementById('orderProductLists');
                        // orderProductListsContainer.innerHtml='';


                        orderProductLists.innerHTML += '\
                            <div class="orderProductRow">\
                                '+productOptions+'\
                                <div class="suppliersRow" id="supplierRows_'+counter+'"data-counter="'+counter+'"></div>\
                            </div>';
                        counter++;

                    }
                    if(targetElement.classList.contains('removeOrderBtn')){
                        let orderRow = targetElement.closest('div.orderProductRow').remove();

                        // console.log('OrderRow'); 
                    }
                });

                document.addEventListener('change', function(e) {
                    targetElement = e.target;
                    classList = targetElement.classList;


                    if(classList.contains('productNameSelect')){
                        let pid = targetElement.value;

                        let counterId = (targetElement.closest('div.orderProductRow').querySelector('.suppliersRow').dataset.counter);
                        // console.log(counterId);
                        $.get('database/getproductsuppliers.php',{id:pid},function(suppliers){
                            vm.renderSuppliersRows(suppliers,counterId);
                            // console.log(suppliers);
                        },'json');
                    }
                });
        },

        this.renderSuppliersRows = function(suppliers,counterId){
            let supplierRows = '';

            suppliers.forEach((supplier) =>{
                supplierRows += '\
                    <div class="row">\
                    <div style="width : 50%">\
                        <p class="supplierName">'+ supplier.supplier_name +'</p>\
                    </div>\
                    <div style="width : 50%">\
                        <label for="quantity">Quantity : </label>\
                        <input type="number" class="appFormInput" class="orderProductQty" id="quantity" placeholder="quantity" name="quantity['+ counterId +']['+ supplier.id +']"/>\
                    </div>\
                </div>';
            });


            let supplierRowContainer = document.getElementById('supplierRows_'+ counterId);
            supplierRowContainer.innerHTML = supplierRows;
        }
    }

    (new script()).initialize();
</script>
</body>

</html>
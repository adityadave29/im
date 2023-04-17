<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

$show_table = 'suppliers';
//   $product = $_SESSION['product'];
$suppliers = include 'database/show.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Order</title>
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
        <?php include 'sidebar/appsidebar.php'?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include 'sidebar/apptopbar.php'?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">

                        <div class="column column-20">
                            <h1 class="sectionheader">
                                List of Purchase Orders
                            </h1>
                            <div class="section_content">
                            <div class="users"> 
                                <div class="poListContainers">
                                    <?php
                                        $stmt = $conn->prepare("SELECT order_product.id,products.product_name, order_product.quantity_ordered,order_product.quantity_received, order_product.batch, users.first_name,users.last_name, suppliers.supplier_name, order_product.status, order_product.created_at FROM order_product,suppliers,products,users WHERE order_product.product=products.id AND order_product.supplier=suppliers.id AND order_product.created_by = users.id ORDER BY order_product.created_at DESC");

                                        $stmt->execute();
                                        $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $data = [];
                                        foreach ($purchase_orders as $purchase_order){
                                            $data[$purchase_order['batch']][] = $purchase_order;
                                        }

                                    ?>
                                    <?php
                                        foreach($data as $batch_id => $batch_pos){
                                    ?>
                                    <div class="poList" id="container-<?= $batch_id ?>">
                                        <p> Batch #: <?= $batch_id ?></p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Qty Ordered</th>
                                                    <th>Qty Received</th>
                                                    <th>Supplier</th>
                                                    <th>Status</th>
                                                    <th>Ordered By</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($batch_pos as $index => $batch_po) {
                                                ?>
                                                <tr>
                                                    <td><?= $index+1 ?></td>
                                                    <td class="po_product"><?= $batch_po['product_name'] ?></td>
                                                    <td class="po_qty_ordered"><?= $batch_po['quantity_ordered'] ?></td>
                                                    <td class="po_qty_received"><?= $batch_po['quantity_received'] ?></td>
                                                    <td class="po_qty_supplier"><?= $batch_po['supplier_name'] ?></td>
                                                    <td class="po_qty_status"><span class="po-badge po-badge-<?=$batch_po['status']?>"><?= $batch_po['status'] ?></span></td>
                                                    <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name'] ?></td>
                                                    <td>
                                                        <?= $batch_po['created_at'] ?>
                                                        <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="poOrderUpdateBtnContainer alignRight">
                                            <button class="appBtn updatePoBtn" data-id="<?= $batch_id ?>">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="./js/jquery-3.5.1.min.js"></script>
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

        // console.log(suppliersList);

        function script() {

            var vm = this;
            this.registerEvents = function() {
                document.addEventListener('click', function(e) {
                        targetElement = e.target;
                        classList = targetElement.classList;
                        // console.log(classList);
                        if (classList.contains('updatePoBtn')) {
                            e.preventDefault();

                            
                            batchNumberContainer =  'container-'+ targetElement.dataset.id;
                            
                            console.log(batchNumberContainer);
                            
                            productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
                            qtyOrderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
                            qtyReceivedList = document.querySelectorAll('#' + batchNumberContainer + '.po_qty_received');
                            supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
                            statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');

                            // console.log(productList,qtyOrderedList,qtyReceivedList,supplierList,statusList);

                            poListsArr = [];

                            for(i=0;i<productList.length;i++) {
                                poListsArr.push({
                                    name: productList[i].innerText,
                                    qtyOrdered: qtyOrderedList[i].innerText,
                                    qtyReceived: qtyReceivedList[i],
                                    supplier: supplierList[i].innerText,
                                    status: statusList[i].innerText,
                                });
                            }   

                            // productList.forEach((product,key) => {
                            //     poListsArr[key]['product'] = product.innerText;
                            //     // console.log(key);
                            // });

                            var poListHtml = '<table>\
                                                <thead>\
                                                    <tr>\
                                                        <th>Product Name</th>\
                                                        <th>Qty Ordered</th>\
                                                        <th>Qty Received</th>\
                                                        <th>Supplier</th>\
                                                        <th>Status</th>\
                                                    </tr>\
                                                </thead>\
                                            <tbody>';


                            poListsArr.forEach((poList) => {
                                poListHtml += '\
                                <tr>\
                                    <td class="po_product alignLeft">'+ poList.name+ '</td>\
                                    <td class="po_qty_ordered">'+ poList.qtyOrdered+ '</td>\
                                    <td class="po_qty_ordered"><input type="number" value="'+ poList.qtyReceived+ '"/></td>\
                                    <td class="po_qty_supplier">'+ poList.supplier+ '</td>\
                                    <td>\
                                         <select>\
                                            <option value="pending" '+(poList.status == 'pending' ? 'selected' : '') + '>pending</option>\
                                            <option value="complete" '+(poList.status == 'complete' ? 'selected' : '') + '>complete</option>\
                                         </select>\
                                        <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">\
                                    </td>\
                                </tr>';

                                
                            });

                            poListHtml+='</tbody></table>';

                            console.log(poListHtml);
    
                            // console.log(poListHtml);
                            // alert('hi');
                            // return;
                            // return;
                            // return;
                            // pName = targetElement.dataset.name;

                            // console.log(userId);
                            
                            BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_PRIMARY,
                                title: 'Update',
                                message: poListHtml
                                // callback: function(isDelete){
                                //     is(isDelete){
                                //         $.ajax({
                                //             method: 'POST',
                                //             data:{
                                //                 id:pId,
                                //                 table:'products'
                                //             },
                                //             url: './database/delete.php',
                                //             dataType: 'json',
                                //             success: function(data){
                                //                 message = data.success ? 'sd' : 'Ed';

                                //                 BootstrapDialog.alert({
                                //                     type: data.success? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                //                     message : message,
                                //                     callback: function(){
                                //                         if(data.success) location.reload();
                                //                     }
                                //                 });
                                //             }
                                //         });
                                //     }
                                // }
                            });
                            
                        }

                    });
            },

            this.initialize = function() {
                this.registerEvents();
            }
        }
        var script = new script;
        script.initialize();
    </script>
</body>

</html>
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
                                        $stmt = $conn->prepare("SELECT order_product.id,order_product.product,products.product_name, order_product.quantity_ordered,order_product.quantity_received, order_product.batch, users.first_name,users.last_name, suppliers.supplier_name, order_product.status, order_product.created_at FROM order_product,suppliers,products,users WHERE order_product.product=products.id AND order_product.supplier=suppliers.id AND order_product.created_by = users.id ORDER BY order_product.created_at DESC");

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
                                                    <th>Delivery History</th>
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
                                                        <input type="hidden" class="po_qty_productid" value="<?= $batch_po['product'] ?>">
                                                    </td>
                                                    <td>
                                                        <button class="appbtn appDeliveryHistory" data-id="<?= $batch_po['id'] ?>">
                                                            Deliveries
                                                        </button>
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

                            batchNumber = targetElement.dataset.id;
                            batchNumberContainer =  'container-'+ batchNumber;
                            
                            // console.log(batchNumberContainer);
                            
                            productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
                            qtyOrderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
                            qtyReceivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
                            supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
                            statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');
                            rowIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_row_id');
                            pIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_productid');
                            

                            // console.log(productList,qtyOrderedList,qtyReceivedList,supplierList,statusList);

                            poListsArr = [];

                            for(i=0;i<productList.length;i++) {
                                poListsArr.push({
                                    name: productList[i].innerText,
                                    qtyOrdered: qtyOrderedList[i].innerText,
                                    qtyReceived: qtyReceivedList[i].innerText,
                                    supplier: supplierList[i].innerText,
                                    status: statusList[i].innerText,
                                    id: rowIds[i].value,
                                    pid: pIds[i].value
                                });
                            }   

                            // productList.forEach((product,key) => {
                            //     poListsArr[key]['product'] = product.innerText;
                            //     // console.log(key);
                            // });

                            // poListsArr.forEach((poList) => {
                            //     console.log(poList);
                            // });

                            // return;

                            // console.log(poListsArr);
                            // return;

                            var poListHtml = '<table id="formTable_'+batchNumber+'">\
                                                <thead>\
                                                    <tr>\
                                                        <th>Product Name</th>\
                                                        <th>Qty Ordered</th>\
                                                        <th>Qty Received</th>\
                                                        <th>Qty Delivered</th>\
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
                                        <td class="po_qty_received">'+ poList.qtyReceived+ '</td>\
                                        <td class="po_qty_delivered"><input type="number" value="0"/></td>\
                                        <td class="po_qty_supplier">'+ poList.supplier+ '</td>\
                                        <td>\
                                            <select class="po_qty_status">\
                                                <option value="pending" '+(poList.status == 'pending' ? 'selected' : '') + '>pending</option>\
                                                <option value="incomplete" '+(poList.status == 'incomplete' ? 'selected' : '') + '>incomplete</option>\
                                                <option value="complete" '+(poList.status == 'complete' ? 'selected' : '') + '>complete</option>\
                                            </select>\
                                            <input type="hidden" class="po_qty_row_id" value="'+poList.id+'">\
                                            <input type="hidden" class="po_qty_pid" value="'+poList.pid+'">\
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
                            pName = targetElement.dataset.name;

                            // console.log(userId);
                            
                            BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_PRIMARY,
                                title: 'Update',
                                message: poListHtml,
                                callback: function(toAdd){
                                    if(toAdd){

                                        formTableContainer = 'formTable_'+batchNumber;

                                        qtyReceivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received');
                                        qtyDeliveredList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_delivered input');
                                        statusList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_status');
                                        rowIds = document.querySelectorAll('#' + formTableContainer + ' .po_qty_row_id');
                                        qtyOrdered = document.querySelectorAll('#' + formTableContainer + ' .po_qty_ordered');
                                        pids = document.querySelectorAll('#' + formTableContainer + ' .po_qty_pid');
                                        

                                        // console.log(qtyReceivedList,statusList,rowIds);

                                        poListsArrForm = [];    

                                        for(i=0;i<qtyDeliveredList.length;i++) {
                                            poListsArrForm.push({
                                                qtyReceive:qtyReceivedList[i].innerText,
                                                qtyDelivered: qtyDeliveredList[i].value,
                                                status: statusList[i].value,
                                                id: rowIds[i].value,
                                                qtyOrdered: qtyOrdered[i].innerText,
                                                pid : pids[i].value
                                            });
                                        }   
                                        // console.log(poListsArrForm);
                                        // return;
                                        $.ajax({
                                            method: 'POST',
                                            data:{
                                                payload : poListsArrForm
                                            },
                                            url: 'database/updateorder.php',
                                            dataType: 'json',
                                            success: function(data){
                                                message = data.message;

                                                BootstrapDialog.alert({
                                                    type: data.success? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                    message : message,
                                                    callback: function(){
                                                        if(data.success) location.reload();
                                                    }
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                            
                        }

                        if(classList.contains('appDeliveryHistory')){
                            // alert('hi');
                            let id = targetElement.dataset.id;
                            
                            $.get('database/viewdeliveryhistory.php',{id:id},function(data){
                                if(data.length){

                                    rows = '';
                                    data.forEach((row,id) => {
                                        receivedDate = new Date(row['date_received']);
                                        rows+='\
                                            <tr>\
                                                <td>'+(id+1)+'</td>\
                                                <td>'+ receivedDate.toUTCString() + ' ' + receivedDate.getUTCHours() + ':' + receivedDate.getUTCMinutes()+'</td>\
                                                <td>'+row['qty_received']+'</td>\
                                            </tr>\
                                        ';  
                                    });

                                    deliveryHistoryHtml = '<table class="deliveryHistoryTable">\
                                    <thead>\
                                        <tr>\
                                            <th>#</th>\
                                            <th>Date Received</th>\
                                            <th>Quantity Received</th>\
                                        </tr>\
                                        </thead>\
                                        <tbody>\
                                            '+rows+'\
                                        </tbody>\
                                    </table>\
                                    ';

                                    BootstrapDialog.show({
                                        title:'<strong>Delivery Histories</strong>',
                                        type: BootstrapDialog.TYPE_PRIMARY,
                                        message: deliveryHistoryHtml
                                    }); 
                                }
                                else{
                                    BootstrapDialog.show({
                                        title:'<strong>No Delivery Histories</strong>',
                                        type: BootstrapDialog.TYPE_INFO,
                                        message: "NO HISTORY FOUND"
                                    }); 
                                }
                            },'json');
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
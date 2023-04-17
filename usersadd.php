<?php
  session_start();
  if(!isset($_SESSION['user'])) header('Location: login.php');
  $_SESSION['table']='users';
  $_SESSION['redirect_to']='usersadd.php';
  
  $show_table = 'users';
  $users = include('database/show.php');   
  
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
        <?php include('sidebar/appsidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('sidebar/apptopbar.php') ?>
            <div class="dashboard_content">

                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <div id="userAddFormContainer">
                                <form action="database/userform.php" method="POST" class="appForm" id="userAddForm">
                                    <div class="appFormInputContainer">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" name="first_name" placeholder="first name"
                                            class="appFormInput">
                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" placeholder="last name"
                                            class="appFormInput">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" placeholder="email id"
                                            class="appFormInput">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" placeholder="password"
                                            class="appFormInput">
                                    </div>
                                    <!-- <input type="hidden" name="table" value="users"> -->
                                    <button type="submit" class="appBtn">Add User</button>

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
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>

    <script>
    function script() {
        this.initialize = function() {
                this.registerEvents();
            },

            this.registerEvents = function() {
                document.addEventListener('click', function(e) {
                    targetElement = e.target;
                    classList = targetElement.classList;
                    // console.log(classList);
                    if (classList.contains('deleteuser')) {
                        e.preventDefault();
                        // console.log('found');
                        userId = targetElement.dataset.userid;
                        fname = targetElement.dataset.fname;
                        lname = targetElement.dataset.lname;
                        fullName = fname + ' ' + lname;
                        // console.log(userId);
                        if (window.confirm('Are you sure you want to delete')) {
                            console.log('will delete');
                            $.ajax({
                                method: 'POST',
                                data: {
                                    user_id: userId,
                                    f_name: fname,
                                    l_name: lname
                                },
                                url: 'database/deleteuser.php',
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

                    // if(classList.contains('updateuser')){
                    //   e.preventDefault();
                    //   // alert('Editing');
                    //   firstName = targetElement.closest('tr').querySelector('td.firstName').innerHTML;
                    //   lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
                    //   email = targetElement.closest('tr').querySelector('td.email').innerHTML;

                    //   console.log(firstName, lastName, email);

                    //   window.confirm({
                    //     title: 'Update' + firstName + ' ' + lastName,
                    //     message: 'Hello'
                    //   }) 

                    // } 

                });


            }


    }
    var script = new script;
    script.initialize();
    </script>
</body>

</html>
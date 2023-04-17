<?php
  session_start();
  if(!isset($_SESSION['user'])) header('Location: login.php');
  $_SESSION['table']='users';
  $user = $_SESSION['user'];
  $show_table = 'users';
  $users = include('database/showusers.php');   
  
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

                        <div class="column column-20">
                            <h1 class="sectionheader">
                                List of Users
                            </h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $index => $user) { ?>
                                            <tr>
                                                <td><?= $index+1 ?></td>
                                                <td class="firstName"><?= $user['first_name'] ?></td>
                                                <td class="lastName"><?= $user['last_name'] ?></td>
                                                <td class="email"><?= $user['email'] ?></td>
                                                <td><?= date('F d,Y @ h A', strtotime($user['created_at'])) ?></td>
                                                <td><?= date('F d,Y @ h A', strtotime($user['updated_at'])) ?></td>
                                                <td>
                                                    <a href="" class="updateuser"><i class="fa fa-pencil"></i> Edit</a>

                                                    <a href="" class="deleteuser" data-userid="<?= $user['id'] ?>"
                                                        data-fname="<?= $user['first_name'] ?>"
                                                        data-lname="<?= $user['last_name'] ?>"><i
                                                            class="fa fa-trash"></i>
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
                                    id: userId,
                                    table:'users'
                                },
                                url: 'database/delete.php',
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
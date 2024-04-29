<?php
// Include your MySQL connection configuration file
include 'config.php';

// Start the session
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Check if the logged-in user is not an admin, redirect to index.php
if ($_SESSION['priority'] !== 'admin') {
    header("Location: index.php");
    exit();
}




// Check if the request is for deleting a user
if (isset($_GET['action']) && $_GET['action'] === 'deleteUser') {
    // Check if user ID is provided
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        // Query to delete user from the users table
        $sql = "DELETE FROM users WHERE id = $userId";
        if ($conn->query($sql) === TRUE) {
            // User deleted successfully
            echo 'User deleted successfully.';
        } else {
            // Error occurred while deleting user
            echo 'Error: ' . $sql . '<br>' . $conn->error;
        }
    } else {
        // User ID not provided
        echo 'User ID not provided.';
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>

    <style>
        /* Center the table and add space around it */
        .table-container {
            margin: 20px auto; /* Center the table horizontally with 20px margin around it */
            padding: 20px; /* Add padding around the table */
            max-width: 90%; /* Limit the maximum width of the table */
            border: 1px solid #ccc; /* Add an outline around the table */
            border-radius: 10px; /* Add rounded corners to the outline */
        }

        .table-container h2{
            text-align:center;
            background:#1844bd;
            padding:10px;
            border-radius:5px;
            color:#fff;
        }

        /* Ensure the table is fully responsive */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2>USERS TABLE         
                <a class="btn btn-dark text-light ms-5" href="#" data-bs-toggle="modal" data-bs-target=
                "#addUserModal">Add user +</a>
                <a class="btn btn-success text-light ms-2" href="admintable.php">Logbook Table</a>
                <a class="btn btn-danger text-light ms-2"href="logout.php">Logout</a>


            </h2>
            <div class="table-responsive">
                <table id="usersTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Actions</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to fetch data from the users table
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['password'] . "</td>";
                                echo '<td>
                                <a href="#" class="me-3 edituser hide-icons" title="Edit" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="GetDetails('. $row['id'] .')"><i class="fas fa-edit text-dark"></i></a>
                                <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DeleteUser(' . $row['id'] . ')"><i class="fas fa-trash-alt text-danger"></i></a>
                                    </td>';
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



             <!-- section -->
    <div class="container pt-5">
        <div class="table-container">
            <h2>DEVICES TABLE         
                <a class="btn btn-dark text-light ms-5" href="#" data-bs-toggle="modal" data-bs-target=
                "#addDeviceModal">Add device +</a>
                <a class="btn btn-success text-light ms-2" href="admintable.php">Logbook Table</a>
                <a class="btn btn-danger text-light ms-2"href="logout.php">Logout</a>


            </h2>
            <div class="table-responsive">
                <table id="deviceTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device Name</th>
                            <th>Actions</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to fetch data from the users table
                        $sql = "SELECT * FROM device";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['device_name'] . "</td>";
                                echo '<td>
                                <a href="#" class="me-3 edituser hide-icons" title="Edit" data-bs-toggle="modal" data-bs-target="#editDeviceModal" onclick="GetDevice('. $row['id'] .')"><i class="fas fa-edit text-dark"></i></a>
                                <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DeleteUser(' . $row['id'] . ')"><i class="fas fa-trash-alt text-danger"></i></a>
                                    </td>';
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

                                       <!-- MODALS FOR ADMMIN PAGE -->

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <input type="hidden" name="userId" id="userId">

                    <div class="mb-3">
                        <label for="addUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="addUsername" name="addUsername" required>
                    </div>

                    <div class="mb-3">
                        <label for="addPassword" class="form-label">Password</label>
                        <input type="text" class="form-control" id="addPassword" name="addPassword" required>
                    </div>

                    <!-- Add other form fields as needed -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="adduser()" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

   <!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" name="userId" id="userId">

                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="editUsername" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="text" class="form-control" id="editPassword" name="editPassword" required>
                    </div>

                    <!-- Add other form fields as needed -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="updateDetails()" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Device Modal -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeviceModalLabel">Edit Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <input type="hidden" name="deviceId" id="deviceId">

                    <div class="mb-3">
                        <label for="addDevicename" class="form-label">Device Name</label>
                        <input type="text" class="form-control" id="addDevicename" name="addDevicename" required>
                    </div>

                    <!-- Add other form fields as needed -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="add_device()" class="btn btn-primary">Add Device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Device Modal -->
<div class="modal fade" id="editDeviceModal" tabindex="-1" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeviceModalLabel">Edit Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDeviceForm">
                    <input type="hidden" name="deviceId" id="deviceId">

                    <div class="mb-3">
                        <label for="editDevicename" class="form-label">Devicename</label>
                        <input type="text" class="form-control" id="editDevicename" name="editDevicename" required>
                    </div>

                    <!-- Add other form fields as needed -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="updateDevice()" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

<script>

        $(document).ready(function() {
            $('#usersTable').DataTable({
                responsive: true
            });
        });

        $(document).ready(function() {
            $('#deviceTable').DataTable({
                responsive: true
            });
        });



           // Update user function
   function GetDetails(updateid){
      $('#userId').val(updateid);

      $.post("update_user.php",{updateid:updateid},function(data,status){
         var userid=JSON.parse(data);
         $('#editUsername').val(userid.username);
         $('#editPassword').val(userid.password);
      });

         $('#editUserModal').modal('show');
   }

   function updateDetails() {
    var editUsername = $('#editUsername').val();
    var editPassword = $('#editPassword').val();
    var userId = $('#userId').val();

    $.post("update_user.php", {
        editUsername: editUsername,
        editPassword: editPassword,
        userId: userId
    }, function(data, status) {
        $('#editUserModal').modal('hide');
        // Reload the page after a short delay to ensure the changes are applied
        setTimeout(function() {
            location.reload();
        }, 500); // Adjust the delay time as needed
    }).fail(function(xhr, status, error) {
        // Display error message if the AJAX request fails
        alert('Error updating user details: ' + error);
    });
};




// Add user
function adduser(){
       var usernameAdd=$('#addUsername').val();
       var passwordAdd=$('#addPassword').val();

       $.ajax({
           url:"add_user.php",
           type:'post',
           data:{
              usernameSend:usernameAdd,
              passwordSend:passwordAdd

            
              
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#addUserModal').modal('hide');
                location.reload();//refreshes the page
            }
        });
  }




//   Delete user
function DeleteUser(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this user?");
    if (confirmation) {
        $.ajax({
            url: "del_user.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                location.reload();
            }
        });
    }
}



// Add Device
function add_device(){
       var devicenameAdd=$('#addDevicename').val();

       $.ajax({
           url:"add_device.php",
           type:'post',
           data:{
              devicenameSend:devicenameAdd,
              
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#addDeviceModal').modal('hide');
                location.reload();//refreshes the page
            }
        });
  }



//   Edit Device
function GetDevice(updateid){
      $('#deviceId').val(updateid);

      $.post("update_device.php",{updateid:updateid},function(data,status){
         var userid=JSON.parse(data);
         $('#editDevicename').val(userid.device_name);
      });

         $('#editDeviceModal').modal('show');
   }

   function updateDevice() {
    var editDevicename = $('#editDevicename').val();
    var deviceId = $('#deviceId').val();

    $.post("update_device.php", {
        editDevicename: editDevicename,
        deviceId: deviceId
    }, function(data, status) {
        $('#editDeviceModal').modal('hide');
        // Reload the page after a short delay to ensure the changes are applied
        setTimeout(function() {
            location.reload();
        }, 500); // Adjust the delay time as needed
    }).fail(function(xhr, status, error) {
        // Display error message if the AJAX request fails
        alert('Error updating user details: ' + error);
    });
};



    </script>
</body>
</html>

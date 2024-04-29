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

// Check if the delete button is clicked and a row ID is provided
if (isset($_POST['delete_id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    // SQL query to delete the row from the database
    $sql = "DELETE FROM logbook WHERE id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        // Row deleted successfully
        // echo "Row deleted successfully!";
    } else {
        // Error occurred while deleting row
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook Table</title>
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>

    <!-- Boxicons -->
   <!-- <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'> -->
	

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
        .action-buttons {
            white-space: nowrap;
        }

    </style>
</head>
<body>
   <div class="container">
        <div class="table-container">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <div class="table-responsive">
                    <table id="logbookTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Department</th>
                                <th>Issue Reported</th>
                                <th>Device Type</th>
                                <th>Brand Name</th>
                                <th>Machine Model</th>
                                <th>Serial Number</th>
                                <th>Received By</th>
                                <th>Additional Items</th>
                                <th>Hypothesis</th>
                                <th>Wikihow</th>
                                <th>Status</th>
                                <th>Handled By</th>
                                <th>Date Fixed</th>
                                <th>Date Taken</th>
                                <th>Actions</th> <!-- New column for edit and delete buttons -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include your MySQL connection configuration file
                            include 'config.php';

                            // Query to fetch data from the logbook table
                            $sql = "SELECT * FROM logbook";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['contact'] . "</td>";
                                    echo "<td>" . $row['department'] . "</td>";
                                    echo "<td>" . $row['issue_reported'] . "</td>";
                                    echo "<td>" . $row['device_type'] . "</td>";
                                    echo "<td>" . $row['brand_name'] . "</td>";
                                    echo "<td>" . $row['machine_model'] . "</td>";
                                    echo "<td>" . $row['serial_number'] . "</td>";
                                    echo "<td>" . $row['received_by'] . "</td>";
                                    echo "<td>" . $row['additional_items'] . "</td>";
                                    echo "<td>" . $row['hypothesis'] . "</td>";
                                    echo "<td>" . $row['wikihow'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "<td>" . $row['handled_by'] . "</td>";
                                    echo "<td>" . $row['date_fixed'] . "</td>";
                                    echo "<td>" . $row['date_taken'] . "</td>";
                                    // Edit and delete buttons
                                    echo "<td class='action-buttons'>";
                                    echo "<a href='edit-logbook.php?id=" . $row['id'] . "' class='me-3' title='Edit'><i class='fas fa-edit text-dark'></i></a>";
                                    echo "<a href='#' class='me-3' title='Delete' onclick='confirmDelete(" . $row['id'] . ")'><i class='fas fa-trash-alt text-danger'></i></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }

                            // Close MySQL connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
       </div>
     </div>
    </div>




    <!-- <script src="../js/jquery-3.6.4.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    
    <!-- buttons -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>

    <script>
      new DataTable('#logbookTable', {
        layout: {
        topStart: {
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
      }
     });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this row?')) {
                // If user confirms deletion, submit the form with delete_id parameter
                var form = $('<form action="" method="post">' +
                    '<input type="hidden" name="delete_id" value="' + id + '" />' +
                    '</form>');
                $('body').append(form);
                form.submit();
            }
        }

        $(document).ready(function() {
            // Attach click event to edit buttons
            $('.edit-btn').click(function() {
                var id = $(this).data('id');
                window.location.href = 'edit-logbook.php?id=' + id;
            });
        });

    </script>
</body>
</html>



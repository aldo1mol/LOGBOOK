 <?php
// session_start();

// if(isset($_SESSION['username'])){
//     echo "Welcome, ".$_SESSION['username']."!";
//     echo "<br><br><a href='logout.php'>Logout</a>";
// } else {
//     header("Location: index.php");
//     exit();
// }

include 'config.php';


session_start();

if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $date = $_POST['date'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $department = $_POST['department'];
    $issue_reported = $_POST['issue_reported'];
    $device_type = $_POST['device_type'];
    $brand_name = $_POST['brand_name'];
    $machine_model = $_POST['machine_model'];
    $serial_number = $_POST['serial_number'];
    $received_by = $_POST['received_by'];
    $additional_items = $_POST['additional_items'];
    $hypothesis = $_POST['hypothesis'];
    $wikihow = $_POST['wikihow'];
    $status = $_POST['status'];
    $handled_by = $_POST['handled_by'];
    $date_fixed = $_POST['date_fixed'];
    $date_taken = $_POST['date_taken'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO logbook (`date`, `name`, contact, department, issue_reported, device_type, brand_name, machine_model, serial_number, received_by, additional_items, hypothesis, wikihow, `status`, handled_by, date_fixed, date_taken) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssssss", $date, $name, $contact, $department, $issue_reported, $device_type, $brand_name, $machine_model, $serial_number, $received_by, $additional_items, $hypothesis, $wikihow, $status, $handled_by, $date_fixed, $date_taken);
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        echo '<script>alert("Form submitted successfully!");</script>';
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '");</script>';
    }

    // Close statement
    $stmt->close();
}


// Fetch handled by options from the users table
$handledByOptions = array();
$sql = "SELECT username FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $handledByOptions[] = $row['username'];
    }
}

// Fetch device_name options from the users table
$deviceOptions = array();
$sql = "SELECT device_name FROM device";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $deviceOptions[] = $row['device_name'];
    }
}

// Fetch device_brand options from the users table
$brandOptions = array();
$sql = "SELECT device_brand FROM brand";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $brandOptions[] = $row['device_brand'];
    }
}


// Fetch status_type options from the status table
$statusOptions = array();
$sql = "SELECT status_type FROM `status`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusOptions[] = $row['status_type'];
    }
}

// Close MySQL connection
$conn->close();
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>logbook form</title>
    <link rel="stylesheet" href="logbookform.css">
</head>
<body>
    <form action="" method="post" class="logbook-form">
        <div class="form-header">
            <h1>LOGBOOK FORM</h1>
            <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
            <div id="responseMessage" style="display: none;"></div>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="input-group">
                    <label>Date</label>
                    <input type="date" name="date" id="date" required>
                </div>
                <div class="input-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>

            </div>

            <div class="row">
            <div class="input-group">
                <label>Contact</label>
                <input type="tel" name="contact" id="contact" pattern="[0-9]{10}" maxlength="10" placeholder="Enter 10-digit contact number" required>
            </div>

                <div class="input-group">
                    <label for="">Department</label>
                    <input type="text" name="department" id="department" required>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Issue Reported</label>
                    <textarea name="issue_reported" id="issue_reported"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Device Type</label>
                    <select name="device_type" id="device_type">
                    <?php foreach ($deviceOptions as $option) { ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="input-group">
                    <label>Brand Name</label>
                    <select name="brand_name" id="brand_name">
                    <?php foreach ($brandOptions as $option) { ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                    <?php } ?>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="input-group">
                    <label>Machine Model</label>
                    <input type="text" name="machine_model" id="machine_model">

                </div>
                <div class="input-group">
                    <label>Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number">
                </div>

            </div>

            <div class="row">
                <div class="input-group">
                    <label>Recieved By</label>
                    <select name="received_by" id="received_by">
                        <?php foreach ($handledByOptions as $option) { ?>
                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Additional Items</label>
                    <input type="text" name="additional_items" id="additional_items">
                </div>
            </div>
            <div class="row">
                <div class="input-group">
                    <label>Hypothesis</label>
                    <textarea name="hypothesis" id="hypothesis"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="input-group">
                    <label>Wikihow</label>
                    <textarea name="wikihow" id="wikihow"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Status</label>
                    <select name="status" id="status">
                        <?php foreach ($statusOptions as $option) { ?>
                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Handled By</label>
                    <select name="handled_by" id="handled_by">
                    <?php foreach ($handledByOptions as $option) { ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Date Fixed</label>
                    <input type="date" name="date_fixed" id="date_fixed">

                </div>
                <div class="input-group">
                    <label>Date Taken</label>
                    <input type="date" name="date_taken" id="date_taken">

                </div>t
            </div>
        </div>
        <div class="form-footer">
           
                <a class="btn-logout" href="logout.php"> 
                    logout
                </a>
                <a class="btn-view" href="viewtable.php"> 
                    view table
                </a>
          
                <button type="submit" class="btn">Submit</button>


        </div>
    </form>
    <script src="js/jquery-3.6.4.js"></script>
    <script src="js/process_form.js"></script>
    <script src="js/contact.js"></script>

    
</body>
</html>


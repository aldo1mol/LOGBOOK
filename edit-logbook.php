<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include your MySQL connection configuration file
include 'config.php';

// Check if the ID parameter is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect the user if the ID parameter is missing
    header("Location: view-table.php");
    exit();
}

// Get the ID parameter from the URL
$id = $_GET['id'];

// Fetch the details of the selected row from the database
$sql = "SELECT * FROM logbook WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the row exists
if ($result->num_rows > 0) {
    // Fetch the row data
    $row = $result->fetch_assoc();
    // Populate form fields with fetched data
    $date = $row['date'];
    $name = $row['name'];
    $contact = $row['contact'];
    $department = $row['department'];
    $issue_reported = $row['issue_reported'];
    $device_type = $row['device_type'];
    $brand_name = $row['brand_name'];
    $machine_model = $row['machine_model'];
    $serial_number = $row['serial_number'];
    $received_by = $row['received_by'];
    $additional_items = $row['additional_items'];
    $hypothesis = $row['hypothesis'];
    $wikihow = $row['wikihow'];
    $status = $row['status'];
    $handled_by = $row['handled_by'];
    $date_fixed = $row['date_fixed'];
    $date_taken = $row['date_taken'];
} else {
    // Redirect the user back to view-table.php if the row is not found
    header("Location: viewtable.php");
    exit();
}

$stmt->close();

if (isset($_POST['submit'])) {
    // Update the row in the database using prepared statement
    $update_sql = "UPDATE logbook SET date = ?, name = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $_POST['date'], $_POST['name'], $id);

    if ($stmt->execute()) {
        // Display "Updated successfully" alert using JavaScript
        echo '<script>alert("Updated successfully!"); window.location.href = "viewtable.php";</script>';
    } else {
        // Display error message in alert
        echo '<script>alert("Error: ' . $conn->error . '");</script>';
    }

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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Logbook Entry</title>
    <link rel="stylesheet" href="logbookform.css">
</head>
<body>
<form id="editLogbookForm" method="post" class="logbook-form">
    <div class="form-header">
        <h1>LOGBOOK FORM</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <div id="responseMessage" style="display: none;"></div>
    </div>
    <div class="form-body">
        <div class="row">
            <div class="input-group">
                <label>Date</label>
                <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
            </div>
            <div class="input-group">
                <label for="">Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Contact</label>
                <input type="tel" name="contact" pattern="[0-9]{10}" maxlength="10" placeholder="Enter 10-digit contact number" value="<?php echo htmlspecialchars($contact); ?>" required>
            </div>
            <div class="input-group">
                <label for="">Department</label>
                <input type="text" name="department" value="<?php echo htmlspecialchars($department); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Issue Reported</label>
                <textarea name="issue_reported"><?php echo htmlspecialchars($issue_reported); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Device Type</label>
                <select name="device_type" id="device_type">
                    <?php foreach ($deviceOptions as $option) { ?>
                        <option value="<?php echo $option; ?>" <?php if ($device_type == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <label>Brand Name</label>
                <select name="brand_name" id="brand_name">
                    <?php foreach ($brandOptions as $option) { ?>
                        <option value="<?php echo $option; ?>" <?php if ($brand_name == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Machine Model</label>
                <input type="text" name="machine_model" value="<?php echo htmlspecialchars($machine_model); ?>">
            </div>
            <div class="input-group">
                <label>Serial Number</label>
                <input type="text" name="serial_number" value="<?php echo htmlspecialchars($serial_number); ?>">
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Received By</label>
                <select name="received_by" id="received_by">
                    <?php foreach ($handledByOptions as $option) { ?>
                        <option value="<?php echo $option; ?>" <?php if ($received_by == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <label>Additional Items</label>
                <input type="text" name="additional_items" value="<?php echo htmlspecialchars($additional_items); ?>">
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Hypothesis</label>
                <textarea name="hypothesis"><?php echo htmlspecialchars($hypothesis); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Wikihow</label>
                <textarea name="wikihow"><?php echo htmlspecialchars($wikihow); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Status</label>
                <select name="status" id="status">
                    <?php foreach ($statusOptions as $option) { ?>
                        <option value="<?php echo $option; ?>" <?php if ($status == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <label>Handled By</label>
                <select name="handled_by" id="handled_by">
                    <?php foreach ($handledByOptions as $option) { ?>
                        <option value="<?php echo $option; ?>" <?php if ($handled_by == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-group">
                <label>Date Fixed</label>
                <input type="date" name="date_fixed" value="<?php echo htmlspecialchars($date_fixed); ?>">
            </div>
            <div class="input-group">
                <label>Date Taken</label>
                <input type="date" name="date_taken" value="<?php echo htmlspecialchars($date_taken); ?>">
            </div>
        </div>
    </div>
    <div class="form-footer">
        <a class="btn-logout" href="logout.php">logout</a>
        <a class="btn-view" href="viewtable.php">view table</a>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </div>
</form>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>

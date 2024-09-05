<?php
session_start();

// Try to include the database connection file
$connection_file = "includes/dbconnection.php";
if (!file_exists($connection_file)) {
    die("Error: Database connection file not found.");
}
include $connection_file;

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

// Check if the database connection is established
if (!isset($conn)) {
    die("Error: Database connection not established.");
}

// Query to fetch the records
$sql = "SELECT * FROM business_records";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Start output buffering
    ob_start();

    // Set the headers to output an Excel file
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=business_records_export_" . date('Y-m-d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Output the column names as the first row
    echo implode("\t", [
        "ID", "Company Name", "Phone Number", "Email Address", "Lead Source", "Decision Maker Name", 
        "Decision Maker Position", "Ecommerce Platform", "Main Product Category", "Monthly Revenue", 
        "First Contact Date", "Services Interested In", "Current Marketing Channels", "Estimated Budget", 
        "Proposal Sent Date", "Proposal Value", "Contract Sign Date", "Contract Value", "Last Contact Date", 
        "Next Scheduled Action", "Current Status", "Follow Ups", "Created At"
    ]) . "\n";

    // Output each row of the data
    while ($row = $result->fetch_assoc()) {
        echo implode("\t", array_values($row)) . "\n";
    }

    // Flush the output buffer
    ob_end_flush();

    // Close the connection
    $conn->close();

    // Redirect to records.php
    // header("Location: records.php");
    exit();
} else {
    // Handle the case where no records were found
    die("No records found to export.");
}
?>

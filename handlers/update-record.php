<?php
session_start();
include "../includes/dbconnection.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

$user_id = intval($_SESSION['user_id']);

// Ensure the user exists in the user_table
$user_check_sql = "SELECT id FROM user_table WHERE id = ?";
$user_check_stmt = $conn->prepare($user_check_sql);
$user_check_stmt->bind_param('i', $user_id);
$user_check_stmt->execute();
$user_check_result = $user_check_stmt->get_result();

if ($user_check_result->num_rows === 0) {
    die("User does not exist.");
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Fetch the old record from the database
    $sql_old = "SELECT * FROM business_records WHERE id = ?";
    $stmt_old = $conn->prepare($sql_old);
    $stmt_old->bind_param('i', $id);
    $stmt_old->execute();
    $result_old = $stmt_old->get_result();
    $old_record = $result_old->fetch_assoc();

    // New values from the form submission
    $company_name = $_POST['company_name'];
    $phone_number = $_POST['phone_number'];
    $email_address = $_POST['email_address'];
    $lead_source = $_POST['lead_source'];
    $decision_maker_name = $_POST['decision_maker_name'];
    $decision_maker_position = $_POST['decision_maker_position'];
    $ecommerce_platform = $_POST['ecommerce_platform'];
    $main_product_category = $_POST['main_product_category'];
    $monthly_revenue = $_POST['monthly_revenue'];
    $first_contact_date = $_POST['first_contact_date'];
    $services_interested_in = $_POST['services_interested_in'];
    $current_marketing_channels = $_POST['current_marketing_channels'];
    $estimated_budget = $_POST['estimated_budget'];
    $proposal_sent_date = $_POST['proposal_sent_date'];
    $proposal_value = $_POST['proposal_value'];
    $contract_sign_date = $_POST['contract_sign_date'];
    $contract_value = $_POST['contract_value'];
    $last_contact_date = $_POST['last_contact_date'];
    $next_scheduled_action = $_POST['next_scheduled_action'];
    $current_status = $_POST['current_status'];
    $follow_ups = $_POST['follow_ups'];

    // Update the record in the database
    $sql_update = "UPDATE business_records SET 
                company_name = ?, phone_number = ?, email_address = ?, lead_source = ?, decision_maker_name = ?, 
                decision_maker_position = ?, ecommerce_platform = ?, main_product_category = ?, monthly_revenue = ?, 
                first_contact_date = ?, services_interested_in = ?, current_marketing_channels = ?, estimated_budget = ?, 
                proposal_sent_date = ?, proposal_value = ?, contract_sign_date = ?, contract_value = ?, last_contact_date = ?, 
                next_scheduled_action = ?, current_status = ?, follow_ups = ?
            WHERE id = ?";

    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param(
        'sssssssssssssssssssssi',
        $company_name, $phone_number, $email_address, $lead_source, $decision_maker_name,
        $decision_maker_position, $ecommerce_platform, $main_product_category, $monthly_revenue,
        $first_contact_date, $services_interested_in, $current_marketing_channels, $estimated_budget,
        $proposal_sent_date, $proposal_value, $contract_sign_date, $contract_value, $last_contact_date,
        $next_scheduled_action, $current_status, $follow_ups, $id
    );

    if ($stmt_update->execute()) {
        // Compare old and new values and log changes
        $changed_fields = [];
        foreach ($old_record as $key => $old_value) {
            $new_value = $$key; // Dynamically access the new value
            if ($old_value != $new_value) {
                $changed_fields[] = "$key changed from '$old_value' to '$new_value'";
            }
        }

        if (!empty($changed_fields)) {
            $log_message = "Record with ID $id updated by user $user_id. Changes: " . implode(', ', $changed_fields);
            $log_sql = "INSERT INTO action_logs (action, user_id) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param('si', $log_message, $user_id);

            if (!$log_stmt->execute()) {
                die("Error logging the action: " . $log_stmt->error);
            }
        }

        // Redirect to a confirmation page or back to the edit page
        header("Location: ../records.php?id=$id&success=1");
        exit();
    } else {
        die("Error updating the record: " . $stmt_update->error);
    }
} else {
    die("Invalid request method.");
}
?>

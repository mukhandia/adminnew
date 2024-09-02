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
    $fields = [
        'company_name', 'phone_number', 'email_address', 'lead_source', 'decision_maker_name',
        'decision_maker_position', 'ecommerce_platform', 'main_product_category', 'monthly_revenue',
        'first_contact_date', 'services_interested_in', 'current_marketing_channels', 'estimated_budget',
        'proposal_sent_date', 'proposal_value', 'contract_sign_date', 'contract_value', 'last_contact_date',
        'next_scheduled_action', 'current_status', 'follow_ups'
    ];

    $new_values = [];
    foreach ($fields as $field) {
        $new_values[$field] = $_POST[$field] ?? ''; // Use empty string if field is not set
    }

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
        $new_values['company_name'], $new_values['phone_number'], $new_values['email_address'], $new_values['lead_source'], $new_values['decision_maker_name'],
        $new_values['decision_maker_position'], $new_values['ecommerce_platform'], $new_values['main_product_category'], $new_values['monthly_revenue'],
        $new_values['first_contact_date'], $new_values['services_interested_in'], $new_values['current_marketing_channels'], $new_values['estimated_budget'],
        $new_values['proposal_sent_date'], $new_values['proposal_value'], $new_values['contract_sign_date'], $new_values['contract_value'], $new_values['last_contact_date'],
        $new_values['next_scheduled_action'], $new_values['current_status'], $new_values['follow_ups'], $id
    );

    if ($stmt_update->execute()) {
        // Compare old and new values and log changes
        foreach ($fields as $field) {
            $old_value = $old_record[$field] ?? '';
            $new_value = $new_values[$field];

            // Handle date formatting
            if (in_array($field, ['first_contact_date', 'proposal_sent_date', 'contract_sign_date', 'last_contact_date', 'next_scheduled_action'])) {
                $old_value = date('Y-m-d H:i:s', strtotime($old_value));
                $new_value = date('Y-m-d H:i:s', strtotime($new_value));
            }

            // Only log if there is a change
            if ($old_value !== $new_value) {
                $old_value_display = $old_value === null ? 'NULL' : $old_value;
                $new_value_display = $new_value === null ? 'NULL' : $new_value;

                // Insert the log entry with an appropriate action description
                $log_sql = "INSERT INTO action_logs (user_id, action, record_id, field_changed, old_value, new_value) VALUES (?, ?, ?, ?, ?, ?)";
                $log_stmt = $conn->prepare($log_sql);
                $action_description = "Field '$field' changed"; // Description of the action
                $log_stmt->bind_param('isssss', $user_id, $action_description, $id, $field, $old_value_display, $new_value_display);

                if (!$log_stmt->execute()) {
                    die("Error logging the action: " . $log_stmt->error);
                }
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

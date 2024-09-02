<?php
require_once '../includes/session.php';
require_once '../includes/dbconnection.php';
require_once '../includes/logger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
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
    $contract_sign_date = $_POST['contract_sign_date'] ?? null;
    $contract_value = $_POST['contract_value'] ?? null;
    $last_contact_date = $_POST['last_contact_date'] ?? null;
    $next_scheduled_action = $_POST['next_scheduled_action'];
    $current_status = $_POST['current_status'];
    $follow_ups = $_POST['follow_ups'];

    // Insert into the database
    $sql = "INSERT INTO business_records (
                company_name, phone_number, email_address, lead_source,
                decision_maker_name, decision_maker_position, ecommerce_platform,
                main_product_category, monthly_revenue, first_contact_date,
                services_interested_in, current_marketing_channels, estimated_budget,
                proposal_sent_date, proposal_value, contract_sign_date,
                contract_value, last_contact_date, next_scheduled_action,
                current_status, follow_ups
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssssssssssssssi",
            $company_name, $phone_number, $email_address, $lead_source,
            $decision_maker_name, $decision_maker_position, $ecommerce_platform,
            $main_product_category, $monthly_revenue, $first_contact_date,
            $services_interested_in, $current_marketing_channels, $estimated_budget,
            $proposal_sent_date, $proposal_value, $contract_sign_date,
            $contract_value, $last_contact_date, $next_scheduled_action,
            $current_status, $follow_ups
        );

        if ($stmt->execute()) {
            // Log the action
            logAction("User {$_SESSION['user_name']} added a new business record for {$company_name}.");

            // Redirect or show success message
            header("Location: ../index.php?success=Record+added+successfully");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
}
?>

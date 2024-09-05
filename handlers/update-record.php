<?php
session_start();
require '../includes/dbconnection.php';
require '../vendor/autoload.php'; // Include Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}
$user_id = intval($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? 'Unknown User'; // Fetch user name from session or default

// Specific email address to receive notifications
$recipient_email = 'support@afripixelsolutions.com';

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
        'company_name',
        'phone_number',
        'email_address',
        'lead_source',
        'decision_maker_name',
        'decision_maker_position',
        'ecommerce_platform',
        'main_product_category',
        'monthly_revenue',
        'first_contact_date',
        'services_interested_in',
        'current_marketing_channels',
        'estimated_budget',
        'proposal_sent_date',
        'proposal_value',
        'contract_sign_date',
        'contract_value',
        'last_contact_date',
        'next_scheduled_action',
        'current_status',
        'follow_ups'
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
        $new_values['company_name'],
        $new_values['phone_number'],
        $new_values['email_address'],
        $new_values['lead_source'],
        $new_values['decision_maker_name'],
        $new_values['decision_maker_position'],
        $new_values['ecommerce_platform'],
        $new_values['main_product_category'],
        $new_values['monthly_revenue'],
        $new_values['first_contact_date'],
        $new_values['services_interested_in'],
        $new_values['current_marketing_channels'],
        $new_values['estimated_budget'],
        $new_values['proposal_sent_date'],
        $new_values['proposal_value'],
        $new_values['contract_sign_date'],
        $new_values['contract_value'],
        $new_values['last_contact_date'],
        $new_values['next_scheduled_action'],
        $new_values['current_status'],
        $new_values['follow_ups'],
        $id
    );

    if ($stmt_update->execute()) {
        $changes = [];
        $company_name = '';

        // Compare old and new values and log changes
        foreach ($fields as $field) {
            $old_value = $old_record[$field] ?? '';
            $new_value = $new_values[$field];

            // Handle integer comparison separately
            if ($field === 'follow_ups') {
                $old_value = intval($old_value);
                $new_value = intval($new_value);
            }

            // Handle date formatting
            if (in_array($field, ['first_contact_date', 'proposal_sent_date', 'contract_sign_date', 'last_contact_date', 'next_scheduled_action'])) {
                $old_value = date('Y-m-d H:i:s', strtotime($old_value));
                $new_value = date('Y-m-d H:i:s', strtotime($new_value));
            }

            // Only log if there is a change
            if ($old_value !== $new_value) {
                $old_value_display = $old_value === null ? 'NULL' : $old_value;
                $new_value_display = $new_value === null ? 'NULL' : $new_value;

                // Reference the company_name directly from the records table during the log insert
                $log_sql = "INSERT INTO action_logs (user_id, company_name, action, record_id, field_changed, old_value, new_value) 
                            VALUES (?, (SELECT company_name FROM business_records WHERE id = ?), ?, ?, ?, ?, ?)";
                $log_stmt = $conn->prepare($log_sql);
                $action_description = "Field '$field' changed"; // Description of the action
                $log_stmt->bind_param('iisssss', $user_id, $id, $action_description, $id, $field, $old_value_display, $new_value_display);

                if (!$log_stmt->execute()) {
                    die("Error logging the action: " . $log_stmt->error);
                }

                // Collect changes for email
                $changes[] = [
                    'field' => $field,
                    'old_value' => $old_value_display,
                    'new_value' => $new_value_display
                ];
            }

            // Capture company name for the email
            if ($field == 'company_name') {
                $company_name = $new_values[$field];
            }
        }

        // Send an email notification using PHPMailer
        if (!empty($changes)) {
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();                                           // Send using SMTP
                $mail->Host       = 'mail.afripixelsolutions.com';                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'system@afripixelsolutions.com';               // SMTP username
                $mail->Password   = 'mUyM,aSHw*mk';                  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS for SSL
                $mail->Port       = 587;                                    // TCP port to connect to

                // Recipients
                $mail->setFrom('fwasike@afripixelsolutions.com', 'Afripixel Admin System');
                $mail->addAddress($recipient_email);                        // Send to the specific account

                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = "Record Updated: $company_name";

                // Build HTML table for changes
                $tableRows = '';
                foreach ($changes as $change) {
                    $tableRows .= "<tr>
                        <td>{$user_name}</td>
                        <td>{$change['field']}</td>
                        <td>{$change['old_value']}</td>
                        <td>{$change['new_value']}</td>
                    </tr>";
                }

                $mail->Body    = "
                <html>
                <head>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        table, th, td {
                            border: 1px solid black;
                        }
                        th, td {
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    <p>The following changes were made to the record  for <strong>$company_name</strong>:</p>
                    <table>
                        <tr>
                            <th>User Who Made Changes</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        $tableRows
                    </table>
                </body>
                </html>";

                $mail->AltBody = strip_tags($mail->Body);                   // Plain text version for non-HTML mail clients

                $mail->send();
            } catch (Exception $e) {
                die("Error sending notification email: {$mail->ErrorInfo}");
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

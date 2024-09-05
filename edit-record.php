<?php
include "includes/dbconnection.php";
include "includes/header.php";

// Check if an ID is provided
if (!isset($_GET['id'])) {
    die("Record ID is missing.");
}

$id = intval($_GET['id']);

// Fetch the record from the database
$sql = "SELECT * FROM business_records WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Record not found.");
}

$record = $result->fetch_assoc();
?>

<div class="row m-t-10">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Edit Business Record</h4>
                <form action="handlers/update-record.php" method="POST">
                    <input type="hidden" name="id" value="<?= $record['id'] ?>">

                    <!-- Form Fields -->
                    <div class="form-group row">
                        <label for="company_name" class="col-sm-4 col-form-label">Company Name</label>
                        <div class="col-sm-12">
                            <input readonly class="form-control" type="text" id="company_name" name="company_name" value="<?= htmlspecialchars($record['company_name']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone_number" class="col-sm-4 col-form-label">Phone Number</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($record['phone_number']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email_address" class="col-sm-4 col-form-label">Email Address</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="email" id="email_address" name="email_address" value="<?= htmlspecialchars($record['email_address']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lead_source" class="col-sm-4 col-form-label">Lead Source</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="lead_source" name="lead_source" value="<?= htmlspecialchars($record['lead_source']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="decision_maker_name" class="col-sm-4 col-form-label">Decision Maker Name</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="decision_maker_name" name="decision_maker_name" value="<?= htmlspecialchars($record['decision_maker_name']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="decision_maker_position" class="col-sm-4 col-form-label">Decision Maker Position</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="decision_maker_position" name="decision_maker_position" value="<?= htmlspecialchars($record['decision_maker_position']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ecommerce_platform" class="col-sm-4 col-form-label">E-commerce Platform</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="ecommerce_platform" name="ecommerce_platform" value="<?= htmlspecialchars($record['ecommerce_platform']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="main_product_category" class="col-sm-4 col-form-label">Store Main Product Category</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="main_product_category" name="main_product_category" value="<?= htmlspecialchars($record['main_product_category']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="monthly_revenue" class="col-sm-4 col-form-label">Monthly Online Revenue</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" id="monthly_revenue" name="monthly_revenue" value="<?= htmlspecialchars($record['monthly_revenue']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="first_contact_date" class="col-sm-4 col-form-label">Date of First Contact</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="datetime-local" id="first_contact_date" name="first_contact_date" value="<?= htmlspecialchars($record['first_contact_date']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="services_interested_in" class="col-sm-4 col-form-label">Services Interested In</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="services_interested_in" name="services_interested_in" value="<?= htmlspecialchars($record['services_interested_in']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="current_marketing_channels" class="col-sm-4 col-form-label">Current Marketing Channels</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" id="current_marketing_channels" name="current_marketing_channels" value="<?= htmlspecialchars($record['current_marketing_channels']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="estimated_budget" class="col-sm-4 col-form-label">Estimated Budget</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" id="estimated_budget" name="estimated_budget" value="<?= htmlspecialchars($record['estimated_budget']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="proposal_sent_date" class="col-sm-4 col-form-label">Proposal Sent Date</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="datetime-local" id="proposal_sent_date" name="proposal_sent_date" value="<?= htmlspecialchars($record['proposal_sent_date']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="proposal_value" class="col-sm-4 col-form-label">Proposal Value</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" id="proposal_value" name="proposal_value" value="<?= htmlspecialchars($record['proposal_value']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contract_sign_date" class="col-sm-4 col-form-label">Contract Sign Date</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="datetime-local" id="contract_sign_date" name="contract_sign_date" value="<?= htmlspecialchars($record['contract_sign_date']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contract_value" class="col-sm-4 col-form-label">Contract Value</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" id="contract_value" name="contract_value" value="<?= htmlspecialchars($record['contract_value']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_contact_date" class="col-sm-4 col-form-label">Last Contact Date</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="datetime-local" id="last_contact_date" name="last_contact_date" value="<?= htmlspecialchars($record['last_contact_date']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="next_scheduled_action" class="col-sm-4 col-form-label">Next Scheduled Action</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="datetime-local" id="next_scheduled_action" name="next_scheduled_action" value="<?= htmlspecialchars($record['next_scheduled_action']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="current_status" class="col-sm-4 col-form-label">Current Status</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="current_status" name="current_status" required>
                                <option value="Lead" <?= $record['current_status'] == 'Lead' ? 'selected' : '' ?>>Lead</option>
                                <option value="Client" <?= $record['current_status'] == 'Client' ? 'selected' : '' ?>>Client</option>
                                <option value="Lost" <?= $record['current_status'] == 'Lost' ? 'selected' : '' ?>>Lost</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="follow_ups" class="col-sm-4 col-form-label">Number of Follow-ups</label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" id="follow_ups" name="follow_ups" value="<?= htmlspecialchars($record['follow_ups']) ?>" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<?php
include "includes/footer.php";
?>

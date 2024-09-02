<?php
include "includes/header.php";
include "includes/dbconnection.php";
// au/index.php (Admin Area)
// require_once '../includes/auth.php';
// checkUserAccess(['admin']); 

$sql = "
    SELECT 
        action_logs.*,
        user_table.name AS user_name
    FROM 
        action_logs
    LEFT JOIN 
        user_table ON action_logs.user_id = user_table.id
    ORDER BY 
        action_logs.action_date DESC Limit 3";  // Order by most recent first

$result = $conn->query($sql);

// Fetch the total number of users from the user_table
$sql_count = "SELECT COUNT(*) AS user_count FROM user_table";
$result_count = $conn->query($sql_count);

// Get the count
$user_count = 0;
if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $user_count = $row_count['user_count'];
}

$record_count = "SELECT COUNT(*) AS records_count FROM business_records";
$clients_count = $conn->query($record_count);

// Get clients count the count
$records_count = 0;
if ($clients_count->num_rows > 0) {
    $row_count = $clients_count->fetch_assoc();
    $records_count = $row_count['records_count'];
}
?>
<div class="page-content-wrapper ">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Afripixel</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-3">
                    <a href="records.php">
                        <div class="card">
                            <div class="card-body justify-content-center">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="far fa-gem text-gradient-danger">Clients</i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1"></h5>
                                            <p class="mb-0 font-12 text-muted"> <?= $records_count ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div> 
                </div>
            </div>
        </div>
<!-- Clents and propspects -->

<?php 

$sql = "SELECT * FROM business_records";
$result = $conn->query($sql);
?>
<div class="row m-t-30">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title pb-3 mt-0">Business Records</h5>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="align-self-center">
                                <th>S/N</th>
                                <th>Company Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                                <th>Lead Source</th>
                                <th>Decision Maker Name</th>
                                <th>Decision Maker Position</th>
                                <th>E-commerce Platform</th>
                                <th>Store Main Product Category</th>
                                <th>Monthly Online Revenue</th>
                                <th>Date of First Contact</th>
                                <th>Services Interested In</th>
                                <th>Current Marketing Channels</th>
                                <th>Estimated Budget</th>
                                <th>Proposal Sent Date</th>
                                <th>Proposal Value</th>
                                <th>Contract Sign Date</th>
                                <th>Contract Value</th>
                                <th>Last Contact Date</th>
                                <th>Next Scheduled Action</th>
                                <th>Current Status</th>
                                <th>Number of Follow-ups</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $sn = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $sn++; ?></td>
                                        <td><?= htmlspecialchars($row['company_name']); ?></td>
                                        <td><?= htmlspecialchars($row['phone_number']); ?></td>
                                        <td><?= htmlspecialchars($row['email_address']); ?></td>
                                        <td><?= htmlspecialchars($row['lead_source']); ?></td>
                                        <td><?= htmlspecialchars($row['decision_maker_name']); ?></td>
                                        <td><?= htmlspecialchars($row['decision_maker_position']); ?></td>
                                        <td><?= htmlspecialchars($row['ecommerce_platform']); ?></td>
                                        <td><?= htmlspecialchars($row['main_product_category']); ?></td>
                                        <td><?= htmlspecialchars($row['monthly_revenue']); ?></td>
                                        <td><?= htmlspecialchars($row['first_contact_date']); ?></td>
                                        <td><?= htmlspecialchars($row['services_interested_in']); ?></td>
                                        <td><?= htmlspecialchars($row['current_marketing_channels']); ?></td>
                                        <td><?= htmlspecialchars($row['estimated_budget']); ?></td>
                                        <td><?= htmlspecialchars($row['proposal_sent_date']); ?></td>
                                        <td><?= htmlspecialchars($row['proposal_value']); ?></td>
                                        <td><?= htmlspecialchars($row['contract_sign_date']); ?></td>
                                        <td><?= htmlspecialchars($row['contract_value']); ?></td>
                                        <td><?= htmlspecialchars($row['last_contact_date']); ?></td>
                                        <td><?= htmlspecialchars($row['next_scheduled_action']); ?></td>
                                        <td><?= htmlspecialchars($row['current_status']); ?></td>
                                        <td><?= htmlspecialchars($row['follow_ups']); ?></td>
                                        <td>
                                            <a href="edit-record.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="delete-record.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="23" class="text-center">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = this.getAttribute('data-id');
                var userName = this.getAttribute('data-name');
                var userEmail = this.getAttribute('data-email');
                var userRole = this.getAttribute('data-role');

                document.getElementById('editUserId').value = userId;
                document.getElementById('editUserName').value = userName;
                document.getElementById('editUserEmail').value = userEmail;
                document.getElementById('editUserRole').value = userRole;
            });
        });
    });
</script>
        <!-- end row -->

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<?php
include "includes/footer.php";
?>
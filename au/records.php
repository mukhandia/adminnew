<?php
include "includes/dbconnection.php";
include "includes/header.php";

// Fetch all records from the database
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

<?php
include "includes/footer.php";
?>

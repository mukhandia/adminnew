<?php
include "includes/dbconnection.php";
include "includes/header.php";

// Fetch logs from the database with the associated username
$sql = "
    SELECT 
        action_logs.*,
        user_table.name AS user_name
    FROM 
        action_logs
    LEFT JOIN 
        user_table ON action_logs.user_id = user_table.id
    ORDER BY 
        action_logs.action_date DESC";  // Order by most recent first

$result = $conn->query($sql);
?>
<div class="row m-t-30">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title pb-3 mt-0">Action Logs</h5>
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-hover mb-0">
                        <thead>
                            <tr class="align-self-center">
                                <th>S/N</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Company Name</th>
                                <th>Field Changed</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Action Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $sn = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $sn++; ?></td>
                                        <td><?= htmlspecialchars($row['user_name']); ?></td> <!-- Display the username -->
                                        <td><?= htmlspecialchars($row['action']); ?></td>
                                        <td><?= htmlspecialchars($row['company_name']); ?></td>
                                        <td><?= htmlspecialchars($row['field_changed']); ?></td>
                                        <td><?= htmlspecialchars($row['old_value']); ?></td>
                                        <td><?= htmlspecialchars($row['new_value']); ?></td>
                                        <td><?= date("Y-m-d H:i:s", strtotime($row['action_date'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No logs available</td>
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

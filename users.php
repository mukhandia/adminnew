<?php
include "includes/header.php";
include "includes/dbconnection.php";
// Display success message
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}

// Display error message
if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']);
}

$sql = "SELECT * FROM user_table";
$result = $conn->query($sql);
?>
<div class="row m-t-30">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title pb-3 mt-0">Users</h5>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="align-self-center">
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $sn = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $sn++; ?></td>
                                        <td>
                                            <?= htmlspecialchars($row['name']); ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['role']); ?></td>
                                        <td><?= htmlspecialchars($row['registered_time']); ?></td>
                                        <td>
                                            <a style="color:white" data-toggle="modal"
                                                data-animation="bounce"
                                                data-target=".bs-example-modal-center" class="btn btn-sm btn-primary edit-btn"
                                                data-id="<?= $row['id']; ?>"
                                                data-name="<?= htmlspecialchars($row['name']); ?>"
                                                data-email="<?= htmlspecialchars($row['email']); ?>"
                                                data-role="<?= htmlspecialchars($row['role']); ?>">Edit</a>
                                            <a  style="color:white;background-color:#CB0000" href="handlers/delete-user.php?id=<?= $row['id']; ?>" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No users found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div><!--end table-responsive-->
                <!-- edit forms for the users -->
                <div class="col-sm-6 col-md-3 mt-4">
                    <!-- Edit User Modal -->
                    <div class="modal fade bs-example-modal-center"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="mySmallModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="handlers/update-user.php" method="POST" id="editUserForm">
                                        <input type="hidden"   name="idu" value="<?php echo $userId; ?>" id="editUserId">
                                        <div class="form-group">
                                            <label for="editUserName">Name</label>
                                            <input type="text" class="form-control" id="editUserName" name="nameu" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editUserEmail">Email</label>
                                            <input type="email" class="form-control" id="editUserEmail" value="" name="emailu" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editUserPassword">Password</label>
                                            <input type="password" class="form-control" id="editUserPassword" name="passwordu">
                                            <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="editUserRole">Role</label>
                                            <select class="form-control" id="editUserRole" name="roleu" required>
                                                <option value="admin">Admin</option>
                                                <option value="superadmin">Super Admin</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.modal -->
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

















<?php
include "includes/footer.php";
?>
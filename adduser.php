  <?php
    session_start();
    include "includes/header.php";
    include "includes/dbconnection.php";
    ?>
  <div class="row m-t-10">
      <div class="col-12">
          <div class="card">
              <div class="card-body">
                  <h4 class="mt-0 header-title">Add New User</h4>
                  <form action="handlers/add-user.php" method="POST">
                      <div class="row">
                          <div class="col-xl-6">
                              <div class="form-group row">
                                  <label for="name" class="col-sm-4 col-form-label">Name</label>
                                  <div class="col-sm-12">
                                      <input class="form-control" type="text" id="name" name="name" required>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="email" class="col-sm-4 col-form-label">Email</label>
                                  <div class="col-sm-12">
                                      <input class="form-control" type="email" id="email" name="email" required>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="password" class="col-sm-4 col-form-label">Password</label>
                                  <div class="col-sm-12">
                                      <input class="form-control" type="password" id="password" name="password" required>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="role" class="col-sm-4 col-form-label">Role</label>
                                  <div class="col-sm-12">
                                      <select class="select2 form-control mb-3 custom-select" id="role" name="role" style="width: 100%; height:36px;" required>
                                          <option value="">Select</option>
                                          <option value="admin">Admin</option>
                                          <option value="superadmin">Super Admin</option>
                                      </select>
                                  </div>
                              </div>
                              <button class="btn btn-primary" type="submit">SUBMIT</button>
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
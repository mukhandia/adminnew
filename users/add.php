  <?php
    session_start();
    include "../includes/header.php";

    ?>
  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-body">
                  <h4 class="mt-0 header-title">Textual inputs</h4>
                  <p class="text-muted mb-4 font-13">Here are examples of <code
                          class="highlighter-rouge">.form-control</code> applied to each
                      textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code
                          class="highlighter-rouge">type</code>.
                  </p>
                  <div class="row">
                      <div class="col-xl-6">
                          <div class="form-group row">
                              <label for="example-text-input" class="col-sm-2 col-form-label">Text</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-search-input" class="col-sm-2 col-form-label">Search</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="search" value="How do I shoot web" id="example-search-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-url-input" class="col-sm-2 col-form-label">URL</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="url" value="https://getbootstrap.com" id="example-url-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-tel-input" class="col-sm-2 col-form-label">Telephone</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="tel" value="1-(555)-555-5555" id="example-tel-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-password-input" class="col-sm-2 col-form-label">Password</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="password" value="hunter2" id="example-password-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-number-input" class="col-sm-2 col-form-label">Number</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="number" value="42" id="example-number-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-datetime-local-input" class="col-sm-2 col-form-label">Date and time</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-date-input" class="col-sm-2 col-form-label">Date</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-month-input" class="col-sm-2 col-form-label">Month</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="month" value="2011-08" id="example-month-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-week-input" class="col-sm-2 col-form-label">Week</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="week" value="2011-W33" id="example-week-input">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="example-time-input" class="col-sm-2 col-form-label">Time</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div> <!-- end col -->
  </div> <!-- end row -->
  <?php
    include "../includes/footer.php";
    ?>
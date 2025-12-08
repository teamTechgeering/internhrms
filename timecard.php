<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <div class="container-fluid p-4">

      <!-- PAGE HEADER -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Time cards</h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addTimeModal">
          <i class="bi bi-plus-lg"></i> Add time manually
        </button>
      </div>

      <!-- TABS -->
      <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-tab="daily">Daily</button></li>
        <li class="nav-item"><button class="nav-link" data-tab="custom">Custom</button></li>
        <li class="nav-item"><button class="nav-link" data-tab="summary">Summary</button></li>
        <li class="nav-item"><button class="nav-link" data-tab="summary_details">Summary details</button></li>
        <li class="nav-item"><button class="nav-link" data-tab="members_clocked_in">Members Clocked In</button></li>
        <li class="nav-item"><button class="nav-link" data-tab="clock_in_out">Clock in-out</button></li>
      </ul>

      <!-- FILTERS -->
      <div class="d-flex gap-2 align-items-center mb-3">
        <select id="filterMember" class="form-select" style="width:180px;">
          <option value="">- Member -</option>
        </select>

        <button class="btn btn-outline-secondary" id="btnPrev"><i class="bi bi-chevron-left"></i></button>
        <button class="btn btn-outline-secondary" id="btnToday">Today</button>
        <button class="btn btn-outline-secondary" id="btnNext"><i class="bi bi-chevron-right"></i></button>

        <div class="ms-auto d-flex gap-2">
          <button id="btnExport" class="btn btn-outline-secondary">Excel</button>
          <button id="btnPrint" class="btn btn-outline-secondary">Print</button>

          <div class="input-group" style="width:230px;">
            <input id="searchInput" type="search" class="form-control" placeholder="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
          </div>
        </div>
      </div>


      <!-- TAB CONTENT -->
      <div id="tabContent">

        <!-- DAILY TAB -->
        <div id="pane-daily">
          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" id="table-daily">
                  <thead class="table-light">
                    <tr>
                      <th>Team member</th>
                      <th>In Date</th>
                      <th>In Time</th>
                      <th>Out Date</th>
                      <th>Out Time</th>
                      <th>Duration</th>
                      <th><i class="bi bi-chat"></i></th>
                      <th><i class="bi bi-pencil-square"></i></th>
                      <th><i class="bi bi-x-circle"></i></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5"></td>
                      <td class="fw-bold" id="daily-total">Total</td>
                      <td colspan="3"></td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <!-- Pagination -->
              <div class="p-3 d-flex justify-content-between">
                <div>
                  <select id="dailyPageSize" class="form-select" style="width:80px;">
                    <option>10</option>
                  </select>
                  <span id="dailyCount" class="ms-2 text-muted">0-0 / 0</span>
                </div>

                <ul class="pagination mb-0" id="dailyPagination"></ul>
              </div>

            </div>
          </div>
        </div>


        <!-- CUSTOM TAB -->
        <div id="pane-custom" class="d-none">
          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" id="table-custom">
                  <thead class="table-light">
                    <tr>
                      <th>Team member</th>
                      <th>In Date</th>
                      <th>In Time</th>
                      <th>Out Date</th>
                      <th>Out Time</th>
                      <th>Duration</th>
                      <th><i class="bi bi-chat"></i></th>
                      <th><i class="bi bi-pencil-square"></i></th>
                      <th><i class="bi bi-x-circle"></i></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

              <div class="p-3 d-flex justify-content-between">
                <div>
                  <select id="customPageSize" class="form-select" style="width:80px;">
                    <option>10</option>
                  </select>
                  <span id="customCount" class="ms-2 text-muted">0-0 / 0</span>
                </div>

                <ul class="pagination mb-0" id="customPagination"></ul>
              </div>
            </div>
          </div>
        </div>


        <!-- SUMMARY TAB -->
        <div id="pane-summary" class="d-none">
          <div class="card">
            <div class="card-body p-0">
              <table class="table mb-0" id="table-summary">
                <thead class="table-light">
                  <tr>
                    <th>Team member</th>
                    <th class="text-end">Duration</th>
                    <th class="text-end">Hours</th>
                  </tr>
                </thead>
                <tbody></tbody>

                <tfoot>
                  <tr>
                    <td class="fw-bold">Total</td>
                    <td id="summaryDurationTotal" class="fw-bold"></td>
                    <td id="summaryHoursTotal" class="fw-bold"></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>


        <!-- SUMMARY DETAILS TAB -->
        <div id="pane-summary_details" class="d-none">
          <div class="card">
            <div class="card-body p-0">
              <table class="table mb-0" id="table-summary-details">
                <thead class="table-light">
                  <tr>
                    <th>Team member</th>
                    <th>Date</th>
                    <th class="text-end">Duration</th>
                    <th class="text-end">Hours</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>


        <!-- MEMBERS CLOCKED IN -->
        <div id="pane-members_clocked_in" class="d-none">
          <div class="card">
            <div class="card-body p-0">
              <table class="table mb-0" id="table-members-clocked-in">
                <thead class="table-light">
                  <tr>
                    <th>Team member</th>
                    <th>In Date</th>
                    <th>In Time</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>


        <!-- CLOCK IN-OUT -->
        <div id="pane-clock_in_out" class="d-none">
          <div class="card">
            <div class="card-body p-0">
              <table class="table mb-0" id="table-clock-in-out">
                <thead class="table-light">
                  <tr>
                    <th>Team members</th>
                    <th>Status</th>
                    <th>Clock in-out</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>

      </div> <!-- /tabContent -->


      <!-- ADD TIME MODAL -->
      <div class="modal fade" id="addTimeModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">Add time manually</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <div class="row gy-3">

                <div class="col-4">Team member</div>
                <div class="col-8">
                  <select id="manual_member" class="form-select"></select>
                </div>

                <div class="col-4">In Date</div>
                <div class="col-4"><input id="manual_in_date" type="date" class="form-control"></div>
                <div class="col-4"><input id="manual_in_time" type="time" class="form-control"></div>

                <div class="col-4">Out Date</div>
                <div class="col-4"><input id="manual_out_date" type="date" class="form-control"></div>
                <div class="col-4"><input id="manual_out_time" type="time" class="form-control"></div>

                <div class="col-4">Note</div>
                <div class="col-8">
                  <textarea id="manual_note" class="form-control" rows="2"></textarea>
                </div>

              </div>
            </div>

            <div class="modal-footer">
              <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button id="manualSave" class="btn btn-primary">Save</button>
            </div>

          </div>
        </div>
      </div>


      <!-- NOTE MODAL -->
      <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">Note</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <label>Note</label>
              <textarea id="noteText" class="form-control" rows="6"></textarea>
            </div>

            <div class="modal-footer">
              <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button id="saveNote" class="btn btn-primary">Save</button>
            </div>

          </div>
        </div>
      </div>


      <!-- EDIT MODAL -->
      <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">Edit time card</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <div class="row gy-3">

                <div class="col-4">Team member</div>
                <div class="col-8 d-flex align-items-center gap-2">
                  <img id="editAvatar" width="32" height="32" class="rounded-circle">
                  <span id="editName"></span>
                </div>

                <div class="col-4">In Date</div>
                <div class="col-4"><input id="edit_in_date" type="date" class="form-control"></div>
                <div class="col-4"><input id="edit_in_time" type="time" class="form-control"></div>

                <div class="col-4">Out Date</div>
                <div class="col-4"><input id="edit_out_date" type="date" class="form-control"></div>
                <div class="col-4"><input id="edit_out_time" type="time" class="form-control"></div>

                <div class="col-4">Note</div>
                <div class="col-8"><textarea id="edit_note" class="form-control" rows="3"></textarea></div>

              </div>
            </div>

            <div class="modal-footer">
              <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button id="editSave" class="btn btn-primary">Save</button>
            </div>

          </div>
        </div>
      </div>


      <!-- DELETE MODAL -->
      <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">Delete time card</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              Are you sure you want to delete this entry?
            </div>

            <div class="modal-footer">
              <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button id="deleteConfirm" class="btn btn-danger">Delete</button>
            </div>

          </div>
        </div>
      </div>


    </div> <!-- container -->
  </div>
</div>

<?php include 'common/footer.php'; ?>
<script src="assets/js/timecard.js"></script>
</body>
</html>

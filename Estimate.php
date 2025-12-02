<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>
<div class="container-fluid mt-4">

    <!-- ====================== -->
    <!--   TAB BUTTONS (TOP)   -->
    <!-- ====================== -->
    <ul class="nav nav-tabs" id="estimateTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="estimates-tab" data-bs-toggle="tab" data-bs-target="#estimates" type="button" role="tab">
                Estimates
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab">
                Estimate Requests
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="forms-tab" data-bs-toggle="tab" data-bs-target="#forms" type="button" role="tab">
                Estimate Request Forms
            </button>
        </li>
    </ul>

    <!-- ====================================================== -->
    <!--            TAB CONTENT START (ALL 3 TABS HERE)         -->
    <!-- ====================================================== -->
    <div class="tab-content mt-4">

        <!-- =============================== -->
        <!--   TAB 1 : ESTIMATES (ACTIVE)   -->
        <!-- =============================== -->
        <div class="tab-pane fade show active" id="estimates" role="tabpanel">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn btn-light border">
                    <i class="fa fa-filter"></i> Add new filter
                </button>

                <div class="d-flex">
                    <button class="btn btn-light border me-2">Excel</button>
                    <button class="btn btn-light border me-2">Print</button>

                    <div class="input-group">
                        <input type="text" id="searchBox" class="form-control" placeholder="Search">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>

                <!-- Add Estimate Button -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEstimateModal">
                    <i class="fa fa-plus"></i> Add estimate
                </button>
            </div>

            <!-- Estimates Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Estimate</th>
                            <th>Client</th>
                            <th>Estimate Date</th>
                            <th>Created by</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="estimatesTable"></tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th id="pageTotal">$0.00</th>
                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total of all pages</th>
                            <th id="allPagesTotal">$0.00</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>

                </table>
            </div>

        </div>

        <!-- ======================================= -->
        <!--   TAB 2 : ESTIMATE REQUESTS (EMPTY)     -->
        <!-- ======================================= -->
        <div class="tab-pane fade" id="requests" role="tabpanel">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5></h5>

               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRequestModal">
    <i class="fa fa-plus"></i> Create estimate request
</button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Title</th>
                            <th>Assigned to</th>
                            <th>Created date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="requestsTable"></tbody>
                </table>
            </div>

        </div>
<!-- ADD ESTIMATE REQUEST MODAL -->
<div class="modal fade" id="addRequestModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Create estimate request</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="addRequestForm">

          <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" id="reqClient" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="reqTitle" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Assigned To</label>
            <input type="text" id="reqAssigned" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Created Date</label>
            <input type="datetime-local" id="reqDate" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="reqStatus" class="form-select" required>
              <option value="New">New</option>
              <option value="Processing">Processing</option>
              <option value="Completed">Completed</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveNewRequest()">Save</button>
      </div>

    </div>
  </div>
</div>
<!-- EDIT REQUEST MODAL -->
<div class="modal fade" id="editRequestModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Estimate Request</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editRequestForm">
          <input type="hidden" id="editReqId">

          <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" id="editReqClient" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="editReqTitle" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Assigned To</label>
            <input type="text" id="editReqAssigned" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Created Date</label>
            <input type="datetime-local" id="editReqDate" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="editReqStatus" class="form-select">
              <option value="New">New</option>
              <option value="Processing">Processing</option>
              <option value="Completed">Completed</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="updateRequest()">Update</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="deleteRequestModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Delete Request</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">Are you sure you want to delete?</div>

      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger btn-sm" id="confirmDeleteRequest">Delete</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="successPopup" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center p-3">
      <p id="successMessage"></p>
      <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">OK</button>
    </div>
  </div>
</div>

        <!-- ============================================= -->
        <!--   TAB 3 : ESTIMATE REQUEST FORMS (EMPTY)      -->
        <!-- ============================================= -->
        <div class="tab-pane fade" id="forms" role="tabpanel">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5></h5>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal">
    <i class="fa fa-plus"></i> Add form
</button>

            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Public</th>
                            <th>Embed</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="formsTable"></tbody>
                </table>
            </div>

        </div>

    </div>
    <!-- ADD FORM MODAL -->
<div class="modal fade" id="addFormModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add Estimate Request Form</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="addFormForm">

          <div class="mb-3">
            <label class="form-label">Form Title</label>
            <input type="text" id="formTitle" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Public</label>
            <select id="formPublic" class="form-select">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Embed Code</label>
            <input type="text" id="formEmbed" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="formStatus" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveNewForm()">Save</button>
      </div>

    </div>
  </div>
</div>
<!-- EDIT FORM MODAL -->
<div class="modal fade" id="editFormModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Form</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editFormForm">

          <input type="hidden" id="editFormId">

          <div class="mb-3">
            <label class="form-label">Form Title</label>
            <input type="text" id="editFormTitle" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Public</label>
            <select id="editFormPublic" class="form-select">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Embed Code</label>
            <input type="text" id="editFormEmbed" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="editFormStatus" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="updateForm()">Update</button>
      </div>

    </div>
  </div>
</div>
<!-- DELETE FORM MODAL -->
<div class="modal fade" id="deleteFormModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Delete Form</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this form?
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger btn-sm" id="confirmDeleteForm">Delete</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="formSuccessPopup" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center p-3">
      <p id="formSuccessMessage"></p>
      <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">OK</button>
    </div>
  </div>
</div>

    <!-- END TAB CONTENT -->

</div>
</div>
</div>


<!-- ============================ -->
<!--        MODALS SECTION       -->
<!-- ============================ -->

<!-- ADD ESTIMATE MODAL -->
<div class="modal fade" id="addEstimateModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add Estimate</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="addEstimateForm">

          <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" id="addClient" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" id="addAmount" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Estimate Date</label>
            <input type="date" id="addDate" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Created By</label>
            <input type="text" id="addCreatedBy" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="addStatus" class="form-select" required>
              <option value="Accepted">Accepted</option>
              <option value="Draft">Draft</option>
              <option value="Sent">Sent</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveNewEstimate()">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editEstimateModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Estimate</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editEstimateForm">
          <input type="hidden" id="editId">

          <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" id="editClient" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" id="editAmount" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" id="editDate" class="form-control">
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="updateEstimate()">Update</button>
      </div>

    </div>
  </div>
</div>

<!-- DELETE CONFIRM -->
<div class="modal fade" id="deleteEstimateModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Are you sure you want to delete this estimate?</p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger btn-sm" id="confirmDelete">Delete</button>
      </div>

    </div>
  </div>
</div>


<?php include 'common/footer.php'; ?>
<script src="assets/js/Estimate.js"></script>
</body>
</html>

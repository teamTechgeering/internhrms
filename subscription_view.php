<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

<div class="container mt-4">
    <!-- HEADER TITLE -->
    <div>
        <h4 class="fw-semibold">
            <i class="bi bi-arrow-repeat me-2"></i>
            <span id="subscriptionTitle" class="text-dark"></span>
        </h4>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-primary">Active</span>
            <a href="#" class="text-decoration-none text-info">Add Label</a>
            <span class="badge bg-light text-secondary border">
                <i class="bi bi-calendar2"></i> <span id="nextBilling"></span>
            </span>
        </div>
    </div>
    <!-- MAIN CONTENT GRID -->
    <div class="row mt-4">
        <!-- LEFT SIDE -->
        <div class="col-lg-8">
            <!-- Subscription Items -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-list-ul me-2"></i> Subscription items
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody id="itemsTable"></tbody>
                        <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Sub Total</td>
                            <td id="subTotal"></td>
                        </tr>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total</td>
                            <td id="grandTotal"></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="mt-3 text-secondary" id="domainInfo"></div>
                </div>
            </div>
            <!-- Invoices -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-receipt me-2"></i> Invoices
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button class="btn btn-outline-secondary me-2"><i class="bi bi-funnel"></i> - Status -</button>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-outline-secondary me-2" id="invExcel">Excel</button>
                            <button class="btn btn-outline-secondary me-3" id="invPrint">Print</button>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" id="invSearch">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Bill date</th>
                            <th>Due date</th>
                            <th>Total invoiced</th>
                            <th>Payment Received</th>
                            <th>Due</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody id="invoiceTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- RIGHT SIDE -->
        <div class="col-lg-4">
            <!-- Subscription info -->
           <div class="card shadow-sm mb-4">
    <div class="card-header fw-semibold bg-white d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-info-circle me-2"></i> Subscription info
        </div>
        <button class="btn btn-light border-0" data-bs-toggle="dropdown">
            <i class="bi bi-three-dots-vertical"></i>
        </button>

        <!-- Dropdown menu -->
        <ul class="dropdown-menu dropdown-menu-end">
           <li><a class="dropdown-item" href="#" id="cancelSubscriptionBtn">Cancel Subscription</a></li>
        </ul>
    </div>

    <div class="card-body">
        <p class="mb-2">
            <i class="bi bi-person me-2"></i>
            <a href="Client-view.php" id="client" class="text-primary text-decoration-none"></a>
        </p>

        <p class="mb-2">
            <strong>First billing date:</strong> <span id="firstBilling"></span>
        </p>

        <p class="mb-2">
            <strong>Type:</strong>
            <span class="badge bg-warning text-dark">App</span>
        </p>

        <p class="mb-0">
            <strong>Repeat every:</strong> <span id="repeatEvery"></span>
        </p>
    </div>
</div>

            <!-- Tasks -->
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold bg-white">
                    <i class="bi bi-check2-circle me-2"></i> Tasks
                </div>
                <div class="card-body">
                   <a href="#" data-bs-toggle="modal" data-bs-target="#addTaskModal" class="text-primary text-decoration-none">+ Add task</a>
                </div>
            </div>
            <!-- Reminders -->
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold bg-white">
                    <i class="bi bi-clock-history me-2"></i> Reminders (Private)
                </div>
                <div class="card-body">

    <!-- Add Reminder Link -->
    <a href="#" id="showReminderForm" class="text-primary text-decoration-none">+ Add reminder</a>

    <!-- Reminder Form (Initially Hidden) -->
    <div id="reminderForm" class="mt-3 d-none">

        <div class="mb-3">
            <input type="text" id="remTitle" class="form-control" placeholder="Title">
        </div>

        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="date" id="remDate" class="form-control" placeholder="Date">
            </div>
            <div class="col-md-6">
                <input type="time" id="remTime" class="form-control" placeholder="Time">
            </div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <label class="me-2 fw-semibold">Repeat <i class="bi bi-question-circle"></i></label>
            <input type="checkbox" id="remRepeat">
        </div>

        <button class="btn btn-primary w-100" id="btnAddReminder">
            <i class="bi bi-check2-circle me-1"></i> Add
        </button>

    </div>

    <!-- Display Added Reminders -->
    <ul id="reminderList" class="list-group mt-3"></ul>

</div>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
 <!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">  <!-- smaller width -->
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title fw-semibold">Add task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body" style="max-height: 70vh; overflow-y: auto;"> <!-- reduce height -->
        <div class="row g-3">

          <!-- Description -->
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea id="taskTitle" rows="2" class="form-control" placeholder="Description"></textarea>
          </div>

          <!-- Points -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Points <i class="bi bi-question-circle"></i></label>
            <select class="form-select">
              <option>1 Point</option>
              <option>2 Points</option>
            </select>
          </div>

          <!-- Assign To -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Assign to</label>
            <select class="form-select">
              <option>John Doe</option>
            </select>
          </div>

          <!-- Collaborators -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Collaborators</label>
            <select class="form-select">
              <option>Collaborators</option>
            </select>
          </div>

          <!-- Status -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select">
              <option>To do</option>
              <option>In progress</option>
            </select>
          </div>

          <!-- Priority -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Priority</label>
            <select class="form-select">
              <option>Priority</option>
            </select>
          </div>

          <!-- Labels -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Labels</label>
            <input type="text" class="form-control" placeholder="Labels">
          </div>

          <!-- Start Date -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Start date</label>
            <input type="text" class="form-control" placeholder="DD-MM-YYYY">
          </div>

          <!-- Deadline -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Deadline</label>
            <input type="text" id="taskDueDate" class="form-control" placeholder="DD-MM-YYYY">
          </div>

          <!-- Recurring -->
          <div class="col-12 d-flex align-items-center">
            <label class="form-label fw-semibold me-2">Recurring <i class="bi bi-question-circle"></i></label>
            <input type="checkbox">
          </div>

        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer d-flex justify-content-between">

        <!-- Left Buttons -->
        <div>
          <button class="btn btn-outline-secondary" id="btnUploadTaskFile">
            <i class="bi bi-paperclip me-1"></i> Upload File
          </button>

          <button class="btn btn-outline-secondary">
            <i class="bi bi-mic"></i>
          </button>

          <!-- Hidden File Input -->
          <input type="file" id="taskFile" class="d-none">
        </div>

        <!-- Right Buttons -->
        <div>
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
          <button class="btn btn-primary" id="btnSaveShowTask">Save & show</button>
          <button class="btn btn-primary" id="btnSaveTask">Save</button>
        </div>

      </div>

    </div>
  </div>
</div>



  </div><!-- content -->
</div><!-- content-page -->

<?php include 'common/footer.php'; ?>
</body>
</html>

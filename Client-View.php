<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>
<!-- ================== MAIN CONTENT AREA FIX ================== -->
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <!-- Top Navbar -->
      <?php include 'common/topnavbar.php'; ?>
      <div class="container-fluid px-4 mt-3">
        <!-- Header Section -->
        <nav class="navbar navbar-light bg-white shadow-sm p-3 mb-3 rounded">
          <div class="container-fluid px-0">
            <span class="navbar-brand mb-0 h5 fw-semibold" id="clientTitle">Client Details</span>
            <a href="Clients.php" class="btn btn-outline-secondary btn-sm">
              <i class="fa-solid fa-arrow-left me-1"></i> Back
            </a>
          </div>
        </nav>
        <!-- Client Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <h3 class="fw-bold mb-0" id="clientName"></h3>
            <h6 class="text-muted" id="clientTagline"></h6>
           
          </div>
          <div class="text-end">
            <span class="badge bg-warning text-dark fs-8 px-3 py-2" id="organization">-</span>
            <div class="mt-2 text-muted small" id="clientMeta">-</div>
          </div>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="clientTabs" role="tablist">
          <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview" type="button">Overview</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#projects" type="button">Projects</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#subscriptions" type="button">Subscriptions</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#invoicesTab" type="button">Invoices</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#paymentsTab" type="button">Payments</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders" type="button">Orders</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#estimates" type="button">Estimates</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#proposals" type="button">Proposals</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#contracts" type="button">Contracts</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#files" type="button">Files</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#expenses" type="button">Expenses</button></li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
          <!-- OVERVIEW TAB -->
          <div class="tab-pane fade show active" id="overview">
            <div class="row g-3">
              <!-- LEFT MAIN CONTENT -->
              <div class="col-lg-8">
                <div class="row g-3">
                  <!-- Top row: Invoice Overview + Invoices summary -->
                  <div class="col-md-7">
                    <div class="card shadow-sm border-0 h-100">
                      <div class="card-body">
                        <h5 class="card-title mb-3">Invoice Overview</h5>
                        <div class="row g-3">
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Overdue</p>
                            <h6 id="overdue" class="fw-semibold mb-0">0</h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Not Paid</p>
                            <h6 id="notPaid" class="fw-semibold mb-0">0</h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Partially Paid</p>
                            <h6 id="partiallyPaid" class="fw-semibold mb-0">0</h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Fully Paid</p>
                            <h6 id="fullyPaid" class="fw-semibold mb-0">0</h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Draft</p>
                            <h6 id="draft" class="fw-semibold mb-0">0</h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Total Invoiced</p>
                            <h6 class="fw-semibold mb-0">$<span id="totalInvoiced">0</span></h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Payments</p>
                            <h6 class="fw-semibold mb-0">$<span id="payments">0</span></h6>
                          </div>
                          <div class="col-6 col-md-4">
                            <p class="mb-1 text-muted small">Due</p>
                            <h6 class="fw-semibold mb-0">$<span id="due">0</span></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Invoices list / summary (like screenshot) -->
                  <div class="col-md-5">
                    <div class="card shadow-sm border-0 h-100">
                      <div class="card-body">
                        <h5 class="card-title mb-3 d-flex justify-content-between align-items-center">
                          <span>Invoices</span>
                          <a href="#" class="btn btn-sm btn-outline-primary">View all</a>
                        </h5>
                        <ul class="list-group list-group-flush" id="recentInvoices">
                          <!-- JS will populate recent invoices as list items -->
                          <li class="list-group-item text-muted">No invoices yet.</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <!-- Contacts full-width -->
                  <div class="col-12">
                    <div class="card shadow-sm border-0">
                      <div class="card-body">
                        <h5 class="card-title mb-3">Contacts</h5>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="mb-1"><strong>Contact Name:</strong> <span id="contactName">-</span></p>
                            <p class="mb-1"><strong>Phone:</strong> <span id="phone">-</span></p>
                          </div>
                          <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong> <span id="email">-</span></p>
                            <p class="mb-1"><strong>Address:</strong> <span id="address">-</span></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Tickets -->
                  <div class="col-12">
                    <div class="card shadow-sm border-0">
                      <div class="card-body">
                        <h5 class="card-title mb-3">Tickets</h5>
                        <div id="ticketArea">
                          <p class="text-muted mb-0">No tickets available.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Events (calendar) -->
                  <div class="col-12">
                    <div class="card shadow-sm border-0">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <h5 class="card-title mb-0">Events</h5>
                          <div class="d-flex gap-2 align-items-center">
                            <button id="prevMonth" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-chevron-left"></i></button>
                            <div id="calendarMonthLabel" class="fw-semibold"></div>
                            <button id="nextMonth" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-chevron-right"></i></button>
                          </div>
                        </div>
                        <!-- Calendar table -->
                        <div class="table-responsive">
                          <table class="table table-bordered mb-2">
                            <thead class="table-light">
                              <tr id="calendarWeekdays"></tr>
                            </thead>
                            <tbody id="calendarBody"></tbody>
                          </table>
                        </div>
                        <!-- Events list for selected day -->
                        <div>
                          <h6 class="mb-2">Events on <span id="selectedDateLabel">-</span></h6>
                          <ul class="list-group" id="dayEventsList">
                            <li class="list-group-item text-muted">Select a date to see events.</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- RIGHT SIDE WIDGETS -->
              <div class="col-lg-4">
                <div class="d-flex flex-column gap-3">
                  <!-- Client Info -->
                  <div class="card shadow-sm border-0">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Client Info</h5>
                      <p class="mb-1"><strong>Organization:</strong> <span id="organizationInfo">-</span></p>
                      <p class="mb-1"><strong>Joined:</strong> <span id="joinedDate">-</span></p>
                      <p class="mb-1"><strong>Status:</strong> <span id="clientStatus">-</span></p>
                      <p class="mb-0"><strong>Website:</strong> <a href="#" id="clientWebsite">-</a></p>
                    </div>
                  </div>
                  <!-- Tasks -->
                  <div class="card shadow-sm border-0">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Tasks</h5>
                      <ul class="list-group list-group-flush" id="taskList">
                        <li class="list-group-item text-muted">No tasks yet.</li>
                      </ul>
                    </div>
                  </div>
                  <!-- Notes -->
                  <div class="card shadow-sm border-0">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Notes</h5>
                      <div id="clientNotes">No notes available.</div>
                    </div>
                  </div>
                  <!-- Reminders -->
                  <div class="card shadow-sm border-0">
                    <div class="card-body">
                      
                      <h5 class="card-title mb-3">Reminders (Private)</h5>
                      <ul class="list-group list-group-flush" id="reminderList">
                        <li class="list-group-item text-muted">No reminders set.</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- OTHER TABS (simple placeholders) -->
          <!-- ================= PROJECTS TAB ================= -->
<div class="tab-pane fade" id="projects">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="statusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item filter-status" data-status="all">All</a></li>
          <li><a class="dropdown-item filter-status" data-status="open">Open</a></li>
          <li><a class="dropdown-item filter-status" data-status="completed">Completed</a></li>
          <li><a class="dropdown-item filter-status" data-status="hold">On Hold</a></li>
          <li><a class="dropdown-item filter-status" data-status="canceled">Canceled</a></li>
        </ul>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportProjectsExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printProjects">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchProjects" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProjectModal">
          + Add project
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="projectsTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Price</th>
              <th>Start date</th>
              <th>Deadline</th>
              <th>Progress</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="projectsTableBody"></tbody>
        </table>
      </div>
      <div class="mt-3 text-muted small">
        <span id="paginationText">10 • 0–0 / 0</span>
      </div>
    </div>
  </div>
</div>

<!-- ================= ADD PROJECT MODAL ================= -->
<div class="modal fade" id="addProjectModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Project</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addProjectForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="projectId" required>
          </div>
          <div class="col-md-8">
            <label>Project Title</label>
            <input type="text" class="form-control" id="projectTitle" required>
          </div>
          <div class="col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" id="projectPrice" required>
          </div>
          <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" class="form-control" id="projectStartDate" required>
          </div>
          <div class="col-md-4">
            <label>Deadline</label>
            <input type="date" class="form-control" id="projectDeadline" required>
          </div>
          <div class="col-md-12">
            <label>Status</label>
            <select class="form-control" id="projectStatus">
              <option value="open">Open</option>
              <option value="completed">Completed</option>
              <option value="hold">On Hold</option>
              <option value="canceled">Canceled</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveProject">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- ================= EDIT PROJECT MODAL ================= -->
<div class="modal fade" id="editProjectModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Project</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editProjectForm" class="row g-3">
          <input type="hidden" id="editProjectId">
          <div class="col-md-12">
            <label>Project Title</label>
            <input type="text" class="form-control" id="editProjectTitle">
          </div>
          <div class="col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" id="editProjectPrice">
          </div>
          <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" class="form-control" id="editProjectStartDate">
          </div>
          <div class="col-md-4">
            <label>Deadline</label>
            <input type="date" class="form-control" id="editProjectDeadline">
          </div>
          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="editProjectStatus">
              <option value="open">Open</option>
              <option value="completed">Completed</option>
              <option value="hold">On Hold</option>
              <option value="canceled">Canceled</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveProjectEdit">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- ================= DELETE PROJECT MODAL ================= -->
<div class="modal fade" id="deleteProjectModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Project?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this project?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteProject">Delete</button>
      </div>
    </div>
  </div>
</div>


            <!-- ================= GENERIC TAB TEMPLATE ================= -->

<!-- Example: SUBSCRIPTIONS TAB -->
<div class="tab-pane fade" id="subscriptions">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="statusFilterSubscriptions" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item filter-status-sub" data-status="all">All</a></li>
          <li><a class="dropdown-item filter-status-sub" data-status="active">Active</a></li>
          <li><a class="dropdown-item filter-status-sub" data-status="expired">Expired</a></li>
        </ul>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportSubscriptionsExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printSubscriptions">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchSubscriptions" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
          + Add Subscription
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="subscriptionsTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Plan</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="subscriptionsTableBody"></tbody>
        </table>
      </div>
      <div class="mt-3 text-muted small">
        <span id="subscriptionsPaginationText">0–0 / 0</span>
      </div>
    </div>
  </div>
</div>

<!-- ADD SUBSCRIPTION MODAL -->
<div class="modal fade" id="addSubscriptionModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Subscription</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addSubscriptionForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="subscriptionId" required>
          </div>
          <div class="col-md-8">
            <label>Name</label>
            <input type="text" class="form-control" id="subscriptionName" required>
          </div>
          <div class="col-md-4">
            <label>Plan</label>
            <input type="text" class="form-control" id="subscriptionPlan" required>
          </div>
          <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" class="form-control" id="subscriptionStartDate" required>
          </div>
          <div class="col-md-4">
            <label>End Date</label>
            <input type="date" class="form-control" id="subscriptionEndDate" required>
          </div>
          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="subscriptionStatus">
              <option value="active">Active</option>
              <option value="expired">Expired</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveSubscription">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT SUBSCRIPTION MODAL -->
<div class="modal fade" id="editSubscriptionModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Subscription</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editSubscriptionForm" class="row g-3">
          <input type="hidden" id="editSubscriptionId">
          <div class="col-md-12">
            <label>Name</label>
            <input type="text" class="form-control" id="editSubscriptionName">
          </div>
          <div class="col-md-4">
            <label>Plan</label>
            <input type="text" class="form-control" id="editSubscriptionPlan">
          </div>
          <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" class="form-control" id="editSubscriptionStartDate">
          </div>
          <div class="col-md-4">
            <label>End Date</label>
            <input type="date" class="form-control" id="editSubscriptionEndDate">
          </div>
          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="editSubscriptionStatus">
              <option value="active">Active</option>
              <option value="expired">Expired</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveSubscriptionEdit">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- DELETE SUBSCRIPTION MODAL -->
<div class="modal fade" id="deleteSubscriptionModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Subscription?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this subscription?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteSubscription">Delete</button>
      </div>
    </div>
  </div>
</div>


            <div class="tab-pane fade" id="invoicesTab">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="invoiceStatusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item filter-status-invoice" data-status="all">All</a></li>
          <li><a class="dropdown-item filter-status-invoice" data-status="paid">Paid</a></li>
          <li><a class="dropdown-item filter-status-invoice" data-status="unpaid">Unpaid</a></li>
          <li><a class="dropdown-item filter-status-invoice" data-status="draft">Draft</a></li>
        </ul>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportInvoicesExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printInvoices">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchInvoices" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInvoiceModal">+ Add Invoice</button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="invoicesTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="invoicesTableBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Invoice Modal -->
<div class="modal fade" id="addInvoiceModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Invoice</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addInvoiceForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="invoiceId" required>
          </div>
          <div class="col-md-8">
            <label>Title</label>
            <input type="text" class="form-control" id="invoiceTitle" required>
          </div>
          <div class="col-md-4">
            <label>Amount</label>
            <input type="number" class="form-control" id="invoiceAmount" required>
          </div>
          <div class="col-md-4">
            <label>Date</label>
            <input type="date" class="form-control" id="invoiceDate" required>
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select class="form-select" id="invoiceStatus">
              <option value="paid">Paid</option>
              <option value="unpaid">Unpaid</option>
              <option value="draft">Draft</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveInvoice">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Invoice Modal -->
<div class="modal fade" id="editInvoiceModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Invoice</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editInvoiceForm" class="row g-3">
          <input type="hidden" id="editInvoiceId">
          <div class="col-md-12">
            <label>Title</label>
            <input type="text" class="form-control" id="editInvoiceTitle">
          </div>
          <div class="col-md-4">
            <label>Amount</label>
            <input type="number" class="form-control" id="editInvoiceAmount">
          </div>
          <div class="col-md-4">
            <label>Date</label>
            <input type="date" class="form-control" id="editInvoiceDate">
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select class="form-select" id="editInvoiceStatus">
              <option value="paid">Paid</option>
              <option value="unpaid">Unpaid</option>
              <option value="draft">Draft</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveInvoiceEdit">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Invoice Modal -->
<div class="modal fade" id="deleteInvoiceModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Invoice?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this invoice?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteInvoice">Delete</button>
      </div>
    </div>
  </div>
</div>



           <!-- Payments Tab Content -->
<div class="tab-pane fade" id="paymentsTab">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="paymentStatusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item filter-status-payment" data-status="all">All</a></li>
          <li><a class="dropdown-item filter-status-payment" data-status="paid">Paid</a></li>
          <li><a class="dropdown-item filter-status-payment" data-status="pending">Pending</a></li>
          <li><a class="dropdown-item filter-status-payment" data-status="failed">Failed</a></li>
        </ul>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportPaymentsExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printPayments">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchPayments" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">+ Add Payment</button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="paymentsTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Payer</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="paymentsTableBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Payment</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addPaymentForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="paymentId" required>
          </div>
          <div class="col-md-8">
            <label>Payer</label>
            <input type="text" class="form-control" id="paymentPayer" required>
          </div>
          <div class="col-md-4">
            <label>Amount</label>
            <input type="number" class="form-control" id="paymentAmount" required>
          </div>
          <div class="col-md-4">
            <label>Date</label>
            <input type="date" class="form-control" id="paymentDate" required>
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select class="form-select" id="paymentStatus">
              <option value="paid">Paid</option>
              <option value="pending">Pending</option>
              <option value="failed">Failed</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="savePayment">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Payment Modal -->
<div class="modal fade" id="editPaymentModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Payment</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editPaymentForm" class="row g-3">
          <input type="hidden" id="editPaymentId">
          <div class="col-md-12">
            <label>Payer</label>
            <input type="text" class="form-control" id="editPaymentPayer">
          </div>
          <div class="col-md-4">
            <label>Amount</label>
            <input type="number" class="form-control" id="editPaymentAmount">
          </div>
          <div class="col-md-4">
            <label>Date</label>
            <input type="date" class="form-control" id="editPaymentDate">
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select class="form-select" id="editPaymentStatus">
              <option value="paid">Paid</option>
              <option value="pending">Pending</option>
              <option value="failed">Failed</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="savePaymentEdit">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Payment Modal -->
<div class="modal fade" id="deletePaymentModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Payment?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this payment?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeletePayment">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="tab-pane fade" id="orders">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">

      <!-- LEFT SIDE FILTER -->
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="orderStatusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item filter-order-status" data-status="all">All</a></li>
          <li><a class="dropdown-item filter-order-status" data-status="pending">Pending</a></li>
          <li><a class="dropdown-item filter-order-status" data-status="processing">Processing</a></li>
          <li><a class="dropdown-item filter-order-status" data-status="completed">Completed</a></li>
          <li><a class="dropdown-item filter-order-status" data-status="canceled">Canceled</a></li>
        </ul>
      </div>

      <!-- RIGHT SIDE ACTIONS -->
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportOrdersExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printOrders">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchOrders" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addOrderModal">
          + Add Order
        </button>
      </div>

    </div>

    <!-- TABLE AREA -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="ordersTable">
          <thead class="table-light">
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Price</th>
              <th>Order Date</th>
              <th>Delivery Date</th>
              <th>Progress</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="ordersTableBody"></tbody>
        </table>
      </div>

      <div class="mt-3 text-muted small">
        <span id="orderPaginationText">10 • 0–0 / 0</span>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Order</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="addOrderForm" class="row g-3">
          <div class="col-md-4">
            <label>Order ID</label>
            <input type="number" class="form-control" id="orderId" required>
          </div>
          
          <div class="col-md-8">
            <label>Customer Name</label>
            <input type="text" class="form-control" id="orderCustomer" required>
          </div>

          <div class="col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" id="orderPrice" required>
          </div>

          <div class="col-md-4">
            <label>Order Date</label>
            <input type="date" class="form-control" id="orderDate" required>
          </div>

          <div class="col-md-4">
            <label>Delivery Date</label>
            <input type="date" class="form-control" id="orderDelivery" required>
          </div>

          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="orderStatus">
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="canceled">Canceled</option>
            </select>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveOrder">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Edit Order</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editOrderForm" class="row g-3">

          <input type="hidden" id="editOrderId">

          <div class="col-md-12">
            <label>Customer Name</label>
            <input type="text" class="form-control" id="editOrderCustomer">
          </div>

          <div class="col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" id="editOrderPrice">
          </div>

          <div class="col-md-4">
            <label>Order Date</label>
            <input type="date" class="form-control" id="editOrderDate">
          </div>

          <div class="col-md-4">
            <label>Delivery Date</label>
            <input type="date" class="form-control" id="editOrderDelivery">
          </div>

          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="editOrderStatus">
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="canceled">Canceled</option>
            </select>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveOrderEdit">Save Changes</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="deleteOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Delete Order?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this order?
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteOrder">Delete</button>
      </div>

    </div>
  </div>
</div>
<!-- ================= ESTIMATES TAB ================= -->
<div class="tab-pane fade" id="estimates">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="estimateStatusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item estimate-filter-status" data-status="all">All</a></li>
          <li><a class="dropdown-item estimate-filter-status" data-status="draft">Draft</a></li>
          <li><a class="dropdown-item estimate-filter-status" data-status="sent">Sent</a></li>
          <li><a class="dropdown-item estimate-filter-status" data-status="accepted">Accepted</a></li>
          <li><a class="dropdown-item estimate-filter-status" data-status="declined">Declined</a></li>
        </ul>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportEstimatesExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printEstimates">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchEstimates" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEstimateModal">
          + Add estimate
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="estimatesTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Client</th>
              <th>Estimate No.</th>
              <th>Amount</th>
              <th>Issue Date</th>
              <th>Valid Until</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="estimatesTableBody"></tbody>
        </table>
      </div>

      <div class="mt-3 text-muted small">
        <span id="estimatePaginationText">10 • 0–0 / 0</span>
      </div>
    </div>
  </div>
</div>
<!-- ================= ADD ESTIMATE MODAL ================= -->
<div class="modal fade" id="addEstimateModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Estimate</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="addEstimateForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="estimateId" required>
          </div>

          <div class="col-md-8">
            <label>Client Name</label>
            <input type="text" class="form-control" id="estimateClient" required>
          </div>

          <div class="col-md-6">
            <label>Estimate Number</label>
            <input type="text" class="form-control" id="estimateNumber" required>
          </div>

          <div class="col-md-6">
            <label>Amount</label>
            <input type="number" class="form-control" id="estimateAmount" required>
          </div>

          <div class="col-md-6">
            <label>Issue Date</label>
            <input type="date" class="form-control" id="estimateIssueDate" required>
          </div>

          <div class="col-md-6">
            <label>Valid Until</label>
            <input type="date" class="form-control" id="estimateValidTill" required>
          </div>

          <div class="col-md-12">
            <label>Status</label>
            <select class="form-control" id="estimateStatus">
              <option value="draft">Draft</option>
              <option value="sent">Sent</option>
              <option value="accepted">Accepted</option>
              <option value="declined">Declined</option>
            </select>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveEstimate">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- ================= EDIT ESTIMATE MODAL ================= -->
<div class="modal fade" id="editEstimateModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Estimate</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editEstimateForm" class="row g-3">
          <input type="hidden" id="editEstimateId">

          <div class="col-md-12">
            <label>Client Name</label>
            <input type="text" class="form-control" id="editEstimateClient">
          </div>

          <div class="col-md-6">
            <label>Estimate Number</label>
            <input type="text" class="form-control" id="editEstimateNumber">
          </div>

          <div class="col-md-6">
            <label>Amount</label>
            <input type="number" class="form-control" id="editEstimateAmount">
          </div>

          <div class="col-md-6">
            <label>Issue Date</label>
            <input type="date" class="form-control" id="editEstimateIssueDate">
          </div>

          <div class="col-md-6">
            <label>Valid Until</label>
            <input type="date" class="form-control" id="editEstimateValidTill">
          </div>

          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="editEstimateStatus">
              <option value="draft">Draft</option>
              <option value="sent">Sent</option>
              <option value="accepted">Accepted</option>
              <option value="declined">Declined</option>
            </select>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveEstimateEdit">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!-- ================= DELETE ESTIMATE MODAL ================= -->
<div class="modal fade" id="deleteEstimateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Estimate?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this estimate?
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteEstimate">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- ================= PROPOSALS TAB ================= -->
<div class="tab-pane fade" id="proposals">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="proposalStatusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item proposal-filter-status" data-status="all">All</a></li>
          <li><a class="dropdown-item proposal-filter-status" data-status="draft">Draft</a></li>
          <li><a class="dropdown-item proposal-filter-status" data-status="sent">Sent</a></li>
          <li><a class="dropdown-item proposal-filter-status" data-status="accepted">Accepted</a></li>
          <li><a class="dropdown-item proposal-filter-status" data-status="rejected">Rejected</a></li>
        </ul>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportProposalsExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printProposals">Print</button>
        <input type="text" class="form-control form-control-sm" id="searchProposals" placeholder="Search" style="width:200px;">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProposalModal">
          + Add proposal
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="proposalsTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Client</th>
              <th>Proposal No.</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Valid Until</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="proposalsTableBody"></tbody>
        </table>
      </div>

      <div class="mt-3 text-muted small">
        <span id="proposalPaginationText">10 • 0–0 / 0</span>
      </div>
    </div>
  </div>
</div>

<!-- ================= ADD PROPOSAL MODAL ================= -->
<div class="modal fade" id="addProposalModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Proposal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addProposalForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="proposalId" required>
          </div>
          <div class="col-md-8">
            <label>Client Name</label>
            <input type="text" class="form-control" id="proposalClient" required>
          </div>
          <div class="col-md-6">
            <label>Proposal Number</label>
            <input type="text" class="form-control" id="proposalNumber" required>
          </div>
          <div class="col-md-6">
            <label>Amount</label>
            <input type="number" class="form-control" id="proposalAmount" required>
          </div>
          <div class="col-md-6">
            <label>Date</label>
            <input type="date" class="form-control" id="proposalDate" required>
          </div>
          <div class="col-md-6">
            <label>Valid Until</label>
            <input type="date" class="form-control" id="proposalValidTill" required>
          </div>
          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="proposalStatus">
              <option value="draft">Draft</option>
              <option value="sent">Sent</option>
              <option value="accepted">Accepted</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveProposal">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- ================= EDIT PROPOSAL MODAL ================= -->
<div class="modal fade" id="editProposalModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Proposal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editProposalForm" class="row g-3">
          <input type="hidden" id="editProposalId">
          <div class="col-md-12">
            <label>Client Name</label>
            <input type="text" class="form-control" id="editProposalClient">
          </div>
          <div class="col-md-6">
            <label>Proposal Number</label>
            <input type="text" class="form-control" id="editProposalNumber">
          </div>
          <div class="col-md-6">
            <label>Amount</label>
            <input type="number" class="form-control" id="editProposalAmount">
          </div>
          <div class="col-md-6">
            <label>Date</label>
            <input type="date" class="form-control" id="editProposalDate">
          </div>
          <div class="col-md-6">
            <label>Valid Until</label>
            <input type="date" class="form-control" id="editProposalValidTill">
          </div>
          <div class="col-md-12">
            <label>Status</label>
            <select class="form-select" id="editProposalStatus">
              <option value="draft">Draft</option>
              <option value="sent">Sent</option>
              <option value="accepted">Accepted</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveProposalEdit">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- ================= DELETE PROPOSAL MODAL ================= -->
<div class="modal fade" id="deleteProposalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Proposal?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this proposal?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteProposal">Delete</button>
      </div>
    </div>
  </div>
</div>
<div class="tab-pane fade" id="contracts">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
      
      <!-- Status Filter (optional like projects) -->
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="contractStatusFilter" data-bs-toggle="dropdown">
          Status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item contract-filter-status" data-status="all">All</a></li>
          <li><a class="dropdown-item contract-filter-status" data-status="active">Active</a></li>
          <li><a class="dropdown-item contract-filter-status" data-status="expired">Expired</a></li>
        </ul>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="exportContractsExcel">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printContracts">Print</button>

        <input type="text" class="form-control form-control-sm" id="searchContracts" placeholder="Search" style="width:200px;">

        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContractModal">
          + Add Contract
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="contractsTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Project</th>
              <th>Start date</th>
              <th>End date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="contractsTableBody"></tbody>
        </table>
      </div>

      <div class="mt-3 text-muted small">
        <span id="contractsPaginationText">10 • 0–0 / 0</span>
      </div>
    </div>

  </div>
</div>
<div class="modal fade" id="addContractModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Add Contract</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="addContractForm" class="row g-3">
          <div class="col-md-4">
            <label>ID</label>
            <input type="number" class="form-control" id="contractId" required>
          </div>

          <div class="col-md-8">
            <label>Contract Title</label>
            <input type="text" class="form-control" id="contractTitle" required>
          </div>

          <div class="col-md-6">
            <label>Start Date</label>
            <input type="date" class="form-control" id="contractStart" required>
          </div>

          <div class="col-md-6">
            <label>End Date</label>
            <input type="date" class="form-control" id="contractEnd" required>
          </div>

          <div class="col-md-6">
            <label>Amount</label>
            <input type="number" class="form-control" id="contractAmount" required>
          </div>

          <div class="col-md-6">
            <label>Related Project</label>
            <input type="text" class="form-control" id="contractProject" placeholder="Optional">
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveContract">Save</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="editContractModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Edit Contract</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editContractForm" class="row g-3">

          <input type="hidden" id="editContractId">

          <div class="col-md-12">
            <label>Contract Title</label>
            <input type="text" class="form-control" id="editContractTitle">
          </div>

          <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" class="form-control" id="editContractStart">
          </div>

          <div class="col-md-4">
            <label>End Date</label>
            <input type="date" class="form-control" id="editContractEnd">
          </div>

          <div class="col-md-4">
            <label>Amount</label>
            <input type="number" class="form-control" id="editContractAmount">
          </div>

          <div class="col-md-12">
            <label>Related Project</label>
            <input type="text" class="form-control" id="editContractProject">
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="saveContractEdit">Save Changes</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="deleteContractModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Delete Contract?</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this contract?
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteContract">Delete</button>
      </div>

    </div>
  </div>
</div>

<div class="tab-pane fade" id="files">

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
      
            </div>

            <div class="d-flex align-items-center gap-2">
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFileModal" >
        + Add files
    </button>

    <div class="input-group input-group-sm" style="max-width: 220px;">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" class="form-control" id="fileSearch" placeholder="Search">
    </div>
</div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>File</th>
                            <th>Size</th>
                            <th>Uploaded By</th>
                            <th>Created date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="filesTableBody"></tbody>
                </table>
            </div>

            <div class="mt-3 text-muted small">
                <span id="filesPaginationText">0 • 0–0 / 0</span>
            </div>
        </div>
    </div>
</div>

<!-- ================= ADD FILE MODAL ================= -->
<div class="modal fade" id="addFileModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add File</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="file" id="uploadFile" class="form-control">
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveFile">Upload</button>
      </div>
    </div>
  </div>
</div>
  <!-- ================= EXPENSES TAB ================= -->
  <div class="tab-pane fade" id="expenses">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Expenses</h5>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExpenseModal" style="width:200px; height: 35px;">
            + Add Expense
          </button>
          <input type="text" class="form-control form-control-sm" id="expenseSearch" placeholder="Search">
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Date</th>
                <th>Added By</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="expenseTableBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Expense</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="text" class="form-control mb-2" id="expTitle" placeholder="Title">
            <input type="number" class="form-control mb-2" id="expAmount" placeholder="Amount">
            <input type="text" class="form-control mb-2" id="expCategory" placeholder="Category">
            <input type="date" class="form-control mb-2" id="expDate">
            <input type="text" class="form-control mb-2" id="expAddedBy" placeholder="Added By">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveExpense">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Expense Modal -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Expense</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editExpId">
            <input type="text" class="form-control mb-2" id="editExpTitle" placeholder="Title">
            <input type="number" class="form-control mb-2" id="editExpAmount" placeholder="Amount">
            <input type="text" class="form-control mb-2" id="editExpCategory" placeholder="Category">
            <input type="date" class="form-control mb-2" id="editExpDate">
            <input type="text" class="form-control mb-2" id="editExpAddedBy" placeholder="Added By">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="updateExpense">Update</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Expense Modal -->
    <div class="modal fade" id="deleteExpenseModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Expense?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this expense?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteExpense">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="tab-pane fade" id="files">
    Files content here
  </div>
</div>

<!-- JS -->


      

         
      </div> <!-- CLOSE .container-fluid -->
    </div> <!-- CLOSE .content -->
  </div> <!-- CLOSE .content-page -->
  <?php include 'common/footer.php'; ?>
<script>

</script>
<script src="assets/js/Client-View.js"></script>

  </body>

  </html>
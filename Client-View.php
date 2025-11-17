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
            <span class="badge bg-warning text-dark fs-6 px-3 py-2" id="organization">-</span>
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
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button class="btn btn-success" id="saveProjectEdit">Save Changes</button>
                    </div>
                </div>
              </div>
            </div>
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
            <div class="modal fade" id="projectSuccessModal">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-3">
                  <div class="modal-body">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <h5 class="mt-2" id="projectSuccessText">Success!</h5>
                    <button class="btn btn-success mt-3" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="subscriptions">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Subscriptions</h5>
                  <p id="subscriptionInfo">No subscriptions found.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="invoicesTab">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Invoices</h5>
                  <p>Total Invoiced: $<span id="invoiceTotal">0</span></p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="paymentsTab">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Payments</h5>
                  <p>No payments found.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="orders">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Orders</h5>
                  <p>No orders found.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="estimates">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Estimates</h5>
                  <p>No estimates found.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="proposals">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Proposals</h5>
                  <p>No proposals found.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="contracts">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Contracts</h5>
                  <p>No contracts available.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="files">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Files</h5>
                  <p>No files uploaded.</p>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="expenses">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5>Expenses</h5>
                  <p>No expenses found.</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div> <!-- CLOSE .container-fluid -->
    </div> <!-- CLOSE .content -->
  </div> <!-- CLOSE .content-page -->
  <?php include 'common/footer.php'; ?>
<script>document.addEventListener("DOMContentLoaded", () => {

  // Load JSON file
  fetch("clientsdata.php")
    .then(response => response.json())
    .then(data => {
      loadClientData(data);
    })
    .catch(err => console.error("JSON Load Error:", err));

});


// MAIN FUNCTION TO FILL HTML
function loadClientData(data) {

  // Basic Information
  setText("clientName", data.clientName);
  setText("clientTagline", data.organization);
  setText("organization", data.organization);
  setText("clientMeta", data.meta);

  // Invoice Overview
  setText("overdue", data.invoiceOverview.overdue);
  setText("notPaid", data.invoiceOverview.notPaid);
  setText("partiallyPaid", data.invoiceOverview.partiallyPaid);
  setText("fullyPaid", data.invoiceOverview.fullyPaid);
  setText("draft", data.invoiceOverview.draft);
  setText("totalInvoiced", data.invoiceOverview.totalInvoiced);
  setText("payments", data.invoiceOverview.payments);
  setText("due", data.invoiceOverview.due);

  // Contacts
  setText("contactName", data.contacts.name);
  setText("phone", data.contacts.phone);
  setText("email", data.contacts.email);
  setText("address", data.contacts.address);

  // Recent Invoices List
  loadList("recentInvoices", data.recentInvoices, (item) =>
    `${item.id} — $${item.amount}`
  );

  // Client Info Section
  setText("organizationInfo", data.clientInfo.organization);
  setText("joinedDate", data.clientInfo.joinedDate);
  setText("clientStatus", data.clientInfo.status);

  // Website link + text
  const website = document.getElementById("clientWebsite");
  if (website) {
    website.href = data.clientInfo.website;
    website.textContent = data.clientInfo.website;
  }

  // Tasks List
  loadList("taskList", data.tasks);

  // Notes
  setText("clientNotes", data.notes);

  // Reminders
  loadList("reminderList", data.reminders);
}


// =========================
// Helper Functions
// =========================

// Set innerText safely
function setText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value;
}

// Render array as <li>
function loadList(id, array, formatter = (x) => x) {
  const listEl = document.getElementById(id);

  if (!listEl) return;

  listEl.innerHTML = ""; // clear old list

  if (!array || array.length === 0) {
    listEl.innerHTML = `<li class="list-group-item">No data available.</li>`;
    return;
  }

  array.forEach(item => {
    const li = document.createElement("li");
    li.className = "list-group-item";
    li.textContent = formatter(item);
    listEl.appendChild(li);
  });
}
</script>
  </body>

  </html>
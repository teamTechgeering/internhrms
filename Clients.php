<?php include 'common/header.php'; ?>

<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

   <?php include 'common/topnavbar.php'; ?>

    <!-- ✅ ✅ ✅ YOUR FULL CONTENT AREA STARTS HERE (UNCHANGED) -->
 
         
        <div class="container-fluid py-4">
          <!-- Tabs -->
          <ul class="nav nav-tabs mb-3" id="mainTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                type="button" role="tab">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="clients-tab" data-bs-toggle="tab" data-bs-target="#clients" type="button"
                role="tab">Clients</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button"
                role="tab">Contacts</button>
            </li>
          </ul>
          <div class="tab-content">
            <!-- === Overview Tab === -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">

              <!-- Top metric cards -->
              <div class="row g-3">
                <div class="col-sm-6 col-md-3">
                  <div class="card h-100 shadow-sm" id="card-total-clients" style="cursor:pointer;">
                    <div class="card-body d-flex align-items-center">
                      <div class="me-3">
                        <div class="bg-primary rounded p-2 d-inline-block">
                          <i class="bi bi-briefcase-fill text-white" style="font-size:1.25rem;"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 text-end">
                        <div class="text-muted small">Total clients</div>
                        <div class="h4 mb-0">49</div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3">
  <div class="card h-100 shadow-sm" id="card-total-contacts" style="cursor:pointer;">
    <div class="card-body d-flex align-items-center">
      <div class="me-3">
        <div class="bg-success rounded p-2 d-inline-block">
          <i class="bi bi-people-fill text-white" style="font-size:1.25rem;"></i>
        </div>
      </div>
      <div class="flex-grow-1 text-end">
        <div class="text-muted small">Total contacts</div>
        <div class="h4 mb-0" id="totalContactsCount">3</div>
      </div>
    </div>
  </div>
</div>


                <div class="col-sm-6 col-md-3">
                  <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                      <div class="me-3">
                        <div class="bg-info rounded p-2 d-inline-block">
                          <i class="bi bi-check2-circle text-white" style="font-size:1.25rem"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 text-end">
                        <div class="text-muted small">Contacts logged in today</div>
                        <div class="h4 mb-0">1</div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3">
                  <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                      <div class="me-3">
                        <div class="bg-secondary rounded p-2 d-inline-block">
                          <i class="bi bi-clock-history text-white" style="font-size:1.25rem"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 text-end">
                        <div class="text-muted small">Contacts logged in last 7 days</div>
                        <div class="h4 mb-0">5</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- three status cards -->
              <div class="row g-3 mt-3">
                <div class="col-md-4">
                  <div class="card shadow-sm h-100 open-client-tab">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <h6 class="mb-1">Clients has unpaid invoices</h6>
                          <small class="text-muted">6% of total clients</small>
                        </div>
                        <div class="h3 mb-0 text-muted">3</div>
                      </div>
                      <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width:12%" aria-valuenow="12"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="card shadow-sm h-100 open-client-tab">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <h6 class="mb-1">Clients has partially paid invoices</h6>
                          <small class="text-muted">10% of total clients</small>
                        </div>
                        <div class="h3 mb-0 text-muted">4</div>
                      </div>
                      <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width:22%" aria-valuenow="22"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="card shadow-sm h-100 open-client-tab">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <h6 class="mb-1">Clients has overdue invoices</h6>
                          <small class="text-muted">6% of total clients</small>
                        </div>
                        <div class="h3 mb-0 text-muted">3</div>
                      </div>
                      <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width:12%" aria-valuenow="12"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- main two-column area (projects/estimates etc) -->
              <div class="row g-3 mt-3">
                <!-- left column -->
                <div class="col-lg-8">
                  <div class="card shadow-sm mb-3">
                    <div class="card-body">
                      <h6 class="mb-3">Projects</h6>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center open-client-tab">Clients has open
                          projects <span class="badge bg-secondary rounded-pill">17</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has
                          completed projects <span class="badge bg-success rounded-pill">5</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has hold
                          projects <span class="badge bg-info rounded-pill">0</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has
                          canceled projects <span class="badge bg-danger rounded-pill">0</span></li>
                      </ul>
                    </div>
                  </div>

                  <div class="card shadow-sm mb-3">
                    <div class="card-body">
                      <h6 class="mb-3">Clients has open tickets</h6>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">76% of total clients</div>
                        <div class="h3 mb-0 text-muted">37</div>
                      </div>
                      <div class="progress mt-3" style="height:8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width:76%" aria-valuenow="76"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>

                  <div class="card shadow-sm">
                    <div class="card-body">
                      <h6 class="mb-3">Clients has new orders</h6>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">12% of total clients</div>
                        <div class="h3 mb-0 text-muted">6</div>
                      </div>
                      <div class="progress mt-3" style="height:8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width:12%" aria-valuenow="12"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- right column -->
                <div class="col-lg-4">
                  <div class="card shadow-sm mb-3">
                    <div class="card-body">
                      <h6 class="mb-3">Estimates</h6>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Client has open
                          estimates <span class="text-muted">4</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has
                          accepted estimates <span class="text-muted">9</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has new
                          estimate requests <span class="text-muted">0</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has
                          estimate requests in progress <span class="text-muted">0</span></li>
                      </ul>
                    </div>
                  </div>

                  <div class="card shadow-sm">
                    <div class="card-body">
                      <h6 class="mb-3">Proposals</h6>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has open
                          proposals <span class="text-muted">1</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has
                          accepted proposals <span class="text-muted">9</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Clients has
                          rejected proposals <span class="text-muted">3</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

            </div> <!-- end overview tab -->
            <!-- === Clients Tab === -->
            <div class="tab-pane fade" id="clients" role="tabpanel" aria-labelledby="clients-tab">
              <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                        data-bs-target="#clients-list" type="button">Clients</button></li>
                  </ul>
                  <div>
                    <button class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-tags"></i> Manage
                      labels</button>
                    <button class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-upload"></i> Import
                      clients</button>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal"><i
                        class="bi bi-plus-circle"></i> Add client</button>
                  </div>
                </div>

                <div class="card-body">
                  <!-- Filter Row -->
                  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div class="btn-group mb-2">
                      <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-funnel"></i> Filter</button>
                      <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-exclamation-circle"></i> Has
                        due</button>
                    </div>
                    <div class="btn-group mb-2">
                      <button class="btn btn-outline-secondary btn-sm" id="exportExcel">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                      </button>

                      <button class="btn btn-outline-secondary btn-sm" id="printTable"><i class="bi bi-printer"></i>
                        Print</button>
                    </div>
                    <input type="text" class="form-control form-control-sm mb-2" id="searchClient" placeholder="Search"
                      style="width:200px;">
                  </div>

                  <!-- Clients Table -->
                  <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" id="clientsTable">
                      <thead class="table-light">
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Primary contact</th>
                          <th>Phone</th>
                          <th>Client groups</th>
                          <th>Labels</th>
                          <th>Projects</th>
                          <th>Total invoiced</th>
                          <th>Payment Received</th>
                          <th>Due</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="clientsTableBody"></tbody>
                    </table>
                    <!-- CLIENTS PAGINATION -->
<div class="d-flex justify-content-between align-items-center mt-2">

    <select id="clientsRowsPerPage" class="form-select" style="width: 90px;" onchange="changeClientsRows()">
        <option value="5">5</option>
        <option value="10" selected>10</option>
        <option value="20">20</option>
    </select>

    <div class="d-flex align-items-center gap-3">
        <span id="clientsPageText">1–10 / 10</span>

        <div id="clientsPaginationNumbers" class="pagination gap-2"></div>
    </div>

</div>

                  </div>
                </div>
              </div>
            </div>

            <!-- === Add Client Modal === -->
            <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="addClientForm" class="row g-3">
                      <div class="col-md-4">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" id="clientId" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="clientName" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Primary Contact</label>
                        <input type="text" class="form-control" id="primaryContact">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Client Group</label>
                        <input type="text" class="form-control" id="clientGroup">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Labels</label>
                        <input type="text" class="form-control" id="labels">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Projects</label>
                        <input type="number" class="form-control" id="projects" value="0">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Total Invoiced</label>
                        <input type="number" class="form-control" id="totalInvoiced" value="0">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Payment Received</label>
                        <input type="number" class="form-control" id="paymentReceived" value="0">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Due</label>
                        <input type="number" class="form-control" id="due" value="0">
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveClient">Save</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                  <div class="modal-body p-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:3rem;"></i>
                    <h5 class="mt-3">Operation Successfully!</h5>
                    <button type="button" class="btn btn-success mt-3" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Edit Client Modal -->
            <div class="modal fade" id="editClientModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Client</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-2">
                      <label>Client Name</label>
                      <input type="text" id="editClientName" class="form-control" required />
                    </div>
                    <div class="mb-2">
                      <label>Primary Contact</label>
                      <input type="text" id="editPrimaryContact" class="form-control" />
                    </div>
                    <div class="mb-2">
                      <label>Phone</label>
                      <input type="text" id="editPhone" class="form-control" />
                    </div>
                    <div class="mb-2">
                      <label>Client Group</label>
                      <input type="text" id="editClientGroup" class="form-control" />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" id="saveEditChanges">Save Changes</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                  <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this client?
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- SUCCESS MODAL -->
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-3">
                  <div class="modal-header border-0">
                    <h5 class="modal-title w-100" id="successModalLabel">Success!</h5>
                  </div>
                  <div class="modal-body">
                    <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                    <p class="mb-0" id="successMessage">Operation successful!</p>
                  </div>
                  <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>


            <!-- === Contacts Tab === -->
           <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Contacts</strong>
           <button class="btn btn-primary btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#addContactModal">
    Add Contact
</button>

        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="contactsTable">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Client name</th>
                            <th>Job Title</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Skype</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="contactsBody"></tbody>
                    
                </table>
                <!-- CONTACTS PAGINATION -->
<div class="d-flex justify-content-between align-items-center mt-2">

    <select id="contactsRowsPerPage" class="form-select" style="width: 90px;" onchange="changeContactsRows()">
        <option value="5">5</option>
        <option value="10" selected>10</option>
        <option value="20">20</option>
    </select>

    <div class="d-flex align-items-center gap-3">
        <span id="contactsPageText">1–10 / 10</span>

        <div id="contactsPaginationNumbers" class="pagination gap-2"></div>
    </div>

</div>

            </div>

        </div>


<!-- ADD CONTACT MODAL -->
<div class="modal fade" id="addContactModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form id="addContactForm">

        <div class="modal-header">
          <h5 class="modal-title">Add Contact</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" name="client" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" name="job" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Skype</label>
            <input type="text" name="skype" class="form-control" />
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Contact</button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="deleteContactModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this contact?
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Success</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                Contact added successfully!
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>



        
    <!-- ✅ ✅ ✅ YOUR FULL CONTENT AREA ENDS HERE -->

  </div>
</div>
      </div>  <!-- CLOSE .content -->
    </div>    <!-- CLOSE .content-page -->


<?php include 'common/footer.php'; ?>
</body>
</html>
<script>
</script>


</body>
</html>

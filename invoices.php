<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <div class="container mt-4">

      <!-- Top row: Page title + right-side top actions -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">Invoices</h4>

        <div class="d-flex align-items-center gap-2">
          <!-- OPEN MANAGE LABELS MODAL -->
          <button class="btn btn-outline-secondary btn-sm rounded-pill"
                  data-bs-toggle="modal" data-bs-target="#manageLabelsModal">
            Manage labels
          </button>

          <button id="addPaymentBtn" class="btn btn-outline-secondary btn-sm rounded-pill">Add payment</button>
          <button id="addInvoiceMainBtn" class="btn btn-primary btn-sm rounded-pill">Add invoice</button>
        </div>
      </div>

      <!-- Tabs -->
      <ul class="nav nav-tabs mb-3" id="invoiceTabs">
    <li class="nav-item">
        <a class="nav-link active" data-tab="listTab">List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-tab="recurringTab">Recurring</a>
    </li>
</ul>

      <!-- Action row -->
      <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- LEFT group -->
        <div class="d-flex align-items-center gap-2">

          <!-- layout button -->
          <button id="layoutBtn" class="btn btn-light border rounded-3">
            <i class="bi bi-layout-sidebar"></i>
          </button>

          <!-- FILTER DROPDOWN -->
          <div class="dropdown">
            <button class="btn btn-light border rounded-3 dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-funnel"></i> Filter
            </button>
            <ul class="dropdown-menu">
              <li><button class="dropdown-item filter-option" data-value="invoice">Invoices</button></li>
              <li><button class="dropdown-item filter-option" data-value="overdue">Overdue</button></li>
            </ul>
          </div>

          <!-- plus boxed button -->
          <button id="quickAddBtn" class="btn btn-light border rounded-3">
            <i class="bi bi-plus-lg"></i>
          </button>

          <!-- Credit Notes pill -->
          <button id="creditNotesBtn" class="btn btn-outline-secondary btn-sm rounded-pill">Credit Notes</button>

          <!-- Invoices pill -->
          <button id="invoicesToggleBtn" class="btn btn-outline-secondary btn-sm rounded-pill active">Invoices</button>

          <!-- alert icon -->
          <button id="alertsBtn" class="btn btn-light border rounded-circle">
            <i class="bi bi-exclamation-triangle"></i>
          </button>

        </div>

        <!-- RIGHT group -->
        <div class="d-flex align-items-center gap-2">

          <button id="exportExcel" class="btn btn-outline-secondary btn-sm rounded-3">Excel</button>
          <button id="printBtn" class="btn btn-outline-secondary btn-sm rounded-3">Print</button>

          <div class="input-group input-group-sm" style="min-width:240px;">
            <input id="searchInput" type="search" class="form-control" placeholder="Search">
            <button class="btn btn-outline-secondary" id="searchClear"><i class="bi bi-x-lg"></i></button>
          </div>

        </div>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="invoicesTable">
          <thead class="table-light">
            <tr>
              <th>Invoice ID</th>
              <th>Client</th>
              <th>Project</th>
              <th>Bill date</th>
              <th>Due date</th>
              <th class="text-end">Total invoiced</th>
              <th class="text-end">Payment Received</th>
              <th class="text-end">Due</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="invoiceBody"></tbody>
          <tfoot class="fw-bold">
            <tr>
              <td colspan="5" class="text-end">Total</td>
              <td id="totalInvoiced" class="text-end"></td>
              <td id="totalReceived" class="text-end"></td>
              <td id="totalDue" class="text-end"></td>
              <td colspan="2"></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="d-flex justify-content-between align-items-center mt-3">

        <!-- Page size dropdown -->
        <div class="d-flex align-items-center gap-2">
          <select id="pageSize" class="form-select form-select-sm" style="width:70px;">
            <option value="10" selected>10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>

          <span id="pageInfo" class="text-muted small">1–10 / 0</span>
        </div>

        <!-- Pagination numbers -->
        <nav>
          <ul class="pagination pagination-sm mb-0" id="paginationNumbers">
            <!-- JS inserts page numbers -->
          </ul>
        </nav>

      </div>
      <!-- END PAGINATION -->
       <!-- ======================== RECURRING TAB ======================== -->
<div id="recurringTab" class="d-none">

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Invoice ID</th>
                    <th>Client</th>
                    <th>Project</th>
                    <th>Next recurring</th>
                    <th>Repeat every</th>
                    <th>Cycles</th>
                    <th>Status</th>
                    <th>Total invoiced</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="recurringBody"></tbody>

            <tfoot class="fw-bold">
                <tr>
                    <td colspan="7" class="text-end">Total</td>
                    <td id="recurringTotal" class="text-end"></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
<!-- ==================== END RECURRING TAB ==================== -->



      <!-- Add / Edit Invoice Modal -->
      <div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="invoiceModalTitle" class="modal-title">Add Invoice</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <form id="invoiceForm" class="small">
                <div class="mb-2">
                  <label class="form-label">Invoice ID</label>
                  <input id="formId" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                  <label class="form-label">Client</label>
                  <input id="formClient" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                  <label class="form-label">Project</label>
                  <input id="formProject" class="form-control form-control-sm">
                </div>
                <div class="row g-2">
                  <div class="col">
                    <label class="form-label">Bill date</label>
                    <input id="formBill" type="date" class="form-control form-control-sm">
                  </div>
                  <div class="col">
                    <label class="form-label">Due date</label>
                    <input id="formDue" type="date" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="mb-2 mt-2">
                  <label class="form-label">Total</label>
                  <input id="formTotal" type="number" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                  <label class="form-label">Status</label>
                  <select id="formStatus" class="form-select form-select-sm">
                    <option>-</option>
                    <option>Overdue</option>
                    <option>Fully paid</option>
                    <option>Not paid</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button id="saveInvoice" class="btn btn-primary btn-sm">Save</button>
              <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Add Payment Modal -->
      <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5>Add Payment</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <form id="paymentForm" class="small">
                <div class="mb-2">
                  <label class="form-label">Invoice ID</label>
                  <select id="paymentInvoiceSelect" class="form-select form-select-sm"></select>
                </div>
                <div class="mb-2">
                  <label class="form-label">Amount</label>
                  <input id="paymentAmount" type="number" class="form-control form-control-sm">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button id="savePayment" class="btn btn-primary btn-sm">Save</button>
              <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <!-- MANAGE LABEL MODAL -->
      <div class="modal fade" id="manageLabelsModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="fw-semibold">Manage labels</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

              <div class="mb-3 d-flex flex-wrap gap-2">
                <div class="bg-success rounded-2 p-3"></div>
                <div class="bg-info rounded-2 p-3"></div>
                <div class="bg-primary rounded-2 p-3"></div>
                <div class="bg-secondary rounded-2 p-3"></div>
                <div class="bg-warning rounded-2 p-3"></div>
                <div class="bg-danger rounded-2 p-3"></div>
                <div class="bg-light border rounded-2 p-3"></div>
                <div class="bg-dark rounded-2 p-3"></div>
              </div>

              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Label">
                <button class="btn btn-outline-secondary">
                  <i class="bi bi-check2-circle me-1"></i> Save
                </button>
              </div>

              <hr>

              <div class="d-flex flex-wrap gap-2">
                <span class="badge rounded-pill text-bg-danger">High Priority</span>
                <span class="badge rounded-pill text-bg-success">On track</span>
                <span class="badge rounded-pill text-bg-info">Perfect</span>
                <span class="badge rounded-pill text-bg-warning">Upcoming</span>
                <span class="badge rounded-pill text-bg-primary">Urgent</span>
              </div>

            </div>

            <div class="modal-footer">
              <button class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- container -->
  </div><!-- content -->
</div><!-- content-page -->

<?php include 'common/footer.php'; ?>
</body>
</html>
<script src="assets/js/invoices.js"></script>

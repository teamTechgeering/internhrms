<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

    <div class="container-fluid py-3">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">Contracts</h4>

        <div class="d-flex align-items-center gap-2">

          <!-- OPEN ADD MODAL -->
          <button id="openAddBtn" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#contractModal">
            <i class="bi bi-plus-lg"></i> Add contract
          </button>
        </div>
      </div>

      <!-- TOP CONTROLS -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
          <button class="btn btn-light" id="exportExcel">Excel</button>
          <button class="btn btn-light" id="printBtn">Print</button>
        </div>

        <div class="d-flex align-items-center gap-2">
          <div class="form-select" style="width:140px;">
            <select id="pageSize" class="form-select form-select-sm">
              <option value="5">5 / page</option>
              <option value="10" selected>10 / page</option>
              <option value="20">20 / page</option>
            </select>
          </div>

          <div class="input-group" style="width: 300px;">
            <input type="text" id="searchBox" class="form-control form-control-sm" placeholder="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
          </div>
        </div>
      </div>

      <!-- FILTERS -->
      <div class="row g-0">
        <div class="col-12 mb-3">
          <div class="d-flex flex-wrap gap-2">
            <div class="btn-group" role="group">
              <button class="btn btn-outline-secondary btn-sm filter-btn active" data-filter="all">All</button>
              <button class="btn btn-outline-secondary btn-sm filter-btn" data-filter="Accepted">Accepted</button>
              <button class="btn btn-outline-secondary btn-sm filter-btn" data-filter="Sent">Sent</button>
              <button class="btn btn-outline-secondary btn-sm filter-btn" data-filter="Draft">Draft</button>
            </div>
          </div>
        </div>
      </div>

      <!-- TABLE -->
      <div class="table-responsive">
        <table class="table align-middle table-hover">
          <thead>
            <tr>
              <th><a href="#" class="sort" data-key="contract_no">Contract <i class="bi bi-arrow-down-up"></i></a></th>
              <th><a href="#" class="sort" data-key="title">Title <i class="bi bi-arrow-down-up"></i></a></th>
              <th><a href="#" class="sort" data-key="client">Client <i class="bi bi-arrow-down-up"></i></a></th>
              <th>Project</th>
              <th><a href="#" class="sort" data-key="contract_date">Contract date <i class="bi bi-arrow-down-up"></i></a></th>
              <th><a href="#" class="sort" data-key="valid_until">Valid until <i class="bi bi-arrow-down-up"></i></a></th>
              <th class="text-end"><a href="#" class="sort" data-key="amount">Amount <i class="bi bi-arrow-down-up"></i></a></th>
              <th>Status</th>
              <th class="text-end"><i class="bi bi-list"></i></th>
            </tr>
          </thead>

          <tbody id="contractBody"></tbody>

          <tfoot class="fw-semibold">
            <tr>
              <td colspan="6" class="text-end">Total</td>
              <td id="totalAmount" class="text-end">$0.00</td>
              <td colspan="2"></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="d-flex justify-content-between align-items-center mt-2">
        <small id="rowsInfo" class="text-muted"></small>

        <nav>
          <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
        </nav>
      </div>

    </div>
  </div>
</div>


<!-- ============================
     ADD CONTRACT MODAL (COMPACT)
   ============================ -->
<div class="modal" id="contractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header py-2">
        <h6 class="modal-title fw-semibold" id="contractModalTitle">Add contract</h6>
        <button type="button" class="btn" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="modal-body py-2">
        <form id="contractForm" class="row g-2">

          <div class="col-3 d-flex align-items-center">Title</div>
          <div class="col-9">
            <input id="title" type="text" class="form-control form-control-sm" required placeholder="Title">
          </div>

          <div class="col-3 d-flex align-items-center">Contract date</div>
          <div class="col-9">
            <input id="contract_date" type="date" class="form-control form-control-sm">
          </div>

          <div class="col-3 d-flex align-items-center">Valid until</div>
          <div class="col-9">
            <input id="valid_until" type="date" class="form-control form-control-sm">
          </div>

          <div class="col-3 d-flex align-items-center">Client/Lead</div>
          <div class="col-9">
            <input id="client" type="text" class="form-control form-control-sm" placeholder="Client">
          </div>

          <div class="col-3 d-flex align-items-center">Project</div>
          <div class="col-9">
            <input id="project" type="text" class="form-control form-control-sm" placeholder="Project">
          </div>

          <div class="col-3 d-flex align-items-center">TAX</div>
          <div class="col-9">
            <select id="tax1" class="form-select form-select-sm">
              <option value="">-</option>
              <option value="GST">GST</option>
            </select>
          </div>

          <div class="col-3 d-flex align-items-center">Second TAX</div>
          <div class="col-9">
            <select id="tax2" class="form-select form-select-sm">
              <option value="">-</option>
              <option value="VAT">VAT</option>
            </select>
          </div>

          <div class="col-3 d-flex align-items-center">Amount</div>
          <div class="col-9">
            <input id="amount" type="number" class="form-control form-control-sm" placeholder="Amount">
          </div>

          <div class="col-3 d-flex align-items-center">Status</div>
          <div class="col-9">
            <select id="status" class="form-select form-select-sm">
              <option value="Accepted">Accepted</option>
              <option value="Sent">Sent</option>
              <option value="Draft">Draft</option>
            </select>
          </div>

          <div class="col-3 d-flex align-items-start">Note</div>
          <div class="col-9">
            <textarea id="note" rows="2" class="form-control form-control-sm" placeholder="Note"></textarea>
          </div>

        </form>
      </div>

      <div class="modal-footer py-2 d-flex justify-content-between">
        <div class="d-flex gap-2">
          <button class="btn btn-light btn-sm"><i class="bi bi-paperclip"></i> Upload</button>
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
          <button id="saveContractBtn" class="btn btn-primary btn-sm">Save</button>
        </div>
      </div>

    </div>
  </div>
</div>


<?php include 'common/footer.php'; ?>
<!-- <script src="assets/js/contract.js"></script> -->


</body>
</html>


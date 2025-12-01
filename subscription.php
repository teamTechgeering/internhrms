<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

    <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">Subscriptions</h4>
        <div>
            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#manageLabelsModal"><i class="bi bi-tags"></i> Manage labels</button>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal"><i class="bi bi-plus-circle"></i> Add subscription</button>

        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <button class="btn btn-outline-secondary me-2"><i class="bi bi-funnel"></i> Add new filter</button>
                </div>
                <div class="d-flex">
                   <button class="btn btn-outline-secondary me-2" id="btnExcel">Excel</button>
                   <button class="btn btn-outline-secondary me-3" id="btnPrint">Print</button>

                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Subscription ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Client</th>
                        <th>First billing date</th>
                        <th>Next billing date</th>
                        <th>Repeat every</th>
                        <th>Cycles</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody id="subscription-body">
                    <!-- Data Loads Here -->
                    </tbody>
                    <tfoot class="fw-bold">
                    <tr>
                        <td colspan="9" class="text-end">Total</td>
                        <td id="totalAmount">$0.00</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link">&lt;</a></li>
                        <li class="page-item active"><a class="page-link">1</a></li>
                        <li class="page-item disabled"><a class="page-link">&gt;</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Manage lebel -->
  <div class="modal fade" id="manageLabelsModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Manage labels</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Color options -->
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
                <!-- Input + Save -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Label">
                    <button class="btn btn-outline-secondary"><i class="bi bi-check2-circle me-1"></i> Save</button>
                </div>
                <hr>
                <!-- Existing labels -->
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
<!-- Add Subscription Modal -->
<div class="modal fade" id="addSubscriptionModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title fw-semibold">Add subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row g-3">

          <!-- Title (full width) -->
          <div class="col-12">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" id="subTitle" class="form-control" placeholder="Title">
          </div>

          <!-- First billing date + Client -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">
              First billing date <i class="bi bi-question-circle ms-1"></i>
            </label>
            <input type="date" id="subFirstBilling" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Client</label>
            <select id="subClient" class="form-select">
              <option>Client</option>
            </select>
          </div>

          <!-- TAX + Second TAX -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">TAX</label>
            <select id="subTax" class="form-select">
              <option>-</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Second TAX</label>
            <select id="subTax2" class="form-select">
              <option>-</option>
            </select>
          </div>

          <!-- Repeat type (side-by-side split) -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Repeat type</label>
            <input type="number" id="subRepeatValue" class="form-control" value="1">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">&nbsp;</label>
            <select id="subRepeatType" class="form-select">
              <option>Month(s)</option>
              <option>Year(s)</option>
            </select>
          </div>

          <!-- Note (full width) -->
          <div class="col-12">
            <label class="form-label fw-semibold">Note</label>
            <textarea id="subNote" class="form-control" rows="2" placeholder="Note"></textarea>
          </div>

          <!-- Labels -->
          <div class="col-12">
            <label class="form-label fw-semibold">Labels</label>
            <input type="text" id="subLabels" class="form-control" placeholder="Labels">
          </div>

        </div>

      </div>

      <div class="modal-footer d-flex justify-content-between">

        <div>
          <button class="btn btn-outline-secondary" id="btnUploadFile">
            <i class="bi bi-paperclip me-1"></i> Upload File
          </button>
          <button class="btn btn-outline-secondary" id="btnMic">
            <i class="bi bi-mic"></i>
          </button>

          <!-- hidden file input -->
          <input type="file" id="subFile" class="d-none">
        </div>

        <div>
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
          <button class="btn btn-primary" id="btnSaveSubscription">
            <i class="bi bi-save me-1"></i> Save
          </button>
        </div>

      </div>

    </div>
  </div>
</div>






     </div><!-- content -->
</div><!-- content-page -->

<?php include 'common/footer.php'; ?>
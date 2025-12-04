<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid mt-3">

    <!-- PAGE TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
            <h4 class="fw-semibold mb-0 me-4">Payment Received</h4>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="tabList" href="#">List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabChart" href="#">Chart</a>
                </li>
            </ul>
        </div>

        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="bi bi-plus-circle me-2"></i>Add payment
        </button>

    </div>

    <!-- FILTER + EXPORT + SEARCH BAR -->
    <div id="listSection">
        <div class="d-flex justify-content-between mb-3">

            <button class="btn btn-outline-secondary">
                <i class="bi bi-funnel me-2"></i>Add new filter
            </button>

            <div class="d-flex align-items-center">
                <button id="btnExcel" class="btn btn-outline-secondary me-2">Excel</button>
                <button id="btnPrint" class="btn btn-outline-secondary me-3">Print</button>

                <div class="input-group" style="width:200px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>
                            Payment date
                            <i class="bi bi-arrow-up"></i>
                        </th>
                        <th>Payment method</th>
                        <th>Note</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody id="paymentBody">
                    <!-- JS will load data -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============================= -->
    <!--         CHART SECTION         -->
    <!-- ============================= -->

    <div id="chartSection" class="d-none">

        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">

            <div class="fw-semibold d-flex align-items-center">
                <i class="bi bi-bar-chart-line me-2"></i> Chart
            </div>

            <div class="d-flex align-items-center gap-2">

                <select class="form-select" style="width:150px;">
                    <option>Currency</option>
                    <option>INR</option>
                    <option>USD</option>
                    <option>EUR</option>
                </select>

                <button class="btn btn-light">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button class="btn btn-outline-secondary">
                    2025
                </button>

                <button class="btn btn-light">
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>

        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div id="paymentChart" style="height:400px;"></div>
            </div>
        </div>

    </div>

</div>

</div>
</div>

<!-- ADD PAYMENT MODAL -->
<div class="modal" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">Add payment</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-0">
                <form id="paymentForm">

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">Payment method</label>
                        <div class="col-sm-9">
                            <select id="payMethod" class="form-control form-control-lg bg-light border-0">
                                <option disabled selected>Select method</option>
                                <option>Cash</option>
                                <option>Card</option>
                                <option>Bank Transfer</option>
                                <option>UPI</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">Payment date</label>
                        <div class="col-sm-9">
                            <input id="payDate" type="text" class="form-control form-control-lg bg-light border-0" value="27-11-2025">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">Amount</label>
                        <div class="col-sm-9">
                            <input id="payAmount" type="number" class="form-control form-control-lg bg-light border-0" value="0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-semibold">Attachment</label>
                        <div class="col-sm-9">
                            <input id="payFile" type="file" class="form-control bg-light border-0">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label fw-semibold">Note</label>
                        <div class="col-sm-9">
                            <textarea id="payNote" rows="3" class="form-control form-control-lg bg-light border-0" placeholder="Description"></textarea>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light border px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Close
                </button>
                <button id="savePaymentBtn" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i> Save
                </button>
            </div>

        </div>
    </div>
</div>

<?php include 'common/footer.php'; ?>
<script src="assets/js/payment.js"></script>
</body>
</html>

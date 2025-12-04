<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-3" id="contractContainer">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-semibold mb-1" id="contractTitle">CONTRACT TITLE</h4>
            <span class="badge" id="contractStatus">Accepted</span>
            <small id="contractDate" class="ms-2 text-muted"></small>
        </div>

        <div>
            <button class="btn btn-outline-primary btn-sm">Contract URL</button>
        </div>
    </div>


    <div class="row">

        <!-- LEFT SIDE MAIN AREA -->
        <div class="col-lg-8">

            <!-- CONTRACT ITEMS BOX -->
            <div class="card mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">Contract Items</h6>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody id="itemBody"></tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="mt-2">
                        <div class="d-flex justify-content-between">
                            <span>Sub Total</span>
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Discount</span>
                            <span>$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-semibold">
                            <span>Total</span>
                            <span id="totalAmount">$0.00</span>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-sm mt-3">Add Item</button>

                </div>
            </div>

            <!-- CONTRACT TEMPLATE TEXT AREA -->
            <div class="card mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-light btn-sm">Change template</button>

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm">Save</button>
                            <button class="btn btn-primary btn-sm">Save & show</button>
                        </div>
                    </div>

                    <textarea class="form-control mt-3" rows="10" id="contractBodyText">
                    </textarea>

                </div>
            </div>

            <!-- LONG CONTRACT PREVIEW -->
            <div class="card mb-5">
                <div class="card-body" id="contractLongPreview">
                    <!-- Filled by JS -->
                </div>
            </div>

        </div>


        <!-- RIGHT SIDE PANEL -->
        <div class="col-lg-4">

            <!-- CONTRACT INFO -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Contract info</h6>

                    <div>
                        <div class="fw-semibold" id="clientName">Client Name</div>
                        <small>Email: <span id="clientEmail">-</span></small><br>
                        <small>Contract date: <span id="infoContractDate"></span></small><br>
                        <small>Valid until: <span id="infoValidUntil"></span></small>
                    </div>

                    <div class="mt-3 d-flex flex-column gap-2">
                        <button class="btn btn-light btn-sm">Preview</button>
                        <button class="btn btn-light btn-sm">Print</button>
                        <button class="btn btn-light btn-sm">View PDF</button>
                        <button class="btn btn-light btn-sm">Download PDF</button>
                    </div>

                </div>
            </div>

            <!-- NOTE -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-2">Note</h6>
                    <p class="text-muted mb-0" id="noteText">No note.</p>
                </div>
            </div>

            <!-- SIGNER INFO -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Signer info (Client)</h6>
                    <p class="mb-1"><strong>Name:</strong> <span id="signerName">Emily Smith</span></p>
                    <p class="mb-0"><strong>Email:</strong> <span id="signerEmail">client@demo.com</span></p>
                </div>
            </div>

            <!-- TASKS -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Tasks</h6>
                    <button class="btn btn-light btn-sm">+ Add task</button>
                </div>
            </div>

            <!-- REMINDERS -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Reminders (Private)</h6>
                    <button class="btn btn-light btn-sm">+ Add reminder</button>
                </div>
            </div>

        </div>

    </div>

</div>
</div>
</div>

<?php include 'common/footer.php'; ?>
<script src="assets/js/contract.js"></script>
</body>
</html>

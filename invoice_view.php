<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container py-3">

    <!-- HEADER SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0" id="invoiceNumber">INV #26</h4>

        <div>
            <button class="btn btn-primary btn-sm" id="emailInvoiceBtn">
                <i class="bi bi-envelope"></i> Email invoice to client
            </button>
        </div>
    </div>

    <!-- BADGES ROW -->
    <div class="d-flex gap-2 mb-3">
        <span class="badge bg-danger" id="invoiceStatus">Overdue</span>
        <button class="btn btn-outline-secondary btn-sm">Add Label</button>
        <button class="btn btn-outline-secondary btn-sm">Never</button>
    </div>

    <!-- MAIN TWO-COLUMN LAYOUT -->
    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-lg-8">

            <div class="card mb-3">
                <div class="card-body">

                    <!-- COMPANY + BILLING -->
                    <div class="row">
                        <div class="col-md-6">

                            <!-- LOGO -->
                            <img src="assets/images/tech-logo21.webp" alt="Company Logo" class="img-fluid mb-2" style="max-height: 80px;">

                            <p class="mb-1 fw-semibold" id="companyName">Awesome IT Company</p>
                            <p class="mb-1">86935 Greenholt Forges</p>
                            <p class="mb-1">Bhubaneswar, 751012</p>
                            <p class="mb-1">Phone: +91 8480889880</p>
                            <p class="mb-1">Email: info@techgeering.com</p>
                            <p class="mb-1">Website: https://www.techgeering.in/</p>

                        </div>

                        <div class="col-md-6 text-md-end mt-3 mt-md-0">

                            <h5 class="fw-bold bg-dark text-white d-inline-block px-3 py-1" id="invoiceCode">
                                INV #26
                            </h5>

                            <p class="mt-2 mb-1" id="billDate">Bill date: 18-10-2025</p>
                            <p class="mb-3" id="dueDate">Due date: 01-11-2025</p>

                            <p class="fw-bold mb-1">Bill To</p>
                            <p class="mb-1" id="clientName">Adrain Ondricka</p>
                            <p class="mb-1">308 Thad Row</p>
                            <p class="mb-1">Lake Macmouth</p>
                            <p class="mb-1">Tennessee</p>
                            <p class="mb-1">Andorra</p>

                        </div>
                    </div>

                    <hr>

                    <!-- ITEMS TABLE -->
                    <h6 class="fw-bold mb-3">Items</h6>

                    <div class="table-responsive">
                        <table class="table align-middle" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="itemRows">

                                <!-- Default Item Row -->
                                <tr>
                                    <td>
                                        <div class="fw-semibold">Custom app development</div>
                                        <div class="text-muted small">App for your business</div>
                                    </td>
                                    <td>2 PC</td>
                                    <td>$1,000.00</td>
                                    <td>$2,000.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary btn-edit-item"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary btn-delete-item"><i class="bi bi-x-lg"></i></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-outline-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="bi bi-plus-lg"></i> Add item
                    </button>

                    <!-- TOTALS -->
                    <table class="table">
                        <tr>
                            <td class="fw-semibold">Sub Total</td>
                            <td class="text-end" id="subTotal">$2,000.00</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Discount</td>
                            <td class="text-end" id="discountAmount">$0.00</td>
                        </tr>
                        <tr class="table-light">
                            <td class="fw-bold">Balance Due</td>
                            <td class="fw-bold text-end" id="balanceDue">$2,000.00</td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>

        <!-- RIGHT SIDEBAR -->
<div class="col-lg-4">

   <!-- INVOICE INFO -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
        Invoice info

        <!-- 3 DOT DROPDOWN -->
        <div class="dropdown">
            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
            </button>

            <!-- FLOATING MENU -->
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">

                <li>
                    <button class="dropdown-item py-2" onclick="window.location='invoice_edit.php'">
                        <i class="bi bi-pencil-square me-2"></i> Edit invoice
                    </button>
                </li>

                <li>
                    <button class="dropdown-item py-2" onclick="markCancelled()">
                        <i class="bi bi-x-lg me-2"></i> Mark as cancelled
                    </button>
                </li>

                <li>
                    <button class="dropdown-item py-2" onclick="window.location='create_credit_note.php'">
                        <i class="bi bi-file-earmark-plus me-2"></i> Create credit note
                    </button>
                </li>

                <li>
                    <button class="dropdown-item py-2" onclick="cloneInvoice()">
                        <i class="bi bi-files me-2"></i> Clone Invoice
                    </button>
                </li>

            </ul>
        </div>

    </div>

    <div class="list-group list-group-flush">

        <!-- CLIENT CLICKABLE -->
        <button class="list-group-item list-group-item-action text-primary d-flex align-items-center"
                onclick="window.location='Client-View.php?id=1'">
            <i class="bi bi-person me-2"></i>
            <span id="sidebarClientName">Adrain Ondricka</span>
        </button>

        <!-- PROJECT CLICKABLE -->
        <button class="list-group-item list-group-item-action text-primary d-flex align-items-center"
                onclick="window.location='project_detail.php?id=12'">
            <i class="bi bi-keyboard me-2"></i>
            Social Media Content Calendar
        </button>

    </div>
</div>



    <!-- PREVIEW / PRINT -->
    <div class="card shadow-sm border-0 mb-3">

        <div class="list-group list-group-flush">

            <div class="d-flex">
                <button id="previewBtn" class="list-group-item list-group-item-action border-end flex-fill text-primary d-flex align-items-center">
                    <i class="bi bi-eye me-2"></i> Preview
                </button>

                <button id="printBtn" class="list-group-item list-group-item-action flex-fill text-primary d-flex align-items-center">
                    <i class="bi bi-printer me-2"></i> Print
                </button>
            </div>

            <div class="d-flex">
                <button id="viewPdfBtn" class="list-group-item list-group-item-action border-end flex-fill text-primary d-flex align-items-center">
                    <i class="bi bi-filetype-pdf me-2"></i> View PDF
                </button>

                <button id="downloadPdfBtn" class="list-group-item list-group-item-action flex-fill text-primary d-flex align-items-center">
                    <i class="bi bi-download me-2"></i> Download PDF
                </button>
            </div>

        </div>
    </div>


    <!-- PAYMENTS -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-white fw-semibold">
            Payments
        </div>

        <div class="list-group list-group-flush">
            <button class="list-group-item list-group-item-action text-primary d-flex align-items-center" 
                    data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="bi bi-plus-lg me-2"></i> Add payment
            </button>
        </div>
    </div>


    <!-- TASKS -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-white fw-semibold">
            Tasks
        </div>

        <div class="list-group list-group-flush">
            <button class="list-group-item list-group-item-action text-primary d-flex align-items-center" 
                    data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-lg me-2"></i> Add task
            </button>
        </div>
    </div>

<!-- REMINDERS -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white fw-semibold d-flex align-items-center">
        <i class="bi bi-clock-history me-2"></i> Reminders (Private)
    </div>

    <div class="list-group list-group-flush">

        <!-- OPEN FORM BUTTON -->
        <button 
            class="list-group-item list-group-item-action text-primary d-flex align-items-center"
            id="openReminderFormBtn">
            <i class="bi bi-plus-lg me-2"></i> Add reminder
        </button>

        <!-- REMINDER FORM (HIDDEN BY DEFAULT) -->
        <div class="p-3 d-none" id="reminderFormBox">

            <input id="remTitle" class="form-control mb-2" placeholder="Title">

            <div class="row mb-2">
                <div class="col">
                    <input id="remDate" type="date" class="form-control" placeholder="Date">
                </div>
                <div class="col">
                    <input id="remTime" type="time" class="form-control" placeholder="Time">
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remRepeat">
                <label class="form-check-label" for="remRepeat">
                    Repeat <i class="bi bi-question-circle ms-1"></i>
                </label>
            </div>

            <button class="btn btn-primary w-100" id="addReminderBtn">
                <i class="bi bi-check-circle me-1"></i> Add
            </button>
        </div>

        <!-- SAVED REMINDERS LIST -->
        <ul id="reminderList" class="list-group small"></ul>

    </div>
</div>


</div>


    </div>
</div>

</div>
</div>

<?php include 'common/footer.php'; ?>
</body>
</html>

<!-- ---------------- MODALS ---------------- -->

<!-- ADD ITEM MODAL -->
<div class="modal fade" id="addItemModal">
<div class="modal-dialog">
<div class="modal-content">

    <div class="modal-header"><h5 class="modal-title">Add Item</h5></div>

    <div class="modal-body">
        <input class="form-control mb-2" id="itemTitle" placeholder="Item title">
        <input class="form-control mb-2" id="itemDesc" placeholder="Description">
        <input class="form-control mb-2" id="itemQty" placeholder="Quantity">
        <input class="form-control mb-2" id="itemRate" placeholder="Rate">
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary btn-sm" id="saveNewItem">Save</button>
        <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
    </div>

</div>
</div>
</div>

<!-- ADD PAYMENT MODAL -->
<div class="modal fade" id="addPaymentModal" tabindex="-1">
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

<!-- ADD TASK MODAL -->
<div class="modal fade" id="addTaskModal">
<div class="modal-dialog">
<div class="modal-content">

    <div class="modal-header"><h5 class="modal-title">Add Task</h5></div>

    <div class="modal-body">
        <input class="form-control mb-2" id="taskName" placeholder="Task name">
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary btn-sm" id="saveTask">Save</button>
        <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
    </div>

</div>
</div>
</div>
<!-- ============================= -->
<!--    EMAIL INVOICE MODAL       -->
<!-- ============================= -->

<div class="modal fade" id="emailInvoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">

            <!-- PAGE 1 -->
            <div id="emailStep1">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Email Invoice</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-semibold">To</label>
                        <input type="email" class="form-control form-control-lg bg-light border-0" id="emailTo" placeholder="client@email.com">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Subject</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" id="emailSubject" value="Invoice INV #26">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Message</label>
                        <textarea class="form-control form-control-lg bg-light border-0" id="emailMessage" rows="5">Hi, please find your invoice attached.</textarea>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="attachPdf">
                        <label class="form-check-label fw-semibold" for="attachPdf">Attach invoice as PDF</label>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary px-4" id="goToStep2">Next</button>
                </div>
            </div>

            <!-- PAGE 2 -->
            <div id="emailStep2" class="d-none">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Confirm & Send</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="p-3 bg-light rounded-3">
                        <p class="fw-semibold mb-1">To: <span id="confirmEmailTo"></span></p>
                        <p class="fw-semibold mb-1">Subject: <span id="confirmEmailSubject"></span></p>
                        <p class="fw-semibold">PDF Attached: <span id="confirmAttach"></span></p>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-outline-secondary px-4" id="backToStep1">Back</button>
                    <button class="btn btn-success px-4" id="sendEmailBtn">
                        <i class="bi bi-send me-1"></i> Send
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- JS LOGIC -->
<script>


</script>

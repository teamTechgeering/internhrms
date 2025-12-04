<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
    <div class="content">

        <div class="container-fluid p-4" style="max-width:1300px">

            <!-- TOP BAR -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-semibold mb-0">PROPOSAL #9</h4>
                <div>
                    <a href="proposal-preview.php"> <button class="btn btn-outline-secondary me-2">

                            <i class="fa fa-link me-2"></i> Proposal URL
                        </button></a>


                </div>
            </div>

            <!-- STATUS + DATE -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="badge bg-primary px-3 py-2">Accepted</span>
                <span class="text-muted">20-10-2025</span>
            </div>

            <div class="row">

                <!-- LEFT MAIN COLUMN -->
                <div class="col-lg-8">

                    <!-- PROPOSAL ITEMS CARD -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-semibold">
                            Proposal items
                        </div>
                        <div class="card-body">

                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody id="proposalItemsTable">

                                </tbody>
                            </table>

                            <button class="btn btn-light mt-2" id="addItemBtn">
                                <i class="fa fa-plus"></i> Add Item
                            </button>

                        </div>

                        <div class="card-footer bg-white text-end">
                            <div>Sub Total: <b>$100.00</b></div>
                            <div>Discount: <b>$0.00</b></div>
                            <div class="fw-bold fs-5 mt-2">Total: $100.00</div>
                        </div>
                    </div>

                    <!-- MAIN PROPOSAL BODY -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-semibold">
                            <button class="btn btn-light btn-sm">Proposal Template</button>
                        </div>

                        <div class="card-body">
                            <div id="editorToolbar" class="mb-2">
                                <!-- WYSIWYG Tools here (icons) -->
                            </div>

                            <div id="proposalContent" class="p-3" style="min-height:300px; background:#fff;">
                                <h2>Web Design Proposal</h2>
                                <img src="assets/images/notebook.png" class="img-fluid mb-3">
                                <p>In response to the growing demands...</p>

                                <h3>Our Best Offer</h3>
                                <p>We aim to deliver best value...</p>

                                <h3>Our Objective</h3>
                                <img src="assets/images/home4.png" class="img-fluid mb-3">
                                <p>Our objective is to align...</p>

                                <h3>Our Portfolio</h3>
                                <img src="assets/images/content.jpg" class="img-fluid mb-3">

                                <h3 class="mt-4">Let's Connect</h3>
                                <p>We are excited about the chance to collaborate...</p>
                            </div>

                            <div class="mt-3 text-end">
                        
                                <button class="btn btn-success">Save & show</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDEBAR -->
                <div class="col-lg-4">

                    <!-- PROPOSAL INFO -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Proposal info</h6>
                            <div class="mb-3">
                                <p class="mb-1">Name: <a href="Client-view.php">Jane Hand</a></p>
                                <p class="mb-0">Proposal Date: 20-10-2025</p>
                                <p class="mb-0">Valid until: 20-12-2025</p>
                                <p class="mb-0">Created: 20-10-2025, 12:21</p>
                            </div>
                        </div>
                    </div>

                    <!-- NOTE -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Note</h6>
                            <p class="text-muted">Voluptatibus re non aliquid.</p>
                        </div>
                    </div>
                    <!-- Preview and Print -->
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

                    <!-- SIGNER INFO -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Signer info</h6>
                            <p class="mb-1">Name: <a href="Client-view.php">Jane Hand</a></p>
                            <p class="mb-1">Email: jane.hand@demo.com</p>
                        </div>
                    </div>

                    <!-- TASKS -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Tasks</h6>
                            <button class="btn btn-light btn-sm" id="addTaskBtn">+ Add task</button>

                            <div id="taskList" class="mt-2"></div>



                        </div>
                    </div>

                    <!-- REMINDERS -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Reminders (Private)</h6>
                            <button class="btn btn-light btn-sm" id="addReminderBtn">+ Add reminder</button>

                            <div id="reminderList" class="mt-2"></div>

                        </div>
                    </div>

                </div>

            </div><!-- row end -->

        </div><!-- container end -->

    </div>
</div>
<!-- ADD / EDIT ITEM MODAL -->
<div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Item</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="itemIndex">

                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" id="itemName" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea id="itemDesc" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="text" id="itemQty" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Rate</label>
                    <input type="number" id="itemRate" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveItemBtn">Save Item</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="saveSuccessModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <h5 class="fw-bold">Saved Successfully!</h5>
            <p class="text-muted">Your proposal has been updated.</p>
            <button class="btn btn-primary w-50 mx-auto" data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteItemModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <h5 class="fw-bold">Delete Item?</h5>
            <p>Are you sure you want to remove this item?</p>
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" id="confirmDeleteItem">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="taskModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5 class="fw-bold">Add Task</h5>
            <input id="taskInput" class="form-control mt-2" placeholder="Task name">
            <button class="btn btn-primary mt-3" id="saveTaskBtn">Save Task</button>
        </div>
    </div>
</div>
<div class="modal fade" id="reminderModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">

            <h5 class="fw-bold mb-2">Add Reminder</h5>

            <!-- Reminder text -->
            <input id="reminderInput" class="form-control mt-2" placeholder="Reminder text">

            <!-- Reminder date -->
            <label class="mt-3 fw-semibold">Reminder Date</label>
            <input id="reminderDate" type="date" class="form-control">

            <!-- Save button -->
            <button class="btn btn-primary mt-3" id="saveReminderBtn">Save Reminder</button>

        </div>
    </div>
</div>




<?php include 'common/footer.php'; ?>

<script>

   /* ============================================================
   PROPOSAL VIEW PAGE — FULL DYNAMIC LOGIC (FIXED VERSION)
   ============================================================ */

let proposal = {};
let proposalId = null;
let deleteIndex = null;

document.addEventListener("DOMContentLoaded", () => {

    /* -----------------------------------------
       GET PROPOSAL ID FROM URL
    ----------------------------------------- */
    const params = new URLSearchParams(window.location.search);
    proposalId = params.get("id") || 9;

    loadProposal();

    /* -----------------------------------------
       TOP BAR BUTTONS
    ----------------------------------------- */
    document.getElementById("previewBtn")?.addEventListener("click", openPreview);
    document.getElementById("printBtn")?.addEventListener("click", printProposal);
    document.getElementById("viewPdfBtn")?.addEventListener("click", viewPdf);
    document.getElementById("downloadPdfBtn")?.addEventListener("click", downloadPdf);

    /* -----------------------------------------
       ITEM BUTTONS
    ----------------------------------------- */
    document.getElementById("addItemBtn")?.addEventListener("click", openAddItem);
    document.getElementById("saveItemBtn")?.addEventListener("click", saveItem);

    /* -----------------------------------------
       TASK + REMINDER BUTTONS
    ----------------------------------------- */
    document.getElementById("addTaskBtn")?.addEventListener("click", () => {
        new bootstrap.Modal(document.getElementById("taskModal")).show();
    });

    document.getElementById("addReminderBtn")?.addEventListener("click", () => {
        new bootstrap.Modal(document.getElementById("reminderModal")).show();
    });

    /* -----------------------------------------
       DELETE ITEM CONFIRM
    ----------------------------------------- */
    document.getElementById("confirmDeleteItem")?.addEventListener("click", () => {
        proposal.items.splice(deleteIndex, 1);
        renderItems();
        renderTotals();
        bootstrap.Modal.getInstance(document.getElementById("deleteItemModal")).hide();
    });

    /* -----------------------------------------
       SAVE PAGE + SAVE & SHOW
    ----------------------------------------- */

    // ❌ REMOVED (WRONG SELECTOR THAT BROKE EVERYTHING)
    // document.querySelector(".card-body .btn.btn-primary")?.addEventListener("click", savePage);

    // ✅ FIXED — correctly attach Save & Show
    document.querySelector(".card-body .btn.btn-success")?.addEventListener("click", saveAndShow);

    /* -----------------------------------------
       TASK SAVE
    ----------------------------------------- */
    document.getElementById("saveTaskBtn")?.addEventListener("click", () => {
        let task = document.getElementById("taskInput").value.trim();
        if (!task) {
            alert("Enter a task name");
            return;
        }

        if (!proposal.tasks) proposal.tasks = [];
        proposal.tasks.push(task);

        localStorage.setItem("proposal_" + proposalId, JSON.stringify(proposal));

        renderTasks();
        bootstrap.Modal.getInstance(document.getElementById("taskModal")).hide();
        document.getElementById("taskInput").value = "";
    });

    /* -----------------------------------------
       REMINDER SAVE
    ----------------------------------------- */
    document.getElementById("saveReminderBtn")?.addEventListener("click", () => {
        let text = document.getElementById("reminderInput").value.trim();
        let date = document.getElementById("reminderDate")?.value || "";

        if (!text) {
            alert("Enter reminder");
            return;
        }

        if (!proposal.reminders) proposal.reminders = [];

        proposal.reminders.push({ text, date });

        localStorage.setItem("proposal_" + proposalId, JSON.stringify(proposal));

        renderReminders();
        bootstrap.Modal.getInstance(document.getElementById("reminderModal")).hide();

        document.getElementById("reminderInput").value = "";
        if (document.getElementById("reminderDate")) {
            document.getElementById("reminderDate").value = "";
        }
    });

});  // END DOMContentLoaded



/* ============================================================
   LOAD PROPOSAL FROM JSON
============================================================ */
function loadProposal() {
    fetch("proposal-view-json.php?id=" + proposalId)
        .then(res => res.json())
        .then(d => {
            proposal = Array.isArray(d) ? d[0] : d;
            proposal.items = proposal.items || [];
            renderPage();
        })
        .catch(err => console.error("JSON Load Error:", err));
}


/* ============================================================
   RENDER FULL PAGE
============================================================ */
function renderPage() {

    // TOP BAR
    document.querySelector("h4").innerText = proposal.proposal_no;
    document.querySelector(".badge").innerText = proposal.status;
    document.querySelector(".text-muted").innerText = proposal.proposal_date;

    // SIDEBAR INFO
    document.querySelectorAll(".card-body")[0].innerHTML = `
        <h6 class="fw-bold">Proposal info</h6>
        <div class="mb-3">
            <p class="mb-1">Name: <a href="#">${proposal.client_name}</a></p>
            <p class="mb-0">Proposal Date: ${proposal.proposal_date}</p>
            <p class="mb-0">Valid until: ${proposal.valid_until}</p>
            <p class="mb-0">Created: ${proposal.proposal_date}, 12:21</p>
        </div>
    `;

    // NOTE
    document.querySelectorAll(".card-body")[1].innerHTML = `
        <h6 class="fw-bold">Note</h6>
        <p class="text-muted">${proposal.note}</p>
    `;

    // SIGNER
    document.querySelectorAll(".card-body")[3].innerHTML = `
        <h6 class="fw-bold">Signer info</h6>
        <p class="mb-1">Name: <a href="#">${proposal.signer_name}</a></p>
        <p class="mb-1">Email: ${proposal.signer_email}</p>
    `;

    // MAIN CONTENT
    document.getElementById("proposalContent").innerHTML = proposal.content_html;

    // ITEMS
    renderItems();
    renderTotals();
}



/* ============================================================
   RENDER ITEMS
============================================================ */
function renderItems() {
    const tbody = document.getElementById("proposalItemsTable");
    tbody.innerHTML = "";

    proposal.items.forEach((item, index) => {
        let row = document.createElement("tr");

        row.innerHTML = `
            <td>${item.item}<br><small class="text-muted">${item.description}</small></td>
            <td>${item.quantity}</td>
            <td>$${Number(item.rate).toFixed(2)}</td>
            <td>$${Number(item.total).toFixed(2)}</td>
            <td>
                <button class="btn btn-sm btn-light" onclick="editItem(${index})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-light text-danger" onclick="deleteItem(${index})"><i class="fa fa-trash"></i></button>
            </td>
        `;

        tbody.appendChild(row);
    });
}



/* ============================================================
   RENDER TOTALS
============================================================ */
function renderTotals() {
    let subtotal = proposal.items.reduce((sum, i) => sum + Number(i.total), 0);

    document.querySelector(".card-footer").innerHTML = `
        <div>Sub Total: <b>$${subtotal.toFixed(2)}</b></div>
        <div>Discount: <b>$0.00</b></div>
        <div class="fw-bold fs-5 mt-2">Total: $${subtotal.toFixed(2)}</div>
    `;
}



/* ============================================================
   ADD ITEM
============================================================ */
function openAddItem() {
    document.getElementById("itemIndex").value = -1;
    document.querySelector("#itemModal .modal-title").innerText = "Add Item";

    document.getElementById("itemName").value = "";
    document.getElementById("itemDesc").value = "";
    document.getElementById("itemQty").value = "";
    document.getElementById("itemRate").value = "";

    new bootstrap.Modal(document.getElementById("itemModal")).show();
}



/* ============================================================
   EDIT ITEM
============================================================ */
function editItem(index) {
    let i = proposal.items[index];

    document.getElementById("itemIndex").value = index;

    document.querySelector("#itemModal .modal-title").innerText = "Edit Item";

    document.getElementById("itemName").value = i.item;
    document.getElementById("itemDesc").value = i.description;
    document.getElementById("itemQty").value = i.quantity;
    document.getElementById("itemRate").value = i.rate;

    new bootstrap.Modal(document.getElementById("itemModal")).show();
}
window.editItem = editItem;



/* ============================================================
   SAVE ITEM  ✅ WORKS NOW
============================================================ */
function saveItem() {
    // Ensure proposal and proposal.items are defined
    if (!window.proposal) {
        window.proposal = {}; // Initialize proposal if undefined
    }
    
    if (!proposal.items) {
        proposal.items = []; // Initialize items if undefined
    }

    let index = Number(document.getElementById("itemIndex").value);
    let qty = Number(document.getElementById("itemQty").value);
    let rate = Number(document.getElementById("itemRate").value);

    let obj = {
        item: document.getElementById("itemName").value,
        description: document.getElementById("itemDesc").value,
        quantity: qty,
        rate: rate,
        total: qty * rate
    };

    if (index === -1) {
        proposal.items.push(obj); // Add new item to the array
    } else {
        proposal.items[index] = obj; // Update existing item
    }

    // Hide modal and show success message
    bootstrap.Modal.getInstance(document.getElementById("itemModal")).hide();

    renderItems();
    renderTotals();

    new bootstrap.Modal(document.getElementById("saveSuccessModal")).show();
}




/* ============================================================
   DELETE ITEM
============================================================ */
function deleteItem(index) {
    deleteIndex = index;
    new bootstrap.Modal(document.getElementById("deleteItemModal")).show();
}
window.deleteItem = deleteItem;



/* ============================================================
   PREVIEW / PRINT / PDF
============================================================ */
function openPreview() {
    window.open("proposal-preview.php?id=" + proposalId, "_blank");
}

function printProposal() {
    window.open("proposal-preview.php?id=" + proposalId + "&print=1", "_blank");
}

function viewPdf() {
    window.open("proposal-preview.php?id=" + proposalId + "&pdf=1", "_blank");
}

function downloadPdf() {
    window.open("proposal-preview.php?id=" + proposalId + "&download=1", "_blank");
}



/* ============================================================
   SAVE PAGE
============================================================ */
function savePage() {
    proposal.content_html = document.getElementById("proposalContent").innerHTML;

    localStorage.setItem("proposal_" + proposalId, JSON.stringify(proposal));

    alert("Saved successfully!");
}



/* ============================================================
   SAVE & SHOW
============================================================ */
function saveAndShow() {
    savePage();
    openPreview();
}



/* ============================================================
   RENDER TASKS
============================================================ */
function renderTasks() {
    const box = document.getElementById("taskList");
    box.innerHTML = "";

    if (!proposal.tasks || proposal.tasks.length === 0) {
        box.innerHTML = `<p class='text-muted small'>No tasks added.</p>`;
        return;
    }

    proposal.tasks.forEach(t => {
        box.innerHTML += `<div class='small mb-1'>• ${t}</div>`;
    });
}



/* ============================================================
   RENDER REMINDERS
============================================================ */
function renderReminders() {
    const box = document.getElementById("reminderList");
    box.innerHTML = "";

    if (!proposal.reminders || proposal.reminders.length === 0) {
        box.innerHTML = `<p class='text-muted small'>No reminders added.</p>`;
        return;
    }

    proposal.reminders.forEach(r => {
        box.innerHTML += `
            <div class='small mb-2'>
                • ${r.text}<br>
                <span class='text-muted'>${r.date || ""}</span>
            </div>
        `;
    });
}
</script>


</body>

</html>
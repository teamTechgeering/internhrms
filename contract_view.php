<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
    <div class="content">

        <?php include 'common/topnavbar.php'; ?>

        <div class="container-fluid p-4" style="max-width:1300px" id="contractContainer">

            <!-- TOP BAR -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-semibold mb-0" id="invoiceNumber">PROPOSAL #0</h4>
                <div>
                    <a id="proposalUrl" href="contract_preview.php"><button class="btn btn-outline-secondary me-2">
                        <i class="fa fa-link me-2"></i> Proposal URL
                    </button></a>
                </div>
            </div>

            <!-- STATUS + DATE -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="badge bg-primary px-3 py-2" id="invoiceStatus">Status</span>
                <span class="text-muted" id="contractDateText">--</span>
            </div>

            <div class="row">

                <!-- LEFT MAIN COLUMN -->
                <div class="col-lg-8">

                    <!-- ITEMS CARD -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-semibold">
                            Contract items
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

                                <tbody id="itemRows"></tbody>
                            </table>

                            <button class="btn btn-light mt-2" id="addItemBtn">
                                <i class="fa fa-plus"></i> Add Item
                            </button>

                        </div>

                        <div class="card-footer bg-white text-end">
                            <div>Sub Total: <b id="subTotal">$0.00</b></div>
                            <div>Discount: <b id="discountAmount">$0.00</b></div>
                            <div class="fw-bold fs-5 mt-2">Total: <span id="balanceDue">$0.00</span></div>
                        </div>
                    </div>

                    <!-- MAIN CONTRACT BODY -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-semibold">
                            <button class="btn btn-light btn-sm">Contract Template</button>
                        </div>

                        <div class="card-body">
                            <div id="editorToolbar" class="mb-2"></div>

                            <div id="proposalContent" class="p-3" style="min-height:300px; background:#fff;">
                                <!-- Filled from JSON -->
                            </div>

                            <div class="mt-3 text-end">
                                <button class="btn btn-success" id="saveAndShowBtn">Save & show</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDEBAR -->
                <div class="col-lg-4">

                    <!-- CONTRACT INFO -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Contract info</h6>
                            <div class="mb-3">
                                <p class="mb-1">Name: <a href="#" id="sidebarClientLink">Client</a></p>
                                <p class="mb-0">Contract Date: <span id="infoContractDate">--</span></p>
                                <p class="mb-0">Valid until: <span id="infoValidUntil">--</span></p>
                                <p class="mb-0">Created: <span id="createdAt">--</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- NOTE -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Note</h6>
                            <p class="text-muted" id="noteText">No note.</p>
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

                    <!-- SIGNER INFO -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold">Signer info</h6>
                            <p class="mb-1">Name: <a href="#" id="signerName">—</a></p>
                            <p class="mb-1">Email: <span id="signerEmail">—</span></p>
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
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="itemModalTitle">Add Item</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="itemIndex">
                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" id="itemTitle" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea id="itemDesc" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" id="itemQty" class="form-control" value="1" min="1">
                </div>

                <div class="mb-3">
                    <label>Rate</label>
                    <input type="number" id="itemRate" class="form-control" value="0" step="0.01">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveItemBtn">Save Item</button>
            </div>

        </div>
    </div>
</div>

<!-- ADD TASK MODAL -->
<div class="modal fade" id="taskModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5 class="fw-bold">Add Task</h5>
            <input id="taskInput" class="form-control mt-2" placeholder="Task name">
            <button class="btn btn-primary mt-3" id="saveTaskBtn">Save Task</button>
        </div>
    </div>
</div>

<!-- REMINDER MODAL -->
<div class="modal fade" id="reminderModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5 class="fw-bold mb-2">Add Reminder</h5>
            <input id="reminderInput" class="form-control mt-2" placeholder="Reminder text">
            <label class="mt-3 fw-semibold">Reminder Date</label>
            <input id="reminderDate" type="date" class="form-control">
            <button class="btn btn-primary mt-3" id="saveReminderBtn">Save Reminder</button>
        </div>
    </div>
</div>

<?php include 'common/footer.php'; ?>

<script>
/* ============================================================
  contract_view.php — loads ID-wise from contract_json.php
  Items should be stored in the JSON under `items` (optional).
  If items not present, we use a default sample item.
============================================================ */

document.addEventListener("DOMContentLoaded", () => {

  // READ ID FROM URL
  const params = new URLSearchParams(window.location.search);
  const contractId = Number(params.get("id")) || 20; // fallback 20

  let contracts = [];
  let contract = null;

  // Load contracts from JSON + merge with localStorage modifications (if any)
  function loadContracts() {
    return fetch("contract_json.php")
      .then(res => res.json())
      .then(list => {
        const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");
        const map = new Map();
        list.forEach(i => map.set(i.id, i));
        saved.forEach(s => map.set(s.id, s)); // saved override
        contracts = Array.from(map.values()).sort((a,b)=>b.id-a.id);
        contract = contracts.find(c => c.id === contractId);
      });
  }

  // Render contract fields
  function renderContract() {
    if (!contract) {
      document.getElementById("contractContainer").innerHTML = "<div class='alert alert-danger'>Contract not found.</div>";
      return;
    }

    // Header & status
    document.getElementById("invoiceNumber").innerText = contract.contract_no || ("CONTRACT #" + contract.id);
    document.getElementById("invoiceStatus").innerText = contract.status || "Draft";
    document.getElementById("invoiceStatus").className = "badge bg-" + (contract.status_color || (contract.status === "Accepted" ? "primary" : "secondary"));
    document.getElementById("contractDateText").innerText = contract.contract_date || "";

    // Sidebar info
    document.getElementById("infoContractDate").innerText = contract.contract_date || "";
    document.getElementById("infoValidUntil").innerText = contract.valid_until || "";
    document.getElementById("clientName").innerText = contract.client || "";
    document.getElementById("sidebarClientLink").innerText = contract.client || "";
    document.getElementById("sidebarClientLink").href = "Client-View.php?id=" + (contract.client_id || "");

    // Signer placeholder
    document.getElementById("signerName").innerText = contract.client || "—";
    document.getElementById("signerEmail").innerText = contract.client_email || "—";

    // Content (if contract has HTML content)
    document.getElementById("proposalContent").innerHTML = contract.content_html || `
        <h5 class="fw-semibold">${contract.title || ""}</h5>
        <p>Contract between ${contract.client || "Client"} and your company describing the services and terms.</p>
    `;

    // Set preview URL
    const urlBtn = document.getElementById("proposalUrl");
    urlBtn.href = "contract_preview.php?id=" + contract.id;

    // Render items (from JSON if present)
    if (!Array.isArray(contract.items) || contract.items.length === 0) {
      // fallback sample items
      contract.items = [{
        name: contract.title || "Service",
        desc: "Service provided",
        qty: 1,
        rate: Number(contract.amount) || 0
      }];
    }

    renderItems();
    calculateTotals();
  }

  // Render items into table
  function renderItems() {
    const tbody = document.getElementById("itemRows");
    tbody.innerHTML = "";

    contract.items.forEach((it, idx) => {
      const qty = Number(it.qty || 0);
      const rate = Number(it.rate || 0);
      const total = qty * rate;

      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><div class="fw-semibold">${escapeHtml(it.name || it.item || "")}</div><div class="text-muted small">${escapeHtml(it.desc || "")}</div></td>
        <td>${qty} ${it.unit || "PC"}</td>
        <td>$${rate.toFixed(2)}</td>
        <td>$${total.toFixed(2)}</td>
        <td>
            <button class="btn btn-sm btn-light" onclick="editItem(${idx})"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-light text-danger" onclick="deleteItem(${idx})"><i class="bi bi-trash"></i></button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  // Totals
  function calculateTotals() {
    const sub = contract.items.reduce((s, it) => s + (Number(it.qty || 0) * Number(it.rate || 0)), 0);
    document.getElementById("subTotal").innerText = "$" + sub.toFixed(2);
    document.getElementById("balanceDue").innerText = "$" + sub.toFixed(2);
  }

  // Escape helper
  function escapeHtml(s) {
    if (!s && s !== 0) return "";
    return String(s)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;");
  }

  // ------------------- item actions (global) -------------------
  window.editItem = function(i) {
    const it = contract.items[i];
    if (!it) return;
    document.getElementById("itemIndex").value = i;
    document.getElementById("itemModalTitle").innerText = "Edit Item";
    document.getElementById("itemTitle").value = it.name || it.item || "";
    document.getElementById("itemDesc").value = it.desc || "";
    document.getElementById("itemQty").value = it.qty || 1;
    document.getElementById("itemRate").value = it.rate || 0;
    new bootstrap.Modal(document.getElementById("addItemModal")).show();
  };

  window.deleteItem = function(i) {
    if (!confirm("Delete item?")) return;
    contract.items.splice(i,1);
    renderItems();
    calculateTotals();
  };

  document.getElementById("addItemBtn").addEventListener("click", () => {
    document.getElementById("itemIndex").value = -1;
    document.getElementById("itemModalTitle").innerText = "Add Item";
    document.getElementById("itemTitle").value = "";
    document.getElementById("itemDesc").value = "";
    document.getElementById("itemQty").value = 1;
    document.getElementById("itemRate").value = 0;
    new bootstrap.Modal(document.getElementById("addItemModal")).show();
  });

  document.getElementById("saveItemBtn").addEventListener("click", () => {
    const idx = Number(document.getElementById("itemIndex").value);
    const obj = {
      name: document.getElementById("itemTitle").value.trim(),
      desc: document.getElementById("itemDesc").value.trim(),
      qty: Number(document.getElementById("itemQty").value) || 0,
      rate: Number(document.getElementById("itemRate").value) || 0
    };
    if (idx === -1) contract.items.push(obj);
    else contract.items[idx] = obj;

    // persist to localStorage so new items show next load
    const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");
    // update or push
    const si = saved.findIndex(s => s.id === contract.id);
    const copy = Object.assign({}, contract);
    // store items in saved copy
    if (si === -1) saved.push(copy);
    else saved[si] = copy;
    localStorage.setItem("contracts_storage_v1", JSON.stringify(saved));

    new bootstrap.Modal(document.getElementById("addItemModal")).hide();
    renderItems();
    calculateTotals();
  });

  // --------------- tasks ---------------
  document.getElementById("addTaskBtn").addEventListener("click", () => {
    new bootstrap.Modal(document.getElementById("taskModal")).show();
  });

  document.getElementById("saveTaskBtn").addEventListener("click", () => {
    const t = document.getElementById("taskInput").value.trim();
    if (!t) return alert("Enter a task");
    contract.tasks = contract.tasks || [];
    contract.tasks.push(t);
    renderTasks();
    document.getElementById("taskInput").value = "";
    bootstrap.Modal.getInstance(document.getElementById("taskModal")).hide();

    // persist
    const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");
    const si = saved.findIndex(s => s.id === contract.id);
    const copy = Object.assign({}, contract);
    if (si === -1) saved.push(copy); else saved[si] = copy;
    localStorage.setItem("contracts_storage_v1", JSON.stringify(saved));
  });

  function renderTasks() {
    const box = document.getElementById("taskList");
    box.innerHTML = "";
    (contract.tasks || []).forEach(t => {
      const d = document.createElement("div");
      d.className = "small mb-1";
      d.textContent = "• " + t;
      box.appendChild(d);
    });
  }

  // --------------- reminders ---------------
  document.getElementById("addReminderBtn").addEventListener("click", () => {
    new bootstrap.Modal(document.getElementById("reminderModal")).show();
  });

  document.getElementById("saveReminderBtn").addEventListener("click", () => {
    const text = document.getElementById("reminderInput").value.trim();
    const date = document.getElementById("reminderDate").value;
    if (!text || !date) return alert("Fill reminder");
    contract.reminders = contract.reminders || [];
    contract.reminders.push({ text, date });
    renderReminders();
    document.getElementById("reminderInput").value = "";
    document.getElementById("reminderDate").value = "";
    bootstrap.Modal.getInstance(document.getElementById("reminderModal")).hide();

    // persist
    const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");
    const si = saved.findIndex(s => s.id === contract.id);
    const copy = Object.assign({}, contract);
    if (si === -1) saved.push(copy); else saved[si] = copy;
    localStorage.setItem("contracts_storage_v1", JSON.stringify(saved));
  });

  function renderReminders() {
    const box = document.getElementById("reminderList");
    box.innerHTML = "";
    (contract.reminders || []).forEach(r => {
      const li = document.createElement("li");
      li.className = "list-group-item d-flex justify-content-between align-items-center";
      li.innerHTML = `<div><b>${escapeHtml(r.text)}</b><br><small>${escapeHtml(r.date)}</small></div>
                      <button class="btn btn-sm btn-outline-danger" onclick="deleteReminderItem(${contract.reminders.indexOf(r)})"><i class="bi bi-trash"></i></button>`;
      box.appendChild(li);
    });
  }

  window.deleteReminderItem = function(i) {
    contract.reminders.splice(i,1);
    renderReminders();
    // persist similar to above:
    const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");
    const si = saved.findIndex(s => s.id === contract.id);
    const copy = Object.assign({}, contract);
    if (si === -1) saved.push(copy); else saved[si] = copy;
    localStorage.setItem("contracts_storage_v1", JSON.stringify(saved));
  };

  // --------------- preview / print / pdf ---------------
  document.getElementById("previewBtn").addEventListener("click", () => {
    window.open(`contract_preview.php?id=${contract.id}`, "_blank");
  });
  document.getElementById("printBtn").addEventListener("click", () => {
    window.open(`contract_preview.php?id=${contract.id}&print=1`, "_blank");
  });
  document.getElementById("viewPdfBtn").addEventListener("click", () => {
    window.open(`contract_preview.php?id=${contract.id}&pdf=1`, "_blank");
  });
  document.getElementById("downloadPdfBtn").addEventListener("click", () => {
    window.open(`contract_preview.php?id=${contract.id}&download=1`, "_blank");
  });

  // Save & show (persist content_html if user edits)
  document.getElementById("saveAndShowBtn").addEventListener("click", () => {
    contract.content_html = document.getElementById("proposalContent").innerHTML;
    const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");
    const si = saved.findIndex(s => s.id === contract.id);
    if (si === -1) saved.push(contract); else saved[si] = contract;
    localStorage.setItem("contracts_storage_v1", JSON.stringify(saved));
    window.open(`contract_preview.php?id=${contract.id}`, "_blank");
  });

  // INIT
  loadContracts().then(() => {
    renderContract();
    renderTasks();
    renderReminders();
  });

}); // DOMContentLoaded
</script>
</body>
</html>

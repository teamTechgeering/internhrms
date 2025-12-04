document.addEventListener("DOMContentLoaded", function () {

    const TABLE = document.getElementById("estimatesTable");
    const searchBox = document.getElementById("searchBox");

    const API_URL = "Estimate-json.php";

    let estimatesData = [];
    let deleteId = null;

    // =====================================================
    // LOAD DATA  (LocalStorage FIRST → If empty → Load API)
    // =====================================================
    function loadEstimates() {
        let local = localStorage.getItem("estimates");

        if (local) {
            estimatesData = JSON.parse(local);
            renderTable(estimatesData);
        } else {
            fetch("Estimate-json.php")
                .then(res => res.json())
                .then(data => {
                    estimatesData = data;
                    localStorage.setItem("estimates", JSON.stringify(estimatesData));
                    renderTable(estimatesData);
                });
        }
    }

    // =====================================================
    // RENDER TABLE  (Unchanged from your code)
    // =====================================================
    function renderTable(list) {

        TABLE.innerHTML = "";

        let pageTotal = 0;
        let allPagesTotal = 0;

        list.forEach(row => {

            pageTotal += parseFloat(row.amount);
            allPagesTotal += parseFloat(row.amount);

            TABLE.innerHTML += `
                <tr>
                    <td><a href="Estimate_view.php?id=${row.id}" class="text-decoration-none">ESTIMATE #${row.id}</a></td>
                    <td><a href="client-view.php?id=${row.client_id}" class="text-decoration-none">${row.client}</a></td>
                    <td>${row.date}</td>
                    <td>${row.created_by || "-"}</td>
                    <td>$${row.amount}</td>
                    <td><span class="badge ${getStatusClass(row.status)}">${row.status}</span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-light" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="openEdit(${row.id})">
                                        <i class="fa fa-edit me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="openDelete(${row.id})">
                                        <i class="fa fa-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
        });

        document.getElementById("pageTotal").innerText = "$" + pageTotal.toFixed(2);
        document.getElementById("allPagesTotal").innerText = "$" + allPagesTotal.toFixed(2);
    }

    function getStatusClass(status) {
        switch (status.toLowerCase()) {
            case "accepted": return "bg-primary";
            case "draft": return "bg-secondary";
            case "sent": return "bg-info";
            default: return "bg-dark";
        }
    }

    // =====================================================
    // SEARCH (Unchanged)
    // =====================================================
    searchBox.addEventListener("keyup", function () {
        const keyword = this.value.toLowerCase();
        const filtered = estimatesData.filter(item =>
            item.client.toLowerCase().includes(keyword) ||
            item.status.toLowerCase().includes(keyword) ||
            ("estimate #" + item.id).toLowerCase().includes(keyword)
        );
        renderTable(filtered);
    });

    // =====================================================
    // ADD ESTIMATE (MODAL)
    // =====================================================
    window.saveNewEstimate = function () {

        let newData = {
            id: Date.now(),
            client: document.getElementById("addClient").value,
            amount: document.getElementById("addAmount").value,
            date: document.getElementById("addDate").value,
            created_by: document.getElementById("addCreatedBy").value,
            status: document.getElementById("addStatus").value,
            client_id: 0
        };

        estimatesData.push(newData);
        localStorage.setItem("estimates", JSON.stringify(estimatesData));

        renderTable(estimatesData);
        document.getElementById("addEstimateForm").reset();

        bootstrap.Modal.getInstance(document.getElementById("addEstimateModal")).hide();
        showSuccess("Estimate added successfully!");
    };

    // =====================================================
    // OPEN EDIT MODAL
    // =====================================================
    window.openEdit = function (id) {
        let row = estimatesData.find(x => x.id == id);

        document.getElementById("editId").value = row.id;
        document.getElementById("editClient").value = row.client;
        document.getElementById("editAmount").value = row.amount;
        document.getElementById("editDate").value = row.date;

        new bootstrap.Modal(document.getElementById("editEstimateModal")).show();
    };

    // =====================================================
    // UPDATE ESTIMATE
    // =====================================================
    window.updateEstimate = function () {

        let id = document.getElementById("editId").value;
        let index = estimatesData.findIndex(x => x.id == id);

        estimatesData[index].client = document.getElementById("editClient").value;
        estimatesData[index].amount = document.getElementById("editAmount").value;
        estimatesData[index].date = document.getElementById("editDate").value;

        localStorage.setItem("estimates", JSON.stringify(estimatesData));
        renderTable(estimatesData);

        bootstrap.Modal.getInstance(document.getElementById("editEstimateModal")).hide();
        showSuccess("Estimate updated successfully!");
    };

    // =====================================================
    // DELETE ESTIMATE
    // =====================================================
    window.openDelete = function (id) {
        deleteId = id;
        new bootstrap.Modal(document.getElementById("deleteEstimateModal")).show();
    };

    document.getElementById("confirmDelete").addEventListener("click", function () {

        estimatesData = estimatesData.filter(x => x.id != deleteId);

        localStorage.setItem("estimates", JSON.stringify(estimatesData));
        renderTable(estimatesData);

        bootstrap.Modal.getInstance(document.getElementById("deleteEstimateModal")).hide();
        showSuccess("Estimate deleted successfully!");
    });

    // =====================================================
    // SUCCESS MODAL
    // =====================================================
   function showSuccess(message) {
    let modal = document.createElement("div");
    modal.className = "modal fade";
    modal.innerHTML = `
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="mb-2">${message}</p>
                    <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>`;

    document.body.appendChild(modal);

    let bsModal = new bootstrap.Modal(modal);
    bsModal.show();

    modal.addEventListener("hidden.bs.modal", () => {
        modal.remove();
        removeBackdrop();  // ⭐ FIX: removes blur completely
    });
}


    // =====================================================
    // EXPORT & PRINT (Unchanged)
    // =====================================================

    document.querySelector('.btn-light.border.me-2').addEventListener("click", function () {
        exportExcel();
    });

    function exportExcel() {
        let table = document.querySelector("table").outerHTML;

        let file = new Blob([table], { type: "application/vnd.ms-excel" });
        let url = URL.createObjectURL(file);

        let a = document.createElement("a");
        a.href = url;
        a.download = "Estimates.xls";
        a.click();
    }

    document.querySelectorAll('.btn-light.border.me-2')[1].addEventListener("click", function () {
        printTable();
    });

    function printTable() {
        let printWindow = window.open("", "", "width=900,height=600");
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print Estimates</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body>
                    <h3 class="text-center mb-3">Estimates</h3>
                    ${document.querySelector(".table-responsive").innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
    
function removeBackdrop() {
    // Remove all bootstrap backdrops
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());

    // Remove .modal-open class from body
    document.body.classList.remove('modal-open');

    // Fix scroll freeze
    document.body.style.overflow = "auto";
    document.body.style.paddingRight = "0";
}

    // LOAD DATA
    loadEstimates();

});
// --------------------------------------
//   ESTIMATE REQUEST LOCALSTORAGE
// --------------------------------------
let requestsData = [];
let deleteRequestId = null;

// Load data from LocalStorage
function loadRequests() {
    let saved = localStorage.getItem("estimate_requests");
    if (saved) {
        requestsData = JSON.parse(saved);
    }
    renderRequests();
}

// Save to localStorage
function saveRequestStorage() {
    localStorage.setItem("estimate_requests", JSON.stringify(requestsData));
}

// --------------------------------------
//   RENDER REQUEST TABLE
// --------------------------------------
function renderRequests() {
    let table = document.getElementById("requestsTable");
    table.innerHTML = "";

    requestsData.forEach(req => {
        table.innerHTML += `
            <tr>
                <td>
    <a href="Estimate_view.php?id=${req.id}" class="text-decoration-none">
        ER #${req.id}
    </a>
</td>

<td>
    <a href="client-view.php?id=${req.client_id}" class="text-decoration-none">
        ${req.client}
    </a>
</td>

                <td>${req.title}</td>
                <td>${req.assigned || "-"}</td>
                <td>${req.date}</td>
                <td><span class="badge bg-info">${req.status}</span></td>
                <td class="text-end">
                    <button class="btn btn-sm btn-light" onclick="openEditRequest(${req.id})">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-light text-danger" onclick="openDeleteRequest(${req.id})">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

// --------------------------------------
//   ADD NEW REQUEST
// --------------------------------------
function saveNewRequest() {
    let req = {
        id: Date.now(),
        client: document.getElementById("reqClient").value,
        title: document.getElementById("reqTitle").value,
        assigned: document.getElementById("reqAssigned").value,
        date: document.getElementById("reqDate").value,
        status: document.getElementById("reqStatus").value
    };

    requestsData.push(req);
    saveRequestStorage();
    renderRequests();

let addModal = bootstrap.Modal.getInstance(document.getElementById("addRequestModal"));
addModal.hide();
removeAllBackdrops();  // FIX BLUR

showSuccess("Estimate Request added successfully!");

}

// --------------------------------------
//   OPEN EDIT REQUEST
// --------------------------------------
function openEditRequest(id) {
    let req = requestsData.find(r => r.id == id);

    document.getElementById("editReqId").value = req.id;
    document.getElementById("editReqClient").value = req.client;
    document.getElementById("editReqTitle").value = req.title;
    document.getElementById("editReqAssigned").value = req.assigned;
    document.getElementById("editReqDate").value = req.date;
    document.getElementById("editReqStatus").value = req.status;

    new bootstrap.Modal(document.getElementById("editRequestModal")).show();
}

// --------------------------------------
//   UPDATE REQUEST
// --------------------------------------
function updateRequest() {
    let id = document.getElementById("editReqId").value;
    let req = requestsData.find(r => r.id == id);

    req.client = document.getElementById("editReqClient").value;
    req.title = document.getElementById("editReqTitle").value;
    req.assigned = document.getElementById("editReqAssigned").value;
    req.date = document.getElementById("editReqDate").value;
    req.status = document.getElementById("editReqStatus").value;

    saveRequestStorage();
    renderRequests();

    bootstrap.Modal.getInstance(document.getElementById("editRequestModal")).hide();
    showSuccess("Request updated successfully!");
}

// --------------------------------------
//   DELETE REQUEST
// --------------------------------------
function openDeleteRequest(id) {
    deleteRequestId = id;
    new bootstrap.Modal(document.getElementById("deleteRequestModal")).show();
}

document.getElementById("confirmDeleteRequest").addEventListener("click", () => {
    requestsData = requestsData.filter(r => r.id != deleteRequestId);
    saveRequestStorage();
    renderRequests();

    bootstrap.Modal.getInstance(document.getElementById("deleteRequestModal")).hide();
    showSuccess("Request deleted successfully!");
});

// --------------------------------------
//   SUCCESS POPUP
// --------------------------------------
function showSuccess(msg) {
    document.getElementById("successMessage").innerText = msg;
    new bootstrap.Modal(document.getElementById("successPopup")).show();
}


// Load on page start
loadRequests();
// ----------------------------
// REMOVE ALL BLUR/BACKDROPS
// ----------------------------
function removeAllBackdrops() {
    document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
    document.body.classList.remove("modal-open");
    document.body.style.overflow = "";
}

// ----------------------------
// FORMS LOCAL STORAGE
// ----------------------------
let formsData = JSON.parse(localStorage.getItem("forms") || "[]");
let deleteFormId = null;

// ----------------------------
// RENDER FORMS TABLE
// ----------------------------
function renderForms() {
    let table = document.getElementById("formsTable");
    table.innerHTML = "";

    formsData.forEach(form => {
        table.innerHTML += `
            <tr>
                <td>
    <a href="Estimaterequestform.php?id=${form.id}" class="text-decoration-none">
        ${form.title}
    </a>
</td>

                <td>${form.public}</td>
                <td>${form.embed}</td>
                <td>${form.status}</td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-light" data-bs-toggle="dropdown">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" onclick="openEditForm(${form.id})">
                                    <i class="fa fa-edit me-2"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="openDeleteForm(${form.id})">
                                    <i class="fa fa-trash me-2"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        `;
    });
}

// ----------------------------
// ADD NEW FORM
// ----------------------------
function saveNewForm() {
    let obj = {
        id: Date.now(),
        title: document.getElementById("formTitle").value,
        public: document.getElementById("formPublic").value,
        embed: document.getElementById("formEmbed").value,
        status: document.getElementById("formStatus").value
    };

    formsData.push(obj);
    localStorage.setItem("forms", JSON.stringify(formsData));

    let modal = bootstrap.Modal.getInstance(document.getElementById("addFormModal"));
    modal.hide();
    removeAllBackdrops();

    showFormSuccess("Form added successfully!");
    renderForms();
}

// ----------------------------
// OPEN EDIT FORM MODAL
// ----------------------------
function openEditForm(id) {
    let f = formsData.find(x => x.id == id);

    document.getElementById("editFormId").value = f.id;
    document.getElementById("editFormTitle").value = f.title;
    document.getElementById("editFormPublic").value = f.public;
    document.getElementById("editFormEmbed").value = f.embed;
    document.getElementById("editFormStatus").value = f.status;

    new bootstrap.Modal(document.getElementById("editFormModal")).show();
}

// ----------------------------
// UPDATE FORM
// ----------------------------
function updateForm() {
    let id = document.getElementById("editFormId").value;
    let index = formsData.findIndex(x => x.id == id);

    formsData[index].title = document.getElementById("editFormTitle").value;
    formsData[index].public = document.getElementById("editFormPublic").value;
    formsData[index].embed = document.getElementById("editFormEmbed").value;
    formsData[index].status = document.getElementById("editFormStatus").value;

    localStorage.setItem("forms", JSON.stringify(formsData));

    let modal = bootstrap.Modal.getInstance(document.getElementById("editFormModal"));
    modal.hide();
    removeAllBackdrops();

    showFormSuccess("Form updated successfully!");
    renderForms();
}

// ----------------------------
// DELETE FORM
// ----------------------------
function openDeleteForm(id) {
    deleteFormId = id;
    new bootstrap.Modal(document.getElementById("deleteFormModal")).show();
}

document.getElementById("confirmDeleteForm").addEventListener("click", () => {
    formsData = formsData.filter(f => f.id != deleteFormId);
    localStorage.setItem("forms", JSON.stringify(formsData));

    let modal = bootstrap.Modal.getInstance(document.getElementById("deleteFormModal"));
    modal.hide();
    removeAllBackdrops();

    showFormSuccess("Form deleted successfully!");
    renderForms();
});

// ----------------------------
// SUCCESS POPUP
// ----------------------------
function showFormSuccess(msg) {
    document.getElementById("formSuccessMessage").innerText = msg;

    let modalEl = document.getElementById("formSuccessPopup");
    let modal = new bootstrap.Modal(modalEl);
    modal.show();

    modalEl.addEventListener("hidden.bs.modal", () => {
        removeAllBackdrops();
    });
}

// INITIAL LOAD
renderForms();
// -------------------------------------------
// SEARCH FOR REQUEST TAB
// -------------------------------------------
if (document.getElementById("searchRequests")) {

    document.getElementById("searchRequests").addEventListener("keyup", function () {

        const keyword = this.value.toLowerCase();

        const filtered = requestsData.filter(req =>
            (req.client || "").toLowerCase().includes(keyword) ||
            (req.title || "").toLowerCase().includes(keyword) ||
            (req.status || "").toLowerCase().includes(keyword)
        );

        renderRequestsFiltered(filtered);
    });


    function renderRequestsFiltered(list) {
        let table = document.getElementById("requestsTable");
        table.innerHTML = "";

        list.forEach(req => {
            table.innerHTML += `
                <tr>
                    <td>ER #${req.id}</td>
                    <td>${req.client}</td>
                    <td>${req.title}</td>
                    <td>${req.assigned || "-"}</td>
                    <td>${req.date}</td>
                    <td><span class="badge bg-info">${req.status}</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-light" onclick="openEditRequest(${req.id})">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-light text-danger" onclick="openDeleteRequest(${req.id})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
}



// -------------------------------------------
// EXCEL EXPORT FOR REQUEST TAB
// -------------------------------------------
if (document.getElementById("excelRequests")) {

    document.getElementById("excelRequests").addEventListener("click", function () {

        let csv = "ID,Client,Title,Assigned,Date,Status\n";

        requestsData.forEach(req => {
            csv += `${req.id},${req.client},${req.title},${req.assigned || "-"},${req.date},${req.status}\n`;
        });

        const blob = new Blob([csv], { type: "text/csv" });
        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "Estimate_Requests.csv";
        a.click();
    });
}



// -------------------------------------------
// PRINT FOR REQUEST TAB
// -------------------------------------------
if (document.getElementById("printRequests")) {

    document.getElementById("printRequests").addEventListener("click", function () {

        let printWindow = window.open("", "", "width=900,height=600");

        printWindow.document.write(`
            <html>
                <head>
                    <title>Estimate Requests</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body>
                    <h3 class="text-center mb-3">Estimate Requests</h3>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Title</th>
                                <th>Assigned</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${requestsData.map(req => `
                                <tr>
                                    <td>ER #${req.id}</td>
                                    <td>${req.client}</td>
                                    <td>${req.title}</td>
                                    <td>${req.assigned || "-"}</td>
                                    <td>${req.date}</td>
                                    <td>${req.status}</td>
                                </tr>
                            `).join("")}
                        </tbody>
                    </table>
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.print();
    });
}
// ========================================================
// FORMS TAB - SEARCH
// ========================================================
const searchForms = document.getElementById("searchForms");
if (searchForms) {

    searchForms.addEventListener("keyup", function () {
        const keyword = this.value.toLowerCase();

        const filtered = formsData.filter(f =>
            (f.title || "").toLowerCase().includes(keyword) ||
            (f.status || "").toLowerCase().includes(keyword) ||
            (f.public || "").toLowerCase().includes(keyword)
        );

        renderFormsFiltered(filtered);
    });


    function renderFormsFiltered(list) {
        let table = document.getElementById("formsTable");
        table.innerHTML = "";

        list.forEach(form => {
            table.innerHTML += `
                <tr>
                    <td>${form.title}</td>
                    <td>${form.public}</td>
                    <td>${form.embed}</td>
                    <td>${form.status}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-light" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="openEditForm(${form.id})">
                                        <i class="fa fa-edit me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="openDeleteForm(${form.id})">
                                        <i class="fa fa-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
        });
    }
}


// ========================================================
// FORMS TAB - EXCEL EXPORT
// ========================================================
const excelFormsBtn = document.getElementById("excelForms");
if (excelFormsBtn) {
    excelFormsBtn.addEventListener("click", function () {

        let csv = "ID,Title,Public,Embed,Status\n";

        formsData.forEach(f => {
            csv += `${f.id},${f.title},${f.public},${f.embed},${f.status}\n`;
        });

        const blob = new Blob([csv], { type: "text/csv" });
        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "Estimate_Request_Forms.csv";
        a.click();
    });
}


// ========================================================
// FORMS TAB - PRINT
// ========================================================
const printFormsBtn = document.getElementById("printForms");
if (printFormsBtn) {

    printFormsBtn.addEventListener("click", function () {

        let printWindow = window.open("", "", "width=900,height=600");

        printWindow.document.write(`
            <html>
                <head>
                    <title>Estimate Request Forms</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body>
                    <h3 class="text-center mb-3">Estimate Request Forms</h3>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Public</th>
                                <th>Embed</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${formsData.map(f => `
                                <tr>
                                    <td>${f.title}</td>
                                    <td>${f.public}</td>
                                    <td>${f.embed}</td>
                                    <td>${f.status}</td>
                                </tr>
                            `).join("")}
                        </tbody>
                    </table>
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.print();
    });
}

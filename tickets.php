<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">

   <!-- TOP TAB BAR -->
<div class="d-flex justify-content-between align-items-center mb-3">

    <!-- LEFT: TABS -->
    <ul class="nav nav-tabs border-0">
        <li class="nav-item">
            <a class="nav-link active" id="tabTickets" style="cursor:pointer;">Tickets</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tabTemplates" style="cursor:pointer;">Templates</a>
        </li>
    </ul>

    

</div>

<!-- ========================= -->
<!--   TICKETS SECTION         -->
<!-- ========================= -->

<div id="ticketsSection">
<!-- RIGHT BUTTONS -->
    
<!-- FILTER BAR -->
<div class="d-flex align-items-center gap-2 mb-3">
    
    <button class="btn btn-outline-secondary btn-sm" id="filterAllBtn"><i class="bi bi-list"></i></button>

    <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="filterDropdownBtn" data-bs-toggle="dropdown">All tickets</button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item filter-option" data-label="All">All tickets</a></li>
            <li><a class="dropdown-item filter-option" data-label="Open">Open</a></li>
            <li><a class="dropdown-item filter-option" data-label="Important">Important</a></li>
            <li><a class="dropdown-item filter-option" data-label="Investigate">Investigate</a></li>
        </ul>
    </div>

    <button class="btn btn-outline-secondary btn-sm" id="filterImportantBtn">Important</button>
    <button class="btn btn-outline-secondary btn-sm" id="filterAssignedBtn"><i class="bi bi-person"></i></button>
    <button class="btn btn-outline-secondary btn-sm" id="filterOpenBtn">Open</button>

    <div class="ms-auto d-flex align-items-center gap-2">
           <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTicketModal">
                <i class="bi bi-plus-lg"></i> Add ticket
            </button>
        <button class="btn btn-outline-secondary btn-sm" id="refreshBtn"><i class="bi bi-arrow-repeat"></i></button>
        <button class="btn btn-outline-secondary btn-sm" id="excelBtn">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printBtn">Print</button>

        <div class="input-group input-group-sm" style="width: 180px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        </div>
    </div>
</div>

<!-- TICKET TABLE -->
<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Title</th>
                <th>Client</th>
                <th>Ticket type</th>
                <th>Labels</th>
                <th>Assigned to</th>
                <th>Last activity</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody id="ticketBody"></tbody>
        
    </table>
    <!-- PAGINATION -->
<div class="d-flex justify-content-between align-items-center mt-2">

    <!-- Items per page -->
    <div class="d-flex align-items-center gap-2">
        <select id="rowsPerPage" class="form-select form-select-sm" style="width: 80px;">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="25">25</option>
        </select>

        <span class="small text-muted" id="paginationInfo">1–0 / 0</span>
    </div>

    <!-- Next / Prev -->
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="prevPageBtn">&lt;</button>
        <span class="btn btn-light btn-sm" id="currentPage">1</span>
        <button class="btn btn-outline-secondary btn-sm" id="nextPageBtn">&gt;</button>
    </div>

</div>

</div>

</div> <!-- END TICKETS SECTION -->


<!-- ========================= -->
<!--   TEMPLATES SECTION       -->
<!-- ========================= -->

<div id="templatesSection" style="display:none;">

    <div class="card p-3">

        <!-- TAB HEADER (ICON + SEARCH + ADD TEMPLATE BUTTON) -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Left icon -->
            <button class="btn btn-light border">
                <i class="bi bi-columns-gap"></i>
            </button>

            <!-- Search -->
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" id="templateSearch" class="form-control" placeholder="Search">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>

            <!-- Add template -->
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTemplateModal">
    <i class="bi bi-plus-circle"></i> Add template
</button>


        </div>

        <!-- TABLE -->
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width:35%">Title</th>
                    <th style="width:35%">Description</th>
                    <th style="width:15%">Category</th>
                    <th style="width:10%">Private</th>
                    <th style="width:5%"></th>
                </tr>
            </thead>
            <tbody id="templateBody"></tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-2">

            <!-- Per page select -->
            <select class="form-select form-select-sm" style="width: 70px;" id="templateRowCount">
                <option>5</option>
                <option>10</option>
                <option>20</option>
            </select>

            <!-- Page indicator -->
            <div id="templatePageInfo" class="small text-muted">1–2 / 2</div>

            <!-- Page arrows -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light btn-sm" id="prevTemplatePage">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <span id="templateCurrentPage" class="px-2">1</span>

                <button class="btn btn-light btn-sm" id="nextTemplatePage">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

        </div>

    </div>

</div>
 <!-- END TEMPLATES SECTION -->

</div>
</div>
</div>


<!-- MODALS (same as your code) -->

<!-- ADD TEMPLATE MODAL -->
<div class="modal fade" id="addTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add template</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="templateForm">

                    <div class="row mb-3">
                        <div class="col-4">Title</div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="title" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Description</div>
                        <div class="col-8">
                            <textarea class="form-control" name="desc" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Ticket type</div>
                        <div class="col-8">
                            <select class="form-select" name="cat">
                                <option>-</option>
                                <option>General</option>
                                <option>Support</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Private</div>
                        <div class="col-8">
                            <input type="checkbox" name="private">
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveTemplateBtn">Save</button>
            </div>

        </div>
    </div>
</div>

<!-- ADD TICKET MODAL -->
<div class="modal fade" id="addTicketModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add ticket</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="addTicketForm">

                    <div class="row mb-3">
                        <div class="col-4">Title</div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="title" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Client</div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="client">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Requested by</div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="requested">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Ticket type</div>
                        <div class="col-8">
                            <select class="form-select" name="type">
                                <option>General Support</option>
                                <option>Bug Reports</option>
                                <option>Sales Inquiry</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Description</div>
                        <div class="col-8">
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">Assign to</div>
                        <div class="col-8">
                            <select class="form-select" name="assigned">
                                <option>-</option>
                                <option>John Doe</option>
                                <option>Michael Wood</option>
                                <option>Richard Gray</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
    <div class="col-4">Labels</div>
    <div class="col-8">
        <select class="form-select" name="labels">
            <option value="">Select label</option>
            <option value="Open">Open</option>
            <option value="Important">Important</option>
            <option value="Investigate">Investigate</option>
        </select>
        
    </div>
</div>


                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveTicketBtn">Save</button>
            </div>

        </div>
    </div>
</div>
<!-- SUCCESS MODAL -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h5 class="mb-2">Saved!</h5>
        <p class="mb-0">Ticket added successfully.</p>
      </div>
    </div>
  </div>
</div>
<!-- DELETE CONFIRM MODAL -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center">
                <h5 class="mb-3">Delete Ticket?</h5>
                <p>Are you sure you want to delete this ticket?</p>

                <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>
<!-- EDIT TEMPLATE MODAL -->
<div class="modal fade" id="editTemplateModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit template</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editTemplateForm">

          <input type="hidden" id="editIndex">

          <div class="row mb-3">
            <div class="col-4">Title</div>
            <div class="col-8">
              <input type="text" class="form-control" id="editTitle">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-4">Description</div>
            <div class="col-8">
              <textarea class="form-control" id="editDesc"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-4">Category</div>
            <div class="col-8">
              <input type="text" class="form-control" id="editCat">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-4">Private</div>
            <div class="col-8">
              <input type="checkbox" id="editPrivate">
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="updateTemplateBtn">Update</button>
      </div>

    </div>
  </div>
</div>

<div id="ticketsSection">
    <!-- your tickets HTML stays SAME -->
<div id="templatesSection" style="display:none;">
    <div class="card p-3">
        <h5 class="mb-3">Ticket Templates</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Template Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Private</th>
                </tr>
            </thead>
            <tbody id="templateBody">
                <!-- JS fills templates -->
            </tbody>
        </table>
    </div>
</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
// Load tickets
let allTickets = []; 

//---------------------------------------------
// LOAD DATA FROM PHP
//---------------------------------------------
function loadFromPHP() {
    fetch("ticket-data.php")
        .then(res => res.json())
        .then(data => {
            allTickets = data;
            saveToLocal(allTickets);
            renderTickets(allTickets);
        });
}

//---------------------------------------------
// LOCAL STORAGE HELPERS
//---------------------------------------------
function loadFromLocal() {
    let data = localStorage.getItem("tickets");
    return data ? JSON.parse(data) : [];
}

function saveToLocal(data) {
    localStorage.setItem("tickets", JSON.stringify(data));
}

//---------------------------------------------
// RENDER TABLE
//---------------------------------------------
function renderTickets(data) {
    let html = "";

    data.forEach(row => {
        let badgeClass =
            row.labels === "Important" ? "warning text-dark" :
            row.labels === "Open" ? "danger" :
            row.labels === "Investigate" ? "info text-dark" :
            "secondary";

        html += `
            <tr>

<td>
    <a href="tickets_view.php?id=${encodeURIComponent(row.id)}&title=${encodeURIComponent(row.title)}" 
       class="text-decoration-none">
       ${row.id}
    </a>
</td>

<td>
    <a href="tickets_view.php?id=${encodeURIComponent(row.id)}&title=${encodeURIComponent(row.title)}"
       class="text-decoration-none">
       ${row.title}
    </a>
</td>


<td>
    <a href="Client-View.php?client=${encodeURIComponent(row.client)}" class="text-decoration-none">
        ${row.client}
    </a>
</td>

<td>${row.type}</td>

<td><span class="badge bg-${badgeClass}">${row.labels}</span></td>

<td>
    <a href="user.php?name=${encodeURIComponent(row.assigned)}" 
       class="d-flex align-items-center gap-2 text-decoration-none">

        <img src="assets/images/users/avatar-6.jpg" 
             class="rounded-circle" width="32" height="32">

        <span>${row.assigned}</span>
    </a>
</td>

<td>${row.activity}</td>

<td><span class="badge bg-${badgeClass}">${row.labels}</span></td>

<td>
    <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
            <i class="bi bi-three-dots"></i>
        </button>

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="editTicket('${row.id}')">Edit</a></li>
            <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('${row.id}')">Delete</a></li>
        </ul>
    </div>
</td>

            </tr>
        `;
    });

    document.getElementById("ticketBody").innerHTML = html;
}

//---------------------------------------------
// SAVE (ADD + EDIT)
//---------------------------------------------
document.getElementById("saveTicketBtn").addEventListener("click", function () {
    
    let form = document.getElementById("addTicketForm");
    let editId = form.getAttribute("data-edit-id");

    let tickets = loadFromLocal();

    if (editId) {
        //---------------------------------------------
        // EDIT MODE
        //---------------------------------------------
        let index = tickets.findIndex(t => t.id === editId);
        if (index !== -1) {
            tickets[index] = {
                id: editId,
                title: form.title.value,
                client: form.client.value,
                requested: form.requested.value,
                type: form.type.value,
                description: form.description.value,
                assigned: form.assigned.value,
                labels: form.labels.value,
                activity: "Updated now"
            };
        }

        form.removeAttribute("data-edit-id");

    } else {
        //---------------------------------------------
        // ADD MODE
        //---------------------------------------------
        let newTicket = {
            id: "Ticket #" + Math.floor(Math.random() * 9000),
            title: form.title.value,
            client: form.client.value,
            requested: form.requested.value,
            type: form.type.value,
            description: form.description.value,
            assigned: form.assigned.value,
            labels: form.labels.value,
            activity: "Just now"
        };

        tickets.unshift(newTicket);
    }

    saveToLocal(tickets);
    renderTickets(tickets);

    // Close modal
    let addModal = bootstrap.Modal.getInstance(document.getElementById("addTicketModal"));
    addModal.hide();

    setTimeout(() => {
        document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
        document.body.classList.remove("modal-open");
    }, 200);

    form.reset();

    // Success popup
    let success = new bootstrap.Modal(document.getElementById("successModal"));
    success.show();
    setTimeout(() => success.hide(), 1500);
});

//---------------------------------------------
// EDIT TICKET (OPEN MODAL WITH DATA)
//---------------------------------------------
function editTicket(id) {
    let tickets = loadFromLocal();
    let t = tickets.find(ticket => ticket.id === id);

    if (!t) return;

    let form = document.getElementById("addTicketForm");
    form.title.value = t.title;
    form.client.value = t.client;
    form.requested.value = t.requested;
    form.type.value = t.type;
    form.description.value = t.description;
    form.assigned.value = t.assigned;
    form.labels.value = t.labels;

    form.setAttribute("data-edit-id", id);

    let modal = new bootstrap.Modal(document.getElementById("addTicketModal"));
    modal.show();
}

//---------------------------------------------
// DELETE LOGIC
//---------------------------------------------
let ticketToDelete = null;

function confirmDelete(id) {
    ticketToDelete = id;

    let modal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
    modal.show();
}

document.getElementById("confirmDeleteBtn").addEventListener("click", () => {
    let tickets = loadFromLocal();
    tickets = tickets.filter(t => t.id !== ticketToDelete);

    saveToLocal(tickets);
    renderTickets(tickets);

    let modal = bootstrap.Modal.getInstance(document.getElementById("deleteConfirmModal"));
    modal.hide();
});

//---------------------------------------------
// FILTER BUTTONS
//---------------------------------------------
document.getElementById("filterOpenBtn").addEventListener("click", () => {
    renderTickets(loadFromLocal().filter(t => t.labels === "Open"));
});

document.getElementById("filterImportantBtn").addEventListener("click", () => {
    renderTickets(loadFromLocal().filter(t => t.labels === "Important"));
});

document.getElementById("filterAssignedBtn").addEventListener("click", () => {
    renderTickets(loadFromLocal().filter(t => t.assigned === "John Doe"));
});

document.getElementById("filterAllBtn").addEventListener("click", () => {
    renderTickets(loadFromLocal());
});

//---------------------------------------------
// SEARCH
//---------------------------------------------
document.getElementById("searchInput").addEventListener("keyup", e => {
    let q = e.target.value.toLowerCase();
    let filtered = loadFromLocal().filter(t =>
        t.title.toLowerCase().includes(q) ||
        t.client.toLowerCase().includes(q) ||
        t.type.toLowerCase().includes(q) ||
        t.labels.toLowerCase().includes(q)
    );

    renderTickets(filtered);
});

//---------------------------------------------
// DROPDOWN FILTER
//---------------------------------------------
document.querySelectorAll(".filter-option").forEach(item => {
    item.addEventListener("click", function () {
        let label = this.getAttribute("data-label");
        let dropdownBtn = document.getElementById("filterDropdownBtn");

        dropdownBtn.textContent = this.textContent;

        if (label === "All") {
            renderTickets(loadFromLocal());
        } else {
            renderTickets(loadFromLocal().filter(t => t.labels === label));
        }
    });
});

//---------------------------------------------
// EXCEL EXPORT
//---------------------------------------------
document.getElementById("excelBtn").addEventListener("click", () => {
    let rows = document.querySelectorAll("table tr");
    let csv = [];

    rows.forEach(row => {
        let cols = row.querySelectorAll("td, th");
        let rowData = [];
        cols.forEach(col => rowData.push('"' + col.innerText.replace(/"/g, '""') + '"'));
        csv.push(rowData.join(","));
    });

    let csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
    let encodedUri = encodeURI(csvContent);

    let link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "tickets_export.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});

//---------------------------------------------
// PRINT
//---------------------------------------------
document.getElementById("printBtn").addEventListener("click", () => {
    let divToPrint = document.getElementById("ticketBody").parentElement;
    let newWin = window.open("");

    newWin.document.write("<html><head><title>Print Tickets</title></head><body>");
    newWin.document.write(divToPrint.outerHTML);
    newWin.document.write("</body></html>");

    newWin.print();
    newWin.close();
});

//---------------------------------------------
// REFRESH (MERGE LOCAL + PHP)
//---------------------------------------------
document.getElementById("refreshBtn").addEventListener("click", () => {
    fetch("ticket-data.php")
        .then(res => res.json())
        .then(serverData => {
            let localData = loadFromLocal();
            let merged = [...localData, ...serverData];

            merged = merged.filter((obj, index, self) =>
                index === self.findIndex(t => t.id === obj.id)
            );

            saveToLocal(merged);
            renderTickets(merged);
        });
});

//---------------------------------------------
// INITIAL LOAD
//---------------------------------------------
if (localStorage.getItem("tickets")) {
    renderTickets(loadFromLocal());
} else {
    loadFromPHP();
}
// ---------------------- PAGINATION ---------------------- //
let currentPage = 1;
let rowsPerPage = 10;

// Update pagination UI
function updatePaginationUI(totalRows) {
    let start = (currentPage - 1) * rowsPerPage + 1;
    let end = Math.min(currentPage * rowsPerPage, totalRows);

    document.getElementById("paginationInfo").textContent = `${start}–${end} / ${totalRows}`;
    document.getElementById("currentPage").textContent = currentPage;
}

// Render tickets with pagination
function renderTicketsWithPagination() {
    let all = loadFromLocal();
    let totalRows = all.length;
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    renderTickets(all.slice(start, end));
    updatePaginationUI(totalRows);
}

// Rows per page change
document.getElementById("rowsPerPage").addEventListener("change", e => {
    rowsPerPage = parseInt(e.target.value);
    currentPage = 1;
    renderTicketsWithPagination();
});

// Next page
document.getElementById("nextPageBtn").addEventListener("click", () => {
    let totalRows = loadFromLocal().length;
    if (currentPage * rowsPerPage < totalRows) {
        currentPage++;
        renderTicketsWithPagination();
    }
});

// Previous page
document.getElementById("prevPageBtn").addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        renderTicketsWithPagination();
    }
});

// ---------------------------------------------
// TAB SWITCHING
// ---------------------------------------------
document.getElementById("tabTickets").addEventListener("click", () => {
    document.getElementById("ticketsSection").style.display = "block";
    document.getElementById("templatesSection").style.display = "none";

    document.getElementById("tabTickets").classList.add("active");
    document.getElementById("tabTemplates").classList.remove("active");
});

document.getElementById("tabTemplates").addEventListener("click", () => {
    document.getElementById("ticketsSection").style.display = "none";
    document.getElementById("templatesSection").style.display = "block";

    document.getElementById("tabTickets").classList.remove("active");
    document.getElementById("tabTemplates").classList.add("active");

    loadTemplates();
});



// ORIGINAL DATA (do NOT modify this on search)
/* ---------------------------------------------
   TEMPLATE DATA (master list)
--------------------------------------------- */
/* -----------------------------------------------
   MASTER TEMPLATE STORAGE
------------------------------------------------ */
let templateMaster = [
    { name: "Support policy", desc: "Please check our support policy here.", cat: "-", private: "No" },
    { name: "How to pay invoice", desc: "Please check it to learn more about how to pay your invoice.", cat: "-", private: "No" }
];

/* Load from LocalStorage if exists */
if (localStorage.getItem("templates")) {
    templateMaster = JSON.parse(localStorage.getItem("templates"));
}
let templates = [...templateMaster];

let templatePage = 1;
let templatePerPage = 10;

/* Save function */
function saveTemplates() {
    localStorage.setItem("templates", JSON.stringify(templateMaster));
}

/* -----------------------------------------------
   RENDER TABLE
------------------------------------------------ */
function loadTemplates() {
    let start = (templatePage - 1) * templatePerPage;
    let end = start + templatePerPage;

    let paginated = templates.slice(start, end);

    let html = "";
    paginated.forEach((t, index) => {

        let realIndex = start + index;

        html += `
            <tr>
               <td>
    <a href="knowledgebase.php?id=${realIndex}"
       class="text-primary text-decoration-none"
       style="cursor:pointer;">
       ${t.name}
    </a>
</td>


                <td>
                    
                        ${t.desc}
                   
                </td>

                <td>${t.cat}</td>
                <td>${t.private}</td>

                <td class="text-end">
                    <button class="btn btn-sm btn-link text-primary" onclick="openEditModal(${realIndex})">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <button class="btn btn-sm btn-link text-danger" onclick="deleteTemplate(${realIndex})">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    document.getElementById("templateBody").innerHTML = html;

    document.getElementById("templatePageInfo").innerText =
        `${templates.length === 0 ? 0 : start + 1}–${Math.min(end, templates.length)} / ${templates.length}`;
    document.getElementById("templateCurrentPage").innerText = templatePage;
}

/* -----------------------------------------------
   PAGINATION
------------------------------------------------ */
document.getElementById("prevTemplatePage").onclick = () => {
    if (templatePage > 1) {
        templatePage--;
        loadTemplates();
    }
};

document.getElementById("nextTemplatePage").onclick = () => {
    if (templatePage * templatePerPage < templates.length) {
        templatePage++;
        loadTemplates();
    }
};

document.getElementById("templateRowCount").onchange = function () {
    templatePerPage = parseInt(this.value);
    templatePage = 1;
    loadTemplates();
};

/* -----------------------------------------------
   SEARCH
------------------------------------------------ */
document.getElementById("templateSearch").addEventListener("keyup", function () {
    let q = this.value.toLowerCase();

    templates = templateMaster.filter(t =>
        t.name.toLowerCase().includes(q) ||
        t.desc.toLowerCase().includes(q)
    );

    templatePage = 1;
    loadTemplates();
});

/* -----------------------------------------------
   OPEN EDIT MODAL
------------------------------------------------ */
function openEditModal(index) {
    let t = templateMaster[index];

    document.getElementById("editIndex").value = index;
    document.getElementById("editTitle").value = t.name;
    document.getElementById("editDesc").value = t.desc;
    document.getElementById("editCat").value = t.cat;
    document.getElementById("editPrivate").checked = t.private === "Yes";

    let modal = new bootstrap.Modal(document.getElementById("editTemplateModal"));
    modal.show();
}

/* -----------------------------------------------
   UPDATE TEMPLATE
------------------------------------------------ */
document.getElementById("updateTemplateBtn").onclick = function () {

    let index = document.getElementById("editIndex").value;

    templateMaster[index].name = document.getElementById("editTitle").value;
    templateMaster[index].desc = document.getElementById("editDesc").value;
    templateMaster[index].cat = document.getElementById("editCat").value;
    templateMaster[index].private = document.getElementById("editPrivate").checked ? "Yes" : "No";

    saveTemplates();
    templates = [...templateMaster];
    loadTemplates();

    let modal = bootstrap.Modal.getInstance(document.getElementById("editTemplateModal"));
    modal.hide();

    showSuccess();  // show success popup
};

/* -----------------------------------------------
   DELETE TEMPLATE
------------------------------------------------ */
let templateToDelete = null;

function deleteTemplate(index) {
    templateToDelete = index;

    let modal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
    modal.show();
}

document.getElementById("confirmDeleteBtn").onclick = function () {
    templateMaster.splice(templateToDelete, 1);

    saveTemplates();
    templates = [...templateMaster];
    loadTemplates();

    let modal = bootstrap.Modal.getInstance(document.getElementById("deleteConfirmModal"));
    modal.hide();

    showSuccess();
};

/* -----------------------------------------------
   ADD TEMPLATE
------------------------------------------------ */
document.getElementById("saveTemplateBtn").onclick = function () {
    let form = document.getElementById("templateForm");

    let newTemplate = {
        name: form.title.value,
        desc: form.desc.value,
        cat: form.cat.value,
        private: form.private.checked ? "Yes" : "No"
    };

    templateMaster.push(newTemplate);
    saveTemplates();

    templates = [...templateMaster];
    loadTemplates();

    let modal = bootstrap.Modal.getInstance(document.getElementById("addTemplateModal"));
    modal.hide();
    form.reset();

    showSuccess();
};

/* -----------------------------------------------
   FIX BLUR AFTER SUCCESS
------------------------------------------------ */
function removeBackdrop() {
    document.querySelectorAll(".modal-backdrop").forEach(e => e.remove());
    document.body.classList.remove("modal-open");
}

/* SUCCESS POPUP */
function showSuccess() {
    let modal = new bootstrap.Modal(document.getElementById("successModal"));
    modal.show();

    setTimeout(() => {
        modal.hide();
        removeBackdrop();
    }, 1500);
}

/* INITIAL LOAD */
loadTemplates();





</script>

</body>
</html>


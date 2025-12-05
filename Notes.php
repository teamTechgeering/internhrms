<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>
<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container py-4">

    <h3 class="mb-4">Notes (Private)</h3>

    <!-- TABS -->
    <ul class="nav nav-tabs mb-2">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#listTab">List</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#gridTab">Grid</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#categoryTab">Categories</button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- -------------------------------- LIST TAB -------------------------------- -->
        <div class="tab-pane fade show active" id="listTab">
<div class="d-flex justify-content-between align-items-center mb-3">

    <!-- LEFT SIDE -->
    <div>
        <button class="btn btn-outline-secondary btn-sm me-2" onclick="refreshNotes()">
    <i class="bi bi-sliders"></i> Manage Levels
</button>

        <button class="btn btn-outline-secondary btn-sm " onclick="refreshNotes()">
    <i class="bi bi-arrow-repeat"></i>
</button>
  


    </div>

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center gap-2">

        <button class="btn btn-outline-secondary btn-sm" onclick="exportToExcel()">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </button>

        <button class="btn btn-outline-secondary btn-sm" onclick="printNotes()">
            <i class="bi bi-printer"></i> Print
        </button>

        <div class="input-group" style="width: 250px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search" onkeyup="filterNotes()">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>

        <button class="btn btn-primary" onclick="openNoteModal()">Add Note</button>

    </div>

</div>
            <table class="table table-hover bg-white align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:200px;">Created date</th>
                        <th style="width:200px;">Title</th>
                        <th style="width:200px;">Category</th>
                        <th style="width:60px;">Files</th>
                        <th class="text-end" style="width:120px;">Action</th>
                    </tr>
                </thead>
                <tbody id="noteList"></tbody>
                
            </table>
            <!-- PAGINATION -->
<div class="d-flex justify-content-between align-items-center mt-3">

    <!-- Left: Rows per page -->
    <div class="d-flex align-items-center">
        <select id="rowsPerPage" class="form-select form-select-sm" style="width: 80px;" onchange="changeRowsPerPage()">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
        </select>
    </div>

    <!-- Right: Pagination buttons -->
    <div class="d-flex align-items-center gap-2">

        <button class="btn btn-light btn-sm" onclick="prevPage()">&#8249;</button>

        <div id="paginationNumbers" class="d-flex align-items-center gap-1"></div>

        <button class="btn btn-light btn-sm" onclick="nextPage()">&#8250;</button>

    </div>

</div>

        </div>

        <!-- -------------------------------- GRID TAB -------------------------------- -->
      <div class="tab-pane fade" id="gridTab">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- LEFT SIDE -->
         
        <button class="btn btn-outline-secondary btn-sm" onclick="refreshNotes()">
            <i class="bi bi-arrow-repeat me-1"></i>Refresh
        </button>

        <!-- RIGHT SIDE -->
        <div class="d-flex align-items-center gap-2">

            <button class="btn btn-outline-secondary btn-sm" onclick="exportToExcel()">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </button>

            <button class="btn btn-outline-secondary btn-sm" onclick="printNotes()">
                <i class="bi bi-printer"></i> Print
            </button>

            <div class="input-group" style="width: 250px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Search" onkeyup="filterNotes()">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>

            <button class="btn btn-primary" onclick="openNoteModal()">Add Note</button>

        </div>

    </div>

    <div class="row" id="noteGrid"></div>
</div>


        <!-- ------------------------------ CATEGORY TAB ------------------------------ -->
      <div class="tab-pane fade" id="categoryTab">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- LEFT SIDE -->
        <button class="btn btn-outline-secondary btn-sm" onclick="refreshCategories()">
            <i class="bi bi-arrow-repeat me-2"></i>Refresh
        </button>

        <!-- RIGHT SIDE -->
        <div class="d-flex align-items-center gap-2">

            <button class="btn btn-outline-secondary btn-sm" onclick="exportToExcel()">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </button>

            <button class="btn btn-outline-secondary btn-sm" onclick="printNotes()">
                <i class="bi bi-printer"></i> Print
            </button>

            <div class="input-group" style="width: 250px;">
                <input type="text" id="searchCategoryInput" class="form-control"
                    placeholder="Search categories..." onkeyup="filterCategories()">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>

            <button class="btn btn-primary" onclick="openCategoryModal()">Add Category</button>

        </div>

    </div>

    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th width="130">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryList"></tbody>
        
    </table>
<!-- PAGINATION -->
<div class="d-flex justify-content-between align-items-center mt-3">

    <!-- Left: Rows per page -->
    <div class="d-flex align-items-center">
        <select id="rowsPerPage" class="form-select form-select-sm" style="width: 80px;" onchange="changeRowsPerPage()">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
        </select>
    </div>

    <!-- Right: Pagination buttons -->
    <div class="d-flex align-items-center gap-2">

        <button class="btn btn-light btn-sm" onclick="prevPage()">&#8249;</button>

        <div id="paginationNumbers" class="d-flex align-items-center gap-1"></div>

        <button class="btn btn-light btn-sm" onclick="nextPage()">&#8250;</button>

    </div>

</div>

</div>


<!-- ---------------------- ADD / EDIT NOTE MODAL ---------------------- -->
<div class="modal fade" id="noteModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="noteId">

                <input type="text" id="noteTitle" class="form-control mb-3" placeholder="Title">
                <input type="file" id="noteFileInput" multiple style="display:none;">


                <textarea id="noteDescription" class="form-control mb-3" rows="6" placeholder="Description..."></textarea>

                <select id="noteCategory" class="form-select mb-3">
                    <option value="">- Category -</option>
                </select>

                <label class="fw-bold">Created Date</label>
                <input type="datetime-local" id="noteCreated" class="form-control mb-4">

                <label class="fw-bold">Labels</label>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <div onclick="selectLabel('#c59bff')" style="width:22px;height:22px;border-radius:50%;background:#c59bff;cursor:pointer;"></div>
                    <div onclick="selectLabel('#8ee2ff')" style="width:22px;height:22px;border-radius:50%;background:#8ee2ff;cursor:pointer;"></div>
                    <div onclick="selectLabel('#ffe98e')" style="width:22px;height:22px;border-radius:50%;background:#ffe98e;cursor:pointer;"></div>
                    <div onclick="selectLabel('#baf7c4')" style="width:22px;height:22px;border-radius:50%;background:#baf7c4;cursor:pointer;"></div>
                    <div onclick="selectLabel('#ffa3b1')" style="width:22px;height:22px;border-radius:50%;background:#ffa3b1;cursor:pointer;"></div>
                </div>

                <button class="btn btn-light border" onclick="document.getElementById('noteFileInput').click()">
    <i class="bi bi-upload"></i> Upload File
</button>


            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="saveNote()">Save</button>
            </div>

        </div>
    </div>
</div>

<!-- ---------------------- VIEW NOTE MODAL ---------------------- -->
<div class="modal fade" id="viewNoteModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Note</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div id="viewColorBar" style="width:4px;height:100%;position:absolute;left:0;top:0;background:#ccc;"></div>

                <h4 id="viewTitle" class="mb-3"></h4>
                <p id="viewDescription" class="mb-4"></p>

                <small class="text-muted">
                    <i class="bi bi-clock"></i> <span id="viewCreated"></span>
                </small>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="viewEditBtn">Edit Note</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- ---------------------- CATEGORY MODAL ---------------------- -->
<div class="modal fade" id="categoryModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="categoryId">
                <input type="text" id="categoryName" class="form-control" placeholder="Name">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="saveCategory()">Save</button>
            </div>

        </div>
    </div>
</div>

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
let notes = [];
let categories = [];
let uploadedFiles = []; // <-- store selected files here

// ------------------------------------------------------------
// LOAD FROM LOCAL STORAGE
// ------------------------------------------------------------
if (localStorage.getItem("notesData")) {
    notes = JSON.parse(localStorage.getItem("notesData"));
}

if (localStorage.getItem("categoryData")) {
    categories = JSON.parse(localStorage.getItem("categoryData"));
} else {
    categories = ["Daily Reflections", "Learning & Development", "Ideas & Inspiration"];
}

// ------------------------------------------------------------
// SAVE TO LOCAL STORAGE
// ------------------------------------------------------------
function saveNotesToStorage() {
    localStorage.setItem("notesData", JSON.stringify(notes));
}

function saveCategoriesToStorage() {
    localStorage.setItem("categoryData", JSON.stringify(categories));
}

// ------------------------------------------------------------
// RENDER CATEGORIES
// ------------------------------------------------------------
function renderCategories() {
    document.getElementById("categoryList").innerHTML =
        categories.map((c, i) => `
        <tr>
            <td>${c}</td>
            <td>
    <i class="bi bi-pencil-square text-warning me-4" role="button" onclick="editCategory(${i})"></i>
    <i class="bi bi-x-circle text-danger" role="button" onclick="deleteCategory(${i})"></i>
</td>

        </tr>
    `).join("");

    document.getElementById("noteCategory").innerHTML =
        `<option value="">- Category -</option>` +
        categories.map(c => `<option>${c}</option>`).join("");
}

// ------------------------------------------------------------
// FORMAT DATE
// ------------------------------------------------------------
function formatDate(date) {
    if (!date) return "-";
    return new Date(date).toLocaleString("en-IN", { hour12: true });
}

// ------------------------------------------------------------
// RENDER NOTES (LIST + GRID)
// ------------------------------------------------------------
function renderNotes() {

    // LIST VIEW
    document.getElementById("noteList").innerHTML = notes.map((n, i) => `
        <tr>
            <td>${formatDate(n.created_at)}</td>

            <td>
                <span style="width:10px;height:10px;border-radius:50%;display:inline-block;background:${n.label_color};margin-right:8px;"></span>
                <a href="#" onclick="openViewNote(${i})" class="text-decoration-none">${n.title}</a>
            </td>

            <td>${n.category}</td>

            <td>${n.files && n.files.length > 0 ? n.files.length + " files" : "-"}</td>

            <td class="text-end">
                <i class="bi bi-pencil-square text-primary me-2 " role="button" onclick="editNote(${i})"></i>
                <i class="bi bi-x-circle text-danger" role="button" onclick="deleteNote(${i})"></i>
            </td>
        </tr>
    `).join("");
    // GRID VIEW
    document.getElementById("noteGrid").innerHTML = notes.map((n, i) => `
        <div class="col-md-4">
            <div class="card mb-3" style="background:${n.background_color}">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-2">
                        <div style="width:12px;height:12px;border-radius:50%;background:${n.label_color}"></div>
                        <h6 class="ms-2 mb-0">${n.title}</h6>
                    </div>

                    <p class="mb-1">${n.description}</p>
                    <span class="badge bg-secondary">${n.category}</span>

                    <div class="mt-1">
                        <button class="btn btn-sm btn-warning" onclick="editNote(${i})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteNote(${i})">Delete</button>
                    </div>

                </div>
            </div>
        </div>
    `).join("");
}

// ------------------------------------------------------------
// ADD NOTE
// ------------------------------------------------------------
let selectedLabel = "";

function openNoteModal() {
    document.getElementById("noteId").value = "";
    document.getElementById("noteTitle").value = "";
    document.getElementById("noteDescription").value = "";
    document.getElementById("noteCategory").value = "";
    document.getElementById("noteCreated").value = "";
    selectedLabel = "";
    uploadedFiles = [];
    document.getElementById("noteFileInput").value = "";

    new bootstrap.Modal("#noteModal").show();
}

// ------------------------------------------------------------
// FILE INPUT HANDLER
// ------------------------------------------------------------
document.getElementById("noteFileInput").addEventListener("change", function () {
    uploadedFiles = Array.from(this.files);
    console.log("Files selected:", uploadedFiles);
});

// ------------------------------------------------------------
// SAVE NOTE (WITH FILES)
// ------------------------------------------------------------
function saveNote() {
    const id = document.getElementById("noteId").value;

    const obj = {
        title: document.getElementById("noteTitle").value,
        description: document.getElementById("noteDescription").value,
        category: document.getElementById("noteCategory").value,
        created_at: document.getElementById("noteCreated").value,
        label_color: selectedLabel,
        background_color: selectedLabel + "33",
        files: uploadedFiles  // <-- FILES SAVED HERE
    };

    if (id === "") notes.push(obj);
    else notes[id] = obj;

    saveNotesToStorage();
    renderNotes();

    // Reset file input
    uploadedFiles = [];
    document.getElementById("noteFileInput").value = "";

    bootstrap.Modal.getInstance(document.getElementById("noteModal")).hide();
}

// ------------------------------------------------------------
// EDIT NOTE
// ------------------------------------------------------------
function editNote(index) {
    const n = notes[index];

    document.getElementById("noteId").value = index;
    document.getElementById("noteTitle").value = n.title;
    document.getElementById("noteDescription").value = n.description;
    document.getElementById("noteCategory").value = n.category;
    document.getElementById("noteCreated").value = n.created_at;
    selectedLabel = n.label_color;

    uploadedFiles = n.files || [];
    document.getElementById("noteFileInput").value = "";

    new bootstrap.Modal("#noteModal").show();
}

// ------------------------------------------------------------
// DELETE NOTE
// ------------------------------------------------------------
function deleteNote(index) {
    notes.splice(index, 1);
    saveNotesToStorage();
    renderNotes();
}

// ------------------------------------------------------------
// SELECT LABEL COLOR
// ------------------------------------------------------------
function selectLabel(color) {
    selectedLabel = color;
}

// ------------------------------------------------------------
// VIEW NOTE
// ------------------------------------------------------------
function openViewNote(index) {
    const n = notes[index];

    document.getElementById("viewTitle").innerText = n.title;
    document.getElementById("viewDescription").innerText = n.description;
    document.getElementById("viewCreated").innerText = formatDate(n.created_at);
    document.getElementById("viewColorBar").style.background = n.label_color;

    document.getElementById("viewEditBtn").onclick = function () {
        editNote(index);
        bootstrap.Modal.getInstance(document.getElementById("viewNoteModal")).hide();
    };

    new bootstrap.Modal("#viewNoteModal").show();
}

// ------------------------------------------------------------
// CATEGORY CRUD
// ------------------------------------------------------------
function openCategoryModal() {
    document.getElementById("categoryId").value = "";
    document.getElementById("categoryName").value = "";
    new bootstrap.Modal("#categoryModal").show();
}

function saveCategory() {
    const id = document.getElementById("categoryId").value;
    const name = document.getElementById("categoryName").value;

    if (id === "") categories.push(name);
    else categories[id] = name;

    saveCategoriesToStorage();
    renderCategories();

    bootstrap.Modal.getInstance(document.getElementById("categoryModal")).hide();
}

function editCategory(index) {
    document.getElementById("categoryId").value = index;
    document.getElementById("categoryName").value = categories[index];
    new bootstrap.Modal("#categoryModal").show();
}

function deleteCategory(index) {
    categories.splice(index, 1);
    saveCategoriesToStorage();
    renderCategories();
}
function filterNotes() {
    const keyword = document.getElementById("searchInput").value.toLowerCase();

    const filtered = notes.filter(n =>
        n.title.toLowerCase().includes(keyword) ||
        n.description.toLowerCase().includes(keyword) ||
        n.category.toLowerCase().includes(keyword)
    );

    renderFilteredNotes(filtered);
}
function exportToExcel() {
    let table = document.getElementById("noteList");
    let rows = [["Created Date", "Title", "Category", "Files"]];

    notes.forEach(n => {
        rows.push([
            formatDate(n.created_at),
            n.title,
            n.category,
            n.files ? n.files.length + " files" : "-"
        ]);
    });

    let csv = rows.map(e => e.join(",")).join("\n");
    let blob = new Blob([csv], { type: "text/csv" });
    let link = document.createElement("a");

    link.href = URL.createObjectURL(blob);
    link.download = "notes_export.csv";
    link.click();
}
function printNotes() {
    let printWindow = window.open("", "_blank");
    
    let tableHTML = `
        <h3>Notes (Private)</h3>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <th>Created Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Files</th>
            </tr>
            ${notes.map(n => `
                <tr>
                    <td>${formatDate(n.created_at)}</td>
                    <td>${n.title}</td>
                    <td>${n.category}</td>
                    <td>${n.files ? n.files.length + " files" : "-"}</td>
                </tr>`).join("")}
        </table>
    `;

    printWindow.document.write(tableHTML);
    printWindow.document.close();
    printWindow.print();
}
// =========================
// PAGINATION VARIABLES
// =========================
let currentPage = 1;
let rowsPerPage = 10;

// =========================
// PAGINATION HANDLER
// =========================
function paginateNotes() {
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    let paginatedNotes = notes.slice(start, end);
    renderPaginatedList(paginatedNotes);
    updatePaginationNumbers();
}

// RENDER ONLY CURRENT PAGE ROWS
function renderPaginatedList(list) {
    document.getElementById("noteList").innerHTML = list
        .map((n, i) => `
        <tr>
            <td>${formatDate(n.created_at)}</td>

            <td>
                <span style="width:10px;height:10px;border-radius:50%;display:inline-block;background:${n.label_color};margin-right:8px;"></span>
                <a href="#" onclick="openViewNote(${i})" class="text-decoration-none">${n.title}</a>
            </td>

            <td>${n.category}</td>
            <td>${n.files && n.files.length > 0 ? n.files.length + " files" : "-"}</td>

            <td class="text-end">
                <i class="bi bi-pencil-square text-primary me-2" role="button" onclick="editNote(${i})"></i>
                <i class="bi bi-x-circle text-danger" role="button" onclick="deleteNote(${i})"></i>
            </td>
        </tr>
    `)
    .join("");
}

// =========================
// PAGINATION BUTTON LOGIC
// =========================
function updatePaginationNumbers() {
    let totalPages = Math.ceil(notes.length / rowsPerPage);
    let container = document.getElementById("paginationNumbers");
    container.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        container.innerHTML += `
            <span class="pagination-number ${i === currentPage ? "active" : ""}" onclick="gotoPage(${i})">${i}</span>
        `;
    }
}

function gotoPage(page) {
    currentPage = page;
    paginateNotes();
}

function nextPage() {
    let totalPages = Math.ceil(notes.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        paginateNotes();
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        paginateNotes();
    }
}

function changeRowsPerPage() {
    rowsPerPage = parseInt(document.getElementById("rowsPerPage").value);
    currentPage = 1;
    paginateNotes();
}

// Hook pagination into your renderNotes()
const originalRenderNotes = renderNotes;

renderNotes = function () {
    originalRenderNotes();
    paginateNotes();
};

// ------------------------------------------------------------
// INITIAL LOAD
// ------------------------------------------------------------
renderCategories();
renderNotes();
</script>



</body>
</html>

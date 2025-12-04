let items = [];
let itemsPerPage = 5;
let currentPage = 1;
let deleteIndex = null;

document.addEventListener("DOMContentLoaded", () => {

    const tbody = document.getElementById("itemBody");
    const searchBox = document.getElementById("searchBox");
    const categoryFilter = document.getElementById("categoryFilter");
    const importFile = document.getElementById("importFile");

    // Load JSON
    fetch("item_json.php")
        .then(res => res.json())
        .then(data => {
            items = data;
            loadCategories();
            renderTable();
        });

    importFile.addEventListener("change", handleImport);

    searchBox.addEventListener("keyup", () => {
        currentPage = 1;
        renderTable();
    });

    categoryFilter.addEventListener("change", () => {
        currentPage = 1;
        renderTable();
    });

});

// ========== RENDER TABLE + PAGINATION ==========
function renderTable() {

    let tbody = document.getElementById("itemBody");
    let search = document.getElementById("searchBox").value.toLowerCase();
    let category = document.getElementById("categoryFilter").value;

    let filtered = items.filter(i =>
        (i.title.toLowerCase().includes(search) || i.description.toLowerCase().includes(search)) &&
        (category === "" || i.category === category)
    );

    let totalPages = Math.ceil(filtered.length / itemsPerPage);

    let start = (currentPage - 1) * itemsPerPage;
    let paginated = filtered.slice(start, start + itemsPerPage);

    tbody.innerHTML = "";

    paginated.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td class="fw-semibold">
                    <i class="bi bi-folder2-open me-1"></i> 
                    <span class="text-primary" role="button" onclick="openViewModal(${start + index})">${item.title}</span>
                </td>
                <td>${item.description}</td>
                <td>${item.category}</td>
                <td>${item.unit}</td>
                <td>${item.rate}</td>
                <td class="text-end">
                    <div class="d-inline-flex">
                        <button class="btn btn-sm btn-light border me-1" onclick="openEditModal(${start + index})"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-light border" onclick="openDelete(${start + index})"><i class="bi bi-x-lg"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    let pag = document.getElementById("pagination");
    pag.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        pag.innerHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <button class="page-link" onclick="goToPage(${i})">${i}</button>
            </li>
        `;
    }
}

function goToPage(page) {
    currentPage = page;
    renderTable();
}

// ================= ADD ITEM =================
function saveNewItem() {
    let newItem = {
        title: document.getElementById("addTitle").value,
        description: document.getElementById("addDescription").value,
        category: document.getElementById("addCategory").value,
        unit: document.getElementById("addUnit").value,
        rate: document.getElementById("addRate").value,
        image: "" // added image support
    };

    items.push(newItem);
    document.getElementById("addTitle").value = "";
    document.getElementById("addDescription").value = "";
    bootstrap.Modal.getInstance(document.getElementById("addItemModal")).hide();
    renderTable();
}

// ================= SMALL EDIT ITEM (Old) =================
function openEditModal(index) {
    // Keep your old modal working
    let item = items[index];

    document.getElementById("editIndex").value = index;
    document.getElementById("editTitle").value = item.title;
    document.getElementById("editDescription").value = item.description;
    document.getElementById("editCategory").value = item.category;
    document.getElementById("editUnit").value = item.unit;
    document.getElementById("editRate").value = item.rate;

    new bootstrap.Modal(document.getElementById("editItemModal")).show();
}

// ================= BIG EDIT MODAL (NEW — screenshot version) =================
function openEditFromView(index) {
    let item = items[index];

    document.getElementById("editIndexBig").value = index;
    document.getElementById("editTitleBig").value = item.title;
    document.getElementById("editDescriptionArea").innerHTML = item.description;
    document.getElementById("editCategoryBig").value = item.category;
    document.getElementById("editUnitBig").value = item.unit;
    document.getElementById("editRateBig").value = item.rate;
    document.getElementById("editShowPortalBig").checked = true;

    // Load image or placeholder
    document.getElementById("editImagePreview").src =
        item.image ? item.image : "https://via.placeholder.com/180";

    new bootstrap.Modal(document.getElementById("editItemModalBig")).show();
}

function updateBigEdit() {

    let i = document.getElementById("editIndexBig").value;

    items[i].title = document.getElementById("editTitleBig").value;
    items[i].description = document.getElementById("editDescriptionArea").innerHTML;
    items[i].category = document.getElementById("editCategoryBig").value;
    items[i].unit = document.getElementById("editUnitBig").value;
    items[i].rate = document.getElementById("editRateBig").value;

    let imgFile = document.getElementById("editImageUpload").files[0];

    if (imgFile) {
        let reader = new FileReader();
        reader.onload = function (e) {
            items[i].image = e.target.result;
            document.getElementById("editImagePreview").src = e.target.result;
            renderTable();
        };
        reader.readAsDataURL(imgFile);
    }

    bootstrap.Modal.getInstance(document.getElementById("editItemModalBig")).hide();
    renderTable();
}

// ================= DELETE ITEM =================
function openDelete(index) {
    deleteIndex = index;
    new bootstrap.Modal(document.getElementById("deleteModal")).show();
}

function confirmDelete() {
    items.splice(deleteIndex, 1);
    bootstrap.Modal.getInstance(document.getElementById("deleteModal")).hide();
    renderTable();
}

// ================= IMPORT CSV =================
function handleImport(event) {
    let file = event.target.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = function (e) {
        let lines = e.target.result.split("\n");

        lines.forEach(line => {
            let parts = line.split(",");
            if (parts.length < 5) return;

            items.push({
                title: parts[0].trim(),
                description: parts[1].trim(),
                category: parts[2].trim(),
                unit: parts[3].trim(),
                rate: parts[4].trim(),
                image: ""
            });
        });

        renderTable();
    };
    reader.readAsText(file);
}

// ================= CATEGORY FILTER LOAD =================
function loadCategories() {
    let cats = [...new Set(items.map(i => i.category))];
    let categoryFilter = document.getElementById("categoryFilter");

    cats.forEach(c => {
        categoryFilter.innerHTML += `<option value="${c}">${c}</option>`;
    });
}

// ================= PRINT =================
function printItems() {
    let printWindow = window.open("", "_blank");
    let table = document.querySelector("table").outerHTML;

    printWindow.document.write(`
        <html>
            <head>
                <title>Print Items</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body class="p-3">
                <h4 class="mb-3">Items</h4>
                ${table}
            </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print();
}

// ================= EXCEL =================
function exportExcel() {
    let table = document.querySelector("table").outerHTML;

    let excelFile =
        `<html>
            <head>
                <meta charset="UTF-8">
            </head>
            <body>${table}</body>
        </html>`;

    let blob = new Blob([excelFile], { type: "application/vnd.ms-excel" });

    let url = URL.createObjectURL(blob);

    let a = document.createElement("a");
    a.href = url;
    a.download = "items.xls";
    a.click();

    URL.revokeObjectURL(url);
}

// ================= VIEW DETAILS =================
function openViewModal(index) {
    let item = items[index];

    document.getElementById("viewTitle").innerText = item.title;
    document.getElementById("viewRateBadge").innerText = `$${item.rate}.00`;
    document.getElementById("viewUnit").innerText = "/" + item.unit;
    document.getElementById("viewDescription").innerText = item.description;

    document.getElementById("viewImage").src =
        item.image ? item.image : "https://via.placeholder.com/180";

    // Updated: open BIG edit modal
    document.getElementById("viewEditBtn").onclick = function () {
        bootstrap.Modal.getInstance(document.getElementById("viewItemModal")).hide();
        openEditFromView(index);
    };

    new bootstrap.Modal(document.getElementById("viewItemModal")).show();
}

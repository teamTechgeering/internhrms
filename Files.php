<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">
<div class="row">

<!-- ================= LEFT ================= -->
<div class="col-md-3 border-end">

    <div class="input-group mb-3">
        <input type="text" id="searchBox" class="form-control" placeholder="Search folder or file">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
    </div>

    <h6>Home</h6>
    <button class="list-group-item list-group-item-action border-0 mb-2"
            onclick="openFolder('Home')">
        <i class="bi bi-house-door me-2"></i> Home
    </button>

    <h6 class="mt-3">Folders</h6>
    <div id="folderList" class="list-group small"></div>

</div>

<!-- ================= CENTER ================= -->
<div class="col-md-6">

    <div class="d-flex justify-content-end gap-2 mb-3">

        <button class="btn btn-outline-primary btn-sm"
                onclick="openFolderModal()">
            <i class="bi bi-folder-plus"></i> New folder
        </button>

        <button class="btn btn-outline-primary btn-sm"
                onclick="document.getElementById('fileInput').click()">
            <i class="bi bi-file-earmark-plus"></i> Upload
        </button>

        <!-- DETAILS TOGGLE -->
        <button class="btn btn-outline-secondary btn-sm"
                onclick="toggleDetails()">
            <i class="bi bi-info-circle"></i>
        </button>

        <input type="file" id="fileInput" class="d-none"
               onchange="uploadFile(this.files)">
    </div>

    <h5 id="currentPath"></h5>
    <div id="fileGrid"></div>

</div>

<!-- ================= DETAILS ================= -->
<div class="col-md-3 border-start d-none" id="detailsPanel">

    <div class="d-flex justify-content-between align-items-center mt-3">
        <h5>Details</h5>
        <button class="btn btn-sm" onclick="toggleDetails()">✕</button>
    </div>

    <div id="detailsBox" class="text-center p-3 text-muted">
        <i class="bi bi-file-earmark-text fs-1 d-block mb-2"></i>
        Select a file
    </div>
</div>

</div>
</div>
</div>
</div>

<!-- ================= CREATE FOLDER ================= -->
<div class="modal fade" id="folderModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
    <div class="modal-header">
        <h5>Create Folder</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <input id="folderName" class="form-control" placeholder="Folder name">
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="createFolder()">Create</button>
    </div>
</div>
</div>
</div>

<!-- ================= PREVIEW ================= -->
<div class="modal fade" id="previewModal">
<div class="modal-dialog modal-fullscreen">
<div class="modal-content bg-dark">
    <div class="modal-header border-0">
        <h6 id="previewTitle" class="text-white"></h6>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body d-flex justify-content-center align-items-center">
        <img id="previewImage" class="img-fluid rounded" style="max-height:90vh">
    </div>
</div>
</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
const UPLOAD_PATH = "uploads/";

const folderList   = document.getElementById("folderList");
const fileGrid     = document.getElementById("fileGrid");
const currentPath  = document.getElementById("currentPath");
const detailsPanel = document.getElementById("detailsPanel");
const detailsBox   = document.getElementById("detailsBox");
const folderName   = document.getElementById("folderName");
const previewTitle = document.getElementById("previewTitle");
const previewImage = document.getElementById("previewImage");

let currentFolder = "Home";
let selectedFile = null;

let fileSystem = {
    Home: { folders: [], files: [] }
};

/* STORAGE */
function save() {
    localStorage.setItem("fs", JSON.stringify(fileSystem));
}
function load() {
    const d = localStorage.getItem("fs");
    if (d) fileSystem = JSON.parse(d);
}

/* HELPERS */
function isImage(name) {
    return /\.(jpg|jpeg|png|gif|webp)$/i.test(name);
}

/* SIDEBAR */
function renderSidebar() {
    folderList.innerHTML = "";
    fileSystem.Home.folders.forEach(f => {
        folderList.innerHTML += `
        <div class="list-group-item border-0"
             onclick="openFolder('${f}')">
            <i class="bi bi-folder me-2"></i>${f}
        </div>`;
    });
}

/* FOLDERS */
function openFolderModal() {
    folderName.value = "";
    new bootstrap.Modal(folderModal).show();
}

function createFolder() {
    const name = folderName.value.trim();
    if (!name) return;

    if (fileSystem[currentFolder].folders.includes(name))
        return alert("Folder exists");

    fileSystem[currentFolder].folders.push(name);
    fileSystem[name] = { folders: [], files: [] };

    save();
    renderSidebar();
    openFolder(currentFolder);

    bootstrap.Modal.getInstance(folderModal).hide();
}

/* OPEN FOLDER */
function openFolder(name) {
    currentFolder = name;
    currentPath.innerHTML = `<i class="bi bi-folder"></i> ${name}`;

    let html = "";

    fileSystem[name].folders.forEach(f => {
        const c = fileSystem[f];
        html += `
        <div class="p-3 border rounded mb-2 d-flex align-items-center"
             ondblclick="openFolder('${f}')">
            <i class="bi bi-folder-fill text-warning fs-2 me-3"></i>
            <div>
                <div class="fw-semibold">${f}</div>
                <small class="text-muted">
                    ${c.folders.length} folders,
                    ${c.files.length} files
                </small>
            </div>
        </div>`;
    });

    fileSystem[name].files.forEach(f => {
        html += `
        <div class="p-3 border rounded mb-2 d-flex align-items-center"
             onclick="showDetails('${f.name}')"
             ondblclick="preview('${f.name}')">
            <i class="bi bi-file-earmark-image fs-2 text-primary me-3"></i>
            <div>
                <div class="fw-semibold">${f.name}</div>
                <small class="text-muted">${f.size}</small>
            </div>
        </div>`;
    });

    fileGrid.innerHTML = html;
}

/* DETAILS */
function toggleDetails() {
    detailsPanel.classList.toggle("d-none");
}

function showDetails(name) {
    const file = fileSystem[currentFolder].files.find(f => f.name === name);
    if (!file) return;

    selectedFile = name;
    detailsPanel.classList.remove("d-none");

    detailsBox.innerHTML = `
        ${isImage(file.name)
            ? `<img src="${UPLOAD_PATH}${file.name}" class="img-fluid rounded mb-3">`
            : ""}
        <h6>${file.name}</h6>
        <div class="text-muted">${file.size}</div>
        <div class="text-muted mb-3">${file.time}</div>

        <button class="btn btn-sm btn-danger w-100"
                onclick="deleteFile()">
            <i class="bi bi-trash"></i> Delete
        </button>`;
}

/* DELETE */
function deleteFile() {
    if (!selectedFile) return;
    if (!confirm("Delete this file?")) return;

    fileSystem[currentFolder].files =
        fileSystem[currentFolder].files.filter(f => f.name !== selectedFile);

    save();
    openFolder(currentFolder);
    toggleDetails();
}

/* PREVIEW */
function preview(name) {
    if (!isImage(name)) return;
    previewTitle.innerText = name;
    previewImage.src = UPLOAD_PATH + name;
    new bootstrap.Modal(previewModal).show();
}

/* UPLOAD */
function uploadFile(files) {
    const file = files[0];
    if (!file) return;

    const fd = new FormData();
    fd.append("file", file);

    fetch("uploads.php", {
        method: "POST",
        body: fd
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            fileSystem[currentFolder].files.push({
                name: d.name,
                size: d.size,
                time: new Date().toLocaleString()
            });
            save();
            openFolder(currentFolder);
        }
    });
}

/* INIT */
load();
renderSidebar();
openFolder("Home");
</script>

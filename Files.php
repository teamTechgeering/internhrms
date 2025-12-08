<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">
<div class="row">

    <!-- ==================== LEFT SIDEBAR ==================== -->
    <div class="col-md-3 border-end">

        <!-- SEARCH -->
        <div class="input-group mb-3">
            <input type="text" id="searchBox" class="form-control" placeholder="Search folder or file">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        </div>

        <h6 class="mb-3">Home</h6>

        <button class="list-group-item list-group-item-action border-0 bg-white mb-3"
                onclick="openFolder('Home')">
            <i class="bi bi-house-door me-2"></i> Home
        </button>

        <h6 class="mb-2">Favorites</h6>

        <div id="favoriteList" class="list-group small">
            <!-- Auto filled by JS -->
        </div>

    </div>

    <!-- ==================== MIDDLE FILE AREA ==================== -->
    <div class="col-md-6">

        <!-- TOP BUTTONS -->
        <div class="d-flex justify-content-end gap-2 mb-3">
            <button class="btn btn-outline-primary btn-sm" onclick="createFolder()">
                <i class="bi bi-folder-plus"></i> New folder
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="document.getElementById('fileInput').click()">
                <i class="bi bi-file-earmark-plus"></i> Add files
            </button>
            <input type="file" id="fileInput" class="d-none" onchange="addFiles(this.files)">
        </div>

        <!-- CURRENT PATH -->
        <h5 id="currentPath" class="mb-3"></h5>

        <!-- FOLDER/FILE LIST -->
        <div id="fileGrid">
            <!-- Filled by JS -->
        </div>
    </div>

    <!-- ==================== RIGHT DETAILS PANEL ==================== -->
    <div class="col-md-3 border-start">
        <h5 class="mt-3">Details</h5>

        <div id="detailsBox" class="text-center p-4 text-muted">
            <i class="bi bi-file-earmark-text fs-1 d-block mb-2"></i>
            Select a file or folder to view its details
        </div>
    </div>

</div>
</div>

</div>
</div>
<!-- CREATE FOLDER MODAL -->
<div class="modal fade" id="newFolderModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Create New Folder</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="text" id="newFolderName" class="form-control" placeholder="Folder name">
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveNewFolder()">Create</button>
      </div>

    </div>
  </div>
</div>


<?php include 'common/footer.php'; ?>
<script>
/* ==========================================
   FILE MANAGER DATA (FOLDERS + FILES)
========================================== */

/* =========================================================
   LOCAL STORAGE HELPERS
========================================================= */
function saveToLocal() {
    localStorage.setItem("fileSystem", JSON.stringify(fileSystem));
    localStorage.setItem("favorites", JSON.stringify(favorites));
}

function loadFromLocal() {
    if (localStorage.getItem("fileSystem")) {
        fileSystem = JSON.parse(localStorage.getItem("fileSystem"));
    }
    if (localStorage.getItem("favorites")) {
        favorites = JSON.parse(localStorage.getItem("favorites"));
    }
}


/* =========================================================
   INITIAL DATA (DEFAULT IF FIRST TIME)
========================================================= */
let fileSystem = {
    "Home": {
        folders: ["Documents", "Human Resources", "Images", "Marketing", "Presentations"],
        files: [
            { name: "working.jpg", size: "206 KB" },
            { name: "study.jpg", size: "167 KB" },
            { name: "mountains.jpg", size: "398 KB" }
        ]
    },

    "Documents": { folders: [], files: [] },
    "Human Resources": { folders: [], files: [] },
    "Images": { folders: [], files: [] },
    "Marketing": { folders: [], files: [] },
    "Presentations": { folders: [], files: [] }
};

let favorites = ["Documents", "Human Resources", "Marketing"];
let currentFolder = "Home";


/* =========================================================
   LOAD FAVORITES
========================================================= */
function loadFavorites() {
    let html = "";
    favorites.forEach(f => {
        html += `
            <button class="list-group-item list-group-item-action border-0"
                    onclick="openFolder('${f}')">${f}</button>`;
    });
    document.getElementById("favoriteList").innerHTML = html;
}


/* =========================================================
   OPEN FOLDER
========================================================= */
function openFolder(folderName) {
    currentFolder = folderName;

    document.getElementById("currentPath").innerHTML =
        `<i class="bi bi-folder"></i> ${folderName}`;

    let folder = fileSystem[folderName];
    let html = "";

    // Render folders
    folder.folders.forEach(f => {
        html += `
            <div class="p-2 border rounded mb-2 d-flex align-items-center"
                 onclick="openFolder('${f}')" style="cursor:pointer;">
                <i class="bi bi-folder-fill text-warning fs-4 me-2"></i>
                <div>${f}</div>
            </div>`;
    });

    // Render files
    folder.files.forEach(f => {
        html += `
            <div class="p-2 border rounded mb-2 d-flex align-items-center"
                 onclick="showDetails('${f.name}', '${f.size}')" style="cursor:pointer;">
                <i class="bi bi-file-earmark fs-4 text-primary me-2"></i>
                <div>
                    <div>${f.name}</div>
                    <small class="text-muted">${f.size}</small>
                </div>
            </div>`;
    });

    document.getElementById("fileGrid").innerHTML = html;
    clearDetails();
}


/* =========================================================
   SHOW FILE DETAILS
========================================================= */
function showDetails(name, size) {
    document.getElementById("detailsBox").innerHTML = `
        <h6>${name}</h6>
        <p class="text-muted">Size: ${size}</p>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteFile('${name}')">
            Delete
        </button>`;
}


/* CLEAR DETAILS PANEL */
function clearDetails() {
    document.getElementById("detailsBox").innerHTML = `
        <i class="bi bi-file-earmark-text fs-1 d-block mb-2"></i>
        Select a file or folder to view its details`;
}


/* =========================================================
   OPEN CREATE FOLDER MODAL
========================================================= */
function createFolder() {
    document.getElementById("newFolderName").value = "";
    new bootstrap.Modal(document.getElementById("newFolderModal")).show();
}


/* =========================================================
   SAVE NEW FOLDER
========================================================= */
function saveNewFolder() {
    let name = document.getElementById("newFolderName").value.trim();
    if (!name) return;

    fileSystem[currentFolder].folders.push(name);
    fileSystem[name] = { folders: [], files: [] };

    saveToLocal();         // <-- FIX: Save changes
    openFolder(currentFolder);

    bootstrap.Modal.getInstance(document.getElementById("newFolderModal")).hide();
}


/* =========================================================
   ADD FILES
========================================================= */
function addFiles(fileList) {
    [...fileList].forEach(file => {
        fileSystem[currentFolder].files.push({
            name: file.name,
            size: Math.round(file.size / 1024) + " KB"
        });
    });

    saveToLocal();         // <-- FIX
    openFolder(currentFolder);
}


/* =========================================================
   DELETE FILE
========================================================= */
function deleteFile(name) {
    let folder = fileSystem[currentFolder];
    folder.files = folder.files.filter(f => f.name !== name);

    saveToLocal();         // <-- FIX
    openFolder(currentFolder);
}


/* =========================================================
   SEARCH
========================================================= */
document.getElementById("searchBox").addEventListener("keyup", function () {
    let q = this.value.toLowerCase();
    let folder = fileSystem[currentFolder];

    let html = "";

    folder.folders
        .filter(f => f.toLowerCase().includes(q))
        .forEach(f => {
            html += `
                <div class="p-2 border rounded mb-2 d-flex align-items-center"
                     onclick="openFolder('${f}')">
                    <i class="bi bi-folder-fill text-warning fs-4 me-2"></i>
                    <span>${f}</span>
                </div>`;
        });

    folder.files
        .filter(f => f.name.toLowerCase().includes(q))
        .forEach(f => {
            html += `
                <div class="p-2 border rounded mb-2 d-flex align-items-center"
                     onclick="showDetails('${f.name}', '${f.size}')">
                    <i class="bi bi-file-earmark fs-4 text-primary me-2"></i>
                    <span>${f.name}</span>
                </div>`;
        });

    document.getElementById("fileGrid").innerHTML = html;
});


/* =========================================================
   INITIAL LOAD
========================================================= */
loadFromLocal();   // <-- Load localStorage first
loadFavorites();
openFolder("Home");
</script>
  
</body>
</html>
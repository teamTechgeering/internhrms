<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">
<div class="row">

<!-- ================= LEFT SIDEBAR ================= -->
<div class="col-md-3 border-end">

    <div class="input-group mb-3">
        <input type="text" id="searchBox" class="form-control" placeholder="Search folder or file">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
    </div>

    <h6 class="mb-2">Home</h6>

    <button class="list-group-item list-group-item-action border-0 bg-white mb-2"
            onclick="openFolder('Home')">
        <i class="bi bi-house-door me-2"></i> Home
    </button>

    <h6 class="mt-3 mb-2">Folders</h6>
    <div id="folderList" class="list-group small"></div>

</div>

<!-- ================= MAIN ================= -->
<div class="col-md-6">

    <div class="d-flex justify-content-end gap-2 mb-3">

        <button class="btn btn-outline-primary btn-sm" onclick="openFolderModal()">
            <i class="bi bi-folder-plus"></i> New folder
        </button>

        <button class="btn btn-outline-primary btn-sm"
                onclick="document.getElementById('fileInput').click()">
            <i class="bi bi-file-earmark-plus"></i> Add files
        </button>

        <button class="btn btn-outline-secondary btn-sm" onclick="toggleDetails()">
            <i class="bi bi-info-circle"></i>
        </button>

        <input type="file" id="fileInput" class="d-none" onchange="uploadFile(this.files)">
    </div>

    <h5 id="currentPath" class="mb-3"></h5>
    <div id="fileGrid"></div>

</div>

<!-- ================= DETAILS ================= -->
<div class="col-md-3 border-start d-none" id="detailsPanel">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h5>Details</h5>
        <button class="btn btn-sm" onclick="closeDetails()">✕</button>
    </div>

    <div id="detailsBox" class="p-3 text-muted text-center mt-3">
        Select a file to view details
    </div>
</div>

</div>
</div>
</div>
</div>

<!-- ================= CREATE FOLDER MODAL ================= -->
<div class="modal fade" id="folderModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Folder</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="folderName" class="form-control" placeholder="Folder name">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="createFolder()">Create</button>
      </div>
    </div>
  </div>
</div>

<!-- ================= CONTEXT MENU ================= -->
 <div id="folderContextMenu"
     class="position-fixed bg-white border rounded shadow d-none"
     style="z-index:9999; min-width:220px">

    <ul class="list-unstyled mb-0">
        <li class="px-3 py-2" onclick="exploreFolder()">⚡ Explore</li>
        <li class="px-3 py-2" onclick="renameFolder()">✏ Rename</li>
        <li class="px-3 py-2 text-danger" onclick="confirmDelete()">🗑 Delete</li>
    </ul>
</div>

<div id="contextMenu" class="position-fixed bg-white border rounded shadow d-none" style="z-index:9999;">
    <ul class="list-unstyled mb-0">
        <li class="px-3 py-2" onclick="viewItem()">⚡ View</li>
        <li class="px-3 py-2" onclick="showDetails(selectedItem)">ℹ Info</li>
        <li class="px-3 py-2 text-danger" onclick="confirmDelete()">🗑 Delete</li>
        <li class="px-3 py-2" onclick="downloadFile()">⬇ Download</li>
    </ul>
</div>

<!-- ================= DELETE MODAL ================= -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm delete</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Are you sure?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" onclick="deleteItem()">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- ================= RENAME FOLDER MODAL ================= -->
<div class="modal fade" id="renameFolderModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Rename Folder</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="text"
               id="renameFolderInput"
               class="form-control"
               placeholder="New folder name">
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="confirmRenameFolder()">Rename</button>
      </div>

    </div>
  </div>
</div>

<!-- ================= PREVIEW MODAL ================= -->
<div class="modal fade" id="previewModal" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <h6 class="modal-title text-white" id="previewTitle"></h6>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center">
        <img id="previewImage" class="img-fluid rounded" style="max-height:90vh;">
      </div>
    </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>

<script>
const UPLOAD_PATH = "uploads/";
const CURRENT_USER = "John Doe";

let currentFolder = "Home";
let selectedItem = null;
let selectedType = null;

/* ================= FILE SYSTEM ================= */
let fileSystem = {
    Home: { folders: [], files: [] }
};

/* ================= STORAGE ================= */
function saveToLocal() {
    localStorage.setItem("fileSystem", JSON.stringify(fileSystem));
}
function loadFromLocal() {
    if (localStorage.getItem("fileSystem")) {
        fileSystem = JSON.parse(localStorage.getItem("fileSystem"));
    }
}

/* ================= HELPERS ================= */
function isImage(name) {
    return /\.(jpg|jpeg|png|gif|webp)$/i.test(name);
}
function toggleDetails() {
    detailsPanel.classList.toggle("d-none");
}
function closeDetails() {
    detailsPanel.classList.add("d-none");
}

/* ================= SIDEBAR (HOME ONLY) ================= */
function renderSidebar() {
    folderList.innerHTML = "";
    fileSystem.Home.folders.forEach(f => {
        folderList.innerHTML += `
        <button class="list-group-item list-group-item-action border-0"
                onclick="openFolder('${f}')">
            <i class="bi bi-folder me-2"></i>${f}
        </button>`;
    });
}

/* ================= CREATE FOLDER ================= */
function openFolderModal() {
    folderName.value = "";
    new bootstrap.Modal(folderModal).show();
}

function createFolder() {
    const name = folderName.value.trim();
    if (!name) return alert("Folder name required");

    if (fileSystem[currentFolder].folders.includes(name)) {
        return alert("Folder already exists");
    }

    // ADD TO CURRENT FOLDER (NESTED SUPPORT)
    fileSystem[currentFolder].folders.push(name);
    fileSystem[name] = { folders: [], files: [] };

    saveToLocal();
    renderSidebar();
    openFolder(currentFolder);

    bootstrap.Modal.getInstance(folderModal).hide();
}

/* ================= OPEN FOLDER ================= */
function openFolder(folder) {
    currentFolder = folder;
    currentPath.innerHTML = `<i class="bi bi-folder me-2"></i>${folder}`;

    let html = "";

    // FOLDERS
    fileSystem[folder].folders.forEach(f => {
        const child = fileSystem[f];
        html += `
        <div class="p-3 border rounded mb-2 d-flex align-items-center"
             ondblclick="openFolder('${f}')"
             oncontextmenu="openContextMenu(event,'${f}','folder')">
            <i class="bi bi-folder-fill text-warning fs-3 me-3"></i>
            <div>
                <div class="fw-semibold">${f}</div>
                <small class="text-muted">
                    ${child.folders.length} Folders, ${child.files.length} Files
                </small>
            </div>
        </div>`;
    });

    // FILES
    fileSystem[folder].files.forEach(f => {
        html += `
        <div class="p-3 border rounded mb-2 d-flex align-items-center"
             ondblclick="openPreview('${f.name}')"
             onclick="showDetails('${f.name}')"
             oncontextmenu="openContextMenu(event,'${f.name}','file')">
            <i class="bi bi-file-earmark fs-3 text-primary me-3"></i>
            <div>
                <div class="fw-semibold">${f.name}</div>
                <small class="text-muted">${f.size}</small>
            </div>
        </div>`;
    });

    fileGrid.innerHTML = html;
}

/* ================= SEARCH ================= */
searchBox.addEventListener("keyup", function () {
    const q = this.value.toLowerCase();
    let html = "";

    fileSystem[currentFolder].folders
        .filter(f => f.toLowerCase().includes(q))
        .forEach(f => {
            html += `
            <div class="p-3 border rounded mb-2 d-flex align-items-center"
                 ondblclick="openFolder('${f}')">
                <i class="bi bi-folder-fill text-warning fs-3 me-3"></i>${f}
            </div>`;
        });

    fileSystem[currentFolder].files
        .filter(f => f.name.toLowerCase().includes(q))
        .forEach(f => {
            html += `
            <div class="p-3 border rounded mb-2 d-flex align-items-center"
                 onclick="showDetails('${f.name}')">
                <i class="bi bi-file-earmark fs-3 text-primary me-3"></i>${f.name}
            </div>`;
        });

    fileGrid.innerHTML = html;
});

/* ================= DETAILS ================= */
function showDetails(name) {
    const file = fileSystem[currentFolder].files.find(f => f.name === name);
    if (!file) return;

    detailsPanel.classList.remove("d-none");
    detailsBox.innerHTML = `
        ${isImage(file.name) ? `<img src="${UPLOAD_PATH}${file.name}" class="img-fluid rounded mb-3">` : ``}
        <div class="fw-semibold text-primary">${file.name}</div>
        <div class="text-muted">${file.size}</div>
        <hr>
        Uploaded by<br>${file.uploadedBy}<br><br>
        Uploaded at<br>${file.uploadedAt}
    `;
}

/* ================= PREVIEW ================= */
function openPreview(name) {
    previewTitle.innerText = name;
    previewImage.src = UPLOAD_PATH + name;
    new bootstrap.Modal(previewModal).show();
}

/* ================= UPLOAD ================= */
function uploadFile(files) {
    if (!files.length) return;

    const formData = new FormData();
    formData.append("file", files[0]);

    fetch("uploads.php", { method: "POST", body: formData })
    .then(res => res.json())
    .then(d => {
        if (d.success) {
            fileSystem[currentFolder].files.push({
                name: d.name,
                size: d.size,
                uploadedBy: CURRENT_USER,
                uploadedAt: new Date().toLocaleString()
            });
            saveToLocal();
            openFolder(currentFolder);
        }
    });
}

/* ================= CONTEXT MENU ================= */
function openContextMenu(e, name, type) {
    e.preventDefault();

    selectedItem = name;
    selectedType = type;

    folderContextMenu.classList.add("d-none");
    contextMenu.classList.add("d-none");

    const menu = type === "folder" ? folderContextMenu : contextMenu;
    menu.style.top = e.clientY + "px";
    menu.style.left = e.clientX + "px";
    menu.classList.remove("d-none");
}

document.addEventListener("click", () => {
    folderContextMenu.classList.add("d-none");
    contextMenu.classList.add("d-none");
});

/* ================= MENU ACTIONS ================= */
function viewItem() {
    if (selectedType === "file") openPreview(selectedItem);
}
function exploreFolder() {
    openFolder(selectedItem);
}
function downloadFile() {
    if (selectedType !== "file") return;

    const link = document.createElement("a");
    link.href = UPLOAD_PATH + selectedItem;
    link.download = selectedItem;   // force download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function confirmDelete() {
    new bootstrap.Modal(deleteModal).show();
}

/* ================= DELETE ================= */
function deleteItem() {

    if (selectedType === "file") {
        fileSystem[currentFolder].files =
            fileSystem[currentFolder].files.filter(f => f.name !== selectedItem);
    }

    if (selectedType === "folder") {
        // REMOVE FROM CURRENT FOLDER (NOT ALWAYS HOME)
        fileSystem[currentFolder].folders =
            fileSystem[currentFolder].folders.filter(f => f !== selectedItem);

        delete fileSystem[selectedItem];
        renderSidebar();
    }

    saveToLocal();
    openFolder(currentFolder);
    closeDetails();
    bootstrap.Modal.getInstance(deleteModal).hide();
}

/* ================= RENAME FOLDER ================= */
function renameFolder() {
    if (selectedType !== "folder") return;

    renameFolderInput.value = selectedItem;
    new bootstrap.Modal(renameFolderModal).show();
}

function confirmRenameFolder() {
    const oldName = selectedItem;
    const newName = renameFolderInput.value.trim();
    if (!newName || newName === oldName) return;

    if (fileSystem[currentFolder].folders.includes(newName)) {
        alert("Folder already exists");
        return;
    }

    const idx = fileSystem[currentFolder].folders.indexOf(oldName);
    if (idx !== -1) {
        fileSystem[currentFolder].folders[idx] = newName;
    }

    fileSystem[newName] = fileSystem[oldName];
    delete fileSystem[oldName];

    saveToLocal();
    renderSidebar();
    openFolder(currentFolder);

    bootstrap.Modal.getInstance(renameFolderModal).hide();
}

/* ================= INIT ================= */
loadFromLocal();
renderSidebar();
openFolder("Home");
</script>




</body>
</html>

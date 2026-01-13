<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-3">

    <!-- TOP BAR -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-4">
            <h4 class="mb-0">Help</h4>

            <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link" href="articles.php">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-medium" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="help.php">Panel</a>
                </li>
            </ul>
        </div>

        <!-- DO NOT REMOVE -->
        <a href="add_category.php" id="addCategoryBtn" class="btn btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Add category
        </a>
    </div>

    <!-- ACTION BAR -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-light border">
                <i class="bi bi-layout-text-window"></i>
            </button>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-light border" onclick="window.print()">Print</button>

            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Search">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="categoryTable">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <a href="guideline.php?category=Guidelines" class="text-primary text-decoration-none">
                                Guidelines
                            </a>
                        </td>
                        <td>Description about how to work with our team.</td>
                        <td>Active</td>
                        <td>0</td>
                        <td class="d-flex gap-2">
                            <button class="btn btn-light btn-sm editBtn">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-light btn-sm" onclick="deleteRow(this)">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="helpdesk.php?category=Help%20desk" class="text-primary text-decoration-none">
                                Help desk
                            </a>
                        </td>
                        <td>All useful information about our team.</td>
                        <td>Active</td>
                        <td>0</td>
                        <td class="d-flex gap-2">
                            <button class="btn btn-light btn-sm editBtn">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-light btn-sm" onclick="deleteRow(this)">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="leavepolicy.php?category=Leave%20policy" class="text-primary text-decoration-none">
                                Leave policy
                            </a>
                        </td>
                        <td>Information about the leave of our team members.</td>
                        <td>Active</td>
                        <td>0</td>
                        <td class="d-flex gap-2">
                            <button class="btn btn-light btn-sm editBtn">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-light btn-sm" onclick="deleteRow(this)">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <select class="form-select w-auto">
                <option>10</option>
            </select>
            <span class="text-muted">1-3 / 3</span>
            <div class="d-flex gap-2">
                <button class="btn btn-light border">&lsaquo;</button>
                <button class="btn btn-light border">1</button>
                <button class="btn btn-light border">&rsaquo;</button>
            </div>
        </div>
    </div>

</div>

</div>
</div>

<!-- ================= ADD CATEGORY MODAL (ADDED ONLY) ================= -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add category</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" id="addTitle" class="form-control" placeholder="Title">
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea id="addDescription" class="form-control" rows="4" placeholder="Description"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Sort</label>
          <input type="number" id="addSort" class="form-control" value="0">
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label><br>
          <input type="radio" name="addStatus" value="Active" checked> Active
          <input type="radio" name="addStatus" value="Inactive" class="ms-3"> Inactive
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x"></i> Close
        </button>
        <button class="btn btn-primary" onclick="addCategoryRow()">
          <i class="bi bi-check-circle"></i> Save
        </button>
      </div>

    </div>
  </div>
</div>

<!-- EDIT CATEGORY MODAL -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit category</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" id="modalTitle" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>

          <div class="border rounded-top p-2 bg-white">
            <button class="btn btn-sm" onclick="cmd('bold')"><b>B</b></button>
            <button class="btn btn-sm" onclick="cmd('italic')"><i>I</i></button>
            <button class="btn btn-sm" onclick="cmd('underline')"><u>U</u></button>
          </div>

          <div id="modalDescription"
               contenteditable="true"
               class="border border-top-0 rounded-bottom p-3"
               style="min-height:140px;"></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Sort</label>
          <input type="number" id="modalSort" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="modalStatus" value="Active" checked>
            <label class="form-check-label">Active</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="modalStatus" value="Inactive">
            <label class="form-check-label">Inactive</label>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x"></i> Close
        </button>
        <button class="btn btn-primary" onclick="saveCategory()">
          <i class="bi bi-check-circle"></i> Save
        </button>
      </div>

    </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>

<script>
let currentRow = null;

/* OPEN EDIT MODAL */
document.querySelectorAll(".editBtn").forEach(btn => {
    btn.addEventListener("click", function () {
        currentRow = this.closest("tr");

        modalTitle.value = currentRow.children[0].innerText.trim();
        modalDescription.innerText = currentRow.children[1].innerText.trim();
        modalSort.value = currentRow.children[3].innerText.trim();

        new bootstrap.Modal(
            document.getElementById("editCategoryModal")
        ).show();
    });
});

/* SAVE */
function saveCategory() {
    if (!currentRow) return;

    currentRow.children[0].innerHTML =
        `<a class="text-primary text-decoration-none">${modalTitle.value}</a>`;

    currentRow.children[1].innerText = modalDescription.innerText;
    currentRow.children[3].innerText = modalSort.value;

    bootstrap.Modal.getInstance(
        document.getElementById("editCategoryModal")
    ).hide();
}

/* SIMPLE EDITOR */
function cmd(command) {
    document.execCommand(command, false, null);
}

/* DELETE ROW */
function deleteRow(btn) {
    if (!confirm("Are you sure you want to delete this category?")) return;
    btn.closest("tr").remove();
}

/* SEARCH */
document.getElementById("searchInput").addEventListener("keyup", function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll("#categoryTable tbody tr").forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(value)
            ? ""
            : "none";
    });
});
/* OPEN ADD MODAL */
document.getElementById("addCategoryBtn").addEventListener("click", function(e){
    e.preventDefault();
    new bootstrap.Modal(document.getElementById("addCategoryModal")).show();
});

/* ADD ROW */
function addCategoryRow() {
    const title = addTitle.value.trim();
    const desc = addDescription.value.trim();
    const sort = addSort.value || 0;
    const status = document.querySelector('input[name="addStatus"]:checked').value;

    if (!title) return alert("Title is required");

    const row = document.createElement("tr");
    row.innerHTML = `
        <td><a class="text-primary text-decoration-none">${title}</a></td>
        <td>${desc}</td>
        <td>${status}</td>
        <td>${sort}</td>
        <td class="d-flex gap-2">
            <button class="btn btn-light btn-sm editBtn"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-light btn-sm" onclick="deleteRow(this)"><i class="bi bi-x"></i></button>
        </td>
    `;
    document.querySelector("#categoryTable tbody").appendChild(row);

    bootstrap.Modal.getInstance(addCategoryModal).hide();
    addTitle.value = addDescription.value = "";
}
</script>

</body>
</html>

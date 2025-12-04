<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-3">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">Items</h4>

        <div class="d-flex align-items-center">

            <!-- Import Items -->
            <input type="file" id="importFile" accept=".csv" class="d-none">
            <button class="btn btn-light border me-2" onclick="document.getElementById('importFile').click()">
                <i class="bi bi-upload me-1"></i> Import items
            </button>

            <!-- Add item button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                <i class="bi bi-plus-lg me-1"></i> Add item
            </button>
        </div>
    </div>

    <!-- FILTER + SEARCH BAR -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group" style="width:220px;">
            <span class="input-group-text bg-white"><i class="bi bi-filter"></i></span>
            <select id="categoryFilter" class="form-select">
                <option value="">- Category -</option>
            </select>
        </div>

        <div class="d-flex align-items-center">
            <button class="btn btn-light border me-2 px-3" onclick="exportExcel()">Excel</button>
            <button class="btn btn-light border me-3 px-3" onclick="printItems()">Print</button>


            <div class="input-group" style="width:230px;">
                <input type="text" id="searchBox" class="form-control" placeholder="Search">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:25%">Title</th>
                    <th>Description</th>
                    <th style="width:10%">Category</th>
                    <th style="width:10%">Unit</th>
                    <th style="width:10%">Rate</th>
                    <th class="text-end" style="width:5%;"></th>
                </tr>
            </thead>
            <tbody id="itemBody"></tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-end mt-3">
        <nav>
            <ul class="pagination" id="pagination"></ul>
        </nav>
    </div>

</div>
</div>
</div>

<!-- ========================= ADD ITEM MODAL ========================= -->
<div class="modal" id="addItemModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Item</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input id="addTitle" class="form-control mb-2" placeholder="Title">
                <textarea id="addDescription" class="form-control mb-2" placeholder="Description"></textarea>

                <select id="addCategory" class="form-select mb-2">
                    <option value="">Select Category</option>
                    <option>Design</option>
                    <option>Services</option>
                    <option>Development</option>
                </select>

                <select id="addUnit" class="form-select mb-2">
                    <option value="Hour">Hour</option>
                    <option value="PC">PC</option>
                </select>

                <input id="addRate" type="number" class="form-control" placeholder="Rate">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="saveNewItem()">Save</button>
            </div>

        </div>
    </div>
</div>

<!-- ========================= EDIT ITEM MODAL ========================= -->
<div class="modal fade" id="editItemModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Item</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input id="editTitle" class="form-control mb-2">
                <textarea id="editDescription" class="form-control mb-2"></textarea>

                <select id="editCategory" class="form-select mb-2">
                    <option>Design</option>
                    <option>Services</option>
                    <option>Development</option>
                </select>

                <select id="editUnit" class="form-select mb-2">
                    <option>Hour</option>
                    <option>PC</option>
                </select>

                <input id="editRate" type="number" class="form-control">
                <input type="hidden" id="editIndex">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="updateItem()">Update</button>
            </div>

        </div>
    </div>
</div>

<!-- ========================= DELETE CONFIRM MODAL ========================= -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body text-center">
                <p class="mb-3">Are you sure you want to delete?</p>
                <button class="btn btn-danger me-2" onclick="confirmDelete()">Delete</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<!-- ========================= VIEW ITEM DETAILS MODAL ========================= -->
<div class="modal fade" id="viewItemModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Item details</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <h4 id="viewTitle" class="fw-semibold"></h4>

                <div class="d-flex align-items-center mb-2">
                    <span id="viewRateBadge" class="badge bg-primary me-2"></span>
                    <span id="viewUnit" class="text-muted"></span>
                </div>

                <p id="viewDescription" class="mb-3"></p>

                <!-- Info text -->
                <p class="text-muted"><i class="bi bi-info-circle me-1"></i> First image will be the default image.</p>

                <!-- Image preview -->
                <img id="viewImage" src="" class="img-thumbnail" style="width:180px;">
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-primary" id="viewEditBtn">
                    <i class="bi bi-pencil me-1"></i>Edit item
                </button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- ========================= EDIT ITEM MODAL (BIG) ========================= -->
<div class="modal fade" id="editItemModalBig">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit item</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Title -->
                <label class="fw-semibold mb-1">Title</label>
                <input id="editTitleBig" class="form-control mb-3">

                <!-- Description -->
                <label class="fw-semibold mb-1">Description</label>

                <div class="border rounded mb-2 p-2 bg-white">
                    <div class="btn-toolbar mb-2">
                        <button class="btn btn-sm btn-light me-1" onclick="document.execCommand('bold')"><b>B</b></button>
                        <button class="btn btn-sm btn-light me-1" onclick="document.execCommand('italic')"><i>I</i></button>
                        <button class="btn btn-sm btn-light me-1" onclick="document.execCommand('underline')"><u>U</u></button>
                        <button class="btn btn-sm btn-light me-1" onclick="document.execCommand('insertUnorderedList')">• List</button>
                        <button class="btn btn-sm btn-light me-1" onclick="document.execCommand('insertOrderedList')">1. List</button>
                    </div>

                    <div id="editDescriptionArea" class="form-control" contenteditable="true" style="min-height:150px;"></div>
                </div>

                <!-- Category -->
                <label class="fw-semibold mb-1">Category</label>
                <select id="editCategoryBig" class="form-select mb-3">
                    <option>Design</option>
                    <option>Services</option>
                    <option>Development</option>
                </select>

                <!-- Unit type -->
                <label class="fw-semibold mb-1">Unit type</label>
                <select id="editUnitBig" class="form-select mb-3">
                    <option>Hour</option>
                    <option>PC</option>
                </select>

                <!-- Rate -->
                <label class="fw-semibold mb-1">Rate</label>
                <input id="editRateBig" type="number" class="form-control mb-3">

                <!-- Checkbox -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="editShowPortalBig">
                    <label class="form-check-label">Show in client portal</label>
                </div>

                <!-- Image preview -->
                <img id="editImagePreview" src="" class="img-thumbnail mb-3" style="width:180px;">

                <!-- Upload image -->
                <input type="file" id="editImageUpload" class="d-none" accept="image/*">
                <button class="btn btn-outline-secondary" onclick="document.getElementById('editImageUpload').click()">
                    <i class="bi bi-camera me-1"></i> Upload Image
                </button>

                <input type="hidden" id="editIndexBig">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="updateBigEdit()">Save</button>
            </div>

        </div>
    </div>
</div>




<?php include 'common/footer.php'; ?>
<script src="assets/js/item.js"></script>
</body>
</html>

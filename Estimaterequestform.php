<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>
<div class="container py-5">

    <h3 class="mb-4">Website Development</h3>

    <!-- FIELD LIST -->
    <div class="card p-4">
        <div id="fieldsContainer"></div>

        <!-- ADD FIELD BUTTON -->
        <div class="text-center mt-3">
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addFieldModal">
                Add field
            </button>
        </div>
    </div>
</div>


<!-- ADD FIELD MODAL -->
<div class="modal fade" id="addFieldModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Field</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input id="addTitle" class="form-control mb-2" placeholder="Title">
                <select id="addType" class="form-select mb-2">
                    <option value="text">Text</option>
                    <option value="dropdown">Dropdown</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="saveNewField()">Save</button>
            </div>

        </div>
    </div>
</div>


<!-- EDIT FIELD MODAL -->
<div class="modal fade" id="editFieldModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Field</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input id="editTitle" class="form-control mb-2" placeholder="Title">
                <select id="editType" class="form-select mb-2">
                    <option value="text">Text</option>
                    <option value="dropdown">Dropdown</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="saveEditedField()">Save changes</button>
            </div>

        </div>
    </div>
</div>


<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete?</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete this field?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" onclick="confirmDelete()">Delete</button>
            </div>

        </div>
    </div>
</div>  
  </div>
</div>
<?php include 'common/footer.php'; ?>
<script src="assets/js/Estimaterequestform.js"></script>
</body>
</html>

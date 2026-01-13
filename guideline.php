<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">
<div class="row">

<!-- LEFT -->
<div class="col-lg-3">
    <div class="input-group mb-3">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input class="form-control" placeholder="Search your question">
    </div>

    <div class="fw-medium mb-2">Categories</div>
    <div class="list-group list-group-flush">
        <a href="guideline.php" class="list-group-item border-0 fw-medium">Guidelines</a>
        <a href="helpdesk.php" class="list-group-item border-0">Help desk</a>
        <a href="leavepolicy.php" class="list-group-item border-0">Leave policy</a>
    </div>
</div>

<!-- RIGHT -->
<div class="col-lg-9">
    <h2 id="catTitle">Guidelines</h2>

    <div class="text-muted mb-3">
        <i class="bi bi-house"></i> / <span id="catBread">Guidelines</span>

        <div class="float-end d-flex gap-2">
            <a href="articles.php" class="btn btn-light border">
                <i class="bi bi-journal-text"></i> Articles
            </a>
            <a href="categories.php" class="btn btn-light border">
                <i class="bi bi-box"></i> Categories
            </a>
            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                <i class="bi bi-pencil"></i>
            </button>
        </div>
    </div>

    <p id="catDesc">Description about how to work with our team.</p>

    <div class="mt-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-file-earmark-text"></i>
            <a href="view_help.php?title=How to develop a best product?" class="text-decoration-none">
                How to develop a best product?
            </a>
        </div>

        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-text"></i>
            <a href="view_help.php?title=How to submit your work to product manager?" class="text-decoration-none">
                How to submit your work to product manager?
            </a>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

<!-- EDIT MODAL -->
<div class="modal" id="editCategoryModal">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
    <h5>Edit category</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input id="editTitle" class="form-control" value="Guidelines">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <div contenteditable="true" id="editDesc"
             class="form-control" style="min-height:120px;">
            Description about how to work with our team.
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Sort</label>
        <input class="form-control" value="0">
    </div>

    <div class="mb-3">
        <label class="form-label">Articles order</label>
        <select class="form-select">
            <option>A-Z</option>
            <option>Z-A</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label><br>
        <input type="radio" checked> Active
        <input type="radio" class="ms-3"> Inactive
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-light border" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary" onclick="saveCategory()">Save</button>
</div>

</div>
</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
function saveCategory(){
    document.getElementById("catTitle").innerText = editTitle.value;
    document.getElementById("catBread").innerText = editTitle.value;
    document.getElementById("catDesc").innerText = editDesc.innerText;
    bootstrap.Modal.getInstance(editCategoryModal).hide();
}
</script>

</body>
</html>

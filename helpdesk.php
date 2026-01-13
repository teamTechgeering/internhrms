<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>
<div class="content-page"><div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4"><div class="row">

<div class="col-lg-3">
    <div class="input-group mb-3">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input class="form-control" placeholder="Search your question">
    </div>
    <div class="fw-medium mb-2">Categories</div>
    <div class="list-group list-group-flush">
        <a href="guideline.php" class="list-group-item border-0">Guidelines</a>
        <a class="list-group-item border-0 fw-medium">Help desk</a>
        <a href="leavepolicy.php" class="list-group-item border-0">Leave policy</a>
    </div>
</div>

<div class="col-lg-9">
    <h2 id="title">Help desk</h2>
    <div class="text-muted mb-3">
        <i class="bi bi-house"></i> / <span id="breadcrumb">Help desk</span>
        <div class="float-end d-flex gap-2">
            <a href="articles.php" class="btn btn-light border">Articles</a>
            <a href="categories.php" class="btn btn-light border">Categories</a>
             <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                <i class="bi bi-pencil"></i>
            </button>
        </div>
    </div>

    <p id="desc">All useful information about our team.</p>

    <div class="mt-4">
        <div><i class="bi bi-file-earmark-text"></i> How to share your knowledge with team?</div>
        <div class="mt-2"><i class="bi bi-file-earmark-text"></i> How to use help desk?</div>
    </div>
</div>

</div></div></div></div>

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
function save(){
    title.innerText = editTitle.value;
    breadcrumb.innerText = editTitle.value;
    desc.innerText = editDesc.innerText;
}
</script>
</body></html>

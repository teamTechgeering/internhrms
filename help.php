<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-5">

    <!-- TOP BUTTONS -->
    <div class="d-flex gap-2 mb-4">
        <a href="articles.php" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="bi bi-journal-text"></i> Articles
        </a>

        <a href="categories.php" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="bi bi-grid"></i> Categories
        </a>
    </div>

    <!-- TITLE -->
    <div class="text-center mb-4">
        <h2 class="fw-normal">Internal Wiki</h2>
    </div>

    <!-- SEARCH -->
    <div class="d-flex justify-content-center mb-5">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text"
                       class="form-control bg-light border-0"
                       placeholder="Search your question">
            </div>
        </div>
    </div>

    <!-- CARDS -->
    <div class="row justify-content-center g-4">

        <!-- Guidelines -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center py-4">
                    <h5 class="mb-2">Guidelines</h5>
                    <p class="text-muted mb-3">
                        Description about how to work with our team.
                    </p>
                    <a href="guideline.php" class="fw-medium">
                        2 articles
                    </a>
                </div>
            </div>
        </div>

        <!-- Help Desk -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center py-4">
                    <h5 class="mb-2">Help desk</h5>
                    <p class="text-muted mb-3">
                        All useful information about our team.
                    </p>
                    <a href="helpdesk.php" class="fw-medium">
                        2 articles
                    </a>
                </div>
            </div>
        </div>

        <!-- Leave Policy -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center py-4">
                    <h5 class="mb-2">Leave policy</h5>
                    <p class="text-muted mb-3">
                        Information about the leave of our team members.
                    </p>
                    <a href="leavepolicy.php" class="fw-medium">
                        2 articles
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

</div>
</div>
<?php include 'common/footer.php'; ?>
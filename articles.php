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
                    <a class="nav-link active fw-medium" href="articles.php">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="help.php">Panel</a>
                </li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#labelModal">
                <i class="bi bi-tag"></i> Manage labels
            </button>
            <a href="new_article.php" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Add new article
            </a>
        </div>
    </div>

    <!-- ACTION BAR -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <button class="btn btn-light border">
                <i class="bi bi-layout-text-window"></i>
            </button>

            <select id="categoryFilter" class="form-select w-auto">
                <option value="">+ Add new filter</option>
                <option value="Help desk">Help desk</option>
                <option value="Guidelines">Guidelines</option>
                <option value="Leave policy">Leave policy</option>
            </select>
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
            <table class="table align-middle mb-0" id="articleTable">
                <thead class="table-light">
                    <tr>
                        <th role="button" onclick="sortTable()">
                            Title <i class="bi bi-arrow-down"></i>
                        </th>
                        <th>Category</th>
                        <th>Created at</th>
                        <th>Status</th>
                        <th>Total views</th>
                        <th>Sort</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="articleBody"></tbody>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <select class="form-select w-auto">
                <option>10</option>
            </select>
            <span class="text-muted">1-6 / 6</span>
            <div class="d-flex gap-2">
                <button class="btn btn-light border">&lsaquo;</button>
                <button class="btn btn-light border">1</button>
                <button class="btn btn-light border">&rsaquo;</button>
            </div>
        </div>
    </div>

</div>

<!-- MANAGE LABEL MODAL -->
<div class="modal fade" id="labelModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Manage labels</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-success">&nbsp;</span>
                    <span class="badge bg-info">&nbsp;</span>
                    <span class="badge bg-primary">&nbsp;</span>
                    <span class="badge bg-secondary">&nbsp;</span>
                    <span class="badge bg-warning">&nbsp;</span>
                    <span class="badge bg-danger">&nbsp;</span>
                    <span class="badge bg-dark">&nbsp;</span>
                </div>

                <div class="d-flex gap-2">
                    <input type="text" class="form-control" placeholder="Label">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
let ARTICLE_DATA = [];

/* LOAD JSON DATA */
fetch('article_json.php')
    .then(res => res.json())
    .then(data => {
        ARTICLE_DATA = data;
        renderArticles(ARTICLE_DATA);
    });

function renderArticles(data) {
    const tbody = document.getElementById("articleBody");
    tbody.innerHTML = "";

    data.forEach((item, index) => {
        const encodedTitle = encodeURIComponent(item.title);

        tbody.innerHTML += `
        <tr>
            <td>
                <a href="view_help.php?title=${encodedTitle}" class="text-primary text-decoration-none">
                    ${item.title}
                </a>
            </td>
            <td>${item.category}</td>
            <td>${item.created_at}</td>
            <td>${item.status}</td>
            <td>${item.views}</td>
            <td>${item.sort}</td>
            <td class="d-flex gap-2">
                <a href="edit_help.php?title=${encodedTitle}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <button class="btn btn-light btn-sm" onclick="deleteArticle(${index})">
                    <i class="bi bi-x"></i>
                </button>
            </td>
        </tr>`;
    });
}

/* DELETE ARTICLE (FRONTEND ONLY) */
function deleteArticle(index) {
    if (!confirm("Are you sure you want to delete this article?")) return;

    ARTICLE_DATA.splice(index, 1);
    renderArticles(ARTICLE_DATA);
}

/* SEARCH */
document.getElementById("searchInput").addEventListener("keyup", function () {
    const value = this.value.toLowerCase();
    const filtered = ARTICLE_DATA.filter(a =>
        a.title.toLowerCase().includes(value)
    );
    renderArticles(filtered);
});

/* CATEGORY FILTER */
document.getElementById("categoryFilter").addEventListener("change", function () {
    const value = this.value;
    const filtered = !value
        ? ARTICLE_DATA
        : ARTICLE_DATA.filter(a => a.category === value);
    renderArticles(filtered);
});

/* SORT BY TITLE */
function sortTable() {
    const sorted = [...ARTICLE_DATA].sort((a, b) =>
        a.title.localeCompare(b.title)
    );
    renderArticles(sorted);
}
</script>

</body>
</html>

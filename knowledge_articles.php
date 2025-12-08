<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">

    <div class="row">

        <!-- ==================== LEFT SIDEBAR ==================== -->
        <div class="col-md-3">

            <!-- SEARCH BAR -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search your question">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>

            <!-- CATEGORY TITLE -->
            <h6 class="mb-3">Categories</h6>

            <!-- CATEGORY LIST (JS will fill this) -->
            <div id="kbCategoryList" class="list-group"></div>

        </div>

        <!-- ==================== RIGHT CONTENT ==================== -->
        <div class="col-md-9">

            <!-- PAGE TITLE -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 id="kbTitle" class="fw-semibold mb-0"></h4>
            </div>

            <!-- BREADCRUMB -->
            <div class="mb-3">
                <span id="kbBreadcrumb" class="text-muted"></span>
            </div>

            <!-- DESCRIPTION -->
            <p id="kbDescription" class="text-muted"></p>

            <!-- ARTICLES LIST -->
            <div id="kbArticleList" class="list-group"></div>

        </div>

    </div>

</div>

</div>
</div>

<?php include 'common/footer.php'; ?>


<!-- =============================== -->
<!--         JAVASCRIPT LOGIC        -->
<!-- =============================== -->

<script>
// ===============================
// KNOWLEDGE BASE DATA
// ===============================
let kbData = [
    {
        id: 1,
        name: "Billing and Payments",
        desc: "Our payment methods, billing terms, invoice policy.",
        articles: [
            "At vero eos et accusamus et iusto odio",
            "How to pay my invoices?",
            "Sed ut perspiciatis unde omnis iste natus"
        ]
    },
    {
        id: 2,
        name: "Features",
        desc: "Details about our business, features and products.",
        articles: [
            "Feature overview",
            "How to use advanced tools"
        ]
    },
    {
        id: 3,
        name: "Sales and Support",
        desc: "Check our sales and customer support policy.",
        articles: [
            "Customer support rules",
            "Sales guidelines"
        ]
    }
];

let activeCategory = 1;


// ===============================
// LOAD CATEGORY LIST (LEFT SIDE)
// ===============================
function loadCategoryList() {
    let html = "";

    kbData.forEach(cat => {
        html += `
            <a onclick="loadCategory(${cat.id})"
               class="list-group-item list-group-item-action ${cat.id === activeCategory ? 'active' : ''}">
                ${cat.name}
            </a>
        `;
    });

    document.getElementById("kbCategoryList").innerHTML = html;
}


// ===============================
// LOAD SELECTED CATEGORY (RIGHT SIDE)
// ===============================
function loadCategory(catId) {
    activeCategory = catId;

    let cat = kbData.find(x => x.id === catId);
    if (!cat) return;

    loadCategoryList(); // reset active style

    // Update title
    document.getElementById("kbTitle").innerText = cat.name;

    // Update breadcrumb
    document.getElementById("kbBreadcrumb").innerHTML =
        `<i class="bi bi-house-door"></i> / ${cat.name}`;

    // Update description
    document.getElementById("kbDescription").innerText = cat.desc;

    // Update article list
    let articleHTML = "";
    cat.articles.forEach(a => {
        articleHTML += `
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-file-text me-2"></i> ${a}
            </a>
        `;
    });

    document.getElementById("kbArticleList").innerHTML = articleHTML;
}


// ===============================
// INITIAL LOAD
// ===============================
window.onload = function () {
    loadCategoryList();
    loadCategory(activeCategory);
};
</script>

</body>
</html>

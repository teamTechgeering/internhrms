<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <!-- ========================= -->
    <!--   TEMPLATES SECTION       -->
    <!-- ========================= -->
    <div id="templatesSection">

        <!-- TOP TABS -->
        

        <!-- CENTER TITLE -->
        <h3 class="text-center mt-5 mb-4">How can we help?</h3>


        <!-- SEARCH BAR -->
        <div class="d-flex justify-content-center mb-4">
            <div class="input-group input-group-lg" style="max-width:500px;">
                <input type="text" class="form-control" placeholder="Search your question">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>

        <!-- CATEGORY GRID -->
        <div class="row g-3 px-4" id="templateCategoryGrid">
            <!-- Auto-filled by JS -->
        </div>

    </div>

  </div>
</div>

<?php include 'common/footer.php'; ?>

<script>
/* ===============================
   TEMPLATE CATEGORY DATA
================================ */
let templateCategories = [
    {
        name: "Billing and Payments",
        desc: "Our payment methods, billing terms, invoice policy.",
        count: 3
    },
    {
        name: "Features",
        desc: "Details about our business, features and products.",
        count: 2
    },
    {
        name: "Sales and Support",
        desc: "Check our sales and customer support policy.",
        count: 2
    }
];

/* ===============================
   LOAD CATEGORY CARDS
================================ */
function loadTemplateCategories() {
    let html = "";

    templateCategories.forEach(cat => {
        html += `
            <div class="col-md-4">
                <div class="card p-4 text-center shadow-sm border-0" style="cursor:pointer;">
                    <h5 class="mb-2">${cat.name}</h5>
                    <p class="text-muted small mb-2">${cat.desc}</p>
                    <a href="knowledge_articles.php" class="text-primary small">${cat.count} articles</a>
                </div>
            </div>
        `;
    });

    document.getElementById("templateCategoryGrid").innerHTML = html;
}

/* ===============================
   INITIAL LOAD
================================ */
window.onload = function () {
    loadTemplateCategories(); // Load categories on page open
};
</script>

</body>
</html>

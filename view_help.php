<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">
    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-lg-3">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search your question">
                </div>
            </div>

            <div class="fw-medium mb-2">Categories</div>
            <div class="list-group list-group-flush">
                 <a href="guideline.php"
                   class="list-group-item border-0 px-0 list-group-item-action">
                    Guidelines
                </a>

                <a href="helpdesk.php"
                   class="list-group-item border-0 px-0 list-group-item-action">
                    Help desk
                </a>

                <a href="leavepolicy.php"
                   class="list-group-item border-0 px-0 list-group-item-action">
                    Leave policy
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-lg-9">
            <h2 id="articleTitle" class="mb-3"></h2>

            <div class="text-muted mb-4">
                <i class="bi bi-house"></i>
                <span id="articleCategory"></span>
                /
                <span id="articleTitle2"></span>
            </div>

            <div id="articleContent" class="text-muted"></div>

            <div class="mt-4 d-flex gap-2">
                <a href="articles.php" class="btn btn-light border">
                    <i class="bi bi-journal-text"></i> Articles
                </a>

                <a id="editBtn" class="btn btn-light border">
                    <i class="bi bi-pencil"></i>
                </a>
            </div>
        </div>

    </div>
</div>

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
const params = new URLSearchParams(window.location.search);
const titleParam = decodeURIComponent(params.get("title") || "").trim();

/* FETCH FROM JSON (SAFE MATCH) */
fetch("article_json.php")
    .then(res => res.json())
    .then(data => {

        const article = data.find(a =>
            a.title &&
            a.title.trim().toLowerCase() === titleParam.toLowerCase()
        );

        if (!article) {
            document.getElementById("articleTitle").innerText = "Article not found";
            return;
        }

        document.getElementById("articleTitle").innerText = article.title;
        document.getElementById("articleTitle2").innerText = article.title;
        document.getElementById("articleCategory").innerText = article.category;

        document.getElementById("articleContent").innerHTML =
            article.content || "No content available for this article.";

        document.getElementById("editBtn").href =
            "edit_help.php?title=" + encodeURIComponent(article.title);
    });
</script>

</body>
</html>

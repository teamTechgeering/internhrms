<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-medium mb-0">Add new article (Help)</h4>

        <a href="articles.php" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="bi bi-journal-text"></i> Articles
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- TITLE -->
            <div class="mb-4">
                <label class="form-label fw-medium">Title</label>
                <input type="text" id="titleInput" class="form-control" placeholder="Title">
            </div>

            <!-- CATEGORY -->
            <div class="mb-4">
                <label class="form-label fw-medium">Category</label>
                <select id="categoryInput" class="form-select">
                    <option selected>Guidelines</option>
                    <option>Help desk</option>
                    <option>Leave policy</option>
                </select>
            </div>

            <!-- EDITOR TOOLBAR -->
            <div class="border rounded-top p-2 bg-white">
                <div class="d-flex flex-wrap gap-2 align-items-center text-muted">

                    <button type="button" class="btn btn-sm" onclick="cmd('bold')"><i class="bi bi-type-bold"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('italic')"><i class="bi bi-type-italic"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('underline')"><i class="bi bi-type-underline"></i></button>

                    <div class="vr"></div>

                    <button type="button" class="btn btn-sm" onclick="cmd('insertUnorderedList')"><i class="bi bi-list-ul"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('insertOrderedList')"><i class="bi bi-list-ol"></i></button>

                    <div class="vr"></div>

                    <button type="button" class="btn btn-sm" onclick="cmd('justifyLeft')"><i class="bi bi-text-left"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('justifyCenter')"><i class="bi bi-text-center"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('justifyRight')"><i class="bi bi-text-right"></i></button>

                    <div class="vr"></div>

                    <button type="button" class="btn btn-sm" onclick="cmd('createLink')"><i class="bi bi-link-45deg"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('insertImage')"><i class="bi bi-image"></i></button>

                    <div class="vr"></div>

                    <button type="button" class="btn btn-sm" onclick="cmd('removeFormat')"><i class="bi bi-eraser"></i></button>
                    <button type="button" class="btn btn-sm" onclick="cmd('code')"><i class="bi bi-code-slash"></i></button>
                </div>
            </div>

            <!-- EDITOR -->
            <div contenteditable="true"
                 id="editor"
                 class="border border-top-0 rounded-bottom p-3 mb-4"
                 style="min-height:260px;"></div>

            <!-- SORT -->
            <div class="mb-4">
                <label class="form-label fw-medium">Sort</label>
                <input type="number" id="sortInput" class="form-control" placeholder="Sort" value="0">
            </div>

            <!-- LABELS -->
            <div class="mb-4">
                <label class="form-label fw-medium">Labels</label>
                <input type="text" id="labelsInput" class="form-control" placeholder="Labels">
            </div>

            <!-- RELATED ARTICLES -->
            <div class="mb-4">
                <label class="form-label fw-medium">Related articles</label>
                <input type="text" id="relatedInput" class="form-control" placeholder="Related articles">
            </div>

            <!-- STATUS -->
            <div class="mb-4">
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="Active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="Inactive">
                        <label class="form-check-label">Inactive</label>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM ACTION BAR -->
        <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">

            <div class="d-flex gap-2">
                <input type="file" id="fileInput" hidden>

                <button type="button"
                        class="btn btn-light border d-flex align-items-center gap-2"
                        onclick="document.getElementById('fileInput').click()">
                    <i class="bi bi-paperclip"></i> Upload File
                </button>

                <button type="button" class="btn btn-light border">
                    <i class="bi bi-mic"></i>
                </button>
            </div>

            <button type="button"
                    class="btn btn-primary d-flex align-items-center gap-2"
                    onclick="saveArticle()">
                <i class="bi bi-check-circle"></i> Save
            </button>

        </div>
    </div>

</div>

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
function cmd(command) {
    if (command === 'createLink') {
        const url = prompt("Enter URL:");
        if (url) document.execCommand(command, false, url);
    } else if (command === 'insertImage') {
        const url = prompt("Enter image URL:");
        if (url) document.execCommand(command, false, url);
    } else if (command === 'code') {
        document.execCommand('insertHTML', false, '<pre><code></code></pre>');
    } else {
        document.execCommand(command, false, null);
    }
}

/* SAVE ARTICLE */
function saveArticle() {
    const articles = JSON.parse(localStorage.getItem("articles") || "[]");

    const status = document.querySelector('input[name="status"]:checked').value;

    const article = {
        title: titleInput.value.trim(),
        category: categoryInput.value,
        content: editor.innerHTML,
        sort: sortInput.value,
        labels: labelsInput.value,
        related: relatedInput.value,
        status: status,
        views: 0,
        created_at: new Date().toLocaleString()
    };

    if (!article.title) {
        alert("Title is required");
        return;
    }

    articles.push(article);
    localStorage.setItem("articles", JSON.stringify(articles));

    location.href = "edit_help.php?title=" + encodeURIComponent(article.title);
}
</script>

</body>
</html>

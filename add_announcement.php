<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid p-4">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4">

      <!-- TITLE -->
      <div class="mb-3">
        <label class="form-label fw-medium">Title</label>
        <input type="text" class="form-control bg-light" placeholder="Title" id="titleInput">
      </div>

      <!-- EDITOR TOOLBAR (UNCHANGED) -->
      <div class="border rounded-top p-2 bg-white">
        <div class="d-flex flex-wrap gap-2 align-items-center text-muted">

          <button class="btn btn-sm" onclick="cmd('bold')"><i class="bi bi-type-bold"></i></button>
          <button class="btn btn-sm" onclick="cmd('italic')"><i class="bi bi-type-italic"></i></button>
          <button class="btn btn-sm" onclick="cmd('underline')"><i class="bi bi-type-underline"></i></button>

          <button class="btn btn-sm" onclick="cmd('insertUnorderedList')"><i class="bi bi-list-ul"></i></button>
          <button class="btn btn-sm" onclick="cmd('insertOrderedList')"><i class="bi bi-list-ol"></i></button>

          <button class="btn btn-sm" onclick="addLink()"><i class="bi bi-link-45deg"></i></button>

          <button class="btn btn-sm" onclick="cmd('removeFormat')"><i class="bi bi-eraser"></i></button>

        </div>
      </div>

      <!-- IMAGE SECTION (UNCHANGED) -->
      <div class="border border-top-0 p-3 mb-3 bg-white text-center">
        <img id="imagePreview" class="img-fluid rounded d-none mb-2">
        <input type="file" id="fileInput" class="d-none" accept="image/*" onchange="attachFile(this)">
        <button class="btn btn-light border btn-sm" onclick="document.getElementById('fileInput').click()">
          <i class="bi bi-image me-1"></i> Add image
        </button>
      </div>

      <!-- DATES -->
      <div class="row mb-4">
        <div class="col-md-6">
          <label class="form-label">Start date</label>
          <input type="text" class="form-control bg-light" placeholder="DD-MM-YYYY" id="startDate">
        </div>
        <div class="col-md-6">
          <label class="form-label">End date</label>
          <input type="text" class="form-control bg-light" placeholder="DD-MM-YYYY" id="endDate">
        </div>
      </div>

      <!-- SHARE WITH -->
      <div class="mb-4">
        <label class="form-label">Share with</label>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox">
          <label class="form-check-label">All team members</label>
        </div>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox">
          <label class="form-check-label">Specific members and teams</label>
        </div>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox">
          <label class="form-check-label">All Clients</label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox">
          <label class="form-check-label">Specific client groups</label>
        </div>
      </div>

      <hr>

      <!-- FOOTER ACTIONS -->
      <div class="d-flex justify-content-end">
        <button class="btn btn-primary px-4" onclick="saveAnnouncement()">
          <i class="bi bi-check-circle me-1"></i> Save
        </button>
      </div>

    </div>
  </div>
</div>

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
/* TEXT COMMANDS (UNCHANGED) */
function cmd(c){ document.execCommand(c); }

function addLink(){
  const url = prompt("Enter URL");
  if(url) document.execCommand("createLink", false, url);
}

/* IMAGE HANDLING */
let imageData = "";

function attachFile(input){
  if(!input.files.length) return;

  const reader = new FileReader();
  reader.onload = () => {
    imageData = reader.result;
    imagePreview.src = imageData;
    imagePreview.classList.remove("d-none");
  };
  reader.readAsDataURL(input.files[0]);
}

/* SAVE + REDIRECT TO EDIT */
function saveAnnouncement(){
  const title = titleInput.value.trim();
  const start = startDate.value;
  const end = endDate.value;

  if(!title){
    alert("Title is required");
    return;
  }

  const id = Date.now();
  let announcements = JSON.parse(localStorage.getItem("announcements") || "[]");

  announcements.unshift({
    id,
    title,
    content: "",   // CONTENT REMOVED BY DESIGN
    image: imageData,
    created_by: "John Doe",
    start_date: start,
    end_date: end,
    created_at: new Date().toLocaleDateString()
  });

  localStorage.setItem("announcements", JSON.stringify(announcements));
  window.location.href = "edit_announcement.php?id=" + id;
}
</script>

</body>
</html>

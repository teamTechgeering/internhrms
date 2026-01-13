<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid p-4">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4">

      <!-- HEADER WITH VIEW BUTTON -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit announcement</h4>
        <button class="btn btn-outline-primary btn-sm" onclick="goToView()">
          <i class="bi bi-eye"></i> View
        </button>
      </div>

      <!-- TITLE -->
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" id="titleInput" class="form-control bg-light">
      </div>

      <!-- TOOLBAR -->
      <div class="border rounded-top p-2 bg-white">
        <button class="btn btn-sm" onclick="cmd('bold')"><b>B</b></button>
        <button class="btn btn-sm" onclick="cmd('italic')"><i>I</i></button>
        <button class="btn btn-sm" onclick="cmd('underline')"><u>U</u></button>
      </div>

      <!-- IMAGE AREA (UNDER TOOLBAR, NOT TEXT) -->
      <div class="border border-top-0 p-3 mb-3 bg-white text-center">
        <img id="imagePreview" class="img-fluid rounded d-none mb-2">
        <input type="file" id="imageInput" class="d-none" accept="image/*" onchange="previewImage(this)">
        <button class="btn btn-light border btn-sm" onclick="document.getElementById('imageInput').click()">
          <i class="bi bi-image me-1"></i> Change image
        </button>
      </div>

      <!-- CONTENT EDITOR -->
      <div id="editor" contenteditable="true"
           class="border rounded p-3 mb-3"
           style="min-height:200px"></div>

      <!-- DATES -->
      <div class="row mb-4">
        <div class="col-md-6">
          <label class="form-label">Start date</label>
          <input type="text" id="startDate" class="form-control bg-light">
        </div>
        <div class="col-md-6">
          <label class="form-label">End date</label>
          <input type="text" id="endDate" class="form-control bg-light">
        </div>
      </div>

      <!-- SAVE -->
      <div class="text-end">
        <button class="btn btn-primary" onclick="updateAnnouncement()">
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
const id = new URLSearchParams(window.location.search).get('id');
let announcements = JSON.parse(localStorage.getItem("announcements") || "[]");
let current = announcements.find(a => a.id == id);
let imageData = current?.image || "";

if(!current){
  alert("Announcement not found");
  window.location.href = "announcement.php";
}

if(current){
  titleInput.value = current.title;
  editor.innerHTML = current.content;
  startDate.value = current.start_date || "";
  endDate.value = current.end_date || "";

  if(current.image){
    imagePreview.src = current.image;
    imagePreview.classList.remove("d-none");
  }
}

function cmd(c){
  document.execCommand(c);
}

function previewImage(input){
  if(!input.files.length) return;

  const r = new FileReader();
  r.onload = () => {
    imageData = r.result;
    imagePreview.src = imageData;
    imagePreview.classList.remove("d-none");
  };
  r.readAsDataURL(input.files[0]);
}

/* SAVE ONLY */
function updateAnnouncement(){
  current.title = titleInput.value.trim();
  current.content = editor.innerHTML;
  current.image = imageData;
  current.start_date = startDate.value;
  current.end_date = endDate.value;

  localStorage.setItem("announcements", JSON.stringify(announcements));
  alert("Successfully saved");
}

/* VIEW BUTTON */
function goToView(){
  window.location.href = "view_announcement.php?id=" + id;
}
</script>

</body>
</html>

<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid p-4">
  <a href="announcement.php" class="text-decoration-none">&larr; Announcements</a>

  <div class="card border-0 shadow-sm mt-3">
    <div class="card-body p-4">

      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <h2 id="title"></h2>
          <p class="text-muted mb-0" id="meta"></p>
        </div>

        <!-- EDIT BUTTON (ADDED) -->
        <button class="btn btn-outline-primary btn-sm" onclick="editCurrent()">
          <i class="bi bi-pencil"></i> Edit
        </button>
      </div>

      <div id="content" class="mb-3"></div>
      <img id="image" class="img-fluid rounded d-none">

    </div>
  </div>
</div>

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
const id = new URLSearchParams(location.search).get('id');

/* MERGE JSON + LOCAL STORAGE */
Promise.all([
  fetch('announcement_json.php').then(r => r.json()),
  Promise.resolve(JSON.parse(localStorage.getItem("announcements") || "[]"))
]).then(([json, local]) => {

  const DATA = [...local, ...json];
  const a = DATA.find(x => x.id == id);

  if(!a){
    alert("Announcement not found");
    window.location.href = "announcement.php";
    return;
  }

  title.innerText = a.title;
  meta.innerText = `${a.created_at || ''}${a.created_at ? ', ' : ''}${a.created_by || ''}`;
  content.innerHTML = a.content;

  if(a.image){
    image.src = a.image;
    image.classList.remove("d-none");
  }
});

/* EDIT CURRENT */
function editCurrent(){
  window.location.href = "edit_announcement.php?id=" + id;
}
</script>

</body>
</html>

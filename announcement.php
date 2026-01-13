<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid p-4">
  <div class="card shadow-sm border-0">
    <div class="card-body p-4">

      <!-- HEADER -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Announcements</h4>
        <a href="add_announcement.php" class="btn btn-outline-primary">
          <i class="bi bi-plus-circle me-1"></i> Add announcement
        </a>
      </div>

      <!-- ACTION BAR -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <button class="btn btn-light border">
            <i class="bi bi-layout-sidebar"></i>
          </button>
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-light border" onclick="printPage()">Print</button>
          <div class="position-relative">
            <input type="text" id="searchInput" class="form-control ps-4" placeholder="Search">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"></i>
          </div>
        </div>
      </div>

      <!-- TABLE -->
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr class="text-muted">
              <th>Title</th>
              <th>Created by</th>
              <th>Start date</th>
              <th>
                <div class="d-flex align-items-center gap-1">
                  <i class="bi bi-arrow-down"></i> End date
                </div>
              </th>
              <th class="text-end">
                <i class="bi bi-list"></i>
              </th>
            </tr>
          </thead>

          <tbody id="announcementBody">
            <!-- JS RENDER -->
          </tbody>
        </table>
      </div>

      <!-- FOOTER -->
      <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex align-items-center gap-2 text-muted">
          <select class="form-select form-select-sm w-auto">
            <option>10</option>
          </select>
          <span id="pageInfo">0</span>
        </div>

        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-light border">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button class="btn btn-outline-primary btn-sm">1</button>
          <button class="btn btn-light border">
            <i class="bi bi-chevron-right"></i>
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

</div>
</div>
<?php include 'common/footer.php'; ?>


<script>
/* =======================
   DATA SOURCE (JSON + LOCAL STORAGE)
======================= */

let DATA = [];

/* Load JSON (existing announcements) */
fetch('announcement_json.php')
  .then(res => res.json())
  .then(json => {
    const local = JSON.parse(localStorage.getItem("announcements") || "[]");
    DATA = [...local, ...json];
    renderTable(DATA);
  });

/* =======================
   RENDER TABLE
======================= */
function renderTable(list){
  const body = document.getElementById('announcementBody');
  body.innerHTML = '';

  if(!list.length){
    body.innerHTML = `<tr>
      <td colspan="5" class="text-center text-muted">No announcements found</td>
    </tr>`;
    return;
  }

  list.forEach(item => {
    body.innerHTML += `
      <tr>
        <td>
          <!-- UPDATED VIEW LINK -->
          <a href="view_announcement.php?id=${item.id}" class="text-primary text-decoration-none">
            ${item.title}
          </a>
        </td>

        <td>
          <a href="member_view.php?name=${item.created_by}" class="text-primary text-decoration-none d-flex align-items-center gap-2">
            <img src="https://via.placeholder.com/32" class="rounded-circle">
            ${item.created_by}
          </a>
        </td>

        <td>${item.start_date || '-'}</td>
        <td>${item.end_date || '-'}</td>

        <td class="text-end">
          <button class="btn btn-light border btn-sm me-1" onclick="editAnnouncement(${item.id})">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn btn-light border btn-sm" onclick="deleteAnnouncement(${item.id})">
            <i class="bi bi-x-lg"></i>
          </button>
        </td>
      </tr>
    `;
  });

  document.getElementById('pageInfo').innerText = `1-${list.length} / ${list.length}`;
}

/* =======================
   EDIT
======================= */
function editAnnouncement(id){
  window.location.href = "edit_announcement.php?id=" + id;
}

/* =======================
   DELETE
======================= */
function deleteAnnouncement(id){
  if(confirm('Delete this announcement?')){
    DATA = DATA.filter(a => a.id !== id);
    localStorage.setItem("announcements", JSON.stringify(DATA));
    renderTable(DATA);
  }
}

/* =======================
   PRINT
======================= */
function printPage(){
  window.print();
}

/* =======================
   SEARCH
======================= */
document.getElementById('searchInput').addEventListener('input', function(){
  const val = this.value.toLowerCase();
  renderTable(DATA.filter(a =>
    a.title.toLowerCase().includes(val) ||
    a.created_by.toLowerCase().includes(val)
  ));
});
</script>

</body>
</html>

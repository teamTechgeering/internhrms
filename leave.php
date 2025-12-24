
<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid p-4"></div>

<div class="container-fluid p-4">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-semibold mb-0">Leave</h4>
  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
      <i class="bi bi-upload"></i> Import leaves
    </button>
    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#applyModal">
      <i class="bi bi-plus-circle"></i> Apply leave
    </button>
    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal">
      <i class="bi bi-plus-circle"></i> Assign leave
    </button>
  </div>
</div>

<!-- TABS -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <button class="nav-link active" onclick="switchTab('pending', this)">Pending approval</button>
  </li>
  <li class="nav-item">
    <button class="nav-link" onclick="switchTab('all', this)">All applications</button>
  </li>
  <li class="nav-item">
    <button class="nav-link" onclick="switchTab('summary', this)">Summary</button>
  </li>
</ul>

<!-- ================= PENDING APPROVAL ================= -->
<div id="tab-pending">

<div class="card">
<div class="card-body p-0">

<table class="table align-middle mb-0">
<thead class="table-light">
<tr>
  <th>Applicant</th>
  <th>Leave type</th>
  <th>Date</th>
  <th>Duration</th>
  <th>Status</th>
  <th></th>
</tr>
</thead>
<tbody id="leaveBody">
<tr>
  <td colspan="6" class="text-center text-muted py-4">No record found.</td>
</tr>
</tbody>
</table>

</div>

<div class="d-flex justify-content-between align-items-center p-3">
  <select class="form-select form-select-sm w-auto">
    <option>10</option>
  </select>
  <span class="small text-muted" id="countText">0-0 / 0</span>
  <div>
    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-chevron-left"></i></button>
    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-chevron-right"></i></button>
  </div>
</div>

</div>
</div>

<!-- ================= ALL APPLICATIONS ================= -->
<div id="tab-all" class="d-none">

<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="d-flex align-items-center gap-2">
    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-chevron-left"></i></button>
    <span class="fw-semibold">December 2025</span>
    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-chevron-right"></i></button>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm">Excel</button>
    <button class="btn btn-outline-secondary btn-sm">Print</button>
    <div class="input-group input-group-sm">
      <input class="form-control" placeholder="Search">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
    </div>
  </div>
</div>

<div class="card">
<div class="card-body p-0">
<table class="table align-middle mb-0">
<thead class="table-light">
<tr>
  <th>Applicant</th>
  <th>Leave type</th>
  <th>Date</th>
  <th>Duration</th>
  <th>Status</th>
</tr>
</thead>
<tbody id="allBody">
<tr>
  <td colspan="5" class="text-center text-muted py-4">No record found.</td>
</tr>
</tbody>
</table>
</div>
</div>

</div>

<!-- ================= SUMMARY ================= -->
<div id="tab-summary" class="d-none">

<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="d-flex gap-2">
    <select class="form-select form-select-sm">
      <option>- Leave type -</option>
      <option>Casual Leave</option>
      <option>Sick Leave</option>
    </select>

    <select class="form-select form-select-sm">
      <option>- Team member -</option>
      <option>Mark Thomas</option>
      <option>John Doe</option>
    </select>

    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-chevron-left"></i></button>
      <span class="fw-semibold">2025</span>
      <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-chevron-right"></i></button>
    </div>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm">Excel</button>
    <button class="btn btn-outline-secondary btn-sm">Print</button>
    <div class="input-group input-group-sm">
      <input class="form-control" placeholder="Search">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
    </div>
  </div>
</div>

<div class="card">
<div class="card-body p-0">
<table class="table align-middle mb-0">
<thead class="table-light">
<tr>
  <th>Applicant</th>
  <th>Leave type</th>
  <th>Total Leave (Yearly)</th>
</tr>
</thead>
<tbody id="summaryBody">
<tr>
  <td colspan="3" class="text-center text-muted py-4">No record found.</td>
</tr>
</tbody>
</table>
</div>
</div>

</div>

</div>

<!-- ================= APPLY LEAVE MODAL ================= -->
<div class="modal" id="applyModal">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
  <h6 class="fw-semibold mb-0">Apply leave</h6>
  <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label small">Leave type</label>
<select class="form-select" id="applyType">
<option>-</option>
<option>Casual Leave</option>
<option>Sick Leave</option>
</select>
</div>

<div class="mb-3">
<label class="form-label small d-block">Duration</label>
<div class="d-flex gap-4">
<div class="form-check">
<input class="form-check-input" type="radio" name="applyDuration" checked>
<label class="form-check-label small">Single day</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="applyDuration">
<label class="form-check-label small">Multiple days</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="applyDuration">
<label class="form-check-label small">Hours</label>
</div>
</div>
</div>

<div class="mb-3">
<label class="form-label small">Date</label>
<input class="form-control" id="applyDate" placeholder="Date">
</div>

<div>
<label class="form-label small">Reason</label>
<textarea class="form-control" rows="3" placeholder="Reason"></textarea>
</div>

</div>

<div class="modal-footer justify-content-between">
<div class="d-flex gap-2">
<button class="btn btn-outline-secondary"><i class="bi bi-paperclip"></i> Upload File</button>
<button class="btn btn-outline-secondary"><i class="bi bi-mic"></i></button>
</div>
<div class="d-flex gap-2">
<button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
<button class="btn btn-primary" onclick="addLeave('Pending')">
<i class="bi bi-check-circle"></i> Apply leave
</button>
</div>
</div>

</div>
</div>
</div>

<!-- ================= ASSIGN LEAVE MODAL ================= -->
<div class="modal" id="assignModal">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h6 class="fw-semibold mb-0">Assign leave</h6>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label small">Team member</label>
<select class="form-select" id="assignUser">
<option>-</option>
<option>Mark Thomas</option>
<option>John Doe</option>
</select>
</div>

<div class="mb-3">
<label class="form-label small">Leave type</label>
<select class="form-select" id="assignType">
<option>-</option>
<option>Casual Leave</option>
<option>Sick Leave</option>
</select>
</div>

<div class="mb-3">
<label class="form-label small d-block">Duration</label>
<div class="d-flex gap-4">
<div class="form-check">
<input class="form-check-input" type="radio" name="assignDuration" checked>
<label class="form-check-label small">Single day</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="assignDuration">
<label class="form-check-label small">Multiple days</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="assignDuration">
<label class="form-check-label small">Hours</label>
</div>
</div>
</div>

<div class="mb-3">
<label class="form-label small">Date</label>
<input class="form-control" id="assignDate" placeholder="Date">
</div>

<div>
<label class="form-label small">Reason</label>
<textarea class="form-control" rows="3" placeholder="Reason"></textarea>
</div>

</div>

<div class="modal-footer justify-content-between">
<div class="d-flex gap-2">
<button class="btn btn-outline-secondary"><i class="bi bi-paperclip"></i> Upload File</button>
<button class="btn btn-outline-secondary"><i class="bi bi-mic"></i></button>
</div>
<div class="d-flex gap-2">
<button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
<button class="btn btn-primary" onclick="addLeave('Approved')">
<i class="bi bi-check-circle"></i> Assign leave
</button>
</div>
</div>

</div>
</div>
</div>

<!-- ================= IMPORT MODAL ================= -->
<div class="modal" id="importModal">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h6 class="fw-semibold">Import leaves</h6>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<div id="importBox"
     class="border rounded text-center py-5 text-muted"
     style="cursor:pointer">
  Drag-and-drop documents here<br>(or click to browse...)
  <input type="file" id="importFile" accept=".xlsx,.xls,.csv" hidden>
</div>

</div>

<div class="modal-footer">
<button class="btn btn-outline-secondary btn-sm">
<i class="bi bi-download"></i> Download sample file
</button>
<button class="btn btn-info btn-sm text-white">Next</button>
</div>

</div>
</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
/* ======================================================
   COMPLETE FRONTEND LEAVE SYSTEM (NO BACKEND)
====================================================== */

let leaves = JSON.parse(localStorage.getItem("leaves_data") || "[]");
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

/* ================= UTIL ================= */
function save(){ localStorage.setItem("leaves_data", JSON.stringify(leaves)); }
function formatMonth(y,m){ return new Date(y,m).toLocaleString("default",{month:"long",year:"numeric"}); }

/* ================= ADD / ASSIGN ================= */
function addLeave(status){
  const type = document.getElementById("applyType")?.value || document.getElementById("assignType").value;
  const date = document.getElementById("applyDate")?.value || document.getElementById("assignDate").value;
  const name = status==="Approved" ? document.getElementById("assignUser").value : "Mark Thomas";

  if(type==="-" || !date || !name){
    alert("Fill all fields");
    return;
  }

  leaves.push({
    id: Date.now(),
    name,
    type,
    date,
    status,
    duration:"1.00 Day (8.00 Hours)"
  });

  save();
  renderAll();
  bootstrap.Modal.getInstance(document.querySelector(".modal.show")).hide();
}

/* ================= TAB ================= */
function switchTab(tab,el){
  document.querySelectorAll(".nav-link").forEach(b=>b.classList.remove("active"));
  el.classList.add("active");
  ["pending","all","summary"].forEach(t=>document.getElementById("tab-"+t).classList.add("d-none"));
  document.getElementById("tab-"+tab).classList.remove("d-none");
  renderAll();
}

/* ================= RENDER ================= */
function renderAll(){
  renderPending();
  renderAllTable();
  renderSummary();
}

/* ================= PENDING ================= */
function renderPending(){
  const body = leaveBody;
  body.innerHTML="";
  const list = leaves.filter(l=>l.status==="Pending");

  if(!list.length){
    body.innerHTML=`<tr><td colspan="6" class="text-center text-muted py-4">No record found.</td></tr>`;
    countText.innerText="0-0 / 0";
    return;
  }

  list.forEach(l=>{
    body.innerHTML+=`
    <tr>
      <td>${l.name}</td>
      <td>${l.type}</td>
      <td>${l.date}</td>
      <td>${l.duration}</td>
      <td><span class="badge bg-warning">Pending</span></td>
      <td class="text-end">
        <i class="bi bi-check-circle text-success me-2" onclick="approve(${l.id})"></i>
        <i class="bi bi-x-circle text-danger" onclick="reject(${l.id})"></i>
      </td>
    </tr>`;
  });

  countText.innerText=`1-${list.length} / ${list.length}`;
}

function approve(id){
  leaves.find(l=>l.id===id).status="Approved";
  save(); renderAll();
}
function reject(id){
  leaves = leaves.filter(l=>l.id!==id);
  save(); renderAll();
}

/* ================= ALL ================= */
function renderAllTable(){
  allBody.innerHTML="";
  let list = leaves.filter(l=>{
    const d=new Date(l.date);
    return d.getMonth()===currentMonth && d.getFullYear()===currentYear;
  });

  if(!list.length){
    allBody.innerHTML=`<tr><td colspan="5" class="text-center text-muted py-4">No record found.</td></tr>`;
    return;
  }

  list.forEach(l=>{
    allBody.innerHTML+=`
    <tr>
      <td>${l.name}</td>
      <td>${l.type}</td>
      <td>${l.date}</td>
      <td>${l.duration}</td>
      <td><span class="badge ${l.status==="Approved"?"bg-success":"bg-warning"}">${l.status}</span></td>
    </tr>`;
  });

  document.querySelector("#tab-all .fw-semibold").innerText = formatMonth(currentYear,currentMonth);
}

/* ================= SUMMARY ================= */
function renderSummary(){
  summaryBody.innerHTML="";
  if(!leaves.length){
    summaryBody.innerHTML=`<tr><td colspan="3" class="text-center text-muted py-4">No record found.</td></tr>`;
    return;
  }

  const map={};
  leaves.forEach(l=>{
    const key=l.name+l.type;
    map[key]=(map[key]||{name:l.name,type:l.type,count:0});
    map[key].count++;
  });

  Object.values(map).forEach(r=>{
    summaryBody.innerHTML+=`
    <tr>
      <td>${r.name}</td>
      <td>${r.type}</td>
      <td>${r.count} Days</td>
    </tr>`;
  });
}

/* ================= SEARCH ================= */
document.querySelectorAll("input[placeholder='Search']").forEach(i=>{
  i.addEventListener("keyup",e=>{
    const v=e.target.value.toLowerCase();
    e.target.closest(".card, #tab-summary, #tab-all")
      .querySelectorAll("tbody tr")
      .forEach(r=>r.style.display=r.innerText.toLowerCase().includes(v)?"":"none");
  });
});

/* ================= EXCEL ================= */
document.querySelectorAll("button").forEach(b=>{
  if(b.innerText==="Excel"){
    b.onclick=()=>{
      let csv="Name,Type,Date,Duration,Status\n";
      leaves.forEach(l=>csv+=`${l.name},${l.type},${l.date},${l.duration},${l.status}\n`);
      const a=document.createElement("a");
      a.href=URL.createObjectURL(new Blob([csv]));
      a.download="leaves.csv";
      a.click();
    };
  }
});

/* ================= PRINT ================= */
document.querySelectorAll("button").forEach(b=>{
  if(b.innerText==="Print"){ b.onclick=()=>window.print(); }
});

/* ================= MONTH NAV ================= */
document.querySelectorAll(".bi-chevron-left").forEach(b=>{
  b.onclick=()=>{currentMonth--; if(currentMonth<0){currentMonth=11;currentYear--;} renderAll();}
});
document.querySelectorAll(".bi-chevron-right").forEach(b=>{
  b.onclick=()=>{currentMonth++; if(currentMonth>11){currentMonth=0;currentYear++;} renderAll();}
});

renderAll();

/* ======================================================
   IMPORT EXCEL 
====================================================== */

const importBox = document.getElementById("importBox");
const importFile = document.getElementById("importFile");

/* CLICK TO UPLOAD */
importBox.addEventListener("click", () => importFile.click());

/* FILE PICK */
importFile.addEventListener("change", e => handleFile(e.target.files[0]));

/* DRAG EVENTS */
importBox.addEventListener("dragover", e => {
  e.preventDefault();
  importBox.classList.add("bg-light");
});

importBox.addEventListener("dragleave", () => {
  importBox.classList.remove("bg-light");
});

importBox.addEventListener("drop", e => {
  e.preventDefault();
  importBox.classList.remove("bg-light");
  handleFile(e.dataTransfer.files[0]);
});

/* HANDLE FILE */
function handleFile(file){
  if(!file) return;

  const allowed = ["xlsx","xls","csv"];
  const ext = file.name.split(".").pop().toLowerCase();

  if(!allowed.includes(ext)){
    alert("Only Excel files allowed (.xlsx, .xls, .csv)");
    return;
  }

  const reader = new FileReader();

  reader.onload = e => {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, { type: "array" });
    const sheet = workbook.Sheets[workbook.SheetNames[0]];
    const rows = XLSX.utils.sheet_to_json(sheet);

    if(!rows.length){
      alert("Empty Excel file");
      return;
    }

    rows.forEach(r=>{
      if(!r.Name || !r.Date || !r.Type) return;

      leaves.push({
        id: Date.now()+Math.random(),
        name: r.Name,
        type: r.Type,
        date: r.Date,
        duration: r.Duration || "1.00 Day (8.00 Hours)",
        status: r.Status || "Pending"
      });
    });

    localStorage.setItem("leaves_data", JSON.stringify(leaves));
    renderAll();

    alert("Leaves imported successfully");
    bootstrap.Modal.getInstance(document.getElementById("importModal")).hide();
  };

  reader.readAsArrayBuffer(file);
}
</script>

</body>
</html>

document.addEventListener("DOMContentLoaded", function () {

/* =======================================================
      🔵 GET PROJECT ID FROM URL
======================================================= */
const urlParams = new URLSearchParams(window.location.search);
const projectId = parseInt(urlParams.get('id'), 10);

/* =======================================================
      🔵 LOAD PROJECT DATA
======================================================= */
async function loadProject() {
  try {
    const res = await fetch('projects_json.php?id=' + projectId, { cache: 'no-store' });
    const data = await res.json();
    const project = data.find(p => p.id === projectId) || data || null;

    if (!project) {
      document.body.innerHTML = '<div class="text-center mt-5 text-danger">Project not found</div>';
      return;
    }

    document.getElementById('projectTitle').textContent = project.title;
    document.getElementById('startDate').textContent = project.start_date;
    document.getElementById('deadline').textContent = project.deadline;
    document.getElementById('client').textContent = project.client || '-';

    /* PROGRESS CHART */
    new Chart(document.getElementById('progressChart'), {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [project.progress, 100 - project.progress],
          backgroundColor: ['#4c6ef5', '#e9ecef'],
          borderWidth: 0
        }]
      },
      options: { cutout: '75%', plugins: { legend: { display: false } } }
    });

    /* DONUT CHART */
    new Chart(document.getElementById('donutChart'), {
      type: 'doughnut',
      data: {
        labels: ['To do', 'In progress', 'Review', 'Done'],
        datasets: [{
          data: [20, 30, 10, 40],
          backgroundColor: ['#ff9800', '#4c6ef5', '#9c27b0', '#009688']
        }]
      },
      options: { cutout: '65%', plugins: { legend: { display: true, position: 'bottom' } } }
    });

    /* ACTIVITY LIST */
    const activity = [
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3467 - Create explainer video animations' },
      { name: 'John Doe', task: '#3468 - Add voice-over and background music' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3469 - Incorporate video special effects' }
    ];

    const activityList = document.getElementById('activityList');
    activityList.innerHTML = activity.map(a => `
      <div class="d-flex align-items-start border-bottom py-2">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="36" height="36" class="rounded-circle me-2">
        <div>
          <div class="fw-semibold">${a.name} <span class="text-muted small">Today 08:09am</span></div>
          <span class="badge bg-light text-primary border me-1">Added</span>
          ${a.task}
        </div>
      </div>
    `).join('');
  } catch (err) {
    console.error("Project load error:", err);
  }
}
loadProject();

/* =======================================================
      🔵 LOAD TASK LIST
======================================================= */
async function loadTaskList() {
  try {
    const res = await fetch("tasklist.php", { cache: "no-store" });
    const data = await res.json();
    const tasks = Array.isArray(data) ? data : (data.tasks || []);

    const tbody = document.querySelector("#taskTable tbody");

    tbody.innerHTML = tasks.map(t => `
      <tr>
        <td>${t.id}</td>
        <td>
          <span
            class="task-title text-dark text-decoration-none"
            role="button"
            data-id="${t.id}"
            data-title="${escapeAttr(t.title)}"
            data-desc="${escapeAttr(t.description || '')}"
            data-user="${escapeAttr(t.assigned_to || '')}"
            data-deadline="${escapeAttr(t.deadline || '')}"
            data-status="${escapeAttr(t.status || '')}"
            data-milestone="${escapeAttr(t.milestone || '')}"
            data-collab="${escapeAttr(t.collaborators || '')}"
          >${escapeHtml(t.title)}</span>
        </td>
        <td>${t.start_date || "-"}</td>
        <td class="${t.deadline_color || ""}">${t.deadline || "-"}</td>
        <td>${t.milestone || "-"}</td>
        <td>${t.assigned_to || "-"}</td>
        <td>${t.collaborators || "-"}</td>
        <td>${t.status || "-"}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary btn-edit" data-id="${t.id}">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-outline-secondary btn-delete" data-id="${t.id}">
            <i class="bi bi-x-circle"></i>
          </button>
        </td>
      </tr>
    `).join("");

    attachModalEvents();
    attachRowButtons();

  } catch (err) {
    console.error("Tasklist load error:", err);
  }
}
loadTaskList();

/* =======================================================
      UTIL FUNCTIONS
======================================================= */
function escapeAttr(s) {
  if (!s) return "";
  return String(s)
    .replace(/&/g, "&amp;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}
function escapeHtml(s) {
  if (!s) return "";
  return String(s)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}

/* =======================================================
      TASK DETAILS MODAL
======================================================= */
function attachModalEvents() {
  const tbody = document.querySelector("#taskTable tbody");
  if (!tbody) return;

  tbody.querySelectorAll(".task-title").forEach(title => {
    title.onclick = null;
    title.addEventListener("click", function () {
      const ds = this.dataset;

      document.querySelector("#modalTaskTitle").innerText = ds.title;
      document.querySelector("#modalTaskDesc").innerText = ds.desc;
      document.querySelector("#modalUserName").innerText = ds.user;
      document.querySelector("#modalProjectName").innerText = ds.milestone;

      const statusBadge = document.querySelector("#modalStatusBadge");
      statusBadge.innerText = ds.status;
      statusBadge.className = "badge bg-secondary";

      new bootstrap.Modal(document.querySelector("#taskModal")).show();
    });
  });
}

/* =======================================================
      EDIT & DELETE BUTTONS
======================================================= */
function attachRowButtons() {
  document.querySelectorAll("#taskTable .btn-delete").forEach(btn => {
    btn.onclick = null;
    btn.addEventListener("click", function () {
      if (!confirm("Delete this task?")) return;
      this.closest("tr")?.remove();
    });
  });

  document.querySelectorAll("#taskTable .btn-edit").forEach(btn => {
    btn.onclick = null;
    btn.addEventListener("click", function () {
      const id = this.dataset.id;
      alert("Edit task " + id);
    });
  });
}

/* =======================================================
      TABS COLOR SWITCH
======================================================= */
document.querySelectorAll('.nav-link').forEach(tab => {
  tab.addEventListener('shown.bs.tab', () => {
    document.querySelectorAll('.nav-link').forEach(t =>
      t.classList.replace('text-dark', 'text-secondary')
    );
    tab.classList.replace('text-secondary', 'text-dark');
  });
});

/* =======================================================
      REMINDERS
======================================================= */
const reminders = [];
const reminderList = document.getElementById('reminderList');

document.getElementById('addReminder').addEventListener('click', () => {
  const title = document.getElementById('reminderTitle').value.trim();
  const date = document.getElementById('reminderDate').value;
  const time = document.getElementById('reminderTime').value;
  const repeat = document.getElementById('repeatReminder').checked;

  if (!title) return alert('Enter title');

  reminders.push({ title, date, time, repeat });
  renderReminders();
  document.getElementById('reminderTitle').value = '';
});

function renderReminders() {
  if (!reminders.length) {
    reminderList.innerHTML = '<li class="list-group-item text-center text-muted">No record found.</li>';
    return;
  }
  reminderList.innerHTML = reminders.map((r, i) => `
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <div class="fw-semibold">${r.title}</div>
        <small class="text-muted">${r.date} ${r.time} ${r.repeat ? '(Repeat)' : ''}</small>
      </div>
      <button class="btn btn-sm btn-outline-danger" onclick="deleteReminder(${i})">
        <i class="bi bi-trash"></i>
      </button>
    </li>
  `).join('');
}

function deleteReminder(i) {
  reminders.splice(i, 1);
  renderReminders();
}

/* =======================================================
      SETTINGS
======================================================= */
const saveBtn = document.getElementById('saveSettings');
const clientTimesheet = document.getElementById('clientTimesheet');
const enableSlack = document.getElementById('enableSlack');
const removeStatus = document.getElementById('removeStatus');

window.addEventListener('load', () => {
  const settings = JSON.parse(localStorage.getItem('settings') || '{}');
  clientTimesheet.checked = settings.clientTimesheet || false;
  enableSlack.checked = settings.enableSlack || false;
  removeStatus.value = settings.removeStatus || '';
});

saveBtn.addEventListener('click', () => {
  const settings = {
    clientTimesheet: clientTimesheet.checked,
    enableSlack: enableSlack.checked,
    removeStatus: removeStatus.value
  };
  localStorage.setItem('settings', JSON.stringify(settings));
  alert('Settings saved!');
});

/* =======================================================
      TASK ACTIONS
======================================================= */
function addTask() { alert("Open Add Task Modal Here"); }
function addMultipleTasks() { alert("Open Add Multiple Tasks Modal"); }

function openLabelManager() {
  let modal = new bootstrap.Modal(document.getElementById("manageLabelsModal"));
  modal.show();
}

/* EDIT TASK POPUP */
function editTask(button) {
  const row = button.closest("tr");
  const cells = row.getElementsByTagName("td");

  document.getElementById("edit-task-id").value = cells[0].innerText;
  document.getElementById("edit-task-title").value = cells[1].innerText.trim();
  document.getElementById("edit-task-start").value = cells[2].innerText === "-" ? "" : cells[2].innerText;
  document.getElementById("edit-task-deadline").value = cells[3].innerText.replaceAll("-", "");
  document.getElementById("edit-task-milestone").value = cells[4].innerText;
  document.getElementById("edit-task-assigned").value = cells[5].innerText.trim();
  document.getElementById("edit-task-status").value = cells[7].innerText;

  new bootstrap.Modal(document.getElementById("editTaskModal")).show();
}

document.getElementById("saveEditedTask").addEventListener("click", function () {
  const id = document.getElementById("edit-task-id").value;
  const rows = document.querySelectorAll("#taskTable tbody tr");

  rows.forEach(row => {
    if (row.children[0].innerText == id) {
      row.children[1].innerText = document.getElementById("edit-task-title").value;
      row.children[2].innerText = document.getElementById("edit-task-start").value || "-";
      row.children[3].innerText = document.getElementById("edit-task-deadline").value;
      row.children[4].innerText = document.getElementById("edit-task-milestone").value;
      row.children[5].innerText = document.getElementById("edit-task-assigned").value;
      row.children[7].innerText = document.getElementById("edit-task-status").value;
    }
  });

  bootstrap.Modal.getInstance(document.getElementById("editTaskModal")).hide();
});

/* =======================================================
      FILTER & SEARCH
======================================================= */
document.querySelectorAll(".filter-option").forEach(item => {
  item.addEventListener("click", function () {
    let filter = this.dataset.filter;

    document.querySelectorAll("#taskBody tr").forEach(row => {
      if (filter === "all") row.style.display = "";
      else if (row.dataset.type === filter || row.dataset.status === filter)
        row.style.display = "";
      else
        row.style.display = "none";
    });
  });
});

function searchTask() {
  let input = document.getElementById("taskSearch").value.toLowerCase();

  document.querySelectorAll("#taskBody tr").forEach(row => {
    let text = row.innerText.toLowerCase();
    row.style.display = text.includes(input) ? "" : "none";
  });
}

/* =======================================================
      PRINT & EXPORT
======================================================= */
function printTable() {
  let table = document.getElementById("taskTable").outerHTML;
  let win = window.open("");
  win.document.write(table);
  win.print();
}

function exportExcel() {
  let table = document.getElementById("taskTable").outerHTML;
  let blob = new Blob([table], { type: "application/vnd.ms-excel" });
  let link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = "tasks.xls";
  link.click();
}

/* =======================================================
      SEARCH FOR OTHER TABLES
======================================================= */
function setupSearch(inputId, tableId) {
  document.getElementById(inputId).addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll(`#${tableId} tbody tr`);

    rows.forEach(row => {
      let text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? "" : "none";
    });
  });
}
setupSearch("expenseSearch", "expensesTable");
setupSearch("contractSearch", "contractsTable");

/* =======================================================
      EXPORT CSV
======================================================= */
function exportTableToCSV(tableId, filename) {
  let table = document.getElementById(tableId);
  let rows = table.querySelectorAll("tr");
  let csv = [];

  rows.forEach(row => {
    let cols = row.querySelectorAll("th, td");
    let rowData = [];
    cols.forEach(col => rowData.push(col.innerText.replace(/,/g, "")));
    csv.push(rowData.join(","));
  });

  let blob = new Blob([csv.join("\n")], { type: "text/csv" });
  let link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = filename;
  link.click();
}

document.getElementById("btnExportExpenses").onclick = () => exportTableToCSV("expensesTable", "expenses.csv");
document.getElementById("btnExportContracts").onclick = () => exportTableToCSV("contractsTable", "contracts.csv");

/* =======================================================
      ADD BUTTONS
======================================================= */
document.getElementById("btnAddExpense").onclick = () => alert("Open 'Add Expense' modal");
document.getElementById("btnAddContract").onclick = () => alert("Open 'Add Contract' modal");

/* =======================================================
      ADD MILESTONE
======================================================= */
document.getElementById("saveMilestone").addEventListener("click", function () {
  const title = document.getElementById("milestoneTitle").value.trim();
  const desc = document.getElementById("milestoneDesc").value.trim();
  const date = document.getElementById("milestoneDate").value;

  if (!title || !date) {
    alert("Title and Due Date are required");
    return;
  }

  const d = new Date(date);
  const month = d.toLocaleString('en-US', { month: 'long' });
  const day = d.getDate();
  const weekday = d.toLocaleString('en-US', { weekday: 'long' });

  const newMilestone = `
        <div class="milestone-item row py-3 border-bottom align-items-center">
            <div class="col-3">
                <div class="text-center border rounded p-2">
                    <span class="badge bg-danger mb-1">${month}</span>
                    <div class="h3 m-0 fw-bold">${day}</div>
                    <div class="small text-muted">${weekday}</div>
                </div>
            </div>

            <div class="col-5">
                <div class="fw-semibold">${title}</div>
                <div class="text-muted small">${desc}</div>
            </div>

            <div class="col-3 text-center">
                <div class="small mb-1">0/0</div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: 0%;"></div>
                </div>
                <div class="small mt-1">0%</div>
            </div>

            <div class="col-1 text-end">
                <button class="btn btn-light btn-sm border"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-light btn-sm border"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    `;

  document.getElementById("milestoneList").insertAdjacentHTML("beforeend", newMilestone);

  bootstrap.Modal.getInstance(document.getElementById("addMilestoneModal")).hide();

  document.getElementById("milestoneTitle").value = "";
  document.getElementById("milestoneDesc").value = "";
  document.getElementById("milestoneDate").value = "";
});

/* =======================================================
      GANTT SETTINGS
======================================================= */
const DAYWIDTH = 40;
const START = new Date("2025-11-20");
const END = new Date("2025-12-14");

/* =======================================================
      GANTT DAYS AUTO GENERATE
======================================================= */
function renderDays() {
  const days = document.getElementById("gantt-days");

  let cur = new Date(START);
  while (cur <= END) {
    const d = document.createElement("div");
    d.style.width = DAYWIDTH + "px";
    d.className = "px-2 text-center";
    d.innerText = String(cur.getDate()).padStart(2, "0");
    days.appendChild(d);
    cur.setDate(cur.getDate() + 1);
  }
}
renderDays();

/* =======================================================
      GANTT DATA
======================================================= */
const ganttData = [
  {
    title: "Beta Release",
    tasks: [
      { title: "Define plugin functionality and scope", start: "2025-11-20", end: "2025-11-25", color: "warning" },
      { title: "Add plugin shortcode and widgets", start: "2025-11-21", end: "2025-11-29", color: "warning" },
      { title: "Ensure plugin security and updates", start: "2025-11-22", end: "2025-11-30", color: "warning" },
      { title: "Submit plugin to WordPress repository", start: "2025-11-23", end: "2025-12-01", color: "primary" },
      { title: "Provide plugin customer support", start: "2025-11-24", end: "2025-12-03", color: "warning" }
    ]
  },
  {
    title: "Release",
    tasks: [
      { title: "Create plugin wireframes and UI", start: "2025-11-25", end: "2025-12-01", color: "warning" },
      { title: "Develop plugin core features", start: "2025-11-26", end: "2025-12-05", color: "info" },
      { title: "Create plugin custom post types", start: "2025-11-27", end: "2025-12-06", color: "info" },
      { title: "Integrate plugin with database", start: "2025-11-28", end: "2025-12-08", color: "info" },
      { title: "Develop plugin documentation", start: "2025-11-29", end: "2025-12-10", color: "secondary" }
    ]
  }
];

/* =======================================================
      GANTT TASK BAR RENDER
======================================================= */
function renderGantt() {
  const box = document.getElementById("gantt-task-container");
  box.innerHTML = "";

  ganttData.forEach(group => {
    let groupTitle = document.createElement("div");
    groupTitle.className = "fw-semibold text-secondary mb-2";
    groupTitle.innerText = group.title;
    box.appendChild(groupTitle);

    group.tasks.forEach(t => {
      let offset = 0;
      let length = 3;

      let row = document.createElement("div");
      row.className = "d-flex align-items-center mb-3";

      row.innerHTML = `
                <div class="position-relative me-3" style="width:150px;">
                    <div class="bg-${t.color} rounded"
                         style="height:10px;
                                position:absolute;
                                left:${offset * DAYWIDTH}px;
                                width:${length * DAYWIDTH}px;">
                    </div>
                </div>

                <div class="small text-nowrap">${t.title}</div>
            `;

      box.appendChild(row);
    });

    box.appendChild(document.createElement("br"));
  });
}
renderGantt();

/* =======================================================
      GANTT MODAL SAVE
======================================================= */
document.getElementById('saveTaskBtn').addEventListener('click', () => {
  const title = document.getElementById('taskTitle').value;
  const badge = document.getElementById('taskBadge').value;
  const deadline = document.getElementById('taskDeadline').value;

  if (!title) {
    alert('Please enter a task title.');
    return;
  }

  console.log({ title, badge, deadline });
  document.getElementById('addTaskForm').reset();
  const addTaskModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
  addTaskModal.hide();
});

/* =======================================================
      NOTES SECTION
======================================================= */
document.getElementById("uploadBtn").onclick = () => {
  document.getElementById("noteFile").click();
};

document.getElementById("noteFile").onchange = function () {
  let file = this.files[0];
  if (file) {
    document.getElementById("fileName").textContent = file.name;
  }
};

let colorButtons = document.querySelectorAll(".color-btn");
let selectedColor = document.getElementById("selectedColor");

colorButtons.forEach(btn => {
  btn.addEventListener("click", function () {
    selectedColor.textContent = this.dataset.color;
    selectedColor.className = "badge bg-" + this.classList[1].replace("btn-", "");
  });
});

document.getElementById("saveNoteBtn").onclick = () => {
  let note = {
    title: document.getElementById("noteTitle").value,
    desc: document.getElementById("noteDesc").value,
    category: document.getElementById("noteCategory").value,
    labels: document.getElementById("noteLabels").value,
    public: document.getElementById("notePublic").checked,
    color: selectedColor.textContent,
    file: document.getElementById("noteFile").files[0]?.name || null
  };
  console.log("NOTE SAVED:", note);
  alert("Note saved!");
  bootstrap.Modal.getInstance(document.getElementById("addNoteModal")).hide();
};

/* =======================================================
      FILES
======================================================= */
document.getElementById("saveFilesBtn").onclick = () => {
  let tbody = document.querySelector("#filesListTab tbody");
  tbody.innerHTML = "";

  uploadedFiles.forEach((f, i) => {
    tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${f.name}</td>
            <td>${document.getElementById("fileCategory").value}</td>
            <td>${f.size}</td>
            <td>You</td>
            <td>${f.date}</td>
            <td></td>
          </tr>
        `;
  });

  bootstrap.Modal.getInstance(document.getElementById("addFilesModal")).hide();
};

/* =======================================================
      PRINT TABLE
======================================================= */
document.getElementById("printTable").onclick = () => {
  window.print();
};

/* =======================================================
      EXPORT TO EXCEL
======================================================= */
document.getElementById("exportExcel").onclick = () => {
  let table = document.querySelector("#filesListTab table").outerHTML;
  let data = new Blob([table], { type: "application/vnd.ms-excel" });
  let url = URL.createObjectURL(data);

  let a = document.createElement("a");
  a.href = url;
  a.download = "files.xls";
  a.click();
};

/* =======================================================
      COMMENTS FILE UPLOAD
======================================================= */
const commentUploadBtn = document.getElementById('commentUploadBtn');
const commentFileInput = document.getElementById('commentFile');
const commentFileName = document.getElementById('commentFileName');

commentUploadBtn.addEventListener('click', () => {
    commentFileInput.click();
});

commentFileInput.addEventListener('change', () => {
    if (commentFileInput.files.length > 0) {
        commentFileName.textContent = "Selected file: " + commentFileInput.files[0].name;
    }
});



});  // END SINGLE DOMContentLoaded
/* --------------------------------------
   🔹 GET PROJECT ID FROM URL
-------------------------------------- */
const urlParams = new URLSearchParams(window.location.search);
const projectId = parseInt(urlParams.get('id'), 10);

/* --------------------------------------
   🔹 LOAD PROJECT DATA
-------------------------------------- */
async function loadProject() {
  try {
    const res = await fetch('projects.json', { cache: 'no-store' });
    const data = await res.json();
    const projects = Array.isArray(data) ? data : data.projects;
    const project = projects.find(p => p.id === projectId);

    if (!project) {
      document.body.innerHTML = '<div class="text-center mt-5 text-danger">Project not found</div>';
      return;
    }

    document.getElementById('projectTitle').textContent = project.title;
    document.getElementById('startDate').textContent = project.start_date;
    document.getElementById('deadline').textContent = project.deadline;
    document.getElementById('client').textContent = project.client || '-';

    /* ------ Progress Chart ------ */
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

    /* ------ Donut Chart ------ */
    new Chart(document.getElementById('donutChart'), {
      type: 'doughnut',
      data: {
        labels: ['To do', 'In progress', 'Review', 'Done'],
        datasets: [{
          data: [20, 30, 10, 40],
          backgroundColor: ['#ff9800', '#4c6ef5', '#9c27b0', '#009688']
        }]
      },
      options: {
        cutout: '65%',
        plugins: { legend: { display: true, position: 'bottom' } }
      }
    });

    /* --------------------------------------
       🔹 ACTIVITY LIST
    -------------------------------------- */
    const activity = [
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3467 - Create explainer video animations' },
      { name: 'John Doe', task: '#3468 - Add voice-over and background music' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3473 - Collaborate with clients on video concept' },
      { name: 'John Doe', task: '#3469 - Incorporate video special effects' }
    ];

    const activityList = document.getElementById('activityList');
    activityList.innerHTML = activity
      .map(a => `
        <div class="d-flex align-items-start border-bottom py-2">
          <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="36" height="36" class="rounded-circle me-2">
          <div>
            <div class="fw-semibold">${a.name} <span class="text-muted small">Today 08:09am</span></div>
            <span class="badge bg-light text-primary border me-1">Added</span>
            ${a.task}
          </div>
        </div>`
      ).join('');

  } catch (err) {
    console.error(err);
  }
}

loadProject();  

/* --------------------------------------
   🔹 LOAD TASKLIST FROM tasklist.php
-------------------------------------- */
async function loadTaskList() {
  try {
    const res = await fetch("tasklist.php", { cache: "no-store" }); // ✅ UPDATED
    const data = await res.json();
    const tasks = Array.isArray(data) ? data : (data.tasks || []);
    const tbody = document.querySelector("#taskTable tbody");

    tbody.innerHTML = tasks.map(t => {
      return `
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
      `;
    }).join("");

    attachModalEvents();
    attachRowButtons();
  } catch (err) {
    console.error("Tasklist load error:", err);
  }
}

/* --------------------------------------
   🔹 UTILS
-------------------------------------- */
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

/* --------------------------------------
   🔹 ATTACH MODAL TO TITLES
-------------------------------------- */
function attachModalEvents() {
  const tbody = document.querySelector("#taskTable tbody");
  if (!tbody) return;

  tbody.querySelectorAll(".task-title").forEach(title => {
    title.onclick = null;
    title.addEventListener("click", function (e) {
      if (e && e.preventDefault) e.preventDefault();

      const ds = this.dataset;

      document.querySelector("#modalTaskTitle").innerText = ds.title || "";
      document.querySelector("#modalTaskDesc").innerText = ds.desc || "";
      document.querySelector("#modalUserName").innerText = ds.user || "";

      const projectNameEl = document.querySelector("#modalProjectName");
      if (projectNameEl) projectNameEl.innerText = ds.milestone || "";

      const statusBadge = document.querySelector("#modalStatusBadge");
      if (statusBadge) {
        statusBadge.innerText = ds.status || "";
        statusBadge.className = "badge " + (ds.status ? "bg-secondary" : "");
      }

      new bootstrap.Modal(document.querySelector("#taskModal")).show();
    });
  });
}

/* --------------------------------------
   🔹 EDIT / DELETE ROW BUTTONS
-------------------------------------- */
function attachRowButtons() {
  document.querySelectorAll("#taskTable .btn-delete").forEach(btn => {
    btn.onclick = null;
    btn.addEventListener("click", function () {
      if (!confirm("Delete this task?")) return;
      const tr = this.closest("tr");
      if (tr) tr.remove();
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

/* --------------------------------------
   🔹 INITIAL CALL
-------------------------------------- */
loadTaskList();

/* --------------------------------------
   🔹 TAB ACTIVE COLOR SWITCH
-------------------------------------- */
const allTabs = document.querySelectorAll('.nav-link');
allTabs.forEach(tab => {
  tab.addEventListener('shown.bs.tab', () => {
    allTabs.forEach(t => t.classList.replace('text-dark', 'text-secondary'));
    tab.classList.replace('text-secondary', 'text-dark');
  });
});

/* --------------------------------------
   🔹 REMINDERS
-------------------------------------- */
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
    </li>`
  ).join('');
}

function deleteReminder(i) {
  reminders.splice(i, 1);
  renderReminders();
}

/* --------------------------------------
   🔹 SETTINGS
-------------------------------------- */
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

/* --------------------------------------
   🔹 TASKLIST — ALL FUNCTIONS FIXED
-------------------------------------- */
function addTask() {
  alert("Open Add Task Modal Here");
}

function addMultipleTasks() {
  alert("Open Add Multiple Tasks Modal");
}

function openLabelManager() {
  alert("Open Label Manager Popup");
}

function deleteTask(btn) {
  if (confirm("Are you sure you want to delete this task?")) {
    btn.closest("tr").remove();
  }
}

function editTask(btn) {
  alert("Open Edit Task Modal for: " + btn.closest("tr").children[1].innerText);
}

function openLabelManager() {
  let modal = new bootstrap.Modal(document.getElementById("manageLabelsModal"));
  modal.show();
}

function editTask(button) {
  const row = button.closest("tr");
  const cells = row.getElementsByTagName("td");

  document.getElementById("edit-task-id").value = cells[0].innerText;
  document.getElementById("edit-task-title").value = cells[1].innerText.trim();
  document.getElementById("edit-task-start").value = cells[2].innerText === "-" ? "" : cells[2].innerText;
  document.getElementById("edit-task-deadline").value = cells[3].innerText.replaceAll("-", "");
  document.getElementById("edit-task-milestone").value = cells[4].innerText;
  document.getElementById("edit-task-assigned").value = cells[5].innerText.replace(/^\s*|\s*$/g, "");
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

/* 🔍 FILTER */
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

/* 🔍 SEARCH */
function searchTask() {
  let input = document.getElementById("taskSearch").value.toLowerCase();

  document.querySelectorAll("#taskBody tr").forEach(row => {
    let text = row.innerText.toLowerCase();
    row.style.display = text.includes(input) ? "" : "none";
  });
}

/* 🖨 PRINT */
function printTable() {
  let table = document.getElementById("taskTable").outerHTML;
  let win = window.open("");
  win.document.write(table);
  win.print();
}

/* 📥 EXPORT EXCEL */
function exportExcel() {
  let table = document.getElementById("taskTable").outerHTML;
  let blob = new Blob([table], { type: "application/vnd.ms-excel" });
  let link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = "tasks.xls";
  link.click();
}

/* ======================================
   📊 1. INCOME VS EXPENSE DONUT CHART
====================================== */
new Chart(document.getElementById("donutChart"), {
  type: "doughnut",
  data: {
    labels: ["Income", "Expenses"],
    datasets: [{
      data: [17830, 9120],
      backgroundColor: ["#1e9c75", "#e91e63"],
      borderWidth: 0
    }]
  },
  options: {
    cutout: "70%",
    plugins: { legend: false }
  }
});
/* ======================================
   📈 2. INVOICE LINE CHART
====================================== */
new Chart(document.getElementById("invoiceLine"), {
  type: "line",
  data: {
    labels: ["", "", "", "", "", "", ""],
    datasets: [{
      data: [0, 5, 15, 45, 90, 35, 0],
      borderColor: "#4285f4",
      borderWidth: 2,
      fill: false,
      tension: 0.4
    }]
  },
  options: {
    plugins: { legend: false },
    scales: { x: { display: false }, y: { display: false } }
  }
});
/* ======================================
   💰 3. INCOME VS EXPENSE TREND LINES
====================================== */
new Chart(document.getElementById("incomeLine"), {
  type: "line",
  data: {
    labels: ["", "", "", "", ""],
    datasets: [
      {
        label: "Income",
        data: [0, 10, 50, 90, 0],
        borderColor: "#1e9c75",
        borderWidth: 2,
        fill: false,
        tension: 0.4
      },
      {
        label: "Expense",
        data: [0, 5, 25, 60, 0],
        borderColor: "#e91e63",
        borderWidth: 2,
        fill: false,
        tension: 0.4
      }
    ]
  },
  options: {
    plugins: { legend: false },
    scales: { x: { display: false }, y: { display: false } }
  }
});
/* ======================================
   📋 4. TASKS OVERVIEW DONUT CHART
====================================== */
new Chart(document.getElementById("tasksDonut"), {
  type: "doughnut",
  data: {
    labels: ["To do", "In progress", "Review", "Done", "Expired"],
    datasets: [{
      data: [73, 61, 69, 173, 133],
      backgroundColor: ["#f4b400", "#0057e7", "#9c27b0", "#009688", "#e91e63"],
      borderWidth: 0
    }]
  },
  options: {
    cutout: "70%",
    plugins: { legend: false }
  }
});
/* ======================================
   🎫 5. TICKET STATUS BAR CHART
====================================== */
new Chart(document.getElementById("ticketChart"), {
  type: "bar",
  data: {
    labels: ["06","08","10","12","14","16","18","20","22","24","26","28","30","01","03"],
    datasets: [{
      data: [5,10,25,32,15,40,22,35,28,20,15,32,41,30,43],
      backgroundColor: "#28a745",
      borderWidth: 0,
      barThickness: 4,
      maxBarThickness: 6
    }]
  },
  plugins: [ChartDataLabels],
  options: {
    plugins: {
      legend: { display: false },
      datalabels: {
        anchor: "end",
        align: "end",
        offset: -2,
        color: "#777",
        font: { size: 9, weight: "600" },
        formatter: (value) => value
      }
    },
    scales: {
      x: { display: true, ticks: { color: "#999" } },
      y: { display: false }
    }
  }
});
/* ======================================
   🧾 6. PROJECT TIMELINE
====================================== */
async function loadTimeline() {
  const res = await fetch("project_timeline.json");
  const data = await res.json();
  const container = document.getElementById("timelineContainer");

  container.innerHTML = data.tasks.map(task => `
    <div class="timeline-item p-3 border-bottom">
      <div class="d-flex align-items-start">
        <img src="${task.avatar}" class="rounded-circle me-3" width="40" height="40">
        <div>
          <div class="d-flex align-items-center mb-1">
            <strong class="me-2">${task.user}</strong>
            <small class="text-muted">${task.time}</small>
          </div>
          <p class="mb-1 task-link" data-bs-toggle="modal" data-bs-target="#taskModal"
             onclick='openTask(${JSON.stringify(task)})'>
            <span class="badge bg-warning text-dark me-2">${task.status}</span>
            Task: <span class="fw-semibold text-dark">#${task.taskId}</span> - ${task.title}
          </p>
          <p class="small mb-0 project-link" data-bs-toggle="modal" data-bs-target="#taskModal">
            Project: <span class="text-primary">${task.project}</span>
          </p>
        </div>
      </div>
    </div>
  `).join("");
}
function openTask(task) {
  document.getElementById("modalTaskTitle").innerText = `Task info #${task.taskId}`;
  document.getElementById("modalTaskDesc").innerText = task.description;
  document.getElementById("modalProjectName").innerText = task.project;
  document.getElementById("modalUserImg").src = task.avatar;
  document.getElementById("modalUserName").innerText = task.user;
  document.getElementById("modalStatusBadge").innerText = task.statusText;
  document.getElementById("modalStatusBadge").className = "badge bg-success";
}
loadTimeline();
/* ======================================
   ⏱️ 7. TASK TIMER & COMMENTS
====================================== */
let recording = false;
let timer = null, startTime = null;

function toggleMic() {
  const btn = document.getElementById('micBtn');
  recording = !recording;
  btn.textContent = recording ? '🔴 Recording...' : '🎤';
  btn.classList.toggle('btn-danger', recording);
}
function addComment() {
  const text = document.getElementById('commentText').value.trim();
  if (text === "") return;
  const html = `
    <div class="comment-item">
      <strong>You</strong> <small class="text-muted">Just now</small>
      <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="30" class="rounded-circle comment-avatar-right">
      <p>${text}</p>
      <div class="d-flex justify-content-between align-items-center">
        <a href="#" class="small text-decoration-none text-primary">Like</a>
        <div class="dropdown">
          <a href="#" class="text-muted small" data-bs-toggle="dropdown">⋮</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Copy link</a></li>
            <li><a class="dropdown-item" href="#">Pin comment</a></li>
            <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
          </ul>
        </div>
      </div>
    </div>`;
  document.getElementById('commentsList').insertAdjacentHTML('afterbegin', html);
  document.getElementById('commentText').value = "";
}
function toggleTimer() {
  const btn = document.getElementById('timerBtn');
  const msgBox = document.getElementById('timerMessageBox');
  const display = document.getElementById('timerDisplay');

  if (btn.textContent.includes('Start')) {
    btn.textContent = 'Stop timer';
    btn.classList.replace('btn-timer', 'btn-stop');
    startTime = new Date();

    timer = setInterval(() => {
      const elapsed = Math.floor((new Date() - startTime) / 1000);
      const hrs = String(Math.floor(elapsed / 3600)).padStart(2, '0');
      const mins = String(Math.floor((elapsed % 3600) / 60)).padStart(2, '0');
      const secs = String(elapsed % 60).padStart(2, '0');
      display.textContent = `${hrs}:${mins}:${secs}`;
    }, 1000);

    msgBox.classList.remove('d-none');
  } else {
    stopTimer();
  }
}
function stopTimer() {
  clearInterval(timer);
  document.getElementById('timerDisplay').textContent = "";
  document.getElementById('timerMessageBox').classList.add('d-none');

  const btn = document.getElementById('timerBtn');
  btn.textContent = 'Start timer';
  btn.classList.replace('btn-stop', 'btn-timer');
}
function showReminderForm(e) {
  e.preventDefault();
  document.getElementById('reminderForm').style.display = 'block';
}
/* ======================================
   📅 EVENT BOX & OPEN PROJECT BOX
====================================== */
async function loadEventAndProjects() {
  const res = await fetch("project_timeline.json");
  const data = await res.json();

  const eventContainer = document.getElementById("eventContainer");
  const projectContainer = document.getElementById("openProjectContainer");
  // 🎯 EVENT BOX
  eventContainer.innerHTML = data.events.map(event => `
    <div class="event-item border-bottom py-2 px-1">
      <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center">
          <div class="icon bg-light p-2 rounded-circle me-2">
            <i class="${event.icon} text-primary"></i>
          </div>
          <div>
            <strong class="d-block">${event.title}</strong>
            <small class="text-muted">${event.date}</small>
          </div>
        </div>
      </div>
    </div>
  `).join("");
  // 🗂️ OPEN PROJECT BOX
  projectContainer.innerHTML = data.projects.map(proj => `
    <div class="project-card">
      <div class="project-info">
        <strong>${proj.name}</strong>
        <small>${proj.category}</small>
        <div class="progress">
          <div class="progress-bar" style="width:${proj.progress}%"></div>
        </div>
        <small><strong>${proj.progress}%</strong> completed • ${proj.deadline}</small>
      </div>
    </div>
  `).join("");
}
loadEventAndProjects();
// Sticky Notes
function addStickyNote() {
    const noteText = document.getElementById("noteInput").value.trim();
    if (noteText === "") return;

    const container = document.getElementById("notesContainer");
    const note = document.createElement("div");
    note.className = "alert alert-warning py-1 px-2 mb-2 small d-flex justify-content-between align-items-center";
    note.innerHTML = `
      <span>${noteText}</span>
      <button class="btn btn-sm btn-outline-dark btn-close-note">×</button>
    `;

    container.prepend(note);
    document.getElementById("noteInput").value = "";

    note.querySelector(".btn-close-note").addEventListener("click", () => note.remove());
  }

// dashboard.js — arranged & compact without removing logic
document.addEventListener("DOMContentLoaded", () => {
  const $id = (id) => document.getElementById(id);

  // Elements
  const profileToggle = $id("profileToggle"),
        profileMenu = $id("profileMenu"),
        darkModeToggle = $id("darkModeToggle"),
        dropdownToggle = $id("dropdownToggle"),
        worksuiteDropdown = $id("worksuiteDropdown"),
        dashboardMenu = $id("dashboardMenu"),
        dashboardDropdown = $id("dashboardDropdown"),
        incomeCanvas = $id("incomeChart"),
        timesheetCanvas = $id("timesheetChart");

  // Profile dropdown
  profileToggle?.addEventListener("click", (e) => {
    e.stopPropagation();
    profileMenu.style.display = profileMenu.style.display === "block" ? "none" : "block";
  });

  // Sidebar submenu
  dashboardMenu?.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    dashboardDropdown.classList.toggle("show");
  });

  // Universal Dropdown
  document.querySelectorAll(".sidebar-dropdown-toggle").forEach(toggle => {
  toggle.addEventListener("click", (e) => {
    e.preventDefault();
    const parent = toggle.parentElement;
    const submenu = parent.querySelector(".dropdown-submenu");

    submenu.classList.toggle("show");
    toggle.querySelector(".fa-chevron-down")?.classList.toggle("rotate");
  });
});



  // Dark Mode (default ON)
  if (darkModeToggle) {
    document.body.classList.add("dark-mode");
    document.body.classList.remove("light-mode");
    darkModeToggle.checked = true;

    darkModeToggle.addEventListener("change", () => {
      const enabled = darkModeToggle.checked;
      document.body.classList.toggle("dark-mode", enabled);
      document.body.classList.toggle("light-mode", !enabled);
    });
  }


  // Charts
  if (!window.Chart) return;

  // Income Bar Chart
  if (incomeCanvas) {
    new Chart(incomeCanvas.getContext("2d"), {
      type: "bar",
      data: {
        labels: ["06-Oct","07-Oct","08-Oct","09-Oct","10-Oct","11-Oct","12-Oct","13-Oct","14-Oct"],
        datasets: [{ data: [12000,18000,35000,24000,48000,29000,61000,32000,45000], backgroundColor: "#287bff", borderRadius: 6 }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false }},
        scales: {
          x: { grid: { display: false }, ticks: { color: "#a8b2d1", font: { size: 11 }}},
          y: { grid: { color: "rgba(255,255,255,0.08)" }, ticks: { color: "#a8b2d1", font: { size: 11 }}}
        }
      }
    });
  }

  // Timesheet Line Chart
  if (timesheetCanvas) {
    const ctx = timesheetCanvas.getContext("2d");
    const gradient = ctx.createLinearGradient(0,0,0,300);
    gradient.addColorStop(0,"rgba(78,161,255,0.4)");
    gradient.addColorStop(1,"rgba(78,161,255,0)");

    new Chart(ctx, {
      type: "line",
      data: {
        labels: ["01-Oct","04-Oct","07-Oct","10-Oct","13-Oct","16-Oct","20-Oct","21-Oct","27-Oct"],
        datasets: [{
          data: [3,4,5,2,5,2,4,4,1],
          borderColor: "#4ea1ff",
          backgroundColor: gradient,
          fill: true,
          tension: 0,
          pointBackgroundColor: "#fff",
          pointBorderColor: "#4ea1ff",
          pointRadius: 5,
          pointHoverRadius: 6
        }]
      },
      options: {
        plugins: { legend: { display: false }},
        scales: {
          x: { grid: { display: false }, ticks: { color: "#a8b2d1", font: { size: 11 }}},
          y: { grid: { color: "rgba(255,255,255,0.08)" }, ticks: { color: "#a8b2d1", font: { size: 11 }}}
        },
        elements: { line: { borderWidth: 2 }}
      }
    });
  }

  // ✅ Load Pending Tasks from JSON
  fetch("pending_task.json")
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("taskContainer");
      container.innerHTML = ""; // clear old HTML

      data.tasks.forEach(task => {
        const statusColor =
          task.status === "Incomplete" ? "red" :
          task.status === "Doing" ? "blue" :
          task.status === "To Do" ? "yellow" : "red";

        container.innerHTML += `
          <div class="section2-task-row">
            <div>
              <p class="task-title">${task.title}</p>
              <span class="task-sub">${task.sub}</span>
            </div>
            <div class="task-user-date">
              <img src="${task.avatar}" class="task-avatar">
              <span class="task-date ${task.date === 'Today' ? 'today' : ''}">${task.date}</span>
            </div>
            <div class="task-status-box">
              <span class="status-dot ${statusColor}"></span>
              <span class="task-status">${task.status}</span>
            </div>
          </div>
        `;
      });
    })
    .catch(err => console.error("Task Load Error:", err));

  
});

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

  // Worksuite dropdown (header)
  dropdownToggle?.addEventListener("click", (e) => {
    e.stopPropagation();
    worksuiteDropdown.classList.toggle("active");
  });

  // Sidebar submenu
  dashboardMenu?.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    dashboardDropdown.classList.toggle("show");
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

  // Close dropdowns on outside click
  window.addEventListener("click", (e) => {
    if (profileMenu?.style.display === "block" &&
        !profileToggle.contains(e.target) &&
        !profileMenu.contains(e.target)) profileMenu.style.display = "none";

    if (worksuiteDropdown?.classList.contains("active") &&
        !dropdownToggle.contains(e.target) &&
        !worksuiteDropdown.contains(e.target)) worksuiteDropdown.classList.remove("active");

    if (dashboardDropdown?.classList.contains("show") &&
        !dashboardMenu.contains(e.target) &&
        !dashboardDropdown.contains(e.target)) dashboardDropdown.classList.remove("show");
  });

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
});

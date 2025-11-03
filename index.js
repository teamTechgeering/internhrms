// dashboard.js — cleaned, safe, and organized
document.addEventListener("DOMContentLoaded", () => {
  // --- Helpers ---
  const $id = (id) => document.getElementById(id);

  // --- Elements ---
  const profileToggle = $id("profileToggle");
  const profileMenu = $id("profileMenu");

  const darkModeToggle = $id("darkModeToggle");

  const dropdownToggle = $id("dropdownToggle");       // Worksuite chevron
  const worksuiteDropdown = $id("worksuiteDropdown"); // Worksuite dropdown box

  const dashboardMenu = $id("dashboardMenu");         // Sidebar Dashboard menu item
  const dashboardDropdown = $id("dashboardDropdown"); // Sidebar Dashboard submenu

 
  // --- Profile dropdown toggle ---
  if (profileToggle && profileMenu) {
    profileToggle.addEventListener("click", (e) => {
      e.stopPropagation(); // prevent global click handler from immediately closing it
      profileMenu.style.display = profileMenu.style.display === "block" ? "none" : "block";
    });
  }

  // --- Worksuite (header) dropdown toggle ---
  if (dropdownToggle && worksuiteDropdown) {
    dropdownToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      worksuiteDropdown.classList.toggle("active");
    });
  }

  // --- Sidebar Dashboard submenu toggle ---
  if (dashboardMenu && dashboardDropdown) {
    dashboardMenu.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      dashboardDropdown.classList.toggle("show");
    });
  }

  // --- Dark mode initial state & toggle ---
  if (darkModeToggle) {
    // set initial state based on checkbox
    if (darkModeToggle.checked) {
      document.body.classList.add("dark-mode");
      document.body.classList.remove("light-mode");
    } else {
      document.body.classList.add("light-mode");
      document.body.classList.remove("dark-mode");
    }

    darkModeToggle.addEventListener("change", () => {
      const enabled = darkModeToggle.checked;
      document.body.classList.toggle("dark-mode", enabled);
      document.body.classList.toggle("light-mode", !enabled);
    });
  }

  // --- Global click to close open menus when clicking outside ---
  window.addEventListener("click", (e) => {
    // Close profile menu
    if (profileMenu && profileMenu.style.display === "block") {
      if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.style.display = "none";
      }
    }

    // Close worksuite dropdown
    if (worksuiteDropdown && worksuiteDropdown.classList.contains("active")) {
      if (!dropdownToggle.contains(e.target) && !worksuiteDropdown.contains(e.target)) {
        worksuiteDropdown.classList.remove("active");
      }
    }

    // Close sidebar dashboard submenu
    if (dashboardDropdown && dashboardDropdown.classList.contains("show")) {
      if (!dashboardMenu.contains(e.target) && !dashboardDropdown.contains(e.target)) {
        dashboardDropdown.classList.remove("show");
      }
    }
  });

});
  document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  });

  const dashboardToggle = document.getElementById("dashboardToggle");
  const dashboardDropdown = document.getElementById("dashboardDropdown");

  dashboardToggle.addEventListener("click", function (e) {
    e.preventDefault();
    const parent = this.parentElement;

    parent.classList.toggle("active"); // adds rotation effect

    // toggle dropdown visibility
    if (dashboardDropdown.style.display === "none" || dashboardDropdown.style.display === "") {
      dashboardDropdown.style.display = "block";
    } else {
      dashboardDropdown.style.display = "none";
    }
  });
  // Example: Hover tooltip animation or card effect
document.querySelectorAll('.custom-card').forEach(card => {
  card.addEventListener('mouseenter', () => {
    card.style.transition = 'all 0.3s ease';
  });
});
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 400,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    views: {
      dayGridMonth: { buttonText: 'month' },
      timeGridWeek: { buttonText: 'week' },
      timeGridDay: { buttonText: 'day' },
      listWeek: { buttonText: 'list' }
    },
    themeSystem: 'standard',
    events: [
      {
        title: 'There was no time.',
        start: '2025-10-27T18:02:00',
        color: '#e74c3c'
      },
      {
        title: 'There was no time.',
        start: '2025-10-26',
        end: '2025-10-28',
        color: '#e74c3c',
        allDay: true
      },
      {
        title: 'There was no time.',
        start: '2025-10-28',
        end: '2025-10-30',
        color: '#e74c3c',
        allDay: true
      },
     
     
    ]
  });

  calendar.render();
});





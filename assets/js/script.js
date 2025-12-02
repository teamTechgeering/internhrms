document.addEventListener("click", function (e) {
  const sidebar = document.querySelector(".side-nav");
  const dropdowns = document.querySelectorAll(".side-nav .collapse.show");

  if (sidebar && !sidebar.contains(e.target)) {
    dropdowns.forEach(function (openMenu) {
      bootstrap.Collapse.getOrCreateInstance(openMenu, {
        toggle: false,
      }).hide();
    });
  }
});
document.addEventListener("DOMContentLoaded", function () {
  const dropdown = document.querySelector(".nav-user");
  const menu = document.querySelector(".profile-dropdown");

  if (dropdown && menu) {
    // For click/touch (mobile)
    dropdown.addEventListener("click", (e) => {
      e.preventDefault();
      menu.classList.toggle("show");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) {
        menu.classList.remove("show");
      }
    });
  }
});


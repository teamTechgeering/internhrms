document.addEventListener("DOMContentLoaded", function () {
  const dropdown = document.querySelector(".nav-user");
  const menu = document.querySelector(".profile-dropdown");

  if (dropdown && menu) {

    // Open dropdown
    dropdown.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation(); // <<< THIS IS THE FIX
      menu.classList.toggle("show");
    });

    // Close when clicking outside
    document.addEventListener("click", () => {
      menu.classList.remove("show");
    });
  }
});

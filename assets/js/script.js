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
document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");

  // ✅ Load events from localStorage or defaults
  let storedEvents = JSON.parse(localStorage.getItem("savedEvents")) || [
    {
      title: "Employee Health Screening",
      start: "2025-10-26",
      color: "#0dcaf0",
    },
    {
      title: "Client Advisory Board Meeting",
      start: "2025-10-28",
      color: "#b5179e",
    },
    { title: "Meeting with John Smith", start: "2025-11-05", color: "#e63946" },
    {
      title: "Company Anniversary Celebration",
      start: "2025-11-07",
      color: "#2a9d8f",
    },
    { title: "Leadership Summit", start: "2025-11-19", color: "#52b788" },
    { title: "Networking Mixer", start: "2025-11-27", color: "#d00000" },
    { title: "Job Training Fair", start: "2025-11-29", color: "#7209b7" },
    { title: "Sales Training Workshop", start: "2025-11-30", color: "#00b4d8" },
  ];

  // ✅ Initialize FullCalendar
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    height: "auto",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    events: storedEvents,

    eventClick: function (info) {
      const event = info.event;
      document.getElementById("eventDetailsTitle").textContent = event.title;
      document.getElementById("eventDetailsDate").textContent = event.start
        ? event.start.toLocaleString()
        : "N/A";
      document.getElementById("eventDetailsColor").style.backgroundColor =
        event.backgroundColor || "#0d6efd";

      document.getElementById("eventDetailsModal").dataset.eventId =
        event.id || event.startStr;

      const eventDetailsModal = new bootstrap.Modal(
        document.getElementById("eventDetailsModal")
      );
      eventDetailsModal.show();
    },
  });

  calendar.render();

  const addEventBtn = document.getElementById("addEventBtn");
  const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
  const eventForm = document.getElementById("eventForm");

  // ✅ Success modal
  const successModalHTML = `
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-body text-center p-4">
            <i class="fa-solid fa-circle-check text-success fs-1 mb-3"></i>
            <h5 class="mb-2">Action completed successfully!</h5>
            <button type="button" class="btn btn-success btn-sm mt-2" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>`;
  document.body.insertAdjacentHTML("beforeend", successModalHTML);
  const successModal = new bootstrap.Modal(
    document.getElementById("successModal")
  );

  // ✅ Delete confirmation modal
  const deleteConfirmHTML = `
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <p>Are you sure you want to delete this event?</p>
          </div>
          <div class="modal-footer justify-content-center">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>`;
  document.body.insertAdjacentHTML("beforeend", deleteConfirmHTML);
  const deleteConfirmModal = new bootstrap.Modal(
    document.getElementById("deleteConfirmModal")
  );

  // ✅ Add Event Button
  addEventBtn.addEventListener("click", () => {
    eventForm.reset();
    eventModal.show();
  });

  // ✅ Add new event
  eventForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const title = document.getElementById("eventTitle").value.trim();
    const startDate = document.getElementById("startDate").value;
    const color = document.getElementById("eventColor").value;

    if (!title || !startDate) {
      alert("Please fill in all required fields.");
      return;
    }

    const newEvent = { title, start: startDate, color };

    calendar.addEvent(newEvent);
    storedEvents.push(newEvent);
    localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

    eventModal.hide();
    setTimeout(() => successModal.show(), 300);
  });

  // ✅ Edit button — open edit modal
  document
    .getElementById("editEventBtn")
    .addEventListener("click", function () {
      const eventId =
        document.getElementById("eventDetailsModal").dataset.eventId;
      const event = calendar
        .getEvents()
        .find((e) => e.id === eventId || e.startStr === eventId);
      if (!event) return;

      document.getElementById("editTitle").value = event.title;
      document.getElementById("editDate").value = event.startStr;
      document.getElementById("editColor").value = event.backgroundColor;

      const editModal = new bootstrap.Modal(
        document.getElementById("editEventModal")
      );
      editModal.show();
    });

  // ✅ Save changes — update calendar & localStorage
  document.getElementById("saveEditBtn").addEventListener("click", function () {
    const eventId =
      document.getElementById("eventDetailsModal").dataset.eventId;
    const event = calendar
      .getEvents()
      .find((e) => e.id === eventId || e.startStr === eventId);
    if (!event) return;

    const newTitle = document.getElementById("editTitle").value.trim();
    const newDate = document.getElementById("editDate").value;
    const newColor = document.getElementById("editColor").value;

    event.setProp("title", newTitle);
    event.setStart(newDate);
    event.setProp("backgroundColor", newColor);

    storedEvents = calendar.getEvents().map((e) => ({
      title: e.title,
      start: e.startStr,
      color: e.backgroundColor,
    }));
    localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

    bootstrap.Modal.getInstance(
      document.getElementById("editEventModal")
    ).hide();
    bootstrap.Modal.getInstance(
      document.getElementById("eventDetailsModal")
    ).hide();

    setTimeout(() => successModal.show(), 300);
  });

  // ✅ Delete event — show modal instead of alert
  let eventToDelete = null;

  document
    .getElementById("deleteEventBtn")
    .addEventListener("click", function () {
      const eventId =
        document.getElementById("eventDetailsModal").dataset.eventId;
      eventToDelete = calendar
        .getEvents()
        .find((e) => e.id === eventId || e.startStr === eventId);
      if (eventToDelete) deleteConfirmModal.show();
    });

  document
    .getElementById("confirmDeleteBtn")
    .addEventListener("click", function () {
      if (!eventToDelete) return;

      eventToDelete.remove();
      storedEvents = calendar.getEvents().map((e) => ({
        title: e.title,
        start: e.startStr,
        color: e.backgroundColor,
      }));
      localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

      deleteConfirmModal.hide();
      bootstrap.Modal.getInstance(
        document.getElementById("eventDetailsModal")
      ).hide();
      setTimeout(() => successModal.show(), 300);
    });
});
// ========================= CLIENT & CONTACT DASHBOARD LOGIC =========================
document
  .getElementById("card-total-clients")
  .addEventListener("click", function () {
    const tabEl = document.getElementById("clients-tab");
    const bsTab = new bootstrap.Tab(tabEl);
    bsTab.show();
    setTimeout(() => {
      document
        .getElementById("clientsTableBody")
        .querySelector("tr")
        ?.scrollIntoView({ behavior: "smooth" });
    }, 150);
  });

document
  .getElementById("card-total-contacts")
  .addEventListener("click", function () {
    const tabEl = document.getElementById("contacts-tab");
    const bsTab = new bootstrap.Tab(tabEl);
    bsTab.show();
  });

document.addEventListener("DOMContentLoaded", () => {
  // ========================= ELEMENT REFERENCES =========================
  const exportBtn = document.getElementById("exportExcel");
  const clientsTableBody = document.getElementById("clientsTableBody");
  const saveClientBtn = document.getElementById("saveClient");
  const successModal = new bootstrap.Modal(
    document.getElementById("successModal")
  );
  const editModal = new bootstrap.Modal(
    document.getElementById("editClientModal")
  );
  const deleteModal = new bootstrap.Modal(
    document.getElementById("deleteConfirmModal")
  );
  const saveEditChangesBtn = document.getElementById("saveEditChanges");
  const confirmDeleteBtn = document.getElementById("confirmDelete");
  const totalClientsEl = document.querySelector("#card-total-clients .h4");
  const addClientModal = document.getElementById("addClientModal");
  const searchInput = document.getElementById("searchClient");

  let clients = JSON.parse(localStorage.getItem("clientsData")) || [];
  let editIndex = null;
  let deleteIndex = null;

  // ========================= UTILITY FUNCTIONS =========================
  function saveClients() {
    localStorage.setItem("clientsData", JSON.stringify(clients));
    if (totalClientsEl) totalClientsEl.textContent = clients.length;
  }

  // ✅ Render clients in table
  function renderClients() {
    clientsTableBody.innerHTML = "";
    clients.forEach((c, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${c.id}</td>
       <td>
  <a href="Client-View.php?id=${c.id}" 
     class="text-decoration-none text-primary fw-semibold">
     ${c.name}
  </a>
</td>
        <td>${c.primaryContact}</td>
        <td>${c.phone}</td>
        <td>${c.clientGroup}</td>
        <td>${c.labels || ""}</td>
        <td>${c.projects || ""}</td>
        <td>$${c.totalInvoiced || 0}</td>
        <td>$${c.paymentReceived || 0}</td>
        <td>$${c.due || 0}</td>
        <td>
          <button class="btn btn-sm btn-outline-primary me-1 editBtn">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-outline-danger deleteBtn">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      `;
      clientsTableBody.appendChild(row);

      // ✏️ Edit button
      row.querySelector(".editBtn").addEventListener("click", () => {
        editIndex = index;
        document.getElementById("editClientName").value = c.name;
        document.getElementById("editPrimaryContact").value = c.primaryContact;
        document.getElementById("editPhone").value = c.phone;
        document.getElementById("editClientGroup").value = c.clientGroup;
        editModal.show();
      });

      // ❌ Delete button
      row.querySelector(".deleteBtn").addEventListener("click", () => {
        deleteIndex = index;
        deleteModal.show();
      });
    });
    saveClients();
  }

  // ========================= ADD CLIENT =========================
  // 🧩 Live input restriction for Add Client modal
  // ========================= ADD CLIENT =========================
  // 🧩 Live input restriction for Add Client modal
  document.getElementById("clientName").addEventListener("input", function () {
    this.value = this.value.replace(/[^A-Za-z\s]/g, "");
  });

  document.getElementById("phone").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9\-]/g, "");
  });

  saveClientBtn.addEventListener("click", () => {
    const clientNameEl = document.getElementById("clientName");
    const primaryContactEl = document.getElementById("primaryContact");
    const phoneEl = document.getElementById("phone");

    const clientName = clientNameEl.value.trim();
    const primaryContact = primaryContactEl.value.trim();
    const phone = phoneEl.value.trim();

    // 🧩 Basic Validation
    let isValid = true;

    // Reset previous error styles
    [clientNameEl, primaryContactEl, phoneEl].forEach((el) => {
      el.classList.remove("is-invalid");
    });

    if (clientName === "") {
      clientNameEl.classList.add("is-invalid");
      isValid = false;
    }

    if (primaryContact === "") {
      primaryContactEl.classList.add("is-invalid");
      isValid = false;
    }

    if (phone === "") {
      phoneEl.classList.add("is-invalid");
      isValid = false;
    }

    // 🛑 Stop if validation fails
    if (!isValid) return;

    // 🧩 No alerts needed since typing restriction is active
    const newClient = {
      id: clients.length + 1,
      name: clientName,
      primaryContact,
      phone,
      clientGroup: document.getElementById("clientGroup").value,
      labels: document.getElementById("labels").value,
      projects: document.getElementById("projects").value,
      totalInvoiced: document.getElementById("totalInvoiced").value,
      paymentReceived: document.getElementById("paymentReceived").value,
      due: document.getElementById("due").value,
    };

    clients.push(newClient);
    renderClients();

    // Reset + close modal + show success popup
    document.getElementById("addClientForm").reset();
    bootstrap.Modal.getInstance(addClientModal)?.hide();

    document.querySelector("#successModal .modal-title").textContent =
      "Client Added Successfully!";
    document.getElementById("successMessage").textContent =
      "The client has been added successfully.";
    successModal.show();
  });

  // 🧩 Fix for blur after success popup closes
  document
    .querySelector("#successModal")
    .addEventListener("hidden.bs.modal", function () {
      // Remove leftover backdrop and restore normal view
      document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
      document.body.classList.remove("modal-open");
      document.body.style = "";
    });

  // ========================= EDIT CLIENT =========================
  // 🧩 Real-time restriction for edit modal fields
  document
    .getElementById("editClientName")
    .addEventListener("input", function () {
      this.value = this.value.replace(/[^A-Za-z\s]/g, "");
    });

  document.getElementById("editPhone").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9\-]/g, "");
  });

  saveEditChangesBtn.addEventListener("click", () => {
    if (editIndex !== null) {
      const editedName = document.getElementById("editClientName").value.trim();
      const editedPhone = document.getElementById("editPhone").value.trim();

      // No alerts — just save what’s already valid
      clients[editIndex].name = editedName;
      clients[editIndex].primaryContact = document
        .getElementById("editPrimaryContact")
        .value.trim();
      clients[editIndex].phone = editedPhone;
      clients[editIndex].clientGroup = document
        .getElementById("editClientGroup")
        .value.trim();

      renderClients();
      editModal.hide();

      // ✅ Success popup message
      document.querySelector("#successModal .modal-title").textContent =
        "Client Updated Successfully!";
      const msg = document.getElementById("successMessage");
      if (msg)
        msg.textContent = "The client details were updated successfully.";
      successModal.show();
    }
  });

  // ========================= DELETE CLIENT =========================
  confirmDeleteBtn.addEventListener("click", () => {
    if (deleteIndex !== null) {
      clients.splice(deleteIndex, 1);
      renderClients();
      deleteModal.hide();

      document.querySelector("#successModal .modal-title").textContent =
        "Client Deleted Successfully!";
      document.getElementById("successMessage").textContent =
        "The client record was deleted.";
      successModal.show();
    }
  });

  // ========================= SEARCH =========================
  if (searchInput) {
    searchInput.addEventListener("keyup", () => {
      const filter = searchInput.value.toLowerCase();
      document.querySelectorAll("#clientsTableBody tr").forEach((row) => {
        row.style.display = row.textContent.toLowerCase().includes(filter)
          ? ""
          : "none";
      });
    });
  }

  // ========================= EXPORT TO EXCEL =========================
  if (exportBtn) {
    exportBtn.addEventListener("click", () => {
      const clients = JSON.parse(localStorage.getItem("clientsData")) || [];
      if (clients.length === 0) {
        alert("⚠️ No clients available to export!");
        return;
      }

      try {
        const worksheet = XLSX.utils.json_to_sheet(clients);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Clients");
        XLSX.writeFile(workbook, "Clients_List.xlsx");
      } catch (err) {
        console.error("❌ Error exporting Excel:", err);
        alert("Something went wrong while exporting the file.");
      }
    });
  }

  // ========================= INITIALIZE =========================
  renderClients();
  saveClients();
});
document.addEventListener("DOMContentLoaded", () => {
  const printBtn = document.getElementById("printTable");

  if (printBtn) {
    printBtn.addEventListener("click", () => {
      const table = document.getElementById("clientsTable");

      if (!table) {
        alert("❌ Table not found!");
        return;
      }

      // Create new print window
      const printWindow = window.open("", "", "width=900,height=700");

      printWindow.document.write(`
        <html>
          <head>
            <title>Print Clients Table</title>
            <style>
              table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
              }
              th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
              }
              th {
                background: #f4f4f4;
              }
              h2 {
                text-align: center;
                margin-bottom: 20px;
              }
            </style>
          </head>
          <body>
            <h2>Clients List</h2>
            ${table.outerHTML}
          </body>
        </html>
      `);

      printWindow.document.close();
      
      // Wait to ensure table loads before printing
      printWindow.onload = function () {
        printWindow.print();
      };
    });
  }
});


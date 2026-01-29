
/* =====================================================
   GLOBAL SAFE WRAPPER (DO NOT TOUCH AGAIN)
===================================================== */
(function () {

  window.$id = function (id) {
    return document.getElementById(id);
  };

  window.on = function (id, ev, fn) {
    const el = document.getElementById(id);
    if (el) el.addEventListener(ev, fn);
  };

  window.safeModalShow = function (id) {
    const el = document.getElementById(id);
    if (el && window.bootstrap) {
      bootstrap.Modal.getOrCreateInstance(el).show();
    }
  };

  window.safeModalHide = function (id) {
    const el = document.getElementById(id);
    const inst = el ? bootstrap.Modal.getInstance(el) : null;
    if (inst) inst.hide();
  };

})();
/* ================= CALENDAR MODULE (SAFE WRAPPED) ================= */
(function () {

  document.addEventListener("DOMContentLoaded", function () {

    const calendarEl = document.getElementById("calendar");

    // 🛑 PAGE GUARD
    if (!calendarEl || typeof FullCalendar === "undefined") return;

    /* ================= LOAD EVENTS ================= */

    let storedEvents = JSON.parse(localStorage.getItem("savedEvents")) || [
      { title: "Employee Health Screening", start: "2025-10-26", color: "#0dcaf0" },
      { title: "Client Advisory Board Meeting", start: "2025-10-28", color: "#b5179e" },
      { title: "Meeting with John Smith", start: "2025-11-05", color: "#e63946" },
      { title: "Company Anniversary Celebration", start: "2025-11-07", color: "#2a9d8f" },
      { title: "Leadership Summit", start: "2025-11-19", color: "#52b788" },
      { title: "Networking Mixer", start: "2025-11-27", color: "#d00000" },
      { title: "Job Training Fair", start: "2025-11-29", color: "#7209b7" },
      { title: "Sales Training Workshop", start: "2025-11-30", color: "#00b4d8" }
    ];

    /* ================= INIT CALENDAR ================= */

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: "dayGridMonth",
      height: "auto",
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
      },
      events: storedEvents,

      eventClick(info) {
        const event = info.event;

        const titleEl = document.getElementById("eventDetailsTitle");
        const dateEl = document.getElementById("eventDetailsDate");
        const colorEl = document.getElementById("eventDetailsColor");
        const modalEl = document.getElementById("eventDetailsModal");

        if (!modalEl) return;

        if (titleEl) titleEl.textContent = event.title;
        if (dateEl)
          dateEl.textContent = event.start
            ? event.start.toLocaleString()
            : "N/A";

        if (colorEl)
          colorEl.style.backgroundColor =
            event.backgroundColor || "#0d6efd";

        modalEl.dataset.eventId = event.id || event.startStr;

        bootstrap.Modal.getOrCreateInstance(modalEl).show();
      }
    });

    calendar.render();

    /* ================= SAFE MODALS ================= */

    if (!document.getElementById("successModal")) {
      document.body.insertAdjacentHTML("beforeend", `
        <div class="modal fade" id="successModal" tabindex="-1">
          <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow">
              <div class="modal-body text-center p-4">
                <i class="fa-solid fa-circle-check text-success fs-1 mb-3"></i>
                <h5 class="mb-2">Action completed successfully!</h5>
                <button class="btn btn-success btn-sm mt-2" data-bs-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>
      `);
    }

    if (!document.getElementById("deleteConfirmModal")) {
      document.body.insertAdjacentHTML("beforeend", `
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
        </div>
      `);
    }

    const successModal = bootstrap.Modal.getOrCreateInstance(
      document.getElementById("successModal")
    );
    const deleteConfirmModal = bootstrap.Modal.getOrCreateInstance(
      document.getElementById("deleteConfirmModal")
    );

    /* ================= ADD EVENT ================= */

    const addEventBtn = document.getElementById("addEventBtn");
    const eventForm = document.getElementById("eventForm");
    const eventModalEl = document.getElementById("eventModal");

    if (addEventBtn && eventForm && eventModalEl) {
      const eventModal = bootstrap.Modal.getOrCreateInstance(eventModalEl);

      addEventBtn.addEventListener("click", () => {
        eventForm.reset();
        eventModal.show();
      });

      eventForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const title = document.getElementById("eventTitle")?.value.trim();
        const startDate = document.getElementById("startDate")?.value;
        const color = document.getElementById("eventColor")?.value;

        if (!title || !startDate) return;

        const newEvent = { title, start: startDate, color };

        calendar.addEvent(newEvent);
        storedEvents.push(newEvent);
        localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

        eventModal.hide();
        setTimeout(() => successModal.show(), 300);
      });
    }

    /* ================= EDIT EVENT ================= */

    document.getElementById("editEventBtn")?.addEventListener("click", () => {
      const id = document.getElementById("eventDetailsModal")?.dataset.eventId;
      const ev = calendar.getEvents().find(
        (e) => e.id === id || e.startStr === id
      );
      if (!ev) return;

      document.getElementById("editTitle").value = ev.title;
      document.getElementById("editDate").value = ev.startStr;
      document.getElementById("editColor").value = ev.backgroundColor;

      bootstrap.Modal.getOrCreateInstance(
        document.getElementById("editEventModal")
      ).show();
    });

    document.getElementById("saveEditBtn")?.addEventListener("click", () => {
      const id = document.getElementById("eventDetailsModal")?.dataset.eventId;
      const ev = calendar.getEvents().find(
        (e) => e.id === id || e.startStr === id
      );
      if (!ev) return;

      ev.setProp("title", document.getElementById("editTitle").value.trim());
      ev.setStart(document.getElementById("editDate").value);
      ev.setProp("backgroundColor", document.getElementById("editColor").value);

      storedEvents = calendar.getEvents().map(e => ({
        title: e.title,
        start: e.startStr,
        color: e.backgroundColor
      }));
      localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

      bootstrap.Modal.getInstance(document.getElementById("editEventModal"))?.hide();
      bootstrap.Modal.getInstance(document.getElementById("eventDetailsModal"))?.hide();

      setTimeout(() => successModal.show(), 300);
    });

    /* ================= DELETE EVENT ================= */

    let eventToDelete = null;

    document.getElementById("deleteEventBtn")?.addEventListener("click", () => {
      const id = document.getElementById("eventDetailsModal")?.dataset.eventId;
      eventToDelete = calendar.getEvents().find(
        (e) => e.id === id || e.startStr === id
      );
      if (eventToDelete) deleteConfirmModal.show();
    });

    document.getElementById("confirmDeleteBtn")?.addEventListener("click", () => {
      if (!eventToDelete) return;

      eventToDelete.remove();
      storedEvents = calendar.getEvents().map(e => ({
        title: e.title,
        start: e.startStr,
        color: e.backgroundColor
      }));
      localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

      deleteConfirmModal.hide();
      bootstrap.Modal.getInstance(
        document.getElementById("eventDetailsModal")
      )?.hide();

      setTimeout(() => successModal.show(), 300);
    });

  });
// ========================= CLIENT & CONTACT DASHBOARD LOGIC =========================
document.addEventListener("DOMContentLoaded", function () {
  const card = document.getElementById("card-total-clients");

  if (!card) return; // 🛑 page guard

  card.addEventListener("click", function () {
    const tabEl = document.getElementById("clients-tab");
    if (!tabEl || !window.bootstrap) return;

    const bsTab = new bootstrap.Tab(tabEl);
    bsTab.show();

    setTimeout(() => {
      document
        .getElementById("clientsTableBody")
        ?.querySelector("tr")
        ?.scrollIntoView({ behavior: "smooth" });
    }, 150);
  });
});


on("card-total-contacts", "click", function () {
  const tabEl = document.getElementById("contacts-tab");
  if (!tabEl || !window.bootstrap) return;

  new bootstrap.Tab(tabEl).show();
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
 <td>
  <a href="Client-Contact.php?id=${c.id}" 
     class="text-decoration-none text-primary fw-semibold">
     ${c.primaryContact}
  </a>
</td>
      
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

      // ✏ Edit button
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
        alert("⚠ No clients available to export!");
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
document.addEventListener("DOMContentLoaded", function () {
    const printBtn = document.getElementById("printTable");
    const table = document.getElementById("clientsTable");

    if (!printBtn) {
        console.log("❌ printTable button not found");
        return;
    }

    printBtn.addEventListener("click", function () {
        if (!table) {
            alert("Table not found!");
            return;
        }

        let win = window.open("", "", "width=900,height=700");
        win.document.write(`
            <html>
            <head>
                <title>Print Clients</title>
                <style>
                    table { width: 100%; border-collapse: collapse; font-size: 14px; }
                    th, td { border: 1px solid #333; padding: 8px; }
                    th { background: #f2f2f2; }
                </style>
            </head>
            <body>
                ${table.outerHTML}
            </body>
            </html>
        `);

        win.document.close();
        win.print();
    });
});
document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll(".open-client-tab").forEach(card => {
        card.style.cursor = "pointer";
        card.addEventListener("click", () => {
            document.getElementById("clients-tab").click();
        });
    });

});


// ================= LOAD CONTACTS =================
// ========================= LOAD CONTACTS =========================
function loadContacts() {
    let stored = JSON.parse(localStorage.getItem("contacts"));

    // Load from localStorage if exists
    if (stored && stored.length > 0) {
        renderContacts(stored);
        updateStatsCard();
        return; // Do NOT fetch from server
    }

    // Otherwise load from server one time
    fetch("contacts.php")
        .then(res => res.json())
        .then(data => {
            localStorage.setItem("contacts", JSON.stringify(data));
            renderContacts(data);
            updateStatsCard();
        });
}

document.addEventListener("DOMContentLoaded", loadContacts);


// ========================= RENDER CONTACTS =========================
function renderContacts(data) {
    const tbody = document.getElementById("contactsBody");

    // 🛑 PAGE GUARD (MOST IMPORTANT)
    if (!tbody) return;

    tbody.innerHTML = "";

    (data || []).forEach((c, index) => {
        tbody.insertAdjacentHTML("beforeend", `
            <tr>
                <td>
                    <img src="assets/images/users/avatar-6.jpg"
                         width="32"
                         class="rounded-circle">
                </td>

                <td onclick="openClient(${c.id})">
                    <a href="Client-Contact.php?id=${c.id}"
                       class="text-decoration-none text-primary fw-semibold"
                       onclick="event.stopPropagation()">
                        ${c.name}
                    </a>
                </td>

                <td onclick="openClient(${c.id})">
                    <a href="Client-View.php?id=${c.id}"
                       class="text-primary text-decoration-none fw-semibold"
                       onclick="event.stopPropagation()">
                        ${c.client_name}
                    </a>
                </td>

                <td>${c.job_title || "-"}</td>
                <td>${c.email || "-"}</td>
                <td>${c.phone || "-"}</td>
                <td>${c.skype || "-"}</td>

                <td>
                    <i class="bi bi-x-lg text-danger delete-btn"
                       style="cursor:pointer;"
                       data-index="${index}">
                    </i>
                </td>
            </tr>
        `);
    });

    attachDeleteEvents?.();
}

// ========================= DELETE CONTACT =========================
let deleteIndex = null;

function attachDeleteEvents() {
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            deleteIndex = this.getAttribute("data-index");

            let modal = new bootstrap.Modal(document.getElementById("deleteContactModal"));
            modal.show();
        });
    });
}


on("confirmDeleteBtn", "click", function () {
    let contacts = JSON.parse(localStorage.getItem("contacts")) || [];

    if (deleteIndex === null) return;

    contacts.splice(deleteIndex, 1);
    localStorage.setItem("contacts", JSON.stringify(contacts));

    renderContacts(contacts);
    updateStatsCard();

    const modalEl = document.getElementById("deleteContactModal");
    if (modalEl) {
        bootstrap.Modal.getInstance(modalEl)?.hide();
    }
});



// ========================= UPDATE CONTACT COUNT =========================
function updateStatsCard() {
    let contacts = JSON.parse(localStorage.getItem("contacts")) || [];
    let counter = document.getElementById("totalContactsCount");

    if (counter) counter.innerText = contacts.length;
}


// ========================= ADD CONTACT =========================
on("addContactForm", "submit", function (e) {
    e.preventDefault();

    let contacts = JSON.parse(localStorage.getItem("contacts")) || [];

    let newContact = {
        id: Date.now(),
        name: this.name?.value || "",
        client_name: this.client?.value || "",
        job_title: this.job?.value || "",
        email: this.email?.value || "",
        phone: this.phone?.value || "",
        skype: this.skype?.value || ""
    };

    // basic guard
    if (!newContact.name || !newContact.email) return;

    contacts.push(newContact);
    localStorage.setItem("contacts", JSON.stringify(contacts));

    renderContacts(contacts);
    updateStatsCard();

    const modalEl = document.getElementById("addContactModal");
    bootstrap.Modal.getInstance(modalEl)?.hide();

    this.reset();

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("successModal")
    )?.show();
});

/* ================= CLIENT & CONTACT MODULE (SAFE WRAPPED) ================= */
(function () {

  /* ---------- SAFE HELPERS ---------- */
  const $ = (id) => document.getElementById(id);
  const on = (id, ev, fn) => {
    const el = $(id);
    if (el) el.addEventListener(ev, fn);
  };

  function showModal(id) {
    const el = $(id);
    if (el && window.bootstrap)
      bootstrap.Modal.getOrCreateInstance(el).show();
  }

  function hideModal(id) {
    const el = $(id);
    const inst = el ? bootstrap.Modal.getInstance(el) : null;
    if (inst) inst.hide();
  }

  /* ================= INIT ON DOM READY ================= */
  document.addEventListener("DOMContentLoaded", () => {

    /* ================= DASHBOARD CARDS ================= */
    on("card-total-clients", "click", () => {
      const tab = $("clients-tab");
      if (!tab) return;
      new bootstrap.Tab(tab).show();

      setTimeout(() => {
        $("clientsTableBody")?.querySelector("tr")?.scrollIntoView({ behavior: "smooth" });
      }, 150);
    });

    on("card-total-contacts", "click", () => {
      const tab = $("contacts-tab");
      if (tab) new bootstrap.Tab(tab).show();
    });

    /* ================= CLIENTS ================= */
    const clientsTableBody = $("clientsTableBody");
    if (clientsTableBody) {

      let clients = JSON.parse(localStorage.getItem("clientsData")) || [];
      let editIndex = null;
      let deleteIndex = null;

      const totalClientsEl = document.querySelector("#card-total-clients .h4");

      function saveClients() {
        localStorage.setItem("clientsData", JSON.stringify(clients));
        if (totalClientsEl) totalClientsEl.textContent = clients.length;
      }

      function renderClients() {
        clientsTableBody.innerHTML = "";

        clients.forEach((c, index) => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${c.id}</td>
            <td><a href="Client-View.php?id=${c.id}" class="fw-semibold text-primary text-decoration-none">${c.name}</a></td>
            <td><a href="Client-Contact.php?id=${c.id}" class="fw-semibold text-primary text-decoration-none">${c.primaryContact}</a></td>
            <td>${c.phone}</td>
            <td>${c.clientGroup || ""}</td>
            <td>${c.labels || ""}</td>
            <td>${c.projects || ""}</td>
            <td>$${c.totalInvoiced || 0}</td>
            <td>$${c.paymentReceived || 0}</td>
            <td>$${c.due || 0}</td>
            <td>
              <button class="btn btn-sm btn-outline-primary editBtn"><i class="bi bi-pencil-square"></i></button>
              <button class="btn btn-sm btn-outline-danger deleteBtn"><i class="bi bi-trash"></i></button>
            </td>
          `;
          clientsTableBody.appendChild(row);

          row.querySelector(".editBtn").onclick = () => {
            editIndex = index;
            $("editClientName").value = c.name;
            $("editPrimaryContact").value = c.primaryContact;
            $("editPhone").value = c.phone;
            $("editClientGroup").value = c.clientGroup;
            showModal("editClientModal");
          };

          row.querySelector(".deleteBtn").onclick = () => {
            deleteIndex = index;
            showModal("deleteConfirmModal");
          };
        });

        saveClients();
      }

      /* ----- ADD CLIENT ----- */
      on("clientName", "input", function () {
        this.value = this.value.replace(/[^A-Za-z\s]/g, "");
      });

      on("phone", "input", function () {
        this.value = this.value.replace(/[^0-9\-]/g, "");
      });

      on("saveClient", "click", () => {
        const name = $("clientName")?.value.trim();
        const contact = $("primaryContact")?.value.trim();
        const phone = $("phone")?.value.trim();

        if (!name || !contact || !phone) return;

        clients.push({
          id: clients.length + 1,
          name,
          primaryContact: contact,
          phone,
          clientGroup: $("clientGroup")?.value,
          labels: $("labels")?.value,
          projects: $("projects")?.value,
          totalInvoiced: $("totalInvoiced")?.value,
          paymentReceived: $("paymentReceived")?.value,
          due: $("due")?.value
        });

        renderClients();
        $("addClientForm")?.reset();
        hideModal("addClientModal");
        showModal("successModal");
      });

      /* ----- EDIT CLIENT ----- */
      on("editClientName", "input", function () {
        this.value = this.value.replace(/[^A-Za-z\s]/g, "");
      });

      on("editPhone", "input", function () {
        this.value = this.value.replace(/[^0-9\-]/g, "");
      });

      on("saveEditChanges", "click", () => {
        if (editIndex === null) return;

        clients[editIndex].name = $("editClientName").value.trim();
        clients[editIndex].primaryContact = $("editPrimaryContact").value.trim();
        clients[editIndex].phone = $("editPhone").value.trim();
        clients[editIndex].clientGroup = $("editClientGroup").value.trim();

        renderClients();
        hideModal("editClientModal");
        showModal("successModal");
      });

      /* ----- DELETE CLIENT ----- */
      on("confirmDelete", "click", () => {
        if (deleteIndex === null) return;
        clients.splice(deleteIndex, 1);
        renderClients();
        hideModal("deleteConfirmModal");
        showModal("successModal");
      });

      /* ----- SEARCH ----- */
      on("searchClient", "keyup", (e) => {
        const q = e.target.value.toLowerCase();
        document.querySelectorAll("#clientsTableBody tr").forEach(row => {
          row.style.display = row.innerText.toLowerCase().includes(q) ? "" : "none";
        });
      });

      /* ----- EXPORT ----- */
      on("exportExcel", "click", () => {
        if (!window.XLSX) return;
        const data = JSON.parse(localStorage.getItem("clientsData")) || [];
        if (!data.length) return alert("No clients to export");

        const ws = XLSX.utils.json_to_sheet(data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Clients");
        XLSX.writeFile(wb, "Clients_List.xlsx");
      });

      renderClients();
    }

    /* ================= CONTACTS ================= */
    const contactsBody = $("contactsBody");
    if (contactsBody) {

      function updateStatsCard() {
        const count = JSON.parse(localStorage.getItem("contacts")) || [];
        $("totalContactsCount") && ($("totalContactsCount").innerText = count.length);
      }

      function renderContacts(data) {
        contactsBody.innerHTML = "";

        data.forEach((c, i) => {
          contactsBody.insertAdjacentHTML("beforeend", `
            <tr>
              <td><img src="assets/images/users/avatar-6.jpg" width="32" class="rounded-circle"></td>
              <td><a href="Client-Contact.php?id=${c.id}" class="fw-semibold text-primary">${c.name}</a></td>
              <td><a href="Client-View.php?id=${c.id}" class="fw-semibold text-primary">${c.client_name}</a></td>
              <td>${c.job_title}</td>
              <td>${c.email}</td>
              <td>${c.phone}</td>
              <td>${c.skype}</td>
              <td><i class="bi bi-x-lg text-danger delete-btn" data-index="${i}" style="cursor:pointer"></i></td>
            </tr>
          `);
        });

        document.querySelectorAll(".delete-btn").forEach(btn => {
          btn.onclick = () => {
            let contacts = JSON.parse(localStorage.getItem("contacts")) || [];
            contacts.splice(btn.dataset.index, 1);
            localStorage.setItem("contacts", JSON.stringify(contacts));
            renderContacts(contacts);
            updateStatsCard();
          };
        });
      }

      function loadContacts() {
        let stored = JSON.parse(localStorage.getItem("contacts"));
        if (stored?.length) {
          renderContacts(stored);
          updateStatsCard();
          return;
        }

        fetch("contacts.php")
          .then(r => r.json())
          .then(d => {
            localStorage.setItem("contacts", JSON.stringify(d));
            renderContacts(d);
            updateStatsCard();
          });
      }

      loadContacts();
    }

  });

})();

document.addEventListener("DOMContentLoaded", () => {

  // Load JSON file
  fetch("clientsdata.php")
    .then(response => response.json())
    .then(data => {
      loadClientData(data);
    })
    .catch(err => console.error("JSON Load Error:", err));

});


// MAIN FUNCTION TO FILL HTML
function loadClientData(data) {

  // Basic Information
  setText("clientName", data.clientName);
  setText("clientTagline", data.organization);
  setText("organization", data.organization);
  setText("clientMeta", data.meta);

  // Invoice Overview
  setText("overdue", data.invoiceOverview.overdue);
  setText("notPaid", data.invoiceOverview.notPaid);
  setText("partiallyPaid", data.invoiceOverview.partiallyPaid);
  setText("fullyPaid", data.invoiceOverview.fullyPaid);
  setText("draft", data.invoiceOverview.draft);
  setText("totalInvoiced", data.invoiceOverview.totalInvoiced);
  setText("payments", data.invoiceOverview.payments);
  setText("due", data.invoiceOverview.due);

  // Contacts
  setText("contactName", data.contacts.name);
  setText("phone", data.contacts.phone);
  setText("email", data.contacts.email);
  setText("address", data.contacts.address);

  // Recent Invoices List
  loadList("recentInvoices", data.recentInvoices, (item) =>
    `${item.id} — $${item.amount}`
  );

  // Client Info Section
  setText("organizationInfo", data.clientInfo.organization);
  setText("joinedDate", data.clientInfo.joinedDate);
  setText("clientStatus", data.clientInfo.status);

  // Website link + text
  const website = document.getElementById("clientWebsite");
  if (website) {
    website.href = data.clientInfo.website;
    website.textContent = data.clientInfo.website;
  }

  // Tasks List
  loadList("taskList", data.tasks);

  // Notes
  setText("clientNotes", data.notes);

  // Reminders
  loadList("reminderList", data.reminders);
}


// =========================
// Helper Functions
// =========================

// Set innerText safely
function setText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value;
}

// Render array as <li>
function loadList(id, array, formatter = (x) => x) {
  const listEl = document.getElementById(id);

  if (!listEl) return;

  listEl.innerHTML = ""; // clear old list

  if (!array || array.length === 0) {
    listEl.innerHTML = `<li class="list-group-item">No data available.</li>`;
    return;
  }

  array.forEach(item => {
    const li = document.createElement("li");
    li.className = "list-group-item";
    li.textContent = formatter(item);
    listEl.appendChild(li);
  });
}
document.addEventListener("DOMContentLoaded", () => {
    // Only initialize if these elements exist on the page
    const monthLabel = document.getElementById("calendarMonthLabel");
    const weekdaysHeader = document.getElementById("calendarWeekdays");
    const calendarBody = document.getElementById("calendarBody");
    const selectedDateLabel = document.getElementById("selectedDateLabel");
    const dayEventsList = document.getElementById("dayEventsList");
    const prevBtn = document.getElementById("prevMonth");
    const nextBtn = document.getElementById("nextMonth");

    if (!monthLabel || !calendarBody || !weekdaysHeader) {
        // ❌ This page doesn't contain the calendar → Stop
        return;
    }

    // ==========================
    // Calendar variables
    // ==========================
    let current = new Date();

    // Dummy events for demonstration
    const dummyEvents = {
        "2025-02-14": ["Client meeting", "Team review call"],
        "2025-02-20": ["Website deployment"],
        "2025-03-05": ["Invoice reminder"],
    };

    // ==========================
    // Render Weekdays
    // ==========================
    const weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    weekdaysHeader.innerHTML = weekdays
        .map(day => `<th class="text-center">${day}</th>`)
        .join("");

    // ==========================
    // Render Calendar
    // ==========================
    function renderCalendar() {
        const year = current.getFullYear();
        const month = current.getMonth();

        monthLabel.textContent = current.toLocaleDateString("en-US", {
            month: "long",
            year: "numeric"
        });

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        let html = "<tr>";
        let day = 1;

        // Empty cells before the 1st
        for (let i = 0; i < firstDay; i++) html += "<td></td>";

        for (let i = firstDay; i < 7; i++) {
            html += renderDayCell(year, month, day);
            day++;
        }
        html += "</tr>";

        while (day <= lastDate) {
            html += "<tr>";
            for (let i = 0; i < 7 && day <= lastDate; i++) {
                html += renderDayCell(year, month, day);
                day++;
            }
            html += "</tr>";
        }

        calendarBody.innerHTML = html;

        // Attach click event to all date cells
        document.querySelectorAll(".calendar-day").forEach(cell => {
            cell.addEventListener("click", () => {
                const dateKey = cell.dataset.date;
                showEventsForDate(dateKey);
            });
        });
    }

    // ==========================
    // Render single day cell
    // ==========================
    function renderDayCell(year, month, day) {
        const dateKey = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
        const hasEvent = dummyEvents[dateKey];

        return `
            <td class="text-center p-2 calendar-day ${hasEvent ? 'bg-light border-primary' : ''}"
                data-date="${dateKey}"
                style="cursor:pointer;">
                ${day}
                ${hasEvent ? '<span class="d-block badge bg-primary mt-1">•</span>' : ''}
            </td>
        `;
    }

    // ==========================
    // Show events for selected day
    // ==========================
    function showEventsForDate(dateKey) {
        selectedDateLabel.textContent = dateKey;

        dayEventsList.innerHTML = "";

        const events = dummyEvents[dateKey];

        if (!events || events.length === 0) {
            dayEventsList.innerHTML = `
                <li class="list-group-item text-muted">No events for this day.</li>
            `;
            return;
        }

        events.forEach(ev => {
            const li = document.createElement("li");
            li.className = "list-group-item";
            li.textContent = ev;
            dayEventsList.appendChild(li);
        });
    }

    // ==========================
    // Month navigation
    // ==========================
    prevBtn?.addEventListener("click", () => {
        current.setMonth(current.getMonth() - 1);
        renderCalendar();
    });

    nextBtn?.addEventListener("click", () => {
        current.setMonth(current.getMonth() + 1);
        renderCalendar();
    });

    // Initialize calendar
    renderCalendar();
});



fetch("client.php")
    .then(r => r.json())
    .then(d => {

        document.getElementById("client-name").innerText = d.first_name + " " + d.last_name;
        document.getElementById("right-name").innerText = d.first_name + " " + d.last_name;
        document.getElementById("job-title").innerText = d.job_title;
        document.getElementById("email").innerText = d.email;
        document.getElementById("phone").innerText = d.phone;

        document.getElementById("full-address").innerText =
            `${d.address}, ${d.city}, ${d.state}, ${d.country}`;

        document.getElementById("first-name").innerText = d.first_name;
        document.getElementById("last-name").innerText = d.last_name;
        document.getElementById("gen-phone").innerText = d.phone;
        document.getElementById("gender").innerText = d.gender;
        document.getElementById("gen-job-title").innerText = d.job_title;

        document.getElementById("owner").innerText = d.owner;
        document.getElementById("address").innerText = d.address;
        document.getElementById("city").innerText = d.city;
        document.getElementById("state").innerText = d.state;
        document.getElementById("country").innerText = d.country;
        document.getElementById("groups").innerText = d.groups.join(", ");
        document.getElementById("labels").innerText = d.labels.join(", ");

        // FIXED PART ↓↓↓
        document.getElementById("facebook").href = d.social_links.facebook;
        document.getElementById("facebook").textContent = d.social_links.facebook;

        document.getElementById("twitter").href = d.social_links.twitter;
        document.getElementById("twitter").textContent = d.social_links.twitter;

        document.getElementById("linkedin").href = d.social_links.linkedin;
        document.getElementById("linkedin").textContent = d.social_links.linkedin;

        document.getElementById("website").href = d.social_links.website;
        document.getElementById("website").textContent = d.social_links.website;
        document.getElementById("acc-email").innerText = d.email;
document.getElementById("acc-status").innerText = d.account_settings.account_status;
document.getElementById("acc-language").innerText = d.account_settings.language;
document.getElementById("acc-timezone").innerText = d.account_settings.timezone;
document.getElementById("acc-created").innerText = d.account_settings.created_on;
document.getElementById("acc-last-login").innerText = d.account_settings.last_login;
// Role
document.getElementById("role").innerText = d.permissions.role;

// Permissions Table
const tbody = document.getElementById("permissions-table");
tbody.innerHTML = "";

d.permissions.access.forEach(p => {
    const row = `
        <tr>
            <td>${p.module}</td>
            <td class="text-center">${p.view ? "✔️" : "❌"}</td>
            <td class="text-center">${p.edit ? "✔️" : "❌"}</td>
            <td class="text-center">${p.delete ? "✔️" : "❌"}</td>
        </tr>
    `;
    tbody.innerHTML += row;
});

    });


})();
document.addEventListener("DOMContentLoaded", () => {

    // state
    let projects = [];
    let filtered = [];
    let currentPage = 1;

    const pageSizeSelect = document.getElementById('pageSize');
    const tbody = document.getElementById('projects-tbody');
    const searchInput = document.getElementById('search');
    const btnExcel = document.getElementById('btn-excel');
    const btnPrint = document.getElementById('btn-print');
    const paginationEl = document.getElementById('pagination');
    const rangeLabel = document.getElementById('rangeLabel');

    if (!tbody || !pageSizeSelect) {
        console.error("❌ Missing required DOM elements. project.js aborted.");
        return;
    }

    let pageSize = parseInt(pageSizeSelect.value, 10);

    // label class mapping
    const labelClassMap = {
        'Urgent': 'badge bg-danger text-white',
        'On track': 'badge bg-success text-white',
        'Upcoming': 'badge bg-warning text-dark',
        'Perfect': 'badge bg-info text-white'
    };

    // load projects
    async function loadProjects() {
        try {
            const res = await fetch('projects_json.php', { cache: 'no-store' });
            if (!res.ok) throw new Error('Failed to load projects.json: ' + res.status);

            const data = await res.json();
            projects = Array.isArray(data) ? data : (data.projects || []);
            filtered = [...projects];

            updateView();
        } catch (err) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-danger text-center">Failed to load projects.json</td>
                </tr>`;
            console.error(err);
        }
    }

    function progressStylePercent(n) {
        const v = Math.max(0, Math.min(100, Number(n) || 0));
        return v + '%';
    }

    function renderLabel(label) {
        if (!label) return '';
        const cls = labelClassMap[label] || 'badge bg-secondary text-white';
        return ` <span class="${cls}">${label}</span>`;
    }

    function renderTable() {
        tbody.innerHTML = '';
        pageSize = parseInt(pageSizeSelect.value, 10);

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr>
                <td colspan="9" class="text-muted text-center">No projects found.</td>
            </tr>`;
            return;
        }

        for (const p of pageItems) {
            const tr = document.createElement('tr');

            const progressPercent = progressStylePercent(p.progress);
            const deadlineClass = p.deadline_alert ? 'text-danger fw-semibold' : '';

            tr.innerHTML = `
                <td>${p.id ?? ''}</td>

                <td class="small">
                  <a href="project_detail.php?id=${encodeURIComponent(p.id)}"
                     class="text-decoration-none text-blue">
                    ${escapeHtml(p.title ?? '')}
                  </a>
                  ${renderLabel(p.label)}
                </td>

                <td>${escapeHtml(p.client ?? '-')}</td>
                <td>${escapeHtml(p.price ?? '-')}</td>
                <td>${escapeHtml(p.start_date ?? '-')}</td>
                <td class="${deadlineClass}">${escapeHtml(p.deadline ?? '-')}</td>

                <td style="min-width:160px">
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar bg-primary"
                             role="progressbar"
                             style="width:${progressPercent}">
                        </div>
                    </div>
                </td>

                <td>${escapeHtml(p.status ?? '-')}</td>

                <td class="text-end">
                    <button class="btn btn-outline-secondary btn-sm me-1 btn-edit" data-id="${p.id}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm btn-delete" data-id="${p.id}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        }

        const total = filtered.length;
        const from = total === 0 ? 0 : (start + 1);
        const to = Math.min(start + pageSize, total);

        rangeLabel.textContent = `${from}–${to} / ${total}`;

        document.querySelectorAll('.btn-edit').forEach(b => b.addEventListener('click', onEditClick));
        document.querySelectorAll('.btn-delete').forEach(b => b.addEventListener('click', onDeleteClick));
    }

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;');
    }

    function renderPagination() {
        paginationEl.innerHTML = '';
        const total = filtered.length;
        pageSize = parseInt(pageSizeSelect.value, 10);

        const pages = Math.max(1, Math.ceil(total / pageSize));
        if (currentPage > pages) currentPage = pages;

        const prev = document.createElement('li');
        prev.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
        prev.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
        prev.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage > 1) { currentPage--; updateView(); }
        });
        paginationEl.appendChild(prev);

        let start = Math.max(1, currentPage - 2);
        let end = Math.min(pages, start + 4);
        if (end - start < 4) start = Math.max(1, end - 4);

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = 'page-item ' + (i === currentPage ? 'active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                currentPage = i;
                updateView();
            });
            paginationEl.appendChild(li);
        }

        const next = document.createElement('li');
        next.className = 'page-item ' + (currentPage === pages ? 'disabled' : '');
        next.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
        next.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage < pages) { currentPage++; updateView(); }
        });
        paginationEl.appendChild(next);
    }

    function updateView() {
        renderTable();
        renderPagination();
    }

    // SEARCH
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            filtered = !q
                ? [...projects]
                : projects.filter(p =>
                    (p.title && p.title.toLowerCase().includes(q)) ||
                    (p.client && p.client.toLowerCase().includes(q))
                );
            currentPage = 1;
            updateView();
        });
    }

    // PAGE SIZE
    pageSizeSelect.addEventListener('change', () => {
        currentPage = 1;
        updateView();
    });

    // EXPORT CSV
    btnExcel?.addEventListener('click', () => {
        const header = [
            'ID', 'Title', 'Client', 'Price', 'Start date',
            'Deadline', 'Progress', 'Status', 'Label'
        ];

        const rows = filtered.map(p => [
            p.id, p.title, p.client || '',
            p.price || '', p.start_date || '',
            p.deadline || '', (p.progress || 0) + '%',
            p.status || '', p.label || ''
        ]);

        const csv = [header, ...rows]
            .map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(','))
            .join('\n');

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'projects.csv';
        a.click();
        URL.revokeObjectURL(url);
    });

    // PRINT
    btnPrint?.addEventListener('click', () => window.print());

    // EDIT MODAL
    const editModalEl = document.getElementById('editModal');
    const editModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;

    function onEditClick(e) {
        if (!editModal) return;

        const id = Number(e.currentTarget.getAttribute('data-id'));
        const p = projects.find(x => Number(x.id) === id);
        if (!p) return;

        document.getElementById('edit-id').value = p.id;
        document.getElementById('edit-title').value = p.title || '';
        document.getElementById('edit-type').value = p.project_type || 'Client Project';
        document.getElementById('edit-label').value = p.label || '';
        document.getElementById('edit-description').value = p.description || '';
        document.getElementById('edit-start').value = p.start_date || '';
        document.getElementById('edit-deadline').value = p.deadline || '';
        document.getElementById('edit-price').value = p.price || '';
        document.getElementById('edit-progress').value = p.progress || 0;
        document.getElementById('edit-status').value = p.status || 'Open';

        editModal.show();
    }

    function onDeleteClick(e) {
        const id = Number(e.currentTarget.getAttribute('data-id'));
        if (!confirm('Delete project ID ' + id + '?')) return;

        projects = projects.filter(x => Number(x.id) !== id);
        filtered = filtered.filter(x => Number(x.id) !== id);
        updateView();
    }

    document.getElementById('saveChanges')?.addEventListener('click', () => {
        const id = Number(document.getElementById('edit-id').value);
        const idx = projects.findIndex(x => Number(x.id) === id);

        if (idx === -1) return;

        projects[idx].title = document.getElementById('edit-title').value.trim();
        projects[idx].project_type = document.getElementById('edit-type').value;
        projects[idx].label = document.getElementById('edit-label').value.trim();
        projects[idx].description = document.getElementById('edit-description').value.trim();
        projects[idx].start_date = document.getElementById('edit-start').value.trim();
        projects[idx].deadline = document.getElementById('edit-deadline').value.trim();
        projects[idx].price = document.getElementById('edit-price').value.trim();
        projects[idx].progress = Number(document.getElementById('edit-progress').value) || 0;
        projects[idx].status = document.getElementById('edit-status').value;

        const fIdx = filtered.findIndex(x => Number(x.id) === id);
        if (fIdx !== -1) filtered[fIdx] = { ...projects[idx] };

        editModal.hide();
        updateView();
    });

    // ADD PROJECT MODAL
    const addModalEl = document.getElementById('addProjectModal');
    const addModal = addModalEl ? new bootstrap.Modal(addModalEl) : null;
    const addForm = document.getElementById('addProjectForm');

    const addBtn = document.querySelector('.btn.btn-primary.btn-sm');

    if (addBtn && addModal && addForm) {
        addBtn.addEventListener('click', () => {
            addForm.reset();
            addForm.classList.remove('was-validated');
            addModal.show();
        });

        document.getElementById('saveProjectBtn')?.addEventListener('click', () => {
            addForm.classList.add('was-validated');

            if (!addForm.checkValidity()) return;

            const newProject = {
                id: Date.now(),
                title: document.getElementById('add-title').value.trim(),
                project_type: document.getElementById('add-type').value,
                label: document.getElementById('add-label').value.trim(),
                description: document.getElementById('add-description').value.trim(),
                start_date: document.getElementById('add-start').value,
                deadline: document.getElementById('add-deadline').value,
                price: document.getElementById('add-price').value.trim(),
                progress: parseInt(document.getElementById('add-progress').value, 10) || 0,
                status: document.getElementById('add-status').value,
                client: document.getElementById('add-client').value.trim(),
            };

            projects.push(newProject);
            filtered = [...projects];
            updateView();

            addModal.hide();
            addForm.reset();
            addForm.classList.remove('was-validated');

            alert('✅ Project added successfully!');
        });
    }

    // MANAGE LABELS + IMPORT PROJECTS
    const manageLabelsModal = new bootstrap.Modal(document.getElementById('manageLabelsModal'));
    const importProjectsModal = new bootstrap.Modal(document.getElementById('importProjectsModal'));

    const manageLabelsBtn = document.querySelector('i.fa-tags')?.closest('button');
    const importProjectsBtn = document.querySelector('i.fa-file-import')?.closest('button');

    manageLabelsBtn?.addEventListener('click', () => manageLabelsModal.show());
    importProjectsBtn?.addEventListener('click', () => importProjectsModal.show());

    document.getElementById('importProjectsBtn')?.addEventListener('click', () => {
        const fileInput = document.getElementById('importFile');
        const file = fileInput.files[0];

        if (!file) {
            alert('⚠️ Please select a file first.');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                let data;

                if (file.name.endsWith('.json')) {
                    data = JSON.parse(e.target.result);
                } else {
                    const lines = e.target.result.split('\n').filter(l => l.trim());
                    const [headers, ...rows] = lines.map(l => l.split(','));

                    data = rows.map(r => Object.fromEntries(
                        headers.map((h, i) => [h.trim(), r[i]?.trim()])
                    ));
                }

                if (Array.isArray(data)) {
                    projects.push(...data);
                    filtered = [...projects];
                    updateView();
                }

                importProjectsModal.hide();
                fileInput.value = '';
                alert('✅ Projects imported successfully!');

            } catch (err) {
                console.error(err);
                alert('❌ Invalid file format.');
            }
        };

        reader.readAsText(file);
    });

    loadProjects();

});
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
document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================================
       1. GLOBAL VARIABLES
    ========================================================== */
    let tasksData = [];
    let filteredData = [];

    /* ==========================================================
       2. FETCH DATA FROM PHP
    ========================================================== */
    fetch('tasks_json.php')
        .then(response => response.json())
        .then(data => {
            tasksData = data;
            filteredData = data;
            renderTable(data);
            renderKanban();
        });

    /* ==========================================================
       3. RENDER TASK TABLE
    ========================================================== */
    function renderTable(data) {
        const tbody = document.getElementById('tasks-body');
        tbody.innerHTML = "";

        data.forEach(task => {
            const row = document.createElement('tr');
            row.setAttribute("data-id", task.id);

            row.innerHTML = `
                <td>${task.id}</td>
                <td>
                    <span class="text-primary taskTitleClick" 
                        style="cursor:pointer;" 
                        data-id="${task.id}">
                        ${task.title}
                    </span>
                </td>
                <td>${task.start_date}</td>
                <td>${task.deadline}</td>
                <td>${task.milestone}</td>
                <td>${task.related_to}</td>
                <td><img src="https://via.placeholder.com/30" class="rounded-circle me-2">${task.assigned_to}</td>
                <td>${task.collaborators}</td>
                <td>${task.status}</td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm editBtn"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-outline-secondary btn-sm deleteBtn"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });

        attachEvents();
    }

    /* ==========================================================
       4. ATTACH BUTTON + TITLE EVENTS
    ========================================================== */
    function attachEvents() {

        /* ---------- DELETE BUTTON ---------- */
        document.querySelectorAll(".deleteBtn").forEach(btn => {
            btn.onclick = function () {
                const row = this.closest("tr");
                const id = row.getAttribute("data-id");

                if (confirm("Are you sure you want to delete this task?")) {
                    tasksData = tasksData.filter(t => t.id != id);
                    filteredData = filteredData.filter(t => t.id != id);

                    row.remove();
                    renderKanban();
                }
            };
        });

        /* ---------- EDIT BUTTON ---------- */
        document.querySelectorAll(".editBtn").forEach(btn => {
            btn.onclick = function () {
                const row = this.closest("tr");
                const id = row.getAttribute("data-id");
                const task = tasksData.find(t => t.id == id);

                document.getElementById("editId").value = task.id;
                document.getElementById("editTitle").value = task.title;
                document.getElementById("editStatus").value = task.status;

                new bootstrap.Modal(document.getElementById("editModal")).show();
            };
        });

        /* ---------- TASK TITLE CLICK ---------- */
        document.querySelectorAll(".taskTitleClick").forEach(title => {
            title.onclick = function () {
                const id = this.getAttribute("data-id");
                openTaskModal(id);
            };
        });
    }

    /* ==========================================================
       4B. OPEN TASK MODAL (USED BY LIST & KANBAN)
    ========================================================== */
    function openTaskModal(id) {
        const task = tasksData.find(t => t.id == id);
        if (!task) return;

        document.getElementById("modalTaskTitle").innerText = task.title;
        document.getElementById("modalTaskDesc").innerText = task.title;
        document.getElementById("modalProjectName").innerText = task.title;
        document.getElementById("modalUserName").innerText = task.assigned_to;
        document.getElementById("modalUserImg").src = "https://via.placeholder.com/40";

        let badge = document.getElementById("modalStatusBadge");
        badge.innerText = task.status;
        badge.className = "badge";

        if (task.status === "To do") badge.classList.add("bg-secondary");
        if (task.status === "In progress") badge.classList.add("bg-info");
        if (task.status === "Review") badge.classList.add("bg-warning");
        if (task.status === "Done") badge.classList.add("bg-success");

        new bootstrap.Modal(document.getElementById("taskModal")).show();
    }

    /* ==========================================================
       5. SAVE EDIT CHANGES
    ========================================================== */
    window.saveEdit = function () {
        const id = document.getElementById("editId").value;
        const title = document.getElementById("editTitle").value;
        const status = document.getElementById("editStatus").value;

        tasksData = tasksData.map(t =>
            t.id == id ? { ...t, title: title, status: status } : t
        );

        filteredData = tasksData;
        renderTable(filteredData);
        renderKanban();

        bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
    };

    /* ==========================================================
       6. SEARCH FUNCTION
    ========================================================== */
    document.querySelector("#taskSearch")?.addEventListener("keyup", function () {
        const value = this.value.toLowerCase();

        filteredData = tasksData.filter(task =>
            task.title.toLowerCase().includes(value) ||
            task.id.toString().includes(value)
        );

        renderTable(filteredData);
        renderKanban();
    });

    /* ==========================================================
       7. FILTER FUNCTION
    ========================================================== */
    function applyFilter(type) {
        if (type === "All") filteredData = tasksData;
        else filteredData = tasksData.filter(task =>
            task.status.toLowerCase() === type.toLowerCase()
        );

        renderTable(filteredData);
        renderKanban();
    }

    /* ==========================================================
       8. EXPORT CSV
    ========================================================== */
    document.getElementById("excelBtn")?.addEventListener("click", function () {
        let csvContent =
            "ID,Title,Start Date,Deadline,Milestone,Related To,Assigned To,Collaborators,Status\n";

        filteredData.forEach(t => {
            csvContent += `${t.id},${t.title},${t.start_date},${t.deadline},${t.milestone},${t.related_to},${t.assigned_to},${t.collaborators},${t.status}\n`;
        });

        const blob = new Blob([csvContent], { type: "text/csv" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "tasks_export.csv";
        a.click();
    });

    /* ==========================================================
       9. PRINT TABLE
    ========================================================== */
    document.getElementById("printBtn")?.addEventListener("click", function () {
        const printWindow = window.open("", "_blank");
        printWindow.document.write("<html><head><title>Print Tasks</title></head><body>");
        printWindow.document.write(document.querySelector("table").outerHTML);
        printWindow.document.write("</body></html>");
        printWindow.document.close();
        printWindow.print();
    });

    /* ==========================================================
       10. RENDER KANBAN BOARD
    ========================================================== */
    function renderKanban() {
        const todo = document.getElementById("kanbanTodo");
        const progress = document.getElementById("kanbanInProgress");
        const review = document.getElementById("kanbanReview");
        const done = document.getElementById("kanbanDone");

        if (!todo) return;

        todo.innerHTML = "";
        progress.innerHTML = "";
        review.innerHTML = "";
        done.innerHTML = "";

        filteredData.forEach(task => {
            const card = `
                <div class="p-2 mb-2 border rounded bg-light kanbanCard"
                     data-id="${task.id}"
                     style="cursor:pointer;">
                    <div class="fw-semibold">${task.id}. ${task.title}</div>
                    <div class="small text-muted">📅 ${task.deadline}</div>
                </div>
            `;

            if (task.status === "To do") todo.innerHTML += card;
            if (task.status === "In progress") progress.innerHTML += card;
            if (task.status === "Review") review.innerHTML += card;
            if (task.status === "Done") done.innerHTML += card;
        });

        attachKanbanEvents(); // ⭐ REQUIRED
    }

    /* ==========================================================
       10B. KANBAN CARD CLICK EVENT
    ========================================================== */
    function attachKanbanEvents() {
        document.querySelectorAll(".kanbanCard").forEach(card => {
            card.onclick = function () {
                const id = this.getAttribute("data-id");
                openTaskModal(id);
            };
        });
    }

    /* ==========================================================
       11. VIEW SWITCH
    ========================================================== */
    window.showList = function () {
        document.getElementById("listSection").classList.remove("d-none");
        document.getElementById("kanbanSection").classList.add("d-none");
    };

    window.showKanban = function () {
        document.getElementById("kanbanSection").classList.remove("d-none");
        document.getElementById("listSection").classList.add("d-none");
        renderKanban();
    };

}); // END DOMContentLoaded
let leads = [];
let allLeads = [];

const CURRENT_USER = "John Doe";

async function loadLeads() {
    const saved = localStorage.getItem("leads");
    if (saved) {
        leads = JSON.parse(saved);
        allLeads = leads;
        renderAll();
        return;
    }

    const res = await fetch("leads-json.php");
    leads = await res.json();
    allLeads = leads;

    localStorage.setItem("leads", JSON.stringify(leads));
    renderAll();
}

function renderAll() {
    renderList();
    renderKanban();
}

function renderList() {
    const table = document.getElementById("leadsTable");
    table.innerHTML = "";

    leads.forEach(l => {
        table.innerHTML += `
        <tr>
            <td onclick="openClient(${l.id})">
                <a href="Client-View.php?id=${l.id}"
                class="text-decoration-none text-primary fw-semibold"
                onclick="event.stopPropagation()">
                    ${l.name}
                </a>
            </td>

            <td onclick="openClient(${l.id})">
                <a href="Client-Contact.php?id=${l.id}"
                class="text-primary text-decoration-none fw-semibold"
                onclick="event.stopPropagation()">
                    ${l.contact}
                </a>
            </td>

            <td>${l.phone}</td>
            <td>${l.owner}</td>
            <td>${l.label}</td>
            <td>${l.created}</td>
            <td>${l.status}</td>

            <td>
                <button class="btn btn-sm btn-danger" onclick="deleteLead(${l.id})">
                    Delete
                </button>
            </td>
        </tr>`;
    });
}

function renderKanban() {
    const board = document.getElementById("kanbanBoard");
    board.innerHTML = "";

    const stages = ["New", "Qualified", "Discussion"];

    stages.forEach(stage => {
        const safeId = stage.replace(/\s+/g, '');

        const col = document.createElement("div");
        col.classList.add("col-md-4");
        col.innerHTML = `
            <h5>${stage}</h5>
            <div id="col-${safeId}" class="border rounded p-2"></div>
        `;
        board.appendChild(col);
    });

    leads.forEach(l => {
        const safeStatus = l.status.replace(/\s+/g, '');

        const colBox = document.getElementById(`col-${safeStatus}`);
        if (!colBox) return;

        colBox.innerHTML += `
    <div class="p-3 mb-3 bg-white border rounded"
         style="cursor:pointer;"
         onclick="openLeadPage(${l.id})">

        <div class="d-flex align-items-center gap-2">
            <img src="assets/images/users/avatar-6.jpg"
                 width="32" height="32"
                 class="rounded-circle" alt="">
            <b>${l.name}</b>
        </div>

        <small>${l.contact}</small><br>
        <span class="badge bg-info">${l.label}</span>
    </div>
`;
    });
}

function openLeadPage(id) {
    window.location.href = "Client-View.php?id=" + id;
}

document.querySelectorAll(".filter-option, .quick-filter").forEach(btn => {
    btn.addEventListener("click", () => {
        applyFilter(btn.dataset.filter);
    });
});

function applyFilter(f) {
    if (f === "all") leads = allLeads;
    else if (f === "50") leads = allLeads.filter(l => l.label.includes("50"));
    else if (f === "90") leads = allLeads.filter(l => l.label.includes("90"));
    else if (f === "call") leads = allLeads.filter(l => l.label.toLowerCase().includes("call"));
    else if (f === "mine") leads = allLeads.filter(l => l.owner === CURRENT_USER);

    renderAll();
}

// ---------------- FIXED ADD LEAD (Success Modal + List Tab) ----------------
function addLead() {
    const obj = {
        id: Date.now(),
        name: document.getElementById("leadName").value,
        contact: document.getElementById("leadContact").value,
        phone: document.getElementById("leadPhone").value,
        owner: document.getElementById("leadOwner").value,
        label: document.getElementById("leadLabel").value,
        created: new Date().toISOString().split("T")[0],
        status: document.getElementById("leadStatus").value
    };

    allLeads.push(obj);
    leads = allLeads;

    localStorage.setItem("leads", JSON.stringify(allLeads));
    renderAll();

    const addModal = bootstrap.Modal.getInstance(document.getElementById("addLeadModal"));
    addModal.hide();

    setTimeout(() => {
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";
        document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());
    }, 180);

    setTimeout(() => {
        new bootstrap.Modal(document.getElementById("successModal")).show();
    }, 250);
}

// ---------------- SUCCESS MODAL OK → CLOSE + OPEN LIST TAB ----------------
document.getElementById("successOkBtn")?.addEventListener("click", () => {

    const successModal = bootstrap.Modal.getInstance(document.getElementById("successModal"));
    successModal.hide();

    setTimeout(() => {
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";

        // 🔥 FIX: Remove ALL leftover backdrops so NO BLUR appears
        document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());

    }, 150);

    const listTab = document.querySelector('a[href="#listTab"]');
    const tab = new bootstrap.Tab(listTab);
    tab.show();
});

function deleteLead(id) {
    allLeads = allLeads.filter(l => l.id !== id);
    leads = allLeads;

    localStorage.setItem("leads", JSON.stringify(allLeads));
    renderAll();
}

loadLeads();

// -------------------- EXCEL --------------------
const excelBtn = Array.from(document.querySelectorAll("button.btn-outline-secondary"))
    .find(btn => btn.textContent.trim().toLowerCase() === "excel");

if (excelBtn) {
    excelBtn.addEventListener("click", () => {
        let csv = "Name,Primary Contact,Phone,Owner,Label,Created,Status\n";

        allLeads.forEach(l => {
            csv += `${l.name},${l.contact},${l.phone},${l.owner},${l.label},${l.created},${l.status}\n`;
        });

        const blob = new Blob([csv], { type: "text/csv" });
        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "leads.csv";
        a.click();
    });
}

// -------------------- PRINT --------------------
const printBtn = Array.from(document.querySelectorAll("button.btn-outline-secondary"))
    .find(btn => btn.textContent.trim().toLowerCase() === "print");

if (printBtn) {
    printBtn.addEventListener("click", () => {
        window.print();
    });
}


// -------------------- REFRESH BUTTON --------------------
const refreshBtn = Array.from(document.querySelectorAll("button.btn-outline-secondary"))
    .find(btn => btn.querySelector(".bi-arrow-clockwise"));

if (refreshBtn) {
    refreshBtn.addEventListener("click", () => {
        location.reload();
    });
}
// subscription.js
document.addEventListener("DOMContentLoaded", function () {
    fetch("subscription_json.php")
        .then(response => response.json())
        .then(data => renderTable(data));

    // -------------------------------
    //  ADDED: Manage Labels Modal Script
    // -------------------------------
    const addLabelBtn = document.getElementById("addLabelBtn");
    const labelsList = document.getElementById("labelsList");
    const labelInput = document.getElementById("labelInput");

    if (addLabelBtn) {   // Prevent error if modal not loaded yet
        addLabelBtn.addEventListener("click", function () {

            const labelText = labelInput.value.trim();
            if (labelText === "") return;

            const li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                ${labelText}
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            `;

            labelsList.appendChild(li);
            labelInput.value = "";
        });
    }
    // -------------------------------
    // END ADDED CODE
    // -------------------------------


    // -------------------------------
    // UPLOAD FILE FUNCTION
    // -------------------------------
    const uploadBtn = document.getElementById("btnUploadFile");
    const fileInput = document.getElementById("subFile");

    if (uploadBtn) {
        uploadBtn.addEventListener("click", function () {
            fileInput.click();
        });

        fileInput.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                alert("File selected: " + fileInput.files[0].name);
            }
        });
    }

    // -------------------------------
    // SAVE SUBSCRIPTION FUNCTION
    // -------------------------------
    const saveBtn = document.getElementById("btnSaveSubscription");

    if (saveBtn) {
        saveBtn.addEventListener("click", function () {

            // Collect data
            let title = document.getElementById("subTitle").value.trim();
            let firstBilling = document.getElementById("subFirstBilling").value;
            let client = document.getElementById("subClient").value;

            // Validation
            if (title === "") {
                alert("Title is required.");
                return;
            }
            if (firstBilling === "") {
                alert("First billing date is required.");
                return;
            }

            // Auto-generate next subscription ID
            let nextId = "SUBSCRIPTION #" + (document.querySelectorAll("#subscription-body tr").length + 1);

            // Prepare new row HTML
            let newRow = `
                <tr>
                    <td><a href="subscription_view.php?id=${encodeURIComponent(nextId)}" class="text-primary text-decoration-none">${nextId}</a></td>
                    <td><a href="subscription_view.php?id=${encodeURIComponent(nextId)}" class="text-primary text-decoration-none">${title}</a></td>
                    <td><span class="badge bg-warning text-dark">App</span></td>
                    <td>${client}</td>
                    <td>${firstBilling}</td>
                    <td>-</td>
                    <td>1 Month(s)</td>
                    <td>0/∞</td>
                    <td><span class="badge bg-primary">Active</span></td>
                    <td>$00.00</td>
                </tr>
            `;

            // Add row to table
            document.getElementById("subscription-body").insertAdjacentHTML("beforeend", newRow);

            // Update total
            let totalAmount = document.getElementById("totalAmount");
            let oldTotal = parseFloat(totalAmount.textContent.replace("$", ""));
            let newTotal = oldTotal + 0;
            totalAmount.textContent = "$" + newTotal.toFixed(2);

            // Close modal
            const modal = bootstrap.Modal.getInstance(
                document.getElementById("addSubscriptionModal")
            );
            modal.hide();

            // Success message
            alert("Subscription added successfully!");
        });
    }

});   // ✅ THIS FIXES YOUR FREEZE BUG — DOMContentLoaded CLOSED PROPERLY!



/* ------------------------------------------------
   renderTable MUST BE OUTSIDE DOMContentLoaded
   (This was causing the fade / backdrop issue!)
--------------------------------------------------*/
function renderTable(data) {
    const tbody = document.getElementById("subscription-body");
    const totalAmount = document.getElementById("totalAmount");
    let html = "";
    let sum = 0;

    data.forEach(item => {
        sum += parseFloat(item.amount);
        html += `
            <tr>
                <td><a href="subscription_view.php" class="text-primary text-decoration-none">${item.subscription_id}</a></td>
                <td><a href="subscription_view.php" class="text-primary text-decoration-none">${item.title}</a></td>
                <td><span class="badge bg-warning text-dark">App</span></td>
                <td>${item.client}</td>
                <td>${item.first_billing_date}</td>
                <td>${item.next_billing_date}</td>
                <td>${item.repeat_every}</td>
                <td>${item.cycles}</td>
                <td><span class="badge bg-primary">Active</span></td>
                <td>$${item.amount}</td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    totalAmount.innerHTML = `$${sum.toFixed(2)}`;
}
// ----------------------------------------------------
// SEARCH FUNCTION
// ----------------------------------------------------
const searchInput = document.getElementById("searchInput");
if (searchInput) {
    searchInput.addEventListener("keyup", function () {
        let filter = searchInput.value.toLowerCase();
        let rows = document.querySelectorAll("#subscription-body tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
}


// ----------------------------------------------------
// PRINT FUNCTION
// ----------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {

  const printBtn = document.getElementById("btnPrint");
  if (!printBtn) return;

  printBtn.addEventListener("click", () => {

    const table = document.getElementById("subscriptionsTable");
    if (!table) {
      console.warn("❌ subscriptionsTable not found");
      return;
    }

    const printWindow = window.open("", "_blank", "width=900,height=600");

    printWindow.document.write(`
      <html>
      <head>
        <title>Print Subscriptions</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          body { padding: 20px; }
          h3 { text-align: center; margin-bottom: 20px; }
        </style>
      </head>
      <body>
        <h3>Subscriptions</h3>
        ${table.outerHTML}
      </body>
      </html>
    `);

    printWindow.document.close();

    printWindow.onload = () => {
      printWindow.focus();
      printWindow.print();
    };

  });

});
document.addEventListener("DOMContentLoaded", () => {

  let invoicesData = [];
  let filteredData = [];
  let currentType = "invoice";
  let activeFilter = "all";
  let currentPage = 1;
  let pageSize = 10;
  let editingId = null; // <-- track when editing

  const invoiceBody = document.getElementById("invoiceBody");
  const totalInvoicedEl = document.getElementById("totalInvoiced");
  const totalReceivedEl = document.getElementById("totalReceived");
  const totalDueEl = document.getElementById("totalDue");
  const searchInput = document.getElementById("searchInput");
  const searchClear = document.getElementById("searchClear");
  const creditNotesBtn = document.getElementById("creditNotesBtn");
  const invoicesToggleBtn = document.getElementById("invoicesToggleBtn");
  const alertsBtn = document.getElementById("alertsBtn");

  const paginationNumbers = document.getElementById("paginationNumbers");
  const pageSizeDropdown = document.getElementById("pageSize");
  const pageInfo = document.getElementById("pageInfo");

  const invoiceModal = new bootstrap.Modal(document.getElementById("invoiceModal"));
  const paymentModal = new bootstrap.Modal(document.getElementById("paymentModal"));

  // SAFELY ensure listTab exists by wrapping the existing table if necessary
  (function ensureListTab() {
    if (!document.getElementById("listTab")) {
      const tableResponsive = document.getElementById("invoicesTable")?.closest(".table-responsive");
      if (tableResponsive) {
        const wrapper = document.createElement("div");
        wrapper.id = "listTab";
        // move the tableResponsive into wrapper
        tableResponsive.parentElement.insertBefore(wrapper, tableResponsive);
        wrapper.appendChild(tableResponsive);
      }
    }
  })();

  // Fetch Data
  fetch("invoices_json.php")
    .then(r => r.json())
    .then(data => {
      // normalize data (ensure numeric fields and default props)
      invoicesData = (data || []).map(d => ({
        id: String(d.id || "").trim(),
        type: d.type || "invoice",
        client: d.client || "",
        project: d.project || "",
        bill_date: d.bill_date || null,
        due_date: d.due_date || null,
        total: Number(d.total || 0),
        received: Number(d.received || 0),
        due: Number(d.due || (Number(d.total || 0) - Number(d.received || 0))),
        status: d.status || "-",
        // optional recurring fields (may be missing)
        recurring: !!d.recurring,
        next_recurring: d.next_recurring || null,
        repeat_every: d.repeat_every || null,
        cycles: d.cycles || null
      }));

      applyAllFiltersAndRender();
      fillPaymentInvoiceSelect();
      updateAlertCount();
    })
    .catch(err => {
      console.error("Failed to load invoices_json.php:", err);
      // keep UI usable
    });

  // RENDER INVOICES
  function renderInvoices(data) {
    invoiceBody.innerHTML = "";
    data.forEach(inv => {
      const billText = inv.bill_date ? formatDate(inv.bill_date) : "-";
      const dueText = inv.due_date ? formatDate(inv.due_date) : "-";
      const statusHtml = getStatusBadge(inv.status);

      invoiceBody.insertAdjacentHTML("beforeend", `
        <tr data-id="${escapeHtml(inv.id)}">

          <!-- CLICKABLE BLUE INVOICE ID (no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary fw-semibold text-decoration-none btn-view-invoice" data-id="${escapeHtml(inv.id)}">
              ${escapeHtml(inv.id)}
            </button>
          </td>

          <!-- CLIENT (clickable, blue, no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary text-decoration-none btn-view-client" data-id="${escapeHtml(inv.id)}" data-client="${escapeHtml(inv.client)}">
              ${escapeHtml(inv.client)}
            </button>
          </td>

          <!-- PROJECT (clickable, blue, no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary text-decoration-none btn-view-project" data-id="${escapeHtml(inv.id)}" data-project="${escapeHtml(inv.project)}">
              ${escapeHtml(inv.project)}
            </button>
          </td>

          <td>${billText}</td>
          <td>${dueText}</td>
          <td class="text-end">${money(inv.total)}</td>
          <td class="text-end">${money(inv.received)}</td>
          <td class="text-end">${money(inv.due)}</td>
          <td>${statusHtml}</td>

          <td class="text-end">
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">

                <li><button class="dropdown-item btn-edit" data-id="${escapeHtml(inv.id)}">Edit</button></li>
                <li><button class="dropdown-item btn-delete" data-id="${escapeHtml(inv.id)}">Delete</button></li>
                <li><button class="dropdown-item btn-add-payment" data-id="${escapeHtml(inv.id)}">Add Payment</button></li>

              </ul>
            </div>
          </td>
        </tr>
      `);
    });
  }

  function getStatusBadge(status) {
    if (!status || status === "-") return "-";
    if (status === "Overdue") return `<span class="badge bg-danger">${escapeHtml(status)}</span>`;
    if (status === "Fully paid") return `<span class="badge bg-primary">${escapeHtml(status)}</span>`;
    if (status === "Not paid") return `<span class="badge bg-warning text-dark">${escapeHtml(status)}</span>`;
    return `<span class="badge bg-secondary">${escapeHtml(status)}</span>`;
  }

  // UTILITIES
  function money(n) {
    return `$${Number(n).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}`;
  }
  function formatDate(v) {
    if (!v) return "-";
    const d = new Date(v);
    if (isNaN(d)) return v;
    return `${String(d.getDate()).padStart(2,"0")}-${String(d.getMonth()+1).padStart(2,"0")}-${d.getFullYear()}`;
  }
  function escapeHtml(s) {
    return String(s || "")
      .replaceAll("&","&amp;")
      .replaceAll("<","&lt;")
      .replaceAll(">","&gt;");
  }

  // TOTALS
  function calculateTotals(data) {
    let a = 0, b = 0, c = 0;
    data.forEach(i => {
      a += Number(i.total) || 0;
      b += Number(i.received) || 0;
      c += Number(i.due) || 0;
    });
    totalInvoicedEl.innerText = money(a);
    totalReceivedEl.innerText = money(b);
    totalDueEl.innerText = money(c);
  }

  // SEARCH
  searchInput.addEventListener("input", () => {
    currentPage = 1;
    applyAllFiltersAndRender();
  });

  searchClear.addEventListener("click", () => {
    searchInput.value = "";
    currentPage = 1;
    applyAllFiltersAndRender();
  });

  // FILTER DROPDOWN
  document.addEventListener("click", (e) => {
    const t = e.target;
    if (t.classList && t.classList.contains("filter-option")) {
      activeFilter = t.dataset.value;
      currentPage = 1;
      applyAllFiltersAndRender();
    }
  });

  // TYPE TOGGLE
  creditNotesBtn.addEventListener("click", () => {
    currentType = currentType === "credit" ? "all" : "credit";
    setToggleButtons();
    applyAllFiltersAndRender();
  });

  invoicesToggleBtn.addEventListener("click", () => {
    currentType = currentType === "invoice" ? "all" : "invoice";
    setToggleButtons();
    applyAllFiltersAndRender();
  });

  function setToggleButtons() {
    creditNotesBtn.classList.toggle("active", currentType === "credit");
    invoicesToggleBtn.classList.toggle("active", currentType === "invoice");
  }

  // APPLY FILTERS + PAGINATION
  function applyAllFiltersAndRender() {
    const q = searchInput.value.toLowerCase().trim();

    filteredData = invoicesData.filter(item => {

      if (currentType === "invoice" && item.type !== "invoice") return false;
      if (currentType === "credit" && item.type !== "credit") return false;

      if (activeFilter === "invoice" && item.type !== "invoice") return false;
      if (activeFilter === "overdue" && item.status !== "Overdue") return false;

      if (q) {
        const text = `${item.id} ${item.client} ${item.project} ${item.status}`.toLowerCase();
        if (!text.includes(q)) return false;
      }

      return true;
    });

    // if current page is out of range after filtering, reset to 1
    const totalPages = Math.max(1, Math.ceil(filteredData.length / pageSize));
    if (currentPage > totalPages) currentPage = 1;

    renderPaginatedData();
    calculateTotals(filteredData);
    updateAlertCount();
    fillPaymentInvoiceSelect(); // keep payment select up to date
  }

  // PAGINATION FUNCTIONS ------------------------------
  function renderPaginatedData() {
    pageSize = parseInt(pageSizeDropdown.value) || 10;

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;

    const currentItems = filteredData.slice(start, end);

    renderInvoices(currentItems);
    updatePageInfo();
    renderPaginationButtons();
  }

  function updatePageInfo() {
    const start = filteredData.length === 0 ? 0 : (currentPage - 1) * pageSize + 1;
    const end = Math.min(currentPage * pageSize, filteredData.length);

    pageInfo.innerText = `${start}–${end} / ${filteredData.length}`;
  }

  function renderPaginationButtons() {
    paginationNumbers.innerHTML = "";

    const totalPages = Math.ceil(filteredData.length / pageSize);
    if (totalPages < 1) return;

    paginationNumbers.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">
        <button class="page-link" data-page="${Math.max(1, currentPage - 1)}">&lsaquo;</button>
      </li>`
    );

    // show up to 7 pages (simple windowing)
    const maxButtons = 7;
    let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxButtons - 1);
    if (endPage - startPage < maxButtons - 1) {
      startPage = Math.max(1, endPage - maxButtons + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
      paginationNumbers.insertAdjacentHTML(
        "beforeend",
        `<li class="page-item ${i === currentPage ? "active" : ""}">
          <button class="page-link" data-page="${i}">${i}</button>
        </li>`
      );
    }

    paginationNumbers.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
        <button class="page-link" data-page="${Math.min(totalPages, currentPage + 1)}">&rsaquo;</button>
      </li>`
    );
  }

  paginationNumbers.addEventListener("click", (e) => {
    const btn = e.target.closest('button[data-page]');
    if (!btn) return;
    const page = parseInt(btn.dataset.page);
    if (!isNaN(page)) {
      currentPage = page;
      renderPaginatedData();
    }
  });

  pageSizeDropdown.addEventListener("change", () => {
    currentPage = 1;
    renderPaginatedData();
  });

  // EXPORT CSV
  document.getElementById("exportExcel").addEventListener("click", () => {
    const rows = [
      ["Invoice ID","Client","Project","Bill date","Due date","Total","Received","Due","Status"]
    ];

    filteredData.forEach(i => {
      rows.push([i.id, i.client, i.project, i.bill_date, i.due_date, i.total, i.received, i.due, i.status]);
    });

    const csvContent = rows.map(r => r.map(cell => `"${String(cell).replace(/"/g,'""')}"`).join(",")).join("\n");
    const blob = new Blob([csvContent], { type: "text/csv" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "invoices.csv";
    a.click();
    URL.revokeObjectURL(url);
  });

  // PRINT
  document.getElementById("printBtn").addEventListener("click", () => window.print());

  // ALERT BADGE
  function updateAlertCount() {
    const overdueCount = invoicesData.filter(i => i.status === "Overdue").length;
    alertsBtn.querySelectorAll(".badge").forEach(b => b.remove());

    if (overdueCount > 0) {
      const s = document.createElement("span");
      s.className = "badge bg-danger rounded-circle position-absolute";
      s.style.cssText = "transform: translate(60%, -40%); font-size: .6rem;";
      s.innerText = overdueCount;
      alertsBtn.style.position = "relative";
      alertsBtn.appendChild(s);
    }
  }

  // QUICK ADD
  document.getElementById("quickAddBtn").addEventListener("click", openAddInvoiceModal);
  document.getElementById("addInvoiceMainBtn").addEventListener("click", openAddInvoiceModal);

  function openAddInvoiceModal() {
    editingId = null;
    document.getElementById("invoiceModalTitle").innerText = "Add Invoice";
    document.getElementById("invoiceForm").reset();
    invoiceModal.show();
  }

  document.getElementById("saveInvoice").addEventListener("click", () => {
    const id = document.getElementById("formId").value.trim() || `INV #${Date.now()}`;
    const client = document.getElementById("formClient").value.trim();
    const project = document.getElementById("formProject").value.trim();
    const bill = document.getElementById("formBill").value;
    const due = document.getElementById("formDue").value;
    const totalVal = Number(document.getElementById("formTotal").value) || 0;
    const status = document.getElementById("formStatus").value;

    if (editingId) {
      // update existing invoice (based on editingId)
      const inv = invoicesData.find(x => x.id === editingId);
      if (inv) {
        inv.id = id;
        inv.client = client;
        inv.project = project;
        inv.bill_date = bill || null;
        inv.due_date = due || null;
        inv.total = totalVal;
        inv.received = Number(inv.received || 0); // keep received as-is
        inv.due = inv.total - inv.received;
        inv.status = status || inv.status;
      }
    } else {
      const invoice = {
        id, type: "invoice", client, project,
        bill_date: bill || null, due_date: due || null, total: totalVal,
        received: 0, due: totalVal, status: status || "-"
      };
      invoicesData.unshift(invoice);
    }

    editingId = null;
    currentPage = 1;
    applyAllFiltersAndRender();
    invoiceModal.hide();
  });

  // ADD PAYMENT
  document.getElementById("addPaymentBtn").addEventListener("click", () => {
    fillPaymentInvoiceSelect();
    paymentModal.show();
  });

  function fillPaymentInvoiceSelect() {
    const sel = document.getElementById("paymentInvoiceSelect");
    if (!sel) return;
    sel.innerHTML = "";
    // only include invoices (not credit notes) and show due > 0 first
    const sorted = invoicesData
      .filter(i => i.type === "invoice")
      .sort((a,b) => (b.due - a.due));
    if (sorted.length === 0) {
      sel.innerHTML = `<option value="">No invoices</option>`;
      return;
    }
    sorted.forEach(i => {
      sel.innerHTML += `<option value="${escapeHtml(i.id)}">${escapeHtml(i.id)} — ${escapeHtml(i.client)} (${money(i.due)})</option>`;
    });
  }

  document.getElementById("savePayment").addEventListener("click", () => {
    const id = document.getElementById("paymentInvoiceSelect").value;
    const amount = Number(document.getElementById("paymentAmount").value) || 0;

    const inv = invoicesData.find(x => x.id === id);
    if (!inv) {
      paymentModal.hide();
      return;
    }

    inv.received = Number(inv.received || 0) + amount;
    inv.due = Number(inv.total || 0) - inv.received;

    if (inv.due <= 0) inv.status = "Fully paid";
    else if (inv.due > 0 && inv.status === "Fully paid") inv.status = "Not paid";

    applyAllFiltersAndRender();
    paymentModal.hide();
  });

  // EDIT / DELETE / ADD PAYMENT inside dropdown + NEW CLICK NAVIGATION
  document.addEventListener("click", (e) => {

    const t = e.target;

    if (t.classList && t.classList.contains("btn-edit")) {
      const id = t.dataset.id;
      const inv = invoicesData.find(i => i.id === id);
      if (inv) {
        editingId = inv.id;
        document.getElementById("invoiceModalTitle").innerText = "Edit Invoice";

        document.getElementById("formId").value = inv.id;
        document.getElementById("formClient").value = inv.client;
        document.getElementById("formProject").value = inv.project;
        document.getElementById("formBill").value = inv.bill_date || "";
        document.getElementById("formDue").value = inv.due_date || "";
        document.getElementById("formTotal").value = inv.total || 0;
        document.getElementById("formStatus").value = inv.status || "-";

        invoiceModal.show();
      }
      return;
    }

    if (t.classList && t.classList.contains("btn-delete")) {
      const id = t.dataset.id;
      if (confirm("Are you sure you want to delete this invoice?")) {
        invoicesData = invoicesData.filter(i => i.id !== id);
        applyAllFiltersAndRender();
      }
      return;
    }

    if (t.classList && t.classList.contains("btn-add-payment")) {
      const id = t.dataset.id;
      document.getElementById("paymentInvoiceSelect").value = id;
      paymentModal.show();
      return;
    }

    // CLICKABLE INVOICE → OPEN PAGE
    if (t.classList && t.classList.contains("btn-view-invoice")) {
      const id = t.dataset.id;
      window.location.href = `invoice_view.php?id=${encodeURIComponent(id)}`;
      return;
    }

    // CLICKABLE CLIENT → OPEN PAGE
    if (t.classList && t.classList.contains("btn-view-client")) {
      const clientName = t.dataset.client;
      window.location.href = `Client-View.php?client=${encodeURIComponent(clientName)}`;
      return;
    }

    // CLICKABLE PROJECT → OPEN PAGE
    if (t.classList && t.classList.contains("btn-view-project")) {
      const projectName = t.dataset.project;
      window.location.href = `projects.php?project=${encodeURIComponent(projectName)}`;
      return;
    }

  });

  // =======================================================
  //            TAB SWITCHING (LIST <-> RECURRING)
  // =======================================================

  document.querySelectorAll('#invoiceTabs .nav-link').forEach(tab => {
    tab.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelectorAll('#invoiceTabs .nav-link').forEach(t => t.classList.remove("active"));
      this.classList.add("active");

      let target = this.getAttribute("data-tab");
      // hide both known targets first
      const listElem = document.getElementById("listTab");
      const recElem = document.getElementById("recurringTab");

      if (listElem) listElem.classList.add("d-none");
      if (recElem) recElem.classList.add("d-none");

      const targetEl = document.getElementById(target);
      if (targetEl) targetEl.classList.remove("d-none");

      if (target === "recurringTab") loadRecurringInvoices();
      else applyAllFiltersAndRender();
    });
  });

  // ensure list is shown initially
  document.getElementById("listTab")?.classList.remove("d-none");

  // =======================================================
  //              LOAD RECURRING INVOICES
  // =======================================================

  function loadRecurringInvoices() {
    // Use already-fetched invoicesData (no extra fetch) — fallback to empty
    const data = invoicesData || [];
    // filter recurring ones (expect invoice JSON to include recurring:true)
    const recurring = data.filter(item => item.recurring === true);

    const tbody = document.getElementById("recurringBody");
    if (!tbody) return;

    tbody.innerHTML = "";

    if (recurring.length === 0) {
      tbody.innerHTML = `<tr><td colspan="9" class="text-center text-muted py-4">No recurring invoices found</td></tr>`;
      document.getElementById("recurringTotal").innerText = money(0);
      return;
    }

    let total = 0;

    recurring.forEach(r => {
      total += Number(r.total) || 0;

      const nextRec = r.next_recurring ? formatDate(r.next_recurring) : "-";
      tbody.innerHTML += `
        <tr>
          <td class="text-primary">${escapeHtml(r.id)}</td>
          <td>${escapeHtml(r.client)}</td>
          <td>${escapeHtml(r.project)}</td>
          <td>${nextRec}</td>
          <td>${escapeHtml(r.repeat_every || "-")}</td>
          <td>${escapeHtml(r.cycles || "-")}</td>
          <td>${getStatusBadge(r.status)}</td>
          <td class="text-end">${money(r.total)}</td>
          <td>
              <button class="btn btn-light border rounded-circle">
                  <i class="bi bi-three-dots"></i>
              </button>
          </td>
        </tr>
      `;
    });

    document.getElementById("recurringTotal").innerText = money(total);
  }

  // Auto-load list tab first
  document.getElementById("listTab")?.classList.remove("d-none");

});


// ----------------------------------------------------
// EXCEL / CSV DOWNLOAD FUNCTION
// ----------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {

  const excelBtn = document.getElementById("btnExcel");
  if (!excelBtn) return; // 🛑 button nahi hai

  excelBtn.addEventListener("click", () => {

    const tbody = document.getElementById("subscription-body");
    if (!tbody) {
      console.warn("❌ subscription-body not found");
      return;
    }

    const table = tbody.closest("table");
    if (!table) {
      console.warn("❌ parent table not found");
      return;
    }

    const rows = table.querySelectorAll("tr");
    if (!rows.length) return;

    let csv = [];

    rows.forEach(row => {
      let cols = row.querySelectorAll("th, td");
      let rowData = [];

      cols.forEach(col => {
        let text = col.innerText.replace(/,/g, " "); // CSV safe
        rowData.push(`"${text}"`);
      });

      csv.push(rowData.join(","));
    });

    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const url = URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.download = "subscriptions.csv";
    link.click();

    URL.revokeObjectURL(url);
  });

});
document.addEventListener("DOMContentLoaded", () => {

  let invoicesData = [];
  let filteredData = [];
  let currentType = "invoice";
  let activeFilter = "all";
  let currentPage = 1;
  let pageSize = 10;
  let editingId = null; // <-- track when editing

  const invoiceBody = document.getElementById("invoiceBody");
  const totalInvoicedEl = document.getElementById("totalInvoiced");
  const totalReceivedEl = document.getElementById("totalReceived");
  const totalDueEl = document.getElementById("totalDue");
  const searchInput = document.getElementById("searchInput");
  const searchClear = document.getElementById("searchClear");
  const creditNotesBtn = document.getElementById("creditNotesBtn");
  const invoicesToggleBtn = document.getElementById("invoicesToggleBtn");
  const alertsBtn = document.getElementById("alertsBtn");

  const paginationNumbers = document.getElementById("paginationNumbers");
  const pageSizeDropdown = document.getElementById("pageSize");
  const pageInfo = document.getElementById("pageInfo");

  const invoiceModal = new bootstrap.Modal(document.getElementById("invoiceModal"));
  const paymentModal = new bootstrap.Modal(document.getElementById("paymentModal"));

  // SAFELY ensure listTab exists by wrapping the existing table if necessary
  (function ensureListTab() {
    if (!document.getElementById("listTab")) {
      const tableResponsive = document.getElementById("invoicesTable")?.closest(".table-responsive");
      if (tableResponsive) {
        const wrapper = document.createElement("div");
        wrapper.id = "listTab";
        // move the tableResponsive into wrapper
        tableResponsive.parentElement.insertBefore(wrapper, tableResponsive);
        wrapper.appendChild(tableResponsive);
      }
    }
  })();

  // Fetch Data
  fetch("invoices_json.php")
    .then(r => r.json())
    .then(data => {
      // normalize data (ensure numeric fields and default props)
      invoicesData = (data || []).map(d => ({
        id: String(d.id || "").trim(),
        type: d.type || "invoice",
        client: d.client || "",
        project: d.project || "",
        bill_date: d.bill_date || null,
        due_date: d.due_date || null,
        total: Number(d.total || 0),
        received: Number(d.received || 0),
        due: Number(d.due || (Number(d.total || 0) - Number(d.received || 0))),
        status: d.status || "-",
        // optional recurring fields (may be missing)
        recurring: !!d.recurring,
        next_recurring: d.next_recurring || null,
        repeat_every: d.repeat_every || null,
        cycles: d.cycles || null
      }));

      applyAllFiltersAndRender();
      fillPaymentInvoiceSelect();
      updateAlertCount();
    })
    .catch(err => {
      console.error("Failed to load invoices_json.php:", err);
      // keep UI usable
    });

  // RENDER INVOICES
  function renderInvoices(data) {
    invoiceBody.innerHTML = "";
    data.forEach(inv => {
      const billText = inv.bill_date ? formatDate(inv.bill_date) : "-";
      const dueText = inv.due_date ? formatDate(inv.due_date) : "-";
      const statusHtml = getStatusBadge(inv.status);

      invoiceBody.insertAdjacentHTML("beforeend", `
        <tr data-id="${escapeHtml(inv.id)}">

          <!-- CLICKABLE BLUE INVOICE ID (no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary fw-semibold text-decoration-none btn-view-invoice" data-id="${escapeHtml(inv.id)}">
              ${escapeHtml(inv.id)}
            </button>
          </td>

          <!-- CLIENT (clickable, blue, no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary text-decoration-none btn-view-client" data-id="${escapeHtml(inv.id)}" data-client="${escapeHtml(inv.client)}">
              ${escapeHtml(inv.client)}
            </button>
          </td>

          <!-- PROJECT (clickable, blue, no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary text-decoration-none btn-view-project" data-id="${escapeHtml(inv.id)}" data-project="${escapeHtml(inv.project)}">
              ${escapeHtml(inv.project)}
            </button>
          </td>

          <td>${billText}</td>
          <td>${dueText}</td>
          <td class="text-end">${money(inv.total)}</td>
          <td class="text-end">${money(inv.received)}</td>
          <td class="text-end">${money(inv.due)}</td>
          <td>${statusHtml}</td>

          <td class="text-end">
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">

                <li><button class="dropdown-item btn-edit" data-id="${escapeHtml(inv.id)}">Edit</button></li>
                <li><button class="dropdown-item btn-delete" data-id="${escapeHtml(inv.id)}">Delete</button></li>
                <li><button class="dropdown-item btn-add-payment" data-id="${escapeHtml(inv.id)}">Add Payment</button></li>

              </ul>
            </div>
          </td>
        </tr>
      `);
    });
  }

  function getStatusBadge(status) {
    if (!status || status === "-") return "-";
    if (status === "Overdue") return `<span class="badge bg-danger">${escapeHtml(status)}</span>`;
    if (status === "Fully paid") return `<span class="badge bg-primary">${escapeHtml(status)}</span>`;
    if (status === "Not paid") return `<span class="badge bg-warning text-dark">${escapeHtml(status)}</span>`;
    return `<span class="badge bg-secondary">${escapeHtml(status)}</span>`;
  }

  // UTILITIES
  function money(n) {
    return `$${Number(n).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}`;
  }
  function formatDate(v) {
    if (!v) return "-";
    const d = new Date(v);
    if (isNaN(d)) return v;
    return `${String(d.getDate()).padStart(2,"0")}-${String(d.getMonth()+1).padStart(2,"0")}-${d.getFullYear()}`;
  }
  function escapeHtml(s) {
    return String(s || "")
      .replaceAll("&","&amp;")
      .replaceAll("<","&lt;")
      .replaceAll(">","&gt;");
  }

  // TOTALS
  function calculateTotals(data) {
    let a = 0, b = 0, c = 0;
    data.forEach(i => {
      a += Number(i.total) || 0;
      b += Number(i.received) || 0;
      c += Number(i.due) || 0;
    });
    totalInvoicedEl.innerText = money(a);
    totalReceivedEl.innerText = money(b);
    totalDueEl.innerText = money(c);
  }

  // SEARCH
  searchInput.addEventListener("input", () => {
    currentPage = 1;
    applyAllFiltersAndRender();
  });

  searchClear.addEventListener("click", () => {
    searchInput.value = "";
    currentPage = 1;
    applyAllFiltersAndRender();
  });

  // FILTER DROPDOWN
  document.addEventListener("click", (e) => {
    const t = e.target;
    if (t.classList && t.classList.contains("filter-option")) {
      activeFilter = t.dataset.value;
      currentPage = 1;
      applyAllFiltersAndRender();
    }
  });

  // TYPE TOGGLE
  creditNotesBtn.addEventListener("click", () => {
    currentType = currentType === "credit" ? "all" : "credit";
    setToggleButtons();
    applyAllFiltersAndRender();
  });

  invoicesToggleBtn.addEventListener("click", () => {
    currentType = currentType === "invoice" ? "all" : "invoice";
    setToggleButtons();
    applyAllFiltersAndRender();
  });

  function setToggleButtons() {
    creditNotesBtn.classList.toggle("active", currentType === "credit");
    invoicesToggleBtn.classList.toggle("active", currentType === "invoice");
  }

  // APPLY FILTERS + PAGINATION
  function applyAllFiltersAndRender() {
    const q = searchInput.value.toLowerCase().trim();

    filteredData = invoicesData.filter(item => {

      if (currentType === "invoice" && item.type !== "invoice") return false;
      if (currentType === "credit" && item.type !== "credit") return false;

      if (activeFilter === "invoice" && item.type !== "invoice") return false;
      if (activeFilter === "overdue" && item.status !== "Overdue") return false;

      if (q) {
        const text = `${item.id} ${item.client} ${item.project} ${item.status}`.toLowerCase();
        if (!text.includes(q)) return false;
      }

      return true;
    });

    // if current page is out of range after filtering, reset to 1
    const totalPages = Math.max(1, Math.ceil(filteredData.length / pageSize));
    if (currentPage > totalPages) currentPage = 1;

    renderPaginatedData();
    calculateTotals(filteredData);
    updateAlertCount();
    fillPaymentInvoiceSelect(); // keep payment select up to date
  }

  // PAGINATION FUNCTIONS ------------------------------
  function renderPaginatedData() {
    pageSize = parseInt(pageSizeDropdown.value) || 10;

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;

    const currentItems = filteredData.slice(start, end);

    renderInvoices(currentItems);
    updatePageInfo();
    renderPaginationButtons();
  }

  function updatePageInfo() {
    const start = filteredData.length === 0 ? 0 : (currentPage - 1) * pageSize + 1;
    const end = Math.min(currentPage * pageSize, filteredData.length);

    pageInfo.innerText = `${start}–${end} / ${filteredData.length}`;
  }

  function renderPaginationButtons() {
    paginationNumbers.innerHTML = "";

    const totalPages = Math.ceil(filteredData.length / pageSize);
    if (totalPages < 1) return;

    paginationNumbers.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">
        <button class="page-link" data-page="${Math.max(1, currentPage - 1)}">&lsaquo;</button>
      </li>`
    );

    // show up to 7 pages (simple windowing)
    const maxButtons = 7;
    let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxButtons - 1);
    if (endPage - startPage < maxButtons - 1) {
      startPage = Math.max(1, endPage - maxButtons + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
      paginationNumbers.insertAdjacentHTML(
        "beforeend",
        `<li class="page-item ${i === currentPage ? "active" : ""}">
          <button class="page-link" data-page="${i}">${i}</button>
        </li>`
      );
    }

    paginationNumbers.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
        <button class="page-link" data-page="${Math.min(totalPages, currentPage + 1)}">&rsaquo;</button>
      </li>`
    );
  }

  paginationNumbers.addEventListener("click", (e) => {
    const btn = e.target.closest('button[data-page]');
    if (!btn) return;
    const page = parseInt(btn.dataset.page);
    if (!isNaN(page)) {
      currentPage = page;
      renderPaginatedData();
    }
  });

  pageSizeDropdown.addEventListener("change", () => {
    currentPage = 1;
    renderPaginatedData();
  });

  // EXPORT CSV
  document.getElementById("exportExcel").addEventListener("click", () => {
    const rows = [
      ["Invoice ID","Client","Project","Bill date","Due date","Total","Received","Due","Status"]
    ];

    filteredData.forEach(i => {
      rows.push([i.id, i.client, i.project, i.bill_date, i.due_date, i.total, i.received, i.due, i.status]);
    });

    const csvContent = rows.map(r => r.map(cell => `"${String(cell).replace(/"/g,'""')}"`).join(",")).join("\n");
    const blob = new Blob([csvContent], { type: "text/csv" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "invoices.csv";
    a.click();
    URL.revokeObjectURL(url);
  });

  // PRINT
  document.getElementById("printBtn").addEventListener("click", () => window.print());

  // ALERT BADGE
  function updateAlertCount() {
    const overdueCount = invoicesData.filter(i => i.status === "Overdue").length;
    alertsBtn.querySelectorAll(".badge").forEach(b => b.remove());

    if (overdueCount > 0) {
      const s = document.createElement("span");
      s.className = "badge bg-danger rounded-circle position-absolute";
      s.style.cssText = "transform: translate(60%, -40%); font-size: .6rem;";
      s.innerText = overdueCount;
      alertsBtn.style.position = "relative";
      alertsBtn.appendChild(s);
    }
  }

  // QUICK ADD
  document.getElementById("quickAddBtn").addEventListener("click", openAddInvoiceModal);
  document.getElementById("addInvoiceMainBtn").addEventListener("click", openAddInvoiceModal);

  function openAddInvoiceModal() {
    editingId = null;
    document.getElementById("invoiceModalTitle").innerText = "Add Invoice";
    document.getElementById("invoiceForm").reset();
    invoiceModal.show();
  }

  document.getElementById("saveInvoice").addEventListener("click", () => {
    const id = document.getElementById("formId").value.trim() || `INV #${Date.now()}`;
    const client = document.getElementById("formClient").value.trim();
    const project = document.getElementById("formProject").value.trim();
    const bill = document.getElementById("formBill").value;
    const due = document.getElementById("formDue").value;
    const totalVal = Number(document.getElementById("formTotal").value) || 0;
    const status = document.getElementById("formStatus").value;

    if (editingId) {
      // update existing invoice (based on editingId)
      const inv = invoicesData.find(x => x.id === editingId);
      if (inv) {
        inv.id = id;
        inv.client = client;
        inv.project = project;
        inv.bill_date = bill || null;
        inv.due_date = due || null;
        inv.total = totalVal;
        inv.received = Number(inv.received || 0); // keep received as-is
        inv.due = inv.total - inv.received;
        inv.status = status || inv.status;
      }
    } else {
      const invoice = {
        id, type: "invoice", client, project,
        bill_date: bill || null, due_date: due || null, total: totalVal,
        received: 0, due: totalVal, status: status || "-"
      };
      invoicesData.unshift(invoice);
    }

    editingId = null;
    currentPage = 1;
    applyAllFiltersAndRender();
    invoiceModal.hide();
  });

  // ADD PAYMENT
  document.getElementById("addPaymentBtn").addEventListener("click", () => {
    fillPaymentInvoiceSelect();
    paymentModal.show();
  });

  function fillPaymentInvoiceSelect() {
    const sel = document.getElementById("paymentInvoiceSelect");
    if (!sel) return;
    sel.innerHTML = "";
    // only include invoices (not credit notes) and show due > 0 first
    const sorted = invoicesData
      .filter(i => i.type === "invoice")
      .sort((a,b) => (b.due - a.due));
    if (sorted.length === 0) {
      sel.innerHTML = `<option value="">No invoices</option>`;
      return;
    }
    sorted.forEach(i => {
      sel.innerHTML += `<option value="${escapeHtml(i.id)}">${escapeHtml(i.id)} — ${escapeHtml(i.client)} (${money(i.due)})</option>`;
    });
  }

  document.getElementById("savePayment").addEventListener("click", () => {
    const id = document.getElementById("paymentInvoiceSelect").value;
    const amount = Number(document.getElementById("paymentAmount").value) || 0;

    const inv = invoicesData.find(x => x.id === id);
    if (!inv) {
      paymentModal.hide();
      return;
    }

    inv.received = Number(inv.received || 0) + amount;
    inv.due = Number(inv.total || 0) - inv.received;

    if (inv.due <= 0) inv.status = "Fully paid";
    else if (inv.due > 0 && inv.status === "Fully paid") inv.status = "Not paid";

    applyAllFiltersAndRender();
    paymentModal.hide();
  });

  // EDIT / DELETE / ADD PAYMENT inside dropdown + NEW CLICK NAVIGATION
  document.addEventListener("click", (e) => {

    const t = e.target;

    if (t.classList && t.classList.contains("btn-edit")) {
      const id = t.dataset.id;
      const inv = invoicesData.find(i => i.id === id);
      if (inv) {
        editingId = inv.id;
        document.getElementById("invoiceModalTitle").innerText = "Edit Invoice";

        document.getElementById("formId").value = inv.id;
        document.getElementById("formClient").value = inv.client;
        document.getElementById("formProject").value = inv.project;
        document.getElementById("formBill").value = inv.bill_date || "";
        document.getElementById("formDue").value = inv.due_date || "";
        document.getElementById("formTotal").value = inv.total || 0;
        document.getElementById("formStatus").value = inv.status || "-";

        invoiceModal.show();
      }
      return;
    }

    if (t.classList && t.classList.contains("btn-delete")) {
      const id = t.dataset.id;
      if (confirm("Are you sure you want to delete this invoice?")) {
        invoicesData = invoicesData.filter(i => i.id !== id);
        applyAllFiltersAndRender();
      }
      return;
    }

    if (t.classList && t.classList.contains("btn-add-payment")) {
      const id = t.dataset.id;
      document.getElementById("paymentInvoiceSelect").value = id;
      paymentModal.show();
      return;
    }

    // CLICKABLE INVOICE → OPEN PAGE
    if (t.classList && t.classList.contains("btn-view-invoice")) {
      const id = t.dataset.id;
      window.location.href = `invoice_view.php?id=${encodeURIComponent(id)}`;
      return;
    }

    // CLICKABLE CLIENT → OPEN PAGE
    if (t.classList && t.classList.contains("btn-view-client")) {
      const clientName = t.dataset.client;
      window.location.href = `Client-View.php?client=${encodeURIComponent(clientName)}`;
      return;
    }

    // CLICKABLE PROJECT → OPEN PAGE
    if (t.classList && t.classList.contains("btn-view-project")) {
      const projectName = t.dataset.project;
      window.location.href = `projects.php?project=${encodeURIComponent(projectName)}`;
      return;
    }

  });

  // =======================================================
  //            TAB SWITCHING (LIST <-> RECURRING)
  // =======================================================

  document.querySelectorAll('#invoiceTabs .nav-link').forEach(tab => {
    tab.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelectorAll('#invoiceTabs .nav-link').forEach(t => t.classList.remove("active"));
      this.classList.add("active");

      let target = this.getAttribute("data-tab");
      // hide both known targets first
      const listElem = document.getElementById("listTab");
      const recElem = document.getElementById("recurringTab");

      if (listElem) listElem.classList.add("d-none");
      if (recElem) recElem.classList.add("d-none");

      const targetEl = document.getElementById(target);
      if (targetEl) targetEl.classList.remove("d-none");

      if (target === "recurringTab") loadRecurringInvoices();
      else applyAllFiltersAndRender();
    });
  });

  // ensure list is shown initially
  document.getElementById("listTab")?.classList.remove("d-none");

  // =======================================================
  //              LOAD RECURRING INVOICES
  // =======================================================

  function loadRecurringInvoices() {
    // Use already-fetched invoicesData (no extra fetch) — fallback to empty
    const data = invoicesData || [];
    // filter recurring ones (expect invoice JSON to include recurring:true)
    const recurring = data.filter(item => item.recurring === true);

    const tbody = document.getElementById("recurringBody");
    if (!tbody) return;

    tbody.innerHTML = "";

    if (recurring.length === 0) {
      tbody.innerHTML = `<tr><td colspan="9" class="text-center text-muted py-4">No recurring invoices found</td></tr>`;
      document.getElementById("recurringTotal").innerText = money(0);
      return;
    }

    let total = 0;

    recurring.forEach(r => {
      total += Number(r.total) || 0;

      const nextRec = r.next_recurring ? formatDate(r.next_recurring) : "-";
      tbody.innerHTML += `
        <tr>
          <td class="text-primary">${escapeHtml(r.id)}</td>
          <td>${escapeHtml(r.client)}</td>
          <td>${escapeHtml(r.project)}</td>
          <td>${nextRec}</td>
          <td>${escapeHtml(r.repeat_every || "-")}</td>
          <td>${escapeHtml(r.cycles || "-")}</td>
          <td>${getStatusBadge(r.status)}</td>
          <td class="text-end">${money(r.total)}</td>
          <td>
              <button class="btn btn-light border rounded-circle">
                  <i class="bi bi-three-dots"></i>
              </button>
          </td>
        </tr>
      `;
    });

    document.getElementById("recurringTotal").innerText = money(total);
  }

  // Auto-load list tab first
  document.getElementById("listTab")?.classList.remove("d-none");

});
let items = [
    { title: "Custom app development", desc: "App for your business", qty: 2, rate: 1000 }
];

// let payments = [];
let tasks = [];

// ------------------------ ITEMS FUNCTIONS -------------------------

function renderItems() {
    let tbody = document.getElementById("itemRows");
    tbody.innerHTML = "";

    items.forEach((it, index) => {
        let total = it.qty * it.rate;
        tbody.innerHTML += `
            <tr>
                <td><div class="fw-semibold">${it.title}</div><div class="text-muted small">${it.desc}</div></td>
                <td>${it.qty}</td>
                <td>$${it.rate.toFixed(2)}</td>
                <td>$${total.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary" onclick="editItem(${index})"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="deleteItem(${index})"><i class="bi bi-x-lg"></i></button>
                </td>
            </tr>
        `;
    });

    calculateTotals();
}

function calculateTotals() {
    let sub = items.reduce((a, b) => a + (b.qty * b.rate), 0);
    let paid = payments.reduce((a, b) => a + b.amount, 0);

    document.getElementById("subTotal").innerText = "$" + sub.toFixed(2);
    document.getElementById("balanceDue").innerText = "$" + (sub - paid).toFixed(2);
}

document.getElementById("saveNewItem").addEventListener("click", () => {
    items.push({
        title: itemTitle.value,
        desc: itemDesc.value,
        qty: Number(itemQty.value),
        rate: Number(itemRate.value)
    });
    renderItems();

    itemTitle.value = "";
    itemDesc.value = "";
    itemQty.value = "";
    itemRate.value = "";
    bootstrap.Modal.getInstance(document.getElementById("addItemModal")).hide();
});

function deleteItem(i) {
    items.splice(i, 1);
    renderItems();
}

function editItem(i) {
    let it = items[i];
    let newTitle = prompt("Edit Title", it.title);
    if (!newTitle) return;
    items[i].title = newTitle;
    renderItems();
}

// ------------------------- PAYMENTS -------------------------

document.getElementById("savePaymentBtn").addEventListener("click", () => {

    let method = payMethod.value;
    let date = payDate.value;
    let amount = Number(payAmount.value);
    let note = payNote.value;
    let file = payFile.files.length > 0 ? payFile.files[0].name : "No file";

    let payment = { method, date, amount, note, file };
    payments.push(payment);

    updatePaymentUI();
    calculateTotals();

    paymentForm.reset();
    bootstrap.Modal.getInstance(document.getElementById("addPaymentModal")).hide();
});

function updatePaymentUI() {
    let list = document.getElementById("paymentList");
    list.innerHTML = "";

    payments.forEach((p, i) => {
        list.innerHTML += `
            <li class="d-flex justify-content-between border-bottom py-1">
                <div>
                    <b>${p.method}</b> - $${p.amount.toFixed(2)}<br>
                    <small>${p.date}</small><br>
                    <small>File: ${p.file}</small>
                </div>
                <button class="btn btn-sm btn-danger" onclick="removePayment(${i})">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
        `;
    });
}

function removePayment(i) {
    payments.splice(i, 1);
    updatePaymentUI();
    calculateTotals();
}

// ------------------------- TASKS -------------------------

document.getElementById("saveTask").addEventListener("click", () => {
    tasks.push(taskName.value);
    taskList.innerHTML += `<li>${taskName.value}</li>`;
    taskName.value = "";
    bootstrap.Modal.getInstance(document.getElementById("addTaskModal")).hide();
});

// ----------------------- PRINT / PREVIEW / PDF --------------------

const invoiceId = 26; // using fixed id for this demo

document.getElementById("previewBtn").addEventListener("click", () => {
    // open preview page in a new tab (user can close via Close Preview)
    window.open(`invoice_preview.php?id=${invoiceId}`, "_blank");
});

document.getElementById("printBtn").addEventListener("click", () => {
    // open preview and auto-call print
    window.open(`invoice_preview.php?id=${invoiceId}&print=1`, "_blank");
});

document.getElementById("viewPdfBtn").addEventListener("click", () => {
    // open preview in new tab (user can use print -> Save as PDF)
    window.open(`invoice_preview.php?id=${invoiceId}&pdf=1`, "_blank");
});

document.getElementById("downloadPdfBtn").addEventListener("click", () => {
    // open preview and auto-open print dialog (user will choose Save as PDF)
    window.open(`invoice_preview.php?id=${invoiceId}&download=1`, "_blank");
});

// MARK CANCELLED
function markCancelled() {
    if (!confirm("Mark this invoice as cancelled?")) return;
    document.getElementById("invoiceStatus").innerText = "Cancelled";
    document.getElementById("invoiceStatus").className = "badge bg-danger";
    alert("Invoice marked as cancelled");
}

// CLONE INVOICE (simple demo)
function cloneInvoice() {
    alert("Invoice cloned (demo). Implement server-side if needed.");
}

// ----------------------- PRINT BUTTON (main page fallback) ---------------------------
document.getElementById("emailInvoiceBtn").addEventListener("click", () => {
    alert("This will open your email composer in real app. (demo)");
});

// ----------------------- INITIAL LOAD ---------------------
renderItems();

// FIX FADE BUG
document.addEventListener("hidden.bs.modal", () => {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.paddingRight = "";
});

// -------------------- REMINDERS -----------------------

let reminders = [];

// Show form when clicking "Add reminder"
document.getElementById("openReminderFormBtn").addEventListener("click", () => {
    document.getElementById("reminderFormBox").classList.remove("d-none");
});

// Add reminder
document.getElementById("addReminderBtn").addEventListener("click", () => {

    let title = remTitle.value.trim();
    let date = remDate.value;
    let time = remTime.value;
    let repeat = remRepeat.checked ? "Yes" : "No";

    if (!title || !date || !time) {
        alert("Please fill all fields");
        return;
    }

    reminders.push({ title, date, time, repeat });
    updateRemindersUI();

    // reset form
    remTitle.value = "";
    remDate.value = "";
    remTime.value = "";
    remRepeat.checked = false;

    alert("Reminder added!");
});

// Display reminders
function updateRemindersUI() {
    let list = document.getElementById("reminderList");
    list.innerHTML = "";

    reminders.forEach((r, i) => {
        list.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <b>${r.title}</b><br>
                    <small>${r.date} — ${r.time}</small><br>
                    <small>Repeat: ${r.repeat}</small>
                </div>

                <button class="btn btn-sm btn-outline-danger" onclick="deleteReminder(${i})">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
        `;
    });
}

// Delete a reminder
function deleteReminder(i) {
    reminders.splice(i, 1);
    updateRemindersUI();
}

// ============================================================
//                EMAIL INVOICE MODAL LOGIC
// ============================================================

// OPEN MODAL
document.getElementById("emailInvoiceBtn").addEventListener("click", () => {
    new bootstrap.Modal(document.getElementById("emailInvoiceModal")).show();
});

// STEP ELEMENTS
const step1 = document.getElementById("emailStep1");
const step2 = document.getElementById("emailStep2");

// GO TO STEP 2
document.getElementById("goToStep2").addEventListener("click", () => {
    document.getElementById("confirmEmailTo").innerText = emailTo.value || "Not provided";
    document.getElementById("confirmEmailSubject").innerText = emailSubject.value || "No subject";
    document.getElementById("confirmAttach").innerText = attachPdf.checked ? "Yes" : "No";

    step1.classList.add("d-none");
    step2.classList.remove("d-none");
});

// BACK TO STEP 1
document.getElementById("backToStep1").addEventListener("click", () => {
    step2.classList.add("d-none");
    step1.classList.remove("d-none");
});

// SEND EMAIL
document.getElementById("sendEmailBtn").addEventListener("click", () => {
    alert("Invoice emailed successfully! (Demo)");
    bootstrap.Modal.getInstance(document.getElementById("emailInvoiceModal")).hide();

    // Reset to step 1 for next time
    step2.classList.add("d-none");
    step1.classList.remove("d-none");
});

// ----------------------- INITIAL LOAD ---------------------
renderItems();
(function () {

  const body = document.body;
  if (!body) return;

  const auto = body.dataset.autoPrint === "1";
  const download = body.dataset.download === "1";

  if (!auto) return;

  window.addEventListener("load", () => {
    setTimeout(() => {
      window.print();

      if (download) {
        setTimeout(() => window.close(), 500);
      }
    }, 400);
  });

})();


// ==================== PROJECTS MODULE ====================

// Load projects from localStorage
let projects = JSON.parse(localStorage.getItem("projectsList")) || [];
let deleteProjectId = null;

// Render Projects Table
function renderProjects() {
    const tbody = document.getElementById("projectsTableBody");

    // 🛑 PAGE GUARD — MOST IMPORTANT LINE
    if (!tbody) {
        console.warn("projectsTableBody not found — skipping renderProjects()");
        return;
    }

    tbody.innerHTML = "";

    if (!Array.isArray(projects) || projects.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="8" class="text-center text-muted">
              No projects found.
            </td>
          </tr>`;
        return;
    }

    projects.forEach(project => {
        tbody.insertAdjacentHTML("beforeend", `
          <tr>
            <td>${project.id}</td>
            <td>${project.title}</td>
            <td>${project.price || "-"}</td>
            <td>${project.start || "-"}</td>
            <td>${project.deadline || "-"}</td>
            <td>
              <div class="progress">
                <div class="progress-bar" style="width:${project.progress || 0}%"></div>
              </div>
            </td>
            <td>
              <span class="badge bg-${statusColor(project.status)}">
                ${project.status || "N/A"}
              </span>
            </td>
            <td>
              <button class="btn btn-sm btn-primary"
                onclick="openEditProject(${project.id})">Edit</button>
              <button class="btn btn-sm btn-danger"
                onclick="openDeleteProject(${project.id})">Delete</button>
            </td>
          </tr>
        `);
    });
}


function statusColor(status) {
    return {
        open: "info",
        completed: "success",
        hold: "warning",
        canceled: "danger"
    }[status] || "secondary";
}

// Save to localStorage
function saveProjects() {
    localStorage.setItem("projectsList", JSON.stringify(projects));
}

// ==================== ADD PROJECT ====================

on("saveProject", "click", function () {

    const id = document.getElementById("projectId")?.value;
    const title = document.getElementById("projectTitle")?.value;
    const price = document.getElementById("projectPrice")?.value;
    const start = document.getElementById("projectStartDate")?.value;
    const deadline = document.getElementById("projectDeadline")?.value;
    const status = document.getElementById("projectStatus")?.value;

    if (!id || !title) {
        alert("ID and Title are required!");
        return;
    }

    projects.push({
        id,
        title,
        price,
        start,
        deadline,
        status,
        progress: 0
    });

    saveProjects();
    renderProjects();

    // Close modal SAFELY
    const modalEl = document.getElementById("addProjectModal");
    bootstrap.Modal.getInstance(modalEl)?.hide();

    document.getElementById("addProjectForm")?.reset();
});

// ==================== EDIT PROJECT ====================

function openEditProject(id) {
    const p = projects.find(pr => pr.id == id);

    document.getElementById("editProjectId").value = p.id;
    document.getElementById("editProjectTitle").value = p.title;
    document.getElementById("editProjectPrice").value = p.price;
    document.getElementById("editProjectStartDate").value = p.start;
    document.getElementById("editProjectDeadline").value = p.deadline;
    document.getElementById("editProjectStatus").value = p.status;

    new bootstrap.Modal(document.getElementById("editProjectModal")).show();
}

on("saveProjectEdit", "click", function () {

    const id = document.getElementById("editProjectId")?.value;
    if (!id) return;

    const project = projects.find(p => p.id == id);
    if (!project) return;

    project.title = document.getElementById("editProjectTitle")?.value || "";
    project.price = document.getElementById("editProjectPrice")?.value || "";
    project.start = document.getElementById("editProjectStartDate")?.value || "";
    project.deadline = document.getElementById("editProjectDeadline")?.value || "";
    project.status = document.getElementById("editProjectStatus")?.value || "";

    saveProjects();
    renderProjects();

    // Close modal SAFELY
    const modalEl = document.getElementById("editProjectModal");
    bootstrap.Modal.getInstance(modalEl)?.hide();
});

// ==================== DELETE PROJECT ====================

function openDeleteProject(id) {
    deleteProjectId = id;
    new bootstrap.Modal(document.getElementById("deleteProjectModal")).show();
}
on("confirmDeleteProject", "click", function () {

    if (deleteProjectId === null) return;

    projects = projects.filter(p => p.id != deleteProjectId);
    saveProjects();
    renderProjects();

    // Close modal SAFELY
    const modalEl = document.getElementById("deleteProjectModal");
    bootstrap.Modal.getInstance(modalEl)?.hide();

    deleteProjectId = null; // reset
});



// ==================== STATUS FILTER ====================

document.querySelectorAll(".filter-status").forEach(btn => {
    btn.addEventListener("click", () => {
        const status = btn.dataset.status;

        if (status === "all") {
            renderProjects();
            return;
        }

        const filtered = projects.filter(p => p.status === status);
        const tbody = document.getElementById("projectsTableBody");
        tbody.innerHTML = "";

        filtered.forEach(project => {
            tbody.innerHTML += `
            <tr>
                <td>${project.id}</td>
                <td>${project.title}</td>
                <td>${project.price}</td>
                <td>${project.start}</td>
                <td>${project.deadline}</td>
                <td>
                    <div class="progress"><div class="progress-bar" style="width:${project.progress || 0}%"></div></div>
                </td>
                <td><span class="badge bg-${statusColor(project.status)}">${project.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="openEditProject(${project.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="openDeleteProject(${project.id})">Delete</button>
                </td>
            </tr>`;
        });
    });
});

// ==================== SEARCH ====================

on("searchProjects", "input", function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll("#projectsTableBody tr").forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";
    });
});


// ==================== EXPORT TO EXCEL ====================

on("exportProjectsExcel", "click", function () {
    if (!Array.isArray(projects) || projects.length === 0) {
        alert("No projects to export");
        return;
    }

    let csv = "ID,Title,Price,Start,Deadline,Status\n";

    projects.forEach(p => {
        csv += `${p.id},${p.title},${p.price},${p.start},${p.deadline},${p.status}\n`;
    });

    const blob = new Blob([csv], { type: "text/csv" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "projects.csv";
    document.body.appendChild(a);
    a.click();
    a.remove();

    URL.revokeObjectURL(url);
});


// ==================== PRINT ====================

document.addEventListener("DOMContentLoaded", () => {
  const printBtn = document.getElementById("printProjects");
  const table = document.getElementById("projectsTable");

  // 🛑 PAGE GUARD
  if (!printBtn || !table) {
    console.warn("printProjects or projectsTable not found");
    return;
  }

  printBtn.addEventListener("click", () => {
    const printContent = table.outerHTML;

    const win = window.open("", "", "width=900,height=600");
    if (!win) return;

    win.document.write(`
      <html>
        <head>
          <title>Print Projects</title>
          <style>
            table { width:100%; border-collapse:collapse; }
            th, td { border:1px solid #333; padding:8px; }
          </style>
        </head>
        <body>
          ${printContent}
        </body>
      </html>
    `);

    win.document.close();
    win.focus();
    win.print();
  });
});


// INITIAL RENDER
renderProjects();

// ==================== SUBSCRIPTIONS MODULE ====================
let subscriptions = JSON.parse(localStorage.getItem("subscriptionsList")) || [];
let deleteSubscriptionId = null;

function renderSubscriptions() {
  const tbody = document.getElementById("subscriptionsTableBody");
  tbody.innerHTML = "";

  if (subscriptions.length === 0) {
    tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">No subscriptions found.</td></tr>`;
    return;
  }

  subscriptions.forEach(sub => {
    tbody.innerHTML += `
      <tr>
        <td>${sub.id}</td>
        <td>${sub.name}</td>
        <td>${sub.plan}</td>
        <td>${sub.start}</td>
        <td>${sub.end}</td>
        <td><span class="badge bg-${sub.status==='active'?'success':'danger'}">${sub.status}</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="openEditSubscription(${sub.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDeleteSubscription(${sub.id})">Delete</button>
        </td>
      </tr>`;
  });
}

// Add subscription
on("saveSubscription", "click", () => {

  const id = document.getElementById("subscriptionId")?.value || "";
  const name = document.getElementById("subscriptionName")?.value || "";
  const plan = document.getElementById("subscriptionPlan")?.value || "";
  const start = document.getElementById("subscriptionStartDate")?.value || "";
  const end = document.getElementById("subscriptionEndDate")?.value || "";
  const status = document.getElementById("subscriptionStatus")?.value || "";

  if (!id || !name) {
    alert("ID and Name are required");
    return;
  }

  let subscriptions =
    JSON.parse(localStorage.getItem("subscriptionsList")) || [];

  subscriptions.push({ id, name, plan, start, end, status });
  localStorage.setItem(
    "subscriptionsList",
    JSON.stringify(subscriptions)
  );

  // 🔁 safe render
  if (typeof renderSubscriptions === "function") {
    renderSubscriptions();
  }

  // 🧼 Safe modal close
  const modalEl = document.getElementById("addSubscriptionModal");
  if (modalEl) {
    bootstrap.Modal.getOrCreateInstance(modalEl).hide();
  }

  // 🧹 Cleanup (safe)
  document.body.classList.remove("modal-open");
  document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());

  document.getElementById("addSubscriptionForm")?.reset();
});


// Edit subscription
function openEditSubscription(id) {
  const sub = subscriptions.find(s => s.id == id);
  document.getElementById("editSubscriptionId").value = sub.id;
  document.getElementById("editSubscriptionName").value = sub.name;
  document.getElementById("editSubscriptionPlan").value = sub.plan;
  document.getElementById("editSubscriptionStartDate").value = sub.start;
  document.getElementById("editSubscriptionEndDate").value = sub.end;
  document.getElementById("editSubscriptionStatus").value = sub.status;

  new bootstrap.Modal(document.getElementById("editSubscriptionModal")).show();
}

document.getElementById("saveSubscriptionEdit").addEventListener("click", () => {
  const id = document.getElementById("editSubscriptionId").value;
  const sub = subscriptions.find(s => s.id == id);

  sub.name = document.getElementById("editSubscriptionName").value;
  sub.plan = document.getElementById("editSubscriptionPlan").value;
  sub.start = document.getElementById("editSubscriptionStartDate").value;
  sub.end = document.getElementById("editSubscriptionEndDate").value;
  sub.status = document.getElementById("editSubscriptionStatus").value;

  localStorage.setItem("subscriptionsList", JSON.stringify(subscriptions));
  renderSubscriptions();

  const modal = bootstrap.Modal.getInstance(document.getElementById("editSubscriptionModal"));
  modal.hide();
});

// Delete subscription
function openDeleteSubscription(id) {
  deleteSubscriptionId = id;
  new bootstrap.Modal(document.getElementById("deleteSubscriptionModal")).show();
}
document.getElementById("confirmDeleteSubscription").addEventListener("click", () => {
  subscriptions = subscriptions.filter(s => s.id != deleteSubscriptionId);
  localStorage.setItem("subscriptionsList", JSON.stringify(subscriptions));
  renderSubscriptions();
  const modal = bootstrap.Modal.getInstance(document.getElementById("deleteSubscriptionModal"));
  modal.hide();
});

// Search
document.getElementById("searchSubscriptions").addEventListener("input", function() {
  const value = this.value.toLowerCase();
  document.querySelectorAll("#subscriptionsTableBody tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
  });
});

// Filter
document.querySelectorAll(".filter-status-sub").forEach(btn => {
  btn.addEventListener("click", () => {
    const status = btn.dataset.status;
    if (status === "all") return renderSubscriptions();
    const filtered = subscriptions.filter(s => s.status === status);
    const tbody = document.getElementById("subscriptionsTableBody");
    tbody.innerHTML = "";
    filtered.forEach(sub => {
      tbody.innerHTML += `
        <tr>
          <td>${sub.id}</td>
          <td>${sub.name}</td>
          <td>${sub.plan}</td>
          <td>${sub.start}</td>
          <td>${sub.end}</td>
          <td><span class="badge bg-${sub.status==='active'?'success':'danger'}">${sub.status}</span></td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditSubscription(${sub.id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openDeleteSubscription(${sub.id})">Delete</button>
          </td>
        </tr>`;
    });
  });
});

// Export
document.getElementById("exportSubscriptionsExcel").addEventListener("click", () => {
  let csv = "ID,Name,Plan,Start,End,Status\n";
  subscriptions.forEach(s => {
    csv += `${s.id},${s.name},${s.plan},${s.start},${s.end},${s.status}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "subscriptions.csv";
  a.click();
});

// Print
document.getElementById("printSubscriptions").addEventListener("click", () => {
  const printContent = document.getElementById("subscriptionsTable").outerHTML;
  const windowPrint = window.open("", "", "width=900,height=600");
  windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
  windowPrint.document.close();
  windowPrint.print();
});

// Initial render
renderSubscriptions();
// ==================== INVOICES MODULE ====================
let invoices = JSON.parse(localStorage.getItem("invoicesList")) || [];
let deleteInvoiceId = null;

// ---------------- Helper to close modal and reset form ----------------
function closeModal(modalId, formId = null) {
  const modalEl = document.getElementById(modalId);
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();

  if (formId) {
    const form = document.getElementById(formId);
    if (form) form.reset();
  }
}

// ---------------- Render invoices ----------------
function renderInvoices() {
  const tbody = document.getElementById("invoicesTableBody");
  tbody.innerHTML = "";

  if (!invoices.length) {
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No invoices found.</td></tr>`;
    return;
  }

  invoices.forEach(inv => {
    tbody.innerHTML += `
      <tr>
        <td>${inv.id}</td>
        <td>${inv.title}</td>
        <td>${inv.amount}</td>
        <td>${inv.date}</td>
        <td><span class="badge bg-${inv.status==='paid'?'success':inv.status==='unpaid'?'danger':'secondary'}">${inv.status}</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="openEditInvoice(${inv.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDeleteInvoice(${inv.id})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// ---------------- Add Invoice ----------------
document.getElementById("saveInvoice").addEventListener("click", () => {
  const id = document.getElementById("invoiceId").value;
  const title = document.getElementById("invoiceTitle").value;
  const amount = document.getElementById("invoiceAmount").value;
  const date = document.getElementById("invoiceDate").value;
  const status = document.getElementById("invoiceStatus").value;

  invoices.push({ id, title, amount, date, status });
  localStorage.setItem("invoicesList", JSON.stringify(invoices));
  renderInvoices();

  closeModal("addInvoiceModal", "addInvoiceForm");
});

// ---------------- Edit Invoice ----------------
function openEditInvoice(id) {
  const inv = invoices.find(i => i.id == id);
  document.getElementById("editInvoiceId").value = inv.id;
  document.getElementById("editInvoiceTitle").value = inv.title;
  document.getElementById("editInvoiceAmount").value = inv.amount;
  document.getElementById("editInvoiceDate").value = inv.date;
  document.getElementById("editInvoiceStatus").value = inv.status;

  new bootstrap.Modal(document.getElementById("editInvoiceModal")).show();
}

document.getElementById("saveInvoiceEdit").addEventListener("click", () => {
  const id = document.getElementById("editInvoiceId").value;
  const inv = invoices.find(i => i.id == id);

  inv.title = document.getElementById("editInvoiceTitle").value;
  inv.amount = document.getElementById("editInvoiceAmount").value;
  inv.date = document.getElementById("editInvoiceDate").value;
  inv.status = document.getElementById("editInvoiceStatus").value;

  localStorage.setItem("invoicesList", JSON.stringify(invoices));
  renderInvoices();

  closeModal("editInvoiceModal");
});

// ---------------- Delete Invoice ----------------
function openDeleteInvoice(id) {
  deleteInvoiceId = id;
  new bootstrap.Modal(document.getElementById("deleteInvoiceModal")).show();
}

document.getElementById("confirmDeleteInvoice").addEventListener("click", () => {
  invoices = invoices.filter(i => i.id != deleteInvoiceId);
  localStorage.setItem("invoicesList", JSON.stringify(invoices));
  renderInvoices();

  closeModal("deleteInvoiceModal");
});

// ---------------- Search ----------------
document.getElementById("searchInvoices").addEventListener("input", function() {
  const value = this.value.toLowerCase();
  document.querySelectorAll("#invoicesTableBody tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
  });
});

// ---------------- Filter ----------------
document.querySelectorAll(".filter-status-inv").forEach(btn => {
  btn.addEventListener("click", () => {
    const status = btn.dataset.status;
    const tbody = document.getElementById("invoicesTableBody");
    tbody.innerHTML = "";

    let filtered = invoices;
    if (status !== "all") filtered = invoices.filter(i => i.status === status);

    filtered.forEach(inv => {
      tbody.innerHTML += `
        <tr>
          <td>${inv.id}</td>
          <td>${inv.title}</td>
          <td>${inv.amount}</td>
          <td>${inv.date}</td>
          <td><span class="badge bg-${inv.status==='paid'?'success':inv.status==='unpaid'?'danger':'secondary'}">${inv.status}</span></td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditInvoice(${inv.id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openDeleteInvoice(${inv.id})">Delete</button>
          </td>
        </tr>
      `;
    });
  });
});

// ---------------- Export CSV ----------------
document.getElementById("exportInvoicesExcel").addEventListener("click", () => {
  let csv = "ID,Title,Amount,Date,Status\n";
  invoices.forEach(inv => {
    csv += `${inv.id},${inv.title},${inv.amount},${inv.date},${inv.status}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "invoices.csv";
  a.click();
});

// ---------------- Print ----------------
document.getElementById("printInvoices").addEventListener("click", () => {
  const printContent = document.getElementById("invoicesTable").outerHTML;
  const windowPrint = window.open("", "", "width=900,height=600");
  windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
  windowPrint.document.close();
  windowPrint.print();
});

// ---------------- Initial render ----------------
renderInvoices();
// ==================== PAYMENTS MODULE ====================
let payments = JSON.parse(localStorage.getItem("paymentsList")) || [];
let deletePaymentId = null;

// Function to render table
function renderPayments() {
  const tbody = document.getElementById("paymentsTableBody");
  tbody.innerHTML = "";

  if (!payments.length) {
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No payments found.</td></tr>`;
    return;
  }

  payments.forEach(pay => {
    tbody.innerHTML += `
      <tr>
        <td>${pay.id}</td>
        <td>${pay.payer}</td>
        <td>${pay.amount}</td>
        <td>${pay.date}</td>
        <td><span class="badge bg-${pay.status==='paid'?'success':pay.status==='pending'?'warning':'danger'}">${pay.status}</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="openEditPayment(${pay.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDeletePayment(${pay.id})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// Helper to close modal and reset form
function closeModal(modalId, formId=null) {
  const modalEl = document.getElementById(modalId);
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
  if (formId) document.getElementById(formId).reset();
}

// Add Payment
document.getElementById("savePayment").addEventListener("click", (e) => {
  e.preventDefault(); // prevents any form submission
  const id = document.getElementById("paymentId").value;
  const payer = document.getElementById("paymentPayer").value;
  const amount = document.getElementById("paymentAmount").value;
  const date = document.getElementById("paymentDate").value;
  const status = document.getElementById("paymentStatus").value;

  payments.push({ id, payer, amount, date, status });
  localStorage.setItem("paymentsList", JSON.stringify(payments));
  renderPayments();

  closeModal("addPaymentModal", "addPaymentForm");
});


// Open Edit Payment Modal
function openEditPayment(id) {
  const pay = payments.find(p => p.id == id);
  document.getElementById("editPaymentId").value = pay.id;
  document.getElementById("editPaymentPayer").value = pay.payer;
  document.getElementById("editPaymentAmount").value = pay.amount;
  document.getElementById("editPaymentDate").value = pay.date;
  document.getElementById("editPaymentStatus").value = pay.status;

  new bootstrap.Modal(document.getElementById("editPaymentModal")).show();
}

// Save Edited Payment
document.getElementById("savePaymentEdit").addEventListener("click", () => {
  const id = document.getElementById("editPaymentId").value;
  const pay = payments.find(p => p.id == id);

  pay.payer = document.getElementById("editPaymentPayer").value;
  pay.amount = document.getElementById("editPaymentAmount").value;
  pay.date = document.getElementById("editPaymentDate").value;
  pay.status = document.getElementById("editPaymentStatus").value;

  localStorage.setItem("paymentsList", JSON.stringify(payments));
  renderPayments();
  closeModal("editPaymentModal");
});

// Delete Payment
function openDeletePayment(id) {
  deletePaymentId = id;
  new bootstrap.Modal(document.getElementById("deletePaymentModal")).show();
}

document.getElementById("confirmDeletePayment").addEventListener("click", () => {
  payments = payments.filter(p => p.id != deletePaymentId);
  localStorage.setItem("paymentsList", JSON.stringify(payments));
  renderPayments();
  closeModal("deletePaymentModal");
});

// Search Payments
document.getElementById("searchPayments").addEventListener("input", function() {
  const value = this.value.toLowerCase();
  document.querySelectorAll("#paymentsTableBody tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
  });
});

// Filter Payments by Status
document.querySelectorAll(".filter-status-payment").forEach(btn => {
  btn.addEventListener("click", () => {
    const status = btn.dataset.status;
    const tbody = document.getElementById("paymentsTableBody");
    tbody.innerHTML = "";

    let filtered = status === "all" ? payments : payments.filter(p => p.status === status);

    filtered.forEach(pay => {
      tbody.innerHTML += `
        <tr>
          <td>${pay.id}</td>
          <td>${pay.payer}</td>
          <td>${pay.amount}</td>
          <td>${pay.date}</td>
          <td><span class="badge bg-${pay.status==='paid'?'success':pay.status==='pending'?'warning':'danger'}">${pay.status}</span></td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditPayment(${pay.id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openDeletePayment(${pay.id})">Delete</button>
          </td>
        </tr>
      `;
    });
  });
});

// Export Payments to CSV
document.getElementById("exportPaymentsExcel").addEventListener("click", () => {
  let csv = "ID,Payer,Amount,Date,Status\n";
  payments.forEach(p => {
    csv += `${p.id},${p.payer},${p.amount},${p.date},${p.status}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "payments.csv";
  a.click();
});

// Print Payments
document.getElementById("printPayments").addEventListener("click", () => {
  const printContent = document.getElementById("paymentsTable").outerHTML;
  const windowPrint = window.open("", "", "width=900,height=600");
  windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
  windowPrint.document.close();
  windowPrint.print();
});

// Initial render
renderPayments();
// ===================== LOAD ORDERS FROM LOCAL STORAGE =====================
let orders = JSON.parse(localStorage.getItem("ordersData")) || [];
let editingOrderId = null;

// ===================== SAVE TO LOCAL STORAGE =====================
function saveOrdersToStorage() {
    localStorage.setItem("ordersData", JSON.stringify(orders));
}

// ===================== RENDER ORDERS =====================
function renderOrders() {
    let search = document.getElementById("searchOrders").value.toLowerCase();
    let statusFilter = document.querySelector("#orderStatusFilter").dataset.selected || "all";

    let filtered = orders.filter(order => {
        let matchesSearch =
            order.customer.toLowerCase().includes(search) ||
            order.orderId.toString().includes(search) ||
            order.price.toString().includes(search);

        let matchesStatus = statusFilter === "all" || order.status === statusFilter;

        return matchesSearch && matchesStatus;
    });

    let tbody = document.getElementById("ordersTableBody");
    tbody.innerHTML = "";

    filtered.forEach(order => {
        tbody.innerHTML += `
            <tr>
                <td>${order.orderId}</td>
                <td>${order.customer}</td>
                <td>₹${order.price}</td>
                <td>${order.orderDate}</td>
                <td>${order.deliveryDate}</td>
                <td>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: ${order.progress}%"></div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${getStatusColor(order.status)}">
                        ${capitalize(order.status)}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="openEditOrder(${order.orderId})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="openDeleteOrder(${order.orderId})">Delete</button>
                </td>
            </tr>
        `;
    });

    document.getElementById("orderPaginationText").innerText =
        `${filtered.length} • Showing ${filtered.length}`;
}

// ===================== STATUS COLORS =====================
function getStatusColor(status) {
    switch (status) {
        case "pending": return "warning text-dark";
        case "processing": return "info text-dark";
        case "completed": return "success";
        case "canceled": return "danger";
        default: return "secondary";
    }
}

function capitalize(t) { return t.charAt(0).toUpperCase() + t.slice(1); }

// ===================== ADD ORDER =====================
document.getElementById("saveOrder").addEventListener("click", () => {

    let order = {
        orderId: Number(document.getElementById("orderId").value),
        customer: document.getElementById("orderCustomer").value,
        price: Number(document.getElementById("orderPrice").value),
        orderDate: document.getElementById("orderDate").value,
        deliveryDate: document.getElementById("orderDelivery").value,
        status: document.getElementById("orderStatus").value,
        progress: getAutoProgress(document.getElementById("orderStatus").value)
    };

    orders.push(order);
    saveOrdersToStorage();
    renderOrders();

    // FIX BLUR: Correct modal instance closing
    let addModal = bootstrap.Modal.getInstance(document.getElementById("addOrderModal"));
    addModal.hide();
});

// Progress auto update
function getAutoProgress(status) {
    if (status === "pending") return 0;
    if (status === "processing") return 50;
    if (status === "completed") return 100;
    return 0;
}

// ===================== EDIT ORDER =====================
function openEditOrder(id) {
    editingOrderId = id;
    let order = orders.find(o => o.orderId === id);

    document.getElementById("editOrderCustomer").value = order.customer;
    document.getElementById("editOrderPrice").value = order.price;
    document.getElementById("editOrderDate").value = order.orderDate;
    document.getElementById("editOrderDelivery").value = order.deliveryDate;
    document.getElementById("editOrderStatus").value = order.status;

    new bootstrap.Modal(document.getElementById("editOrderModal")).show();
}

document.getElementById("saveOrderEdit").addEventListener("click", () => {
    let order = orders.find(o => o.orderId === editingOrderId);

    order.customer = document.getElementById("editOrderCustomer").value;
    order.price = Number(document.getElementById("editOrderPrice").value);
    order.orderDate = document.getElementById("editOrderDate").value;
    order.deliveryDate = document.getElementById("editOrderDelivery").value;
    order.status = document.getElementById("editOrderStatus").value;
    order.progress = getAutoProgress(order.status);

    saveOrdersToStorage();
    renderOrders();

    let editModal = bootstrap.Modal.getInstance(document.getElementById("editOrderModal"));
    editModal.hide();
});

// ===================== DELETE =====================
function openDeleteOrder(id) {
    editingOrderId = id;
    new bootstrap.Modal(document.getElementById("deleteOrderModal")).show();
}

document.getElementById("confirmDeleteOrder").addEventListener("click", () => {
    orders = orders.filter(o => o.orderId !== editingOrderId);
    saveOrdersToStorage();
    renderOrders();

    let deleteModal = bootstrap.Modal.getInstance(document.getElementById("deleteOrderModal"));
    deleteModal.hide();
});

// ===================== SEARCH =====================
document.getElementById("searchOrders").addEventListener("input", renderOrders);

// ===================== FILTER =====================
document.querySelectorAll(".filter-order-status").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelector("#orderStatusFilter").innerText = btn.innerText;
        document.querySelector("#orderStatusFilter").dataset.selected = btn.dataset.status;
        renderOrders();
    });
});

// ===================== ON PAGE LOAD =====================
renderOrders();
document.addEventListener("hidden.bs.modal", function () {
  document.body.classList.remove('modal-open');
  const modalBackdrop = document.querySelector('.modal-backdrop');
  if (modalBackdrop) modalBackdrop.remove();
});

// ===== Estimates JS with localStorage, search, filter, export, print =====
(function () {
  const STORAGE_KEY = "estimatesData_v1";

  // state
  let estimates = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  let editingEstimateId = null;

  // elements (safe getters)
  const tbody = document.getElementById("estimatesTableBody");
  const paginationText = document.getElementById("estimatePaginationText");
  const searchInput = document.getElementById("searchEstimates");
  const statusFilterBtn = document.getElementById("estimateStatusFilter");
  const saveBtn = document.getElementById("saveEstimate");
  const saveEditBtn = document.getElementById("saveEstimateEdit");
  const confirmDeleteBtn = document.getElementById("confirmDeleteEstimate");
  const exportBtn = document.getElementById("exportEstimatesExcel");
  const printBtn = document.getElementById("printEstimates");

  // helpers
  function persist() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(estimates));
  }

  function statusBadgeClass(status) {
    // Option B: draft → secondary, sent → info, accepted → success, declined → danger
    switch ((status || "").toLowerCase()) {
      case "draft": return "secondary";
      case "sent": return "info text-dark";
      case "accepted": return "success";
      case "declined": return "danger";
      default: return "secondary";
    }
  }

  function capitalize(s) { return String(s || "").charAt(0).toUpperCase() + String(s || "").slice(1); }

  function getFilterStatus() {
    return statusFilterBtn?.dataset?.selected || "all";
  }

  // Render table
  function renderEstimates() {
    if (!tbody) return;
    const q = (searchInput?.value || "").toLowerCase();
    const filter = getFilterStatus();

    const filtered = estimates.filter(e => {
      const matchesSearch = (
        String(e.id).includes(q) ||
        String(e.client || "").toLowerCase().includes(q) ||
        String(e.estimateNumber || "").toLowerCase().includes(q) ||
        String(e.amount || "").toLowerCase().includes(q)
      );
      const matchesStatus = filter === "all" || (e.status === filter);
      return matchesSearch && matchesStatus;
    });

    tbody.innerHTML = "";

    if (filtered.length === 0) {
      tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-3">No estimates found</td></tr>`;
      paginationText && (paginationText.innerText = "0 • 0–0 / 0");
      return;
    }

    filtered.forEach(e => {
      tbody.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${e.id}</td>
          <td>${escapeHtml(e.client)}</td>
          <td>${escapeHtml(e.estimateNumber)}</td>
          <td>${formatNumber(e.amount)}</td>
          <td>${e.issueDate || ""}</td>
          <td>${e.validTill || ""}</td>
          <td><span class="badge bg-${statusBadgeClass(e.status)}">${capitalize(e.status)}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick="openEditEstimate(${e.id})">Edit</button>
            <button class="btn btn-sm btn-outline-danger" onclick="openDeleteEstimate(${e.id})">Delete</button>
          </td>
        </tr>
      `);
    });

    paginationText && (paginationText.innerText = `${filtered.length} • Showing ${filtered.length} results`);
  }

  // escape to avoid simple XSS when injecting innerHTML
  function escapeHtml(str) {
    if (str === null || str === undefined) return "";
    return String(str)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function formatNumber(n) {
    if (n === null || n === undefined || n === "") return "";
    return Number(n).toLocaleString();
  }

  // Add estimate
  if (saveBtn) {
    saveBtn.addEventListener("click", (ev) => {
      // prevent default form submission if inside <form>
      ev.preventDefault?.();

      // gather values
      const idVal = document.getElementById("estimateId")?.value;
      const client = (document.getElementById("estimateClient")?.value || "").trim();
      const number = (document.getElementById("estimateNumber")?.value || "").trim();
      const amount = document.getElementById("estimateAmount")?.value;
      const issueDate = document.getElementById("estimateIssueDate")?.value;
      const validTill = document.getElementById("estimateValidTill")?.value;
      const status = (document.getElementById("estimateStatus")?.value || "draft").toLowerCase();

      if (!idVal || !client || !number) {
        // minimal validation
        alert("Please provide ID, Client and Estimate Number.");
        return;
      }

      const id = Number(idVal);

      // prevent duplicate id
      if (estimates.some(e => e.id === id)) {
        alert("Estimate ID already exists. Choose a different ID.");
        return;
      }

      const newEstimate = {
        id,
        client,
        estimateNumber: number,
        amount: Number(amount) || 0,
        issueDate,
        validTill,
        status
      };

      estimates.push(newEstimate);
      persist();
      renderEstimates();

      // hide modal correctly and reset form
      const addModalEl = document.getElementById("addEstimateModal");
      const addModalInstance = bootstrap.Modal.getInstance(addModalEl) || new bootstrap.Modal(addModalEl);
      addModalInstance.hide();

      const form = document.getElementById("addEstimateForm");
      form && form.reset();
    });
  }

  // Edit helpers (exposed globally for inline onclick)
  window.openEditEstimate = function (id) {
    const est = estimates.find(x => x.id === id);
    if (!est) return alert("Estimate not found.");

    editingEstimateId = id;
    document.getElementById("editEstimateId").value = est.id;
    document.getElementById("editEstimateClient").value = est.client;
    document.getElementById("editEstimateNumber").value = est.estimateNumber;
    document.getElementById("editEstimateAmount").value = est.amount;
    document.getElementById("editEstimateIssueDate").value = est.issueDate;
    document.getElementById("editEstimateValidTill").value = est.validTill;
    document.getElementById("editEstimateStatus").value = est.status;

    const editModalEl = document.getElementById("editEstimateModal");
    new bootstrap.Modal(editModalEl).show();
  };

  // Save edit
  if (saveEditBtn) {
    saveEditBtn.addEventListener("click", (ev) => {
      ev.preventDefault?.();
      const id = editingEstimateId;
      const idx = estimates.findIndex(e => e.id === id);
      if (idx === -1) return alert("Estimate not found.");

      const client = (document.getElementById("editEstimateClient")?.value || "").trim();
      const number = (document.getElementById("editEstimateNumber")?.value || "").trim();
      const amount = document.getElementById("editEstimateAmount")?.value;
      const issueDate = document.getElementById("editEstimateIssueDate")?.value;
      const validTill = document.getElementById("editEstimateValidTill")?.value;
      const status = (document.getElementById("editEstimateStatus")?.value || "draft").toLowerCase();

      if (!client || !number) {
        alert("Please fill client and estimate number.");
        return;
      }

      estimates[idx].client = client;
      estimates[idx].estimateNumber = number;
      estimates[idx].amount = Number(amount) || 0;
      estimates[idx].issueDate = issueDate;
      estimates[idx].validTill = validTill;
      estimates[idx].status = status;

      persist();
      renderEstimates();

      const editModalEl = document.getElementById("editEstimateModal");
      const editModalInstance = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
      editModalInstance.hide();
    });
  }

  // Delete flow
  window.openDeleteEstimate = function (id) {
    editingEstimateId = id;
    const deleteModalEl = document.getElementById("deleteEstimateModal");
    new bootstrap.Modal(deleteModalEl).show();
  };

  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", (ev) => {
      ev.preventDefault?.();
      if (editingEstimateId === null) return;

      estimates = estimates.filter(e => e.id !== editingEstimateId);
      persist();
      renderEstimates();

      const deleteModalEl = document.getElementById("deleteEstimateModal");
      const deleteModalInstance = bootstrap.Modal.getInstance(deleteModalEl) || new bootstrap.Modal(deleteModalEl);
      deleteModalInstance.hide();
    });
  }

  // Search
  searchInput && searchInput.addEventListener("input", renderEstimates);

  // Status filter - clicks on dropdown items should set data-selected on button and re-render
  document.querySelectorAll(".estimate-filter-status").forEach(item => {
    item.addEventListener("click", function (ev) {
      ev.preventDefault();
      const s = this.dataset.status || "all";
      if (statusFilterBtn) {
        statusFilterBtn.innerText = this.innerText;
        statusFilterBtn.dataset.selected = s;
      }
      renderEstimates();
    });
  });

  // Export CSV (all columns)
  exportBtn && exportBtn.addEventListener("click", () => {
    if (!estimates.length) return alert("No estimates to export.");

    const headers = ["ID", "Client", "Estimate Number", "Amount", "Issue Date", "Valid Until", "Status"];
    const rows = estimates.map(e => [
      e.id,
      e.client,
      e.estimateNumber,
      e.amount,
      e.issueDate,
      e.validTill,
      e.status
    ]);

    const csv = [headers, ...rows].map(r => r.map(cell => {
      // escape quotes
      const cellStr = cell === null || cell === undefined ? "" : String(cell);
      return `"${cellStr.replace(/"/g, '""')}"`;
    }).join(",")).join("\n");

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "estimates.csv";
    document.body.appendChild(a);
    a.click();
    a.remove();
  });

  // Print table
  printBtn && printBtn.addEventListener("click", () => {
    const tableHtml = document.getElementById("estimatesTable").outerHTML;
    const w = window.open("", "_blank");
    w.document.write(`
      <html><head>
        <title>Print Estimates</title>
        <link href="${location.origin}/" rel="stylesheet">
        <style>
          body { font-family: Arial, Helvetica, sans-serif; padding: 20px; }
          table { width: 100%; border-collapse: collapse; }
          table, th, td { border: 1px solid #ccc; }
          th, td { padding: 8px 6px; text-align: left; }
        </style>
      </head><body>
      <h3>Estimates</h3>
      ${tableHtml}
      </body></html>`);
    w.document.close();
    w.focus();
    w.print();
    w.close();
  });

  // Utility: remove leftover modal backdrops & classes when any modal hides
  document.addEventListener("hidden.bs.modal", function (e) {
    // remove any stray modal-backdrop left behind
    document.body.classList.remove("modal-open");
    document.querySelectorAll(".modal-backdrop").forEach(n => n.remove());
  });

  // init render
  renderEstimates();

  // expose quick debug helpers if needed
  window._estimates_store = estimates;
})();
// ===== Proposals JS with localStorage, search, filter, export, print =====
(function () {
  const STORAGE_KEY = "proposalsData_v1";
  let proposals = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  let editingProposalId = null;

  const tbody = document.getElementById("proposalsTableBody");
  const paginationText = document.getElementById("proposalPaginationText");
  const searchInput = document.getElementById("searchProposals");
  const statusFilterBtn = document.getElementById("proposalStatusFilter");
  const saveBtn = document.getElementById("saveProposal");
  const saveEditBtn = document.getElementById("saveProposalEdit");
  const confirmDeleteBtn = document.getElementById("confirmDeleteProposal");
  const exportBtn = document.getElementById("exportProposalsExcel");
  const printBtn = document.getElementById("printProposals");

  function persist() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(proposals));
  }

  function statusBadgeClass(status) {
    switch ((status || "").toLowerCase()) {
      case "draft": return "secondary";
      case "sent": return "info text-dark";
      case "accepted": return "success";
      case "rejected": return "danger";
      default: return "secondary";
    }
  }

  function capitalize(s) { return String(s || "").charAt(0).toUpperCase() + String(s || "").slice(1); }
  function getFilterStatus() { return statusFilterBtn?.dataset?.selected || "all"; }

  function escapeHtml(str) {
    if (str === null || str === undefined) return "";
    return String(str)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function formatNumber(n) {
    if (n === null || n === undefined || n === "") return "";
    return Number(n).toLocaleString();
  }

  function renderProposals() {
    if (!tbody) return;
    const q = (searchInput?.value || "").toLowerCase();
    const filter = getFilterStatus();

    const filtered = proposals.filter(p => {
      const matchesSearch = (
        String(p.id).includes(q) ||
        String(p.client || "").toLowerCase().includes(q) ||
        String(p.proposalNumber || "").toLowerCase().includes(q) ||
        String(p.amount || "").toLowerCase().includes(q)
      );
      const matchesStatus = filter === "all" || (p.status === filter);
      return matchesSearch && matchesStatus;
    });

    tbody.innerHTML = "";
    if (filtered.length === 0) {
      tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-3">No proposals found</td></tr>`;
      paginationText && (paginationText.innerText = "0 • 0–0 / 0");
      return;
    }

    filtered.forEach(p => {
      tbody.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${p.id}</td>
          <td>${escapeHtml(p.client)}</td>
          <td>${escapeHtml(p.proposalNumber)}</td>
          <td>${formatNumber(p.amount)}</td>
          <td>${p.date || ""}</td>
          <td>${p.validTill || ""}</td>
          <td><span class="badge bg-${statusBadgeClass(p.status)}">${capitalize(p.status)}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick="openEditProposal(${p.id})">Edit</button>
            <button class="btn btn-sm btn-outline-danger" onclick="openDeleteProposal(${p.id})">Delete</button>
          </td>
        </tr>
      `);
    });

    paginationText && (paginationText.innerText = `${filtered.length} • Showing ${filtered.length} results`);
  }

  // Add
  if (saveBtn) {
    saveBtn.addEventListener("click", function (ev) {
      ev.preventDefault?.();
      const idVal = document.getElementById("proposalId")?.value;
      const client = (document.getElementById("proposalClient")?.value || "").trim();
      const num = (document.getElementById("proposalNumber")?.value || "").trim();
      const amount = document.getElementById("proposalAmount")?.value;
      const date = document.getElementById("proposalDate")?.value;
      const validTill = document.getElementById("proposalValidTill")?.value;
      const status = (document.getElementById("proposalStatus")?.value || "draft").toLowerCase();

      if (!idVal || !client || !num) {
        alert("Please enter ID, Client and Proposal Number.");
        return;
      }
      const id = Number(idVal);
      if (proposals.some(x => x.id === id)) {
        alert("Proposal ID already exists.");
        return;
      }

      const newP = { id, client, proposalNumber: num, amount: Number(amount) || 0, date, validTill, status };
      proposals.push(newP);
      persist();
      renderProposals();

      const addModalEl = document.getElementById("addProposalModal");
      const addModalInstance = bootstrap.Modal.getInstance(addModalEl) || new bootstrap.Modal(addModalEl);
      addModalInstance.hide();

      const form = document.getElementById("addProposalForm");
      form && form.reset();
    });
  }

  // Edit exposed fn
  window.openEditProposal = function (id) {
    const p = proposals.find(x => x.id === id);
    if (!p) return alert("Proposal not found.");
    editingProposalId = id;
    document.getElementById("editProposalId").value = p.id;
    document.getElementById("editProposalClient").value = p.client;
    document.getElementById("editProposalNumber").value = p.proposalNumber;
    document.getElementById("editProposalAmount").value = p.amount;
    document.getElementById("editProposalDate").value = p.date;
    document.getElementById("editProposalValidTill").value = p.validTill;
    document.getElementById("editProposalStatus").value = p.status;

    const editModalEl = document.getElementById("editProposalModal");
    new bootstrap.Modal(editModalEl).show();
  };

  // Save edit
  if (saveEditBtn) {
    saveEditBtn.addEventListener("click", function (ev) {
      ev.preventDefault?.();
      const id = editingProposalId;
      const idx = proposals.findIndex(x => x.id === id);
      if (idx === -1) return alert("Proposal not found.");

      const client = (document.getElementById("editProposalClient")?.value || "").trim();
      const num = (document.getElementById("editProposalNumber")?.value || "").trim();
      const amount = document.getElementById("editProposalAmount")?.value;
      const date = document.getElementById("editProposalDate")?.value;
      const validTill = document.getElementById("editProposalValidTill")?.value;
      const status = (document.getElementById("editProposalStatus")?.value || "draft").toLowerCase();

      if (!client || !num) {
        alert("Please fill client and proposal number.");
        return;
      }

      proposals[idx].client = client;
      proposals[idx].proposalNumber = num;
      proposals[idx].amount = Number(amount) || 0;
      proposals[idx].date = date;
      proposals[idx].validTill = validTill;
      proposals[idx].status = status;

      persist();
      renderProposals();

      const editModalEl = document.getElementById("editProposalModal");
      const editModalInstance = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
      editModalInstance.hide();
    });
  }

  // Delete
  window.openDeleteProposal = function (id) {
    editingProposalId = id;
    const deleteModalEl = document.getElementById("deleteProposalModal");
    new bootstrap.Modal(deleteModalEl).show();
  };

  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", function (ev) {
      ev.preventDefault?.();
      if (editingProposalId === null) return;
      proposals = proposals.filter(x => x.id !== editingProposalId);
      persist();
      renderProposals();
      const deleteModalEl = document.getElementById("deleteProposalModal");
      const deleteModalInstance = bootstrap.Modal.getInstance(deleteModalEl) || new bootstrap.Modal(deleteModalEl);
      deleteModalInstance.hide();
    });
  }

  // Search
  searchInput && searchInput.addEventListener("input", renderProposals);

  // Status filter dropdown items
  document.querySelectorAll(".proposal-filter-status").forEach(item => {
    item.addEventListener("click", function (ev) {
      ev.preventDefault();
      const s = this.dataset.status || "all";
      if (statusFilterBtn) {
        statusFilterBtn.innerText = this.innerText;
        statusFilterBtn.dataset.selected = s;
      }
      renderProposals();
    });
  });

  // Export CSV
  exportBtn && exportBtn.addEventListener("click", function () {
    if (!proposals.length) return alert("No proposals to export.");
    const headers = ["ID", "Client", "Proposal Number", "Amount", "Date", "Valid Until", "Status"];
    const rows = proposals.map(p => [p.id, p.client, p.proposalNumber, p.amount, p.date, p.validTill, p.status]);
    const csv = [headers, ...rows].map(r => r.map(cell => `"${String(cell||"").replace(/"/g,'""')}"`).join(",")).join("\n");
    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "proposals.csv";
    document.body.appendChild(a);
    a.click();
    a.remove();
  });

  // Print
  printBtn && printBtn.addEventListener("click", function () {
    const tableHtml = document.getElementById("proposalsTable").outerHTML;
    const w = window.open("", "_blank");
    w.document.write(`<html><head><title>Print Proposals</title>
      <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px;}table{width:100%;border-collapse:collapse;}table,th,td{border:1px solid #ccc;}th,td{padding:8px 6px;text-align:left;}</style>
      </head><body><h3>Proposals</h3>${tableHtml}</body></html>`);
    w.document.close();
    w.focus();
    w.print();
    w.close();
  });

  // Remove leftover backdrops when modals hide
  document.addEventListener("hidden.bs.modal", function () {
    document.body.classList.remove("modal-open");
    document.querySelectorAll(".modal-backdrop").forEach(n => n.remove());
  });

  // initial render
  renderProposals();

  // debug helper
  window._proposals_store = proposals;
})();
// =============================== LOCAL STORAGE ===============================
function getContracts() {
    return JSON.parse(localStorage.getItem("contracts")) || [];
}
function saveContracts(data) {
    localStorage.setItem("contracts", JSON.stringify(data));
}



// =============================== RENDER TABLE ===============================
function renderContracts() {
    const tbody = document.getElementById("contractsTableBody");
    const search = document.getElementById("searchContracts").value.toLowerCase();
    const statusFilter = document.getElementById("contractStatusFilter").dataset.selected || "all";

    let contracts = getContracts();

    // Filter by search
    contracts = contracts.filter(c =>
        c.title.toLowerCase().includes(search) ||
        c.project.toLowerCase().includes(search)
    );

    // Filter by status
    if (statusFilter !== "all") {
        contracts = contracts.filter(c => c.status === statusFilter);
    }

    if (contracts.length === 0) {
        tbody.innerHTML = `
            <tr><td colspan="8" class="text-center py-3 text-muted">No record found</td></tr>
        `;
        return;
    }

    tbody.innerHTML = contracts.map((c, i) => `
        <tr>
            <td>${c.id}</td>
            <td>${c.title}</td>
            <td>${c.project || "-"}</td>
            <td>${c.startDate}</td>
            <td>${c.endDate}</td>
            <td>₹${c.amount}</td>
            <td><span class="badge bg-success">${c.status}</span></td>

            <td>
                <button class="btn btn-sm btn-outline-primary me-1"
                        onclick="openEditContract(${c.id})">
                    Edit
                </button>

                <button class="btn btn-sm btn-outline-danger"
                        onclick="openDeleteContract(${c.id})">
                    Delete
                </button>
            </td>
        </tr>
    `).join('');
}



// =============================== ADD CONTRACT ===============================
document.getElementById("saveContract").addEventListener("click", function () {
    const id = document.getElementById("contractId").value.trim();
    const title = document.getElementById("contractTitle").value.trim();
    const start = document.getElementById("contractStart").value;
    const end = document.getElementById("contractEnd").value;
    const amount = document.getElementById("contractAmount").value.trim();
    const project = document.getElementById("contractProject").value.trim() || "-";

    if (!id || !title || !start || !end || !amount) {
        alert("Please fill all required fields");
        return;
    }

    const contracts = getContracts();

    contracts.push({
        id,
        title,
        startDate: start,
        endDate: end,
        amount,
        project,
        status: "active"
    });

    saveContracts(contracts);

    document.querySelector("#addContractModal .btn-close").click();
    document.getElementById("addContractForm").reset();

    renderContracts();
});



// =============================== OPEN EDIT MODAL ===============================
let currentEditId = null;

function openEditContract(id) {
    const contract = getContracts().find(c => c.id == id);
    if (!contract) return;

    currentEditId = id;

    document.getElementById("editContractId").value = id;
    document.getElementById("editContractTitle").value = contract.title;
    document.getElementById("editContractStart").value = contract.startDate;
    document.getElementById("editContractEnd").value = contract.endDate;
    document.getElementById("editContractAmount").value = contract.amount;
    document.getElementById("editContractProject").value = contract.project;

    new bootstrap.Modal(document.getElementById("editContractModal")).show();
}



// =============================== SAVE EDIT ===============================
document.getElementById("saveContractEdit").addEventListener("click", function () {
    const contracts = getContracts();

    let index = contracts.findIndex(c => c.id == currentEditId);
    if (index === -1) return;

    contracts[index].title = document.getElementById("editContractTitle").value;
    contracts[index].startDate = document.getElementById("editContractStart").value;
    contracts[index].endDate = document.getElementById("editContractEnd").value;
    contracts[index].amount = document.getElementById("editContractAmount").value;
    contracts[index].project = document.getElementById("editContractProject").value;

    saveContracts(contracts);

    document.querySelector("#editContractModal .btn-close").click();
    renderContracts();
});



// =============================== DELETE ===============================
let deleteId = null;

function openDeleteContract(id) {
    deleteId = id;
    new bootstrap.Modal(document.getElementById("deleteContractModal")).show();
}

document.getElementById("confirmDeleteContract").addEventListener("click", function () {
    let contracts = getContracts();
    contracts = contracts.filter(c => c.id != deleteId);
    saveContracts(contracts);

    document.querySelector("#deleteContractModal .btn-close").click();
    renderContracts();
});



// =============================== SEARCH ===============================
document.getElementById("searchContracts").addEventListener("input", renderContracts);



// =============================== STATUS FILTER ===============================
document.querySelectorAll(".contract-filter-status").forEach(btn => {
    btn.addEventListener("click", function () {
        const status = this.dataset.status;
        document.getElementById("contractStatusFilter").dataset.selected = status;
        document.getElementById("contractStatusFilter").innerText = status.charAt(0).toUpperCase() + status.slice(1);
        renderContracts();
    });
});



// =============================== EXPORT EXCEL ===============================
document.getElementById("exportContractsExcel").addEventListener("click", function () {
    const table = document.getElementById("contractsTable");
    const csv = [];
    
    [...table.rows].forEach(row => {
        const cols = [...row.cells].map(cell => `"${cell.innerText}"`);
        csv.push(cols.join(","));
    });

    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = "contracts.csv";
    a.click();
});



// =============================== PRINT ===============================
document.getElementById("printContracts").addEventListener("click", function () {
    const printContent = document.getElementById("contractsTable").outerHTML;
    const win = window.open("", "", "width=900,height=700");
    win.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
    win.document.close();
    win.print();
});



// =============================== INIT ===============================
document.addEventListener("DOMContentLoaded", renderContracts);
// ================= LOCAL STORAGE =================
// ================= LOCAL STORAGE HELPERS =================
function getFiles() {
    return JSON.parse(localStorage.getItem("clientFiles")) || [];
}

function saveFiles(data) {
    localStorage.setItem("clientFiles", JSON.stringify(data));
}



// ================= RENDER FILES TABLE =================
function renderFiles() {
    const tbody = document.getElementById("filesTableBody");
    const search = document.getElementById("fileSearch").value.toLowerCase();

    const files = getFiles().filter(f =>
        f.name.toLowerCase().includes(search)
    );

    if (files.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-3">No files found</td>
            </tr>
        `;
        document.getElementById("filesPaginationText").innerText = "0 files";
        return;
    }

    tbody.innerHTML = files
        .map((f, i) => `
            <tr>
                <td>${i + 1}</td>
                <td><i class="bi bi-file-earmark"></i> ${f.name}</td>
                <td>${f.size}</td>
                <td>
                    <img src="https://i.pravatar.cc/30?img=1"
                         class="rounded-circle me-1" width="25">
                    John Doe
                </td>
                <td>${f.date}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteFile(${f.id})">
                        <i class="bi bi-x"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="downloadFile(${f.id})">
                        <i class="bi bi-download"></i>
                    </button>
                </td>
            </tr>
        `)
        .join("");

    document.getElementById("filesPaginationText").innerText =
        `${files.length} • 1–${files.length} / ${files.length}`;
}



// ================= ADD FILE =================
document.getElementById("saveFile").addEventListener("click", function () {
    const file = document.getElementById("uploadFile").files[0];

    if (!file) {
        alert("Select a file first");
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        let files = getFiles();

        files.push({
            id: Date.now(),
            name: file.name,
            size: (file.size / 1024).toFixed(2) + " KB",
            date: new Date().toLocaleString(),
            base64: e.target.result  // ✔ SAVE BASE64
        });

        saveFiles(files);

        // Close modal + reset input
        document.querySelector("#addFileModal .btn-close").click();
        document.getElementById("uploadFile").value = "";

        renderFiles();
    };

    reader.readAsDataURL(file);
});



// ================= DELETE FILE =================
function deleteFile(id) {
    let files = getFiles().filter(f => f.id !== id);
    saveFiles(files);
    renderFiles();
}



// ================= DOWNLOAD FILE =================
function downloadFile(id) {
    let files = getFiles();
    let file = files.find(f => f.id === id);

    if (!file) {
        alert("File not found");
        return;
    }

    if (!file.base64) {
        alert("This file was saved earlier without Base64. Re-upload it.");
        return;
    }

    const a = document.createElement("a");
    a.href = file.base64;
    a.download = file.name;
    a.click();
}



// ================= SEARCH =================
document.getElementById("fileSearch").addEventListener("keyup", renderFiles);


// ================= INITIAL LOAD =================
document.addEventListener("DOMContentLoaded", renderFiles);

document.addEventListener('DOMContentLoaded', () => {
  // Load expenses from localStorage or empty array
  let expenses = JSON.parse(localStorage.getItem('expenses')) || [];
  let editIndex = null, deleteIndex = null;
  const tableBody = document.getElementById('expenseTableBody');

  function saveToStorage() {
    localStorage.setItem('expenses', JSON.stringify(expenses));
  }

  function renderExpenses(filter = '') {
    tableBody.innerHTML = '';
    expenses
      .map((e, i) => ({...e, id: i+1}))
      .filter(e => e.title.toLowerCase().includes(filter.toLowerCase()))
      .forEach(exp => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${exp.id}</td>
          <td>${exp.title}</td>
          <td>${exp.amount}</td>
          <td>${exp.category}</td>
          <td>${exp.date}</td>
          <td>${exp.addedBy}</td>
          <td>
            <button class="btn btn-sm btn-warning me-1 edit-btn">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn">Delete</button>
          </td>`;
        tableBody.appendChild(tr);

        tr.querySelector('.edit-btn').addEventListener('click', () => {
          editIndex = exp.id - 1;
          document.getElementById('editExpTitle').value = exp.title;
          document.getElementById('editExpAmount').value = exp.amount;
          document.getElementById('editExpCategory').value = exp.category;
          document.getElementById('editExpDate').value = exp.date;
          document.getElementById('editExpAddedBy').value = exp.addedBy;
          new bootstrap.Modal(document.getElementById('editExpenseModal')).show();
        });

        tr.querySelector('.delete-btn').addEventListener('click', () => {
          deleteIndex = exp.id - 1;
          new bootstrap.Modal(document.getElementById('deleteExpenseModal')).show();
        });
      });
  }

  // Add Expense
  document.getElementById('saveExpense').addEventListener('click', () => {
    expenses.push({
      title: document.getElementById('expTitle').value,
      amount: document.getElementById('expAmount').value,
      category: document.getElementById('expCategory').value,
      date: document.getElementById('expDate').value,
      addedBy: document.getElementById('expAddedBy').value
    });
    saveToStorage();
    renderExpenses();
    bootstrap.Modal.getInstance(document.getElementById('addExpenseModal')).hide();
  });

  // Update Expense
  document.getElementById('updateExpense').addEventListener('click', () => {
    expenses[editIndex] = {
      title: document.getElementById('editExpTitle').value,
      amount: document.getElementById('editExpAmount').value,
      category: document.getElementById('editExpCategory').value,
      date: document.getElementById('editExpDate').value,
      addedBy: document.getElementById('editExpAddedBy').value
    };
    saveToStorage();
    renderExpenses();
    bootstrap.Modal.getInstance(document.getElementById('editExpenseModal')).hide();
  });

  // Delete Expense
  document.getElementById('confirmDeleteExpense').addEventListener('click', () => {
    expenses.splice(deleteIndex, 1);
    saveToStorage();
    renderExpenses();
    bootstrap.Modal.getInstance(document.getElementById('deleteExpenseModal')).hide();
  });

  // Search
  document.getElementById('expenseSearch').addEventListener('input', e => renderExpenses(e.target.value));

  // Initial render
  renderExpenses();
  document.addEventListener("DOMContentLoaded", () => {

  // Load JSON file
  fetch("clientsdata.php")
    .then(response => response.json())
    .then(data => {
      loadClientData(data);
    })
    .catch(err => console.error("JSON Load Error:", err));

});


// MAIN FUNCTION TO FILL HTML
function loadClientData(data) {

  // Basic Information
  setText("clientName", data.clientName);
  setText("clientTagline", data.organization);
  setText("organization", data.organization);
  setText("clientMeta", data.meta);

  // Invoice Overview
  setText("overdue", data.invoiceOverview.overdue);
  setText("notPaid", data.invoiceOverview.notPaid);
  setText("partiallyPaid", data.invoiceOverview.partiallyPaid);
  setText("fullyPaid", data.invoiceOverview.fullyPaid);
  setText("draft", data.invoiceOverview.draft);
  setText("totalInvoiced", data.invoiceOverview.totalInvoiced);
  setText("payments", data.invoiceOverview.payments);
  setText("due", data.invoiceOverview.due);

  // Contacts
  setText("contactName", data.contacts.name);
  setText("phone", data.contacts.phone);
  setText("email", data.contacts.email);
  setText("address", data.contacts.address);

  // Recent Invoices List
  loadList("recentInvoices", data.recentInvoices, (item) =>
    `${item.id} — $${item.amount}`
  );

  // Client Info Section
  setText("organizationInfo", data.clientInfo.organization);
  setText("joinedDate", data.clientInfo.joinedDate);
  setText("clientStatus", data.clientInfo.status);

  // Website link + text
  const website = document.getElementById("clientWebsite");
  if (website) {
    website.href = data.clientInfo.website;
    website.textContent = data.clientInfo.website;
  }

  // Tasks List
  loadList("taskList", data.tasks);

  // Notes
  setText("clientNotes", data.notes);

  // Reminders
  loadList("reminderList", data.reminders);
}


// =========================
// Helper Functions
// =========================

// Set innerText safely
function setText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value;
}

// Render array as <li>
function loadList(id, array, formatter = (x) => x) {
  const listEl = document.getElementById(id);

  if (!listEl) return;

  listEl.innerHTML = ""; // clear old list

  if (!array || array.length === 0) {
    listEl.innerHTML = `<li class="list-group-item">No data available.</li>`;
    return;
  }

  array.forEach(item => {
    const li = document.createElement("li");
    li.className = "list-group-item";
    li.textContent = formatter(item);
    listEl.appendChild(li);
  });
}
document.addEventListener("DOMContentLoaded", () => {
    // Only initialize if these elements exist on the page
    const monthLabel = document.getElementById("calendarMonthLabel");
    const weekdaysHeader = document.getElementById("calendarWeekdays");
    const calendarBody = document.getElementById("calendarBody");
    const selectedDateLabel = document.getElementById("selectedDateLabel");
    const dayEventsList = document.getElementById("dayEventsList");
    const prevBtn = document.getElementById("prevMonth");
    const nextBtn = document.getElementById("nextMonth");

    if (!monthLabel || !calendarBody || !weekdaysHeader) {
        // ❌ This page doesn't contain the calendar → Stop
        return;
    }

    // ==========================
    // Calendar variables
    // ==========================
    let current = new Date();

    // Dummy events for demonstration
    const dummyEvents = {
        "2025-02-14": ["Client meeting", "Team review call"],
        "2025-02-20": ["Website deployment"],
        "2025-03-05": ["Invoice reminder"],
    };

    // ==========================
    // Render Weekdays
    // ==========================
    const weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    weekdaysHeader.innerHTML = weekdays
        .map(day => `<th class="text-center">${day}</th>`)
        .join("");

    // ==========================
    // Render Calendar
    // ==========================
    function renderCalendar() {
        const year = current.getFullYear();
        const month = current.getMonth();

        monthLabel.textContent = current.toLocaleDateString("en-US", {
            month: "long",
            year: "numeric"
        });

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        let html = "<tr>";
        let day = 1;

        // Empty cells before the 1st
        for (let i = 0; i < firstDay; i++) html += "<td></td>";

        for (let i = firstDay; i < 7; i++) {
            html += renderDayCell(year, month, day);
            day++;
        }
        html += "</tr>";

        while (day <= lastDate) {
            html += "<tr>";
            for (let i = 0; i < 7 && day <= lastDate; i++) {
                html += renderDayCell(year, month, day);
                day++;
            }
            html += "</tr>";
        }

        calendarBody.innerHTML = html;

        // Attach click event to all date cells
        document.querySelectorAll(".calendar-day").forEach(cell => {
            cell.addEventListener("click", () => {
                const dateKey = cell.dataset.date;
                showEventsForDate(dateKey);
            });
        });
    }

    // ==========================
    // Render single day cell
    // ==========================
    function renderDayCell(year, month, day) {
        const dateKey = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
        const hasEvent = dummyEvents[dateKey];

        return `
            <td class="text-center p-2 calendar-day ${hasEvent ? 'bg-light border-primary' : ''}"
                data-date="${dateKey}"
                style="cursor:pointer;">
                ${day}
                ${hasEvent ? '<span class="d-block badge bg-primary mt-1">•</span>' : ''}
            </td>
        `;
    }

    // ==========================
    // Show events for selected day
    // ==========================
    function showEventsForDate(dateKey) {
        selectedDateLabel.textContent = dateKey;

        dayEventsList.innerHTML = "";

        const events = dummyEvents[dateKey];

        if (!events || events.length === 0) {
            dayEventsList.innerHTML = `
                <li class="list-group-item text-muted">No events for this day.</li>
            `;
            return;
        }

        events.forEach(ev => {
            const li = document.createElement("li");
            li.className = "list-group-item";
            li.textContent = ev;
            dayEventsList.appendChild(li);
        });
    }

    // ==========================
    // Month navigation
    // ==========================
    prevBtn?.addEventListener("click", () => {
        current.setMonth(current.getMonth() - 1);
        renderCalendar();
    });

    nextBtn?.addEventListener("click", () => {
        current.setMonth(current.getMonth() + 1);
        renderCalendar();
    });

    // Initialize calendar
    renderCalendar();
});

// ==================== PROJECTS MODULE ====================

// Load projects from localStorage
let projects = JSON.parse(localStorage.getItem("projectsList")) || [];
let deleteProjectId = null;

// Render Projects Table
function renderProjects() {
    const tbody = document.getElementById("projectsTableBody");
    tbody.innerHTML = "";

    if (projects.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted">No projects found.</td></tr>`;
        return;
    }

    projects.forEach(project => {
        tbody.innerHTML += `
        <tr>
            <td>${project.id}</td>
            <td>${project.title}</td>
            <td>${project.price}</td>
            <td>${project.start}</td>
            <td>${project.deadline}</td>
            <td>
                <div class="progress">
                    <div class="progress-bar" style="width:${project.progress || 0}%"></div>
                </div>
            </td>
            <td><span class="badge bg-${statusColor(project.status)}">${project.status}</span></td>
            <td>
                <button class="btn btn-sm btn-primary" onclick="openEditProject(${project.id})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="openDeleteProject(${project.id})">Delete</button>
            </td>
        </tr>`;
    });
}

function statusColor(status) {
    return {
        open: "info",
        completed: "success",
        hold: "warning",
        canceled: "danger"
    }[status] || "secondary";
}

// Save to localStorage
function saveProjects() {
    localStorage.setItem("projectsList", JSON.stringify(projects));
}

// ==================== ADD PROJECT ====================

document.getElementById("saveProject").addEventListener("click", () => {
    const id = document.getElementById("projectId").value;
    const title = document.getElementById("projectTitle").value;
    const price = document.getElementById("projectPrice").value;
    const start = document.getElementById("projectStartDate").value;
    const deadline = document.getElementById("projectDeadline").value;
    const status = document.getElementById("projectStatus").value;

    if (!id || !title) {
        alert("ID and Title are required!");
        return;
    }

    projects.push({ id, title, price, start, deadline, status, progress: 0 });
    saveProjects();
    renderProjects();

    // Close Add modal cleanly
    const modal = bootstrap.Modal.getInstance(document.getElementById("addProjectModal"));
    modal.hide();
    document.body.classList.remove("modal-open");
    document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());

    document.getElementById("addProjectForm").reset();
});

// ==================== EDIT PROJECT ====================

function openEditProject(id) {
    const p = projects.find(pr => pr.id == id);

    document.getElementById("editProjectId").value = p.id;
    document.getElementById("editProjectTitle").value = p.title;
    document.getElementById("editProjectPrice").value = p.price;
    document.getElementById("editProjectStartDate").value = p.start;
    document.getElementById("editProjectDeadline").value = p.deadline;
    document.getElementById("editProjectStatus").value = p.status;

    new bootstrap.Modal(document.getElementById("editProjectModal")).show();
}

document.getElementById("saveProjectEdit").addEventListener("click", () => {
    const id = document.getElementById("editProjectId").value;
    const project = projects.find(p => p.id == id);

    project.title = document.getElementById("editProjectTitle").value;
    project.price = document.getElementById("editProjectPrice").value;
    project.start = document.getElementById("editProjectStartDate").value;
    project.deadline = document.getElementById("editProjectDeadline").value;
    project.status = document.getElementById("editProjectStatus").value;

    saveProjects();
    renderProjects();

    const modal = bootstrap.Modal.getInstance(document.getElementById("editProjectModal"));
    modal.hide();
    document.body.classList.remove("modal-open");
    document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
});

// ==================== DELETE PROJECT ====================

function openDeleteProject(id) {
    deleteProjectId = id;
    new bootstrap.Modal(document.getElementById("deleteProjectModal")).show();
}
document.getElementById("confirmDeleteProject").addEventListener("click", () => {
    if (deleteProjectId === null) return;

    projects = projects.filter(p => p.id != deleteProjectId);
    saveProjects();
    renderProjects();

    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById("deleteProjectModal"));
    modal.hide();

    deleteProjectId = null; // reset
});


// ==================== STATUS FILTER ====================

document.querySelectorAll(".filter-status").forEach(btn => {
    btn.addEventListener("click", () => {
        const status = btn.dataset.status;

        if (status === "all") {
            renderProjects();
            return;
        }

        const filtered = projects.filter(p => p.status === status);
        const tbody = document.getElementById("projectsTableBody");
        tbody.innerHTML = "";

        filtered.forEach(project => {
            tbody.innerHTML += `
            <tr>
                <td>${project.id}</td>
                <td>${project.title}</td>
                <td>${project.price}</td>
                <td>${project.start}</td>
                <td>${project.deadline}</td>
                <td>
                    <div class="progress"><div class="progress-bar" style="width:${project.progress || 0}%"></div></div>
                </td>
                <td><span class="badge bg-${statusColor(project.status)}">${project.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="openEditProject(${project.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="openDeleteProject(${project.id})">Delete</button>
                </td>
            </tr>`;
        });
    });
});

// ==================== SEARCH ====================

document.getElementById("searchProjects").addEventListener("input", function () {
    const value = this.value.toLowerCase();

    const rows = document.querySelectorAll("#projectsTableBody tr");
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});

// ==================== EXPORT TO EXCEL ====================

document.getElementById("exportProjectsExcel").addEventListener("click", () => {
    let csv = "ID,Title,Price,Start,Deadline,Status\n";

    projects.forEach(p => {
        csv += `${p.id},${p.title},${p.price},${p.start},${p.deadline},${p.status}\n`;
    });

    const blob = new Blob([csv], { type: "text/csv" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");

    a.href = url;
    a.download = "projects.csv";
    a.click();
});

// ==================== PRINT ====================

document.getElementById("printProjects").addEventListener("click", () => {
    const printContent = document.getElementById("projectsTable").outerHTML;
    const windowPrint = window.open("", "", "width=900,height=600");
    windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
    windowPrint.document.close();
    windowPrint.print();
});

// INITIAL RENDER
renderProjects();

// ==================== SUBSCRIPTIONS MODULE ====================
let subscriptions = JSON.parse(localStorage.getItem("subscriptionsList")) || [];
let deleteSubscriptionId = null;

function renderSubscriptions() {
  const tbody = document.getElementById("subscriptionsTableBody");
  tbody.innerHTML = "";

  if (subscriptions.length === 0) {
    tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">No subscriptions found.</td></tr>`;
    return;
  }

  subscriptions.forEach(sub => {
    tbody.innerHTML += `
      <tr>
        <td>${sub.id}</td>
        <td>${sub.name}</td>
        <td>${sub.plan}</td>
        <td>${sub.start}</td>
        <td>${sub.end}</td>
        <td><span class="badge bg-${sub.status==='active'?'success':'danger'}">${sub.status}</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="openEditSubscription(${sub.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDeleteSubscription(${sub.id})">Delete</button>
        </td>
      </tr>`;
  });
}

// Add subscription
document.getElementById("saveSubscription").addEventListener("click", () => {
  const id = document.getElementById("subscriptionId").value;
  const name = document.getElementById("subscriptionName").value;
  const plan = document.getElementById("subscriptionPlan").value;
  const start = document.getElementById("subscriptionStartDate").value;
  const end = document.getElementById("subscriptionEndDate").value;
  const status = document.getElementById("subscriptionStatus").value;

  subscriptions.push({ id, name, plan, start, end, status });
  localStorage.setItem("subscriptionsList", JSON.stringify(subscriptions));
  renderSubscriptions();

const modalEl = document.getElementById("addSubscriptionModal");
bootstrap.Modal.getOrCreateInstance(modalEl).hide(); // ensures instance exists
document.body.classList.remove("modal-open");          // remove body blur
document.querySelectorAll(".modal-backdrop").forEach(el => el.remove()); // remove leftover backdrop
document.getElementById("addSubscriptionForm").reset();

  document.getElementById("addSubscriptionForm").reset();
});

// Edit subscription
function openEditSubscription(id) {
  const sub = subscriptions.find(s => s.id == id);
  document.getElementById("editSubscriptionId").value = sub.id;
  document.getElementById("editSubscriptionName").value = sub.name;
  document.getElementById("editSubscriptionPlan").value = sub.plan;
  document.getElementById("editSubscriptionStartDate").value = sub.start;
  document.getElementById("editSubscriptionEndDate").value = sub.end;
  document.getElementById("editSubscriptionStatus").value = sub.status;

  new bootstrap.Modal(document.getElementById("editSubscriptionModal")).show();
}

document.getElementById("saveSubscriptionEdit").addEventListener("click", () => {
  const id = document.getElementById("editSubscriptionId").value;
  const sub = subscriptions.find(s => s.id == id);

  sub.name = document.getElementById("editSubscriptionName").value;
  sub.plan = document.getElementById("editSubscriptionPlan").value;
  sub.start = document.getElementById("editSubscriptionStartDate").value;
  sub.end = document.getElementById("editSubscriptionEndDate").value;
  sub.status = document.getElementById("editSubscriptionStatus").value;

  localStorage.setItem("subscriptionsList", JSON.stringify(subscriptions));
  renderSubscriptions();

  const modal = bootstrap.Modal.getInstance(document.getElementById("editSubscriptionModal"));
  modal.hide();
});

// Delete subscription
function openDeleteSubscription(id) {
  deleteSubscriptionId = id;
  new bootstrap.Modal(document.getElementById("deleteSubscriptionModal")).show();
}
document.getElementById("confirmDeleteSubscription").addEventListener("click", () => {
  subscriptions = subscriptions.filter(s => s.id != deleteSubscriptionId);
  localStorage.setItem("subscriptionsList", JSON.stringify(subscriptions));
  renderSubscriptions();
  const modal = bootstrap.Modal.getInstance(document.getElementById("deleteSubscriptionModal"));
  modal.hide();
});

// Search
document.getElementById("searchSubscriptions").addEventListener("input", function() {
  const value = this.value.toLowerCase();
  document.querySelectorAll("#subscriptionsTableBody tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
  });
});

// Filter
document.querySelectorAll(".filter-status-sub").forEach(btn => {
  btn.addEventListener("click", () => {
    const status = btn.dataset.status;
    if (status === "all") return renderSubscriptions();
    const filtered = subscriptions.filter(s => s.status === status);
    const tbody = document.getElementById("subscriptionsTableBody");
    tbody.innerHTML = "";
    filtered.forEach(sub => {
      tbody.innerHTML += `
        <tr>
          <td>${sub.id}</td>
          <td>${sub.name}</td>
          <td>${sub.plan}</td>
          <td>${sub.start}</td>
          <td>${sub.end}</td>
          <td><span class="badge bg-${sub.status==='active'?'success':'danger'}">${sub.status}</span></td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditSubscription(${sub.id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openDeleteSubscription(${sub.id})">Delete</button>
          </td>
        </tr>`;
    });
  });
});

// Export
document.getElementById("exportSubscriptionsExcel").addEventListener("click", () => {
  let csv = "ID,Name,Plan,Start,End,Status\n";
  subscriptions.forEach(s => {
    csv += `${s.id},${s.name},${s.plan},${s.start},${s.end},${s.status}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "subscriptions.csv";
  a.click();
});

// Print
document.getElementById("printSubscriptions").addEventListener("click", () => {
  const printContent = document.getElementById("subscriptionsTable").outerHTML;
  const windowPrint = window.open("", "", "width=900,height=600");
  windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
  windowPrint.document.close();
  windowPrint.print();
});

// Initial render
renderSubscriptions();
// ==================== INVOICES MODULE ====================
let invoices = JSON.parse(localStorage.getItem("invoicesList")) || [];
let deleteInvoiceId = null;

// ---------------- Helper to close modal and reset form ----------------
function closeModal(modalId, formId = null) {
  const modalEl = document.getElementById(modalId);
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();

  if (formId) {
    const form = document.getElementById(formId);
    if (form) form.reset();
  }
}

// ---------------- Render invoices ----------------
function renderInvoices() {
  const tbody = document.getElementById("invoicesTableBody");
  tbody.innerHTML = "";

  if (!invoices.length) {
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No invoices found.</td></tr>`;
    return;
  }

  invoices.forEach(inv => {
    tbody.innerHTML += `
      <tr>
        <td>${inv.id}</td>
        <td>${inv.title}</td>
        <td>${inv.amount}</td>
        <td>${inv.date}</td>
        <td><span class="badge bg-${inv.status==='paid'?'success':inv.status==='unpaid'?'danger':'secondary'}">${inv.status}</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="openEditInvoice(${inv.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDeleteInvoice(${inv.id})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// ---------------- Add Invoice ----------------
document.getElementById("saveInvoice").addEventListener("click", () => {
  const id = document.getElementById("invoiceId").value;
  const title = document.getElementById("invoiceTitle").value;
  const amount = document.getElementById("invoiceAmount").value;
  const date = document.getElementById("invoiceDate").value;
  const status = document.getElementById("invoiceStatus").value;

  invoices.push({ id, title, amount, date, status });
  localStorage.setItem("invoicesList", JSON.stringify(invoices));
  renderInvoices();

  closeModal("addInvoiceModal", "addInvoiceForm");
});

// ---------------- Edit Invoice ----------------
function openEditInvoice(id) {
  const inv = invoices.find(i => i.id == id);
  document.getElementById("editInvoiceId").value = inv.id;
  document.getElementById("editInvoiceTitle").value = inv.title;
  document.getElementById("editInvoiceAmount").value = inv.amount;
  document.getElementById("editInvoiceDate").value = inv.date;
  document.getElementById("editInvoiceStatus").value = inv.status;

  new bootstrap.Modal(document.getElementById("editInvoiceModal")).show();
}

document.getElementById("saveInvoiceEdit").addEventListener("click", () => {
  const id = document.getElementById("editInvoiceId").value;
  const inv = invoices.find(i => i.id == id);

  inv.title = document.getElementById("editInvoiceTitle").value;
  inv.amount = document.getElementById("editInvoiceAmount").value;
  inv.date = document.getElementById("editInvoiceDate").value;
  inv.status = document.getElementById("editInvoiceStatus").value;

  localStorage.setItem("invoicesList", JSON.stringify(invoices));
  renderInvoices();

  closeModal("editInvoiceModal");
});

// ---------------- Delete Invoice ----------------
function openDeleteInvoice(id) {
  deleteInvoiceId = id;
  new bootstrap.Modal(document.getElementById("deleteInvoiceModal")).show();
}

document.getElementById("confirmDeleteInvoice").addEventListener("click", () => {
  invoices = invoices.filter(i => i.id != deleteInvoiceId);
  localStorage.setItem("invoicesList", JSON.stringify(invoices));
  renderInvoices();

  closeModal("deleteInvoiceModal");
});

// ---------------- Search ----------------
document.getElementById("searchInvoices").addEventListener("input", function() {
  const value = this.value.toLowerCase();
  document.querySelectorAll("#invoicesTableBody tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
  });
});

// ---------------- Filter ----------------
document.querySelectorAll(".filter-status-inv").forEach(btn => {
  btn.addEventListener("click", () => {
    const status = btn.dataset.status;
    const tbody = document.getElementById("invoicesTableBody");
    tbody.innerHTML = "";

    let filtered = invoices;
    if (status !== "all") filtered = invoices.filter(i => i.status === status);

    filtered.forEach(inv => {
      tbody.innerHTML += `
        <tr>
          <td>${inv.id}</td>
          <td>${inv.title}</td>
          <td>${inv.amount}</td>
          <td>${inv.date}</td>
          <td><span class="badge bg-${inv.status==='paid'?'success':inv.status==='unpaid'?'danger':'secondary'}">${inv.status}</span></td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditInvoice(${inv.id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openDeleteInvoice(${inv.id})">Delete</button>
          </td>
        </tr>
      `;
    });
  });
});

// ---------------- Export CSV ----------------
document.getElementById("exportInvoicesExcel").addEventListener("click", () => {
  let csv = "ID,Title,Amount,Date,Status\n";
  invoices.forEach(inv => {
    csv += `${inv.id},${inv.title},${inv.amount},${inv.date},${inv.status}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "invoices.csv";
  a.click();
});

// ---------------- Print ----------------
document.getElementById("printInvoices").addEventListener("click", () => {
  const printContent = document.getElementById("invoicesTable").outerHTML;
  const windowPrint = window.open("", "", "width=900,height=600");
  windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
  windowPrint.document.close();
  windowPrint.print();
});

// ---------------- Initial render ----------------
renderInvoices();
// ==================== PAYMENTS MODULE ====================
let payments = JSON.parse(localStorage.getItem("paymentsList")) || [];
let deletePaymentId = null;

// Function to render table
function renderPayments() {
  const tbody = document.getElementById("paymentsTableBody");
  tbody.innerHTML = "";

  if (!payments.length) {
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No payments found.</td></tr>`;
    return;
  }

  payments.forEach(pay => {
    tbody.innerHTML += `
      <tr>
        <td>${pay.id}</td>
        <td>${pay.payer}</td>
        <td>${pay.amount}</td>
        <td>${pay.date}</td>
        <td><span class="badge bg-${pay.status==='paid'?'success':pay.status==='pending'?'warning':'danger'}">${pay.status}</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="openEditPayment(${pay.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDeletePayment(${pay.id})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// Helper to close modal and reset form
function closeModal(modalId, formId=null) {
  const modalEl = document.getElementById(modalId);
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
  if (formId) document.getElementById(formId).reset();
}

// Add Payment
document.getElementById("savePayment").addEventListener("click", (e) => {
  e.preventDefault(); // prevents any form submission
  const id = document.getElementById("paymentId").value;
  const payer = document.getElementById("paymentPayer").value;
  const amount = document.getElementById("paymentAmount").value;
  const date = document.getElementById("paymentDate").value;
  const status = document.getElementById("paymentStatus").value;

  payments.push({ id, payer, amount, date, status });
  localStorage.setItem("paymentsList", JSON.stringify(payments));
  renderPayments();

  closeModal("addPaymentModal", "addPaymentForm");
});


// Open Edit Payment Modal
function openEditPayment(id) {
  const pay = payments.find(p => p.id == id);
  document.getElementById("editPaymentId").value = pay.id;
  document.getElementById("editPaymentPayer").value = pay.payer;
  document.getElementById("editPaymentAmount").value = pay.amount;
  document.getElementById("editPaymentDate").value = pay.date;
  document.getElementById("editPaymentStatus").value = pay.status;

  new bootstrap.Modal(document.getElementById("editPaymentModal")).show();
}

// Save Edited Payment
document.getElementById("savePaymentEdit").addEventListener("click", () => {
  const id = document.getElementById("editPaymentId").value;
  const pay = payments.find(p => p.id == id);

  pay.payer = document.getElementById("editPaymentPayer").value;
  pay.amount = document.getElementById("editPaymentAmount").value;
  pay.date = document.getElementById("editPaymentDate").value;
  pay.status = document.getElementById("editPaymentStatus").value;

  localStorage.setItem("paymentsList", JSON.stringify(payments));
  renderPayments();
  closeModal("editPaymentModal");
});

// Delete Payment
function openDeletePayment(id) {
  deletePaymentId = id;
  new bootstrap.Modal(document.getElementById("deletePaymentModal")).show();
}

document.getElementById("confirmDeletePayment").addEventListener("click", () => {
  payments = payments.filter(p => p.id != deletePaymentId);
  localStorage.setItem("paymentsList", JSON.stringify(payments));
  renderPayments();
  closeModal("deletePaymentModal");
});

// Search Payments
document.getElementById("searchPayments").addEventListener("input", function() {
  const value = this.value.toLowerCase();
  document.querySelectorAll("#paymentsTableBody tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
  });
});

// Filter Payments by Status
document.querySelectorAll(".filter-status-payment").forEach(btn => {
  btn.addEventListener("click", () => {
    const status = btn.dataset.status;
    const tbody = document.getElementById("paymentsTableBody");
    tbody.innerHTML = "";

    let filtered = status === "all" ? payments : payments.filter(p => p.status === status);

    filtered.forEach(pay => {
      tbody.innerHTML += `
        <tr>
          <td>${pay.id}</td>
          <td>${pay.payer}</td>
          <td>${pay.amount}</td>
          <td>${pay.date}</td>
          <td><span class="badge bg-${pay.status==='paid'?'success':pay.status==='pending'?'warning':'danger'}">${pay.status}</span></td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditPayment(${pay.id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openDeletePayment(${pay.id})">Delete</button>
          </td>
        </tr>
      `;
    });
  });
});

// Export Payments to CSV
document.getElementById("exportPaymentsExcel").addEventListener("click", () => {
  let csv = "ID,Payer,Amount,Date,Status\n";
  payments.forEach(p => {
    csv += `${p.id},${p.payer},${p.amount},${p.date},${p.status}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "payments.csv";
  a.click();
});

// Print Payments
document.getElementById("printPayments").addEventListener("click", () => {
  const printContent = document.getElementById("paymentsTable").outerHTML;
  const windowPrint = window.open("", "", "width=900,height=600");
  windowPrint.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
  windowPrint.document.close();
  windowPrint.print();
});

// Initial render
renderPayments();
// ===================== LOAD ORDERS FROM LOCAL STORAGE =====================
let orders = JSON.parse(localStorage.getItem("ordersData")) || [];
let editingOrderId = null;

// ===================== SAVE TO LOCAL STORAGE =====================
function saveOrdersToStorage() {
    localStorage.setItem("ordersData", JSON.stringify(orders));
}

// ===================== RENDER ORDERS =====================
function renderOrders() {
    let search = document.getElementById("searchOrders").value.toLowerCase();
    let statusFilter = document.querySelector("#orderStatusFilter").dataset.selected || "all";

    let filtered = orders.filter(order => {
        let matchesSearch =
            order.customer.toLowerCase().includes(search) ||
            order.orderId.toString().includes(search) ||
            order.price.toString().includes(search);

        let matchesStatus = statusFilter === "all" || order.status === statusFilter;

        return matchesSearch && matchesStatus;
    });

    let tbody = document.getElementById("ordersTableBody");
    tbody.innerHTML = "";

    filtered.forEach(order => {
        tbody.innerHTML += `
            <tr>
                <td>${order.orderId}</td>
                <td>${order.customer}</td>
                <td>₹${order.price}</td>
                <td>${order.orderDate}</td>
                <td>${order.deliveryDate}</td>
                <td>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: ${order.progress}%"></div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${getStatusColor(order.status)}">
                        ${capitalize(order.status)}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="openEditOrder(${order.orderId})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="openDeleteOrder(${order.orderId})">Delete</button>
                </td>
            </tr>
        `;
    });

    document.getElementById("orderPaginationText").innerText =
        `${filtered.length} • Showing ${filtered.length}`;
}

// ===================== STATUS COLORS =====================
function getStatusColor(status) {
    switch (status) {
        case "pending": return "warning text-dark";
        case "processing": return "info text-dark";
        case "completed": return "success";
        case "canceled": return "danger";
        default: return "secondary";
    }
}

function capitalize(t) { return t.charAt(0).toUpperCase() + t.slice(1); }

// ===================== ADD ORDER =====================
document.getElementById("saveOrder").addEventListener("click", () => {

    let order = {
        orderId: Number(document.getElementById("orderId").value),
        customer: document.getElementById("orderCustomer").value,
        price: Number(document.getElementById("orderPrice").value),
        orderDate: document.getElementById("orderDate").value,
        deliveryDate: document.getElementById("orderDelivery").value,
        status: document.getElementById("orderStatus").value,
        progress: getAutoProgress(document.getElementById("orderStatus").value)
    };

    orders.push(order);
    saveOrdersToStorage();
    renderOrders();

    // FIX BLUR: Correct modal instance closing
    let addModal = bootstrap.Modal.getInstance(document.getElementById("addOrderModal"));
    addModal.hide();
});

// Progress auto update
function getAutoProgress(status) {
    if (status === "pending") return 0;
    if (status === "processing") return 50;
    if (status === "completed") return 100;
    return 0;
}

// ===================== EDIT ORDER =====================
function openEditOrder(id) {
    editingOrderId = id;
    let order = orders.find(o => o.orderId === id);

    document.getElementById("editOrderCustomer").value = order.customer;
    document.getElementById("editOrderPrice").value = order.price;
    document.getElementById("editOrderDate").value = order.orderDate;
    document.getElementById("editOrderDelivery").value = order.deliveryDate;
    document.getElementById("editOrderStatus").value = order.status;

    new bootstrap.Modal(document.getElementById("editOrderModal")).show();
}

document.getElementById("saveOrderEdit").addEventListener("click", () => {
    let order = orders.find(o => o.orderId === editingOrderId);

    order.customer = document.getElementById("editOrderCustomer").value;
    order.price = Number(document.getElementById("editOrderPrice").value);
    order.orderDate = document.getElementById("editOrderDate").value;
    order.deliveryDate = document.getElementById("editOrderDelivery").value;
    order.status = document.getElementById("editOrderStatus").value;
    order.progress = getAutoProgress(order.status);

    saveOrdersToStorage();
    renderOrders();

    let editModal = bootstrap.Modal.getInstance(document.getElementById("editOrderModal"));
    editModal.hide();
});

// ===================== DELETE =====================
function openDeleteOrder(id) {
    editingOrderId = id;
    new bootstrap.Modal(document.getElementById("deleteOrderModal")).show();
}

document.getElementById("confirmDeleteOrder").addEventListener("click", () => {
    orders = orders.filter(o => o.orderId !== editingOrderId);
    saveOrdersToStorage();
    renderOrders();

    let deleteModal = bootstrap.Modal.getInstance(document.getElementById("deleteOrderModal"));
    deleteModal.hide();
});

// ===================== SEARCH =====================
document.getElementById("searchOrders").addEventListener("input", renderOrders);

// ===================== FILTER =====================
document.querySelectorAll(".filter-order-status").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelector("#orderStatusFilter").innerText = btn.innerText;
        document.querySelector("#orderStatusFilter").dataset.selected = btn.dataset.status;
        renderOrders();
    });
});

// ===================== ON PAGE LOAD =====================
renderOrders();
document.addEventListener("hidden.bs.modal", function () {
  document.body.classList.remove('modal-open');
  const modalBackdrop = document.querySelector('.modal-backdrop');
  if (modalBackdrop) modalBackdrop.remove();
});

// ===== Estimates JS with localStorage, search, filter, export, print =====
(function () {
  const STORAGE_KEY = "estimatesData_v1";

  // state
  let estimates = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  let editingEstimateId = null;

  // elements (safe getters)
  const tbody = document.getElementById("estimatesTableBody");
  const paginationText = document.getElementById("estimatePaginationText");
  const searchInput = document.getElementById("searchEstimates");
  const statusFilterBtn = document.getElementById("estimateStatusFilter");
  const saveBtn = document.getElementById("saveEstimate");
  const saveEditBtn = document.getElementById("saveEstimateEdit");
  const confirmDeleteBtn = document.getElementById("confirmDeleteEstimate");
  const exportBtn = document.getElementById("exportEstimatesExcel");
  const printBtn = document.getElementById("printEstimates");

  // helpers
  function persist() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(estimates));
  }

  function statusBadgeClass(status) {
    // Option B: draft → secondary, sent → info, accepted → success, declined → danger
    switch ((status || "").toLowerCase()) {
      case "draft": return "secondary";
      case "sent": return "info text-dark";
      case "accepted": return "success";
      case "declined": return "danger";
      default: return "secondary";
    }
  }

  function capitalize(s) { return String(s || "").charAt(0).toUpperCase() + String(s || "").slice(1); }

  function getFilterStatus() {
    return statusFilterBtn?.dataset?.selected || "all";
  }

  // Render table
  function renderEstimates() {
    if (!tbody) return;
    const q = (searchInput?.value || "").toLowerCase();
    const filter = getFilterStatus();

    const filtered = estimates.filter(e => {
      const matchesSearch = (
        String(e.id).includes(q) ||
        String(e.client || "").toLowerCase().includes(q) ||
        String(e.estimateNumber || "").toLowerCase().includes(q) ||
        String(e.amount || "").toLowerCase().includes(q)
      );
      const matchesStatus = filter === "all" || (e.status === filter);
      return matchesSearch && matchesStatus;
    });

    tbody.innerHTML = "";

    if (filtered.length === 0) {
      tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-3">No estimates found</td></tr>`;
      paginationText && (paginationText.innerText = "0 • 0–0 / 0");
      return;
    }

    filtered.forEach(e => {
      tbody.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${e.id}</td>
          <td>${escapeHtml(e.client)}</td>
          <td>${escapeHtml(e.estimateNumber)}</td>
          <td>${formatNumber(e.amount)}</td>
          <td>${e.issueDate || ""}</td>
          <td>${e.validTill || ""}</td>
          <td><span class="badge bg-${statusBadgeClass(e.status)}">${capitalize(e.status)}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick="openEditEstimate(${e.id})">Edit</button>
            <button class="btn btn-sm btn-outline-danger" onclick="openDeleteEstimate(${e.id})">Delete</button>
          </td>
        </tr>
      `);
    });

    paginationText && (paginationText.innerText = `${filtered.length} • Showing ${filtered.length} results`);
  }

  // escape to avoid simple XSS when injecting innerHTML
  function escapeHtml(str) {
    if (str === null || str === undefined) return "";
    return String(str)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function formatNumber(n) {
    if (n === null || n === undefined || n === "") return "";
    return Number(n).toLocaleString();
  }

  // Add estimate
  if (saveBtn) {
    saveBtn.addEventListener("click", (ev) => {
      // prevent default form submission if inside <form>
      ev.preventDefault?.();

      // gather values
      const idVal = document.getElementById("estimateId")?.value;
      const client = (document.getElementById("estimateClient")?.value || "").trim();
      const number = (document.getElementById("estimateNumber")?.value || "").trim();
      const amount = document.getElementById("estimateAmount")?.value;
      const issueDate = document.getElementById("estimateIssueDate")?.value;
      const validTill = document.getElementById("estimateValidTill")?.value;
      const status = (document.getElementById("estimateStatus")?.value || "draft").toLowerCase();

      if (!idVal || !client || !number) {
        // minimal validation
        alert("Please provide ID, Client and Estimate Number.");
        return;
      }

      const id = Number(idVal);

      // prevent duplicate id
      if (estimates.some(e => e.id === id)) {
        alert("Estimate ID already exists. Choose a different ID.");
        return;
      }

      const newEstimate = {
        id,
        client,
        estimateNumber: number,
        amount: Number(amount) || 0,
        issueDate,
        validTill,
        status
      };

      estimates.push(newEstimate);
      persist();
      renderEstimates();

      // hide modal correctly and reset form
      const addModalEl = document.getElementById("addEstimateModal");
      const addModalInstance = bootstrap.Modal.getInstance(addModalEl) || new bootstrap.Modal(addModalEl);
      addModalInstance.hide();

      const form = document.getElementById("addEstimateForm");
      form && form.reset();
    });
  }

  // Edit helpers (exposed globally for inline onclick)
  window.openEditEstimate = function (id) {
    const est = estimates.find(x => x.id === id);
    if (!est) return alert("Estimate not found.");

    editingEstimateId = id;
    document.getElementById("editEstimateId").value = est.id;
    document.getElementById("editEstimateClient").value = est.client;
    document.getElementById("editEstimateNumber").value = est.estimateNumber;
    document.getElementById("editEstimateAmount").value = est.amount;
    document.getElementById("editEstimateIssueDate").value = est.issueDate;
    document.getElementById("editEstimateValidTill").value = est.validTill;
    document.getElementById("editEstimateStatus").value = est.status;

    const editModalEl = document.getElementById("editEstimateModal");
    new bootstrap.Modal(editModalEl).show();
  };

  // Save edit
  if (saveEditBtn) {
    saveEditBtn.addEventListener("click", (ev) => {
      ev.preventDefault?.();
      const id = editingEstimateId;
      const idx = estimates.findIndex(e => e.id === id);
      if (idx === -1) return alert("Estimate not found.");

      const client = (document.getElementById("editEstimateClient")?.value || "").trim();
      const number = (document.getElementById("editEstimateNumber")?.value || "").trim();
      const amount = document.getElementById("editEstimateAmount")?.value;
      const issueDate = document.getElementById("editEstimateIssueDate")?.value;
      const validTill = document.getElementById("editEstimateValidTill")?.value;
      const status = (document.getElementById("editEstimateStatus")?.value || "draft").toLowerCase();

      if (!client || !number) {
        alert("Please fill client and estimate number.");
        return;
      }

      estimates[idx].client = client;
      estimates[idx].estimateNumber = number;
      estimates[idx].amount = Number(amount) || 0;
      estimates[idx].issueDate = issueDate;
      estimates[idx].validTill = validTill;
      estimates[idx].status = status;

      persist();
      renderEstimates();

      const editModalEl = document.getElementById("editEstimateModal");
      const editModalInstance = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
      editModalInstance.hide();
    });
  }

  // Delete flow
  window.openDeleteEstimate = function (id) {
    editingEstimateId = id;
    const deleteModalEl = document.getElementById("deleteEstimateModal");
    new bootstrap.Modal(deleteModalEl).show();
  };

  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", (ev) => {
      ev.preventDefault?.();
      if (editingEstimateId === null) return;

      estimates = estimates.filter(e => e.id !== editingEstimateId);
      persist();
      renderEstimates();

      const deleteModalEl = document.getElementById("deleteEstimateModal");
      const deleteModalInstance = bootstrap.Modal.getInstance(deleteModalEl) || new bootstrap.Modal(deleteModalEl);
      deleteModalInstance.hide();
    });
  }

  // Search
  searchInput && searchInput.addEventListener("input", renderEstimates);

  // Status filter - clicks on dropdown items should set data-selected on button and re-render
  document.querySelectorAll(".estimate-filter-status").forEach(item => {
    item.addEventListener("click", function (ev) {
      ev.preventDefault();
      const s = this.dataset.status || "all";
      if (statusFilterBtn) {
        statusFilterBtn.innerText = this.innerText;
        statusFilterBtn.dataset.selected = s;
      }
      renderEstimates();
    });
  });

  // Export CSV (all columns)
  exportBtn && exportBtn.addEventListener("click", () => {
    if (!estimates.length) return alert("No estimates to export.");

    const headers = ["ID", "Client", "Estimate Number", "Amount", "Issue Date", "Valid Until", "Status"];
    const rows = estimates.map(e => [
      e.id,
      e.client,
      e.estimateNumber,
      e.amount,
      e.issueDate,
      e.validTill,
      e.status
    ]);

    const csv = [headers, ...rows].map(r => r.map(cell => {
      // escape quotes
      const cellStr = cell === null || cell === undefined ? "" : String(cell);
      return `"${cellStr.replace(/"/g, '""')}"`;
    }).join(",")).join("\n");

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "estimates.csv";
    document.body.appendChild(a);
    a.click();
    a.remove();
  });

  // Print table
  printBtn && printBtn.addEventListener("click", () => {
    const tableHtml = document.getElementById("estimatesTable").outerHTML;
    const w = window.open("", "_blank");
    w.document.write(`
      <html><head>
        <title>Print Estimates</title>
        <link href="${location.origin}/" rel="stylesheet">
        <style>
          body { font-family: Arial, Helvetica, sans-serif; padding: 20px; }
          table { width: 100%; border-collapse: collapse; }
          table, th, td { border: 1px solid #ccc; }
          th, td { padding: 8px 6px; text-align: left; }
        </style>
      </head><body>
      <h3>Estimates</h3>
      ${tableHtml}
      </body></html>`);
    w.document.close();
    w.focus();
    w.print();
    w.close();
  });

  // Utility: remove leftover modal backdrops & classes when any modal hides
  document.addEventListener("hidden.bs.modal", function (e) {
    // remove any stray modal-backdrop left behind
    document.body.classList.remove("modal-open");
    document.querySelectorAll(".modal-backdrop").forEach(n => n.remove());
  });

  // init render
  renderEstimates();

  // expose quick debug helpers if needed
  window._estimates_store = estimates;
})();
// ===== Proposals JS with localStorage, search, filter, export, print =====
(function () {
  const STORAGE_KEY = "proposalsData_v1";
  let proposals = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  let editingProposalId = null;

  const tbody = document.getElementById("proposalsTableBody");
  const paginationText = document.getElementById("proposalPaginationText");
  const searchInput = document.getElementById("searchProposals");
  const statusFilterBtn = document.getElementById("proposalStatusFilter");
  const saveBtn = document.getElementById("saveProposal");
  const saveEditBtn = document.getElementById("saveProposalEdit");
  const confirmDeleteBtn = document.getElementById("confirmDeleteProposal");
  const exportBtn = document.getElementById("exportProposalsExcel");
  const printBtn = document.getElementById("printProposals");

  function persist() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(proposals));
  }

  function statusBadgeClass(status) {
    switch ((status || "").toLowerCase()) {
      case "draft": return "secondary";
      case "sent": return "info text-dark";
      case "accepted": return "success";
      case "rejected": return "danger";
      default: return "secondary";
    }
  }

  function capitalize(s) { return String(s || "").charAt(0).toUpperCase() + String(s || "").slice(1); }
  function getFilterStatus() { return statusFilterBtn?.dataset?.selected || "all"; }

  function escapeHtml(str) {
    if (str === null || str === undefined) return "";
    return String(str)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function formatNumber(n) {
    if (n === null || n === undefined || n === "") return "";
    return Number(n).toLocaleString();
  }

  function renderProposals() {
    if (!tbody) return;
    const q = (searchInput?.value || "").toLowerCase();
    const filter = getFilterStatus();

    const filtered = proposals.filter(p => {
      const matchesSearch = (
        String(p.id).includes(q) ||
        String(p.client || "").toLowerCase().includes(q) ||
        String(p.proposalNumber || "").toLowerCase().includes(q) ||
        String(p.amount || "").toLowerCase().includes(q)
      );
      const matchesStatus = filter === "all" || (p.status === filter);
      return matchesSearch && matchesStatus;
    });

    tbody.innerHTML = "";
    if (filtered.length === 0) {
      tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-3">No proposals found</td></tr>`;
      paginationText && (paginationText.innerText = "0 • 0–0 / 0");
      return;
    }

    filtered.forEach(p => {
      tbody.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${p.id}</td>
          <td>${escapeHtml(p.client)}</td>
          <td>${escapeHtml(p.proposalNumber)}</td>
          <td>${formatNumber(p.amount)}</td>
          <td>${p.date || ""}</td>
          <td>${p.validTill || ""}</td>
          <td><span class="badge bg-${statusBadgeClass(p.status)}">${capitalize(p.status)}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick="openEditProposal(${p.id})">Edit</button>
            <button class="btn btn-sm btn-outline-danger" onclick="openDeleteProposal(${p.id})">Delete</button>
          </td>
        </tr>
      `);
    });

    paginationText && (paginationText.innerText = `${filtered.length} • Showing ${filtered.length} results`);
  }

  // Add
  if (saveBtn) {
    saveBtn.addEventListener("click", function (ev) {
      ev.preventDefault?.();
      const idVal = document.getElementById("proposalId")?.value;
      const client = (document.getElementById("proposalClient")?.value || "").trim();
      const num = (document.getElementById("proposalNumber")?.value || "").trim();
      const amount = document.getElementById("proposalAmount")?.value;
      const date = document.getElementById("proposalDate")?.value;
      const validTill = document.getElementById("proposalValidTill")?.value;
      const status = (document.getElementById("proposalStatus")?.value || "draft").toLowerCase();

      if (!idVal || !client || !num) {
        alert("Please enter ID, Client and Proposal Number.");
        return;
      }
      const id = Number(idVal);
      if (proposals.some(x => x.id === id)) {
        alert("Proposal ID already exists.");
        return;
      }

      const newP = { id, client, proposalNumber: num, amount: Number(amount) || 0, date, validTill, status };
      proposals.push(newP);
      persist();
      renderProposals();

      const addModalEl = document.getElementById("addProposalModal");
      const addModalInstance = bootstrap.Modal.getInstance(addModalEl) || new bootstrap.Modal(addModalEl);
      addModalInstance.hide();

      const form = document.getElementById("addProposalForm");
      form && form.reset();
    });
  }

  // Edit exposed fn
  window.openEditProposal = function (id) {
    const p = proposals.find(x => x.id === id);
    if (!p) return alert("Proposal not found.");
    editingProposalId = id;
    document.getElementById("editProposalId").value = p.id;
    document.getElementById("editProposalClient").value = p.client;
    document.getElementById("editProposalNumber").value = p.proposalNumber;
    document.getElementById("editProposalAmount").value = p.amount;
    document.getElementById("editProposalDate").value = p.date;
    document.getElementById("editProposalValidTill").value = p.validTill;
    document.getElementById("editProposalStatus").value = p.status;

    const editModalEl = document.getElementById("editProposalModal");
    new bootstrap.Modal(editModalEl).show();
  };

  // Save edit
  if (saveEditBtn) {
    saveEditBtn.addEventListener("click", function (ev) {
      ev.preventDefault?.();
      const id = editingProposalId;
      const idx = proposals.findIndex(x => x.id === id);
      if (idx === -1) return alert("Proposal not found.");

      const client = (document.getElementById("editProposalClient")?.value || "").trim();
      const num = (document.getElementById("editProposalNumber")?.value || "").trim();
      const amount = document.getElementById("editProposalAmount")?.value;
      const date = document.getElementById("editProposalDate")?.value;
      const validTill = document.getElementById("editProposalValidTill")?.value;
      const status = (document.getElementById("editProposalStatus")?.value || "draft").toLowerCase();

      if (!client || !num) {
        alert("Please fill client and proposal number.");
        return;
      }

      proposals[idx].client = client;
      proposals[idx].proposalNumber = num;
      proposals[idx].amount = Number(amount) || 0;
      proposals[idx].date = date;
      proposals[idx].validTill = validTill;
      proposals[idx].status = status;

      persist();
      renderProposals();

      const editModalEl = document.getElementById("editProposalModal");
      const editModalInstance = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
      editModalInstance.hide();
    });
  }

  // Delete
  window.openDeleteProposal = function (id) {
    editingProposalId = id;
    const deleteModalEl = document.getElementById("deleteProposalModal");
    new bootstrap.Modal(deleteModalEl).show();
  };

  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", function (ev) {
      ev.preventDefault?.();
      if (editingProposalId === null) return;
      proposals = proposals.filter(x => x.id !== editingProposalId);
      persist();
      renderProposals();
      const deleteModalEl = document.getElementById("deleteProposalModal");
      const deleteModalInstance = bootstrap.Modal.getInstance(deleteModalEl) || new bootstrap.Modal(deleteModalEl);
      deleteModalInstance.hide();
    });
  }

  // Search
  searchInput && searchInput.addEventListener("input", renderProposals);

  // Status filter dropdown items
  document.querySelectorAll(".proposal-filter-status").forEach(item => {
    item.addEventListener("click", function (ev) {
      ev.preventDefault();
      const s = this.dataset.status || "all";
      if (statusFilterBtn) {
        statusFilterBtn.innerText = this.innerText;
        statusFilterBtn.dataset.selected = s;
      }
      renderProposals();
    });
  });

  // Export CSV
  exportBtn && exportBtn.addEventListener("click", function () {
    if (!proposals.length) return alert("No proposals to export.");
    const headers = ["ID", "Client", "Proposal Number", "Amount", "Date", "Valid Until", "Status"];
    const rows = proposals.map(p => [p.id, p.client, p.proposalNumber, p.amount, p.date, p.validTill, p.status]);
    const csv = [headers, ...rows].map(r => r.map(cell => `"${String(cell||"").replace(/"/g,'""')}"`).join(",")).join("\n");
    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "proposals.csv";
    document.body.appendChild(a);
    a.click();
    a.remove();
  });

  // Print
  printBtn && printBtn.addEventListener("click", function () {
    const tableHtml = document.getElementById("proposalsTable").outerHTML;
    const w = window.open("", "_blank");
    w.document.write(`<html><head><title>Print Proposals</title>
      <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px;}table{width:100%;border-collapse:collapse;}table,th,td{border:1px solid #ccc;}th,td{padding:8px 6px;text-align:left;}</style>
      </head><body><h3>Proposals</h3>${tableHtml}</body></html>`);
    w.document.close();
    w.focus();
    w.print();
    w.close();
  });

  // Remove leftover backdrops when modals hide
  document.addEventListener("hidden.bs.modal", function () {
    document.body.classList.remove("modal-open");
    document.querySelectorAll(".modal-backdrop").forEach(n => n.remove());
  });

  // initial render
  renderProposals();

  // debug helper
  window._proposals_store = proposals;
})();
// =============================== LOCAL STORAGE ===============================
function getContracts() {
    return JSON.parse(localStorage.getItem("contracts")) || [];
}
function saveContracts(data) {
    localStorage.setItem("contracts", JSON.stringify(data));
}



// =============================== RENDER TABLE ===============================
function renderContracts() {
    const tbody = document.getElementById("contractsTableBody");
    const search = document.getElementById("searchContracts").value.toLowerCase();
    const statusFilter = document.getElementById("contractStatusFilter").dataset.selected || "all";

    let contracts = getContracts();

    // Filter by search
    contracts = contracts.filter(c =>
        c.title.toLowerCase().includes(search) ||
        c.project.toLowerCase().includes(search)
    );

    // Filter by status
    if (statusFilter !== "all") {
        contracts = contracts.filter(c => c.status === statusFilter);
    }

    if (contracts.length === 0) {
        tbody.innerHTML = `
            <tr><td colspan="8" class="text-center py-3 text-muted">No record found</td></tr>
        `;
        return;
    }

    tbody.innerHTML = contracts.map((c, i) => `
        <tr>
            <td>${c.id}</td>
            <td>${c.title}</td>
            <td>${c.project || "-"}</td>
            <td>${c.startDate}</td>
            <td>${c.endDate}</td>
            <td>₹${c.amount}</td>
            <td><span class="badge bg-success">${c.status}</span></td>

            <td>
                <button class="btn btn-sm btn-outline-primary me-1"
                        onclick="openEditContract(${c.id})">
                    Edit
                </button>

                <button class="btn btn-sm btn-outline-danger"
                        onclick="openDeleteContract(${c.id})">
                    Delete
                </button>
            </td>
        </tr>
    `).join('');
}



// =============================== ADD CONTRACT ===============================
document.getElementById("saveContract").addEventListener("click", function () {
    const id = document.getElementById("contractId").value.trim();
    const title = document.getElementById("contractTitle").value.trim();
    const start = document.getElementById("contractStart").value;
    const end = document.getElementById("contractEnd").value;
    const amount = document.getElementById("contractAmount").value.trim();
    const project = document.getElementById("contractProject").value.trim() || "-";

    if (!id || !title || !start || !end || !amount) {
        alert("Please fill all required fields");
        return;
    }

    const contracts = getContracts();

    contracts.push({
        id,
        title,
        startDate: start,
        endDate: end,
        amount,
        project,
        status: "active"
    });

    saveContracts(contracts);

    document.querySelector("#addContractModal .btn-close").click();
    document.getElementById("addContractForm").reset();

    renderContracts();
});



// =============================== OPEN EDIT MODAL ===============================
let currentEditId = null;

function openEditContract(id) {
    const contract = getContracts().find(c => c.id == id);
    if (!contract) return;

    currentEditId = id;

    document.getElementById("editContractId").value = id;
    document.getElementById("editContractTitle").value = contract.title;
    document.getElementById("editContractStart").value = contract.startDate;
    document.getElementById("editContractEnd").value = contract.endDate;
    document.getElementById("editContractAmount").value = contract.amount;
    document.getElementById("editContractProject").value = contract.project;

    new bootstrap.Modal(document.getElementById("editContractModal")).show();
}



// =============================== SAVE EDIT ===============================
document.getElementById("saveContractEdit").addEventListener("click", function () {
    const contracts = getContracts();

    let index = contracts.findIndex(c => c.id == currentEditId);
    if (index === -1) return;

    contracts[index].title = document.getElementById("editContractTitle").value;
    contracts[index].startDate = document.getElementById("editContractStart").value;
    contracts[index].endDate = document.getElementById("editContractEnd").value;
    contracts[index].amount = document.getElementById("editContractAmount").value;
    contracts[index].project = document.getElementById("editContractProject").value;

    saveContracts(contracts);

    document.querySelector("#editContractModal .btn-close").click();
    renderContracts();
});



// =============================== DELETE ===============================
let deleteId = null;

function openDeleteContract(id) {
    deleteId = id;
    new bootstrap.Modal(document.getElementById("deleteContractModal")).show();
}

document.getElementById("confirmDeleteContract").addEventListener("click", function () {
    let contracts = getContracts();
    contracts = contracts.filter(c => c.id != deleteId);
    saveContracts(contracts);

    document.querySelector("#deleteContractModal .btn-close").click();
    renderContracts();
});



// =============================== SEARCH ===============================
document.getElementById("searchContracts").addEventListener("input", renderContracts);



// =============================== STATUS FILTER ===============================
document.querySelectorAll(".contract-filter-status").forEach(btn => {
    btn.addEventListener("click", function () {
        const status = this.dataset.status;
        document.getElementById("contractStatusFilter").dataset.selected = status;
        document.getElementById("contractStatusFilter").innerText = status.charAt(0).toUpperCase() + status.slice(1);
        renderContracts();
    });
});



// =============================== EXPORT EXCEL ===============================
document.getElementById("exportContractsExcel").addEventListener("click", function () {
    const table = document.getElementById("contractsTable");
    const csv = [];
    
    [...table.rows].forEach(row => {
        const cols = [...row.cells].map(cell => `"${cell.innerText}"`);
        csv.push(cols.join(","));
    });

    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = "contracts.csv";
    a.click();
});



// =============================== PRINT ===============================
document.getElementById("printContracts").addEventListener("click", function () {
    const printContent = document.getElementById("contractsTable").outerHTML;
    const win = window.open("", "", "width=900,height=700");
    win.document.write(`<html><head><title>Print</title></head><body>${printContent}</body></html>`);
    win.document.close();
    win.print();
});



// =============================== INIT ===============================
document.addEventListener("DOMContentLoaded", renderContracts);
// ================= LOCAL STORAGE =================
// ================= LOCAL STORAGE HELPERS =================
function getFiles() {
    return JSON.parse(localStorage.getItem("clientFiles")) || [];
}

function saveFiles(data) {
    localStorage.setItem("clientFiles", JSON.stringify(data));
}



// ================= RENDER FILES TABLE =================
function renderFiles() {
    const tbody = document.getElementById("filesTableBody");
    const search = document.getElementById("fileSearch").value.toLowerCase();

    const files = getFiles().filter(f =>
        f.name.toLowerCase().includes(search)
    );

    if (files.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-3">No files found</td>
            </tr>
        `;
        document.getElementById("filesPaginationText").innerText = "0 files";
        return;
    }

    tbody.innerHTML = files
        .map((f, i) => `
            <tr>
                <td>${i + 1}</td>
                <td><i class="bi bi-file-earmark"></i> ${f.name}</td>
                <td>${f.size}</td>
                <td>
                    <img src="https://i.pravatar.cc/30?img=1"
                         class="rounded-circle me-1" width="25">
                    John Doe
                </td>
                <td>${f.date}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteFile(${f.id})">
                        <i class="bi bi-x"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="downloadFile(${f.id})">
                        <i class="bi bi-download"></i>
                    </button>
                </td>
            </tr>
        `)
        .join("");

    document.getElementById("filesPaginationText").innerText =
        `${files.length} • 1–${files.length} / ${files.length}`;
}



// ================= ADD FILE =================
document.getElementById("saveFile").addEventListener("click", function () {
    const file = document.getElementById("uploadFile").files[0];

    if (!file) {
        alert("Select a file first");
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        let files = getFiles();

        files.push({
            id: Date.now(),
            name: file.name,
            size: (file.size / 1024).toFixed(2) + " KB",
            date: new Date().toLocaleString(),
            base64: e.target.result  // ✔ SAVE BASE64
        });

        saveFiles(files);

        // Close modal + reset input
        document.querySelector("#addFileModal .btn-close").click();
        document.getElementById("uploadFile").value = "";

        renderFiles();
    };

    reader.readAsDataURL(file);
});



// ================= DELETE FILE =================
function deleteFile(id) {
    let files = getFiles().filter(f => f.id !== id);
    saveFiles(files);
    renderFiles();
}



// ================= DOWNLOAD FILE =================
function downloadFile(id) {
    let files = getFiles();
    let file = files.find(f => f.id === id);

    if (!file) {
        alert("File not found");
        return;
    }

    if (!file.base64) {
        alert("This file was saved earlier without Base64. Re-upload it.");
        return;
    }

    const a = document.createElement("a");
    a.href = file.base64;
    a.download = file.name;
    a.click();
}



// ================= SEARCH =================
document.getElementById("fileSearch").addEventListener("keyup", renderFiles);


// ================= INITIAL LOAD =================
document.addEventListener("DOMContentLoaded", renderFiles);

document.addEventListener('DOMContentLoaded', () => {
  // Load expenses from localStorage or empty array
  let expenses = JSON.parse(localStorage.getItem('expenses')) || [];
  let editIndex = null, deleteIndex = null;
  const tableBody = document.getElementById('expenseTableBody');

  function saveToStorage() {
    localStorage.setItem('expenses', JSON.stringify(expenses));
  }

  function renderExpenses(filter = '') {
    tableBody.innerHTML = '';
    expenses
      .map((e, i) => ({...e, id: i+1}))
      .filter(e => e.title.toLowerCase().includes(filter.toLowerCase()))
      .forEach(exp => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${exp.id}</td>
          <td>${exp.title}</td>
          <td>${exp.amount}</td>
          <td>${exp.category}</td>
          <td>${exp.date}</td>
          <td>${exp.addedBy}</td>
          <td>
            <button class="btn btn-sm btn-warning me-1 edit-btn">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn">Delete</button>
          </td>`;
        tableBody.appendChild(tr);

        tr.querySelector('.edit-btn').addEventListener('click', () => {
          editIndex = exp.id - 1;
          document.getElementById('editExpTitle').value = exp.title;
          document.getElementById('editExpAmount').value = exp.amount;
          document.getElementById('editExpCategory').value = exp.category;
          document.getElementById('editExpDate').value = exp.date;
          document.getElementById('editExpAddedBy').value = exp.addedBy;
          new bootstrap.Modal(document.getElementById('editExpenseModal')).show();
        });

        tr.querySelector('.delete-btn').addEventListener('click', () => {
          deleteIndex = exp.id - 1;
          new bootstrap.Modal(document.getElementById('deleteExpenseModal')).show();
        });
      });
  }

  // Add Expense
  document.getElementById('saveExpense').addEventListener('click', () => {
    expenses.push({
      title: document.getElementById('expTitle').value,
      amount: document.getElementById('expAmount').value,
      category: document.getElementById('expCategory').value,
      date: document.getElementById('expDate').value,
      addedBy: document.getElementById('expAddedBy').value
    });
    saveToStorage();
    renderExpenses();
    bootstrap.Modal.getInstance(document.getElementById('addExpenseModal')).hide();
  });

  // Update Expense
  document.getElementById('updateExpense').addEventListener('click', () => {
    expenses[editIndex] = {
      title: document.getElementById('editExpTitle').value,
      amount: document.getElementById('editExpAmount').value,
      category: document.getElementById('editExpCategory').value,
      date: document.getElementById('editExpDate').value,
      addedBy: document.getElementById('editExpAddedBy').value
    };
    saveToStorage();
    renderExpenses();
    bootstrap.Modal.getInstance(document.getElementById('editExpenseModal')).hide();
  });

  // Delete Expense
  document.getElementById('confirmDeleteExpense').addEventListener('click', () => {
    expenses.splice(deleteIndex, 1);
    saveToStorage();
    renderExpenses();
    bootstrap.Modal.getInstance(document.getElementById('deleteExpenseModal')).hide();
  });

  // Search
  document.getElementById('expenseSearch').addEventListener('input', e => renderExpenses(e.target.value));

  // Initial render
  renderExpenses();
});

});

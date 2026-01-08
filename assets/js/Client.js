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
    let tbody = document.getElementById("contactsBody");
    tbody.innerHTML = "";

    data.forEach((c, index) => {
        tbody.innerHTML += `
            <tr>
                <td><img src="assets/images/users/avatar-6.jpg" width="32" class="rounded-circle"></td>

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

                <td>${c.job_title}</td>
                <td>${c.email}</td>
                <td>${c.phone}</td>
                <td>${c.skype}</td>

                <td>
                    <i class="bi bi-x-lg text-danger delete-btn"
                       style="cursor:pointer;"
                       data-index="${index}">
                    </i>
                </td>
            </tr>
        `;
    });

    attachDeleteEvents();
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


document.getElementById("confirmDeleteBtn").addEventListener("click", function () {
    let contacts = JSON.parse(localStorage.getItem("contacts")) || [];

    contacts.splice(deleteIndex, 1);

    localStorage.setItem("contacts", JSON.stringify(contacts));

    renderContacts(contacts);
    updateStatsCard();

    let modal = bootstrap.Modal.getInstance(document.getElementById("deleteContactModal"));
    modal.hide();
});


// ========================= UPDATE CONTACT COUNT =========================
function updateStatsCard() {
    let contacts = JSON.parse(localStorage.getItem("contacts")) || [];
    let counter = document.getElementById("totalContactsCount");

    if (counter) counter.innerText = contacts.length;
}


// ========================= ADD CONTACT =========================
document.getElementById("addContactForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let contacts = JSON.parse(localStorage.getItem("contacts")) || [];

    let newContact = {
        id: Date.now(),
        name: this.name.value,
        client_name: this.client.value,
        job_title: this.job.value,
        email: this.email.value,
        phone: this.phone.value,
        skype: this.skype.value
    };

    contacts.push(newContact);

    localStorage.setItem("contacts", JSON.stringify(contacts));

    renderContacts(contacts);
    updateStatsCard();

    let modal = bootstrap.Modal.getInstance(document.getElementById("addContactModal"));
    modal.hide();

    this.reset();

    let successModal = new bootstrap.Modal(document.getElementById("successModal"));
    successModal.show();
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


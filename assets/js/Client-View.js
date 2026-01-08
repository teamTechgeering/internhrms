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


document.addEventListener("DOMContentLoaded", () => {
  
  let invoicesData = [];
  let filteredData = [];
  let currentType = "invoice"; 
  let activeFilter = "all"; 
  let currentPage = 1;
  let pageSize = 10;

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

  // Fetch Data
  fetch("invoices_json.php")
    .then(r => r.json())
    .then(data => {
      invoicesData = data;
      applyAllFiltersAndRender();
      fillPaymentInvoiceSelect();
      updateAlertCount();
    });

  // RENDER INVOICES
  function renderInvoices(data) {
    invoiceBody.innerHTML = "";
    data.forEach(inv => {
      const billText = inv.bill_date ? formatDate(inv.bill_date) : "-";
      const dueText = inv.due_date ? formatDate(inv.due_date) : "-";
      const statusHtml = getStatusBadge(inv.status);

      invoiceBody.insertAdjacentHTML("beforeend", `
        <tr data-id="${inv.id}">
        
          <!-- CLICKABLE BLUE INVOICE ID (no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary fw-semibold text-decoration-none btn-view-invoice" data-id="${inv.id}">
              ${inv.id}
            </button>
          </td>

          <!-- CLIENT (clickable, blue, no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary text-decoration-none btn-view-client" data-id="${inv.id}" data-client="${escapeHtml(inv.client)}">
              ${escapeHtml(inv.client)}
            </button>
          </td>

          <!-- PROJECT (clickable, blue, no underline) -->
          <td>
            <button class="btn btn-link p-0 text-primary text-decoration-none btn-view-project" data-id="${inv.id}" data-project="${escapeHtml(inv.project)}">
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

                <li><button class="dropdown-item btn-edit" data-id="${inv.id}">Edit</button></li>
                <li><button class="dropdown-item btn-delete" data-id="${inv.id}">Delete</button></li>
                <li><button class="dropdown-item btn-add-payment" data-id="${inv.id}">Add Payment</button></li>

              </ul>
            </div>
          </td>
        </tr>
      `);
    });
  }

  function getStatusBadge(status) {
    if (!status || status === "-") return "-";
    if (status === "Overdue") return `<span class="badge bg-danger">${status}</span>`;
    if (status === "Fully paid") return `<span class="badge bg-primary">${status}</span>`;
    if (status === "Not paid") return `<span class="badge bg-warning text-dark">${status}</span>`;
    return `<span class="badge bg-secondary">${status}</span>`;
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
    return String(s || "").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;");
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
    if (e.target.classList.contains("filter-option")) {
      activeFilter = e.target.dataset.value;
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

    renderPaginatedData();
    calculateTotals(filteredData);
  }

  // PAGINATION FUNCTIONS ------------------------------
  function renderPaginatedData() {
    pageSize = parseInt(pageSizeDropdown.value);

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
        <button class="page-link" data-page="${currentPage - 1}">&lsaquo;</button>
      </li>`
    );

    for (let i = 1; i <= totalPages; i++) {
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
        <button class="page-link" data-page="${currentPage + 1}">&rsaquo;</button>
      </li>`
    );
  }

  paginationNumbers.addEventListener("click", (e) => {
    if (e.target.dataset.page) {
      currentPage = parseInt(e.target.dataset.page);
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

    const csvContent = rows.map(r => r.join(",")).join("\n");
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
    const total = Number(document.getElementById("formTotal").value);
    const status = document.getElementById("formStatus").value;

    const invoice = {
      id, type: "invoice", client, project,
      bill_date: bill, due_date: due, total,
      received: 0, due: total, status
    };

    invoicesData.unshift(invoice);
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
    sel.innerHTML = "";
    invoicesData.forEach(i => {
      sel.innerHTML += `<option value="${i.id}">${i.id} — ${i.client} (${money(i.due)})</option>`;
    });
  }

  document.getElementById("savePayment").addEventListener("click", () => {
    const id = document.getElementById("paymentInvoiceSelect").value;
    const amount = Number(document.getElementById("paymentAmount").value);

    const inv = invoicesData.find(x => x.id === id);
    if (!inv) return;

    inv.received += amount;
    inv.due = inv.total - inv.received;

    if (inv.due <= 0) inv.status = "Fully paid";

    applyAllFiltersAndRender();
    paymentModal.hide();
  });

  // EDIT / DELETE / ADD PAYMENT inside dropdown + NEW CLICK NAVIGATION
  document.addEventListener("click", (e) => {

    if (e.target.classList.contains("btn-edit")) {
      const id = e.target.dataset.id;
      const inv = invoicesData.find(i => i.id === id);
      if (inv) {
        document.getElementById("invoiceModalTitle").innerText = "Edit Invoice";

        document.getElementById("formId").value = inv.id;
        document.getElementById("formClient").value = inv.client;
        document.getElementById("formProject").value = inv.project;
        document.getElementById("formBill").value = inv.bill_date;
        document.getElementById("formDue").value = inv.due_date;
        document.getElementById("formTotal").value = inv.total;
        document.getElementById("formStatus").value = inv.status;

        invoiceModal.show();
      }
    }

    if (e.target.classList.contains("btn-delete")) {
      const id = e.target.dataset.id;
      if (confirm("Are you sure you want to delete this invoice?")) {
        invoicesData = invoicesData.filter(i => i.id !== id);
        applyAllFiltersAndRender();
      }
    }

    if (e.target.classList.contains("btn-add-payment")) {
      const id = e.target.dataset.id;
      document.getElementById("paymentInvoiceSelect").value = id;
      paymentModal.show();
    }

    // CLICKABLE INVOICE → OPEN PAGE
    if (e.target.classList.contains("btn-view-invoice")) {
      const id = e.target.dataset.id;
      window.location.href = `invoice_view.php?id=${id}`;
    }

    // CLICKABLE CLIENT → OPEN PAGE
    if (e.target.classList.contains("btn-view-client")) {
      const clientName = e.target.dataset.client;
      window.location.href = `Client-View.php?client=${encodeURIComponent(clientName)}`;
    }

    // CLICKABLE PROJECT → OPEN PAGE
    if (e.target.classList.contains("btn-view-project")) {
      const projectName = e.target.dataset.project;
      window.location.href = `projects.php?project=${encodeURIComponent(projectName)}`;
    }

  });

});

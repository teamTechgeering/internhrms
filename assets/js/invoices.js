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

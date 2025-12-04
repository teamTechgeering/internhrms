document.addEventListener("DOMContentLoaded", () => {

  const STORAGE_KEY = "contracts_storage_v1";

  let data = [];
  let filtered = [];
  let currentPage = 1;
  let sortKey = null;
  let sortDir = 1;

  // Detect page
  const isViewPage = window.location.pathname.includes("contract_view.php");
  const isListPage = window.location.pathname.includes("contract.php");

  /***************************************************
   * COMMON FUNCTIONS FOR BOTH PAGES
   ***************************************************/
  function loadInitial() {
    return fetch("contract_json.php")
      .then(r => r.json())
      .then(initial => {
        const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
        const map = new Map();
        initial.forEach(i => map.set(i.id, i));
        saved.forEach(s => map.set(s.id, s));
        data = Array.from(map.values());
      });
  }

  function persist() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
  }


  /***************************************************
   * ========== CONTRACT LIST PAGE (contract.php) ==========
   ***************************************************/
  if (isListPage) {

    const contractBody = document.getElementById("contractBody");
    const totalAmountEl = document.getElementById("totalAmount");
    const rowsInfo = document.getElementById("rowsInfo");
    const paginationEl = document.getElementById("pagination");
    const searchBox = document.getElementById("searchBox");
    const pageSizeSelect = document.getElementById("pageSize");

    const modal = new bootstrap.Modal(document.getElementById("contractModal"));
    const titleInput = document.getElementById("title");
    const contractDateInput = document.getElementById("contract_date");
    const validUntilInput = document.getElementById("valid_until");
    const clientInput = document.getElementById("client");
    const projectInput = document.getElementById("project");
    const tax1Input = document.getElementById("tax1");
    const tax2Input = document.getElementById("tax2");
    const amountInput = document.getElementById("amount");
    const statusInput = document.getElementById("status");
    const noteInput = document.getElementById("note");

    function render() {
      const q = searchBox.value.toLowerCase();
      const activeFilter = document.querySelector(".filter-btn.active").dataset.filter;

      filtered = data.filter(d => {
        const matchQ =
          d.title.toLowerCase().includes(q) ||
          d.client.toLowerCase().includes(q) ||
          d.contract_no.toLowerCase().includes(q);

        const matchStatus = activeFilter === "all" || d.status === activeFilter;

        return matchQ && matchStatus;
      });

      if (sortKey) {
        filtered.sort((a, b) => {
          let A = a[sortKey] || "";
          let B = b[sortKey] || "";
          if (sortKey === "amount") {
            return (Number(A) - Number(B)) * sortDir;
          }
          return String(A).localeCompare(String(B)) * sortDir;
        });
      }

      const pageSize = Number(pageSizeSelect.value);
      const total = filtered.length;
      const totalPages = Math.ceil(total / pageSize) || 1;

      if (currentPage > totalPages) currentPage = totalPages;

      const start = (currentPage - 1) * pageSize;
      const pageItems = filtered.slice(start, start + pageSize);

      contractBody.innerHTML = pageItems.map(row => `
        <tr>
          <td><a href="contract_view.php?id=${row.id}" class="text-primary fw-semibold">${row.contract_no}</a></td>
          <td>${row.title}</td>
          <td><a href="Client-view.php?id=${row.id}" class="text-primary">${row.client}</a></td>
          <td>${row.project}</td>
          <td>${row.contract_date}</td>
          <td>${row.valid_until}</td>
          <td class="text-end">$${Number(row.amount).toFixed(2)}</td>
          <td><span class="badge bg-${row.status === 'Accepted' ? 'primary' : row.status === 'Sent' ? 'info' : 'secondary'}">${row.status}</span></td>
          <td class="text-end">
            <div class="btn-group">
              <button class="btn btn-sm btn-light edit-btn" data-id="${row.id}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-light delete-btn" data-id="${row.id}">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      `).join("");

      const sum = filtered.reduce((s, d) => s + Number(d.amount), 0);
      totalAmountEl.innerText = "$" + sum.toFixed(2);

      rowsInfo.innerText = `Showing ${start + 1} - ${Math.min(start + pageItems.length, total)} of ${total}`;

      paginationEl.innerHTML = "";
      for (let i = 1; i <= totalPages; i++) {
        paginationEl.innerHTML += `
          <li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" data-page="${i}" href="#">${i}</a>
          </li>
        `;
      }
    }

    // Sorting
    document.querySelectorAll(".sort").forEach(sortBtn => {
      sortBtn.addEventListener("click", (e) => {
        e.preventDefault();
        const key = sortBtn.dataset.key;
        if (sortKey === key) sortDir = -sortDir;
        else { sortKey = key; sortDir = 1; }
        render();
      });
    });

    paginationEl.addEventListener("click", e => {
      const page = e.target.dataset.page;
      if (!page) return;
      currentPage = Number(page);
      render();
    });

    document.querySelectorAll(".filter-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        document.querySelectorAll(".filter-btn").forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        currentPage = 1;
        render();
      });
    });

    searchBox.addEventListener("input", () => {
      currentPage = 1;
      render();
    });

    pageSizeSelect.addEventListener("change", () => {
      currentPage = 1;
      render();
    });

    // ADD CONTRACT
    document.getElementById("saveContractBtn")?.addEventListener("click", () => {

      const newData = {
        id: Date.now(),
        contract_no: "CONTRACT #" + Date.now(),
        title: titleInput.value.trim(),
        client: clientInput.value.trim(),
        project: projectInput.value.trim() || "-",
        contract_date: contractDateInput.value,
        valid_until: validUntilInput.value,
        tax1: tax1Input.value,
        tax2: tax2Input.value,
        note: noteInput.value,
        amount: Number(amountInput.value),
        status: statusInput.value
      };

      data.unshift(newData);
      persist();
      modal.hide();
      render();

      document.getElementById("contractForm").reset();
    });

    // EDIT
    contractBody.addEventListener("click", e => {
      const btn = e.target.closest(".edit-btn");
      if (btn) {
        window.location.href = `contract_edit.php?id=${btn.dataset.id}`;
      }
    });

    // DELETE
    contractBody.addEventListener("click", e => {
      const del = e.target.closest(".delete-btn");
      if (del) {
        data = data.filter(d => d.id != del.dataset.id);
        persist();
        render();
      }
    });

    // EXPORT CSV
    document.getElementById("exportExcel").addEventListener("click", () => {
      let csv = "Contract,Title,Client,Project,Contract Date,Valid Until,Amount,Status\n";

      data.forEach(r => {
        csv += `"${r.contract_no}","${r.title}","${r.client}","${r.project}","${r.contract_date}","${r.valid_until}",${r.amount},"${r.status}"\n`;
      });

      const blob = new Blob([csv], { type: "text/csv" });
      const url = URL.createObjectURL(blob);

      const a = document.createElement("a");
      a.href = url;
      a.download = "contracts.csv";
      document.body.appendChild(a);
      a.click();
      a.remove();
    });

    // PRINT
    document.getElementById("printBtn").addEventListener("click", () => {
      window.print();
    });

    // INIT
    loadInitial().then(render);
  }



  /***************************************************
   * ========== CONTRACT VIEW PAGE (contract_view.php) ==========
   ***************************************************/
  if (isViewPage) {

    const urlParams = new URLSearchParams(window.location.search);
    const contractId = Number(urlParams.get("id"));

    let contract = null;

    function renderContractView() {

      contract = data.find(c => c.id === contractId);

      if (!contract) {
        document.getElementById("contractContainer").innerHTML =
          "<div class='alert alert-danger'>Contract not found.</div>";
        return;
      }

      // HEADER
      document.getElementById("contractTitle").innerText =
        `CONTRACT #${contractId}: ${contract.title}`;

      const badge = document.getElementById("contractStatus");
      badge.innerText = contract.status;
      badge.classList.add(
        contract.status === "Accepted" ? "bg-primary" :
        contract.status === "Sent" ? "bg-info" : "bg-secondary",
        "text-white"
      );

      document.getElementById("contractDate").innerText = contract.contract_date;

      // RIGHT INFO
      document.getElementById("clientName").innerText = contract.client;
      document.getElementById("infoContractDate").innerText = contract.contract_date;
      document.getElementById("infoValidUntil").innerText = contract.valid_until;

      document.getElementById("noteText").innerText = contract.note || "No note.";

      // STATIC ITEMS
      const items = [
        {
          name: "Art pictures",
          desc: "Hand art pictures for your website.",
          qty: 4,
          rate: 40,
          total: 160
        }
      ];

      let subtotal = 0;
      let html = "";

      items.forEach(it => {
        subtotal += it.total;
        html += `
          <tr>
              <td><strong>${it.name}</strong><br><small>${it.desc}</small></td>
              <td>${it.qty} PC</td>
              <td>$${it.rate}</td>
              <td>$${it.total}</td>
              <td class="text-end"><i class="bi bi-pencil"></i> <i class="bi bi-x ms-2"></i></td>
          </tr>
        `;
      });

      document.getElementById("itemBody").innerHTML = html;
      document.getElementById("subtotal").innerText = `$${subtotal.toFixed(2)}`;
      document.getElementById("totalAmount").innerText = `$${subtotal.toFixed(2)}`;

      // LONG PREVIEW TEMPLATE
      document.getElementById("contractLongPreview").innerHTML = `
          <h5 class="fw-semibold">{CONTRACT_TITLE}</h5>
          <p>This contract outlines the terms...</p>

          <h6>Service Details</h6>
          <p>{CONTRACT_ITEMS}</p>

          <h6>1. Service Policy</h6>
          <p>...</p>

          <h6>2. Delivery</h6>
          <p>...</p>

          <h6>3. Intellectual property rights</h6>
          <p>...</p>

          <h6>4. Confidentiality</h6>
          <p>...</p>

          <h6>5. Support</h6>
          <p>...</p>
      `;
    }

    // INIT VIEW PAGE
    loadInitial().then(renderContractView);
  }

});

<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <div class="container-fluid p-4">

      <!-- PAGE HEADER -->
      <div class="d-flex justify-content-between align-items-center mb-4 p-2 bg-white rounded border">
        <h4 class="fw-semibold mb-0">Orders</h4>
        <button class="btn btn-outline-secondary d-flex align-items-center">
          <i class="bi bi-plus-lg me-2"></i> Add order
        </button>
      </div>

      <!-- FILTER BAR -->
      <div class="d-flex flex-wrap align-items-center gap-2 mb-3">

        <button class="btn btn-outline-secondary"><i class="bi bi-columns"></i></button>

        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-funnel me-1"></i> This Month
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item filter-all" href="#">All</a></li>
            <li><a class="dropdown-item filter-month" href="#">This Month</a></li>
            <li><a class="dropdown-item filter-new" href="#">New</a></li>
          </ul>
        </div>

        <button class="btn btn-outline-secondary"><i class="bi bi-plus-lg"></i></button>
        <button class="btn btn-outline-secondary">All</button>
        <button class="btn btn-outline-secondary">New</button>
        <button class="btn btn-outline-secondary"><i class="bi bi-box"></i></button>

        <div class="ms-auto d-flex align-items-center gap-2">
          <button class="btn btn-outline-secondary excel-btn">Excel</button>
          <button class="btn btn-outline-secondary print-btn">Print</button>

          <div class="input-group" style="width: 230px;">
            <input type="text" class="form-control" placeholder="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
          </div>
        </div>

      </div>

      <!-- TABLE -->
      <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Order</th>
              <th>Client</th>
              <th>Invoices</th>
              <th>Order date</th>
              <th>Amount</th>
              <th>Status</th>
              <th><i class="bi bi-list"></i></th>
            </tr>
          </thead>
          <tbody id="ordersTableBody">
            <tr>
              <td colspan="7" class="text-center py-4 text-muted fw-semibold">Loading...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION (NOT USED) -->
      <div class="d-flex justify-content-between align-items-center mt-3">
        <select class="form-select" style="width: 80px;">
          <option selected>10</option>
          <option>20</option>
          <option>50</option>
        </select>

        <span class="text-muted">0-0 / 0</span>

        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary px-3 prev-btn"><i class="bi bi-chevron-left"></i></button>
          <button class="btn btn-outline-secondary px-3 next-btn"><i class="bi bi-chevron-right"></i></button>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- ========================= -->
<!--  FUNCTIONS: Load JSON, Search, Filter, Excel, Print -->
<!-- ========================= -->
<script>
// GLOBAL DATA
let ordersData = [];

// =========================
// 0. LOAD JSON FROM PHP
// =========================
fetch("orderlist_json.php")
  .then(res => res.json())
  .then(data => {
    ordersData = data;
    loadTable(ordersData);
  });

// =========================
// BUILD TABLE FROM JSON
// =========================
const tableBody = document.querySelector("#ordersTableBody");

function loadTable(data) {
  if (!data.length) {
    tableBody.innerHTML = `
      <tr><td colspan="7" class="text-center py-4 text-muted fw-semibold">No record found.</td></tr>
    `;
    return;
  }

  tableBody.innerHTML = "";

  data.forEach(row => {
    tableBody.innerHTML += `
  <tr>

    <td>
      <a href="orderlist_view.php?id=${encodeURIComponent(row.order)}" class="text-decoration-none">
        ${row.order}
      </a>
    </td>

    <td>
      <a href="Client-view.php?name=${encodeURIComponent(row.client)}" class="text-decoration-none">
        ${row.client}
      </a>
    </td>

    <td>${row.invoice}</td>
    <td>${row.date}</td>
    <td>${row.amount}</td>
    <td>${row.status}</td>
    <td><i class="bi bi-three-dots"></i></td>

  </tr>
`;

  });
}

// =========================
// 1. SEARCH FUNCTIONALITY
// =========================
const searchInput = document.querySelector('input[placeholder="Search"]');

searchInput.addEventListener("keyup", function () {
  const filter = this.value.toLowerCase();

  const filtered = ordersData.filter(row =>
    Object.values(row).join(" ").toLowerCase().includes(filter)
  );

  loadTable(filtered);
});

// =========================
// 2. EXPORT TO EXCEL
// =========================
document.querySelector(".excel-btn").addEventListener("click", function () {

  let csv = "";
  const rows = document.querySelectorAll("table tr");

  rows.forEach(row => {
    const cols = row.querySelectorAll("th, td");
    csv += [...cols].map(td => `"${td.innerText}"`).join(",") + "\n";
  });

  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);

  const a = document.createElement("a");
  a.href = url;
  a.download = "orders.csv";
  a.click();
});

// =========================
// 3. PRINT TABLE
// =========================
document.querySelector(".print-btn").addEventListener("click", function () {
  const tableHTML = document.querySelector("table").outerHTML;
  const win = window.open("", "", "width=900,height=700");

  win.document.write(`
    <html>
    <head><title>Print Orders</title></head>
    <body>${tableHTML}</body>
    </html>
  `);

  win.print();
});

// =========================
// 4. FILTER: ALL
// =========================
document.querySelector(".filter-all").addEventListener("click", function () {
  loadTable(ordersData);
});

// =========================
// 5. FILTER: THIS MONTH
// =========================
document.querySelector(".filter-month").addEventListener("click", function () {

  const filtered = ordersData.filter(row =>
    row.date.includes("11-2025") || row.date.includes("12-2025")
  );

  loadTable(filtered);
});

// =========================
// 6. FILTER: NEW STATUS
// =========================
document.querySelector(".filter-new").addEventListener("click", function () {
  const filtered = ordersData.filter(row => row.status === "New");
  loadTable(filtered);
});
</script>

<?php include 'common/footer.php'; ?>

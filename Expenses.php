<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
    <div class="content">
        <?php include 'common/topnavbar.php'; ?>

        <div class="container-fluid py-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Expenses</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="openImportModal()">Import expense</button>
                    <button class="btn btn-primary" onclick="openAddExpense()">Add expense</button>
                </div>
            </div>

            <!-- TABS -->
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <button class="nav-link active" onclick="showListTab(this)">List</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" onclick="showRecurringTab(this)">Recurring</button>
                </li>
            </ul>


            <!-- FILTER BAR -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <button class="btn btn-outline-secondary btn-sm" onclick="toggleExpenseFilters()">
                    + Add new filter
                </button>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="exportToExcel()">Excel</button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="printExpenses()">Print</button>

                    <input type="text" id="searchExpense" class="form-control form-control-sm" placeholder="Search">
                </div>
            </div>

            <!-- FILTER PANEL -->
            <div id="expenseFilters" class="d-none border rounded p-3 mb-3">
                <div class="d-flex flex-wrap gap-2 align-items-center">

                    <select id="filterCategory" class="form-select form-select-sm" style="width:180px">
                        <option value="">- Category -</option>
                        <option>Electricity</option>
                        <option>Advertising</option>
                        <option>Salary</option>
                    </select>

                    <select id="filterMember" class="form-select form-select-sm" style="width:180px">
                        <option value="">- Member -</option>
                        <option>John Doe</option>
                        <option>Sara Ann</option>
                    </select>

                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary" onclick="setRange('month')">Monthly</button>
                        <button class="btn btn-outline-secondary" onclick="setRange('year')">Yearly</button>
                        <button class="btn btn-outline-secondary" onclick="setRange('custom')">Custom</button>
                        <button class="btn btn-outline-secondary" onclick="setRange('dynamic')">Dynamic</button>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary btn-sm" onclick="changeMonth(-1)">‹</button>
                        <strong id="filterMonthLabel"></strong>
                        <button class="btn btn-outline-secondary btn-sm" onclick="changeMonth(1)">›</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="toggleExpenseFilters()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                </div>
            </div>

            <!-- TABLE -->
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Files</th>
                        <th>Amount</th>
                        <th>TAX</th>
                        <th>Second TAX</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="expenseTable"></tbody>

                <!-- ✅ TOTAL FOOTER -->
                <tfoot>
                    <tr class="fw-semibold">
                        <td colspan="5" class="text-end">Total</td>
                        <td id="sumAmount">$0.00</td>
                        <td id="sumTax">$0.00</td>
                        <td id="sumTax2">$0.00</td>
                        <td id="sumTotal">$0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <!-- PAGINATION -->
            <div class="d-flex justify-content-between align-items-center mt-3">

                <div class="d-flex align-items-center gap-2">

                    <select id="pageSize" class="form-select form-select-sm" style="width:90px">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>

                <div id="pageInfo" class="text-muted small"></div>

                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary" onclick="prevPage()">‹</button>
                    <button class="btn btn-outline-secondary" onclick="nextPage()">›</button>
                </div>

            </div>

        </div>

    </div>

    <!-- ADD / EDIT EXPENSE MODAL -->
    <div class="modal fade" id="expenseModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalTitle">Add expense</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    <input type="hidden" id="expenseIndex">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Date of expense</label>
                            <input type="date" id="expDate" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select id="expCategory" class="form-select">
                                <option value="">Select category</option>
                                <option>Electricity</option>
                                <option>Advertising</option>
                                <option>Salary</option>
                                <option>Utilities</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Amount</label>
                            <input type="number" id="expAmount" class="form-control" placeholder="Amount">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" id="expTitle" class="form-control" placeholder="Title">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea id="expDesc" class="form-control" rows="3"
                                placeholder="Description"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Client</label>
                            <select class="form-select">
                                <option>John Doe</option>
                                <option>Sara Ann</option>
                                <option>Abe bosich</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Project</label>
                            <select class="form-select">
                                <option>Task complete</option>
                                <option>Do every work</option>
                                <option>Attend meetings</option>
                                <option>About page create</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Team member</label>
                            <select class="form-select">
                                <option>-</option>
                                <option>John Doe</option>
                                <option>Sara Ann</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">TAX</label>
                            <select class="form-select">
                                <option>-</option>
                                <option>10%</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Second TAX</label>
                            <select class="form-select">
                                <option>-</option>
                                <option>20%</option>
                            </select>
                        </div>

                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="recurring">
                                <label class="form-check-label" for="recurring">
                                    Recurring
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer justify-content-between">
                    <div>
                        <input type="file" id="expFile" class="d-none">
                        <button class="btn btn-outline-secondary btn-sm"
                            onclick="document.getElementById('expFile').click()">
                            📎 Upload File
                        </button>

                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-primary" onclick="saveExpense()">
                            Save
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Expense details</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detailsBox"></div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" onclick="cloneExpense()">Clone expense</button>
                    <button class="btn btn-primary" onclick="editFromDetails()">Edit expense</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <!-- IMPORT MODAL -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Import expense</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">

                    <form id="importExpenseForm">
                        <label for="importFile"
                            class="border rounded p-5 text-muted w-100 text-center"
                            style="cursor:pointer">
                            Drag-and-drop documents here<br>
                            <small>(or click to browse)</small>
                        </label>


                        <input type="file"
                            id="importFile"
                            class="d-none"
                            accept=".csv,.xls,.xlsx">
                    </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary">Download sample file</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Next</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <h5>Delete?</h5>
                <p class="text-muted">You won’t be able to undo this action.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FILE VIEW MODAL -->
    <div class="modal fade" id="fileViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">View File</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center" id="filePreviewBox">
                    <!-- dynamic -->
                </div>

            </div>
        </div>
    </div>


    <?php include 'common/footer.php'; ?>

    <script>
        /* ================= DATA ================= */
        function saveToLocal() {
            localStorage.setItem("expenses", JSON.stringify(expenses));
        }

        function loadFromLocal() {
            const saved = localStorage.getItem("expenses");
            if (saved) {
                expenses = JSON.parse(saved);
            }
        }

        let expenses = [];
        let expenseModalInstance = null;
        let importModalInstance = null;

        /* ================= INIT ================= */

        document.addEventListener("DOMContentLoaded", () => {
            expenseModalInstance = new bootstrap.Modal(document.getElementById("expenseModal"));
            importModalInstance = new bootstrap.Modal(document.getElementById("importModal"));

            loadFromLocal(); // ✅ load saved data
            renderExpenses();
        });


        /* ================= FILTER TOGGLE ================= */
        function toggleExpenseFilters() {
            document.getElementById("expenseFilters").classList.toggle("d-none");
        }


        /* ================= RENDER TABLE ================= */
        function renderExpenses(data = expenses) {
            const tbody = document.getElementById("expenseTable");
            tbody.innerHTML = "";

            filteredExpenses = data;

            if (filteredExpenses.length === 0) {
                tbody.innerHTML = `
      <tr>
        <td colspan="10" class="text-center text-muted py-4">
          No expenses found
          
        </td>
      </tr>`;
                updatePageInfo(0);
                return;
            }

            const start = (currentPage - 1) * pageSize;
            const end = start + pageSize;
            const pageData = filteredExpenses.slice(start, end);

            pageData.forEach((e, i) => {
                tbody.innerHTML += `
      <tr>
        <td>
        <a href="javascript:void(0)"
        class="text-primary"
        onclick="openDetails(${start + i})">
        ${e.date}
        </a>
        </td>

        <td>${e.category}</td>
        <td>${e.title}</td>
        <td>${e.desc || "-"}</td>
       <td>
        ${e.file
        ? `<button class="btn btn-sm btn-outline-primary"
         onclick="viewFile(${start + i})">View</button>`
        : "-"}
        </td>

        <td>$${Number(e.amount).toFixed(2)}</td>
        <td>$0.00</td>
        <td>$0.00</td>
        <td>$${Number(e.amount).toFixed(2)}</td>
        <td class="text-nowrap">
          <button class="btn btn-sm btn-light" onclick="editExpense(${start + i})">✏</button>
          <button class="btn btn-sm btn-light text-danger" onclick="deleteExpense(${start + i})">✖</button>
        </td>
      </tr>`;
            });

            updatePageInfo(filteredExpenses.length);
            updateTotals(filteredExpenses);

        }
        let fileViewModal = new bootstrap.Modal(
            document.getElementById("fileViewModal")
        );

        function viewFile(i) {
            const file = expenses[i].file;
            const box = document.getElementById("filePreviewBox");

            if (!file) return;

            if (file.type.startsWith("image/")) {
                box.innerHTML = `
      <img src="${file.data}" class="img-fluid rounded">
        `;
            } else if (file.type === "application/pdf") {
                box.innerHTML = `
      <iframe src="${file.data}" width="100%" height="500px"></iframe>
        `;
            } else {
                box.innerHTML = `
      <a href="${file.data}" download="${file.name}"
         class="btn btn-primary">
        Download ${file.name}
      </a>
        `;
            }

            fileViewModal.show();
        }


        /* ================= ADD EXPENSE ================= */
        function openAddExpense() {
            document.getElementById("expenseModalTitle").innerText = "Add expense";
            document.getElementById("expenseIndex").value = "";

            resetExpenseForm();
            expenseModalInstance.show();
        }

        /* ================= RESET FORM ================= */
        function resetExpenseForm() {
            expDate.value = "";
            expCategory.value = "";
            expAmount.value = "";
            expTitle.value = "";
            expDesc.value = "";
            document.getElementById("recurring").checked = false;
        }

        /* ================= SAVE ================= */
        function saveExpense() {
            if (!expDate.value || !expCategory.value || !expAmount.value || !expTitle.value) {
                alert("Please fill required fields");
                return;
            }

            let fileData = null;

            if (expFile.files.length) {
                const file = expFile.files[0];
                const reader = new FileReader();

                reader.onload = function() {
                    fileData = {
                        name: file.name,
                        type: file.type,
                        data: reader.result
                    };

                    saveExpenseData(fileData);
                };

                reader.readAsDataURL(file);
            } else {
                saveExpenseData(null);
            }
        }

        function saveExpenseData(fileData) {
            const obj = {
                date: expDate.value,
                category: expCategory.value,
                title: expTitle.value,
                desc: expDesc.value,
                amount: expAmount.value,
                file: fileData
            };

            const index = expenseIndex.value;

            if (index === "") {
                expenses.push(obj);
            } else {
                expenses[index] = obj;
            }

            saveToLocal();
            filteredExpenses = expenses;
            currentPage = 1;
            renderExpenses();
            expenseModalInstance.hide();
        }


        /* ================= EDIT ================= */
        function editExpense(i) {
            const e = expenses[i];
            document.getElementById("expenseModalTitle").innerText = "Edit expense";
            document.getElementById("expenseIndex").value = i;

            expDate.value = e.date;
            expCategory.value = e.category;
            expAmount.value = e.amount;
            expTitle.value = e.title;
            expDesc.value = e.desc;

            expenseModalInstance.show();
        }

        /* ================= DELETE ================= */
        let deleteIndex = null;
        let deleteModal = null;

        document.addEventListener("DOMContentLoaded", () => {
            deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
        });

        function deleteExpense(i) {
            deleteIndex = i;
            deleteModal.show();
        }

        function confirmDelete() {
            expenses.splice(deleteIndex, 1);
            saveToLocal();
            renderExpenses();
            deleteModal.hide();
        }


        /* ================= SEARCH ================= */
        document.getElementById("searchExpense").addEventListener("keyup", function() {
            const q = this.value.toLowerCase();
            const rows = document.querySelectorAll("#expenseTable tr");

            rows.forEach(r => {
                r.style.display = r.innerText.toLowerCase().includes(q) ? "" : "none";
            });
        });

        /* ================= IMPORT ================= */
        function openImportModal() {
            document.getElementById("importFile").value = "";
            importModalInstance.show();
        }

        /* ================= FILE SELECT ================= */
        document.getElementById("importFile").addEventListener("change", function() {
            if (this.files.length) {
                alert("Selected file: " + this.files[0].name);
            }
        });

        /* ================= FILTER STATE ================= */
        let filterMonth = new Date();
        let filterRange = "month";

        /* ================= INIT FILTER LABEL ================= */
        updateMonthLabel();

        /* ================= CATEGORY / MEMBER ================= */
        document.getElementById("filterCategory").addEventListener("change", applyFilters);
        document.getElementById("filterMember").addEventListener("change", applyFilters);

        /* ================= RANGE ================= */
        function setRange(type) {
            filterRange = type;
            applyFilters();
        }

        /* ================= MONTH NAV ================= */
        function changeMonth(step) {
            filterMonth.setMonth(filterMonth.getMonth() + step);
            updateMonthLabel();
            applyFilters();
        }

        function updateMonthLabel() {
            document.getElementById("filterMonthLabel").innerText =
                filterMonth.toLocaleString("default", {
                    month: "long",
                    year: "numeric"
                });
        }

        /* ================= APPLY FILTERS ================= */
        function applyFilters() {
            const cat = document.getElementById("filterCategory").value;
            const mem = document.getElementById("filterMember").value;

            const tbody = document.getElementById("expenseTable");
            tbody.innerHTML = "";

            const filtered = expenses.filter(e => {

                /* CATEGORY */
                if (cat && e.category !== cat) return false;

                /* MEMBER */
                if (mem && e.member !== mem) return false;

                /* DATE RANGE */
                const d = new Date(e.date);
                if (filterRange === "month") {
                    return d.getMonth() === filterMonth.getMonth() &&
                        d.getFullYear() === filterMonth.getFullYear();
                }

                if (filterRange === "year") {
                    return d.getFullYear() === filterMonth.getFullYear();
                }

                return true;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `
      <tr>
        <td colspan="10" class="text-center text-muted py-4">
          No records found
        </td>
      </tr>`;
                return;
            }

            filtered.forEach((e) => {
                const realIndex = expenses.indexOf(e);

                tbody.innerHTML += `
    <tr>
      <td>
        <a href="javascript:void(0)"
           class="text-primary"
           onclick="openDetails(${realIndex})">
          ${e.date}
        </a>
      </td>
      <td>${e.category}</td>
      <td>${e.title}</td>
      <td>${e.desc || "-"}</td>
      <td>
  ${e.file
    ? `<button class="btn btn-sm btn-outline-primary"
         onclick="viewFile(${realIndex})">View</button>`
    : "-"}
</td>

      <td>$${Number(e.amount).toFixed(2)}</td>
      <td>$0.00</td>
      <td>$0.00</td>
      <td>$${Number(e.amount).toFixed(2)}</td>
      <td class="text-nowrap">
        <button class="btn btn-sm btn-light" onclick="editExpense(${realIndex})">✏</button>
        <button class="btn btn-sm btn-light text-danger" onclick="deleteExpense(${realIndex})">✖</button>
      </td>
    </tr>
  `;
            });
            updateTotals(filtered);

        }

        function exportToExcel() {
            if (expenses.length === 0) {
                alert("No data to export");
                return;
            }

            let csv = "Date,Category,Title,Description,Amount\n";

            expenses.forEach(e => {
                csv += `"${e.date}","${e.category}","${e.title}","${e.desc || ""}","${e.amount}"\n`;
            });

            const blob = new Blob([csv], {
                type: "text/csv;charset=utf-8;"
            });
            const url = URL.createObjectURL(blob);

            const a = document.createElement("a");
            a.href = url;
            a.download = "expenses.csv";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function printExpenses() {
            if (expenses.length === 0) {
                alert("No data to print");
                return;
            }

            let printWindow = window.open("", "", "width=900,height=650");

            printWindow.document.write(`
    <html>
    <head>
      <title>Expenses</title>
      <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
      </style>
    </head>
    <body>
      <h2>Expenses</h2>
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Category</th>
            <th>Title</th>
            <th>Description</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
  `);

            expenses.forEach(e => {
                printWindow.document.write(`
      <tr>
        <td>${e.date}</td>
        <td>${e.category}</td>
        <td>${e.title}</td>
        <td>${e.desc || "-"}</td>
        <td>$${Number(e.amount).toFixed(2)}</td>
      </tr>
    `);
            });

            printWindow.document.write(`
        </tbody>
      </table>
    </body>
    </html>
  `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
        /* ================= PAGINATION STATE ================= */
        let currentPage = 1;
        let pageSize = 10;
        let filteredExpenses = [];

        /* ================= UPDATE PAGE SIZE ================= */
        document.getElementById("pageSize").addEventListener("change", function() {
            pageSize = Number(this.value);
            currentPage = 1;
            renderExpenses(filteredExpenses.length ? filteredExpenses : expenses);
        });

        /* ================= NEXT / PREV ================= */
        function nextPage() {
            if (currentPage * pageSize < filteredExpenses.length) {
                currentPage++;
                renderExpenses(filteredExpenses);
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderExpenses(filteredExpenses);
            }
        }

        /* ================= PAGE INFO ================= */
        function updatePageInfo(total) {
            const start = total ? (currentPage - 1) * pageSize + 1 : 0;
            const end = Math.min(currentPage * pageSize, total);
            document.getElementById("pageInfo").innerText =
                `${start}-${end} of ${total}`;
        }
        let selectedDetailsIndex = null;
        let detailsModal = new bootstrap.Modal(document.getElementById("detailsModal"));

        function openDetails(i) {
            const e = expenses[i];
            selectedDetailsIndex = i;

            detailsBox.innerHTML = `
    <h6>Expense # ${e.date}</h6>
    <strong>$${Number(e.amount).toFixed(2)}</strong><br><br>
    <strong>${e.title}</strong><br>
    ${e.desc || "-"}<br><br>
    <strong>Category:</strong> ${e.category}<br>
    <strong>File:</strong> ${e.file || "-"}
  `;

            detailsModal.show();
        }

        function editFromDetails() {
            detailsModal.hide();
            editExpense(selectedDetailsIndex);
        }

        function cloneExpense() {
            const copy = {
                ...expenses[selectedDetailsIndex]
            };
            expenses.push(copy);
            saveToLocal();
            renderExpenses();
            detailsModal.hide();
        }

        function updateTotals(list) {
            let amount = 0;
            let tax = 0;
            let tax2 = 0;
            let total = 0;

            list.forEach(e => {
                const amt = Number(e.amount) || 0;
                amount += amt;
                total += amt; // (you can modify if TAX logic added later)
            });

            document.getElementById("sumAmount").innerText = `$${amount.toFixed(2)}`;
            document.getElementById("sumTax").innerText = `$${tax.toFixed(2)}`;
            document.getElementById("sumTax2").innerText = `$${tax2.toFixed(2)}`;
            document.getElementById("sumTotal").innerText = `$${total.toFixed(2)}`;
        }

        function activateTab(btn) {
            document.querySelectorAll(".nav-link").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
        }

        function showListTab(btn) {
            activateTab(btn);
            filteredExpenses = expenses;
            currentPage = 1;
            renderExpenses(expenses);
        }

        function showRecurringTab(btn) {
            activateTab(btn);

            const recurringOnly = expenses.filter(e => e.recurring === true);
            filteredExpenses = recurringOnly;
            currentPage = 1;
            renderExpenses(recurringOnly);
        }
    </script>
    </body>

    </html>
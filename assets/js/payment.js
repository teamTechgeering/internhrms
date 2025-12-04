// ==========================================================================
// AUTO-DETECT WHICH PAGE WE ARE ON
// ==========================================================================

document.addEventListener("DOMContentLoaded", () => {
    const isPaymentListPage = document.getElementById("paymentBody") !== null;
    const isPaymentViewPage = document.getElementById("invoiceNumber") !== null;

    if (isPaymentListPage) {
        runPaymentListCode();
    }

    if (isPaymentViewPage) {
        window.invoiceId = getInvoiceIdFromURL();
        runPaymentViewCode();
    }
});

// Extract invoice ID from URL
function getInvoiceIdFromURL() {
    const p = new URLSearchParams(window.location.search);
    return p.get("id") ? parseInt(p.get("id")) : 0;
}

// ==========================================================================
//       PAYMENT LIST PAGE  (payment.php)
// ==========================================================================
function runPaymentListCode() {

    let paymentData = [];

    // FETCH JSON DATA
    fetch("payment_json.php")
        .then(res => res.json())
        .then(data => {
            paymentData = data.list; // IMPORTANT
            renderTable(paymentData);
        });

    const body = document.getElementById("paymentBody");
    const searchInput = document.getElementById("searchInput");

    // RENDER PAYMENT TABLE
    function renderTable(data) {
        body.innerHTML = "";

        data.forEach(row => {
            const id = row.invoice_id.replace("INV #", "");
            const tr = document.createElement("tr");

            tr.innerHTML = `
                <td>
                    <a href="payment_view.php?id=${id}" 
                       class="text-primary text-decoration-none">
                       ${row.invoice_id}
                    </a>
                </td>

                <td>${row.payment_date}</td>
                <td>${row.method}</td>
                <td>${row.note}</td>
                <td class="text-end">$${parseFloat(row.amount).toFixed(2)}</td>
            `;

            body.appendChild(tr);
        });
    }

    // =======================================================
    // ADD PAYMENT MODAL — updates table instantly
    // =======================================================

   document.getElementById("savePaymentBtn").addEventListener("click", () => {

    let method = payMethod.value;
    let date = payDate.value;
    let amount = Number(payAmount.value);
    let note = payNote.value;
    let file = payFile.files.length > 0 ? payFile.files[0].name : "No file";

    if (!method || !amount) {
        alert("Please fill required fields");
        return;
    }

    // Create new payment entry
    const newPayment = {
        invoice_id: "INV #" + (paymentData.length + 1),
        payment_date: date,
        method: method,
        note: note,
        amount: amount.toFixed(2)
    };

    // Add to main array
    paymentData.unshift(newPayment);

    // UPDATE TABLE WITH NEW ROW ONLY (no full reload)
    const tr = document.createElement("tr");
    const id = newPayment.invoice_id.replace("INV #", "");

    tr.innerHTML = `
        <td>
            <a href="payment_view.php?id=${id}" 
               class="text-primary text-decoration-none">
               ${newPayment.invoice_id}
            </a>
        </td>

        <td>${newPayment.payment_date}</td>
        <td>${newPayment.method}</td>
        <td>${newPayment.note}</td>
        <td class="text-end">$${newPayment.amount}</td>
    `;

    document.getElementById("paymentBody").prepend(tr);

    // Reset form
    paymentForm.reset();

    // Close modal instantly (no fade)
    const modal = bootstrap.Modal.getInstance(document.getElementById("addPaymentModal"));
    modal._element.classList.remove("fade"); // remove fade class
    modal.hide();

    alert("Payment added successfully!");
});


    // =======================================================
    // SEARCH FILTER
    // =======================================================

    searchInput.addEventListener("keyup", () => {
        const value = searchInput.value.toLowerCase();

        const filtered = paymentData.filter(row =>
            row.invoice_id.toLowerCase().includes(value) ||
            row.payment_date.toLowerCase().includes(value) ||
            row.method.toLowerCase().includes(value) ||
            row.note.toLowerCase().includes(value) ||
            row.amount.toLowerCase().includes(value)
        );

        renderTable(filtered);
    });
    // =======================================================
    // EXPORT TO CSV
    // =======================================================

    document.getElementById("btnExcel").addEventListener("click", () => {

        let csv = "Invoice ID,Payment Date,Method,Note,Amount\n";

        paymentData.forEach(row => {
            csv += `${row.invoice_id},${row.payment_date},${row.method},${row.note},${row.amount}\n`;
        });

        const blob = new Blob([csv], { type: "text/csv" });
        const url = window.URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "payment_data.csv";
        a.click();

        window.URL.revokeObjectURL(url);
    });


    // =======================================================
    // PRINT TABLE
    // =======================================================

    document.getElementById("btnPrint").addEventListener("click", () => {
        window.print();
    });

    // TAB SWITCHING
    document.getElementById("tabList").addEventListener("click", function () {
        document.getElementById("listSection").classList.remove("d-none");
        document.getElementById("chartSection").classList.add("d-none");
        this.classList.add("active");
        document.getElementById("tabChart").classList.remove("active");
    });

    document.getElementById("tabChart").addEventListener("click", function () {
        document.getElementById("chartSection").classList.remove("d-none");
        document.getElementById("listSection").classList.add("d-none");
        this.classList.add("active");
        document.getElementById("tabList").classList.remove("active");
        renderPaymentChart();
    });

    // Chart Render Function
    function renderPaymentChart() {
     var chartData = [0,0,0,0,0,600,300,0,0,700,12000,5000];

        var chart = new ApexCharts(document.querySelector("#paymentChart"), {
            chart: { type: "bar", height: 400 },
            series: [{ name: "Payments", data: chartData }],
            xaxis: { categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"] }
        });

        chart.render();
    }


}

// ==========================================================================
//       PAYMENT VIEW PAGE  (payment_view.php)
// ==========================================================================
document.addEventListener("DOMContentLoaded", function () {

    // =======================================================
    // FIX #1 — JS MUST RUN AFTER PAGE LOAD
    // =======================================================

    // State
    let items = [];
    let payments = [];
    let tasks = [];
    let reminders = [];

    // Helpers
    function qs(id) { return document.getElementById(id); }
    function money(n) { return "$" + Number(n).toFixed(2); }

    // Fetch invoice data
    const invoiceId = window.invoiceId || 0;

    function fetchInvoice(id) {
        if (!id) {
            renderEverything();
            return;
        }

        fetch("payment_json.php?id=" + encodeURIComponent(id))
            .then(res => res.json())
            .then(data => {
                if (!data || Object.keys(data).length === 0) return;
                loadInvoice(data);
            })
            .catch(err => console.error("Failed loading invoice:", err));
    }

    // =======================================================
    // Load invoice details
    // =======================================================
    function loadInvoice(data) {
        // Header
        qs("invoiceNumber").innerText = data.invoice_number;
        qs("invoiceCode").innerText = data.invoice_number;

        // Company
        qs("companyName").innerText      = data.company.name;
        qs("companyAddress1").innerText  = data.company.address1;
        qs("companyAddress2").innerText  = data.company.address2;
        qs("companyPhone").innerText     = "Phone: " + data.company.phone;
        qs("companyEmail").innerText     = "Email: " + data.company.email;
        qs("companyWebsite").innerText   = "Website: " + data.company.website;

        // Client
        qs("billDate").innerText   = "Bill date: " + data.bill_date;
        qs("dueDate").innerText    = "Due date: " + data.due_date;
        qs("clientName").innerText = data.client.name;
        qs("clientAddr1").innerText = data.client.addr1;
        qs("clientAddr2").innerText = data.client.addr2;
        qs("clientAddr3").innerText = data.client.city;
        qs("clientCountry").innerText = data.client.country;
        qs("sidebarClientName").innerText = data.client.name;

        // Status
        qs("invoiceStatus").innerText = data.status;

        // Items
        items = data.items;

        // Payments
        payments = data.payments;

        // Tasks
        tasks = data.tasks;

        // Reminders
        reminders = data.reminders;

        renderEverything();
    }

    // =======================================================
    // MERGED RENDER
    // =======================================================
    function renderEverything() {
        renderItems();
        updatePaymentUI();
        renderTasksUI();
        updateRemindersUI();
    }

    // =======================================================
    // ITEMS TABLE
    // =======================================================
    function renderItems() {
        const tbody = qs("itemRows");
        tbody.innerHTML = "";

        items.forEach((it, i) => {
            const total = it.qty * it.rate;

            tbody.innerHTML += `
                <tr>
                    <td><div class="fw-semibold">${it.title}</div><div class="text-muted small">${it.desc}</div></td>
                    <td>${it.qty}</td>
                    <td>${money(it.rate)}</td>
                    <td>${money(total)}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary" onclick="editItem(${i})"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="deleteItem(${i})"><i class="bi bi-x-lg"></i></button>
                    </td>
                </tr>
            `;
        });

        calculateTotals();
    }

    function calculateTotals() {
        let sub = items.reduce((a, b) => a + (b.qty * b.rate), 0);
        let paid = payments.reduce((a, b) => a + b.amount, 0);

        qs("subTotal").innerText = money(sub);
        qs("balanceDue").innerText = money(sub - paid);
        qs("discountAmount").innerText = money(0);
    }

    window.deleteItem = function(i) {
        items.splice(i, 1);
        renderItems();
    };

    window.editItem = function(i) {
        let it = items[i];
        let t = prompt("Edit Title", it.title);
        if (t === null) return;
        it.title = t;
        renderItems();
    };

    qs("saveNewItem").addEventListener("click", () => {
        let it = {
            title: qs("itemTitle").value,
            desc: qs("itemDesc").value,
            qty: Number(qs("itemQty").value),
            rate: Number(qs("itemRate").value)
        };

        items.push(it);
        renderItems();

        qs("itemTitle").value = "";
        qs("itemDesc").value = "";
        qs("itemQty").value = "";
        qs("itemRate").value = "";

        bootstrap.Modal.getInstance(document.getElementById("addItemModal")).hide();
    });

    // =======================================================
    // PAYMENTS
    // =======================================================
    qs("savePaymentBtn").addEventListener("click", () => {
        let p = {
            method: qs("payMethod").value,
            date: qs("payDate").value,
            amount: Number(qs("payAmount").value),
            note: qs("payNote").value,
            file: qs("payFile").files.length ? qs("payFile").files[0].name : "No file"
        };

        payments.push(p);
        updatePaymentUI();
        calculateTotals();

        qs("paymentForm").reset();
        bootstrap.Modal.getInstance(document.getElementById("addPaymentModal")).hide();
    });

    function updatePaymentUI() {
        const list = qs("paymentList");
        list.innerHTML = "";

        if (!payments.length) {
            list.innerHTML = `<li class="small text-muted">No payments yet</li>`;
            return;
        }

        payments.forEach((p, i) => {
            list.innerHTML += `
                <li class="d-flex justify-content-between border-bottom py-1">
                    <div>
                        <b>${p.method}</b> - ${money(p.amount)}<br>
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

    window.removePayment = function(i) {
        payments.splice(i, 1);
        updatePaymentUI();
        calculateTotals();
    };

    // =======================================================
    // TASKS
    // =======================================================
    qs("saveTask").addEventListener("click", () => {
        let t = qs("taskName").value;
        tasks.push(t);
        renderTasksUI();
        qs("taskName").value = "";
        bootstrap.Modal.getInstance(document.getElementById("addTaskModal")).hide();
    });

    function renderTasksUI() {
        const list = qs("taskList");
        list.innerHTML = "";
        tasks.forEach((t, i) => {
            list.innerHTML += `
                <li>${t} <button class="btn btn-sm btn-outline-danger" onclick="deleteTask(${i})"><i class="bi bi-trash"></i></button></li>
            `;
        });
    }

    window.deleteTask = function(i) {
        tasks.splice(i, 1);
        renderTasksUI();
    };

    // =======================================================
    // REMINDERS
    // =======================================================
    qs("openReminderFormBtn").addEventListener("click", () => {
        qs("reminderFormBox").classList.remove("d-none");
    });

    qs("addReminderBtn").addEventListener("click", () => {
        let r = {
            title: qs("remTitle").value,
            date: qs("remDate").value,
            time: qs("remTime").value,
            repeat: qs("remRepeat").checked ? "Yes" : "No"
        };

        reminders.push(r);
        updateRemindersUI();
    });

    function updateRemindersUI() {
        const list = qs("reminderList");
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

    window.deleteReminder = function(i) {
        reminders.splice(i, 1);
        updateRemindersUI();
    };

    // =======================================================
    // PREVIEW / PRINT / PDF
    // =======================================================
    qs("previewBtn").addEventListener("click", () => {
        window.open(`invoice_preview.php?id=${invoiceId}`, "_blank");
    });

    qs("printBtn").addEventListener("click", () => {
        window.open(`invoice_preview.php?id=${invoiceId}&print=1`, "_blank");
    });

    qs("viewPdfBtn").addEventListener("click", () => {
        window.open(`invoice_preview.php?id=${invoiceId}&pdf=1`, "_blank");
    });

    qs("downloadPdfBtn").addEventListener("click", () => {
        window.open(`invoice_preview.php?id=${invoiceId}&download=1`, "_blank");
    });

    // =======================================================
    // EMAIL INVOICE MODAL
    // =======================================================
    qs("emailInvoiceBtn").addEventListener("click", () => {
        new bootstrap.Modal(document.getElementById("emailInvoiceModal")).show();
    });

    qs("goToStep2").addEventListener("click", () => {
        qs("confirmEmailTo").innerText = qs("emailTo").value;
        qs("confirmEmailSubject").innerText = qs("emailSubject").value;
        qs("confirmAttach").innerText = qs("attachPdf").checked ? "Yes" : "No";

        qs("emailStep1").classList.add("d-none");
        qs("emailStep2").classList.remove("d-none");
    });

    qs("backToStep1").addEventListener("click", () => {
        qs("emailStep2").classList.add("d-none");
        qs("emailStep1").classList.remove("d-none");
    });

    qs("sendEmailBtn").addEventListener("click", () => {
        alert("Invoice emailed! (demo)");
        bootstrap.Modal.getInstance(document.getElementById("emailInvoiceModal")).hide();
    });

    // =======================================================
    // INITIAL LOAD
    // =======================================================
    fetchInvoice(invoiceId);

});

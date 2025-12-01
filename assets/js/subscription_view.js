// -------------------------------------------------------
// subscription_view.js
// -------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       1. FETCH SUBSCRIPTION DETAILS
    ====================================================== */
    fetch("subscription_view_json.php")
        .then(res => res.json())
        .then(data => loadDetails(data));


    /* =====================================================
       2. LOAD DETAILS INTO PAGE
    ====================================================== */
    function loadDetails(data) {

        document.getElementById("subscriptionTitle").textContent =
            data.subscription_id + ": " + data.title;

        document.getElementById("nextBilling").textContent = data.next_billing_date;
        document.getElementById("client").textContent = data.client;
        document.getElementById("firstBilling").textContent = data.first_billing_date;
        document.getElementById("repeatEvery").textContent = data.repeat_every;

        // Items
        let itemsHTML = "";
        data.items.forEach(i => {
            itemsHTML += `
                <tr>
                    <td>
                        <strong>${i.name}</strong><br>
                        <span class="text-secondary">${i.description}</span>
                    </td>
                    <td>${i.quantity}</td>
                    <td>$${i.rate}</td>
                    <td>$${i.total}</td>
                </tr>`;
        });
        document.getElementById("itemsTable").innerHTML = itemsHTML;

        document.getElementById("subTotal").textContent = "$" + data.sub_total;
        document.getElementById("grandTotal").textContent = "$" + data.total;
        document.getElementById("domainInfo").textContent = "Domain: " + data.domain;

        // Invoices
        let invoiceHTML = "";
        data.invoices.forEach(inv => {
            invoiceHTML += `
                <tr>
                    <td>${inv.id}</td>
                    <td>${inv.bill_date}</td>
                    <td>${inv.due_date}</td>
                    <td>$${inv.total}</td>
                    <td>$${inv.received}</td>
                    <td>$${inv.due}</td>
                    <td>${inv.status}</td>
                </tr>`;
        });
        document.getElementById("invoiceTable").innerHTML = invoiceHTML;
    }


    /* =====================================================
       3. TASK UPLOAD FILE
    ====================================================== */
    const uploadTaskBtn = document.getElementById("btnUploadTaskFile");
    const taskFileInput = document.getElementById("taskFile");

    if (uploadTaskBtn) {
        uploadTaskBtn.addEventListener("click", () => taskFileInput.click());
        taskFileInput.addEventListener("change", () => {
            if (taskFileInput.files.length > 0) {
                alert("File selected: " + taskFileInput.files[0].name);
            }
        });
    }


    /* =====================================================
       4. SAVE TASK
    ====================================================== */
    const saveTaskBtn = document.getElementById("btnSaveTask");

    if (saveTaskBtn) {
        saveTaskBtn.addEventListener("click", function () {

            let title = document.getElementById("taskTitle").value.trim();
            let due = document.getElementById("taskDueDate").value;

            if (title === "") return alert("Task title is required.");
            if (due === "") return alert("Task due date is required.");

            const modal = bootstrap.Modal.getInstance(
                document.getElementById("addTaskModal")
            );
            modal.hide();

            setTimeout(() => alert("Task added successfully!"), 300);
        });
    }


    /* =====================================================
       5. REMINDER FORM SHOW / ADD
    ====================================================== */
    const showReminderForm = document.getElementById("showReminderForm");
    const reminderForm = document.getElementById("reminderForm");
    const reminderList = document.getElementById("reminderList");

    if (showReminderForm) {
        showReminderForm.addEventListener("click", function (e) {
            e.preventDefault();
            showReminderForm.classList.add("d-none");
            reminderForm.classList.remove("d-none");
        });
    }

    const btnAddReminder = document.getElementById("btnAddReminder");

    if (btnAddReminder) {
        btnAddReminder.addEventListener("click", function () {

            let title = document.getElementById("remTitle").value.trim();
            let date = document.getElementById("remDate").value;
            let time = document.getElementById("remTime").value;
            let repeat = document.getElementById("remRepeat").checked ? "Yes" : "No";

            if (title === "") return alert("Reminder title is required.");

            let li = document.createElement("li");
            li.className = "list-group-item";
            li.innerHTML = `<strong>${title}</strong><br>${date} ${time} — Repeat: ${repeat}`;

            reminderList.appendChild(li);

            document.getElementById("remTitle").value = "";
            document.getElementById("remDate").value = "";
            document.getElementById("remTime").value = "";
            document.getElementById("remRepeat").checked = false;

            alert("Reminder added successfully!");
        });
    }


    /* =====================================================
       6. CANCEL SUBSCRIPTION (POPUP)
    ====================================================== */
    const cancelBtn = document.getElementById("cancelSubscriptionBtn");
    const statusBadge = document.querySelector(".badge.bg-primary"); // Active badge

    if (cancelBtn) {
        cancelBtn.addEventListener("click", function (e) {
            e.preventDefault();

            if (confirm("Are you sure you want to cancel this subscription?")) {

                // Change color and text
                statusBadge.classList.remove("bg-primary");
                statusBadge.classList.add("bg-danger");
                statusBadge.textContent = "Cancelled";

                alert("Subscription has been cancelled!");
            }
        });
    }
    /* =====================================================
   7. INVOICE SEARCH FUNCTION
======================================================*/
const invSearch = document.getElementById("invSearch");

if (invSearch) {
    invSearch.addEventListener("keyup", function () {
        let filter = invSearch.value.toLowerCase();
        let rows = document.querySelectorAll("#invoiceTable tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
}
/* =====================================================
   8. PRINT INVOICES
======================================================*/
const invPrint = document.getElementById("invPrint");

if (invPrint) {
    invPrint.addEventListener("click", function () {

        let tableHTML = document.querySelector("#invoiceTable").parentElement.outerHTML;

        let w = window.open("", "_blank");
        w.document.write(`
            <html>
            <head>
                <title>Print Invoices</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                <h3 class="text-center my-3">Invoices</h3>
                ${tableHTML}
            </body>
            </html>
        `);
        w.document.close();
        w.print();
    });
}
/* =====================================================
   9. EXPORT INVOICES TO CSV
======================================================*/
const invExcel = document.getElementById("invExcel");

if (invExcel) {
    invExcel.addEventListener("click", function () {

        let table = document.querySelector("#invoiceTable").parentElement;
        let rows = table.querySelectorAll("tr");

        let csv = [];

        rows.forEach(row => {
            let cols = row.querySelectorAll("th,td");
            let rowData = [];

            cols.forEach(col => rowData.push(col.innerText.trim()));
            csv.push(rowData.join(","));
        });

        let csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");

        let download = document.createElement("a");
        download.href = encodeURI(csvContent);
        download.download = "invoices.csv";
        download.click();
    });
}


});

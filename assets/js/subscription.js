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
const printBtn = document.getElementById("btnPrint");
if (printBtn) {
    printBtn.addEventListener("click", function () {
        let printWindow = window.open("", "PrintWindow");
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Subscriptions</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                <h3 class="text-center mb-3">Subscriptions</h3>
                <table class="table table-bordered">
                    ${document.querySelector("table").outerHTML}
                </table>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });
}


// ----------------------------------------------------
// EXCEL / CSV DOWNLOAD FUNCTION
// ----------------------------------------------------
const excelBtn = document.getElementById("btnExcel");
if (excelBtn) {
    excelBtn.addEventListener("click", function () {

        let table = document.querySelector("#subscription-body").parentElement;
        let rows = table.querySelectorAll("tr");

        let csv = [];

        rows.forEach(row => {
            let cols = row.querySelectorAll("td, th");
            let rowData = [];

            cols.forEach(col => rowData.push(col.innerText));
            csv.push(rowData.join(","));
        });

        let csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");

        let tempLink = document.createElement("a");
        tempLink.href = encodeURI(csvContent);
        tempLink.download = "subscriptions.csv";
        tempLink.click();
    });
}

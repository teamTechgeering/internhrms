/* ============================================================
   PROPOSALS LIST PAGE JS (FOR proposals.php)
   Pure JS + Bootstrap + Fetch + LocalStorage
   ============================================================ */


// ------------------------------------------------------------
// FETCH PROPOSALS FROM PHP JSON
// ------------------------------------------------------------
let proposals = [];

fetch("proposals.php")
    .then(res => res.json())
    .then(data => {
        proposals = data;
        localStorage.setItem("proposals", JSON.stringify(proposals));
        loadListPage();
    })
    .catch(() => {
        // fallback to local storage
        proposals = JSON.parse(localStorage.getItem("proposals") || "[]");
        loadListPage();
    });


// ------------------------------------------------------------
// SAVE LOCAL STORAGE
// ------------------------------------------------------------
function saveLS() {
    localStorage.setItem("proposals", JSON.stringify(proposals));
}


// ============================================================
// LOAD LIST PAGE
// ============================================================
function loadListPage() {
    renderProposalTable();

    // FILTER BUTTONS
    document.querySelectorAll("[data-status]").forEach(btn => {
        btn.addEventListener("click", () => {
            renderProposalTable(btn.dataset.status);
        });
    });

    // SEARCH BOX
    document.getElementById("search").addEventListener("input", function () {
        renderProposalTable("search:" + this.value);
    });

    // EXCEL EXPORT
    document.getElementById("excelBtn").addEventListener("click", exportExcel);

    // PRINT
    document.getElementById("printBtn").addEventListener("click", () => window.print());
}



// ============================================================
// RENDER PROPOSAL TABLE
// ============================================================
function renderProposalTable(filter = "all") {
    const tbody = document.getElementById("proposalTable");
    tbody.innerHTML = "";

    let data = [...proposals];

    // ✔ STATUS FILTER
    if (filter !== "all" && !filter.startsWith("search:")) {
        data = data.filter(p => p.status === filter);
    }

    // ✔ SEARCH FILTER
    if (filter.startsWith("search:")) {
        let q = filter.replace("search:", "").toLowerCase();
        data = data.filter(p =>
            p.proposal_no.toLowerCase().includes(q) ||
            p.client.toLowerCase().includes(q)
        );
    }

    // ✔ BUILD TABLE ROWS
    data.forEach(p => {
        let tr = document.createElement("tr");

        tr.innerHTML = `
            <td>
                <a href="proposal-view.php?id=${p.id}" class="text-primary fw-semibold">
                    ${p.proposal_no}
                </a>
            </td>
               <td>
                <a href="Client-view.php?id=${p.id}" class="text-primary fw-semibold">
                    ${p.client}
                </a>
            </td>
            
            <td>${p.proposal_date}</td>
            <td>${p.valid_until}</td>
            <td>${formatAmount(p.amount)}</td>
            <td>
                <span class="badge bg-${getStatusColor(p.status)}">${p.status}</span>
            </td>
           <td>
           
                <a class="" href="#" onclick="openEditProposal(${p.id})">
                    <i class="fa fa-edit "></i>Edit
                </a>
           
</td>
           <td>
                <a class="text-danger" href="#" onclick="openDeleteProposal(${p.id})">
                    <i class="fa fa-trash "></i>Delete
                </a>
          
</td>

        `;

        tbody.appendChild(tr);
    });
}



// ============================================================
// HELPERS
// ============================================================
function getStatusColor(s) {
    if (s === "Accepted") return "primary";
    if (s === "Draft") return "secondary";
    if (s === "Declined") return "danger";
    return "dark";
}

function formatAmount(a) {
    if (isNaN(a)) return a; 
    return "$" + Number(a).toFixed(2);
}



// ============================================================
// ADD PROPOSAL (MODAL)
// ============================================================
function addProposal() {
    let newP = {
        id: Date.now(),
        proposal_no: "PROPOSAL #" + Date.now().toString().slice(-4),
        client: document.getElementById("pClient").value,
        proposal_date: document.getElementById("pDate").value,
        valid_until: document.getElementById("pValid").value,
        status: document.getElementById("pStatus").value,
        note: document.getElementById("pNote").value,
        amount: 0,
        items: []
    };

    proposals.push(newP);
    saveLS();
    renderProposalTable();

    const modal = bootstrap.Modal.getInstance(document.getElementById("addProposalModal"));
    modal.hide();
}



// ============================================================
// EXPORT TO EXCEL
// ============================================================
function exportExcel() {
    let csv = "Proposal,Client,Proposal Date,Valid Until,Amount,Status\n";

    proposals.forEach(p => {
        csv += `${p.proposal_no},${p.client},${p.proposal_date},${p.valid_until},${formatAmount(p.amount)},${p.status}\n`;
    });

    const blob = new Blob([csv], { type: "text/csv" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "proposals.csv";
    a.click();
}



// ============================================================
// FIX BOOTSTRAP BACKDROP (NO BLUR)
// ============================================================
document.addEventListener("hidden.bs.modal", () => {
    document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());
    document.body.classList.remove("modal-open");
});

// ============================================================
// EDIT PROPOSAL
// ============================================================
function openEditProposal(id) {

    let p = proposals.find(x => x.id == id);

    // Fill modal fields
    document.getElementById("editProposalId").value = p.id;
    document.getElementById("editPDate").value = p.proposal_date;
    document.getElementById("editPValid").value = p.valid_until;
    document.getElementById("editPClient").value = p.client;
    document.getElementById("editPStatus").value = p.status;
    document.getElementById("editPNote").value = p.note;

    new bootstrap.Modal(document.getElementById("editProposalModal")).show();
}


// ============================================================
// UPDATE PROPOSAL (SAVE CHANGES)
// ============================================================
function updateProposal() {

    let id = document.getElementById("editProposalId").value;

    let index = proposals.findIndex(p => p.id == id);

    proposals[index].proposal_date = document.getElementById("editPDate").value;
    proposals[index].valid_until = document.getElementById("editPValid").value;
    proposals[index].client = document.getElementById("editPClient").value;
    proposals[index].status = document.getElementById("editPStatus").value;
    proposals[index].note = document.getElementById("editPNote").value;

    saveLS();
    renderProposalTable();

    bootstrap.Modal.getInstance(document.getElementById("editProposalModal")).hide();
}



// ============================================================
// DELETE PROPOSAL
// ============================================================
let deleteProposalId = null;

function openDeleteProposal(id) {
    deleteProposalId = id;
    new bootstrap.Modal(document.getElementById("deleteProposalModal")).show();
}


document.getElementById("confirmDeleteProposal").addEventListener("click", function () {

    proposals = proposals.filter(p => p.id != deleteProposalId);

    saveLS();
    renderProposalTable();

    bootstrap.Modal.getInstance(document.getElementById("deleteProposalModal")).hide();
});

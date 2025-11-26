let leads = [];
let allLeads = [];

const CURRENT_USER = "John Doe";

async function loadLeads() {
    const saved = localStorage.getItem("leads");
    if (saved) {
        leads = JSON.parse(saved);
        allLeads = leads;
        renderAll();
        return;
    }

    const res = await fetch("leads-json.php");
    leads = await res.json();
    allLeads = leads;

    localStorage.setItem("leads", JSON.stringify(leads));
    renderAll();
}

function renderAll() {
    renderList();
    renderKanban();
}

function renderList() {
    const table = document.getElementById("leadsTable");
    table.innerHTML = "";

    leads.forEach(l => {
        table.innerHTML += `
        <tr>
            <td onclick="openClient(${l.id})">
                <a href="Client-View.php?id=${l.id}"
                class="text-decoration-none text-primary fw-semibold"
                onclick="event.stopPropagation()">
                    ${l.name}
                </a>
            </td>

            <td onclick="openClient(${l.id})">
                <a href="Client-Contact.php?id=${l.id}"
                class="text-primary text-decoration-none fw-semibold"
                onclick="event.stopPropagation()">
                    ${l.contact}
                </a>
            </td>

            <td>${l.phone}</td>
            <td>${l.owner}</td>
            <td>${l.label}</td>
            <td>${l.created}</td>
            <td>${l.status}</td>

            <td>
                <button class="btn btn-sm btn-danger" onclick="deleteLead(${l.id})">
                    Delete
                </button>
            </td>
        </tr>`;
    });
}

function renderKanban() {
    const board = document.getElementById("kanbanBoard");
    board.innerHTML = "";

    const stages = ["New", "Qualified", "Discussion"];

    stages.forEach(stage => {
        const safeId = stage.replace(/\s+/g, ''); // remove spaces

        const col = document.createElement("div");
        col.classList.add("col-md-4");
        col.innerHTML = `
            <h5>${stage}</h5>
            <div id="col-${safeId}" class="border rounded p-2"></div>
        `;
        board.appendChild(col);
    });

    leads.forEach(l => {
        const safeStatus = l.status.replace(/\s+/g, '');

       document.getElementById(`col-${safeStatus}`).innerHTML += `
    <div class="p-3 mb-3 bg-white border rounded"
         style="cursor:pointer;"
         onclick="openLeadPage(${l.id})">

        <div class="d-flex align-items-center gap-2">
            <img src="assets/images/users/avatar-6.jpg"
                 width="32" height="32"
                 class="rounded-circle" alt="">
            <b>${l.name}</b>
        </div>

        <small>${l.contact}</small><br>
        <span class="badge bg-info">${l.label}</span>
    </div>
`;
    });
}
function openLeadPage(id) {
    window.location.href = "Client-View.php?id=" + id;
}


document.querySelectorAll(".filter-option, .quick-filter").forEach(btn => {
    btn.addEventListener("click", () => {
        applyFilter(btn.dataset.filter);
    });
});

function applyFilter(f) {
    if (f === "all") leads = allLeads;
    else if (f === "50") leads = allLeads.filter(l => l.label.includes("50"));
    else if (f === "90") leads = allLeads.filter(l => l.label.includes("90"));
    else if (f === "call") leads = allLeads.filter(l => l.label.toLowerCase().includes("call"));
    else if (f === "mine") leads = allLeads.filter(l => l.owner === CURRENT_USER);

    renderAll();
}

// ---------------- FIXED ADD LEAD (Success Modal + List Tab) ----------------
function addLead() {
    const obj = {
        id: Date.now(),
        name: document.getElementById("leadName").value,
        contact: document.getElementById("leadContact").value,
        phone: document.getElementById("leadPhone").value,
        owner: document.getElementById("leadOwner").value,
        label: document.getElementById("leadLabel").value,
        created: new Date().toISOString().split("T")[0],
        status: document.getElementById("leadStatus").value
    };

    allLeads.push(obj);
    leads = allLeads;

    localStorage.setItem("leads", JSON.stringify(allLeads));
    renderAll();

    const addModal = bootstrap.Modal.getInstance(document.getElementById("addLeadModal"));
    addModal.hide();

    setTimeout(() => {
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";
        document.querySelector(".modal-backdrop")?.remove();

        // SHOW success modal
        new bootstrap.Modal(document.getElementById("successModal")).show();

    }, 180);
}

// ---------------- SUCCESS MODAL OK → CLOSE + OPEN LIST TAB ----------------
document.getElementById("successOkBtn")?.addEventListener("click", () => {

    const successModal = bootstrap.Modal.getInstance(document.getElementById("successModal"));
    successModal.hide();

    setTimeout(() => {
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";
        document.querySelector(".modal-backdrop")?.remove();
    }, 150);

    // SWITCH TO LIST TAB
    const listTab = document.querySelector('a[href="#listTab"]');
    const tab = new bootstrap.Tab(listTab);
    tab.show();
});

function deleteLead(id) {
    allLeads = allLeads.filter(l => l.id !== id);
    leads = allLeads;

    localStorage.setItem("leads", JSON.stringify(allLeads));
    renderAll();
}

loadLeads();

// -------------------- EXCEL --------------------
const excelBtn = Array.from(document.querySelectorAll("button.btn-outline-secondary"))
    .find(btn => btn.textContent.trim().toLowerCase() === "excel");

if (excelBtn) {
    excelBtn.addEventListener("click", () => {
        let csv = "Name,Primary Contact,Phone,Owner,Label,Created,Status\n";

        allLeads.forEach(l => {
            csv += `${l.name},${l.contact},${l.phone},${l.owner},${l.label},${l.created},${l.status}\n`;
        });

        const blob = new Blob([csv], { type: "text/csv" });
        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "leads.csv";
        a.click();
    });
}

// -------------------- PRINT --------------------
const printBtn = Array.from(document.querySelectorAll("button.btn-outline-secondary"))
    .find(btn => btn.textContent.trim().toLowerCase() === "print");

if (printBtn) {
    printBtn.addEventListener("click", () => {
        window.print();
    });
}
// -------------------- REFRESH BUTTON --------------------
const refreshBtn = Array.from(document.querySelectorAll("button.btn-outline-secondary"))
    .find(btn => btn.querySelector(".bi-arrow-clockwise"));

if (refreshBtn) {
    refreshBtn.addEventListener("click", () => {
        location.reload(); // simple full page reload
    });
}

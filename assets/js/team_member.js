let teamData = [];
let filtered = [];
let currentPage = 1;
const pageSize = 5;

// default tab
let currentTab = "active";

document.addEventListener("DOMContentLoaded", () => {
    fetch("team_json.php")
        .then(res => res.json())
        .then(data => {
            teamData = data;
            // load active by default
            filtered = teamData.filter(m => m.status === "active");
            renderTable();
        });

    document.getElementById("searchBox").addEventListener("input", searchFilter);
    document.getElementById("btnExcel").addEventListener("click", exportExcel);
    document.getElementById("btnPrint").addEventListener("click", () => window.print());
    document.getElementById("sortJob").addEventListener("click", sortJob);
    document.getElementById("prevPage").addEventListener("click", () => changePage(-1));
    document.getElementById("nextPage").addEventListener("click", () => changePage(1));

    // tab listeners
    document.getElementById("tabActive").addEventListener("click", () => switchTab("active"));
    document.getElementById("tabInactive").addEventListener("click", () => switchTab("inactive"));

    initImportModal();
    initInvitationModal();
    initAddMemberWizard();
});

function switchTab(tabName) {
    currentTab = tabName;

    document.getElementById("tabActive").classList.remove("active");
    document.getElementById("tabInactive").classList.remove("active");

    if (tabName === "active") document.getElementById("tabActive").classList.add("active");
    else document.getElementById("tabInactive").classList.add("active");

    filtered = teamData.filter(m => m.status === currentTab);
    currentPage = 1;
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById("teamBody");
    tbody.innerHTML = "";

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;

    const pageItems = filtered.slice(start, end);

    pageItems.forEach(member => {
        const row = `
            <tr>
                <td class="d-flex align-items-center gap-2"><img src="${member.avatar}" width="40" height="40" class="rounded-circle"><a href="member_view.php?email=${member.email}" class="text-primary" style="text-decoration:none;">${member.name}</a></td>
                <td>${member.job}</td>
                <td>${member.email}</td>
                <td>${member.phone}</td>
                <td>
                    <button class="btn btn-light rounded-circle p-1" onclick="deleteMember('${member.email}')">
                        <i class="bi bi-x"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });

    document.getElementById("pageText").innerText =
        `${start + 1}–${Math.min(end, filtered.length)} / ${filtered.length}`;
}

function searchFilter(e) {
    const query = e.target.value.toLowerCase();

    filtered = teamData.filter(m =>
        m.status === currentTab && (
            m.name.toLowerCase().includes(query) ||
            m.job.toLowerCase().includes(query) ||
            m.email.toLowerCase().includes(query)
        )
    );

    currentPage = 1;
    renderTable();
}

function deleteMember(email) {
    // move to inactive
    const member = teamData.find(m => m.email === email);
    if (member) member.status = "inactive";

    // refresh filtered for current tab
    filtered = teamData.filter(m => m.status === currentTab);
    renderTable();
}

let sortAsc = true;
function sortJob() {
    filtered.sort((a, b) =>
        sortAsc ? a.job.localeCompare(b.job) : b.job.localeCompare(a.job)
    );
    sortAsc = !sortAsc;
    renderTable();
}

function changePage(step) {
    const maxPage = Math.ceil(filtered.length / pageSize);
    currentPage += step;
    if (currentPage < 1) currentPage = 1;
    if (currentPage > maxPage) currentPage = maxPage;
    renderTable();
}

function exportExcel() {
    let csv = "Name,Job Title,Email,Phone\n";
    filtered.forEach(m => {
        csv += `${m.name},${m.job},${m.email},${m.phone}\n`;
    });

    const blob = new Blob([csv], { type: "text/csv" });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "team_members.csv";
    a.click();
}


/* ------------------------------------------------------------------
   MODAL: IMPORT
------------------------------------------------------------------ */
function initImportModal() {
    const drop = document.getElementById("importDrop");
    const fileInput = document.getElementById("importFile");
    const nextBtn = document.getElementById("importNextBtn");
    const downloadSample = document.getElementById("downloadSample");

    drop && drop.addEventListener("click", () => fileInput && fileInput.click());
    fileInput && fileInput.addEventListener("change", () => alert("File selected successfully!"));
    nextBtn && nextBtn.addEventListener("click", () => alert("Import complete."));

    downloadSample && downloadSample.addEventListener("click", () => {
        // sample CSV content
        const sample = "name,job,email,phone,status\nJohn Doe,Admin,john@demo.com,+123456789,active\n";
        const blob = new Blob([sample], { type: "text/csv" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "sample_team.csv";
        a.click();
    });
}

/* ------------------------------------------------------------------
   MODAL: INVITE
------------------------------------------------------------------ */
function initInvitationModal() {
    const addBtn = document.getElementById("addMoreEmail");
    const sendBtn = document.getElementById("sendInviteBtn");
    const emailList = document.getElementById("emailList");

    addBtn && addBtn.addEventListener("click", () => {
        emailList.innerHTML += `<input type="email" class="form-control mb-2 inviteEmail" placeholder="Email">`;
    });

    sendBtn && sendBtn.addEventListener("click", () => {
        const emails = [...document.querySelectorAll(".inviteEmail")].map(i => i.value).filter(x => x);
        if (emails.length === 0) {
            alert("Enter at least one email.");
            return;
        }
        alert("Invitations sent to:\n" + emails.join("\n"));
        // close modal if bootstrap present
        const modalEl = document.getElementById("inviteModal");
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal && modal.hide();
        }
    });
}

/* ------------------------------------------------------------------
   MODAL: ADD MEMBER WIZARD
------------------------------------------------------------------ */
function initAddMemberWizard() {
    let step = 1;

    const nextBtn = document.getElementById("nextStepBtn");
    const tabs = document.querySelectorAll(".wizardTab");
    const steps = document.querySelectorAll(".wizardStep");

    function showStep() {
        steps.forEach(s => s.classList.add("d-none"));
        document.getElementById(`step${step}`).classList.remove("d-none");

        tabs.forEach(t => t.classList.remove("active"));
        document.querySelector(`.wizardTab[data-step="${step}"]`).classList.add("active");

        nextBtn.innerHTML =
            step === 3
                ? `Finish <i class="bi bi-check-circle"></i>`
                : `Next <i class="bi bi-arrow-right-circle"></i>`;
    }

    nextBtn && nextBtn.addEventListener("click", () => {
        if (step === 3) {
            addNewMember();
            step = 1;
            showStep();
            // hide modal
            const modalEl = document.getElementById("addMemberModal");
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal && modal.hide();
            }
            return;
        }
        step++;
        showStep();
    });

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            step = parseInt(tab.dataset.step);
            showStep();
        });
    });

    showStep();
}

/* ------------------------------------------------------------------
   ADD NEW MEMBER (always active)
------------------------------------------------------------------ */
function addNewMember() {
    // note: the step1 inputs are in order: first, last, (textarea), phone
    const first = (document.querySelector("#step1 input:nth-of-type(1)") || {}).value || "New";
    const last = (document.querySelector("#step1 input:nth-of-type(2)") || {}).value || "Member";
    const phone = (document.querySelector("#step1 input:nth-of-type(3)") || {}).value || "---";
    const job = (document.querySelector("#step2 input:nth-of-type(1)") || {}).value || "Employee";
    const email = (first + "." + last + "@demo.com").toLowerCase();

    const newMember = {
        name: first + " " + last,
        email: email,
        phone: phone,
        job: job,
        avatar: "https://i.pravatar.cc/40?u=" + Date.now(),
        status: "active"
    };

    teamData.push(newMember);

    // refresh filtered according to currentTab
    filtered = teamData.filter(m => m.status === currentTab);
    renderTable();
    alert("Member added successfully!");
}

document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================================
       1. GLOBAL VARIABLES
    ========================================================== */
    let tasksData = [];
    let filteredData = [];

    /* ==========================================================
       2. FETCH DATA FROM PHP
    ========================================================== */
    fetch('tasks_json.php')
        .then(response => response.json())
        .then(data => {
            tasksData = data;
            filteredData = data;
            renderTable(data);
            renderKanban();
        });

    /* ==========================================================
       3. RENDER TASK TABLE
    ========================================================== */
    function renderTable(data) {
        const tbody = document.getElementById('tasks-body');
        tbody.innerHTML = "";

        data.forEach(task => {
            const row = document.createElement('tr');
            row.setAttribute("data-id", task.id);

            row.innerHTML = `
                <td>${task.id}</td>
                <td>
                    <span class="text-primary taskTitleClick" 
                        style="cursor:pointer;" 
                        data-id="${task.id}">
                        ${task.title}
                    </span>
                </td>
                <td>${task.start_date}</td>
                <td>${task.deadline}</td>
                <td>${task.milestone}</td>
                <td>${task.related_to}</td>
                <td><img src="https://via.placeholder.com/30" class="rounded-circle me-2">${task.assigned_to}</td>
                <td>${task.collaborators}</td>
                <td>${task.status}</td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm editBtn"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-outline-secondary btn-sm deleteBtn"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });

        attachEvents();
    }

    /* ==========================================================
       4. ATTACH BUTTON + TITLE EVENTS
    ========================================================== */
    function attachEvents() {

        /* ---------- DELETE BUTTON ---------- */
        document.querySelectorAll(".deleteBtn").forEach(btn => {
            btn.onclick = function () {
                const row = this.closest("tr");
                const id = row.getAttribute("data-id");

                if (confirm("Are you sure you want to delete this task?")) {
                    tasksData = tasksData.filter(t => t.id != id);
                    filteredData = filteredData.filter(t => t.id != id);

                    row.remove();
                    renderKanban();
                }
            };
        });

        /* ---------- EDIT BUTTON ---------- */
        document.querySelectorAll(".editBtn").forEach(btn => {
            btn.onclick = function () {
                const row = this.closest("tr");
                const id = row.getAttribute("data-id");
                const task = tasksData.find(t => t.id == id);

                document.getElementById("editId").value = task.id;
                document.getElementById("editTitle").value = task.title;
                document.getElementById("editStatus").value = task.status;

                new bootstrap.Modal(document.getElementById("editModal")).show();
            };
        });

        /* ---------- TASK TITLE CLICK ---------- */
        document.querySelectorAll(".taskTitleClick").forEach(title => {
            title.onclick = function () {
                const id = this.getAttribute("data-id");
                openTaskModal(id);
            };
        });
    }

    /* ==========================================================
       4B. OPEN TASK MODAL (USED BY LIST & KANBAN)
    ========================================================== */
    function openTaskModal(id) {
        const task = tasksData.find(t => t.id == id);
        if (!task) return;

        document.getElementById("modalTaskTitle").innerText = task.title;
        document.getElementById("modalTaskDesc").innerText = task.title;
        document.getElementById("modalProjectName").innerText = task.title;
        document.getElementById("modalUserName").innerText = task.assigned_to;
        document.getElementById("modalUserImg").src = "https://via.placeholder.com/40";

        let badge = document.getElementById("modalStatusBadge");
        badge.innerText = task.status;
        badge.className = "badge";

        if (task.status === "To do") badge.classList.add("bg-secondary");
        if (task.status === "In progress") badge.classList.add("bg-info");
        if (task.status === "Review") badge.classList.add("bg-warning");
        if (task.status === "Done") badge.classList.add("bg-success");

        new bootstrap.Modal(document.getElementById("taskModal")).show();
    }

    /* ==========================================================
       5. SAVE EDIT CHANGES
    ========================================================== */
    window.saveEdit = function () {
        const id = document.getElementById("editId").value;
        const title = document.getElementById("editTitle").value;
        const status = document.getElementById("editStatus").value;

        tasksData = tasksData.map(t =>
            t.id == id ? { ...t, title: title, status: status } : t
        );

        filteredData = tasksData;
        renderTable(filteredData);
        renderKanban();

        bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
    };

    /* ==========================================================
       6. SEARCH FUNCTION
    ========================================================== */
    document.querySelector("#taskSearch")?.addEventListener("keyup", function () {
        const value = this.value.toLowerCase();

        filteredData = tasksData.filter(task =>
            task.title.toLowerCase().includes(value) ||
            task.id.toString().includes(value)
        );

        renderTable(filteredData);
        renderKanban();
    });

    /* ==========================================================
       7. FILTER FUNCTION
    ========================================================== */
    function applyFilter(type) {
        if (type === "All") filteredData = tasksData;
        else filteredData = tasksData.filter(task =>
            task.status.toLowerCase() === type.toLowerCase()
        );

        renderTable(filteredData);
        renderKanban();
    }

    /* ==========================================================
       8. EXPORT CSV
    ========================================================== */
    document.getElementById("excelBtn")?.addEventListener("click", function () {
        let csvContent =
            "ID,Title,Start Date,Deadline,Milestone,Related To,Assigned To,Collaborators,Status\n";

        filteredData.forEach(t => {
            csvContent += `${t.id},${t.title},${t.start_date},${t.deadline},${t.milestone},${t.related_to},${t.assigned_to},${t.collaborators},${t.status}\n`;
        });

        const blob = new Blob([csvContent], { type: "text/csv" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "tasks_export.csv";
        a.click();
    });

    /* ==========================================================
       9. PRINT TABLE
    ========================================================== */
    document.getElementById("printBtn")?.addEventListener("click", function () {
        const printWindow = window.open("", "_blank");
        printWindow.document.write("<html><head><title>Print Tasks</title></head><body>");
        printWindow.document.write(document.querySelector("table").outerHTML);
        printWindow.document.write("</body></html>");
        printWindow.document.close();
        printWindow.print();
    });

    /* ==========================================================
       10. RENDER KANBAN BOARD
    ========================================================== */
    function renderKanban() {
        const todo = document.getElementById("kanbanTodo");
        const progress = document.getElementById("kanbanInProgress");
        const review = document.getElementById("kanbanReview");
        const done = document.getElementById("kanbanDone");

        if (!todo) return;

        todo.innerHTML = "";
        progress.innerHTML = "";
        review.innerHTML = "";
        done.innerHTML = "";

        filteredData.forEach(task => {
            const card = `
                <div class="p-2 mb-2 border rounded bg-light kanbanCard"
                     data-id="${task.id}"
                     style="cursor:pointer;">
                    <div class="fw-semibold">${task.id}. ${task.title}</div>
                    <div class="small text-muted">📅 ${task.deadline}</div>
                </div>
            `;

            if (task.status === "To do") todo.innerHTML += card;
            if (task.status === "In progress") progress.innerHTML += card;
            if (task.status === "Review") review.innerHTML += card;
            if (task.status === "Done") done.innerHTML += card;
        });

        attachKanbanEvents(); // ⭐ REQUIRED
    }

    /* ==========================================================
       10B. KANBAN CARD CLICK EVENT
    ========================================================== */
    function attachKanbanEvents() {
        document.querySelectorAll(".kanbanCard").forEach(card => {
            card.onclick = function () {
                const id = this.getAttribute("data-id");
                openTaskModal(id);
            };
        });
    }

    /* ==========================================================
       11. VIEW SWITCH
    ========================================================== */
    window.showList = function () {
        document.getElementById("listSection").classList.remove("d-none");
        document.getElementById("kanbanSection").classList.add("d-none");
    };

    window.showKanban = function () {
        document.getElementById("kanbanSection").classList.remove("d-none");
        document.getElementById("listSection").classList.add("d-none");
        renderKanban();
    };

}); // END DOMContentLoaded

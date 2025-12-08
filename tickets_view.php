<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<?php
// Ticket values passed via URL
$id     = isset($_GET['id']) ? $_GET['id'] : "Ticket";
$title  = isset($_GET['title']) ? $_GET['title'] : "Untitled Ticket";
?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1"><?= htmlspecialchars($id) ?> - <?= htmlspecialchars($title) ?></h4>

            <div class="d-flex align-items-center gap-2 mt-2">
                <span class="badge bg-secondary">Closed</span>

                <a href="#" class="text-decoration-none small text-muted">
                    <i class="bi bi-plus-circle"></i> Add Label
                </a>

                <div class="d-flex align-items-center gap-1">
                    <img src="assets/images/users/avatar-6.jpg" class="rounded-circle" width="28" height="28">
                    <span class="small">Sara Ann</span>
                </div>

                <span class="small text-muted">Just now</span>
            </div>
        </div>

        <button class="btn btn-danger btn-sm">Mark as Open</button>
    </div>

    <div class="row">

<!-- LEFT SIDE -->
<div class="col-lg-8">

    <!-- REPLY BOX -->
    <div class="card mb-4">
        <div class="card-body">

            <!-- Sender Dropdown -->
            <div class="d-flex align-items-center gap-2 mb-2">
                <img src="assets/images/users/avatar-6.jpg" width="35" class="rounded-circle">

                <select id="senderSelect" class="form-select form-select-sm w-auto">
                    <option value="You">You (Agent)</option>
                    <option value="Blaze Rohan">Client: Blaze Rohan</option>
                </select>

                <span class="small text-muted">Now</span>
            </div>

            <textarea class="form-control mb-3" id="replyText" rows="5" placeholder="Write a reply..."></textarea>

            <input type="file" id="fileInput" class="d-none">
            <span id="selectedFileName" class="small text-muted"></span>

            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" id="uploadFileBtn">
                        <i class="bi bi-upload"></i> Upload File
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-earmark"></i> Template
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm">Save as note</button>
                    <button class="btn btn-primary btn-sm" id="sendMsgBtn">Send</button>
                </div>
            </div>

        </div>
    </div>

    <!-- MESSAGES TIMELINE -->
    <div class="card mb-3">
        <div class="card-body" id="messageTimeline">
            <!-- Dynamic messages inserted here -->
        </div>
    </div>

</div>

<!-- RIGHT SIDEBAR -->
<div class="col-lg-4">

    <!-- TICKET INFO -->
    <div class="card mb-3">
    <div class="card-body">

        <h6 class="fw-semibold mb-3 text-dark">
            <i class="bi bi-info-circle me-1 text-muted"></i> Ticket Info
        </h6>

        <div class="text-center mb-3">
            <span class="badge bg-secondary">General Support</span>
        </div>

        <div class="row text-center mb-3">
            <div class="col">
                <h4 class="mb-0 text-danger" id="inCount">0</h4>
                <small class="text-muted">In messages</small>
            </div>
            <div class="col">
                <h4 class="mb-0 text-primary" id="outCount">0</h4>
                <small class="text-muted">Out messages</small>
            </div>
        </div>

        <p class="small text-muted mb-1">
            <i class="bi bi-clock me-1 text-muted"></i> Today at 04:42 pm
        </p>
        <p class="small text-muted">
            <i class="bi bi-clock-history me-1 text-muted"></i> Today at 04:42 pm
        </p>

    </div>
</div>


    <!-- CLIENT INFO -->
    <div class="card mb-3">
    <div class="card-body">

        <h6 class="fw-semibold mb-3 text-dark">
            <i class="bi bi-person-circle me-1 text-muted"></i> Client Info
        </h6>

        <p class="fw-semibold mb-1 text-dark"><a href="Client-View.php">Blaze Rohan</a></p>

        <p class="mb-1 text-muted"><i class="bi bi-telephone me-2 text-muted"></i> 1-267-468-6486</p>

        <p class="mb-1 text-muted"><i class="bi bi-ticket-detailed me-2 text-muted"></i> 6 Tickets</p>

        <p class="mb-1 text-muted"><i class="bi bi-envelope me-2 text-muted"></i> CC</p>

    </div>
</div>


    <!-- TASKS -->
   <div class="card mb-3">
    <div class="card-body">
        <h6 class="fw-semibold mb-3 text-dark">Tasks</h6>
        <button class="btn btn-outline-secondary btn-sm w-100" onclick="openTaskModal()">+ Add task</button>

        <ul id="taskList" class="list-group mt-2 text-dark"></ul>
    </div>
</div>


    <!-- REMINDERS -->
    <div class="card mb-3">
    <div class="card-body">
        <h6 class="fw-semibold mb-3 text-dark">Reminders (Private)</h6>
        <button class="btn btn-outline-secondary btn-sm w-100" onclick="openReminderModal()">+ Add reminder</button>

        <ul id="reminderList" class="list-group mt-2 text-dark"></ul>
    </div>
</div>


</div>

    </div>

</div>
</div>
</div>
<!-- ADD TASK MODAL -->
<div class="modal fade" id="taskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add Task</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="text" id="taskText" class="form-control" placeholder="Enter task..." />
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveTaskBtn">Save Task</button>
      </div>

    </div>
  </div>
</div>

<!-- ADD REMINDER MODAL -->
<div class="modal fade" id="reminderModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add Reminder</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="text" id="reminderText" class="form-control" placeholder="Enter reminder..." />
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveReminderBtn">Save Reminder</button>
      </div>

    </div>
  </div>
</div>


<?php include 'common/footer.php'; ?>

<script>
let TICKET_ID = "<?= $id ?>";

// Load or create ticket storage
function loadTicketData() {
    let data = localStorage.getItem("ticket-" + TICKET_ID);
    return data ? JSON.parse(data) : { messages: [], tasks: [], reminders: [] };
}

function saveTicketData(data) {
    localStorage.setItem("ticket-" + TICKET_ID, JSON.stringify(data));
}

let ticketData = loadTicketData();

/* ------------------------------------------
   FILE UPLOAD
------------------------------------------- */
document.getElementById("uploadFileBtn").addEventListener("click", () => {
    document.getElementById("fileInput").click();
});

let uploadedFile = null;

document.getElementById("fileInput").addEventListener("change", function () {
    uploadedFile = this.files[0];
    document.getElementById("selectedFileName").innerText =
        uploadedFile ? "📎 " + uploadedFile.name : "";
});

/* ------------------------------------------
   SEND MESSAGE (YOU or CLIENT)
------------------------------------------- */
document.getElementById("sendMsgBtn").addEventListener("click", () => {
    let sender = document.getElementById("senderSelect").value;
    let text = document.getElementById("replyText").value.trim();

    if (!text && !uploadedFile) return;

    let msgObj = {
        user: sender,
        text: text,
        file: uploadedFile ? uploadedFile.name : null,
        time: new Date().toLocaleString()
    };

    ticketData.messages.push(msgObj);
    saveTicketData(ticketData);

    appendMessage(msgObj);

    // Reset input
    document.getElementById("replyText").value = "";
    document.getElementById("fileInput").value = "";
    document.getElementById("selectedFileName").innerText = "";
    uploadedFile = null;

    updateCounts();
});

/* ------------------------------------------
   APPEND MESSAGE TO TIMELINE
------------------------------------------- */
function appendMessage(msg) {
    let avatar = msg.user === "You"
        ? "assets/images/users/avatar-6.jpg"
        : "assets/images/users/most-attractive-man-in-a-country-v0-kvv18zjkat8b1.webp";

    let container = document.getElementById("messageTimeline");

    container.innerHTML += `
        <div class="d-flex mb-4">
            <img src="${avatar}" class="rounded-circle me-3" width="35" height="35">

            <div>
                <strong>${msg.user}</strong>
                <span class="small text-muted">${msg.time}</span>

                <p class="mt-1 small">${msg.text}</p>

                ${msg.file ? `<a href="#" class="small text-primary">📎 ${msg.file}</a>` : ""}
            </div>
        </div>
    `;
}

/* ------------------------------------------
   UPDATE COUNTS
------------------------------------------- */
function updateCounts() {
    let incoming = ticketData.messages.filter(m => m.user !== "You").length;
    let outgoing = ticketData.messages.filter(m => m.user === "You").length;

    document.getElementById("inCount").innerText = incoming;
    document.getElementById("outCount").innerText = outgoing;
}

/* ------------------------------------------
   TASK + REMINDER MODAL LOGIC
------------------------------------------- */

// Open Task Modal
function openTaskModal() {
    let modal = new bootstrap.Modal(document.getElementById("taskModal"));
    modal.show();
}

// Save Task
document.getElementById("saveTaskBtn").addEventListener("click", () => {
    let task = document.getElementById("taskText").value.trim();
    if (task === "") return;

    ticketData.tasks.push(task);
    saveTicketData(ticketData);

    renderTasks();

    let modal = bootstrap.Modal.getInstance(document.getElementById("taskModal"));
    modal.hide();
    document.getElementById("taskText").value = "";
});

// Render Tasks
function renderTasks() {
    let list = document.getElementById("taskList");
    list.innerHTML = "";

    ticketData.tasks.forEach(t => {
        list.innerHTML += `<li class="list-group-item">${t}</li>`;
    });
}


// Open Reminder Modal
function openReminderModal() {
    let modal = new bootstrap.Modal(document.getElementById("reminderModal"));
    modal.show();
}

// Save Reminder
document.getElementById("saveReminderBtn").addEventListener("click", () => {
    let note = document.getElementById("reminderText").value.trim();
    if (note === "") return;

    ticketData.reminders.push(note);
    saveTicketData(ticketData);

    renderReminders();

    let modal = bootstrap.Modal.getInstance(document.getElementById("reminderModal"));
    modal.hide();
    document.getElementById("reminderText").value = "";
});

// Render Reminders
function renderReminders() {
    let list = document.getElementById("reminderList");
    list.innerHTML = "";

    ticketData.reminders.forEach(r => {
        list.innerHTML += `<li class="list-group-item">${r}</li>`;
    });
}

/* ------------------------------------------
   INITIAL LOAD
------------------------------------------- */
window.onload = () => {
    ticketData.messages.forEach(m => appendMessage(m));
    renderTasks();
    renderReminders();
    updateCounts();
};
</script>


</body>
</html>

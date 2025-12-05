<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

<div class="container-fluid p-4">

    <!-- TOP BUTTONS -->
    <div class="d-flex mb-3 gap-2">
        <!-- Compose trigger -->
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#composeModal">
            <i class="bi bi-plus-lg"></i> Compose
        </button>

        <button class="btn btn-light border d-flex align-items-center gap-2">
            <i class="bi bi-inbox"></i> Inbox
        </button>

        <button class="btn btn-light border d-flex align-items-center gap-2">
            <i class="bi bi-send"></i> Sent
        </button>
    </div>

    <div class="row g-3">

        <!-- LEFT PANEL -->
        <div class="col-4">
            <div class="border bg-white rounded">

                <!-- Title -->
                <div class="p-2 border-bottom d-flex align-items-center gap-2 small">
                    <i class="bi bi-send"></i>
                    <span>Sent items</span>
                </div>

                <!-- Search -->
                <div class="px-2 py-2 border-bottom">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <!-- Mail item -->
                <div class="px-2 py-2 border-bottom d-flex gap-2" id="mailItem" style="cursor:pointer;">

                    <img src="https://i.pravatar.cc/40?img=47" class="rounded-circle" width="35" height="35">

                    <div class="small">
                        <div class="fw-semibold">Emily Smith</div>
                        <div class="text-muted small">Today at 11:15:55 am</div>

                        <span class="badge bg-primary mt-1">Reply</span>

                        <div class="mt-1">
                            Need to discuss about new project
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="p-2 small d-flex justify-content-between align-items-center">

                    <select class="form-select form-select-sm w-auto">
                        <option>10</option>
                    </select>

                    <div class="text-muted small">1-1 / 1</div>

                    <div class="d-flex align-items-center gap-1">
                        <button class="btn btn-light border btn-sm px-2">&lt;</button>
                        <button class="btn btn-primary btn-sm px-3">1</button>
                        <button class="btn btn-light border btn-sm px-2">&gt;</button>
                    </div>

                </div>

            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="col-8">

            <!-- Placeholder -->
            <div class="border bg-white rounded d-flex flex-column justify-content-center align-items-center py-5" id="rightPlaceholder">
                <div class="text-muted small mb-2">Select a message to view</div>
                <i class="bi bi-envelope text-muted" style="font-size:60px;"></i>
            </div>

            <!-- Conversation View (Hidden initially) -->
            <div class="border bg-white rounded p-3 d-none" id="conversationView">

                <h6 id="convName" class="fw-semibold mb-3"></h6>

                <div id="convMessages"></div>

                <div class="d-flex align-items-start mt-4 gap-2">
                    <img src="https://i.pravatar.cc/40?img=32" class="rounded-circle" width="40">
                    <textarea class="form-control" id="replyInput" placeholder="Write a reply..." rows="2"></textarea>
                </div>

                <div class="d-flex mt-2 gap-2">
                    <button class="btn btn-light border d-flex align-items-center gap-2" id="chatUploadBtn">
                        <i class="bi bi-upload"></i> Upload File
                    </button>

                    <button class="btn btn-light border d-flex align-items-center">
                        <i class="bi bi-mic"></i>
                    </button>

                    <button class="btn btn-primary d-flex align-items-center gap-2 ms-auto" id="chatSendBtn">
                        <i class="bi bi-send-fill"></i> Reply
                    </button>
                </div>

            </div>

        </div>

    </div>

</div>

  </div>
</div>

<!-- ========================= -->
<!-- COMPOSE MODAL -->
<!-- ========================= -->

<div class="modal" id="composeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Send message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">To</label>
          <select class="form-select" id="msgTo">
            <option value="">-</option>
            <option value="Emily Smith">Emily Smith</option>
            <option value="Mark Johnson">Mark Johnson</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Subject</label>
          <input type="text" class="form-control" id="msgSubject" placeholder="Subject">
        </div>

        <div class="mb-3">
          <textarea class="form-control" id="msgBody" rows="10" placeholder="Write a message..."></textarea>
        </div>

      </div>

      <div class="modal-footer d-flex justify-content-between">

        <div class="d-flex gap-2">
          <button class="btn btn-light border d-flex align-items-center gap-2" id="uploadBtn">
            <i class="bi bi-upload"></i> Upload File
          </button>

          <button class="btn btn-light border d-flex align-items-center">
            <i class="bi bi-mic"></i>
          </button>
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary d-flex align-items-center gap-2" id="sendMessageBtn">
            <i class="bi bi-send-fill"></i> Send
          </button>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- Hidden file input for ALL uploads -->
<input type="file" id="hiddenFileInput" multiple style="display:none;">

<?php include 'common/footer.php'; ?>

<!-- ========================= -->
<!-- JAVASCRIPT LOGIC (FRONTEND ONLY) -->
<!-- ========================= -->

<script>
document.addEventListener("DOMContentLoaded", () => {

    /* ============================================================
       FILE UPLOAD (Frontend only)
    ============================================================ */
    const uploadBtn = document.getElementById("uploadBtn");
    const chatUploadBtn = document.getElementById("chatUploadBtn");
    const hiddenFileInput = document.getElementById("hiddenFileInput");
    let selectedFiles = [];

    uploadBtn.addEventListener("click", () => hiddenFileInput.click());
    chatUploadBtn.addEventListener("click", () => hiddenFileInput.click());

    hiddenFileInput.addEventListener("change", (e) => {
        selectedFiles = Array.from(e.target.files);
        alert(selectedFiles.length + " file(s) selected");
    });



    /* ============================================================
       SAMPLE CONVERSATION STORAGE (Frontend only)
    ============================================================ */
    let conversationData = [
        { sender: "Emily Smith", message: "Hi John, I would like to discuss our new project. When can we do it?", time: "Today at 07:49:58 am" },
        { sender: "Me", message: "We can discuss on Monday :)", time: "Today at 11:15:27 am" },
        { sender: "Emily Smith", message: "OK. No problem.", time: "Today at 11:15:55 am" },
        { sender: "Me", message: "Great!", time: "Today at 06:15:49 am" },
        { sender: "Me", message: "hii", time: "Today at 06:15:49 am" }
    ];



    /* ============================================================
       LOAD CONVERSATION WHEN LEFT MAIL ITEM CLICKED
    ============================================================ */

    const mailItem = document.getElementById("mailItem");
    const placeholder = document.getElementById("rightPlaceholder");
    const conversation = document.getElementById("conversationView");
    const convName = document.getElementById("convName");
    const convMessages = document.getElementById("convMessages");

    function loadConversation() {
        placeholder.classList.add("d-none");
        conversation.classList.remove("d-none");

        convName.innerText = "Emily Smith";
        convMessages.innerHTML = "";

        conversationData.forEach(msg => {
            convMessages.innerHTML += `
                <div class="d-flex justify-content-between border-bottom py-2">
                    <div>
                        <div class="fw-semibold">${msg.sender}</div>
                        <div>${msg.message}</div>
                        ${msg.file ? `<div class='text-muted small'>📎 ${msg.file}</div>` : ""}
                    </div>
                    <div class="small text-muted">${msg.time}</div>
                </div>
            `;
        });
    }

    mailItem.addEventListener("click", loadConversation);



    /* ============================================================
       SEND REPLY — Add Message to Conversation
    ============================================================ */

    const chatSendBtn = document.getElementById("chatSendBtn");
    const replyInput = document.getElementById("replyInput");

    chatSendBtn.addEventListener("click", () => {

        const text = replyInput.value.trim();

        if (!text && selectedFiles.length === 0) {
            alert("Type a reply or upload a file.");
            return;
        }

        const now = new Date();
        const time = now.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit", second: "2-digit" });

        const fileName = selectedFiles.length > 0 ? selectedFiles[0].name : null;

        // Add new reply on top
        conversationData.unshift({
            sender: "Me",
            message: text,
            file: fileName,
            time: "Today at " + time
        });

        selectedFiles = [];
        replyInput.value = "";
        hiddenFileInput.value = "";

        loadConversation();
    });



    /* ============================================================
       COMPOSE MODAL — FRONTEND ONLY
    ============================================================ */

    const sendMessageBtn = document.getElementById("sendMessageBtn");
    const toField = document.getElementById("msgTo");
    const subjectField = document.getElementById("msgSubject");
    const bodyField = document.getElementById("msgBody");

    sendMessageBtn.addEventListener("click", () => {

        if (!toField.value || !subjectField.value || !bodyField.value.trim()) {
            alert("Please fill all fields.");
            return;
        }

        alert("Message composed (frontend only).");

        toField.value = "";
        subjectField.value = "";
        bodyField.value = "";
        hiddenFileInput.value = "";
        selectedFiles = [];

        const modal = bootstrap.Modal.getInstance(document.getElementById("composeModal"));
        modal.hide();
    });

});
</script>

</body>
</html>

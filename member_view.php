<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <?php
    // read email param to identify member
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    ?>

    <div class="container-fluid p-0">

      <input type="hidden" id="profileEmail" value="<?= htmlspecialchars($email) ?>">

      <!-- BLUE HEADER: left icons (camera/upload), avatar, details, right stats -->
      <div class="w-100 bg-primary" style="background-color:#6892E0;">
        <div class="row py-2 px-3 align-items-center">

          <!-- LEFT SECTION -->
          <div class="col-md-4 d-flex flex-column align-items-center text-center">

            <!-- vertical icons + avatar -->
            <div class="d-flex align-items-center mt-2">
              <!-- icons column -->
              <div class="d-flex flex-column me-3">
                <button id="cameraBtn" type="button" class="btn btn-outline-light rounded-circle mb-2"
                        aria-label="Camera">
                  <i class="bi bi-camera-fill"></i>
                </button>

                <button id="uploadBtn" type="button" class="btn btn-outline-light rounded-circle"
                        aria-label="Upload">
                  <i class="bi bi-upload"></i>
                </button>

                <input type="file" id="avatarInput" accept="image/*" hidden>
              </div>

              <!-- avatar -->
              <img id="avatar" src="https://i.pravatar.cc/140" alt="avatar" width="120" height="120"
                   class="rounded-circle">
            </div>

            <!-- job badge -->
            <span id="jobTitle" class="badge rounded-pill mt-2 mb-1 text-white" style="background:#2CB3F5;">
            </span>

            <!-- name -->
            <h5 id="fullName" class="mt-1 mb-2 text-white fw-semibold">Member Name</h5>

            <!-- contact -->
            <div class="d-flex justify-content-center gap-2 text-white small">
              <i class="bi bi-envelope"></i>
              <span id="emailText">email@demo.com</span>
            </div>

            <div class="d-flex justify-content-center gap-2 text-white small mb-2">
              <i class="bi bi-telephone"></i>
              <span id="phoneText">+1 234-567-8974</span>
            </div>

            <!-- social icons -->
            <div class="d-flex gap-2 mb-2">
              <a id="fbLink" href="https://facebook.com/" target="_blank"
                 class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center"
                 role="button" aria-label="Facebook">
                <i class="bi bi-facebook"></i>
              </a>

              <a id="ytLink" href="https://youtube.com/" target="_blank"
                 class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center"
                 role="button" aria-label="YouTube">
                <i class="bi bi-youtube"></i>
              </a>
            </div>

            <!-- action buttons -->
            <div class="d-flex gap-2 mb-1">
              <button id="sendMsgBtn" class="btn btn-outline-light btn-sm">
                <i class="bi bi-chat-dots"></i> Send message
              </button>
              <button id="reminderBtn" class="btn btn-outline-light btn-sm">
                <i class="bi bi-alarm"></i> Reminders
              </button>
            </div>

          </div>

          <!-- RIGHT STATS -->
          <div class="col-md-8 d-flex align-items-center">
            <div class="row text-center w-100 text-white small">

              <div class="col-6 mb-2">
                <h3 class="fw-bold m-0">23</h3>
                <div>OPEN PROJECTS</div>
              </div>

              <div class="col-6 mb-2">
                <h3 class="fw-bold m-0">7</h3>
                <div>PROJECTS COMPLETED</div>
              </div>

              <div class="col-12">
                <hr class="my-2" style="border-color:rgba(255,255,255,0.35);">
              </div>

              <div class="col-6">
                <h3 class="fw-bold m-0">219.83</h3>
                <div>TOTAL HOURS WORKED</div>
              </div>

              <div class="col-6">
                <h3 class="fw-bold m-0">216.92</h3>
                <div>TOTAL PROJECT HOURS</div>
              </div>

            </div>
          </div>

        </div>
      </div>

      <!-- TABS (one horizontal row) -->
      <div class="border-bottom mt-1">
        <ul class="nav nav-tabs px-3" id="profileTabs" style="font-size:15px; white-space:nowrap; overflow:auto;">
          <li class="nav-item"><button class="nav-link active" data-tab="timeline">Timeline</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="general">General Info</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="social">Social Links</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="job">Job Info</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="account">Account settings</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="files">Files</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="notes">Notes</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="projects">Projects</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="timesheets">Timesheets</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="timecards">Time cards</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="leave">Leave</button></li>
          <li class="nav-item"><button class="nav-link" data-tab="expenses">Expenses</button></li>
        </ul>
      </div>

      <!-- TAB CONTENT CONTAINER -->
      <div id="tabContentArea" class="py-4 px-3">

        <!-- default timeline content -->
        <div id="timeline" class="tab-pane active">
          <div class="text-center text-muted mt-5">
            <i class="bi bi-menu-down" style="font-size:45px;"></i><br>
            No posts to show
          </div>
        </div>

        <!-- General Info template (id general) -->
        <div id="general" class="tab-pane d-none">
          <h5>General Info</h5>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-4">First name</div>
                <div class="col-8"><input id="gi_first" class="form-control" placeholder="First name"></div>

                <div class="col-4">Last name</div>
                <div class="col-8"><input id="gi_last" class="form-control" placeholder="Last name"></div>

                <div class="col-4">Mailing address</div>
                <div class="col-8"><textarea id="gi_address" class="form-control" placeholder="Mailing address"></textarea></div>

                <div class="col-4">Phone</div>
                <div class="col-8"><input id="gi_phone" class="form-control" placeholder="+1 234-567-8974"></div>

                <div class="col-4">Date of birth</div>
                <div class="col-8"><input id="gi_dob" type="date" class="form-control"></div>
              </div>
            </div>
          </div>

          <button id="saveGeneral" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
        </div>

        <!-- Social Links -->
        <div id="social" class="tab-pane d-none">
          <h5>Social Links</h5>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-4">Facebook</div>
                <div class="col-8"><input id="sl_fb" class="form-control" placeholder="https://facebook.com/"></div>

                <div class="col-4">Twitter</div>
                <div class="col-8"><input id="sl_tw" class="form-control" placeholder="https://twitter.com/"></div>

                <div class="col-4">Linkedin</div>
                <div class="col-8"><input id="sl_li" class="form-control" placeholder="https://linkedin.com/"></div>

                <div class="col-4">Youtube</div>
                <div class="col-8"><input id="sl_yt" class="form-control" placeholder="https://youtube.com/"></div>
              </div>
            </div>
          </div>

          <button id="saveSocial" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
        </div>

        <!-- Job Info -->
        <div id="job" class="tab-pane d-none">
          <h5>Job Info</h5>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-4">Job Title</div>
                <div class="col-8"><input id="job_title" class="form-control" placeholder="Web Developer"></div>

                <div class="col-4">Salary</div>
                <div class="col-8"><input id="job_salary" class="form-control" placeholder="Salary"></div>

                <div class="col-4">Date of hire</div>
                <div class="col-8"><input id="job_hire" type="date" class="form-control"></div>
              </div>
            </div>
          </div>

          <button id="saveJob" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
        </div>

        <!-- Account settings -->
        <div id="account" class="tab-pane d-none">
          <h5>Account settings</h5>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-4">Email</div>
                <div class="col-8"><input id="acc_email" class="form-control"></div>

                <div class="col-4">Password</div>
                <div class="col-8"><input id="acc_pwd" type="password" class="form-control"></div>

                <div class="col-4">Role</div>
                <div class="col-8">
                  <select id="acc_role" class="form-select">
                    <option>Developer</option>
                    <option>Team member</option>
                    <option>Admin</option>
                  </select>
                </div>

                <div class="col-4">Disable login</div>
                <div class="col-8"><input id="acc_disable" type="checkbox" class="form-check-input"></div>
              </div>
            </div>
          </div>

          <button id="saveAccount" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
        </div>

        <!-- Files -->
        <div id="files" class="tab-pane d-none">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Files</h5>
            <div>
              <button class="btn btn-outline-secondary me-2" id="btnExportFiles">Excel</button>
              <button class="btn btn-outline-secondary me-2" id="btnPrintFiles">Print</button>
              <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addFileModal">Add files</button>
            </div>
          </div>

          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" id="filesTable">
                  <thead class="table-light">
                    <tr>
                      <th>ID</th>
                      <th>File</th>
                      <th>Size</th>
                      <th>Uploaded by</th>
                      <th>Created date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td colspan="6" class="text-center text-muted">No record found.</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div id="notes" class="tab-pane d-none">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Notes</h5>
            <div>
              <button class="btn btn-outline-secondary me-2" id="btnExportNotes">Excel</button>
              <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#addNoteModal">Add note</button>
            </div>
          </div>

          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" id="notesTable">
                  <thead class="table-light">
                    <tr><th>Created date</th><th>Title</th><th>Files</th><th></th></tr>
                  </thead>
                  <tbody>
                    <tr><td colspan="4" class="text-center text-muted">No record found.</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Projects (placeholder) -->
        <div id="projects" class="tab-pane d-none">
          <h5>Projects</h5>
          <div class="text-muted">No projects to show.</div>
        </div>

        <!-- Timesheets -->
        <div id="timesheets" class="tab-pane d-none">
          <h5>Timesheets</h5>
          <div class="text-muted">No timesheets to show.</div>
        </div>

        <!-- Time cards -->
        <div id="timecards" class="tab-pane d-none">
          <h5>Time cards</h5>
          <div class="text-muted">No time cards to show.</div>
        </div>

        <!-- Leave -->
        <div id="leave" class="tab-pane d-none">
          <h5>Leave</h5>
          <div class="mb-3">
            <nav>
              <div class="nav nav-tabs">
                <button class="nav-link active" id="leave-monthly">Monthly</button>
                <button class="nav-link" id="leave-yearly">Yearly</button>
              </div>
            </nav>
          </div>

          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead class="table-light">
                    <tr><th>Leave type</th><th>Date</th><th>Duration</th><th>Status</th></tr>
                  </thead>
                  <tbody>
                    <tr><td colspan="4" class="text-center text-muted">No record found.</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Expenses -->
        <div id="expenses" class="tab-pane d-none">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Expenses</h5>
            <div>
              <button class="btn btn-outline-secondary me-2" id="btnExportExpenses">Excel</button>
              <button class="btn btn-outline-secondary me-2" id="btnPrintExpenses">Print</button>
              <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">Add expense</button>
            </div>
          </div>

          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" id="expensesTable">
                  <thead class="table-light">
                    <tr><th>Date</th><th>Category</th><th>Title</th><th>Amount</th><th>Status</th><th></th></tr>
                  </thead>
                  <tbody>
                    <tr><td colspan="6" class="text-center text-muted">No record found.</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- tabContentArea -->

    </div> <!-- container-fluid -->
  </div>
</div>

<!-- ===================== SEND MESSAGE MODAL ===================== -->
<div class="modal fade" id="sendMessageModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Send message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3 d-flex align-items-center gap-2">
            <label class="fw-semibold">To</label>
            <img id="msgAvatar" src="" width="32" height="32" class="rounded-circle">
            <span id="msgName" class="fw-semibold"></span>
        </div>

        <div class="mb-3">
            <input id="msgSubject" class="form-control" placeholder="Subject">
        </div>

        <div class="mb-3">
            <textarea id="msgBody" class="form-control" rows="6" placeholder="Write a message..."></textarea>
        </div>

        <div class="d-flex gap-2">
            <label class="btn btn-outline-secondary">
                <i class="bi bi-upload"></i> Upload File
                <input type="file" id="msgFile" hidden>
            </label>

            <button class="btn btn-outline-secondary">
                <i class="bi bi-mic"></i>
            </button>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="sendMsgSubmit" class="btn btn-primary">
            <i class="bi bi-send"></i> Send
        </button>
      </div>

    </div>
  </div>
</div>


<!-- ===================== REMINDER MODAL ===================== -->
<div class="modal fade" id="reminderModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Reminders (Private)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
            <input id="remTitle" class="form-control" placeholder="Title">
        </div>

        <div class="row">
            <div class="col mb-3">
                <input id="remDate" type="date" class="form-control" placeholder="Date">
            </div>
            <div class="col mb-3">
                <input id="remTime" type="time" class="form-control" placeholder="Time">
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
            <span>Repeat</span>
            <input id="remRepeat" type="checkbox">
            <i class="bi bi-question-circle" title="Repeat this reminder"></i>
        </div>

        <button id="remAddBtn" class="btn btn-primary w-100">
            <i class="bi bi-check-circle"></i> Add
        </button>

      </div>

      <div class="modal-footer justify-content-center">
        <button class="btn btn-light w-100">Show all reminders</button>
      </div>

    </div>
  </div>
</div>


<!-- ===================== ADD FILE MODAL ===================== -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add files</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div id="dropZoneFile" class="border rounded p-4 text-center">
          <p class="text-muted mb-0">Drag-and-drop documents here<br>(or click to browse...)</p>
          <input type="file" id="fileUploadInput" multiple hidden>
        </div>
      </div>
      <div class="modal-footer">
        <button id="closeAddFile" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="saveFilesBtn" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- ===================== ADD NOTE MODAL ===================== -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input id="note_title" class="form-control mb-3" placeholder="Title">
        <textarea id="note_desc" class="form-control mb-3" rows="6" placeholder="Description..."></textarea>
        <select id="note_cat" class="form-select mb-3"><option>- Category -</option><option>General</option></select>
        <input id="note_labels" class="form-control mb-2" placeholder="Labels">
        <div class="d-flex gap-2 mt-2">
          <!-- color pills (visual only) -->
          <span class="border rounded-circle" style="width:20px;height:12px;display:inline-block;background:#7ED957"></span>
          <span class="border rounded-circle" style="width:20px;height:12px;display:inline-block;background:#50D1D8"></span>
          <span class="border rounded-circle" style="width:20px;height:12px;display:inline-block;background:#4EB8FF"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="saveNoteBtn" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- ===================== ADD EXPENSE MODAL ===================== -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add expense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="row gy-3">
          <div class="col-4">Date of expense</div>
          <div class="col-8"><input id="exp_date" type="date" class="form-control"></div>

          <div class="col-4">Category</div>
          <div class="col-8"><select id="exp_cat" class="form-select"><option>Advertising</option></select></div>

          <div class="col-4">Amount</div>
          <div class="col-8"><input id="exp_amount" class="form-control" placeholder="Amount"></div>

          <div class="col-4">Title</div>
          <div class="col-8"><input id="exp_title" class="form-control" placeholder="Title"></div>

          <div class="col-4">Description</div>
          <div class="col-8"><textarea id="exp_desc" class="form-control" rows="3"></textarea></div>

          <div class="col-4">Team member</div>
          <div class="col-8"><select id="exp_member" class="form-select"></select></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="saveExpenseBtn" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>

<script>
/* ========== Data arrays (frontend-only) ========== */
let filesData = [];
let notesData = [];
let expensesData = [];
let teamData = []; // populated from JSON files

/* ========== Utility helpers ========== */
function findMemberByEmail(email) {
  return teamData.find(m => m.email === email);
}

/* ========== Load member + init UI ========== */
document.addEventListener('DOMContentLoaded', () => {

  /* ------------------------------------
     FIRST FETCH (Original) - team_json.php
     ------------------------------------ */
  fetch('team_json.php')
    .then(r => r.json())
    .then(data => {
      teamData = data || [];
      initProfile();
      populateExpenseMemberOptions();
    })
    .catch(() => { 
      teamData = []; 
      initProfile(); 
    });

  /* ------------------------------------
     SECOND FETCH (ADDED) - timecard_json.php
     ------------------------------------ */
  fetch('timecard_json.php')
    .then(r => r.json())
    .then(data => {
      if (data && data.members) {

        // Merge team_json + timecard_json members
        const combined = [...teamData, ...data.members];

        // Remove duplicate emails
        const map = {};
        combined.forEach(m => map[m.email] = m);

        teamData = Object.values(map);

        // Reinitialize with combined data
        initProfile();
        populateExpenseMemberOptions();
      }
    });

  /* -------------------------- TABS -------------------------- */
  document.querySelectorAll('#profileTabs button').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('#profileTabs button').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const tab = btn.dataset.tab;
      document.querySelectorAll('#tabContentArea > div').forEach(d => d.classList.add('d-none'));
      const pane = document.getElementById(tab);
      if (pane) pane.classList.remove('d-none');
      else document.getElementById('timeline').classList.remove('d-none');
    });
  });

  /* -------------------- Avatar Upload -------------------- */
  document.getElementById('cameraBtn').onclick =
    document.getElementById('uploadBtn').onclick =
      () => document.getElementById('avatarInput').click();

  document.getElementById('avatarInput').addEventListener('change', function(){
    const f = this.files[0];
    if (!f) return;
    const r = new FileReader();
    r.onload = e => document.getElementById('avatar').src = e.target.result;
    r.readAsDataURL(f);
  });

  /* -------------------- Send Message Modal -------------------- */
  document.getElementById('sendMsgBtn').addEventListener('click', () => {
    document.getElementById("msgName").innerText = document.getElementById("fullName").innerText;
    document.getElementById("msgAvatar").src = document.getElementById("avatar").src;
    new bootstrap.Modal(document.getElementById("sendMessageModal")).show();
  });

  /* -------------------- Reminder Modal -------------------- */
  document.getElementById('reminderBtn').addEventListener('click', () => {
    new bootstrap.Modal(document.getElementById("reminderModal")).show();
  });

  /* -------------------- Save Handlers -------------------- */
  document.getElementById('saveGeneral').addEventListener('click', saveGeneralInfo);
  document.getElementById('saveSocial').addEventListener('click', saveSocialLinks);
  document.getElementById('saveJob').addEventListener('click', saveJobInfo);
  document.getElementById('saveAccount').addEventListener('click', () => alert('Account saved (demo)'));

  /* -------------------- Files Modal -------------------- */
  const dropZone = document.getElementById('dropZoneFile');
  const fileInput = document.getElementById('fileUploadInput');
  dropZone.addEventListener('click', () => fileInput.click());
  fileInput.addEventListener('change', e => {
    const files = Array.from(e.target.files || []);
    files.forEach(f => {
      filesData.push({
        id: Date.now() + Math.random(),
        name: f.name,
        size: Math.round(f.size / 1024) + ' KB',
        uploaded_by: 'You',
        created: new Date().toLocaleDateString()
      });
    });
    renderFilesTable();
  });

  document.getElementById('saveFilesBtn').addEventListener('click', () => {
    renderFilesTable();
    document.getElementById('closeAddFile').click();
  });

  /* -------------------- Notes Modal -------------------- */
  document.getElementById('saveNoteBtn').addEventListener('click', () => {
    const t = document.getElementById('note_title').value || 'Untitled';
    const d = document.getElementById('note_desc').value || '';
    notesData.push({
      id: Date.now() + Math.random(),
      created: new Date().toLocaleDateString(),
      title: t,
      files: '',
      desc: d
    });
    renderNotesTable();
    const m = bootstrap.Modal.getInstance(document.getElementById('addNoteModal'));
    if (m) m.hide();
  });

  /* -------------------- Expenses Modal -------------------- */
  document.getElementById('saveExpenseBtn').addEventListener('click', () => {
    const eDate = document.getElementById('exp_date').value || new Date().toISOString().slice(0,10);
    const cat = document.getElementById('exp_cat').value || '-';
    const amt = document.getElementById('exp_amount').value || '0';
    const title = document.getElementById('exp_title').value || '';
    const mem = document.getElementById('exp_member').value || '';

    expensesData.push({
      id: Date.now() + Math.random(),
      date: eDate,
      category: cat,
      title: title,
      amount: amt,
      status: 'Pending',
      member: mem
    });

    renderExpensesTable();
    const m = bootstrap.Modal.getInstance(document.getElementById('addExpenseModal'));
    if (m) m.hide();
  });

  /* Exports / Print (demo only) */
  document.getElementById('btnExportFiles').addEventListener('click', () => alert('Export files (frontend demo)'));
  document.getElementById('btnPrintFiles').addEventListener('click', () => window.print());
  document.getElementById('btnExportNotes').addEventListener('click', () => alert('Export notes (frontend demo)'));
  document.getElementById('btnExportExpenses').addEventListener('click', () => alert('Export expenses (frontend demo)'));
  document.getElementById('btnPrintExpenses').addEventListener('click', () => window.print());

  /* Initial table renders */
  renderFilesTable();
  renderNotesTable();
  renderExpensesTable();
});

/* =======================================================
   INIT PROFILE
======================================================= */
function initProfile(){
  const email = document.getElementById('profileEmail').value || '';
  let member = null;
  if (email) member = findMemberByEmail(email);
  if (!member && teamData.length > 0) member = teamData[0];

  if (member) {
    document.getElementById('avatar').src = member.avatar || 'https://i.pravatar.cc/140';
    document.getElementById('jobTitle').innerText = member.job || '';
    document.getElementById('fullName').innerText = member.name || '';
    document.getElementById('emailText').innerText = member.email || '';
    document.getElementById('phoneText').innerText = member.phone || '';

    document.getElementById('sl_fb').value = (member.social && member.social.facebook) || '';
    document.getElementById('sl_yt').value = (member.social && member.social.youtube) || '';
    document.getElementById('sl_tw').value = (member.social && member.social.twitter) || '';
    document.getElementById('sl_li').value = (member.social && member.social.linkedin) || '';

    document.getElementById('acc_email').value = member.email || '';

    document.getElementById('fbLink').href = (member.social && member.social.facebook) || 'https://facebook.com/';
    document.getElementById('ytLink').href = (member.social && member.social.youtube) || 'https://youtube.com/';
  }
}

/* =======================================================
   SAVE HANDLERS
======================================================= */
function saveGeneralInfo(){
  const first = document.getElementById('gi_first').value;
  const last = document.getElementById('gi_last').value;
  const phone = document.getElementById('gi_phone').value;

  if (first || last)
    document.getElementById('fullName').innerText = (first + ' ' + last).trim();

  if (phone)
    document.getElementById('phoneText').innerText = phone;

  alert('General info saved (frontend-only).');
}

function saveSocialLinks(){
  const fb = document.getElementById('sl_fb').value;
  const yt = document.getElementById('sl_yt').value;

  document.getElementById('fbLink').href = fb || 'https://facebook.com/';
  document.getElementById('ytLink').href = yt || 'https://youtube.com/';

  alert('Social links saved (frontend-only).');
}

function saveJobInfo(){
  const jt = document.getElementById('job_title').value;
  if (jt) document.getElementById('jobTitle').innerText = jt;
  alert('Job info saved (frontend-only).');
}

/* =======================================================
   RENDER TABLES
======================================================= */
function renderFilesTable(){
  const tbody = document.querySelector('#filesTable tbody');
  tbody.innerHTML = '';
  if (filesData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No record found.</td></tr>';
    return;
  }
  filesData.forEach((f,i)=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${i+1}</td><td>${f.name}</td><td>${f.size}</td><td>${f.uploaded_by}</td><td>${f.created}</td>
      <td><button class="btn btn-sm btn-link text-danger" onclick="removeFile(${f.id})">Delete</button></td>`;
    tbody.appendChild(tr);
  });
}

function renderNotesTable(){
  const tbody = document.querySelector('#notesTable tbody');
  tbody.innerHTML = '';
  if (notesData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No record found.</td></tr>';
    return;
  }
  notesData.forEach(n=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${n.created}</td><td>${n.title}</td><td>${n.files || ''}</td>
      <td><button class="btn btn-sm btn-link text-danger" onclick="removeNote('${n.id}')">Delete</button></td>`;
    tbody.appendChild(tr);
  });
}

function renderExpensesTable(){
  const tbody = document.querySelector('#expensesTable tbody');
  tbody.innerHTML = '';
  if (expensesData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No record found.</td></tr>';
    return;
  }
  expensesData.forEach(e=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${e.date}</td><td>${e.category}</td><td>${e.title}</td><td>${e.amount}</td>
      <td>${e.status}</td><td><button class="btn btn-sm btn-link text-danger" onclick="removeExpense('${e.id}')">Delete</button></td>`;
    tbody.appendChild(tr);
  });
}

/* Remove helpers */
function removeFile(id){
  filesData = filesData.filter(x => x.id !== id);
  renderFilesTable();
}
function removeNote(id){
  notesData = notesData.filter(x => x.id !== id);
  renderNotesTable();
}
function removeExpense(id){
  expensesData = expensesData.filter(x => x.id !== id);
  renderExpensesTable();
}

/* Populate Expense Member Select */
function populateExpenseMemberOptions(){
  const sel = document.getElementById('exp_member');
  sel.innerHTML = '';
  if (!teamData || teamData.length === 0) {
    const opt = document.createElement('option'); 
    opt.text = 'No members'; 
    sel.add(opt);
    return;
  }
  teamData.forEach(m=>{
    const opt = document.createElement('option');
    opt.value = m.name; 
    opt.text = m.name;
    sel.add(opt);
  });
}

/* Non-alert buttons */
document.getElementById("sendMsgSubmit").onclick = () => {
    console.log("Message sent!");
};

document.getElementById("remAddBtn").onclick = () => {
    console.log("Reminder added!");
};
</script>


</body>
</html>

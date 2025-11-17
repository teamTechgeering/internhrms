<?php include 'common/header.php'; ?>

<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

   <?php include 'common/topnavbar.php'; ?>
   
<div class="container-fluid py-3">
    <!-- ===================== HEADER ===================== -->
    <div class="d-flex align-items-center mb-3 flex-wrap">
        <i class="bi bi-grid fs-5 me-2"></i>
        <h5 class="mb-0 me-2" id="projectTitle">Project Title</h5>
        <i class="bi bi-star text-warning"></i>

        <div class="ms-auto d-flex flex-wrap align-items-center gap-2">
            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#remindersModal">
                <i class="bi bi-clock me-1"></i>Reminders
            </button>

            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="bi bi-gear me-1"></i>Settings
            </button>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-link-45deg me-1"></i>Actions
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2-circle"></i> Marked Project As Completed</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-pause-circle"></i> Marked Project As Hold</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-x-circle"></i> Marked Project As Canceled</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-copy"></i> Clone Project</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil-square"></i> Edit Project</a></li>
                </ul>
            </div>
            <button class="btn btn-success">
                <i class="bi bi-play-circle me-1"></i>Start Timer
            </button>
        </div>
    </div>
    <!-- ===================== MAIN TABS ===================== -->
    <ul class="nav nav-underline nav-fill border-bottom mb-4">
        <li class="nav-item"><a class="nav-link text-secondary active" data-bs-toggle="tab" href="#overview">Overview</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#tasklist">Task List</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#taskkanban">Task Kanban</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#milestones">Milestones</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#gantt">Gantt</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#notes">Notes</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#files">Files</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#comments">Comments</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#feedback">Customer Feedback</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#timesheets">Timesheets</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#invoices">Invoices</a></li>
    </ul>
    <!-- ===================== SUB-TABS ===================== -->
    <ul class="nav nav-underline border-bottom mb-4">
        <li class="nav-item"><a class="nav-link text-secondary active" data-bs-toggle="tab" href="#payments">Payments</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#expenses">Expenses</a></li>
        <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#contracts">Contracts</a></li>
    </ul>
    <!-- ===================== REMINDERS MODAL ===================== -->
    <div class="modal fade" id="remindersModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-slideout modal-dialog-end modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reminders (Private)</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="text" class="form-control mb-2" placeholder="Title">
                        <div class="d-flex gap-2 mb-2">
                            <input type="date" class="form-control">
                            <input type="time" class="form-control">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="repeat">
                            <label for="repeat" class="form-check-label">
                                Repeat <i class="bi bi-question-circle"></i>
                            </label>
                        </div>
                        <button type="button" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-1"></i>Add
                        </button>
                    </form>
                    <hr>
                    <p class="text-center text-muted mb-0">No record found.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-outline-secondary w-100">Show all reminders</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== SETTINGS MODAL ===================== -->
    <div class="modal fade" id="settingsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Settings</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <label class="mb-0">Client can view timesheet?</label>
                            <input type="checkbox" class="form-check-input">
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <label class="mb-0">Enable slack</label>
                            <input type="checkbox" class="form-check-input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remove task statuses</label>
                            <input type="text" class="form-control" placeholder="Task Statuses" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">
                        <i class="bi bi-check2-circle me-1"></i>Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== OVERVIEW TAB ===================== -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="overview">
            <div class="row g-2">
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <canvas id="progressChart" style="max-height:160px;"></canvas>
                            </div>
                            <p class="text-secondary mb-1">
                                Start date: <span id="startDate" class="text-dark"></span>
                            </p>
                            <p class="text-secondary mb-1">
                                Deadline: <span id="deadline" class="text-dark"></span>
                            </p>
                            <p class="text-secondary mb-0">
                                Client: <span id="client" class="text-primary"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Donut Chart -->
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center mb-0">
                            <canvas id="donutChart" style="max-height:255px;"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Activity -->
                <div class="col-lg-5 ms-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Activity</h6>
                            <div id="activityList"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW 2: Clock + Project Members + Client Contacts -->
            <div class="row g-2 mt-1">
                <div class="col-lg-6">
                    <!-- CLOCK -->
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <i class="bi bi-clock fs-1 text-secondary"></i>
                            <div class="text-end">
                                <h4 class="mb-0" id="hoursWorked">48.75</h4>
                                <p class="mb-0 text-secondary">Total hours worked</p>
                            </div>
                        </div>
                    </div>
                    <!-- PROJECT MEMBERS -->
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Project members</h6>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                <i class="bi bi-plus-lg me-1"></i>Add member
                            </button>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png"
                                         width="40" height="40" class="rounded-circle me-3">
                                    <div>
                                        <div class="fw-semibold">John Doe</div>
                                        <div class="text-secondary small">Admin</div>
                                    </div>
                                </div>
                                <i class="bi bi-x text-secondary"></i>
                            </li>
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140037.png"
                                         width="40" height="40" class="rounded-circle me-3">
                                    <div>
                                        <div class="fw-semibold">Mark Thomas</div>
                                        <div class="text-secondary small">Web Developer</div>
                                    </div>
                                </div>
                                <div>
                                    <i class="bi bi-envelope me-2 text-secondary"></i>
                                    <i class="bi bi-x text-secondary"></i>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140040.png"
                                         width="40" height="40" class="rounded-circle me-3">
                                    <div>
                                        <div class="fw-semibold">Michael Wood</div>
                                        <div class="text-secondary small">Project Manager</div>
                                    </div>
                                </div>
                                <div>
                                    <i class="bi bi-envelope me-2 text-secondary"></i>
                                    <i class="bi bi-x text-secondary"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- CLIENT CONTACTS -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Client contacts</h6>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addContactModal">
                                <i class="bi bi-plus-lg me-1"></i>Add contact
                            </button>
                        </div>
                        <div class="card-body text-center text-secondary small">No record found.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== ADD MEMBER MODAL ===================== -->
    <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-person-plus me-2"></i>Add Member
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addMemberForm">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" required placeholder="Enter member name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" required>
                                <option value="">Select Role</option>
                                <option>Admin</option>
                                <option>Project Manager</option>
                                <option>Web Developer</option>
                                <option>Web Designer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required placeholder="Enter email address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Image URL</label>
                            <input type="url" class="form-control" placeholder="https://example.com/image.png">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== ADD CONTACT MODAL ===================== -->
    <div class="modal fade" id="addContactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-person-lines-fill me-2"></i>Add Contact
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addContactForm">
                        <div class="mb-3">
                            <label class="form-label">Client Name</label>
                            <input type="text" class="form-control" required placeholder="Enter client name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" class="form-control" placeholder="Enter company name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required placeholder="Enter email address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" placeholder="Enter phone number">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== TASK LIST ===================== -->
    <div class="tab-pane fade" id="tasklist">
        <div class="container-fluid mt-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold">Tasks</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#manageLabelsModal"><i class="bi bi-tag"></i> Manage labels</button>
                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#addMultipleTasksModal">
                                <i class="bi bi-plus-circle"></i> Add multiple tasks
                            </button>
                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="bi bi-plus-circle"></i> Add task</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                        <button class="btn btn-sm"><i class="bi bi-layout-split"></i></button>
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-funnel"></i> Filters</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Tasks</a></li>
                                <li><a class="dropdown-item" href="#">Bug</a></li>
                                <li><a class="dropdown-item" href="#">My Task</a></li>
                                <li><a class="dropdown-item" href="#">Recently Updated</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-sm"><i class="bi bi-plus"></i></button>
                        <button class="btn btn-sm">All tasks</button>
                        <button class="btn btn-sm">Bug</button>
                        <button class="btn btn-sm"><i class="bi bi-person"></i></button>
                        <button class="btn btn-sm"><i class="bi bi-gear"></i></button>
                        <div class="ms-auto d-flex gap-2">
                            <button class="btn btn-sm" onclick="exportExcel()">Excel</button>
                            <button class="btn btn-sm" onclick="printTable()">Print</button>
                            <div class="input-group input-group-sm" style="width:200px;">
                                <input type="text" class="form-control" placeholder="Search" onkeyup="searchTask(this.value)">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle" id="taskTable">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Start date</th>
                                    <th>Deadline</th>
                                    <th>Milestone</th>
                                    <th>Assigned to</th>
                                    <th>Collaborators</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== TASK MODAL ===================== -->
    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTaskTitle" class="modal-title"></h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- LEFT SIDE -->
                        <div class="col-md-8">
                            <p id="modalTaskDesc" class="fw-semibold"></p>
                            <p><strong>Project:</strong> <a id="modalProjectName" href="#"></a></p>
                            <p><strong>Checklist</strong> 0/0</p>
                            <input class="form-control mb-3" placeholder="Add item">
                            <p><strong>Sub tasks</strong></p>
                            <input class="form-control mb-2" placeholder="Create a sub task">
                            <div class="dropdown mb-3">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Add dependency</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">This task is blocked by</a></li>
                                    <li><a class="dropdown-item" href="#">This task is blocking</a></li>
                                </ul>
                            </div>
                            <!-- COMMENT BOX -->
                            <div class="comment-box mb-3">
                                <textarea class="form-control mb-2" id="commentText" placeholder="Write a comment..."></textarea>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="btn btn-light btn-sm mb-0">
                                        Upload File <input type="file" hidden>
                                    </label>
                                    <button class="btn btn-post btn-sm" onclick="addComment()">Post Comment</button>
                                </div>
                            </div>
                            <!-- COMMENTS SECTION -->
                            <div id="commentsList" class="mb-4">
                                <div class="comment-item">
                                    <strong>Emily Smith</strong>
                                    <small class="text-muted">Today at 09:57:33 am</small>
                                    <p>We need to discuss about this.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="#" class="small text-decoration-none text-primary"></a>
                                        <div class="dropdown">
                                            <a href="#" class="text-muted small" data-bs-toggle="dropdown">Like</a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Copy link</a></li>
                                                <li><a class="dropdown-item" href="#">Pin comment</a></li>
                                                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ACTIVITY SECTION -->
                            <h6 class="fw-bold mt-4">Activity</h6>
                            <div class="activity-box mb-2">
                                <strong>Sara Ann</strong>
                                <small class="text-muted">Today at 01:12:46 pm</small>
                                <p>
                                    <span class="badge bg-warning text-dark">Updated</span>
                                    Task: #3425 - Implement product zoom and gallery<br>
                                    Status: <s>Review</s>
                                    <span class="text-success fw-bold">Done</span>
                                </p>
                            </div>
                            <div class="activity-box">
                                <strong>John Doe</strong>
                                <small class="text-muted">Today at 08:09:37 am</small>
                                <p>
                                    <span class="badge bg-primary">Added</span> Task: #3425 - Implement product zoom and gallery
                                </p>
                            </div>
                        </div>
                        <!-- ===================== RIGHT SIDE ===================== -->
                        <div class="col-md-4 border-start ps-3">
                            <div class="d-flex align-items-center mb-3">
                                <img id="modalUserImg" src="" width="40" class="rounded-circle me-2">
                                <div>
                                    <strong id="modalUserName"></strong><br>
                                    <span id="modalStatusBadge" class="badge"></span>
                                </div>
                            </div>
                            <p><strong>Milestone:</strong> Beta Release</p>
                            <p><strong>Start date:</strong> Add Start date</p>
                            <p><strong>Deadline:</strong> 31-10-2025</p>
                            <p><strong>Priority:</strong> Add Priority</p>
                            <p><strong>Label:</strong> <span class="label-bug">Bug</span></p>
                            <p><strong>Collaborators:</strong> Add Collaborators</p>
                            <button id="timerBtn" class="btn btn-timer mb-2" onclick="toggleTimer()">Start timer</button>
                            <div id="timerDisplay" class="text-center fw-bold mb-2 text-primary"></div>
                            <div id="timerMessageBox" class="d-none">
                                <textarea id="timerMessage" class="form-control mb-2" placeholder="Write a note..."></textarea>
                                <button class="btn btn-danger w-100 btn-sm" onclick="stopTimer()">Stop timer</button>
                            </div>
                            <p><strong>Total time logged:</strong> <a href="#">04:25:00</a></p>
                            <p><strong>Reminders (Private):</strong></p>
                            <a href="#" id="addReminderLink" class="text-primary small" onclick="showReminderForm(event)">+ Add reminder</a>
                            <div class="reminder-form" id="reminderForm">
                                <input class="form-control mb-2" placeholder="Title">
                                <div class="d-flex mb-2">
                                    <input type="date" class="form-control me-1">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="repeatCheck">
                                    <label for="repeatCheck" class="form-check-label small">Repeat</label>
                                </div>
                                <button class="btn btn-primary w-100 mb-2">Add</button>
                            </div>
                            <p class="text-muted small text-center">No record found.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary">Clone</button>
                    <button class="btn btn-outline-primary">Edit</button>
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== EDIT TASK MODAL ===================== -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm" class="row g-3">
                        <input type="hidden" id="edit-task-id">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input id="edit-task-title" type="text" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Start date</label>
                            <input id="edit-task-start" type="date" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Deadline</label>
                            <input id="edit-task-deadline" type="date" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Milestone</label>
                            <input id="edit-task-milestone" type="text" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Assigned to</label>
                            <input id="edit-task-assigned" type="text" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select id="edit-task-status" class="form-select">
                                <option>To do</option>
                                <option>In progress</option>
                                <option>Completed</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="saveEditedTask" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== MANAGE LABELS MODAL ===================== -->
    <div class="modal fade" id="manageLabelsModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Manage labels</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <div class="bg-success rounded-2 p-3"></div>
                        <div class="bg-info rounded-2 p-3"></div>
                        <div class="bg-primary rounded-2 p-3"></div>
                        <div class="bg-secondary rounded-2 p-3"></div>
                        <div class="bg-warning rounded-2 p-3"></div>
                        <div class="bg-danger rounded-2 p-3"></div>
                        <div class="bg-light border rounded-2 p-3"></div>
                        <div class="bg-dark rounded-2 p-3"></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Label">
                        <button class="btn btn-outline-secondary"><i class="bi bi-check2-circle me-1"></i> Save</button>
                    </div>
                    <hr>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge rounded-pill text-bg-danger">High Priority</span>
                        <span class="badge rounded-pill text-bg-success">On track</span>
                        <span class="badge rounded-pill text-bg-info">Perfect</span>
                        <span class="badge rounded-pill text-bg-warning">Upcoming</span>
                        <span class="badge rounded-pill text-bg-primary">Urgent</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== ADD TASK MODAL ===================== -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content p-2">
                <div class="modal-header border-0 py-2">
                    <h5 class="modal-title fw-semibold">Add task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="small text-muted mb-1">Title</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Title">
                        </div>
                        <div class="col-12">
                            <label class="small text-muted mb-1">Description</label>
                            <textarea class="form-control form-control-sm" rows="2" placeholder="Description"></textarea>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Points</label>
                            <select class="form-select form-select-sm">
                                <option>1 Point</option>
                                <option>2 Points</option>
                                <option>3 Points</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Milestone</label>
                            <select class="form-select form-select-sm">
                                <option>Milestone</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Assign to</label>
                            <select class="form-select form-select-sm">
                                <option>John Doe</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Collaborators</label>
                            <select class="form-select form-select-sm">
                                <option>Collaborators</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Status</label>
                            <select class="form-select form-select-sm">
                                <option>To do</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Priority</label>
                            <select class="form-select form-select-sm">
                                <option>Priority</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Labels</label>
                            <select class="form-select form-select-sm">
                                <option>Labels</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Start date</label>
                            <input type="text" class="form-control form-control-sm" placeholder="DD-MM-YYYY">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 py-2 d-flex justify-content-between">
                    <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm">Save & show</button>
                        <button class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== ADD MULTIPLE TASKS MODAL ===================== -->
    <div class="modal fade" id="addMultipleTasksModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content p-2">
                <div class="modal-header border-0 py-2">
                    <h5 class="modal-title fw-semibold">Add multiple tasks</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="small text-muted mb-1">Title</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Title">
                        </div>
                        <div class="col-12">
                            <label class="small text-muted mb-1">Description</label>
                            <textarea class="form-control form-control-sm" rows="2" placeholder="Description"></textarea>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Points</label>
                            <select class="form-select form-select-sm">
                                <option>1 Point</option>
                                <option>2 Points</option>
                                <option>3 Points</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Milestone</label>
                            <select class="form-select form-select-sm">
                                <option>Milestone</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Assign to</label>
                            <select class="form-select form-select-sm">
                                <option>John Doe</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Collaborators</label>
                            <select class="form-select form-select-sm">
                                <option>Collaborators</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Status</label>
                            <select class="form-select form-select-sm">
                                <option>To do</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Priority</label>
                            <select class="form-select form-select-sm">
                                <option>Priority</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Labels</label>
                            <select class="form-select form-select-sm">
                                <option>Labels</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted mb-1">Start date</label>
                            <input type="text" class="form-control form-control-sm" placeholder="DD-MM-YYYY">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 py-2 d-flex justify-content-between">
                    <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm">Save & add more</button>
                        <button class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>  <!-- CLOSE .content -->
    </div>    <!-- CLOSE .content-page -->


<?php include 'common/footer.php'; ?>




</html>

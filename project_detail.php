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
            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#remindersModal"><i class="bi bi-clock me-1"></i>Reminders</button>
            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#settingsModal"><i class="bi bi-gear me-1"></i>Settings</button>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-link-45deg me-1"></i>Actions</button>
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
    <li class="nav-item"><a class="nav-link text-secondary" data-bs-toggle="tab" href="#expenses">Expenses</a></li>
</ul>
<!-- ===================== MAIN TAB CONTENT ===================== -->
<div class="tab-content">

 <!-- ================================= OVERVIEW ================================= -->
<div class="tab-pane fade show active" id="overview">

                <div class="row g-2">
                    <!-- Progress -->
                    <div class="col-lg-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <canvas id="progressChart" style="max-height:160px;"></canvas>

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
                    <!-- Donut -->
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
                <!-- ROW 2 -->
                <div class="row g-2 mt-1">
                    <!-- Hours worked -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <i class="bi bi-clock fs-1 text-secondary"></i>
                                <div class="text-end">
                                    <h4 class="mb-0" id="hoursWorked">48.75</h4>
                                    <p class="mb-0 text-secondary">Total hours worked</p>
                                </div>
                            </div>
                        </div>
                        <!-- Project members -->
                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Project members</h6>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addMemberModal"><i class="bi bi-plus-lg me-1"></i>Add member</button>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" width="40" height="40" class="rounded-circle me-3">
                                        <div>
                                            <div class="fw-semibold">John Doe</div>
                                            <div class="text-secondary small">Admin</div>
                                        </div>
                                    </div>
                                    <i class="bi bi-x text-secondary"></i>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140037.png" width="40" height="40" class="rounded-circle me-3">
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
                                        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140040.png" width="40" height="40" class="rounded-circle me-3">
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
                        <!-- Client contacts -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Client contacts</h6>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addContactModal"><i class="bi bi-plus-lg me-1"></i>Add contact</button>
                            </div>
                            <div class="card-body text-center text-secondary small">No record found.</div>
                        </div>
                    </div>
                </div>
                
</div><!-- END OVERVIEW main tab -->

    <!-- ================================= TASK LIST ================================= -->
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


    <!-- ================================= TASK KANBAN ================================= -->
     <div class="tab-pane fade " id="taskkanban">
    <div class="container-fluid">
        <!-- Top Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-semibold">Tasks Kanban</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manageLabelsModal"><i class="bi bi-tags"></i> Manage labels</button>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#multipleTasksModal"><i class="bi bi-plus-lg"></i> Add multiple tasks</button>
                <button class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add task
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-repeat"></i>
                </button>
                <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-funnel"></i> Filters</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Tasks</a></li>
                                <li><a class="dropdown-item" href="#">Bug</a></li>
                                <li><a class="dropdown-item" href="#">My Task</a></li>
                                <li><a class="dropdown-item" href="#">Recently Updated</a></li>
                            </ul>
                        </div>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-plus"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm">All tasks</button>
                <button class="btn btn-outline-secondary btn-sm">Bug</button>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-people"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-brightness-high"></i>
                </button>
            </div>

            <input type="text" class="form-control form-control-sm" placeholder="Search" style="width:200px;">
        </div>

        <!-- Kanban Board -->
        <div class="row g-3">
            <!-- Column 1 -->
            <div class="col-3">
                <div class="border rounded bg-white p-3">

                    <div class="d-flex justify-content-between">
                        <h6 class="fw-semibold">To do</h6>
                        <span class="text-muted">2</span>
                    </div>

                    <div class="bg-warning mt-2 mb-3" style="height:3px;"></div>

                    <div class="border rounded p-3 mb-3 bg-white">
                        <small>3642. Add company logo and contact details</small>
                    </div>

                    <div class="border rounded p-3 bg-white">
                        <small>3651. Analyze competitor business card designs</small>
                    </div>

                </div>
            </div>

            <!-- Column 2 -->
            <div class="col-3">
                <div class="border rounded bg-white p-3">

                    <div class="d-flex justify-content-between">
                        <h6 class="fw-semibold">In progress</h6>
                        <span class="text-muted">2</span>
                    </div>

                    <div class="bg-primary mt-2 mb-3" style="height:3px;"></div>

                    <div class="border rounded p-3 mb-3">
                        <small>3649. Design matching email signature</small><br>
                        <span class="badge bg-success mt-1">Design</span>
                    </div>

                    <div class="border rounded p-3">
                        <small>3646. Collaborate with printing companies</small>
                    </div>

                </div>
            </div>

            <!-- Column 3 -->
            <div class="col-3">
                <div class="border rounded bg-white p-3">

                    <div class="d-flex justify-content-between">
                        <h6 class="fw-semibold">Review</h6>
                        <span class="text-muted">5</span>
                    </div>

                    <div class="bg-info mt-2 mb-3" style="height:3px;"></div>

                    <div class="border rounded p-3 mb-3">
                        <small>3645. Incorporate brand colors and fonts</small>
                    </div>

                    <div class="border rounded p-3">
                        <small>3648. Update business card design based on feedback</small>
                    </div>

                </div>
            </div>

            <!-- Column 4 -->
            <div class="col-3">
                <div class="border rounded bg-white p-3">

                    <div class="d-flex justify-content-between">
                        <h6 class="fw-semibold">Done</h6>
                        <span class="text-muted">2</span>
                    </div>

                    <div class="bg-success mt-2 mb-3" style="height:3px;"></div>

                    <div class="border rounded p-3 mb-3">
                        <small>3650. Create digital stationery templates</small>
                        <span class="badge bg-success mt-1">Design</span>
                    </div>
                    <div class="border rounded p-3">
                        <small>3640. Understand client brand identity</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- ================================= MILESTONES (YOUR PART 4) ================================= -->
    <div class="tab-pane fade" id="milestones">

    <!-- Milestone Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold">Milestones</h5>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMilestoneModal"><i class="bi bi-plus-lg me-1"></i> Add milestone</button>

    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-outline-secondary btn-sm" id="printMilestonesBtn">Print</button>

        <div class="input-group" style="max-width: 220px;">
            <input type="text" id="milestoneSearch" class="form-control form-control-sm" placeholder="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>

    <!-- Table Header -->
    <div class="row fw-semibold border-bottom pb-2 small text-secondary">
        <div class="col-3">Due date</div>
        <div class="col-5">Title</div>
        <div class="col-3 text-center">Progress</div>
        <div class="col-1 text-end"><i class="bi bi-list"></i></div>
    </div>

    <!-- CONTAINER FOR ALL MILESTONE ITEMS -->
    <div id="milestoneList">

        <!-- Milestone Item #1 -->
        <div class="milestone-item row py-3 border-bottom align-items-center">
            <div class="col-3">
                <div class="text-center border rounded p-2">
                    <span class="badge bg-danger mb-1">November</span>
                    <div class="h3 m-0 fw-bold">10</div>
                    <div class="small text-muted">Monday</div>
                </div>
            </div>

            <div class="col-5">
                <div class="fw-semibold">Release</div>
            </div>

            <div class="col-3 text-center">
                <div class="small mb-1">5/8</div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: 63%;"></div>
                </div>
                <div class="small mt-1">63%</div>
            </div>

            <div class="col-1 text-end">
                <button class="btn btn-light btn-sm border"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-light btn-sm border"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>

        <!-- Milestone Item #2 -->
        <div class="milestone-item row py-3 border-bottom align-items-center">
            <div class="col-3">
                <div class="text-center border rounded p-2">
                    <span class="badge bg-danger mb-1">September</span>
                    <div class="h3 m-0 fw-bold">29</div>
                    <div class="small text-muted">Monday</div>
                </div>
            </div>

            <div class="col-5">
                <div class="fw-semibold">Beta Release</div>
            </div>

            <div class="col-3 text-center">
                <div class="small mb-1">1/6</div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: 17%;"></div>
                </div>
                <div class="small mt-1">17%</div>
            </div>

            <div class="col-1 text-end">
                <button class="btn btn-light btn-sm border"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-light btn-sm border"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>

    </div>

    <!-- Pagination (unchanged) -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">10</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item">10</a></li>
                <li><a class="dropdown-item">20</a></li>
                <li><a class="dropdown-item">30</a></li>
            </ul>
        </div>

        <div class="small">1–2 / 2</div>

        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link">&laquo;</a></li>
                <li class="page-item active"><a class="page-link">1</a></li>
                <li class="page-item"><a class="page-link">&raquo;</a></li>
            </ul>
        </nav>
    </div>

</div>


    <!-- EMPTY TABS (KEEPED INTACT) -->
<div class="tab-pane fade" id="gantt">

    <!-- Top Actions -->
   <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    <!-- Left Buttons -->
    <div class="btn-group">
        <button class="btn btn-outline-secondary btn-sm" id="refreshBtn">
            <i class="bi bi-arrow-clockwise"></i>
        </button>
        <button class="btn btn-outline-secondary btn-sm" id="addFilterBtn">
            + Add new filter
        </button>
    </div>

    <!-- Right: View Selector + Add Task -->
    <div class="d-flex align-items-center gap-2">
        <select class="form-select form-select-sm" id="viewSelect">
            <option>Days view</option>
            <option>Weeks view</option>
            <option>Months view</option>
        </select>

        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="bi bi-plus-lg"></i> Add task
        </button>
    </div>
</div>
    <!-- MONTH + DAYS HEADER -->
    <div class="border rounded p-2 mb-3">
        <div class="d-flex border-bottom small fw-semibold pb-1">
            <div>November</div>
            <div class="ms-auto">December</div>
        </div>

        <div class="overflow-auto" style="white-space: nowrap;">
            <div id="gantt-days" class="d-inline-flex small text-muted"></div>
        </div>
    </div>

    <!-- TASKS + BARS -->
    <div class="overflow-auto" style="white-space: nowrap;">
        <div id="gantt-task-container" class="d-inline-block w-100"></div>
    </div>

</div>

    <!-- Notes -->
    <div class="tab-pane fade" id="notes">
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold mb-0">Notes (Private)</h5>

                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal"><i class="fa-solid fa-plus"></i> Add note</button>

            </div>

            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-table-cells-large"></i>
                </button>

                <div class="input-group input-group-sm" style="width: 200px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Created date</th>
                            <th>Title</th>
                            <th>Files</th>
                            <th class="text-end"><i class="fa-solid fa-bars"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted fs-6">
                                No record found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <select class="form-select form-select-sm" style="width: 70px;">
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                    </select>
                </div>

                <div class="text-muted">
                    0-0 / 0
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-chevron-left small"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-chevron-right small"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- Files -->
    <div class="tab-pane fade" id="files">

  <div class="card border-0 shadow-sm">
    <div class="card-body">

      <!-- TOP BAR -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">Files</h5>
        <button class="btn btn-outline-primary btn-sm"data-bs-toggle="modal"data-bs-target="#addFilesModal"><i class="fa-solid fa-plus me-1"></i> Add files</button>
      </div>

      <!-- FILE NAV TABS -->
      <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#filesListTab">Files list</button>
        </li>
     </ul>

      <div class="tab-content">

        <!-- FILES LIST TAB -->
        <div class="tab-pane fade show active" id="filesListTab">

          <!-- FILTERS / SEARCH -->
          <div class="d-flex justify-content-between align-items-center mb-3">

            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-table-list"></i>
              </button>

              <select class="form-select form-select-sm">
                <option>- Category -</option>
              </select>
            </div>

            <div class="d-flex gap-2 align-items-center">
              <button id="exportExcel" class="btn btn-outline-secondary btn-sm">Excel</button>
              <button id="printTable" class="btn btn-outline-secondary btn-sm">Print</button>


              <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
              </div>
            </div>

          </div>

          <!-- TABLE -->
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>File</th>
                  <th>Category</th>
                  <th>Size</th>
                  <th>Uploaded by</th>
                  <th>Created date</th>
                  <th class="text-end"><i class="fa-solid fa-bars"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">No record found.</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          <div class="d-flex justify-content-between align-items-center mt-3">
            <select class="form-select form-select-sm" style="width: 80px;">
              <option>10</option>
            </select>
            <span class="text-muted small">0-0 / 0</span>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary btn-sm">&lt;</button>
              <button class="btn btn-outline-secondary btn-sm">&gt;</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- Comments -->
<div class="tab-pane fade" id="comments">
    <div class="card">
        <div class="card-body">

            <div class="d-flex">
                <img src="avatar.png" class="rounded-circle me-2" width="40">
                <textarea class="form-control" rows="3" placeholder="Write a comment..."></textarea>
            </div>

            <!-- Hidden file input -->
            <input type="file" id="commentFile" class="d-none">

            <div class="d-flex justify-content-between mt-3">
                <div>
                    <!-- Upload Button (RENAMED) -->
                    <button class="btn btn-light" id="commentUploadBtn"><i class="bi bi-paperclip"></i> Upload File</button>

                    <button class="btn btn-light"><i class="bi bi-mic"></i></button>
                </div>

                <button class="btn btn-primary"><i class="bi bi-send"></i> Post Comment</button>
            </div>

            <!-- File Name Display (RENAMED) -->
            <div id="commentFileName" class="text-muted mt-2"></div>

        </div>
    </div>
</div>

    
    <!-- Expenses -->
    <div class="tab-pane fade" id="expenses">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h4>Expenses</h4>
                <button class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle"></i> Add expense
                </button>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>File</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Second Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No record found.</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>


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
<!-- Taskkanban -->
 <!-- Manage Labels Modal -->
<div class="modal fade" id="manageLabelsModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manage labels</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Label">
          <button class="btn btn-outline-primary">Save</button>
        </div>
        <hr>
        <!-- Existing Labels -->
        <div class="d-flex gap-2 flex-wrap">
          <span class="badge rounded-pill bg-danger">Bug</span>
          <span class="badge rounded-pill bg-success">Design</span>
          <span class="badge rounded-pill bg-primary">Enhancement</span>
          <span class="badge rounded-pill bg-info text-dark">Feedback</span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Multiple Tasks Modal -->
<div class="modal fade" id="multipleTasksModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add multiple tasks</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-3"><label class="form-label">Title</label></div>
          <div class="col-9"><input class="form-control" placeholder="Title"></div>
          <div class="col-3"><label class="form-label">Description</label></div>
          <div class="col-9"><textarea class="form-control" rows="2" placeholder="Description"></textarea></div>
          <div class="col-3"><label class="form-label">Points</label></div>
          <div class="col-9">
            <select class="form-select">
              <option>1 Point</option>
              <option>2 Points</option>
              <option>3 Points</option>
            </select>
          </div>

          <div class="col-3"><label class="form-label">Milestone</label></div>
          <div class="col-9"><select class="form-select"><option>Milestone</option></select></div>

          <div class="col-3"><label class="form-label">Assign to</label></div>
          <div class="col-9"><select class="form-select"><option>John Doe</option></select></div>

          <div class="col-3"><label class="form-label">Collaborators</label></div>
          <div class="col-9"><select class="form-select"><option>Collaborators</option></select></div>

          <div class="col-3"><label class="form-label">Status</label></div>
          <div class="col-9"><select class="form-select"><option>To do</option></select></div>

          <div class="col-3"><label class="form-label">Priority</label></div>
          <div class="col-9"><select class="form-select"><option>Priority</option></select></div>

          <div class="col-3"><label class="form-label">Labels</label></div>
          <div class="col-9"><select class="form-select"><option>Labels</option></select></div>

          <div class="col-3"><label class="form-label">Start date</label></div>
          <div class="col-9"><input type="text" class="form-control" placeholder="DD-MM-YYYY"></div>
        </div>
        <div class="mt-4">
          <button class="btn btn-outline-secondary"><i class="bi bi-upload"></i> Upload File</button>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Save & add more</button>
      </div>
<!-- Milestone -->
<!-- ADD MILESTONE MODAL (MUST BE OUTSIDE ALL TAB-PANES) -->
<div class="modal fade" id="addMilestoneModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title">Add Milestone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Title -->
       <!-- Title -->
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input id="milestoneTitle" type="text" class="form-control" placeholder="Enter milestone title">
        </div>

        <!-- Description -->
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea id="milestoneDesc" class="form-control" rows="3" placeholder="Enter description"></textarea>
        </div>

        <!-- Due Date -->
        <div class="mb-3">
          <label class="form-label">Due Date</label>
          <input id="milestoneDate" type="date" class="form-control">
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button id="saveMilestone" type="button" class="btn btn-primary">Save</button>
      </div>

    </div>
  </div>
</div>
<!-- Gantt -->
 <!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addTaskForm">
          <div class="mb-3">
            <label for="taskTitle" class="form-label">Task Title</label>
            <input type="text" class="form-control" id="taskTitle" required>
          </div>
          <div class="mb-3">
            <label for="taskBadge" class="form-label">Badge</label>
            <select class="form-select" id="taskBadge">
              <option>Enhancement</option>
              <option>Bug</option>
              <option>Feature</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="taskDeadline" class="form-label">Deadline</label>
            <input type="date" class="form-control" id="taskDeadline">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-sm" id="saveTaskBtn">Save Task</button>
      </div>
    </div>
  </div>
</div>
<!-- Notes -->
 <!-- ADD NOTE MODAL -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add note</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Title -->
                <input type="text" id="noteTitle" class="form-control mb-3" placeholder="Title">

                <!-- Description -->
                <textarea id="noteDesc" class="form-control mb-3" rows="8" placeholder="Description..."></textarea>

                <!-- Category -->
                <select id="noteCategory" class="form-select mb-3">
                    <option value="">- Category -</option>
                    <option>Personal</option>
                    <option>Work</option>
                    <option>Important</option>
                    <option>Ideas</option>
                </select>

                <!-- Labels -->
                <input type="text" id="noteLabels" class="form-control mb-3" placeholder="Labels">

                <!-- Mark as public -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="notePublic">
                    <label class="form-check-label">Mark as public</label>
                </div>

                <!-- Color Picker (Bootstrap buttons only) -->
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <div class="d-flex flex-wrap gap-1">
                        <button type="button" class="btn btn-success btn-sm color-btn" data-color="green"></button>
                        <button type="button" class="btn btn-primary btn-sm color-btn" data-color="blue"></button>
                        <button type="button" class="btn btn-warning btn-sm color-btn" data-color="yellow"></button>
                        <button type="button" class="btn btn-danger btn-sm color-btn" data-color="red"></button>
                        <button type="button" class="btn btn-secondary btn-sm color-btn" data-color="grey"></button>
                        <button type="button" class="btn btn-dark btn-sm color-btn" data-color="black"></button>
                    </div>
                </div>

                <!-- Selected Color (Bootstrap badge) -->
                <span id="selectedColor" class="badge bg-primary">blue</span>

                <!-- File Upload -->
                <div class="input-group mt-3 mb-3">
                    <input type="file" id="noteFile" class="d-none">
                    <button class="btn btn-outline-secondary" id="uploadBtn">
                        <i class="fa-solid fa-upload"></i> Upload File
                    </button>
                    <span id="fileName" class="ms-2 small text-muted"></span>

                    <button class="btn btn-outline-secondary ms-2">
                        <i class="fa-solid fa-microphone"></i>
                    </button>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveNoteBtn">Save</button>
            </div>

        </div>
    </div>
</div>
<!-- Files -->
 <!-- ADD FILES MODAL -->
<div class="modal fade" id="addFilesModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title fw-semibold">Add files</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Category -->
        <label class="form-label">Category</label>
        <select id="fileCategory" class="form-select mb-3">
          <option value="-">-</option>
          <option>Design</option>
          <option>Documents</option>
        </select>

        <!-- Upload Area -->
        <div id="dropArea"
             class="border border-2 border-secondary rounded p-5 text-center"
             style="cursor: pointer;">
          <p class="text-secondary mb-0">
            Drag-and-drop documents here <br>
            <small>(or click to browse…)</small>
          </p>
          <input type="file" id="fileInput" class="d-none" multiple>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="saveFilesBtn" class="btn btn-primary">Save</button>
      </div>

    </div>
  </div>
</div>
</div> <!-- END MAIN CONTENT -->


</div>  <!-- CLOSE .content -->
    </div>    <!-- CLOSE .content-page -->
<?php include 'common/footer.php'; ?>
</body>
</html>

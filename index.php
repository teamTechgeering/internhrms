<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

   <?php include 'common/topnavbar.php'; ?>

   <div class="container-fluid py-3">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="mb-0 fw-semibold">Dashboard</h5>
  <div class="d-flex align-items-center gap-3">
    <i class="bi bi-search"></i>
    <i class="bi bi-bell position-relative">
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">1</span>
    </i>
    <span class="fw-medium">John Doe</span>
  </div>
</div>

<!-- TOP CARDS -->
<div class="row g-3 mb-4">

<a href="clock.php" class="col-md-3 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body d-flex align-items-center gap-3">
      <i class="bi bi-clock fs-3 text-primary"></i>
      <div>
        <div class="small text-muted">Clock started at</div>
        <div class="fw-semibold">10:31:59 am</div>
      </div>
    </div>
  </div>
</a>

<a href="tasks.php" class="col-md-3 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body d-flex align-items-center gap-3">
      <i class="bi bi-list-task fs-3 text-info"></i>
      <div>
        <div class="small text-muted">My open tasks</div>
        <div class="fw-semibold fs-5">50</div>
      </div>
    </div>
  </div>
</a>

<a href="Event.php" class="col-md-3 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body d-flex align-items-center gap-3">
      <i class="bi bi-calendar-event fs-3 text-primary"></i>
      <div>
        <div class="small text-muted">Events today</div>
        <div class="fw-semibold fs-5">1</div>
      </div>
    </div>
  </div>
</a>

<a href="invoices.php" class="col-md-3 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body d-flex align-items-center gap-3">
      <i class="bi bi-currency-dollar fs-3 text-danger"></i>
      <div>
        <div class="small text-muted">Due</div>
        <div class="fw-semibold fs-5">$8,616.00</div>
      </div>
    </div>
  </div>
</a>

</div>

<!-- ===================== UPDATED MIDDLE SECTION ===================== -->
<div class="row g-3 mb-4">

<!-- LEFT COLUMN -->
<div class="col-lg-4 d-flex flex-column gap-3">

  <!-- PROJECTS OVERVIEW -->
  <a href="projects.php" class="text-decoration-none text-dark">
    <div class="card">
      <div class="card-body">

        <div class="d-flex align-items-center gap-2 mb-2">
          <i class="bi bi-grid"></i>
          <h6 class="mb-0 fw-semibold">Projects Overview</h6>
        </div>

        <div class="row text-center mb-3">
          <div class="col">
            <div class="fw-bold fs-4 text-success">24</div>
            <div class="text-muted small">Open</div>
          </div>
          <div class="col border-start">
            <div class="fw-bold fs-4 text-danger">6</div>
            <div class="text-muted small">Completed</div>
          </div>
          <div class="col border-start">
            <div class="fw-bold fs-4 text-warning">0</div>
            <div class="text-muted small">Hold</div>
          </div>
        </div>

        <div class="progress rounded-pill" style="height:26px">
          <div class="progress-bar bg-success rounded-pill" style="width:30%"></div>
          <div class="position-absolute w-100 text-center small fw-medium">
            Progression 30%
          </div>
        </div>

      </div>
    </div>
  </a>

  <!-- REMINDER TODAY (UNCHANGED – NOT REQUESTED) -->
  <div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">

      <div>
        <div class="fw-bold fs-4 text-danger">0</div>
        <div class="text-muted small">Reminder Today</div>
      </div>

      <div class="border-start ps-3">
        <i class="bi bi-bell text-danger"></i>
        <div class="small fw-medium">Next reminder</div>
        <div class="text-muted small">
          17-01-2026 - Renew mydo...
        </div>
      </div>

    </div>
  </div>

</div>

<!-- MIDDLE COLUMN -->
<a href="invoices.php" class="col-lg-4 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body d-flex flex-column">

      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-file-earmark-text"></i>
        <h6 class="mb-0 fw-semibold">Invoice Overview</h6>
      </div>

      <div class="mb-2 d-flex justify-content-between">
        <span><span class="text-danger fw-semibold">5</span> Overdue</span>
        <span>$2,648.50</span>
      </div>
      <div class="mb-2 d-flex justify-content-between">
        <span><span class="text-warning fw-semibold">5</span> Not paid</span>
        <span>$3,256.00</span>
      </div>
      <div class="mb-2 d-flex justify-content-between">
        <span><span class="text-primary fw-semibold">9</span> Partially paid</span>
        <span>$10,720.00</span>
      </div>
      <div class="mb-2 d-flex justify-content-between">
        <span><span class="fw-semibold">11</span> Fully paid</span>
        <span>$12,470.00</span>
      </div>
      <div class="mb-3 d-flex justify-content-between">
        <span><span class="fw-semibold">1</span> Draft</span>
        <span>$120.00</span>
      </div>

      <hr class="my-2">

      <div class="d-flex justify-content-between mb-2">
        <div>
          <div class="text-muted small">Total invoiced</div>
          <div class="fw-semibold">$26,446.00</div>
          <div class="text-muted small mt-1">Due</div>
          <div class="fw-semibold">$8,616.00</div>
        </div>
        <div class="text-muted small align-self-end">
          Last 12 months
        </div>
      </div>

      <canvas id="invoiceChart" width="280" height="110"></canvas>

    </div>
  </div>
</a>

<!-- RIGHT COLUMN -->
<a href="reports.php" class="col-lg-4 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body d-flex flex-column">

      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-clock-history"></i>
        <h6 class="mb-0 fw-semibold">Income vs Expenses</h6>
      </div>

      <div class="d-flex justify-content-between mb-3">
        <canvas id="incomeDonut" width="190" height="190"></canvas>

        <div>
          <div class="fw-medium">This Year</div>
          <div class="text-success">● $5,207.00</div>
          <div class="text-danger">● $215.00</div>

          <div class="fw-medium mt-3">Last Year</div>
          <div class="text-success">● $12,623.00</div>
          <div class="text-danger">● $8,905.00</div>
        </div>
      </div>

      <div class="fw-medium mb-1">This Year</div>
      <canvas id="incomeLine" width="280" height="70"></canvas>

    </div>
  </div>
</a>

</div>

<!-- ===================== END MIDDLE SECTION ===================== -->
<!-- ===================== NEXT DASHBOARD SECTION (EXACT) ===================== -->
<div class="row g-3 mb-4">

<!-- ALL TASKS OVERVIEW -->
<a href="tasks.php" class="col-lg-4 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body">

      <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-list-check"></i>
        <h6 class="mb-0 fw-semibold">All Tasks Overview</h6>
      </div>

      <div class="d-flex justify-content-center mb-3">
        <canvas id="tasksDonut" width="220" height="220"></canvas>
      </div>

      <div class="row small">
        <div class="col-6">
          <div class="mb-2"><span class="text-warning">●</span> To do</div>
          <div class="mb-2"><span class="text-primary">●</span> In progress</div>
          <div class="mb-2"><span class="text-purple">●</span> Review</div>
          <div class="mb-2"><span class="text-success">●</span> Done</div>
          <div><span class="text-danger">●</span> Expired</div>
        </div>
        <div class="col-6 text-end">
          <div class="mb-2 text-warning">79</div>
          <div class="mb-2 text-primary">61</div>
          <div class="mb-2 text-purple">68</div>
          <div class="mb-2 text-success">169</div>
          <div class="text-danger">135</div>
        </div>
      </div>

      <div class="d-flex justify-content-between text-muted small mt-3">
        <span>⛔ 18</span>
        <span>❗ 29</span>
        <span>⬆ 41</span>
        <span>⬇ 28</span>
      </div>

    </div>
  </div>
</a>

<!-- TEAM + ANNOUNCEMENT -->
<div class="col-lg-4 d-flex flex-column gap-3">

<!-- TEAM MEMBERS OVERVIEW -->
<a href="team_member.php" class="text-decoration-none text-dark">
  <div class="card">
    <div class="card-body">

      <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-people"></i>
        <h6 class="mb-0 fw-semibold">Team Members Overview</h6>
      </div>

      <div class="row text-center mb-3">
        <div class="col border-end">
          <div class="fw-bold fs-3">5</div>
          <div class="text-muted small">Team members</div>
        </div>
        <div class="col">
          <div class="fw-bold fs-3 text-warning">0</div>
          <div class="text-muted small">On leave today</div>
        </div>
      </div>

      <div class="row text-center">
        <div class="col border-end">
          <div class="fw-bold fs-4 text-danger">2</div>
          <div class="progress mb-1" style="height:4px">
            <div class="progress-bar bg-danger" style="width:40%"></div>
          </div>
          <div class="text-muted small">Members Clocked In</div>
        </div>
        <div class="col">
          <div class="fw-bold fs-4 text-primary">3</div>
          <div class="progress mb-1" style="height:4px">
            <div class="progress-bar bg-primary" style="width:60%"></div>
          </div>
          <div class="text-muted small">Members Clocked Out</div>
        </div>
      </div>

    </div>
  </div>
</a>

<!-- LAST ANNOUNCEMENT -->
<a href="announcement.php" class="text-decoration-none text-dark">
  <div class="card">
    <div class="card-body">

      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-megaphone"></i>
        <h6 class="mb-0 fw-semibold">Last announcement</h6>
      </div>

      <div class="text-muted">
        Tomorrow is holiday!
      </div>

    </div>
  </div>
</a>

</div>

<!-- TICKET STATUS -->
<a href="tickets.php" class="col-lg-4 text-decoration-none text-dark">
  <div class="card h-100">
    <div class="card-body">

      <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-life-preserver"></i>
        <h6 class="mb-0 fw-semibold">Ticket Status</h6>
      </div>

      <div class="row small mb-3">
        <div class="col-6">
          <div class="mb-2"><span class="text-warning">●</span> New</div>
          <div class="mb-2"><span class="text-primary">●</span> Open</div>
          <div><span class="text-success">●</span> Closed</div>
        </div>
        <div class="col-6 text-end">
          <div class="mb-2">21</div>
          <div class="mb-2">39</div>
          <div>69</div>
        </div>
      </div>

      <div class="row small mb-3">
        <div class="col-8">General Support</div>
        <div class="col-4 text-danger text-end">16</div>

        <div class="col-8">Bug Reports</div>
        <div class="col-4 text-danger text-end">25</div>

        <div class="col-8">Sales Inquiry</div>
        <div class="col-4 text-danger text-end">19</div>
      </div>

      <div class="fw-medium small mb-2">New tickets in last 30 days</div>
      <canvas id="ticketBars" width="300" height="120"></canvas>

    </div>
  </div>
</a>

</div>

<!-- ===================== END NEXT DASHBOARD SECTION ===================== -->

<!-- Next Section -->
<div class="container-fluid py-4">
  <div class="row g-3">

    <!-- PROJECT TIMELINE -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header bg-white fw-semibold">
          <i class="bi bi-clock"></i> Project Timeline
        </div>

        <div class="card-body overflow-auto" id="timeline" style="max-height:600px">
          <!-- tasks injected here -->
        </div>
      </div>
    </div>

    <!-- EVENTS + OPEN PROJECTS -->
    <div class="col-lg-4 d-flex flex-column gap-3">

      <!-- EVENTS -->
      <div class="card">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
          <span><i class="bi bi-calendar"></i> Events</span>
          <a href="Event.php" class="small text-decoration-none">
            View on calendar
          </a>
        </div>

        <div class="list-group list-group-flush">

          <div class="list-group-item">
            <i class="bi bi-lock text-danger me-2"></i>
            <a href="#" class="fw-semibold text-decoration-none"
               onclick="openEvent(
                 'Meeting with John Smith',
                 'Today, 06:33:00 am – 07:23:00 am',
                 'Discussion about project development.',
                 'John Doe'
               )">
              Meeting with John Smith
            </a>
            <small class="text-muted d-block">
              Today, 06:33:00 am – 07:23:00 am
            </small>
          </div>

          <div class="list-group-item">
            <i class="bi bi-lock text-success me-2"></i>
            <a href="#" class="fw-semibold text-decoration-none"
               onclick="openEvent(
                 'Company Anniversary Celebration',
                 'Tomorrow, 01:10:00 am – 02:30:00 am',
                 'Celebrating company success and milestones.',
                 'Management Team'
               )">
              Company Anniversary Celebration
            </a>
            <small class="text-muted d-block">
              Tomorrow, 01:10:00 am – 02:30:00 am
            </small>
          </div>

          <div class="list-group-item">
            <i class="bi bi-lock text-primary me-2"></i>
            <a href="#" class="fw-semibold text-decoration-none"
               onclick="openEvent(
                 'Industry Panel Discussion',
                 'Sun, January 18, 07:59:00 pm – 09:39:00 pm',
                 'Panel discussion with industry experts.',
                 'Panel Members'
               )">
              Industry Panel Discussion
            </a>
            <small class="text-muted d-block">
              Sun, January 18, 07:59:00 pm – 09:39:00 pm
            </small>
          </div>

          <div class="list-group-item">
            <i class="bi bi-lock text-success me-2"></i>
            <a href="#" class="fw-semibold text-decoration-none"
               onclick="openEvent(
                 'Leadership Summit',
                 'Tue, January 27, 05:37:00 am – 06:47:00 am',
                 'Leadership strategy and executive alignment meeting.',
                 'Executive Team'
               )">
              Leadership Summit
            </a>
            <small class="text-muted d-block">
              Tue, January 27, 05:37:00 am – 06:47:00 am
            </small>
          </div>

          <div class="list-group-item">
            <i class="bi bi-lock text-secondary me-2"></i>
            <a href="#" class="fw-semibold text-decoration-none"
               onclick="openEvent(
                 'Cultural Diversity Symposium',
                 'Wed, January 28, 06:41:00 am – 07:31:00 am',
                 'Discussion on inclusion, diversity, and workplace culture.',
                 'HR Department'
               )">
              Cultural Diversity Symposium
            </a>
            <small class="text-muted d-block">
              Wed, January 28, 06:41:00 am – 07:31:00 am
            </small>
          </div>

        </div>
      </div>

      <!-- OPEN PROJECTS -->
      <div class="card">
        <div class="card-header bg-white fw-semibold">
          <i class="bi bi-grid"></i> Open Projects
        </div>

        <div class="card-body">

          <div class="mb-3">
            <div class="d-flex justify-content-between">
              <a href="projects.php?id=23"
                 class="link-dark text-decoration-none fw-semibold">
                Online Course Creation and Launch
              </a>
              <span class="text-muted">0%</span>
            </div>
            <small class="text-muted">
              Start date: 18-01-2026 | Deadline: 30-01-2026
            </small>
            <div class="progress mt-1">
              <div class="progress-bar" style="width:0%"></div>
            </div>
          </div>

          <div class="mb-3">
            <div class="d-flex justify-content-between">
              <a href="projects.php?id=13"
                 class="link-dark text-decoration-none fw-semibold">
                Social Media Influencer Collaboration
              </a>
              <span class="text-muted">0%</span>
            </div>
            <small class="text-muted">
              Start date: 17-01-2026 | Deadline: 02-09-2023
            </small>
            <div class="progress mt-1">
              <div class="progress-bar" style="width:0%"></div>
            </div>
          </div>

          <div>
            <div class="d-flex justify-content-between">
              <a href="projects.php?id=28"
                 class="link-dark text-decoration-none fw-semibold">
                Virtual Reality Experience Design
              </a>
              <span class="text-primary fw-semibold">20%</span>
            </div>
            <small class="text-muted">
              Start date: 08-01-2026 | Deadline: 15-01-2026
            </small>
            <div class="progress mt-1">
              <div class="progress-bar bg-primary" style="width:20%"></div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- TODO -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
          <span><i class="bi bi-check-square"></i> To do (Private)</span>
          <div class="form-check form-switch m-0">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label small text-muted">Sortable</label>
          </div>
        </div>

    <div class="card-body">

      <!-- ADD TODO -->
      <div class="input-group mb-3">
        <input class="form-control" id="todoInput" placeholder="Add a to do...">
        <button class="btn btn-primary" onclick="addTodo()">Save</button>
      </div>

      <!-- TABS + SEARCH -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="btn-group">
          <button class="btn btn-light btn-sm active" id="todoTabBtn">To do</button>
          <button class="btn btn-light btn-sm" id="doneTabBtn">Done</button>
        </div>

        <div class="input-group input-group-sm w-50">
          <input class="form-control" placeholder="Search">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
      </div>

      <!-- TODO LIST -->
      <div class="list-group" id="todoList">

  <div class="list-group-item d-flex align-items-center justify-content-between">
    <div>
      <input class="form-check-input me-2" type="checkbox"
             onchange="moveToDone(this)">
      <span class="todo-text">Set roles and permissions for team members</span>
    </div>

    <div class="dropdown">
      <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots text-muted"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" onclick="editTodo(this)">
            <i class="bi bi-pencil me-2"></i>Edit
          </a>
        </li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="deleteTodo(this)">
            <i class="bi bi-trash me-2"></i>Delete
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="list-group-item d-flex align-items-center justify-content-between">
    <div>
      <input class="form-check-input me-2" type="checkbox"
             onchange="moveToDone(this)">
      <span class="todo-text">Re-arrange the widgets of my dashboard</span>
    </div>

    <div class="dropdown">
      <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots text-muted"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" onclick="editTodo(this)">
            <i class="bi bi-pencil me-2"></i>Edit
          </a>
        </li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="deleteTodo(this)">
            <i class="bi bi-trash me-2"></i>Delete
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="list-group-item d-flex align-items-center justify-content-between">
    <div>
      <input class="form-check-input me-2" type="checkbox"
             onchange="moveToDone(this)">
      <span class="todo-text">Setup IP restriction for time logs</span>
    </div>

    <div class="dropdown">
      <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots text-muted"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" onclick="editTodo(this)">
            <i class="bi bi-pencil me-2"></i>Edit
          </a>
        </li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="deleteTodo(this)">
            <i class="bi bi-trash me-2"></i>Delete
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="list-group-item d-flex align-items-center justify-content-between">
    <div>
      <input class="form-check-input me-2" type="checkbox"
             onchange="moveToDone(this)">
      <span class="todo-text">Discuss with team members</span>
    </div>

    <div class="dropdown">
      <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots text-muted"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" onclick="editTodo(this)">
            <i class="bi bi-pencil me-2"></i>Edit
          </a>
        </li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="deleteTodo(this)">
            <i class="bi bi-trash me-2"></i>Delete
          </a>
        </li>
      </ul>
    </div>
  </div>

</div>

<!-- DONE LIST -->
<div class="list-group d-none" id="doneList"></div>

<!-- PAGINATION (UI ONLY) -->
<div class="d-flex justify-content-center align-items-center gap-2 mt-4">
  <button class="btn btn-light btn-sm">&lt;</button>
  <button class="btn btn-outline-secondary btn-sm">1</button>
  <button class="btn btn-light btn-sm">&gt;</button>
</div>

  </div>
</div>


<!-- TASK MODAL -->
<div class="modal fade" id="taskModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskTitle"></h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>Status:</strong> <span id="taskStatus"></span></li>
          <li class="list-group-item"><strong>Deadline:</strong> <span id="taskDeadline"></span></li>
          <li class="list-group-item"><strong>Milestone:</strong> <span id="taskMilestone"></span></li>
          <li class="list-group-item"><strong>Assigned To:</strong> <span id="taskAssigned"></span></li>
          <li class="list-group-item"><strong>Project:</strong> <span id="taskProject"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Events Modal  -->
 <div class="modal fade" id="eventModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Event details</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <i class="bi bi-lock text-danger me-2"></i>
          <span class="fw-semibold fs-5" id="eventTitle"></span>
        </div>

        <div class="text-muted mb-3">
          <i class="bi bi-clock me-1"></i>
          <span id="eventTime"></span>
        </div>

        <div class="border-start border-4 border-danger ps-3 py-2 mb-4 bg-light"
             id="eventDescription">
        </div>

        <div class="d-flex align-items-center mb-4">
          <img src="assets/images/users/avatar-6.jpg"
               width="32" height="32"
               class="rounded-circle me-2">
          <span class="fw-semibold" id="eventUser"></span>
        </div>

        <!-- REMINDERS -->
        <div>
          <div class="fw-semibold mb-2">Reminders (Private):</div>
          <a href="#" class="text-decoration-none"
             onclick="showReminderForm()">+ Add reminder</a>
        </div>

        <!-- REMINDER FORM -->
        <div id="reminderForm" class="mt-4 d-none">

          <input class="form-control mb-3" placeholder="Title">

          <div class="row g-3 mb-3">
            <div class="col">
              <input type="date" class="form-control">
            </div>
            <div class="col">
              <input type="time" class="form-control">
            </div>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="repeat">
            <label class="form-check-label" for="repeat">Repeat</label>
          </div>

          <button class="btn btn-primary w-100">
            <i class="bi bi-check-circle me-1"></i> Add
          </button>

        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-dismiss="modal">
          <i class="bi bi-x"></i> Close
        </button>
      </div>

    </div>
  </div>
</div>



<?php include 'common/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(invoiceChart, {
  type: 'line',
  data: {
    labels: ['','','','','',''],
    datasets: [{
      data: [0,0,0,0,90,40],
      borderColor: '#6c8cff',
      borderWidth: 2,
      tension: 0.45,
      pointRadius: 0
    }]
  },
  options: {
    responsive: false,
    plugins:{legend:{display:false}},
    scales:{x:{display:false},y:{display:false}}
  }
});

new Chart(incomeDonut, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: [75,25],
      backgroundColor: ['#2fa97c','#e11d48'],
      borderWidth: 0
    }]
  },
  options:{
    responsive:false,
    cutout:'82%',
    plugins:{legend:{display:false}}
  }
});

new Chart(incomeLine, {
  type: 'line',
  data: {
    labels:['','','',''],
    datasets:[{
      data:[60,8,5,5],
      borderColor:'#2fa97c',
      borderWidth:2,
      tension:0.45,
      pointRadius:0
    }]
  },
  options:{
    responsive:false,
    plugins:{legend:{display:false}},
    scales:{x:{display:false},y:{display:false}}
  }
});

new Chart(tasksDonut, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: [79,61,68,169,135],
      backgroundColor: ['#f59e0b','#2563eb','#a21caf','#10b981','#ef4444'],
      borderWidth: 0
    }]
  },
  options:{
    responsive:false,
    cutout:'80%',
    plugins:{legend:{display:false}}
  }
});

new Chart(ticketBars, {
  type: 'bar',
  data: {
    labels:['08','10','12','14','16','18','20','22','24','26','28','30','01','03','05'],
    datasets:[{
      data:[2,6,3,5,8,7,6,6,7,5,8,3,6,4,7],
      backgroundColor:'#10b981'
    }]
  },
  options:{
    responsive:false,
    plugins:{legend:{display:false}},
    scales:{
      x:{grid:{display:false}},
      y:{display:false}
    }
  }
});
// Project Timeline
let projectsMap = {};

// load projects
fetch('projects_json.php')
.then(res => res.json())
.then(projects => {
  projects.forEach(p => {
    projectsMap[p.title] = p.id;
  });
});

// load tasks
fetch('tasks_json.php')
.then(res => res.json())
.then(tasks => {
  const timeline = document.getElementById('timeline');

  tasks.forEach(task => {

    const projectId = projectsMap[task.related_to] ?? 0;

    timeline.innerHTML += `
      <div class="d-flex mb-4">
        <img src="assets/images/users/avatar-6.jpg" class="rounded-circle me-3" width="32"height="32"alt="User">
        <div>
          <div class="fw-semibold">
            ${task.assigned_to}
            <small class="text-muted"> • Task ID ${task.id}</small>
          </div>

          <div class="mt-1">
            <span class="badge bg-warning text-dark">Updated</span>
            <a href="#" class="fw-semibold text-decoration-none ms-1"
               onclick='openTask(${JSON.stringify(task)})'>
               ${task.title}
            </a>
          </div>

          <ul class="small mt-2 mb-1">
            <li>Status: <span class="text-primary">${task.status}</span></li>
          </ul>

          <a href="projects.php?id=${projectId}" class="small text-decoration-none">
            Project: ${task.related_to}
          </a>
        </div>
      </div>
      <hr>
    `;
  });
});

function openTask(task) {
  document.getElementById('taskTitle').innerText = task.title;
  document.getElementById('taskStatus').innerText = task.status;
  document.getElementById('taskDeadline').innerText = task.deadline;
  document.getElementById('taskMilestone').innerText = task.milestone;
  document.getElementById('taskAssigned').innerText = task.assigned_to;
  document.getElementById('taskProject').innerText = task.related_to;

  new bootstrap.Modal(document.getElementById('taskModal')).show();
}
// Event
function openEvent(title, time, description, user) {
  document.getElementById('eventTitle').innerText = title;
  document.getElementById('eventTime').innerText = time;
  document.getElementById('eventDescription').innerText = description;
  document.getElementById('eventUser').innerText = user;

  document.getElementById('reminderForm').classList.add('d-none');

  new bootstrap.Modal(document.getElementById('eventModal')).show();
}

function showReminderForm() {
  document.getElementById('reminderForm').classList.remove('d-none');
}
// TODO
const todoList = document.getElementById('todoList');
const doneList = document.getElementById('doneList');

document.getElementById('todoTabBtn').onclick = () => {
  todoList.classList.remove('d-none');
  doneList.classList.add('d-none');
};

document.getElementById('doneTabBtn').onclick = () => {
  doneList.classList.remove('d-none');
  todoList.classList.add('d-none');
};

function moveToDone(checkbox) {
  const item = checkbox.closest('.list-group-item');
  checkbox.checked = true;
  checkbox.setAttribute('onchange', 'moveToTodo(this)');
  doneList.appendChild(item);
}

function moveToTodo(checkbox) {
  const item = checkbox.closest('.list-group-item');
  checkbox.checked = false;
  checkbox.setAttribute('onchange', 'moveToDone(this)');
  todoList.appendChild(item);
}

function addTodo() {
  const input = document.getElementById('todoInput');
  if (!input.value.trim()) return;

  const item = document.createElement('div');
  item.className = 'list-group-item d-flex align-items-center justify-content-between';
  item.innerHTML = `
    <div>
      <input class="form-check-input me-2" type="checkbox"
             onchange="moveToDone(this)">
      <span class="todo-text">${input.value}</span>
    </div>

    <div class="dropdown">
      <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots text-muted"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" onclick="editTodo(this)">
            <i class="bi bi-pencil me-2"></i>Edit
          </a>
        </li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="deleteTodo(this)">
            <i class="bi bi-trash me-2"></i>Delete
          </a>
        </li>
      </ul>
    </div>
  `;

  todoList.appendChild(item);
  input.value = '';
}

/* ===========================
   NEW FUNCTIONS (ADDED ONLY)
   =========================== */

function editTodo(el) {
  const item = el.closest('.list-group-item');
  const textSpan = item.querySelector('.todo-text');
  const oldText = textSpan.innerText;

  const input = document.createElement('input');
  input.className = 'form-control form-control-sm';
  input.value = oldText;

  textSpan.replaceWith(input);
  input.focus();

  input.onblur = () => saveEdit(input, oldText);
  input.onkeydown = e => {
    if (e.key === 'Enter') input.blur();
  };
}

function saveEdit(input, fallback) {
  const span = document.createElement('span');
  span.className = 'todo-text';
  span.innerText = input.value.trim() || fallback;
  input.replaceWith(span);
}

function deleteTodo(el) {
  const item = el.closest('.list-group-item');
  item.remove();
}

</script>

</body>
</html>

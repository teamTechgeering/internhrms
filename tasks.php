<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

    <!-- PAGE CONTENT -->
    <div class="container-fluid p-4">
        <h4 class="fw-semibold mb-4">Tasks</h4>

        <!-- ================= TOP TABS ================= -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="showList()">List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showKanban()">Kanban</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Gantt</a>
                </li>
            </ul>

            <!-- RIGHT BUTTON GROUP -->
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manageLabelsModal"><i class="fa-solid fa-tags"></i> Manage labels</button>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importProjectsModal"><i class="fa-solid fa-upload"></i> Import tasks</button>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addMultipleTasksModal"><i class="fa-solid fa-plus"></i> Add multiple tasks</button>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="fa-solid fa-plus"></i> Add task</button>
            </div>
        </div>

        <!-- ======================= LIST SECTION (Wrapped) ======================= -->
        <div id="listSection">

            <!-- FILTERS ROW -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary"><i class="fa-solid fa-table-cells-large"></i></button>

                    <div class="btn-group">
                      <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-filter"></i> Filters</button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">All Tasks</a></li>
                        <li><a class="dropdown-item" href="#">Bug</a></li>
                        <li><a class="dropdown-item" href="#">Critical</a></li>
                        <li><a class="dropdown-item" href="#">Major</a></li>
                        <li><a class="dropdown-item" href="#">My Tasks</a></li>
                        <li><a class="dropdown-item" href="#">Recently Updated</a></li>
                      </ul>
                    </div>

                    <button class="btn btn-outline-secondary">+</button>
                    <button class="btn btn-outline-secondary">All tasks</button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-bug"></i> Bug</button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-circle-question"></i></button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-up"></i></button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-down"></i></button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-gear"></i></button>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" id="excelBtn">Excel</button>
                    <button class="btn btn-outline-secondary" id="printBtn">Print</button>
                    <input type="text" id="taskSearch" class="form-control" placeholder="Search" style="width:180px;">
                </div>
            </div>

            <!-- TASK TABLE -->
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Start date</th>
                        <th>Deadline</th>
                        <th>Milestone</th>
                        <th>Related to</th>
                        <th>Assigned to</th>
                        <th>Collaborators</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tasks-body"></tbody>
            </table>

            <!-- PAGINATION BLOCK 1 -->
            <div class="d-flex justify-content-between align-items-center mt-3">
              <div class="d-flex align-items-center gap-2">
                <select id="pageSize" class="form-select form-select-sm w-auto">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                </select>
                <span id="rangeLabel" class="text-muted small">0–0 / 0</span>
              </div>
              <nav>
                <ul id="pagination" class="pagination pagination-sm mb-0"></ul>
              </nav>
            </div>

            <!-- PAGINATION BLOCK 2 -->
            <div class="d-flex justify-content-end align-items-center gap-3 mt-3">
              <nav>
                <ul class="pagination pagination-sm mb-0">
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                </ul>
              </nav>
            </div>

        </div> <!-- END LIST SECTION -->

        <!-- ======================= KANBAN SECTION ======================= -->
        <div id="kanbanSection" class="mt-4 d-none">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="border rounded p-3 bg-white shadow-sm">
                        <h6 class="fw-semibold text-secondary">To do</h6>
                        <div id="kanbanTodo" class="mt-2"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 bg-white shadow-sm">
                        <h6 class="fw-semibold text-primary">In progress</h6>
                        <div id="kanbanInProgress" class="mt-2"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 bg-white shadow-sm">
                        <h6 class="fw-semibold text-warning">Review</h6>
                        <div id="kanbanReview" class="mt-2"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 bg-white shadow-sm">
                        <h6 class="fw-semibold text-success">Done</h6>
                        <div id="kanbanDone" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>


<!-- Modal -->
     <!-- Edit -->
     <div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Task</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editId">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" id="editTitle" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select id="editStatus" class="form-select">
            <option>Pending</option>
            <option>In Progress</option>
            <option>Completed</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveEdit()">Save</button>
      </div>
    </div>
  </div>
</div>
 <!-- Manage lebel -->
  <div class="modal fade" id="manageLabelsModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Manage labels</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Color options -->
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
                <!-- Input + Save -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Label">
                    <button class="btn btn-outline-secondary"><i class="bi bi-check2-circle me-1"></i> Save</button>
                </div>
                <hr>
                <!-- Existing labels -->
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
<!-- Import task -->
 <div class="modal fade" id="importProjectsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-semibold">Import projects</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="importProjectsForm" class="text-center" novalidate>
          <div class="mb-3">
            <label for="importFile" class="form-label fw-medium">Select a JSON or CSV file</label>
            <input class="form-control" type="file" id="importFile" accept=".json,.csv" required>
            <div class="form-text text-muted">Ensure the file follows correct format.</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Cancel</button>
        <button id="importProjectsBtn" type="button" class="btn btn-primary">Import</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Multiple Task -->
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
                    <button class="btn btn-primary btn-sm" id="saveAddMoreBtn">Save & add more</button>
                    <button class="btn btn-primary btn-sm" id="saveTaskBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Task -->
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
                    <button class="btn btn-primary btn-sm" id="saveShowBtn">Save & show</button>
                    <button class="btn btn-primary btn-sm" id="saveTaskBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Task Modal -->
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








  </div><!-- content -->
</div><!-- content-page -->

<?php include 'common/footer.php'; ?>
<script src="assets/js/tasks.js"></script>

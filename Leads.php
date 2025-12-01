<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <div class="container-fluid">

        <h4 class="mt-3">Leads</h4>

        <!-- TABS -->
        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#listTab">List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kanbanTab">Kanban</a>
            </li>
        </ul>

        <!-- ================= FILTER BAR (FIXED BUTTONS) ================= -->
        <div class="d-flex align-items-center mt-3 flex-wrap gap-2">

            <!-- Board/List Toggle -->
            <button class="btn btn-outline-secondary" id="toggleViewBtn">
                <i class="bi bi-layout-three-columns"></i>
            </button>

            <!-- Filter dropdown (My leads ▼) -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-filter"></i> My leads
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item filter-option" data-filter="mine">My leads</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="all">All leads</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="50">50%</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="90">90%</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="call">Call this week</a></li>
                </ul>
            </div>

            <!-- Plus button -->
            <button class="btn btn-outline-secondary">+</button>

            <!-- Quick Filters -->
            <button class="btn btn-outline-secondary quick-filter" data-filter="50">50%</button>
            <button class="btn btn-outline-secondary quick-filter" data-filter="90">90%</button>

            <button class="btn btn-outline-secondary quick-filter" data-filter="call">
                <i class="bi bi-telephone"></i>
            </button>

            <button class="btn btn-outline-secondary quick-filter" data-filter="mine">
                <i class="bi bi-person"></i>
            </button>

            <!-- RIGHT SIDE BUTTON GROUP -->
            <div class="ms-auto d-flex align-items-center gap-2">

                <button class="btn btn-outline-secondary">
                    <i class="bi bi-tags"></i> Manage labels
                </button>

                <button class="btn btn-outline-secondary">
                    <i class="bi bi-upload"></i> Import leads
                </button>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadModal">
                    <i class="bi bi-plus-circle"></i> Add lead
                </button>

                <button class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>

                <button class="btn btn-outline-secondary">Excel</button>
                <button class="btn btn-outline-secondary">Print</button>

                <!-- Search -->
                <div class="input-group" style="width:200px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>

            </div>
        </div>
        <!-- ================= END FILTER BAR ================= -->


        <!-- TAB CONTENT -->
        <div class="tab-content mt-3">

            <!-- LIST TAB -->
            <div class="tab-pane fade show active" id="listTab">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Primary Contact</th>
                            <th>Phone</th>
                            <th>Owner</th>
                            <th>Labels</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="leadsTable"></tbody>
                </table>
            </div>

            <!-- KANBAN TAB -->
            <div class="tab-pane fade" id="kanbanTab">
                <div class="row" id="kanbanBoard"></div>
            </div>

        </div>

    </div>

  </div>
</div>


<!-- ADD LEAD MODAL -->
<div class="modal fade" id="addLeadModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" id="leadName" placeholder="Lead Name">
                <input class="form-control mb-2" id="leadContact" placeholder="Primary Contact">
                <input class="form-control mb-2" id="leadPhone" placeholder="Phone">
                <input class="form-control mb-2" id="leadOwner" placeholder="Owner">
                <input class="form-control mb-2" id="leadLabel" placeholder="Label (50%, 90%)">
                <input class="form-control mb-2" id="leadStatus" placeholder="Status (New, Qualified, Discussion)">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="addLead()">Save</button>
            </div>

        </div>
    </div>
</div>
<!-- SUCCESS MODAL -->
<div class="modal fade" id="successModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-success">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                Lead added successfully!
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="successOkBtn">OK</button>
            </div>

        </div>
    </div>
</div>



<?php include 'common/footer.php'; ?>
<script src="assets/js/leads.js"></script>
</body>
</html>
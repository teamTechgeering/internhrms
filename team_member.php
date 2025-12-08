<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-4">

    <!-- TOP HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Team members</h4>

        <div class="d-flex align-items-center gap-2">
            <button class="btn"><i class="bi bi-layout-text-sidebar-reverse"></i></button>
            <button class="btn"><i class="bi bi-columns-gap"></i></button>

            <!-- Import Modal Trigger -->
            <button class="btn d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload"></i> Import team members
            </button>

            <!-- Send Invitation Modal Trigger -->
            <button class="btn d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#inviteModal">
                <i class="bi bi-envelope"></i> Send invitation
            </button>

            <!-- Add Member Modal Trigger -->
            <button class="btn d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                <i class="bi bi-plus-circle"></i> Add member
            </button>
        </div>
    </div>

    <!-- TABS + RIGHT BUTTONS -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- LEFT: TABS -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active" id="tabActive">Active members</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tabInactive">Inactive members</button>
            </li>
        </ul>

        <!-- RIGHT: EXCEL, PRINT, SEARCH -->
        <div class="d-flex align-items-center gap-2">

            <button id="btnExcel" class="btn btn-light">Excel</button>
            <button id="btnPrint" class="btn btn-light">Print</button>

            <div class="input-group" style="width: 230px;">
                <input type="text" id="searchBox" class="form-control" placeholder="Search">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>

        </div>
    </div>

    <!-- TEAM TABLE -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th id="sortJob" class="sortable">
                        <div class="d-flex align-items-center gap-1">
                            Job Title <i class="bi bi-arrow-down"></i>
                        </div>
                    </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th><i class="bi bi-list"></i></th>
                </tr>
            </thead>
            <tbody id="teamBody"></tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-between align-items-center mt-2">
        <select class="form-select" style="width: 70px;">
            <option>10</option>
        </select>

        <div class="d-flex align-items-center gap-3">
            <span id="pageText">1–5 / 5</span>

            <ul class="pagination mb-0">
                <li class="page-item">
                    <button id="prevPage" class="page-link">&lt;</button>
                </li>
                <li class="page-item active">
                    <button class="page-link">1</button>
                </li>
                <li class="page-item">
                    <button id="nextPage" class="page-link">&gt;</button>
                </li>
            </ul>
        </div>
    </div>

</div>

<!-- ========================================================= -->
<!--                    IMPORT TEAM MEMBERS MODAL              -->
<!-- ========================================================= -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Import team members</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div id="importDrop"
                     class="border border-2 border-secondary border-opacity-25 rounded d-flex justify-content-center align-items-center"
                     style="height:180px; cursor:pointer;">
                    <p class="text-muted text-center m-0">
                        Drag-and-drop documents here<br>
                        (or click to browse…)
                    </p>
                </div>

                <input type="file" id="importFile" hidden>

            </div>

            <div class="modal-footer d-flex justify-content-between">

                <button class="btn btn-light" id="downloadSample">
                    <i class="bi bi-download"></i> Download sample file
                </button>

                <div>
                    <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="importNextBtn">
                        Next <i class="bi bi-arrow-right-circle"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!--                    SEND INVITATION MODAL                  -->
<!-- ========================================================= -->
<div class="modal fade" id="inviteModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Send invitation</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label class="form-label">Invite someone to join as a team member.</label>
                <div id="emailList">
                    <input type="email" class="form-control mb-2 inviteEmail" placeholder="Email">
                </div>

                <button class="btn btn-link p-0" id="addMoreEmail">
                    <i class="bi bi-plus-circle"></i> Add more
                </button>

                <hr>

                <label class="form-label">Role</label>
                <select class="form-select" id="inviteRole">
                    <option>Team member</option>
                    <option>Admin</option>
                </select>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="sendInviteBtn">
                    <i class="bi bi-send"></i> Send
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ========================================================= -->
<!--                     ADD MEMBER MODAL                      -->
<!-- ========================================================= -->
<div class="modal" id="addMemberModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title">Add member</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <!-- Wizard Tabs -->
        <div class="d-flex justify-content-around mb-3">
            <button class="btn btn-link wizardTab active" data-step="1">● General Info</button>
            <button class="btn btn-link wizardTab" data-step="2">○ Job Info</button>
            <button class="btn btn-link wizardTab" data-step="3">○ Account settings</button>
        </div>

        <!-- STEP 1 -->
        <div class="wizardStep" id="step1">
            <label class="form-label">First name</label>
            <input class="form-control mb-2" placeholder="First name">

            <label class="form-label">Last name</label>
            <input class="form-control mb-2" placeholder="Last name">

            <label class="form-label">Mailing address</label>
            <textarea class="form-control mb-2" placeholder="Mailing address"></textarea>

            <label class="form-label">Phone</label>
            <input class="form-control mb-2" placeholder="+1 201-555-0123">

            <label class="form-label">Gender</label>
            <div class="d-flex gap-3 mb-2">
                <label><input type="radio" name="gender" checked> Male</label>
                <label><input type="radio" name="gender"> Female</label>
                <label><input type="radio" name="gender"> Other</label>
            </div>
        </div>

        <!-- STEP 2 -->
        <div class="wizardStep d-none" id="step2">
            <label class="form-label">Job Title</label>
            <input class="form-control mb-3" placeholder="Job title">

            <label class="form-label">Department</label>
            <input class="form-control mb-3" placeholder="Department">
        </div>

        <!-- STEP 3 -->
        <div class="wizardStep d-none" id="step3">
            <label class="form-label">Username</label>
            <input class="form-control mb-3" placeholder="Username">

            <label class="form-label">Password</label>
            <input type="password" class="form-control mb-3" placeholder="Password">
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="nextStepBtn">
            Next <i class="bi bi-arrow-right-circle"></i>
        </button>
    </div>

</div>
</div>
</div>

<?php include 'common/footer.php'; ?>
<script src="assets/js/team_member.js"></script>

</body>
</html>

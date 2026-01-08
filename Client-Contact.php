<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <!-- ✅ Event Page Content Starts Here -->
    <!-- Page Content -->
    <div class="container-fluid p-4">

    <!-- PROFILE HEADER -->
  <div class="bg-primary text-white p-4 rounded mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
            <img src="assets/images/users/avatar-6.jpg" class="rounded-circle" width="80" height="80" alt="">
            
            <div class="ms-3">
                <h4 id="client-name" class="mb-1"></h4>
                <span id="job-title"></span><br>
                <i class="bi bi-envelope"></i> <span id="email"></span><br>
                <i class="bi bi-telephone"></i> <span id="phone"></span>
            </div>
        </div>

        <div class="col-md-6 text-end">
            <h6 id="right-name"></h6>
            <span id="full-address"></span>
        </div>
    </div>
</div>


    <!-- TABS -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#general">General Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#contact">Contact Info</a>
        </li>
         <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#social">Social Links</a>
        </li>
         <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#account">Account Settings</a>
        </li>
         <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#permission">Permission</a>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content mt-3">

        <!-- GENERAL INFO -->
        <div class="tab-pane fade show active" id="general">
            <div class="card p-3">
                <div class="row gy-3">
                    <div class="col-md-12"><b>First Name:</b> <span id="first-name"></span></div>
                    <div class="col-md-12"><b>Last Name:</b> <span id="last-name"></span></div>
                    <div class="col-md-12"><b>Phone:</b> <span id="gen-phone"></span></div>
                    <div class="col-md-12"><b>Gender:</b> <span id="gender"></span></div>
                    <div class="col-md-12"><b>Job Title:</b> <span id="gen-job-title"></span></div>
                </div>
            </div>
        </div>

        <!-- CONTACT INFO -->
        <div class="tab-pane fade" id="contact">
            <div class="card p-3">
                <div class="row gy-3">
                    <div class="col-md-12"><b>Owner:</b> <span id="owner"></span></div>
                    <div class="col-md-12"><b>Address:</b> <span id="address"></span></div>
                    <div class="col-md-12"><b>City:</b> <span id="city"></span></div>
                    <div class="col-md-12"><b>State:</b> <span id="state"></span></div>
                    <div class="col-md-12"><b>Country:</b> <span id="country"></span></div>
                    <div class="col-md-12"><b>Groups:</b> <span id="groups"></span></div>
                    <div class="col-md-12"><b>Labels:</b> <span id="labels"></span></div>
                </div>
            </div>
        </div>
      <div class="tab-pane fade" id="social">
    <div class="card p-3">
        <div class="row gy-3">

            <div class="col-md-12">
                <b>Facebook:</b>
                <a id="facebook" href="#" target="_blank">N/A</a>
            </div>

            <div class="col-md-12">
                <b>Twitter:</b>
                <a id="twitter" href="#" target="_blank">N/A</a>
            </div>

            <div class="col-md-12">
                <b>LinkedIn:</b>
                <a id="linkedin" href="#" target="_blank">N/A</a>
            </div>

            <div class="col-md-12">
                <b>Website:</b>
                <a id="website" href="#" target="_blank">N/A</a>
            </div>

        </div>

    </div>
</div>

        <div class="tab-pane fade" id="account">
    <div class="card p-3">
        <div class="row gy-3">

            <div class="col-md-12">
                <b>Email (Login):</b>
                <span id="acc-email"></span>
            </div>

            <div class="col-md-12">
                <b>Account Status:</b>
                <span id="acc-status"></span>
            </div>

            <div class="col-md-12">
                <b>Language:</b>
                <span id="acc-language"></span>
            </div>

            <div class="col-md-12">
                <b>Timezone:</b>
                <span id="acc-timezone"></span>
            </div>

            <div class="col-md-12">
                <b>Created On:</b>
                <span id="acc-created"></span>
            </div>

            <div class="col-md-12">
                <b>Last Login:</b>
                <span id="acc-last-login"></span>
            </div>

        </div>

    </div>
</div>

        <div class="tab-pane fade" id="permission">
    <div class="card p-3">

        

        <div class="row gy-3">

            <div class="col-md-6">
                <b>User Role:</b>
                <span id="role"></span>
            </div>

        </div>

        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Module</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody id="permissions-table">
            </tbody>
        </table>

    </div>
</div>


    </div>
</div>
    </div>
  </div>

<?php include 'common/footer.php'; ?>
<script>

    </script>

</body>

</html>
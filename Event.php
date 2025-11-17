<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <!-- ✅ Event Page Content Starts Here -->
    <!-- Page Content -->
<div class="container-fluid py-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold">Event Calendar</h4>
            <div class="d-flex align-items-center gap-4">
              <select class="form-select form-select-sm" style="width: 160px;">
                <option selected>- Event label -</option>
                <option>Workshops</option>
                <option>Meetings</option>
                <option>Training</option>
              </select>
              <select class="form-select form-select-sm" style="width: 140px;">
                <option selected>Event type</option>
                <option>Online</option>
                <option>In-person</option>
              </select>
              <button class="btn btn-outline-secondary btn-sm">Manage labels</button>
              <button id="addEventBtn" class="btn btn-primary btn-sm">Add event</button>

            </div>
          </div>

          <div id="calendar"></div>
        </div>
    <div id="calendar"></div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="eventForm">
          <div class="modal-header">
            <h5 class="modal-title" id="eventModalLabel">Add event</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" class="form-control" id="eventTitle" placeholder="Title" required>
            </div>
            <div class="row mb-3">
              <div class="col-md-3">
                <label class="form-label">Start date</label>
                <input type="date" class="form-control" id="startDate" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Start time</label>
                <input type="time" class="form-control" id="startTime">
              </div>
              <div class="col-md-3">
                <label class="form-label">End date</label>
                <input type="date" class="form-control" id="endDate">
              </div>
              <div class="col-md-3">
                <label class="form-label">End time</label>
                <input type="time" class="form-control" id="endTime">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" class="form-control" id="eventLocation" placeholder="Location">
              </div>
              <div class="col-md-6">
                <label class="form-label">Labels</label>
                <input type="text" class="form-control" id="eventLabel" placeholder="Labels">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Client</label>
                <input type="text" class="form-control" id="eventClient" placeholder="Client">
              </div>
              <div class="col-md-6">
                <label class="form-label">Share with</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="only" id="shareOnly">
                  <label class="form-check-label" for="shareOnly">Only me</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="all" id="shareAll">
                  <label class="form-check-label" for="shareAll">All team members</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="specific" id="shareSpecific">
                  <label class="form-check-label" for="shareSpecific">Specific members and teams</label>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Repeat</label>
              <select class="form-select" id="eventRepeat">
                <option selected>No</option>
                <option>Daily</option>
                <option>Weekly</option>
                <option>Monthly</option>
              </select>
            </div>

            <div class="d-flex align-items-center gap-2 mb-3">
              <label class="form-label me-2">Event color:</label>
              <input type="color" class="form-control form-control-color" id="eventColor" value="#0d6efd">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 id="eventDetailsTitle" class="fw-bold mb-2"></h5>
          <p><i class="fa-regular fa-calendar me-2"></i><span id="eventDetailsDate"></span></p>
          <div class="d-flex align-items-center mt-3">
            <span class="me-2">Event color:</span>
            <div id="eventDetailsColor" style="width:20px; height:20px; border-radius:4px;"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="editEventBtn" class="btn btn-primary">Edit</button>
          <button id="deleteEventBtn" class="btn btn-danger">Delete</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editEventForm">
          <div class="mb-3">
            <label class="form-label">Event Title</label>
            <input type="text" id="editTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" id="editDate" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Color</label>
            <input type="color" id="editColor" class="form-control form-control-color">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="saveEditBtn" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>
</div>
      </div>
    </div>
  </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>
</body>
</html>

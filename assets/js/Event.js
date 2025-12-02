document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");

  // ✅ Load events from localStorage or defaults
  let storedEvents = JSON.parse(localStorage.getItem("savedEvents")) || [
    {
      title: "Employee Health Screening",
      start: "2025-10-26",
      color: "#0dcaf0",
    },
    {
      title: "Client Advisory Board Meeting",
      start: "2025-10-28",
      color: "#b5179e",
    },
    { title: "Meeting with John Smith", start: "2025-11-05", color: "#e63946" },
    {
      title: "Company Anniversary Celebration",
      start: "2025-11-07",
      color: "#2a9d8f",
    },
    { title: "Leadership Summit", start: "2025-11-19", color: "#52b788" },
    { title: "Networking Mixer", start: "2025-11-27", color: "#d00000" },
    { title: "Job Training Fair", start: "2025-11-29", color: "#7209b7" },
    { title: "Sales Training Workshop", start: "2025-11-30", color: "#00b4d8" },
  ];

  // ✅ Initialize FullCalendar
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    height: "auto",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    events: storedEvents,

    eventClick: function (info) {
      const event = info.event;
      document.getElementById("eventDetailsTitle").textContent = event.title;
      document.getElementById("eventDetailsDate").textContent = event.start
        ? event.start.toLocaleString()
        : "N/A";
      document.getElementById("eventDetailsColor").style.backgroundColor =
        event.backgroundColor || "#0d6efd";

      document.getElementById("eventDetailsModal").dataset.eventId =
        event.id || event.startStr;

      const eventDetailsModal = new bootstrap.Modal(
        document.getElementById("eventDetailsModal")
      );
      eventDetailsModal.show();
    },
  });

  calendar.render();

  const addEventBtn = document.getElementById("addEventBtn");
  const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
  const eventForm = document.getElementById("eventForm");

  // ✅ Success modal
  const successModalHTML = `
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-body text-center p-4">
            <i class="fa-solid fa-circle-check text-success fs-1 mb-3"></i>
            <h5 class="mb-2">Action completed successfully!</h5>
            <button type="button" class="btn btn-success btn-sm mt-2" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>`;
  document.body.insertAdjacentHTML("beforeend", successModalHTML);
  const successModal = new bootstrap.Modal(
    document.getElementById("successModal")
  );

  // ✅ Delete confirmation modal
  const deleteConfirmHTML = `
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <p>Are you sure you want to delete this event?</p>
          </div>
          <div class="modal-footer justify-content-center">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>`;
  document.body.insertAdjacentHTML("beforeend", deleteConfirmHTML);
  const deleteConfirmModal = new bootstrap.Modal(
    document.getElementById("deleteConfirmModal")
  );

  // ✅ Add Event Button
  addEventBtn.addEventListener("click", () => {
    eventForm.reset();
    eventModal.show();
  });

  // ✅ Add new event
  eventForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const title = document.getElementById("eventTitle").value.trim();
    const startDate = document.getElementById("startDate").value;
    const color = document.getElementById("eventColor").value;

    if (!title || !startDate) {
      alert("Please fill in all required fields.");
      return;
    }

    const newEvent = { title, start: startDate, color };

    calendar.addEvent(newEvent);
    storedEvents.push(newEvent);
    localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

    eventModal.hide();
    setTimeout(() => successModal.show(), 300);
  });

  // ✅ Edit button — open edit modal
  document
    .getElementById("editEventBtn")
    .addEventListener("click", function () {
      const eventId =
        document.getElementById("eventDetailsModal").dataset.eventId;
      const event = calendar
        .getEvents()
        .find((e) => e.id === eventId || e.startStr === eventId);
      if (!event) return;

      document.getElementById("editTitle").value = event.title;
      document.getElementById("editDate").value = event.startStr;
      document.getElementById("editColor").value = event.backgroundColor;

      const editModal = new bootstrap.Modal(
        document.getElementById("editEventModal")
      );
      editModal.show();
    });

  // ✅ Save changes — update calendar & localStorage
  document.getElementById("saveEditBtn").addEventListener("click", function () {
    const eventId =
      document.getElementById("eventDetailsModal").dataset.eventId;
    const event = calendar
      .getEvents()
      .find((e) => e.id === eventId || e.startStr === eventId);
    if (!event) return;

    const newTitle = document.getElementById("editTitle").value.trim();
    const newDate = document.getElementById("editDate").value;
    const newColor = document.getElementById("editColor").value;

    event.setProp("title", newTitle);
    event.setStart(newDate);
    event.setProp("backgroundColor", newColor);

    storedEvents = calendar.getEvents().map((e) => ({
      title: e.title,
      start: e.startStr,
      color: e.backgroundColor,
    }));
    localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

    bootstrap.Modal.getInstance(
      document.getElementById("editEventModal")
    ).hide();
    bootstrap.Modal.getInstance(
      document.getElementById("eventDetailsModal")
    ).hide();

    setTimeout(() => successModal.show(), 300);
  });

  // ✅ Delete event — show modal instead of alert
  let eventToDelete = null;

  document
    .getElementById("deleteEventBtn")
    .addEventListener("click", function () {
      const eventId =
        document.getElementById("eventDetailsModal").dataset.eventId;
      eventToDelete = calendar
        .getEvents()
        .find((e) => e.id === eventId || e.startStr === eventId);
      if (eventToDelete) deleteConfirmModal.show();
    });

  document
    .getElementById("confirmDeleteBtn")
    .addEventListener("click", function () {
      if (!eventToDelete) return;

      eventToDelete.remove();
      storedEvents = calendar.getEvents().map((e) => ({
        title: e.title,
        start: e.startStr,
        color: e.backgroundColor,
      }));
      localStorage.setItem("savedEvents", JSON.stringify(storedEvents));

      deleteConfirmModal.hide();
      bootstrap.Modal.getInstance(
        document.getElementById("eventDetailsModal")
      ).hide();
      setTimeout(() => successModal.show(), 300);
    });
});
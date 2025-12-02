// ----------------------------
// LOCAL STORAGE
// ----------------------------
let fields = JSON.parse(localStorage.getItem("estimate_fields") || "[]");
let editIndex = null;
let deleteIndex = null;


// ----------------------------
// RENDER FIELDS LIKE SCREENSHOT
// ----------------------------
function renderFields() {
    const box = document.getElementById("fieldsContainer");
    box.innerHTML = "";

    fields.forEach((f, i) => {
        const row = document.createElement("div");
        row.className = "p-3 mb-3 border rounded bg-white";

        let inputHtml = "";

        // Editable TEXT FIELD
        if (f.type === "text") {
            inputHtml = `<input class="form-control" value="${f.value || ""}">`;
        }

        // Working DROPDOWN FIELD
        else if (f.type === "dropdown") {
            const opts = f.options || ["Select", "Option 1", "Option 2"];
            inputHtml = `
                <select class="form-select">
                    ${opts.map(opt => `<option>${opt}</option>`).join("")}
                </select>
            `;
        }

        row.innerHTML = `
            <div class="d-flex align-items-start gap-3">

    <!-- Drag handle -->
    <span class="text-secondary pt-4">
        <i class="bi bi-list"></i>
    </span>

    <!-- Field + buttons -->
    <div class="w-100">
        <label class="form-label mb-1">${f.title}</label>

        <div class="d-flex align-items-center gap-2">

            ${inputHtml}

            <!-- Edit button -->
            <button class="btn btn-outline-secondary btn-sm" onclick="openEdit(${i})">
                <i class="bi bi-pencil"></i>
            </button>

            <!-- Delete button -->
            <button class="btn btn-outline-danger btn-sm" onclick="openDelete(${i})">
                <i class="bi bi-x"></i>
            </button>

        </div>
    </div>

</div>

        `;

        box.appendChild(row);
    });
}


// ----------------------------
// ADD FIELD
// ----------------------------
function saveNewField() {
    const title = document.getElementById("addTitle").value;
    const type = document.getElementById("addType").value;

    if (!title.trim()) return alert("Enter title!");

    let newField = { title, type };

    // Default dropdown options
    if (type === "dropdown") {
        newField.options = ["Select", "Option 1", "Option 2"];
    }

    fields.push(newField);

    localStorage.setItem("estimate_fields", JSON.stringify(fields));
    renderFields();

    bootstrap.Modal.getInstance(document.getElementById("addFieldModal")).hide();
}


// ----------------------------
// EDIT FIELD
// ----------------------------
function openEdit(i) {
    editIndex = i;

    document.getElementById("editTitle").value = fields[i].title;
    document.getElementById("editType").value = fields[i].type;

    new bootstrap.Modal(document.getElementById("editFieldModal")).show();
}

function saveEditedField() {
    fields[editIndex].title = document.getElementById("editTitle").value;
    fields[editIndex].type = document.getElementById("editType").value;

    // If changing from text → dropdown, add default options
    if (fields[editIndex].type === "dropdown" && !fields[editIndex].options) {
        fields[editIndex].options = ["Select", "Option 1", "Option 2"];
    }

    localStorage.setItem("estimate_fields", JSON.stringify(fields));
    renderFields();

    bootstrap.Modal.getInstance(document.getElementById("editFieldModal")).hide();
}


// ----------------------------
// DELETE FIELD
// ----------------------------
function openDelete(i) {
    deleteIndex = i;
    new bootstrap.Modal(document.getElementById("deleteModal")).show();
}

function confirmDelete() {
    fields.splice(deleteIndex, 1);
    localStorage.setItem("estimate_fields", JSON.stringify(fields));

    renderFields();

    bootstrap.Modal.getInstance(document.getElementById("deleteModal")).hide();
}


// ----------------------------
// INITIAL LOAD
// ----------------------------
renderFields();


// ----------------------------
// FIX BLUR ISSUE — REMOVE BACKDROP SAFELY
// ----------------------------
document.addEventListener("hidden.bs.modal", function () {
    document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());
});

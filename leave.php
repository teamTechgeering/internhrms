<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

    <div class="container-fluid p-4"></div>

    <div class="container-fluid p-4">
      <div class="card shadow-sm">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-start mb-3">
            <h4 class="mb-0">Leave</h4>

            <div class="d-flex gap-2">
              <button id="btnImport" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">⤓ Import leaves</button>
              <button id="btnApply" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#applyModal">➕ Apply leave</button>
              <button id="btnAssign" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#assignModal">➕ Assign leave</button>
            </div>
          </div>

          <ul class="nav nav-tabs" id="leaveTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending approval</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#allapps" type="button" role="tab">All applications</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab">Summary</button>
            </li>
          </ul>

          <div class="tab-content pt-3">

            <!-- TABLE AREA -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">

              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <button id="toggleColumns" class="btn btn-sm btn-light border">☰</button>
                </div>

                <div class="d-flex gap-2 align-items-center">
                  <button id="btnExcel" class="btn btn-sm btn-outline-secondary">Excel</button>
                  <button id="btnPrint" class="btn btn-sm btn-outline-secondary">Print</button>
                  <div class="input-group input-group-sm" style="width:240px">
                    <input id="searchInput" type="search" class="form-control" placeholder="Search">
                    <button id="clearSearch" class="btn btn-outline-secondary">🔍</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table id="leaveTable" class="table table-borderless align-middle">
                  <thead>
                    <tr class="text-muted small">
                      <th>Applicant</th>
                      <th>Leave type</th>
                      <th>Date</th>
                      <th>Duration</th>
                      <th>Status</th>
                      <th class="text-end"> </th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex align-items-center gap-2">
                  <select id="pageSize" class="form-select form-select-sm" style="width:75px">
                    <option>5</option>
                    <option selected>10</option>
                    <option>25</option>
                  </select>
                  <small id="pagerInfo" class="text-muted">0-0 / 0</small>
                </div>
                <nav>
                  <ul id="pagination" class="pagination pagination-sm mb-0"></ul>
                </nav>
              </div>

            </div>

            <!-- ALL APPLICATIONS TAB -->
            <div class="tab-pane fade" id="allapps" role="tabpanel">
              <div class="mt-2 text-muted">All applications list (includes approved & rejected).</div>
              <div class="table-responsive mt-2">
                <table id="leaveTableAll" class="table table-borderless align-middle">
                  <thead>
                    <tr class="text-muted small">
                      <th>Applicant</th>
                      <th>Leave type</th>
                      <th>Date</th>
                      <th>Duration</th>
                      <th>Status</th>
                      <th class="text-end"> </th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

            <!-- SUMMARY TAB -->
            <div class="tab-pane fade" id="summary" role="tabpanel">
              <div class="mt-2">
                <div id="summaryCards" class="row gy-3"></div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- IMPORT MODAL -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Import leaves</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="dropZone" class="border rounded p-5 text-center">
              <div class="text-muted">Drag-and-drop documents here<br><small class="text-muted">(or click to browse...)</small></div>
              <input id="fileInput" type="file" accept=".csv" class="form-control form-control-sm mt-3" />
            </div>
          </div>
          <div class="modal-footer">
            <button id="downloadSample" class="btn btn-light">⤓ Download sample file</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
            <button id="importNext" type="button" class="btn btn-primary">Next</button>
          </div>
        </div>
      </div>
    </div>

    <!-- APPLY MODAL -->
    <div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Apply leave</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-4">Leave type
                <select id="applyLeaveType" class="form-select">
                  <option>-</option>
                  <option>Casual</option>
                  <option>Sick</option>
                  <option>Work from Home</option>
                </select>
              </div>
              <div class="col-8">Duration<br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="applyDuration" id="applySingle" value="Single day" checked>
                  <label class="form-check-label" for="applySingle">Single day</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="applyDuration" id="applyMultiple" value="Multiple days">
                  <label class="form-check-label" for="applyMultiple">Multiple days</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="applyDuration" id="applyHours" value="Hours">
                  <label class="form-check-label" for="applyHours">Hours</label>
                </div>
              </div>

              <div class="col-12">Date<br>
                <input id="applyDate" type="date" class="form-control">
              </div>

              <div class="col-12">Reason<br>
                <textarea id="applyReason" class="form-control" rows="4" placeholder="Reason"></textarea>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <div class="me-auto">
              <button id="applyUpload" class="btn btn-outline-secondary">📎 Upload File</button>
              <button class="btn btn-outline-secondary">🎤</button>
            </div>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
            <button id="applySubmit" type="button" class="btn btn-primary">Apply leave</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ASSIGN MODAL -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Assign leave</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-6">Team member
                <select id="assignMember" class="form-select">
                  <option>-</option>
                  <option>Alice</option>
                  <option>Bob</option>
                  <option>Charlie</option>
                </select>
              </div>
              <div class="col-6">Leave type
                <select id="assignLeaveType" class="form-select">
                  <option>-</option>
                  <option>Casual</option>
                  <option>Sick</option>
                  <option>Work from Home</option>
                </select>
              </div>

              <div class="col-12">Duration<br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="assignDuration" id="assignSingle" value="Single day" checked>
                  <label class="form-check-label" for="assignSingle">Single day</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="assignDuration" id="assignMultiple" value="Multiple days">
                  <label class="form-check-label" for="assignMultiple">Multiple days</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="assignDuration" id="assignHours" value="Hours">
                  <label class="form-check-label" for="assignHours">Hours</label>
                </div>
              </div>

              <div class="col-12">Date<br>
                <input id="assignDate" type="date" class="form-control">
              </div>

              <div class="col-12">Reason<br>
                <textarea id="assignReason" class="form-control" rows="4" placeholder="Reason"></textarea>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <div class="me-auto">
              <button id="assignUpload" class="btn btn-outline-secondary">📎 Upload File</button>
              <button class="btn btn-outline-secondary">🎤</button>
            </div>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">✕ Close</button>
            <button id="assignSubmit" type="button" class="btn btn-primary">Assign leave</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include 'common/footer.php'; ?>

<script>
  // ============================
  // START WITH NO DATA
  // ============================
  let leaves = [];   // EMPTY ARRAY
  let nextId = 1;

  // Pagination & filtering state
  let currentPage = 1;
  let pageSize = parseInt(document.getElementById('pageSize').value || '10');
  let searchTerm = '';

  function formatRow(l){
    return `
          <tr data-id="${l.id}">
            <td>${escapeHtml(l.applicant)}</td>
            <td>${escapeHtml(l.type)}</td>
            <td>${escapeHtml(l.date)}</td>
            <td>${escapeHtml(l.duration)}</td>
            <td>${statusBadge(l.status)}</td>
            <td class="text-end">
              <div class="btn-group">
                <button class="btn btn-sm btn-outline-secondary viewBtn">View</button>
                ${l.status === 'Pending' ? '<button class="btn btn-sm btn-success approveBtn">Approve</button><button class="btn btn-sm btn-danger rejectBtn">Reject</button>' : ''}
                <button class="btn btn-sm btn-outline-secondary deleteBtn">Delete</button>
              </div>
            </td>
          </tr>
        `;
  }

  function escapeHtml(s){ return String(s||'').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }
  function statusBadge(s){
    if(s==='Approved') return '<span class="badge bg-success">Approved</span>';
    if(s==='Rejected') return '<span class="badge bg-danger">Rejected</span>';
    return '<span class="badge bg-secondary">Pending</span>';
  }

  function renderTables(){
    const tbody = document.querySelector('#leaveTable tbody');
    const pending = leaves.filter(l=> l.status === 'Pending' && matchesSearch(l));
    renderPaged(tbody, pending);

    const tbodyAll = document.querySelector('#leaveTableAll tbody');
    const all = leaves.filter(l=> matchesSearch(l));
    tbodyAll.innerHTML = all.map(formatRow).join('') || '<tr><td colspan="6" class="text-center text-muted">No record found.</td></tr>';

    attachRowHandlers();
    renderSummary();
  }

  function matchesSearch(l){
    if(!searchTerm) return true;
    const s = searchTerm.toLowerCase();
    return (l.applicant||'').toLowerCase().includes(s)
      || (l.type||'').toLowerCase().includes(s)
      || (l.status||'').toLowerCase().includes(s)
      || (l.date||'').toLowerCase().includes(s);
  }

  function renderPaged(tbody, items){
    pageSize = parseInt(document.getElementById('pageSize').value || '10');
    const total = items.length;
    const pages = Math.max(1, Math.ceil(total / pageSize));
    if(currentPage > pages) currentPage = pages;

    const start = (currentPage-1)*pageSize;
    const end = start + pageSize;
    const pageItems = items.slice(start, end);

    tbody.innerHTML = pageItems.map(formatRow).join('') 
      || '<tr><td colspan="6" class="text-center text-muted">No record found.</td></tr>';

    document.getElementById('pagerInfo').textContent =
      `${Math.min(total, start+1)}-${Math.min(total, end)} / ${total}`;

    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    for(let p=1; p<=pages; p++){
      const li = document.createElement('li');
      li.className = 'page-item ' + (p===currentPage?'active':'');
      li.innerHTML = `<a class="page-link" href="#">${p}</a>`;
      li.addEventListener('click', (e)=>{ 
        e.preventDefault(); 
        currentPage = p; 
        renderTables(); 
      });
      pagination.appendChild(li);
    }
  }

  function attachRowHandlers(){
    document.querySelectorAll('.approveBtn').forEach(b=> b.onclick = () => updateStatus(rowId(b),'Approved'));
    document.querySelectorAll('.rejectBtn').forEach(b=> b.onclick = () => updateStatus(rowId(b),'Rejected'));
    document.querySelectorAll('.deleteBtn').forEach(b=> b.onclick = () => deleteRow(rowId(b)));
    document.querySelectorAll('.viewBtn').forEach(b=> b.onclick = () => viewRow(rowId(b)));
  }

  function rowId(btn){ return parseInt(btn.closest('tr').dataset.id); }

  function updateStatus(id, status){
    const it = leaves.find(l=> l.id===id);
    if(!it) return;
    it.status = status;
    renderTables();
  }

  function deleteRow(id){
    if(!confirm('Delete this leave?')) return;
    leaves = leaves.filter(l=> l.id!==id);
    renderTables();
  }

  function viewRow(id){
    const l = leaves.find(x=>x.id===id);
    if(!l) return alert("Not found");
    alert(
      `Applicant: ${l.applicant}\nType: ${l.type}\nDate: ${l.date}\nDuration: ${l.duration}\nStatus: ${l.status}\nReason: ${l.reason}`
    );
  }

  function renderSummary(){
    const container = document.getElementById('summaryCards');
    if(leaves.length === 0){
      container.innerHTML = '<div class="text-muted">No data</div>';
      return;
    }

    const types = {};
    leaves.forEach(l=> { types[l.type] = (types[l.type]||0) + 1; });

    const statuses = { Pending:0, Approved:0, Rejected:0 };
    leaves.forEach(l=> { statuses[l.status] = (statuses[l.status]||0) + 1; });

    let html = '';
    for(const t in types){
      html += `
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0">${t}</h6>
              <div class="text-muted">Total: ${types[t]}</div>
            </div>
          </div>
        </div>`;
    }

    html += `
      <div class="col-12">
        <div class="card mt-2">
          <div class="card-body small text-muted">
            Statuses: Pending ${statuses.Pending} • Approved ${statuses.Approved} • Rejected ${statuses.Rejected}
          </div>
        </div>
      </div>`;

    container.innerHTML = html;
  }

  // Search
  document.getElementById('searchInput').addEventListener('input', (e)=>{
    searchTerm = e.target.value.trim(); 
    currentPage = 1; 
    renderTables();
  });

  document.getElementById('clearSearch').addEventListener('click', ()=>{
    document.getElementById('searchInput').value='';
    searchTerm='';
    renderTables();
  });

  // Page size change
  document.getElementById('pageSize').addEventListener('change', ()=>{
    currentPage = 1;
    renderTables();
  });

  // Excel Export
  document.getElementById('btnExcel').addEventListener('click', ()=>{
    const rows = leaves.map(l=> [l.applicant,l.type,l.date,l.duration,l.status,l.reason]);
    const csv = [
      'Applicant,Leave type,Date,Duration,Status,Reason',
      ...rows.map(r=> r.map(cell=> `"${String(cell||'').replace(/"/g,'""')}"`).join(','))
    ].join('\n');
    downloadBlob(csv, 'leaves.csv', 'text/csv');
  });

  // Print
  document.getElementById('btnPrint').addEventListener('click', ()=>{ 
    window.print(); 
  });

  // Import logic
  document.getElementById('downloadSample').addEventListener('click', ()=>{
    const sample =
      'Applicant,Leave type,Date,Duration,Status,Reason\n' +
      'Alice,Casual,2025-12-25,Single day,Pending,Family';
    downloadBlob(sample, 'leaves_sample.csv', 'text/csv');
  });

  const dropZone = document.getElementById('dropZone');
  dropZone.addEventListener('click', ()=> document.getElementById('fileInput').click());
  dropZone.addEventListener('dragover', (e)=>{ e.preventDefault(); });
  dropZone.addEventListener('drop', (e)=>{
    e.preventDefault(); 
    handleFile(e.dataTransfer.files[0]);
  });

  document.getElementById('fileInput').addEventListener('change', (e)=> 
    handleFile(e.target.files[0])
  );

  let importedFile = null;

  function handleFile(f){
    if(!f) return;
    importedFile = f;
    dropZone.querySelector('.text-muted').textContent = `Selected: ${f.name}`;
  }

  document.getElementById('importNext').addEventListener('click', ()=>{
    if(!importedFile){ alert('Please choose a CSV file first.'); return; }

    const reader = new FileReader();
    reader.onload = function(){
      parseCSV(reader.result).forEach(row=>{
        if(row.length>=3){
          leaves.push({
            id: nextId++,
            applicant: row[0]||'Unknown',
            type: row[1]||'-',
            date: row[2]||'',
            duration: row[3]||'Single day',
            status: row[4]||'Pending',
            reason: row[5]||''
          });
        }
      });

      importedFile = null;
      document.getElementById('fileInput').value='';

      bootstrap.Modal.getInstance(document.getElementById('importModal')).hide();
      renderTables();
    };

    reader.readAsText(importedFile);
  });

  function parseCSV(text){
    const lines = text.split(/\r?\n/).filter(Boolean);
    const out = [];
    for(let i=1; i<lines.length; i++){
      const parts = lines[i].split(',').map(s=> s.replace(/^"|"$/g,'').trim());
      out.push(parts);
    }
    return out;
  }

  // Apply leave
  document.getElementById('applySubmit').addEventListener('click', ()=>{
    const type = document.getElementById('applyLeaveType').value;
    const duration = document.querySelector('input[name="applyDuration"]:checked').value;
    const date = document.getElementById('applyDate').value;
    const reason = document.getElementById('applyReason').value;

    if(!date){ alert('Please select a date'); return; }

    leaves.push({
      id: nextId++,
      applicant: 'You',
      type: type==='-'?'Other':type,
      date,
      duration,
      status: 'Pending',
      reason
    });

    bootstrap.Modal.getInstance(document.getElementById('applyModal')).hide();
    renderTables();
  });

  // Assign leave
  document.getElementById('assignSubmit').addEventListener('click', ()=>{
    const member = document.getElementById('assignMember').value;
    const type = document.getElementById('assignLeaveType').value;
    const duration = document.querySelector('input[name="assignDuration"]:checked').value;
    const date = document.getElementById('assignDate').value;
    const reason = document.getElementById('assignReason').value;

    if(member==='-' || !date){
      alert('Select member and date');
      return;
    }

    leaves.push({
      id: nextId++,
      applicant: member,
      type: type==='-'?'Other':type,
      date,
      duration,
      status: 'Pending',
      reason
    });

    bootstrap.Modal.getInstance(document.getElementById('assignModal')).hide();
    renderTables();
  });

  // Helper
  function downloadBlob(content, filename, mime){
    const blob = new Blob([content], { type: mime });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; 
    a.download = filename; 
    document.body.appendChild(a); 
    a.click(); 
    a.remove(); 
    URL.revokeObjectURL(url);
  }

  // INITIAL RENDER
  renderTables();
</script>

  </body>
</html>

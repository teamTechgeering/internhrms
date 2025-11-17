   // state
    let projects = [];
    let filtered = [];
    let currentPage = 1;
    let pageSize = parseInt(document.getElementById('pageSize').value, 10);
    const tbody = document.getElementById('projects-tbody');

    // mapping label -> bootstrap badge class (compose using only bootstrap classes)
    const labelClassMap = {
      'Urgent': 'badge bg-danger text-white',
      'On track': 'badge bg-success text-white',
      'Upcoming': 'badge bg-warning text-dark',
      'Perfect': 'badge bg-info text-white'
    };
    // fetch projects.json
    async function loadProjects() {
      try {
        const res = await fetch('projects.json', {cache: 'no-store'});
        if (!res.ok) throw new Error('Failed to load projects.json: ' + res.status);
        // support both { "projects": [...] } and plain array
        const data = await res.json();
        projects = Array.isArray(data) ? data : (data.projects || []);
        filtered = projects.slice();
        renderTable();
        renderPagination();
      } catch (err) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-danger text-center">Failed to load projects.json. Make sure you serve this page via a web server (e.g., python -m http.server).</td></tr>';
        console.error(err);
      }
    }
    // convert numeric progress to width percent (string)
    function progressStylePercent(n) {
      const v = Math.max(0, Math.min(100, Number(n) || 0));
      return v + '%';
    }
    // build badge HTML for label
    function renderLabel(label) {
      if (!label) return '';
      const cls = labelClassMap[label] || 'badge bg-secondary text-white';
      return ` <span class="${cls}">${label}</span>`;
    }
    // render current page rows
    function renderTable() {
      tbody.innerHTML = '';
      pageSize = parseInt(document.getElementById('pageSize').value, 10);
      const start = (currentPage - 1) * pageSize;
      const pageItems = filtered.slice(start, start + pageSize);

      if (pageItems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-muted text-center">No projects found.</td></tr>';
      } else {
        for (const p of pageItems) {
          const tr = document.createElement('tr');
          // deadline alert class if deadline earlier -> we use p.deadline_alert if exists OR if date in past (not strict)
          const deadlineClass = p.deadline_alert ? 'text-danger fw-semibold' : '';
          // progress bar (we set width inline because bootstrap doesn't provide fine-grained width utilities)
          const progressPercent = progressStylePercent(p.progress);
          // assemble row HTML
          tr.innerHTML = `
            <td>${p.id ?? ''}</td>
<td class="small">
  <a href="project_detail.html?id=${p.id}" class="text-decoration-none text-blue">
    ${escapeHtml(p.title ?? '')}
  </a>
  ${renderLabel(p.label)}
</td>
            <td>${escapeHtml(p.client ?? '-')}</td>
            <td>${escapeHtml(p.price ?? '-')}</td>
            <td>${escapeHtml(p.start_date ?? '-')}</td>
            <td class="${deadlineClass}">${escapeHtml(p.deadline ?? '-')}</td>
            <td style="min-width:160px">
              <div class="progress" style="height:6px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width:${progressPercent}"></div>
              </div>
            </td>
            <td>${escapeHtml(p.status ?? '-')}</td>
            <td class="text-end">
              <button class="btn btn-outline-secondary btn-sm me-1 btn-edit" data-id="${p.id}" title="Edit"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-outline-secondary btn-sm btn-delete" data-id="${p.id}" title="Delete"><i class="bi bi-x-lg"></i></button>
            </td>
          `;
          tbody.appendChild(tr);
        }
      }
      // update range label
      const total = filtered.length;
      const from = total === 0 ? 0 : (start + 1);
      const to = Math.min(start + pageSize, total);
      document.getElementById('rangeLabel').textContent = `${from}–${to} / ${total}`;
      // wire edit/delete buttons
      document.querySelectorAll('.btn-edit').forEach(b => b.addEventListener('click', onEditClick));
      document.querySelectorAll('.btn-delete').forEach(b => b.addEventListener('click', onDeleteClick));
    }
    // escape HTML to avoid injection in table
    function escapeHtml(s) {
      if (s === null || s === undefined) return '';
      return String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;');
    }
    // pagination controls
    function renderPagination() {
      const container = document.getElementById('pagination');
      container.innerHTML = '';
      const total = filtered.length;
      pageSize = parseInt(document.getElementById('pageSize').value, 10);
      const pages = Math.max(1, Math.ceil(total / pageSize));
      if (currentPage > pages) currentPage = pages;
      // prev
      const prev = document.createElement('li');
      prev.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
      prev.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
      prev.addEventListener('click', e => { e.preventDefault(); if (currentPage > 1) { currentPage--; updateView(); }});
      container.appendChild(prev);
      // page numbers window (max 5)
      let start = Math.max(1, currentPage - 2);
      let end = Math.min(pages, start + 4);
      if (end - start < 4) start = Math.max(1, end - 4);
      for (let i = start; i <= end; i++) {
        const li = document.createElement('li');
        li.className = 'page-item ' + (i === currentPage ? 'active' : '');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', e => { e.preventDefault(); currentPage = i; updateView(); });
        container.appendChild(li);
      }
      // next
      const next = document.createElement('li');
      next.className = 'page-item ' + (currentPage === pages ? 'disabled' : '');
      next.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
      next.addEventListener('click', e => { e.preventDefault(); if (currentPage < pages) { currentPage++; updateView(); }});
      container.appendChild(next);
    }
    function updateView() {
      renderTable();
      renderPagination();
    }
    // search filter
    document.getElementById('search').addEventListener('input', () => {
      const q = document.getElementById('search').value.trim().toLowerCase();
      if (!q) filtered = projects.slice();
      else filtered = projects.filter(p =>
        (p.title && p.title.toLowerCase().includes(q)) ||
        (p.client && p.client.toLowerCase().includes(q))
      );
      currentPage = 1;
      updateView();
    });
    // pageSize change
    document.getElementById('pageSize').addEventListener('change', () => {
      currentPage = 1;
      updateView();
    });
    // Export CSV (Excel)
    document.getElementById('btn-excel').addEventListener('click', () => {
      const header = ['ID','Title','Client','Price','Start date','Deadline','Progress','Status','Label'];
      const rows = filtered.map(p => [p.id, p.title, p.client||'', p.price||'', p.start_date||'', p.deadline||'', (p.progress||0)+'%', p.status||'', p.label||'']);
      const csv = [header, ...rows].map(r => r.map(c => `"${String(c).replace(/"/g,'""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href = url; a.download = 'projects.csv'; a.click();
      URL.revokeObjectURL(url);
    });
    // Print
    document.getElementById('btn-print').addEventListener('click', () => window.print());
    // filter dropdown (Open/All)
    document.querySelectorAll('[data-filter]').forEach(el => el.addEventListener('click', e => {
      e.preventDefault();
      const f = el.getAttribute('data-filter');
      if (f === 'open') filtered = projects.filter(p => (p.status || '').toLowerCase() === 'open');
      else filtered = projects.slice();
      currentPage = 1;
      updateView();
    }));
    // Edit click -> open modal with data
    let editModalInstance;
    const editModalEl = document.getElementById('editModal');
    editModalInstance = new bootstrap.Modal(editModalEl);
    function onEditClick(e) {
      const id = Number(e.currentTarget.getAttribute('data-id'));
      const p = projects.find(x => Number(x.id) === id);
      if (!p) return;
      // populate fields
      document.getElementById('edit-id').value = p.id;
      document.getElementById('edit-title').value = p.title || '';
      document.getElementById('edit-type').value = p.project_type || 'Client Project';
      document.getElementById('edit-label').value = p.label || '';
      document.getElementById('edit-description').value = p.description || '';
      document.getElementById('edit-start').value = p.start_date || '';
      document.getElementById('edit-deadline').value = p.deadline || '';
      document.getElementById('edit-price').value = p.price || '';
      document.getElementById('edit-progress').value = p.progress || 0;
      document.getElementById('edit-status').value = p.status || 'Open';
      editModalInstance.show();
    }
    // Delete click
    function onDeleteClick(e) {
      const id = Number(e.currentTarget.getAttribute('data-id'));
      if (!confirm('Delete project ID ' + id + '?')) return;
      projects = projects.filter(x => Number(x.id) !== id);
      filtered = filtered.filter(x => Number(x.id) !== id);
      updateView();
    }
    // Save changes from modal (updates in-memory)
    document.getElementById('saveChanges').addEventListener('click', () => {
      const id = Number(document.getElementById('edit-id').value);
      const idx = projects.findIndex(x => Number(x.id) === id);
      if (idx === -1) return;
      projects[idx].title = document.getElementById('edit-title').value.trim();
      projects[idx].project_type = document.getElementById('edit-type').value;
      projects[idx].label = document.getElementById('edit-label').value.trim();
      projects[idx].description = document.getElementById('edit-description').value.trim();
      projects[idx].start_date = document.getElementById('edit-start').value.trim();
      projects[idx].deadline = document.getElementById('edit-deadline').value.trim();
      projects[idx].price = document.getElementById('edit-price').value.trim();
      projects[idx].progress = Number(document.getElementById('edit-progress').value) || 0;
      projects[idx].status = document.getElementById('edit-status').value;
      // update filtered copy
      const fIdx = filtered.findIndex(x => Number(x.id) === id);
      if (fIdx !== -1) filtered[fIdx] = {...projects[idx]};
      editModalInstance.hide();
      updateView();
    });
    // small helper: escape all occurrences (polyfill for older browsers)
    if (!String.prototype.replaceAll) {
      String.prototype.replaceAll = function(search, replacement) {
        return this.split(search).join(replacement);
      };
    }
    // init
    loadProjects();
    // ADD PROJECT MODAL & FORM VALIDATION
document.addEventListener('DOMContentLoaded', () => {
  const addBtn = document.querySelector('.btn.btn-primary.btn-sm'); // The "Add project" button in header
  const addModalEl = document.getElementById('addProjectModal');
  const addModal = new bootstrap.Modal(addModalEl);
  const form = document.getElementById('addProjectForm');

  // open modal on "Add project" click
  addBtn.addEventListener('click', () => {
    form.reset();
    form.classList.remove('was-validated');
    addModal.show();
  });

  // handle form submission
  document.getElementById('saveProjectBtn').addEventListener('click', () => {
    form.classList.add('was-validated');

    if (!form.checkValidity()) {
      return; // stop if invalid
    }

    // collect values
    const newProject = {
      id: Date.now(),
      title: document.getElementById('add-title').value.trim(),
      project_type: document.getElementById('add-type').value,
      label: document.getElementById('add-label').value.trim(),
      description: document.getElementById('add-description').value.trim(),
      start_date: document.getElementById('add-start').value,
      deadline: document.getElementById('add-deadline').value,
      price: document.getElementById('add-price').value.trim(),
      progress: parseInt(document.getElementById('add-progress').value, 10) || 0,
      status: document.getElementById('add-status').value,
      client: document.getElementById('add-client').value.trim(),
    };

    // Add to existing table (global "projects" if defined)
    if (typeof projects !== 'undefined') {
      projects.push(newProject);
      filtered = projects.slice();
      if (typeof updateView === 'function') updateView();
    }

    // Close modal
    addModal.hide();

    // Reset form
    form.reset();
    form.classList.remove('was-validated');

    // Optional: toast / alert
    alert('✅ Project added successfully!');
  });
});
// MANAGE LABELS & IMPORT PROJECTS MODALS

document.addEventListener('DOMContentLoaded', () => {
  // Modal triggers
  const manageLabelsBtn = document.querySelector('button.btn-outline-secondary.btn-sm i.fa-tags')?.closest('button');
  const importProjectsBtn = document.querySelector('button.btn-outline-secondary.btn-sm i.fa-file-import')?.closest('button');

  const manageLabelsModal = new bootstrap.Modal(document.getElementById('manageLabelsModal'));
  const importProjectsModal = new bootstrap.Modal(document.getElementById('importProjectsModal'));

  // Open Manage Labels modal
  if (manageLabelsBtn) {
    manageLabelsBtn.addEventListener('click', () => manageLabelsModal.show());
  }

  // Open Import Projects modal
  if (importProjectsBtn) {
    importProjectsBtn.addEventListener('click', () => importProjectsModal.show());
  }

  // Handle Import Projects action
  document.getElementById('importProjectsBtn').addEventListener('click', () => {
    const fileInput = document.getElementById('importFile');
    const file = fileInput.files[0];

    if (!file) {
      alert('⚠️ Please select a file first.');
      return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
      try {
        let data;
        if (file.name.endsWith('.json')) {
          data = JSON.parse(e.target.result);
        } else {
          // Basic CSV handling
          const lines = e.target.result.split('\n').filter(l => l.trim());
          const [headers, ...rows] = lines.map(l => l.split(','));
          data = rows.map(r => Object.fromEntries(headers.map((h, i) => [h.trim(), r[i]?.trim()])));
        }

        // Merge imported projects into global list
        if (typeof projects !== 'undefined' && Array.isArray(data)) {
          projects.push(...data);
          filtered = projects.slice();
          if (typeof updateView === 'function') updateView();
        }

        importProjectsModal.hide();
        fileInput.value = '';
        alert('✅ Projects imported successfully!');
      } catch (err) {
        console.error(err);
        alert('❌ Failed to import: invalid file format.');
      }
    };
    reader.readAsText(file);
  });
});

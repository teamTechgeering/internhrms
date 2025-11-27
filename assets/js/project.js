document.addEventListener("DOMContentLoaded", () => {

    // state
    let projects = [];
    let filtered = [];
    let currentPage = 1;

    const pageSizeSelect = document.getElementById('pageSize');
    const tbody = document.getElementById('projects-tbody');
    const searchInput = document.getElementById('search');
    const btnExcel = document.getElementById('btn-excel');
    const btnPrint = document.getElementById('btn-print');
    const paginationEl = document.getElementById('pagination');
    const rangeLabel = document.getElementById('rangeLabel');

    if (!tbody || !pageSizeSelect) {
        console.error("❌ Missing required DOM elements. project.js aborted.");
        return;
    }

    let pageSize = parseInt(pageSizeSelect.value, 10);

    // label class mapping
    const labelClassMap = {
        'Urgent': 'badge bg-danger text-white',
        'On track': 'badge bg-success text-white',
        'Upcoming': 'badge bg-warning text-dark',
        'Perfect': 'badge bg-info text-white'
    };

    // load projects
    async function loadProjects() {
        try {
            const res = await fetch('projects_json.php', { cache: 'no-store' });
            if (!res.ok) throw new Error('Failed to load projects.json: ' + res.status);

            const data = await res.json();
            projects = Array.isArray(data) ? data : (data.projects || []);
            filtered = [...projects];

            updateView();
        } catch (err) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-danger text-center">Failed to load projects.json</td>
                </tr>`;
            console.error(err);
        }
    }

    function progressStylePercent(n) {
        const v = Math.max(0, Math.min(100, Number(n) || 0));
        return v + '%';
    }

    function renderLabel(label) {
        if (!label) return '';
        const cls = labelClassMap[label] || 'badge bg-secondary text-white';
        return ` <span class="${cls}">${label}</span>`;
    }

    function renderTable() {
        tbody.innerHTML = '';
        pageSize = parseInt(pageSizeSelect.value, 10);

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr>
                <td colspan="9" class="text-muted text-center">No projects found.</td>
            </tr>`;
            return;
        }

        for (const p of pageItems) {
            const tr = document.createElement('tr');

            const progressPercent = progressStylePercent(p.progress);
            const deadlineClass = p.deadline_alert ? 'text-danger fw-semibold' : '';

            tr.innerHTML = `
                <td>${p.id ?? ''}</td>

                <td class="small">
                  <a href="project_detail.php?id=${encodeURIComponent(p.id)}"
                     class="text-decoration-none text-blue">
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
                        <div class="progress-bar bg-primary"
                             role="progressbar"
                             style="width:${progressPercent}">
                        </div>
                    </div>
                </td>

                <td>${escapeHtml(p.status ?? '-')}</td>

                <td class="text-end">
                    <button class="btn btn-outline-secondary btn-sm me-1 btn-edit" data-id="${p.id}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm btn-delete" data-id="${p.id}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        }

        const total = filtered.length;
        const from = total === 0 ? 0 : (start + 1);
        const to = Math.min(start + pageSize, total);

        rangeLabel.textContent = `${from}–${to} / ${total}`;

        document.querySelectorAll('.btn-edit').forEach(b => b.addEventListener('click', onEditClick));
        document.querySelectorAll('.btn-delete').forEach(b => b.addEventListener('click', onDeleteClick));
    }

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;');
    }

    function renderPagination() {
        paginationEl.innerHTML = '';
        const total = filtered.length;
        pageSize = parseInt(pageSizeSelect.value, 10);

        const pages = Math.max(1, Math.ceil(total / pageSize));
        if (currentPage > pages) currentPage = pages;

        const prev = document.createElement('li');
        prev.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
        prev.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
        prev.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage > 1) { currentPage--; updateView(); }
        });
        paginationEl.appendChild(prev);

        let start = Math.max(1, currentPage - 2);
        let end = Math.min(pages, start + 4);
        if (end - start < 4) start = Math.max(1, end - 4);

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = 'page-item ' + (i === currentPage ? 'active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                currentPage = i;
                updateView();
            });
            paginationEl.appendChild(li);
        }

        const next = document.createElement('li');
        next.className = 'page-item ' + (currentPage === pages ? 'disabled' : '');
        next.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
        next.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage < pages) { currentPage++; updateView(); }
        });
        paginationEl.appendChild(next);
    }

    function updateView() {
        renderTable();
        renderPagination();
    }

    // SEARCH
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            filtered = !q
                ? [...projects]
                : projects.filter(p =>
                    (p.title && p.title.toLowerCase().includes(q)) ||
                    (p.client && p.client.toLowerCase().includes(q))
                );
            currentPage = 1;
            updateView();
        });
    }

    // PAGE SIZE
    pageSizeSelect.addEventListener('change', () => {
        currentPage = 1;
        updateView();
    });

    // EXPORT CSV
    btnExcel?.addEventListener('click', () => {
        const header = [
            'ID', 'Title', 'Client', 'Price', 'Start date',
            'Deadline', 'Progress', 'Status', 'Label'
        ];

        const rows = filtered.map(p => [
            p.id, p.title, p.client || '',
            p.price || '', p.start_date || '',
            p.deadline || '', (p.progress || 0) + '%',
            p.status || '', p.label || ''
        ]);

        const csv = [header, ...rows]
            .map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(','))
            .join('\n');

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'projects.csv';
        a.click();
        URL.revokeObjectURL(url);
    });

    // PRINT
    btnPrint?.addEventListener('click', () => window.print());

    // EDIT MODAL
    const editModalEl = document.getElementById('editModal');
    const editModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;

    function onEditClick(e) {
        if (!editModal) return;

        const id = Number(e.currentTarget.getAttribute('data-id'));
        const p = projects.find(x => Number(x.id) === id);
        if (!p) return;

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

        editModal.show();
    }

    function onDeleteClick(e) {
        const id = Number(e.currentTarget.getAttribute('data-id'));
        if (!confirm('Delete project ID ' + id + '?')) return;

        projects = projects.filter(x => Number(x.id) !== id);
        filtered = filtered.filter(x => Number(x.id) !== id);
        updateView();
    }

    document.getElementById('saveChanges')?.addEventListener('click', () => {
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

        const fIdx = filtered.findIndex(x => Number(x.id) === id);
        if (fIdx !== -1) filtered[fIdx] = { ...projects[idx] };

        editModal.hide();
        updateView();
    });

    // ADD PROJECT MODAL
    const addModalEl = document.getElementById('addProjectModal');
    const addModal = addModalEl ? new bootstrap.Modal(addModalEl) : null;
    const addForm = document.getElementById('addProjectForm');

    const addBtn = document.querySelector('.btn.btn-primary.btn-sm');

    if (addBtn && addModal && addForm) {
        addBtn.addEventListener('click', () => {
            addForm.reset();
            addForm.classList.remove('was-validated');
            addModal.show();
        });

        document.getElementById('saveProjectBtn')?.addEventListener('click', () => {
            addForm.classList.add('was-validated');

            if (!addForm.checkValidity()) return;

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

            projects.push(newProject);
            filtered = [...projects];
            updateView();

            addModal.hide();
            addForm.reset();
            addForm.classList.remove('was-validated');

            alert('✅ Project added successfully!');
        });
    }

    // MANAGE LABELS + IMPORT PROJECTS
    const manageLabelsModal = new bootstrap.Modal(document.getElementById('manageLabelsModal'));
    const importProjectsModal = new bootstrap.Modal(document.getElementById('importProjectsModal'));

    const manageLabelsBtn = document.querySelector('i.fa-tags')?.closest('button');
    const importProjectsBtn = document.querySelector('i.fa-file-import')?.closest('button');

    manageLabelsBtn?.addEventListener('click', () => manageLabelsModal.show());
    importProjectsBtn?.addEventListener('click', () => importProjectsModal.show());

    document.getElementById('importProjectsBtn')?.addEventListener('click', () => {
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
                    const lines = e.target.result.split('\n').filter(l => l.trim());
                    const [headers, ...rows] = lines.map(l => l.split(','));

                    data = rows.map(r => Object.fromEntries(
                        headers.map((h, i) => [h.trim(), r[i]?.trim()])
                    ));
                }

                if (Array.isArray(data)) {
                    projects.push(...data);
                    filtered = [...projects];
                    updateView();
                }

                importProjectsModal.hide();
                fileInput.value = '';
                alert('✅ Projects imported successfully!');

            } catch (err) {
                console.error(err);
                alert('❌ Invalid file format.');
            }
        };

        reader.readAsText(file);
    });

    loadProjects();

});

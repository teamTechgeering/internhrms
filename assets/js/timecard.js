// timecard.js
// Simple frontend renderer using only Bootstrap classes (no CSS).
// Expects timecard_json.php to return { entries: [...], summary: [...], members: [...], ... }

let TIME_DATA = null;
let currentNoteEntryId = null;
let currentEditEntryId = null;
let currentDeleteEntryId = null;

function $(sel){ return document.querySelector(sel); }
function $all(sel){ return Array.from(document.querySelectorAll(sel)); }

async function loadTimeData(){
  const res = await fetch('timecard_json.php');
  TIME_DATA = await res.json();
  if (!TIME_DATA) TIME_DATA = { entries:[], summary:[], summary_details:[], members:[], members_clocked_in:[], clock_in_out:[] };
  initUI();
  renderAll();
}

function initUI(){
  // populate member filters and selects
  const select = $('#filterMember');
  const manualSel = $('#manual_member');
  select.innerHTML = '<option value="">- Member -</option>';
  manualSel.innerHTML = '<option value="">- Member -</option>';
  (TIME_DATA.members || []).forEach(m=>{
    const opt = document.createElement('option');
    opt.value = m.email; opt.text = m.name;
    select.appendChild(opt);
    const opt2 = opt.cloneNode(true);
    manualSel.appendChild(opt2);
  });

  // tabs - your markup uses buttons with data-tab attribute
  $all('.nav-tabs .nav-link').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      $all('.nav-tabs .nav-link').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const tab = btn.dataset.tab || btn.getAttribute('data-tab');
      if (!tab) return;
      $all('#tabContent > div').forEach(p=>p.classList.add('d-none'));
      const pane = document.getElementById('pane-'+tab);
      if (pane) pane.classList.remove('d-none');
    });
  });

  // Search
  $('#searchInput').addEventListener('input', ()=> renderAll());

  // Export/Print basic
  $('#btnPrint').addEventListener('click', ()=> window.print());
  $('#btnExport').addEventListener('click', ()=> alert('Export (frontend demo)'));

  // Prev/Today/Next (no calendar implemented; basic)
  $('#btnToday').addEventListener('click', ()=> alert('Today filter (frontend demo)'));
  $('#btnPrev').addEventListener('click', ()=> alert('Prev (frontend demo)'));
  $('#btnNext').addEventListener('click', ()=> alert('Next (frontend demo)'));

  // manual save
  $('#manualSave').addEventListener('click', ()=>{
    const memberEmail = $('#manual_member').value;
    const member = (TIME_DATA.members||[]).find(m=>m.email===memberEmail) || {name:'Unknown', email:memberEmail};
    const entry = {
      id: String(Date.now()+Math.random()),
      member_name: member.name,
      member_email: member.email,
      in_date: $('#manual_in_date').value || '',
      in_time: $('#manual_in_time').value || '',
      out_date: $('#manual_out_date').value || '',
      out_time: $('#manual_out_time').value || '',
      duration: '',
      hours: '',
      note: ''
    };
    TIME_DATA.entries = TIME_DATA.entries || [];
    TIME_DATA.entries.unshift(entry);
    // close modal
    const modalEl = document.getElementById('addTimeModal');
    const bsModal = bootstrap.Modal.getInstance(modalEl);
    if (bsModal) bsModal.hide();
    renderAll();
  });

  // wire saveNote, editSave, deleteConfirm
  $('#saveNote').addEventListener('click', saveNoteFromModal);
  $('#editSave').addEventListener('click', saveEditFromModal);
  $('#deleteConfirm').addEventListener('click', confirmDeleteFromModal);
}

function renderAll(){
  renderDaily();
  renderCustom();
  renderSummary();
  renderSummaryDetails();
  renderMembersClockedIn();
  renderClockInOut();
}

/* ================== RENDER FUNCTIONS ================== */

function renderDaily(){
  const tbody = document.querySelector('#table-daily tbody');
  tbody.innerHTML = '';
  const q = ($('#searchInput') && $('#searchInput').value || '').toLowerCase();
  const mfilter = ($('#filterMember') && $('#filterMember').value) || '';

  const entries = (TIME_DATA.entries || []).filter(e=>{
    const member = (e.member_name||'').toLowerCase();
    if (mfilter && e.member_email !== mfilter) return false;
    if (q && !(member.includes(q) || (e.in_date||'').includes(q) || (e.in_time||'').includes(q))) return false;
    return true;
  });

  entries.forEach(e=>{
    const tr = document.createElement('tr');

    // buttons: Note, Edit, Delete (use icons text-only so no external css)
    const noteBtn = `<button class="btn btn-sm " onclick="openNoteModal('${e.id}')"><i class="bi bi-chat-dots"></i></button>`;
    const editBtn = `<button class="btn btn-sm " onclick="openEditModal('${e.id}')"><i class="bi bi-pencil-square"></i></button>`;
    const delBtn  = `<button class="btn btn-sm " onclick="openDeleteModal('${e.id}')"><i class="bi bi-x-lg"></i></button>`;

    tr.innerHTML = `
      <td>
        <img src="${findMemberAvatar(e.member_email)}" width="32" height="32" class="rounded-circle me-2 align-middle">
        <a href="member_view.php?email=${encodeURIComponent(e.member_email)}" class="text-primary">${escapeHtml(e.member_name)}</a>
      </td>
      <td>${escapeHtml(e.in_date||'')}</td>
      <td>${escapeHtml(e.in_time||'')}</td>
      <td>${escapeHtml(e.out_date||'')}</td>
      <td>${escapeHtml(e.out_time||'')}</td>
      <td>${escapeHtml(e.duration||'')}</td>
      <td class="text-center">${noteBtn}</td>
      <td class="text-center">${editBtn}</td>
      <td class="text-center">${delBtn}</td>
    `;
    tbody.appendChild(tr);
  });

  // count text (basic)
  $('#dailyCount').innerText = `${entries.length>0 ? '1' : '0'}-${entries.length} / ${entries.length}`;
}

function renderCustom(){
  const tbody = document.querySelector('#table-custom tbody');
  tbody.innerHTML = '';
  const entries = TIME_DATA.entries || [];
  entries.forEach(e=>{
    const tr = document.createElement('tr');
    const noteBtn = `<button class="btn btn-sm " onclick="openNoteModal('${e.id}')"><i class="bi bi-chat-dots"></i></button>`;
    const editBtn = `<button class="btn btn-sm " onclick="openEditModal('${e.id}')"><i class="bi bi-pencil-square"></i></button>`;
    const delBtn  = `<button class="btn btn-sm " onclick="openDeleteModal('${e.id}')"><i class="bi bi-x-lg"></i></button>`;

    tr.innerHTML = `
      <td>
        <img src="${findMemberAvatar(e.member_email)}" width="32" height="32" class="rounded-circle me-2 align-middle">
        <a href="member_view.php?email=${encodeURIComponent(e.member_email)}" class="text-primary">${escapeHtml(e.member_name)}</a>
      </td>
      <td>${escapeHtml(e.in_date||'')}</td>
      <td>${escapeHtml(e.in_time||'')}</td>
      <td>${escapeHtml(e.out_date||'')}</td>
      <td>${escapeHtml(e.out_time||'')}</td>
      <td>${escapeHtml(e.duration||'')}</td>
      <td class="text-center">${noteBtn}</td>
      <td class="text-center">${editBtn}</td>
      <td class="text-center">${delBtn}</td>
    `;
    tbody.appendChild(tr);
  });

  $('#customCount').innerText = `${entries.length>0 ? '1' : '0'}-${entries.length} / ${entries.length}`;
}

function renderSummary(){
  const tbody = document.querySelector('#table-summary tbody');
  tbody.innerHTML = '';
  let durTotal = '00:00:00';
  let hoursTotal = 0;
  (TIME_DATA.summary || []).forEach(s=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <img src="${findMemberAvatarByName(s.name)}" width="32" height="32" class="rounded-circle me-2 align-middle">
        <a href="member_view.php?email=${encodeURIComponent(s.email)}" class="text-primary">${escapeHtml(s.name)}</a>
      </td>
      <td class="text-end">${escapeHtml(s.duration)}</td>
      <td class="text-end">${escapeHtml(String(s.hours))}</td>
    `;
    tbody.appendChild(tr);
    durTotal = sumDurations(durTotal, s.duration);
    hoursTotal += Number(s.hours)||0;
  });
  $('#summaryDurationTotal').innerText = durTotal;
  $('#summaryHoursTotal').innerText = (hoursTotal || 0).toFixed(2);
}

function renderSummaryDetails(){
  const tbody = document.querySelector('#table-summary-details tbody');
  tbody.innerHTML = '';
  (TIME_DATA.summary_details || []).forEach(s=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <img src="${findMemberAvatarByName(s.name)}" width="32" height="32" class="rounded-circle me-2 align-middle">
        <a href="member_view.php?email=${encodeURIComponent(s.email)}" class="text-primary">${escapeHtml(s.name)}</a>
      </td>
      <td>${escapeHtml(s.date)}</td>
      <td class="text-end">${escapeHtml(s.duration)}</td>
      <td class="text-end">${escapeHtml(String(s.hours))}</td>
    `;
    tbody.appendChild(tr);
  });
}

function renderMembersClockedIn(){
  const tbody = document.querySelector('#table-members-clocked-in tbody');
  tbody.innerHTML = '';
  (TIME_DATA.members_clocked_in || []).forEach(m=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <img src="${findMemberAvatar(m.email)}" width="32" height="32" class="rounded-circle me-2 align-middle">
        <a href="member_view.php?email=${encodeURIComponent(m.email)}" class="text-primary">${escapeHtml(m.name)}</a>
      </td>
      <td>${escapeHtml(m.in_date||'')}</td>
      <td>${escapeHtml(m.in_time||'')}</td>
    `;
    tbody.appendChild(tr);
  });
}

function renderClockInOut(){
  const tbody = document.querySelector('#table-clock-in-out tbody');
  tbody.innerHTML = '';
  (TIME_DATA.clock_in_out || []).forEach(m=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <img src="${findMemberAvatar(m.email)}" width="32" height="32" class="rounded-circle me-2 align-middle">
        <a href="member_view.php?email=${encodeURIComponent(m.email)}" class="text-primary">${escapeHtml(m.name)}</a>
      </td>
      <td>${escapeHtml(m.status)}</td>
      <td>
        <button class="btn btn-outline-secondary btn-sm" onclick="clockInOut('${m.email}')">${m.status === 'Not clocked in yet' ? 'Clock In' : 'Clock Out'}</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function clockInOut(email){
  const item = (TIME_DATA.clock_in_out || []).find(x=>x.email===email);
  if (!item) return;
  if (item.status === 'Not clocked in yet') item.status = 'Clocked In';
  else item.status = 'Not clocked in yet';
  renderClockInOut();
}

/* ================== MODAL HANDLERS: Note / Edit / Delete ================== */

function openNoteModal(entryId){
  currentNoteEntryId = entryId;
  const entry = (TIME_DATA.entries || []).find(e => String(e.id) === String(entryId));
  $('#noteText').value = (entry && entry.note) || '';
  const modalEl = document.getElementById('noteModal');
  const bs = new bootstrap.Modal(modalEl);
  bs.show();
}

function saveNoteFromModal(){
  if (!currentNoteEntryId) return;
  const entry = (TIME_DATA.entries || []).find(e => String(e.id) === String(currentNoteEntryId));
  if (!entry) return;
  entry.note = $('#noteText').value;
  // close modal
  const modalEl = document.getElementById('noteModal');
  const bs = bootstrap.Modal.getInstance(modalEl);
  if (bs) bs.hide();
  renderAll();
}

function openEditModal(entryId){
  currentEditEntryId = entryId;
  const entry = (TIME_DATA.entries || []).find(e => String(e.id) === String(entryId));
  if (!entry) return;
  $('#editAvatar').src = findMemberAvatar(entry.member_email);
  $('#editName').innerText = entry.member_name || '';
  $('#edit_in_date').value = entry.in_date || '';
  $('#edit_in_time').value = entry.in_time || '';
  $('#edit_out_date').value = entry.out_date || '';
  $('#edit_out_time').value = entry.out_time || '';
  $('#edit_note').value = entry.note || '';
  const modalEl = document.getElementById('editModal');
  const bs = new bootstrap.Modal(modalEl);
  bs.show();
}

function saveEditFromModal(){
  if (!currentEditEntryId) return;
  const entry = (TIME_DATA.entries || []).find(e => String(e.id) === String(currentEditEntryId));
  if (!entry) return;
  entry.in_date = $('#edit_in_date').value || '';
  entry.in_time = $('#edit_in_time').value || '';
  entry.out_date = $('#edit_out_date').value || '';
  entry.out_time = $('#edit_out_time').value || '';
  entry.note = $('#edit_note').value || '';
  // Optionally update duration/hours here if you want; left blank for frontend demo.
  const modalEl = document.getElementById('editModal');
  const bs = bootstrap.Modal.getInstance(modalEl);
  if (bs) bs.hide();
  renderAll();
}

function openDeleteModal(entryId){
  currentDeleteEntryId = entryId;
  const modalEl = document.getElementById('deleteModal');
  const bs = new bootstrap.Modal(modalEl);
  bs.show();
}

function confirmDeleteFromModal(){
  if (!currentDeleteEntryId) return;
  TIME_DATA.entries = (TIME_DATA.entries || []).filter(e => String(e.id) !== String(currentDeleteEntryId));
  currentDeleteEntryId = null;
  const modalEl = document.getElementById('deleteModal');
  const bs = bootstrap.Modal.getInstance(modalEl);
  if (bs) bs.hide();
  renderAll();
}

/* ================== HELPERS ================== */

function escapeHtml(s){ return (s===null||s===undefined)?'':String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

function findMemberAvatar(email){
  if (!email) return 'https://i.pravatar.cc/40';
  const m = (TIME_DATA.members || []).find(x=>x.email===email);
  return (m && m.avatar) || 'https://i.pravatar.cc/40';
}
function findMemberAvatarByName(name){
  if (!name) return 'https://i.pravatar.cc/40';
  const m = (TIME_DATA.members || []).find(x=>x.name===name);
  return (m && m.avatar) || 'https://i.pravatar.cc/40';
}

// sum durations in HH:MM:SS format (simple)
function sumDurations(a,b){
  function toSec(hms){
    const parts = (hms||'00:00:00').split(':').map(x=>Number(x)||0);
    return parts[0]*3600 + parts[1]*60 + parts[2];
  }
  function toHms(sec){
    const h = Math.floor(sec/3600); sec %= 3600;
    const m = Math.floor(sec/60); const s = sec%60;
    return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
  }
  return toHms(toSec(a)+toSec(b));
}

// load on DOM ready
document.addEventListener('DOMContentLoaded', loadTimeData);

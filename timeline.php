<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid py-3">
<div class="row">

<!-- ================= LEFT TIMELINE ================= -->
<div class="col-lg-9">

<!-- SHARE BOX -->
<div class="card mb-3">
<div class="card-body">
<div class="d-flex gap-3 align-items-start">

<div class="col-auto">
<img src="assets/images/people.png" class="rounded-circle img-fluid" width="48" height="48">
</div>

<div class="flex-grow-1">
<textarea class="form-control border-0 mb-3" rows="2" id="postText"
placeholder="Share an idea or documents..."></textarea>

<div class="d-flex justify-content-between align-items-center">
<div class="d-flex gap-2">
<input type="file" id="postFile" class="d-none">
<button class="btn btn-light border" onclick="postFile.click()">
<i class="bi bi-paperclip"></i> Upload File
</button>
<button class="btn btn-light border">
<i class="bi bi-mic"></i>
</button>
</div>
<button class="btn btn-primary" id="postBtn">
<i class="bi bi-send"></i> Post
</button>
</div>
</div>

</div>
</div>
</div>

<!-- TODAY BADGE -->
<div class="text-center mb-3">
<span class="badge rounded-pill bg-primary px-3">Today</span>
</div>

<!-- ================= POSTS ROW ================= -->
<!-- ================= POSTS ROW ================= -->
<div class="row g-3" id="postsRow">

<!-- POST 1 -->
<div class="col-lg-6">
<div class="card h-100">
<div class="card-body d-flex flex-column">

<div class="d-flex justify-content-between align-items-start mb-2">
<div class="d-flex gap-3 align-items-center">
<img src="assets/images/people.png" class="rounded-circle img-fluid" width="48">
<div>
<h6 class="mb-0">John Doe</h6>
<small class="text-muted">Today at 07:08:03 am</small>
</div>
</div>
<div class="position-relative">
  <i class="bi bi-chevron-down post-menu-toggle" style="cursor:pointer;"></i>

  <div class="post-menu d-none position-absolute end-0 mt-2 bg-white border rounded shadow-sm">
    <button class="dropdown-item text-danger delete-post-btn">
      <i class="bi bi-trash"></i> Delete
    </button>
  </div>
</div>
</div>

<p class="mb-2">
Hello everyone!<br>
I have a new idea. Lets discuss it tomorrow!
</p>

<div class="ratio ratio-16x9 rounded overflow-hidden mb-2">
<img src="assets/images/note.webp"
     class="img-fluid w-100 h-100 post-image"
     data-img="assets/images/note.webp"
     style="cursor:pointer;">
</div>

<div class="d-flex justify-content-between mt-auto">
<a href="#" class="text-decoration-none reply-btn">
<i class="bi bi-reply"></i> Reply
</a>
<a href="assets/images/note.webp" download class="text-decoration-none">Download</a>
</div>

<!-- REPLY AREA -->
<div class="reply-area d-none mt-3">
<div class="d-flex gap-2">
<img src="assets/images/people.png" class="rounded-circle" width="32">

<div class="flex-grow-1 border rounded p-2">

<textarea class="form-control mb-2 reply-text"
rows="4"
placeholder="Write a reply..."></textarea>

<button class="btn btn-primary btn-sm post-reply">
<i class="bi bi-reply"></i> Post Reply
</button>

</div>
</div>

<div class="replies mt-3"></div>
</div>


</div>
</div>
</div>

<!-- POST 2 -->
<div class="col-lg-6">
<div class="card h-100">
<div class="card-body d-flex flex-column">

<div class="d-flex justify-content-between align-items-start mb-2">
<div class="d-flex gap-3 align-items-center">
<img src="assets/images/people.png" class="rounded-circle img-fluid" width="48" height="48">
<div>
<h6 class="mb-0">John Doe</h6>
<small class="text-muted">Today at 07:05:05 am</small>
</div>
</div>
<div class="position-relative">
  <i class="bi bi-chevron-down post-menu-toggle" style="cursor:pointer;"></i>

  <div class="post-menu d-none position-absolute end-0 mt-2 bg-white border rounded shadow-sm">
    <button class="dropdown-item text-danger delete-post-btn">
      <i class="bi bi-trash"></i> Delete
    </button>
  </div>
</div>
</div>

<p class="mb-2">This is our new project!</p>

<div class="ratio ratio-16x9 rounded overflow-hidden mb-2">
<img src="assets/images/stair.webp"
     class="img-fluid w-100 h-100 post-image"
     data-img="assets/images/stair.webp"
     style="cursor:pointer;">
</div>

<div class="d-flex justify-content-between mt-auto">
<a href="#" class="text-decoration-none reply-btn">
<i class="bi bi-reply"></i> Reply
</a>
<a href="assets/images/stair.webp" download class="text-decoration-none">Download</a>
</div>

<!-- REPLY AREA -->
<div class="reply-area d-none mt-3">
<div class="d-flex gap-2">
<img src="assets/images/people.png" class="rounded-circle" width="32">

<div class="flex-grow-1 border rounded p-2">

<textarea class="form-control mb-2 reply-text"
rows="4"
placeholder="Write a reply..."></textarea>

<button class="btn btn-primary btn-sm post-reply">
<i class="bi bi-reply"></i> Post Reply
</button>

</div>
</div>

<div class="replies mt-3"></div>
</div>


</div>
</div>
</div>




</div>
</div>

<!-- ================= RIGHT USERS PANEL ================= -->
<div class="col-lg-3">
<div class="card">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-3">
<h6 class="mb-0">Members</h6>
<button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#messageModal">
<i class="bi bi-chat-dots"></i>
</button>
</div>

<?php
$users = [
["Mark Thomas","Web Developer"],
["Michael Wood","Project Manager"],
["Richard Gray","Web Developer"],
["Sara Ann","Web Designer"]
];
foreach($users as $u){
?>
<div class="d-flex justify-content-between align-items-center mb-3 user-item" data-name="<?= $u[0] ?>">
<div class="d-flex gap-2 align-items-center">
<img src="assets/images/people.png" class="rounded-circle img-fluid" width="40" height="40">
<div>
<div class="fw-semibold"><?= $u[0] ?></div>
<small class="text-muted"><?= $u[1] ?></small>
</div>
</div>
<i class="bi bi-envelope"></i>
</div>
<?php } ?>

</div>
</div>
</div>

</div>
</div>

<!-- ================= MESSAGE MODAL (UNCHANGED STRUCTURE, UPDATED FUNCTIONALITY) ================= -->
<div class="modal fade" id="messageModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Send message</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<div class="mb-3 d-flex align-items-center gap-2">
<strong>To</strong>
<span id="modalToName" class="fw-semibold">Mark Thomas</span>
</div>

<input type="text" class="form-control mb-3" id="messageSubject" placeholder="Subject">

<textarea class="form-control mb-3" rows="6" id="messageText"
placeholder="Write a message..."></textarea>

<div id="sentInfo" class="text-success d-none">
  ✓ Message sent successfully
</div>

<!-- FILE INFO (ADDED, NOTHING REMOVED) -->
<div id="fileInfo" class="small text-muted d-none"></div>
</div>

<div class="modal-footer justify-content-between">

<div class="d-flex gap-2">

<!-- HIDDEN FILE INPUT (ADDED) -->
<input type="file" id="messageFile" class="d-none">

<button class="btn btn-light border"
onclick="document.getElementById('messageFile').click()">
<i class="bi bi-paperclip"></i> Upload File
</button>

<button class="btn btn-light border">
<i class="bi bi-mic"></i>
</button>

</div>

<div>
<button class="btn btn-light border" data-bs-dismiss="modal">Close</button>

<button class="btn btn-primary" id="sendMessageBtn">
<i class="bi bi-send"></i> Send
</button>
</div>

</div>

</div>
</div>
</div>


<!-- IMAGE FULLSCREEN VIEWER -->
<div id="imageViewer"
     style="display:none; position:fixed; inset:0; background:#000; z-index:9999;">

  <span id="closeViewer"
        style="position:absolute; top:15px; right:20px;
               font-size:28px; color:#fff; cursor:pointer;">
    &times;
  </span>

  <img id="viewerImg"
       src=""
       style="max-width:100%; max-height:100%;
              position:absolute; top:50%; left:50%;
              transform:translate(-50%, -50%);">
</div>


<?php include 'common/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {

/* ================= USER MESSAGE MODAL ================= */
document.querySelectorAll('.user-item').forEach(item => {
  item.addEventListener('click', () => {
    document.getElementById('modalToName').innerText = item.dataset.name;
    new bootstrap.Modal(document.getElementById('messageModal')).show();
  });
});


/* ================= IMAGE FULLSCREEN VIEW ================= */
document.addEventListener('click', e => {

  // open viewer
  if (e.target.classList.contains('post-image')) {
    const viewer = document.getElementById('imageViewer');
    const img = document.getElementById('viewerImg');

    img.src = e.target.dataset.img;
    viewer.style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  // close viewer
  if (e.target.id === 'closeViewer') {
    document.getElementById('imageViewer').style.display = 'none';
    document.getElementById('viewerImg').src = '';
    document.body.style.overflow = '';
  }
});


/* ================= TOGGLE REPLY ================= */
document.addEventListener('click', e => {
  const btn = e.target.closest('.reply-btn');
  if (!btn) return;

  e.preventDefault();

  const area = btn.closest('.card-body').querySelector('.reply-area');
  area.classList.toggle('d-none');

  // ✅ ADD THIS LINE
  area.querySelector('.d-flex').classList.remove('d-none');
});



/* ================= POST REPLY ================= */
document.addEventListener('click', e => {
  const btn = e.target.closest('.post-reply');
  if (!btn) return;

  const area = btn.closest('.reply-area');
  const text = area.querySelector('.reply-text').value.trim();
  const replies = area.querySelector('.replies');

  if (!text) return;

  replies.insertAdjacentHTML('beforeend', `
  <div class="d-flex justify-content-between align-items-start gap-2 mb-3 reply-item">

    <div class="d-flex gap-2">
      <img src="assets/images/people.png" class="rounded-circle" width="32">
      <div>
        <div class="fw-semibold">
          John Doe
          <small class="text-muted ms-2">
            Today at ${new Date().toLocaleTimeString()}
          </small>
        </div>
        <div>${text}</div>
      </div>
    </div>

    <div class="position-relative">
      <i class="bi bi-chevron-down reply-menu-toggle" style="cursor:pointer;"></i>

      <div class="reply-menu d-none position-absolute end-0 mt-1 bg-white border rounded shadow-sm">
        <button class="dropdown-item text-danger delete-reply-btn">
          <i class="bi bi-trash"></i> Delete
        </button>
      </div>
    </div>

  </div>
`);

  area.querySelector('.reply-text').value = '';
  area.querySelector('.d-flex').classList.add('d-none');
});


/* ================= TOP POST → NEW POST ================= */
document.getElementById('postBtn').addEventListener('click', () => {

  const text = postText.value.trim();
  const file = postFile.files[0];
  if (!text && !file) return;

  let imageBlock = '';
  let download = '';

  if (file) {
    const url = URL.createObjectURL(file);

    imageBlock = `
      <div class="ratio ratio-16x9 rounded overflow-hidden mb-2">
        <img src="${url}"
             class="img-fluid w-100 h-100 post-image"
             data-img="${url}"
             style="cursor:pointer;">
      </div>
    `;

    download = `
      <a href="${url}" download class="text-decoration-none">
        Download
      </a>
    `;
  }

  postsRow.insertAdjacentHTML('afterbegin', `
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-body d-flex flex-column">

          <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex gap-3 align-items-center">
              <img src="assets/images/people.png" width="48" height="48" class="rounded-circle">
              <div>
                <h6 class="mb-0">John Doe</h6>
                <small class="text-muted">Just now</small>
              </div>
            </div>

            <div class="position-relative">
              <i class="bi bi-chevron-down post-menu-toggle" style="cursor:pointer;"></i>
              <div class="post-menu d-none position-absolute end-0 mt-2 bg-white border rounded shadow-sm">
                <button class="dropdown-item text-danger delete-post-btn">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </div>
            </div>
          </div>

          <p>${text}</p>
          ${imageBlock}

          <div class="d-flex justify-content-between mt-auto">
            <a href="#" class="reply-btn text-decoration-none">
              <i class="bi bi-reply"></i> Reply
            </a>
            ${download}
          </div>

          <div class="reply-area d-none mt-3">
            <div class="d-flex gap-2">
              <img src="assets/images/people.png" width="32" height="32" class="rounded-circle">
              <div class="flex-grow-1 border rounded p-2">
                <textarea class="form-control mb-2 reply-text" rows="3"></textarea>
                <input type="file" class="form-control mb-2 reply-file">
                <button class="btn btn-primary btn-sm post-reply">Post Reply</button>
              </div>
            </div>
            <div class="replies mt-3"></div>
          </div>

        </div>
      </div>
    </div>
  `);

  postText.value = '';
  postFile.value = '';
});


/* ================= SEND MESSAGE BUTTON ================= */
document.getElementById('sendMessageBtn').addEventListener('click', () => {

  const to = document.getElementById('modalToName').innerText.trim();
  const subject = document.getElementById('messageSubject').value.trim();
  const message = document.getElementById('messageText').value.trim();

  const fileInput = document.getElementById('messageFile');
  const file = fileInput ? fileInput.files[0] : null;

  if (!message) {
    alert('Message cannot be empty');
    return;
  }

  document.getElementById('sentInfo').classList.remove('d-none');

  document.getElementById('messageSubject').value = '';
  document.getElementById('messageText').value = '';

  if (fileInput) {
    fileInput.value = '';
  }

  const fileInfo = document.getElementById('fileInfo');
  if (fileInfo) {
    fileInfo.classList.add('d-none');
    fileInfo.innerText = '';
  }

  setTimeout(() => {
    document.getElementById('sentInfo').classList.add('d-none');
    bootstrap.Modal
      .getInstance(document.getElementById('messageModal'))
      .hide();
  }, 800);

  console.log('Message sent to:', to);
  console.log('Subject:', subject);
  console.log('Message:', message);

  if (file) {
    console.log('Attached file:', file.name);
  }
});


/* ================= TOGGLE POST MENU ================= */
document.addEventListener('click', e => {

  const toggle = e.target.closest('.post-menu-toggle');
  if (toggle) {
    e.stopPropagation();
    const menu = toggle.parentElement.querySelector('.post-menu');
    menu.classList.toggle('d-none');
    return;
  }

  const delBtn = e.target.closest('.delete-post-btn');
  if (delBtn) {
    e.stopPropagation();
    const postCard = delBtn.closest('.col-lg-6');
    if (postCard) {
      postCard.remove();
    }
    return;
  }

  document.querySelectorAll('.post-menu').forEach(menu => {
    menu.classList.add('d-none');
  });
});

/* ================= TOGGLE REPLY MENU ================= */
document.addEventListener('click', e => {

  // open reply menu
  const toggle = e.target.closest('.reply-menu-toggle');
  if (toggle) {
    e.stopPropagation();
    const menu = toggle.parentElement.querySelector('.reply-menu');
    menu.classList.toggle('d-none');
    return;
  }

  // delete reply
  const del = e.target.closest('.delete-reply-btn');
  if (del) {
    e.stopPropagation();
    const replyItem = del.closest('.reply-item');
    if (replyItem) {
      replyItem.remove();
    }
    return;
  }

  // close reply menus when clicking outside
  document.querySelectorAll('.reply-menu').forEach(menu => {
    menu.classList.add('d-none');
  });
});

}); // ✅ END DOMContentLoaded
</script>


</body>
</html>

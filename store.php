<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

    <div class="container py-4">

      <!-- TOP BAR -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Store</h4>

        <div class="d-flex align-items-center gap-3">
          <!-- Category -->
          <select id="categorySelect" class="form-select" style="width:150px;">
            <option value="all">- Category -</option>
            <option value="Design">Design</option>
            <option value="Hosting">Hosting</option>
            <option value="Writing">Writing</option>
            <option value="SEO">SEO</option>
          </select>

          <!-- Search -->
          <div class="input-group" style="width:260px;">
            <input id="searchInput" type="text" class="form-control" placeholder="Search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
          </div>

          <!-- Checkout button -->
          <button id="checkoutBtn" class="btn btn-success d-flex align-items-center gap-2">
            <i class="bi bi-check2-circle"></i> Checkout
          </button>

        </div>
      </div>

      <!-- PRODUCT GRID -->
      <div id="productGrid" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4"></div>

    </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>


<!-- QUICK VIEW MODAL -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Item details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <h4 id="modalTitle" class="fw-semibold mb-0"></h4>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
          <div id="modalPrice" style="background:#d63384;color:#fff;padding:.35rem .6rem;border-radius:.5rem;font-weight:600;">$0.00</div>
          <div id="modalUnit" class="text-muted fw-semibold">/PC</div>
        </div>

        <p id="modalDesc" class="text-muted"></p>

        <div class="text-muted small d-flex align-items-center gap-2 mb-3">
          <i class="bi bi-info-circle"></i><span>First image will be the default image.</span>
        </div>

        <img id="modalImage" src="" class="img-fluid rounded" style="max-height:180px;object-fit:cover;">
      </div>

      <div class="modal-footer">
        <button id="openEditBtn" type="button" class="btn btn-outline-secondary">
          <i class="bi bi-pencil"></i> Edit item
        </button>
        <a id="goToCartFromModal" href="cart.php" class="btn btn-primary">Go to checkout</a>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT ITEM MODAL (store) -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editFormStore" onsubmit="return false;">
          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10"><input id="editTitle" type="text" class="form-control"></div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <textarea id="editDesc" class="form-control" rows="4"></textarea>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Quantity</label>
            <div class="col-sm-4"><input id="editQty" type="number" class="form-control" min="1" value="1"></div>

            <label class="col-sm-2 col-form-label">Unit type</label>
            <div class="col-sm-4"><input id="editUnit" type="text" class="form-control" value="PC"></div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Rate</label>
            <div class="col-sm-4"><input id="editRate" type="number" class="form-control"></div>
            <div class="col-sm-6 d-flex align-items-center">
              <input id="editShow" type="checkbox" class="form-check-input">
              <label class="form-check-label ms-2">Show in client portal</label>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10 d-flex align-items-center gap-3">
              <img id="editPreview" src="" style="width:110px;height:70px;object-fit:cover;border:1px solid #e9ecef;" class="rounded">
              <input id="editImageInput" type="file" accept="image/*" class="form-control" style="max-width:320px;">
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button id="saveEditBtn" type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
      </div>
    </div>
  </div>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* Product list (initial) */
let products = [
  {id:1,name:"Logo Design",price:100,unit:"/PC",desc:"Logo design for your brand.",img:"assets/images/logo.jpg",category:"Design", added:false},
  {id:2,name:"10GB Hosting",price:100,unit:"/PC",desc:"Cloud Hosting service 10GB space.",img:"assets/images/hosting.jpg",category:"Hosting", added:false},
  {id:3,name:"Art Pictures",price:40,unit:"/PC",desc:"Hand art pictures for your website.",img:"assets/images/art.jpg",category:"Design", added:false},
  {id:4,name:"Content Writing",price:15,unit:"/Hour",desc:"We write content for different types.",img:"assets/images/content.jpg",category:"Writing", added:false},
  {id:5,name:"Custom App Development",price:1000,unit:"/PC",desc:"Custom app development services.",img:"assets/images/CAD.png",category:"Design", added:false},
  {id:6,name:"Domain .com",price:11,unit:"/PC",desc:"Get your .com domain instantly.",img:"assets/images/domain.webp",category:"Hosting", added:false},
  {id:7,name:"SEO",price:10,unit:"/Hour",desc:"Boost search rankings for your site.",img:"assets/images/seo.jpg",category:"SEO", added:false},
  {id:8,name:"Website Design",price:20,unit:"/Hour",desc:"Website design for personal use.",img:"assets/images/web design.avif",category:"Design", added:false}
];

const $ = id => document.getElementById(id);

/* localStorage helpers */
function loadSavedCart() {
  const saved = JSON.parse(localStorage.getItem('cart') || '[]');
  return Array.isArray(saved) ? saved : [];
}
function saveCartToStorage(arr) {
  localStorage.setItem('cart', JSON.stringify(arr));
}

/* merge saved cart into products (mark added and prefer saved data) */
function mergeSaved() {
  const saved = loadSavedCart();
  if(!saved.length) return;
  saved.forEach(s => {
    const p = products.find(x=>x.id===s.id);
    if(p) {
      p.added = true;
      // keep local product data but prefer saved fields for edits
      p.name = s.name || p.name;
      p.price = s.price || p.price;
      p.unit = s.unit || p.unit;
      p.desc = s.desc || p.desc;
      p.img = s.img || p.img;
    } else {
      // if new product in saved, optionally ignore or push
    }
  });
}

/* create single card (stable hover) */
function createCard(p){
  const col = document.createElement('div');
  col.className = 'col';
  col.dataset.category = p.category;
  col.dataset.name = p.name.toLowerCase();

  const card = document.createElement('div');
  card.className = 'card border-0 shadow-sm h-100';

  const wrap = document.createElement('div');
  wrap.className = 'position-relative overflow-hidden';

  const img = document.createElement('img');
  img.src = p.img;
  img.alt = p.name;
  img.className = 'card-img-top';
  img.style.cssText = 'height:200px;width:100%;object-fit:cover;display:block;transition:transform .22s ease;';

  const overlay = document.createElement('div');
  overlay.className = 'position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25';
  overlay.style.cssText = 'opacity:0;visibility:hidden;pointer-events:none;transition:opacity .18s ease;';

  const bottom = document.createElement('div');
  bottom.className = 'position-absolute bottom-0 start-0 end-0 d-flex justify-content-between align-items-center p-3';

  const btnCart = document.createElement('button');
  btnCart.className = p.added ? 'btn btn-success d-flex align-items-center gap-2' : 'btn btn-primary d-flex align-items-center gap-2';
  btnCart.innerHTML = p.added ? '<i class="bi bi-check-lg"></i> Added to cart' : '<i class="bi bi-cart"></i> Add to cart';
  btnCart.disabled = !!p.added;
  btnCart.onclick = function(e){
    e.stopPropagation();
    p.added = true;
    btnCart.innerHTML = '<i class="bi bi-check-lg"></i> Added to cart';
    btnCart.className = 'btn btn-success d-flex align-items-center gap-2';
    btnCart.disabled = true;
    // update storage: push product with qty=1 if not exists
    const cart = loadSavedCart();
    const exists = cart.find(x=>x.id===p.id);
    if(!exists) {
      cart.push({ id:p.id, name:p.name, price:p.price, unit:p.unit, desc:p.desc, img:p.img, category:p.category, qty:1 });
      saveCartToStorage(cart);
    }
  };

  const btnEye = document.createElement('button');
  btnEye.className = 'btn btn-light';
  btnEye.innerHTML = '<i class="bi bi-eye"></i>';
  btnEye.onclick = function(e){
    e.stopPropagation();
    openQuickView(p.id);
  };

  bottom.appendChild(btnCart);
  bottom.appendChild(btnEye);
  overlay.appendChild(bottom);

  wrap.appendChild(img);
  wrap.appendChild(overlay);

  wrap.addEventListener('mouseenter', ()=>{
    overlay.style.pointerEvents = 'auto';
    overlay.style.visibility = 'visible';
    requestAnimationFrame(()=> overlay.style.opacity = '1');
    img.style.transform = 'translateZ(0) scale(1.05)';
  });
  wrap.addEventListener('mouseleave', ()=>{
    overlay.style.opacity = '0';
    setTimeout(()=>{ overlay.style.visibility = 'hidden'; overlay.style.pointerEvents = 'none'; }, 180);
    img.style.transform = 'translateZ(0) scale(1)';
  });

  const body = document.createElement('div');
  body.className = 'card-body';
  body.innerHTML = `
    <h6 class="fw-semibold mb-1">${p.name}</h6>
    <p class="text-danger fw-semibold mb-1">$${p.price.toFixed(2)} <small class="text-dark">${p.unit}</small></p>
    <p class="text-muted small mb-0">${p.desc}</p>
  `;

  card.appendChild(wrap);
  card.appendChild(body);
  col.appendChild(card);
  return col;
}

/* render grid */
function renderGrid(){
  mergeSaved();
  const grid = $('productGrid');
  grid.innerHTML = '';
  products.forEach(p => {
    grid.appendChild(createCard(p));
  });
}

/* quick view + edit flow */
const quickModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
const editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
let currentProductId = null;

function openQuickView(id){
  const p = products.find(x=>x.id===id);
  if(!p) return;
  currentProductId = id;
  $('modalTitle').textContent = p.name;
  $('modalPrice').textContent = '$' + p.price.toFixed(2);
  $('modalUnit').textContent = p.unit;
  $('modalDesc').textContent = p.desc;
  $('modalImage').src = p.img;
  quickModal.show();
}

/* open edit from quick view */
$('openEditBtn').addEventListener('click', ()=>{
  if(currentProductId === null) return;
  const p = products.find(x=>x.id===currentProductId);
  if(!p) return;
  $('editTitle').value = p.name;
  $('editDesc').value = p.desc || '';
  $('editQty').value = 1;
  $('editUnit').value = p.unit ? p.unit.replace('/','') : '';
  $('editRate').value = p.price;
  $('editShow').checked = false;
  $('editPreview').src = p.img || '';
  $('editImageInput').value = '';
  quickModal.hide();
  editModal.show();
});

/* image preview */
$('editImageInput').addEventListener('change', function(){
  const f = this.files && this.files[0];
  if(!f) return;
  const r = new FileReader();
  r.onload = ev => $('editPreview').src = ev.target.result;
  r.readAsDataURL(f);
});

/* save edit in store (also update localStorage cart if item already added) */
$('saveEditBtn').addEventListener('click', ()=>{
  if(currentProductId === null) return;
  const p = products.find(x=>x.id===currentProductId);
  if(!p) return;
  p.name = $('editTitle').value || p.name;
  p.desc = $('editDesc').value;
  p.unit = $('editUnit').value ? '/' + $('editUnit').value : p.unit;
  p.price = parseFloat($('editRate').value) || p.price;
  p.img = $('editPreview').src || p.img;

  // if this item exists in localStorage cart, update it too
  const cart = loadSavedCart();
  const idx = cart.findIndex(x=>x.id === p.id);
  if(idx !== -1) {
    cart[idx].name = p.name;
    cart[idx].desc = p.desc;
    cart[idx].unit = p.unit;
    cart[idx].price = p.price;
    cart[idx].img = p.img;
    saveCartToStorage(cart);
  }

  renderGrid();
  editModal.hide();
});

/* search & category filter */
$('searchInput').addEventListener('input', ()=>{
  const q = $('searchInput').value.trim().toLowerCase();
  document.querySelectorAll('#productGrid .col').forEach(col=>{
    const ok = col.dataset.name.includes(q);
    col.style.display = ok ? '' : 'none';
  });
});
$('categorySelect').addEventListener('change', ()=>{
  const cat = $('categorySelect').value;
  document.querySelectorAll('#productGrid .col').forEach(col=>{
    if(cat === 'all') col.style.display = '';
    else col.style.display = (col.dataset.category === cat) ? '' : 'none';
  });
});

/* checkout button */
$('checkoutBtn').addEventListener('click', ()=> {
  window.location.href = 'cart.php';
});

/* init */
renderGrid();
</script>

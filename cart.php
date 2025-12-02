<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">
    <?php include 'common/topnavbar.php'; ?>

    <div class="container py-4">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Process Order</h4>
          <p class="text-muted">You are about to create the order. Please check details before submitting.</p>

          <!-- table -->
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th style="width:40px;"></th>
                  <th>Item</th>
                  <th style="width:120px;text-align:center;">Quantity</th>
                  <th style="width:140px;text-align:right;">Rate</th>
                  <th style="width:140px;text-align:right;">Total</th>
                  <th style="width:120px;text-align:center;">Actions</th>
                </tr>
              </thead>
              <tbody id="cartTbody"></tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
              <a href="store.php" class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i> Find more items</a>
            </div>
            <div style="min-width:360px;">
              <div class="d-flex justify-content-between border-top pt-3">
                <div class="text-end pe-3">Sub Total</div>
                <div id="subTotal" class="fw-semibold">$0.00</div>
              </div>
              <div class="d-flex justify-content-between bg-light py-3 mt-2">
                <div class="text-end pe-3 fw-semibold">Total</div>
                <div id="grandTotal" class="fw-semibold">$0.00</div>
              </div>
            </div>
          </div>

          <!-- client + note -->
          <div class="row mt-4">
            <div class="col-md-3">
              <label class="form-label">Client</label>
              <select id="clientSelect" class="form-select">
                <option>Client</option>
                <option>Client A</option>
                <option>Client B</option>
              </select>
            </div>

            <div class="col-md-9">
              <label class="form-label">Note</label>
              <textarea id="orderNote" class="form-control" rows="3" placeholder="Note"></textarea>
            </div>
          </div>

          <!-- footer -->
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              <button class="btn btn-outline-secondary"><i class="bi bi-upload"></i> Upload File</button>
              <button class="btn btn-outline-secondary ms-2"><i class="bi bi-mic"></i></button>
            </div>
            <div>
              <button id="placeOrderBtn" class="btn btn-primary"><i class="bi bi-check2-circle"></i> Place order</button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>


<!-- EDIT MODAL (cart page) -->
<div class="modal fade" id="editItemModalCart" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editFormCart" onsubmit="return false;">
          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10"><input id="editTitleCart" type="text" class="form-control"></div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <textarea id="editDescCart" class="form-control" rows="4"></textarea>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Quantity</label>
            <div class="col-sm-4"><input id="editQtyCart" type="number" class="form-control" min="1" value="1"></div>

            <label class="col-sm-2 col-form-label">Unit type</label>
            <div class="col-sm-4"><input id="editUnitCart" type="text" class="form-control" value="PC"></div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Rate</label>
            <div class="col-sm-4"><input id="editRateCart" type="number" class="form-control"></div>
            <div class="col-sm-6 d-flex align-items-center">
              <input id="editShowCart" type="checkbox" class="form-check-input">
              <label class="form-check-label ms-2">Show in client portal</label>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10 d-flex align-items-center gap-3">
              <img id="editPreviewCart" src="" style="width:110px;height:70px;object-fit:cover;border:1px solid #e9ecef;" class="rounded">
              <input id="editImageInputCart" type="file" accept="image/*" class="form-control" style="max-width:320px;">
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button id="saveEditBtnCart" type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
      </div>
    </div>
  </div>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const $ = id => document.getElementById(id);

/* load cart from localStorage */
function loadCart() {
  const arr = JSON.parse(localStorage.getItem('cart') || '[]');
  return Array.isArray(arr) ? arr : [];
}
function saveCart(arr) { localStorage.setItem('cart', JSON.stringify(arr)); }

/* format currency */
function fmt(n){ return '$' + Number(n).toFixed(2); }

/* render cart table */
function renderCartTable() {
  const cart = loadCart();
  const tbody = $('cartTbody');
  tbody.innerHTML = '';

  if(!cart.length) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No items in cart. <a href="store.php">Add items</a></td></tr>';
    $('subTotal').textContent = fmt(0);
    $('grandTotal').textContent = fmt(0);
    return;
  }

  let subtotal = 0;
  cart.forEach((p, idx) => {
    const total = (p.qty || 1) * (p.price || 0);
    subtotal += total;

    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td class="text-center"><i class="bi bi-list" style="opacity:.6"></i></td>
      <td>${p.name}</td>
      <td class="text-center">${(p.qty||1)} ${p.unit ? p.unit.replace('/','') : ''}</td>
      <td class="text-end">${fmt(p.price)}</td>
      <td class="text-end">${fmt(total)}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-outline-secondary btn-edit me-1" data-id="${p.id}" title="Edit"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger btn-del" data-id="${p.id}" title="Remove"><i class="bi bi-x"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });

  $('subTotal').textContent = fmt(subtotal);
  $('grandTotal').textContent = fmt(subtotal);
  attachRowActions();
}

/* attach edit/delete actions */
function attachRowActions() {
  document.querySelectorAll('.btn-edit').forEach(btn=>{
    btn.addEventListener('click', function(){
      const id = parseInt(this.dataset.id,10);
      openEditCart(id);
    });
  });
  document.querySelectorAll('.btn-del').forEach(btn=>{
    btn.addEventListener('click', function(){
      const id = parseInt(this.dataset.id,10);
      deleteFromCart(id);
    });
  });
}

/* delete */
function deleteFromCart(id) {
  let cart = loadCart();
  cart = cart.filter(x=>x.id !== id);
  saveCart(cart);
  renderCartTable();
}

/* edit modal (cart) */
const editModal = new bootstrap.Modal(document.getElementById('editItemModalCart'));
let currentEditId = null;
function openEditCart(id) {
  const cart = loadCart();
  const p = cart.find(x=>x.id === id);
  if(!p) return;
  currentEditId = id;
  $('editTitleCart').value = p.name || '';
  $('editDescCart').value = p.desc || '';
  $('editQtyCart').value = p.qty || 1;
  $('editUnitCart').value = p.unit ? p.unit.replace('/','') : '';
  $('editRateCart').value = p.price || 0;
  $('editShowCart').checked = !!p.show;
  $('editPreviewCart').src = p.img || '';
  $('editImageInputCart').value = '';
  editModal.show();
}

/* image preview */
$('editImageInputCart').addEventListener('change', function(){
  const f = this.files && this.files[0];
  if(!f) return;
  const fr = new FileReader();
  fr.onload = ev => $('editPreviewCart').src = ev.target.result;
  fr.readAsDataURL(f);
});

/* save edited cart item */
$('saveEditBtnCart').addEventListener('click', function(){
  if(currentEditId === null) return;
  const cart = loadCart();
  const idx = cart.findIndex(x=>x.id === currentEditId);
  if(idx === -1) return;
  cart[idx].name = $('editTitleCart').value || cart[idx].name;
  cart[idx].desc = $('editDescCart').value || cart[idx].desc;
  cart[idx].qty = parseInt($('editQtyCart').value,10) || 1;
  cart[idx].unit = $('editUnitCart').value ? ('/' + $('editUnitCart').value) : cart[idx].unit;
  cart[idx].price = parseFloat($('editRateCart').value) || cart[idx].price;
  cart[idx].show = !!$('editShowCart').checked;
  cart[idx].img = $('editPreviewCart').src || cart[idx].img;
  saveCart(cart);
  editModal.hide();
  renderCartTable();
});

/* place order (demo) */
$('placeOrderBtn').addEventListener('click', function(){
  const cart = loadCart();
  if(!cart.length) {
    alert('No items to place order.');
    return;
  }
  // For demo: clear cart and show success
  alert('Order placed. (Demo) — cart cleared.');
  localStorage.removeItem('cart');
  renderCartTable();
});

/* init */
renderCartTable();
</script>

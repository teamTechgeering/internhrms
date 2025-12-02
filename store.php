<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

<!-- TOP BAR -->
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold">Store</h4>

        <div class="d-flex align-items-center gap-3">
            <select class="form-select" style="width:150px;">
                <option>- Category -</option>
                <option>Design</option>
                <option>Hosting</option>
                <option>Writing</option>
                <option>SEO</option>
            </select>

            <div class="input-group" style="width:200px;">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- GRID -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

        <!-- CARD TEMPLATE (use same structure for all cards) -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/logo.jpg"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Logo Design</h6>
                    <p class="text-danger fw-semibold mb-1">$100.00 <small class="text-dark">/PC</small></p>
                    <p class="text-muted small mb-0">Logo design for your brand.</p>
                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/hosting.jpg"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">10GB Hosting</h6>
                    <p class="text-danger fw-semibold mb-1">$100.00 <small class="text-dark">/PC</small></p>
                    <p class="text-muted small mb-0">Cloud Hosting service 10GB Space.</p>
                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/art.jpg"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Art pictures</h6>
                    <p class="text-danger fw-semibold mb-1">$40.00 <small class="text-dark">/PC</small></p>
                    <p class="text-muted small mb-0">Hand art pictures for your website.</p>
                </div>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/content.jpg"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Content writing</h6>
                    <p class="text-danger fw-semibold mb-1">$15.00 <small class="text-dark">/Hour</small></p>
                    <p class="text-muted small mb-0">We write content for different types.</p>
                </div>
            </div>
        </div>

        <!-- CARD 5 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/CAD.png"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Custom app development</h6>
                    <p class="text-danger fw-semibold mb-1">$1,000.00 <small class="text-dark">/PC</small></p>
                    <p class="text-muted small mb-0">Custom app development services.</p>
                </div>
            </div>
        </div>

        <!-- CARD 6 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/domain.webp"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Domain .com</h6>
                    <p class="text-danger fw-semibold mb-1">$11.00 <small class="text-dark">/PC</small></p>
                    <p class="text-muted small mb-0">Get your .com domain instantly.</p>
                </div>
            </div>
        </div>

        <!-- CARD 7 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/seo.jpg"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">SEO</h6>
                    <p class="text-danger fw-semibold mb-1">$10.00 <small class="text-dark">/Hour</small></p>
                    <p class="text-muted small mb-0">Boost search rankings for your site.</p>
                </div>
            </div>
        </div>

        <!-- CARD 8 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <img src="assets/images/web design.avif"
                     class="card-img-top object-fit-cover"
                     style="height:200px;" />

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Website Design</h6>
                    <p class="text-danger fw-semibold mb-1">$20.00 <small class="text-dark">/Hour</small></p>
                    <p class="text-muted small mb-0">Website design for personal use.</p>
                </div>
            </div>
        </div>

    </div>
</div>

</div><!-- content -->
</div><!-- content-page -->

<?php include 'common/footer.php'; ?>

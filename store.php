<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

    <?php include 'common/topnavbar.php'; ?>

<div class="container py-4">

    <!-- TOP BAR -->
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
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>
        </div>
    </div>

    <!-- PRODUCT GRID -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

        <!-- CARD TEMPLATE FUNCTION -->
        <!-- REPEAT THIS BLOCK FOR EACH CARD -->

        <!-- CARD 1 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/logo.jpg"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

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
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/hosting.jpg"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">10GB Hosting</h6>
                    <p class="text-danger fw-semibold mb-1">$100.00 <small>/PC</small></p>
                    <p class="text-muted small mb-0">Cloud Hosting service 10GB space.</p>
                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/art.jpg"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Art Pictures</h6>
                    <p class="text-danger fw-semibold mb-1">$40.00 <small>/PC</small></p>
                    <p class="text-muted small mb-0">Hand art pictures for your website.</p>
                </div>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/content.jpg"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Content Writing</h6>
                    <p class="text-danger fw-semibold mb-1">$15.00 <small>/Hour</small></p>
                    <p class="text-muted small mb-0">We write content for different types.</p>
                </div>
            </div>
        </div>

        <!-- CARD 5 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/CAD.png"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Custom App Development</h6>
                    <p class="text-danger fw-semibold mb-1">$1,000.00 <small>/PC</small></p>
                    <p class="text-muted small mb-0">Custom app development services.</p>
                </div>
            </div>
        </div>

        <!-- CARD 6 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/domain.webp"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Domain .com</h6>
                    <p class="text-danger fw-semibold mb-1">$11.00 <small>/PC</small></p>
                    <p class="text-muted small mb-0">Get your .com domain instantly.</p>
                </div>
            </div>
        </div>

        <!-- CARD 7 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/seo.jpg"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">SEO</h6>
                    <p class="text-danger fw-semibold mb-1">$10.00 <small>/Hour</small></p>
                    <p class="text-muted small mb-0">Boost search rankings for your site.</p>
                </div>
            </div>
        </div>

        <!-- CARD 8 -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative overflow-hidden"
                     onmouseover="this.querySelector('.hover-tools').style.display='block'"
                     onmouseout="this.querySelector('.hover-tools').style.display='none'">

                    <img src="assets/images/web design.avif"
                         class="card-img-top object-fit-cover"
                         style="height:200px;">

                    <div class="hover-tools position-absolute top-0 start-0 w-100 h-100 
                        bg-dark bg-opacity-25 p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-end h-100">
                            <button class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="bi bi-cart"></i> Add to cart
                            </button>

                            <button class="btn btn-light">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Website Design</h6>
                    <p class="text-danger fw-semibold mb-1">$20.00 <small>/Hour</small></p>
                    <p class="text-muted small mb-0">Website design for personal use.</p>
                </div>
            </div>
        </div>

    </div>
</div>

</div><!-- content -->
</div><!-- content-page -->

<?php include 'common/footer.php'; ?>

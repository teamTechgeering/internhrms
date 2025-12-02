<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 26;
$autoPrint = isset($_GET['print']) || isset($_GET['pdf']) || isset($_GET['download']);
?>

<div class="container py-3">

    <!-- CLOSE PREVIEW BUTTON -->
    <div class="text-center mb-3">
        <button class="btn btn-outline-secondary" onclick="window.close()">Close Preview</button>
    </div>

    <!-- INVOICE WRAPPER -->
    <div class="mx-auto bg-white p-4 rounded shadow-sm" style="max-width: 1000px;">

        <!-- CANCELLED RIBBON (Bootstrap only) -->
        <div class="position-relative mb-3">
            <div class="position-absolute top-0 start-0 translate-middle-y bg-danger text-white px-4 py-1 fw-bold"
                 style="transform: rotate(-45deg) translate(-40px, -20px);">
                Cancelled
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="row">
            <div class="col-md-6">

                <img src="assets/images/tech-logo21.webp" class="img-fluid mb-2" style="max-height: 80px;">

                <p class="fw-semibold mb-1">Awesome Demo Company</p>
                <p class="mb-1">86935 Greenholt Forges</p>
                <p class="mb-1">Florida, 5626</p>
                <p class="mb-1">Phone: +12345678888</p>
                <p class="mb-1">Email: info@demo.company</p>
                <p class="mb-1">Website: https://fairsketch.com</p>
            </div>

            <div class="col-md-6 text-end">

                <span class="bg-dark text-white px-3 py-1 fw-bold d-inline-block">
                    ESTIMATE #<?php echo $id; ?>
                </span>

                <p class="mt-3 mb-1">Bill date: 18-10-2025</p>
                <p class="mb-3">Due date: 01-11-2025</p>

                <p class="fw-bold mb-1">Bill To</p>
                <p class="mb-1">Adrain Ondricka</p>
                <p class="mb-1">308 Thad Row</p>
                <p class="mb-1">Lake Macmouth</p>
                <p class="mb-1">Tennessee</p>
                <p class="mb-1">Andorra</p>

            </div>
        </div>

        <hr>

        <!-- ITEMS TABLE -->
        <h6 class="fw-bold mb-3">Items</h6>

        <div class="table-responsive mb-3">
            <table class="table">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            Custom app development<br>
                            <small class="text-muted">App for your business</small>
                        </td>
                        <td>2 PC</td>
                        <td>$1,000.00</td>
                        <td>$2,000.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- TOTALS -->
        <div class="row justify-content-end">
            <div class="col-md-4">

                <table class="table">
                    <tr>
                        <td>Sub Total</td>
                        <td class="text-end">$2,000.00</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Balance Due</td>
                        <td class="fw-semibold text-end">$2,000.00</td>
                    </tr>
                </table>

            </div>
        </div>

    </div><!-- wrapper end -->

</div><!-- container -->

<?php include 'common/footer.php'; ?>

<script>
// AUTO PRINT HANDLER
(function() {
    const auto = <?php echo $autoPrint ? 'true' : 'false'; ?>;

    if (auto) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                window.print();

                <?php if (isset($_GET['download'])): ?>
                setTimeout(() => { window.close(); }, 500);
                <?php endif; ?>
            }, 400);
        });
    }
})();
</script>


<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">

<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$autoPrint = isset($_GET['print']) || isset($_GET['pdf']) || isset($_GET['download']);
?>

<div class="container py-3">

    <!-- CLOSE PREVIEW BUTTON -->
    <div class="text-center mb-3">
        <button class="btn btn-outline-secondary" onclick="window.close()">Close Preview</button>
    </div>

    <!-- INVOICE WRAPPER -->
   
            <!-- MAIN PROPOSAL BODY -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">
                    <button class="btn btn-light btn-sm"><i class="fa-solid fa-circle-check"></i> Proposal Accepted
</button>
                
                </div>

                <div class="card-body">
                    <div id="editorToolbar" class="mb-2">
                        <!-- WYSIWYG Tools here (icons) -->
                    </div>

                    <div id="proposalContent" class="p-3" style="min-height:300px; background:#fff;">
                        <h2>Web Design Proposal</h2>
                        <img src="assets/images/notebook.png" class="img-fluid mb-3">
                        <p>In response to the growing demands...</p>

                        <h3>Our Best Offer</h3>
                        <p>We aim to deliver best value...</p>

                        <h3>Our Objective</h3>
                        <img src="assets/images/home4.png" class="img-fluid mb-3">
                        <p>Our objective is to align...</p>

                        <h3>Our Portfolio</h3>
                        <img src="assets/images/content.jpg" class="img-fluid mb-3">

                        <h3 class="mt-4">Let's Connect</h3>
                        <p>We are excited about the chance to collaborate...</p>
                    </div>

                    
                </div>
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
</body>
</html>


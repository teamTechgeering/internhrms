<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<?php
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$autoPrint = isset($_GET["print"]) || isset($_GET["pdf"]) || isset($_GET["download"]);
?>

<div class="content-page">
<div class="content">

<div class="container py-3" id="previewContainer">

    <!-- CLOSE PREVIEW BUTTON -->
    <div class="text-center mb-3">
        <button class="btn btn-outline-secondary" onclick="window.close()">Close Preview</button>
    </div>

    <!-- CONTRACT WRAPPER -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">
            <button class="btn btn-light btn-sm" id="statusBadge">
                <i class="fa-solid fa-circle-check"></i> Status
            </button>
        </div>

        <div class="card-body">

            <!-- MAIN CONTENT -->
            <div id="contractContent" class="p-3" style="min-height:300px; background:#fff;">
                <!-- Filled by JS -->
            </div>

        </div>
    </div>

</div><!-- container end -->

</div>
</div>

<?php include 'common/footer.php'; ?>

<script>
/*******************************************************
    CONTRACT PREVIEW PAGE (contract_preview.php)
    Fetch contract by ID → Render → Handle print
*******************************************************/

document.addEventListener("DOMContentLoaded", () => {

    const params = new URLSearchParams(window.location.search);
    const contractId = Number(params.get("id")) || 0;
    const auto = <?php echo $autoPrint ? "true" : "false"; ?>;

    let contracts = [];
    let contract = null;

    // Load JSON + localStorage merged
    function loadContracts() {
        return fetch("contract_json.php")
            .then(res => res.json())
            .then(initial => {
                const saved = JSON.parse(localStorage.getItem("contracts_storage_v1") || "[]");

                const map = new Map();
                initial.forEach(i => map.set(i.id, i));
                saved.forEach(s => map.set(s.id, s)); // saved overrides JSON

                contracts = Array.from(map.values());
                contract = contracts.find(c => c.id === contractId);
            });
    }

    function renderPreview() {

        if (!contract) {
            document.getElementById("previewContainer").innerHTML =
                "<div class='alert alert-danger'>Contract not found.</div>";
            return;
        }

        // STATUS BADGE
        const badge = document.getElementById("statusBadge");
        badge.innerHTML = `
            <i class="fa-solid fa-circle-check"></i> ${contract.status}
        `;
        badge.className = `btn btn-sm btn-${contract.status_color || "secondary"}`;

        // ITEMS
        let itemsHtml = "";
        let subtotal = 0;

        let items = contract.items;

        // fallback if contract has no items stored
        if (!Array.isArray(items) || items.length === 0) {
            items = [{
                name: contract.title || "Service",
                desc: "Service included",
                qty: 1,
                rate: Number(contract.amount) || 0
            }];
        }

        items.forEach(it => {
            const qty = Number(it.qty || 0);
            const rate = Number(it.rate || 0);
            const total = qty * rate;
            subtotal += total;

            itemsHtml += `
                <tr>
                    <td><b>${it.name}</b><br><small>${it.desc || ""}</small></td>
                    <td>${qty} PC</td>
                    <td>$${rate.toFixed(2)}</td>
                    <td>$${total.toFixed(2)}</td>
                </tr>
            `;
        });

        // LONG BODY TEMPLATE
        const longHTML = contract.content_html || `
            <h2>${contract.title}</h2>
            <p>This contract outlines the agreed services between <b>${contract.client}</b> and your company.</p>

            <h4>Service Overview</h4>
            <p>Details of work and expectations...</p>

            <h4>Terms</h4>
            <p>All standard terms and policies apply.</p>
        `;

        // RENDER FINAL PREVIEW
        document.getElementById("contractContent").innerHTML = `

            <h4 class="fw-bold mb-3">${contract.contract_no}</h4>
            <p class="text-muted">Contract Date: ${contract.contract_date}</p>
            <p class="text-muted">Valid Until: ${contract.valid_until}</p>
            <hr>

            <h5 class="fw-semibold">Client Details</h5>
            <p><b>${contract.client}</b></p>
            <hr>

            <h5 class="fw-semibold">Contract Items</h5>
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Item</th><th>Qty</th><th>Rate</th><th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemsHtml}
                </tbody>
            </table>

            <h5 class="text-end mt-3">Subtotal: $${subtotal.toFixed(2)}</h5>
            <h4 class="text-end fw-bold">Total: $${subtotal.toFixed(2)}</h4>

            <hr>

            <div class="mt-4">
                ${longHTML}
            </div>
        `;
    }

    // Auto print handler
    function autoPrintTrigger() {
        if (!auto) return;

        window.addEventListener("load", () => {
            setTimeout(() => {
                window.print();

                // auto-close after saving PDF
                <?php if (isset($_GET["download"])): ?>
                    setTimeout(() => { window.close(); }, 600);
                <?php endif; ?>

            }, 400);
        });
    }

    loadContracts().then(() => {
        renderPreview();
        autoPrintTrigger();
    });

});
</script>

</body>
</html>

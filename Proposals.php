<?php include 'common/header.php'; ?>

<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
  <div class="content">

   <?php include 'common/topnavbar.php'; ?>

    <!-- ✅ ✅ ✅ YOUR FULL CONTENT AREA STARTS HERE (UNCHANGED) -->
 <div class="container-fluid p-4">

    <h4>Proposals</h4>

    <!-- FILTER BAR -->
    <div class="d-flex align-items-center gap-2 my-3">

        <button class="btn btn-outline-secondary" data-status="all">All</button>
        <button class="btn btn-outline-secondary" data-status="Accepted">Accepted</button>
        <button class="btn btn-outline-secondary" data-status="Draft">Draft</button>
        <button class="btn btn-outline-secondary" data-status="Declined">Declined</button>

        <div class="ms-auto d-flex gap-2">

            <button class="btn btn-outline-secondary" id="excelBtn">Excel</button>
            <button class="btn btn-outline-secondary" id="printBtn">Print</button>

            <input type="text" id="search" class="form-control" placeholder="Search" style="width:200px">

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProposalModal">
                Add proposal
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <table class="table table-hover bg-white border rounded">
        <thead>
            <tr>
                <th>Proposal</th>
                <th>Client</th>
                <th>Proposal date</th>
                <th>Valid until</th>
                <th>Amount</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="proposalTable"></tbody>
    </table>

</div>


<!-- ADD PROPOSAL MODAL -->
<div class="modal fade" id="addProposalModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add proposal</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Proposal date</label>
                        <input id="pDate" type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Valid until</label>
                        <input id="pValid" type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Client/Lead</label>
                        <select id="pClient" class="form-select">
                            <option>Jane Hand</option>
                            <option>Demo Client</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Status</label>
                        <select id="pStatus" class="form-select">
                            <option>Accepted</option>
                            <option>Draft</option>
                            <option>Declined</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label>Note</label>
                        <textarea id="pNote" class="form-control"></textarea>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="addProposal()">Save</button>
            </div>

        </div>
    </div>
</div>
         
        
      </div>  <!-- CLOSE .content -->
    </div>    <!-- CLOSE .content-page -->


<?php include 'common/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/proposals.js"></script>
</body>
</html>
</body>
</html>

<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<!-- ================= MODULE BUTTONS ================= -->
<div class="container-fluid mb-3">
    <div class="d-flex gap-2 align-items-center py-2">

        <!-- SALES -->
        <div class="dropdown">
            <button class="btn btn-light d-flex align-items-center gap-2 dropdown-toggle"
                    data-bs-toggle="dropdown">
                🛒 <span>Sales</span>
            </button>

            <ul class="dropdown-menu shadow">
                <li>
                    <a class="dropdown-item"
                       href="javascript:void(0)"
                       onclick="openTab('sales-invoice-summary','Invoices summary')">
                        Invoices summary
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="javascript:void(0)"
                       onclick="openTab('sales-invoice-details','Invoice details')">
                        Invoice details
                    </a>
                </li>
            </ul>
        </div>

        <!-- FINANCE -->
        <div class="dropdown">
            <button class="btn btn-light d-flex align-items-center gap-2 dropdown-toggle"
                    data-bs-toggle="dropdown">
                📊 <span>Finance</span>
            </button>

            <ul class="dropdown-menu shadow">
                <li>
                    <a class="dropdown-item"
                       href="javascript:void(0)"
                       onclick="openTab('finance-income-expense','Income vs Expenses')">
                        Income vs Expenses
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="javascript:void(0)"
                       onclick="openTab('finance-expense-summary','Expenses summary')">
                        Expenses summary
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="javascript:void(0)"
                       onclick="openTab('finance-payment-summary','Payments Summary')">
                        Payments Summary
                    </a>
                </li>
            </ul>
        </div>

        <!-- OTHERS -->
        <button class="btn btn-light d-flex align-items-center gap-2 px-3"
                onclick="openTab('timesheets','Timesheets')">
            ⏱ <span>Timesheets</span>
        </button>

        <button class="btn btn-light d-flex align-items-center gap-2 px-3"
                onclick="openTab('projects','Projects')">
            🧩 <span>Projects</span>
        </button>

        <button class="btn btn-light d-flex align-items-center gap-2 px-3"
                onclick="openTab('leads','Leads')">
            📂 <span>Leads</span>
        </button>

        <button class="btn btn-light d-flex align-items-center gap-2 px-3"
                onclick="openTab('tickets','Tickets')">
            🎫 <span>Tickets</span>
        </button>

    </div>
</div>

<!-- ================= APP TAB AREA ================= -->
<div class="container-fluid">

    <!-- TAB HEADER -->
    <ul class="nav nav-tabs mb-2" id="appTabs"></ul>

    <!-- TAB CONTENT -->
    <div class="tab-content border border-top-0 p-3 bg-white"
         id="appTabContent"></div>

</div>

</div>
</div>

<?php include 'common/footer.php'; ?>





<script>
/* =====================================================
   SINGLE TAB HANDLER
===================================================== */
function openTab(id, title) {
    const tabs = document.getElementById('appTabs');
    const content = document.getElementById('appTabContent');

    tabs.innerHTML = '';
    content.innerHTML = '';

    tabs.innerHTML = `
        <li class="nav-item">
            <button class="nav-link active">${title}</button>
        </li>
    `;

    content.innerHTML = getTabContent(id);

    if (id === 'sales-invoice-summary') initInvoiceSummary();
    if (id === 'sales-invoice-details') initInvoiceDetails();
    if (id === 'finance-income-expense') initFinanceIncomeExpense();
    if (id === 'finance-expense-summary') initExpenseSummary();
if (id === 'finance-payment-summary') initFinancePaymentSummary();
if (id === 'timesheets') initTimesheets();
if (id === 'tickets') initTicketStatistics();
if (id === 'projects') initProjectSummary();
if (id === "leads") initLeadsTeamSummary();


}

/* =====================================================
   TAB CONTENT
===================================================== */
function getTabContent(id) {

if (id === 'sales-invoice-summary') {
return `
<div class="card"><div class="card-body">

<div class="d-flex align-items-center gap-4 mb-3">
    <h5 class="mb-0 fw-semibold">Invoices summary</h5>
    <ul class="nav nav-tabs mb-0" id="invoiceTabs">
        <li class="nav-item"><button class="nav-link active" data-type="yearly">Yearly</button></li>
        <li class="nav-item"><button class="nav-link" data-type="monthly">Monthly</button></li>
        <li class="nav-item"><button class="nav-link" data-type="custom">Custom</button></li>
    </ul>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm" style="width:150px">
            <option>- Currency -</option>
        </select>
        <button class="btn btn-outline-secondary btn-sm">‹</button>
        <span class="fw-semibold">2025</span>
        <button class="btn btn-outline-secondary btn-sm">›</button>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="excelBtn">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printBtn">Print</button>
        <input class="form-control form-control-sm" id="search" placeholder="Search">
    </div>
</div>

<div class="table-responsive">
<table class="table align-middle">
<thead class="table-light">
<tr>
    <th>Client name</th>
    <th>Count</th>
    <th>Invoice total</th>
    <th>Discount</th>
    <th>TAX</th>
    <th>Second TAX</th>
    <th>TDS</th>
    <th>Payment Received</th>
    <th>Due</th>
</tr>
</thead>
<tbody id="tableBody"></tbody>
<tfoot class="table-light fw-bold">
<tr>
    <td>Total</td>
    <td id="tCount"></td>
    <td id="tInvoice"></td>
    <td>$0.00</td>
    <td>$0.00</td>
    <td>$0.00</td>
    <td>$0.00</td>
    <td id="tPaid"></td>
    <td id="tDue"></td>
</tr>
</tfoot>
</table>
</div>

<div class="d-flex justify-content-between pt-3">
    <span id="pageInfo"></span>
    <div class="btn-group btn-group-sm">
        <button class="btn btn-outline-secondary" id="prevPage">‹</button>
        <button class="btn btn-outline-secondary" id="nextPage">›</button>
    </div>
</div>

</div></div>`;
}

/* ===================== INVOICE DETAILS ===================== */
/* ===================== INVOICE DETAILS ===================== */
if (id === 'sales-invoice-details') {
return `
<div class="card"><div class="card-body">

<div class="d-flex align-items-center gap-4 mb-3">
    <h5 class="mb-0 fw-semibold">Invoice details</h5>
    <ul class="nav nav-tabs mb-0" id="detailTabs">
        <li class="nav-item"><button class="nav-link active">Yearly</button></li>
        <li class="nav-item"><button class="nav-link">Monthly</button></li>
        <li class="nav-item"><button class="nav-link">Custom</button></li>
    </ul>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2 align-items-center">

        <select class="form-select form-select-sm" style="width:150px">
            <option>- Currency -</option>
        </select>

        <!-- 🔥 MONTH CONTROLS -->
        <button class="btn btn-outline-secondary btn-sm" id="monthPrev">‹</button>
        <span class="fw-semibold" id="monthLabel"></span>
        <button class="btn btn-outline-secondary btn-sm" id="monthNext">›</button>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="excelDetails">Excel</button>
        <button class="btn btn-outline-secondary btn-sm" id="printDetails">Print</button>
        <input class="form-control form-control-sm" id="searchDetails" placeholder="Search">
    </div>
</div>

<div class="table-responsive">
<table class="table align-middle table-hover">
<thead class="table-light">
<tr>
    <th>Invoice ID</th>
    <th>Client</th>
    <th>Bill date</th>
    <th>Due date</th>
    <th>Invoice total</th>
    <th>Payment Received</th>
    <th>Due</th>
    <th>Status</th>
</tr>
</thead>
<tbody id="detailsBody"></tbody>
<tfoot class="table-light fw-bold">
<tr>
    <td colspan="4">Total</td>
    <td id="dTotal"></td>
    <td id="dPaid"></td>
    <td id="dDue"></td>
    <td></td>
</tr>
</tfoot>
</table>
</div>

<div class="d-flex justify-content-between pt-3">
    <span id="detailsPageInfo"></span>
    <div class="btn-group btn-group-sm">
        <button class="btn btn-outline-secondary" id="detailsPrev">‹</button>
        <button class="btn btn-outline-secondary" id="detailsNext">›</button>
    </div>
</div>

</div></div>`;
}

/* ===================== FINANCE INCOME VS EXPENSE ===================== */


    if (id === 'finance-income-expense') {
        return `
        <div class="card"><div class="card-body">

        <ul class="nav nav-tabs mb-3" id="financeTabs">
            <li class="nav-item">
                <button class="nav-link active" data-tab="chart">Chart</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="summary">Summary</button>
            </li>
        </ul>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2 align-items-center">
                <button class="btn btn-outline-secondary btn-sm" id="financePrev">‹</button>
                <span class="fw-semibold" id="financeYear"></span>
                <button class="btn btn-outline-secondary btn-sm" id="financeNext">›</button>
            </div>
        </div>

        <div id="financeChartWrap">
            <canvas id="incomeExpenseChart" height="120"></canvas>
        </div>

        <div id="financeSummaryWrap" class="d-none">
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>Month</th>
                <th>Income</th>
                <th>Expenses</th>
                <th>Profit</th>
            </tr>
        </thead>

        <tbody id="financeSummaryBody"></tbody>

        <!-- ✅ TOTAL ROW -->
        <tfoot class="table-light fw-bold">
            <tr>
                <td>Total</td>
                <td id="financeIncomeTotal">$0.00</td>
                <td id="financeExpenseTotal">$0.00</td>
                <td id="financeProfitTotal">$0.00</td>
            </tr>
        </tfoot>
    </table>
</div>


        </div></div>`;
    }
if (id === 'finance-expense-summary') {
return `
<div class="card">
  <div class="card-body">

    <!-- HEADER + TABS -->
    <div class="d-flex align-items-center gap-4 mb-3">
      <h5 class="mb-0 fw-semibold">Expenses summary</h5>

      <ul class="nav nav-tabs mb-0" id="expenseTabs">
        <li class="nav-item">
          <button class="nav-link active" data-type="yearly">Yearly</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-type="monthly">Monthly</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-type="custom">Custom</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-type="yearly-chart">Yearly Chart</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-type="category-chart">Category Chart</button>
        </li>
      </ul>
    </div>

    <!-- ================= TABLE VIEW ================= -->
    <div id="expenseTableWrap">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2 align-items-center">
          <button class="btn btn-outline-secondary btn-sm" id="expPrev">‹</button>
          <span class="fw-semibold" id="expLabel"></span>
          <button class="btn btn-outline-secondary btn-sm" id="expNext">›</button>
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm" id="expExcel">Excel</button>
          <button class="btn btn-outline-secondary btn-sm" id="expPrint">Print</button>
          <input class="form-control form-control-sm" id="expSearch" placeholder="Search">
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Category</th>
              <th>Amount</th>
              <th>TAX</th>
              <th>Second TAX</th>
              <th>Total</th>
            </tr>
          </thead>

          <tbody id="expBody"></tbody>

          <tfoot class="table-light fw-bold">
            <tr>
              <td>Total</td>
              <td id="expAmount"></td>
              <td>$0.00</td>
              <td>$0.00</td>
              <td id="expTotal"></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="d-flex justify-content-between pt-3">
        <span id="expPageInfo"></span>
        <div class="btn-group btn-group-sm">
          <button class="btn btn-outline-secondary" id="expPrevPage">‹</button>
          <button class="btn btn-outline-secondary" id="expNextPage">›</button>
        </div>
      </div>

    </div>

  <div id="expenseYearChartWrap" class="d-none">
  <center>
    <canvas id="expenseYearChart" width="360" height="200"></canvas>
  </center>
</div>

<div id="expenseCategoryChartWrap" class="d-none">
  <center>
    <canvas id="expenseCategoryChart" width="360" height="200"></canvas>
  </center>
</div>




  </div>
</div>


</div></div>`;
}
if (id === 'finance-payment-summary') {
return `
<div class="card"><div class="card-body">

<h5 class="fw-semibold mb-3">Payments Summary</h5>

<ul class="nav nav-tabs mb-3" id="paymentTabs">
  <li class="nav-item">
    <button class="nav-link active" data-tab="monthly">Monthly summary</button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-tab="clients">Clients summary</button>
  </li>
</ul>

<!-- FILTER BAR -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="d-flex gap-2 align-items-center">
    <select class="form-select form-select-sm" style="width:160px">
      <option>- Payment method -</option>
    </select>

    <button class="btn btn-outline-secondary btn-sm" id="payPrev">‹</button>
    <span class="fw-semibold" id="payYear"></span>
    <button class="btn btn-outline-secondary btn-sm" id="payNext">›</button>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm" id="payExcel">Excel</button>
    <button class="btn btn-outline-secondary btn-sm" id="payPrint">Print</button>
    <input class="form-control form-control-sm" id="paySearch" placeholder="Search">
  </div>
</div>

<!-- ================= MONTHLY SUMMARY ================= -->
<div id="monthlyWrap">

<table class="table align-middle">
<thead class="table-light">
<tr>
  <th>Month</th>
  <th class="text-end">Count</th>
  <th class="text-end">Amount</th>
</tr>
</thead>

<tbody id="monthlyBody"></tbody>

<tfoot class="table-light fw-bold">
<tr>
  <td>Total</td>
  <td class="text-end" id="mCount"></td>
  <td class="text-end" id="mAmount"></td>
</tr>
</tfoot>
</table>

<div class="d-flex justify-content-between pt-2">
  <span id="monthlyPageInfo"></span>
  <div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary" id="monthlyPrev">‹</button>
    <button class="btn btn-outline-secondary" id="monthlyNext">›</button>
  </div>
</div>

</div>

<!-- ================= CLIENTS SUMMARY ================= -->
<div id="clientsWrap" class="d-none">

<table class="table align-middle">
<thead class="table-light">
<tr>
  <th>Client</th>
  <th class="text-end">Count</th>
  <th class="text-end">Amount</th>
</tr>
</thead>

<tbody id="clientsBody"></tbody>

<tfoot class="table-light fw-bold">
<tr>
  <td>Total</td>
  <td class="text-end" id="cCount"></td>
  <td class="text-end" id="cAmount"></td>
</tr>
</tfoot>
</table>

<div class="d-flex justify-content-between pt-2">
  <span id="clientsPageInfo"></span>
  <div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary" id="clientsPrev">‹</button>
    <button class="btn btn-outline-secondary" id="clientsNext">›</button>
  </div>
</div>

</div>

</div></div>`;
}
if (id === 'timesheets') {
return `
<div class="card"><div class="card-body">

<div class="d-flex align-items-center gap-4 mb-3">
  <h5 class="mb-0 fw-semibold">Timesheets</h5>

  <ul class="nav nav-tabs mb-0" id="timesheetTabs">
    <li class="nav-item">
      <button class="nav-link active" data-tab="summary">Summary</button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-tab="chart">Chart</button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-tab="daily">Daily Activity</button>
    </li>
  </ul>
</div>

<!-- FILTER BAR -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="d-flex gap-2 align-items-center">
    <button class="btn btn-outline-secondary btn-sm" id="tsPrev">‹</button>
    <span class="fw-semibold" id="tsLabel"></span>
    <button class="btn btn-outline-secondary btn-sm" id="tsNext">›</button>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm">Excel</button>
    <button class="btn btn-outline-secondary btn-sm">Print</button>
    <input class="form-control form-control-sm" id="tsSearch" placeholder="Search">
  </div>
</div>

<!-- ================= SUMMARY ================= -->
<div id="tsSummaryWrap">

<table class="table align-middle">
<thead class="table-light">
<tr>
  <th>Project</th>
  <th>Task</th>
  <th>Member</th>
  <th>Start date</th>
  <th>End date</th>
  <th class="text-end">Hours</th>
</tr>
</thead>

<tbody id="tsBody"></tbody>

<tfoot class="table-light fw-bold">
<tr>
  <td colspan="5">Total</td>
  <td class="text-end" id="tsTotal"></td>
</tr>
</tfoot>
</table>


<div class="d-flex justify-content-between pt-2">
  <span id="tsPageInfo"></span>
  <div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary" id="tsPrevPage">‹</button>
    <button class="btn btn-outline-secondary" id="tsNextPage">›</button>
  </div>
</div>

</div>

<!-- ================= CHART ================= -->
<div id="tsChartWrap" class="d-none">
  <canvas id="tsChart" height="120"></canvas>
</div>

<!-- ================= DAILY ACTIVITY ================= -->
<div id="tsDailyWrap" class="d-none">
  <div class="table-responsive">
    <table class="table table-bordered text-center">
      <thead>
        <tr id="tsDailyHead"></tr>
      </thead>
      <tbody id="tsDailyBody"></tbody>
    </table>
  </div>
</div>


</div></div>`;
}
if (id === 'tickets') {
return `
<div class="card"><div class="card-body">

<div class="d-flex align-items-center gap-4 mb-3">
  <h5 class="mb-0 fw-semibold">Tickets</h5>

  <ul class="nav nav-tabs mb-0" id="ticketTabs">
    <li class="nav-item">
      <button class="nav-link active" data-tab="stats">Ticket Statistics</button>
    </li>
  </ul>
</div>

<!-- FILTER BAR -->
<div class="d-flex gap-2 align-items-center mb-3">
  <select class="form-select form-select-sm" style="width:180px">
    <option>- Ticket type -</option>
  </select>

  <select class="form-select form-select-sm" style="width:180px">
    <option>- Assigned to -</option>
  </select>

  <select class="form-select form-select-sm" style="width:150px">
    <option>- Label -</option>
  </select>

  <button class="btn btn-outline-secondary btn-sm" id="ticketPrev">‹</button>
  <span class="fw-semibold" id="ticketMonth"></span>
  <button class="btn btn-outline-secondary btn-sm" id="ticketNext">›</button>
</div>

<!-- CHART -->
<div class="table-responsive">
  <canvas id="ticketChart" height="120"></canvas>
</div>

</div></div>`;
}
if (id === 'projects') {
return `
<div class="card"><div class="card-body">

<!-- PROJECT SUMMARY TABS -->
<ul class="nav nav-tabs mb-3" id="projectTabs">
  <li class="nav-item">
    <button class="nav-link active" data-tab="team">Team members summary</button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-tab="clients">Clients summary</button>
  </li>
</ul>

<!-- FILTER BAR -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="d-flex gap-2">
    <input type="date" class="form-control form-control-sm">
    <input type="date" class="form-control form-control-sm">
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm" id="projExcel">Excel</button>
<button class="btn btn-outline-secondary btn-sm" id="projPrint">Print</button>
<input class="form-control form-control-sm" id="projSearch" placeholder="Search">

  </div>
</div>

<!-- ================= TEAM MEMBERS SUMMARY ================= -->
<div id="teamWrap">

<table class="table align-middle">
<thead class="table-light">
<tr>
  <th>Team member</th>
  <th>Open Projects</th>
  <th>Completed Projects</th>
  <th>Hold Projects</th>
  <th>Open Tasks</th>
  <th>Completed Tasks</th>
  <th>Total time logged</th>
  <th>Total time logged (Hours)</th>
</tr>
</thead>

<tbody id="teamBody"></tbody>

<tfoot class="table-light fw-bold">
<tr>
  <td>Total</td>
  <td id="tOpen"></td>
  <td id="tCompleted"></td>
  <td id="tHold"></td>
  <td id="tOT"></td>
  <td id="tCT"></td>
  <td></td>
  <td id="tHours"></td>
</tr>
</tfoot>
</table>

<div class="d-flex justify-content-between pt-2">
  <span id="teamPageInfo"></span>
  <div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary" id="teamPrev">‹</button>
    <button class="btn btn-outline-secondary" id="teamNext">›</button>
  </div>
</div>

</div>

<!-- ================= CLIENT SUMMARY ================= -->
<div id="clientsWrap" class="d-none">

<table class="table align-middle">
<thead class="table-light">
<tr>
  <th>Client</th>
  <th>Open Projects</th>
  <th>Completed Projects</th>
  <th>Hold Projects</th>
  <th>Open Tasks</th>
  <th>Completed Tasks</th>
  <th>Total time logged</th>
  <th>Total time logged (Hours)</th>
</tr>
</thead>

<tbody id="clientsBody"></tbody>

<tfoot class="table-light fw-bold">
<tr>
  <td>Total</td>
  <td id="cOpen"></td>
  <td id="cCompleted"></td>
  <td id="cHold"></td>
  <td id="cOT"></td>
  <td id="cCT"></td>
  <td></td>
  <td id="cHours"></td>
</tr>
</tfoot>
</table>

<div class="d-flex justify-content-between pt-2">
  <span id="clientsPageInfo"></span>
  <div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary" id="clientsPrev">‹</button>
    <button class="btn btn-outline-secondary" id="clientsNext">›</button>
  </div>
</div>

</div>

</div></div>`;
}
if (id === "leads") {
return `
<div class="card"><div class="card-body">

<h5 class="fw-semibold mb-3">Team members summary</h5>

<!-- FILTER BAR -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <div></div>
  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm" id="leadExcel">Excel</button>
    <button class="btn btn-outline-secondary btn-sm" id="leadPrint">Print</button>
    <input class="form-control form-control-sm" id="leadSearch" placeholder="Search">
  </div>
</div>

<!-- CHART -->
<div class="mb-4">
  <canvas id="leadChart" height="120"></canvas>
</div>

<table class="table align-middle">
<thead class="table-light">
<tr>
  <th>Owner</th>
  <th>New</th>
  <th>Qualified</th>
  <th>Discussion</th>
  <th>Converted to client</th>
</tr>
</thead>

<tbody id="leadBody"></tbody>

<tfoot class="table-light fw-bold">
<tr>
  <td>Total</td>
  <td id="tNew"></td>
  <td id="tQualified"></td>
  <td id="tDiscussion"></td>
  <td id="tConverted"></td>
</tr>
</tfoot>
</table>

<div class="d-flex justify-content-between pt-2">
  <span id="leadPageInfo"></span>
  <div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary" id="leadPrev">‹</button>
    <button class="btn btn-outline-secondary" id="leadNext">›</button>
  </div>
</div>

</div></div>`;
}


    return `<p>No content</p>`;
}

/* =====================================================
   INVOICE SUMMARY LOGIC (FIXED BODY)
===================================================== */
function initInvoiceSummary() {

let data=[], filtered=[], page=1, limit=8, type='yearly';

function loadData(){
fetch(`data.php?type=${type}`)
.then(r=>r.json())
.then(d=>{ data=d; filtered=d; page=1; render(); });
}

function render(){
const tbody=tableBody;
tbody.innerHTML="";
let start=(page-1)*limit, rows=filtered.slice(start,start+limit);
let tC=0,tI=0,tP=0,tD=0;

rows.forEach(r=>{
const i=+r.invoice_total||0,p=+r.paid||0,d=+r.due||0;
tC+=+r.count||0; tI+=i; tP+=p; tD+=d;

tbody.innerHTML+=`
<tr>
<td><a href="client-view.php?name=${encodeURIComponent(r.client)}"
    class="text-decoration-none text-primary">${r.client}</a></td>
<td>${r.count}</td>
<td>$${i.toFixed(2)}</td>
<td>$0.00</td>
<td>$0.00</td>
<td>$0.00</td>
<td>$0.00</td>
<td>$${p.toFixed(2)}</td>
<td>$${d.toFixed(2)}</td>
</tr>`;
});

tCount.innerText=tC;
tInvoice.innerText=`$${tI.toFixed(2)}`;
tPaid.innerText=`$${tP.toFixed(2)}`;
tDue.innerText=`$${tD.toFixed(2)}`;
pageInfo.innerText=`${start+1}-${Math.min(start+limit,filtered.length)} of ${filtered.length}`;
}

document.querySelectorAll("#invoiceTabs button").forEach(b=>{
b.onclick=()=>{
document.querySelectorAll("#invoiceTabs button").forEach(x=>x.classList.remove("active"));
b.classList.add("active");
type=b.dataset.type;
loadData();
};
});

search.onkeyup=e=>{
filtered=data.filter(r=>r.client.toLowerCase().includes(e.target.value.toLowerCase()));
page=1; render();
};

prevPage.onclick=()=>{if(page>1){page--;render();}};
nextPage.onclick=()=>{if(page*limit<filtered.length){page++;render();}};
excelBtn.onclick=()=>window.print();
printBtn.onclick=()=>window.print();

loadData();
}

/* =====================================================
   INVOICE DETAILS LOGIC (YEARLY / MONTHLY / CUSTOM SAME)
===================================================== */
function initInvoiceDetails() {

let data = [];
let filtered = [];
let page = 1;
let limit = 10;
let mode = "yearly";

/* 🔥 CURRENT MONTH STATE */
let currentDate = new Date(); // today

function updateMonthLabel() {
    const m = currentDate.toLocaleString('default', { month: 'long' });
    const y = currentDate.getFullYear();
    monthLabel.innerText = `${m} ${y}`;
}

/* 🔥 FILTER LOGIC */
function applyFilter() {

    if (mode === "monthly") {
        const ym = currentDate.toISOString().slice(0,7); // YYYY-MM
        filtered = data.filter(r =>
            r.bill_date && r.bill_date.startsWith(ym)
        );
    } else {
        filtered = data;
    }

    page = 1;
    render();
}

/* LOAD DATA */
function loadData(){
fetch("invoices_json.php")
.then(r=>r.json())
.then(d=>{
data = d.filter(x => x.type === "invoice");
applyFilter();
});
}

/* RENDER TABLE */
function render(){
const tbody = detailsBody;
tbody.innerHTML="";

let start=(page-1)*limit;
let rows=filtered.slice(start,start+limit);
let tT=0,tP=0,tD=0;

rows.forEach(r=>{
const t=+r.total||0,p=+r.received||0,d=+r.due||0;
tT+=t; tP+=p; tD+=d;

const badge =
r.status==="Fully paid"?"bg-success":
r.status==="Overdue"?"bg-danger":
r.status==="Not paid"?"bg-warning":"bg-secondary";

tbody.innerHTML+=`
<tr>
<td><a href="invoice_view.php?id=${encodeURIComponent(r.id)}"
 class="fw-semibold text-primary text-decoration-none">${r.id}</a></td>
<td><a href="client-view.php?name=${encodeURIComponent(r.client)}"
 class="text-decoration-none text-primary">${r.client}</a></td>
<td>${r.bill_date||"-"}</td>
<td>${r.due_date||"-"}</td>
<td>$${t.toFixed(2)}</td>
<td>$${p.toFixed(2)}</td>
<td>$${d.toFixed(2)}</td>
<td><span class="badge ${badge}">${r.status}</span></td>
</tr>`;
});

dTotal.innerText=`$${tT.toFixed(2)}`;
dPaid.innerText=`$${tP.toFixed(2)}`;
dDue.innerText=`$${tD.toFixed(2)}`;
detailsPageInfo.innerText=
`${start+1}-${Math.min(start+limit,filtered.length)} of ${filtered.length}`;
}

/* 🔥 TAB SWITCH */
document.querySelectorAll("#detailTabs button").forEach(btn=>{
btn.onclick=()=>{
document.querySelectorAll("#detailTabs button").forEach(b=>b.classList.remove("active"));
btn.classList.add("active");

const label = btn.innerText.toLowerCase();
mode = label === "monthly" ? "monthly" : "yearly";
applyFilter();
};
});

/* 🔥 MONTH NAVIGATION */
monthPrev.onclick=()=>{
currentDate.setMonth(currentDate.getMonth()-1);
updateMonthLabel();
applyFilter();
};

monthNext.onclick=()=>{
currentDate.setMonth(currentDate.getMonth()+1);
updateMonthLabel();
applyFilter();
};

/* SEARCH */
searchDetails.onkeyup=e=>{
filtered=data.filter(r =>
r.client.toLowerCase().includes(e.target.value.toLowerCase()) ||
r.id.toLowerCase().includes(e.target.value.toLowerCase())
);
page=1; render();
};

detailsPrev.onclick=()=>{ if(page>1){page--;render();} };
detailsNext.onclick=()=>{ if(page*limit<filtered.length){page++;render();} };
excelDetails.onclick=()=>window.print();
printDetails.onclick=()=>window.print();

/* INIT */
updateMonthLabel();
loadData();
}
function initFinanceIncomeExpense() {

let year = new Date().getFullYear();
let chart;

const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

Promise.all([
    fetch("invoices_json.php").then(r=>r.json()),
    fetch("expenses_json.php").then(r=>r.json()).catch(()=>[])
]).then(([invoices, expenses]) => {

    function aggregate() {
        let income = Array(12).fill(0);
        let expense = Array(12).fill(0);

        invoices.forEach(i => {
            if (!i.bill_date) return;
            const d = new Date(i.bill_date);
            if (d.getFullYear() === year) {
                income[d.getMonth()] += Number(i.received || 0);
            }
        });

        expenses.forEach(e => {
            if (!e.date) return;
            const d = new Date(e.date);
            if (d.getFullYear() === year) {
                expense[d.getMonth()] += Number(e.amount || 0);
            }
        });

        return { income, expense };
    }

    function render() {
        financeYear.innerText = year;
        const data = aggregate();

        if (chart) chart.destroy();

        chart = new Chart(incomeExpenseChart, {
            type: "line",
            data: {
                labels: months,
                datasets: [
                    { label: "Income", data: data.income, fill: true, tension: 0.4 },
                    { label: "Expense", data: data.expense, fill: true, tension: 0.4 }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: "bottom" } }
            }
        });

        financeSummaryBody.innerHTML = "";

let totalIncome = 0;
let totalExpense = 0;

months.forEach((m, i) => {
    const inc = data.income[i];
    const exp = data.expense[i];
    const profit = inc - exp;

    totalIncome += inc;
    totalExpense += exp;

    financeSummaryBody.innerHTML += `
    <tr>
        <td>${m}</td>
        <td>$${inc.toFixed(2)}</td>
        <td>$${exp.toFixed(2)}</td>
        <td>$${profit.toFixed(2)}</td>
    </tr>`;
});

/* ✅ TOTALS */
financeIncomeTotal.innerText = `$${totalIncome.toFixed(2)}`;
financeExpenseTotal.innerText = `$${totalExpense.toFixed(2)}`;
financeProfitTotal.innerText = `$${(totalIncome - totalExpense).toFixed(2)}`;

    }

    /* TAB SWITCH */
    document.querySelectorAll("#financeTabs button").forEach(btn=>{
        btn.onclick = () => {
            document.querySelectorAll("#financeTabs button").forEach(b=>b.classList.remove("active"));
            btn.classList.add("active");

            financeChartWrap.classList.toggle("d-none", btn.dataset.tab !== "chart");
            financeSummaryWrap.classList.toggle("d-none", btn.dataset.tab !== "summary");
        };
    });

    financePrev.onclick = () => { year--; render(); };
    financeNext.onclick = () => { year++; render(); };

    render();
});
}
/* =====================================================
   EXPENSE SUMMARY (TABLE + CHARTS) – FINAL
===================================================== */

let yearlyChart = null;
let categoryChart = null;

function initExpenseSummary() {

  /* ===== DOM ===== */
  const tableWrap = document.getElementById("expenseTableWrap");
  const yearlyWrap = document.getElementById("expenseYearChartWrap");
  const categoryWrap = document.getElementById("expenseCategoryChartWrap");

  const expBody = document.getElementById("expBody");
  const expLabel = document.getElementById("expLabel");
  const expAmount = document.getElementById("expAmount");
  const expTotal = document.getElementById("expTotal");
  const expPageInfo = document.getElementById("expPageInfo");

  const expPrev = document.getElementById("expPrev");
  const expNext = document.getElementById("expNext");
  const expPrevPage = document.getElementById("expPrevPage");
  const expNextPage = document.getElementById("expNextPage");
  const expSearch = document.getElementById("expSearch");

  /* ===== DATA ===== */
  const data = JSON.parse(localStorage.getItem("expenses") || "[]");
  let filtered = [];
  let page = 1;
  let limit = 7;
  let mode = "yearly";
  let currentDate = new Date();

  /* ===== LABEL ===== */
  function updateLabel() {
    expLabel.innerText =
      mode === "yearly"
        ? currentDate.getFullYear()
        : currentDate.toLocaleString("default", { month: "long" }) +
          " " + currentDate.getFullYear();
  }

  /* ===== FILTER ===== */
  function applyFilter() {
    filtered = data.filter(e => {
      if (!e.date) return false;
      const d = new Date(e.date);

      if (mode === "yearly") {
        return d.getFullYear() === currentDate.getFullYear();
      }

      if (mode === "monthly") {
        return (
          d.getFullYear() === currentDate.getFullYear() &&
          d.getMonth() === currentDate.getMonth()
        );
      }

      return true; // custom
    });

    page = 1;
    renderTable();
  }

  /* ===== TABLE ===== */
  function renderTable() {

    expBody.innerHTML = "";

    if (!filtered.length) {
      expBody.innerHTML = `
        <tr>
          <td colspan="5" class="text-center text-muted py-4">
            No expenses found
          </td>
        </tr>`;
      expAmount.innerText = "$0.00";
      expTotal.innerText = "$0.00";
      expPageInfo.innerText = "0-0 of 0";
      return;
    }

    let start = (page - 1) * limit;
    let rows = filtered.slice(start, start + limit);
    let total = 0;

    rows.forEach(r => {
      const amt = Number(r.amount || 0);
      total += amt;

      expBody.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${r.category}</td>
          <td>$${amt.toFixed(2)}</td>
          <td>$0.00</td>
          <td>$0.00</td>
          <td>$${amt.toFixed(2)}</td>
        </tr>
      `);
    });

    expAmount.innerText = `$${total.toFixed(2)}`;
    expTotal.innerText = `$${total.toFixed(2)}`;
    expPageInfo.innerText =
      `${start + 1}-${Math.min(start + limit, filtered.length)} of ${filtered.length}`;
  }

  /* ===== TAB SWITCH ===== */
  document.querySelectorAll("#expenseTabs button").forEach(btn => {
    btn.addEventListener("click", () => {

      document.querySelectorAll("#expenseTabs button")
        .forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const type = btn.dataset.type;

      /* hide all */
      tableWrap.classList.add("d-none");
      yearlyWrap.classList.add("d-none");
      categoryWrap.classList.add("d-none");

      /* TABLE */
      if (type === "yearly" || type === "monthly" || type === "custom") {
        tableWrap.classList.remove("d-none");
        mode = type;
        updateLabel();
        applyFilter();
        return;
      }

      /* YEARLY CHART */
      if (type === "yearly-chart") {
        yearlyWrap.classList.remove("d-none");
        setTimeout(initExpenseYearlyChart, 50);
        return;
      }

      /* CATEGORY CHART */
      if (type === "category-chart") {
        categoryWrap.classList.remove("d-none");
        setTimeout(initExpenseCategoryChart, 50);
      }
    });
  });

  /* NAV */
  expPrev.onclick = () => {
    mode === "yearly"
      ? currentDate.setFullYear(currentDate.getFullYear() - 1)
      : currentDate.setMonth(currentDate.getMonth() - 1);
    updateLabel();
    applyFilter();
  };

  expNext.onclick = () => {
    mode === "yearly"
      ? currentDate.setFullYear(currentDate.getFullYear() + 1)
      : currentDate.setMonth(currentDate.getMonth() + 1);
    updateLabel();
    applyFilter();
  };

  expSearch.onkeyup = e => {
    filtered = data.filter(x =>
      x.category.toLowerCase().includes(e.target.value.toLowerCase())
    );
    page = 1;
    renderTable();
  };

  expPrevPage.onclick = () => { if (page > 1) { page--; renderTable(); } };
  expNextPage.onclick = () => { if (page * limit < filtered.length) { page++; renderTable(); } };

  updateLabel();
  applyFilter();
}

/* ================= YEARLY BAR CHART ================= */
function initExpenseYearlyChart() {

  const canvas = document.getElementById("expenseYearChart");
  if (!canvas) return;

  if (yearlyChart) yearlyChart.destroy();

  const data = JSON.parse(localStorage.getItem("expenses") || "[]");
  let months = Array(12).fill(0);

  data.forEach(e => {
    if (!e.date) return;
    const d = new Date(e.date);
    months[d.getMonth()] += Number(e.amount || 0);
  });

 yearlyChart = new Chart(canvas, {
  type: "bar",
  data: {
    labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
    datasets: [{
      label: "Expenses",
      data: months
    }]
  },
  options: {
    responsive: false,        // 🔥 THIS IS THE KEY
    plugins: {
      legend: { position: "bottom" }
    }
  }
});

}

/* ================= CATEGORY DONUT CHART ================= */
function initExpenseCategoryChart() {

  const canvas = document.getElementById("expenseCategoryChart");
  if (!canvas) return;

  if (categoryChart) categoryChart.destroy();

  const data = JSON.parse(localStorage.getItem("expenses") || "[]");
  let map = {};

  data.forEach(e => {
    map[e.category] = (map[e.category] || 0) + Number(e.amount || 0);
  });

 categoryChart = new Chart(canvas, {
  type: "doughnut",
  data: {
    labels: Object.keys(map),
    datasets: [{
      data: Object.values(map)
    }]
  },
  options: {
    responsive: false,        // 🔥 THIS IS THE KEY
    cutout: "70%",
    plugins: {
      legend: { position: "bottom" }
    }
  }
});

}
function initFinancePaymentSummary() {

let year = new Date().getFullYear();
payYear.innerText = year;

/* ================= TAB SWITCH ================= */
document.querySelectorAll("#paymentTabs button").forEach(btn => {
  btn.onclick = () => {
    document.querySelectorAll("#paymentTabs button")
      .forEach(b => b.classList.remove("active"));
    btn.classList.add("active");

    monthlyWrap.classList.toggle("d-none", btn.dataset.tab !== "monthly");
    clientsWrap.classList.toggle("d-none", btn.dataset.tab !== "clients");
  };
});

/* =================================================
   MONTHLY SUMMARY + PAGINATION
================================================= */
const monthlyData = [
  { month: "December", count: 6, amount: 4697.5 },
  { month: "November", count: 11, amount: 12555.5 },
  { month: "October", count: 4, amount: 3100 },
  { month: "September", count: 2, amount: 1800 }
];

let mPage = 1;
let mLimit = 2;

function renderMonthly() {

monthlyBody.innerHTML = "";

let start = (mPage - 1) * mLimit;
let rows = monthlyData.slice(start, start + mLimit);

let tC = 0, tA = 0;

rows.forEach(r => {
  tC += r.count;
  tA += r.amount;

  monthlyBody.innerHTML += `
  <tr>
    <td>${r.month}</td>
    <td class="text-end">${r.count}</td>
    <td class="text-end">$${r.amount.toFixed(2)}</td>
  </tr>`;
});

/* TOTAL (ALL DATA) */
mCount.innerText =
monthlyData.reduce((s,r)=>s+r.count,0);

mAmount.innerText =
`$${monthlyData.reduce((s,r)=>s+r.amount,0).toFixed(2)}`;

/* PAGE INFO */
monthlyPageInfo.innerText =
`${start+1}-${Math.min(start+mLimit,monthlyData.length)} of ${monthlyData.length}`;
}

/* MONTHLY PAGINATION */
monthlyPrev.onclick = () => {
  if (mPage > 1) { mPage--; renderMonthly(); }
};

monthlyNext.onclick = () => {
  if (mPage * mLimit < monthlyData.length) { mPage++; renderMonthly(); }
};

/* =================================================
   CLIENTS SUMMARY + PAGINATION
================================================= */
let clientsData = [];
let cPage = 1;
let cLimit = 2;

function loadClients() {

fetch("clientsdata.php")
.then(r => r.json())
.then(d => {

clientsData = [{
  name: d.clientName,
  count:
    d.invoiceOverview.fullyPaid +
    d.invoiceOverview.partiallyPaid +
    d.invoiceOverview.notPaid,
  amount: d.invoiceOverview.payments
}];

renderClients();
});
}

function renderClients() {

clientsBody.innerHTML = "";

let start = (cPage - 1) * cLimit;
let rows = clientsData.slice(start, start + cLimit);

rows.forEach(r => {
  clientsBody.innerHTML += `
  <tr>
    <td>
      <a href="client-view.php?name=${encodeURIComponent(r.name)}"
         class="text-decoration-none text-primary">
         ${r.name}
      </a>
    </td>
    <td class="text-end">${r.count}</td>
    <td class="text-end">$${r.amount.toFixed(2)}</td>
  </tr>`;
});

/* TOTAL */
cCount.innerText =
clientsData.reduce((s,r)=>s+r.count,0);

cAmount.innerText =
`$${clientsData.reduce((s,r)=>s+r.amount,0).toFixed(2)}`;

/* PAGE INFO */
clientsPageInfo.innerText =
`${start+1}-${Math.min(start+cLimit,clientsData.length)} of ${clientsData.length}`;
}

/* CLIENT PAGINATION */
clientsPrev.onclick = () => {
  if (cPage > 1) { cPage--; renderClients(); }
};

clientsNext.onclick = () => {
  if (cPage * cLimit < clientsData.length) { cPage++; renderClients(); }
};

/* =================================================
   NAV + SEARCH
================================================= */
payPrev.onclick = () => { year--; payYear.innerText = year; };
payNext.onclick = () => { year++; payYear.innerText = year; };

payExcel.onclick = () => window.print();
payPrint.onclick = () => window.print();

/* SEARCH (CLIENTS TAB) */
paySearch.onkeyup = e => {
  const q = e.target.value.toLowerCase();
  document.querySelectorAll("#clientsBody tr").forEach(tr => {
    tr.style.display =
      tr.innerText.toLowerCase().includes(q) ? "" : "none";
  });
};

/* INIT */
renderMonthly();
loadClients();
}
function initTimesheets() {

/* ================= DOM ================= */
const tsBody = document.getElementById("tsBody");
const tsTotal = document.getElementById("tsTotal");
const tsPageInfo = document.getElementById("tsPageInfo");

const tsSummaryWrap = document.getElementById("tsSummaryWrap");
const tsChartWrap = document.getElementById("tsChartWrap");
const tsDailyWrap = document.getElementById("tsDailyWrap");

let page = 1;
let limit = 5;
let data = [];
let filtered = [];
let currentDate = new Date();

/* ================= LABEL ================= */
function updateLabel() {
  tsLabel.innerText =
    currentDate.toLocaleString("default", { month: "long" }) +
    " " + currentDate.getFullYear();
}

/* ================= TAB SWITCH ================= */
document.querySelectorAll("#timesheetTabs button").forEach(btn => {
  btn.onclick = () => {
    document.querySelectorAll("#timesheetTabs button")
      .forEach(b => b.classList.remove("active"));
    btn.classList.add("active");

    tsSummaryWrap.classList.toggle("d-none", btn.dataset.tab !== "summary");
    tsChartWrap.classList.toggle("d-none", btn.dataset.tab !== "chart");
    tsDailyWrap.classList.toggle("d-none", btn.dataset.tab !== "daily");

    if (btn.dataset.tab === "chart") renderChart();
    if (btn.dataset.tab === "daily") renderDaily();
  };
});

/* ================= LOAD DATA ================= */
Promise.all([
  fetch("projects_json.php").then(r => r.json()),
  fetch("tasks_json.php").then(r => r.json())
]).then(([projects, tasks]) => {

data = tasks.map(t => {
  const p = projects.find(x => x.title === t.related_to);

  return {
    project: p ? p.title : "-",
    projectId: p ? p.id : 0,
    start_date: p ? p.start_date : "-",
    end_date: p ? p.deadline : "-",
    task: t.title,
    taskId: t.id,
    member: t.assigned_to,
    memberId: t.assigned_to, // using name as id (safe)
    hours: Math.floor(Math.random() * 6) + 1
  };
});


filtered = data;
renderTable();
});

/* ================= TABLE ================= */
function renderTable() {

tsBody.innerHTML = "";

let start = (page - 1) * limit;
let rows = filtered.slice(start, start + limit);

let total = 0;

rows.forEach(r => {
  total += r.hours;

 tsBody.innerHTML += `
<tr>
  <td>
    <a href="project_detail.php?id=${r.projectId}"
       class="text-decoration-none text-primary">
       ${r.project}
    </a>
  </td>

  <td>
    <a href="tasks.php?id=${r.taskId}"
       class="text-decoration-none text-primary">
       ${r.task}
    </a>
  </td>

  <td>
    <a href="client-view.php?name=${encodeURIComponent(r.member)}"
       class="text-decoration-none text-primary">
       ${r.member}
    </a>
  </td>

  <td>${r.start_date}</td>
  <td>${r.end_date}</td>

  <td class="text-end">${r.hours.toFixed(2)}</td>
</tr>`;

});

tsTotal.innerText =
filtered.reduce((s,r)=>s+r.hours,0).toFixed(2);

tsPageInfo.innerText =
`${start+1}-${Math.min(start+limit,filtered.length)} of ${filtered.length}`;
}

/* ================= PAGINATION ================= */
tsPrevPage.onclick = () => {
  if (page > 1) { page--; renderTable(); }
};

tsNextPage.onclick = () => {
  if (page * limit < filtered.length) { page++; renderTable(); }
};

/* ================= SEARCH ================= */
tsSearch.onkeyup = e => {
  const q = e.target.value.toLowerCase();
  filtered = data.filter(r =>
    r.project.toLowerCase().includes(q) ||
    r.task.toLowerCase().includes(q) ||
    r.member.toLowerCase().includes(q)
  );
  page = 1;
  renderTable();
};

/* ================= MONTH NAV ================= */
tsPrev.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  updateLabel();
};

tsNext.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  updateLabel();
};

/* ================= CHART ================= */
let chart;
function renderChart() {
  if (chart) chart.destroy();

  chart = new Chart(tsChart, {
    type: "line",
    data: {
      labels: Array.from({length: 31}, (_, i) => i + 1),
      datasets: [{
        label: "Timesheets",
        data: Array.from({length: 31}, () => Math.floor(Math.random() * 8)),
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      plugins: { legend: { position: "bottom" } }
    }
  });
}

/* ================= DAILY ACTIVITY ================= */
function renderDaily() {

  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  // ✅ correct number of days in month
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  tsDailyHead.innerHTML = "<th>Member</th>";
  for (let i = 1; i <= daysInMonth; i++) {
    tsDailyHead.innerHTML += `<th>${i}</th>`;
  }

  tsDailyBody.innerHTML = "";

  ["John Doe", "Richard Gray", "Sara Ann"].forEach(m => {
    let row = `<tr><td>${m}</td>`;
    for (let i = 1; i <= daysInMonth; i++) {
      row += `<td>${Math.random() > 0.7 ? (Math.random()*8).toFixed(2) : ""}</td>`;
    }
    row += "</tr>";
    tsDailyBody.innerHTML += row;
  });
}


/* INIT */
updateLabel();
}
/* =====================================================
   GLOBAL STATE (IMPORTANT)
===================================================== */
let ticketCurrentDate = new Date();
let ticketChart = null;

/* =====================================================
   INIT TICKET STATISTICS
===================================================== */
function initTicketStatistics() {

  updateTicketMonthLabel();

  fetch("ticket-data.php")
    .then(r => r.json())
    .then(tickets => {

      const year = ticketCurrentDate.getFullYear();
      const month = ticketCurrentDate.getMonth();

      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const labels = Array.from({ length: daysInMonth }, (_, i) => i + 1);

      let openData = Array(daysInMonth).fill(0);
      let newData  = Array(daysInMonth).fill(0);

      tickets.forEach(t => {
        const day = extractTicketDay(t.activity, year, month);
        if (!day) return;

        if (t.status === "Open") openData[day - 1]++;
        if (t.status === "New")  newData[day - 1]++;
      });

      renderTicketChart(labels, openData, newData);
    });

  /* ===== NAV BUTTONS ===== */
  ticketPrev.onclick = () => {
    ticketCurrentDate.setMonth(ticketCurrentDate.getMonth() - 1);
    initTicketStatistics();
  };

  ticketNext.onclick = () => {
    ticketCurrentDate.setMonth(ticketCurrentDate.getMonth() + 1);
    initTicketStatistics();
  };
}

/* =====================================================
   MONTH LABEL
===================================================== */
function updateTicketMonthLabel() {
  ticketMonth.innerText =
    ticketCurrentDate.toLocaleString("default", { month: "long" }) +
    " " + ticketCurrentDate.getFullYear();
}

/* =====================================================
   DATE PARSER (MONTH SAFE)
===================================================== */
function extractTicketDay(text, year, month) {

  // Format: 06-12-2025
  const m = text.match(/(\d{2})-(\d{2})-(\d{4})/);
  if (m) {
    const d = parseInt(m[1]);
    const mo = parseInt(m[2]) - 1;
    const y = parseInt(m[3]);

    if (y === year && mo === month) return d;
    return null;
  }

  if (text.toLowerCase().includes("today")) {
    const now = new Date();
    if (now.getFullYear() === year && now.getMonth() === month)
      return now.getDate();
  }

  if (text.toLowerCase().includes("yesterday")) {
    const yest = new Date();
    yest.setDate(yest.getDate() - 1);
    if (yest.getFullYear() === year && yest.getMonth() === month)
      return yest.getDate();
  }

  return null;
}

/* =====================================================
   CHART RENDER
===================================================== */
function renderTicketChart(labels, openData, newData) {

  if (ticketChart) ticketChart.destroy();

  ticketChart = new Chart(
    document.getElementById("ticketChart"),
    {
      type: "bar",
      data: {
        labels,
        datasets: [
          { label: "Open", data: openData },
          { label: "New", data: newData }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: "bottom" }
        },
        scales: {
          x: { stacked: true },
          y: { stacked: true, beginAtZero: true }
        }
      }
    }
  );
}
function initProjectSummary() {

  /* ================= DOM (CRITICAL) ================= */
  const projExcel  = document.getElementById("projExcel");
  const projPrint  = document.getElementById("projPrint");
  const projSearch = document.getElementById("projSearch");

  const teamWrap    = document.getElementById("teamWrap");
  const clientsWrap = document.getElementById("clientsWrap");

  const teamBody    = document.getElementById("teamBody");
  const clientsBody = document.getElementById("clientsBody");

  const teamPrev = document.getElementById("teamPrev");
  const teamNext = document.getElementById("teamNext");
  const clientsPrev = document.getElementById("clientsPrev");
  const clientsNext = document.getElementById("clientsNext");

  const teamPageInfo    = document.getElementById("teamPageInfo");
  const clientsPageInfo = document.getElementById("clientsPageInfo");

  const tOpen = document.getElementById("tOpen");
  const tCompleted = document.getElementById("tCompleted");
  const tHold = document.getElementById("tHold");
  const tOT = document.getElementById("tOT");
  const tCT = document.getElementById("tCT");
  const tHours = document.getElementById("tHours");

  const cOpen = document.getElementById("cOpen");
  const cCompleted = document.getElementById("cCompleted");

  /* ================= TAB SWITCH ================= */
  document.querySelectorAll("#projectTabs button").forEach(btn => {
    btn.addEventListener("click", () => {
      document.querySelectorAll("#projectTabs button")
        .forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      teamWrap.classList.toggle("d-none", btn.dataset.tab !== "team");
      clientsWrap.classList.toggle("d-none", btn.dataset.tab !== "clients");
    });
  });

  /* ================= LOAD ALL JSON ================= */
  Promise.all([
    fetch("team_json.php").then(r => r.json()),
    fetch("projects_json.php").then(r => r.json()),
    fetch("tasks_json.php").then(r => r.json())
  ]).then(([team, projects, tasks]) => {
    buildTeamSummary(team, projects, tasks);
    buildClientSummary(projects, tasks);
  });

  /* =================================================
     TEAM MEMBERS SUMMARY
  ================================================= */
  function buildTeamSummary(team, projects, tasks) {

    let teamData = team.map(m => {

      const userTasks = tasks.filter(t => t.assigned_to === m.name);

      const relatedProjects = projects.filter(p =>
        userTasks.some(t => t.related_to === p.title)
      );

      return {
        name: m.name,
        openP: relatedProjects.filter(p => p.status !== "Completed").length,
        completedP: relatedProjects.filter(p => p.status === "Completed").length,
        holdP: 0,
        openT: userTasks.filter(t => t.status !== "Done").length,
        doneT: userTasks.filter(t => t.status === "Done").length,
        hours: userTasks.length * 2 // demo: 2 hours per task
      };
    });

    let page = 1, limit = 5;
    let filtered = [...teamData];

    function renderTeam() {

      teamBody.innerHTML = "";

      let start = (page - 1) * limit;
      let rows = filtered.slice(start, start + limit);

      rows.forEach(r => {
        teamBody.innerHTML += `
        <tr>
          <td>
            <a href="client-view.php?name=${encodeURIComponent(r.name)}"
               class="text-primary text-decoration-none">${r.name}</a>
          </td>
          <td>${r.openP}</td>
          <td>${r.completedP}</td>
          <td>${r.holdP}</td>
          <td>${r.openT}</td>
          <td>${r.doneT}</td>
          <td>${Math.floor(r.hours)}:00</td>
          <td>${r.hours.toFixed(2)}</td>
        </tr>`;
      });

      /* TOTAL ROW (ALL DATA) */
      tOpen.innerText = teamData.reduce((s,r)=>s+r.openP,0);
      tCompleted.innerText = teamData.reduce((s,r)=>s+r.completedP,0);
      tHold.innerText = 0;
      tOT.innerText = teamData.reduce((s,r)=>s+r.openT,0);
      tCT.innerText = teamData.reduce((s,r)=>s+r.doneT,0);
      tHours.innerText = teamData.reduce((s,r)=>s+r.hours,0).toFixed(2);

      teamPageInfo.innerText =
        `${start+1}-${Math.min(start+limit,filtered.length)} of ${filtered.length}`;
    }

    teamPrev.onclick = () => {
      if (page > 1) { page--; renderTeam(); }
    };

    teamNext.onclick = () => {
      if (page * limit < filtered.length) { page++; renderTeam(); }
    };

    projSearch.onkeyup = e => {
      const q = e.target.value.toLowerCase();
      filtered = teamData.filter(r =>
        r.name.toLowerCase().includes(q)
      );
      page = 1;
      renderTeam();
    };

    renderTeam();
  }

  /* =================================================
     CLIENTS SUMMARY
  ================================================= */
  function buildClientSummary(projects, tasks) {

    let map = {};

    projects.forEach(p => {
      if (p.client === "-") return;

      if (!map[p.client]) {
        map[p.client] = {openP:0, completedP:0};
      }

      p.status === "Completed"
        ? map[p.client].completedP++
        : map[p.client].openP++;
    });

    let clientsArr = Object.keys(map).map(k => ({
      name: k,
      ...map[k]
    }));

    let page = 1, limit = 5;

    function renderClients() {

      clientsBody.innerHTML = "";

      let start = (page - 1) * limit;
      let rows = clientsArr.slice(start, start + limit);

      rows.forEach(c => {
        clientsBody.innerHTML += `
        <tr>
          <td>
            <a href="client-view.php?name=${encodeURIComponent(c.name)}"
               class="text-primary text-decoration-none">${c.name}</a>
          </td>
          <td>${c.openP}</td>
          <td>${c.completedP}</td>
          <td>0</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>`;
      });

      cOpen.innerText = clientsArr.reduce((s,r)=>s+r.openP,0);
      cCompleted.innerText = clientsArr.reduce((s,r)=>s+r.completedP,0);

      clientsPageInfo.innerText =
        `${start+1}-${Math.min(start+limit,clientsArr.length)} of ${clientsArr.length}`;
    }

    clientsPrev.onclick = () => {
      if (page > 1) { page--; renderClients(); }
    };

    clientsNext.onclick = () => {
      if (page * limit < clientsArr.length) { page++; renderClients(); }
    };

    renderClients();
  }

  /* ================= EXCEL / PRINT ================= */
  projExcel.onclick = () => window.print();
  projPrint.onclick = () => window.print();
}
function initLeadsTeamSummary() {

  /* ================= DOM ================= */
  const body = document.getElementById("leadBody");
  const prev = document.getElementById("leadPrev");
  const next = document.getElementById("leadNext");
  const pageInfo = document.getElementById("leadPageInfo");

  const excelBtn = document.getElementById("leadExcel");
  const printBtn = document.getElementById("leadPrint");
  const searchInp = document.getElementById("leadSearch");

  const tNew = document.getElementById("tNew");
  const tQualified = document.getElementById("tQualified");
  const tDiscussion = document.getElementById("tDiscussion");
  const tConverted = document.getElementById("tConverted");

  let page = 1, limit = 5;
  let summary = [], filtered = [];
  let chartInstance = null;

  /* ================= LOAD DATA ================= */
  Promise.all([
    fetch("leads-json.php").then(r => r.json()),
    Promise.resolve(JSON.parse(localStorage.getItem("leads") || "[]"))
  ]).then(([serverLeads, localLeads]) => {

    const leads = [...serverLeads, ...localLeads];
    summary = buildSummary(leads);
    filtered = [...summary];

    renderTable();
    renderChart();
  });

  /* ================= BUILD SUMMARY ================= */
  function buildSummary(leads) {

    const map = {};

    leads.forEach(l => {
      if (!l.owner) return;

      if (!map[l.owner]) {
        map[l.owner] = {
          owner: l.owner,
          New: 0,
          Qualified: 0,
          Discussion: 0,
          Converted: 0
        };
      }

      if (l.status === "New") map[l.owner].New++;
      if (l.status === "Qualified") map[l.owner].Qualified++;
      if (l.status === "Discussion") map[l.owner].Discussion++;
      if (l.status === "Won") map[l.owner].Converted++;
    });

    return Object.values(map);
  }

  /* ================= TABLE ================= */
  function renderTable() {

    body.innerHTML = "";

    let start = (page - 1) * limit;
    let rows = filtered.slice(start, start + limit);

    rows.forEach(r => {
      body.insertAdjacentHTML("beforeend", `
        <tr>
          <td>
            <a href="Client-view.php?name=${encodeURIComponent(r.owner)}"
               class="text-primary text-decoration-none fw-semibold">
               ${r.owner}
            </a>
          </td>
          <td>${r.New}</td>
          <td>${r.Qualified}</td>
          <td>${r.Discussion}</td>
          <td>${r.Converted}</td>
        </tr>
      `);
    });

    /* TOTALS */
    tNew.innerText = summary.reduce((s,r)=>s+r.New,0);
    tQualified.innerText = summary.reduce((s,r)=>s+r.Qualified,0);
    tDiscussion.innerText = summary.reduce((s,r)=>s+r.Discussion,0);
    tConverted.innerText = summary.reduce((s,r)=>s+r.Converted,0);

    pageInfo.innerText =
      `${start+1}-${Math.min(start+limit,filtered.length)} of ${filtered.length}`;
  }

  /* ================= PAGINATION ================= */
  prev.onclick = () => {
    if (page > 1) { page--; renderTable(); }
  };

  next.onclick = () => {
    if (page * limit < filtered.length) { page++; renderTable(); }
  };

  /* ================= SEARCH ================= */
  searchInp.onkeyup = e => {
    const q = e.target.value.toLowerCase();
    filtered = summary.filter(r =>
      r.owner.toLowerCase().includes(q)
    );
    page = 1;
    renderTable();
  };

  /* ================= CHART ================= */
  function renderChart() {

    const canvas = document.getElementById("leadChart");
    if (!canvas) return;

    setTimeout(() => {

      if (chartInstance) chartInstance.destroy();

      chartInstance = new Chart(canvas, {
        type: "bar",
        data: {
          labels: summary.map(x => x.owner),
          datasets: [
            {
              label: "New",
              data: summary.map(x => x.New)
            },
            {
              label: "Qualified",
              data: summary.map(x => x.Qualified)
            },
            {
              label: "Discussion",
              data: summary.map(x => x.Discussion)
            },
            {
              label: "Converted",
              data: summary.map(x => x.Converted)
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: "bottom" }
          },
          scales: {
            y: { beginAtZero: true }
          }
        }
      });

    }, 100);
  }

  /* ================= EXCEL ================= */
  excelBtn.onclick = () => {

    let csv = "Owner,New,Qualified,Discussion,Converted\n";
    summary.forEach(r => {
      csv += `${r.owner},${r.New},${r.Qualified},${r.Discussion},${r.Converted}\n`;
    });

    const blob = new Blob([csv], { type: "text/csv" });
    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = "leads_team_summary.csv";
    a.click();
  };

  /* ================= PRINT ================= */
  printBtn.onclick = () => window.print();
}


/* =====================================================
   DEFAULT LOAD
===================================================== */
document.addEventListener("DOMContentLoaded",()=>{
openTab("sales-invoice-details","Invoice details");
});



</script>




</body>
</html>

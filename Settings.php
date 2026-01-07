<?php include 'common/header.php'; ?>
<?php include 'common/sidenavbar.php'; ?>

<div class="content-page">
<div class="content">
<?php include 'common/topnavbar.php'; ?>

<div class="container-fluid">
  <div class="row">

    <!-- ================= SETTINGS LEFT MENU ================= -->
    <div class="col-md-3 border-end">

      <!-- APP SETTINGS -->
      <button class="btn w-100 text-start" data-bs-toggle="collapse" data-bs-target="#appSettings">
        App Settings
      </button>
      <div class="collapse show" id="appSettings">
        <ul class="list-group list-group-flush">
          <li class="list-group-item" onclick="loadPage('general')">General</li>
          <li class="list-group-item" onclick="loadPage('localization')">Localization</li>
          <li class="list-group-item" onclick="loadPage('email')">Email</li>
          <li class="list-group-item" onclick="loadPage('modules')">Modules</li>
          <li class="list-group-item" onclick="loadPage('left_menu')">Left menu</li>
          <li class="list-group-item" onclick="loadPage('notifications')">Notifications</li>
          <li class="list-group-item" onclick="loadPage('integration')">Integration</li>
          <li class="list-group-item" onclick="loadPage('cron')">Cron Job</li>
        </ul>
      </div>

      <!-- ACCESS PERMISSION -->
      <button class="btn w-100 text-start mt-2" data-bs-toggle="collapse" data-bs-target="#accessPermission">
        Access Permission
      </button>
      <div class="collapse" id="accessPermission">
        <ul class="list-group list-group-flush">
          <li class="list-group-item" onclick="loadPage('roles')">Roles</li>
          <li class="list-group-item" onclick="loadPage('user_roles')">User Roles</li>
          <li class="list-group-item" onclick="loadPage('team')">Team</li>
          <li class="list-group-item" onclick="loadPage('ip')">IP Restriction</li>
        </ul>
      </div>

      <!-- CLIENT PORTAL -->
      <button class="btn w-100 text-start mt-2" data-bs-toggle="collapse" data-bs-target="#clientPortal">
        Client portal
      </button>
      <div class="collapse" id="clientPortal">
        <ul class="list-group list-group-flush">
          <li class="list-group-item" onclick="loadPage('client_permissions')">Client permissions</li>
          <li class="list-group-item" onclick="loadPage('client_dashboard')">Dashboard</li>
        </ul>
      </div>

      <!-- SALES & PROSPECTS -->
      <button class="btn w-100 text-start mt-2" data-bs-toggle="collapse" data-bs-target="#sales">
        Sales & Prospects
      </button>
      <div class="collapse" id="sales">
        <ul class="list-group list-group-flush">
          <li class="list-group-item" onclick="loadPage('company')">Company</li>
          <li class="list-group-item" onclick="loadPage('item_categories')">Item categories</li>
          <li class="list-group-item" onclick="loadPage('store')">Store</li>
          <li class="list-group-item" onclick="loadPage('contracts')">Contracts</li>
          <li class="list-group-item" onclick="loadPage('taxes')">Taxes</li>
          <li class="list-group-item" onclick="loadPage('payment_methods')">Payment methods</li>
        </ul>
      </div>

      <!-- SETUP -->
      <button class="btn w-100 text-start mt-2" data-bs-toggle="collapse" data-bs-target="#setup">
        Setup
      </button>
      <div class="collapse" id="setup">
        <ul class="list-group list-group-flush">
          <li class="list-group-item" onclick="loadPage('custom_fields')">Custom fields</li>
          <li class="list-group-item" onclick="loadPage('client_groups')">Client groups</li>
          <li class="list-group-item" onclick="loadPage('tasks')">Tasks</li>
          <li class="list-group-item" onclick="loadPage('projects')">Projects</li>
          <li class="list-group-item" onclick="loadPage('timesheets')">Timesheets</li>
          <li class="list-group-item" onclick="loadPage('events')">Events</li>
          <li class="list-group-item" onclick="loadPage('reminders')">Reminders</li>
          <li class="list-group-item" onclick="loadPage('expense_categories')">Expense Categories</li>
          <li class="list-group-item" onclick="loadPage('leave_types')">Leave types</li>
          <li class="list-group-item" onclick="loadPage('tickets')">Tickets</li>
          <li class="list-group-item" onclick="loadPage('leads')">Leads</li>
          <li class="list-group-item" onclick="loadPage('gdpr')">GDPR</li>
          <li class="list-group-item" onclick="loadPage('pages')">Pages</li>
        </ul>
      </div>

      <!-- PLUGINS -->
      <button class="btn w-100 text-start mt-2" onclick="loadPage('plugins')">
        Plugins
      </button>

    </div>

    <!-- ================= RIGHT CONTENT AREA ================= -->
    <div class="col-md-9">
      <div id="settingsContent" class="p-3">
        <h4>Select a setting</h4>
        <p>Choose any option from the left menu.</p>
      </div>
    </div>

  </div>
</div>

</div>
</div>
<div class="modal fade" id="saveSuccessModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="fs-3 mb-2">✅</div>
        <h6 class="mb-1">Settings Saved</h6>
        <p class="text-muted mb-3">Your changes have been saved successfully.</p>
        <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="emailErrorModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="fs-3 mb-2">⚠️</div>
        <h6 class="mb-1">Email Required</h6>
        <p class="text-muted mb-3">
          Please enter an email address to send test mail.
        </p>
        <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">
          OK
        </button>
      </div>
    </div>
  </div>
</div>

<?php include 'common/footer.php'; ?>
<script>
 
let remindersSettings = {
  earlyReminder: "-"
};

/* ===============================
   STATE (SIMULATED BACKEND)
================================ */
let topMenuItems = [
  { name: "Store", url: "#" },
  { name: "Knowledge base", url: "#" },
  { name: "Custom page", url: "#" },
  { name: "Sign in", url: "#" }
];

let footerMenuItems = [
  { name: "Store", url: "#" },
  { name: "Knowledge base", url: "#" },
  { name: "Custom page", url: "#" }
];

let localization = {
  language: "English",
  timezone: "UTC",
  dateFormat: "d-m-Y",
  timeFormat: "12 am",
  firstDay: "Sunday",
  weekends: ["Sunday"],
  currency: "USD",
  currencySymbol: "$",
  currencyPosition: "Left",
  decimalSeparator: "Dot (.)",
  decimals: "2",
  conversions: [{ currency: "AED", rate: "" }]
};

let emailSettings = {
  protocol: "Mail",
  fromName: "RISE CRM",
  fromAddress: "info@demo.com"
};

/* MODULES */
let modulesState = {
  "Self Improvements": ["To do","Note","Reminder","Event"],
  "Business Growth": ["Lead","Expense"],
  "Sales Management": ["Contract","Proposal","Estimate","Estimate Request","Invoice","Subscription","Order"],
  "Customer Support": ["Ticket","Knowledge base (Public)"],
  "Team Management": ["Leave","Time cards","Project timesheet","Gantt","Help (Team members)"],
  "Collaboration": ["Message","Chat","File manager","Timeline","Announcement"]
};
/* LEFT MENU → PAGE MAP (ADDED) */
const leftMenuPageMap = {
  "Dashboard": "index.php",
  "Events": "Event.php",
  "Clients": "Clients.php",
  "Projects": "projects.php",
  "Tasks": "tasks.php",
  "Leads": "leads.php",
  "Subscription": "subscription.php",
  "Sales": "invoices.php",
  "Prospects": "Estimate.php",
  "Notes": "Notes.php",
  "Messages": "message.php",
  "Team": "team_member.php",
  "Tickets": "tickets.php",
  "Knowledge base": "knowledgebase.php",
  "Files": "Files.php",
  "Expenses": "Expenses.php",
  "Reports": "Report.php",
  "Settings": "Settings.php"
};

function openMenuPage(item) {
  if (leftMenuPageMap[item]) {
    window.location.href = leftMenuPageMap[item];
  }
}

/* LEFT MENU CONFIG */
let leftMenuItems = [
  "Dashboard","Events","Clients","Projects","Tasks","Leads",
  "Subscription","Sales","Prospects","Notes","Messages",
  "Team","Tickets","Knowledge base","Files","Expenses","Reports","Settings"
];
/* ===============================
   🔔 NOTIFICATION STATE (ONLY ADDED)
================================ */
let notificationData = [
  {
    event: "New order received",
    notify: ["Team members: John Doe"],
    category: "Order",
    email: false,
    web: true,
    slack: false
  },
  {
    event: "Project created",
    notify: ["Primary contact of client","Team members: John Doe"],
    category: "Project",
    email: false,
    web: true,
    slack: false
  },
  {
    event: "Project deleted",
    notify: [],
    category: "Project",
    email: false,
    web: false,
    slack: false
  },
  {
    event: "Order status updated",
    notify: [],
    category: "Order",
    email: false,
    web: false,
    slack: false
  },
  {
    event: "Project completed",
    notify: ["Primary contact of client","Team members: John Doe"],
    category: "Project",
    email: false,
    web: true,
    slack: false
  },
  {
    event: "Project task created",
    notify: ["Project members","Task assignee"],
    category: "Project",
    email: false,
    web: true,
    slack: false
  },
  {
    event: "Project task updated",
    notify: ["Project members","Task assignee"],
    category: "Project",
    email: false,
    web: true,
    slack: false
  }
];
let clientPermissions = {
  disableSignup: false,
  verifyEmail: false,
  disableLogin: false,
  disableInvitation: false,

  defaultPermissions: ["Projects"],

  collaborationUsers: ["John Doe", "Michael Wood"],
  clientToClientMessage: true,

  hideMenus: "",
  projectTabOrder: "",
  disableFavorite: false,
  disableLeftMenuEdit: false,
  disableTopbarEdit: false,
  disableDashboardEdit: false,

  project: {
    create: true,
    edit: true,
    viewTasks: true,
    createTasks: true,
    editTasks: true,
    assignTasks: true,
    commentTasks: true,
    viewFiles: true,
    addFiles: true,
    commentFiles: true,
    deleteOwnFiles: true,
    viewMilestones: true,
    viewGantt: true,
    viewOverview: true,
    viewActivity: true
  },

  others: {
    viewFiles: true,
    addFiles: true,
    accessStore: true,
    createReminders: true,
    accessNotes: true
  }
};

/* ===============================
   🔗 INTEGRATION STATE
================================ */
let integrationState = {
  recaptcha: { protocol: "v2 Checkbox", siteKey: "", secretKey: "" },
  googleDrive: { enabled: false },
  pusher: { enabled: false },
  slack: { enabled: false },
  bitbucket: { enabled: false },
  github: { enabled: false },
  tinymce: { enabled: false }
};
let userRolesData = {
  active: [
    { id: 1, name: "John Doe", role: "Admin" },
    { id: 2, name: "Mark Thomas", role: "Developer" },
    { id: 3, name: "Michael Wood", role: "Project Manager" },
    { id: 4, name: "Richard Gray", role: "Developer" },
    { id: 5, name: "Sara Ann", role: "Developer" },
    { id: 6, name: "Vineeth AAA", role: "Developer" }
  ],
  inactive: [
    { id: 7, name: "Ayan Francis", role: "Team member" }
  ]
};
let ipRestriction = {
  allowedIPs: ""
};
let companies = [
  {
    id: 1,
    name: "Awesome Demo Company",
    address: "86935 Greenholt Forges, Florida, 5626",
    phone: "+12345678888",
    email: "info@demo.company",
    website: "https://fairsketch.com",
    vat: "",
    gst: "",
    isDefault: true,
    logo: "assets/images/tech-logo21.webp"
  }
];
for (let i = 2; i <=12; i++) {
  companies.push({
    id: i,
    name: "Demo Company " + i,
    address: "Address " + i,
    phone: "+91 90000000" + i,
    email: "company" + i + "@demo.com",
    website: "https://example.com",
    vat: "",
    gst: "",
    isDefault: false,
    logo: "assets/images/tech-logo21.webp"
  });
}

let companyPage = 1;
let companyLimit = 10;
let editingCompanyId = null;
/* ===============================
   ITEM CATEGORIES STATE
================================ */
let itemCategories = [
  { id: 1, title: "Design" },
  { id: 2, title: "Development" },
  { id: 3, title: "Services" },
  { id: 4, title: "Marketing" },
  { id: 5, title: "SEO" },
  { id: 6, title: "Consulting" },
  { id: 7, title: "Support" },
  { id: 8, title: "Hosting" },
  { id: 9, title: "Maintenance" },
  { id: 10, title: "Branding" },
  { id: 11, title: "UI/UX" }
];


let categoryPage = 1;
let categoryLimit = 10;
let editingCategoryId = null;
/* ===============================
   LEAVE TYPES STATE
================================ */
let leaveTypes = [
  { id: 1, title: "Casual Leave", description: "-", color: "#20c997", status: "Active" },
  { id: 2, title: "Maternity Leave", description: "-", color: "#f1c40f", status: "Active" },
  { id: 3, title: "Paternity leave", description: "-", color: "#f39c12", status: "Active" },
  { id: 4, title: "Sick Leave", description: "-", color: "#d63384", status: "Active" }
];

let editingLeaveId = null;
/* ===============================
   CLIENT GROUPS STATE
================================ */
let clientGroups = [
  { id: 1, title: "Gold" },
  { id: 2, title: "Silver" },
  { id: 3, title: "VIP" }
];

let clientGroupPage = 1;
let clientGroupLimit = 10;
let editingClientGroupId = null;
let teamMembers = [
  { id: 1, name: "John Doe", role: "Web Developer" },
  { id: 2, name: "Michael Wood", role: "Web Developer" },
  { id: 3, name: "Sara Ann", role: "Web Designer" },
  { id: 4, name: "Richard Gray", role: "Web Developer" },
  { id: 5, name: "Mark Thomas", role: "Web Developer" },
  { id: 6, name: "Ayan Francis", role: "Team member" },
  { id: 7, name: "Vineeth AAA", role: "Developer" }
];
let storeSettings = {
  visibleBeforeLogin: true,
  acceptOrderBeforeLogin: false,
  showPaymentAfterOrder: true,
  orderStatusAfterPayment: "Processing",
  bannerImage: "assets/images/content.jpg"
};
let contractSettings = JSON.parse(localStorage.getItem("contractSettings")) || {
  prefix: "CONTRACT #",
  color: "#000000",
  bccEmail: "",
  initialNumber: 21,
  defaultTemplate: "Template 3.6",
  signClient: false,
  signTeam: false,
  lockState: false,
  disablePdf: false
};
let plugins = []; // empty like screenshot

let pluginPage = 1;
let pluginLimit = 10;

/* ===============================
   PAYMENT METHODS STATE
================================ */
let paymentMethods = [
  {
    id: 1,
    title: "Cash",
    description: "Cash payments",
    availableOnInvoice: "-",
    minAmount: "-"
  },
  {
    id: 2,
    title: "Stripe",
    description: "Stripe online payments",
    availableOnInvoice: "No",
    minAmount: "-"
  },
  {
    id: 3,
    title: "PayPal Payments Standard",
    description: "PayPal Payments Standard Online Payments",
    availableOnInvoice: "No",
    minAmount: "-"
  },
  {
    id: 4,
    title: "Paytm",
    description: "Paytm online payments",
    availableOnInvoice: "No",
    minAmount: "-"
  },
  {
    id: 5,
    title: "Client Wallet",
    description: "Client wallet to store and allocate funds to invoices",
    availableOnInvoice: "-",
    minAmount: "-"
  }
];

let paymentPage = 1;
let paymentLimit = 10;
let editingPaymentId = null;
/* ===============================
   TASK STATE
================================ */

let activeTaskTab = "settings";

let taskSettings = {
  recurring: true,
  createBefore: "-",
  preReminder: "1 Day",
  dayReminder: true,
  overdueReminder: "-",
  pointRange: "1-5",
  showKanban: ["ID"],
  showTime: false,
  showStatusCheckbox: true,
  projectOnlyGlobal: false
};

let taskStatuses = [
  { id: 1, title: "Open" },
  { id: 2, title: "In Progress" },
  { id: 3, title: "Completed" }
];

let editingTaskStatusId = null;
/* ===============================
   CUSTOM FIELDS STATE
================================ */

let customFieldTabs = [
  "Clients","Client contacts","Companies","Contracts","Estimates","Events",
  "Expenses","Invoices","Items","Leads","Lead contacts","Orders","Projects",
  "Project files","Proposals","Subscriptions","Tasks","Team members","Tickets","Timesheets"
];

let activeCustomTab = "Lead contacts";

let customFields = {
  "Lead contacts": [
    {
      id: 1,
      title: "hjjkj",
      type: "Text",
      required: false,
      showInTable: false,
      showInOrder: false,
      adminOnly: false,
      hideFromClients: false
    }
  ]
};
let eventSettings = {
  earlyReminder: "-"
};
let expenseCategories = [
  { id: 1, title: "Advertising" },
  { id: 2, title: "Electricity" },
  { id: 3, title: "Miscellaneous" },
  { id: 4, title: "Office Rent" },
  { id: 5, title: "Salary" },
  { id: 6, title: "Software Licenses" },
  { id: 7, title: "Utilities" }
];

let expensePage = 1;
let expenseLimit = 10;
let editingExpenseId = null;
/* ===============================
   PROJECT STATE
================================ */

let activeProjectTab = "settings";

let projectSettings = {
  tabOrder: ""
};

let projectStatuses = [
  { id: 1, title: "Open", icon: "fa-th-large" },
  { id: 2, title: "Completed", icon: "fa-check-circle" }
];

let editingProjectStatusId = null;
let editingCustomFieldId = null;
let taxes = [
  { id: 1, name: "Tax", percentage: 10 }
];
/* ===============================
   TIMESHEET STATE
================================ */
let timesheetSettings = {
  multipleTimers: false,
  totalHoursOnly: false
};
let taxPage = 1;
let taxLimit = 10;
let editingTaxId = null;
/* ===============================
   TICKET STATE
================================ */
let ticketTab = "types";

let ticketTypes = [
  { id: 1, name: "Bug Reports" },
  { id: 2, name: "General Support" },
  { id: 3, name: "Sales Inquiry" }
];
/* ===============================
   LEADS STATE
================================ */
let leadTab = "status";

let leadStatuses = [
  { id: 1, title: "New", color: "#f1c40f" },
  { id: 2, title: "Qualified", color: "#3498db" },
  { id: 3, title: "Discussion", color: "#20c997" },
  { id: 4, title: "Negotiation", color: "#d6b3ff" },
  { id: 5, title: "Won", color: "#8bc34a" },
  { id: 6, title: "Lost", color: "#e74c3c" }
];

let leadSources = [
  { id: 1, title: "Google" },
  { id: 2, title: "Facebook" },
  { id: 3, title: "Twitter" },
  { id: 4, title: "Youtube" },
  { id: 5, title: "Elsewhere" },
  { id: 6, title: "Site" },
  { id: 7, title: "Google ads" }
];

let leadSettings = {
  publicForm: false,
  embeddedForm: false,
  hiddenFields: ""
};

let editingLeadId = null;
let editingLeadSourceId = null;

const leadColors = [
  "#8bc34a","#20c997","#3498db","#95a5a6",
  "#f1c40f","#f39c12","#e74c3c","#d63384",
  "#9b59b6","#0dcaf0","#2c3e50",
  "#e0b0ff","#4f83ff"
];
/* ===============================
   GDPR STATE
================================ */
let gdprSettings = {
  enabled: false
};
const BASE_PAGE_URL = "http://localhost/internhrms/index.php/about/";

let pages = [
  {
    id: 1,
    title: "Custom Page Example",
    slug: "custom-page-example",
    content: "<p>Sample content</p>",
    status: "Active",
    hideTopbar: false
  },
  {
    id: 2,
    title: "Terms and conditions",
    slug: "terms-and-conditions",
    content: "<p>Terms content</p>",
    status: "Active",
    hideTopbar: false
  }
];

let editingPageId = null;
let ticketSettings = {
  recentFirst: true,
  projectReference: false,
  prefix: "",
  autoCloseDays: "",
  autoReply: false,
  embeddedForm: false
};

let ticketAutomations = [];
let editingTicketTypeId = null;
let teams = [
  { id: 1, title: "Developer", members: [1,2,3] },
  { id: 2, title: "Management", members: [4,5] }
];

let editingTeamId = null;

let currentUserRoleTab = "active";
let editingUserId = null;

let notifyPage = 1;
let notifyLimit = 5;
let editingNotifyIndex = null;

/* ===============================
   LOAD PAGE
================================ */
function loadPage(page) {

  /* ---------- GENERAL ---------- */
  if (page === "general") {
    document.getElementById("settingsContent").innerHTML = `
      <h4 class="mb-3">General Settings</h4>

      <ul class="nav nav-tabs mb-4">
        <li class="nav-item"><button class="nav-link active" onclick="showGeneralTab('ui',event)">UI Options</button></li>
        <li class="nav-item"><button class="nav-link" onclick="showGeneralTab('top',event)">Top menu</button></li>
        <li class="nav-item"><button class="nav-link" onclick="showGeneralTab('footer',event)">Footer</button></li>
        <li class="nav-item"><button class="nav-link" onclick="showGeneralTab('pwa',event)">PWA</button></li>
      </ul>

      <div id="generalTabContent"></div>
      <button class="btn btn-primary mt-4" onclick="saveSettings()">✓ Save</button>
    `;
    showGeneralTab("ui");
    return;
  }

  if (page === "localization") { renderLocalization(); return; }
  if (page === "email") { renderEmailSettings(); return; }
  if (page === "modules") { renderModules(); return; }
  if (page === "left_menu") { renderLeftMenu(); return; }
 if (page === "notifications") { renderNotifications(); return; }
 if (page === "integration") { renderIntegration(); return; }
 if (page === "cron") { renderCronJob(); return; }
if (page === "roles") { renderRoles(); return; }
if (page === "user_roles") {
  renderUserRoles();
  return;
}
if (page === "team") { renderTeam(); return; }
if (page === "ip") { 
  renderIPRestriction(); 
  return; 
}
if (page === "client_permissions") {
  renderClientPermissions();
  return;
}
if (page === "company") {
  renderCompanyPage();
  return;
}
if (page === "item_categories") {
  renderItemCategories();
  return;
}
if (page === "store") {
  renderStoreSettings();
  return;
}
if (page === "contracts") {
  renderContractSettings();
  return;
}
if (page === "taxes") {
  renderTaxesPage();
  return;
}
if (page === "payment_methods") {
  renderPaymentMethods();
  return;
}
if (page === "plugins") {
  renderPlugins();
  return;
}
if (page === "custom_fields") {
  renderCustomFields();
  return;
}
if (page === "client_groups") {
  renderClientGroups();
  return;
}
if (page === "tasks") {
  renderTaskSection("settings");
  return;
}
if (page === "projects") {
  renderProjectSection("settings");
  return;
}
if (page === "timesheets") {
  renderTimesheetSettings();
  return;
}
if (page === "events") {
  renderEventSettings();
  return;
}
 if (page === "reminders") {
  renderRemindersSettings();
  return;
}
if (page === "expense_categories") {
  renderExpenseCategories();
  return;
}
if (page === "leave_types") {
  renderLeaveTypes();
  return;
}
if (page === "tickets") {
  renderTicketSection("types");
  return;
}
if (page === "leads") {
  renderLeadSection("status");
  return;
}
if (page === "gdpr") {
  renderGDPRSettings();
  return;
}
if (page === "pages") {
  renderPages();
  return;
}

  document.getElementById("settingsContent").innerHTML =
    `<h4>${page.replace('_',' ')}</h4><p>Settings content</p>`;
}

/* ===============================
   GENERAL TABS
================================ */
function showGeneralTab(tab, e) {
  if (e) {
    document.querySelectorAll(".nav-link").forEach(b => b.classList.remove("active"));
    e.target.classList.add("active");
  }

  let html = "";

  if (tab === "ui") {
    html = `
      <div class="mb-3 d-flex justify-content-between"><span>Enable rich text editor</span><input type="checkbox" checked></div>
      <div class="mb-3 d-flex justify-content-between"><span>Enable audio recording</span><input type="checkbox" checked></div>
      <div class="mb-3 d-flex justify-content-between"><span>Show theme color changer</span><input type="checkbox" checked></div>
      <div class="mb-3"><label>Rows per page</label><select class="form-select w-25"><option>10</option><option>25</option></select></div>
      <div class="mb-3"><label>Scrollbar</label><select class="form-select w-25"><option>Native</option></select></div>
      <div class="mb-3"><label>Filter Bar</label><select class="form-select"><option>Keep filter bar collapsed</option></select></div>
      <div class="mb-3 d-flex justify-content-between"><span>Hide chat icon</span><input type="checkbox"></div>
      <div class="mb-3"><label>Phone input default country</label><select class="form-select w-50"><option>United States</option><option>India</option></select></div>
    `;
  }

  if (tab === "top" || tab === "footer") {
    let list = tab === "top" ? topMenuItems : footerMenuItems;
    html = `
      <ul class="list-group mb-3">
        ${list.map(m=>`
          <li class="list-group-item d-flex justify-content-between">
            <span>☰ ${m.name}</span>
            <span>
              <button class="btn btn-sm">✏</button>
              <button class="btn btn-sm text-danger">✕</button>
            </span>
          </li>`).join("")}
      </ul>
    `;
  }

  if (tab === "pwa") {
    html = `
      <div class="mb-3"><label>Icon (192×192)</label><input type="file" class="form-control w-50"></div>
      <div class="mb-3"><label>App color</label><input type="color" class="form-control form-control-color"></div>
    `;
  }

  document.getElementById("generalTabContent").innerHTML = html;
}

/* ===============================
   LOCALIZATION
================================ */
function renderLocalization() {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Localization Settings</h4>
    ${locRow("Language", locSelect(["English","Hindi"], localization.language))}
    ${locRow("Timezone", locSelect(["UTC","Asia/Kolkata"], localization.timezone))}
    ${locRow("Date Format", locSelect(["d-m-Y","Y-m-d"], localization.dateFormat))}
    ${locRow("Time Format", locSelect(["12 am","24 h"], localization.timeFormat))}
    ${locRow("First Day of Week", locSelect(["Sunday","Monday"], localization.firstDay))}
    ${locRow("Weekends", weekendsHtml())}
    ${locRow("Currency", locSelect(["USD","INR"], localization.currency))}
    ${locRow("Currency Symbol", `<input class="form-control w-25" value="${localization.currencySymbol}">`)}
    ${locRow("Currency Position", locSelect(["Left","Right"], localization.currencyPosition))}
    ${locRow("Decimal Separator", locSelect(["Dot (.)","Comma (,)"], localization.decimalSeparator))}
    ${locRow("No. of decimals", locSelect(["0","1","2","3"], localization.decimals))}
    ${locRow("Conversion rate", conversionHtml())}
    <button class="btn btn-primary mt-4" onclick="saveSettings()">✓ Save</button>
  `;
}

/* ===============================
   EMAIL SETTINGS
================================ */
function renderEmailSettings() {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Email Settings</h4>
    ${locRow("Email protocol", `<select class="form-select w-50"><option>Mail</option><option>SMTP</option></select>`)}
    ${locRow("Email sent from name", `<input class="form-control w-75" value="${emailSettings.fromName}">`)}
    ${locRow("Email sent from address", `<input class="form-control w-75" value="${emailSettings.fromAddress}">`)}
    ${locRow("Send a test mail to", `
      <div class="d-flex gap-2">
        <input id="testEmailInput" class="form-control w-50">
        <button class="btn btn-outline-primary btn-sm" onclick="sendTestMail()">Send</button>
      </div>`)}
    <button class="btn btn-primary mt-4" onclick="saveSettings()">✓ Save</button>
  `;
}

function sendTestMail() {
  let email = document.getElementById("testEmailInput").value;
  if (!email) {
    new bootstrap.Modal(document.getElementById("emailErrorModal")).show();
    return;
  }
  new bootstrap.Modal(document.getElementById("saveSuccessModal")).show();
}

/* ===============================
   MODULES
================================ */
function renderModules() {
  let html = `<h4 class="mb-1">Manage Modules</h4>
              <p class="text-muted mb-4">Select the modules you want to use.</p>`;

  Object.keys(modulesState).forEach(group => {
    html += `<h6 class="mb-3">${group}</h6><div class="row mb-4">`;
    modulesState[group].forEach(m => {
      html += `
        <div class="col-md-3 mb-3">
          <div class="card p-3 text-center">
            <div class="form-check form-switch d-flex justify-content-center mb-2">
              <input class="form-check-input" type="checkbox" checked>
            </div>
            <div>${m}</div>
          </div>
        </div>`;
    });
    html += `</div>`;
  });

  html += `<button class="btn btn-primary" onclick="saveSettings()">✓ Save</button>`;
  document.getElementById("settingsContent").innerHTML = html;
}

/* ===============================
   LEFT MENU BUILDER
================================ */
function renderLeftMenu() {
  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Left menu</h4>
      <button class="btn btn-primary" onclick="saveSettings()">✓ Save</button>
    </div>

    <p class="text-muted">
      This will be the default left menu for team members.
    </p>

    <div class="row">

      <!-- AVAILABLE -->
      <div class="col-md-4">
        <div class="card p-3">
          <h6>Available menu items</h6>
          <p class="text-muted">No more items available</p>
        </div>
      </div>

      <!-- LEFT MENU -->
      <div class="col-md-4">
        <div class="card p-3" style="max-height:420px;overflow-y:auto">
          <h6>Left menu</h6>

          ${leftMenuItems.map(item=>`
            <div class="border rounded p-2 mb-2 d-flex align-items-center gap-2"
                 style="cursor:pointer"
                 onclick="openMenuPage('${item}')">
              <span>↕</span>
              <span>${item}</span>
            </div>
          `).join("")}
        </div>
      </div>

      <!-- PREVIEW -->
      <div class="col-md-4">
        <div class="card p-3" style="max-height:420px;overflow-y:auto">
          <h6>Preview</h6>

          <div class="text-center mb-3">
            <img src="assets/images/tech-logo21.webp" height="40">
          </div>

          ${leftMenuItems.map(item=>`
            <div class="d-flex align-items-center gap-2 mb-2"
                 style="cursor:pointer"
                 onclick="openMenuPage('${item}')">
              <i class="fa-solid fa-circle-dot"></i>
              <span>${item}</span>
            </div>
          `).join("")}
        </div>
      </div>

    </div>
  `;
}


/* ===============================
   HELPERS
================================ */
function locRow(label, field) {
  return `<div class="row mb-3">
    <div class="col-md-4 text-muted">${label}</div>
    <div class="col-md-8">${field}</div>
  </div>`;
}

function locSelect(options, selected) {
  return `<select class="form-select w-50">
    ${options.map(o=>`<option ${o===selected?"selected":""}>${o}</option>`).join("")}
  </select>`;
}

function weekendsHtml() {
  return localization.weekends.map((d,i)=>`
    <span class="badge bg-light text-dark me-2">
      ${d}
      <button class="btn btn-sm" onclick="removeWeekend(${i})">×</button>
    </span>`).join("");
}

function conversionHtml() {
  return localization.conversions.map(()=>`
    <div class="d-flex gap-2 mb-2">
      <select class="form-select w-25"><option>AED</option></select>
      <input class="form-control w-25">
    </div>`).join("") +
    `<button class="btn btn-sm btn-outline-primary" onclick="addConversion()">＋ Add more</button>`;
}

function removeWeekend(i){ localization.weekends.splice(i,1); renderLocalization(); }
function addConversion(){ localization.conversions.push({}); renderLocalization(); }

/* ===============================
   SAVE
================================ */
function saveSettings() {
  new bootstrap.Modal(document.getElementById("saveSuccessModal")).show();
}

/* ===============================
   🔔 NOTIFICATION RENDER
================================ */
function renderNotifications() {

  let start = (notifyPage - 1) * notifyLimit;
  let rows = notificationData.slice(start, start + notifyLimit);

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Notification Settings</h4>

    <div class="d-flex justify-content-between mb-3">
      <select class="form-select w-auto">
        <option>- Category -</option>
        <option>Order</option>
        <option>Project</option>
      </select>
      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Event</th>
          <th>Notify to</th>
          <th>Category</th>
          <th class="text-center">Enable email</th>
          <th class="text-center">Enable web</th>
          <th class="text-center">Enable slack</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        ${rows.map((n,i)=>`
          <tr>
            <td>${n.event}</td>
            <td>${n.notify.map(x=>`• ${x}`).join("<br>")}</td>
            <td>${n.category}</td>
            <td class="text-center">
              <i class="fa-regular fa-circle-check ${n.email?'text-primary':'text-muted'}"
                 onclick="toggleNotify(${start+i},'email')"></i>
            </td>
            <td class="text-center">
              <i class="fa-regular fa-circle-check ${n.web?'text-primary':'text-muted'}"
                 onclick="toggleNotify(${start+i},'web')"></i>
            </td>
            <td class="text-center">
              <i class="fa-regular fa-circle-check ${n.slack?'text-primary':'text-muted'}"
                 onclick="toggleNotify(${start+i},'slack')"></i>
            </td>
            <td>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="openNotifyEdit(${start+i})">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    ${renderNotifyPagination()}
  `;
}

function toggleNotify(i,type){
  notificationData[i][type] = !notificationData[i][type];
  renderNotifications();
}

function renderNotifyPagination(){
  let pages = Math.ceil(notificationData.length / notifyLimit);
  return `
    <div class="d-flex justify-content-end gap-2">
      ${Array.from({length:pages},(_,i)=>`
        <button class="btn btn-sm ${notifyPage===i+1?'btn-primary':'btn-outline-primary'}"
          onclick="notifyPage=${i+1};renderNotifications()">
          ${i+1}
        </button>
      `).join("")}
    </div>
  `;
}

/* ===============================
   🔔 EDIT MODAL
================================ */
function openNotifyEdit(i){
  editingNotifyIndex = i;
  document.getElementById("notifyEvent").value = notificationData[i].event;
  document.getElementById("notifyCategory").value = notificationData[i].category;
  new bootstrap.Modal(document.getElementById("notifyEditModal")).show();
}

function saveNotifyEdit(){
  notificationData[editingNotifyIndex].event =
    document.getElementById("notifyEvent").value;
  notificationData[editingNotifyIndex].category =
    document.getElementById("notifyCategory").value;

  bootstrap.Modal.getInstance(
    document.getElementById("notifyEditModal")
  ).hide();

  renderNotifications();
}
/* ===============================
   INTEGRATION UI
================================ */
function renderIntegration(tab = "recaptcha") {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Integration</h4>

    <ul class="nav nav-tabs mb-4">
      ${integrationTab("recaptcha","reCAPTCHA",tab)}
      ${integrationTab("googleDrive","Google Drive",tab)}
      ${integrationTab("pusher","Pusher",tab)}
      ${integrationTab("slack","Slack",tab)}
      ${integrationTab("bitbucket","Bitbucket",tab)}
      ${integrationTab("github","GitHub",tab)}
      ${integrationTab("tinymce","TinyMCE",tab)}
    </ul>

    <div id="integrationContent">
      ${renderIntegrationContent(tab)}
    </div>
  `;
}

function integrationTab(key,label,active){
  return `
    <li class="nav-item">
      <button class="nav-link ${active===key?'active':''}"
        onclick="renderIntegration('${key}')">${label}</button>
    </li>`;
}

/* ===============================
   TAB CONTENT
================================ */
function renderIntegrationContent(tab){

  if(tab==="recaptcha"){
    return `
      <p>Get your key from here: <a href="#" class="text-primary">Google reCAPTCHA</a></p>

      ${locRow("reCAPTCHA Protocol",
        `<select class="form-select w-50">
          <option>v2 Checkbox</option>
        </select>`)}

      ${locRow("Site key",
        `<input class="form-control" placeholder="Site key">`)}

      ${locRow("Secret key",
        `<input class="form-control" placeholder="Secret key">`)}

      <p class="text-muted mt-3">
        Before you logout, please open a new browser and make sure the reCaptcha is working.
      </p>

      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  if(tab==="googleDrive"){
    return `
      ${toggleRow("Enable Google Drive API to upload file","googleDrive")}
      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  if(tab==="pusher"){
    return `
      ${toggleRow("Enable push notification","pusher")}
      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  if(tab==="slack"){
    return `
      ${toggleRow("Enable slack","slack")}
      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  if(tab==="bitbucket"){
    return `
      ${toggleRow("Enable bitbucket commit logs in tasks","bitbucket")}
      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  if(tab==="github"){
    return `
      ${toggleRow("Enable github commit logs in tasks","github")}
      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  if(tab==="tinymce"){
    return `
      ${toggleRow("Enable TinyMCE","tinymce")}
      <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
    `;
  }

  return "";
}

/* ===============================
   TOGGLE HELPER
================================ */
function toggleRow(label,key){
  return `
    <div class="row mb-3">
      <div class="col-md-6">${label}</div>
      <div class="col-md-6">
        <input type="checkbox"
          ${integrationState[key].enabled?'checked':''}
          onchange="integrationState['${key}'].enabled=this.checked">
      </div>
    </div>
  `;
}
/* ===============================
   CRON JOB
================================ */
function renderCronJob() {

  const cronUrl = "http://localhost/internhrms/index.php/cron";

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Cron Job</h4>

    ${locRow("Cron Job link",
      `<a href="${cronUrl}" target="_blank">${cronUrl}</a>`
    )}

    ${locRow("Last Cron Job run",
      `<span class="badge bg-danger">Never</span>`
    )}

    ${locRow("Recommended execution interval",
      `Every 10 minutes`
    )}

    ${locRow("cPanel Cron Job Command *",
      `<input class="form-control" readonly
        value="wget -q -O- ${cronUrl}">`
    )}

    <button class="btn btn-outline-primary mt-3"
      onclick="triggerCronJob()">
      Trigger Manually
    </button>
  `;
}
function triggerCronJob() {
  fetch("http://localhost/internhrms/index.php/cron")
    .then(() => {
      new bootstrap.Modal(
        document.getElementById("saveSuccessModal")
      ).show();
    })
    .catch(() => {
      alert("Cron job failed");
    });
}
let roles = [
  { id: 1, name: "Developer" },
  { id: 2, name: "Project Manager" }
];

let activeRole = null;
function renderRoles() {
  document.getElementById("settingsContent").innerHTML = `
    <div class="row">

      <!-- LEFT SIDE -->
      <div class="col-md-4 border-end">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5>Roles</h5>
          <button class="btn btn-sm btn-outline-primary" onclick="addRole()">+ Add role</button>
        </div>

        <div class="list-group">
          ${roles.map(r => `
            <div class="list-group-item d-flex justify-content-between align-items-center
              ${activeRole === r.id ? 'active' : ''}"
              onclick="openRole(${r.id})"
              style="cursor:pointer">

              <span>${r.name}</span>

              <span class="d-flex gap-2">
                <i class="fa fa-sliders"
                   title="Permissions"
                   onclick="event.stopPropagation(); openRole(${r.id})"></i>

                <i class="fa fa-pen"
                   title="Edit"
                   onclick="event.stopPropagation(); editRole(${r.id})"></i>

                <i class="fa fa-times text-danger"
                   title="Delete"
                   onclick="event.stopPropagation(); deleteRole(${r.id})"></i>
              </span>

            </div>
          `).join("")}
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="col-md-8">
        <div id="rolePermissionArea" class="p-3 text-muted text-center">
          <h5>Select a role</h5>
        </div>
      </div>

    </div>
  `;
}

function openRole(roleId) {
  activeRole = roleId;
  renderRoles(); // re-render to highlight active role

  document.getElementById("rolePermissionArea").innerHTML = `
    <h5 class="mb-3">Permissions: ${getRoleName(roleId)}</h5>

    ${permissionSection("Set project permissions", [
      "Don't show projects",
      "Can manage all projects",
      "Can create projects",
      "Can edit projects",
      "Can delete projects",
      "Can add/remove project members"
    ])}

    ${permissionSection("Set task permissions", [
      "Can create tasks",
      "Can edit tasks",
      "Can delete tasks",
      "Can comment on tasks"
    ])}

    ${permissionSection("Administration permissions", [
      "Can manage all kinds of settings",
      "Can add/remove team members",
      "Can activate/deactivate team members"
    ])}

    ${radioSection("Can manage team member's leaves?", [
      "No",
      "Yes, all members",
      "Yes, specific members or teams"
    ])}

    ${radioSection("Can access tickets?", [
      "No",
      "Yes, all tickets",
      "Yes, assigned tickets only"
    ])}

    ${permissionSection("Invoice permissions", [
      "Can't access invoices",
      "Can manage invoices",
      "Can view all invoices"
    ])}

    <button class="btn btn-primary mt-4" onclick="saveRolePermissions()">✓ Save</button>
  `;
}
function getRoleName(id) {
  return roles.find(r => r.id === id)?.name || "";
}

function permissionSection(title, items) {
  return `
    <div class="mb-4">
      <strong>${title}:</strong>
      <div class="mt-2">
        ${items.map(i => `
          <div class="form-check">
            <input class="form-check-input" type="checkbox" checked>
            <label class="form-check-label">${i}</label>
          </div>
        `).join("")}
      </div>
    </div>
  `;
}

function radioSection(title, options) {
  return `
    <div class="mb-4">
      <strong>${title}</strong>
      <div class="mt-2">
        ${options.map((o, i) => `
          <div class="form-check">
            <input class="form-check-input" type="radio" name="${title}">
            <label class="form-check-label">${o}</label>
          </div>
        `).join("")}
      </div>
    </div>
  `;
}

function saveRolePermissions() {
  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
let currentRoleAction = null;
let currentRoleId = null;

/* ADD ROLE */
function addRole() {
  currentRoleAction = "add";
  currentRoleId = null;
  document.getElementById("roleModalTitle").innerText = "Add Role";
  document.getElementById("roleNameInput").value = "";
  new bootstrap.Modal(document.getElementById("roleModal")).show();
}

/* EDIT ROLE */
function editRole(id) {
  currentRoleAction = "edit";
  currentRoleId = id;

  const role = roles.find(r => r.id === id);
  document.getElementById("roleModalTitle").innerText = "Edit Role";
  document.getElementById("roleNameInput").value = role.name;

  new bootstrap.Modal(document.getElementById("roleModal")).show();
}

/* SAVE ROLE (ADD / EDIT) */
function saveRole() {
  const name = document.getElementById("roleNameInput").value.trim();
  if (!name) return;

  if (currentRoleAction === "add") {
    const id = Date.now();
    roles.push({ id, name });
    activeRole = id;
  }

  if (currentRoleAction === "edit") {
    const role = roles.find(r => r.id === currentRoleId);
    role.name = name;
  }

  bootstrap.Modal.getInstance(document.getElementById("roleModal")).hide();
  renderRoles();
}

/* DELETE ROLE */
function deleteRole(id) {
  currentRoleId = id;
  new bootstrap.Modal(document.getElementById("deleteRoleModal")).show();
}

function confirmDeleteRole() {
  roles = roles.filter(r => r.id !== currentRoleId);

  if (activeRole === currentRoleId) {
    activeRole = null;
    document.getElementById("rolePermissionArea").innerHTML =
      `<h5>Select a role</h5>`;
  }

  bootstrap.Modal.getInstance(
    document.getElementById("deleteRoleModal")
  ).hide();

  renderRoles();
}
function renderUserRoles() {
  const list = userRolesData[currentUserRoleTab];

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-3">User Roles</h4>

    <!-- TABS + ACTIONS -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="btn-group">
        <button class="btn ${currentUserRoleTab==='active'?'btn-primary':'btn-outline-secondary'}"
          onclick="switchUserRoleTab('active')">
          Active members
        </button>
        <button class="btn ${currentUserRoleTab==='inactive'?'btn-primary':'btn-outline-secondary'}"
          onclick="switchUserRoleTab('inactive')">
          Inactive members
        </button>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="window.print()">Print</button>
        <input class="form-control" style="width:200px" placeholder="Search">
      </div>
    </div>

    <!-- TABLE -->
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Team members</th>
          <th>Role</th>
          <th class="text-end"></th>
        </tr>
      </thead>
      <tbody>
        ${list.map(u => `
          <tr>
            <td>
              <a href="javascript:void(0)" class="text-primary">${u.name}</a>
            </td>
            <td>${u.role}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary"
                onclick="openEditUserRole(${u.id})">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    <!-- PAGINATION (STATIC LIKE SCREENSHOT) -->
    <div class="d-flex justify-content-between align-items-center">
      <select class="form-select w-auto">
        <option>10</option>
      </select>

      <div class="text-muted">
        1-${list.length} / ${list.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm">‹</button>
        <button class="btn btn-outline-secondary btn-sm">1</button>
        <button class="btn btn-outline-secondary btn-sm">›</button>
      </div>
    </div>
  `;
}
function switchUserRoleTab(tab) {
  currentUserRoleTab = tab;
  renderUserRoles();
}
function openEditUserRole(userId) {
  editingUserId = userId;

  const user =
    userRolesData.active.find(u => u.id === userId) ||
    userRolesData.inactive.find(u => u.id === userId);

  document.getElementById("editUserName").innerText = user.name;
  document.getElementById("editUserRoleSelect").value = user.role;

  new bootstrap.Modal(document.getElementById("editUserRoleModal")).show();
}
function saveUserRoleChange() {
  const newRole = document.getElementById("editUserRoleSelect").value;

  ["active","inactive"].forEach(group => {
    const u = userRolesData[group].find(x => x.id === editingUserId);
    if (u) u.role = newRole;
  });

  bootstrap.Modal.getInstance(
    document.getElementById("editUserRoleModal")
  ).hide();

  renderUserRoles();
}
let teamPage = 1;
let teamLimit = 10;

function renderTeam() {

  const start = (teamPage - 1) * teamLimit;
  const paginatedTeams = teams.slice(start, start + teamLimit);
  const totalPages = Math.ceil(teams.length / teamLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Team</h4>
      <button class="btn btn-outline-primary" onclick="openTeamModal()">+ Add team</button>
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th>Team members</th>
          <th class="text-end"></th>
        </tr>
      </thead>
      <tbody>
        ${paginatedTeams.map(t => `
          <tr>
            <td>${t.title}</td>
            <td>
              <span class="badge bg-light text-dark"
                style="cursor:pointer"
                onclick="viewTeamMembers(${t.id})">
                👥 ${t.members.length}
              </span>
            </td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary"
                onclick="editTeam(${t.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger"
                onclick="deleteTeam(${t.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    ${renderTeamPagination(totalPages)}
  `;
}
function renderTeamPagination(totalPages) {

  if (totalPages <= 1) return "";

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="teamLimit=this.value; teamPage=1; renderTeam()">
        <option ${teamLimit==10?'selected':''}>10</option>
        <option ${teamLimit==25?'selected':''}>25</option>
        <option ${teamLimit==50?'selected':''}>50</option>
      </select>

      <div class="d-flex align-items-center gap-2">

        <button class="btn btn-sm btn-outline-secondary"
          ${teamPage===1?'disabled':''}
          onclick="teamPage--; renderTeam()">
          ‹
        </button>

        ${Array.from({length: totalPages}, (_, i) => `
          <button class="btn btn-sm ${teamPage===i+1?'btn-primary':'btn-outline-primary'}"
            onclick="teamPage=${i+1}; renderTeam()">
            ${i+1}
          </button>
        `).join("")}

        <button class="btn btn-sm btn-outline-secondary"
          ${teamPage===totalPages?'disabled':''}
          onclick="teamPage++; renderTeam()">
          ›
        </button>

      </div>
    </div>
  `;
}

function openTeamModal() {
  editingTeamId = null;
  document.getElementById("teamModalTitle").innerText = "Add team";
  document.getElementById("teamTitleInput").value = "";
  renderTeamMemberSelect([]);
  new bootstrap.Modal(document.getElementById("teamModal")).show();
}

function editTeam(id) {
  editingTeamId = id;
  const team = teams.find(t => t.id === id);
  document.getElementById("teamModalTitle").innerText = "Edit team";
  document.getElementById("teamTitleInput").value = team.title;
  renderTeamMemberSelect(team.members);
  new bootstrap.Modal(document.getElementById("teamModal")).show();
}

function renderTeamMemberSelect(selected) {
  document.getElementById("teamMemberSelect").innerHTML =
    teamMembers.map(m => `
      <option value="${m.id}" ${selected.includes(m.id) ? "selected" : ""}>
        ${m.name}
      </option>
    `).join("");
}

function saveTeam() {
  const title = document.getElementById("teamTitleInput").value.trim();
  const members = [...document.getElementById("teamMemberSelect").selectedOptions]
                    .map(o => Number(o.value));

  if (!title) return;

  if (editingTeamId) {
    const team = teams.find(t => t.id === editingTeamId);
    team.title = title;
    team.members = members;
  } else {
    teams.push({
      id: Date.now(),
      title,
      members
    });
  }

  bootstrap.Modal.getInstance(document.getElementById("teamModal")).hide();
  renderTeam();
}
function viewTeamMembers(teamId) {
  const team = teams.find(t => t.id === teamId);
  document.getElementById("teamMembersList").innerHTML =
    team.members.map(id => {
      const m = teamMembers.find(x => x.id === id);
      return `
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>${m.name}</div>
          <span class="badge bg-primary">${m.role}</span>
        </div>
      `;
    }).join("");

  new bootstrap.Modal(document.getElementById("teamMembersModal")).show();
}
let deleteTeamId = null;

function deleteTeam(id) {
  deleteTeamId = id;
  new bootstrap.Modal(document.getElementById("deleteTeamModal")).show();
}

function confirmDeleteTeam() {
  teams = teams.filter(t => t.id !== deleteTeamId);

  const maxPage = Math.ceil(teams.length / teamLimit);
  if (teamPage > maxPage) teamPage = maxPage || 1;

  bootstrap.Modal.getInstance(
    document.getElementById("deleteTeamModal")
  ).hide();

  renderTeam();
}
function renderIPRestriction() {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">IP Restriction</h4>

    <p class="fw-semibold mb-2">
      Allow timecard access from these IPs only.
    </p>

    <textarea
      id="ipRestrictionInput"
      class="form-control mb-2"
      rows="8"
      placeholder="e.g.
192.168.1.1
103.25.64.0
2405:200:1000::"
    >${ipRestriction.allowedIPs}</textarea>

    <div class="text-muted mb-4">
      <i class="fa fa-info-circle me-1"></i>
      Enter one IP per line. Keep it blank to allow all IPs.
      <strong>Admin users will not be affected.</strong>
    </div>

    <button class="btn btn-primary" onclick="saveIPRestriction()">
      ✓ Save
    </button>
  `;
}
function saveIPRestriction() {
  ipRestriction.allowedIPs =
    document.getElementById("ipRestrictionInput").value.trim();

  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderClientPermissions() {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Client permissions</h4>

    ${section("Signup & Login", `
      ${toggle("Disable client signup", "disableSignup")}
      ${toggle("Verify email before client signup", "verifyEmail")}
      ${toggle("Disable client login", "disableLogin")}
      ${toggle("Disable user invitation option by clients", "disableInvitation")}

      ${row("Default permissions for non-primary contact",
        badgeSelect(clientPermissions.defaultPermissions))}
    `)}

    ${section("Collaboration", `
      ${row("Who can send/receive message to/from clients",
        multiSelect(clientPermissions.collaborationUsers))}
      ${toggle("Client can send/receive message to/from own contacts?",
        "clientToClientMessage")}
    `)}

    ${section("UI", `
      ${row("Hide menus from client portal",
        `<input class="form-control" placeholder="Hidden menus">`)}
      ${row("Set project tab order",
        `<input class="form-control" placeholder="Project tab order">`)}

      ${toggle("Disable access favorite project option for clients", "disableFavorite")}
      ${toggle("Disable editing left menu by clients", "disableLeftMenuEdit")}
      ${toggle("Disable topbar menu customization", "disableTopbarEdit")}
      ${toggle("Disable dashboard customization by clients", "disableDashboardEdit")}
    `)}

    ${section("Projects & Tasks", projectToggles())}

    ${section("Others", `
      ${toggle("Client can view files?", "others.viewFiles")}
      ${toggle("Client can add files?", "others.addFiles")}
      ${toggle("Client can access store?", "others.accessStore")}
      ${toggle("Client can create reminders?", "others.createReminders")}
      ${toggle("Client can access notes?", "others.accessNotes")}
    `)}

    <button class="btn btn-primary mt-3" onclick="saveSettings()">✓ Save</button>
  `;
}
function section(title, content) {
  return `
    <div class="mb-4">
      <h6 class="text-uppercase text-muted mb-3">${title}</h6>
      ${content}
    </div>
  `;
}

function toggle(label, key) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-2">
      <span>${label}</span>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox"
          ${getValue(key) ? "checked" : ""}
          onchange="setValue('${key}', this.checked)">
      </div>
    </div>
  `;
}

function row(label, field) {
  return `
    <div class="row mb-2">
      <div class="col-md-6">${label}</div>
      <div class="col-md-6">${field}</div>
    </div>
  `;
}

function badgeSelect(items) {
  return items.map(i =>
    `<span class="badge bg-light text-dark me-1">${i}</span>`
  ).join("");
}

function multiSelect(items) {
  return items.map(i =>
    `<span class="badge bg-light text-dark me-1">${i}</span>`
  ).join("");
}

function projectToggles() {
  return Object.entries(clientPermissions.project).map(([k, v]) =>
    toggle("Client can " + k.replace(/([A-Z])/g," $1").toLowerCase() + "?", "project."+k)
  ).join("");
}

function getValue(path) {
  return path.split(".").reduce((o,k)=>o[k], clientPermissions);
}

function setValue(path, val) {
  let obj = clientPermissions;
  let keys = path.split(".");
  keys.slice(0,-1).forEach(k => obj = obj[k]);
  obj[keys.at(-1)] = val;
}
function renderCompanyPage() {

  const start = (companyPage - 1) * companyLimit;
  const rows = companies.slice(start, start + companyLimit);
  const totalPages = Math.ceil(companies.length / companyLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Company Settings</h4>
      <button class="btn btn-outline-primary" onclick="openCompanyModal()">
        <i class="fa fa-plus me-1"></i> Add company
      </button>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Logo</th>
          <th>Company Info</th>
          <th class="text-end"></th>
        </tr>
      </thead>
      <tbody>
        ${rows.map(c => `
          <tr>
            <td>
              <img src="${c.logo}" height="60">
            </td>

            <td>
              <div class="fw-semibold">
                ${c.name}
                ${c.isDefault ? `<span class="badge bg-primary ms-2">Default company</span>` : ""}
              </div>
              <div class="text-muted small">
                ${c.address}<br>
                ${c.phone}<br>
                ${c.email}<br>
                ${c.website}
              </div>
            </td>

            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary"
                onclick="editCompany(${c.id})">
                <i class="fa fa-pen"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    ${renderCompanyPagination(totalPages)}
  `;
}
function renderCompanyPagination(totalPages) {

  if (totalPages <= 1) return "";

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="companyLimit=this.value; companyPage=1; renderCompanyPage()">
        <option ${companyLimit==10?'selected':''}>10</option>
        <option ${companyLimit==25?'selected':''}>25</option>
      </select>

      <div class="text-muted">
        ${(companyPage-1)*companyLimit+1} -
        ${Math.min(companyPage*companyLimit, companies.length)}
        / ${companies.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary"
          ${companyPage===1?'disabled':''}
          onclick="companyPage--; renderCompanyPage()">
          ‹
        </button>

        <button class="btn btn-sm btn-outline-secondary">
          ${companyPage}
        </button>

        <button class="btn btn-sm btn-outline-secondary"
          ${companyPage===totalPages?'disabled':''}
          onclick="companyPage++; renderCompanyPage()">
          ›
        </button>
      </div>
    </div>
  `;
}

function openCompanyModal() {
  editingCompanyId = null;
  document.getElementById("companyModalTitle").innerText = "Add company";

  ["companyName","companyAddress","companyPhone","companyEmail",
   "companyWebsite","companyVat","companyGst"].forEach(id=>{
     document.getElementById(id).value="";
   });

  document.getElementById("companyDefault").checked = false;
  new bootstrap.Modal(document.getElementById("companyModal")).show();
}

function editCompany(id) {
  editingCompanyId = id;
  const c = companies.find(x => x.id === id);

  document.getElementById("companyModalTitle").innerText = "Edit company";
  document.getElementById("companyName").value = c.name;
  document.getElementById("companyAddress").value = c.address;
  document.getElementById("companyPhone").value = c.phone;
  document.getElementById("companyEmail").value = c.email;
  document.getElementById("companyWebsite").value = c.website;
  document.getElementById("companyVat").value = c.vat;
  document.getElementById("companyGst").value = c.gst;
  document.getElementById("companyDefault").checked = c.isDefault;

  new bootstrap.Modal(document.getElementById("companyModal")).show();
}

function saveCompany() {

  const obj = {
    id: editingCompanyId || Date.now(),
    name: companyName.value,
    address: companyAddress.value,
    phone: companyPhone.value,
    email: companyEmail.value,
    website: companyWebsite.value,
    vat: companyVat.value,
    gst: companyGst.value,
    isDefault: companyDefault.checked,
    logo: "assets/images/tech-logo21.webp"
  };

  if (obj.isDefault) {
    companies.forEach(c => c.isDefault = false);
  }

  if (editingCompanyId) {
    const index = companies.findIndex(c => c.id === editingCompanyId);
    companies[index] = obj;
  } else {
    companies.push(obj);
  }

  bootstrap.Modal.getInstance(
    document.getElementById("companyModal")
  ).hide();

  renderCompanyPage();
}
function renderItemCategories() {

  const start = (categoryPage - 1) * categoryLimit;
  const rows = itemCategories.slice(start, start + categoryLimit);
  const totalPages = Math.ceil(itemCategories.length / categoryLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Item categories</h4>

      <button class="btn btn-outline-primary"
        onclick="openCategoryModal()">
        <i class="fa fa-plus me-1"></i> Add category
      </button>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th class="text-end">
            <i class="fa fa-arrow-up me-3"></i>
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        ${rows.map(c => `
          <tr>
            <td>${c.title}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary me-1"
                onclick="editCategory(${c.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteCategory(${c.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    ${renderCategoryPagination(totalPages)}
  `;
}
function renderCategoryPagination(totalPages) {

  if (totalPages <= 1) return "";

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="categoryLimit=this.value; categoryPage=1; renderItemCategories()">
        <option ${categoryLimit==10?'selected':''}>10</option>
        <option ${categoryLimit==25?'selected':''}>25</option>
      </select>

      <div class="text-muted">
        ${(categoryPage-1)*categoryLimit+1} -
        ${Math.min(categoryPage*categoryLimit, itemCategories.length)}
        / ${itemCategories.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary"
          ${categoryPage===1?'disabled':''}
          onclick="categoryPage--; renderItemCategories()">
          ‹
        </button>

        <button class="btn btn-sm btn-outline-secondary">
          ${categoryPage}
        </button>

        <button class="btn btn-sm btn-outline-secondary"
          ${categoryPage===totalPages?'disabled':''}
          onclick="categoryPage++; renderItemCategories()">
          ›
        </button>
      </div>
    </div>
  `;
}
function openCategoryModal() {
  editingCategoryId = null;
  document.getElementById("categoryModalTitle").innerText = "Add category";
  document.getElementById("categoryTitle").value = "";
  new bootstrap.Modal(document.getElementById("categoryModal")).show();
}

function editCategory(id) {
  editingCategoryId = id;
  const c = itemCategories.find(x => x.id === id);

  document.getElementById("categoryModalTitle").innerText = "Edit category";
  document.getElementById("categoryTitle").value = c.title;

  new bootstrap.Modal(document.getElementById("categoryModal")).show();
}

function saveCategory() {
  const title = document.getElementById("categoryTitle").value.trim();
  if (!title) return;

  if (editingCategoryId) {
    const c = itemCategories.find(x => x.id === editingCategoryId);
    c.title = title;
  } else {
    itemCategories.push({
      id: Date.now(),
      title
    });
  }

  bootstrap.Modal.getInstance(
    document.getElementById("categoryModal")
  ).hide();

  renderItemCategories();
}

function deleteCategory(id) {
  itemCategories = itemCategories.filter(c => c.id !== id);

  const maxPage = Math.ceil(itemCategories.length / categoryLimit);
  if (categoryPage > maxPage) categoryPage = maxPage || 1;

  renderItemCategories();
}
function storeRowCheckbox(label, hint, key) {
  return `
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
      <div>
        <div class="fw-semibold">${label}</div>
        ${hint ? `<div class="text-muted small mt-1">${hint}</div>` : ""}
      </div>

      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox"
          ${storeSettings[key] ? "checked" : ""}
          onchange="storeSettings['${key}'] = this.checked">
      </div>
    </div>
  `;
}

function renderStoreSettings() {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Store settings</h4>

    <div class="border rounded">

      ${storeRowCheckbox(
        "Visitors can see store before login",
        "You can set the store as landing page by adding 'store' in the landing page setting. <a href='#' class='text-primary'>General Settings</a>",
        "visibleBeforeLogin"
      )}

      ${storeRowCheckbox(
        "Accept order before login",
        "",
        "acceptOrderBeforeLogin"
      )}

      ${storeRowCheckbox(
        "Show payment option after submitting the order",
        "",
        "showPaymentAfterOrder"
      )}

      ${storeRowSelect(
        "Order status after payment",
        ["Processing", "Completed", "Pending"],
        storeSettings.orderStatusAfterPayment,
        "This will be applicable only when the order status is <strong>New</strong>."
      )}

      ${storeRowImage(
        "Banner image on public store",
        storeSettings.bannerImage
      )}

    </div>

    <button class="btn btn-primary mt-4" onclick="saveStoreSettings()">
      ✓ Save
    </button>
  `;
}
function storeRowSelect(label, options, value, hint) {
  return `
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
      <div>
        <div class="fw-semibold">${label}</div>
        <div class="text-muted small mt-1">${hint}</div>
      </div>

      <select class="form-select w-25"
        onchange="storeSettings.orderStatusAfterPayment=this.value">
        ${options.map(o => `
          <option ${o===value?'selected':''}>${o}</option>
        `).join("")}
      </select>
    </div>
  `;
}
function storeRowImage(label, img) {
  return `
    <div class="p-3">
      <div class="fw-semibold mb-2">${label}</div>

      <div class="d-flex align-items-center gap-3">
        <img src="${img}" height="80" class="border rounded">

        <button class="btn btn-outline-secondary btn-sm">
          <i class="fa fa-ellipsis-h"></i>
        </button>
      </div>
    </div>
  `;
}
function saveStoreSettings() {
  // simulate backend save
  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderContractSettings() {
  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Contract settings</h4>

    <div class="row mb-3">
      <div class="col-md-4 text-muted">Contract prefix</div>
      <div class="col-md-6">
        <input class="form-control"
          value="${contractSettings.prefix}"
          onchange="contractSettings.prefix=this.value">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4 text-muted">Contract color</div>
      <div class="col-md-6">
        <input type="color"
          value="${contractSettings.color}"
          onchange="contractSettings.color=this.value">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4 text-muted">
        When sending contract to client, send BCC to
      </div>
      <div class="col-md-6">
        <input class="form-control"
          value="${contractSettings.bccEmail}"
          placeholder="Email"
          onchange="contractSettings.bccEmail=this.value">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4 text-muted">Initial number of the contract</div>
      <div class="col-md-3">
        <input type="number"
          class="form-control"
          value="${contractSettings.initialNumber}"
          onchange="contractSettings.initialNumber=this.value">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4 text-muted">Default contract template</div>
      <div class="col-md-4">
        <select class="form-select"
          onchange="contractSettings.defaultTemplate=this.value">
          <option ${contractSettings.defaultTemplate==="Template 3.6"?"selected":""}>
            Template 3.6
          </option>
          <option>Template 4.0</option>
        </select>
      </div>
    </div>

    ${checkboxRow("Add signature option on accepting contract","signClient")}
    ${checkboxRow("Add signature option for team members","signTeam")}
    ${checkboxRow("Enable lock state","lockState")}
    ${checkboxRow("Disable PDF for clients","disablePdf")}

    <button class="btn btn-primary mt-3" onclick="saveContractSettings()">
      ✓ Save
    </button>
  `;
}

function checkboxRow(label,key){
  return `
    <div class="row mb-3">
      <div class="col-md-4 text-muted">${label}</div>
      <div class="col-md-6">
        <input type="checkbox"
          ${contractSettings[key]?"checked":""}
          onchange="contractSettings['${key}']=this.checked">
      </div>
    </div>
  `;
}

function saveContractSettings(){
  localStorage.setItem("contractSettings", JSON.stringify(contractSettings));
  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderContractsPage(contracts) {

  const settings =
    JSON.parse(localStorage.getItem("contractSettings")) || contractSettings;

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-3">Contracts</h4>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Contract</th>
          <th>Client</th>
          <th>Date</th>
          <th>Valid Until</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        ${contracts.map(c => `
          <tr>
            <td style="color:${settings.color}">
              ${settings.prefix}${c.id}<br>
              <small class="text-muted">${c.title}</small>
            </td>
            <td>${c.client}</td>
            <td>${c.contract_date}</td>
            <td>${c.valid_until}</td>
            <td>$${c.amount.toFixed(2)}</td>
            <td>
              <span class="badge bg-${c.status_color}">
                ${c.status}
              </span>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>
  `;
}
fetch("contracts_json.php")
  .then(res => res.json())
  .then(data => renderContractsPage(data));
function renderTaxesPage() {

  const start = (taxPage - 1) * taxLimit;
  const rows = taxes.slice(start, start + taxLimit);
  const totalPages = Math.ceil(taxes.length / taxLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Taxes</h4>

      <button class="btn btn-outline-primary" onclick="openTaxModal()">
        <i class="fa fa-plus me-1"></i> Add Tax
      </button>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Name</th>
          <th>
            <i class="fa fa-arrow-up me-2"></i> Percentage (%)
          </th>
          <th class="text-end">
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        ${rows.map(t => `
          <tr>
            <td>${t.name} (${t.percentage}%)</td>
            <td>${t.percentage}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary me-1"
                onclick="editTax(${t.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteTax(${t.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    ${renderTaxPagination(totalPages)}
  `;
}
function renderTaxPagination(totalPages) {

  if (totalPages <= 1) {
    return `
      <div class="d-flex justify-content-between align-items-center mt-3">
        <select class="form-select w-auto">
          <option>10</option>
        </select>

        <div class="text-muted">
          1-${taxes.length} / ${taxes.length}
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm">‹</button>
          <button class="btn btn-outline-secondary btn-sm">1</button>
          <button class="btn btn-outline-secondary btn-sm">›</button>
        </div>
      </div>
    `;
  }

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="taxLimit=this.value; taxPage=1; renderTaxesPage()">
        <option ${taxLimit==10?'selected':''}>10</option>
        <option ${taxLimit==25?'selected':''}>25</option>
      </select>

      <div class="text-muted">
        ${(taxPage-1)*taxLimit+1} -
        ${Math.min(taxPage*taxLimit, taxes.length)}
        / ${taxes.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary"
          ${taxPage===1?'disabled':''}
          onclick="taxPage--; renderTaxesPage()">‹</button>

        <button class="btn btn-sm btn-outline-secondary">
          ${taxPage}
        </button>

        <button class="btn btn-sm btn-outline-secondary"
          ${taxPage===totalPages?'disabled':''}
          onclick="taxPage++; renderTaxesPage()">›</button>
      </div>
    </div>
  `;
}
function openTaxModal() {
  editingTaxId = null;
  taxModalTitle.innerText = "Add Tax";
  taxName.value = "";
  taxPercentage.value = "";
  new bootstrap.Modal(document.getElementById("taxModal")).show();
}

function editTax(id) {
  editingTaxId = id;
  const t = taxes.find(x => x.id === id);

  taxModalTitle.innerText = "Edit Tax";
  taxName.value = t.name;
  taxPercentage.value = t.percentage;

  new bootstrap.Modal(document.getElementById("taxModal")).show();
}

function saveTax() {
  const name = taxName.value.trim();
  const percentage = Number(taxPercentage.value);

  if (!name || percentage <= 0) return;

  if (editingTaxId) {
    const t = taxes.find(x => x.id === editingTaxId);
    t.name = name;
    t.percentage = percentage;
  } else {
    taxes.push({
      id: Date.now(),
      name,
      percentage
    });
  }

  bootstrap.Modal.getInstance(
    document.getElementById("taxModal")
  ).hide();

  renderTaxesPage();
}

function deleteTax(id) {
  taxes = taxes.filter(t => t.id !== id);

  const maxPage = Math.ceil(taxes.length / taxLimit);
  if (taxPage > maxPage) taxPage = maxPage || 1;

  renderTaxesPage();
}
function renderPaymentMethods() {

  const start = (paymentPage - 1) * paymentLimit;
  const rows = paymentMethods.slice(start, start + paymentLimit);
  const totalPages = Math.ceil(paymentMethods.length / paymentLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Payment methods</h4>

      <button class="btn btn-outline-primary"
        onclick="openPaymentModal()">
        <i class="fa fa-plus me-1"></i> Add payment method
      </button>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Available on Invoice</th>
          <th>Minimum payment amount</th>
          <th class="text-end">
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>
      <tbody>
  ${rows.map(p => `
    <tr>
      <td>☰ ${p.title}</td>
      <td>${p.description}</td>
      <td>${p.availableOnInvoice}</td>
      <td>${p.minAmount}</td>
      <td class="text-end align-middle">
        <div class="d-inline-flex align-items-center gap-1">
          <button class="btn btn-sm btn-outline-secondary"
            onclick="editPayment(${p.id})">
            <i class="fa fa-pen"></i>
          </button>
          <button class="btn btn-sm btn-outline-secondary"
            onclick="deletePayment(${p.id})">
            <i class="fa fa-times"></i>
          </button>
        </div>
      </td>
    </tr>
  `).join("")}
</tbody>

    </table>

    ${renderPaymentPagination(totalPages)}
  `;
}
function renderPaymentPagination(totalPages) {

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="paymentLimit=this.value; paymentPage=1; renderPaymentMethods()">
        <option value="10" ${paymentLimit==10?'selected':''}>10</option>
        <option value="25" ${paymentLimit==25?'selected':''}>25</option>
      </select>

      <div class="text-muted">
        ${(paymentPage-1)*paymentLimit+1} -
        ${Math.min(paymentPage*paymentLimit, paymentMethods.length)}
        / ${paymentMethods.length}
      </div>

      <div class="d-flex align-items-center gap-1">
        <button class="btn btn-sm btn-outline-secondary"
          ${paymentPage===1?'disabled':''}
          onclick="paymentPage--; renderPaymentMethods()">
          ‹
        </button>

        <button class="btn btn-sm btn-outline-secondary">
          ${paymentPage}
        </button>

        <button class="btn btn-sm btn-outline-secondary"
          ${paymentPage===totalPages?'disabled':''}
          onclick="paymentPage++; renderPaymentMethods()">
          ›
        </button>
      </div>
    </div>
  `;
}

function openPaymentModal() {
  editingPaymentId = null;
  document.getElementById("paymentModalTitle").innerText = "Add payment method";
  document.getElementById("paymentTitle").value = "";
  document.getElementById("paymentDesc").value = "";
  new bootstrap.Modal(document.getElementById("paymentModal")).show();
}

function editPayment(id) {
  editingPaymentId = id;
  const p = paymentMethods.find(x => x.id === id);

  document.getElementById("paymentModalTitle").innerText = "Edit payment method";
  document.getElementById("paymentTitle").value = p.title;
  document.getElementById("paymentDesc").value = p.description;

  new bootstrap.Modal(document.getElementById("paymentModal")).show();
}

function savePayment() {

  const obj = {
    id: editingPaymentId || Date.now(),
    title: paymentTitle.value.trim(),
    description: paymentDesc.value.trim(),
    availableOnInvoice: "-",
    minAmount: "-"
  };

  if (!obj.title) return;

  if (editingPaymentId) {
    const index = paymentMethods.findIndex(p => p.id === editingPaymentId);
    paymentMethods[index] = obj;
  } else {
    paymentMethods.push(obj);
  }

  bootstrap.Modal.getInstance(
    document.getElementById("paymentModal")
  ).hide();

  renderPaymentMethods();
}

function deletePayment(id) {
  paymentMethods = paymentMethods.filter(p => p.id !== id);

  const maxPage = Math.ceil(paymentMethods.length / paymentLimit);
  if (paymentPage > maxPage) paymentPage = maxPage || 1;

  renderPaymentMethods();
}
function renderPlugins() {

  const start = (pluginPage - 1) * pluginLimit;
  const rows = plugins.slice(start, start + pluginLimit);
  const total = plugins.length;

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-3">Plugins</h4>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th>
            <i class="fa fa-arrow-up me-2"></i>
            Description
          </th>
          <th>Status</th>
          <th class="text-end">
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>

      <tbody>
        ${
          rows.length === 0
            ? `
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  No record found.
                </td>
              </tr>
            `
            : rows.map(p => `
              <tr>
                <td>${p.title}</td>
                <td>${p.description}</td>
                <td>
                  <span class="badge ${p.enabled ? 'bg-success' : 'bg-secondary'}">
                    ${p.enabled ? 'Active' : 'Inactive'}
                  </span>
                </td>
                <td class="text-end"></td>
              </tr>
            `).join("")
        }
      </tbody>
    </table>

    ${renderPluginPagination()}
  `;
}
function renderPluginPagination() {

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto">
        <option>10</option>
      </select>

      <div class="text-muted">
        ${plugins.length === 0 ? "0-0 / 0" : "1-" + plugins.length + " / " + plugins.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary" disabled>
          ‹
        </button>
        <button class="btn btn-sm btn-outline-secondary">
          1
        </button>
        <button class="btn btn-sm btn-outline-secondary" disabled>
          ›
        </button>
      </div>
    </div>
  `;
}
/* ===============================
   CUSTOM FIELDS
================================ */

function renderCustomFields() {

  let fields = customFields[activeCustomTab] || [];

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Custom fields</h4>
      <button class="btn btn-outline-primary" onclick="openCustomFieldModal()">
        <i class="fa fa-plus"></i> Add field
      </button>
    </div>

    <div class="d-flex flex-wrap gap-3 border-bottom mb-4 pb-2">
      ${customFieldTabs.map(t => `
        <div style="cursor:pointer"
          class="${activeCustomTab === t ? 'fw-semibold border-bottom border-2 pb-1' : ''}"
          onclick="switchCustomTab('${t}')">
          ${t}
        </div>
      `).join("")}
    </div>

    ${
      fields.length === 0
        ? `<div class="text-muted">No fields found.</div>`
        : fields.map(f => `
          <div class="border rounded p-3 mb-2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
              <i class="fa fa-bars text-muted"></i>
              <div class="fw-semibold">${f.title}</div>
            </div>

            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary"
                onclick="editCustomField(${f.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteCustomField(${f.id})">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
        `).join("")
    }
  `;
}

function switchCustomTab(tab) {
  activeCustomTab = tab;
  renderCustomFields();
}

function openCustomFieldModal() {
  editingCustomFieldId = null;

  document.getElementById("customFieldModalTitle").innerText = "Add field";

  document.querySelectorAll("#customFieldModal input").forEach(i => {
    if (i.type === "checkbox") i.checked = false;
    else i.value = "";
  });

  document.getElementById("cfType").value = "Text";

  new bootstrap.Modal(
    document.getElementById("customFieldModal")
  ).show();
}

function editCustomField(id) {
  let f = customFields[activeCustomTab].find(x => x.id === id);
  editingCustomFieldId = id;

  document.getElementById("customFieldModalTitle").innerText = "Edit field";

  cfTitle.value = f.title;
  cfType.value = f.type;
  cfRequired.checked = f.required;
  cfShowTable.checked = f.showInTable;
  cfShowOrder.checked = f.showInOrder;
  cfAdminOnly.checked = f.adminOnly;
  cfHideClient.checked = f.hideFromClients;

  new bootstrap.Modal(
    document.getElementById("customFieldModal")
  ).show();
}

function saveCustomField() {

  if (!customFields[activeCustomTab]) {
    customFields[activeCustomTab] = [];
  }

  const title = cfTitle.value.trim();
  if (!title) return;

  const obj = {
    id: editingCustomFieldId || Date.now(),
    title,
    type: cfType.value,
    required: cfRequired.checked,
    showInTable: cfShowTable.checked,
    showInOrder: cfShowOrder.checked,
    adminOnly: cfAdminOnly.checked,
    hideFromClients: cfHideClient.checked
  };

  if (editingCustomFieldId) {
    const i = customFields[activeCustomTab]
      .findIndex(x => x.id === editingCustomFieldId);
    customFields[activeCustomTab][i] = obj;
  } else {
    customFields[activeCustomTab].push(obj);
  }

  bootstrap.Modal.getInstance(
    document.getElementById("customFieldModal")
  ).hide();

  renderCustomFields();
}

function deleteCustomField(id) {
  customFields[activeCustomTab] =
    customFields[activeCustomTab].filter(x => x.id !== id);
  renderCustomFields();
}
function renderClientGroups() {

  const start = (clientGroupPage - 1) * clientGroupLimit;
  const rows = clientGroups.slice(start, start + clientGroupLimit);
  const totalPages = Math.ceil(clientGroups.length / clientGroupLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Client groups</h4>

      <button class="btn btn-outline-primary"
        onclick="openClientGroupModal()">
        <i class="fa fa-plus me-1"></i> Add client group
      </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th class="text-end">
            <i class="fa fa-arrow-up me-3"></i>
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>

      <tbody>
        ${
          rows.length === 0
            ? `
              <tr>
                <td colspan="2" class="text-center text-muted py-4">
                  No record found.
                </td>
              </tr>
            `
            : rows.map(g => `
              <tr>
                <td>${g.title}</td>
                <td class="text-end">
                  <button class="btn btn-sm btn-outline-secondary me-1"
                    onclick="editClientGroup(${g.id})">
                    <i class="fa fa-pen"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-secondary"
                    onclick="deleteClientGroup(${g.id})">
                    <i class="fa fa-times"></i>
                  </button>
                </td>
              </tr>
            `).join("")
        }
      </tbody>
    </table>

    ${renderClientGroupPagination(totalPages)}
  `;
}
function renderClientGroupPagination(totalPages) {

  if (totalPages <= 1) {
    return `
      <div class="d-flex justify-content-between align-items-center mt-3">
        <select class="form-select w-auto">
          <option>10</option>
        </select>

        <div class="text-muted">
          1-${clientGroups.length} / ${clientGroups.length}
        </div>

        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm">‹</button>
          <button class="btn btn-outline-secondary btn-sm">1</button>
          <button class="btn btn-outline-secondary btn-sm">›</button>
        </div>
      </div>
    `;
  }

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="clientGroupLimit=this.value; clientGroupPage=1; renderClientGroups()">
        <option ${clientGroupLimit==10?'selected':''}>10</option>
        <option ${clientGroupLimit==25?'selected':''}>25</option>
      </select>

      <div class="text-muted">
        ${(clientGroupPage-1)*clientGroupLimit+1} -
        ${Math.min(clientGroupPage*clientGroupLimit, clientGroups.length)}
        / ${clientGroups.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm"
          ${clientGroupPage===1?'disabled':''}
          onclick="clientGroupPage--; renderClientGroups()">‹</button>

        <button class="btn btn-outline-secondary btn-sm">
          ${clientGroupPage}
        </button>

        <button class="btn btn-outline-secondary btn-sm"
          ${clientGroupPage===totalPages?'disabled':''}
          onclick="clientGroupPage++; renderClientGroups()">›</button>
      </div>
    </div>
  `;
}
function openClientGroupModal() {
  editingClientGroupId = null;
  clientGroupModalTitle.innerText = "Add client group";
  clientGroupTitle.value = "";

  new bootstrap.Modal(
    document.getElementById("clientGroupModal")
  ).show();
}

function editClientGroup(id) {
  const g = clientGroups.find(x => x.id === id);
  editingClientGroupId = id;

  clientGroupModalTitle.innerText = "Edit client group";
  clientGroupTitle.value = g.title;

  new bootstrap.Modal(
    document.getElementById("clientGroupModal")
  ).show();
}

function saveClientGroup() {
  const title = clientGroupTitle.value.trim();
  if (!title) return;

  if (editingClientGroupId) {
    const g = clientGroups.find(x => x.id === editingClientGroupId);
    g.title = title;
  } else {
    clientGroups.push({
      id: Date.now(),
      title
    });
  }

  bootstrap.Modal.getInstance(
    document.getElementById("clientGroupModal")
  ).hide();

  renderClientGroups();
}

function deleteClientGroup(id) {
  clientGroups = clientGroups.filter(x => x.id !== id);

  const maxPage = Math.ceil(clientGroups.length / clientGroupLimit);
  if (clientGroupPage > maxPage) clientGroupPage = maxPage || 1;

  renderClientGroups();
}
function renderTaskSection(tab) {

  activeTaskTab = tab;

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex gap-4 border-bottom pb-2">
        ${taskTab("settings","Task settings")}
        ${taskTab("status","Task Status")}
        ${taskTab("priority","Task priority")}
        ${taskTab("template","Checklist Template")}
        ${taskTab("group","Checklist group")}
      </div>

      ${tab !== "settings"
        ? `<button class="btn btn-outline-primary"
             onclick="openTaskStatusModal()">
             <i class="fa fa-plus"></i> Add ${tab === "status" ? "task status" : "item"}
           </button>`
        : ""
      }
    </div>

    <div id="taskTabContent"></div>

    ${tab === "settings"
      ? `<button class="btn btn-primary mt-3" onclick="saveTaskSettings()">✓ Save</button>`
      : ""
    }
  `;

  if (tab === "settings") renderTaskSettings();
  if (tab === "status") renderTaskStatus();
}
function taskTab(key,label){
  return `
    <div style="cursor:pointer"
      class="${activeTaskTab===key?'fw-semibold border-bottom border-2 pb-1':''}"
      onclick="renderTaskSection('${key}')">
      ${label}
    </div>
  `;
}
function renderTaskSettings() {
  document.getElementById("taskTabContent").innerHTML = `
    ${taskToggle("Enable recurring option for tasks","recurring")}
    ${taskSelect("Create recurring tasks before","createBefore",["-","1 Day","3 Days"])}
    ${taskSelect("Send task deadline pre reminder","preReminder",["1 Day","2 Days"])}
    ${taskToggle("Send task reminder on the day of deadline","dayReminder")}
    ${taskSelect("Send task deadline overdue reminder","overdueReminder",["-","1 Day"])}
    ${taskSelect("Task point range","pointRange",["1-5","1-10"])}
    ${taskMulti("Show in kanban",["ID"])}
    ${taskToggle("Show time with task start date and deadline","showTime")}
    ${taskToggle("Show the status checkbox in tasks list","showStatusCheckbox")}
    ${taskToggle("Create only the project related tasks from the global task creation modal","projectOnlyGlobal")}
  `;
}

function taskToggle(label,key){
  return `
    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
      <span>${label}</span>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox"
          ${taskSettings[key]?"checked":""}
          onchange="taskSettings['${key}']=this.checked">
      </div>
    </div>
  `;
}

function taskSelect(label,key,options){
  return `
    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
      <span>${label}</span>
      <select class="form-select w-25"
        onchange="taskSettings['${key}']=this.value">
        ${options.map(o=>`
          <option ${taskSettings[key]===o?'selected':''}>${o}</option>
        `).join("")}
      </select>
    </div>
  `;
}

function taskMulti(label,values){
  return `
    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
      <span>${label}</span>
      <span class="badge bg-light text-dark">× ${values[0]}</span>
    </div>
  `;
}

function saveTaskSettings(){
  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderTaskStatus() {

  document.getElementById("taskTabContent").innerHTML = `
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th class="text-end">
            <i class="fa fa-arrow-up me-3"></i>
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        ${taskStatuses.map(s=>`
          <tr>
            <td>${s.title}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary me-1"
                onclick="editTaskStatus(${s.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteTaskStatus(${s.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>
  `;
}
function openTaskStatusModal(){
  editingTaskStatusId = null;
  taskStatusModalTitle.innerText = "Add task status";
  taskStatusTitle.value = "";

  new bootstrap.Modal(
    document.getElementById("taskStatusModal")
  ).show();
}

function editTaskStatus(id){
  const s = taskStatuses.find(x=>x.id===id);
  editingTaskStatusId = id;

  taskStatusModalTitle.innerText = "Edit task status";
  taskStatusTitle.value = s.title;

  new bootstrap.Modal(
    document.getElementById("taskStatusModal")
  ).show();
}

function saveTaskStatus(){
  const title = taskStatusTitle.value.trim();
  if (!title) return;

  if (editingTaskStatusId){
    taskStatuses.find(x=>x.id===editingTaskStatusId).title = title;
  } else {
    taskStatuses.push({ id: Date.now(), title });
  }

  bootstrap.Modal.getInstance(
    document.getElementById("taskStatusModal")
  ).hide();

  renderTaskStatus();
}

function deleteTaskStatus(id){
  taskStatuses = taskStatuses.filter(x=>x.id!==id);
  renderTaskStatus();
}
function renderProjectSection(tab) {

  activeProjectTab = tab;

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">

      <div class="d-flex gap-4 border-bottom pb-2">
        ${projectTab("settings","Project settings")}
        ${projectTab("status","Project Status")}
      </div>

      ${tab === "status"
        ? `<button class="btn btn-outline-primary"
             onclick="openProjectStatusModal()">
             <i class="fa fa-plus"></i> Add project status
           </button>`
        : ""
      }
    </div>

    <div id="projectTabContent"></div>

    ${tab === "settings"
      ? `<button class="btn btn-primary mt-3"
           onclick="saveProjectSettings()">✓ Save</button>`
      : ""
    }
  `;

  if (tab === "settings") renderProjectSettings();
  if (tab === "status") renderProjectStatus();
}

function projectTab(key,label){
  return `
    <div style="cursor:pointer"
      class="${activeProjectTab===key?'fw-semibold border-bottom border-2 pb-1':''}"
      onclick="renderProjectSection('${key}')">
      ${label}
    </div>
  `;
}
function renderProjectSettings() {

  document.getElementById("projectTabContent").innerHTML = `
    <div class="row mb-3 align-items-center">
      <div class="col-md-4 text-muted">
        Set project tab order
      </div>

      <div class="col-md-6">
        <input class="form-control"
          placeholder="Project tab order"
          value="${projectSettings.tabOrder}"
          onchange="projectSettings.tabOrder=this.value">
      </div>
    </div>

    <div class="text-muted">
      <i class="fa fa-info-circle me-1"></i>
      Please note that, this tabs will show as per user's permissions.
    </div>
  `;
}

function saveProjectSettings(){
  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderProjectStatus() {

  document.getElementById("projectTabContent").innerHTML = `
    <div class="list-group">

      ${projectStatuses.map(s=>`
        <div class="list-group-item d-flex justify-content-between align-items-center">

          <div class="d-flex align-items-center gap-3">
            <i class="fa ${s.icon} text-muted"></i>
            <span>${s.title}</span>
          </div>

          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary"
              onclick="editProjectStatus(${s.id})">
              <i class="fa fa-pen"></i>
            </button>

            ${s.id > 2 ? `
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteProjectStatus(${s.id})">
                <i class="fa fa-times"></i>
              </button>
            ` : ``}
          </div>

        </div>
      `).join("")}

    </div>
  `;
}
function openProjectStatusModal() {
  editingProjectStatusId = null;
  projectStatusModalTitle.innerText = "Add project status";
  projectStatusTitle.value = "";

  new bootstrap.Modal(
    document.getElementById("projectStatusModal")
  ).show();
}

function editProjectStatus(id) {
  const s = projectStatuses.find(x => x.id === id);
  editingProjectStatusId = id;

  projectStatusModalTitle.innerText = "Edit project status";
  projectStatusTitle.value = s.title;

  new bootstrap.Modal(
    document.getElementById("projectStatusModal")
  ).show();
}

function saveProjectStatus() {

  const title = projectStatusTitle.value.trim();
  if (!title) return;

  if (editingProjectStatusId) {
    projectStatuses.find(x => x.id === editingProjectStatusId).title = title;
  } else {
    projectStatuses.push({
      id: Date.now(),
      title,
      icon: "fa-calendar"
    });
  }

  bootstrap.Modal.getInstance(
    document.getElementById("projectStatusModal")
  ).hide();

  renderProjectStatus();
}

function deleteProjectStatus(id) {
  projectStatuses = projectStatuses.filter(x => x.id !== id);
  renderProjectStatus();
}
/* ===============================
   RENDER TIMESHEET SETTINGS
================================ */
function renderTimesheetSettings() {

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Timesheet Settings</h4>

    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
      <span>Users can start multiple timers at a time</span>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox"
          ${timesheetSettings.multipleTimers ? "checked" : ""}
          onchange="timesheetSettings.multipleTimers = this.checked">
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
      <span>Users can input only total hours instead of period</span>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox"
          ${timesheetSettings.totalHoursOnly ? "checked" : ""}
          onchange="timesheetSettings.totalHoursOnly = this.checked">
      </div>
    </div>

    <button class="btn btn-primary mt-4"
      onclick="saveTimesheetSettings()">
      ✓ Save
    </button>
  `;
}

/* ===============================
   SAVE ACTION
================================ */
function saveTimesheetSettings() {

  console.log("Saved Timesheet Settings:", timesheetSettings);

  // later → send to backend or localStorage
  // localStorage.setItem("timesheetSettings", JSON.stringify(timesheetSettings));

  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderEventSettings() {

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Event settings</h4>

    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
      <div class="d-flex align-items-center gap-2">
        <span>Send early reminder before</span>
        <i class="fa fa-question-circle text-muted"></i>
      </div>

      <select class="form-select w-auto"
        onchange="eventSettings.earlyReminder = this.value">
        ${renderEventReminderOptions()}
      </select>
    </div>

    <button class="btn btn-primary mt-4"
      onclick="saveEventSettings()">
      ✓ Save
    </button>
  `;
}
function renderEventReminderOptions() {

  const options = [
    "-",
    "15 Minutes",
    "30 Minutes",
    "1 Hour",
    "2 Hours",
    "1 Day",
    "2 Days"
  ];

  return options.map(o => `
    <option ${eventSettings.earlyReminder === o ? "selected" : ""}>
      ${o}
    </option>
  `).join("");
}
function saveEventSettings() {

  console.log("Saved Event Settings:", eventSettings);

  // optional future backend save
  // localStorage.setItem("eventSettings", JSON.stringify(eventSettings));

  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderRemindersSettings() {

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">Reminders Settings</h4>

    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
      <div class="d-flex align-items-center gap-2">
        <span>Send early reminder before</span>
        <i class="fa fa-question-circle text-muted"></i>
      </div>

      <select class="form-select w-auto"
        onchange="remindersSettings.earlyReminder = this.value">
        ${renderReminderOptions()}
      </select>
    </div>

    <button class="btn btn-primary mt-4"
      onclick="saveRemindersSettings()">
      ✓ Save
    </button>
  `;
}
function renderReminderOptions() {

  const options = [
    "-",
    "15 Minutes",
    "30 Minutes",
    "1 Hour",
    "2 Hours",
    "1 Day",
    "2 Days"
  ];

  return options.map(o => `
    <option ${remindersSettings.earlyReminder === o ? "selected" : ""}>
      ${o}
    </option>
  `).join("");
}
function saveRemindersSettings() {

  console.log("Saved Reminders Settings:", remindersSettings);

  // Optional future backend / localStorage save
  // localStorage.setItem("remindersSettings", JSON.stringify(remindersSettings));

  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderExpenseCategories() {

  const start = (expensePage - 1) * expenseLimit;
  const rows = expenseCategories.slice(start, start + expenseLimit);
  const totalPages = Math.ceil(expenseCategories.length / expenseLimit);

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Expense Categories</h4>

      <button class="btn btn-outline-primary"
        onclick="openExpenseCategoryModal()">
        <i class="fa fa-plus me-1"></i> Add category
      </button>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25"
        placeholder="Search"
        oninput="filterExpenseCategories(this.value)">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th class="text-end">
            <i class="fa fa-arrow-up me-3"></i>
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        ${rows.map(c => `
          <tr>
            <td>${c.title}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary me-1"
                onclick="editExpenseCategory(${c.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteExpenseCategory(${c.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    ${renderExpensePagination(totalPages)}
  `;
}
function renderExpensePagination(totalPages) {

  if (totalPages <= 1) return "";

  return `
    <div class="d-flex justify-content-between align-items-center mt-3">

      <select class="form-select w-auto"
        onchange="expenseLimit=this.value; expensePage=1; renderExpenseCategories()">
        <option ${expenseLimit==10?'selected':''}>10</option>
        <option ${expenseLimit==25?'selected':''}>25</option>
      </select>

      <div class="text-muted">
        ${(expensePage-1)*expenseLimit+1} -
        ${Math.min(expensePage*expenseLimit, expenseCategories.length)}
        / ${expenseCategories.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary"
          ${expensePage===1?'disabled':''}
          onclick="expensePage--; renderExpenseCategories()">‹</button>

        <button class="btn btn-sm btn-outline-secondary">
          ${expensePage}
        </button>

        <button class="btn btn-sm btn-outline-secondary"
          ${expensePage===totalPages?'disabled':''}
          onclick="expensePage++; renderExpenseCategories()">›</button>
      </div>

    </div>
  `;
}
function openExpenseCategoryModal() {
  editingExpenseId = null;
  expenseCategoryModalTitle.innerText = "Add category";
  expenseCategoryTitle.value = "";
  new bootstrap.Modal(document.getElementById("expenseCategoryModal")).show();
}

function editExpenseCategory(id) {
  editingExpenseId = id;
  const c = expenseCategories.find(x => x.id === id);

  expenseCategoryModalTitle.innerText = "Edit category";
  expenseCategoryTitle.value = c.title;

  new bootstrap.Modal(document.getElementById("expenseCategoryModal")).show();
}

function saveExpenseCategory() {
  const title = expenseCategoryTitle.value.trim();
  if (!title) return;

  if (editingExpenseId) {
    expenseCategories.find(x => x.id === editingExpenseId).title = title;
  } else {
    expenseCategories.push({
      id: Date.now(),
      title
    });
  }

  bootstrap.Modal.getInstance(
    document.getElementById("expenseCategoryModal")
  ).hide();

  renderExpenseCategories();
}

function deleteExpenseCategory(id) {
  expenseCategories = expenseCategories.filter(x => x.id !== id);

  const maxPage = Math.ceil(expenseCategories.length / expenseLimit);
  if (expensePage > maxPage) expensePage = maxPage || 1;

  renderExpenseCategories();
}

function filterExpenseCategories(q) {
  q = q.toLowerCase();
  expenseCategories = expenseCategories.filter(c =>
    c.title.toLowerCase().includes(q)
  );
  expensePage = 1;
  renderExpenseCategories();
}
function renderLeaveTypes() {

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Leave types</h4>

      <button class="btn btn-outline-primary"
        onclick="openLeaveModal()">
        <i class="fa fa-plus me-1"></i> Add leave type
      </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary">Print</button>
        <input class="form-control" style="width:200px" placeholder="Search">
      </div>
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th>
            <i class="fa fa-arrow-up me-1"></i> Description
          </th>
          <th>Status</th>
          <th class="text-end">
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>

      <tbody>
        ${leaveTypes.map(l => `
          <tr>
            <td>
              <span class="me-2"
                style="display:inline-block;width:14px;height:14px;
                background:${l.color};border-radius:2px"></span>
              ${l.title}
            </td>

            <td>${l.description || "-"}</td>

            <td>${l.status}</td>

            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary me-1"
                onclick="editLeave(${l.id})">
                <i class="fa fa-pen"></i>
              </button>

              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteLeave(${l.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    <!-- PAGINATION (STATIC LIKE SCREENSHOT) -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <select class="form-select w-auto">
        <option>10</option>
      </select>

      <div class="text-muted">
        1-${leaveTypes.length} / ${leaveTypes.length}
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm">‹</button>
        <button class="btn btn-outline-secondary btn-sm">1</button>
        <button class="btn btn-outline-secondary btn-sm">›</button>
      </div>
    </div>
  `;
}
function openLeaveModal() {
  editingLeaveId = null;

  leaveModalTitle.innerText = "Add leave type";
  leaveTitle.value = "";
  leaveDesc.value = "";
  leaveColor.value = "#4f83ff";

  document.querySelector(
    "input[name='leaveStatus'][value='Active']"
  ).checked = true;

  renderLeaveColors("#4f83ff");

  new bootstrap.Modal(
    document.getElementById("leaveModal")
  ).show();
}


function selectLeaveColor(c) {
  leaveColor.value = c;
}

function editLeave(id) {
  const l = leaveTypes.find(x => x.id === id);
  editingLeaveId = id;

  leaveModalTitle.innerText = "Edit leave type";
  leaveTitle.value = l.title;
  leaveDesc.value = l.description;
  leaveColor.value = l.color;

  document.querySelector(
    `input[name='leaveStatus'][value='${l.status}']`
  ).checked = true;

  renderLeaveColors(l.color);

  new bootstrap.Modal(
    document.getElementById("leaveModal")
  ).show();
}


function saveLeave() {
  const obj = {
    id: editingLeaveId || Date.now(),
    title: leaveTitle.value.trim(),
    description: leaveDesc.value,
    color: leaveColor.value,
    status: document.querySelector("input[name='leaveStatus']:checked").value
  };

  if (!obj.title) return;

  if (editingLeaveId) {
    const i = leaveTypes.findIndex(x => x.id === editingLeaveId);
    leaveTypes[i] = obj;
  } else {
    leaveTypes.push(obj);
  }

  bootstrap.Modal.getInstance(
    document.getElementById("leaveModal")
  ).hide();

  renderLeaveTypes();
}

function deleteLeave(id) {
  leaveTypes = leaveTypes.filter(x => x.id !== id);
  renderLeaveTypes();
}
const leaveColors = [
  "#8bc34a", "#20c997", "#3498db", "#95a5a6",
  "#f1c40f", "#f39c12", "#e74c3c", "#d63384",
  "#9b59b6", "#0dcaf0", "#2c3e50",
  "#e0b0ff", "#4f83ff"
];

function renderLeaveColors(selected = "#4f83ff") {
  document.getElementById("leaveColorPalette").innerHTML =
    leaveColors.map(c => `
      <span
        onclick="selectLeaveColor('${c}')"
        style="
          width:22px;
          height:22px;
          border-radius:4px;
          background:${c};
          cursor:pointer;
          border:${c === selected ? '2px solid #000' : '1px solid #ddd'};
        ">
      </span>
    `).join("");
}

function selectLeaveColor(color) {
  document.getElementById("leaveColor").value = color;
  renderLeaveColors(color);
}
function renderTicketSection(tab) {
  ticketTab = tab;

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex gap-4 border-bottom pb-2">
        ${renderTicketTabs()}
      </div>

      ${renderTicketActionButton()}
    </div>

    <div id="ticketTabContent"></div>
  `;

  if (tab === "types") renderTicketTypes();
  if (tab === "tickets") renderTicketSettings();
  if (tab === "imap") renderIMAPSettings();
  if (tab === "automation") renderAutomations();
}

function renderTicketTabs() {
  const tabs = [
    ["types","Ticket types"],
    ["tickets","Tickets"],
    ["imap","IMAP settings"],
    ["automation","Automations"]
  ];

  return tabs.map(t => `
    <div style="cursor:pointer"
      class="${ticketTab===t[0]?'fw-semibold border-bottom border-2 pb-1':''}"
      onclick="renderTicketSection('${t[0]}')">
      ${t[1]}
    </div>
  `).join("");
}

function renderTicketActionButton() {
  if (ticketTab === "types")
    return `<button class="btn btn-outline-primary"
      onclick="openTicketTypeModal()">+ Add ticket type</button>`;

  if (ticketTab === "automation")
    return `<button class="btn btn-outline-primary"
      onclick="openAutomationModal()">+ Add automation</button>`;

  return "";
}
function renderTicketTypes() {
  document.getElementById("ticketTabContent").innerHTML = `
    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary">Print</button>
        <input class="form-control" style="width:200px" placeholder="Search">
      </div>
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Name</th>
          <th class="text-end">
            <i class="fa fa-arrow-up me-2"></i>
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        ${ticketTypes.map(t=>`
          <tr>
            <td>${t.name}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-secondary me-1"
                onclick="editTicketType(${t.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-secondary"
                onclick="deleteTicketType(${t.id})">
                <i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        `).join("")}
      </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <select class="form-select w-auto"><option>10</option></select>
      <div class="text-muted">1-${ticketTypes.length}/${ticketTypes.length}</div>
      <div>
        <button class="btn btn-sm btn-outline-secondary">‹</button>
        <button class="btn btn-sm btn-outline-secondary">1</button>
        <button class="btn btn-sm btn-outline-secondary">›</button>
      </div>
    </div>
  `;
}
function openTicketTypeModal(){
  editingTicketTypeId=null;
  ticketTypeTitle.innerText="Add ticket type";
  ticketTypeName.value="";
  new bootstrap.Modal(ticketTypeModal).show();
}

function editTicketType(id){
  editingTicketTypeId=id;
  const t=ticketTypes.find(x=>x.id===id);
  ticketTypeTitle.innerText="Edit ticket type";
  ticketTypeName.value=t.name;
  new bootstrap.Modal(ticketTypeModal).show();
}

function saveTicketType(){
  const name=ticketTypeName.value.trim();
  if(!name) return;

  if(editingTicketTypeId){
    ticketTypes.find(x=>x.id===editingTicketTypeId).name=name;
  } else {
    ticketTypes.push({id:Date.now(),name});
  }

  bootstrap.Modal.getInstance(ticketTypeModal).hide();
  renderTicketTypes();
}

function deleteTicketType(id){
  ticketTypes=ticketTypes.filter(x=>x.id!==id);
  renderTicketTypes();
}
function renderTicketSettings(){
  document.getElementById("ticketTabContent").innerHTML=`
    ${ticketToggle("Show most recent ticket comments at the top","recentFirst")}
    ${ticketToggle("Enable project reference","projectReference")}
    ${ticketInput("Ticket prefix","prefix")}
    ${ticketInput("Auto close ticket after","autoCloseDays","Days")}
    ${ticketToggle("Auto reply to tickets","autoReply")}
    ${ticketToggle("Enable embedded form to get tickets","embeddedForm")}

    <button class="btn btn-primary mt-4"
      onclick="saveTicketSettings()">✓ Save</button>
  `;
}

function ticketToggle(label,key){
  return `
    <div class="d-flex justify-content-between py-3 border-bottom">
      <span>${label}</span>
      <input type="checkbox"
        ${ticketSettings[key]?'checked':''}
        onchange="ticketSettings.${key}=this.checked">
    </div>`;
}

function ticketInput(label,key,suffix=""){
  return `
    <div class="d-flex justify-content-between py-3 border-bottom">
      <span>${label}</span>
      <div class="d-flex align-items-center gap-2">
        <input class="form-control"
          value="${ticketSettings[key]}"
          oninput="ticketSettings.${key}=this.value">
        ${suffix}
      </div>
    </div>`;
}

function saveTicketSettings(){
  console.log(ticketSettings);
  new bootstrap.Modal(saveSuccessModal).show();
}
function renderIMAPSettings(){
  document.getElementById("ticketTabContent").innerHTML=`
    <div class="text-muted py-4">IMAP settings content</div>
  `;
}
function renderAutomations(){
  document.getElementById("ticketTabContent").innerHTML=`
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th><i class="fa fa-arrow-down"></i> Event</th>
          <th class="text-end"><i class="fa fa-bars"></i></th>
        </tr>
      </thead>
      <tbody>
        ${ticketAutomations.length===0?
          `<tr><td colspan="3" class="text-center text-muted">No record found.</td></tr>`
          : ticketAutomations.map(a=>`
            <tr>
              <td>${a.title}</td>
              <td>${a.event}</td>
              <td class="text-end"></td>
            </tr>`).join("")
        }
      </tbody>
    </table>
  `;
}
function openAutomationModal() {
  automationTitle.value = "";
  automationEvent.value = "";

  new bootstrap.Modal(
    document.getElementById("automationModal")
  ).show();
}

function saveAutomation() {
  const title = automationTitle.value.trim();
  const event = automationEvent.value;

  if (!title || !event) return;

  ticketAutomations.push({
    id: Date.now(),
    title,
    event
  });

  bootstrap.Modal.getInstance(
    document.getElementById("automationModal")
  ).hide();

  renderAutomations();
}
function renderLeadSection(tab) {
  leadTab = tab;

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex gap-4 border-bottom pb-2">
        ${leadTabItem("status","Lead status")}
        ${leadTabItem("source","Lead source")}
        ${leadTabItem("settings","Leads")}
      </div>

      ${renderLeadActionButton()}
    </div>

    <div id="leadTabContent"></div>
  `;

  if (tab === "status") renderLeadStatus();
  if (tab === "source") renderLeadSource();
  if (tab === "settings") renderLeadSettings();
}

function leadTabItem(key,label){
  return `
    <div style="cursor:pointer"
      class="${leadTab===key?'fw-semibold border-bottom border-2 pb-1':''}"
      onclick="renderLeadSection('${key}')">
      ${label}
    </div>`;
}

function renderLeadActionButton(){
  if (leadTab === "status")
    return `<button class="btn btn-outline-primary"
      onclick="openLeadStatusModal()">+ Add lead status</button>`;

  if (leadTab === "source")
    return `<button class="btn btn-outline-primary"
      onclick="openLeadSourceModal()">+ Add lead source</button>`;

  return "";
}
function renderLeadStatus() {
  document.getElementById("leadTabContent").innerHTML = `
    ${leadStatuses.map(s => `
      <div class="d-flex justify-content-between align-items-center border-bottom py-3">

        <div class="d-flex align-items-center gap-3">
          <i class="fa fa-bars text-muted"></i>
          <span style="width:14px;height:14px;border-radius:2px;
            background:${s.color};display:inline-block"></span>
          ${s.title}
        </div>

        <div>
          <button class="btn btn-sm btn-outline-secondary me-1"
            onclick="editLeadStatus(${s.id})">
            <i class="fa fa-pen"></i>
          </button>
          <button class="btn btn-sm btn-outline-secondary"
            onclick="deleteLeadStatus(${s.id})">
            <i class="fa fa-times"></i>
          </button>
        </div>

      </div>
    `).join("")}
  `;
}
function renderLeadColors(selected) {
  leadColorPalette.innerHTML = leadColors.map(c => `
    <span onclick="selectLeadColor('${c}')"
      style="width:22px;height:22px;border-radius:4px;
      background:${c};cursor:pointer;
      border:${c===selected?'2px solid #000':'1px solid #ddd'}">
    </span>
  `).join("");
}

function selectLeadColor(c){
  leadStatusColor.value = c;
  renderLeadColors(c);
}

function openLeadStatusModal(){
  editingLeadId=null;
  leadStatusTitle.innerText="Add lead status";
  leadStatusName.value="";
  leadStatusColor.value="#4f83ff";
  renderLeadColors("#4f83ff");
  new bootstrap.Modal(leadStatusModal).show();
}

function editLeadStatus(id){
  const s=leadStatuses.find(x=>x.id===id);
  editingLeadId=id;
  leadStatusTitle.innerText="Edit lead status";
  leadStatusName.value=s.title;
  leadStatusColor.value=s.color;
  renderLeadColors(s.color);
  new bootstrap.Modal(leadStatusModal).show();
}

function saveLeadStatus(){
  const obj={
    id:editingLeadId||Date.now(),
    title:leadStatusName.value.trim(),
    color:leadStatusColor.value
  };
  if(!obj.title) return;

  if(editingLeadId){
    leadStatuses[leadStatuses.findIndex(x=>x.id===editingLeadId)] = obj;
  } else {
    leadStatuses.push(obj);
  }

  bootstrap.Modal.getInstance(leadStatusModal).hide();
  renderLeadStatus();
}

function deleteLeadStatus(id){
  leadStatuses = leadStatuses.filter(x=>x.id!==id);
  renderLeadStatus();
}
function renderLeadSource(){
  document.getElementById("leadTabContent").innerHTML = `
    ${leadSources.map(s=>`
      <div class="d-flex justify-content-between border-bottom py-3">
        <div class="d-flex align-items-center gap-3">
          <i class="fa fa-bars text-muted"></i>
          ${s.title}
        </div>
        <div>
          <button class="btn btn-sm btn-outline-secondary me-1"
            onclick="editLeadSource(${s.id})"><i class="fa fa-pen"></i></button>
          <button class="btn btn-sm btn-outline-secondary"
            onclick="deleteLeadSource(${s.id})"><i class="fa fa-times"></i></button>
        </div>
      </div>
    `).join("")}
  `;
}
function openLeadSourceModal(){
  editingLeadSourceId=null;
  leadSourceTitle.innerText="Add lead source";
  leadSourceName.value="";
  new bootstrap.Modal(leadSourceModal).show();
}

function editLeadSource(id){
  editingLeadSourceId=id;
  const s=leadSources.find(x=>x.id===id);
  leadSourceTitle.innerText="Edit lead source";
  leadSourceName.value=s.title;
  new bootstrap.Modal(leadSourceModal).show();
}

function saveLeadSource(){
  const title=leadSourceName.value.trim();
  if(!title) return;

  if(editingLeadSourceId){
    leadSources.find(x=>x.id===editingLeadSourceId).title=title;
  } else {
    leadSources.push({id:Date.now(),title});
  }

  bootstrap.Modal.getInstance(leadSourceModal).hide();
  renderLeadSource();
}

function deleteLeadSource(id){
  leadSources=leadSources.filter(x=>x.id!==id);
  renderLeadSource();
}
function renderLeadSettings(){
  document.getElementById("leadTabContent").innerHTML=`
    ${leadToggle("Can create lead from public form","publicForm")}
    ${leadToggle("Enable embedded form to get leads","embeddedForm")}
    <div class="d-flex justify-content-between py-3 border-bottom">
      <span>Hide fields from lead embedded forms</span>
      <input class="form-control w-50"
        value="${leadSettings.hiddenFields}"
        placeholder="Hidden client fields"
        oninput="leadSettings.hiddenFields=this.value">
    </div>

    <button class="btn btn-primary mt-4"
      onclick="saveLeadSettings()">✓ Save</button>
  `;
}

function leadToggle(label,key){
  return `
    <div class="d-flex justify-content-between py-3 border-bottom">
      <span>${label}</span>
      <input type="checkbox"
        ${leadSettings[key]?'checked':''}
        onchange="leadSettings.${key}=this.checked">
    </div>`;
}

function saveLeadSettings(){
  console.log(leadSettings);
  new bootstrap.Modal(saveSuccessModal).show();
}
function renderGDPRSettings() {

  document.getElementById("settingsContent").innerHTML = `
    <h4 class="mb-4">GDPR</h4>

    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
      <span>Enable GDPR</span>

      <input type="checkbox"
        ${gdprSettings.enabled ? "checked" : ""}
        onchange="gdprSettings.enabled = this.checked">
    </div>

    <button class="btn btn-primary mt-4"
      onclick="saveGDPRSettings()">
      ✓ Save
    </button>
  `;
}
function saveGDPRSettings() {

  console.log("Saved GDPR Settings:", gdprSettings);

  // Optional later:
  // localStorage.setItem("gdprSettings", JSON.stringify(gdprSettings));
  // OR send to backend via AJAX

  new bootstrap.Modal(
    document.getElementById("saveSuccessModal")
  ).show();
}
function renderPages() {

  document.getElementById("settingsContent").innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Pages</h4>

      <button class="btn btn-outline-primary"
        onclick="openPageModal()">
        <i class="fa fa-plus me-1"></i> Add page
      </button>
    </div>

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-outline-secondary">
        <i class="fa fa-table-columns"></i>
      </button>

      <input class="form-control w-25" placeholder="Search">
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Title</th>
          <th>
            <i class="fa fa-arrow-up me-1"></i> URL
          </th>
          <th>Status</th>
          <th>Options</th>
          <th class="text-end">
            <i class="fa fa-bars"></i>
          </th>
        </tr>
      </thead>

      <tbody>
        ${pages.map(p => `
          <tr>
            <td>${p.title}</td>
            <td>
              <a href="${BASE_PAGE_URL}${p.slug}" target="_blank">
                ${BASE_PAGE_URL}${p.slug}
              </a>
            </td>
            <td>
              <span class="badge bg-primary">${p.status}</span>
            </td>
            <td>
              <i class="fa fa-arrows-left-right"></i>
            </td>
            <td class="text-end">
  <button class="btn btn-sm btn-outline-secondary gap-2 "
    title="Edit"
    onclick="editPage(${p.id})">
    <i class="fa fa-pen"></i>
  </button>

  <button class="btn btn-sm btn-outline-secondary"
    title="Delete"
    onclick="deletePage(${p.id})">
    <i class="fa fa-times"></i>
  </button>
</td>

          </tr>
        `).join("")}
      </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <select class="form-select w-auto"><option>10</option></select>
      <div class="text-muted">1-${pages.length}/${pages.length}</div>
      <div>
        <button class="btn btn-sm btn-outline-secondary">‹</button>
        <button class="btn btn-sm btn-outline-secondary">1</button>
        <button class="btn btn-sm btn-outline-secondary">›</button>
      </div>
    </div>
  `;
}
function openPageModal() {
  editingPageId = null;

  pageModalTitle.innerText = "Add page";
  pageTitle.value = "";
  pageContent.value = "";
  pageSlug.value = "";
  pageStatus.value = "Active";
  pageHideTopbar.checked = false;

  new bootstrap.Modal(pageModal).show();
}

function autoGenerateSlug(title) {
  const slug = title.toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/(^-|-$)/g, "");
  pageSlug.value = slug;
}

function editPage(id) {
  const p = pages.find(x => x.id === id);
  editingPageId = id;

  pageModalTitle.innerText = "Edit page";
  pageTitle.value = p.title;
  pageContent.value = p.content;
  pageSlug.value = p.slug;
  pageStatus.value = p.status;
  pageHideTopbar.checked = p.hideTopbar;

  new bootstrap.Modal(pageModal).show();
}

function savePage() {
  const obj = {
    id: editingPageId || Date.now(),
    title: pageTitle.value.trim(),
    slug: pageSlug.value,
    content: pageContent.value,
    status: pageStatus.value,
    hideTopbar: pageHideTopbar.checked
  };

  if (!obj.title) return;

  if (editingPageId) {
    pages[pages.findIndex(x => x.id === editingPageId)] = obj;
  } else {
    pages.push(obj);
  }

  bootstrap.Modal.getInstance(pageModal).hide();
  renderPages();
}

function deletePage(id) {
  pages = pages.filter(x => x.id !== id);
  renderPages();
}
</script>
<div class="modal fade" id="pageModal">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="pageModalTitle">Add page</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input id="pageTitle" class="form-control" placeholder="Title"
            oninput="autoGenerateSlug(this.value)">
        </div>

        <div class="mb-3">
          <label class="form-label">Content</label>
          <textarea id="pageContent" class="form-control"
            style="height:250px"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Slug</label>
          <input id="pageSlug" class="form-control"
            placeholder="${BASE_PAGE_URL}[slug]" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select id="pageStatus" class="form-select">
            <option>Active</option>
            <option>Inactive</option>
          </select>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="pageHideTopbar">
          <label class="form-check-label">Hide topbar</label>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="savePage()">✓ Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="leadSourceModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="leadSourceTitle">Add lead source</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label>Title</label>
        <input id="leadSourceName" class="form-control" placeholder="Title">
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="saveLeadSource()">✓ Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="leadStatusModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="leadStatusTitle">Add lead status</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label>Title</label>
          <input id="leadStatusName" class="form-control" placeholder="Title">
        </div>

        <div class="mb-3">
          <div class="d-flex gap-2 flex-wrap" id="leadColorPalette"></div>
          <input type="hidden" id="leadStatusColor">
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="saveLeadStatus()">✓ Save</button>
      </div>

    </div>
  </div>
</div>

<!-- ADD AUTOMATION MODAL -->
<div class="modal fade" id="automationModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="automationModalTitle">Add automation</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input id="automationTitle"
            class="form-control"
            placeholder="Title">
        </div>

        <div class="mb-3">
          <label class="form-label">Event</label>
          <select id="automationEvent" class="form-select">
            <option value="">-</option>
            <option value="Ticket created">Ticket created</option>
            <option value="Ticket replied">Ticket replied</option>
            <option value="Ticket closed">Ticket closed</option>
          </select>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">
          ✕ Close
        </button>
        <button class="btn btn-primary" onclick="saveAutomation()">
          ✓ Save
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="ticketTypeModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="ticketTypeTitle">Add ticket type</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label class="form-label">Title</label>
        <input id="ticketTypeName" class="form-control" placeholder="Title">
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="saveTicketType()">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="leaveModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="leaveModalTitle">Add leave type</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- TITLE -->
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input id="leaveTitle" class="form-control" placeholder="Title">
        </div>

        <!-- COLOR PICKER -->
        <div class="mb-3">
          <div class="d-flex flex-wrap gap-2" id="leaveColorPalette"></div>
          <input type="hidden" id="leaveColor" value="#4f83ff">
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea id="leaveDesc"
            class="form-control"
            placeholder="Description"></textarea>
        </div>

        <!-- STATUS -->
        <div class="mb-3">
          <label class="form-label">Status</label><br>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio"
              name="leaveStatus" value="Active" checked>
            <label class="form-check-label">Active</label>
          </div>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio"
              name="leaveStatus" value="Inactive">
            <label class="form-check-label">Inactive</label>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="saveLeave()">✓ Save</button>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="expenseCategoryModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="expenseCategoryModalTitle">Add category</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-3 text-muted">Title</div>
          <div class="col-md-9">
            <input id="expenseCategoryTitle"
              class="form-control"
              placeholder="Title">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="saveExpenseCategory()">✓ Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="projectStatusModal">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="projectStatusModalTitle">Add project status</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input id="projectStatusTitle"
            class="form-control"
            placeholder="Title">
        </div>

        <div class="mb-3">
          <label class="form-label">
            Title Language Key
            <i class="fa fa-question-circle text-muted"></i>
          </label>
          <input class="form-control"
            placeholder="Keep it blank if you don't use translation">
        </div>

        <!-- ICON GRID (UI ONLY) -->
        <div class="border rounded p-3 text-muted text-center">
          Icon picker UI (static like screenshot)
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">
          ✕ Close
        </button>
        <button class="btn btn-primary" onclick="saveProjectStatus()">
          ✓ Save
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="taskStatusModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="taskStatusModalTitle">Add task status</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label class="form-label">Title</label>
        <input id="taskStatusTitle" class="form-control" placeholder="Title">
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="saveTaskStatus()">✓ Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="clientGroupModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="clientGroupModalTitle">Add client group</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label class="form-label">Title</label>
        <input id="clientGroupTitle"
          class="form-control"
          placeholder="Title">
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">
          ✕ Close
        </button>
        <button class="btn btn-primary" onclick="saveClientGroup()">
          ✓ Save
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="customFieldModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="customFieldModalTitle">Add field</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input id="cfTitle" class="form-control" placeholder="Title">
        </div>

        <div class="mb-3">
          <label class="form-label">
            Title Language Key
            <i class="fa fa-question-circle text-muted"></i>
          </label>
          <input class="form-control"
            placeholder="Keep it blank if you don't use translation">
        </div>

        <div class="mb-3">
          <label class="form-label">Placeholder</label>
          <input class="form-control" placeholder="Placeholder">
        </div>

        <div class="mb-3">
          <label class="form-label">
            Placeholder Language Key
            <i class="fa fa-question-circle text-muted"></i>
          </label>
          <input class="form-control"
            placeholder="Keep it blank if you don't use translation">
        </div>

        <div class="mb-3">
          <label class="form-label">Template variable name</label>
          <input class="form-control" placeholder="VARIABLE_NAME">
        </div>

        <div class="mb-4">
          <label class="form-label">Field Type</label>
          <select id="cfType" class="form-select">
            <option value="Text">Text</option>
            <option value="Number">Number</option>
            <option value="Date">Date</option>
            <option value="Textarea">Textarea</option>
          </select>
        </div>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="cfRequired">
          <label class="form-check-label">Required</label>
        </div>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="cfShowTable">
          <label class="form-check-label">Show in table</label>
        </div>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="cfShowOrder">
          <label class="form-check-label">Show in order</label>
        </div>

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="cfAdminOnly">
          <label class="form-check-label">Visible to admins only</label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="cfHideClient">
          <label class="form-check-label">Hide from clients</label>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">✕ Close</button>
        <button class="btn btn-primary" onclick="saveCustomField()">✓ Save</button>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="paymentModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="paymentModalTitle">Add payment method</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row mb-3">
          <div class="col-md-3 text-muted">Title</div>
          <div class="col-md-9">
            <input id="paymentTitle"
              class="form-control"
              placeholder="Title">
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-muted">Description</div>
          <div class="col-md-9">
            <textarea id="paymentDesc"
              class="form-control"
              placeholder="Description"></textarea>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">
          ✕ Close
        </button>
        <button class="btn btn-primary" onclick="savePayment()">
          ✓ Save
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="taxModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="taxModalTitle">Add Tax</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row mb-3 align-items-center">
          <div class="col-md-3 text-muted">Name</div>
          <div class="col-md-9">
            <input id="taxName" class="form-control" placeholder="Name">
          </div>
        </div>

        <div class="row mb-3 align-items-center">
          <div class="col-md-3 text-muted">Percentage (%)</div>
          <div class="col-md-9">
            <input id="taxPercentage" type="number"
              class="form-control" placeholder="Percentage (%)">
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">
          ✕ Close
        </button>
        <button class="btn btn-primary" onclick="saveTax()">
          ✓ Save
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="categoryModalTitle" class="modal-title">
          Add category
        </h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row align-items-center mb-3">
          <div class="col-md-3 text-muted">Title</div>
          <div class="col-md-9">
            <input id="categoryTitle"
              class="form-control"
              placeholder="Title">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">
          ✕ Close
        </button>
        <button class="btn btn-primary" onclick="saveCategory()">
          ✓ Save
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="companyModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="companyModalTitle">Add company</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label>Company name</label>
          <input id="companyName" class="form-control">
        </div>

        <div class="mb-3">
          <label>Address</label>
          <textarea id="companyAddress" class="form-control"></textarea>
        </div>

        <div class="mb-3">
          <label>Phone</label>
          <input id="companyPhone" class="form-control">
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input id="companyEmail" class="form-control">
        </div>

        <div class="mb-3">
          <label>Website</label>
          <input id="companyWebsite" class="form-control">
        </div>

        <div class="mb-3">
          <label>VAT Number</label>
          <input id="companyVat" class="form-control">
        </div>

        <div class="mb-3">
          <label>GST Number</label>
          <input id="companyGst" class="form-control">
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="companyDefault">
          <label class="form-check-label">Default company</label>
        </div>

        <div class="mb-3">
          <label>Company Logo (300×100)</label><br>
          <img id="companyLogoPreview" src="assets/images/company-logo.png" height="70">
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="saveCompany()">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- 🔔 NOTIFICATION EDIT MODAL -->
<div class="modal fade" id="notifyEditModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Notification</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label>Event</label>
        <input id="notifyEvent" class="form-control mb-2">
        <label>Category</label>
        <input id="notifyCategory" class="form-control">
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="saveNotifyEdit()">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- ADD / EDIT ROLE MODAL -->
<div class="modal fade" id="roleModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="roleModalTitle" class="modal-title">Role</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label class="mb-1">Role name</label>
        <input id="roleNameInput" class="form-control" placeholder="Enter role name">
      </div>

      <div class="modal-footer">
        <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" onclick="saveRole()">Save</button>
      </div>

    </div>
  </div>
</div>
<!-- DELETE ROLE MODAL -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body text-center">
        <div class="fs-2 text-danger mb-2">⚠️</div>
        <h6>Delete this role?</h6>
        <p class="text-muted mb-3">
          This action cannot be undone.
        </p>

        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-danger btn-sm" onclick="confirmDeleteRole()">Delete</button>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- EDIT USER ROLE MODAL -->
<div class="modal fade" id="editUserRoleModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Role</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="fw-semibold mb-2" id="editUserName"></p>

        <label class="mb-1">Role</label>
        <select id="editUserRoleSelect" class="form-select">
          <option>Admin</option>
          <option>Developer</option>
          <option>Project Manager</option>
          <option>Team member</option>
        </select>
      </div>

      <div class="modal-footer">
        <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" onclick="saveUserRoleChange()">Save</button>
      </div>

    </div>
  </div>
</div>
<!-- ADD / EDIT TEAM MODAL -->
<div class="modal fade" id="teamModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="teamModalTitle">Add team</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label>Title</label>
        <input id="teamTitleInput" class="form-control mb-3">

        <label>Team members</label>
        <select id="teamMemberSelect" class="form-select" multiple size="6"></select>
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="saveTeam()">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- TEAM MEMBERS MODAL -->
<div class="modal fade" id="teamMembersModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Team members</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="teamMembersList"></div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- DELETE TEAM MODAL -->
<div class="modal fade" id="deleteTeamModal">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body text-center">
        <div class="fs-3 text-danger">⚠️</div>
        <h6>Delete this team?</h6>
        <p class="text-muted">This action cannot be undone.</p>

        <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger btn-sm" onclick="confirmDeleteTeam()">Delete</button>
      </div>

    </div>
  </div>
</div>
</body>
</html>

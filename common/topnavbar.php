<div class="navbar-custom d-flex justify-content-between align-items-center px-3">

  <div class="d-flex align-items-center">
    <button class="button-menu-mobile open-left me-3 border-0 bg-transparent">
      <i class="mdi mdi-menu fs-4"></i>
    </button>

    <div class="app-search dropdown d-none d-lg-block">
      <form>
        <div class="input-group">
          <input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search" />
          <span class="mdi mdi-magnify search-icon"></span>
          <button class="input-group-text btn-primary" type="submit">Search</button>
        </div>
      </form>
    </div>
  </div>

  <ul class="list-unstyled topbar-menu d-flex align-items-center mb-0">
    <li class="dropdown notification-list">
      <a class="nav-link dropdown-toggle nav-user arrow-none me-0 d-flex align-items-center"
        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">

        <span class="account-user-avatar me-2">
          <img src="assets/images/users/avatar-6.jpg" alt="user-image" class="rounded-circle" width="32" height="32" />
        </span>

        <span>
          <span class="account-user-name">John Doe</span>
          <span class="account-position d-block text-muted" style="font-size: 0.8rem;">Founder</span>
        </span>
      </a>

      <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
        <div class="dropdown-header noti-title">
          <h6 class="text-overflow m-0">Welcome!</h6>
        </div>
        <a href="#" class="dropdown-item notify-item"><i class="mdi mdi-account-circle me-1"></i>My Account</a>
        <a href="#" class="dropdown-item notify-item"><i class="mdi mdi-account-edit me-1"></i>Settings</a>
        <a href="#" class="dropdown-item notify-item"><i class="mdi mdi-lifebuoy me-1"></i>Support</a>
        <a href="#" class="dropdown-item notify-item"><i class="mdi mdi-lock-outline me-1"></i>Lock Screen</a>
        <a href="#" class="dropdown-item notify-item"><i class="mdi mdi-logout me-1"></i>Logout</a>
      </div>
    </li>
  </ul>

</div>

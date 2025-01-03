<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
  <div class=" dropdown-header noti-title">
    <h6 class="text-overflow m-0">Bienvenido!</h6>
  </div>
  <a href="/profile" class="dropdown-item">
    <i class="ni ni-single-02"></i>
    <span>Mi perfil</span>
  </a>
  <a href="#" class="dropdown-item">
    <i class="ni ni-settings-gear-65"></i>
    <span>Configuración</span>
  </a>
  @if ($role == 'patient')
    <a href="/appointments" class="dropdown-item">
      <i class="ni ni-calendar-grid-58"></i>
      <span>Mis citas</span>
    </a>
  @elseif ($role == 'doctor')
    <a href="/appointments" class="dropdown-item">
      <i class="ni ni-calendar-grid-58"></i>
      <span>Mis citas</span>
    </a>
  @elseif ($role == 'admin')
    <a href="/appointments" class="dropdown-item">
      <i class="ni ni-calendar-grid-58"></i>
      <span>Citas Médicas</span>
    </a>
  @endif
  <a href="#" class="dropdown-item">
    <i class="ni ni-support-16"></i>
    <span>Ayuda</span>
  </a>
  <div class="dropdown-divider"></div>
  <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
    <i class="ni ni-user-run"></i>
    <span>Cerrar Sesión</span>
  </a>
</div>
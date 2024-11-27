<!-- Sidebar user panel (optional) -->
<font color="white">


<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    
    <li class="nav-item" >
      <a href="../kasir_dashboard" class="nav-link  <?php if($konstruktor=='kasir_dashboard'){echo 'active';}?>">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>

    <li class="nav-item" >
            <a href="../kasir_penjualan" class="nav-link  <?php if($konstruktor=='kasir_penjualan'){echo 'active';}?>">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
               Penjualan
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="../kasir_laporan_jual" class="nav-link <?php if($konstruktor=='kasir_laporan_jual'){echo 'active';}?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
               Laporan Penjualan
              </p>
            </a>
          </li>

    <li class="nav-item" >
      <a href="../kasir_gantipw" class="nav-link  <?php if($konstruktor=='kasir_gantipw'){echo 'active';}?>">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Ganti Password
        </p>
      </a>
    </li>

    

    <li class="nav-item">
          <a href="../auth/logout.php" class="nav-link">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Keluar</p>
          </a>
        </li>

  </ul>
</nav>
<!-- /.sidebar-menu -->
</font> 

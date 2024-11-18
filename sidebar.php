<!-- Sidebar user panel (optional) -->
    <font color="white">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item" >
            <a href="../admin_dashboard" class="nav-link  <?php if($konstruktor=='admin_dashboard'){echo 'active';}?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item" >
            <a href="../admin_pembelian" class="nav-link  <?php if($konstruktor=='admin_pembelian'){echo 'active';}?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
               Pembelian
              </p>
            </a>
          </li>

          <li class="nav-item" >
            <a href="../admin_stok" class="nav-link  <?php if($konstruktor=='admin_stok'){echo 'active';}?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
               Stok Buku
              </p>
            </a>
          </li>

          <li class="nav-item" >
            <a href="../admin_penjualan" class="nav-link  <?php if($konstruktor=='admin_penjualan'){echo 'active';}?>">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
               Penjualan
              </p>
            </a>
          </li>

           <li class="nav-item <?php if($konstruktor=='admin_master_kategori'){echo 'menu-open';}?> <?php if($konstruktor=='admin_master_buku'){echo 'menu-open';}?> <?php if($konstruktor=='admin_master_administrator'){echo 'menu-open';}?> <?php if($konstruktor=='admin_master_kasir'){echo 'menu-open';}?> <?php if($konstruktor=='admin_master_supplier'){echo 'menu-open';}?> <?php if($konstruktor=='admin_master_margin'){echo 'menu-open';}?>">
            <a href="../admin_dashboard" class="nav-link ">
              <i class="nav-icon fas fa-database"></i>
              <p>
               Master Data
               <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">



              <li class="nav-item">
                <a href="../admin_master_kategori" class="nav-link <?php if($konstruktor=='admin_master_kategori'){echo 'active';}?> ">
                  <i class="fas fa-folder nav-icon"></i>
                  <p>Kategori Buku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../admin_master_buku" class="nav-link <?php if($konstruktor=='admin_master_buku'){echo 'active';}?>">
                  <i class="fas fa-book nav-icon"></i>
                  <p>Buku</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../admin_master_margin" class="nav-link <?php if($konstruktor=='admin_master_margin'){echo 'active';}?>">
                  <i class="fas fa-book nav-icon"></i>
                  <p>Margin</p>
                </a>
              </li>

              <li class="nav-item">
            <a href="../admin_master_administrator" class="nav-link <?php if($konstruktor=='admin_master_administrator'){echo 'active';}?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Data Admin
              </p>
            </a>
          </li>

           <li class="nav-item">
            <a href="../admin_master_kasir" class="nav-link <?php if($konstruktor=='admin_master_kasir'){echo 'active';}?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Data Kasir
              </p>
            </a>
          </li>

           <li class="nav-item">
            <a href="../admin_master_supplier" class="nav-link <?php if($konstruktor=='admin_master_supplier'){echo 'active';}?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data supplier
              </p>
            </a>
          </li>

            </ul>
          </li>
          
          
          <li class="nav-item">
            <a href="../ganti_pass" class="nav-link <?php if($konstruktor=='ganti_pass'){echo 'active';}?>">
              <i class="nav-icon fas fa-lock"></i>
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

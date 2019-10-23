<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-mail-bulk"></i>
    </div>
    <div class="sidebar-brand-text mx-3">AMS Pertanahan</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my">

  <!-- Query -->

  <?php
  $roleid = $this->session->userdata('roleid');
  $queryMenu = "SELECT `um`.`usermenuid`, `um`.`menu`
                  FROM `usermenu` `um`, `useraccessmenu` `uam`
                 WHERE `um`.`usermenuid` = `uam`.`usermenuid`
                   AND `uam`.`roleid` = $roleid
                 ORDER BY `uam`.`usermenuid` ASC";

  $menu = $this->db->query($queryMenu)->result_array();

  ?>


  <!-- Looping Menu -->
  <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
      <?= $m['menu']; ?>
    </div>

    <!--Siapkan Submenu Sesuai Menu -->
    <?php
      $menuId = $m['usermenuid'];
      $querySubMenu = "SELECT * 
                         FROM `usersubmenu` 
                        WHERE `usermenuid` = $menuId
                          AND `isactive` = 1
      
      ";
      $subMenu = $this->db->query($querySubMenu)->result_array();

      ?>

    <?php foreach ($subMenu as $m) : ?>
      <?php if ($title ==  $m['title']) : ?>

        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= base_url($m['url']); ?>">
          <i class="<?= $m['icon']; ?>"></i>
          <span><?= $m['title']; ?></span></a>
        </li>
      <?php endforeach; ?>

      <hr class="sidebar-divider mt-3">

    <?php endforeach; ?>



    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= url('/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= auth() ? auth()->name : 'Alexander Pierce' ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li <?= (isActiveMenu(['/']) ? 'class="active"' : '') ?>>
          <a href="<?= url('/') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php if (is_admin()) {
          ?>
        <li <?= (isActiveMenu(['/users']) ? 'class="active"' : '') ?>>
          <a href="<?= url('/users') ?>">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
          <?php
        }
        ?>
        <li <?= (isActiveMenu(['/websites']) ? 'class="active"' : '') ?>>
          <a href="<?= url('/websites') ?>">
            <i class="fa fa-globe"></i> <span>Websites</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
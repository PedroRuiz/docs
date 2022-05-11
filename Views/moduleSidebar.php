
<li class="nav-item <?= isset($docsModuleMenuOpen) && $docsModuleMenuOpen === true ? 'menu-open' : null ?>">
  <a href="#" class="nav-link <?= isset($docsModuleMenuOpen) && $docsModuleMenuOpen === true ? 'active' : null ?>">
    <i class="fas fa-file"></i>
    <p>
      <?= lang('docsModule.moduleName') ?>
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="<?= base_locale('docs') ?>" class="nav-link <?= isset($docsModuleEditorActive) && $docsModuleEditorActive === true ? 'active' : null ?>">
        <i class="far fa-circle nav-icon"></i>
        <p><?= lang('docsModule.sidebarTextEditor') ?></p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= base_locale('docs/list') ?>" class="nav-link <?= isset($docsModuleDocsList) && $docsModuleDocsList === true ? 'active' : null ?>"">
        <i class="far fa-circle nav-icon"></i>
        <p><?= lang('docsModule.docsList') ?></p>
      </a>
    </li>   
  </ul>
</li>
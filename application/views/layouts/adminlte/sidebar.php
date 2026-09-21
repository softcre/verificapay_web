<aside class="app-sidebar bg-body-secondary shadow"
       data-bs-theme="dark">

    <div class="sidebar-brand">

        <a href="<?= site_url('admin') ?>"
           class="brand-link">

            <span class="brand-text fw-light">
                My Admin
            </span>

        </a>

    </div>

    <div class="sidebar-wrapper">

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu">

                <li class="nav-item">

                    <a href="<?= site_url('admin') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-speedometer2"></i>

                        <p>
                            Dashboard
                        </p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?= site_url('admin/users') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-people"></i>

                        <p>
                            Users
                        </p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?= site_url('admin/settings') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-gear"></i>

                        <p>
                            Settings
                        </p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>
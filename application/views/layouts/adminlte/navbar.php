<nav class="app-header navbar navbar-expand bg-body">

    <div class="container-fluid">

        <ul class="navbar-nav">

            <li class="nav-item">

                <a class="nav-link"
                   data-lte-toggle="sidebar"
                   href="#"
                   role="button">

                    <i class="bi bi-list"></i>

                </a>

            </li>

        </ul>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item d-flex align-items-center px-2 text-body-secondary">
                <?= html_escape(isset($current_user) ? $current_user : '') ?>
            </li>

            <li class="nav-item">

                <a href="<?= site_url('/') ?>"
                   class="nav-link">

                    <i class="bi bi-globe"></i>
                    Sitio web

                </a>

            </li>

            <li class="nav-item">

                <a href="<?= site_url('logout') ?>"
                   class="nav-link">

                    <i class="bi bi-box-arrow-right"></i>
                    Cerrar sesión

                </a>

            </li>

        </ul>

    </div>

</nav>
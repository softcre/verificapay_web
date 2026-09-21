<main class="app-main">

    <div class="app-content-header">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-6">

                    <h3 class="mb-0">
                        <?= isset($page_title)
                            ? html_escape($page_title)
                            : 'Dashboard'
                        ?>
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="app-content">

        <div class="container-fluid">

            <?php $this->load->view($content_view); ?>

        </div>

    </div>

</main>
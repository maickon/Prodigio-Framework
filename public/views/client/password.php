<!DOCTYPE html>
<html lang="pt-br">

<?php include partials('header'); ?>

<body class="crm_body_bg">

    <?php include partials('sidebar'); ?>

    <section class="main_content dashboard_part large_header_bg">
        
        <?php include partials('top-menu'); ?>

        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">

                <?php breadcrumb($title, $breadcrumb); ?>

                <?php include component('alerts') ?>
                
                <?php include 'partials/password.php' ?>
            </div>
        </div>

        <?php include partials('footer'); ?>
    </section>

    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#">
            <i class="ti-angle-up"></i>
        </a>
    </div>


    <?php include partials('scripts'); ?>
    
</body>

</html>
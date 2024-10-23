<!DOCTYPE html>
<html lang="pt-br">

<?php include partials('header'); ?>

<body class="crm_body_bg">

    <?php include partials('sidebar'); ?>

    <section class="main_content dashboard_part large_header_bg">

        <?php include partials('top-menu'); ?>

        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">

                <?php include partials('breadcrumb'); ?>

                <div class="row ">
                    <div class="col-xl-8 ">
                        <div class="white_card mb_30 card_height_100">
                            <div class="white_card_header">
                                <div class="row align-items-center justify-content-between flex-wrap">
                                    <div class="col-lg-4">
                                        <div class="main-title">
                                            <h3 class="m-0">Stoke Details</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-end d-flex justify-content-end">
                                        <select class="nice_Select2 max-width-220">
                                            <option value="1">Show by month</option>
                                            <option value="1">Show by year</option>
                                            <option value="1">Show by day</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div id="management_bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 ">
                        <div class="white_card card_height_100 mb_30 user_crm_wrapper">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="/assets/img/crm/businessman.svg" alt>
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $clientsTotal ?></h4>
                                            <p>Clientes registrados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm ">
                                        <div class="crm_head d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="/assets/img/crm/infographic.svg" alt>
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= str_replace('.', ',', $totalOrders['total_price']) ?></h4>
                                            <p>Arrecadados de <?= $totalOrders['total_orders'] ?> pedidos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head crm_bg_2 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="/assets/img/crm/infographic.svg" alt>
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $ordersByWeek ?></h4>
                                            <p>Pedidos nesta semana</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head crm_bg_2 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="/assets/img/crm/infographic.svg" alt>
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $ordersTotal ?></h4>
                                            <p>Pedidos já realizados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head crm_bg_1 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="/assets/img/crm/businessman.svg" alt>
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $topClient->client_name ?></h4>
                                            <p><?= $topClient->total_orders ?> Pedidos</p>
                                            <p>R$ <?= number_format($topClient->total_spent, 2, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head crm_bg_1 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="/assets/img/crm/businessman.svg" alt>
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $badClient->client_name ?></h4>
                                            <p><?= $badClient->total_orders ?> Pedidos</p>
                                            <p>R$ <?= number_format($badClient->total_spent, 2, ',', '.')  ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <?php include partials('last-users'); ?>
                    <?php include partials('last-sales'); ?>
                    <?php include partials('sales-details'); ?>

                </div>
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
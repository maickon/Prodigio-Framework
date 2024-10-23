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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30 pt-4">
                            <div class="white_card_body">
                                <div class="QA_section">
                                    <div class="white_box_tittle list_header">
                                        <h4><?= $subtitle ?></h4>
                                        <?php include partials('query-table') ?>
                                    </div>

                                    <?php include component('alerts') ?>

                                    <div class="QA_table mb_30">

                                        <table class="table lms_table_active ">
                                            <thead>
                                                <tr>
                                                    <th scope="col">id</th>
                                                    <th scope="col">Nome da taxa</th>
                                                    <th scope="col">Taxa CNPJ</th>
                                                    <th scope="col">Taxa ICMS</th>
                                                    <th scope="col">Taxa Assessoria</th>
                                                    <th scope="col">Cadastrado</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $object): ?>
                                                <tr>
                                                    <th scope="row"><?= $object->id ?></th>
                                                    <td><?= $object->name ?></td>
                                                    <td><?= $object->cnpj_fee ?>%</td>
                                                    <td><?= $object->icms_fee ?>%</td>
                                                    <td><?= $object->advisory_fee ?>%</td>
                                                    <td><?= date("d/m/Y h:i:s",strtotime($object->created_at)) ?></td>
                                                    <td>
                                                        <div class="action_btns d-flex">
                                                            <a href="/dashboard/taxa/<?= $object->id ?>/editar" class="action_btn mr_10">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                            <a href="/dashboard/taxa/<?= $object->id ?>/excluir" class="action_btn delete" data-bs-toggle="modal" data-bs-target="#modal" data-title="Deletar registro" data-message="Tem certeza que deseja deletar este registro?">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
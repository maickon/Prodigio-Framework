<div class="row">
    <div class="col-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0"><?= $subtitle ?></h3>
                    </div>
                </div>
            </div>
            <form method="POST" action="<?= $path ?>">
                <div class="white_card_body">
                    <div class="row">
                        <div class="col-lg-6">
                            <span>Nome completo</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Nome completo" name="fullname" value="<?= value($formdata, 'fullname') ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <span>Email</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Email" name="email" value="<?= value($formdata, 'email') ?>">
                            </div>
                        </div>

                        <?php if($button == 'Cadastrar'): ?>
                        <div class="col-lg-6">
                            <span>Senha</span>
                            <div class="common_input mb_15">
                                <input type="password" placeholder="Senha" name="password" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <span>Confirmar senha</span>
                            <div class="common_input mb_15">
                                <input type="password" placeholder="Confirmar senha" name="confirm" value="">
                            </div>
                        </div>
                        <?php endif ?>
                        
                        <div class="col-12">
                            <div class="create_report_btn mt_30">
                                <button type="submit" class="btn_1 radius_btn d-block text-center" style="width: 100%;"><?= $button ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
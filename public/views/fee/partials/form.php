<div class="row">
    <div class="col-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0"><?= $subtitle ?></h3>
                        <p>Os campos de porcentagem não são todos obrigatórios. Os campos que não possuem taxa, você pode deixar como 0.</p>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <form method="POST" action="<?= $path ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <span>Nome</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Informe um nome para a taxa" value="<?= value($formdata, 'name') ?>" name="name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <span>Taxa de CNPJ (Campo não obrigatório)</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Informe a porcentagem da taxa de CNPJ. Ex: 2.7 ou 0 se este campo não tiver taxa." value="<?= value($formdata, 'cnpj_fee') ?>" name="cnpj_fee">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <span>Taxa de ICMS (Campo não obrigatório)</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Informe a porcentagem da taxa de ICMS. Ex: 3.1 ou 0 se este campo não tiver taxa." value="<?= value($formdata, 'icms_fee') ?>" name="icms_fee">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <span>Taxa de Assessoria (Campo não obrigatório)</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Informe a porcentagem da taxa de asessoria. Ex: 12 ou 0 se este campo não tiver taxa." value="<?= value($formdata, 'advisory_fee') ?>" name="advisory_fee">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="create_report_btn mt_30">
                                <button type="submit" class="btn_1 radius_btn d-block text-center" style="width: 100%;"><?= $button ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
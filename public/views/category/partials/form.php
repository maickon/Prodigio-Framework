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
            <div class="white_card_body">
                <form method="POST" action="<?= $path ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <span>Nome</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Nome da categoria" value="<?= value($formdata, 'name') ?>" name="name">
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
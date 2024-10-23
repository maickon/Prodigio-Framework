<div class="row">
    <div class="col-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0"><?= $title ?></h3>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <form method="POST" action="<?= $path ?>">
                    <div class="row">
                        <div class="col-lg-3">
                            <span>Cliente</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Nome do cliente" value="<?= value($formdata, 'client')->name ?>" name="client_id">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Produto</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Informe um nome. Ex: BLUSA, SAIA, CAMISA..." value="<?= value($formdata, 'name')->name ?>" name="name_id">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Código do Produto</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Código do produto" value="<?= value($formdata, 'product_code') ?>" name="product_code">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Quantidade</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Quantidade" value="<?= value($formdata, 'quantity') ?>" name="quantity">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Preço</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Quantidade" value="<?= value($formdata, 'price') ?>" name="price">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Marca</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Marca" value="<?= value($formdata, 'brand')->name ?>" name="brand_id">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Tamanho</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Tamanho" value="<?= value($formdata, 'size')->name ?>" name="size_id">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Cor</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Cor" value="<?= value($formdata, 'color')->name ?>" name="color_id">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Status</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Status" value="<?= value($formdata, 'status') ?>" name="status">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Tipo de envio</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Tipo de envio" value="<?= value($formdata, 'shipping_type') ?>" name="shipping_type">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Custo do envio</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Custo do envio" value="<?= value($formdata, 'shipping_cost') ?>" name="shipping_cost">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <span>Imagem</span>
                            <div class="common_input mb_15">
                                <img src="<?= value($formdata, 'photo') ?>" class="img-thumbnail">
                                <input type="file" value="" name="photo">
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
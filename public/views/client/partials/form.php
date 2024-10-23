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
                        <div class="col-lg-12">
                            <span>Nome completo</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Nome completo" name="name" value="<?= value($formdata, 'name') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>CPF ou CNPJ</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="CPF ou CNPJ" name="cpf_cnpj" value="<?= value($formdata, 'cpf_cnpj') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Data de nascimento</span>
                            <div class="common_input mb_15">
                                <input type="date" placeholder="Data de nascimento" name="birth_date" value="<?= value($formdata, 'birth_date') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Sexo</span>
                            <div class="common_input custom-select mb_15">
                                <select class="nice_Select2 nice_Select_line wide" name="gender" id="gender">
                                    <option value="">Selecione</option>
                                    <option value="Masculino" <?= selected('Masculino', $formdata, 'gender') ?>>Masculino</option>
                                    <option value="Feminino" <?= selected('Feminino', $formdata, 'gender') ?>>Feminino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Número do WhatsApp</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="WhatsApp" name="whatsapp" value="<?= value($formdata, 'whatsapp') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Número de telefone alternativo</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Telefone" name="phone" value="<?= value($formdata, 'phone') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Email</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Email" name="email" value="<?= value($formdata, 'email') ?>">
                            </div>
                        </div>
                        <?php if ($button == 'Cadastrar'): ?>
                        <div class="col-lg-3">
                            <span>Senha</span>
                            <div class="common_input mb_15">
                                <input type="password" placeholder="Senha" name="password" value="">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <span>Confirmar senha</span>
                            <div class="common_input mb_15">
                                <input type="password" placeholder="Confirmar senha" name="confirm" value="">
                            </div>
                        </div>
                        <?php endif ?>
                        <div class="col-lg-6">
                            <span>Endereço</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Endereço" name="address" value="<?= value($formdata, 'address') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Complemento</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Complemento" name="complement" value="<?= value($formdata, 'complement') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Bairro</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="Bairro" name="neighborhood" value="<?= value($formdata, 'neighborhood') ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span>Estado</span>
                            <div class="common_input custom-select mb_15">
                                <select class="nice_Select2 nice_Select_line wide" name="state" id="state">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mb_15">
                            <span>Cidade</span>
                            <div class="common_input custom-select mb_15">
                                <select class="nice_Select2 nice_Select_line wide" name="city" id="city">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <span>CEP</span>
                            <div class="common_input mb_15">
                                <input type="text" placeholder="CEP" name="zip_code" value="<?= value($formdata, 'zip_code') ?>">
                            </div>
                        </div>
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
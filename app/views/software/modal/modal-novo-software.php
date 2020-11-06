<!-- Modal Entidade Externa -->
<div class="modal fade" id="novoSoftWare" tabindex="-1" role="dialog" aria-labelledby="Software" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-windows"></i> Novo software ou Licença</h4>
            </div>
            <div class="modal-body">
                <form id="demo-form" class="form-horizontal form-label-left" data-parsley-validate="" novalidate="" method="POST" action="<?= $v_page_url ?>registar">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">Nome: <span style="color: red;"> *</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="nome" id="nome" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Tipo: <span style="color: red;"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="tipo" id="tipo" required="required" class="form-control col-md-7 col-xs-12">
                                <option value=""> --- </option>
                                <option value="<?= Geral::CONS_TIPO_SOFTWARE?>">Software</option>
                                <option value="<?= Geral::CONS_TIPO_DOMINIO?>">Domínio</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Descrição: <span style="color: red;"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea rows="3" name="descricao" id="descricao" required="required" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Licenciamento: <span style="color: red;"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" name="data_inicio" id="data_inicio" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Vencimento: <span style="color: red;"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" name="data_fim" id="data_fim" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Gravar</button>
                            <button class="btn btn-default" type="reset"><i class="fa fa-eraser"></i> Limpar</button>
                        </div>
                    </div>
                </form>
                
            </div>

        </div>


    </div>
</div>


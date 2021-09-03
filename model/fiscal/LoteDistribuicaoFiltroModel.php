<!-- Start Modal Filtro -->
<div class="modal fade" id="FiltroModal" role="dialog" aria-spanledby="FiltroModalspan">
    <div class="modal dialog modal-lg center-block" role="document">
        <div class="container-flex modal-content">
            <form method="get" action="LoteDistribuicao.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="FiltroModalspan">Filtrar documento</h4>
                </div>

                <div class="modal-body" style="padding: 1rem;">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Datas -->
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <label for="dataInicial">Data inicial</label>
                                <div class="input-group date">
                                    <input type="date" id="dataInicial" class="form-control" name="dataInicial">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <label for="dataFinal">Data final</label>
                                <div class="input-group date">
                                    <input type="date" id="dataFinal" class="form-control" name="dataFinal">
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <!--Fechamento body-->
                </div>

                <!--Botões footer-->
                <div class="modal-footer">
                    <button type="button" class="botaoBranco pullTop" data-dismiss="modal">Cancelar</button>
                    <button type="reset" class="botaoBranco pullTop" onClick="limpaform()">Limpar</button>
                    <button type="submit" class="botaoBranco pullTop">Aplicar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- //End Modal Filtro -->

<script>
    $(document).ready(function() {
        
        $('#dataInicial').val("<?= Sistema::getGet("dataInicial") ?>");
        $('#dataFinal').val("<?= Sistema::getGet("dataFinal") ?>");
     });
</script>
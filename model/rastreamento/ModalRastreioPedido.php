<!-- Start Modal Filtro -->
<div class="modal fade" id="FiltroModal" role="dialog" aria-spanledby="FiltroModalspan">
    <div class="modal-lg  center-block" role="document">
        <div class="modal-content">
            <form method="get" action="RastreioPedido.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="FiltroModalspan">Filtrar rastreio de pedido</h4>
                </div>

                <div class="modal-body">
                    <div hidden>
                        <?php
                        if (Sistema::getPost("pendente") == '0'){
                            echo "<input class=\"botaoPressionado\" type='text' name='pendente' value='6,5,2,1'>";
                            echo "<input class=\"botaoPressionado\" type='text' name='ehpendente' value='False'>";
                        }
                        else{
                            echo "<input class=\"botaoPressionado\" type='text' name='pendente' value='0'>";
                            echo "<input class=\"botaoPressionado\" type='text' name='ehpendente' value='True'>";
                        }
                    ?>
                    </div>
                <!--Linha 1-->
                    <div class="row">
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Filial</span>
                            <select name="filial[]" multiple id="filial"></select>
                        </div>
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Cliente</span>
                            <select name="cliente[]" multiple id="cliente"></select>
                        </div>  
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Tipo de pedido</span>
                            <select name="tipo[]" multiple id="tipo"></select>
                        </div>                      
                    </div>

                <!--Linha 2-->
                        <div class="row">                        
                            <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <span>Situação</span>
                                <select name="situacao[]" multiple id="situacao">
                                </select>
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <span>Unidade de negócio do cliente</span>
                                <select name="unidadenegocio[]" multiple id="unidadenegocio">
                                </select>
                            </div> 
                            <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <span>Nr controle</span>
                            <input class="form-control" id="numeroControle" name="numeroControle">
                        </div>                       
                        </div>

                <!--Linha 3-->
                    <div class="row">                           
                            <div class="col-xs-4 col-md-4 col-sm-4 pullBottoms">
                                <span>Data inicial</span>
                                <input type="date" id="dataInicio" class="form-control" name="dataInicio">
                            </div>

                            <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <span>Data final</span>
                                <input type="date" id="dataFinal" class="form-control" name="dataFinal">
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <span>Nr pedido</span>
                            <input class="form-control" id="numeroPedido" name="numeroPedido">
                        </div> 
                        </div>

                <!--Linha 4-->
                    <div class="row">                        
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Remetente</span>
                            <input class="form-control" id="remetente" name="remetente">
                        </div>

                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Destinatário</span>
                            <input class="form-control" id="destinatario" name="destinatario">
                        </div> 
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Rastreamento</span>
                            <input class="form-control" id="rastreamento" name="rastreamento">
                        </div>                       
                    </div>                
                
                <!--Linha 5-->
                    <div class="row">
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Transportadora</span>
                            <input type="text" id="transportadora" class="form-control" name="transportadora">
                        </div>
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                            <span>Nr. doc de transporte (CT-e, NFS-e, ND)</span>
                            <input class="form-control" id="cte" name="cte">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 pullBottom">
                            <span>Nr. doc originário (NF-e, NF, Outros)</span>
                            <input class="form-control" id="documento" name="documento">
                        </div>                        

                        <!-- Esse cara é filho do Transportadora ali de cima-->
                        </break>
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <input type="checkbox" class="form-check-input btnTransporteProprio" id="TRANSPORTEPROPRIO" name="TRANSPORTEPROPRIO">
                                <label class="form-check-label" for="TRANSPORTEPROPRIO">Transporte próprio</label>
                                </break>
                        </div>
                        <!-- Define no filtro para retornar apenas registros com documento emitido--> 
                        <div class="col-xs-4 col-md-4 col-sm-4 pullBottom">
                                <input type="checkbox" class="form-check-input btnEmTransporte" id="EMTRANSPORTE" name="EMTRANSPORTE">
                                <label class="form-check-label" for="EMTRANSPORTE">Em transporte</label>
                                </break>
                        </div>
                    </div>
                
                <!--Linha 6-->
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-sm-12 pullBotton">
                            <span>Observação originário</span>
                            <input type="text" id="observacao" class="form-control" name="observacao"> 
                        </div>   
                    </div>
                
                <!--Fechamento body-->
                </div>

                <!--Botões footer-->
                <div class="modal-footer">
                    <button type="button" class="botaoBranco pullTop" data-dismiss="modal">Cancelar</button>
                    <button type="reset" class="botaoBranco pullTop btnLimpar" >Limpar</button>
                    <button type="button" class="botaoBranco pullTop btnAplicar" data-dismiss="modal">Aplicar</button>
                </div>
               
            </form>
        </div>
    </div>
</div>
<!-- //End Modal Filtro -->

<script>
    $(document).ready(function() {        
        $('#observacao').val("<?= Sistema::getPost("filtroObservacao") ?>");
        $('#numeroPedido').val("<?= Sistema::getPost("filtroNumeroPedido") ?>");
        $('#rastreamento').val("<?= Sistema::getPost("filtroRastreamento") ?>");
        $('#dataInicio').val("<?= Sistema::getPost("filtroDataInicio") ?>");
        $('#dataFinal').val("<?= Sistema::getPost("filtroDataFinal") ?>");
        $('#remetente').val("<?= Sistema::getPost("filtroRemetente") ?>");
        $('#documento').val("<?= Sistema::getPost("filtroDocumento") ?>");
        $('#numeroControle').val("<?= Sistema::getPost("filtroNumeroControle") ?>");
        $('#transportadora').val("<?= Sistema::getPost("filtroTransportadora") ?>");
        $('#cte').val("<?= Sistema::getPost("filtroCte") ?>");
    <?php

    if (!empty(Sistema::getPost('filtroFilial'))) {
        foreach (Sistema::getPostArray('filtroFilial') as $filial) {
            $filialExplode = explode(';', $filial, 2);
            ?>
            $('#filial').append($('<option>', {
                value: '<?= $filial ?>',
                text: '<?= $filialExplode[1] ?>',
                selected: true
            }));
        <?php
    }
    }
    if (!empty(Sistema::getPostArray('filtroTipo'))) {
        foreach (Sistema::getPostArray('filtroTipo') as $tipo) {
            $tipoExplode = explode(';', $tipo, 2);
            ?>
                $('#tipo').append($('<option>', {
                    value: '<?= $tipo ?>',
                    text: '<?= $tipoExplode[1] ?>',
                    selected: true
                }));
            <?php
        }
    }

    if (!empty(Sistema::getPostArray('filtroUnidadenegocio'))) {
        foreach (Sistema::getPostArray('filtroUnidadenegocio') as $unidadenegocio) {
            $unidadenegocioExplode = explode(';', $unidadenegocio, 2);
            ?>
                $('#unidadenegocio').append($('<option>', {
                    value: '<?= $unidadenegocio ?>',
                    text: '<?= $unidadenegocioExplode[1] ?>',
                    selected: true
                }));
            <?php
        }
    }

    if (!empty(Sistema::getPostArray('filtroSituacao'))) {
        foreach (Sistema::getPostArray('filtroSituacao') as $situacao) {
            $situacaoExplode = explode(';', $situacao, 2);
            ?>
                $('#situacao').append($('<option>', {
                    value: '<?= $situacao ?>',
                    text: '<?= $situacaoExplode[1] ?>',
                    selected: true
                }));
            <?php
        }
    }

    if (!empty(Sistema::getPostArray('filtroCliente'))) {
        foreach (Sistema::getPostArray('filtroCliente') as $cliente) {
            $clienteExplode = explode(';', $cliente, 2);
            ?>
                $('#cliente').append($('<option>', {
                    value: '<?= $cliente ?>',
                    text: '<?= $clienteExplode[1] ?>',
                    selected: true
                }));
            <?php
        }
    }

    # Valida se o parâmetro deve estar marcado ao abrir o form de filtros e se estiver deixa o label de transportadora readonly e vazio.
    if (Sistema::getPost('filtroTransporteProprio') == 'S') {
        ?>
        $('#TRANSPORTEPROPRIO').attr('checked', true);
        $('#transportadora').attr('readonly', '');
        $('#transportadora').val('');
        <?php
    }

    if (Sistema::getPost('FiltroEmTransporte') == 'S') {
        ?>
        $('#EMTRANSPORTE').attr('checked', true);
        <?php
    }
    ?>
     });

    // Deixa o label Transportadora readonly e limpo se o Transporte próprio estiver marcado, se não permite edição.
     $("#TRANSPORTEPROPRIO").on('click', function() {
         if ($('#TRANSPORTEPROPRIO').prop('checked') == true) {
            $('#transportadora').attr('readonly', '');
            $('#transportadora').val('');
         } else {
            $('#transportadora').removeAttr('readonly');
            $('#transportadora').val('');
         }
     });
</script>
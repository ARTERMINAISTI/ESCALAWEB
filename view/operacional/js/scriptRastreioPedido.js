var
    $filtroPendenteBoll = false;
    $filtroEmTransporteBoll = false;
    $filtroTransporteProprioBoll = false;
    $vlrFiltroPendente = " AND (A.STATUS NOT IN (3, 4)) "
    $vlrFiltroEmTransporte = 'N';
    $vlrFiltroTransporteProprio = 'N';

$(function () {
    var reqtablenew = $('#reqtablenew').DataTable({
        "createdRow": function( nRow, aData, iDataIndex ) {
            $(nRow).attr('handle', aData["HANDLE"]);                    
        },
        "processing": true,
        "serverSide": true,
        "pageLength": 50,
        "searching": false,
        "scrollY": "71vh",
        "scrollX": true,
        "scrollCollapse": true,
        "lengthMenu": [[20, 50, 100, 1000], [20, 50, 100, 1000]],
        "ajax": {
            "url": "../../model/operacional/RastreioPedidoTabelaModel.php",
            "type": "POST",
            "data": function (d) {
                return $.extend({}, d, {
                    "filtroPendente": $vlrFiltroPendente,
                    "filtroPessoaUsuario": $('#pessoaUsuario').val(),
                    //Filtro modal:
                    //Linha 1:
                    "filtroFilial": $('#filial').val(),
                    "filtroCliente": $('#cliente').val(),
                    "filtroTipoPedido": $('#tipo').val(),
                    //Linha 2:
                    "filtroSituacao": $('#situacao').val(),
                    "filtroUnidadeNegocio": $('#unidadenegocio').val(),
                    "filtroNumeroControle": $('#numeroControle').val(),
                    //Linha 3:
                    "filtroDataInicio": $('#dataInicio').val(),
                    "filtroDataFinal": $('#dataFinal').val(),
                    "filtroNumeroPedido": $('#numeroPedido').val(),
                    //Linha 4:
                    "filtroRemetente": $('#remetente').val(),
                    "filtroDestinatario": $('#destinatario').val(),
                    "filtroRastreamento": $('#rastreamento').val(),
                    //Linha 5:
                    "filtroTransportadora": $('#transportadora').val(),
                    "filtroCte": $('#cte').val(),
                    "filtroDocumento": $('#documento').val(),
                    "filtroTransporteProprio": $vlrFiltroTransporteProprio,
                    "filtroEmTransporte": $vlrFiltroEmTransporte,
                    //Linha 6:
                    "filtroObservacao": $('#observacao').val()
                });
            }
        },
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "columns":[
        {
            "data": "STATUS",
            "responsivePriority": 1,
            "ordenable": true
        },
        {
            "data": "RASTREAMENTO",
            "responsivePriority": 2,
            "ordenable": true
        },
        {
            "data": "EMISSAODOCUMENTO",
            "responsivePriority": 10,
            "className":"text-center",
            "ordenable": false
        },
        {   
            "data": "TIPO",
            "responsivePriority": 4,
            "ordenable": false
        },
        {
            "data": "DOCUMENTOTRANSPORTE",
            "responsivePriority": 9,
            "ordenable": false
        },
        {
            "data": "NUMERONOTAFISCAL",
            "responsivePriority": 7,
            "ordenable": false
        },
        {
            "data": "DESTINATARIO",
            "responsivePriority": 19,
            "ordenable": false
        },
        {
            "data": "MUNICIPIOENTREGA",
            "responsivePriority": 20,
            "ordenable": false
        },
        {
            "data": "ESTADOENTREGA",
            "responsivePriority": 21,
            "ordenable": false
        },
        {
            "data": "VALORMERCADORIA",
            "responsivePriority": 8,
            "className":"text-right",
            "ordenable": false
        },
        {
            "data": "PESOREALDOCUMENTO",
            "responsivePriority": 11,
            "className":"text-right",
            "ordenable": false
        },
        {
            "data": "PESOCUBADODOCUMENTO",
            "responsivePriority": 12,
            "className":"text-right",
            "ordenable": false
        },
        {
            "data": "QTDVOLUMEDOCUMENTO",
            "responsivePriority": 13,
            "className":"text-right",
            "ordenable": false
        },
        {
            "data": "ETAPADATA",
            "responsivePriority": 23,
            "className":"text-center",
            "ordenable": false
        },
        {
            "data": "ETAPAATUAL",
            "responsivePriority": 22,
            "ordenable": false
        },
        {
            "data": "PREVISAOENTREGADOCUMENTO",
            "responsivePriority": 15,
            "className":"text-center",
            "ordenable": false
        },
        {
            "data": "DATAENTREGA",
            "responsivePriority": 3,
            "className":"text-center",
            "ordenable": false
        },
        {
            "data": "REMETENTE",
            "responsivePriority": 16,
            "ordenable": false
        },
        {
            "data": "NUMEROPEDIDO",
            "responsivePriority": 5,
            "ordenable": false
        },
        {
            "data": "NUMEROCONTROLE",
            "responsivePriority": 6,
            "ordenable": false
        }]
    });  

    $(".btnPendente").on('click', function(){
        $filtroPendenteBoll = !$filtroPendenteBoll;

        if ($filtroPendenteBoll) {
            $vlrFiltroPendente = " AND A.STATUS IN (6,5,4,2,1) "
        } else
        {
            $vlrFiltroPendente = " AND (A.STATUS NOT IN (3, 4)) "
        }

        reqtablenew.draw();
    })

    //Destaca a linha ao clicar.
    $('#reqtablenew tbody').on('click', 'tr', function () {
        reqtablenew.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected')});                    

    //Acessa registro com Dbclick.
    $('#reqtablenew tbody').on('dblclick', 'tr', function() {
        var data = $(this).attr('handle');       

        window.location = '../rastreamento/VisualizarRastreioPedido.php?pedido=' + data + "&OP=1";
    });
    
    $(".btnAplicar").on('click',() =>{
        $filtroPendenteBoll = true;
        $vlrFiltroPendente = " AND A.STATUS IN (6,5,4,2,1) ";

        reqtablenew.draw();
    });

    //Limpa os filtros.
    $(".btnLimpar").on('click', function(){
        //$('input').val('');
        $('option').removeAttr('selected');
        $('button#btnMultiselect').text("").attr({title: "Limpou"});
        $vlrFiltroEmTransporte = 'N';
        $vlrFiltroTransporteProprio = 'N';
    });

    $(".btnEmTransporte").on('click', function (){
        $filtroEmTransporteBoll = !$filtroEmTransporteBoll;

        if ($filtroEmTransporteBoll) {
            $vlrFiltroEmTransporte = 'S';

        } else {
            $vlrFiltroEmTransporte = 'N';
        }
    })

    $('.btnTransporteProprio').on('click', function (){
        $filtroTransporteProprioBoll = !$filtroTransporteProprioBoll

        if ($filtroTransporteProprioBoll) {
            $vlrFiltroTransporteProprio = 'S';

        } else {
            $vlrFiltroTransporteProprio = 'N';
        }
    })

    $(".btnExportar").on('click', function(){
        
        $.ajax({
            url: "../../controller/rastreamento/Pedido.php",
            method: "POST",
            dataType: "JSON",
            "data": {
                "ACAO": "getConsultaGenericaMalFeita",
                "filtroPendente": $vlrFiltroPendente,
                "filtroPessoaUsuario": $('#pessoaUsuario').val(),
                //Filtro modal:
                //Linha 1:
                "filtroFilial": $('#filial').val(),
                "filtroCliente": $('#cliente').val(),
                "filtroTipoPedido": $('#tipo').val(),
                //Linha 2:
                "filtroSituacao": $('#situacao').val(),
                "filtroUnidadeNegocio": $('#unidadenegocio').val(),
                "filtroNumeroControle": $('#numeroControle').val(),
                //Linha 3:
                "filtroDataInicio": $('#dataInicio').val(),
                "filtroDataFinal": $('#dataFinal').val(),
                "filtroNumeroPedido": $('#numeroPedido').val(),
                //Linha 4:
                "filtroRemetente": $('#remetente').val(),
                "filtroDestinatario": $('#destinatario').val(),
                "filtroRastreamento": $('#rastreamento').val(),
                //Linha 5:
                "filtroTransportadora": $('#transportadora').val(),
                "filtroCte": $('#cte').val(),
                "filtroDocumento": $('#documento').val(),
                "filtroTransporteProprio": $vlrFiltroTransporteProprio,
                "filtroEmTransporte": $vlrFiltroEmTransporte,
                //Linha 6:
                "filtroObservacao": $('#observacao').val()
            },
            success: function (retorno) {
                //downloadCSV({filename: "Rastreio de pedido.csv", stockData: reqtablenew.ajax.json().data});
                downloadCSV({filename: "Rastreio de pedido.csv", stockData: retorno, charset:"utf-8"});                
            },
            error: function(retorno){
                swal({
                    title: "Oopss!",
                    text: retorno.responseText,
                    icon: "error"
                });
            }
        });        
    });

    $('#reqtablenew').on( 'page.dt', function () {
        $('html, tbody').animate({
            scrollTop: 0
        }, 200);     
    });
});    

function multiselection() {
    $('#filial').multiselect({
        columns: 1,
        search: true
    });

    $('#tipo').multiselect({
        columns: 1,
        search: true
    });

    $('#situacao').multiselect({
        columns: 1,
        search: true
    });

    $('#cliente').multiselect({
        columns: 1,
        search: true
    });

    $('#unidadenegocio').multiselect({
        columns: 1,
        search: true
    });    
};

$.getJSON('../../controller/rastreamento/retornaUnidadeNegocioPedidoFiltro.php', function (data) {
    
    var arrayValue = [];

    $('#unidadenegocio > option:selected').each(function () {
        arrayValue.push($(this).val());
    });

    $('#unidadenegocio').empty();
    
    $.each(data, function (key, value) {
        $("#unidadenegocio").append("<option value='" + value.HANDLE + ";" + value.NOME + "'>" + value.NOME + "</option>");
    });

    arrayValue.forEach(function (value) {
        $('#unidadenegocio option[value="' + value + '"]').attr('selected','selected');
    });
});

$.getJSON('../../controller/administracao/retornaFilialFiltro.php', function (data) {
    
    var arrayValue = [];

    $('#filial > option:selected').each(function () {
        arrayValue.push($(this).val());
    });

    $('#filial').empty();
    
    $.each(data, function (key, value) {
        $("#filial").append("<option value='" + value.HANDLE + ";" + value.NOME + "'>" + value.NOME + "</option>");
    });

    arrayValue.forEach(function (value) {
        $('#filial option[value="' + value + '"]').attr('selected','selected');
    });
});

$.getJSON('../../controller/rastreamento/retornaTipoPedidoFiltro.php', function (data) {
    
    var arrayValue = [];

    $('#tipo > option:selected').each(function () {
        arrayValue.push($(this).val());
    });

    $('#tipo').empty();
    
    $.each(data, function (key, value) {
        $("#tipo").append("<option value='" + value.HANDLE + ";" + value.NOME + "'>" + value.NOME + "</option>");
    });

    arrayValue.forEach(function (value) {
        $('#tipo option[value="' + value + '"]').attr('selected','selected');
    });
});

$.getJSON('../../controller/rastreamento/retornaEtapaPedidoFiltro.php', function (data) {
    
    var arrayValue = [];

    $('#situacao > option:selected').each(function () {
        arrayValue.push($(this).val());
    });

    $('#situacao').empty();
    
    $.each(data, function (key, value) {
        $("#situacao").append("<option value='" + value.HANDLE + ";" + value.NOME + "'>" + value.NOME + "</option>");
    });

    arrayValue.forEach(function (value) {
        $('#situacao option[value="' + value + '"]').attr('selected','selected');
    });
});

$.getJSON('../../controller/rastreamento/retornaPessoaPedidoFiltro.php', function (data) {
    
    var arrayValue = [];

    $('#cliente > option:selected').each(function () {
        arrayValue.push($(this).val());
    });

    $('#cliente').empty();
    
    $.each(data, function (key, value) {
        $("#cliente").append("<option value='" + value.HANDLE + ";" + value.NOME + "'>" + value.NOME + "</option>");
    });

    arrayValue.forEach(function (value) {
        $('#cliente option[value="' + value + '"]').attr('selected','selected');
    });
});
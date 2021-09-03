new WOW().init();

var columnsToHide = [];

var getHighlightedRow = function() {
    return $('table > tbody > tr.highlight');
}

$(document).ready(function () {
	currentRow = getHighlightedRow().closest("tr"); 
	$(currentRow).removeClass('highlight');
});

$(function() {
    var timer = 0;
    $('#tableConsultaConteiner').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
        oldValue = currentRow.find("td:eq(0)").text();
        currentRow = getHighlightedRow().closest("tr"); 
            if((timer == 0)) {
                timer = 1;
                timer = setTimeout(function(){ timer = 0; }, 600);
            }
            else if (currentRow.find("td:eq(0)").text() == oldValue) { 
                window.location.href = '../../view/patio/VisualizarConteiner.php?conteiner=' + parseInt(currentRow.find("td:eq(0)").text());
            }
    });
        timer = 0; 
});

$(function () {

    $('.table').tablesorter({
        widgets: ['zebra', 'columns'],
        usNumberFormat: false,
        dateFormat: 'pt'
    });
    
});

function multiselection() {
    $('#filial,#cliente,#situacao,#tipooperacao,#conteiner,#tipoconteiner,#localizacao,#classificacaoiso,#finalidade').multiselect({
        columns: 1,
        search: true
    });
};

function limparFiltro() {
    $('.btn-multiselect').text('');
    $('.ms-options li.selected label').click();
    $('.ms-options li.selected').removeClass('selected');
    $('#conteiner,#dataInicio,#dataFinal,#dataDemurrage').val(null);
    $('#filial,#cliente,#situacao,#tipooperacao,#conteiner,#tipoconteiner,#localizacao,#classificacaoiso,#finalidade').val('');
}

function aplicarFiltro() {  
    $('#FiltroModal').modal('hide');
    $('#loader').show();
    $('#tableConsultaConteiner tbody').empty();
    $('#registroNaoEncontrato').hide();
    
    $.post('../../controller/patio/ConsultaConteinerRequest.php', { 
        'REQUEST' : 'getRegistro', 
        'FILTRO' : { 
            'FILIAL' : $('#filial').val(),
            'CLIENTE' : $('#cliente').val(),
            'SITUACAO' : $('#situacao').val(),
            'TIPOOPERACAO' : $('#tipooperacao').val(),
            'CONTEINER' : $('#conteiner').val(),
            'TIPOCONTEINER' : $('#tipoconteiner').val(),
            'LOCALIZACAO' : $('#localizacao').val(),
            'CLASSIFICACAOISO' : $('#classificacaoiso').val(),
            'FINALIDADE' : $('#finalidade').val(),
            'DATAENTRADA' : $('#dataInicio').val(),
            'DATASAIDA' : $('#dataFinal').val(),
            'DATADEMURRAGE' : $('#dataDemurrage').val(),
        } 
    }, function(res) {
        if(res) {                
            if(res.DADOS.length > 0) {                
                $('#tableConsultaConteiner tbody').html(res.DADOS.join(''));           
            }
            else {
                $('#registroNaoEncontrato').show();
            }
        }      
        else {
            $('#registroNaoEncontrato').show();
        }        
        $('#loader').hide();    
        
        $('.table').trigger("update");    
        
        setTimeout(function() {      
            ocultaColunas();        
        }, 100);
    }, 'json');       
};


new WOW().init();

var columnsToHide = [];

function multiselection() {
    $('#filial,#dataOrdem,#cliente,#conteiner,#localizacao').multiselect({
        columns: 1,
        search: true
    });
};

function ocultaColunas() {
    for(var i in columnsToHide) {    
        $('.table td:nth-child(' + columnsToHide[i] + '),.table th:nth-child(' + columnsToHide[i] + ')').hide();
    } 
};

function limparColunasExibir(e) { 
    if(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ocultaColunas();

    $('li.list-group-item').each(function () {
        if($(this).hasClass('active')) {
            $(this).click();
        }
    });
};

function limparFiltro() {
    $('.btn-multiselect').text('');
    $('.ms-options li.selected label').click();
    $('.ms-options li.selected').removeClass('selected');
    $('#filial,#dataOrdem,#cliente,#conteiner,#localizacao').val('');
}

function aplicarFiltro() {  	
    $('#FiltroModal').modal('hide');
    $('#loader').show();
    $('#tableConfirmaConteiner tbody').empty();
    $('#registroNaoEncontrato').hide();

    
    $.post('../../controller/patio/ConfirmarConteinerRequest.php', { 
        'REQUEST' : 'getRegistro', 
        'FILTRO' : { 
            'FILIAL' : $('#filial').val(),
			'DATA' : $('#dataOrdem').val(),
            'CLIENTE' : $('#cliente').val(),
            'CONTEINER' : $('#conteiner').val(),
            'LOCALIZACAO' : $('#localizacao').val()            
        } 
    }, function(res) {
        if(res) {                
            if(res.DADOS.length > 0) {                
                $('#tableConfirmaConteiner tbody').html(res.DADOS.join(''));           
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

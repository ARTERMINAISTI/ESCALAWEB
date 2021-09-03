new WOW().init();

var columnsToHide = [];
var mensagem = '';

$(function () {
    adicionarOnClickConsulta();

    $('.table').tablesorter({
        widgets: ['zebra', 'columns'],
        usNumberFormat: false,
        dateFormat: 'pt'
    });

    function reposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    };
    
    $('.modal').on('show.bs.modal', reposition);
    
    $(window).on('resize', function () {
        $('.modal:visible').each(reposition);
    });

    $('.list-group.checked-list-box .list-group-item').each(function () {
        var $widget = $(this),
        $checkbox = $('<input type="checkbox" class="hidden" />'),
        color = ($widget.data('color') ? $widget.data('color') : "primary"),
        style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
        settings = {
            on: {
                icon: 'glyphicon glyphicon-check'
            },
            off: {
                icon: 'glyphicon glyphicon-unchecked'
            }
        };

        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);

        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });

        $checkbox.on('change', function () {
            updateDisplay();
        });

        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
            
            $widget.data('state', (isChecked) ? "on" : "off");
            $widget.find('.state-icon').removeClass().addClass('state-icon ' + settings[$widget.data('state')].icon);

            if(isChecked) {
                $widget.addClass(style + color + ' active');
            } 
            else {
                $widget.removeClass(style + color + ' active');
            }
        };

        function init() {
            if($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplay();
            
            if($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
            }
        };
        init();
    });

    $('#get-checked-data').on('click', function (event) {
        event.preventDefault();
        var checkedItems = {}, counter = 0;
        $("#check-list-box li.active").each(function (idx, li) {
            checkedItems[counter] = $(li).text();
            counter++;
        });
        $('#display-json').html(JSON.stringify(checkedItems, null, '\t'));
    });

    $('.keep-open li.list-group-item').on({
        "click": function() {
            return false;
        }
    });

    $('li.list-group-item').click(function () {
        var ind = $(this).attr('ind-column');
        
        if(!$(this).hasClass('active')) {
            columnsToHide.push(ind);
            $('.table td:nth-child(' + ind + '),.table th:nth-child(' + ind + ')').hide();            
        } 
        else {
            for(var i in columnsToHide) {
                if(columnsToHide[i] == ind) {
                   columnsToHide.splice(i, 1); 
                }
            };
            $('.table td:nth-child(' + ind + '),.table th:nth-child(' + ind + ')').show();
        }        
    });    
    
    limparColunasExibir();
    
});

function multiselection() {
    $('#produto,#cliente,#naturezamercadoria').multiselect({
        columns: 1,
        search: true
    });
};

function adicionarOnClickConsulta(){
    var touchtime = 0;
    $("#tableRoteiroAnalise td").on("click", function() {
    if (touchtime == 0) {
        // set first click
        touchtime = new Date().getTime();
    } else {
        // compare first click to this click and see if they occurred within double click threshold
        if (((new Date().getTime()) - touchtime) < 800) {
            // double click occurred
            $('#tableRoteiroAnalise td').removeClass("activetr");
            $(this).addClass("activetr");
            $(this).parent('tr').find('[name="check[]"]').prop('checked', true);
        
            $('input:radio').each(function () {
                if ($(this).is(':checked')) {
                    window.location.href = '../../view/armazenagem/efetuarCheckList.php?checkList=' + parseInt($(this).val());
                }
            });  
            touchtime = 0;
        } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
        }
    }
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
    $('#produto,#cliente,#naturezamercadoria').val('');
    $('#nrpedido,#lote,#validade').val('');
    $('#notafiscal,#emissao').val('');
}

function aplicarFiltro() {  
    $('#FiltroModal').modal('hide');
    $('#loader').show();
    $('#tableRoteiroAnalise tbody').empty();
    $('#registroNaoEncontrato').hide();
    
    $.post('../../controller/armazenagem/EstoqueArmazemRequest.php', { 
        'REQUEST' : 'getRegistro', 
        'FILTRO' : { 
            'PRODUTO' : $('#produto').val(),
            'NATUREZAMERCADORIA' : $('#naturezamercadoria').val(),
            'CLIENTE' : $('#cliente').val(),
            'NRPEDIDO' : $('#nrpedido').val(),
            'LOTE' : $('#lote').val(),
            'VALIDADE' : $('#validade').val(),
            'NOTAFISCAL' : $('#notafiscal').val(),
            'EMISSAO' : $('#emissao').val()                
        } 
    }, function(res) {
        if(res) {                
            if(res.DADOS.length > 0) {                
                $('#tableRoteiroAnalise tbody').html(res.DADOS.join(''));           
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
        
        adicionarOnClickConsulta();    
        
        setTimeout(function() {      
            ocultaColunas();        
        }, 100);
    }, 'json');       
};
function getHandleCheckList() {
    return $('table').find('.activetr').closest('tr').find(".handle").text();
} 

function EfetuarChecklistFun() {
     mostrarCarregando()
    
    var JSONData = new Object();

    var elementos = document.getElementById("tableEfetuarChecklist").rows;
    for(var i = 1; i < elementos.length; i++) {
        var handleChecklistValor = elementos[i].cells[0].children[0].value;
        var handleChecklistMarcado = 0;
        var observacao = '';

        for(var j = 0; j < elementos[i].cells[2].children.length; j++){
            if (elementos[i].cells[2].children[j].checked){
                handleChecklistMarcado = elementos[i].cells[2].children[j].dataset.handle;
                observacao = elementos[i].cells[3].children[0].value;
            }
        };

        var Checklist = new Object();

        Checklist.HandleChecklistValor = handleChecklistValor;
        Checklist.HandleChecklistMarcado = handleChecklistMarcado;
        Checklist.Observacao = observacao;

        JSONData[i-1] = Checklist;
    }

        $.ajax({
            url: "../../model/armazenagem/GravarCheckList.php",
            method: "POST",
            dataType: 'JSON',
            data: JSONData,
            success: function (retorno) {
                $('#loader').hide();                
                swal({
                    title: "Sucesso!",
                    text: "O checklist foi preenchido com sucesso.",
                    icon: "success",
                    timer: 5000,
                    button: false
                }).then(function () {          
                    inserirAnexosChecklist();
                    //window.location = ('roteiroAnalise.php');       				
                });
            },
            error: function (retorno) {
                $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível preencher o checklist: " + retorno.responseJSON.message,
                    icon: "error",
                    timer: 5000,
                    button: false
                });       
            }			
        
        });        
};

$(document).ready(function() {
    if (document.getElementById("tableEfetuarChecklist")){
        let container = new DataTransfer();
        
        $('input:radio').on("click", function() {
            $(this).context.parentElement.parentElement.cells[4].children[0].removeAttribute('disabled');
        }); 

        var elementos = document.getElementById("tableEfetuarChecklist").rows;
        for(var i = 1; i < elementos.length; i++) {
            elementos[i].cells[4].children[0].setAttribute('disabled', 'disabled');
            for(var j = 0; j < elementos[i].cells[2].children.length; j++) {
                if (elementos[i].cells[2].children[j].checked){
                    elementos[i].cells[4].children[0].removeAttribute('disabled');
                }
            };
        };

        //Anexos
        arrayAnexos = [];

        $('[id^=anexoChecklist]').click(function(){
            handleArray = $(this).context.parentElement.parentElement.cells[0].children[0].value;
        });

        $('#AnexoChecklistModal').on('shown.bs.modal', function(){
            const indexChecklist = arrayAnexos.findIndex(element => element === handleArray);

            if (indexChecklist !== -1){
                container.clearData();

                for (let i=0; i < arrayAnexos[indexChecklist+1].length; i++){
                    container.items.add(arrayAnexos[indexChecklist+1][i]);
                }

                document.querySelector('#anexos').files = container.files;
            }
        });

        $('#AnexoChecklistModal').on('hidden.bs.modal', function() {    
           $('#anexos').val('');
        });

        $('#gravar').on('click', function() {
            arrayAnexosArquivos = [];

            for (let i=0; i<document.querySelector('#anexos').files.length; i++){
                arrayAnexosArquivos[i] = document.querySelector('#anexos').files[i];
            }

            if (!arrayAnexos.some(element => element === handleArray)){
                arrayAnexos[arrayAnexos.length] = handleArray;
                arrayAnexos[arrayAnexos.length] = arrayAnexosArquivos;
            } else {
                arrayAnexos[arrayAnexos.findIndex(element => element === handleArray) + 1 ]  = arrayAnexosArquivos;
            }
        });
    }
});

function inserirAnexosChecklist() {
    $(document).ready(function() {
        mostrarCarregando()

        var elementos = document.getElementById("tableEfetuarChecklist").rows;
        for(var i = 1; i < elementos.length; i++) {
            var handleChecklistValor = elementos[i].cells[0].children[0].value;
            var Checklist = new Object();

            Checklist.HandleChecklistValor = handleChecklistValor;
            Checklist.anexo = [];

            const indexChecklist = arrayAnexos.findIndex(element => element === handleChecklistValor);

            if (indexChecklist !== -1){
                for (let j = 0; j < arrayAnexos[indexChecklist+1].length; j++) {
                    var dataAtual = new Date();
                    var form_data = new FormData();
                    form_data.set('handleChecklist', handleChecklistValor);
                    form_data.set('dataAtual', dataAtual.toLocaleString());
                    form_data.append('files', arrayAnexos[indexChecklist+1][j]);

                    jQuery.ajax({
                        type: "POST",
                        url: "../../model/armazenagem/GravarAnexoChecklist.php",
                        dataType: 'json',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            mensagem = '<br> Anexos cadastrados.' 
                        },
                        error: function (data) {
                            msg = 'Erro: ' + data.responseJSON.message
                            mostrarErro(msg);
                            fecharCarregando();
                            $('#modalOcorrencia').modal('hide');   
                        }
                    });
                    mostrarErro(mensagem);
                    fecharCarregando();
                }
                fecharCarregando();
            }
        };
    })
};
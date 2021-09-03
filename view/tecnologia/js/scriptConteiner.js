$(document).ready(function () {
    $("#CancelarConteiner").hide();   
});

var getHighlightedRow = function() {
    return $('table > tbody > tr.highlight');
}

$(function() {
    $('#movimentacoesmanuaistable').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
      currentRow = getHighlightedRow().closest("tr"); 
      
      $("#CancelarConteiner").toggle(currentRow.find("td:eq(4)").text() == '2');

    });
});

function MovimentarConteiner(){
    var tipoMovimentacao = document.getElementById('tipomovimentacao').value; tipoMovimentacao = tipoMovimentacao.split(","); tipoMovimentacao = tipoMovimentacao[0];
    var dataMovimentacao = document.getElementById('dataMovimentacao').value.toString(); 
    dataMovimentacao = dataMovimentacao.replace('T', ' ');
    var filial = document.getElementById('filialSelect').value; filial = filial.split(","); filial = filial[0];
    var empresa = document.getElementById('filialSelect').value; empresa = empresa.split(","); empresa = empresa[1];
    var localizacao = document.getElementById('localizacaoSelect').value;
    var handleConteiner = document.getElementById('tipomovimentacao').value; handleConteiner = handleConteiner.split(","); handleConteiner = handleConteiner[2];
    var observacao = document.getElementById('observacaoSelect').value;

    var data = {"tipoMovimentacao": tipoMovimentacao, 
                "dataMovimentacao": dataMovimentacao,
                "filial": filial, 
                "empresa": empresa,
                "localizacao": localizacao, 
                "handleConteiner": handleConteiner,
                "observacao": observacao};
    
    if (tipoMovimentacao == '') {	
        $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível realizar a movimentação manual: O tipo de movimentação não pode estar em branco.",
                    icon: "error",
                    timer: 5000,
                    button: false
                });       
    }
    else if (Date.parse(dataMovimentacao) > Date.now()){
        $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível realizar a movimentação manual: A data de movimentação não pode ser maior do que a atual.",
                    icon: "error",
                    timer: 5000,
                    button: false
                });        
    }
    else if (localizacao == '') {	
        $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível realizar a movimentação manual: A localização não pode estar em branco.",
                    icon: "error",
                    timer: 5000,
                    button: false
                });       
    }
    else {
        $('#loader').removeAttr('style');

        $.ajax({
            url: "../../model/patio/MovimentacaoManualConteiner.php",
            method: "POST",
            dataType: 'JSON',
            data: data,
            success: function (retorno) {
                $('#loader').hide();                
                swal({
                    title: "Sucesso!",
                    text: "A movimentação manual foi realizada com sucesso.",
                    icon: "success",
                    timer: 5000,
                    button: false
                }).then(function () {  
                    location.reload();                    					
                });
            },
            error: function (retorno) {
                $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível realizar a movimentação manual: " + retorno.responseJSON.message,
                    icon: "error",
                    timer: 5000,
                    button: false
                });       
            }			
        
        });        
    }
};

$(document).on("hide.bs.modal", function() {
    $(document).find('form').trigger('reset');
})

function CancelarMovimentacaoManual(){
    var movimentacaoManualHandle = currentRow.find("td:eq(3)").text();
    var motivo = document.getElementById('motivo').value;
    var data = {"handle": movimentacaoManualHandle, 
                "motivo": motivo, 
                "cancelar": true};

    if (motivo != '') {	
        $('#loader').removeAttr('style');

        $.ajax({
            url: "../../model/patio/CancelarConteiner.php",
            method: "POST",
            dataType: 'JSON',
            data: data,
            success: function (retorno) {
                $('#loader').hide();                
                swal({
                    title: "Sucesso!",
                    text: "Sua movimentação interna foi cancelada com sucesso.",
                    icon: "success",
                    timer: 5000,
                    button: false
                }).then(function () {  
                    location.reload();                    					
                });
            },
            error: function (retorno) {
                $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível cancelar a sua movimentação interna: " + retorno.responseJSON.message,
                    icon: "error",
                    timer: 5000,
                    button: false
                });       
            }			
        
        });
    } else {
        $('#loader').hide();
                swal({
                    title: "Oopss!",
                    text: "Não foi possível cancelar a sua movimentação interna: O motivo não pode estar em branco.",
                    icon: "error",
                    timer: 5000,
                    button: false
                });           
    }
};
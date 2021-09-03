var getHighlightedRow = function() {
    return $('table > tbody > tr.highlight');
}

$(document).ready(function () {
	currentRow = getHighlightedRow().closest("tr"); 
	$(currentRow).removeClass('highlight');
});

$(function() {
    $('#tableConfirmaConteiner').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
      currentRow = getHighlightedRow().closest("tr"); 
	  handleOrdem = currentRow.find("td:eq(7)").text();
	  handleLocalizacao = currentRow.find("td:eq(8)").text();

		if(handleLocalizacao != 0){
			$('#confirmar').removeClass('display');
		} else {
			$('#confirmar').addClass('display');	
		}
    });
});

$('.modal').on('show.bs.modal', function(){
	handleLocalizacao = currentRow.find("td:eq(8)").text();
	posicaoLocalizacao = currentRow.find("td:eq(6)").text();
	document.getElementById('localizacaoSelect').appendChild(new Option(posicaoLocalizacao, handleLocalizacao));
	$("#localizacaoSelect option[value='" + handleLocalizacao + "']").hide();
	$('#localizacaoSelect').val(handleLocalizacao);
});
$('.modal').on('hidden.bs.modal', function(){
	$("#localizacaoSelect option[value='" + $('#localizacaoSelect').val()+ "']").remove();
});

function ConfirmarLocalizacao(){
	handleLocalizacao = $('#localizacaoSelect').val();
	
	var data = {"handleOrdem": handleOrdem, 
	            "handleLocalizacao": handleLocalizacao};

	if (handleOrdem == '') {	
		$('#loader').hide();
				swal({
					title: "Oopss!",
					text: "Não foi possível realizar a movimentação manual: A ordem selecionada não pode estar em branco.",
					icon: "error",
					timer: 5000,
					button: false
				});   
	}
	else if (handleLocalizacao == '') {	
		$('#loader').hide();
				swal({
					title: "Oopss!",
					text: "Não foi possível realizar a movimentação manual: A localização selecionada não pode estar em branco.",
					icon: "error",
					timer: 5000,
					button: false
				});    
	}
	else {
		$('#loader').removeAttr('style');

		$.ajax({
			url: "../../model/patio/ConfirmarLocalizacaoConteiner.php",
			method: "POST",
			dataType: 'JSON',
			data: data,
			success: function (retorno) {
				$('#loader').hide();                
				swal({
					title: "Sucesso!",
					text: "A localização foi confirmada com sucesso.",
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
					text: "Não foi possível confirmar a localização: " + retorno.responseJSON.message,
					icon: "error",
					timer: 5000,
					button: false
				});       
			}			
		
		});        
	}
};
 $(document).ready(function () {
    $('#reqtablenew td').dblclick(function () {

        $('#reqtablenew td').removeClass("activetr");
        $(this).addClass("activetr");
        $(this).parent('tr').find('[name="check[]"]').prop('checked', true);

        $('input:radio').each(function () {
            if ($(this).is(':checked')) {
                window.location.href = '../../view/fiscal/VisualizarLoteDistribuicao.php?lote=' + parseInt($(this).val());
            }
        });
    });

    $('#reqtableDocumentoLote tr').each(function() {
        $(this).on('click', function() {
            if ($(this).find('input').is(':checked')) {
                $(this).find('input').prop('checked', false);
            } else {
                $(this).find('input').prop('checked', true);
            }
        });
    });

    $('#check').each(function() {
        $(this).on('click', function() {
            if ($(this).is(':checked')) {
                $(this).prop('checked', false);
            } else {
                $(this).prop('checked', true);
            }
        });
    });

    $(function () {
        $('[class="topBarRight"] button').tooltip();
    })

    if ($("#statusLote").val() == "84") {
        setTimeout(() => {
            location.reload();
        }, 15000);
    }

    $("#statusLote").val() == 5 ? $("#botaoDownloadVisualizarLote").css({"display":""}) : $("#botaoDownloadVisualizarLote").css({"display":"none"});
});

function gerarLote($tipoExtracao) {
    let documentos = "";
    let json = "";
    let cliente = null;
    
    $("#reqtableDocumentoLote input:checked").each(function () {
        if ((cliente == null)) {cliente = $(this).attr("cliente")};
        documentos = documentos + "{\"handle\":\"" + $(this).attr("handle") + "\"},";
    });
    
    documentos = documentos.substring(0, documentos.length - 1); // remove a ultima virgula
    
    json = "{" +
           "\"cliente\":\""+ cliente +"\"," +
           "\"tipoExtracao\":\""+ $tipoExtracao + "\"," +
           "\"dataInicial\":\""+ $("#dataInicial").val() +"\"," +
           "\"dataFinal\":\""+ $("#dataFinal").val() +"\"," +
           "\"documentos\":["+ documentos +"]}";

    $.ajax({
    url : "../../controller/fiscal/LoteDistribuicao.php",
        method : "POST",
        datatype : "JSON",
        data : {
            "ACAO" : "gerarLoteDistribuicao",
            "DADOS" : json
        },
        beforeSend : function(){
            $('#loader').css({"display":""});
        },
        success: function (retorno) {
            console.log("Success");
            $('#loader').css({"display":"none"});

            swal({
                title: "Lote gerado!",
                icon: "success",
                showCloseButton: true
            }).then(function(dismiss) {
                location.href = "../../view/fiscal/VisualizarLoteDistribuicao.php?lote=" + retorno;
            });;
        },
        error: function (retorno){
            $('#loader').css({"display":"none"});
            let jsonRetorno = JSON.parse(retorno.responseText);

            swal({
                title: "Oopss!",
                text: jsonRetorno.message,
                icon: "error"
            });     
        }
    });
}

function invertSelection() {
    $("#reqtableDocumentoLote input").each(function () {
        if ($(this).is(":checked")) {
            $(this).prop("checked", false);
        } else {
            $(this).prop("checked", true);
        }
    });
}

const b64toBlob = (b64Data, contentType='', sliceSize=512) => {
    const byteCharacters = atob(b64Data);
    const byteArrays = [];
  
    for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
      const slice = byteCharacters.slice(offset, offset + sliceSize);
  
      const byteNumbers = new Array(slice.length);
      for (let i = 0; i < slice.length; i++) {
        byteNumbers[i] = slice.charCodeAt(i);
      }
  
      const byteArray = new Uint8Array(byteNumbers);
      byteArrays.push(byteArray);
    }
  
    const blob = new Blob(byteArrays, {type: contentType});
    return blob;
  }

function exportarLote(loteHandle) {
    $.ajax({
        url: "../../controller/fiscal/loteDistribuicao.php",
        method: "POST",
        dataType: "JSON",
        data: {
            "ACAO"  : "downloadLote",
            "DADOS" : "{\"loteHandle\":\"" + loteHandle + "\"}"
        },
        success: function(retorno) {
            const blob = b64toBlob(retorno.ARQUIVO, "application/octet-stream");
            var link = document.createElement('a');            
            link.href=window.URL.createObjectURL(blob);
            
            link.download = "LoteDistribuicao" + retorno.HANDLE + ".zip";
            link.click();
        },
        error: function( jqXHR, textStatus ) {
            var jsonErro = JSON.parse(jqXHR.responseText);
             
            swal({
                title: "Oopss!",
                text: "Não foi possível baixar o pdf: " + jsonErro.code + ":" + jsonErro.message,
                icon: "error"
            });

        }
    });
}
function ajustarMascaraCampoModalFiltro() {
    const elementoModal = document.getElementById('painel_filtro');
    const elementoModalCampo = elementoModal.querySelectorAll('input');

    elementoModalCampo.forEach(elementoModalCampoItem => {
        if (elementoModalCampoItem.hasAttribute('data-mask')) {
            $('#' + elementoModalCampoItem.id).mask(elementoModalCampoItem.getAttribute('data-mask'));
        }
    });
}

function abrirModalFiltro() {
    $('#painel_filtro').modal('show');
}

function atualizarValorEditTabelaModalFiltro(idElementoEdit, handleRegistroSelecionado, traducaoRegistroSelecionado) {
    var elementoEdit = document.getElementById(idElementoEdit);
   
    elementoEdit.setAttribute('valorcomparacao', handleRegistroSelecionado);
    elementoEdit.value = traducaoRegistroSelecionado;    

    document.getElementById(idElementoEdit + '_botao_remover').style.display = "inline-block";
}

function fecharModalFiltro() {
    const elementoModal = document.getElementById('painel_filtro');
    const elementoModalCampo = elementoModal.querySelectorAll("input");

    continuar = true;

    elementoModalCampo.forEach(elementoModalCampoItem => {
        if (!continuar) {
            return;
        }

        if ((elementoModalCampoItem.getAttribute('obrigatorio') == 'S') && (elementoModalCampoItem.value == '')) {
            alert('O filtro ' + elementoModalCampoItem.getAttribute('legenda').toLowerCase() + ' não foi preenchido.');
                        
            continuar = false;

            return;
        }

        if (elementoModalCampoItem.classList.contains("data-invalida")) {
            alert('O valor informado no filtro ' + elementoModalCampoItem.getAttribute('legenda').toLowerCase() + ' não é válido. Verifique se a data está no formato: ' + elementoModalCampoItem.getAttribute("placeholder") + '.');
                        
            continuar = false;

            return;            
        }
    });

    if (continuar) {								
        $('#painel_filtro').modal('hide');
        
        atualizarPainel();
    }
}	

function gerarJsonModalFiltro () {								
    const elementoModal = document.getElementById('painel_filtro');
    const elementoModalCampo = elementoModal.querySelectorAll("input");

    var json = [];
    
    elementoModalCampo.forEach(elementoModalCampoItem => {
        var jsonItem = {};
        
        jsonItem.nome = elementoModalCampoItem.id.replace('painel_filtro_', ''); 
        jsonItem.tipo = elementoModalCampoItem.getAttribute('tipo');

        if (elementoModalCampoItem.hasAttribute('valorcomparacao')) {
            jsonItem.valor = elementoModalCampoItem.getAttribute('valorcomparacao');										
        }
        else {
            jsonItem.valor = elementoModalCampoItem.value;
        }

        json.push(jsonItem);
    });

    return JSON.stringify(json);
}

function removerSelecaoModalFiltro(elementoBotaoRemover) {
    var elementoEdit = document.getElementById(elementoBotaoRemover.id.replace('_botao_remover', ''));
    
    elementoEdit.setAttribute('valorcomparacao', '');
    elementoEdit.value = '';

    elementoBotaoRemover.style.display = "none";
}

function validarDataModalFiltro(elementoData) {	
    elementoData.classList.remove("data-invalida");
    elementoData.setAttribute('valorcomparacao', '1899/12/01 00:00:00');
    
    const dataDigitada = elementoData.value;
   
    if (dataDigitada != '') {
        let mascaraData = elementoData.getAttribute("placeholder");
        let parteData = [];

        parteData['AAAA'] = (new Date).getFullYear();
        parteData['DD'] = (new Date).getDate();
        parteData['MM'] = (new Date).getMonth() + 1;
        parteData['mm'] = '00';
        parteData['hh'] = '00';
        parteData['ss'] = '00';

        Object.entries(parteData).forEach(([key, value]) => {
            let mascaraDataIndice = mascaraData.indexOf(key);

            if ((mascaraDataIndice >= 0) && (dataDigitada.length >= (mascaraDataIndice + key.length))) {
                parteData[key] = dataDigitada.substring(mascaraDataIndice, mascaraDataIndice + key.length);
            }; 	        
        });

        let dataVerificacao = new Date(parteData['AAAA'] + '/' + parteData['MM'] + '/' + parteData['DD'] + ' ' + parteData['hh'] + ':' + parteData['mm']  + ':' + parteData['ss']);

        if ((dataVerificacao == 'Invalid Date') || (dataVerificacao == 'Data Invalida') || (dataDigitada.length != mascaraData.length)) {           
            elementoData.classList.toggle("data-invalida", true);        
        }
        else {
            elementoData.setAttribute('valorcomparacao', parteData['AAAA'] + '/' + parteData['MM'] + '/' + parteData['DD'] + ' ' + parteData['hh'] + ':' + parteData['mm']  + ':' + parteData['ss']);
        }
    }
}

function validarNumericoModalFiltro(elementoNumerico) {	
    if (elementoNumerico.value == '') {
        elementoNumerico.value = 0;
    }
}
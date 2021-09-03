var _painelFiltroBotaoBuscar = null;

function abrirModalFiltroSelecao(elementoBotaoBuscar) {
    _painelFiltroBotaoBuscar = elementoBotaoBuscar;

    document.getElementById('painel_filtro_selecao_edit').value = '';

    atualizarModalFiltroSelecao('');

    $('#painel_filtro_selecao').modal('show');
}	

function atualizarModalFiltroSelecao(idElementoOrdenacao) {
    const elementoTabela = document.getElementById('painel_filtro_selecao_tabela');
    const json = gerarJsonModalFiltroSelecao(idElementoOrdenacao);

    efetuarRequest('FILTRO=' + json + '&ACAO=FILTROBUSCARREGISTRO', function (response) {
        elementoTabela.innerHTML = response;
    });
}

function buscarRegistroModalFiltroSelecao() {
    atualizarModalFiltroSelecao('');
}

function fecharModalFiltroSelecao() {
    const elementoTabela = document.getElementById('painel_filtro_selecao_tabela');
    elementoTabela.innerHTML = '';

    $('#painel_filtro_selecao').modal('hide');
}	

function gerarJsonModalFiltroSelecao(idElementoOrdenacao) {
    var jsonResultado = {};

    const elementoOrdenacao = document.getElementById(idElementoOrdenacao);
    var jsonParametro = atob(_painelFiltroBotaoBuscar.getAttribute('parametro'));   

    var ordenacaoCrescente = true;
    var campoordenacao = '';

    if (elementoOrdenacao != null) {
        ordenacaoCrescente = !elementoOrdenacao.classList.contains("th-asc");
        campoordenacao = elementoOrdenacao.getAttribute('name');
    }

    if (jsonParametro != '') {
        jsonParametro = JSON.parse(jsonParametro);
        
        jsonResultado.campo = jsonParametro.campo;
        jsonResultado.tabela = jsonParametro.tabela;
        jsonResultado.localwheredefault = jsonParametro.localwheredefault;
    }

    jsonResultado.campoordenacao = campoordenacao;
    jsonResultado.ordenacaoasc = ordenacaoCrescente;
    jsonResultado.localwhereusuario = document.getElementById('painel_filtro_selecao_edit').value;

    return JSON.stringify(jsonResultado);    
}

function ordernarTabelaModalFiltroSelecao(idElementoOrdenacao) {
    atualizarModalFiltroSelecao(idElementoOrdenacao);
}

function selecionarRegistroTabelaModalFiltroSelecao(elementoSelecionado) {
    atualizarValorEditTabelaModalFiltro(_painelFiltroBotaoBuscar.id.replace('_botao_buscar', ''), elementoSelecionado.getAttribute('value'), elementoSelecionado.parentElement.getAttribute('value'));

    fecharModalFiltroSelecao();
}
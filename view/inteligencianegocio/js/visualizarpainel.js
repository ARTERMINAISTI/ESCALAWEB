import Painel from "./class/painel.js";

document.addEventListener("DOMContentLoaded", () => {   
    let painel = new Painel();    

    painel.elemento = document.getElementById("painel_conteudo");
    painel.identificador = document.location.search.replace("?", "");

    painel.carregarEstrutura();

    document.getElementById("botao_atualizar").addEventListener("click", args => {
        painel.atualizarValor();
    });

    document.getElementById("botao_filtrar").addEventListener("click", args => {
        painel.filtrar();
    }); 
});
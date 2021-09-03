import Constantes from "../helper/constantes.js";
import Abstract from "./abstract.js";

export default class Valor extends Abstract {

    atualizarValor(valor) {
        if (valor.item == null) {
            return;
        }

        let dimensao = this.#calcularDimensao(valor);

        if (dimensao == null) {
            return;
        }

        this.elemento.style.display = "flex";
        this.elemento.style.flex = "initial";
        this.elemento.style.flexDirection = "row";
        this.elemento.style.flexWrap = "wrap";

        valor.item.forEach(item => {
            let div = this.criarElementoHtml(this.elemento, "div");

            div.style.flex = "initial";
            div.style.flexDirection = "column";

            div.style.height = dimensao.altura + "px";
            div.style.width = dimensao.largura + "%";  

            if (("ehexibirborda" in item) && (item.ehexibirborda)) {
                div.style.border = "1px solid #ddd";
            }

            if (("corfundo" in item) && (item.corfundo != null)) {
                div.style.background = item.corfundo;
            }
            else if (("ehdestacar" in item) && (item.ehdestacar)) {
                div.classList.add("componente-item-active");
            }

            if (("corfonte" in item) && (item.corfonte != null)) {
                div.style.color = item.corfonte;
            }

            if ("titulo" in item) {
                var titulo = this.montarItemTitulo(div, item);
            }

            if ("valor" in item) {
                var valor = this.montarItemValor(div, item);
            }

            this.ajustarAlturaCorpo(div, valor, titulo, null, true);
        });      
    }

    #calcularDimensao(valor) {
        valor.quantidaderegirstro = valor.quantidaderegirstro > valor.item.length ? valor.item.length : valor.quantidaderegirstro;

        if (valor.quantidaderegirstro == 0) {
            return;
        }

        let quantidadeColuna = 0;
        let quantidadelinha = 0;

        if (valor.organizarregistro === Constantes.ComponenteOrganizarRegistroLinha) {
            quantidadeColuna = Math.ceil(valor.item.length / valor.quantidaderegirstro);
            quantidadelinha  = valor.quantidaderegirstro;
        }
        else {
            quantidadeColuna = valor.quantidaderegirstro;
            quantidadelinha  = Math.ceil(valor.item.length / valor.quantidaderegirstro);
        }

        return {altura: Math.floor(this.elemento.offsetHeight / quantidadelinha), largura: 100 / quantidadeColuna};
    }

    montarItemTitulo(elemento, item) {
        if (item.titulo == null) {
            return;
        }

        let header = this.criarElementoHtml(elemento, "header");

        header.style.alignItems = "center";
        header.style.display = "flex";

        header.style.fontSize = item.titulo.tamanhofonte + "px";
        header.style.height = (item.titulo.tamanhofonte + 10) + "px";
        
        switch (item.titulo.alinhamento) {
            case Constantes.AlinhamentoTextoCentro:
                header.style.justifyContent = "center";
                break;

            case Constantes.AlinhamentoTextoDireita:
                header.style.justifyContent = "flex-end";
                break;
        
            default:
                break;
        }

        header.textContent = item.titulo.valor;

        return header;
    }

    montarItemValor(elemento, item) {
        return null;
    }
}
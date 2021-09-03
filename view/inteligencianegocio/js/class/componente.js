import Abstract from "./abstract.js";
import Calendario from "./calendario.js";
import Constantes from "../helper/constantes.js";
import Grafico from "./grafico.js";
import Tabela from "./tabela.js";
import ValorIndicador from "./valorindicador.js";
import ValorMedidor from "./valormedidor.js";

export default class Componente extends Abstract {

    #componente = null;
    #estrutura = null;

    atualizarValor(filtro) {
        this.elemento.textContent = "buscando valor...";
        this.elemento.style.color = "black"; 
        this.elemento.style.fontSize = "10px"; 
        this.elemento.style.paddingLeft = "15px";
        this.elemento.style.paddingTop = "15px";
        
        const request = new XMLHttpRequest();
								
        request.open("POST", "../../controller/inteligencianegocio/painelcontroller.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        request.onload = () => {                       
            this.elemento.style.paddingLeft = "0px";
            this.elemento.style.paddingTop = "0px";

            let json = JSON.parse(request.response);

            this.#removerElemento();

            if (request.status === 200) {
                this.#montarComponenteValor(json);

                return;
            }

            this.atualizarErro(json);

            return;
        }

        request.send(JSON.stringify({destino: "Componente", metodo: "getValor", parametro: {estrutura: this.#estrutura, filtro: filtro}}));
    }

    carregarEstrutura(filtro) {
        const request = new XMLHttpRequest();
								
        request.open("POST", "../../controller/inteligencianegocio/painelcontroller.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        request.onload = () => {
            let json = JSON.parse(request.response);

            if (request.status === 200) {
                this.#estrutura = json.estrutura;

                this.#montarComponente(json.tipo);
                this.atualizarValor(filtro);

                return;
            }

            this.atualizarErro(json);

            return;
        }
        
        request.send(JSON.stringify({destino: "Componente", metodo: "getEstrutura", parametro: {identificador: this.identificador}}));
    }

    #montarComponente(tipo) {
        switch (tipo) {
            case Constantes.ComponenteTipoCalendario:
                this.#componente = new Calendario();
                
                break;

            case Constantes.ComponenteTipoGrafico:
                this.#componente = new Grafico();
                
                break;

            case Constantes.ComponenteTipoIndicadorValor:
                this.#componente = new ValorIndicador();
                
                break;

            case Constantes.ComponenteTipoMedidor:
                this.#componente = new ValorMedidor();
                
                break;

            case Constantes.ComponenteTipoTabela:
                this.#componente = new Tabela();
                
                break;
        
            default:
                this.#componente = new Abstract();

                break;
        }
    }

    #montarComponenteCorpo(elemento, valor) {
        if (valor.corpo === null) {
            return;
        }

        return this.criarElementoHtml(elemento, "div");
    }

    #montarComponenteRodape(elemento, valor) {
        if (valor.rodape === null) {
            return;
        }

        let footer = this.criarElementoHtml(elemento, "footer");

        if (valor.rodape.ehdestacar) {
            footer.classList.add("componente-item-active");
        }

        footer.style.alignItems = "center";
        footer.style.borderTop = "1px solid #ddd";
        footer.style.display = "flex";
        footer.style.fontSize = valor.rodape.tamanhofonte + "px";
        footer.style.height = (valor.rodape.tamanhofonte + 10) + "px";        

        switch (valor.rodape.alinhamento) {
            case Constantes.AlinhamentoTextoCentro:
                footer.style.justifyContent = "center";
                break;

            case Constantes.AlinhamentoTextoDireita:
                footer.style.justifyContent = "flex-end";
                break;
        
            default:
                break;
        }

        footer.textContent = valor.rodape.valor;

        return footer;
    }

    #montarComponenteTitulo(elemento, valor) {
        if (valor.titulo === null) {
            return;
        }

        let header = this.criarElementoHtml(elemento, "header");
        
        header.style.borderBottom = "1px solid #ddd";
        header.style.display = "flex";
        header.style.flexDirection = "row";

        if (valor.titulo.ehdestacar) {
            header.classList.add("componente-item-active");
        }

        let div = this.criarElementoHtml(header, "div");

        div.style.alignItems = "center";
        div.style.display = "flex";
        div.style.flex = "2";
        div.style.fontSize = valor.titulo.tamanhofonte + "px";
        div.style.height = (valor.titulo.tamanhofonte + 10) + "px";

        div.classList.add("componente-item-header");
        
        switch (valor.titulo.alinhamento) {
            case Constantes.AlinhamentoTextoCentro:
                div.style.justifyContent = "center";
                break;

            case Constantes.AlinhamentoTextoDireita:
                div.style.justifyContent = "flex-end";
                break;
        
            default:
                break;
        }

        div.textContent = valor.titulo.valor;

        return header;
    }

    #montarComponenteValor(valor) {
        let div = this.criarElementoHtml(this.elemento, "div");        
        
        div.style.margin = "2px";
        div.style.height = this.elemento.offsetHeight - 5 + "px";
        div.style.width = "99%";

        if (("ehexibirborda" in valor) && (valor.ehexibirborda)) {
              div.style.border = "1px solid #ddd";
        }

        if ("titulo" in valor) {
            var titulo = this.#montarComponenteTitulo(div, valor);
        }

        if ("corpo" in valor) {
            var corpo = this.#montarComponenteCorpo(div, valor);
        }  

        if ("rodape" in valor) {
            var rodape = this.#montarComponenteRodape(div, valor);
        }
        
        if (titulo != null) {
            this.#componente.elemento = titulo;
            this.#componente.identificador = this.identificador;
            this.#componente.atualizarTitulo(valor.titulo);
        }       

        if (corpo != null) {
            this.ajustarAlturaCorpo(div, corpo, titulo, rodape, true);            

            this.#componente.elemento = corpo;
            this.#componente.identificador = this.identificador;
            this.#componente.atualizarValor(valor.corpo);
        }
    }

    #removerElemento() {
        while (this.elemento.firstChild) {
            this.elemento.removeChild(this.elemento.firstChild);
        }
    }
}
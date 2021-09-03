import Abstract from "./abstract.js";
import Componente from "./componente.js";
import Filtro from "./filtro.js";
import Constantes from "../helper/constantes.js";

export default class Painel extends Abstract {
    #componentes = []; 
    #filtro = null;

    #alturaConfiguracao = 0;
    #larguraConfiguracao = 0;

    #atualizarTitulo(titulo) {
        document.getElementById("painel_titulo").innerHTML = titulo;
    }

    atualizarValor() { 
        if ((this.#filtro != null) && (!this.#filtro.filtrando)) {
            this.elemento.style.paddingLeft = "0px";
            this.elemento.style.paddingTop = "0px";

            this.#componentes.forEach(componente => {
                componente.atualizarValor(this.#filtro.valor);            
            });
        }
    }

    carregarEstrutura() {
        const request = new XMLHttpRequest();
								
        request.open("POST", "../../controller/inteligencianegocio/painelcontroller.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        request.onload = () => {  
            let json = JSON.parse(request.response);

            if (request.status === 200) {
                this.#atualizarTitulo(json.titulo);
                this.#montarFiltro(json.filtro);
                this.#montarPainel(json.componente);

                return;
            }

            this.atualizarErro(json)

            return;
        }
        
        request.send(JSON.stringify({destino: "Painel", metodo: "getEstrutura", parametro: {handle: this.identificador}}));
    }  

    #instanciarCompoenente(div, identificador) {
        let componente = new Componente();

        componente.elemento = div;
        componente.identificador = identificador;

        componente.carregarEstrutura(this.#filtro.valor);

        this.#componentes.push(componente);
    } 

    #montarComponente(componente, componentePai, elementoPai) {
        if (componente === null) {
            return;
        }

        if ("item" in componente) {
            if (window.screen.width <= 800) {
                var div = elementoPai;

                if (componente.nome === "dxLayoutControlGroup_Root") {
                    this.#alturaConfiguracao = componente.parent.altura;
                    this.#larguraConfiguracao = componente.parent.largura;
                }                
            }
            else {
                var div = this.criarElementoHtml(elementoPai, "div");
                
                if (componente.nome === "dxLayoutControlGroup_Root") {
                    div.style.height =  (componente.altura * 100) / componente.parent.altura + "%";
                    div.style.width = (componente.largura * 100) / componente.parent.largura + "%";
                }
                else {
                    div.style.height = (componente.altura * 100) / componentePai.altura + "%";
                    div.style.width = (componente.largura * 100) / componentePai.largura + "%";
                }

                if ("orientacao" in componente) {
                    switch (parseInt(componente.orientacao)) {
                        case Constantes.ComponenteOrientacaoHorizontal: 
                            div.classList.add("componente-grupo-linha");
                            break;

                        case Constantes.ComponenteOrientacaoVertical: 
                            div.classList.add("componente-grupo-coluna");
                            break;
                    }
                }
            }
            
            componente.item.forEach(componenteItem => {
               this.#montarComponente(componenteItem, componente, div) 
            });
        }
        else {
            let div = this.criarElementoHtml(elementoPai, "div");

            div.classList.add("componente-item");

            div.id = componente.identificador;

            div.style.height = div.style.height = window.screen.width > 800 ? (componente.altura * 100) / componentePai.altura + "%" : (componente.altura / this.#alturaConfiguracao) * 800 + "px";
            div.style.width = (componente.largura * 100) / componentePai.largura + "%";            

            this.#instanciarCompoenente(div, componente.identificador);
        }
    }

    async #montarFiltro(filtro) {
        this.#filtro = new Filtro();

        this.#filtro.identificador = this.identificador;

        this.#filtro.carregarEstrutura(filtro);

        this.#filtro.parent = this;
    }

    #montarPainel(componente) {
        let elementoPai = document.getElementById("painel_conteudo");
        
        let div = this.criarElementoHtml(elementoPai, "div");

        div.classList.add("componente-grupo-coluna");
        
        div.style.height = window.screen.width > 800 ? window.screen.height - 180 + "px" : "auto";
        div.style.width = "100%";

        this.#montarComponente(componente, null, div);
    }

    filtrar() {
        if ((this.#filtro != null) && (!this.#filtro.filtrando)) {
            this.#filtro.executar();
        }
    }    
}
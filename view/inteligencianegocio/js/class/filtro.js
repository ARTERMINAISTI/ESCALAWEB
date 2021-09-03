import Abstract from "./abstract.js";
import Edit from "./edit.js";
import EditDateTime from "./editdatetime.js";
import EditLookup from "./editlookup.js";
import EditNumeric from "./editnumeric.js";
import Constantes from "../helper/constantes.js";

export default class Filtro extends Abstract {
    #edits = [];
    #formulario = null;
    #parent = null;
    
    set parent(parent) {
        this.#parent = parent;
    }

    get filtrando (){
        return this.#formulario.style.display == "block";
    }

    get valor () {
        let valor = [];
        
        this.#edits.forEach(edit => {
            valor.push(edit.valor);
        });
    
        return valor;        
    }

    #alterarDisplayComponente(display) {
        document.querySelectorAll(".nao_exibir_ao_filtrar").forEach(nao_exibir_ao_filtrar => {
            nao_exibir_ao_filtrar.style.display = display;            
        });
    }

    carregarEstrutura(estrutura) {
        this.#formulario = this.criarElementoHtml(document.body, "div");

        this.#formulario.style.backgroundColor = "rgba(0,0,0,0.4)";
        this.#formulario.style.display = "none";
        this.#formulario.style.left = 0;
        this.#formulario.style.position = "fixed";
        this.#formulario.style.top = 0;
        this.#formulario.style.paddingTop = "55px";
        this.#formulario.style.height = "100%";
        this.#formulario.style.width = "100%";

        let conteudo = this.criarElementoHtml(this.#formulario, "div");

        conteudo.style.backgroundColor = "#fefefe";
        conteudo.style.width = window.screen.width <= 800 ? "100%": "700px";
        conteudo.style.height = "auto";
        conteudo.style.margin = "auto";
        conteudo.style.border = "1px solid #888";
        conteudo.style.fontFamily = "segoe UI";
        conteudo.style.fontSize = "12px";

        let header = this.criarElementoHtml(conteudo, "header");

        header.classList.add("componente-item-active");
        header.classList.add("modal-item");
        
        header.style.alignItems = "center";
        header.style.borderBottom = "1px solid #ddd";
        header.style.display = "flex";
        header.style.flexDirection = "row";
        header.style.width = "100%";
        header.style.height = "30px";

        header.textContent = "Filtro do painel";

        let corpo = this.criarElementoHtml(conteudo, "div");

        estrutura.forEach(filtro => {
            let agrupador = this.criarElementoHtml(corpo, "div");

            agrupador.classList.add("modal-item");

            agrupador.style.width = "100%";

            let legenda = this.criarElementoHtml(agrupador, "div");

            legenda.style.width = "100%";
            legenda.textContent = filtro.titulo;            
          
            switch (filtro.tipo) {
                case Constantes.ComponenteTipoFiltroData:
                    let editDateTime = new EditDateTime();

                    editDateTime.identificador = filtro.nome;
                    editDateTime.elemento = agrupador;
                    editDateTime.carregarEstrutura(filtro);

                    this.#edits.push(editDateTime);

                    break;

                case Constantes.ComponenteTipoFiltroLista:
                case Constantes.ComponenteTipoFiltroTabela:
                    let editLookup = new EditLookup();

                    editLookup.identificador = filtro.nome;
                    editLookup.elemento = agrupador;
                    editLookup.carregarEstrutura(filtro);

                    this.#edits.push(editLookup);

                    break;

                case Constantes.ComponenteTipoFiltroNumerico:
                    let editnumeric = new EditNumeric();
    
                    editnumeric.identificador = filtro.nome;
                    editnumeric.elemento = agrupador;
                    editnumeric.carregarEstrutura(filtro);
    
                    this.#edits.push(editnumeric);
    
                    break;

                case Constantes.ComponenteTipoFiltroTexto:
                    let edit = new Edit();

                    edit.identificador = filtro.nome;
                    edit.elemento = agrupador;
                    edit.carregarEstrutura(filtro);

                    this.#edits.push(edit);

                    break;
            
              default:
                break;
            }
        });        

        let footer = this.criarElementoHtml(conteudo, "footer");

        footer.classList.add("modal-item");
        
        footer.style.alignItems = "center";
        footer.style.borderTop = "1px solid #ddd";
        footer.style.display = "flex";
        footer.style.flexDirection = "row";
        footer.style.justifyContent = "flex-end";

        let button = this.criarElementoHtml(footer, "button");

        button.style.display = "flex";
        button.style.fontSize = "10px";
        button.style.height = "30px";
        button.style.alignItems = "center";
        button.textContent = "Ok";

        button.addEventListener("click", args => {
            this.#fecharFormulario();
        });
    }

    executar() {
        this.#alterarDisplayComponente("none");

        this.#formulario.style.display = "block";
    }

    #fecharFormulario () {
        var continuar = true;

        this.#edits.forEach(edit => {
            if (!continuar) {
                return;
            }

            if (!edit.valorValido()) {
                continuar = false;
                
                return;
            }
        });
        
        if (continuar) {
            this.#alterarDisplayComponente("block");
            this.#formulario.style.display = "none";
            this.#parent.atualizarValor();
        }
    }
}
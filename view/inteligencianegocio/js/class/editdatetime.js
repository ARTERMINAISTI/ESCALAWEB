import Abstract from "./abstract.js";
import Constantes from "../helper/constantes.js";
import FormatarData from "../helper/formatardata.js";

export default class EditDateTime extends Abstract {
    #estrutura = null;
    
    #inputDe = null;
    #inputAte = null;

    get valor() {
        return {nome: this.#estrutura.nome, tipo: this.#estrutura.tipo, valorde: this.#inputDe.getAttribute("valor"), valorate: this.#inputAte.getAttribute("valor")};
    }

    valorValido() {
        if ((this.#estrutura.ehobrigatorio) && (this.#inputDe.value == "") && (this.#inputAte.value == "")) {
            alert(`O filtro ${this.#estrutura.titulo.toLowerCase()} não foi preenchido.`);
            
            return false;
        }

        if ((this.#inputDe.classList.contains("data-invalida")) || (this.#inputAte.classList.contains("data-invalida"))) {
            alert(`O valor informado no filtro ${this.#estrutura.titulo.toLowerCase()} não é válido. Verifique se a data está no formato: ${this.#estrutura.data.formatacao.exibicao}.`);
                        
            return false;      
        }

        return true;
    }

    carregarEstrutura(estrutura) {
        this.#estrutura = estrutura;

        let div = this.criarElementoHtml(this.elemento, "div");
        
        div.style.display = "flex";
        div.style.flexDirection = "row";        
        
        this.#inputDe = this.criarElementoHtml(div, "input");

        this.#inputDe.classList.add("form-control");
        
        this.#inputDe.setAttribute("maxlength", estrutura.data.formatacao.exibicao.length);
        this.#inputDe.setAttribute("placeholder", estrutura.data.formatacao.exibicao);
        this.#inputDe.setAttribute("data-mask", estrutura.data.formatacao.sugestao);
        this.#inputDe.setAttribute("type", "text");

        this.#inputDe.style.flex = "initial";
        this.#inputDe.style.marginRight = "2px";
        this.#inputDe.style.width = "35%";        

        if (("data" in estrutura) && ("valorinicial" in estrutura.data) && (estrutura.data.valorinicial != null)) {
            this.#inputDe.setAttribute("valor", estrutura.data.valorinicial);
            this.#inputDe.setAttribute("value", FormatarData(estrutura.data.formatacao.validacao, estrutura.data.valorinicial));
        }

        this.#inputDe.addEventListener("blur", () => {
            this.#validarData(this.#inputDe);
        });

        this.#inputAte = this.criarElementoHtml(div, "input");

        this.#inputAte.classList.add("form-control");
        
        this.#inputAte.setAttribute("maxlength", estrutura.data.formatacao.exibicao.length);
        this.#inputAte.setAttribute("placeholder", estrutura.data.exibicao);
        this.#inputAte.setAttribute("data-mask", estrutura.data.formatacao.sugestao);
        this.#inputAte.setAttribute("type", "text");

        this.#inputAte.style.flex = "initial";
        this.#inputAte.style.marginLeft = "2px";
        this.#inputAte.style.width = "35%";   

        if (("data" in estrutura) && ("valorfinal" in estrutura.data) && (estrutura.data.valorfinal != null)) {
            this.#inputAte.setAttribute("valor", estrutura.data.valorfinal);
            this.#inputAte.setAttribute("value", FormatarData(estrutura.data.formatacao.validacao, estrutura.data.valorfinal.toString()));
        }

        this.#inputAte.addEventListener("blur", () => {
            this.#validarData(this.#inputAte);
        });

        Maska.create(this.#inputDe);
        Maska.create(this.#inputAte);
    }

    #validarData(input) {
        input.classList.remove("data-invalida");
        input.setAttribute("valor", "");

        if (input.value != "") {
            let hoje = new Date();
            let data = {AAAA: hoje.getFullYear(), DD: hoje.getDate(), HH: "00", MM: ("0" + (hoje.getMonth() + 1)).slice(-2),  mm: "00", ss: "00"};
    
            Object.entries(data).forEach(([key, value]) => {
                const indice = this.#estrutura.data.formatacao.exibicao.indexOf(key);
    
                if ((indice >= 0) && (input.value.length >= (indice + key.length))) {
                    data[key] = input.value.substring(indice, indice + key.length);
                }; 	        
            });
    
            let valor = new Date(data["AAAA"] + "/" + data["MM"] + "/" + data["DD"] + " " + data["HH"] + ":" + data["mm"]  + ":" + data["ss"]);
    
            if ((valor == "Invalid Date") || (valor == "Data Invalida") || (input.value.length != this.#estrutura.data.formatacao.exibicao.length)) {           
                input.classList.toggle("data-invalida", true);        
            }
            else {
                input.setAttribute("valor", data["AAAA"] + "/" + data["MM"] + "/" + data["DD"] + " " + data["HH"] + ":" + data["mm"]  + ":" + data["ss"]);
            }
        }
    }
}
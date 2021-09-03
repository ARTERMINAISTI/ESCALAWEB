import Abstract from "./abstract.js";

export default class EditNumeric extends Abstract {
    #estrutura = null;
    
    #inputDe = null;
    #inputAte = null;

    get valor() {
        return {nome: this.#estrutura.nome, tipo: this.#estrutura.tipo, valorde: parseFloat(this.#inputDe.value), valorate: parseFloat(this.#inputAte.value)};
    }

    valorValido() {
        if ((this.#estrutura.ehobrigatorio) && (this.#inputDe.value == 0) && (this.#inputAte.value == 0)) {
            alert(`O filtro ${this.#estrutura.titulo.toLowerCase()} não foi preenchido.`);
            
            return false;
        }

        return true;
    }

    carregarEstrutura(estrutura) {
        let div = this.criarElementoHtml(this.elemento, "div");
        
        div.style.display = "flex";
        div.style.flexDirection = "row";     

        this.#inputDe = this.criarElementoHtml(div, "input");

        this.#inputDe.classList.add("form-control");
        
        this.#inputDe.setAttribute("type", "number");

        this.#inputDe.style.flex = "initial";
        this.#inputDe.style.marginRight = "2px";
        this.#inputDe.style.width = "35%";      

        if (("numerico" in estrutura) && ("valorinicial" in estrutura.numerico) && (estrutura.numerico.valorinicial != null)) {
            this.#inputDe.setAttribute("value", estrutura.numerico.valorinicial);
        }

        this.#inputDe.addEventListener("blur", args => {
            if (this.#inputDe.value == "") {
                this.#inputDe.value = 0;
            }
        });

        this.#inputAte = this.criarElementoHtml(div, "input");

        this.#inputAte.classList.add("form-control");
        
        this.#inputAte.setAttribute("type", "number");

        this.#inputAte.style.flex = "initial";
        this.#inputAte.style.marginLeft = "2px";
        this.#inputAte.style.width = "35%";   

        if (("numerico" in estrutura) && ("valorfinal" in estrutura.numerico) && (estrutura.numerico.valorinicial != null)) {
            this.#inputAte.setAttribute("value", estrutura.numerico.valorfinal);
        }

        this.#inputAte.addEventListener("blur", args => {
            if (this.#inputAte.value == "") {
                this.#inputAte.value = 0;
            }
        });
        
        this.#estrutura = estrutura;
    }
}

import Abstract from "./abstract.js";

export default class Edit extends Abstract {
    #estrutura = null;
    #input = null;

    get valor() {
        return {nome: this.#estrutura.nome, tipo: this.#estrutura.tipo, valor: this.#input.value};
    }

    valorValido() {
        if ((this.#estrutura.ehobrigatorio) && (this.#input.value == "")) {
            alert(`O filtro ${this.#estrutura.titulo.toLowerCase()} não foi preenchido.`);
            
            return false;
        }

        return true;
    }

    carregarEstrutura(estrutura) {
        this.#input = this.criarElementoHtml(this.elemento, "input");

        this.#input.classList.add("form-control");
        
        this.#input.style.width = "100%";
        this.#input.setAttribute("type", "text");

        if (("texto" in estrutura) && ("valor" in estrutura.texto) && (estrutura.texto.valor != null)) {
            this.#input.setAttribute("value", estrutura.texto.valor);
        }

        this.#estrutura = estrutura;
    }
}

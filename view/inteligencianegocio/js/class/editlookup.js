import Abstract from "./abstract.js";
import EditLookupSelecao from "./editlookupselecao.js";

export default class EditLookup extends Abstract {
    #botaoRemover = null;
    #estrutura = null;    
    #input = null;
    #selecao = null;

    get estrutura() {
        return this.#estrutura;
    }

    get valor() {
        return {nome: this.#estrutura.nome, tipo: this.#estrutura.tipo, valor: this.#input.getAttribute("valor")};
    }

    alterarSelecao(valorHandle, valordescricao) {
        this.#botaoRemover.style.display = "block";

        this.#input.setAttribute("valor", valorHandle);

        this.#input.value = valordescricao;
    }

    carregarEstrutura(estrutura) {
        this.#estrutura = estrutura;
        
        let div = this.criarElementoHtml(this.elemento, "div");
        
		div.classList.add("input-group");

        div.style.display = "flex";
        div.style.flexDirection = "row";

        let barraEdit = this.criarElementoHtml(div, "div");
        
        barraEdit.style.display = "flex";
        barraEdit.style.flexDirection = "row";        
        barraEdit.style.flex = "2";
        
        this.#input = this.criarElementoHtml(barraEdit, "input");
        
        this.#input.classList.add("form-control");

        this.#input.setAttribute("disabled", "true");
        this.#input.setAttribute("placeholder", "Buscar " + estrutura.titulo.toLowerCase());
        this.#input.setAttribute("type", "text");
        this.#input.setAttribute("valor", estrutura.tabela.valorhandle);

        this.#input.value = estrutura.tabela.valordescricao;

        let barraBotoes = this.criarElementoHtml(div, "div");
        
        barraBotoes.classList.add("input-group-btn");

        barraBotoes.style.display = "flex";
        barraBotoes.style.flexDirection = "row";
        barraBotoes.style.justifyContent = "flex-end";

        this.#botaoRemover = this.criarElementoHtml(barraBotoes, "button");

        this.#botaoRemover.classList.add("btn");
        this.#botaoRemover.classList.add("btn-default");

        this.#botaoRemover.setAttribute("type", "submit");

        this.#botaoRemover.style.display = estrutura.tabela.valorhandle != 0 ? "block" : "none";

        this.#botaoRemover.addEventListener("click", args => {
            this.#input.setAttribute("valor", "0");
            this.#input.value = "";
        
            this.#botaoRemover.style.display = "none";
        });
        
        let botaoRemoverImagem = this.criarElementoHtml(this.#botaoRemover, "i");

        botaoRemoverImagem.classList.add("glyphicon");
        botaoRemoverImagem.classList.add("glyphicon-remove");

        let botaoBuscar = this.criarElementoHtml(barraBotoes, "button");

        botaoBuscar.classList.add("btn");
        botaoBuscar.classList.add("btn-default");

        botaoBuscar.setAttribute("type", "submit");

        botaoBuscar.addEventListener("click", args => {
            this.#selecao.executar();
        });

        let botaoBuscarImagem = this.criarElementoHtml(botaoBuscar, "i");

        botaoBuscarImagem.classList.add("glyphicon");
        botaoBuscarImagem.classList.add("glyphicon-search");

        this.#selecao = new EditLookupSelecao();
        this.#selecao.parent = this;
        this.#selecao.carregarEstrutura();
    }

    valorValido() {
        if ((this.#estrutura.ehobrigatorio) && ((this.#input.getAttribute("valor") == 0) || (this.#input.getAttribute("valor") == ""))) {
            alert(`O filtro ${this.#estrutura.titulo.toLowerCase()} não foi preenchido.`);
            
            return false;
        }

        return true;
    }
}
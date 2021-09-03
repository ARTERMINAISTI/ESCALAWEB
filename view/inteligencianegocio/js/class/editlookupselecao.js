import Abstract from "./abstract.js";

export default class EditLookupSelecao extends Abstract {

    #barraTable = null;
    #formulario = null;
    #input = null;
    #parent = null;
    
    set parent(parent) {
        this.#parent = parent;
    }

    #atualizarValor(campoorderby, orderbyasc) {
        const request = new XMLHttpRequest();
								
        request.open("POST", "../../controller/inteligencianegocio/painelcontroller.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        request.onload = () => {
            if (request.status === 200) {
                this.#montarTabela(JSON.parse(request.response));

                return;
            }

            return;
        }

        request.send(JSON.stringify(
            {
                destino: "Filtro", 
                metodo: "getValorTabela", 
                parametro: {
                    sql: this.#parent.estrutura.tabela.sql,
                    condicao: this.#input.value,
                    campo: this.#parent.estrutura.tabela.campo,
                    campoorderby: campoorderby,
                    orderbyasc: orderbyasc
                }
            }
        ));

    }

    carregarEstrutura() {     
        this.#montarFormulario();
    }

    executar() {        
        this.#input.value = "";

        this.#atualizarValor("", true);
        this.#formulario.style.display = "block";
    }    
    
    #fecharFormulario () {
        this.#formulario.style.display = "none";        
    }

    #montarFormulario() {
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
        conteudo.style.width = window.screen.width <= 800 ? "100%": "900px";
        conteudo.style.height = "auto";
        conteudo.style.margin = "auto";
        conteudo.style.border = "1px solid #888";
        conteudo.style.fontFamily = "segoe UI";
        conteudo.style.fontSize = "12px";

        let header = this.criarElementoHtml(conteudo, "header");

        header.classList.add("modal-item");
        header.classList.add("componente-item-active");
        
        header.style.alignItems = "center";
        header.style.borderBottom = "1px solid #ddd";
        header.style.display = "flex";
        header.style.flexDirection = "row";
        header.style.width = "100%";
        header.style.height = "30px";
        header.textContent = "Selecionar " + this.#parent.estrutura.titulo.toLowerCase();

        let corpo = this.criarElementoHtml(conteudo, "div");

        let barraEdit = this.criarElementoHtml(corpo, "div");

        barraEdit.classList.add("modal-item");        
        
        barraEdit.style.display = "flex";
        barraEdit.style.flexDirection = "row";        
        barraEdit.style.flex = "2"
        barraEdit.style.width = "100%";
        
        this.#input = this.criarElementoHtml(barraEdit, "input");
        
        this.#input.classList.add("form-control");

        this.#input.setAttribute("placeholder", "Procurar " + this.#parent.estrutura.titulo.toLowerCase());
        this.#input.setAttribute("type", "text");

        let barraBotoes = this.criarElementoHtml(barraEdit, "div");

        barraBotoes.classList.add("input-group-btn");

        barraBotoes.style.display = "flex";
        barraBotoes.style.flexDirection = "row";
        barraBotoes.style.justifyContent = "flex-end";

        let botaoProcurar = this.criarElementoHtml(barraBotoes, "button");

        botaoProcurar.classList.add("btn");
        botaoProcurar.classList.add("btn-default");

        botaoProcurar.setAttribute("type", "submit");

        botaoProcurar.addEventListener("click", args => {
            this.#atualizarValor("", true);
        });        

        let botaoProcurarImagem = this.criarElementoHtml(botaoProcurar, "i");

        botaoProcurarImagem.classList.add("glyphicon");
        botaoProcurarImagem.classList.add("glyphicon-search");

        let linha = this.criarElementoHtml(corpo, "div");

        linha.classList.add("modal-item");

        this.#barraTable = this.criarElementoHtml(linha, "div");

        this.#barraTable.style.overflowX = "auto";
        this.#barraTable.style.height = "300px";
        this.#barraTable.style.width = "100%";
        this.#barraTable.style.border = "1px solid #ddd";

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
        button.textContent = "Fechar";

        button.addEventListener("click", args => {
            this.#fecharFormulario();
        });
    }

    #montarTabela(valor) {
        let div = document.createElement("div");

        let header = this.criarElementoHtml(div, "table");

        header.classList.add("table");
        header.classList.add("table-bordered");
        header.classList.add("table-head");

        let thead = this.criarElementoHtml(header, "thead");        
        let tr = this.criarElementoHtml(thead, "tr");        
        
        this.#parent.estrutura.tabela.campo.forEach(campo => {
            let th = this.criarElementoHtml(tr, "th");

            th.setAttribute("nome", campo.nome);

            th.style.fontSize = "13px";
            th.style.width = campo.tamanho + "%";
   
            th.textContent = campo.titulo;

            if (valor.campoorderby == campo.nome) {
                if (valor.orderbyasc) {
                    th.classList.add("th-asc");
                }
                else {
                    th.classList.add("th-desc");
                }
            }

            th.addEventListener("click", args => {
                this.#atualizarValor(th.getAttribute("nome"), !th.classList.contains("th-asc"));  
            });            
        });

        let body = this.criarElementoHtml(div, "table");

        body.classList.add("table");
        body.classList.add("table-body");
        body.classList.add("table-bordered");
        body.classList.add("table-hover");
        body.classList.add("table-striped");

        body.style.cursor = "pointer";

        let tbody = this.criarElementoHtml(body, "tbody");

        valor.registro.forEach(registro => {

            let tr = this.criarElementoHtml(tbody, "tr");

            tr.setAttribute("valordescricao", registro.traducao);
            tr.setAttribute("valorhandle", registro.handle);            

            tr.addEventListener("dblclick", args => {
                this.#selecionarRegistro(tr);
            });

            this.#parent.estrutura.tabela.campo.forEach(campo => {
                let td = this.criarElementoHtml(tr, "td");

                td.style.fontSize = "13px";
                td.style.width = campo.tamanho + "%";
    
                td.textContent = registro.valor[campo.nome];
            });   
        });

        while (this.#barraTable.firstChild) {
            this.#barraTable.removeChild(this.#barraTable.firstChild);
        }

        this.#barraTable.appendChild(div);
    }

    #selecionarRegistro(tr) {
        this.#parent.alterarSelecao(tr.getAttribute("valorhandle"), tr.getAttribute("valordescricao"));

        this.#fecharFormulario();
    }
}
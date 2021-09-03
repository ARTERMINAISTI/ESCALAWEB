export default class Abstract {
    #elemento = null;
    #identificador = null;

    get elemento() {
        return this.#elemento;
    }

    get identificador() {
        return this.#identificador;
    }

    set elemento(elemento) {
        this.#elemento = elemento;
    }

    set identificador(identificador) {
        this.#identificador = identificador;
    }

    ajustarAlturaCorpo(elementoReferencia, corpo, titulo, rodape, fixar) {               
        let alturaRodape = 0;
        let alturaTitulo = 0;

        if (titulo != null) {
            alturaTitulo = titulo.offsetHeight;
        }

        if (rodape != null) {
            alturaRodape = rodape.offsetHeight;
        }

        let alturaElemento = elementoReferencia.offsetHeight;
        
        if (elementoReferencia.style.borderTopWidth != "") {
            alturaElemento -= new Number(elementoReferencia.style.borderTopWidth.replace("px", ""));
        }

        if (elementoReferencia.style.borderBottomWidth != "") {
            alturaElemento -= new Number(elementoReferencia.style.borderBottomWidth.replace("px", ""));
        }

        if ((alturaElemento > (corpo.offsetHeight + alturaTitulo + alturaRodape)) || (fixar)) {
            corpo.style.height = alturaElemento - alturaTitulo - alturaRodape + "px";            
        }
    }

    atualizarErro(erros) {
        this.#elemento.textContent = this.#extrairMensagemErro(erros);
        this.#elemento.style.color = "red";        
        this.#elemento.style.fontSize = "10px"; 
        this.#elemento.style.paddingLeft = "15px";
        this.#elemento.style.paddingTop = "15px";
    }

    atualizarTitulo(titulo) {

    }

    atualizarValor(valor) {
    }

    #extrairMensagemErro(erros) {
        if ('errors' in erros) {
            return erros.errors.detail;
        }

        return "Não foi possível exibir a informação! Tente mais tarde!";
    }

    criarElementoHtml(elemento, tipo) {
        let div = document.createElement(tipo);
        
        elemento.appendChild(div);

        return div;
    }
}

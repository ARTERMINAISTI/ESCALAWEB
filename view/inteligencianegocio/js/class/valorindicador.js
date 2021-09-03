import Constantes from "../helper/constantes.js";
import FormatarData from "../helper/formatardata.js";
import FormatarNumero from "../helper/formatarnumero.js"
import Valor from "./valor.js";

export default class ValorIndicador extends Valor {

    montarItemValor(elemento, item) {
        if (item.valor == null) {
            return;
        }
        
        let div = this.criarElementoHtml(elemento, "div");
        
        div.style.alignItems = "center";
        div.style.display = "flex";

        if ("imagem" in item) {
            let imagem = this.criarElementoHtml(div, "span");

            imagem.style.alignItems = "center";
            imagem.style.display = "flex";
            imagem.style.fontSize = "10px";
            imagem.style.justifyContent = "flex-start";
            imagem.style.margin = "2px";

            imagem.classList.add("glyphicon");

            switch (item.imagem) {
                case Constantes.ComponenteMarcadorImagemParaBaixo:
                    imagem.classList.add("glyphicon-chevron-down");

                    break;
            
                case Constantes.ComponenteMarcadorImagemParaCima:
                    imagem.classList.add("glyphicon-chevron-up");

                    break;
            }
        }

        let valor = this.criarElementoHtml(div, "div");

        valor.style.alignItems = "center";
        valor.style.display = "flex";
        valor.style.flex = "2";
        valor.style.fontSize = item.valor.tamanhofonte + "px";
        valor.style.margin = "2px";
        
        switch (item.valor.alinhamento) {
            case Constantes.AlinhamentoTextoCentro:
                valor.style.justifyContent = "center";
                break;

            case Constantes.AlinhamentoTextoDireita:
                valor.style.justifyContent = "flex-end";
                break;
        
            default:
                break;
        }

        if (("formatacao" in item.valor) && ("tipo" in item.valor) && (item.valor.formatacao != null)) {
            switch (item.valor.tipo) {
                case Constantes.ComponenteTipoCampoInteiro:
                case  Constantes.ComponenteTipoCampoNumerico:
                    valor.textContent = FormatarNumero(item.valor.formatacao, item.valor.valor);

                    break;

                case  Constantes.ComponenteTipoCampoData:
                    valor.textContent = FormatarData(item.valor.formatacao, item.valor.valor);

                    break;
            }
        }
        else {
            valor.textContent = item.valor.valor;
        }

        return div;
    }
}
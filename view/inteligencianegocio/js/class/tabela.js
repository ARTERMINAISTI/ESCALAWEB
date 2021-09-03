import Abstract from "./abstract.js";
import Constantes from "../helper/constantes.js";
import FormatarData from "../helper/formatardata.js";
import FormatarNumero from "../helper/formatarnumero.js";

export default class Tabela extends Abstract {

    atualizarTitulo(titulo) {
       
        let div = this.criarElementoHtml(this.elemento, "div");

        div.style.display = "flex";
        div.style.justifyContent = "flex-end";
        div.style.alignItems = "center";
        div.style.flexDirection = "row";        

        let exportarXlsx = this.criarElementoHtml(div, "button");
        
        exportarXlsx.style.display = "flex";
        exportarXlsx.style.fontSize = titulo.tamanhofonte + "px";
        exportarXlsx.style.height = (titulo.tamanhofonte + 5) + "px";
        exportarXlsx.style.alignItems = "center";
        exportarXlsx.textContent = "exportar xlsx";

        exportarXlsx.addEventListener("click", args => {
            this.#exportarXlsx(exportarXlsx);
        });
        
        let exportarCsv = this.criarElementoHtml(div, "button");
        
        exportarCsv.style.display = "flex";
        exportarCsv.style.fontSize = titulo.tamanhofonte + "px";
        exportarCsv.style.height = (titulo.tamanhofonte + 5) + "px";
        exportarCsv.style.alignItems = "center";
        exportarCsv.textContent = "exportar csv";

        exportarCsv.addEventListener("click", args => {
            this.#exportarCsv(exportarCsv);
        });
    }

    atualizarValor(valor) {
        this.elemento.classList.add("table-responsive");

        if ("titulo" in valor) {
            var titulo = this.#montarValorTitulo(valor);
        }

        if ("corpo" in valor) {
            var corpo = this.#montarValorCorpo(valor);
        }

        if ("titulo" in valor) {
            var rodape = this.#montarValorRodape(valor);
        }

        this.ajustarAlturaCorpo(this.elemento, corpo, titulo, rodape, false);
    }

    #converterRgbParaKml(rgb) {
        let sep = rgb.indexOf(",") > -1 ? "," : " ";

        rgb = rgb.substr(4).split(")")[0].split(sep);

        if (rgb.length < 3) {
            return null;
        }

        let r = (+rgb[0]).toString(16);
        let g = (+rgb[1]).toString(16);
        let b = (+rgb[2]).toString(16);
      
        if (r.length == 1) {
            r = "0" + r;
        }
        
        if (g.length == 1) {
            g = "0" + g;
        }

        if (b.length == 1) {
            b = "0" + b;
        }
      
        return r + g + b; 
    }

    #criarElementoExportacao() {
        var tableExportacao = null;

        var tableTitulo = document.getElementById(this.identificador + "_table_titulo");
        var tableCorpo = document.getElementById(this.identificador + "_table_corpo");
        var tableRodape = document.getElementById(this.identificador + "_table_rodape");
    
        if (tableTitulo != null) {
            tableExportacao = tableTitulo.cloneNode(true);
        }
        else if (tableCorpo != null) {
            tableExportacao = tableCorpo.cloneNode(true);
        }
    
        if (tableExportacao != null) {
            
            if ((tableCorpo != null) && (tableTitulo != null)) {
                var tableBodyCorpo = tableCorpo.cloneNode(true).tBodies;
    
                if ((tableBodyCorpo != null) && (tableBodyCorpo.length > 0)) {
                    tableExportacao.append(tableBodyCorpo[0]);
                }            
            }
    
            if (tableRodape != null) {
                var tableHeadRodape = tableRodape.cloneNode(true).tHead;
    
                if (tableHeadRodape != null) {
                    tableExportacao.append(tableHeadRodape);
                }
            }
        }
    
        return tableExportacao;
    }

    #exportarCsv() {
        var tabelaExportacao = this.#criarElementoExportacao();

        var csv = "";
        
        if (tabelaExportacao != null) {
            var linhas = tabelaExportacao.rows;

            for (let linha of linhas) {    
                var valor = "";
                var colunas = linha.children;
                
                for (let coluna of colunas) {
                    if (valor != "") {
                        valor += ";";
                    }
                    
                    valor += coluna.textContent;
                }
               
                csv += valor + "\r\n";
            }
        }
    
        var csvFile = new Blob([csv], {type: "text/csv"});
        
        var downloadLink = document.createElement("a");
    
        downloadLink.download = "Exportação de painel.csv";
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        
        document.body.appendChild(downloadLink);
    
        downloadLink.click();
        downloadLink.remove();
    }

    #exportarXlsx() {
        var tabelaExportacao = this.#criarElementoExportacao();

        if (tabelaExportacao != null) {
            var tamanhoColuna = "";

            if ((tabelaExportacao.rows != null) && ( tabelaExportacao.rows.length > 0)) {
                let colunas = tabelaExportacao.rows[0].children;

                for (let coluna of colunas) {
                    if (tamanhoColuna != "") {
                        tamanhoColuna += ",";
                    }

                    tamanhoColuna += (parseInt(coluna.style.width.replace("%", "")) + 5);
                }
            }
        }

        tabelaExportacao.setAttribute("data-cols-width", tamanhoColuna);
        
        TableToExcel.convert(tabelaExportacao, {
            name: "Exportação de painel.xlsx",
            sheet: {
                name: "Exportação"
            }
        });
    }

    #montarValorCorpo(valor) {
        if (valor.corpo === null) {
            return;
        }
        
        let div = this.criarElementoHtml(this.elemento, "div");
        
        let table = this.criarElementoHtml(div, "table");

        table.id = this.identificador + "_table_corpo";

        table.classList.add("table");
        table.classList.add("table-body");
        table.classList.add("table-hover");

        if ((valor.ehexibirdivisorcoluna) && (valor.ehexibirdivisorlinha)) {
            table.classList.add("table-bordered");
        }
        else if (valor.ehexibirdivisorcoluna) {
            table.classList.add("table-bordered-column");
        }
        else if (valor.ehexibirdivisorlinha) {
            table.classList.add("table-bordered-row");
        }
        
        if (valor.corpo.ehzebrado) {
            table.classList.add("table-striped");
        }
        
        let body = this.criarElementoHtml(table, "tbody");

        valor.corpo.valor.forEach(linha => {
            let tr = this.criarElementoHtml(body, "tr");
            
            linha.forEach(coluna => {
                let td = this.criarElementoHtml(tr, "td");

                td.setAttribute("handle", coluna.handle);

                td.style.fontSize = coluna.tamanhofonte + "px";
                td.style.width = coluna.tamanho + "%";

                switch (coluna.alinhamento) {
                    case Constantes.AlinhamentoTextoCentro:
                        td.style.textAlign = "center";
                        td.setAttribute("data-a-h", "center");
                        break;

                    case Constantes.AlinhamentoTextoDireita:
                        td.style.textAlign = "right";
                        td.setAttribute("data-a-h", "right");
                        break;
    
                    default:
                        break;
                }

                if (("corfonte" in coluna) && (coluna.corfonte != null)) {
                    td.style.color = coluna.corfonte;
                    td.setAttribute("data-f-color", this.#converterRgbParaKml(coluna.corfonte));
                }

                if (("corfundo" in coluna) && (coluna.corfundo != null)) {
                    td.style.background = coluna.corfundo;
                    td.setAttribute("data-fill-color", this.#converterRgbParaKml(coluna.corfundo));
                }

                if (("formatacao" in coluna) && (coluna.formatacao != null)) {
                    switch (coluna.tipo) {
                        case  Constantes.ComponenteTipoCampoData:
                            if (coluna.valor != null) {
                                td.textContent = FormatarData(coluna.formatacao, coluna.valor);
                                td.setAttribute("value", coluna.valor); 
                            }                                                       

                            break;                        
                        
                        case Constantes.ComponenteTipoCampoInteiro:                            
                            if (coluna.valor != null) {
                                td.textContent = coluna.valor;
                                td.setAttribute("value", coluna.valor);
                            }
                            
                            break;

                        case  Constantes.ComponenteTipoCampoNumerico:
                            if (coluna.valor != null) {
                                td.textContent = FormatarNumero(coluna.formatacao, coluna.valor);
                            }                              
                            
                            td.setAttribute("value", coluna.valor);

                            break;
                    }
                }
                else {
                    td.textContent = coluna.valor;
                }
            });
        });

        return div;
    }

    #montarValorRodape(valor) {
        if (valor.rodape === null) {
            return;
        }

        let table = this.criarElementoHtml(this.elemento, "table");

        table.id = this.identificador + "_table_rodape";

        table.classList.add("table");
        table.classList.add("table-foot");

        if ((valor.ehexibirdivisorcoluna) && (valor.ehexibirdivisorlinha)) {
            table.classList.add("table-bordered");
        }
        else if (valor.ehexibirdivisorcoluna) {
            table.classList.add("table-bordered-column");
        }
        else if (valor.ehexibirdivisorlinha) {
            table.classList.add("table-bordered-row");
        }

        let head = this.criarElementoHtml(table, "thead");
        let tr = this.criarElementoHtml(head, "tr");

        if ((valor.rodape.valor.length > 0) && ("valor" in valor.rodape.valor[0]) && (valor.rodape.valor[0].valor === "Total")) {
            if ((valor.rodape.valor.length > 1) && (((!("valor" in valor.rodape.valor[1])) || (valor.rodape.valor[1].valor === null)))) {
                valor.rodape.valor[0].tamanho += valor.rodape.valor[1].tamanho;
                valor.rodape.valor[0].colspan = 1;

                valor.rodape.valor[1].tamanho = 0;
            }
        }        

        valor.rodape.valor.forEach(valor => {
            let th = this.criarElementoHtml(tr, "th");

            th.setAttribute("handle", valor.handle);

            th.style.fontSize = valor.tamanhofonte + "px";
            th.style.width = valor.tamanho + "%";
    
            if (("valor" in valor) && (valor.valor != null)) {
                if (valor.valor === "Total") {
                    th.textContent = valor.valor;

                    if ("colspan" in valor) {
                        th.setAttribute("colspan", valor.colspan);
                    }
                }
                else {
                    th.style.textAlign = "right";
                    th.setAttribute("data-a-h", "right");
                    th.textContent = FormatarNumero(valor.formatacao, valor.valor); 
                }
            }
        });

        return table;
    }

    #montarValorTitulo(valor) {
        if (valor.titulo === null) {
            return;
        }
        
        let table = this.criarElementoHtml(this.elemento, "table");

        table.id = this.identificador + "_table_titulo";
        
        table.classList.add("table");
        table.classList.add("table-head");

        if ((valor.ehexibirdivisorcoluna) && (valor.ehexibirdivisorlinha)) {
            table.classList.add("table-bordered");
        }
        else if (valor.ehexibirdivisorcoluna) {
            table.classList.add("table-bordered-column");
        }
        else if (valor.ehexibirdivisorlinha) {
            table.classList.add("table-bordered-row");
        }        

        if (valor.titulo.ehdestacar) {
            table.classList.add("componente-item-active");
        } 

        let head = this.criarElementoHtml(table, "thead");
        let tr = this.criarElementoHtml(head, "tr");

        valor.titulo.valor.forEach(valor => {
            let th = this.criarElementoHtml(tr, "th");

            th.style.fontSize = valor.tamanhofonte + "px";
            th.style.width = valor.tamanho + "%";

            th.setAttribute("data-f-bold", "true");
            th.setAttribute("handle", valor.handle);
    
            switch (valor.alinhamento) {
                case Constantes.AlinhamentoTextoCentro:
                    th.style.textAlign = "center";
                    th.setAttribute("data-a-h", "center");

                    break;

                default:
                    break;
            }

            switch (valor.tipo) {
                case Constantes.ComponenteTipoCampoData:
                    th.classList.add("th-date");

                    break;
                
                case Constantes.ComponenteTipoCampoInteiro:
                case Constantes.ComponenteTipoCampoNumerico:
                    th.classList.add("th-number");

                    break;
            }           

            th.textContent = valor.valor;

            th.addEventListener("click", args => {
                this.#ordenarRegistro(th);
            });
        });
        
        return table;      
    }

    #ordenarRegistro(th) {
        let tabelaOrigem = th.parentElement.parentElement.parentElement;
        let tabelaDestino = document.getElementById(this.identificador + "_table_corpo");
    
        if ((tabelaDestino != null) && (tabelaDestino.tBodies.length == 1)) {
            let tipoData = th.classList.contains("th-date");
            let tipoNumerico = th.classList.contains("th-number");
            let thIndice = th.cellIndex + 1;
    
            let tabelaDestinoBody = tabelaDestino.tBodies[0];
            let tabelaDestinoTr = Array.from(tabelaDestinoBody.querySelectorAll("tr"));
    
            const ordenacaoCrescente = !th.classList.contains("th-asc");
            const ordenacaoCrescenteFator = ordenacaoCrescente ? 1 : -1;
    
            const linhaOrdenada = tabelaDestinoTr.sort((linha1, linha2) => {
                if (tipoData) {
                    const linha1Data = new Date(linha1.querySelector(`td:nth-child(${ thIndice })`).getAttribute('value'));
                    const linha2Data = new Date(linha2.querySelector(`td:nth-child(${ thIndice })`).getAttribute('value'));
    
                    return linha1Data > linha2Data ? (1 * ordenacaoCrescenteFator) : (-1 * ordenacaoCrescenteFator);
                }
                else {
                    const linha1Valor = linha1.querySelector(`td:nth-child(${ thIndice})`).textContent.trim();
                    const linha2Valor = linha2.querySelector(`td:nth-child(${ thIndice})`).textContent.trim();
    
                    if (tipoNumerico) {
                        const linha1Numero = new Number(linha1Valor.replaceAll('.', '').replaceAll(',','.'));
                        const linha2Numero = new Number(linha2Valor.replaceAll('.', '').replaceAll(',','.'));
    
                        return linha1Numero > linha2Numero ? (1 * ordenacaoCrescenteFator) : (-1 * ordenacaoCrescenteFator);
                    }
                    else {
                        return linha1Valor > linha2Valor ? (1 * ordenacaoCrescenteFator) : (-1 * ordenacaoCrescenteFator);											
                    }
                }
            });

             while (tabelaDestinoBody.firstChild) {
                tabelaDestinoBody.removeChild(tabelaDestinoBody.firstChild);
            }
    
            tabelaDestinoBody.append(...linhaOrdenada);																	
    
            tabelaOrigem.querySelectorAll("th").forEach(th => th.classList.remove("th-asc", "th-desc"));
            
            th.classList.toggle("th-asc", ordenacaoCrescente);
            th.classList.toggle("th-desc", !ordenacaoCrescente);
        }              
    }  
}
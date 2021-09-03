function montarTabelaExportar(elementoBotao, tipoExportacao) {
    var tabelaCabecalho = document.getElementById(elementoBotao.id.replace('_botao_exportar_' + tipoExportacao, '_tabela_cabecalho'));
    var tabelaCorpo = document.getElementById(elementoBotao.id.replace('_botao_exportar_' + tipoExportacao, '_tabela_corpo'));
    var tabelaRodape = document.getElementById(elementoBotao.id.replace('_botao_exportar_xlsx' + tipoExportacao, '_tabela_rodape'));

    var tabelaExportar = null;

    if (tabelaCabecalho != null) {
        tabelaExportar = tabelaCabecalho.cloneNode(true);
    }
    else if (tabelaCorpo != null) {
        tabelaExportar = tabelaCorpo.cloneNode(true);
    }

    if (tabelaExportar != null) {
        
        if ((tabelaCorpo != null) && (tabelaCabecalho != null)) {
            var tabelaCorpoBody = tabelaCorpo.cloneNode(true).tBodies;

            if ((tabelaCorpoBody != null) && (tabelaCorpoBody.length > 0)) {
                tabelaExportar.append(tabelaCorpoBody[0]);
            }            
        }

        if (tabelaRodape != null) {
            var tabelaRodapeHead = tabelaRodape.cloneNode(true).tHead;

            if (tabelaRodapeHead != null) {
                tabelaExportar.append(tabelaRodapeHead);
            }
        }
    }

    return tabelaExportar;
}

function exportarComponenteTabelaCsv(elementoBotao) {
    var tabelaExportar = montarTabelaExportar(elementoBotao, 'csv');

    var csv = '';
    
    if (tabelaExportar != null) {
        var rows = tabelaExportar.rows;

        for (var i = 0; i < rows.length; i++) {
            var row = '';
            var cols = rows[i].querySelectorAll('td, th');
            
            for (var j = 0; j < cols.length; j++) {
                if (row != '') {
                    row += ';';
                }
                
                row += cols[j].innerText;
            }
           
            csv += row + '\r\n';
        }
    }

    var csvFile = new Blob([csv], {type: 'text/csv'});
    
    var downloadLink = document.createElement("a");

    downloadLink.download = 'Exportação de painel.csv';
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    
    document.body.appendChild(downloadLink);

    downloadLink.click();
    downloadLink.remove();
}

function exportarComponenteTabelaXlsx(elementoBotao) {
    var tabelaExportar = montarTabelaExportar(elementoBotao, 'xlsx');
    
    TableToExcel.convert(tabelaExportar, {
        name: 'Exportação de painel.xlsx',
        sheet: {
            name: 'Exportação'
        }
    });
}

function atualizarComponente(json) {
    if (Array.isArray(json)) {
        json.forEach(jsonItem => {
            atualizarComponente(jsonItem);
        });											
    }
    else if (json != null) {
        const elementoDestino = document.getElementById(json.elementoDestino);

        if (elementoDestino != null) {
            switch (json.tipo) {
                case 'calendario':
                    atualizarComponenteCalendario(elementoDestino, json);

                    break;                
                case 'grafico':
                    
                    atualizarComponenteGrafico(elementoDestino, json);

                    break;

                case 'medidor':
                    
                    atualizarComponenteMedidor(elementoDestino, json);
    
                    break;

                case 'texto':
                    elementoDestino.innerHTML = json.valor;

                    break;
            }
        }
    }
};

function atualizarComponenteCalendario(elementoCalendario, json) {   
    var calendario = new FullCalendar.Calendar(elementoCalendario, {

        plugins: [ 'dayGrid'],

        header: {
            left: null,
            center: 'title',
            right: 'today,prev,next'
        }, 

        views: {
            dayGridMonth: {
                titleFormat: {  year: 'numeric', month: 'short' }
            }
        }, 
        defaultView: 'dayGridMonth',
        editable: false,
        eventLimit: false,
        contentHeight: json.altura,
        locale: 'pt-br',
        weekNumbers: false,
        weekNumbersWithinDays: false
    });

    calendario.render();
}

function atualizarComponenteGrafico(elementoGrafico, json) {
    var chart = null;
    var eixoX = null;
    var eixoY = null;

    var tipoBarra = (['4', '5'].includes(json.tipografico));
    var tipoPizza = json.tipografico == '6';

    if (tipoPizza) {
        chart = am4core.create(elementoGrafico, am4charts.PieChart);
        chart.padding(5,5,5,5);
    }
    else {
        chart = am4core.create(elementoGrafico, am4charts.XYChart);
    }

    chart.data = json.valor;
    chart.fontSize = '10px';

    if (json.exibirlegenda == 'S') {
        chart.legend = new am4charts.Legend();
        chart.legend.labels.template.maxWidth = 95;
        chart.legend.position = 'right';
        chart.legend.fontSize = '10px';
        chart.legend.top = 0;
    }
    
    if (tipoBarra) {
        eixoY = chart.yAxes.push(new am4charts.CategoryAxis());
        eixoY.dataFields.category = 'EIXOX';
        eixoY.renderer.cellStartLocation = 0.1
        eixoY.renderer.cellEndLocation = 0.9
        eixoY.renderer.grid.template.location = 0;								
        eixoY.renderer.inversed = true;

        eixoX = chart.xAxes.push(new am4charts.ValueAxis());
        eixoX.renderer.opposite = true;
        eixoX.min = 0;
        eixoX.max = json.eixoymaiornumero * 1.2;								
    } 
    else if (!tipoPizza) {
        eixoX = chart.xAxes.push(new am4charts.CategoryAxis());
        eixoX.dataFields.category = 'EIXOX';
        eixoX.renderer.cellStartLocation = 0.1
        eixoX.renderer.cellEndLocation = 0.9
        eixoX.renderer.grid.template.location = 0;
        eixoX.renderer.minGridDistance = 20;

        eixoY = chart.yAxes.push(new am4charts.ValueAxis());
        eixoY.min = 0;
        eixoY.max = json.eixoymaiornumero * 1.2;
    }

    json.cor.forEach(corItem => {	
		chart.colors.list.push(am4core.color('rgb(' + corItem.nome + ')'));        
    });
	
    json.serie.forEach(function (serieItem, indice) {
        var chartSerie = null;

        if (tipoPizza) { 
            chartSerie = chart.series.push(new am4charts.PieSeries());
            chartSerie.alignLabels = false;

            chartSerie.dataFields.value = serieItem.nome;
            chartSerie.dataFields.category = 'EIXOX';
                        								
            chartSerie.labels.template.fontSize = '8px';
            chartSerie.labels.template.fill = am4core.color("white");
            chartSerie.labels.template.radius = am4core.percent(-40);		
            chartSerie.labels.template.text = "{value.percent.formatNumber('#.0')}%";
            
            chartSerie.slices.template.stroke = am4core.color("#fff");
            chartSerie.slices.template.strokeOpacity = 1;

            chartSerie.ticks.template.disabled = true;    
                    
            chartSerie.labels.template.adapter.add("radius", function(radius, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent < 11)) {
                    return 0;
                }
                if ((target.dataItem) && (target.dataItem.values.value.percent <= 14)) {
                    return -45;
                }
                
                return radius;
            });

            chartSerie.labels.template.adapter.add("relativeRotation", function(relativeRotation, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent >= 11) && (target.dataItem.values.value.percent <= 14)) {
                    return 90;
                }

                return relativeRotation;
            });

            chartSerie.labels.template.adapter.add("text", function(text, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent < 5)) {
                    return '';
                }
                return text;
            });

            chartSerie.labels.template.adapter.add("fill", function(color, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent < 11)) {
                    return am4core.color("#000");
                }

				return color;
            });

            chartSerie.slices.template.adapter.add("fill", function(color, target) {
                if ((json.serie.length == 1) && (json.cor.length > target.dataItem.index)) {
					return chart.colors.getIndex(target.dataItem.index);
				}
				return fill;
            });
        }
        else {
			switch (json.tipografico) {
                case '1':
                case '2':
                case '4':
                case '5':
                    chartSerie = chart.series.push(new am4charts.ColumnSeries());
					
					chartSerie.columns.template.adapter.add("fill", function(fill, target) {
						if ((json.serie.length == 1) && (json.cor.length > target.dataItem.index) && (target.dataItem.index > -1)) {
							return chart.colors.getIndex(target.dataItem.index);
						}
						return fill;
					});  						

                    break;
                
                case '3':
				
                    chartSerie = chart.series.push(new am4charts.LineSeries());
					
					chartSerie.adapter.add("fill", function(fill, target) {
					
						if ((json.serie.length == 1) && (json.cor.length > target.dataItem.index) && (target.dataItem.index > -1)) {
							return chart.colors.getIndex(target.dataItem.index);
						}
						return fill;
					});  
					
                    break;
                
                case '7':
                case '8':
                    chartSerie = chart.series.push(new am4charts.LineSeries());
					
					chartSerie.adapter.add("fill", function(fill, target) {
					
						if ((json.serie.length == 1) && (json.cor.length > target.dataItem.index) && (target.dataItem.index > -1)) {
							return chart.colors.getIndex(target.dataItem.index);
						}
						return fill;
					})					

                    break;
            }

            chartSerie.name = serieItem.legenda;		

            if (tipoBarra) {
                chartSerie.dataFields.categoryY = 'EIXOX';
                chartSerie.dataFields.valueX = serieItem.nome;
            } else {
                chartSerie.dataFields.valueY = serieItem.nome;
                chartSerie.dataFields.categoryX = 'EIXOX';
            }

            if (json.exibirvalorserie == 'S') {
                var chartSerieValor = chartSerie.bullets.push(new am4charts.LabelBullet());
                chartSerieValor.label.fontSize = '8px';
                chartSerieValor.label.truncate = false;

                var formatacao = '';

                if (serieItem.formatacao > 0) {
                    formatacao = '#.###,' + '0'.repeat(serieItem.formatacao);
                }

                if (tipoBarra) {
                    chartSerieValor.label.text = '{valueX.formatNumber("' + formatacao + '")}';
                    chartSerieValor.dx = 25;
                } else {
                    chartSerieValor.dy = -10;
                    chartSerieValor.label.text = '{valueY.formatNumber("' + formatacao + '")}';
                }
            }
        }							
    });								
};

function atualizarComponenteMedidor(elementoMedidor, json) {
    var chart = am4core.create(elementoMedidor, am4charts.GaugeChart);

    chart.hiddenState.properties.opacity = 0;
    chart.fontSize = 11;
    chart.innerRadius = am4core.percent(80);
    chart.resizable = true;    

    if (json.exibirescala == 'S') {
        var eixoEscala = chart.xAxes.push(new am4charts.ValueAxis());
        eixoEscala.min = json.numeroinicial;
        eixoEscala.max = json.numerofinal;
        eixoEscala.strictMinMax = true;
        eixoEscala.renderer.radius = am4core.percent(80);
        eixoEscala.renderer.inside = true;
        eixoEscala.renderer.line.strokeOpacity = 0.1;
        eixoEscala.renderer.ticks.template.disabled = false;
        eixoEscala.renderer.ticks.template.strokeOpacity = 1;
        eixoEscala.renderer.ticks.template.strokeWidth = 0.5;
        eixoEscala.renderer.ticks.template.length = 5;
        eixoEscala.renderer.grid.template.disabled = true;
        eixoEscala.renderer.labels.template.radius = am4core.percent(23);
        eixoEscala.renderer.labels.template.fontSize = "8px";
    }	
    
    var eixoGrupo = chart.xAxes.push(new am4charts.ValueAxis());    
    eixoGrupo.min = json.numeroinicial;
    eixoGrupo.max = json.numerofinal;
    eixoGrupo.strictMinMax = true;
    eixoGrupo.renderer.labels.template.disabled = true;
    eixoGrupo.renderer.ticks.template.disabled = true;
    eixoGrupo.renderer.grid.template.disabled = false;
    eixoGrupo.renderer.grid.template.opacity = 0.5;
    eixoGrupo.renderer.labels.template.bent = true;
    eixoGrupo.renderer.labels.template.fill = am4core.color("#000");
    eixoGrupo.renderer.labels.template.fontWeight = "bold";
    eixoGrupo.renderer.labels.template.fillOpacity = 0.3;    

    json.grupo.forEach(grupoItem => {
        var grupo = eixoGrupo.axisRanges.create();
        grupo.axisFill.fill = am4core.color('rgb(' + grupoItem.cor + ')');
        grupo.axisFill.fillOpacity = 0.8;
        grupo.axisFill.zIndex = -1;
        grupo.value = grupoItem.inicio;
        grupo.endValue = grupoItem.termino;
        grupo.grid.strokeOpacity = 0;
        grupo.stroke = am4core.color('rgb(' + grupoItem.cor + ')').lighten(-0.1);
        grupo.label.inside = true;
        grupo.label.text = grupoItem.titulo;
        grupo.label.inside = true;
        grupo.label.location = 0.5;
        grupo.label.inside = true;
        grupo.label.radius = am4core.percent(10);
        grupo.label.paddingBottom = -5;
        grupo.label.fontSize = "0.9em";
    });

    var label = chart.radarContainer.createChild(am4core.Label);
    label.isMeasured = false;
    label.fontSize = "10px";
    label.x = am4core.percent(50);
    label.paddingBottom = 0;
    label.horizontalCenter = "middle";
    label.verticalCenter = "bottom";
    label.text = json.valoratual;    
    
    var hand = chart.hands.push(new am4charts.ClockHand());
    hand.axis = eixoGrupo;
    hand.innerRadius = am4core.percent(55);
    hand.startWidth = 2;
    hand.pin.disabled = true;
    hand.value = json.posicaoatual;
    hand.fill = am4core.color("#444");
    hand.stroke = am4core.color("#000");
}

function atualizarPainel () {
    const elementoPainelParametro = document.getElementById("painel_parametro");
    const filtroPainel = gerarJsonModalFiltro();

    $('#loader').show();

    efetuarRequest('PAINELPARAMETRO=' + elementoPainelParametro.getAttribute('value') + '&ACAO=ATUALIZARPAINEL&ALTURA=' + document.body.clientHeight + '&LARGURA=' + document.body.clientWidth + '&FILTRO=' + filtroPainel, function (response) {
        atualizarComponente(JSON.parse(response));

        $('#loader').hide();
    });
}

function carregarPainel () {
    var paramURL = $.parseJSON(window.atob(document.location.search.replace('?identificador=', '')));

    const elementoPainelConteudo = document.getElementById("painel_conteudo");
    const elementoPainelIdentificacao = document.getElementById("painel_identificacao");

    elementoPainelIdentificacao.innerText = paramURL.nome;

    $('#loader').hide();
    
    efetuarRequest('PAINEL=' + paramURL.handle + '&ACAO=CARREGARPAINEL&LARGURA=' + document.body.clientWidth, function (response) {
        elementoPainelConteudo.innerHTML = response;

        ajustarMascaraCampoModalFiltro();
        
        atualizarPainel();        
    });
}

function efetuarRequest(parametro, callback) {
    const request = new XMLHttpRequest();
								
    request.open('POST', '../../controller/painelindicador/painelindicador.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    request.onload = () => {
        callback(request.response);						
    }
    
    request.send(parametro);
}

function ordernarTabela (elemento) {
    const elementoTabelaOrigem = elemento.parentElement.parentElement.parentElement;
    const elementoTabelaDestino = document.getElementById(elementoTabelaOrigem.id.replaceAll('cabecalho', 'corpo'));

    if ((elementoTabelaDestino != null) && (elementoTabelaDestino.tBodies.length == 1)) {										
        const elementoTabelaDestinoColunaData = elemento.classList.contains("th-date");
        const elementoTabelaDestinoColunaNumerica = elemento.classList.contains("th-number");
        const elementoTabelaDestinoColunaIndice = elemento.cellIndex + 1;									

        const elementoTabelaDestinoCorpo = elementoTabelaDestino.tBodies[0];
        const elementoTabelaDestinoLinha = Array.from(elementoTabelaDestinoCorpo.querySelectorAll("tr"));

        const ordenacaoCrescente = !elemento.classList.contains("th-asc");
        const ordenacaoCrescenteFator = ordenacaoCrescente ? 1 : -1;

        const linhaOrdenada = elementoTabelaDestinoLinha.sort((linha1, linha2) => {
            if (elementoTabelaDestinoColunaData) {
                const linha1Data = new Date(linha1.querySelector(`td:nth-child(${ elementoTabelaDestinoColunaIndice })`).getAttribute('value'));
                const linha2Data = new Date(linha2.querySelector(`td:nth-child(${ elementoTabelaDestinoColunaIndice })`).getAttribute('value'));

                return linha1Data > linha2Data ? (1 * ordenacaoCrescenteFator) : (-1 * ordenacaoCrescenteFator);
            }
            else {
                const linha1Valor = linha1.querySelector(`td:nth-child(${ elementoTabelaDestinoColunaIndice})`).textContent.trim();
                const linha2Valor = linha2.querySelector(`td:nth-child(${ elementoTabelaDestinoColunaIndice})`).textContent.trim();

                if (elementoTabelaDestinoColunaNumerica) {
                    const linha1Numero = new Number(linha1Valor.replaceAll('.', '').replaceAll(',','.'));
                    const linha2Numero = new Number(linha2Valor.replaceAll('.', '').replaceAll(',','.'));

                    return linha1Numero > linha2Numero ? (1 * ordenacaoCrescenteFator) : (-1 * ordenacaoCrescenteFator);
                }
                else {
                    return linha1Valor > linha2Valor ? (1 * ordenacaoCrescenteFator) : (-1 * ordenacaoCrescenteFator);											
                }
            }
        });

        while (elementoTabelaDestinoCorpo.firstChild) {
            elementoTabelaDestinoCorpo.removeChild(elementoTabelaDestinoCorpo.firstChild);
        }

        elementoTabelaDestinoCorpo.append(...linhaOrdenada);																	

        elementoTabelaOrigem.querySelectorAll("th").forEach(th => th.classList.remove("th-asc", "th-desc"));
        
        elemento.classList.toggle("th-asc", ordenacaoCrescente);
        elemento.classList.toggle("th-desc", !ordenacaoCrescente);
    }
}

document.addEventListener('DOMContentLoaded', () => { carregarPainel(); });
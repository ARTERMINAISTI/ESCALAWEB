import Constantes from "../helper/constantes.js";
import Abstract from "./abstract.js";

export default class Grafico extends Abstract {    
    
    atualizarValor(valor) {
        switch (valor.tipo) {
            case Constantes.ComponenteTipoGraficoArea:
            case Constantes.ComponenteTipoGraficoAreaEmpilhada:
            case Constantes.ComponenteTipoGraficoLinha:
                this.#montarGraficoArea(this.elemento, valor);

                break;

            case Constantes.ComponenteTipoGraficoColuna:
            case Constantes.ComponenteTipoGraficoColunaEmpilhada:
                this.#montarGraficoColuna(this.elemento, valor);

                break;

            case Constantes.ComponenteTipoGraficoBarra:
            case Constantes.ComponenteTipoGraficoBarraEmpilhada:
                this.#montarGraficoBarra(this.elemento, valor);

                break;

            case Constantes.ComponenteTipoGraficoPizza:
                this.#montarGraficoPizza(this.elemento, valor);

                break;

            default:
                break;
        }
    }

    #montarGraficoArea(elemento, valor) {

        let chart = am4core.create(elemento, am4charts.XYChart);

        chart.data = valor.eixox;
        chart.fontSize = "10px";

        let xAxes = chart.xAxes.push(new am4charts.CategoryAxis());
        
        xAxes.dataFields.category = "EIXOX";
        xAxes.renderer.cellStartLocation = 0.1
        xAxes.renderer.cellEndLocation = 0.9
        xAxes.renderer.grid.template.location = 0;
        xAxes.renderer.labels.template.wrap = true;
        xAxes.renderer.labels.template.maxWidth = 120;
        xAxes.renderer.minGridDistance = 20;

        let yAxes = chart.yAxes.push(new am4charts.ValueAxis());
        
        yAxes.min = 0;
        yAxes.max = (valor.tipo != Constantes.ComponenteTipoGraficoAreaEmpilhada) || (valor.serie.length == 1) ? valor.eixoy.valorfinal * 1.2 : null;

        yAxes.tooltip.disabled = true;
        yAxes.renderer.minWidth = 35;

        if ((valor.ehexibirlegenda) && (valor.serie.length > 1)) {
            chart.legend = new am4charts.Legend();
            chart.legend.labels.template.maxWidth = 95;
            chart.legend.position = "right";
            chart.legend.fontSize = "10px";
            chart.legend.top = 0;
        }       
        
        valor.serie.forEach(serie => {
            let series = chart.series.push(new am4charts.LineSeries());

            series.name = serie.legenda

            series.dataFields.valueY = serie.nome;
            series.dataFields.categoryX = "EIXOX";
            series.strokeWidth = 2;

            series.stacked = (valor.tipo == Constantes.ComponenteTipoGraficoAreaEmpilhada) && (valor.serie.length > 1);

            let circleBullets = series.bullets.push(new am4charts.CircleBullet());

            circleBullets.stroke = am4core.color("#fff");
            circleBullets.tooltipText = "{name}: {valueY.formatNumber('" + serie.formatacao + "')}";

            if ("cor" in serie) {
                circleBullets.fill = am4core.color(serie.cor);
                
                series.fill = am4core.color(serie.cor);
                series.stroke = am4core.color(serie.cor);
            }
            else {
                circleBullets.propertyFields.fill = "cor";
                
                series.propertyFields.fill = "cor";
                series.propertyFields.stroke = "cor";
            }

            if (valor.tipo != Constantes.ComponenteTipoGraficoLinha) {
                series.fillOpacity = 0.5;
            }

            if (serie.ehexibirvalor) {
                let labelBullets = series.bullets.push(new am4charts.LabelBullet());
                
                labelBullets.dy = -10;
                labelBullets.label.fontSize = "8px";
                labelBullets.label.truncate = false;
                labelBullets.label.text =  "{valueY.formatNumber('" + serie.formatacao + "')}";
            } 
        });

    }

    #montarGraficoBarra(elemento, valor) {

        let chart = am4core.create(elemento, am4charts.XYChart);

        chart.data = valor.eixox;
        chart.fontSize = "10px";

        let yAxes = chart.yAxes.push(new am4charts.CategoryAxis());
        
        yAxes.dataFields.category = 'EIXOX';
        yAxes.renderer.cellStartLocation = 0.1
        yAxes.renderer.cellEndLocation = 0.9
        yAxes.renderer.grid.template.location = 0;								
        yAxes.renderer.inversed = true;

        let xAxes = chart.xAxes.push(new am4charts.ValueAxis());
        
        xAxes.renderer.opposite = true;
        xAxes.min = 0;
        xAxes.max = (valor.tipo != Constantes.ComponenteTipoGraficoBarraEmpilhada) || (valor.serie.length == 1) ? valor.eixoy.valorfinal * 1.2 : null;

        if ((valor.ehexibirlegenda) && (valor.serie.length > 1)) {
            chart.legend = new am4charts.Legend();
            chart.legend.labels.template.maxWidth = 95;
            chart.legend.position = "right";
            chart.legend.fontSize = "10px";
            chart.legend.top = 0;
        }        

        valor.serie.forEach(serie => {
            let series = chart.series.push(new am4charts.ColumnSeries());

            series.name = serie.legenda

            series.columns.template.stroke = am4core.color("#fff");
            series.columns.template.tooltipText = "{name}: {valueX.formatNumber('" + serie.formatacao + "')}";

            series.dataFields.categoryY = "EIXOX";
            series.dataFields.valueX = serie.nome;

            series.stacked = (valor.tipo == Constantes.ComponenteTipoGraficoBarraEmpilhada) && (valor.serie.length > 1);

            if ("cor" in serie) {
                series.fill = am4core.color(serie.cor);
            }
            else {
                series.columns.template.propertyFields.fill = "cor";
            }

            if (serie.ehexibirvalor) {
                let bullets = series.bullets.push(new am4charts.LabelBullet());
                
                bullets.dx = -10;
                bullets.label.fontSize = "8px";
                bullets.label.truncate = false;
                bullets.label.text =  "{valueX.formatNumber('" + serie.formatacao + "')}";
            } 
        });

    }

    #montarGraficoColuna(elemento, valor) {

        let chart = am4core.create(elemento, am4charts.XYChart);

        chart.data = valor.eixox;
        chart.fontSize = "10px";

        let xAxes = chart.xAxes.push(new am4charts.CategoryAxis());
        
        xAxes.dataFields.category = "EIXOX";
        xAxes.renderer.cellStartLocation = 0.1
        xAxes.renderer.cellEndLocation = 0.9
        xAxes.renderer.grid.template.location = 0;
        xAxes.renderer.labels.template.wrap = true;
        xAxes.renderer.labels.template.maxWidth = 120;
        xAxes.renderer.minGridDistance = 20;

        let yAxes = chart.yAxes.push(new am4charts.ValueAxis());
        
        yAxes.min = 0;
        yAxes.max = (valor.tipo != Constantes.ComponenteTipoGraficoColunaEmpilhada) || (valor.serie.length == 1) ? valor.eixoy.valorfinal * 1.2 : null;

        if ((valor.ehexibirlegenda) && (valor.serie.length > 1)) {
            chart.legend = new am4charts.Legend();
            chart.legend.labels.template.maxWidth = 95;
            chart.legend.position = "right";
            chart.legend.fontSize = "10px";
            chart.legend.top = 0;
        }        

        valor.serie.forEach(serie => {
            let series = chart.series.push(new am4charts.ColumnSeries());

            series.name = serie.legenda

            series.columns.template.stroke = am4core.color("#fff");
            series.columns.template.tooltipText = "{name}: {valueY.formatNumber('" + serie.formatacao + "')}";

            series.dataFields.valueY = serie.nome;
            series.dataFields.categoryX = "EIXOX";

            series.stacked = (valor.tipo == Constantes.ComponenteTipoGraficoColunaEmpilhada) && (valor.serie.length > 1);

            if ("cor" in serie) {
                series.fill = am4core.color(serie.cor);
            }
            else {
                series.columns.template.propertyFields.fill = "cor";
            }

            if (serie.ehexibirvalor) {
                let bullets = series.bullets.push(new am4charts.LabelBullet());
                
                bullets.dy = (valor.tipo != Constantes.ComponenteTipoGraficoColunaEmpilhada) || (valor.serie.length == 1) ? -10 : 10;
                bullets.label.fontSize = "8px";
                bullets.label.truncate = false;
                bullets.label.text =  "{valueY.formatNumber('" + serie.formatacao + "')}";
            } 
        });
    }

    #montarGraficoPizza(elemento, valor) {

        let chart = am4core.create(elemento, am4charts.PieChart);

        chart.padding(5,5,5,5);

        chart.data = valor.eixox;
        chart.fontSize = "10px";

        if (valor.ehexibirlegenda) {
            chart.legend = new am4charts.Legend();
            chart.legend.labels.template.maxWidth = 95;
            chart.legend.position = "right";
            chart.legend.fontSize = "10px";
            chart.legend.top = 0;
        }        

        if (valor.serie.length > 0) {
            let serie = valor.serie[0];

            let series = chart.series.push(new am4charts.PieSeries());

            series.alignLabels = false;

            series.dataFields.value = serie.nome;
            series.dataFields.category = 'EIXOX';
                        								
            series.labels.template.fontSize = '8px';
            series.labels.template.fill = am4core.color("white");
            series.labels.template.radius = am4core.percent(-40);		
            series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
            series.slices.template.tooltipText = "{category}: {value.formatNumber('" + serie.formatacao + "')}";
            
            series.slices.template.stroke = am4core.color("#fff");
            series.slices.template.strokeOpacity = 1;

            series.ticks.template.disabled = true;    

            if ("cor" in serie) {
                series.fill = am4core.color(serie.cor);
            }
            else {
                series.slices.template.propertyFields.fill = "cor";
            }
                    
            series.labels.template.adapter.add("radius", function(radius, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent < 11)) {
                    return 0;
                }
                if ((target.dataItem) && (target.dataItem.values.value.percent <= 14)) {
                    return -45;
                }
                
                return radius;
            });

            series.labels.template.adapter.add("relativeRotation", function(relativeRotation, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent >= 11) && (target.dataItem.values.value.percent <= 14)) {
                    return 90;
                }

                return relativeRotation;
            });

            series.labels.template.adapter.add("text", function(text, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent < 5)) {
                    return '';
                }
                return text;
            });

            series.labels.template.adapter.add("fill", function(color, target) {
                if ((target.dataItem) && (target.dataItem.values.value.percent < 11)) {
                    return am4core.color("#000");
                }

				return color;
            });
        };
    }
}
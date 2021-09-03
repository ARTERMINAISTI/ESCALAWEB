import Constantes from "../helper/constantes.js";
import FormatarNumero from "../helper/formatarnumero.js"
import Valor from "./valor.js";

export default class ValorIndicador extends Valor {
    montarItemValor(elemento, item) {
        if (item.valor == null) {
            return;
        }

        am4core.options.autoDispose = true;

        let div = this.criarElementoHtml(elemento, "div");

        let chart = am4core.create(div, am4charts.GaugeChart);

        chart.hiddenState.properties.opacity = 0;
        chart.fontSize = 10;
        chart.innerRadius = am4core.percent(80);
        chart.resizable = true;    
    
        this.#montarEixoEscala(item, chart);
        
        this.#montarEixoGrupo(chart, item);
    
        this.#montarLabelValor(chart, item);

        return div;
    }

    #montarEixoGrupo(chart, item) {
        let xAxes = chart.xAxes.push(new am4charts.ValueAxis());

        xAxes.min = item.valor.escalainicial;
        xAxes.max = item.valor.escalafinal;
        xAxes.renderer.grid.template.disabled = true;
        xAxes.renderer.grid.template.opacity = 0.5;
        xAxes.renderer.labels.template.bent = true;
        xAxes.renderer.labels.template.disabled = true;
        xAxes.renderer.labels.template.fill = am4core.color("#000");
        xAxes.renderer.labels.template.fillOpacity = 0.3;
        xAxes.renderer.labels.template.fontWeight = "bold";
        xAxes.renderer.ticks.template.disabled = false;
        xAxes.strictMinMax = true;

        let hand = chart.hands.push(new am4charts.ClockHand());
       
        hand.axis = xAxes;
        hand.innerRadius = am4core.percent(25);
        hand.startWidth = 1;
        hand.endWidth = 1;
        hand.pin.disabled = true;
        hand.value = item.valor.valor;
        
        if (item.grupo != null) {
            item.grupo.forEach(grupo => {

                let axisRange = xAxes.axisRanges.create();

                axisRange.axisFill.fill = am4core.color(grupo.cor);
                axisRange.axisFill.fillOpacity = 0.7;
                axisRange.axisFill.zIndex = -1;
                
                axisRange.value = grupo.valorinicial;
                axisRange.endValue = grupo.valorfinal;

                axisRange.grid.strokeOpacity = 0;

                axisRange.label.fontSize = "0.9em";
                axisRange.label.inside = true;
                axisRange.label.location = 0.5;
                axisRange.label.paddingBottom = -5;
                axisRange.label.radius = am4core.percent(10);
                axisRange.label.text = grupo.titulo;
            });
        }
    }

    #montarEixoEscala(item, chart) {
        if (!item.ehexibirescala) {
            return;
        };
        
        let xAxes = chart.xAxes.push(new am4charts.ValueAxis());

        xAxes.min = item.valor.escalainicial;
        xAxes.max = item.valor.escalafinal;
        xAxes.renderer.grid.template.disabled = true;
        xAxes.renderer.radius = am4core.percent(80);
        xAxes.renderer.inside = true;
        xAxes.renderer.labels.template.radius = am4core.percent(23);
        xAxes.renderer.labels.template.fontSize = "0.9em";
        xAxes.renderer.line.strokeOpacity = 0.1;
        xAxes.renderer.ticks.template.disabled = false;
        xAxes.renderer.ticks.template.strokeOpacity = 1;
        xAxes.renderer.ticks.template.strokeWidth = 0.5;
        xAxes.renderer.ticks.template.length = 2;
        xAxes.strictMinMax = true;
    }

    #montarLabelValor(chart, item) {
        let label = chart.radarContainer.createChild(am4core.Label);

        label.isMeasured = false;
        label.fontSize = "10px";
        label.x = am4core.percent(50);
        label.paddingBottom = 0;
        label.horizontalCenter = "middle";
        label.verticalCenter = "bottom";
        label.text = FormatarNumero(item.valor.formatacao, item.valor.valor);
    }
}
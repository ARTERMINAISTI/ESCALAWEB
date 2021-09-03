import Abstract from "./abstract.js";

export default class Calendario extends Abstract {

    atualizarValor(valor) {
        let div = this.criarElementoHtml(this.elemento, "div");

        div.classList.add("nao_exibir_ao_filtrar");
       
        let calendario = new FullCalendar.Calendar(div, {

            plugins: [ "dayGrid"],
    
            header: {
                left: null,
                center: "title",
                right: "today,prev,next"
            }, 
    
            views: {
                dayGridMonth: {
                    titleFormat: {  year: "numeric", month: "short" }
                }
            },

            defaultView: "dayGridMonth",
            editable: false,
            eventLimit: false,
            height: "parent",
            locale: "pt-br",            
            weekNumbers: false,
            weekNumbersWithinDays: false,
            handleWindowResize: false,
            width: "parent"
        });        
        
        calendario.render();        
    }
}
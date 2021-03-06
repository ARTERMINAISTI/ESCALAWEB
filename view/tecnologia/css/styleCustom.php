<?php 
    header("Content-type: text/css; charset=utf-8");
    include_once('../config.php');    
?>

/* CSS Document */

.body{
	width: 100%;	
	background-color:#f0f0f0;
}

.bottomPull{
	margin-bottom: 2.5em;	
}

.buttonRight{
	float: right;
}

.itemPedidoPainel{
	border: 1px solid #b7c4ca;
	border-radius: 10px;
	padding: 1em;
	margin: 0px;
}

@media(max-width: 500px){
	.mapa{
		height: 250px;
	}
}

@media(min-width: 1000px){
	.mapa{
		height: 620px;
	}
}

.itemPedidoPainel hr{
	margin-top: 5px;
	margin-bottom: 5px;
}
.itemPedidoPainel i{
	float: right;
	color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	margin-left: 10px;
}

.rastreioForm{
	color: #FFFFFF;
	padding-right: 0px;
}

.rastreioForm > div > p{		
	background-repeat:no-repeat;
}

#formRastreio{
	padding-right: 35px;
	padding-left: 20px;
	font-size: 15px;
}
#formRastreio>img{
	margin: 0 auto;
}
#conteudoRastreio{
	background-color: #FFFFFF;
	color: #111111;
	padding-top: 1%;
	padding-bottom: 1%;
	padding-left: 35px;
	padding-right: 15px;
	min-height: 100vh;
	height: 100%;
	font-size: 15px;
}
#retornoRastreio{
	color: #CC0E11;
	padding: 0px;
}
.centering-hv{
	float:none;
	margin:0 auto;
	position: relative;
	top: 100%;
	transform: translateY(70%);
}
.centering-v{
	top: 100%;
	transform: translateY(70%);
}
.centering-h{
	float:none;
	margin:0 auto;
}


.centralizarlogin{
	margin-top: 50%;
	margin-left:50%;
	width:320px;
	height:256px;
	top: -160px;
	left:-128px;
}

.footerFixed{
	bottom: 0;
	position: fixed;
	float: right;
	margin-right: 2%;
	width: 100%;
	background-color: #e5e5e5;
}

.footerNotThatFixed{
	bottom: 0;
	float: left;
	margin-right: 2%;
	width: 100%;
	background-color: #e5e5e5;
}

.textarea{
	max-width: 100%;	
}
.left{
	padding: 0 0 0 0;
	float:left;
	text-align:left;
}
.right{
	padding: 0 0 0 0;
	float:right;
	text-align:right;
	width: 50%;
}
.rightTop{
	padding: 0 0.6em 0 0;
	float:right;
	text-align:right;
}

.center-text{
	text-align:center;	
}

.w100{
	width:100%;	
}
.top20{
	margin-top: 20px;	
}
.left10{
	margin-left: 10px;	
}

.Noactivetr{
	background-color: none;
}
.activetr { 
	background-color: #BDBDBD;
}

/* enable absolute positioning */
.inner-addon { 
    position: relative;
	width:100%;
}

/* style icon */
.inner-addon .icone {
  position: absolute;
  padding: 15px;
  pointer-events: none;
  color:#939393;
  z-index:5050;
}

/* align icon */
.left-addon .icone  { left:  0px;}
.right-addon .icone { right: 0px;}


.inner-addon .glyphicon {
  position: absolute;
  padding: 12px;
  pointer-events: none;
  color:#555;
  z-index:2;
}

.inner-addon .add {
  position: absolute;
  padding: 12px 45px 0 0;
  pointer-events: none;
  color:#555;
  z-index:9;
}

/* align icon */
.left-addon .glyphicon  { left:  0px;}
.right-addon .glyphicon { right: 0px;}



/* add padding  */
.left-addon input  { padding-left:  36px; }
.right-addon input { padding-right: 30px; }





/* style icon inputLg */
.inner-addonLg .icone {
  position: absolute;
  padding: 15px;
  pointer-events: none;
  color:#939393;
  z-index:5050;
}

/* align icon */
.left-addonLg .icone  { left:  0px;}
.right-addonLg .icone { right: 0px;}


.inner-addonLg .glyphicon {
  position: absolute;
  padding: 26px;
  pointer-events: none;
  color:#555;
  z-index:2;
}

/* align icon */
.left-addonLg .glyphicon  { left:  0px;}
.right-addonLg .glyphicon { right: 0px;}



/* add padding  */
.left-addon input  { padding-left:  36px; }
.right-addon input { padding-right: 30px; }



.borderDivider {
	border-style: solid;
	border-top:none;
	border-right:none;
	border-left:none;
    border-bottom-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	width:100%;
}


.dividerH {
  height: 1px;
  width:100%;
  display:block; /* for use on default inline elements like span */
  margin: 0px 0 ;
  overflow: hidden;
  background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
}


.span {
	background-color:#e5e5e5;
	color:#000000;
	font-size:18px;
	padding:9px 1px;
	text-decoration:none;
	border:none;
}

.botao {
	background-color:#e5e5e5;
	color:#000000;
	font-size:15px;
	padding:11px 15px;
	text-decoration:none;
	border:none;
}

.botao:hover {
	background-color:#BFBFBF;
}
.botao[disabled] {
	background-color:#7EC5E3;
	color: rgba(255,255,255,0.78);
}
.botao:active {
	position:relative;
	top:1px;
}

.botaoMobile {
	background-color:#FFF;
	color:#000000;
	font-size:15px;
	padding:11px 15px;
	text-decoration:none;
	border: 1px solid #C3C3C3;
	width:100%;
	text-align:left;
}

.botaoMobile:hover {
	background-color:#e5e5e5;
}
.botaoMobile[disabled] {
	background-color:#e5e5e5;
	color: rgba(255,255,255,0.78);
}
.botaoMobile:active {
	position:relative;
	top:1px;
}

.botaoBranco {
	background-color:#FFFFFF;
	color:#2A2A2A;
	font-size:15px;
	padding:10px 7px;
	text-decoration:none;
	border:none;
	margin-top: 1px;
}

.botaoBranco:hover {
	background-color:#D8D8D8;
}
.botaoBranco:active {
	position:relative;
	top:1px;
}

.botaoBrancoLg {
	background-color:#FFFFFF;
	color:#2A2A2A;
	font-size:16px;
	padding:10px 23px;
	text-decoration:none;
	border:none;
}

.botaoBrancoLg:hover {
	background-color:#D8D8D8;
}
.botaoBrancoLg:active {
	position:relative;
	top:1px;
}

.botaoLogin {
	background-color:#FFFFFF;
	color:#2A2A2A;
	font-size:16px;
	padding:10px 12px;
	text-decoration:none;
	border: 1px solid #ccc;
	border-left: none;
	border-radius: 0 4px 4px 0;
	height:45px;
}

.botaoLogin:active {
	background-color:#FFFFFF;
	color:#2A2A2A;
	font-size:16px;
	padding:10px 12px;
	text-decoration:none;
	border: 1px solid #ccc;
	border-left: none;
	border-radius: 0 4px 4px 0;
	height:45px;
}

.botaoLogin:hover {
	background-color:#FFFFFF;
	color:#2A2A2A;
	font-size:16px;
	padding:10px 12px;
	text-decoration:none;
	border: 1px solid #ccc;
	border-left: none;
	border-radius: 0 4px 4px 0;
	height:45px;
}

.botaoBranco1 {
	background-color:transparent;
	color:#2A2A2A;
	padding:4px 8px;
	text-decoration:none;
	border:none;
}

.botaoBranco1:hover {
	background-color:#D8D8D8;
}
.botaoBranco1:active {
	position:relative;
	top:1px;
}

.botaoBranco1:disabled {
	color: #A7A7A7;
}

.botaoBranco2 {
	background-color:#FFFFFF;
	color:#2A2A2A;
	font-size:23px;
	padding:8px 12px;
	text-decoration:none;
	border:none;
}

.botaoBranco2:hover {
	background-color:#D8D8D8;
}
.botaoBranco2:active {
	position:relative;
	top:1px;
}


.listNoneStyle {
	list-style:none;
}


input[type="file"] {
    display: none;
}
.display {
	display: none;
	visibility:hidden;
}

.inputRight{
	text-align:right;	
}

.pullBottom {
	padding-bottom: 0.5em;	
}
.pullTop {
	margin-top: 0.5em;	
}
.pullBottomLogin {
	padding-bottom: 1em;	
}

.tableth{
	font-weight:normal;
	background-color:#E5E5E5;
}

input[type="datetime-local"]::-webkit-calendar-picker-indicator{
  -webkit-appearance: none;
  background-color: #fff;
  color: transparent;
  background: url(../img/arrowDown.png);
  background-repeat:no-repeat;
  background-position: 80% 100%;
  background-size:11px;
}

input[type="datetime-local"]::-webkit-inner-spin-button{
  -webkit-appearance: none;
   display: block;
   visibility:hidden;
}

input[type="datetime-local"]::-webkit-clear-button {
  -webkit-appearance: none;
   display: block;
   visibility:hidden;
}


input[type="date"]::-webkit-calendar-picker-indicator{
  -webkit-appearance: none;
  background-color: #fff;
  color: transparent;
  background: url(../img/arrowDown.png);
  background-repeat:no-repeat;
  background-position: 80% 100%;
  background-size:11px;
}

input[type="date"]::-webkit-inner-spin-button{
  -webkit-appearance: none;
   display: block;
   visibility:hidden;
}

input[type="date"]::-webkit-clear-button {
  -webkit-appearance: none;
   display: block;
   visibility:hidden;
}

.mobileHide{
	display: block;	
	/*width:auto;*/
	border:none;
}
.mobileHideTd{
	text-align: right;
	border:none;
}
.desktopHide{
	display: none;	
	width:auto;
}

.semBarraRolagem{
	overflow-y:hidden;
	overflow-x:hidden;	
}

.inputLg {
  height: 66px;
  padding: 10px 16px;
  font-size: 28px;
  line-height: 1.3333333;
  width:100%;
  margin-left:1px;
  border: 1px solid;
  border-color: rgba(255,0,0,1.00);
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255,0,0, .4);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255,0,0, .4);
}
.topBar{
	padding: 0.7em 0;	
	font-size:19px;
	font-weight: normal !important;
	width:80%;
	left: 55px;
	text-align:left;
	position: inherit;
	color:#FFFFFF;
	white-space: nowrap;
}

.topBarRight{
	text-align: right;
	right: 0;
	top: 0;
	position:fixed;
	padding: 0em 0.4em;
}

.footerBar{	
	background-repeat:no-repeat;
}


.panelTitle{
	background-color: #BFBFBF;
	width:100%;
	padding: 8px;	
	color:#000000;
}

@media screen and (max-width: 1680px) {
 
}

@media screen and (max-width: 1440px) {
	
}

@media screen and (max-width: 1366px) {
 .topBar{
	text-align:left;
}
}
@media screen and (max-width: 1280px) {
  
}
@media screen and (max-width: 1024px) {
  
}
@media screen and (max-width: 991px) {
	
.pullBottom {
	padding-bottom: 0.1em;	
}

.topBar{
	padding: 0.7em 0 0 0;	
	font-size:19px;
}


}
@media screen and (max-width: 840px) {
	
}
@media screen and (max-width: 768px) {

.itemPedidoPainel{
	border: 1px solid #b7c4ca;
	border-radius: 10px;
	padding: 1em;
	margin: 2px;
	width: 99.3%;
}
.rastreioForm{
	color: #FFFFFF;
	padding-right: 10px;
}
.rastreioForm > div > p{	
	background-repeat:no-repeat;
}
#formRastreio{
	padding-right: 15px;
	margin-bottom: 15px;
}
#formRastreio>img{
	margin: 20px auto;
}
#conteudoRastreio{
	background-color: #FFFFFF;
	color: #111111;
	padding-top: 8%;
	padding-bottom: 8%;
	padding-left: 15px;
	padding-right: 15px;
	min-height: 100%;
	height: auto;
}
#retornoRastreio{
	color: #CC0E11;
	padding-top: 5px;
}
.centering-hv{
	float:none;
	margin:0 auto;
	position: relative;
	top: 100%;
	transform: translateY(70%); 
}
.centering-v{
	top: auto;
	transform: translateY(0%);
	padding-bottom: 40px;
}
.centering-h{
	float:none;
	margin:0 auto;
}

	
.mobileHideTd{
	display: none;
}
.mobileHide{
	display: none;	
	width:auto;
}
.desktopHide{
	display: block;	
	width:auto;
}
.inputLg {
  height: 58px;
  padding: 10px 16px;
  font-size: 24px;
  line-height: 1.3333333;
  width:100%;
}

.inner-addonLg .glyphicon {
  position: absolute;
  padding: 21px;
  pointer-events: none;
  color:#555;
  z-index:2;
  font-size: 15px
}

.topBar{
	padding: 0.7em 0 0 0;	
	font-size:19px;
}

}
@media screen and (max-width: 640px) {
	
.pullBottom {
	padding-bottom: 0.1em;	
}

.inputLg {
  height: 51px;
  padding: 10px 16px;
  font-size: 20px;
  line-height: 1.3333333;
  width:100%;
}

.inner-addonLg .glyphicon {
  position: absolute;
  padding: 19px;
  pointer-events: none;
  color:#555;
  z-index:2;
  font-size: 13px
}
.topBar{
	padding: 0.8em 0 0 0;	
	font-size:18px;
}

.botao {
	background-color:#e5e5e5;
	color:#000000;
	font-size:17px;
	padding:7px 15px;
	text-decoration:none;
	border:none;
}
.botaoMobile {
	background-color:#FFF;
	color:#000000;
	font-size:15px;
	padding:11px 15px;
	text-decoration:none;
	border: 1px solid #C3C3C3;
	width:100%;
	text-align:left;
}
.span {
	padding:7px 1px;
}

}
@media screen and (max-width: 480px) {
.inputLg {
  height: 46px;
  padding: 10px 16px;
  font-size: 16px;
  line-height: 1.3333333;
  width:100%;
}

.inner-addonLg .glyphicon {
  position: absolute;
  padding: 18px;
  pointer-events: none;
  color:#555;
  z-index:2;
  font-size: 12px
}

.topBar{
	padding: 0.7em 0 0 1.5em;	
	font-size:17px;
	left: 30px;
}

.botao {
	background-color:#e5e5e5;
	color:#000000;
	font-size:16px;
	padding:10px 10px;
	text-decoration:none;
	border:none;
}
.botaoMobile {
	background-color:#FFF;
	color:#000000;
	font-size:15px;
	padding:11px 15px;
	text-decoration:none;
	border: 1px solid #C3C3C3;
	width:100%;
	text-align:left;
}

.span {
	padding:4px 1px;
}
}
@media screen and (max-width: 384px) {
.topBar{
	padding: 0.9em 0 0 1.5em;	
	font-size:15px;
	left: 30px;
}
}
@media screen and (max-width: 320px) {
	.inputLg {
  height: 46px;
  padding: 10px 16px;
  font-size: 16px;
  line-height: 1.3333333;
  width:100%;
}

.inner-addonLg .glyphicon {
  position: absolute;
  padding: 18px;
  pointer-events: none;
  color:#555;
  z-index:2;
  font-size: 12px
}

.topBar{
	padding: 0.9em 0 0 1.5em;	
	font-size:15px;
	left: 30px;
}

.botao {
	background-color:#e5e5e5;
	color:#000000;
	font-size:16px;
	padding: 10px 8px;
	text-decoration:none;
	border:none;
}
.botaoMobile {
	background-color:#FFF;
	color:#000000;
	font-size:15px;
	padding:11px 15px;
	text-decoration:none;
	border: 1px solid #C3C3C3;
	width:100%;
	text-align:left;
}

.span {
	padding: 4px 1px;
}

.topBarRight{
	padding: 0 0.5em;
}

}

form#formCurriculoAlterarSenha .inner-addon .fa-address-card-o,
form#formCurriculoAlterarSenha .inner-addon .fa-user {
	margin: 16px 0 0 0;
}

form#formCurriculoAlterarSenha .inner-addon .fa-lock {
	padding: 10px;
}

form#formCurriculoAlterarSenha .botaoLogin, .botaoLogin:hover {
	height: 34px;
	padding: 5px 12px;
	background-color: #fff;
}
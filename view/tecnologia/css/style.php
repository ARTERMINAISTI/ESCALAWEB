﻿<?php 
    header("Content-type: text/css; charset=utf-8");
    include_once('../config.php');    
?>

.floatRight{
    float:right;
}

.meu_popup {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 10px;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    background-color: rgba(0,0,0, 0.5);    
    z-index: 10;
  }

  .meu_popup_inner {
    position: absolute;
    left: 10%;
    right: 10%;
    top: 10%;
    bottom: 10%;
    margin: auto;
    background: white;
    border-radius: 10px; 
    overflow: auto;
  }

h4, h5, h6,
h1, h2, h3 {margin: 0;}
ul, ol {margin: 0;}
p {margin: 0;}
@font-face {
      font-family: 'Tahoma';
      src: local("Tahoma"),
         local("Tahoma"),
         url('../fonts/Tahoma.eot?#iefix') format('embedded-opentype'),
         url('../fonts/Tahoma.woff') format('woff'),
         url('../fonts/Tahoma.svg#SegoeUI') format('svg');
	  font-weight: normal;
      font-style: normal;
}

@font-face {
    font-family: 'Segoe UI';
    src: url('../fonts/segoeui.eot');
    src: local("Segoe UI"),
         local("Segoe"),
         local("Segoe WP"),
         url('../fonts/segoeui.eot?#iefix') format('embedded-opentype'),
         url('../fonts/segoeui.woff') format('woff'),
         url('../fonts/segoeui.svg#SegoeUI') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'Segoe UI Semibold';
    src: url('../fonts/seguisb.eot');
    src: local("Segoe Semibold"),
         local("Segoe WP Semibold"), 
         url('../fonts/seguisb.eot?#iefix') format('embedded-opentype'),
         url('../fonts/seguisb.woff') format('woff'),
         url('../fonts/seguisb.svg#SegoeUISemibold') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'Segoe UI Bold';
    src: url('../fonts/segoeuib.eot');
    src: local("Segoe Bold"),
         local("Segoe WP Bold"),
         url('../fonts/segoeuib.eot?#iefix') format('eot'), /* Wrong format will tell IE9+ to ignore and use WOFF instead. MSHAR-2822 */
         url('../fonts/segoeuib.woff') format('woff'),
         url('../fonts/segoeuib.svg#SegoeUIBold') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'Segoe UI Light';
    src: url('/light/segoeuil.eot');
    src: local("Segoe UI Light"),
         local("Segoe WP Light"),
         url('../fonts/segoeuil.eot?#iefix') format('embedded-opentype'),
         url('../fonts/segoeuil.woff') format('woff'),
         url('../fonts/segoeuil.svg#SegoeUILight') format('svg');
    font-weight: normal;
    font-style: normal;
}
  
html, body{
  	/*font-family: 'Roboto Condensed', sans-serif;*/
	font-family: 'Segoe UI Light';
    font-size: 100%;
  	overflow-x: hidden;
	background: #fff;
	width:100%;
	height: 100%; 
}
body a{
	transition: 0.5s all ease;
	-webkit-transition: 0.5s all ease;
	-moz-transition: 0.5s all ease;
	-o-transition: 0.5s all ease;
	-ms-transition: 0.5s all ease;
	text-decoration:none;
}
form{
	font-size:14px;	
}
#cbp-spmenu-s1 {
  	overflow-y: auto;
}
#side-menu{
	margin-bottom: 3em;	
}
table.tableTabPage{
	font-size:14px;	
	font-family: 'Tahoma';
}
a.disabled {
   pointer-events: none;
   cursor: default;
}
button:disabled {
   pointer-events: none;
   cursor: default;
}
h1,h2,h3,h4,h5,h6{
	margin:0;			   
}
p{
	margin:0;
}
ul,label{
	margin:0;
	padding:0;
}
body a:hover{
	text-decoration:none;
}
div#loader{
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0px;
	left:0px;
	background-color: rgba(86, 153, 210, 0.6);
	background-image: url(../img/loading.svg);
	background-position: center center;
	background-repeat: no-repeat;
	z-index: 9999999999999999999;
}

.marginZero{
	margin:0.2em;	
}
.dashboardBody{
	height:100%;	
}
.main-content {
    position: relative;
}
.logoRight {
	text-align: right;
	float: right;
	margin-top:-2.2em;
}
.footerFixed {
	text-align: right;
	float: right;
	font-family: 'Segoe UI Light';
}
.topHeader{
	padding: 1em 0 0 0;	
	font-size:22px;
	font-weight: normal !important;
	margin:0 auto;
	width:400px;
}

.topHeaderIndex{
	padding: 1em 5em 0 0;	
	font-size:22px;
	text-align:center;	
}

.topHeaderTitle{
	padding: 1em 5em 0 0;	
	font-size:22px;
	text-align:left;	
}

.inputLogin{
	background-color:#FFFFFF;	
}
.pageContent{
	margin: 3.5em 0 4em 0;
	font-family: 'Tahoma';
}
.formContent{
	margin: 0.7em 0.5em 0 0.5em;
	font-family: 'Tahoma';
}
.pageContentFiltro{
	margin: 5em 0 0 0;
}
.dataTableGrid{
	padding-top: 0.9em;	
}

form#formCurriculoAlterar .form-group input.form-control {
    border-radius: 5px !important;
    border: 1px solid #ccc !important;
}

form#formCurriculoAlterar .form-group textarea {
    resize: none;
}

form#formCurriculoAlterar .form-group {
    margin-right: 5px;
    margin-left: 5px;
}

form#formCurriculoAlterar span {
    font-weight: bold;
}

form#formCurriculoAlterar button,
form#formCurriculoAlterarSenha button {
    width: 200px;
    position: relative;
    float: left;
    width: 200px;
    text-align: center;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    border-color: #255625;
    color: #fff;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 1px;
}

form#formCurriculoAlterar a.voltar,
form#formCurriculoAlterarSenha a.voltar {
    position: relative;
    float: left;
    width: 200px;
    text-align: center;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    border-color: #255625;
    color: #fff;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 1px;
}

form#formCurriculoAlterar a.voltar:hover,
form#formCurriculoAlterarSenha a.voltar:hover {
    border-color: #E74225 !important;
    background: #E74225 !important;
}

/*-------HEADER SECTION------*/
/* ----STICKY HEADER----*/
.sticky-header{
    position: fixed;
    top: 0;
    left:0px;
    width: 100%;
    z-index: 100;
}
.header-section {
    background: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	color:#FFFFFF;
    box-shadow:  1px 1px 4px rgba(0, 0, 0, 0.21);
    -webkit-box-shadow:  1px 1px 4px rgba(0, 0, 0, 0.21);
    -moz-box-shadow:  1px 1px 4px rgba(0, 0, 0, 0.21);
    -o-box-shadow:  1px 1px 4px rgba(0, 0, 0, 0.21);
}
.header-section::after {
    clear: both;
    display: block;
    content: '';
}
.header-left {
    float: left;
    width: 45%;
}
.header-right {
    float: right;
}
/* ----menu-icon----*/
.topoMenu{
	background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	width: 100%;	
	padding: 0.1em 0em 0 0.8em;
}
.titleMenu {
	color:#FFFFFF;	
	padding-bottom:0.5em;
	font-size:1.2em;
}
.infoMenu {
	color:#FFFFFF;	
	padding: 1em 1em 1em;
	text-align:right;
}
.imgMenu {
	color:#FFFFFF;	
	padding: 0px 0em 1em;
}
button#showLeftPush {
    font-size: 1.8em;
    width: 80px;
    padding: 0.2em 0;
    text-align: center;
    cursor: pointer;
    float: left;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
	z-index:999999999999;
	width:50px;
}
button#showLeftPush:hover {
    color: #175d79;
}
button#showLeftPushVoltarForm {
    font-size: 1.4em;
    width: 80px;
    padding: 0.5em 0;
    text-align: center;
    cursor: pointer;
    float: left;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
	z-index:999999999999;
	width:50px;
}
button#showLeftPushVoltarForm:hover {
    color: #175d79;
}

button#showLeftPushVoltarModal {
    font-size: 1.5em;
    padding: 0;
    text-align: center;
    cursor: pointer;
    float: left;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
	z-index:999999999999;
	width:40px;
}
button#showLeftPushVoltarModal:hover {
    color: #175d79;
}

button#showLeftPushClose {
    font-size: 1em;
    width: 30px;
    padding: 0;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: transparent;
	outline:none;
	z-index:999999999999;
	width:50px;
}
button#showLeftPushClose:hover {
    color: #B50000;
}

.botaoTop {
    font-size: 1.3em;
    width: 40px;
	max-height: 48px;
    padding: 0.6em 0;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

.fundoAzul{
	background-color: #113644;
	height:100%;
}
/*--push-menu-css--*/
.cbp-spmenu {
	position: fixed;
}
.cbp-spmenu-vertical {
    width: 350px;
    height: 105vh;
    top: 0;
    z-index: 1000;
    /*background-color:#175d79;*/
	background-color:#FFFFFF;
	border-right: 1px solid #4c4c4c;
	/*padding: 2em 10px;*/
}
.cbp-spmenu-left {
    left: -360px;
}
.cbp-spmenu-left.cbp-spmenu-open {
	left: 0;
}
/* Push classes applied to the body */
.cbp-spmenu-push {
	overflow-x: hidden;
	position: relative;
}
.cbp-spmenu-push-toright {
	left: 0;
}
/* Transitions */

.cbp-spmenu,
.cbp-spmenu-push {
	-webkit-transition: all 0.3s ease;
	-moz-transition: all 0.3s ease;
	transition: all 0.3s ease;
}
.cbp-spmenu-push div#page-wrapper {
    margin: 0 0 0 19.3em;
	transition:.5s all;
	-webkit-transition:.5s all;
	-moz-transition:.5s all;
}
.cbp-spmenu-push.cbp-spmenu-push-toright div#page-wrapper {
    margin: 0;
}
/*--//push-menu-css--*/
/*--side-menu--*/
.sidebar ul li{
	 margin-bottom: 1em;
}
.sidebar ul li a {
    color: #1D1D1D;
    font-size: 1em;
}

.nav > li > a:hover, .nav > li > a:focus {
    text-decoration: none;
    background-color: #e5e5e5;
    color: #252525;
}
.sidebar .arrow {
    float: right;
}
i.nav_icon {
    margin-right: 1em;
	font-size: 1.1em;
}
.fa {
    display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
span.nav-badge {
    font-size: 12px;
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.32);
    width: 25px;
    height: 25px;
    border-radius: 68%;
    -webkit-border-radius: 68%;
    -moz-border-radius: 68%;
    -o-border-radius: 68%;
    position: absolute;
    top: 18%;
    right: 15%;
    line-height: 26px;
    letter-spacing: 1px;
    text-align: center;
}
span.nav-badge-btm {
    font-size: 12px;
    color: #FFF;
    background: #175d79;
    position: absolute;
    top: 18%;
    right: 15%;
    line-height: 22px;
    letter-spacing: 1px;
    text-align: center;
    padding: 0em 1em;
}
.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    background: none;
    color: #175d79;
}
.chart-nav span.nav-badge-btm {
	right: 5%;
    top: 24%;
}
ul.dropdown-menu{
	animation: flipInX 1s ease;
	-moz-animation: flipInX 1s ease;
	-webkit-animation: flipInX 1s ease;
	-webkit-backface-visibility: visible !important;
	-ms-backface-visibility: visible !important;
	backface-visibility: visible !important;
	-moz-backface-visibility: visible !important;
	data-wow-delay:".1s";
}
/*--//side-menu--*/
/* ----Logo----*/
.logo {
    background: #175d79;
    text-align: center;
    float: left;
}
.logo a{
    padding: 0.9em 3.3em .7em;
	display: block;
	text-decoration: none;
}
.logo a h1 {
    color: #fff;
    font-size: 1.5em;
    line-height: 1.2em;
    font-weight: 700;
}
.logo a span {
    color: #F8F8F8;
    font-size: .7em;
    text-align: center;
    letter-spacing: 7px;
}
/* ----//Logo----*/
/*start search*/
.search-box {
    float: left;
    width: 34%;
    margin: 1.2em 0 0 3em;
	position: relative;
    z-index: 1;
    display: inline-block;
}
.sb-search-input {
    outline: none;
    background: #fff;
    width: 100%;
    margin: 0;
    z-index: 10;
    font-size: 0.9em;
    color: #175d79;
    padding: 0.5em 1em;
	border: 2px solid rgba(79, 82, 186, 0.3);
	-webkit-appearance: none; /* for box shadows to show on iOS */
	font-family: 'Roboto Condensed', sans-serif;
}
.sb-search-input::-webkit-input-placeholder {
	color:#175d79;
}
.sb-search-input:-moz-placeholder {
	color: #175d79;
}
.sb-search-input::-moz-placeholder {
	color: #175d79;
}
.sb-search-input:-ms-input-placeholder {
	color: #175d79;
}
.input__label {
	-webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	position: absolute;
	width: 100%;
	height: 100%;
}

.graphic {
	fill: none;
	-webkit-transform: scale3d(1, -1, 1);
	transform: scale3d(1, -1, 1);
	-webkit-transition: stroke-dashoffset 0.5s;
	transition: stroke-dashoffset 0.5s;
	pointer-events: none;
	stroke: #D81B60;
    stroke-width: 6px;
    stroke-dasharray: 962;
    stroke-dashoffset: 962;
}
/* Madoka */
.input__field--madoka {
	background: transparent;
	display: block;
	float: right;
}
.input__field--madoka:focus {
	outline: none;
}
.input__field--madoka:focus + .input__label,
.input--filled .input__label {
	cursor: default;
	pointer-events: none;
}
.input__field--madoka:focus + .input__label .graphic,
.input--filled .graphic {
	stroke-dashoffset: 0;
}

.input__field--madoka:focus + .input__label .input__label-content{
	-webkit-transform: scale3d(0.81, 0.81, 1) translate3d(0, 4em, 0);
	transform: scale3d(0.81, 0.81, 1) translate3d(0, 4em, 0);
}
/*--//search-ends --*/
/*--- Progress Bar ----*/
.meter {
	position: relative;
}
.meter > span {
	display: block;
	height: 100%;
	   
	position: relative;
	overflow: hidden;
}
.meter > span:after, .animate > span > span {
	content: "";
	position: absolute;
	top: 0; left: 0; bottom: 0; right: 0;
	
	overflow: hidden;
}

.animate > span:after {
	display: none;
}

@-webkit-keyframes move {
    0% {
       background-position: 0 0;
    }
    100% {
       background-position: 50px 50px;
    }
}

@-moz-keyframes move {
    0% {
       background-position: 0 0;
    }
    100% {
       background-position: 50px 50px;
    }
}

.red > span {
	background-color: #65CEA7;
}

.nostripes > span > span, .nostripes > span:after {
	-webkit-animation: none;
	-moz-animation: none;
	background-image: none;
}
/*--- User Panel---*/
.profile_details_left {
    float: left;
}
.dropdown-menu {
    box-shadow: 2px 3px 4px rgba(0, 0, 0, .175);
	-webkit-box-shadow: 2px 3px 4px rgba(0, 0, 0, .175);
	-moz-box-shadow: 2px 3px 4px rgba(0, 0, 0, .175);
    border-radius: 0;
}
li.dropdown.head-dpdn {
    display: inline-block;
    padding: 1.7em 0;
    border-left: 1px solid #E0E0E0;
	float: left;
}
li.dropdown.head-dpdn:nth-child(3) {
    border-right: 1px solid #E0E0E0;
}
li.dropdown.head-dpdn a.dropdown-toggle {
    padding: 1.7em 2em;
}
ul.dropdown-menu li {
    margin-left: 0;
    width: 100%;
	min-width: 200px;
    padding: 0;
}
ul.dropdown-menu li:hover {
	background: #e5e5e5;
}
.user-panel-top ul{
	padding-left:0;
}
.user-panel-top li{
	float:left;
	margin-left:15px;
	position:relative;
}
.user-panel-top li span.digit{
    font-size:11px;
    font-weight:bold;
	color:#FFF;
	background:#175d79;
	line-height:20px;
	width:20px;
	height:20px;
	border-radius:2em;
	-webkit-border-radius:2em;
	-moz-border-radius:2em;
	-o-border-radius:2em;	
	text-align:center;
	display: inline-block;
	position: absolute;
	top: -3px;
	right: -10px;
}
.user-panel-top li:first-child{
	margin-left:0;
}
.sidebar .nav-second-level li a.active ,.sidebar ul li a.active{
    color: #252525;
	background-color: #e5e5e5;
}
li.active a i, .act a i {
    color: #252525;
}
.custom-nav > li.act > a, .custom-nav > li.act > a:hover, .custom-nav > li.act > a:focus {
    background-color: #353f4f;
    color:#8BC34A;
}
.user-panel-top li a{
	display: block;
	padding: 5px;
	text-decoration:none;
}
.header-right i.fa.fa-envelope{
	color:#6F6F6F;
}
i.fa.fa-bell{
	color:#6F6F6F;
}
i.fa.fa-tasks{
	color:#6F6F6F;
}
.user-panel-top li a:hover{
	border-color:rgba(101, 124, 153, 0.93);
}
.user-panel-top li a i{
	width:24px;
	height:24px;
	display: block;
	text-align:center;
	line-height:25px;
}
.user-panel-top li a i span{
	font-size:15px;
	color:#FFF;
}
.user-panel-top li a.user{
	background:#667686;
}
.user-panel-top li span.green{
	background:#a88add;
}
.user-panel-top li span.red{
	background:#b8c9f1;
}
.user-panel-top li span.yellow{
	background:#bdc3c7;
}
/***** Messages *************/
.notification_header{
	background-color:#FAFAFA;
	padding: 10px 15px;
	border-bottom:1px solid rgba(0, 0, 0, 0.05);
	margin-bottom: 8px;
}
.notification_header h3{	
	color:#6A6A6A;
	font-size:12px;
	font-weight:600;
	margin:0;
}
.notification_bottom {
    background-color: rgba(200, 129, 230, 0.14);
    padding: 4px 0;
    text-align: center;
	margin-top: 5px;
}
.notification_bottom a {
    color: #6F6F6F;
	 font-size: 1em;
}
.notification_bottom a:hover {
    color:#175d79;
}
.notification_bottom h3 a{	
	color: #717171;
	font-size:12px;
	border-radius:0;
	border:none;
	padding:0;
	text-align:center;
}
.notification_bottom h3 a:hover{	
	color:#4A4A4A;
	text-decoration:underline;
	background:none;
}
.user_img{
	float:left;
	width:19%;
}
.user_img img{
	max-width:100%;
	display:block;
	border-radius:2em;
	-webkit-border-radius:2em;
	-moz-border-radius:2em;
	-o-border-radius:2em;
}
.notification_desc{
	float:left;
	width:70%;
	margin-left:5%;
}
.notification_desc p{
	color:#757575;
	font-size:13px;
	padding:2px 0;
}
.wrapper-dropdown-2 .dropdown li a:hover .notification_desc p{
	color:#424242;
}
.notification_desc p span{
	color:#979797 !important;
	font-size:11px;
}
/*---bages---*/
.header-right span.badge {
    font-size: 11px;
    font-weight: bold;
    color: #FFF;
    background: #8BC34A;
    line-height: 15px;
    width: 20px;
    height: 20px;
    border-radius: 2em;
    -webkit-border-radius: 2em;
    -moz-border-radius: 2em;
    -o-border-radius: 2em;
    text-align: center;
    display: inline-block;
    position: absolute;
    top: 16%;
    padding: 2px 0 0;
}
.header-right span.blue{
	background-color:#D81B60;
}
.header-right span.red{
	background-color:#ef553a;
}
.header-right span.blue1{
	background-color:#9358ac;
}
i.icon_1{
  float: left;
  color: #00aced;
  line-height: 2em;
  margin-right: 1em;
}
i.icon_2{
  float: left;
  color:#ef553a;
  line-height: 2em;
  margin-right: 1em;
  font-size: 20px;
}
i.icon_3{
  float: left;
  color:#9358ac;
  line-height: 2em;
  margin-right: 1em;
  font-size: 20px;
}
.avatar_left {
  float: left;
}
i.icon_4{
  width: 45px;
  height: 45px;
  background: #F44336;
  float: left;
  color: #fff;
  text-align: center;
  font-size: 1.5em;
  line-height: 44px;
  font-style: normal;
  margin-right: 1em;
}
i.icon_5{
  background-color: #3949ab;
}
i.icon_6{
  background-color: #03a9f4;
}
.blue-text {
  color: #2196F3 !important;
  float:right;
}
/*---//bages---*/
/*--Progress bars--*/
.progress {
    height: 10px;
    margin: 7px 0;
    overflow: hidden;
    background: #e1e1e1;
    z-index: 1;
    cursor: pointer;
}
.task-info .percentage{
	float:right;
	height:inherit;
	line-height:inherit;
}
.task-desc{
	font-size:12px;
}
.wrapper-dropdown-3 .dropdown li a:hover span.task-desc {
	color:#65cea7;
}
.progress .bar {
		z-index: 2;
		height:15px; 
		font-size: 12px;
		color: white;
		text-align: center;
		float:left;
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		-ms-box-sizing: content-box;
		box-sizing: content-box;
		-webkit-transition: width 0.6s ease;
		  -moz-transition: width 0.6s ease;
		  -o-transition: width 0.6s ease;
		  transition: width 0.6s ease;
	}
.progress-striped .yellow{
	background:#f0ad4e;
} 
.progress-striped .green{
	background:#5cb85c;
} 
.progress-striped .light-blue{
	background:<?= ViewConfig::getCorFundoPrimaria(); ?>;
} 
.progress-striped .red{
	background:#d9534f;
} 
.progress-striped .blue{
	background:#428bca;
} 
.progress-striped .orange {
	background:#175d79;
}
.progress-striped .bar {
  background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  -webkit-background-size: 40px 40px;
  -moz-background-size: 40px 40px;
  -o-background-size: 40px 40px;
  background-size: 40px 40px;
}
.progress.active .bar {
  -webkit-animation: progress-bar-stripes 2s linear infinite;
  -moz-animation: progress-bar-stripes 2s linear infinite;
  -ms-animation: progress-bar-stripes 2s linear infinite;
  -o-animation: progress-bar-stripes 2s linear infinite;
  animation: progress-bar-stripes 2s linear infinite;
}
@-webkit-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
@-moz-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
@-ms-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
@-o-keyframes progress-bar-stripes {
  from {
    background-position: 0 0;
  }
  to {
    background-position: 40px 0;
  }
}
@keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
/*--Progress bars--*/
/********* profile details **********/
ul.dropdown-menu.drp-mnu i.fa {
    margin-right: 0.5em;
}
ul.dropdown-menu {
    padding: 0;
    min-width: 200px;
    top:101%;
}
.dropdown-menu > li > a {
    padding: 3px 15px;
	font-size: 1em;
}
.profile_details {
    float: right;
}
.profile_details_drop .fa.fa-angle-up{
	display:none;
}
.profile_details_drop.open .fa.fa-angle-up{
    display:block;
}
.profile_details_drop.open .fa.fa-angle-down{
	display:none;
}
.profile_details_drop a.dropdown-toggle {
    display:block;
	padding: 0.8em 3em 0 2em;
}
.profile_img span.prfil-img{
	float:left;
}
.user-name{
	 float:left;
	 margin-top:8px;
	 margin-left:11px;
	 height:35px;
}
.profile_details ul li{
	list-style-type:none;
	position:relative;
}
.profile_details li a i.fa.lnr {
    position: absolute;
    top: 34%;
    right: 8%;
    color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    font-size: 1.6em;
}
.profile_details ul li ul.dropdown-menu.drp-mnu {
    padding: 1em;
    min-width: 190px;
    top: 122%;
    left:0%;
}
ul.dropdown-menu.drp-mnu li {
    list-style-type: none;
    padding: 3px 0;
}
.user-name p{
	font-size:1em;
	color:<?= ViewConfig::getCorFundoPrimaria(); ?>;
	line-height:1em;
	font-weight:700;
}
.user-name span {
    font-size: .75em;
    font-style: italic;
    color: #424f63;
    font-weight: normal;
    margin-top: .3em;
}
/*---footer---*/
.footer {
    /*padding: 5em;*/
	bottom: 0px;
	width:auto;
	font-size: 14px;
    text-align:center;
	background-color:<?= ViewConfig::getCorFundoPrimaria(); ?>;
	position:fixed;
	color: #FFFFFF;
	
	/*box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.21);
	-webkit-box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.21);
	-moz-box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.21);
	-ms-box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.21);
	-o-box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.21);*/
}
.footer  p {
	/*color: #7A7676;*/
    font-size: 1em;
	line-height: 1.6em;
}
.footer  p a{
	color:#175d79;
}
.footer  p a:hover{
	text-decoration:underline;
}
/*---//footer---*/
/*---main-content-start---*/
.widget {
    width: 32%;
    border: 1px solid #F5F1F1;
    padding: 0px;
    box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
}
.widget.states-mdl {
    margin: 0 2%;
}
.stats-left {
    float: left;
    width: 70%;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	text-align: center;
	padding: 1em;
}
.states-mdl .stats-left {
    background-color: #585858;
}
.states-mdl .stats-right {
    background-color: rgba(88, 88, 88, 0.88);
}
.states-last .stats-left {
    background-color: #175d79;
}
.states-last .stats-right {
    background-color: rgba(233, 78, 2, 0.84);
}
.stats-right {
    float: right;
    width: 30%;
    text-align: center;
	padding: 1.54em 1em;
	background-color: rgba(79, 82, 186, 0.88);
}
.stats-left h5 {
    color: #fff;
    font-size: 1em;
}
.stats-left h4 {
    font-size: 2em;
    color: #fff;
    margin-top: 10px;
}
.stats-right label {
    font-size: 2em;
    color: #fff;
}
/*--charts--*/
.charts,.row {
    margin: 1em 0 0;
}
.charts-grids {
    background-color: #fff;
    padding:1em;
}
.charts-grids canvas.barCharts {
    width: 100% !important;
}
.charts canvas#line {
    width: 100% !important;
}
h4.title {
    font-size: 1.1em;
    color: #6b6b6b;
    margin: 0.5em 0 1em;
    text-transform: uppercase;
}
/*--//charts--*/
.widget-shadow {
    background-color: #fff;
    box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
	-webkit-box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
	-moz-box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
	 border: 3px solid #BFBFBF;
}
/*--statistics--*/
.stats-info.widget {
    padding: 1em;
    background-color: #fff;
}
.stats-info ul li {
    margin-bottom: 1em;
    border-bottom: 1px solid #EFE9E9;
    padding-bottom: 10px;
    font-size: 0.9em;
    color: #555;
}
.progress.progress-right {
    width: 25%;
    float: right;
    height: 8px;
    margin-bottom: 0;
}
.stats-info ul li.last {
    border-bottom: none;
    padding-bottom: 0;
    margin-bottom: 0.5em;
}
.stats-info span.pull-right {
    font-size: 0.7em;
    margin-left: 11px;
    line-height: 2em;
}
.stats-info.stats-last {
    padding: 1.15em 1em;
    width: 66%;
    margin-left: 2%;
}
.table.stats-table {
    margin-bottom: 0;
}
.stats-table span.label{
    font-weight: 500;
}
.stats-table h5 {
    color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    font-size: 0.9em;
}
.stats-table h5.down {
    color: #D81B60;
}
.stats-table h5 i.fa {
    font-size: 1.2em;
    font-weight: 800;
    margin-left: 3px;
}
.stats-table thead tr th {
    color: #555;
}
.stats-table td {
    font-size: 0.9em;
    color: #555;
    padding: 11px !important;
}
/*--//statistics--*/
/*--map--*/
.map {
    padding: 1em;
}
/*--//map--*/
/*--social-media--*/
.social-media {
    padding: 0;
    margin-left: 2%;
    width: 31.3%;
}
.wid-social {
    display: inline-block;
    width: 33.33%;
    padding: 15px;
    float: left;
	text-align: center;
}
.facebook {
  background-color:#3b5998 !important;
  color: #ffffff !important;
}
.icon-xlg {
    font-size: 30px;
}
.wid-social .social-info h3 {
	color: rgba(255, 255, 255, 0.91);
    font-weight: 800;
    font-size: 1.5em;
    margin: 0.3em 0;
}
.wid-social .social-info h4 {
    margin: 0;
    font-size: 0.8em;
    color: #fff;
    letter-spacing: 1px;
}
.twitter {
  background-color:#55acee !important;
  color: #ffffff !important;
}
.google-plus {
  background-color: #dc4e41 !important;
  color: #ffffff !important;
}
.dribbble {
  background-color:#ea4c89 !important;
  color: #ffffff !important;
}
.xing {
  background-color: #cfdc00 !important;
  color: #ffffff !important;
}
.vimeo {
  background-color: #162221 !important;
  color: #ffffff !important;
}
.yahoo {
  background-color: #410093 !important;
  color: #ffffff !important;
}
.flickr {
  background-color: #a4c639 !important;
  color: #ffffff !important;
}
.rss {
  background-color: #f26522 !important;
  color: #ffffff !important;
}
.wid-social.youtube {
    width: 100%;
	background-color: #cd201f !important;
	color: #ffffff !important;
}
.wid-social.youtube .icon-xlg {
    font-size: 38px;
}
.youtube .social-icon {
    display: inline-block;
    margin-right: 6em;
    vertical-align: super;
}
.youtube .social-info {
    display: inline-block;
}
.wid-social:hover .social-icon {
    transform: rotatey(360deg);
    transition: .5s all;
}
/*--//social-media--*/
/*--calender --*/
.calender {
    padding: 1em 1.5em 1.5em;
}
/*--//calender --*/
/*---//main-content---*/
/*-- media --*/
h3.title1 {
    font-size: 2em;
    color: #175d79;
    margin-bottom: 0.8em;
}
.bs-example5{
   background:#fff;
   padding:2em;
}
.media-heading {
  color: #000;
}
.sidebard-panel .feed-element, .media-body, .sidebard-panel p {
  font-size:0.85em;
  color:#999;
}
.example_6{
	margin:2em 0 0 0;
}
.demolayout {
  background:#175d79;
  width: 60px;
  overflow: hidden;
}
.padding-5 {
  padding: 5px;
}
.demobox {
  background:#f0f0f0;
  color: #333;
  font-size: 13px;
  text-align: center;
  line-height:30px;
  display: block;
}
.padding-l-5 {
  padding-left: 5px;
}
.padding-r-5 {
  padding-right: 5px;
}
.padding-t-5 {
  padding-top: 5px;
}
.padding-b-5 {
  padding-bottom: 5px;
}
code {
  background:rgb(246, 255, 252);
  padding: 2px 2px;
  color: #000;
}
.media_1-left {
    padding: 0;
    background-color: #fff;
    width: 49%;
}
.media_1-right {
    float: left;
    margin-left: 2%;
    width: 49%;
    padding: 0;
}
.media_1{
	margin:2em 0 0 0;
	padding-bottom: 1px;
}
.media_box{
	margin-bottom:2em;
}
.media_box1{
	margin-top:2em;
}
.media {
  margin-top:40px !important;
}
.media:first-child {
  margin-top: 0 !important;
  padding: 0 1px;
}
.panel_2{
	padding:2em 2em 0;
	background:#fff;
}
.panel_2 p{
	color:#555;
	font-size:0.85em;
	margin-bottom:1em;
}
td.head {
  color: #000 !important;
  font-size: 1.2em !important;
}
/*--Typography--*/
h3.hdg {
    font-size: 2em;
}
.show-grid [class^=col-] {
    background: #fff;
  text-align: center;
  margin-bottom: 10px;
  line-height: 2em;
  border: 10px solid #f0f0f0;
}
.show-grid [class*="col-"]:hover {
  background: #e0e0e0;
}
.xs h3, h3.m_1{
	color:#000;
	font-size:1.7em;
	font-weight:300;
	margin-bottom: 1em;
}
.grid_3 p{
  color: #999;
  font-size: 0.85em;
  margin-bottom: 1em;
  font-weight: 300;
}
.label {
  font-weight: 300 !important;
  border-radius:4px;
}  
.grid_3 {
    padding: 1.5em 1em;
}
.grid_5{
	margin-top: 2em;
}
.grid_5 h3, .grid_5 h2, .grid_5 h1, .grid_5 h4, .grid_5 h5, h3.hdg {
	margin-bottom:0.6em;
	color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
}
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
  z-index: 0;
}
.badge-primary {
  background-color: #03a9f4;
}
.badge-success {
  background-color: #8bc34a;
}
.badge-warning {
  background-color: #ffc107;
}
.badge-danger {
  background-color: #e51c23;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
  border-top: none;
  /*font-size:0.8em;*/
}
table .gridTable{
 	font-size:0.8em;
}
.grid_3 p{
  line-height: 2em;
  color: #888;
  font-size: 0.9em;
  margin-bottom: 1em;
  font-weight: 300;
}
.bs-docs-example {
  margin: 1em 0;
}
section#tables  p {
 margin-top: 1em;
}


@media (max-width:768px){
	.footer {
		position: absolute;	
	}

.grid_3 {
	margin-bottom: 0em;
}
.topHeader{
	padding: 1em 0 0 0;	
	font-size:18px;
	text-align:center;
	width:75%;
}
.topHeaderIndex{
	padding: 1em 0 0 0;	
	font-size:18px;
	text-align:center;	
}

.pageContent{
	margin: 3.5em 0 3.5 0;
}
button#showLeftPush {
    padding: 0.2em 0;
	font-size: 1.8em;
	width: 50px;
}
button#showLeftPushVoltarForm {
    padding: 0.5em 0;
	font-size: 1.5em;
	width: 50px;
}
button#showLeftPushVoltarModal {
    padding: 0;
	font-size: 1.5em;
	width: 40px;
}
}
@media (max-width:640px){

.logologin{
max-width:60%;	
}

button#showLeftPush {
padding: 0.25em 0;
font-size: 1.7em;
width: 50px;
}
button#showLeftPushVoltarForm {
padding: 0.4em 0;
font-size: 1.5em;
width: 50px;
}
button#showLeftPushVoltarModal {
padding: 0;
font-size: 1.5em;
width: 40px;
}
h1, .h1, h2, .h2, h3, .h3 {
	margin-top: 0px;
	margin-bottom: 0px;
}
.grid_5 h3, .grid_5 h2, .grid_5 h1, .grid_5 h4, .grid_5 h5, h3.hdg, h3.bars {
	margin-bottom: .5em;
}
.progress {
	height: 10px;
	margin-bottom: 10px;
}
ol.breadcrumb li,.grid_3 p,ul.list-group li,li.list-group-item1 {
	font-size: 14px;
}
.breadcrumb {
	margin-bottom: 10px;
}
.well {
	font-size: 14px;
	margin-bottom: 10px;
}
h2.typoh2 {
	font-size: 1.5em;
}
.grid_4 {
    margin-top: 30px;
}
.pageContent{
	margin: 3.5em 0 3.5em 0;
}

}
@media (max-width:480px){
button#showLeftPush {
	padding: 0.18em 0;
	font-size: 1.7em;
	width: 50px;
}
.topBar{
	padding:0.7em 0 0 1.5em;	
}
button#showLeftPushVoltarForm {
	padding: 0.4em 0;
	font-size: 1.5em;
	width: 50px;
}
button#showLeftPushVoltarModal {
	padding: 0;
	font-size: 1.5em;
	width: 40px;
}
.logologin{
	max-width:55%;	
}

.table h1 {
	font-size: 26px;
}
.table h2 {
	font-size: 23px;
}
.table h3 {
	font-size: 20px;
}
.alert,p {
	font-size: 14px;
}
.pagination {
	margin: 20px 0 0px;
}

.pageContent{
margin: 3em 0 3em 0;
}

}
@media (max-width: 325px){

button#showLeftPush {
	padding: 0.15em 0;
	font-size: 1.8em;
	width: 50px;
}
button#showLeftPushVoltarForm {
	padding: 0.15em 0;
	font-size: 1.8em;
	width: 50px;
}
button#showLeftPushVoltarModal {
	padding: 0.15em 0;
	font-size: 1.8em;
	width: 50px;
}
.grid_4 {
	margin-top: 18px;
}
h3.title {
	font-size: 1.6em;
}
.alert, p,ol.breadcrumb li, .grid_3 p,.well, ul.list-group li, li.list-group-item1,a.list-group-item {
	font-size: 13px;
}
.alert {
	padding: 10px;
	margin-bottom: 10px;
}
ul.pagination li a {
	font-size: 14px;
	padding: 5px 11px !important;
}
.list-group {
	margin-bottom: 10px;
}
.pageContent{
margin: 3em 0 2.5em 0;
}

}
/*--//Typography--*/
/*--table--*/
.tables h4 {
    font-size: 1.4em;
    margin-bottom: 1em;
    color: #777777;
}
.tables .panel-body ,.tables .bs-example{
    padding: 2em 2em 0.5em;
}
.tables .table > thead > tr > th, .tables .table > tbody > tr > th, .tables .table > tfoot > tr > th, .tables .table > thead > tr > td, .tables .table > tbody > tr > td, .tables .table > tfoot > tr > td {
    padding: 13px;
	border-top: 1px solid #E0E0E0;
}
.bs-example {
    margin-top: 2em;
}
.table-hover > tbody > tr:hover {
    background-color: #E8E6E6;
}
/*--//table--*/
/*--forms--*/
.forms h3.title1 {
    margin-bottom:0;
}
.forms h4 {
    font-size: 1.3em;
    color: #6F6F6F;
}
.form-title {
    padding: 1em 2em;
    background-color: #EAEAEA;
    border-bottom: 1px solid #D6D5D5;
}
.form-body {
    padding: 1.5em 2em;
}
.inline-form .form-group,.inline-form .checkbox, .form-two .form-group{
    margin-right: 1em;
}
.forms label {
    font-weight: 400;
}
.form-control {
    border-radius: inherit;
}
.help-block {
    margin-top: 10px;
}
.forms button.btn.btn-default {
    background-color: rgba(97, 100, 193, 0.85);
    color: #fff;
    padding: .5em 1.5em;
	border: none;
	outline:none;
	border-radius: inherit;
}
.inline-form.widget-shadow {
    margin-top: 2em;
}
.form-two {
    margin-top: 2em;
}
.form-three{
    margin-top:2em;
    padding: 2em;
}
/* --  general forms  -- */
.form-control1, .form-control_2.input-sm{
  border: 1px solid #ccc;
  padding: 5px 8px;
  color: #616161;
  background: #fff;
  box-shadow: none !important;
  width: 100%;
  font-size: 0.85em;
  font-weight: 300;
  height: 40px;
  border-radius: 0;
  -webkit-appearance: none;
  resize: none;
}
.general .tab-content {
    padding: 1.5em 0.5em 0;
}
.control3{
	margin:0 0 1em 0;
}
.btn-warning {
  color: #fff;
  background-color:rgb(6, 217, 149);
  border-color:rgb(6, 217, 149);
  padding:8.5px 12px;
}
.tag_01{
  margin-right:5px;
}
.tag_02{
  margin-right:3px;
}
.btn-warning:hover{
  background-color:rgb(3, 197, 135);
  border-color:rgb(3, 197, 135);
}
.btn-success:hover{
  border-color:#E74225 !important;
  background:#E74225 !important;
}
.control2{
  height:200px;
}
.bs-example4 {
  background: #fff;
  padding: 2em;
}
button.note-color-btn {
  width: 20px !important;
  height: 20px !important;
  border: none !important;
}

.show-grid [class^=col-] {
  background: #fff;
  text-align: center;
  margin-bottom: 10px;
  line-height: 2em;
  border: 10px solid #f0f0f0;
}
.show-grid [class*="col-"]:hover {
  background: #e0e0e0;
}
.xs h3, .widget_head{
	color:#000;
	font-size:1.7em;
	font-weight:300;
	margin-bottom: 1em;
}
.grid_3 p{
  color: #999;
  font-size: 0.85em;
  margin-bottom: 1em;
  font-weight: 300;
}
.input-icon.right > i, .input-icon.right .icon {
  right:12px;
  float: right;
}
.input-icon > i, .input-icon .icon {
  position: absolute;
  display: block;
  margin: 10px 8px;
  line-height: 14px;
  color: #999;
}
.form-group input#disabledinput {
	cursor: not-allowed;
}
/*--//forms--*/
/*--validation--*/
.validation-grids {
    padding: 0;
    width: 49%;
}
.validation-grids.validation-grids-right {
    margin-left: 2%;
}
.validation-grids .radio{
    display: inline-block;
    margin: 0.5em 2em 0 0;
}
.help-block {
    font-size: 0.8em;
    color: #6F6F6F;
    margin-left: .5em;
}
.validation-grids .btn-primary{
    background: #175d79 !important;
    color: #FFF;
    border: none;
    font-size: 0.9em;
    font-weight: 400;
    padding: .5em 1.2em;
    width: 100%;
    margin-top: 1.5em;
    outline: none;
    display:block;
    transition: 0.5s all;
    -webkit-transition: 0.5s all;
    -moz-transition: 0.5s all;
    -o-transition: 0.5s all;
    -ms-transition: 0.5s all;
	border-radius: inherit;
}
.validation-grids .btn-primary:hover{
	 background: rgba(79, 82, 186, 0.81) !important;
}
.bottom .btn-primary {
    margin: 0;
}
.bottom .form-group {
    margin-bottom: 0;
}
/*--//validation--*/
/*--grids--*/
.grids {
    padding: 2em 1em;
	margin-bottom: 2em;
}
.grids .form-group {
    margin: 0;
}
.grid-bottom{
    padding: 2em;
}
.grid-bottom .table{
	margin:0;
}
/*--//grids--*/
/*--blank-page--*/
.blank-page{
    padding: 2em;
}
.blank-page p {
    font-size: 1em;
    color: #555;
    line-height: 1.8em;
}
/*--//blank-page--*/
/*--login-page--*/
.FlexContainer {
            align-items: center;
            background: none;
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
            width: 100vw;
}
        ​
.FlexItem {
            box-sizing: border-box; /* 2 */
            max-width: 100%; /* 1 */
            padding: 1em;
}
		
.login-page {
    width: 50%;
    margin: 0 auto 0;
	max-width: 500px;
}
.login-page h3.title1 {
    text-align: center;
    margin-bottom: 1em;
}
.login-top {
    padding: 1.5em;
    border-bottom: 1px solid #DED9D9;
    text-align: center;
}
.login-body {
	padding: 0em;
	max-width: 500px;
}
.login-top  h4 {
    font-size: 1.1em;
    color: #555;
    line-height: 1.8em;
}
.login-top  h4  a {
    color: #175d79;
}
.login-top  h4  a:hover{
    color: #555;
}
/*
.login-page input[type="text"], .login-page input[type="password"] {
    font-size: 0.9em;
    padding: 10px 15px 10px 37px;
    width: 100%;
    color: #313131;
    outline: none;
    border: none;
    background-color: #FFFFFF;	
    margin: 0em 0em 1.5em 0em;
}
*/

.login-page input[type="text"], .login-page input[type="password"]{
	height: 45px;	
	border-radius: 3px;
	font-weight: bold;
}

.login-page label.checkbox {
    margin: 0 0 0 1.3em;
    font-size: 1em;
    color: #555;
    font-weight: 400;
    display: inline-block;
    float: left;
}
.login-page label.checkbox {
    margin-left: 1.3em;
}
.login-page label.checkbox {
    margin-left: 1.3em;
    font-size: 1em;
    color: #555;
    font-weight: 400;
    display: inline-block;
	cursor: pointer;
}
.forgot-grid {
    margin-top: 1.2em;
}
.forgot {
    float: right;
}
.forgot a {
    font-size: 1em;
    color: #555;
    display:block;
}
.forgot a:hover{
    color: #175d79;
}
.login-page input[type="submit"], a.botaoVoltar {
    border: none;
    outline: none;
    cursor: pointer;
    color: #fff;
    background: #175d79;
	font-weight: bold;
    width: 100%;
    padding: 0.7em 1em;
    font-size: 1em;
    margin: 1em 0 0;
	border-radius: 3px;
}
.login-page input[type="submit"]:hover, a.botaoVoltar:hover{
    background: #0D3949;
	border-radius: 3px;
	box-shadow: 0px 0px 3px 1px #175d79;
}

a.botaoVoltar {
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    color: #fff;
    background: #175d79;
    font-weight: bold;
    width: 100%;
    padding: 0.7em 1em;
    font-size: 1em;
    margin: 1em 0 0;
    border-radius: 3px;
    text-align: center;    
}

a.botaoCadastrar {
    border: none;
    outline: none;
    cursor: pointer;
    color: #fff;
    background: #175d79;
    font-weight: bold;
    width: 100%;
    padding: 0.7em 1em;
    font-size: 1em;
    margin: 1em 0 0;
    border-radius: 3px;
    float: left;
    text-align: center;
}

a.botaoCadastrar:hover {
    background: #0D3949;
    border-radius: 3px;
    box-shadow: 0px 0px 3px 1px #175d79;
}

.login-page-bottom {
    text-align: center;
}
.social-btn {
    display: inline-block;
    background: #3B5998;
    transition: all 0.5s ease-out;
    -webkit-transition: all 0.5s ease-out;
    -moz-transition: all 0.5s ease-out;
    -ms-transition: all 0.5s ease-out;
    -o-transition: all 0.5s ease-out;
}
.social-btn i {
    color: #fff;
    padding: .8em 1.3em;
    font-size: 0.9em;
	vertical-align: middle;
}
.social-btn i.fa {
    background-color: #354F88;
    padding: .6em 1em;
    font-size: 1.1em;
	transition:.5s all;
	-webkit-transition:.5s all;
	-moz-transition:.5s all;
}
.social-btn:hover {
	background:#354F88;
}
.social-btn.sb-two {
    background-color: #45B0E3;
	margin-left: 2em;
}
.social-btn i.fa.fa-twitter {
    background-color: #40A2D1;
}
.social-btn.sb-two:hover{
    background-color: #40A2D1;
}
.login-page-bottom h5 {
    font-size: 1.5em;
    color: #524C4F;
    font-weight: 800;
    margin: 1em 0;
}
.social-btn:hover i.fa {
    transform: rotateY(360deg);
	-moz-transform: rotateY(360deg);
	-webkit-transform: rotateY(360deg);
	-o-transform: rotateY(360deg);
	-ms-transform: rotateY(360deg);
}
/*--//login-page--*/
/*-- sign-up --*/
.signup-page h3.title1 {
    margin-bottom: 0.4em;
	text-align: center;
}
p.creating {
    text-align: center;
}
.sign-up-row {
    padding: 2em;
    width: 70%;
    margin: 2em auto;
}
.sign-up1{
	float:left;
}
.sign-up1 h4 {
    color: #555;
    margin: 1.6em 0 1em;
    font-size: 1em;
}
.sign-up2{
	float:right;
	width:78%;
}
.sign-up2 label {
    font-weight: 400;
    margin: 1.6em 2em 1em 0;
}
.sign-up2 input[type="text"],.sign-up2 input[type="password"]{
	outline:none;
	border: 1px solid #D0D0D0;
    background: none;
    font-size: 14px;
	padding:10px 10px;
	width:100%;
	margin:1em 0;
}
.sign-up2 input[type="text"]:focus ,.sign-up2 input[type="password"]:focus{
    border-color: #175d79;
}
.signup-page h5,.signup-page h6{
	margin: 0 0 1em;
    color:#175d79;
    font-size: 1.1em;
}
.signup-page h6{
	margin:1em 0 !important;
}
.sub-login-left{
	float:left;
	width:30%;
}
.sub-login-right{
	float:right;
}
.sub-login{
	margin:5em 0 0;
}
.signup-page p{
    font-size: 1em;
    color: #555;
}
.sub-login-right p a {
    color: #a88add;
    padding-left: 8px;
}
.sub-login-right p a:hover{
	color:#fff;
}
.sub_home  input[type="submit"] {
    border: none;
    outline: none;
    cursor: pointer;
    color: #fff;
    background: #175d79;
    width: 23%;
    padding: .5em 1em;
    font-size: 1em;
    margin: 0.5em 0 0 11em;
}
.sub_home input[type="submit"]:hover {
    background-color: #175d79;
}
.signup-page .radios {
    margin-top: 1.5em;
}
.signup-page label.label_radio {
    margin-right: 2em;
    color: #7D7878;
    font-size: 1em;
}
/*-- //sign-up --*/
/*-- charts-page--*/
.chrt-page-grids {
    width: 98%;
	left:1%;
	right:1%;
	height:100%;
   /* border: 1px solid #F5F1F1;
    padding: 1em;
    box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
	-webkit-box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
	-moz-box-shadow: 0 -1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);*/
    background-color: #fff;
}
.fullscreen{
    z-index: 99999999999; 
    width: 100%; 
    height: 100%; 
    position: fixed; 
    top: 0; 
    left: 0; 
 }
.chrt-page-grids p{
	font-size: 44px;	
	text-align: center;
	padding:0.1em;
}
.chrt-page-grids span{
	font-size: 10px;	
	text-align: center;
	padding: 0;
}
.chrt-page-grids label{
	font-size: 16px;	
	text-align: center;
	padding: 1em;
	text-decoration:none;
	text-transform:none;
	color: #626262;
}
.chrt-page-grids a i{
	font-size: 17px;
	font-weight: lighter;	
	float:right;
	color:#6F6F6F;
	/*padding: 0.1em 0 0 0.4em;*/
	margin: 0 30px 0 -14px;
}
.chrt-page-grids.chrt-right {
    margin-left: 2%;
}
.doughnut-grid ,.polar-area,.pie-grid{
    width: 74%;
    margin: 2.2em auto;
}
.polar-area {
    margin: 2.9em auto 1em;
}
.pie-grid{
    margin: 2.8em auto 1em;
}
.radar-grid {
    width: 85%;
    margin: 0 auto;
}
.chrt-page-grids  canvas.barCharts {
    width: 100% !important;
}
/*--//charts-page--*/
/*--general elements--*/
.panel-info.widget-shadow {
    padding: 2em 1em;
}
.panel {
    border-radius: inherit;
}
.general h4.title2{
    font-size: 1.4em;
    margin: 0 0 1em 1em;
    color: #777777;
}
.modals{
    margin-top: 2em;
    padding: 2em 1em;
}
.modal .row {
    margin: 1em 0 0;
}
h4.modal-title {
    margin: 0;
}
.modal-grids button.btn.btn-primary {
    background-color: #175d79;
    font-size: 1em;
    color: #fff;   
	border-color: #175d79;
	outline:none;
	border-radius: 3px;
}
.general-grids {
    padding: 2em 1.5em;
    width: 49%;
}
.general-grids.grids-right {
    margin-left: 2%;
}
/*--ScrollSpy --*/
.scrollspy-example {
    position: relative;
    height: 200px;
    margin-top: 10px;
    overflow: auto;
    padding-right: 20px;
}
.scrollspy-example h4 {
    font-size: 1.2em;
    color: #175d79;
    margin-bottom: .5em;
}
.scrollspy-example p {
    font-size: 0.9em;
    color: #555;
    line-height: 1.8em;
    margin-bottom: 2em;
}
.general-grids ul.dropdown-menu{
    padding: 0.5em;
}
.general-grids h4.title2 ,.tool-tips h4.title2{
    margin: 0 0 1em;
}
/*--tabs --*/
.nav-tabs {
    border-bottom: 1px solid <?= ViewConfig::getCorFundoPrimaria(); ?>;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    border: 1px solid <?= ViewConfig::getCorFundoPrimaria(); ?>;
	border-bottom-color: transparent;
}
.tab-content p {
    /*font-size: 0.9em;*/
    color: #555;
    line-height: 1.8em;
}
/*--tool-tips--*/
.tool-tips.widget-shadow {
    padding: 2em;
    margin-top: 2em;
}
.bs-example-tooltips {
    margin-bottom: 1em;
	text-align: center;
}
.bs-example-tooltips .btn-default {
    margin-right: 1em;
}
.collps-grids{
    width: 49%;
}
/*--//general elements--*/
/*--inbox--*/
.inbox-page {
    width: 80%;
    margin: 0 auto;
}
.inbox-row {
	padding: 0.5em 1em;
}
.inbox-page h4 {
    font-size: 1.2em;
    color: #A2A0A0;
    margin-bottom: 1em;
}
.mail {
    float: left;
    margin-right: 1em;
}
.mail.mail-name {
    width: 27%;
}
.mail-right {
    float: right;
    margin-left: 1.5em;
}
.inbox-page h6 {
    font-size: 1em;
    color: #555;
}
.inbox-page input.checkbox {
    margin: 13px 0 0;
}
.inbox-page img {
    width: 100%;
    vertical-align: bottom;
}
.inbox-page p {
    font-size: 1em;
    color: #000;
    line-height: 2em;
}
.inbox-page h6 {
    font-size: 1em;
    color: #555;
    line-height: 2em;
}
.inbox-page ul.dropdown-menu {
    padding: 5px 0;
    min-width: 105px;
    top: 0;
    left: -110px;
}
.inbox-page .dropdown-menu > li > a {
    padding: 4px 15px;
    font-size: 0.9em;
}
.inbox-page .dropdown-menu > li > a:hover, .inbox-page .dropdown-menu > li > a:focus {
    color: #175d79;
}
.mail-icon {
    margin-right: 7px;
}
.inbox-page.row {
    margin-top: 2em;
}
.inbox-page .checkbox {
    position: relative;
    top: -3px;
    margin: 0 1rem 0 0;
    cursor: pointer;
}
.inbox-page .checkbox:before {
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    content: "";
    position: absolute;
    left: 0;
    z-index: 1;
    width: 15px;
    height: 15px;
    border: 1px solid #A0A0A0;
}
.inbox-page .checkbox:after {
    content: "";
    position: absolute;
    top: -0.125rem;
    left: 0;
    width: 1.1rem;
    height: 1.1rem;
    background: #fff;
    cursor: pointer;
}
.inbox-page .checkbox:checked:before {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
    height: .4rem;
    width: .8rem;
    border-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    border-top-style: none;
    border-right-style: none;
    border-width: 2px;
}
.mail-body {
    padding: 1em 2em;
    border: 1px solid #D4D4D4;
    margin: 10px 0;
    transition: .5s all;
}
.mail-body p{
    font-size: 0.9em;
    line-height: 1.8em;
}
.mail-body input[type="text"]{
    width: 100%;
    border: none;
    border-bottom: 1px solid #F5F5F5;
    padding: 1em 0;
	outline:none;
	transition:.5s all;
	-webkit-transition:.5s all;
	-moz-transition:.5s all;
	font-size:1em;
}
.mail-body input[type="text"]:focus{
	padding: 2em 0;
	border-bottom: 1px solid #C7C5C5;
}
.mail-body input[type="submit"] {
    border: none;
    background: none;
    font-size: 1em;
    margin-top: 0.5em;
    color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
	font-weight: 600;
}
/*--//inbox--*/
/*--compose mail--*/
.compose-left{
    width: 28%;
	padding: 0;
}
.compose-right{
    width: 70%;
    margin-left: 2%;
	padding: 0;
}
.compose-left a i.fa {
    margin-right: 0.7em;
}
.compose-left ul li{
	display:block;
}
.compose-left ul li.head {
    padding: 0.5em 1.5em;
    border-bottom: 1px solid #DCDCDC;
    color: #000;
    font-size: 1.2em;
    background-color: #F5F5F5;
}
.compose-left ul li a {
    display: block;
    font-size: 1em;
    color: #555;
    border-bottom: 1px solid #DCDCDC;
    padding: 0.7em 1.5em;
}
.compose-left ul li a:hover {
    background-color: rgb(241, 241, 241);
}
.compose-left span {
    float: right;
    background-color: rgba(233, 78, 2, 0.73);
    padding: 3px 10px;
    font-size: .7em;
    border-radius: 4px;
    color: #fff;
}
.chat-left {
    position: relative;
    float: left;
    width: 25%;
}
.chat-right {
    float: left;
}
.small-badge {
    position: absolute;
    left: 27px;
    top: 1px;
    overflow: hidden;
    width: 12px;
    height: 12px;
    padding: 0;
    border: 2px solid #fff!important;
    border-radius: 20px;
    background-color: red;
}
.small-badge.bg-green {
    background-color: green;
}
.chat-grid.widget-shadow {
    margin-top: 2em;
}
.chat-right p {
    font-size: 1em;
    color: #000;
	line-height: 1.2em;
}
.chat-right h6 {
    font-size: 0.8em;
    color: #999;
    line-height: 1.4em;
}
.compose-right .panel-heading {
    padding: 0.8em 2em;
}
.compose-right .panel-body {
    padding: 2em;
}
.compose-right .alert.alert-info {
    padding: 10px 20px;
    font-size: 0.9em;
    color: #175d79;
	background-color: rgba(212, 213, 243, 0.98);
    border-color: rgba(151, 153, 230, 0.41);
	border-radius: inherit;
}
.compose-right .form-group {
    margin: .5em 0;
}
.compose-right .btn.btn-file {
    position: relative;
    overflow: hidden;
	border-radius: inherit;
}
.compose-right .btn.btn-file>input[type='file'] {
    position: absolute;
    top: 0;
    right: 0;
    opacity: 0;
    filter: alpha(opacity=0);
    outline: none;
    background: white;
    cursor: inherit;
    display: inline-flex;
    width: 100%;
    padding: 0.4em;
}
.compose-right p.help-block {
    display: inline-block;
    margin-left: 0.5em;
    font-size: 0.9em;
    color: #6F6F6F;
}
.compose-right input[type="submit"] {
    font-size: 0.9em;
    background-color: #175d79;
    border: 1px solid <?= ViewConfig::getCorFundoPrimaria(); ?>;
    color: #fff;
    padding: 0.4em 1em;
    margin-top: 1em;
}
/*--//compose mail--*/
/*--widgets-page--*/
/*--profile--*/
.profile{
    padding: 0;
	width: 32%;
}
.profile-top {
    background-color: #175d79;
    text-align: center;
	padding: 1.5em;
}
.profile-top img {
    vertical-align: middle;
    border: 4px solid #175d79;
    border-radius: 63%;
}
.profile-top h4 {
    font-size: 1.1em;
    color: #fff;
    margin: .5em 0;
}
.profile-top h5 {
    font-size: 0.9em;
    color: rgba(255, 255, 255, 0.59);
}
h4.title3 {
    padding: 1em;
    background-color: rgb(79, 82, 186);
    color: rgba(206, 207, 243, 0.9);
}
.profile-text {
    padding: 1.5em 3em;
}
.profile-row.row-middle {
    margin: 1em 0;
}
.profile-left {
    float: left;
    width: 15%;
}
.profile-right {
    float: left;
    width: 85%;
}
.row-middle .profile-right {
    border-top: 1px dotted #175d79;
    border-bottom: 1px dotted #175d79;
    padding: 1em 0;
}
.profile-row .profile-icon {
    font-size: 1.4em;
	margin-top: 0.6em;
	color: #6F6F6F;
}
i.fa.fa-mobile.profile-icon {
    font-size: 2em;
}
i.fa.fa-facebook.profile-icon {
    font-size: 1.6em;
    margin-top: .3em;
}
.profile-right h4 {
    font-size: 1em;
    color: #504E4E;
    font-weight: 500;
}
.profile-right p {
    font-size: .9em;
    color: #999;
    margin-top: .4em;
}
.profile-btm ul {
    background-color: #e4e4e4;
}
.profile-btm ul li {
    display: inline-block;
    width: 32.5%;
    text-align: center;
    padding: 1.35em 0;
}
.profile-btm ul li:nth-child(2) {
    border-left: 1px solid #CACACA;
    border-right: 1px solid #CACACA;
}
.profile-btm ul li h4 {
    font-size: 1.3em;
    color: #175d79;
    font-weight: 900;
}
.profile-btm ul li h5 {
    font-size: 0.9em;
    color: #6F6F6F;
    margin-top: 0.3em;
}
/*--//profile--*/
/*--chat--*/
.chat-mdl-grid {
    margin: 0 2%;
}
.activity-img1 {
    width: 64%;
    padding: 0;
}
.scrollbar {
    height: 462px;
    background: #fff;
    overflow-y: scroll;
    padding:2em 1em 0;
}
.activity-row {
    margin-bottom: 1em;
    padding-bottom: 1.02em;
}
.activity-desc-sub, .activity-desc-sub1 {
    padding: .7em;
    background: #E7E7E7;
    position: relative;
}
.activity-desc-sub1:after {
    right: -6%;
    top: 20%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-color: rgba(213, 242, 239, 0);
    border-left-color: #E7E7E7;
    border-width: 8px;
    margin-top: -5px;
}
.activity-desc-sub:before {
    left: -8%;
    top: 20%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-color: rgba(213, 242, 239, 0);
    border-right-color: #E7E7E7;
    border-width: 9px;
    margin-top: -5px;
}
.activity-row p {
    font-size: 0.9em;
    color: #555;
    margin-bottom: .3em;
}
.activity-row span {
    font-size: .7em;
    color: #ADADAD;
}
.activity-row span.right {
    text-align: right;
    display: block;
}
.chat-bottom {
    padding: 1em;
}
.chat-bottom input[type="text"] {
    width: 100%;
    border: none;
    border-bottom: 1px solid #D4CFCF;
    padding: 0.6em 1em;
    outline: none;
    transition: .5s all;
    -webkit-transition: .5s all;
    -moz-transition: .5s all;
    box-shadow: 0px -1px 2px #CECECE;
	-webkit-box-shadow: 0px -1px 2px #CECECE;
	-moz-box-shadow: 0px -1px 2px #CECECE;
}
/*--//chat--*/
/*--todo--*/
.single-bottom ul li {
    list-style: none;
    padding: 0px 10px 18px;
}
.single-bottom ul li input[type="checkbox"] {
    display: none;
}
.single-bottom ul li input[type="checkbox"]+label {
    position: relative;
    padding-left: 2em;
    border: none;
    outline: none;
    font-size: 0.9em;
    color: #999;
    font-weight: 400;
	cursor: pointer;
}
.single-bottom ul li input[type="checkbox"]+label span:first-child {
    width: 17px;
    height: 17px;
    display: inline-block;
    border: 2px solid #C8C8C8;
    position: absolute;
    left: 0;
	top: 2px;
}
.single-bottom ul li input[type="checkbox"]:checked+label span:first-child:before {
    content: "";
    background: url(../images/tick.png)no-repeat;
    position: absolute;
    left: 1px;
    top: 2px;
    font-size: 10px;
    width: 10px;
    height: 10px;
}
/*--//todo--*/
/*--weather--*/
.weather-grids {
    padding: 0;
    width: 49%;
}
.header-top {
    border-bottom: 3px solid rgba(97, 100, 193, 0.56);
    padding: 1.5em;
    background-color: rgba(97, 100, 193, 0.71);
}
.header-top h2 {
    float: left;
    margin: .1em 0 0 .5em;
    color: #FFFFFF;
    font-size: 1.3em;
}
.header-top ul {
    float: right;
    border: 1px solid #FFFFFF;
    border-radius: 5px;
}
.header-top li{
	display: inline-block;
	float: left;
}
.header-top li p{
	color:#fff;
	font-size: 1em;
	padding: 4px 6px;
}
.header-top li p.cen {
    background: #FFFFFF;
    color: #175d79;
    border-radius: 0 3px 3px 0;
}
.whe {
    vertical-align: bottom;
    margin-right: 0.5em;
}
/*----*/
.weather-grids canvas {
    display: block;
    margin: 0 auto;
}
.weather-grids canvas#clear-day {
    width: 30px;
    float: left;
}
.header-bottom1 {
    float: left;
    width: 25%;  
}
.header-head{
	padding: 2em;
	text-align:center;
}
.header-bottom2 {
  background: #f1f1f1;  
}
.header-bottom1:nth-child(3) {
    border-right: none;
}
.header-head h4 {
    color: #175d79;
    font-size: 1.1em;
    margin-bottom: 1em;
}
.header-head h6 {
    color: #000;
    font-size: 1.5em;
    font-weight: bold;
    margin: 0.5em 0;
}
.bottom-head p{
	color:#8C8B8B;
	font-size: 1em;
	line-height: 1.4em;
}
/*--//weather--*/
/*--circle-charts--*/
.weather-grids.weather-right {
    margin-left: 2%;
    text-align: center;
}
.weather-grids.weather-right h3 {
    font-size: 1.2em;
    color: #fff;
    text-align: left;
}
.circle-charts {
    padding: 3em 2em;
}
.weather-right ul li {
    display: inline-block;
}
.weather-right ul li:nth-child(2){
    margin:0 2em;
}
.weather-right ul li  p {
    font-size: 1em;
    color: #555;
    margin-top: 1em;
}
/*--//circle-charts--*/
.widget_1_box {
    width: 32%;
    padding: 0;
}
.widget_1_box.widget-mdl-grid{
    margin: 0 2%;
}
.widget_1_box.widget-mdl-grid2{
    margin-right: 2%;
}
.tile-progress{
	padding: 2em 3em;
	text-align:center;
}
.widget_1_box .bg-info {
    background-color: #175d79;
}
.widget_1_box .bg-success {
    background-color: #175d79;
}
.widget_1_box  .bg-danger {
    background-color: rgba(233, 78, 2, 0.88);
}
.tile-progress h4 {
    color: #fff;
    font-size: 1.2em;
}
.tile-progress span {
    color: rgba(255, 255, 255, 0.67);
    font-size: 1em;
}
.widget_1_box .progress {
    background: rgba(50, 50, 58, 0.5);
    margin: 1em 0;
}
.widget_1_box .progress-striped .blue {
    background: rgba(242, 179, 63, 0.78);
}
.widget_1_box .progress-striped .yellow {
    background: #EB621F;
}
.widget_1_box .progress-striped .orange {
    background: #175d79;
}
.widget_1_box .progress-striped .bar {
    background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    -webkit-background-size: 40px 40px;
    -moz-background-size: 40px 40px;
    -o-background-size: 40px 40px;
    background-size: 40px 40px;
}
/*--//widgets-page--*/
/*---- responsive-design -----*/
@media(max-width:1440px){
.chrt-page-grids p{
	font-size: 40px;	
	text-align: center;
	padding:0.1em;
}
.login-page {
    width: 43%;
}
.general .tab-content {
    padding: 1em 0.5em 0;
}
.activity-desc-sub:before {
    left: -9%;
}
.activity-desc-sub1:after {
    right: -8.5%;
}
.doughnut-grid {
    width: 81%;
	margin: 2.5em auto 1.6em;
}
/*.chrt-page-grids canvas#line {
    height: 310px !important;
}
.chrt-page-grids canvas.barCharts {
    height: 292px !important;
}*/
.navbar-collapse.bs-example-js-navbar-scrollspy {
    padding: 0;
}
.navbar-collapse.bs-example-js-navbar-scrollspy .nav > li > a {
    padding: 8px 10px;
}
.general-grids .tab-content {
    overflow-y: scroll;
    height: 228px;
}
.sub_home input[type="submit"] {
    margin: 0.5em 0 0 9.2em;
}
}
@media(max-width:1366px){
.chrt-page-grids p{
	font-size: 40px;	
	text-align: center;
	padding:0.1em;
}
.navbar-collapse.bs-example-js-navbar-scrollspy .nav > li > a {
    padding: 15px 11px;
}
.weather-right ul li:nth-child(2) {
    margin: 0 1em;
}
.activity-desc-sub1:after {
    right: -9%;
}
.activity-desc-sub:before {
    left: -10%;
}
.login-page {
    width: 46%;
}
.doughnut-grid {
    margin: 3.6em auto 1.6em;
}
.pie-grid {
    margin: 4.1em auto 1em;
}
.polar-area {
    margin: 2.8em auto 0.6em;
}
#navbar-example2 .navbar-brand {
    font-size: 16px;
}
.navbar-collapse.bs-example-js-navbar-scrollspy .nav > li > a {
    padding: 15px 8px;
    font-size: 0.9em;
}
}
@media(max-width:1280px){

.profile-text {
    padding: 1.5em 2em;
}
.profile-btm ul li {
    width: 32.4%;
}
.activity-img1 {
    width: 75%;
}
.activity-img2 {
    padding: 0;
}
.activity-right .activity-img {
    padding-left: 0;
}
.activity-left .activity-img {
    padding-right: 0;
}
.activity-desc-sub:before {
    left: -9.4%;
}
.activity-desc-sub1:after {
    right: -8.5%;
}
.weather-right ul li:nth-child(2) {
    margin: 0 0.3em;
}
.sign-up2 {
    width: 75%;
}
.tile-progress {
    padding: 2em 2em;
}
.login-page {
    width: 52%;
}
.sub_home input[type="submit"] {
    margin: 0.5em 0 0 9em;
}
.chrt-page-grids canvas#line {
    height: 282px !important;
}
.chrt-page-grids canvas.barCharts {
    height: 265px !important;
}

.topHeader{
	padding: 1em 0 0 0;	
	font-size:21px;
	font-weight: normal !important;
	margin:0 auto;	
	width:300px;
	text-align:center;
}
.topHeaderIndex{
	padding: 1em 0 0 0;	
	font-size:21px;
	text-align:center;	
}

.botaoTop {
    font-size: 1.4em;
    width: 40px;
	max-height: 48px;
    padding: 0.6em 0;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

}
@media(max-width:1080px){
.chrt-page-grids p{
	font-size: 27px;	
	text-align: center;
	padding:0.1em;
}
.logo a {
    padding: 0.9em 2.35em .7em;
}
.header-left {
    width: 52%;
}
.cbp-spmenu-vertical {
    /*width: 280px;*/
}
.cbp-spmenu-push div#page-wrapper {
    margin:0 0 0 17.4em;
	/*padding: 2em 10px;*/
}
.sidebar ul li {
    margin-bottom: 0.8em;
}
.wid-social .social-info h3 {
    font-size: 1.1em;
}
.stats-info ul li {
    padding-bottom: 9px;
}
.youtube .social-icon {
    margin-right: 4em;
}
h3.title1 {
    font-size: 1.8em;
}
.general-grids {
    width: 100%;
}
.general-grids.grids-right {
    margin: 2em 0 0;
}
#navbar-example2 .navbar-brand {
    font-size: 18px;
}
.navbar-collapse.bs-example-js-navbar-scrollspy .nav > li > a {
    padding: 15px 20px;
    font-size: 1em;
}
.header-head {
    padding: 2em 1em;
}
.profile-text {
    padding: 1.5em 1.2em;
}
div#vmap {
    height: 311px !important;
}
.profile-btm ul li {
    width: 32.2%;
}
.wid-social {
    width: 33.33%;
    padding: 16px 8px;
}
.wid-social .social-info h4 {
    font-size: 0.7em;
    letter-spacing: 0.5px;
}
.inbox-page {
    width: 96%;
}
.sign-up-row {
    width: 78%;
}
.weather-grids {
    width: 100%;
}
.weather-grids.weather-right {
    margin: 2em 0 0;
}
.weather-right ul li:nth-child(2) {
    margin: 0 3em;
}
.scrollbar {
    padding: 1.5em 1em 0;
}
.activity-row p {
    font-size: 0.8em;
}
.activity-row {
    margin-bottom: 0;
    padding-bottom: 1em;
}
.activity-desc-sub:before {
    left: -12%;
    top: 17%;
}
.activity-desc-sub1:after {
    right: -10.5%;
}
.sign-up2 {
    width: 72%;
}
.single-bottom ul li {
    padding: 0px 0px 18px;
}
.inbox-page {
    width: 100%;
}
.compose-left ul li a {
    padding: 0.7em 1em;
}
.login-page {
    width: 63%;
}
.chrt-page-grids canvas#line {
    height: 237px !important;
}
.polar-area {
    margin: 2em auto 0em;
    width: 80%;
}
.chrt-page-grids canvas.barCharts {
    height: 223px !important;
}
.charts, .row {
    margin: 1em 0 0;
}

}
@media(max-width:1024px){
.panel_2 {
    padding: 1.5em 1em 0;
}
.doughnut-grid {
    width: 87%;
}
}
@media(max-width:991px){
.chrt-page-grids p{
	font-size: 20px;	
	text-align: center;
	padding:0.1em;
}
.search-box {
    margin: 1.2em 0 0 2em;
}
.widget {
    float: left;
}
.stats-info.widget {
    width: 36%;
}
.stats-info.stats-last {
    width: 62%;
    float: left;
}
.map {
    float: left;
    width: 60%;
}
.social-media {
    width: 38%;
    float: left;
}
.grid_box1 {
    margin-bottom: 1em;
}
.example_6, .media_1 {
    margin: 1.5em 0 0 0;
}
.media_1-left {
    width: 100%;
}
.media_1-right {
    float: none;
    margin: 0;
    width: 100%;
}
.panel_2 {
    padding: 1.5em 1em;
}
.panel_2.panel_3 {
    margin-top: 1.5em;
}
.panel_2 .table {
    margin-bottom: 0;
}
.modal-grids {
    float: left;
    width: 33%;
    text-align: center;
}
.modal-grids:nth-child(4) {
    margin-top: 0.2em;
}
.bs-example-tooltips {
    text-align: left;
}
.modals {
    margin-top: 1.5em;
}
.tool-tips.widget-shadow {
    margin-top: 1.5em;
}
h3.title1 {
    font-size: 1.6em;
}
.profile {
    width: 100%;
}
.chat-mdl-grid {
    margin: 1.5em 0;
}
.profile-text {
    padding: 1.5em 5em;
}
.scrollbar {
    padding: 1.5em 3em 0;
}
.activity-desc-sub:before {
    left: -3.8%;
    top: 29%;
}
.activity-desc-sub, .activity-desc-sub1 {
    padding: .7em 1em;
}
.activity-desc-sub1:after {
    right: -3.5%;
    top: 36%;
}
.activity-row .col-xs-3 {
    width: 15%;
}
.activity-img1,.activity-img2 {
    width: 85%;
}
.activity-left .activity-img img {
    margin: 0 0 0 auto;
}
.mail.mail-name {
    width: 20%;
}
.mail-right {
    margin-left: 0.8em;
}
.inbox-page h6 {
    font-size: 0.9em;
}
.inbox-page p {
    font-size: 0.9em;
}
.compose-left {
    width: 35%;
    float: left;
}
.compose-right {
    width: 62%;
    float: right;
}
.inline-form .form-group, .inline-form .checkbox, .form-two .form-group {
    margin-right: 0.5em;
}
.form-three {
    margin-top: 1em;
}
.validation-grids {
    width: 100%;
}
.validation-grids.validation-grids-right {
    margin: 1.5em 0 0;
}
.inline-form.widget-shadow {
    margin-top: 1.5em;
}
.login-page {
    width: 70%;
}
.sign-up-row {
    width: 90%;
}
.sign-up2 {
    width: 71%;
}
.chrt-page-grids {
    width: 100%;
   /* padding: 1.5em 2em;*/
}
.chrt-page-grids.chrt-right {
    /*margin: 1.5em 0 0;*/
}
.doughnut-grid {
    width: 65%;
	margin: 2em auto 0.5em;
}
.radar-grid {
    width: 70%;
}
.polar-area, .pie-grid {
    width: 60%;
    margin: 1.5em auto 0;
}

.topHeader{
	padding: 1.2em 0 0 0;	
	font-size:20px;
	font-weight: normal !important;
	margin:0 auto;	
	width:260px;
	text-align:center;
}
.topHeaderIndex{
	padding: 1.2em 0 0 0;	
	font-size:20px;
	text-align:center;	
}

.botaoTop {
    font-size: 1.5em;
    width: 40px;
    padding: 0.6em 0;
	max-height: 48px;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

}
@media(max-width:900px){
.logo a {
    padding: 0.95em 1.95em .7em;
}
.logo a span {
    letter-spacing: 5px;
}
.search-box {
    width: 39%;
}
li.dropdown.head-dpdn a.dropdown-toggle {
    padding: 1.7em 1.5em;
}
.profile_details_drop a.dropdown-toggle {
    padding: 0.8em 2em 0 1em;
}
.profile_details ul li ul.dropdown-menu.drp-mnu {
    padding: 0.5em;
    min-width: 163px;
}


/*
.botaoTop {
    width: 65px;
}
*/
.cbp-spmenu-vertical {
   /*padding: 2em 10px;*/
	/*width: 280px;*/
}
.sidebar ul li a {
    font-size: 0.9em;
}
.sidebar .nav-second-level li a {
    font-size: .8em !important;
}
.cbp-spmenu-push div#page-wrapper {
    margin: 0 0 0 14.5em;
}
.bs-example-tooltips .btn-default {
    margin-right: 0.2em;
}
.grid_3.grid_5 .label {
    font-size: 60%;
}
.well {
    font-size: 0.9em;
    line-height: 1.8em;
	padding: 11px 15px;
}
.compose-right .panel-body {
    padding: 1.5em;
}
.tables .panel-body, .tables .bs-example {
    padding: 1.5em 1.5em 0em;
}
.tables h4 {
    margin-bottom: 0.8em;
}
.tables .table > thead > tr > th, .tables .table > tbody > tr > th, .tables .table > tfoot > tr > th, .tables .table > thead > tr > td, .tables .table > tbody > tr > td, .tables .table > tfoot > tr > td {
  font-size: 0.9em;
}
.form-body {
    padding: 1.5em;
}

.forms button.btn.btn-default {
    padding: .5em .9em;
}
.login-page {
    width: 77%;
}
.login-top h4 {
    font-size: 1em;
}
.sign-up2 input[type="text"], .sign-up2 input[type="password"] {
    padding: 8px 10px;
    margin: 0.5em 0;
}
.sign-up1 h4 {
    margin: 1em 0 0;
}
.blank-page p {
    font-size: 0.9em;
}
.doughnut-grid {
    width: 55%;
}
.polar-area, .pie-grid {
    width: 55%;
}
}
@media(max-width:800px){
.search-box {
    width: 38%;
    margin: 1.2em 0 0 1em;
}
}
@media(max-width:768px){
.logo a {
    padding: 1.1em 1.3em .7em;
}
.logo a h1 {
    font-size: 1.2em;
	line-height:1em;
}
.logo a span {
    font-size: .6em;
}
li.dropdown.head-dpdn a.dropdown-toggle {
    padding: 1em 1.4em;
}

.sb-search-input {
    font-size: 0.8em;
	padding: 0.5em;
}
.search-box {
    width: 36%;
    margin: 1em 0 0 2em;
}
li.dropdown.head-dpdn {
    padding: 1.5em 0;
}
li.dropdown.head-dpdn a.dropdown-toggle {
    padding: 1.5em 1.6em 1.5em 1.2em;
}
.profile_details_drop a.dropdown-toggle {
    padding: 0.6em 2em 0 1em;
}
.profile_details li a i.fa.lnr {
    top: 28%;
}
.cbp-spmenu{
	margin: -0.3em 0 0 0;	
}
.cbp-spmenu-vertical {
    /*padding: 2em 10px;*/
    /*width: 280px;*/
    top: 0
}
.cbp-spmenu-push div#page-wrapper {
    margin: 0;
}
.cbp-spmenu-left.cbp-spmenu-open {
	left:0;
}
.cbp-spmenu-vertical {
    
	left: -360px;
}
.activity-desc-sub:before {
    left: -3.4%;
}
.activity-desc-sub1:after {
    right: -3.1%;
}
.botaoTop {
    font-size: 1.1em;
    width: 40px;
    padding: 0.52em 0;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

}
@media(max-width:767px){
.sidebar .navbar-collapse.collapse {
    display: block;
}
.topHeader{
	padding: 0.8em 0 0 0;	
	font-size:21px;
	text-align:center;
}

.topHeaderIndex{
	padding: 1em 0 0 0;	
	font-size:21px;
	text-align:center;	
}

.botaoTop {
    font-size: 1.5em;
    width: 35px;
    padding: 0.4em 0;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

}
@media(max-width:640px){
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
  border-top: none;
  /*font-size:0.6em;*/
}
table .gridTable{
 	font-size:0.6em;
}
.cbp-spmenu-vertical {
    top: 0;
}

.topHeader{
	padding: 2em 10px;	
	font-size:18px;
	font-weight: normal !important;
	text-align:center;
	margin:0 auto;
	width:230px;
}
.topHeaderIndex{
	padding: 1em 0 0 0;	
	font-size:18px;
	text-align:center;	
}

.botaoTop {
    font-size: 1.4em;
    width: 40px;
    padding: 0.6em 0;
    text-align: center;
    cursor: pointer;
	max-height: 48px;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

.rightTop{
	min-width:100px;	
}

.sidebar .navbar-collapse.collapse {
    display: block;
}
.header-left {
    width: 100%;
    float: none;
}
.search-box {
    width: 40%;
    margin: 1em 0 0 8em;
}
.header-right {
    float: none;
    width: 100%;
    padding: 0;
    margin-top: 1em;
}
.profile_details_drop a.dropdown-toggle {
    padding: 0 3em 0 0;
}
.header-right span.badge {
    font-size: 9px;
    line-height: 13px;
    width: 18px;
    height: 17px;
}
.header-right i.fa{
    font-size: .9em;
	margin-right: 0.2em;
}
.progress {
	height: 7px;
    margin-bottom: 5px;
}
li.dropdown.head-dpdn {
    padding: 1.2em 0;
}
li.dropdown.head-dpdn a.dropdown-toggle {
    padding: 1.2em 2em 1.2em 1.5em;
}
.profile_details ul li ul.dropdown-menu.drp-mnu {
    padding: 0.5em 1em;
}
ul.dropdown-menu.drp-mnu li {
    padding: 6px 0;
}
.profile_details .dropdown-menu > li > a {
    padding: 0;
    font-size: 0.9em;
}
.profile_details li a i.fa.lnr {
    top: 14%;
}
.cbp-spmenu-push div#page-wrapper {
    padding: 10.5em 1em 2em;
}
h4.title {
    font-size: 1em;
}
.stats-left h4 {
    font-size: 1.7em;
}
.stats-right {
    padding: 1.35em 0em;
}
.wid-social {
    padding: 15px 8px;
}
.activity-desc-sub:before {
    left: -4.3%;
}
.activity-desc-sub1:after {
    right: -3.8%;
}
.charts, .row {
    margin: 0.2em 0 0;
}
.charts-grids canvas#pie {
    width: 100% !important;
    height: auto !important;
    margin: 0.9em 0;
}
.stats-info ul li {
    font-size: 0.8em;
}
.progress.progress-right {
    width: 33%;
    height: 5px;
}
.stats-table td {
    padding: 9px 13px !important;
}
.grids {
    padding: 1.5em 0.5em;
}
.grid-bottom {
    padding: 1.5em;
}
.grid-bottom  th {
    font-size: 0.8em;
}
.panel-info.widget-shadow {
    padding: 1.5em 0.5em 0.5em;
}
.panel-body {
    font-size: 4pxem;
}
.navbar-nav {
    margin: 0;
}
.grid_5 {
    margin-top: 1.5em;
}
.grid_4 {
    margin-top: 20px;
}
.tab-content > .active {
    padding: 0;
}
.bs-example {
    margin-top: 1em;
}
.widget_1_box {
    width: 100%;
}
.widget_1_box.widget-mdl-grid {
    margin: 3% 0;
}
.tile-progress {
    padding: 1.5em 2em;
}
.inbox-page.row {
    margin-top: 1.5em;
}
.compose-left ul li a {
    padding: 0.58em 1em;
}
.form-grids-right label {
    float: left;
    text-align: right;
    width: 20%;
}
.form-grids .checkbox label {
    width: 100%;
    text-align: left;
}
.form-grids .col-sm-offset-2 {
    margin-left: 7em;
}
.form-grids .col-sm-9 {
    float: right;
    width: 80%;
}
.forms button.btn.btn-default {
    padding: .5em 2.5em;
}
.signup-page p {
    font-size: 0.9em;
    margin: 0 5em;
    line-height: 1.8em;
}
.footer p {
    font-size: 0.9em;
}


}
@media(max-width:480px){
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
  border-top: none;
 /* font-size:0.55em;*/
}
table .gridTable{
 	font-size:0.55em;
}
.search-box {
    margin: 1em 0 0 3em;
}
.logo a {
    padding: 1em 1.38em .6em;
}
.logo a span {
    font-size: .55em;
}
.cbp-spmenu-vertical {
    top: 0;
	width: 320px;
}
.stats-left {
    width: 68%;
    padding: 1em .6em;
}
.stats-right {
    padding: 1.52em 0;
	width: 32%;
}
.sidebar .nav-second-level li a {
    padding-left: 40px !important;
}
.stats-left h4 {
    font-size: 1.4em;
}
.stats-right label {
    font-size: 1.5em;
}
.charts, .row {
    margin: 1em 0 0;
}
.charts .charts-grids {
    width: 100%;
    padding: 1em 2em;
}
.charts-grids canvas.barCharts,.charts canvas#line {
    height: 215px !important;
}
.charts-grids.states-mdl {
    margin: 4% 0;
}
.charts-grids canvas#pie {
    width: 73% !important;
    margin: 0 auto;
}
.stats-info.widget {
    width: 100%;
    float: none;
}
.stats-info.stats-last {
    width: 100%;
    float: none;
    margin: 4% 0 0;
}
.map {
    float: none;
    width: 100%;
}
div#vmap {
    height: 250px !important;
}
.social-media {
    width: 100%;
    float: none;
    margin: 3% 0 0;
}
.bs-example-tooltips .btn-default {
    margin: 0 auto 1em;
    display: block;
}
.modals {
    padding: 1.5em 1em;
}
.modals h4.title2 {
    margin: 0 0 1em 0;
}
.modal-grids {
    float: left;
    width: inherit;
    text-align: center;
    padding: 0;
}
.modal-grids:nth-child(3) {
    margin: 0 1em;
}
.modal-grids button.btn.btn-primary {
    font-size: 0.9em;
}
.scrollspy-example p {
    margin-bottom: 0.8em;
}
.tool-tips.widget-shadow {
    padding: 1.5em;
}
.general-grids.grids-right {
    margin: 1.5em 0 0;
}
.popover {
    max-width: 140px;
}
.grid_3.grid_5 .label {
    font-size: 41%;
}
h3.hdg {
    font-size: 1.5em;
}
.table {
    margin-bottom:0;
}
.header-top {
    padding: 1em 1.5em;
}
.weather-grids.weather-right {
    margin: 1.5em 0 0;
}
.weather-right ul li:nth-child(2) {
    margin: 0 0.4em;
}
.inbox-page p {
    font-size: 0.8em;
}
.inbox-page h4 {
    font-size: 1em;
    margin-bottom: 0.8em;
}
.mail {
    margin-right: 0.7em;
}
.mail.mail-name {
    width: 10%;
}
.inbox-page h6 {
    font-size: 0.8em;
}
.inbox-row a .mail {
    margin: 0;
}
h3.title1 {
    margin-bottom: 0.6em;
}
.mail-body {
    padding: 0.5em 1em;
}
.mail-body input[type="text"] {
    padding: 0.5em 0;
    font-size: 0.9em;
}
.mail-body input[type="text"]:focus {
    padding: 1em 0;
}
.mail-body input[type="submit"] {
    font-size: 0.9em;
    margin-top: 0.2em;
}
.inbox-page.row {
    margin-top: 1em;
}
.footer p {
    font-size: 0.8em;
}
.compose-left {
    width: 100%;
    float: none;
}
.chat-grid.widget-shadow {
    margin-top: 1.3em;
}
.compose-right {
    width: 100%;
    float: none;
    margin: 4% 0 0;
}
.compose-right .alert.alert-info {
    padding: 6px 20px;
}
.compose-right .alert {
    margin-bottom: 14px;
}
.tables h4 {
    margin-bottom: 0.5em;
}
.tables .panel-body, .tables .bs-example {
    padding: 1.5em 1.5em;
}
h3.title1 {
    font-size: 1.3em;
}
.form-three {
    padding: 1em 1.5em;
}
.form-title {
    padding: 0.8em 1.5em;
}
.forms h4 {
    font-size: 1.1em;
}
.login-page {
    width: 90%;
    margin: 0 auto;
}
.login-top {
    padding: 1em;
}
.login-page h3.title1 {
    margin-bottom: 0.8em;
}
.login-top h4 {
    font-size: 0.9em;
}
.login-body {
    padding: 1em;
}

.login-page label.checkbox {
    font-size: 0.9em;
}
.login-page-bottom h5 {
    font-size: 1.3em;
    margin: 1em 0;
}
.social-btn i {
    padding: .8em 1em;
    font-size: 0.8em;
}
.social-btn i.fa {
    padding: .5em 0.8em;
    font-size: 1em;
}
.sign-up-row {
    padding: 1.5em;
    margin: 0.8em auto 0;
}
.sign-up1 h4 {
    margin: 1.1em 0 0;
    font-size: 0.9em;
}
.sign-up2 label {
    margin: 1em 2em 0 0;
    font-size: .9em;
}
.sub_home input[type="submit"] {
    margin: 0.5em 0 0 6.6em;
    width: 28%;
    font-size: 0.9em;
}
.blank-page {
    padding: 1.5em;
}
.chrt-page-grids {
    width: 100%;
}
ul.nav.nav-second-level li a {
    padding: 8px 15px;
}
span.nav-badge-btm {
    font-size: 11px;
    padding: 0 0.7em;
}
span.nav-badge {
    font-size: 10px;
    width: 23px;
    height: 23px;
    line-height: 23px;
}
.sidebar ul li {
    margin-bottom: 0.6em;
}
h3.title1 {
    font-size: 1.4em;
}

.topHeader{
	padding: 0.7em 0 0 0;	
	font-size:18px;
	font-weight: normal !important;
	text-align:center;
	margin:0 auto;
	width:230px;
}
.topHeaderIndex{
	padding: 0.7em 0 0 0;	
	font-size:18px;
	text-align:center;	
}


.botaoTop {
    font-size: 1.2em;
    width: 40px;
    padding: 0.6em 0;
    text-align: center;
    cursor: pointer;
	max-height: 48px;
    float: right;
    color: #FFFFFF;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}

.rightTop{
	min-width:100px;	
}

}
@media(max-width:384px){
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
  border-top: none;
  /*font-size:0.5em;*/
}
table .gridTable{
 	font-size:0.5em;
}
.topHeader{
	padding: 0.7em 0 0 0;	
	font-size:16px;
	font-weight: normal !important;
	text-align:center;
	margin:0 auto;
	width:150px;
}
.topHeaderIndex{
	padding: 0.7em 0 0 0;	
	font-size:16px;
	text-align:center;	
}

.cbp-spmenu {
	/*margin: -0.95em 0 0 0;*/
	top: 0;	
}

.botaoTop {
    font-size: 1.2em;
    width: 35px;
    padding: 0.6em 0;
    text-align: center;
    cursor: pointer;
    float: right;
    color: #FFFFFF;
	max-height: 48px;
    -moz-transition: all 0.2s ease-out 0s;
    -webkit-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
	border: none;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
	outline:none;
}
.botaoTop:hover {
    color: #175d79;
}
.botaoTop:active {
	color: #175d79;
}
button#showLeftPush {
    padding: 0.18;
	font-size: 1.7em;
	width: 50px;
}
button#showLeftPushVoltarForm {
    padding: 0.37em 0 0.2em 0;
	font-size: 1.5em;
	width: 50px;
}
button#showLeftPushVoltarModal {
    padding: 0;
	font-size: 1.5em;
	width: 40px;
}
}

@media(max-width:320px){
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-top: none;
    /*font-size:0.5em;*/
    }
    table .gridTable{
        font-size:0.5em;
    }
    .botaoTop {
        font-size: 1.3em;
        width: 30px;
        padding: 0.5em 0;
        text-align: center;
        cursor: pointer;
        float: right;
        color: #FFFFFF;
        -moz-transition: all 0.2s ease-out 0s;
        -webkit-transition: all 0.2s ease-out 0s;
        transition: all 0.2s ease-out 0s;
        border: none;
        background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
        outline:none;
    }
    .botaoTop:hover {
        color: #175d79;
    }
    .botaoTop:active {
        color: #175d79;
    }
    button#showLeftPush {
        padding: 0 0 0.1em 0;
        font-size: 2em;
        width: 50px;
    }

    button#showLeftPushVoltarForm {
        padding: 0.37em 0 0.2em 0;
        font-size: 1.5em;
        width: 50px;
    }

    .logo a {
        padding: 0.9em 1em .3em;
    }
    .logo a h1 {
        font-size: 1em;
        line-height: 0.7em;
    }
    .logo a span {
        letter-spacing: 4px;
        font-size: .5em;
    }

    i.fa.fa-bars {
        font-size: 0.9em;
    }

    .search-box {
        margin: 0.7em 0 0 0.5em;
    }
    .sb-search-input {
        font-size: 0.75em;
        padding: 0.5em .8em;
    }
    .header-right {
        margin-top: 0.5em;
    }
    li.dropdown.head-dpdn {
        padding: 0.8em 0;
    }
    li.dropdown.head-dpdn a.dropdown-toggle {
        padding: 0.8em 1.3em 0.8em 0.8em;
    }
    li.dropdown.head-dpdn a.dropdown-toggle {
        padding: 0.8em 1.3em 0.8em 0.8em;
    }
    .header-right span.badge {
        font-size: 8px;
        line-height: 11px;
        width: 16px;
        height: 15px;
    }
    .header-right i.fa {
        margin-right: 0;
    }
    .profile_details_drop a.dropdown-toggle {
        padding: 0 1.5em 0 0;
    }
    .user-name p {
        font-size: 0.9em;
    }
    .profile_img span.prfil-img {
        width: 32%;
    }
    .profile_img span.prfil-img img {
        width: 100%;
    }
    .user-name {
        margin-top: 5px;
        margin-left: 8px;
    }
    .profile_details li a i.fa.lnr {
        top: 8%;
    }
    .cbp-spmenu-vertical {
        /*padding: 2em 10px;*/
        /*width: 280px;*/
        top: 0;
    }
    i.nav_icon {
        margin-right: 0.7em;
        font-size: 1em;
    }
    .sidebar ul li a {
        font-size: 0.85em;
    /*padding: 5px 10px;*/
    }
    span.nav-badge {
        font-size: 8px;
        width: 21px;
        height: 20px;
        line-height: 21px;
    }
    span.nav-badge-btm {
        font-size: 9px;
        padding: 0 0.8em;
        line-height: 18px;
        top: 22%;
    }
    ul.nav.nav-second-level li a {
        padding: 5px 32px;
    }
    .cbp-spmenu-push div#pageContent{
        padding: 8.2em 1em 1.5em;
    }
    .bs-example5 {
        padding: 1em;
    }
    .panel-info.widget-shadow {
        padding: 1.5em 0em 0.5em;
    }
    .panel-body {
        padding: 2px;
    }
    .tool-tips.widget-shadow {
        padding: 1em;
    }
    .widget {
        float: none;
        width: 100%;
    }
    .widget.states-mdl {
        margin: 3% 0;
    }
    .stats-right {
        padding: 1.35em 0;
    }
    .charts .charts-grids {
        padding: 0.5em 1em;
    }
    h4.title {
        margin: 0.5em 0 0.8em;
    }
    .stats-info.stats-last {
        padding: 0.8em;
    }
    .stats-left {
        padding: 0.82em .6em;
    }
    .stats-table th {
        font-size: 0.7em;
    }
    .stats-table td {
        padding: 9px 8px !important;
        font-size: 0.7em;
    }
    .map {
        padding: 0.5em .8em;
    }
    .map h4.title {
        margin-bottom: 0;
    }
    div#vmap {
        height: 180px !important;
    }
    .social-media .icon-xlg {
        font-size: 20px;
    }
    .wid-social .social-info h3 {
        font-size: 1em;
    }
    .wid-social .social-info h4 {
        font-size: 0.75em;
        letter-spacing: 0px;
    }
    .charts, .row {
        margin: 1em 0 0;
    }
    .calender {
        padding: 0.5em 1em 1em;
    }
    h3.title1 {
        font-size: 1.3em;
    }
    .grids {
        padding: 1em 0em;
        margin-bottom: 1.5em;
    }
    .grid-bottom {
        padding: .5em;
    }
    .grid-bottom th {
        font-size: 0.6em;
    }
    .grid-bottom td {
        font-size: .75em;
    }
    .sidebard-panel .feed-element, .media-body, .sidebard-panel p {
        font-size: 0.8em;
    }
    .media {
        margin-top: 16px !important;
    }
    .media_1 td.head {
        font-size: 1em !important;
    }

    .padding-5{
        padding:2px;
    }
    .padding-l-5 {
        padding-left: 2px;
    }
    .padding-r-5 {
        padding-right: 2px;
    }
    .padding-t-5 {
        padding-top: 2px;
    }
    .padding-b-5 {
        padding-bottom: 2px;
    }
    .notification_header h3 {
        font-size: 11px;
    }
    .notification_desc p {
        font-size: 12px;
    }
    .notification_desc p span {
        font-size: 10px;
    }
    .dropdown-menu > li > a {
        padding: 3px 8px;
    }
    ul.dropdown-menu {
        min-width: 175px;
    }
    .notification_header {
        margin-bottom: 4px;
    }
    .notification_bottom a {
        font-size: 0.9em;
    }
    .progress {
        height: 6px;
        margin: 4px 0;
    }
    .profile_details ul li ul.dropdown-menu.drp-mnu {
        min-width: 130px;
    }
    ul.dropdown-menu.drp-mnu li {
        padding: 4px 0;
    }
    .modal-grids {
        float: none;
    }
    .modal-grids:nth-child(3) {
        margin: 1em 0;
    }
    .general-grids {
        padding: 1.5em 1em;
    }
    #navbar-example2 .navbar-brand {
        font-size: 16px;
    }
    .navbar {
        margin-bottom: 12px;
    }
    .scrollspy-example p {
        font-size: 0.8em;
    }
    .grids-right .nav > li > a {
        padding: 10px 10px;
    }
    .grids-right ul.dropdown-menu {
        min-width: 105px;
    }
    .tool-tips.widget-shadow {
        margin-top: 1.2em;
    }
    .general h4.title2 {
        font-size: 1.2em;
    }
    .header-head {
        padding: 1.5em 0;
    }
    .header-head h4 {
        font-size: 0.9em;
    }
    .weather-grids canvas {
        width:45px;
    }
    .bottom-head p {
        font-size: 0.8em;
    }
    .header-head h6 {
        font-size: 1.1em;
    }
    .header-top {
        padding: 1em 1em;
    }
    .header-top li p {
        font-size: 0.8em;
        padding: 2px 6px;
    }
    .weather-grids canvas#clear-day {
        width: 25px;
    }
    .header-top h2 {
        margin: .2em 0 0 .5em;
        font-size: 1.2em;
    }
    .weather-grids.weather-right {
        margin: 1.2em 0 0;
    }
    .weather-right ul li:nth-child(2) {
        margin: 2em 0;
    }
    .profile-text {
        padding: 1.5em 1.5em;
    }
    .scrollbar {
        padding: 1.5em 1em 0;
    }
    .activity-row .col-xs-3 {
        width: 21%;
    }
    .activity-img1, .activity-img2 {
        width: 78%;
    }
    .activity-desc-sub:before {
        left: -9%;
        top: 20%;
    }
    .activity-desc-sub1:after {
        right: -8.5%;
        top: 28%;
    }
    .activity-row p {
        font-size: 0.8em;
    }
    .activity-desc-sub, .activity-desc-sub1 {
        padding: .5em 0.8em;
    }
    h4.title3 {
        padding: 0.6em 1em;
    }
    .single-bottom ul li input[type="checkbox"]+label {
        font-size: 0.8em;
    }
    .single-bottom ul li input[type="checkbox"]+label span:first-child {
        width: 15px;
        height: 15px;
        top: 1px;
    }
    .compose-left ul li.head {
        font-size: 1em;
    }
    .compose-left ul li a {
        font-size: 0.9em;
    }
    .compose-right .panel-body {
        padding: 1em;
    }
    .form-control1,.form-control_2.input-sm {
        height: 35px;
    }
    .validation .form-control {
        height: 29px;
    }
    .validation-grids .btn-primary {
        font-size: 0.8em;
    }
    .control2 {
        height: 150px;
    }
    .compose-right input[type="submit"] {
        margin-top: 0.5em;
    }
    .tables .panel-body, .tables .bs-example {
        padding: 1.5em 1em;
    }
    .form-body {
        padding: 1em;
    }
    .form-grids-right label {
        font-size: 0.9em;
    }
    .form-grids .col-sm-9 {
        width: 77%;
    }
    .form-grids .col-sm-offset-2 {
        margin-left: 4em;
    }
    .form-three {
        padding: 1em;
    }
    .forms label {
        font-size: 0.9em;
    }
    .login-page {
        width: 100%;
    }
    .login-top h4 {
        font-size: 0.8em;
    }
    .login-body {
        padding: 1em;
    }
    .login-page input.user, .login-page input.lock {
        background-position: 11px 11px;
        background-size: 6%;
        padding: 8px 15px 8px 37px;
        background-color:rgba(23,93,121,0.58);	
    }
    .forgot a {
        font-size: 0.9em;
    }
    .login-page input[type="submit"] {
        font-size: 0.9em;
    }
    .login-page-bottom h5 {
        font-size: 1.1em;
    }
    .social-btn.sb-two {
        margin: 1em 0 0;
    }
    .signup-page p {
        font-size: 0.8em;
        margin: 0;
    }
    .sign-up-row {
        width: 100%;
        padding: 1em;
    }
    .sign-up1,.sign-up2 {
        float: none;
        width: 100%;
    }
    .sign-up2 input[type="text"], .sign-up2 input[type="password"] {
        padding: 7px 10px;
        font-size: 12px;
    }
    .sign-up1 h4 {
        margin: .5em 0 0;
    }
    .blank-page {
        padding: 1em;
    }
    .sub_home input[type="submit"] {
        margin: 0.5em 0 0 0;
        width: 34%;
        font-size: 0.8em;
    }
    .chrt-page-grids {
    }
    .polar-area, .pie-grid {
        width: 80%;
        margin: 1em auto 0;
    }
}
/*--//responsive-design---*/

table.vagas {
    width: 100%;
    float: left;
    margin-bottom: 20px;
}

table.vagas td {
    padding: 10px;
    border: 1px solid #b1acac;
}

table.vagas h2 {
    font-size: 20px;
}

table.vagas button.detalhesVagas,
table.vagas button.showVaga {
    position: relative;
    width: 100px;
    text-align: center;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    border-color: #255625;
    color: #fff;
    display: inline-block;
    padding: 6px 6px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 1px;
}

table.vagas button.detalhesVagas:hover,
table.vagas button.showVaga:hover {
    border-color: #E74225 !important;
    background: #E74225 !important;
}

#botoes-pagina-candidatar a,
#botoes-pagina-candidatar button {
    position: relative;
    width: 100px;
    text-align: center;
    background-color: <?= ViewConfig::getCorFundoPrimaria(); ?>;
    border-color: #255625;
    color: #fff;
    display: inline-block;
    padding: 6px 6px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 1px;
}

#botoes-pagina-candidatar a:hover {
    border-color: #E74225 !important;
    background: #E74225 !important;
}
<?php 
    header("Content-type: text/css; charset=utf-8");
    include_once('../config.php');    
?>

#wrapper {
    width: 100%;
}

#page-wrapper {
    padding: 5em 0 0 0;
}

.navbar-top-links {
    margin-right: 0;
}

.navbar-top-links li {
    display: inline-block;
}

.navbar-top-links li:last-child {
    margin-right: 15px;
}

.navbar-top-links li a {
    padding: 15px;
    min-height: 50px;
}

.navbar-top-links .dropdown-menu li {
    display: block;
}

.navbar-top-links .dropdown-menu li:last-child {
    margin-right: 0;
}

.navbar-top-links .dropdown-menu li a {
    padding: 3px 20px;
    min-height: 0;
}

.navbar-top-links .dropdown-menu li a div {
    white-space: normal;
}

.navbar-top-links .dropdown-messages,
.navbar-top-links .dropdown-tasks,
.navbar-top-links .dropdown-alerts {
    width: 310px;
    min-width: 0;
}

.navbar-top-links .dropdown-messages {
    margin-left: 5px;
}

.navbar-top-links .dropdown-tasks {
    margin-left: -59px;
}

.navbar-top-links .dropdown-alerts {
    margin-left: -123px;
}

.navbar-top-links .dropdown-user {
    right: 0;
    left: auto;
}

.sidebar .sidebar-nav.navbar-collapse {
    padding-right: 0;
    padding-left: 0;
}

.sidebar .sidebar-search {
    padding: 15px;
}

.sidebar .arrow {
    float: right;
}

.sidebar .fa.arrow:before {
    content: "\f107";
}

.sidebar .active>a>.fa.arrow:before {
    content: "\f106";
}

.sidebar .nav-second-level li,
.sidebar .nav-third-level li {
    border-bottom: 0 !important;
    margin-bottom: 0;
}

.sidebar .nav-second-level li a {
    padding-left: 53px;
    font-size: .9em;
}

.sidebar .nav-third-level li a {
    padding-left: 52px;
}

.row-same-height {
    display: table-cell;
    float: none;
    height: 100%;
}

.row-height {
    display: table;
    table-layout: fixed;
    height: 100%;
    width: 100%;
}

.col-height {
    display: table-cell;
    float: none;
    height: 100%;
}

@media (max-width:768px) {
    .col-height {
        display: block;
    }
}

@media(min-width:768px) {

    .navbar-top-links .dropdown-messages,
    .navbar-top-links .dropdown-tasks,
    .navbar-top-links .dropdown-alerts {
        margin-left: auto;
    }
}

.selected {
    background-color: <?= ViewConfig::getCorFundoSecundaria(); ?> !important;
}

.highlight {
    background:rgb(204, 204, 204) !important;
}
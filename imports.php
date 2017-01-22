<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#141414">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/jquery-3.1.1.js" type="text/javascript"></script>
<script src="js/jquery.timeago.js" type="text/javascript"></script>
<script src="js/angular.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/freelancer.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
<link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<style>
    @keyframes loader {
        from{
            width:0%;
        }
        to {
            width:100%;
        }
    }
    @keyframes popup {
        0%{
            transform: scale(1);
        }
        50%{
            transform: scale(1.4);
        }
        60%{
            transform: scale(1.1);
        }
        70%{
            transform: scale(1.2);
        }
        80%{
            transform: scale(1);
        }
        90%{
            transform: scale(1.1);
        }
        100%{
            transform: scale(1);
        }
    }
    .simple{
        padding: 5px;
        border: 1px solid #ffffff;
        color: #ffffff;
        font-size: 0.7em;
        text-transform: none !important;
        margin: 10px 0;
        display: inline-block;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        letter-spacing: 1px;
        background: transparent;
        outline: none;
        border-radius: 0px;
    }
    .simple[type=button]{
        opacity: 0.65;
    }
    .simple:focus{
        outline: none;
        box-shadow: none;
        -webkit-box-shadow: none;
    }
    hr{
        color: white;
        height: 1px;
        margin: 6px 0px;
    }
    input{
        text-align: left !important;
        outline: none;
    }
    input[type=button]{
        text-align: center;
    }

    .simple:hover {
        opacity: 1;
    }
    .well{
        color: white;
        border: 0px; 
        background: #141414;
        /*box-shadow: 0px 0px 5px black;*/
        border-radius: 0px;
    }
    h1 {
        letter-spacing: 5px;
        text-transform: none !important;
        font: 40px "Lato", sans-serif;
        color: #ffffff;
    }
    h2 {
        letter-spacing: 5px;
        text-transform: none !important;
        font: 25px "Lato", sans-serif;
        color: #ffffff;
    }
    h3 {
        letter-spacing: 5px;
        text-transform: none !important;
        font: 20px "Lato", sans-serif;
        color: #111;
    }
    label {
        letter-spacing: 5px;
        text-transform: none !important;
        font: 10px "Lato", sans-serif;
        color: white;
    }
    a{
        letter-spacing: 3px;
        text-transform: uppercase !important;
    }
    .navbar-custom, header .intro-text .name {
        text-transform: none !important;
    }
    .well h1,.well h2,.well h3,.well h4{
        color: white;
        margin: 0px;

    }
    .float-left{
        float:left;
        margin-right: 40px !important;
    }
    .float-right{
        float:right;
        margin-left: 40px !important;
    }
    .table-hover tbody tr:hover{
        color: #141414;
    }
    .dropdown-menu {
        background-color: #141414;
    }
    .navbar-custom .navbar-nav li ul li a:hover{
        color: #141414;
    }
    /* Base for label styling */
    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
        position: absolute;
        left: -9999px;
    }
    [type="checkbox"]:not(:checked) + label,
    [type="checkbox"]:checked + label {
        position: relative;
        padding-left: 30px;
        padding-top: 6px;
        cursor: pointer;
    }

    /* checkbox aspect */
    [type="checkbox"]:not(:checked) + label:before,
    [type="checkbox"]:checked + label:before {
        content: '';
        position: absolute;
        left:0; top: 1px;
        width: 23px; height: 23px;
        border: 1px solid white;
        box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
    }
    /* checked mark aspect */
    [type="checkbox"]:not(:checked) + label:after,
    [type="checkbox"]:checked + label:after {
        content: '✔';
        position: absolute;
        top: 4px; left: 4px;
        font-size: 19px;
        line-height: 0.8;
        color: white;
        transition: all .2s;
    }
    /* checked mark aspect changes */
    [type="checkbox"]:not(:checked) + label:after {
        opacity: 0;
        transform: scale(0);
    }
    [type="checkbox"]:checked + label:after {
        opacity: 1;
        transform: scale(1);
    }
    /* disabled checkbox */
    [type="checkbox"]:disabled:not(:checked) + label:before,
    [type="checkbox"]:disabled:checked + label:before {
        box-shadow: none;
        border-color: white;
        background-color: #ddd;
    }
    [type="checkbox"]:disabled:checked + label:after {
        color: #999;
    }
    [type="checkbox"]:disabled + label {
        color: #aaa;
    }
    /* accessibility */
    [type="checkbox"]:checked:focus + label:before,
    [type="checkbox"]:not(:checked):focus + label:before {
        border: 1px dotted white;
    }

    /* hover style just for information */
    label:hover:before {
        border: 1px solid white!important;
    }
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    [type="radio"]:not(:checked),
    [type="radio"]:checked {
        position: absolute;
        left: -9999px;
    }
    [type="radio"]:not(:checked) + label,
    [type="radio"]:checked + label {
        position: relative;
        padding-left: 30px;
        padding-top: 6px;
        cursor: pointer;
    }

    /* checkbox aspect */
    [type="radio"]:not(:checked) + label:before,
    [type="radio"]:checked + label:before {
        content: '';
        position: absolute;
        left:0; top: 1px;
        width: 23px; height: 23px;
        border: 1px solid white;
        box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
    }
    /* checked mark aspect */
    [type="radio"]:not(:checked) + label:after,
    [type="radio"]:checked + label:after {
        content: '+';
        position: absolute;
        top: 1px; left: 4px;
        font-size: 25px;
        line-height: 0.8;
        color: white;
        transition: all .2s;
    }
    /* checked mark aspect changes */
    [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        transform: scale(0);
    }
    [type="radio"]:checked + label:after {
        opacity: 1;
        transform: scale(1);
    }
    /* disabled checkbox */
    [type="radio"]:disabled:not(:checked) + label:before,
    [type="radio"]:disabled:checked + label:before {
        box-shadow: none;
        border-color: white;
        background-color: #ddd;
    }
    [type="radio"]:disabled:checked + label:after {
        color: #999;
    }
    [type="radio"]:disabled + label {
        color: #aaa;
    }
    /* accessibility */
    [type="radio"]:checked:focus + label:before,
    [type="radio"]:not(:checked):focus + label:before {
        border: 1px dotted white;
    }

    /* hover style just for information */
    label:hover:before {
        border: 1px solid white!important;
    }
    .dialogbox{
        position: fixed;
        top: 25%;
        left: 25%;
        width: 50%;
        z-index: 99999;
        text-align: left;
    }
    .dialogbox:before{
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: rgba(0, 0, 0, 0.79);
    }
    @media (max-width: 767px) {
        .navbar-default .navbar-nav .open .dropdown-menu>li>a {
            color: white; 
        }
        .navbar-default .navbar-nav .open .dropdown-menu>li>a:focus, .navbar-default .navbar-nav .open .dropdown-menu>li>a:hover {
            color: #141414;
            background-color: white;
        }
        .dialogbox{
            position: fixed;
            top: 5%;
            left: 5%;
            width: 90%;
            z-index: 99999;
            text-align: left;
        }
    }
</style>



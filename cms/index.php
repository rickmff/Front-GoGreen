<?php
require 'auth.inc.php';

include("config/inc_pags.php");

if (array_search($_GET['p'],$pags)) {
	$inc = $_GET['p'].'.inc.php';
} elseif ($_GET['p'] == 'sair') {
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(),'',time()-42000,'/');
	}
	session_destroy();
	Go($config_urlCmsCliente);
} else {
	$inc = 'home.inc.php';
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" itemscope="" itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title><?=$config_nomeCliente?> - Área Restrita</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js" ></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,700,500,900,300|Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<meta name="theme-color" content="#<?=$config_corCliente?>">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
<script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">

<link href="panel.css" rel="stylesheet" type="text/css" />
<!-- zoom -->
<link rel="stylesheet" href="<?=$config_urlCliente?>assets/css/magnific.css" type="text/css">
<script src="<?=$config_urlCliente?>assets/js/vendor/magnific.min.js"></script>
<script src="<?=$config_urlCliente?>assets/js/config_zoom.js"></script>
<script src="<?=$config_urlCliente?>assets/js/formata_campo.js"></script>
<!-- Mascara -->
<script src="<?=$config_urlCliente?>assets/js/vendor/jquery.mask.min.js"></script>
<script src="<?=$config_urlCliente?>assets/js/config_mask.js"></script>

<script src="jscolor.js"></script>

<script type="text/javascript">
function Confirma(tex) {
	if (confirm(tex)) {return true;} else  {return false;}
}
</script>

<? if($config_corCliente){?>
<style type="text/css">
.topo {	background-color:#<?=$config_corCliente?>;}
.botao:hover { background-color:#<?=$config_corCliente?>;}

body {background-image: radial-gradient(#<?=$config_corCliente?>,#<?=$config_corCliente?>);}
a{ color: #<?=$config_corCliente?>; }
a:hover {color:#<?=$config_corCliente?>;}

.btn, btn:active {background: #<?=$config_corCliente?>;}

.form-control:focus {border-color: #<?=$config_corCliente?>;}

.sidebar {background: #<?=$config_corCliente?>;}

.menu-home li a:hover {background: #<?=$config_corCliente?>;}
hr {background: #<?=$config_corCliente?>;}

a.dt-button, button.dt-button, div.dt-button, a.dt-button:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {transition: all .4s; background: #<?=$config_corCliente?> !important; color: #FFF !important;
border: 1px solid #<?=$config_corCliente?> !important;}

.tgl:before {color: #<?=$config_corCliente?>;}

h1.tit-secao:hover {color:  #<?=$config_corCliente?>;}
h1.tit-secao:after {border-color:  #<?=$config_corCliente?>;}

.lista li:before{color: #<?=$config_corCliente?>;}
@media screen and (max-width: 992px) {body {background-image: none;}}
</style>
<? } ?>


</head>

<body>

<div class="sidebar">
    <p class="logo">
        <a href="<?=$config_prCliente?>home">
            <img src="images/logo.png" alt="Cliente">
        </a>
    </p>

    <i class="fa fa-bars tg-menu" aria-hidden="true"></i>

    <div class="menu">
        <ul>
            <? include("config/inc_menu.php");?>
            <li><a href="<?=$config_prCliente?>sair"><i class="fa fa-sign-out"></i> SAIR</a></li>
        </ul>

        <a class="kombi hm" href="http://www.agenciakombi.com.br/?utm_source=cms&utm_campaign=<?=cleanString($config_nomeCliente)?>" target="_blank">
            <img src="images/credito.png" alt="Desenvolvido por Agência Kombi" />
        </a>

    </div>
</div>

<div class="main">

    <div class="topmainbar text-right">
        <a class="btn hm" href="<?=$config_prCliente?>home">INICIAL <i class="fa fa-home"></i></a>
        <a class="btn" href="<?=$config_prCliente?>admin&id_admin=<?=$_SESSION['Auth']['ID']?>">MEUS DADOS <i class="fa fa-user"></i></a>
        <a class="btn" href="<?=$config_urlCliente?>" target="_blank">SITE <i class="fa fa-sitemap"></i></a>
        <a class="btn sair" href="<?=$config_prCliente?>sair">SAIR <i class="fa fa-sign-out"></i></a>
    </div>


        <?php include $inc; ?>


    <section>
        <div class="row">
            <div class="col-sm-6 tcm"><a href="http://www.agenciakombi.com.br/?utm_source=cms&utm_campaign=<?=cleanString($config_nomeCliente)?>" target="_blank">Desenvolvido por Agência Kombi</a></div>
            <div class="col-sm-6 text-right tcm">
                <a href="mailto:suporte@agenciakombi.com.br" target="_blank">suporte@agenciakombi.com.br</a>
            </div>
        </div>
    </section>

</div>

<!-- Modal Dicas -->
<div id="myModalDicas" class="overlay">
    <div class="content-overlay">
        <h4 id="myModalDicasLabel"></h4>
        <div id="myModalDicasContent"></div>
        <button type="button" class="btn close-overlay"><span class="fa fa-times"></span> Fechar</button>
    </div>
</div>






<script>

    function getLoading(){
        var montaLoader = '<div id="elm_loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Carregando...</span></div>';
        $('body').prepend(montaLoader).fadeIn();
    }

    function delLoading(){
        $('#elm_loading').remove();
    }

    $(document).ready(function(){
        $(".tg-menu").click(function(){
            $(".menu").slideToggle();
        });


        $( window ).on( "load", function() {
            $('.menu ul ul').slideUp(0);
        });
        $('.menu ul li a').on("click",function(){
            $(this).next().slideToggle();
        });


        $(".tit-secao").click(function (){
            $(this).toggleClass('ativo');
            $(this).next("form").slideToggle();
        });

		$(".tit-secao").closest('section').find('form').slideUp(0);
		
	    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    	$.fn.dataTable.moment( 'DD/MM/YYYY às HH:mm:ss' );
	
		$('.table-datatables').DataTable({
			language: {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json",
				buttons: {
					pageLength: {
						_: "%d registros por página +",
						'-1': "Todos"
					}
				}
   			},
			"order": [],
			"columnDefs": [ {
				  "targets": 'tbl_acao',
				  "sortable": false,
				  "ordable": false,
				}
			],
			lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10 registros', '25 registros', '50 registros', 'Todos' ]
			],
			dom: 'Bfrtip',
			buttons: [
				'pageLength',
				'copyHtml5',
				'excelHtml5',
				'pdfHtml5'
			],
			responsive: true
                <? /*
                ,
			initComplete: function () {
				this.api().columns().every( function () {
					var column = this;
					var select = $('<select><option value="">Todos</option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							decolumn
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						d = $(d).text();
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
			} */?>
		});
    });

    $(function(){

        $(window).resize(function(){
            if($(this).width() >= 640){
                $(".menu").slideDown();
            } else {
                $(".menu").slideUp();

            }
        })
            .resize();//trigger resize on page load
    });


</script>

</body>
</html>
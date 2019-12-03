<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="assets/js/vendor/jquery-scrolltofixed-min.js"></script>
<script src="assets/js/funcoes.js"></script>

<?
#################	CONFIGURAÇÃO DOS JS/PLUGINS DE CADA PÁGINA	#################

switch($cur_page){
	case 'index.php': ?>
        <script src="assets/js/vendor/slick.min.js"></script>
        <script src="assets/js/config_slider.js"></script>
	<? break;
    	
	case 'fale-conosco.php':
	?>
        <script src="assets/js/vendor/jquery.mask.js"></script>
		<script src="assets/js/config_mask.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<? break;
}
#################	FIM CONFIGURAÇÃO DOS JS/PLUGINS DE CADA PÁGINA	#################
?>
<script src="assets/js/vendor/magnific.min.js"></script>
<script src="assets/js/config_zoom.js"></script>
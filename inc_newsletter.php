Preencha o formulário para receber nossas novidades por e-mail

<form action="javascript:" method="post" enctype="text/plain" class="form_newsletter" id="form_newsletter" onSubmit="cadastraNews();">
	<input type="text" required="required" name="news_nome" id="news_nome" placeholder="Seu nome">
    <input type="email" required="required" name="news_email" id="news_email" placeholder="Seu e-mail">
    <input type="submit" value="Cadastrar">
</form>


<script>
function cadastraNews(){
	var email = $('#news_email').val(); var nome = $('#news_nome').val();
	if(email){
		$.post("./ajax_newsletter.php?act=CadastraNews", { email: $('#news_email').val(), nome: $('#news_nome').val()},
			function(result){
				alert(result);
				$('#news_email').val('');
				$('#news_nome').val('');
		});
	}
}
</script>
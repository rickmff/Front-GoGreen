<section>
    <h3 class="text-right">Olá <?=$_SESSION['Auth']['Nome']?>, seja bem vindo.</h3>
    <?php ShowErros();?>
</section>

<section style="background: none; border: none; padding: 0">
<div class="menu-home">
    <ul class="row">
        <? include("config/inc_menu.php");?>
    </ul>
</div>
</section>


<section>
    <h4><a class="tgl"><i class="fa fa-area-chart"></i> Gráfico Acessos ao Sistema</a></h4>
    <div class="cont">
        <div id="chart" style="height: 400px; width: 100%"></div>
    </div>
</section>

<div class="rw">
<div class="col-md-4 ng">
    <section>
        <h4><a class="tgl"><i class="fa fa-clock-o"></i> Últimos Acessos </a></h4>
        <div class="cont">
            <? $resAcessos= mysql_query("SELECT * FROM site_tb_log_acesso WHERE sucesso = 'Sim' ORDER BY data DESC LIMIT 5");?>
            <table class="table table-striped t-acessos">
                <thead>
                  <tr>
                    <th>Login</th>
                    <th>Data</th>
                    <th>IP</th>
                  </tr>
                </thead>
                <tbody>
                <? while($rowAcessos = mysql_fetch_array($resAcessos)){?>
                    <tr>
                        <th><?=$rowAcessos['login']?></th>
                        <th><?=mostraData(substr($rowAcessos['data'],0,10))?></th>
                        <th><?=$rowAcessos['ip']?></th>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?

$feedUrl = "http://agenciakombi.com.br/apicms/getCmsDicas.php";
$curl = curl_init($feedUrl);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$feedContent = curl_exec($curl);
curl_close($curl);

$feedDicas = false;
if($feedContent && !empty($feedContent)){
	$feedDicas = true;
	$feedXml = @simplexml_load_string($feedContent);
}
?>
<? if($feedDicas){?>
<div class="col-md-4 ng">
    <section>
        <h4><a class="tgl"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Algumas Dicas Úteis </a></h4>
        <div class="cont">
            <ul class="lista">
                <? foreach($feedXml->channel->item as $item){?>
                <li><a href="javascript:" class="item-dica" data-rel="<?=$item->title?>"><?=$item->title?></a></li>
                <? } ?>
            </ul>
        </div>
    </section>
</div>
<? } ?>

<div class="col-md-4 ng">
    <section>
        <h4><a class="tgl"><i class="ico-kombi"></i> Agência Kombi </a></h4>
        <div class="cont">
            <a class="btn btn-total facebook" target="_blank" href="https://www.facebook.com/kombiagencia/"><i class="fa fa-facebook"></i> /kombiagencia</a>
            <a class="btn btn-total site" target="_blank" href="https://www.agenciakombi.com.br/?utm_source=cms&utm_campaign=<?=cleanString($config_nomeCliente)?>"><i class="fa fa-link"></i> agenciakombi.com.br</a>
        </div>
    </section>
</div>
</div>
<div class="col-md-6 ng">
    <section>
        <h4><a class="tgl"><i class="fa fa-cog"></i> Suporte </a></h4>
        <div class="cont col-md-12">
            <form id="form-send-suporte" action="javascript:" enctype="text/plain" method="post">
                <div class="form-group">
                    <label>Nome</label>
                    <input required name="suporte_nome" id="suporte_nome" type="text" class="form-control" value="<?=$_SESSION['Auth']['Nome']?>">
                </div>
                <div class="form-group">
                    <label>E-Mail</label>
                    <input required name="suporte_email" id="suporte_email" type="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input required name="suporte_fone" type="text" id="suporte_fone" class="form-control mask_phone">
                </div>
                <div class="form-group">
                    <label>Dúvida</label>
                    <textarea required name="suporte_mensagem" id="suporte_mensagem" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" value="SOLICITAR">
                </div>
            </form>
        </div>
    </section>
</div>


<div class="col-md-6 ng">
    <section>
        <h4><a class="tgl"><i class="fa fa-star"></i> Indique a Agência Kombi para um parceiro </a></h4>
        <div class="cont col-md-12">
            <form id="form-send-indica" action="javascript:" enctype="text/plain" method="post">
                <div class="form-group">
                    <label>Nome</label>
                    <input required name="indica_nome" id="indica_nome" type="text" class="form-control" value="<?=$_SESSION['Auth']['Nome']?>">
                </div>
                <div class="form-group">
                    <label>E-Mail</label>
                    <input required name="indica_email" id="indica_email" type="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Nome do Parceiro</label>
                    <input required name="indica_nomeIndicado" type="text" id="indica_nomeIndicado" class="form-control">
                </div>
                <div class="form-group">
                    <label>E-mail do Parceiro</label>
                    <input required name="indica_emailIndicado" type="email" id="indica_emailIndicado" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" value="INDICAR">
                </div>
            </form>
        </div>
    </section>
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	$(".item-dica").click(function (){
        var ref = $(this).data('rel');
		getLoading();

		$.post("./ajax.php?act=getContentDica", { ref_dica: ref, session:'<?=session_id()?>'},
			function(result){
				delLoading();

                $('.overlay').addClass('open');

				retorno = result;
				$('#myModalDicasLabel').html(ref);
				$('#myModalDicasContent').html('<small class="text-right">'+retorno.data_dica+'</small><br>'+retorno.txt_dica);
				/*$('#myModalDicas').modal('show'); */
			},'json'
		);
		delLoading();

        $(".close-overlay").click(function () {
            $('.overlay').removeClass('open');
        });
    });
	
	$('#form-send-suporte').on('submit',function(e){	
		getLoading();
		var send_nome = $('#form-send-suporte #suporte_nome').val();
		var send_email = $('#form-send-suporte #suporte_email').val();
		var send_fone = $('#form-send-suporte #suporte_fone').val();
		var send_msg = $('#form-send-suporte #suporte_mensagem').val();
		
		if(send_nome!='' && send_email!='' && send_fone!='' && send_msg!=''){	
			$.post("./ajax.php?act=sendHomeSuporte", { nome: send_nome, email: send_email, telefone: send_fone, mensagem: send_msg, session:'<?=session_id()?>'},
				function(result){
					if(result=='sucesso'){
						delLoading();
						$('#form-send-suporte #suporte_nome').val('');
						$('#form-send-suporte #suporte_email').val('');
						$('#form-send-suporte #suporte_fone').val('');
						$('#form-send-suporte #suporte_mensagem').val('');

						alert('Sua mensagem foi enviada com sucesso!');
						
					} else {
						alert(result);
						delLoading();
					}
				}
			);
		} else{
			delLoading();
			alert('Preencha suas informações no formulário!');
		}
	});
	
	$('#form-send-indica').on('submit',function(e){	
		getLoading();
		var send_nome = $('#form-send-indica #indica_nome').val();
		var send_email = $('#form-send-indica #indica_email').val();
		var send_nomeIndicado = $('#form-send-indica #indica_nomeIndicado').val();
		var send_emailIndicado = $('#form-send-indica #indica_emailIndicado').val();
		
		if(send_nome!='' && send_email!='' && send_nomeIndicado!='' && send_emailIndicado!=''){	
			$.post("./ajax.php?act=sendHomeIndique", { nome: send_nome, email: send_email, nome_indicado: send_nomeIndicado, email_indicado: send_emailIndicado, session:'<?=session_id()?>'},
				function(result){
					if(result=='sucesso'){
						delLoading();
						$('#form-send-indica #indica_nome').val('');
						$('#form-send-indica #indica_email').val('');
						$('#form-send-indica #indica_nomeIndicado').val('');
						$('#form-send-indica #indica_emailIndicado').val('');

						alert('Sua indicação foi enviada com sucesso!');
						
					} else {
						alert(result);
						delLoading();
					}					
				}
			);
		} else{
			delLoading();
			alert('Preencha suas informações no formulário!');
		}
	});
	
    $(".tgl").click(function (){
        $(this).toggleClass('ativo');
        $(this).parent().next(".cont").slideToggle();
    });

    $(".conteudo").slideUp(0);

    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart2);
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['mês', 'acessos'],
            <?
            $end_month = date('Y-m');
            $bet_month = '12';//numero de meses

            function getAcessosCMS($ano_mes){
                $res = mysql_query("SELECT COUNT(*) as total FROM site_tb_log_acesso WHERE data LIKE '".$ano_mes."%' AND sucesso = 'Sim'");
                $row = mysql_fetch_array($res);
                return $row['total'];
            }

            for($x=$bet_month;$x>-1;$x--){
                $cur_month = date("Y-m", strtotime('-'.$x.' months',strtotime($end_month)));
                echo '["'.substr($cur_month,5,2).'/'.substr($cur_month,0,4).'",'.getAcessosCMS($cur_month).'],';
            }
            ?>
        ]);

        var options = {
            title: 'Acessos ao Sistema / Mês',
            colors: ['#<?=$config_corCliente?>'],
            backgroundColor: 'none',
            legend: { position: 'none' },
               chartArea: {
                left: 40,
                top: 10,
                width: 900,
                height: 350
            },
            vAxis: {
                minValue: 0,
                gridlines: {
                    color: '#f3f3f3',
                    count: 5
                }
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart'));
        chart.draw(data, options);
    }

    $(window).resize(function(){
        drawChart2();
    });






</script>
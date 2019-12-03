<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
<? if($Header_Endereco){?><meta itemprop="streetAddress" content="<?=$Header_Endereco?>"><? } ?>
<? if($Header_Cidade){?><meta itemprop="addressLocality" content="<?=$Header_Cidade?>"><? } ?>
<? if($Header_UF){?><meta itemprop="addressRegion" content="<?=$Header_UF?>"><? } ?>
<? if($Header_Pais){?><meta itemprop="addressCountry" content="<?=$Header_Pais?>"><? } ?></span>
<? if($Header_NomeEmpresa){?><meta itemprop="name" content="<?=$Header_NomeEmpresa?>"><? } ?>
<? if($Header_Site){?><meta itemprop="url" content="<?=$Header_Site?>"><? } ?>
<? if($Header_Telefone){?><meta itemprop="telephone" content="<?=$Header_Telefone?>"><? } ?>
<? if($Header_Email){?><meta itemprop="email" content="<?=$Header_Email?>"><? } ?>


<header>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light nav-header">
                <div class="menu-holder">
                    <a href="home"><img class="logo" src="assets/images/logo1.svg" alt="<?=$config_nomeCliente?>"></a>
                </div>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-icon"><i class="fas fa-bars fa-2x"></i></span>
                </button>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li><a href="sobre" class="<?php if($cur_page == 'sobre.php'){echo 'menu-active';}?>">Sobre</a></li>
                        <li><a href="produtos" class="<?php if($cur_page == 'produtos.php'){echo 'menu-active';}?>">Produtos</a></li>
                        <li><a href="parceiros" class="<?php if($cur_page == 'parceiros.php'){echo 'menu-active';}?>">Parceiros</a></li>
                        <li><a href="fale-conosco" class="<?php if($cur_page == 'fale-conosco.php'){echo 'menu-active';}?>">Fale conosco</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
<!-- HEADER -->
<header id="header"> 

	<!-- pulled right: nav area -->
	<div class="pull-right">

		<!-- collapse menu button -->
		<div id="hide-menu" class="btn-header pull-right">
			<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
		</div>
		<!-- end collapse menu -->

		<!-- #MOBILE -->
		<!-- Top menu profile link : this shows only when top menu is active -->
		<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
			<li class="">
				<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
					<img src="img/avatars/sunny.jpg" alt="John Doe" class="online" />  
				</a>
				<ul class="dropdown-menu pull-right">
					<li>
						<a href="login.php" class="padding-10 padding-top-5 padding-bottom-5"><i class="fa fa-cog fa-lg fa-spin"></i> <strong>Administração</strong></a>
					</li>
				</ul>
			</li>
		</ul>

		<!-- logout button -->
		<div id="logout" class="btn-header transparent pull-right">
			<span> <a href="login.html" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
		</div>
		<!-- end logout button -->

        <!--<div id="carrinho" class="btn-header transparent pull-right hidden-sm hidden-xs" title="Carrinho">
            <div>
                <ul class="header-dropdown-list hidden-xs">
                    <li id="carrinhocompras">

                    </li>
                </ul>
            </div>
        </div>-->


    </div>
	<!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->

<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
			
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="img/avatars/sunny.png" alt="me" class="online" /> 
				<span>
					john.doe 
				</span>
				<i class="fa fa-angle-down"></i>
			</a> 
			
		</span>
	</div>
	<!-- end user info -->

	<nav>
		<!-- 
		NOTE: Notice the gaps after each icon usage <i></i>..
		Please note that these links work a bit different than
		traditional href="" links. See documentation for details.
		-->

		<ul>
			<li>
				<a href="index.php" title="Comprando na Lojinha"><i class="fa fa-lg fa-fw fa-shopping-cart"></i> <span class="menu-item-parent">Loja</span></a>
			</li>

			<li>
				<a href="listaConsumo.php" title="Comprando na Lojinha"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Consumo</span></a>
			</li>

			<li>
				<a href="notas.php" title="Notas de Compra"><i class="fa fa-lg fa-fw fa-file"></i> <span class="menu-item-parent">Notas</span></a>
			</li>

			<?php if($_SESSION['administrador'] == 1) {?>
				<li>
					<a href="#" title="Dashboard"><i class="fa fa-lg fa-fw fa fa-cogs fa-spin"></i> <span class="menu-item-parent">Admin</span></a>
					<ul>
						<li>
	                        <a href="grid_produtos.php" title="Cadastrar Produto">Produtos</a>
	                    </li>
	                    <li>
	                        <a href="grid_usuarios.php" title="Cadastra Usuário">Usuários</a>
	                    </li>

						<li>
	                        <a href="graficoConsumo.php" title="Gráfico Consumo Mensal">Gráfico</a>
	                    </li>

	                    <li>
	                        <a href="relatoriosProdutos.php" target="_blank" title="Relatórios Produtos">Rel. Produtos</a>
	                    </li>

	                    <li>
	                        <a href="relatoriosUsuario.php" target="_blank" title="Relatórios Usuários Consumo">Rel. Usuários</a>
	                    </li>

						<li>
							<a href="muralvergonha.php" target="_blank" title="Mural da Vergonha">Mural da Vergonha</a>
						</li>

						<li>
							<a href="qrcode.php" target="_blank" title="Gerar QRCode Pagina">QRCode Loja</a>
						</li>

                        <li>
                            <a href="ranking.php" target="_blank" title="Rancking">Rancking</a>
                        </li>
					</ul>
				</li>
			<?php } ?>

			<li id="carrinho" class="hidden">
				<a href="#"><i class="fa fa-lg fa-fw fa-shopping-basket"id="totalCesta"></i> <span class="menu-item-parent">Cesta</span><b class="collapse-sign"><em class="fa fa-minus-square-o"></em></b></a>
				<ul style="display: block;" id="carrinhocompras">

				</ul>
			</li>
		</ul>
	</nav>
	

	<span class="minifyme" data-action="minifyMenu"> 
		<i class="fa fa-arrow-circle-left hit"></i> 
	</span>

</aside>
<!-- END NAVIGATION -->

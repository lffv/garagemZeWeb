<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link href="<?php echo base_url(); ?>css/reset.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/flexigrid/css/flexigrid.css" />

		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/autoNumeric-1.7.5.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/lib.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>js/flexigrid/flexigrid.js"/></script>

		<title>Garagem do Zé</title>
	</head>
	<body>

		<div class="megadiv">
		
			<div class="header">

				<a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>images/logo.png" class="logo" /></a>
				
				<img src="<?php echo base_url(); ?>images/addAnuncio2.png" width="120px" id="imgaddanuncio" 
					style="<?php if(!$temLogin) echo 'display: none;'; ?>"/>
				
				<div id="divlog" class="login"<?php if($temLogin) echo ' style="display: none;"'; ?>>

					<div class="dlogin">
						<form id="frmlog">
						<p class="tus">
							<label for="nuser">Utilizador:</label>
							<input type="text" id="nuser" name="nuser" class="w200"/>
						</p>
						<p class="tus">
							<label for="puser">Password:</label>
							<input type="password"" id="puser" name="puser" class="w200"/>
						</p>
						<p class="tbt">
							<input id="btnreg" type="button" value="Registar" />
							<input class="tus" type="submit" value="Login" />
						</p>
						<p>
						</p>
						</form>
					</div>	
				</div>
				
					<div id="usrdados" class="login"<?php if(!$temLogin) echo ' style="display: none;"'; ?>>
						
						<div class="dlogin mtop10">
	
							<p class="tus" id="pbemvindo">
								<?php echo isset($dadosUser['nu']) ? 'Bem Vindo, '.$dadosUser['nu'].'<br />Feedback:'.$dadosUser['feedback'] : ""; ?> 
							</p>
							<p class="tus">
								<a href="<?php echo base_url(); ?>areapessoal"><input type="button" value="Área Pessoal" /></a>
								<a href="<?php echo base_url(); ?>home/logout"><input type="button" value="Logout" /></a>
							</p>
	
						</div>
					</div>
	
			</div>
			
			<div class="content">

				<div class="detailAnuncio">
					
					<div style="margin: 20px 0 0 15px;">
						<table id="tabelaCategorias" style="display: none;"></table>
					</div>
				</div>

				<div class="categorias">

					<?php
					
						foreach($categorias as $k => $v){

							// Pai:
							
							echo '<br /><p><a href="'.base_url().'detailscategoria/index/'.$k.'">'.$v["nome"].'</a></p><br />';
							
							foreach($v["filhos"] as $k2 => $v2){
								
								// Filhos
								
								echo '<p> &nbsp;&nbsp;&nbsp; &rArr; <a href="'.base_url().'detailscategoria/index/'.$k2.'">'.$v2.'</a></p>';
								
							}
							
						}

					?>

				</div>
			
			</div>
		
		</div>
		
	</body>
</html>


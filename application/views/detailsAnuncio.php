<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link href="<?php echo base_url(); ?>css/reset.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/autoNumeric-1.7.5.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/lib.js"></script>

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
					<img id="imgAnuncio" src="<?php echo base_url(); ?>imganuncios/<?php echo isset($an->IMG) ? $an->IMG : 'default.gif'; ?>" style="max-width: 360px; max-height: 250px; margin: 5px 0 0 2px;" />
					<table class="tabAnuncio" style="">
						<tr>
							<td>
								<?php echo $an->T; ?>
							</td>
							<td style="text-align: right;">
								<?php echo $an->P; ?> €
							</td>
						</tr>
						<tr><td><br /></td><td></td></tr>
						<tr>
							<td>
								Criado a: <?php echo $an->DC; ?>
							</td>
							<td style="text-align: right;">
								Fecho:<?php echo $an->DF; ?>
							</td>
						</tr>
						<tr><td><br /></td><td></td></tr>
						<tr>
							<td>
								Estado: <?php
								
								if($an->E==2) echo 'Terminado';
								else{
									$exp = strtotime(str_replace(".", "-", $an->DF)) < strtotime(date("y-m-d"));
									if($exp) echo "Expirado";
									else{
										if($an->E==0) echo 'Em curso';
										elseif($an->E==1) echo 'Em leilão';
									}
								}
								
								?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<th>Descrição Anuncio:</th>
						<tr>

							<td colspan="2">
								 <textarea readonly="readonly" " style="width: 340px; height: 60px;"><?php echo $an->D; ?></textarea>
							</td>

						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								Pagamento: 
								<select id="selpagamento" name="selpagamento">
									<option value="1">Carteira</option>
									<option value="2">Combinar com o Vendedor</option>
								</select>
							</td>
							<td style="vertical-align: bottom;">
								<input style="cursor: pointer;" id="btncomprar" type="button" value="Comprar Já"/>
							</td>
						</tr>
						<tr><td><br /></td><td></td></tr>
						<tr>
							<td>
								Licitação: <input type="text" id="txtlicitar" style="width: 122px;" value="<?php echo $lic; ?>"/>
							</td>

							<td>
								<input style="cursor: pointer; width: 92px;" id="btnlicitar" type="button" value="Licitar"/>
							</td>
								
						</tr>
						<tr><td><br /></td><td></td></tr>
						<tr>
							<td colspan="2">
								<div class="payDest" >
									<img style="float:right;cursor: pointer;" id="imginter" src="<?php echo base_url(); ?>images/star<?php if(!$temInteresse) echo 'gray'; ?>.jpg"/>
									<a name="januser" href="home/janeladetutilizador/<?php echo $an->U; ?>">
										<img style="float:right;" class="userDest" src="<?php echo base_url(); ?>images/user32.png"/>
									</a>
								
								</div>
							</td>
						</tr>
						
					</table>

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


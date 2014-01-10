<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link href="./css/reset.css" rel="stylesheet" type="text/css">
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="./js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		
		<script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="./js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		
		<link rel="stylesheet" type="text/css" href="./js/flexigrid/css/flexigrid.css" />
		<script type="text/javascript" src="./js/flexigrid/flexigrid.js"/></script>
		
		<script type="text/javascript" src="./js/lib.js"></script>

		<title>Garagem do Zé</title>
	</head>
	<body>
		
		<div class="megadiv">
		
			<div class="header">
	
				<a href="home"><img src="./images/logo.png" class="logo" /></a>
				<img src="./images/addAnuncio2.png" width="120px" id="imgaddanuncio" />
				<div id="usrdados" class="login"<?php if(!$temLogin) echo ' style="display: none;"'; ?>>
					
					<div class="dlogin mtop10">

						<p class="tus" id="pbemvindo">
							<?php echo isset($dadosUser['nu']) ? 'Bem Vindo, '.$dadosUser['nu'].'<br />Feedback:'.$dadosUser['feedback'] : ""; ?> 
						</p>
						<p class="tus">
							<a href="./areapessoal"><input type="button" value="Área Pessoal" /></a>
							<a href="./home/logout"><input type="button" value="Logout" /></a>
						</p>

					</div>
				</div>
			
			<div class="content">
			
				<div class="areapessoal">
					
					<table id="tabarea">
						
						<tr>
							<th class="">Nome de Utilizador: </th>
							<td><?php echo $dadosUser["u"]; ?></td>
						</tr>
						
						<tr>
							<th>Nome Completo: </th>
							<td><?php echo $dadosUser["nu"]; ?></td>
						</tr>
						
						<tr>
							<th>Data de Nascimento: </th>
							<td><?php echo $dadosUser["dn"]; ?></td>
						</tr>
						
						<tr>
							<th>Morada: </th>
							<td><?php echo $dadosUser["m"]; ?></td>
						</tr>
						
						<tr>
							<th>Freguesia: </th>
							<td><?php echo $dadosUser["nomef"]; ?></td>
						</tr>
						
						<tr>
							<th>Cod. Postal: </th>
							<td colspan="6"><?php echo $dadosUser["cp"]; ?></td>
						</tr>
						<tr>
							<th>Email: </th>
							<td colspan="6"><?php echo $dadosUser["e"]; ?></td>
						</tr>
						<tr>
							<th>Saldo: </th>
							<td colspan="6"><?php echo $saldo; ?> €</td>
						</tr>
					</table>
					<table id="tabareabuttons" >
						<tr>
							<th>Vendas</th>
							<th>Compras</th>
							<th class="lnk" id="interesses">Interesses</th>
							<th>Carteira</th>
							<th>FeedBack</th>
						</tr>
						<tr class="listaarea">
							<td class="lnk" id="vendasdecorrer">Em curso</td>
							<td class="lnk" id="comprasEfectuadas">Efectuadas</td>
							<td></td>
							<td class="lnk" id="carteira">Movimentos</td>
							<td class="lnk" id="feedbackAtribuir">Atribuido</td>
						</tr>
						<tr class="listaarea">
							<td class="lnk" id="vendasTerminadas" >Terminadas</td>
							<td class="lnk" id="comprasCurso">Leilões em curso</td>
							<td></td>
							<td id="levSaldo" style="cursor: pointer;">Levantar Saldo</td>
							<td class="lnk" id="feedbackPorAtribuir">Por Atribuir</td>
						</tr>
						<tr class="listaarea">
							<td></td>
							<td></td>
							<td></td>
							<td id="carSaldo" style="cursor: pointer;">Carregar Conta</td>
							<td class="lnk" id="feedbackRecebido" >Recebido</td>
						</tr>
					</table>	

				</div>
				
				<div class="categorias">
					
					<?php
					
						foreach($categorias as $k => $v){
								
							// Pai:
							
							echo '<br /><p><a href="./detailscategoria/index/'.$k.'">'.$v["nome"].'</a></p><br />';
							
							foreach($v["filhos"] as $k2 => $v2){
								
								// Filhos
								
								echo '<p> &nbsp;&nbsp;&nbsp; &rArr; <a href="./detailscategoria/index/'.$k2.'">'.$v2.'</a></p>';
								
							}
							
						}
					
					?>

				</div>
			
			</div>
		
		</div>
		
	</body>
</html>


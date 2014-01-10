<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link href="./css/reset.css" rel="stylesheet" type="text/css">
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="./js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/jquery-ui-1.9.2.custom.min.css" type="text/css" media="screen" />

		<script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="./js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="./js/autoNumeric-1.7.5.js"></script>
		<script type="text/javascript" src="./js/jquery.iframe-post-form.js"></script>
		<script type="text/javascript" src="./js/lib.js"></script>

		<title>Garagem do Zé</title>
	</head>
	<body>

		<div class="megadiv">

			<div class="header">

				<a href="home"><img src="./images/logo.png" class="logo" /></a>
				
				
				<img src="./images/addAnuncio2.png" width="120px" id="imgaddanuncio" 
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
								<a href="./areapessoal"><input type="button" value="Área Pessoal" /></a>
								<a href="./home/logout"><input type="button" value="Logout" /></a>
							</p>
	
						</div>
					</div>
	
			</div>
			
			<div class="content">
			
				<div class="destaques">
					<table class="tabDestaques">
						
						<tr class="linhaDestaques">

							<td class="colDestaques">
								
								<?php if(isset($destaques[0])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[0]->IMG) ? $destaques[0]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">

									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[0]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[0]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>

								<?php } ?>
								
							</td>
						
							<td class="colDestaques" >
								
								<?php if(isset($destaques[1])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[1]->IMG) ? $destaques[1]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[1]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[1]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							<td class="colDestaques" >
								
								<?php if(isset($destaques[2])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[2]->IMG) ? $destaques[2]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">									
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[2]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[2]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							</td>
						</tr>
						<tr class="linhaDestaques">
							
							<td class="colDestaques" >
								
								<?php if(isset($destaques[3])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[3]->IMG) ? $destaques[3]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[3]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[3]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							</td>
						
							<td class="colDestaques" >
								
								<?php if(isset($destaques[4])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[4]->IMG) ? $destaques[4]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[4]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[4]->U; ?>">
											<img class="userDest" src="images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							<td class="colDestaques" >
								
								<?php if(isset($destaques[5])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[5]->IMG) ? $destaques[5]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[5]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[5]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							</td>
						</tr>
						<tr class="linhaDestaques">
							
							<td class="colDestaques" >
								
								<?php if(isset($destaques[6])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[6]->IMG) ? $destaques[6]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[6]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[6]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							</td>
						
							<td class="colDestaques" >
								
								<?php if(isset($destaques[7])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[7]->IMG) ? $destaques[7]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[7]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[7]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							<td class="colDestaques" >
								
								<?php if(isset($destaques[8])) { ?>
								
								<img class="imgDestaque" src="./imganuncios/<?php echo isset($destaques[8]->IMG) ? $destaques[8]->IMG : 'default.gif'; ?>" />
								<br/>
								<div class="buttonsDestaque">
									
									<div class="actionDest">	
										<a href="detailsanuncio/index/<?php echo $destaques[8]->A; ?>">
											<img class="detailsDest" src="./images/search32.png"/>
										</a>
										<a name="januser" href="home/janeladetutilizador/<?php echo $destaques[8]->U; ?>">
											<img class="userDest" src="./images/user32.png"/>
										</a>
									</div>
								</div>
								
								<?php } ?>
								
							</td>
							</td>
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


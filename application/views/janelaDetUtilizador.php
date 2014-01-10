
<div class="janelaDetUtilizador">
	<div id="titFormWin"> Detalhes Utilizador: <?php echo $uti->U; ?></div>
	</br>
	<table>
		<tr>
			<td>Nome:</td>
			<td><?php echo $uti->NU; ?></td>
		</tr>
		<tr>
			<td>Local:</td>
			<td><?php echo $uti->NF.' - '.$uti->NC; ?></td>
		</tr>
		<tr>
			<td>FeedBack:</td>
			<td>
				
				 
				
				<?php
				
				$num = round(floatval(str_replace(",", ".", $uti->FEED))); 
				  
				  for($i=0; $i<$num; $i++){
				  	echo '<img src="'.base_url().'images/star.jpg" width="15px"/>'; 
				  }
				
				?>
				
				&nbsp;( <?php echo $uti->FEED; ?> )
				
			</td>
		</tr>

	</table>
	</br>
		Contactar Utilizador:
		<form id="contactUser" name="contactUser">
			<p class="tus">
				<p for="tmsg">Titulo:</p>
				<input type="text" id="tmsg" name="tmsg" class="w200"/>
			</p>
		
		
			<p class="tus">
				<p for="dmsg">Descrição:</p>
				<textarea  rows="7" cols="20" id="dmsg" name="dmsg" class="w200"></textarea>
			</p>
			<p class="tus" >
				<input id="submitAddAnuncio" type="button" value="Enviar" />
			</p>
			
		
		</form>
	
</div>
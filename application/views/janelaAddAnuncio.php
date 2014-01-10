
<div class="janelaAddAnuncio">
	<div id="titFormWin"> Inserir Anuncio: </div>
	<?php $at["id"]="frmaddAnuncio"; echo form_open_multipart((base_url().'areapessoal/insereanuncio'),$at); ?>
		<p class="tus">
			<label for="tanuncio">Titulo:</label>
			<input type="text" id="tanuncio" name="tanuncio" class="w228"/>
		</p>
		<p class="tus">
			<label for="canuncio">Categoria:</label>
			<select name="canuncio" id="canuncio" class="w228">
				  <option disabled="disabled" selected="selected" value="">Selecciona uma Categoria</option>

				  <?php
				  
				  	foreach($categorias as $c){
				  		foreach($c["filhos"] as $k => $f){
							echo '<option value="'.$k.'">'.$f.'</option>';
						}
				  	}
				  
				  ?>

		 	</select>
		</p>
		<p class="tus">
			<label for="panuncio">Preço:</label>
			<input type="text" id="panuncio" name="panuncio" class="w228"/>
		</p>
		<p class="tus">
			<label for="danuncio">Descrição:</label>
			<textarea rows="7" id="danuncio" name="danuncio" class="w228"></textarea>
		</p>
		<p class="tus">
			<label for="ianuncio">Imagem:</label>
			<input type="file" name="ianuncio" id="ianuncio">
		</p>
		<p class="tus">
			<input id="submitAddAnuncio" type="button" value="Inserir" />
		</p>
		<p>
		</p>
		
	</form>

</div>

<div class="janelaRegUser">
	<div id="titFormWin"> Registo de Utilizador: </div>
	<br />
	<form id="regUser" name="regUser">
		<p class="tus">
			<label for="usern">Utilizador:</label>
			<input type="text" id="usern" name="usern" class="w200"/>
		</p>
		<p class="tus">
			<label for="unuser">Nome:</label>
			<input type="text" id="unuser" name="unuser" class="w200"/>
		</p>
		</p>
		<p class="tus">
			<label for="euser">Email:</label>
			<input type="text" id="euser" name="euser" class="w200"/>
		</p>
		<p class="tus">
			<label for="puser1">Password:</label>
			<input type="password" id="puser1" name="puser1" class="w200"/>
		</p>
		<p class="tus">
			<label for="puser2">Repita Password:</label>
			<input type="password" id="puser2" name="puser2" class="w200"/>
		</p>
		<p class="tus">
			<label for="dnuser">Data Nascimento:</label>
			<input type="text" id="dnuser" name="dnuser" class="w200"/>
		</p>
		<p class="tus">
			<label for="muser">Morada:</label>
			<input type="text" id="muser" name="muser" class="w200"/>
		</p>
		<p class="tus">
			<label for="diuser">Distritos:</label>
			<select name="diuser" id="diuser" class="w200">
				
				<option disabled="disabled" selected="selected" value="">Selecione um Distrito</option>

				<?php

					foreach ($distritos as $d) {
						
						echo '<option value="'.$d->C.'">'.$d->NC.'</option>';

					}
									
				?>
				
		 	</select>
		</p>
		<p class="tus">
			<label for="couser">Concelhos:</label>
			<select name="couser" id="couser" class="w200">

				<option disabled="disabled" selected="selected" value="">Selecione um Concelho</option>

		 	</select>
		</p>
		<p class="tus">
			<label for="fruser">Freguesia:</label>
			<select name="fruser" id="fruser" class="w200">
				<option disabled="disabled" selected="selected" value="">Selecione uma Freguesia</option>
		 	</select>
		</p>
		<p class="tus">
			<label for="cpuser">Cód. Postal:</label>
			<input type="text" id="cpuser" name="cpuser" class="w200"/>
		</p>
		<p class="tus">
			<input id="submitReg" type="submit"" value="Registar" />
		</p>
		<p>
		</p>
		
	</form>

</div>
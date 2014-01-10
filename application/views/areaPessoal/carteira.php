	
<script type="text/javascript">

	$(document).ready(function(){
		
		$("#tabelaMovimentos").flexigrid({
			url: './areapessoal/loadtabelamovimentos',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'mov.M', resizable: false, width : 20, sortable : true, align: 'left'},
				{display: 'Tipo de Movimento', name : 'tipo', resizable: false, width : 440, sortable : false, align: 'left'},
				{display: 'Valor', name : 'mov.V', resizable: false, width : 60, sortable : true, align: 'left'},
				{display: 'Data', name : 'mov.DM', resizable: false, width : 130, sortable : true, align: 'left'}
				],
			sortname: "mov.M",
			sortorder: "asc",
			usepager: true,
			title: 'Movimentos Efectuados',
			useRp: true,
			rp: 15,
			showTableToggleBtn: false,
			width: 700,
			height: 270,
			resizable: false,
			singleSelect: true
		}); 
		
	});
			
</script>

<div class="janelaFlexi">
	<table id="tabelaMovimentos" style="display: none;"></table>
</div>

	
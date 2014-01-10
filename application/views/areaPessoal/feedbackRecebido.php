	
<script type="text/javascript">

	$(document).ready(function(){
		
		$("#tabelaFeedRecebido").flexigrid({
			url: './areapessoal/loadtabelafeedbackRecebido',
			dataType: 'json',
			colModel : [
				{display: 'Anuncio', name : 'anu.T', resizable: false, width : 220, sortable : true, align: 'left'},
				{display: 'Recebido de', name : 'fe.UD', resizable: false, width : 80, sortable : true, align: 'left'},
				{display: 'Pontuação', name : 'fe.P', resizable: false, width : 50, sortable : true, align: 'left'},
				{display: 'Comentário', name : 'fe.C', resizable: false, width : 300, sortable : true, align: 'left'}
				],
			searchitems : [
				{display: 'Titulo', name : 'anu.T', isdefault: true},
				{display: 'Comentário', name : 'fe.C'}
				],
			sortname: "anu.T",
			sortorder: "asc",
			usepager: true,
			title: 'Feedback Recebido',
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
	<table id="tabelaFeedRecebido" style="display: none;"></table>
</div>

	
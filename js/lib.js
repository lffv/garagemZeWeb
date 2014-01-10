
$(document).ready(function(){
	
	var base = "http://localhost/";
	var parm = $(location).attr("href");

	function isValidEmailAddress(emailAddress) {
	    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	    return pattern.test(emailAddress);
	};

	if($("#txtlicitar").length>0){
		$("#txtlicitar").autoNumeric();
	    $("#txtlicitar").autoNumericSet(parseFloat($("#txtlicitar").val().replace(",",".")));
   	}

    function abrirJanela(caminho, titulo, tipo){
        $.fancybox({
            'href': base+caminho,
            'scrolling': 'no',
            'title': titulo,
            'padding': 0,
            'onComplete': function(){
            	
            	if(caminho=="home/janelaregisto"){

					$("#dnuser").datepicker({
						changeMonth: true,
            			changeYear: true,
            			dateFormat: "yy-mm-dd"
					});            		
            		
            	}
            	
            	if(caminho=="home/janelaAddAnuncio"){
            		$("#panuncio").autoNumeric();
            	}
            	
            }
        });
    }
    
   	if(parm.indexOf("detailscategoria/index/")>0){
		var catego = parm.substring(parm.indexOf("detailscategoria/index/")+23);

		$("#tabelaCategorias").flexigrid({
			url: base+'home/loadtabelacategorias/'+catego,
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'anu.A', resizable: false, width : 20, sortable : true, align: 'left'},
				{display: 'Titulo', name : 'anu.T', resizable: false, width : 243, sortable : true, align: 'left'},
				{display: 'Vendedor', name : 'uti.NU', resizable: false, width : 180, sortable : true, align: 'left'},
				{display: 'Preço', name : 'anu.P', resizable: false, width : 50, sortable : true, align: 'left'},
				{display: 'Estado', name : 'anu.E', resizable: false, width : 130, sortable : true, align: 'left'}
				],
			searchitems : [
				{display: 'Titulo', name : 'anu.T', isdefault: true},
				{display: 'Vendedor', name : 'uti.NU'}
				],
			sortname: "anu.A",
			sortorder: "asc",
			usepager: true,
			title: 'Anúncios da Categoria',
			useRp: true,
			rp: 5,
			showTableToggleBtn: false,
			width: 700,
			height: 200,
			resizable: false,
			singleSelect: true
		}); 
	
	}
    
    $('input, select, textarea, p').live("click",function(){
    	$(this).css("border","");
    });
    
	$("#btnreg").click(function(){
		abrirJanela("home/janelaregisto", "Registo de Utilizador");
	});	

	$("a[name=januser]").click(function(){
		abrirJanela($(this).attr("href"), "Dados do Utilizador");
		return false;
	});
	
	function isFloat(value){
	
	   if(isNaN(value)){
	     return false;
	   } else {
	      if(parseFloat(value)) {
	              return true;
	          } else {
	              return false;
	          }
	   }
	}
	
	$("#levSaldo").click(function(){
		
		var saldo=prompt("Indique a quantia a levantar:");
		
		if(saldo==null) return;
		
        if (isFloat(saldo)){
			var valor=parseFloat(saldo);

			if(valor>0){
				
				$.ajax({
				  type: "POST",
				  url: base+"areapessoal/levantasaldo",
				  data: {saldo: valor},
				  dataType: 'json'
				}).done(function(msg) {
	
				  if(msg=="20099"){
				  	alert("O saldo da sua conta não permite o levantamento!");
				  }else{
				  	alert("A quantia foi levantada");
				  	location.reload(true);
				  }

				});
				
			}else{
				alert("O valor tem de ser maior do que 0");
			}
			
		}else{
			alert("Erro no valor inserido");			
		}

		
	});
	
	$("#carSaldo").click(function(){
		
		var saldo=prompt("Indique a quantia a carregar:");
		
		if(saldo==null) return;
		
        if (isFloat(saldo)){
			var valor=parseFloat(saldo);

			if(valor>0){
				
				$.ajax({
				  type: "POST",
				  url: base+"areapessoal/carregasaldo",
				  data: {saldo: valor},
				  dataType: 'json'
				}).done(function(msg) {
	
				  alert("A quantia foi carregada");
				  location.reload(true);

				});
				
			}else{
				alert("O valor tem de ser maior do que 0");
			}
			
		}else{
			alert("Erro no valor inserido");			
		}

		
	});

	$("#imgaddanuncio").click(function(){
		abrirJanela("home/janelaAddAnuncio", "Inserir novo Anuncio");
	});
	
	$("#diuser").live("change",function(){

		// Limpa os concelhos e freguesias
		$("#couser, #fruser").find('option').remove().end();

		$("#couser").append('<option disabled="disabled" selected="selected">Selecione um Concelho</option>');
		$("#fruser").append('<option disabled="disabled" selected="selected">Selecione uma Freguesia</option>');
		
		$.getJSON(base+'home/jsonconcelhos', {d:$(this).val()}, function(data) {
		
		  $.each(data, function(key, val) {
		    $("#couser").append('<option value="'+val.C+'">'+val.NC+'</option>');
		  });
		
		});
		
	});
	
	$("#couser").live("change",function(){

		// Limpa os concelhos e freguesias
		$("#fruser").find('option').remove().end();

		$("#fruser").append('<option disabled="disabled" selected="selected">Selecione uma Freguesia</option>');
		
		$.getJSON(base+'home/jsonfreguesias', {c:$(this).val()}, function(data) {

		  $.each(data, function(key, val) {
		    $("#fruser").append('<option value="'+val.F+'">'+val.NF+'</option>');
		  });

		});

	});
	
	$("#regUser").live("submit",function(){

		var f=true;

		if($("#usern").val()==""){ $("#usern").css("border","1px solid red"); f=false; }
		if($("#unuser").val()==""){ $("#unuser").css("border","1px solid red"); f=false; }
		
		if($("#euser").val()=="" 
		|| !isValidEmailAddress($("#euser").val())){ $("#euser").css("border","1px solid red"); f=false; }

		if($("#puser1").val()==""){ $("#puser1").css("border","1px solid red"); f=false; }
		if($("#puser2").val()==""){ $("#puser2").css("border","1px solid red"); f=false; }
		
		if($("#puser1").val()!=$("#puser2").val()){ $("#puser1, #puser2").css("border","1px solid red"); f=false; }
		if(!$("#dnuser").datepicker("getDate")){ $("#dnuser").css("border","1px solid red"); f=false; }
		if($("#muser").val()==""){ $("#muser").css("border","1px solid red"); f=false; }
		if(!$("#diuser").val()){ $("#diuser").css("border","1px solid red"); f=false; }
		else $("#couser, #fruser").css("border","1px solid black");
		if(!$("#couser").val()){ $("#couser").css("border","1px solid red"); f=false; }
		if(!$("#fruser").val()){ $("#fruser").css("border","1px solid red"); f=false; }
		if($("#cpuser").val()==""){ $("#cpuser").css("border","1px solid red"); f=false; }

		if(f){

			$.ajax({
			  type: "POST",
			  url: base+"home/insereuser",
			  data: $(this).serializeArray(),
			  dataType: 'json'
			}).done(function(msg) {

			  if(msg.res==(-1)){
				alert("O Utilizador foi inserido com sucesso");
				$.fancybox.close();
			  }else if(msg.res==(-2)){
			  	alert("O Nome de Utilizador já existe");
			  }else if(msg.res==(-3)){
			  	alert("O Email inserido já existe");
			  }
			  else
				alert("Erro");
			  
			});

		}else alert("Campos Inválidos");

		return false;

	});

		
	$(".lnk").click(function(){
		
		abrirJanela("areapessoal/"+$(this).attr('id'), $(this).html());
	});
	
	$("#frmlog").submit(function(){
		
		var n = $("#nuser").val(),
			p = $("#puser").val(), 
			f=true;
			
		if(n==""){ $("#nuser").css("border","1px solid red"); f=false; }
		if(p==""){ $("#puser").css("border","1px solid red"); f=false; }
		
		if(f){
			
			$.ajax({
			  type: "POST",
			  url: base+"home/autenticaruser",
			  data: $(this).serializeArray(),
			  dataType: 'json'
			}).done(function(msg) {
				
				if(msg !="" && msg.res==1){
					$("#pbemvindo").html("Bem Vindo, " + msg.nome + '<br />'+"Feedback: "+msg.feedback);
					$("#divlog").hide();
					$("#usrdados, #imgaddanuncio").show();
				}else{
					alert("Dados de Login Inválidos");
				}
			  
			});
			
		}
		
		return false;
		
	});
	
	$("#submitAddAnuncio").live("click",function(){
		
		var f=true;

		if($("#tanuncio").val()==""){ $("#tanuncio").css("border","1px solid red"); f=false; }
		if(!$("#canuncio").val()){ $("#canuncio").css("border","1px solid red"); f=false; }
		var preco = $("#panuncio").autoNumericGet();
		if(preco==0){ $("#panuncio").css("border","1px solid red"); f=false; }
		if($("#danuncio").val()==""){ $("#danuncio").css("border","1px solid red"); f=false; }

		if($("#tmpnomeimg").length==0){
			$("#frmaddAnuncio").append('<input type="hidden" name="tmpnomeimg" id="tmpnomeimg" value="'+$("#ianuncio").val()+'" />');
			$("#frmaddAnuncio").append('<input type="hidden" name="tmppreco" id="tmppreco" value="'+preco+'" />');
		}else{
			$("#tmpnomeimg").val($("#ianuncio").val());
			$("#tmppreco").val(preco);
		}

		if(f){

			$("#frmaddAnuncio").iframePostForm({
				json: true,
				complete : function (msg){

							if(msg.code == (-1)){
								alert("O anuncio foi inserido com sucesso");
								$.fancybox.close();
								$(location).attr('href',base+'detailsanuncio/index/'+msg.message);
							}else{
								alert("Ocorreu o seguinte erro:\n\n"+msg.code+": "+msg.message);
							
							}
							
						}
			});

			$("#frmaddAnuncio").submit();

		}

		return false;
		
	});
	
	$("#imginter").click(function(){

		var parm = $(location).attr("href");
		var an = parm.substring(parm.indexOf("detailsanuncio/index/")+21);

		$.ajax({
			  type: "POST",
			  url: base+"home/fazinteresse",
			  data: {an: an}
			}).done(function(msg) {
				
				if(msg==(-1)) alert("Nao tem o login efectuado!");
				else if(msg==(-2)){
					$("#imginter").attr("src",base+"images/star.jpg");
				}
				else if(msg==(-3)){
					$("#imginter").attr("src",base+"images/stargray.jpg");
				}
				else alert("Ocorreu um Erro: "+msg);

		});
		
		return false;
		
	});
	
	$("#btncomprar").click(function(){

		var parm = $(location).attr("href");
		var an = parm.substring(parm.indexOf("detailsanuncio/index/")+21);
		
		var pag = $("#selpagamento").val();

		$.ajax({
			  type: "POST",
			  url: base+"home/compraranuncio",
			  data: {an: an, mp: pag}
			}).done(function(msg) {

				if(msg==(-1)) alert("Nao tem o login efectuado!");
				else if(msg==(-2)){ 
					alert("Parabéns! Acabou de comprar o Anuncio");
					location.reload(true); 
				}else if(msg==(20001)) alert("O Anuncio já foi vendido!");
				else if(msg==(20002)) alert("O Anuncio entrou em leilão, por favor licite!");
				else if(msg==(20004)) alert("A data de conclusao do anuncio foi ultrapassada!");
				else alert(msg);

		});
		
		return false;
		
	})
	
	$("#btnlicitar").click(function(){

		var parm = $(location).attr("href");
		var an = parm.substring(parm.indexOf("detailsanuncio/index/")+21);
		
		var pag = $("#selpagamento").val();
		
		var preco = $("#txtlicitar").autoNumericGet();

		if(preco<=0) $("#txtlicitar").css("border","1px solid red");
		else{
			$.ajax({
				  type: "POST",
				  url: base+"home/licitaranuncio",
				  data: {an: an, mp: pag, pr: preco}
				}).done(function(msg) {
	
					if(msg==(-1)) alert("Nao tem o login efectuado!");
					else if(msg==(-2)){ 
						alert("A sua licitação foi inserida com sucessso!");
						location.reload(true);
					}else if(msg==(20001)) alert("O Anuncio já foi vendido!");
					else if(msg==(20003)) alert("A Licitação é inferior ou igual à maior Existente!");
					else if(msg==(20004)) alert("A data de conclusao do anuncio foi ultrapassada!");
					else alert(msg);

			});
		}
		
		return false;
		
	})
	
});


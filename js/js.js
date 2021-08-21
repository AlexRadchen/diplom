/*
 
Здесь всего одна функция form_send - она отправляет полученные из формы данные на ту же страницу, на которой находится форма, ajax-запрос, чтобы форма не перезагружала страницу.

*/
function form_send(form)
{							  						  
	$('#'+form+' .status').html('<img src="/img/load.gif" width="20" height="20" />');  

	$.ajax({  
		type: 'POST',  
		url: location.pathname+location.search, 
		data: 'save=1&'+$('#'+form).serialize(), 
		cache: false,  
		timeout: 60000,
		success: function(html){  		
			$('#'+form+' .status').html(html);  
		},
		error: function(){				
			$('#'+form+' .status').html('');
			alert('Сервер не отвечает, попробуйте снова.');  
		}
	});
}
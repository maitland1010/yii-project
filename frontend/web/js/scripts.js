(function ($) {

	var cur_focus = -1;
	
	$(document).bind({
		click : function(e) {
			if(!$(e.target).closest('.multiple-dropdown').hasClass('multiple-dropdown'))
				$('.multiple-dropdown > label').next().removeClass('collapse-dropdownlist');
		},
		keydown : function(e){
			var code = e.keyCode || e.which; 
			if(code == 9) {
				$('.multiple-dropdown > label').next().removeClass('collapse-dropdownlist');
			}
		}
	});
	
	$('.multiple-dropdown > label').bind({
		click : function(){
			$(this).next().toggleClass('collapse-dropdownlist');
		},
	});
	
	$('.editable-dropdown .selection-list .select-arrow').bind({
		click : function(){
			$(this).next().next().toggle();
			$(this).next().next().find('li').show();
		},
	});
	
	$('.editable-dropdown .selection-list input').bind({
		keypress : function(e){
			var code = e.keyCode || e.which; 
			if(code == 13) {
				$(this).next().hide();
				return false;
			}
		},
		keydown : function (e) {
			var code = e.keyCode || e.which; 
			if(code == 9) {
				cur_focus = -1;
				var val = $(this).next().find('li.cur_focus').eq(0).html();
				$(this).next().hide();
				if(val != '' && typeof val !== "undefined") $(this).val(val);
				$(this).next().find('li').removeClass('cur_focus');
			}
		},
		keyup : function(e){
			var txt = $(this).val();
			var length = $(this).next().find('li:contains('+txt+')').length;
			$(this).next().find('li').hide();
			
			if(length > 0){
			$(this).next().show();
			}else{
				$(this).next().hide();
			}
			$(this).next().find('li:contains('+txt+')').show();
			
			var code = e.keyCode || e.which; 
			if(code == 40) {
				if(cur_focus >= length-1){
					cur_focus = -1;
				}
				$(this).next().find('li').removeClass('cur_focus');
				$(this).next().find('li:contains('+txt+')').eq(++cur_focus).addClass('cur_focus');
			}else if(code == 38) {
				if(cur_focus < 0){
					cur_focus = length-1;
				}
				$(this).next().find('li').removeClass('cur_focus');
				$(this).next().find('li:contains('+txt+')').eq(--cur_focus).addClass('cur_focus');
			}
		},
		focus : function(){
			$(this).next().show();
			$(this).next().find('li').show();
			$(this).next().find('li').removeClass('cur_focus');
		},
		blur : function(){
			$(this).next().hide();
			$(this).next().find('li').hide();
			var val = $(this).next().find('li.cur_focus').eq(0).html();
			if(val != '' && typeof val !== "undefined") $(this).val(val);
			$(this).next().find('li').removeClass('cur_focus');
		},
	});

	$(".editable-dropdown .selection-list li").bind({
		mouseenter : function(){
			$(this).parent().find('li').removeClass('cur_focus');
			$(this).addClass('cur_focus');
		},
		mouseleave : function(){
			$(this).parent().find('li').removeClass('cur_focus');
		},
		click : function(){
			$(this).parent().hide();
			$(this).parent().find('li').hide();
			var val = $(this).parent().find('li.cur_focus').eq(0).html();
			if(val != '' && typeof val !== "undefined") $(this).parent().prev().val(val);
			$(this).removeClass('cur_focus');
		},
	});	
	
	$('.autocomplete-box input.at-input').bind({ 
		keypress : function(e){
			var code = e.keyCode || e.which; 
			if(code == 13) {
				var name = $(this).attr('data-name');
				var color = '33CCFF';
				var val = $(this).val();
				if(val.length != 0){
					var size = val.length*10;
					var size_div = val.length*10+25;
					$(this).before('<div class="tag" style="background-color:#'+color+';width:'+size_div+'px"><input type="text" value="'+val+'" style="width:'+size+'px" readonly name="'+name+'[]" /><span>&times;</span></div>');
					$(this).next().hide();
					$(this).val('').focus();
					$(this).prev().find('span').click(function(){
						$(this).parent().remove();
					});
				}
				return false;
			}
		}, 
		keyup : function(e){
			var txt = $(this).val();
			var length = $(this).next().find('li:contains('+txt+')').length;
			$(this).next().find('li').hide();
			$(this).next().find('li:contains('+txt+')').show();
			if(length > 0 && txt != ''){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
			var code = e.keyCode || e.which; 
			if(code == 40) {
				if(cur_focus >= length-1){
					cur_focus = -1;
				}
				$(this).next().find('li').removeClass('cur_focus');
				$(this).next().find('li:contains('+txt+')').eq(++cur_focus).addClass('cur_focus');
			}else if(code == 38) {
				if(cur_focus < 0){
					cur_focus = length-1;
				}
				$(this).next().find('li').removeClass('cur_focus');
				$(this).next().find('li:contains('+txt+')').eq(--cur_focus).addClass('cur_focus');
			}
		},
		keydown : function(e){
			var code = e.keyCode || e.which; 
			if(code == 9) {
				cur_focus = -1;
				var cur_elm = $(this).next().find('li.cur_focus').eq(0);
				var val = cur_elm.html();
				$(this).next().hide();
				if(val != '' && typeof val !== "undefined") {
					var name = $(this).attr('data-name');
					var color = cur_elm.attr('data-color');
					var id = cur_elm.attr('data-id');
					var size = val.length*10;
					var size_div = val.length*10+25;
					$(this).before('<div class="tag" style="background-color:#'+color+';width:'+size_div+'px"><input type="text" value="'+val+'" style="width:'+size+'px" readonly name="'+name+'['+id+']" /><span>&times;</span></div>');
					$(this).next().hide();
					$(this).val('').focus();
					$(this).prev().find('span').click(function(){
						$(this).parent().remove();
					});
				}
				$(this).next().find('li').removeClass('cur_focus');
				return false;
			}
			if(code == 40) {
				return false;
			}else if(code == 38) {
				return false;
			}
		},
		blur : function(){
			cur_focus = -1;
			var cur_elm = $(this).next().find('li.cur_focus').eq(0);
			var val = cur_elm.html();
			$(this).next().hide();
			if(val != '' && typeof val !== "undefined") {
				var name = $(this).attr('data-name');
				var color = cur_elm.attr('data-color');
				var id = cur_elm.attr('data-id');
				var size = val.length*10;
				var size_div = val.length*10+25;
				$(this).before('<div class="tag" style="background-color:#'+color+';width:'+size_div+'px"><input type="text" value="'+val+'" style="width:'+size+'px" readonly name="'+name+'['+id+']" /><span>&times;</span></div>');
				$(this).next().hide();
				$(this).val('').focus().next().find('li').removeClass('cur_focus');
				$(this).prev().find('span').click(function(){
					$(this).parent().remove();
				});
			}
		},
	});

	$('.autocomplete-box ul li').bind({ 
		mouseenter : function(){
			$(this).parent().find('li').removeClass('cur_focus');
			$(this).addClass('cur_focus');
		},
		mouseleave : function(){
			$(this).parent().find('li').removeClass('cur_focus');
		},
	});	
	
	$('.action-btn').bind({
		click : function(){
			var action = $(this).attr('data-action');
			var url_ajax = $(this).attr('data-url');
			var grid_id = $(this).closest('.grid-view').attr('id');
			
			if(action == 'add'){
				var cur_row = $(this).parent().parent('.editable-row');
				var del_url = cur_row.attr('data-del-url');
				var edit_url = cur_row.attr('data-edit-url');
				var inputs = cur_row.find('input');
				var datas = [];
				var keys = [];
				inputs.each(function(i,e){
					datas[i] = {"name": $(this).attr('name'), "value": $(this).val()};
					keys[i] = $(this).attr('name');
				});
				$.ajax({
				  type: "POST",
				  url: url_ajax,
				  data: datas,
				})
				.done(function( response ) {
					var rs = JSON.parse(response);
					var datas = rs.datas;
					if(rs.status == true){
						/*
						var tr = $('<tr></tr>'); 
						tr.attr('data-key',rs.id)
						tr.attr('data-url',edit_url)
						for(var i = 0;i < keys.length;i++){
							var input = '<input type="text" value="'+datas[keys[i]]+'" name="'+keys[i]+'" readonly=readonly class="editable-input">';
							tr.append("<td>"+input+"</td>");
						}
						tr.append("<td><button class='action-btn' data-url='"+del_url+"' data-action='delete'>delete</button></td>");
						tr.find('input.editable-input').each(function(){
							editableItem($(this));
						});
						tr.find('button.action-btn').each(function(){
							deleteItem($(this));
						});
						//$('.editable-body').prepend(tr);*/
						$.pjax.reload({container:'#'+grid_id});
						alert(rs.msg);
					}else{
						alert(rs.msg);
					}
				});
			}else if(action == 'edit'){
			
			}else if(action == 'delete'){
				var url_ajax = $(this).attr('data-url');
				var cur_row = $(this).parent().parent();
				var id = cur_row.attr('data-key');
				$.ajax({
				  type: "POST",
				  url: url_ajax,
				  data: {'id':id},
				})
				.done(function( response ) {
					var rs = JSON.parse(response);
					var datas = rs.datas;
					if(rs.status == true){
						//cur_row.remove();
						$.pjax.reload({container:'#'+grid_id});
						alert(rs.msg);
					}else{
						alert(rs.msg);
					}
				});
			}
		},
	});
	
	$('.editable-input').bind({
		dblclick : function(){
			if($(this).attr("readonly") == 'readonly'){
				$(this).attr("readonly",false);
			}
		},
		focus : function(){
			if($(this).attr("readonly") == 'readonly'){
				$(this).attr("readonly",false);
			}
		},
		keypress : function(e){
			var code = e.keyCode || e.which;
			if(code == 13) {
				var cur_row = $(this).parent().parent();
				var url_ajax = cur_row.attr('data-url');
				var inputs = cur_row.find('input');
				var datas = [];
				var keys = [];
				inputs.each(function(i,e){
					datas[i] = {name: $(this).attr('name'), value: $(this).val()};
					keys[i] = $(this).attr('name');
				});
				inputs.attr("readonly",true);
				$.ajax({
				  type: "POST",
				  url: url_ajax,
				  data: datas,
				})
				.done(function( response ) {
					var rs = JSON.parse(response);
					var datas = rs.datas;
					if(rs.status == true){
						alert(rs.msg);
					}else{
						alert(rs.msg);
					}
				});
				return false;
			}
		},
		blur : function(){
			var cur_row = $(this).parent().parent();
				var url_ajax = cur_row.attr('data-url');
				var inputs = cur_row.find('input');
				var datas = [];
				var keys = [];
				inputs.each(function(i,e){
					datas[i] = {name: $(this).attr('name'), value: $(this).val()};
					keys[i] = $(this).attr('name');
				});
				$(this).attr("readonly",true);
				$.ajax({
				  type: "POST",
				  url: url_ajax,
				  data: datas,
				})
				.done(function( response ) {
					var rs = JSON.parse(response);
					var datas = rs.datas;
					if(rs.status == true){
						alert(rs.msg);
					}else{
						alert(rs.msg);
						return false;
					}
				});
		}
	});
	/*
	function editableItem(elm){
		elm.dblclick(function(){
			if($(this).attr("readonly") == 'readonly'){
				$(this).attr("readonly",false);
			}
		});
		
		elm.keypress(function(e){
			var code = e.keyCode || e.which; 
			if(code == 13) {
				var cur_row = $(this).parent().parent();
				var url_ajax = cur_row.attr('data-url');
				var inputs = cur_row.find('input');
				var datas = [];
				var keys = [];
				inputs.each(function(i,e){
					datas[i] = {name: $(this).attr('name'), value: $(this).val()};
					keys[i] = $(this).attr('name');
				});
				inputs.attr("readonly",true);
				$.ajax({
				  type: "POST",
				  url: url_ajax,
				  data: datas,
				})
				.done(function( response ) {
					var rs = JSON.parse(response);
					var datas = rs.datas;
					if(rs.status == true){
						alert(rs.msg);
					}else{
						alert(rs.msg);
					}
				});
				return false;
			}
		});
	}
	
	function deleteItem(elm){
		elm.click(function(){
			var url_ajax = $(this).attr('data-url');
			var cur_row = $(this).parent().parent();
			var id = cur_row.attr('data-key');
			$.ajax({
			  type: "POST",
			  url: url_ajax,
			  data: {'id':id},
			})
			.done(function( response ) {
				var rs = JSON.parse(response);
				var datas = rs.datas;
				if(rs.status == true){
					cur_row.remove();
					alert(rs.msg);
				}else{
					alert(rs.msg);
				}
			});
		});
	}
	*/
})(window.jQuery);
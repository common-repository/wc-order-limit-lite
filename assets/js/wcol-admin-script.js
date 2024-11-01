
jQuery(document).ready(function($){
	"use strict";		
	/* JS for tabs*/
	$("form :input").on('change',function() {
	  $(this).closest('form').addClass('xs-changed');
	});
	$("select").on('change',function() {
	  $(this).closest('form').addClass('xs-changed');
	});
	$('nav.wcol-nav a.nav-tab').on('click',function(e){
		var	url	= $(this).attr('href');
		e.preventDefault();
		if($('form').hasClass('xs-changed')) {
			$('#wcol-modal').show();
			$('#wcol-modal-close').on('click',function(){
				$('#wcol-modal').hide();
				return;
			});

			$('#wcol-modal-pwos').on('click',function(){
				$('#wcol-modal').hide();
				location.replace(url);
			});

			$('#wcol-modal-sbp').on('click',function(){
				$('#wcol-modal').hide();
				$('input[type="submit"]').trigger( "click" );
				location.replace(url);
			});

  		}else{
  			location.replace(url);
  		}
	});
	$('.wcol-select-products').select2({
		placeholder: 'Select Products',
		data:wcol_script_vars.products,
		width:"95%",
		multiple:true
	});
	$('.wcol-select-categories').select2({
		placeholder: 'Select Categories',
		data:wcol_script_vars.categories,
		width:"95%",
		multiple:true
	});
	$('#wcol-add-product-rule').on('click', function(){
		$(this).closest('form').addClass('xs-changed');
		$('.wcol-rule-options').addClass('wcol-hidden');
		$('.wcol-hide-more-options').addClass('wcol-hidden');
		$('.wcol-show-more-options').removeClass('wcol-hidden');
		$('.wcol-options-open').addClass('wcol-hidden');
		$('table.wcol-collapsed').removeClass('wcol-collapsed');
		$('.wcol-new').removeClass('wcol-new');
		var table = $(this).parent().parent().find('table.wp-list-table').find('tbody.wcol-main-body');
		var spinner = $(this).closest('.wcol-actions-btn').find('.wcol_spinner');
		spinner.closest('form').css('pointer-events','none');
		spinner.addClass('wcol_is_active');
		var wcol_rid = $(".xswcol-pid").val();
		$.ajax({
			url: wcol_script_vars.ajax_url,
			type:'post',
			data:{'action':'wcol_load_new_row', '_wcol_new_rule_nonce': $('#_wcol_new_rule_nonce').val(), 'row_for':'product' , 'wcol_pid': wcol_rid},
			success: function(res){
				wcol_rid++;
				$(".xswcol-pid").val(wcol_rid);
				$(table).append(res);
				$('.wcol-new .wcol-select-products').select2({
					placeholder: 'Select Products',
					data:wcol_script_vars.products,
					width:"95%",
					multiple:true,
				});
				$('.wcol-new .wcol-select-users').select2({
					placeholder: 'Select Users',
					data:wcol_script_vars.users,
					width:"95%",
					multiple:true
				});
				
				$('.wcol-new .wcol-select-roles').select2({
					placeholder: 'Select Roles',
					data:wcol_script_vars.user_roles,
					width:"95%",
					multiple:true
				});
				
			}
		}).always(function(jqXHR, textStatus, errorThrown){
			if(textStatus !== 'success'){
				alert(errorThrown);
			}
			spinner.closest('form').css('pointer-events','auto');
			spinner.removeClass('wcol_is_active');
		});
		//$(table).append(new_product_html);
	});
	
	$('#wcol-add-category-rule').on('click', function(){
		$(this).closest('form').addClass('xs-changed');
		$('.wcol-rule-options').addClass('wcol-hidden');
		$('.wcol-hide-more-options').addClass('wcol-hidden');
		$('.wcol-show-more-options').removeClass('wcol-hidden');
		$('.wcol-options-open').addClass('wcol-hidden');
		$('table.wcol-collapsed').removeClass('wcol-collapsed');
		var table = $(this).parent().parent().find('table.wp-list-table').find('tbody.wcol-main-body');
		$('.wcol-new').removeClass('wcol-new');
		var spinner = $(this).closest('.wcol-actions-btn').find('.wcol_spinner');
		spinner.closest('form').css('pointer-events','none');
		spinner.addClass('wcol_is_active');
		var wcol_rid = $(".xswcol-cid").val();
		$.ajax({
			url: wcol_script_vars.ajax_url,
			type:'post',
			data:{'action':'wcol_load_new_row', '_wcol_new_rule_nonce': $('#_wcol_new_rule_nonce').val(), 'row_for':'product_cat' , 'wcol_cid': wcol_rid},
			success: function(res){
				$(table).append(res);
				wcol_rid++;
				$(".xswcol-cid").val(wcol_rid);
				$('.wcol-select-categories').select2({
					placeholder: 'Select Categories',
					data:wcol_script_vars.categories,
					width:"95%",
					multiple:true
				});
			},
		}).always(function(jqXHR, textStatus, errorThrown){
			if(textStatus !== 'success'){
				alert(errorThrown);
			}
			spinner.closest('form').css('pointer-events','auto');
			spinner.removeClass('wcol_is_active');	
		});
		//$(table).append(new_category_html);		
	});
	
	$('.wcol-select-products').on('change',function(){
		var check = $.inArray("-1" , $(this).val() ); 
		if(check != "-1"){
			$(this).val(['-1']).trigger('change.select2');
		}
	});
	$('.wcol-select-categories').on('change',function(){
		var check = $.inArray("-1" , $(this).val() ); 
		if(check != "-1"){
			$(this).val(['-1']).trigger('change.select2');
		}
	});
	$('.wcol-select-all input').on('change', function(){
		if($(this).is(':checked')){
			$(this).parent().parent().parent().parent().find('.wcol-cb input').attr('checked', true);
		}else{
			$(this).parent().parent().parent().parent().find('.wcol-cb input').attr('checked', false);
		}
	});
	
	$('.wcol-delete-selected').on('click', function(){
		if(window.confirm(wcol_script_vars.text3)){
			$(this).parent().parent().parent().find('.wcol-cb input').each(function(){
				if($(this).is(':checked')){
					$(this).parent().parent().remove();
				}
			});
		}
	});
	$('.wp-list-table').on('click', '.wcol-show-more-options', function(e){
		e.preventDefault();
		$('.wcol-rule-options').addClass('wcol-hidden');
		$('.wcol-hide-more-options').addClass('wcol-hidden');
		$('.wcol-show-more-options').removeClass('wcol-hidden');
		$('.wcol-options-open').addClass('wcol-hidden');
		
		var position_top = $(this).position().top-10;
		var position_top2 = position_top+1;
		var bgc = $(this).parent().parent().parent().css('background-color');
		if(bgc=='rgba(0, 0, 0, 0)'){
			bgc = 'white';
		}
		
		$(this).addClass('wcol-hidden');
		$(this).parent().find('.wcol-hide-more-options').removeClass('wcol-hidden');
		
		$(this).parent().find('.wcol-options-open').removeClass('wcol-hidden');
		$(this).parent().find('.wcol-rule-options').removeClass('wcol-hidden');
		$(this).parent().parent().parent().parent().parent().addClass('wcol-collapsed');
		$(this).parent().parent().parent().parent().parent().parent().find('.wcol-actions-btn').addClass('wcol-collapsed');
		$(this).parent().find('.wcol-rule-options').attr('style','top:'+position_top+'px ; background-color:'+bgc+';');
		$(this).parent().find('.wcol-options-open').attr('style','top:'+position_top2 +'px ; background-color:'+bgc+';');
		$(this).parent().find('.wcol-options-open').attr('style','top:'+position_top2 +'px ; background-color:'+bgc+'; height:'+$(this).closest('tr').height()+'px ;');
	});
	
	$('.wp-list-table').on('click', '.wcol-hide-more-options', function(e){
		e.preventDefault();
		$(this).parent().find('.wcol-show-more-options').removeClass('wcol-hidden');
		$(this).addClass('wcol-hidden');
		$(this).parent().find('.wcol-options-open').addClass('wcol-hidden');
		$(this).parent().find('.wcol-rule-options').addClass('wcol-hidden');
		$('table.wcol-collapsed').removeClass('wcol-collapsed');
		$('div.wcol-collapsed').removeClass('wcol-collapsed');
	});
	
	$('.enable-cart-total-max-rule-limit').on('change', function(){
		if($(this).is(':checked')){
				$(this).parent().parent().parent().find('.wcol-rule-max-limit').parent().parent().removeClass('wcol-hidden');
		}else{
			$(this).parent().parent().parent().find('.wcol-rule-max-limit').parent().parent().addClass('wcol-hidden');
		}
	});
	$('.wp-list-table , #wcol_tab , .form-table').on('change', '.enable-max-rule-limit' , function(){
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0 ){
			if($(this).is(':checked')){
				$(this).parent().parent().find('.wcol-rule-max-limit').parent().removeClass('wcol-hidden');
			}else{
				$(this).parent().parent().find('.wcol-rule-max-limit').parent().addClass('wcol-hidden');
			}
		}else if( window.location.href.indexOf('term.php') > 0 || window.location.href.indexOf('edit-tags.php') > 0 ){
			if($(this).is(':checked')){
				$(this).parent().parent().find('.wcol-rule-max-limit').parent().removeClass('wcol-hidden');
			}else{
				$(this).parent().parent().find('.wcol-rule-max-limit').parent().addClass('wcol-hidden');
			}
		}else{	
			if($(this).is(':checked')){
				$(this).parent().parent().parent().find('.wcol-rule-max-limit').parent().parent().removeClass('wcol-hidden');
			}else{
				$(this).parent().parent().parent().find('.wcol-rule-max-limit').parent().parent().addClass('wcol-hidden');
			}
		}
	});
		
	$('.wp-list-table , #wcol_tab , .form-table').on('change', '.wcol-loop-checkbox', function(){
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0 ){
			if($(this).is(':checked')){
				$(this).closest('p.form-field').find('.wcol-loop-checkbox-hidden').val('on');
			}else{
				$(this).closest('p.form-field').find('.wcol-loop-checkbox-hidden').val('');
			}
		}else if( window.location.href.indexOf('term.php') > 0 || window.location.href.indexOf('edit-tags.php') > 0 ){
			if($(this).is(':checked')){
				$(this).closest('p.form-field').find('.wcol-loop-checkbox-hidden').val('on');
			}else{
				$(this).closest('p.form-field').find('.wcol-loop-checkbox-hidden').val('');
			}
		}else{
			if($(this).is(':checked')){
				$(this).parent().find('.wcol-loop-checkbox-hidden').val('on');
			}else{
				$(this).parent().find('.wcol-loop-checkbox-hidden').val('');
			}
		}
	});
	$('.wcol_edit_rule').on('change', function(){
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0 ){
			if($(this).is(':checked') && $(this).closest('.wc-metabox-content').find('.wcol_accomulative').val() != ''){
				$(this).closest('.wc-metabox').removeClass('wcol_accomulative_rule');
				$(this).closest('.wc-metabox-content').find('.wcol_accomulative').val('');
			}else{
				$(this).closest('.wc-metabox').addClass('wcol_accomulative_rule');
				$(this).closest('.wc-metabox-content').find('.wcol_accomulative').val('on');
			}
		}else{
			if($(this).is(':checked') && $(this).closest('.wcol_single_cat_rule').find('.wcol_accomulative').val() != ''){
				$(this).closest('.wcol_single_cat_rule').removeClass('wcol_accomulative_rule');
				$(this).closest('.wcol_single_cat_rule').find('.wcol_accomulative').val('');
			}else{
				$(this).closest('.wcol_single_cat_rule').addClass('wcol_accomulative_rule');
				$(this).closest('.wcol_single_cat_rule').find('.wcol_accomulative').val('on');
			}
		}
		
	});
	$('#wcol_add_new_rule').on('click', function(e){
		e.preventDefault();
		$(this).closest('form').addClass('xs-changed');
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0 ){
			$('#wcol_tab  .wc-metaboxes .wc-metabox').removeClass('open').addClass('closed').find('.wc-metabox-content').hide();
			$('.wcol-new').removeClass('wcol-new');
			var spinner = $(this).closest('#wcol_tab').find('.wcol_spinner');
			spinner.closest('form').css('pointer-events','none');
			spinner.addClass('wcol_is_active');
			var wcol_rid = $(".xswcol-spid").val();
			wcol_rid++;
			$.ajax({
				url: wcol_script_vars.ajax_url,
				type:'post',
				data:{'action':'wcol_load_new_row', '_wcol_new_rule_nonce': $('#_wcol_new_rule_nonce').val(), 'row_for':'single_product', 'wcol_spid': wcol_rid },
				success: function(res){
					$(".xswcol-spid").val(wcol_rid);
					$('#wcol_tab .wc-metaboxes').append(res);
					$('.wcol-new .wcol-select-users').select2({
						placeholder: 'Select Users',
						data:wcol_script_vars.users,
						width:"95%",
						multiple:true
					});
					$('.wcol-new .wcol-select-roles').select2({
						placeholder: 'Select Roles',
						data:wcol_script_vars.user_roles,
						width:"95%",
						multiple:true
					});

				},
			}).always(function(jqXHR, textStatus, errorThrown){
				if(textStatus !== 'success'){
					alert(errorThrown);
				}
				spinner.closest('form').css('pointer-events','auto');
				spinner.removeClass('wcol_is_active');
			});
		}else{
			$('.wcol_single_cat_rules .wcol_single_cat_rule').removeClass('wcol_single_cat_rule_open').find('.wcol_cat_panel').slideUp();
			$('.wcol-new').removeClass('wcol-new');
			var spinner = $(this).parent().find('.wcol_spinner');
			spinner.closest('form').css('pointer-events','none');
			spinner.addClass('wcol_is_active');
			var wcol_rid = $(".xswcol-spcid").val();
			wcol_rid++;
			$.ajax({
				url: wcol_script_vars.ajax_url,
				type:'post',
				data:{'action':'wcol_load_new_row', '_wcol_new_rule_nonce': $('#_wcol_new_rule_nonce').val(), 'row_for':'single_product_cat' ,'wcol_spcid': wcol_rid},
				success: function(res){
					$(".xswcol-spcid").val(wcol_rid);
					$('.wcol_single_cat_rules').append(res);
					$('.wcol-new .wcol-select-users').select2({
						placeholder: 'Select Users',
						data:wcol_script_vars.users,
						width:"95%",
						multiple:true
					});
					$('.wcol-new .wcol-select-roles').select2({
						placeholder: 'Select Roles',
						data:wcol_script_vars.user_roles,
						width:"95%",
						multiple:true
					});
				},
			}).always(function(jqXHR, textStatus, errorThrown){
				if(textStatus !== 'success'){
					alert(errorThrown);
				}
				spinner.closest('form').css('pointer-events','auto');
				spinner.removeClass('wcol_is_active');
			});
		}
	});
	
	$('.wcol_cat_accordion').on('click', function(){
		if($(this).closest('.wcol_single_cat_rule').hasClass('wcol_single_cat_rule_open')){
			$(this).closest('.wcol_single_cat_rule').removeClass('wcol_single_cat_rule_open');
			$(this).closest('.wcol_single_cat_rule').find('.wcol_cat_panel').slideUp();
		}else{
			$(this).closest('.wcol_single_cat_rule').addClass('wcol_single_cat_rule_open');
			$(this).closest('.wcol_single_cat_rule').find('.wcol_cat_panel').slideDown();
		}
	});
	
	$('.wcol-delete').on('click', function(){
		var confirm_message = '';
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0 ){
			confirm_message = 'This will delete the rule when you will save/update the product!.';
		}else{
			confirm_message = 'This will delete the rule when you will save/update the category!.';
		}
		
		if( window.confirm(confirm_message) ){
			var rule_key = $(this).parent().parent().find('input[name="wcol_rules[wcol_rule_key][]"]').val();
			if(rule_key){
				$(this).parent().parent().addClass('wcol-deleted-rule').append('<input type="hidden" name="wcol_rules[wcol_deleted_rule_key][]" class="wcol_deleted_rule_key" value="'+rule_key+'">');
				$(this).removeClass('wcol-delete').addClass('wcol-undo').text('Undo');
			}else{
				$(this).parent().parent().remove();
			}
		}
	});
	
	$('.wcol-undo').on('click', function(){
		$(this).parent().parent().removeClass('wcol-deleted-rule').find('.wcol_deleted_rule_key').remove();
		$(this).removeClass('wcol-undo').addClass('wcol-delete').text('Delete');
	});
	
	$('.wp-list-table , #wcol_tab , .form-table').on('change','.wcol-disable-rule-limit', function(){
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0){
			if($(this).is(':checked')){
				$(this).closest('.wc-metabox-content').find('.enable-max-rule-limit').addClass('wcol-disabled');
				$(this).closest('.wc-metabox-content').find('.wcol-rule-max-limit').addClass('wcol-disabled');
				$(this).closest('.wc-metabox-content').find('.wcol-rule-min-limit').addClass('wcol-disabled');
				$(this).closest('.wc-metabox-content').find('.wcol-applied-on').addClass('wcol-disabled');	
				
				

			}else{
				$(this).closest('.wc-metabox-content').find('.enable-max-rule-limit').removeClass('wcol-disabled');
				$(this).closest('.wc-metabox-content').find('.wcol-rule-max-limit').removeClass('wcol-disabled');
				$(this).closest('.wc-metabox-content').find('.wcol-rule-min-limit').removeClass('wcol-disabled');
				$(this).closest('.wc-metabox-content').find('.wcol-applied-on').removeClass('wcol-disabled');	
			}
		}else if(window.location.href.indexOf('term.php') > 0 || window.location.href.indexOf('edit-tags.php') > 0){
			if($(this).is(':checked')){
				$(this).closest('.wcol_cat_panel').find('.enable-max-rule-limit').addClass('wcol-disabled');
				$(this).closest('.wcol_cat_panel').find('.wcol-rule-max-limit').addClass('wcol-disabled');
				$(this).closest('.wcol_cat_panel').find('.wcol-rule-min-limit').addClass('wcol-disabled');
				$(this).closest('.wcol_cat_panel').find('.wcol-applied-on').addClass('wcol-disabled');	
				
			}else{
				$(this).closest('.wcol_cat_panel').find('.enable-max-rule-limit').removeClass('wcol-disabled');
				$(this).closest('.wcol_cat_panel').find('.wcol-rule-max-limit').removeClass('wcol-disabled');
				$(this).closest('.wcol_cat_panel').find('.wcol-rule-min-limit').removeClass('wcol-disabled');
				$(this).closest('.wcol_cat_panel').find('.wcol-applied-on').removeClass('wcol-disabled');	
			}
		}else{
			if($(this).is(':checked')){
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-select-categories').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-select-products').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-rule-min-limit').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-select-applied-on').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-accomulative').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-editable').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.enable-max-rule-limit').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-rule-max-limit').addClass('wcol-disabled');
			}else{
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-select-products').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-select-categories').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-rule-min-limit').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-select-applied-on').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-accomulative').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-editable').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.enable-max-rule-limit').removeClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').closest('tr').find('.wcol-rule-max-limit').removeClass('wcol-disabled');
			}
		}
	});		
	$('.wp-list-table , #wcol_tab , .form-table').on('change','.across-all-orders-limit', function(){
		if( window.location.href.indexOf('post.php') > 0 || window.location.href.indexOf('post-new') > 0){
			if($(this).is(':checked')){
				$(this).closest('.wc-metabox-content').find('.enable-max-rule-limit').prop('checked', true);
				$(this).closest('.wc-metabox-content').find('.enable-max-rule-limit').addClass('wcol-disabled').closest('.options_group').removeClass('wcol-hidden');
				$(this).closest('.wc-metabox-content').find('.enable-max-rule-limit-hidden').val('on');
				$(this).closest('.wc-metabox-content').find('.wcol-rule-max-limit').closest('.form-field').removeClass('wcol-hidden');
				
			}else{
				$(this).closest('.wc-metabox-content').find('.enable-max-rule-limit').removeClass('wcol-disabled');
			}
		}else if(window.location.href.indexOf('term.php') > 0 || window.location.href.indexOf('edit-tags.php') > 0){
			if($(this).is(':checked')){
				$(this).closest('.wcol_cat_panel').find('.enable-max-rule-limit').prop('checked', true);
				$(this).closest('.wcol_cat_panel').find('.enable-max-rule-limit').addClass('wcol-disabled').closest('.options_group').removeClass('wcol-hidden');
				$(this).closest('.wcol_cat_panel').find('.enable-max-rule-limit-hidden').val('on');
				$(this).closest('.wcol_cat_panel').find('.wcol-rule-max-limit').closest('.form-field').removeClass('wcol-hidden');
				
			}else{
				$(this).closest('.wcol_cat_panel').find('.enable-max-rule-limit').removeClass('wcol-disabled');
			}
		}else{
			if($(this).is(':checked')){
				$(this).closest('.wcol-rule-options').find('.enable-max-rule-limit').prop('checked', true);
				$(this).closest('.wcol-rule-options').find('.enable-max-rule-limit').addClass('wcol-disabled');
				$(this).closest('.wcol-rule-options').find('.enable-max-rule-limit-hidden').val('on');
				$(this).closest('.wcol-rule-options').find('.wcol-rule-max-limit').closest('tr').removeClass('wcol-hidden');
			}else{
				$(this).closest('.wcol-rule-options').find('.enable-max-rule-limit').removeClass('wcol-disabled');
			}
		}
	});

	$('.xs-wcol').on('click' , function(e){
		e.preventDefault();
		$(this).closest('form').removeClass('xs-changed');
		$.ajax({
			url: wcol_script_vars.ajax_url,
			type:'post',
			dataType: "json",
			beforeSend:function(){ 
				$('.spinner').show();
				$('.spinner').css('visibility', 'visible');
			},
			complete:function(){
				$('.spinner').hide();
				$('.spinner').css('visibility', 'hidden');
			},
			data:{
				action:'save_rules',
				_wcol_save_rules_nonce:$('#_wcol_save_rules_nonce').val(),
				rules:$(this).closest('form').serialize(),
			},
			success: function(res){
				$('.wcol-data-save-notice').show();
			},

		});
	});
	$('.xs-wcol-notice-dismiss').on('click',function(){
		$('.wcol-data-save-notice').hide();
	});
	$('#xs_name , #xs_email , #xs_message').on('change',function(e){
        if(!$(this).val()){
            $(this).addClass("error");
        }else{
            $(this).removeClass("error");
        }
    });
	$('.xsollwc_support_form').on('submit' , function(e){ 
        e.preventDefault();
        $('.xs-send-email-notice').hide();
        $('.xs-mail-spinner').addClass('xs_is_active');
        $('#xs_name').removeClass("error");
        $('#xs_email').removeClass("error");
        $('#xs_message').removeClass("error"); 
        $.ajax({ 
            url:ajaxurl,
            type:'post',
            data:{'action':'xsollwc_support_form','_xsollwc_support_nonce':$('#_xsollwc_support_nonce').val(),'data':$(this).serialize()},
            beforeSend: function(){
            	if(!$('#xs_name').val()){
                    $('#xs_name').addClass("error");
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Please fill all the fields');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    $('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!$('#xs_email').val()){
                    $('#xs_email').addClass("error");
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Please fill all the fields');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    $('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!$('#xs_message').val()){
                    $('#xs_message').addClass("error");
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Please fill all the fields');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    $('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                $(".xsollwc_support_form :input").prop("disabled", true);
                $("#xs_message").prop("disabled", true);
               	$('.xs-send-mail').prop('disabled',true);
            },
            success: function(res){
                $('.xs-send-email-notice').find('.xs-notice-dismiss').show();
                $('.xs-send-mail').prop('disabled',false);
                $(".xsollwc_support_form :input").prop("disabled", false);
                $("#xs_message").prop("disabled", false);
                if(res.status == true){
                    $('.xs-send-email-notice').removeClass('error');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('notice-success');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Successfully sent');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    $('.xsollwc_support_form')[0].reset();
                }else{
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Sent Failed');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                }
                $('.xs-mail-spinner').removeClass('xs_is_active');
            }

        });
    });
    $('.notice-dismiss, .xs-notice-dismiss').on('click',function(e){
        e.preventDefault();
        $(this).parent().hide();
        $(this).hide();
    })
});
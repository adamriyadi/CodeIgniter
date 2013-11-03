var currentWinId = 1;
$(function() {
	// Activates the Carousel
	$('.carousel').carousel({
	  interval: 5000
	});

	// Activates Tooltips for Social Links
	$('.tooltip-social').tooltip({
	  selector: "a[data-toggle=tooltip]"
	});
	if ($("#logoutLink").length) {
		$("#logoutLink").click(function(evt) {
			location.href=base_url + "users/do_logout";
			evt.preventDefault();
			evt.stopPropagation();
		});
	}
	if ($("#loginLink").length) {
		$("#loginLink").click(function(evt) {
			$("#login_error").hide();
		});
	}
	if ($("#loginErrorDissmiss").length) {
		$("#loginErrorDissmiss").click(function() {
			$("#login_error").slideUp();
		});
	}
	if ($("#loginBtn").length) {
		$("#Username").keyup(function(evt) {
			if (evt.keyCode == 13) {
				doLogin();
			}
		});
		$("#Password").keyup(function(evt) {
			if (evt.keyCode == 13) {
				doLogin();
			}
		});
		$("#loginBtn").click(function() {
			doLogin();
		});
	}

	if ( $("#check_all").length) {
		$("#check_all").click(function() {
			$('.data_check').prop("checked" , true);
			$(".action_btn").prop("disabled",false);
		});
	}

	if ( $("#uncheck_all").length) {
		$("#uncheck_all").click(function() {
			$('.data_check').prop("checked" , false);
			$(".action_btn").prop("disabled",true);
		});
	}

	if ( $(".data_check").length) {
		$(".data_check").change(function() {
			var count = 0;
			$.each($(".data_check"), function() {
				if ($(this).is(':checked')) {
					count++;
				}
			});
			if (count > 0) {
				$(".action_btn").prop("disabled",false);
			}
			else {
				$(".action_btn").prop("disabled",true);
			}
			if (count == 1) {
				$(".action_btn_single").prop("disabled",false);
			}
			else {
				$(".action_btn_single").prop("disabled",true);
			}
		}); 
	}    
	if ( $(".input-append.date").length) {
		$('.input-append.date').datepicker({
			format: "dd/mm/yyyy"
		});
	}
	if ( $(".input-sm.date").length) {
		$('.input-sm.date').datepicker({
			format: "dd/mm/yyyy"
		});
	}
	if ( $(".Num").length) {
		$(".Num").blur(function() {
			var target = $(this).attr("data-target");
			var value = $(this).val().replace(/,/g,"");
			$("#"+target).val(value);

			value = $.formatNumber(value, {format:"#,###.00", locale:"us"});
			$(this).val(value);
			$("#"+target).change();
		});
		$(".Num").focus(function() {
			var target = $(this).attr("data-target");
			var value = $(this).val().replace(/,/g,"");
			$(this).val(value);
		});
	}
});

function doLogin() {
	$("#login_error").hide();
	$.ajax({
		url: base_url + "users/do_login",
		type: "POST",
		data:{
			username : $("#Username").val(),
			password : $("#Password").val()
		},
		error: function() {
			alert("Page Not Found !!");
		},
		dataType: "json",
		success: function(content){
			if (content) {
				if (content.result == '1') {
					location.href = base_url+"dashboard";
					$("#loginDialog").hide();
				}
				else {
					$("#error_message").html(content.result);
					$("#login_error").slideDown();
				}
			}
		}
	});
}

function alert_dialog(msg) {
	modalStr = '<div class="modal fade" id="alertDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	modalStr += '<div class="modal-dialog my-dialog">';
	modalStr += '<div class="modal-content">';
	modalStr += '<div class="modal-header">';
	modalStr += '<button type="button" class="close white" data-dismiss="modal" aria-hidden="true">&times;</button>';
	modalStr += '<h4 class="modal-title">Alert</h4>';
	modalStr += '</div>';
	modalStr += '<div class="modal-body" style="width:100%;">';
	modalStr += '<div class="container" style="width:100%;">';
	modalStr += '<div class="alert alert-danger">';
	modalStr += '<span class="glyphicon glyphicon-exclamation-sign">&nbsp;</span>' + msg;
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '<div class="modal-footer">';
	modalStr += '<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;Close</button>';
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '</div>';
			
    var alertModal = $(modalStr);


    alertModal.modal('show');     
}
function confirm_dialog(heading, question, cancelButtonTxt, okButtonTxt, form, action, callback) {
	
	modalStr = '<div class="modal fade" id="confirmDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	modalStr += '<div class="modal-dialog my-dialog">';
	modalStr += '<div class="modal-content">';
	modalStr += '<div class="modal-header">';
	modalStr += '<button type="button" class="close white" data-dismiss="modal" aria-hidden="true">&times;</button>';
	modalStr += '<h4 class="modal-title">'+heading+'</h4>';
	modalStr += '</div>';
	modalStr += '<div class="modal-body" style="width:100%;">';
	modalStr += '<div class="container" style="width:100%;">';
	modalStr += '<div class="alert alert-danger">';
	modalStr += '<span class="glyphicon glyphicon-exclamation-sign">&nbsp;</span>' + question;
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '<div class="modal-footer">';
	modalStr += '<button type="button" class="btn btn-primary" id="okButton"><span class="glyphicon glyphicon-ok"></span>&nbsp;' + okButtonTxt  + '</button>';
	modalStr += '<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;' + cancelButtonTxt  + '</button>';
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '</div>';
	modalStr += '</div>';
			
    var confirmModal = $(modalStr);

	confirmModal.find('#okButton').click(function(event) {
		if (form != '') {
			$('#'+form).attr('action',action);
			$('#'+form).submit();
		}
		else if (callback != '') {
			callback();
		}
		confirmModal.modal('hide');
	});

    confirmModal.modal('show');     
}

function toggle_check(selector) {
	if ($(selector).is(':checked')) {
		$(selector).prop('checked',false);
	}
	else {
		$(selector).prop('checked',true);
	}
	$(selector).change();
}

function reset_form(selector) {
	var childs = $(selector).find('.form-control');

	$.each(childs, function(key,val) {
		$(this).val('');
	});
	$(selector).submit();
}

function get_selected_value() {
	var value = "-1";
	$('.data_check').each(function() {
		if ($(this).is(':checked')) {
			value = $(this).val();
		}
	});
	
	return value;
}

function get_selected_values() {
	var values = [];
	$('.data_check').each(function() {
		if ($(this).is(':checked')) {
			values.push($(this).val());
		}
	});

	return values;
}

function open_page(url,width,height,winId) {
    if (!winId) {
        winId = 'win' + currentWinId;
        currentWinId++;
    }
    else {
        winId = winId + currentWinId;
        currentWinId++;
    }
    leftPos = Math.round(screen.width / 2) - Math.round(width / 2);
    topPos =  Math.round(screen.height / 2) - Math.round(height / 2);
    
    window.open(url,winId,'toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=' +
        width + ',height=' + height + ',left=' + leftPos + ',top=' +topPos);
}

function ajax_loader(url, target) {
	$.ajax({
		url: url,
		type: "GET",
		error: function() {
			alert("Page Not Found !!");
		},
		dataType: "html",
		success: function(content){
			if (content) {
				$("#"+target).html(content);
			}
		}
	});
	return false;
}
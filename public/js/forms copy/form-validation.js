$(document).ready(function () {	
	
	$(".css_btn").on('click',function(){
		$(".reset_css input").css({"border":"1px solid transparent"});
		$(".reset_css textarea").css({"border":"1px solid transparent"});
	});
	
	
//=============Request More Info==============//	
	var request_more_info_submit_disabled = false;
    $("#request_more_info_submit").on('click',function(){
		if ( request_more_info_submit_disabled ) {
			return;
		}
		validationStr = false;
        var textArray = [
        	"rmi_name",            		
        	"rmi_email",
            "rmi_phone",
			"rmi_password"
        ]; 
		for (var n = 0; n < textArray.length; n++) {
        	str = textArray[n];			
            e = document.getElementById(str);                    
            if (e) {
        		$('#'+str).css({"border":"1px solid transparent"});
                if (e.value == "") {  
                    validationStr = true;
        			$('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
        		}
                if (str == "rmi_email") {                     
                    var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var varEmail = e.value; 
                    if (varEmail.search(varTestExp) == -1) {
                        validationStr = true;
                        $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
                    }
                }   
        	}
        }
        if (validationStr) {    		
    	   return false;
        }   
		
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "php/ajax-form.php",
            data : $('#rmi_form').serialize(),
			beforeSend : function(arr, $form, options){
				request_more_info_submit_disabled = true;
				$( '#request_more_info_submit .btn-loader' ).show();
			},
            success : function (data) {
				request_more_info_submit_disabled = false;
				$( '#request_more_info_submit .btn-loader' ).hide();
            	$( '#rmi_notice' ).fadeIn();
            	$( '#rmi_notice' ).html(data.msg).delay(4000).fadeOut('slow');
            	$( '#rmi_form' )[0].reset();
				grecaptcha.reset(recaptcha1);
            	$('select').find('option').prop("selected", false);
            },
            error: function(msg){
				request_more_info_submit_disabled = false;
				$( '#request_more_info_submit .btn-loader' ).hide();
    			alert('Something went wrong!');                
    		}
        });
        return false;
    });
	
	
//=============Schedule Test Drive===============//	
	var schedule_test_drive_submit_disabled = false;
    $("#schedule_test_drive_submit").on('click',function(){
		if ( schedule_test_drive_submit_disabled ) {
			return;
		}
		validationStr = false;
        var textArray = [
        	"std_firstname",            		
        	"std_email",
			"std_phone",
			"std_day",
			"std_time"
        ]; 
		for (var n = 0; n < textArray.length; n++) {
        	str = textArray[n];			
            e = document.getElementById(str);                    
            if (e) {
        		$('#'+str).css({"border":"1px solid transparent"});			
                if (e.value == "") {                                              
        			validationStr = true;
                    $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
        		}
                
                if (str == "std_email") {                     
                    var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var varEmail = e.value; 
                    if (varEmail.search(varTestExp) == -1) {
                        validationStr = true;
                        $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
                    }
                }   
        	}
            
        }
        
        if (validationStr) {    		
    	   return false;
        }
        
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "php/ajax-form.php",
            data : $('#std_form').serialize(),
			beforeSend : function(arr, $form, options){
				schedule_test_drive_submit_disabled = true;
				$( '#schedule_test_drive_submit .btn-loader' ).show();
			},
            success : function (data) {
				schedule_test_drive_submit_disabled = false;
				$( '#schedule_test_drive_submit .btn-loader' ).hide();
            	$('#std_notice').fadeIn();
            	$('#std_notice').html(data.msg).delay(4000).fadeOut('slow');
            	$("#std_form")[0].reset();
				grecaptcha.reset(recaptcha2);
            	$('select').find('option').prop("selected", false);
            },
            error: function(msg){
				schedule_test_drive_submit_disabled = false;
				$( '#schedule_test_drive_submit .btn-loader' ).hide();
    			alert('Something went wrong!');                
    		}
        });
        return false;
    });
	
	
//=============Make An Offer================// 
    var make_an_offer_submit_disabled = false;
	$("#make_an_offer_submit").on('click',function(){
		if ( make_an_offer_submit_disabled ) {
			return;
		}
		validationStr = false;
        var textArray = [
        	"mao_name",            		
        	"mao_email",
			"mao_phone",
			"mao_price",
			"mao_comments"
        ]; 
		for (var n = 0; n < textArray.length; n++) {
        	str = textArray[n];			
            e = document.getElementById(str);                    
            if (e) {
        		$('#'+str).css({"border":"1px solid transparent"});			
                if (e.value == "") {
                    validationStr = true;
        			$('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
        		}
                
                if (str == "mao_email") {                     
                    var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var varEmail = e.value; 
                    if (varEmail.search(varTestExp) == -1) {
                        validationStr = true;
                        $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
                    }
                }    
        	}
                       
        }
        if (validationStr) {    		
    	   return false;
        }
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "php/ajax-form.php",
            data : $('#mao_form').serialize(),
			beforeSend : function(arr, $form, options){
				make_an_offer_submit_disabled = true;
				$( '#make_an_offer_submit .btn-loader' ).show();
			},
            success : function (data) {
				make_an_offer_submit_disabled = false;
				$( '#make_an_offer_submit .btn-loader' ).hide();
            	$('#mao_notice').fadeIn();
            	$('#mao_notice').html(data.msg).delay(4000).fadeOut('slow');
            	$("#mao_form")[0].reset();
				grecaptcha.reset(recaptcha3);
            	$('select').find('option').prop("selected", false);
            },
            error: function(msg){
				make_an_offer_submit_disabled = false;
				$( '#make_an_offer_submit .btn-loader' ).hide();
    			alert('Something went wrong!');                
    		}
        });
        return false;
    }); 
	
	
//===============Email To Friend================//
	var email_to_friend_submit_disabled = false;
    $(document).on('click','#email_to_friend_submit',function(){
		if ( email_to_friend_submit_disabled ) {
			return;
		}
        validationStr = false;
		var textArray = [
        	"etf_name",            		
        	"etf_email",
			"etf_fmail",
			"etf_fmessage"
        ]; 
		for (var n = 0; n < textArray.length; n++) {
        	str = textArray[n];			
            e = document.getElementById(str);                    
            if (e) {
        		$('#'+str).css({"border":"1px solid transparent"});			
                if (e.value == "") {
                    validationStr = true;
        			$('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
        		} 
                if (str == "etf_email") {                     
                    var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var varEmail = e.value; 
                    if (varEmail.search(varTestExp) == -1) {
                        validationStr = true;
                        $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
                    }
                } 
                  
        	}
        }
        
        if (validationStr) {    		
    	   return false;
        }
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "php/ajax-form.php",
            data : $('#etf_form').serialize(),
			beforeSend : function(arr, $form, options){
				email_to_friend_submit_disabled = true;
				$( '#email_to_friend_submit .btn-loader' ).show();
			},
            success : function (data) {
				email_to_friend_submit_disabled = false;
				$( '#email_to_friend_submit .btn-loader' ).hide();
            	$('#etf_notice').fadeIn();
            	$('#etf_notice').html(data.msg).delay(4000).fadeOut('slow');
            	$("#etf_form")[0].reset();
				grecaptcha.reset(recaptcha4);
            	$('select').find('option').prop("selected", false);
            },
            error: function(msg){
				email_to_friend_submit_disabled = false;
				$( '#email_to_friend_submit .btn-loader' ).hide();
    			alert('Something went wrong!');                
    		}
        });
        return false;
    });
	
	
//================Trade In Appraisal===================//	
    var trade_in_appraisal_submit_disabled = false;
	$(document).on('click','#trade_in_appraisal_submit',function(){
		if ( trade_in_appraisal_submit_disabled ) {
			return;
		}
        validationStr = false;
		var textArray = [
        	"tia_firstname",            		
        	"tia_lastname",
			"tia_workphone",
			"tia_phone",
			"tia_email",
			"tia_comments",
			"tia_year",
			"tia_make",
			"tia_model",
			"tia_colour",
			"tia_vin",
			"tia_kilometers",
			"tia_engine"
        ]; 
		for (var n = 0; n < textArray.length; n++) {
        	str = textArray[n];			
            e = document.getElementById(str);                    
            if (e) {
        		$('#'+str).css({"border":"1px solid transparent"});			
                if (e.value == "") {
                    validationStr = true;
        			$('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
        		}
                if (str == "tia_email") {                     
                    var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var varEmail = e.value; 
                    if (varEmail.search(varTestExp) == -1) {
                        validationStr = true;
                        $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
                    }
                }                
        	}
        }
        if (validationStr) {    		
    	   return false;
        }
		var g = $("#g-recaptcha-response").val();
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "php/ajax-form.php",
            data : $('#tia_form').serialize(),
			beforeSend : function(arr, $form, options){
				trade_in_appraisal_submit_disabled = true;
				$( '#trade_in_appraisal_submit .btn-loader' ).show();
			},
            success : function (data) {
				trade_in_appraisal_submit_disabled = false;
				$( '#trade_in_appraisal_submit .btn-loader' ).hide();
            	$('#tia_notice').fadeIn();
            	$('#tia_notice').html(data.msg).delay(4000).fadeOut('slow');
            	$("#tia_form")[0].reset();
				grecaptcha.reset(recaptcha5);
            	$('select').find('option').prop("selected", false);
            },
            error: function(msg){
				trade_in_appraisal_submit_disabled = false;
				$( '#trade_in_appraisal_submit .btn-loader' ).hide();
    			alert('Something went wrong!');                
    		}
        });
        return false;
    });

//===============Send Enquiry================//
	function isNotEmpty( element ) {
		return ( ( $(element).val() != $(element).attr("placeholder") ) && ( $(element).val().length > 0 ) );
	}

	var send_enquiry_submit_disabled = false;
    $(document).on('click','#send_enquiry_submit',function(){
		
		if ( send_enquiry_submit_disabled ) {
			return false;
		}
		
        var validationStr = false;
		var textArray = [
        	"send_enquiry_name",            		
        	"send_enquiry_email",
			"send_enquiry_message",
        ];
		for (var n = 0; n < textArray.length; n++) {
        	var str = textArray[n],
				e = document.getElementById(str);
            if (e) {
        		$('#'+str).css({"border":"1px solid transparent"});			
                if ( ! isNotEmpty(e) ) {
                    validationStr = true;
        			$('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
        		} 
                if (str == "send_enquiry_email") {                     
                    var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var varEmail = e.value; 
                    if (varEmail.search(varTestExp) == -1) {
                        validationStr = true;
                        $('#'+str).css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
                    }
                } 
                  
        	}
        }
        
        if (validationStr) {    		
    	   return false;
        }
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "php/ajax-form.php",
            data : $('#send_enquiry_form').serialize(),
			beforeSend : function(arr, $form, options){
				send_enquiry_submit_disabled = true;
				$( '#send_enquiry_submit' ).show();
				$( '#send_enquiry_submit .btn-loader' ).show();
			},
            success : function (data) {
				send_enquiry_submit_disabled = false;
				$( '#send_enquiry_submit .btn-loader' ).hide();
            	$('#send_enquiry_notice').fadeIn();
            	$('#send_enquiry_notice').html(data.msg).delay(4000).fadeOut('slow');
            	$("#send_enquiry_form")[0].reset();
            	$('select').find('option').prop("selected", false);
            },
            error: function(msg){
				send_enquiry_submit_disabled = false;
				$( '#send_enquiry_submit .btn-loader' ).hide();
    			alert('Something went wrong!');
    		}
        });
        return false;
    });	

	/**************************************************
		Financing Calculator
	**************************************************/
	function fnisNum(x) {
		var filter = /(^\d+\.?$)|(^\d*\.\d+$)/;
		if (filter.test(x)) {
			return true;
		}
		return false;
	}
	$(document).on('click','.calculate_finance',function(){
		var form_id          = $(this).attr('data-form-id');
		var current_form     = $( '#'+form_id );
		var loan_amount_el   = $( current_form ).find( '#loan-amount' );
		var loan_amount      = $( loan_amount_el ).val();
		var interest_rate_el = $( current_form ).find( '#interest-rate' );
		var interest_rate    = $( interest_rate_el ).val();
		var period_el        = $( current_form ).find( '#period' );
		var period           = $( period_el ).val();
		var down_payment_el  = $( current_form ).find( '#down-payment' );
		var down_payment     = $( down_payment_el ).val();
		var currency_symbol  = '$';

		console.log( current_form );

		var t = down_payment;
		var I = interest_rate;
		var N = period;
		var P = loan_amount;

		var vTempP = String(P).replace(currency_symbol, '').replace(',', '');
		if (!fnisNum(vTempP)) {
			alert("Please enter a valid number for the Loan Amount (P).");
			$( loan_amount_el ).focus();
			return false;
		}

		var vTempT = String(t).replace(currency_symbol, '').replace(',', '');
		if (!fnisNum(vTempT)) {
			alert("Please enter a valid number for the Down Payment (P).");
			$( down_payment_el ).focus();
			return false;
		}

		if (!fnisNum(I)) {
			alert("Enter an Interest Rate (r).");
			$( interest_rate_el ).focus();
			return false;
		}
		if (!fnisNum(N)) {
			alert("Please enter the Total Number of Payments (N).");
			$( period_el ).focus();
			return false;
		}

		P = vTempP;
		t = vTempT;
		var X = (P - t);
		var Y = ((I / 100) / 12);
		var z = (Math.pow((1 + ((I / 100) / 12)), -N));
		var a = (X * Y);
		var b = (1 - z);
		var Tot = (a / b);
		var ans2 = Tot.toFixed(2);

		$( '#txtPayment' ).html( currency_symbol + ans2 + '<sup>&#47;mo</sup>' );
	});

});
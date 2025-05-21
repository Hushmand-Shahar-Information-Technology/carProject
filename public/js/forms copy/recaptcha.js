(function($){
	"use strict";

	var recaptcha1;
	var recaptcha2;
	var recaptcha3;
	var recaptcha4;
	var recaptcha5;

	var myCallBack = function() {
		//Render the recaptcha1 on the element with ID "recaptcha1"
		recaptcha1 = grecaptcha.render('recaptcha1', {
			'sitekey' : '6LfYqRkUABCZYBMrLp0FdD0G3j8MwP8kBbwMJMHi', //Replace this with your Site key
			'theme' : 'light'
		});

		//Render the recaptcha2 on the element with ID "recaptcha2"
		recaptcha2 = grecaptcha.render('recaptcha2', {
			'sitekey' : '6LfYqRkUABCZYBMrLp0FdD0G3j8MwP8kBbwMJMHi', //Replace this with your Site key
			'theme' : 'light'
		});

		recaptcha3 = grecaptcha.render('recaptcha3', {
			'sitekey' : '6LfYqRkUABCZYBMrLp0FdD0G3j8MwP8kBbwMJMHi', //Replace this with your Site key
			'theme' : 'light'
		});

		recaptcha4 = grecaptcha.render('recaptcha4', {
			'sitekey' : '6LfYqRkUABCZYBMrLp0FdD0G3j8MwP8kBbwMJMHi', //Replace this with your Site key
			'theme' : 'light'
		});
	
		recaptcha5 = grecaptcha.render('recaptcha5', {
			'sitekey' : '6LfYqRkUABCZYBMrLp0FdD0G3j8MwP8kBbwMJMHi', //Replace this with your Site key
			'theme' : 'light'
		});
	};

	window.onload = function() {
		myCallBack();
	};

})(jQuery);

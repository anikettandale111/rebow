/* global logincust_script */

jQuery( document ).ready( function( $ ) {

	/*
	 * Switch to the /login-customizer/ page, where we can live-preview Customizer options.
	 * Source: Login Designer
	*/
	wp.customize.preview.bind( 'logincust-url-switcher', function( data ) {
		// When the section is expanded, open the login designer page.
		if ( true === data.expanded ) {
			wp.customize.preview.send( 'url', logincust_script.page );
		}
	});

	wp.customize.preview.bind( 'logincust-back-to-home', function( data ) {
		wp.customize.preview.send( 'url', data.home_url );
	});

	wp.customize( 'login_customizer_options[logincust_bg_color]', function( value ) {
		value.bind( function( newval ) {
			$( 'body.login' ).css( 'background-color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_bg_image]', function( value ) {
		value.bind( function( newval ) {
			$( 'body.login' ).css( 'background-image', 'url(' +newval+ ')' );
		});
	});

	wp.customize( 'login_customizer_options[logincust_bg_image_repeat]', function( value ) {
		value.bind( function( newval ) {
			$( 'body.login' ).css( 'background-repeat', newval );
		});
	});

	var imageCustom = false;
	wp.customize( 'login_customizer_options[logincust_bg_image_size]', function( value ) {
		value.bind( function( newval ) {
			if ( newval !== 'custom' ) {
				$( 'body.login' ).css( 'background-size', newval );
				imageCustom = false;
			} else {
				imageCustom = true;
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_bg_size]', function( value ) {
		value.bind( function( newval ) {
			if ( imageCustom ) {
				$( 'body.login' ).css( 'background-size', newval );
			}
		});
	});

	var bgpx = wp.customize( 'login_customizer_options[logincust_bg_image_position_x]' )._value;
	wp.customize( 'login_customizer_options[logincust_bg_image_position_x]', function( value ) {
		value.bind( function( newval ) {
			bgpx = newval;
			$( 'body.login' ).css( 'background-position', bgpx + ' ' + bgpy );
		});
	});
	
	var bgpy = wp.customize( 'login_customizer_options[logincust_bg_image_position_y]' )._value;
	wp.customize( 'login_customizer_options[logincust_bg_image_position_y]', function( value ) {
		value.bind( function( newval ) {
			bgpy = newval;
			$( 'body.login' ).css( 'background-position', bgpx + ' ' + bgpy );
		});
	});

	wp.customize( 'login_customizer_options[logincust_logo_show]', function( value ) {
		value.bind( function( newval ) {
			if ( newval === true ) {
				$( 'body.login div#login h1 a' ).css( 'display', 'none' );
			} else {
				$( 'body.login div#login h1 a' ).css( 'display', 'block' );
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_logo]', function( value ) {
		value.bind( function( newval ) {
			$( 'body.login div#login h1 a' ).css( 'background-image', 'url(' +newval+ ')' );
		});
	});

	var logowidth = wp.customize( 'login_customizer_options[logincust_logo_width]' )._value;
	wp.customize( 'login_customizer_options[logincust_logo_width]', function( value ) {
		value.bind( function( newval ) {
			logowidth = newval;
			$( 'body.login div#login h1 a' ).css( 'width', newval );
			$( 'body.login div#login h1 a' ).css( 'background-size', logowidth + ' ' + logoheight );
		});
	});

	var logoheight = wp.customize( 'login_customizer_options[logincust_logo_height]' )._value;
	wp.customize( 'login_customizer_options[logincust_logo_height]', function( value ) {
		value.bind( function( newval ) {
			logoheight = newval;
			$( 'body.login div#login h1 a' ).css( 'height', newval );
			$( 'body.login div#login h1 a' ).css( 'background-size', logowidth + ' ' + logoheight );
		});
	});

	wp.customize( 'login_customizer_options[logincust_logo_padding]', function( value ) {
		value.bind( function( newval ) {
			$( 'body.login div#login h1 a' ).css( 'padding-bottom', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_form_bg_image]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform' ).css( 'background-image', 'url(' +newval+ ')' );
		});
	});

	wp.customize( 'login_customizer_options[logincust_form_bg_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform' ).css( 'background-color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_form_width]', function( value ) {
		value.bind( function( newval ) {
			$( 'div#login' ).css( 'width', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_form_height]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform' ).css( 'height', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_form_padding]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform' ).css( 'padding', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_form_radius]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform' ).css( 'border-radius', newval );
		});
	});

	var formshadowspread = wp.customize( 'login_customizer_options[logincust_form_shadow_spread]' )._value;
	wp.customize( 'login_customizer_options[logincust_form_shadow_spread]', function( value ) {
		value.bind( function( newval ) {
			formshadowspread = newval;
			$( '#login form#loginform' ).css( 'box-shadow', '0 3px ' + formshadowspread + ' ' + formshadow );
		});
	});

	var formshadow = wp.customize( 'login_customizer_options[logincust_form_shadow]' )._value;
	wp.customize( 'login_customizer_options[logincust_form_shadow]', function( value ) {
		value.bind( function( newval ) {
			formshadow = newval;
			$( '#login form#loginform' ).css( 'box-shadow', '0 3px ' + formshadowspread + ' ' + formshadow );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_remember_me]', function( value ) {
		value.bind( function( newval ) {
			if ( newval === true ) {
				$( '#login form .forgetmenot' ).css( 'display', 'none' );
			} else {
				$( '#login form .forgetmenot' ).css( 'display', 'block' );
			}
		});
	});

	var navNode = document.querySelector( '#nav' );
	wp.customize( 'login_customizer_options[logincust_field_register_link]', function( value ) {
		value.bind( function( newval ) {
			if ( newval === true ) {
				navNode.children[0].style.display = 'none';
			} else {
				navNode.children[0].style.display = 'inline';
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_lost_password]', function( value ) {
		value.bind( function( newval ) {
			if ( newval === true ) {
				if ( navNode.children[1] === undefined ) {
					navNode.children[0].style.display = 'none';
				} else {
					navNode.children[1].style.display = 'none';
				}
			} else {
				if ( navNode.children[1] === undefined ) {
					navNode.children[0].style.display = 'inline';
				} else {
					navNode.children[1].style.display = 'inline';
				}
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_width]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'width', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_font_size]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'font-size', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_border_width]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'border-width', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_border_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'border-color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_radius]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'border-radius', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_box_shadow]', function( value ) {
		value.bind( function( newval ) {
			if ( newval === true ) {
				$( '#login form#loginform .input' ).css( 'box-shadow', 'unset' );
			} else {
				$( '#login form#loginform .input' ).css( 'box-shadow', 'inset 0 1px 2px rgba(0,0,0,.07)' );
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_margin]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'margin', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_padding]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'padding', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_bg]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'background-color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform .input' ).css( 'color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_label]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform label' ).css( 'color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_field_label_font_size]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form#loginform label' ).css( 'font-size', newval );
			$( '#login form#loginform .forgetmenot label' ).css( 'font-size', ( parseInt( newval )  - 2 + 'px' ) );
		});
	});

	var buttonbg = wp.customize( 'login_customizer_options[logincust_button_bg]' )._value;
	wp.customize( 'login_customizer_options[logincust_button_bg]', function( value ) {
		value.bind( function( newval ) {
			buttonbg = newval;
			$( '#login form .submit .button' ).css( 'background-color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_hover_bg]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).hover( function(){
				$( this ).css( 'background-color', newval );
			}, function(){
				$( this ).css( 'background-color', buttonbg );
			});
		});
	});

	var customSize = wp.customize( 'login_customizer_options[logincust_button_height_width]' )._value;
	var customWidth = wp.customize( 'login_customizer_options[logincust_button_width_size]' )._value;
	var customHeight = wp.customize( 'login_customizer_options[logincust_button_height_size]' )._value;
	wp.customize( 'login_customizer_options[logincust_button_height_width]', function( value ) {
		value.bind( function( newval ) {
			customSize = newval;
			if ( customSize === 'auto' ) {
				$( '#login form .submit .button' ).css( 'width', 'auto' );
				$( '#login form .submit .button' ).css( 'height', 'auto' );
			} else if ( customSize === 'custom' ) {
				$( '#login form .submit .button' ).css( 'width', customWidth );
				$( '#login form .submit .button' ).css( 'height', customHeight );
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_width_size]', function( value ) {
		value.bind( function( newval ) {
			if ( customSize === 'custom' ) {
				customWidth = newval;
				$( '#login form .submit .button' ).css( 'width', newval );
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_height_size]', function( value ) {
		value.bind( function( newval ) {
			if ( customSize === 'custom' ) {
				customHeight = newval;
				$( '#login form .submit .button' ).css( 'height', newval );
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_font_size]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).css( 'font-size', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).css( 'color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_padding]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).css( 'padding', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_border_width]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).css( 'border-width', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_border_radius]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).css( 'border-radius', newval );
		});
	});

	var buttoncolor = wp.customize( 'login_customizer_options[logincust_button_border]' )._value;
	wp.customize( 'login_customizer_options[logincust_button_border]', function( value ) {
		value.bind( function( newval ) {
			buttoncolor = newval;
			$( '#login form .submit .button' ).css( 'border-color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_hover_border]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).hover( function(){
				$( this ).css( 'border-color', newval );
			}, function(){
				$( this ).css( 'border-color', buttoncolor );
			});
		});
	});

	var buttonshadowspread = wp.customize( 'login_customizer_options[logincust_button_shadow_spread]' )._value;
	wp.customize( 'login_customizer_options[logincust_button_shadow_spread]', function( value ) {
		value.bind( function( newval ) {
			buttonshadowspread = newval;
			$( '#login form .submit .button' ).css( 'box-shadow', '0 3px ' + buttonshadowspread + ' ' + buttonshadow );
		});
	});

	var buttonshadow = wp.customize( 'login_customizer_options[logincust_button_shadow]' )._value;
	wp.customize( 'login_customizer_options[logincust_button_shadow]', function( value ) {
		value.bind( function( newval ) {
			buttonshadow = newval;
			$( '#login form .submit .button' ).css( 'box-shadow', '0 1px ' + buttonshadowspread + ' ' + buttonshadow );
		});
	});

	wp.customize( 'login_customizer_options[logincust_button_text_shadow]', function( value ) {
		value.bind( function( newval ) {
			$( '#login form .submit .button' ).css( 'text-shadow', '0 -1px 1px ' + newval + ',1px 0 1px ' + newval + ',0 1px 1px ' + newval + ',-1px 0 1px ' + newval );
		});
	});
	wp.customize( 'login_customizer_options[logincust_field_back_blog]', function( value ) {
		value.bind( function( newval ) {
			if ( newval === true ) {
				$( '.login #backtoblog' ).css( 'display', 'none' );
			} else {
				$( '.login #backtoblog' ).css( 'display', 'block' );
			}
		});
	});

	wp.customize( 'login_customizer_options[logincust_other_font_size]', function( value ) {
		value.bind( function( newval ) {
			$( '.login #nav' ).css( 'font-size', newval );
			$( '.login #nav a' ).css( 'font-size', newval );
			$( '.login #backtoblog a' ).css( 'font-size', newval );
		});
	});

	var othercolor = wp.customize( 'login_customizer_options[logincust_other_color]' )._value;
	wp.customize( 'login_customizer_options[logincust_other_color]', function( value ) {
		value.bind( function( newval ) {
			othercolor = newval;
			$( '.login #nav' ).css( 'color', newval );
			$( '.login #nav a' ).css( 'color', newval );
			$( '.login #backtoblog a' ).css( 'color', newval );
		});
	});

	wp.customize( 'login_customizer_options[logincust_other_color_hover]', function( value ) {
		value.bind( function( newval ) {
			$( '.login #backtoblog a' ).hover( function(){
				$( this ).css( 'color', newval );
			}, function(){
				$( this ).css( 'color', othercolor );
			});
			$( '.login #nav a' ).hover( function(){
				$( this ).css( 'color', newval );
			}, function(){
				$( this ).css( 'color', othercolor );
			});
		});
	});

});
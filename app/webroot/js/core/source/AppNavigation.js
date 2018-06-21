(function (namespace, $) {
	"use strict";

	var AppNavigation = function () {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function () {
			o.initialize();
		});

	};
	var p = AppNavigation.prototype;

	// =========================================================================
	// MEMBERS
	// =========================================================================

	// Constant
	AppNavigation.MENU_MAXIMIZED = 1;
	AppNavigation.MENU_COLLAPSED = 2;
	AppNavigation.MENU_HIDDEN = 3;

	// Private
	p._lastOpened = null;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function () {
		this._enableEvents();
		
		//this._invalidateMenu();
		this._evalMenuScrollbar();
	};

	// =========================================================================
	// HANDLE AJAX LOAD
	// =========================================================================

	p.ajaxLoad = function (link, destino) {

		// VERIFICA SE O LINK TEM UMA URL DEFINIDA PARA SER REQUISITADA
		// CASO CONTRÁRIO NÃO CONTINUA O PROCESSO
        if (typeof link.attr('href') === 'undefined'){
	        return false;
        } else {
        	if (baseSub !== '/'){
        		link.attr('href', link.attr('href').replace(baseSub,''));
        	}
        	if (link.attr('href')[0] === '/'){
				link.attr('href', link.attr('href').replace('/',''));
			}
        }

       	// INSTANCIA VARIÁVEIS
        var history = (typeof link.attr('history') !== 'undefined') ? location.href.split('#')[0]+link.attr('history') : link.attr('href');
        var request = link.attr('requestJS');
        var modal = link.attr('modal');
        var destino = $(destino); 

		// VERIFICA O TIPO DE CARREGAMENTO, SE MODAL ABRI O 
		if (typeof link.attr('modal') !== 'undefined'){
			var modalObject = $('#nivel6');
			var url = link.attr('href');
	        window.materialadmin.AppForm.loadModal(modalObject, url, '500px', function(){
	        	// CARREGA JS REQUISITADO NO MENU
                p.requestJS(modalObject, request);
	        });
	        return false;
        }
        
		// REMOVE A PÁGINA ATUAL E EXIBE MENSAGEM DE CARREGAMENTO DE PÁGINA
		p.carregando(destino);

        // CARREGA A PÁGINA VIA AJAX
		destino.load(baseUrl+link.attr('href')+' ', function(page, textStatus, jqXHR){

            if(jqXHR.status == 200) {        
                // ALTERA O ENDEREÇO DA BARRA DE FERRAMENTAS                
                p.changeTitle(history,link);

                // CARREGA JS REQUISITADO NO MENU
                p.requestJS($(page), request);
            }
        });
	};

	p.changeTitle = function(history,link){
		window.history.pushState({url: "" + history + ""}, link.attr('title') , baseUrl+history);
        $('html, body').scrollTop(0);
	}

	p.requestJS = function(pageLoaded, request){
		// VERIFICA SE TEVE PERMISSÃO DE ACESSO
        if (!pageLoaded.find('#AppRestrito').length){
            // CARREGA SCRIPTS REQUISITADOS NO MENU
            if (typeof request !== 'undefined'){
            	window.materialadmin.App.load(request);
            }
        } else {
        	// CARREGA O SCRIPT RESTRITO
        	window.materialadmin.App.load('AppRestrito');
        }
	}

	p.carregando = function(element){
		// SE EXISTE SECTION ACIMA NÃO USE O SECTION
		if (element.closest('section').length > 0){
			element.html('<div class="alert alert-callout alert-warning" role="alert"><strong>Carregando...</strong> <i class="fa fa-spinner fa-spin"></i></div>');
		} else {
			element.html('<section><div class="section-body alert alert-callout alert-warning" role="alert"><strong>Carregando...</strong> <i class="fa fa-spinner fa-spin"></i></div></section>');
		}
	};

	// =========================================================================
	// EVENTS
	// =========================================================================

	// events
	p._enableEvents = function () {
		var o = this;

		// Window events
		$(window).on('resize', function (e) {
			o._handleScreenSize(e);
		});
		
		// Menu events
		$('[data-toggle="menubar"]').on('click', function (e) {
			o._handleMenuToggleClick(e);
		});
		$('[data-dismiss="menubar"]').on('click', function (e) {
			o._handleMenubarLeave();
		});
		$('#main-menu').on('click', 'li', function (e) {
			o._handleMenuItemClick(e);
		});
		$('#main-menu').on('click', 'a', function (e) {
			o._handleMenuLinkClick(e);
		});
		$('#header-menu').on('click', 'a', function (e) {
			var logout = $(this).attr('href').split('/users/logout').length;
					
			if (logout <= 1){
				o._handleMenuLinkClick(e);
			}
		});
		$('body.menubar-hoverable').on('mouseenter', '#menubar', function (e) {
			setTimeout(function () {
				o._handleMenubarEnter();
			}, 1);
		});
	};

	// handlers
	p._handleScreenSize = function (e) {
		//this._invalidateMenu();
		this._evalMenuScrollbar(e);
	};

	// =========================================================================
	// MENU TOGGLER
	// =========================================================================

	p._handleMenuToggleClick = function (e) {
		if (materialadmin.App.isBreakpoint('xs')) {
			$('body').toggleClass('menubar-pin');
		}

		var state = this.getMenuState();

		if (state === AppNavigation.MENU_COLLAPSED) {
			this._handleMenubarEnter();
		}
		else if (state === AppNavigation.MENU_MAXIMIZED) {
			this._handleMenubarLeave();
		}
		else if (state === AppNavigation.MENU_HIDDEN) {
			this._handleMenubarEnter();
		}
	};

	// =========================================================================
	// MAIN BAR
	// =========================================================================

	p._handleMenuItemClick = function (e) {
		e.stopPropagation();

		var item = $(e.currentTarget);
		var submenu = item.find('> ul');
		var parentmenu = item.closest('ul');

		this._handleMenubarEnter(item);
		
		if (submenu.children().length !== 0) {
			this._closeSubMenu(parentmenu);
			
			var menuIsCollapsed = this.getMenuState() === AppNavigation.MENU_COLLAPSED;
			if(menuIsCollapsed || item.hasClass('expanded') === false) {
				this._openSubMenu(item);
			}
		}
	};

	p._handleMenubarEnter = function (menuItem) {
		var o = this;
		var offcanvasVisible = $('body').hasClass('offcanvas-left-expanded');
		var menubarExpanded = $('#menubar').data('expanded');
		var menuItemClicked = (menuItem !== undefined);

		// Check if the menu should open
		if ((menuItemClicked === true || offcanvasVisible === false) && menubarExpanded !== true) {
			// Add listener to close the menubar
			$('#content').one('mouseover', function (e) {
				o._handleMenubarLeave();
			});

			// Add open variables
			$('body').addClass('menubar-visible');
			$('#menubar').data('expanded', true);

			// Triger enter event
			$('#menubar').triggerHandler('enter');

			if (menuItemClicked === false) {
				// If there is a previous opened item, open it and all of its parents
				if (this._lastOpened) {
					var o = this;
					this._openSubMenu(this._lastOpened, 0);
					this._lastOpened.parents('.gui-folder').each(function () {
						o._openSubMenu($(this), 0);
					});
				}
				else {
					// Else open the active item
					var item = $('#main-menu > li.active');
					this._openSubMenu(item, 0);
				}
			}
		}
	};

	p._handleMenubarLeave = function () {
		$('body').removeClass('menubar-visible');
		
		// Don't close the menus when it is pinned on large viewports
		if (materialadmin.App.minBreakpoint('md')) {
			if ($('body').hasClass('menubar-pin')) {
				return;
			}
		}
		$('#menubar').data('expanded', false);


		// Never close the menu on extra small viewports
		if (materialadmin.App.isBreakpoint('xs') === false) {
			this._closeSubMenu($('#main-menu'));
		}
	};

	p._handleMenuLinkClick = function (e) {
		// Prevent the link from firing
		e.preventDefault();

		// Get correct object "a"
		var link = (e.target.tagName != 'A') ? $(e.target).parents('a') : $(e.target);
		var path = '#content';

		// Remove acive class
		$('#header-menu li').removeClass('active');

		p._invalidateMenu(link);

		// Load page by ajax
		p.ajaxLoad(link, path);
	};

	// =========================================================================
	// OPEN / CLOSE MENU
	// =========================================================================

	p._closeSubMenu = function (menu) {
		var o = this;
		menu.find('> li > ul').stop().slideUp(170, function () {
			$(this).closest('li').removeClass('expanded');
			o._evalMenuScrollbar();
		});
	};

	p._openSubMenu = function (item, duration) {
		var o = this;
		if (typeof (duration) === 'undefined') {
			duration = 170;
		}
		
		// Remember the last opened item
		this._lastOpened = item;

		// Expand the menu
		item.addClass('expanding');
		item.find('> ul').stop().slideDown(duration, function () {
			item.addClass('expanded');
			item.removeClass('expanding');

			// Check scrollbars
			o._evalMenuScrollbar();

			// Manually remove the style, jQuery sometimes failes to remove it
			$('#main-menu ul').removeAttr('style');
		});
	};

	// =========================================================================
	// UTILS
	// =========================================================================

	p._invalidateMenu = function (item) {
		// PEGA TODOS OS LI DO MENU
		var menu_li = $('#main-menu li');
		var item_li = item.parents('li');

		// SE O ITEM É UM LINK OU UM A PASTA  
		// SE FOR UMA PASTA INTERROMPI O PROCESSO
		if (item.parent('li').hasClass('gui-folder')){
			return false;
        }

        // REMOVE A CLASSE ACTIVE 
		menu_li.removeClass('active');

		// ADICIONA A CLASSE ACTIVE NO LINK CLICADO
		item.parents('li:not(.gui-folder)').addClass('active');

		// Check if the menu is visible
		if ($('body').hasClass('menubar-visible')) {
			this._handleMenubarEnter();
		}

		// Trigger event
		$('#main-menu').triggerHandler('ready');

		// Add the animate class for CSS transitions.
		// It solves the slow initiation bug in IE, 
		// wich makes the collapse visible on startup
		$('#menubar').addClass('animate');
	};

	p.getMenuState = function () {
		// By using the CSS properties, we can attach 
		// states to CSS properties and therefor control states in CSS
		var matrix = $('#menubar').css("transform");
		var values = (matrix) ? matrix.match(/-?[\d\.]+/g) : null;
			
		var menuState = AppNavigation.MENU_MAXIMIZED;
		if (values === null) {
			if ($('#menubar').width() <= 100) {
				menuState = AppNavigation.MENU_COLLAPSED;
			}
			else {
				menuState = AppNavigation.MENU_MAXIMIZED;
			}
		}
		else {
			if (values[4] === '0') {
				menuState = AppNavigation.MENU_MAXIMIZED;
			}
			else {
				menuState = AppNavigation.MENU_HIDDEN;
			}
		}

		return menuState;
	};

	p._evalMenuScrollbar = function () {
		if (!$.isFunction($.fn.nanoScroller)) {
			return;
		}
		
		// First calculate the footer height
		var footerHeight = $('#menubar .menubar-foot-panel').outerHeight();
		footerHeight = Math.max(footerHeight, 1);
		$('.menubar-scroll-panel').css({'padding-bottom': footerHeight});
		
		
		// Check if there is a menu
		var menu = $('#menubar');
		if (menu.length === 0)
			return;
		
		// Get scrollbar elements
		var menuScroller = $('.menubar-scroll-panel');
		var parent = menuScroller.parent();

		// Add the scroller wrapper
		if (parent.hasClass('nano-content') === false) {
		menuScroller.wrap('<div class="nano"><div class="nano-content"></div></div>');
		}

		// Set the correct height
		var height = $(window).height() - menu.position().top - menu.find('.nano').position().top;
		var scroller = menuScroller.closest('.nano');
		scroller.css({height: height});

		// Add the nanoscroller
		scroller.nanoScroller({preventPageScrolling: true, iOSNativeScrolling: true});
	};

	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin.AppNavigation = new AppNavigation;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):

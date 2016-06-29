/*!
 * Nestable jQuery Plugin - Copyright (c) 2012 David Bushell - http://dbushell.com/
 * Dual-licensed under the BSD or MIT licenses
 */
;(function($, window, document, undefined)
{
	var SiteBuilder = function (el, options) {
        this.options = options;
        this.$el = $(el);
        this.init();
    };
	
	SiteBuilder.DEFAULTS = {
		'active': 'active',
		'htmlPanel':'<div class="site-panel panel panel-default"><div class="panel-heading"><h4>Add Something</h4><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div><div class="panel-body">Write Something here</div></div>',
	};
	SiteBuilder.prototype.init = function () {
		this.$topbar = this.$el.find('#top-header');
		this.$sidebar = this.$el.find('#side-nav');
		this.initSidebar();
	};
	
	SiteBuilder.prototype.initSidebar = function () {
		var that = this; // Site builder
		this.$sidebar.find('.site-control').each(function(){
			var $this = $(this); // Site control
			var panel = $(that.options.htmlPanel).prependTo(that.$sidebar).hide();
			panel.find('.close').on('click', $.proxy(that.onHidePanel, that));
			panel.find('>.panel-heading>h4').text($this.data('title'));
			$this.data('control.panel', panel);
			$this.on('click', $.proxy(that.onTogglePanel, that));
			that.onLoadPanel($this);
		});
		$(document).on('click', $.proxy(that.onHidePanel, that));
		$('.site-control, .site-panel').on('click', function(event){
			event.stopPropagation();
		});
	};
	
	SiteBuilder.prototype.onLoadPanel = function ($el) {
		var panel = $el.data('control.panel');
		var dataId = $el.data('id');
		if(dataId == 'control.pages'){
			panel.css('width','400px');
		}
	};
	
	SiteBuilder.prototype.onTogglePanel = function (event) {
		var that = this;
		var $this = $(event.currentTarget);
		var panel = $this.data('control.panel');
		if($this.hasClass(that.options.active)){
			$this.removeClass(that.options.active);
			panel.hide();			
		}else{
			that.$sidebar.find('.site-control').each(function(){
				$(this).removeClass(that.options.active);
				$(this).data('control.panel').hide();	
			});
			$this.addClass(that.options.active);
			panel.show();
		}
	};
	SiteBuilder.prototype.onHidePanel = function (event) {
		var that = this;
		that.$sidebar.find('.site-control').each(function(){
			var $this = $(this);
			var panel = $this.data('control.panel');
			$this.removeClass(that.options.active);
			panel.hide();
		});
	};

	SiteBuilder.prototype.onLoadPanelPages = function () {

	};	
	
	$.fn.siteBuilder = function (options) {
		this.each(function () {
			var $this = $(this), data = $this.data('site.builder');
			if (!data) {
				var options = $.extend({}, SiteBuilder.DEFAULTS, options);
				$this.data('site.builder', (data = new SiteBuilder(this, options)));
			}
		});
		return this;
	};
})(window.jQuery || window.Zepto, window, document);

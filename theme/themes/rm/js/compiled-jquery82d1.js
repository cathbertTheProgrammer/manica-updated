// Home Slider
$(window).load(function() {
	$('.loading').hide();  
	if ($('.carousel').hasClass("carousel-remember")) {
	
	  var banner_cookie_name="zp_banner_view";
	  var banner_next = [];
	  if ($.cookie(banner_cookie_name)) {
		banner_next = $.cookie(banner_cookie_name).split('-');
	  }
  
	  var banner_found = false;
	  if (banner_next.length) {
		banner_next.forEach(function(id){
		  if (!banner_found) {
			var $banner = $(".carousel .carousel-inner > .carousel-item[data-id="+id+"]:first");
			if ($banner.length) {
			  $banner.addClass("active")
			  $(".carousel .carousel-indicators li[data-slide-to="+$banner.data("slide-no")+"]").addClass('active');
			  banner_found = true;
			}
		  }
		});
	  } 
	  if (!banner_next.length || !banner_found) {
		$(".carousel .carousel-inner > .carousel-item:first").addClass("active");
		$(".carousel .carousel-indicators li:first").addClass("active");
	  }
  
	  banner_next = [];
	  $(".carousel .carousel-inner > .carousel-item.active").nextAll().each(function(){
		$this = $(this);
		banner_next.push($this.data('id'));
	  });
	  $($(".carousel .carousel-inner > .carousel-item.active").prevAll().get().reverse()).each(function(){
		$this = $(this);
		banner_next.push($this.data('id'));
	  });
	  $.cookie(banner_cookie_name, banner_next.join('-'));
	} else {
	  $(".carousel .carousel-inner > .carousel-item:first").addClass("active");
	  $(".carousel .carousel-indicators li:first").addClass("active");
	}
  
	
	
});
$(document).ready(function() {
	$('.carousel').carousel({
	  interval: 30000,
	  pause: "false"
	});
	$('#home-carousel').on('slide.bs.carousel', function () {
	  $('video').load();
	});

	// Accessibility
	$('.accessibility .access-btn').click(function(){
		$('.accessibility').toggleClass("open");
		return false;
	});
	
	// Scrolling Tabs
	$('.nav-tabs').scrollingTabs();
	  
	// Mobile Menu
	$(function() {
		$('nav#menu').mmenu({
			"extensions": [
			  "pageshadow",
			  "theme-dark"
		   ],
			offCanvas: {
			  position: "left"
		   }
		});
		var API = $("nav#menu").data( "mmenu" );

		$("#close").click(function() {
		   API.close();
		});
	});
	
	// Equal height
	$('.equal-height').matchHeight();
	$('.min-height').matchHeight();
	
	// Menu hover - Desktop
	if ( $(window).width() > 767 ) {
		$('.navbar-nav li.dropdown').hover(function() {
			$(this).addClass('show');
			$(this).children('.dropdown-menu').addClass('show');
		}, function() {
			$(this).removeClass('show');
			$(this).children('.dropdown-menu').removeClass('show');
		});
    } else {
        return false;
    }
	
	// Mobile menu - Toggle open on click
	(function($){
		$(document).ready(function(){
			$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
				event.preventDefault(); 
				event.stopPropagation(); 
				$(this).parent().siblings().removeClass('open');
				$(this).siblings().toggleClass('open');
			});
			$(".navbar-toggle").click(function() {
				$('.header-area').toggleClass('open');
			});
		});
	})(jQuery);
	
	// Fixed menu
	var stickyTop = $('.header-area').offset().top;
	$(window).on( 'scroll', function(){
		if ($(window).scrollTop() >= stickyTop) {
			$('.header-area').addClass('header-fixed');
		} else {
			$('.header-area').removeClass('header-fixed');
		}
	});
	
	
	$('.header-area .navbar-default .navbar-toggle').click(function() {
		$(this).parent(".navbar-header").toggleClass("open");
	});
	
	// Bootstrap - Tooltip
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
	
		
	// Fancybox
	$('[data-fancybox]').fancybox({
		youtube : {
			controls : 0,
			showinfo : 0
		},
		vimeo : {
			color : 'f00'
		}
	});
	
});

$(function() {
	// Home page counter

	if($('#counter').length){
	var a = 0;
	$(window).scroll(function() {
	
	  var oTop = $('#counter').offset().top - window.innerHeight;
	  if (a == 0 && $(window).scrollTop() > oTop) {
		$('.counter-value').each(function() {
		  var $this = $(this),
			countTo = $this.attr('data-count');
		  $({
			countNum: $this.text()
		  }).animate({
			  countNum: countTo
			},
	
			{
	
			  duration: 3000,
			  easing: 'swing',
			  step: function() {
				$this.text(Math.floor(this.countNum));
			  },
			  complete: function() {
				$this.text(this.countNum);
			  }
	
			});
		});
		a = 1;
	  }
	
	});
  }
  function newsByThemeUpdate($link, page) {
	  if ($link) {
		var $target = $($link.attr('href'));
		var theme = $link.data('id');
		var type = $link.data('type');
		var tag = $link.data('tag');
		var term = $link.data('term');
		var url = $link.data('url');
		var limit = $link.data('limit');
		var pagination = $link.data('pagination');
		var horizontal = $link.data('horizontal');
		var asset = $link.data('asset');
		var researcher = $link.data('researcher');
		var loader = '<div class="p-5 font-size-50 text-center"><i class="fa fa-spin fa-spinner"></i></div>';
  
		if (theme) {
		  url = url +'/theme/'+theme;
		}
		if (type) {
		  url = url +'/type/'+type;
		}
		if (tag) {
		  url = url +'/tag/'+tag;
		}
		if (term) {
		  url = url +'/term/'+encodeURIComponent(term);
		}
		if (limit) {
		  url = url +'/limit/'+limit;
		}
		if (asset) {
		  url = url +'/asset/'+asset;
		}
		if (researcher) {
		  url = url +'/researcher/'+researcher;
		}
		if ($("#news-by-theme-area .sort-by-field.active").length) {
		  var sortBy = $("#news-by-theme-area .sort-by-field.active:first").data("field");
		  url = url + "/sort-by/"+sortBy;
		  if (sortBy === 'relevance') {
			  $('#news-by-theme-area .sort-by-direction').addClass('disabled');
		  } else {
			  $('#news-by-theme-area .sort-by-direction').removeClass('disabled');
		  }
		}
		if ($("#news-by-theme-area .sort-by-direction.active").length) {
		  url = url + "/sort-direction/"+$("#news-by-theme-area .sort-by-direction.active:first").data("direction");
		}
		if ($("#news-by-theme-area .filter-by-date.active").length) {
		  url = url + "/date/"+$("#news-by-theme-area .filter-by-date.active:first").data("date-filter");
		}
		var dateRange = $("#news-by-theme-area .filter-by-range[name=\"date-range\"]").val();
		if (dateRange) {
			dateParts = dateRange.split(' - ');
			if (dateParts.length === 2) {
				url = url + "/date-start/"+dateParts[0].replace(/\//g, '-');
				url = url + "/date-end/"+dateParts[1].replace(/\//g, '-');
			}
		}
		if (pagination) {
		  url = url + "/pagination/yes";
		}
		if (horizontal) {
		  url = url + "/horizontal/1";
		}
		if (page) {
		  url = url + "?zpage="+page;
		}
		if (url) {
		  $target.html(loader).load(url);
		}
	  }
	}
  
	$("#news-by-theme-area .sort-by-theme").on("show.bs.tab",function(){
	  newsByThemeUpdate($(event.target));
	});
	$("#news-by-theme-area .sort-by-type").on("show.bs.tab",function(){
	  newsByThemeUpdate($(event.target));
	});
	$("#news-by-theme-area .sort-by-field").click(function(){
	  $("#news-by-theme-area .sort-by-field").removeClass('active');
	  $(this).addClass('active');
	  newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"));
	});
	$("#news-by-theme-area .sort-by-direction").click(function(){
	  $("#news-by-theme-area .sort-by-direction").removeClass('active');
	  $(this).addClass('active');
	  newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"));
	});
	$("#news-by-theme-area .filter-by-date").click(function(){
	  $("#news-by-theme-area .filter-by-date").removeClass('active');
	  $(this).addClass('active').parents(".dropdown-menu").prev(".dropdown-toggle").html($(this).html());
	  newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"));
	});
	$("#news-by-theme-area [name=\"date-range\"]").daterangepicker({
		autoUpdateInput: false,
		applyButtonClasses: 'btn btn-red',
		cancelButtonClasses: 'btn btn-red',
		locale: {
			cancelLabel: 'Clear'
		}
	});
	$("#news-by-theme-area [name=\"date-range\"]").on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
		newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"));
	});
	$("#news-by-theme-area [name=\"date-range\"]").on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
		newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"));
	});
	$("#news-by-theme-area [name=\"date-range\"]").on('shown.bs.collapse', function(){
		$(this).trigger('click');
	}) 
	$(document).on("click", "#news-by-theme-area .go-to-page", function(){
	  newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"), $(this).data('page'));
	});
	$(document).on("click", "#news-by-theme-area .pagination .page-link", function(e){
	  e.preventDefault();
	  $(window).scrollTop($("#news-by-theme-area").offset().top-200);
	  let pageCheck = $(this).attr('href').match(/.+\?zpage=(?<page>[0-9]+)/);
	  if (pageCheck) {
		let page = pageCheck.groups.page;
		if (page.match(/^[0-9]+$/)) {
			newsByThemeUpdate($("#news-by-theme-area .nav-link.active:first"), page);
		}
	  }
	});

	$("#generalSearchForm, #themeSearchForm").submit(function(){
		$(this).find('button[type="submit"]').attr('disabled', 'disabled');;
	});
	

});
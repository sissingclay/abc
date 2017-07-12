jQuery(document).ready(function($){
	$(".tt_tabs").bind("tabsbeforeactivate", function(event, ui){
		if(ui.newTab.length)
		{
			if(ui.newTab[0].parentNode.className.indexOf("all_filters")===-1)
				$("html, body").animate({scrollTop: $("#"+$(ui.newTab).children("a").attr("id")).offset().top}, 400);
			else
			{
				if($(".events_categories_filter").length)
					$("html, body").animate({scrollTop: $(".events_categories_filter").offset().top}, 400);
				else if($(".events_filter").length)
					$("html, body").animate({scrollTop: $(".events_filter").offset().top}, 400);
			}
		}
	});
	
	$(".tt_tabs").on("tabsactivate", function(event, ui){
		ui.newPanel.find(".image_carousel").trigger('configuration', ['debug', false, true]);
	});
	
	$(".tt_tabs_navigation a").click(function(event){
		var $this = $(this);
		$this.parent().parent().find("li").removeClass("ui-tabs-active");
		$this.parent().addClass("ui-tabs-active");
	});
	
	$(".tt_tabs").tabs({
		event: 'change',
		show: true,
		create: function(event, ui){
			$("html, body").scrollTop(0);
			if($(".tt_tabs_navigation.all_filters").length)
			{
				if(ui.tab.length && $(".tt_tabs_navigation.events_categories_filter a[href='" + ui.tab[0].children[0].hash + "']").length)
					$(".tt_tabs_navigation.events_categories_filter a[href='" + ui.tab[0].children[0].hash + "']").parent().addClass("ui-tabs-active");
				else
					$(".tt_tabs_navigation.events_categories_filter li:first-child a").parent().addClass("ui-tabs-active");
				
				if(ui.tab.length && $(".tt_tabs_navigation.events_filter a[href='" + ui.tab[0].children[0].hash + "']").length)
					$(".tt_tabs_navigation.events_filter a[href='" + ui.tab[0].children[0].hash + "']").parent().addClass("ui-tabs-active");
				else
					$(".tt_tabs_navigation.events_filter li:first-child a").parent().addClass("ui-tabs-active");
			}
		}
	});
	
	//browser history
	$(".tt_tabs .ui-tabs-nav a").click(function(){
		if($(this).attr("href").substr(0,4)!="http")
			$.bbq.pushState($(this).attr("href"));
		else
			window.location.href = $(this).attr("href");
	});
	
	//tabs box navigation
	$(".tabs_box_navigation").mouseover(function(){
		$(this).find("ul").removeClass("tabs_box_navigation_hidden");
	});
	
	$(".tabs_box_navigation a").click(function(event){
		if($.param.fragment()==$(this).attr("href").replace("#", "") || ($.param.fragment()=="" && $(this).attr("href").replace("#", "").substr(0, 10)=="all-events"))
			event.preventDefault();
		$(this).parent().parent().find(".selected").removeClass("selected");
		$(this).parent().addClass("selected");
		$(this).parent().parent().parent().children('label').text($(this).text());
		$(this).parent().parent().addClass("tabs_box_navigation_hidden");
	});
	
	$(".tt_tabs_navigation:not(.all_filter) a, .tabs_box_navigation:not(.all_filter) a").click(function(event){
		event.preventDefault();
		var $this = $(this);
		var hash = $this.attr("href");
		var event_str = ($(".events_filter .selected a").length ? $(".events_filter .selected a").attr("href").replace("#", "") : ($(".events_filter .ui-tabs-active a").length ? $(".events_filter .ui-tabs-active a").attr("href").replace("#", "") : ""));
		var events_category_str = ($(".events_categories_filter .selected a").length ? $(".events_categories_filter .selected a").attr("href").replace("#", "") : ($(".events_categories_filter .ui-tabs-active a").length ? $(".events_categories_filter .ui-tabs-active a").attr("href").replace("#", "") : ""));
		$("#tt_error_message").addClass("tt_hide");
		if(event_str!=="" && events_category_str!=="")
		{
			if((event_str!=="all-events" && events_category_str!=="all-events" && $("#" + event_str + ".tt-event-category-" + events_category_str).length) || (events_category_str==="all-events"))
				window.location.hash = "#" + event_str;
			else if(event_str==="all-events" && events_category_str!=="all-events")
				window.location.hash = "#" + events_category_str;
			else
			{
				window.location.hash = "#";
				$(".tt_tabs").tabs('option', 'collapsible', true);
				$(".tt_tabs").tabs('option', 'active', false);
				$("#tt_error_message").removeClass("tt_hide");
			}
		}
		else
			window.location.hash = hash;
	});
	
	if($(".events_categories_filter li.ui-tabs-active").length && $(".events_filter li.ui-tabs-active").length)	
		$(".events_filter li.ui-tabs-active a").click();
	
	//hashchange
	$(window).bind("hashchange", function(event){
		var hashSplit = $.param.fragment().split("-");
		var hashString = "";
		for(var i=0; i<hashSplit.length-1; i++)
			hashString = hashString + hashSplit[i] + (i+1<hashSplit.length-1 ? "-" : "");
		if(hashSplit[0].substr(0,7)!="filter" && hashSplit[0].substr(0,4)!="page")
			$(".tabs_box_navigation a[href='#" + decodeURIComponent($.param.fragment()) + "']").trigger("click");
		$('.tt_tabs .ui-tabs-nav [href="#' + decodeURIComponent(hashString) + '"]').trigger("change");
		$('.tt_tabs .ui-tabs-nav [href="#' + decodeURIComponent($.param.fragment()) + '"]').trigger("change");
	}).trigger("hashchange");
	
	//tooltip
	$(".tt_tooltip").bind("mouseover click", function(){
		var attachTo = $(this);
		if($(this).is(".event_container"))
			attachTo = $(this).parent();
		var position = attachTo.position();
		var tooltip_text = $(this).children(".tt_tooltip_text");
		tooltip_text.css("width", $(this).outerWidth() + "px");
		tooltip_text.css("height", tooltip_text.height() + "px");
		tooltip_text.css({"top": position.top-tooltip_text.innerHeight() + "px", "left": position.left + "px"});
	});
	
	//upcoming events
	$(".tt_upcoming_events").each(function(){
		var self = $(this);
		var autoscroll = 0;
		var elementClasses = $(this).attr('class').split(' ');
		for(var i=0; i<elementClasses.length; i++)
		{
			if(elementClasses[i].indexOf('autoscroll-')!=-1)
				autoscroll = elementClasses[i].replace('autoscroll-', '');
		}
		self.carouFredSel({
			direction: "up",
			items: {
				visible: (self.children().length>2 ? 3 : self.children().length),
				height: 'variable'
			},
			scroll: {
				items: 1,
				easing: "swing",
				pauseOnHover: true
			},
			prev: {button: self.next().children('#upcoming_event_prev')},
			next: {button: self.next().children('#upcoming_event_next')},
			auto: {
				play: (parseInt(autoscroll) ? true : false)
			}
		});
		
		self.find("li a.tt_upcoming_events_event_container, li>span").hover(function(){
			self.trigger('configuration', ['debug', false, true]);
		},
		function(){
			setTimeout(function(){
				self.trigger('configuration', ['debug', false, true]);
			}, 1);
		});
	});
	$(window).resize(function(){
		$(".tt_upcoming_events").trigger('configuration', ['debug', false, true]);
	});
	
	//timetable row heights
	/*var maxHeight = Math.max.apply(null, $(".timetable:visible tr td:first-child").map(function ()
	{
		return $(this).height();
	}).get());
	$(".timetable:visible tr td").css("height", maxHeight);
	//timetable height fix
	$(".timetable .event").each(function(){
		if($(this).children(".event_container").length>1)
		{
			var childrenHeight = 0;
			$(this).children(".event_container").not(":last").each(function(){
				childrenHeight += $(this).innerHeight();
			});
			var height = $(this).height()-childrenHeight-($(this).parent().parent().width()<=750 ? 9 : 22);
			if(height>$(this).children(".event_container").last().height())
				$(this).children(".event_container").last().css("height", height + "px");
		}
	});*/
});
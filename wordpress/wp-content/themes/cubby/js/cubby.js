(function ($) {
            $.fn.extend({
                Scroll: function (opt, callback) {
                    if (!opt) var opt = {};
                    var _btnUp = $("#" + opt.up);  
                    var _btnDown = $("#" + opt.down);
                    var _this = this.eq(0).find("ul:first");
                    var lineH = _this.find("li:first").height();     
                    var line = opt.line ? parseInt(opt.line, 10) : parseInt(this.height() / lineH, 10); 
                    var speed = opt.speed ? parseInt(opt.speed, 10) : 600; 
                    var m = line;  
                    var count = _this.find("li").length; 
                    var upHeight = line * lineH;
                    function scrollUp() {
                        if (!_this.is(":animated")) {  
                            if (m < count) {  
                                m += line;

                                _this.animate({ marginTop: "-=" + upHeight + "px" }, speed);
                            }
                        }
                    }
                    function scrollDown() {
                        if (!_this.is(":animated")) {
                            if (m > line) { 
                                m -= line;
                                _this.animate({ marginTop: "+=" + upHeight + "px" }, speed);
                            }
                        }
                    }
                    _btnUp.bind("click", scrollUp);
                    _btnDown.bind("click", scrollDown);
                }
            });
        })(jQuery);
      jQuery(function () {
            jQuery(".client-says").Scroll({ line: 1, speed: 500,up: "scroll_up", down: "scroll_down" });
        });
	  
  jQuery(document).ready(function() {
	 //carousel
	  if (jQuery("#feature-slider").length > 0) { 
      jQuery("#feature-slider").owlCarousel({
      navigation : true,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true,
	  autoPlay : true,
	  pagination : false,
	  navigationText: [
		"<i class='icon-chevron-left icon-white'></i>",
		"<i class='icon-chevron-right icon-white'></i>"
		],
		afterMove:function(e){
		jQuery(".owl-buttons .carousel_item_title").remove();
		var title    = e.find(".owl-item:nth-child("+(this.owl.currentItem+1)+") img").attr("alt");
		var img_link = e.find(".owl-item:nth-child("+(this.owl.currentItem+1)+") a").attr("href");
		if(typeof img_link === "undefined"){img_link = "#";}
		jQuery(".owl-prev").after("<span class='carousel_item_title'><a href='"+img_link+"'>"+title+"</a></span>");
		},
		afterInit:function(e){
		
		var title    = e.find(".owl-item:nth-child(1) img").attr("alt");
		var img_link = e.find(".owl-item:nth-child(1) a").attr("href");
		if(typeof img_link === "undefined"){img_link = "#";}
		jQuery(".owl-prev").after("<span class='carousel_item_title'><a href='"+img_link+"'>"+title+"</a></span>");
		}
      });
	  }
    if (jQuery("#partners-slider").length > 0) { 
	var owl = jQuery("#partners-slider");
    owl.owlCarousel({items : 4,pagination : false});
	
    // Custom Navigation Events
    jQuery(".carousel-next").click(function(){
    owl.trigger('owl.next');
    })
    jQuery(".carousel-prev").click(function(){
    owl.trigger('owl.prev');
    })
     }
  //menu

  jQuery('.site-nav ul li').hover(function(){
	jQuery(this).find('ul:first').slideDown(100);
	jQuery(this).addClass("hover");
	},function(){
	jQuery(this).find('ul').css('display','none');
	jQuery(this).removeClass("hover");
	});
  jQuery('.site-nav li ul li:has(ul)').find("a:first").append(" <span class='menu_more'>»</span> ");
   var menu_width = 0;
		jQuery('.site-nav ul:first > li').each(function(){
       menu_width = jQuery(this).outerWidth()+menu_width;
		if(menu_width > jQuery(this).parents("ul").innerWidth()){
			jQuery(this).prev().addClass("menu_last_item");
			menu_width = jQuery(this).outerWidth();
			}						   
});
		
//slider

       if(jQuery("#top-slider").length > 0 ){
        jQuery("#top-slider").nivoSlider( {prevText: "",nextText: "",controlNav:false});
	   }

//contact
    jQuery("form.contact-form").submit(function(){
	var Name    = jQuery(this).find("input#contact-name").val();
	var Email   = jQuery(this).find("input#contact-email").val();
	var Message = jQuery(this).find("textarea#contact-msg").val();
	var     obj = jQuery(this);
    jQuery('.fa-spinner').remove();
	jQuery(this).find("#loading").append('<i class="fa fa-spinner fa-2 fa-spin"></i>');
	
	 jQuery.ajax({
				 type:"POST",
				 dataType:"json",
				 url:cubby_params.ajaxurl,
				 data:"contact-name="+Name+"&contact-email="+Email+"&contact-msg="+Message+"&action=cubby_contact",
				 success:function(data){
					 if(data.error==0){
						   obj.find("#loading").html(data.msg);	
						  }
				obj.find('.fa-spinner').remove();
				obj[0].reset();
				return false;
				},
				error:function(){
					obj.find("#loading").html("Error.");
					obj.find('.fa-spinner').remove();
					return false;
					}});
	 return false;
	 });
	
    });
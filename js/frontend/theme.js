var mainCategoriesHtml = {};
jQuery(document).ready(function(){
    jQuery('.tip').tooltip();
    jQuery('.dropdown-toggle').dropdown();

	jQuery('.bxslider').bxSlider({
	    pagerCustom: '#bx-pager'
	});

    jQuery('.bestselling').bxSlider({
        slideWidth: 200,
        minSlides: 2,
        maxSlides: 5,
        slideMargin: 20
    });
  
    jQuery('.also').bxSlider({
        slideWidth: 200,
        minSlides: 2,
        maxSlides: 5,
        slideMargin: 20
    });
  
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });
    
    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });
	
	jQuery('#myTab1 .mainCategoryLink').click(function(){
		var id = parseInt(jQuery(this).data('id'))
		,	dataToEl = jQuery(jQuery(this).attr('href'))
		,	writeHtml = function() {
				dataToEl.html( mainCategoriesHtml[ id ] );
			};
		
		if(!mainCategoriesHtml[ id ]) {
			doAjaxReq({
				url: getReqUrl('categories/getProductsHtml/'+ id)
			,	msgEl: dataToEl
			,	onSuccess: function(res) {
					if(!res.errors && res.html) {
						mainCategoriesHtml[ id ] = res.html;
						writeHtml();
					}
				}
			});
		} else {
			writeHtml();
		}
	});
	jQuery('#myTab1 .mainCategoryLink:first').click();
    
    // animate download counter for products
    var count = jQuery('.progress p').attr('data-has');
    jQuery('.progress p').animateNumber(
        {
          number: count
        },
        1000
    );
    
    jQuery('#filters a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    })
});

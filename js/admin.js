jQuery(document).ready(function() {		
    App.setPage("index");  //Set current page
    App.init(); //Initialise plugins and elements

    jQuery('#sidebar .sub .active').parent().css('display','block').parent().addClass('open');
});
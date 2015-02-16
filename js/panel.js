/* 
 * Satellite Panel JS
 * @author C- Pres
 * @site http://c-pr.es/satellite
 *
 */

jQuery(document).ready(function($) {
  
  slidePanel = function(e) {
    e.preventDefault();

    if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') == 'off'){
      $(this).attr('data-toggled','on');
      $(this).find($('.panel-info')).fadeIn('fast');
    } else {
      $(this).attr('data-toggled','off');
      $(this).find($('.panel-info')).fadeOut('slow');
    }
    
  }
  panelAway = function () {
    $(this).find($('.panel-info')).fadeOut('slow');
    $(this).attr('data-toggled','off');
  }
  
  $('.portrait-slide').each( function() {
    $(this).on( "tap click", slidePanel );
    $(this).hover( slidePanel, panelAway );
  });
  
});
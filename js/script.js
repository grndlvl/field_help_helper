/**
 * @file
 * JavaScript file for the Coffee module.
 */

(function ($, Drupal, drupalSettings, context) {

  Drupal.behaviors.field_help_helper = {
    attach: function () {
      var $formWrapper = $('.form-wrapper', context);
      var $helperLink = $('a[data-drupal-selector="edit-field-help-helper-link"]', context);
      var $description = $('.description', context);

      $formWrapper.each(function(){
        if ($(this).find($description).length) {
          $(this)
            .find($helperLink)
            .on('mouseover', function(){
              $(this).parent($formWrapper).find($description).addClass('hovered');
            }).on('mouseout', function(){
              $(this).parent($formWrapper).find($description).removeClass('hovered');
            });
        }
      });
    }
  }

}(jQuery, Drupal, drupalSettings));

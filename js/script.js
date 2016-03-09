/**
 * @file
 * JavaScript file for the Coffee module.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.field_help_helper = {
    attach: function (context) {
      var $edit_links = $('a[data-drupal-selector="edit-field-help-helper-link"]', context);
      var help_text_selector = '.description';
      var hover_class = 'hovered';

      $edit_links.each(function () {
        $(this)
          .on('mouseover', function() {
            $(help_text_selector, $(this).parent()).addClass(hover_class);
          })
          .on('mouseout', function() {
            $(help_text_selector, $(this).parent()).removeClass(hover_class);
          });
      });
    }
  }

}(jQuery, Drupal, drupalSettings));

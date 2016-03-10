/**
 * @file
 * JavaScript file for the Field help helper module.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.field_help_helper = {
    attach: function (context) {
      var $edit_links = $('a[data-drupal-selector="edit-field-help-helper-link"]', context);
      var help_text_selector = '.description';

      $edit_links.each(function () {
        $(this)
          .once('field-help-helper-link')
          .appendTo($(help_text_selector, $(this).parent()))
      });
    }
  }

}(jQuery, Drupal, drupalSettings));


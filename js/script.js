/**
 * @file
 * JavaScript file for the Coffee module.
 */

(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.field_help_helper = {
    attach: function (context) {
      var $edit_links = $('a.field-help-helper-link', context);
      var help_text_selector = '.description';

      $edit_links.each(function () {
        $(this)
          .once()
          .appendTo(help_text_selector)
      });
    }
  }

}(jQuery, Drupal));

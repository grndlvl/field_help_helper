/**
 * @file
 * JavaScript file for the Coffee module.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.field_help_helper = {
    attach: function (context) {
      $('a[data-drupal-selector="edit-field-help-helper-link"]', context).each(function () {
        $(this).on('mouseover mouseout', function() {
          $('.description', $(this).parent()).toggleClass('hovered');
        });
      });
    }
  }

}(jQuery, Drupal, drupalSettings));

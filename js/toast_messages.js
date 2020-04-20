(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.toast_messages = {
    attach: function (context, settings) {
      $("body")
        .once()
        .each(function () {
          if ("toast_messages" in settings) {
            let messages = settings.toast_messages.messages;
            toastr.options = settings.toast_messages.options;
            let keys = Object.keys(messages);

            //iterate through all messagesQ
            for (var i = 0; i < keys.length; i++) {
              let type = keys[i];
              let message = messages[keys[i]];
              printMessage(type, message);
            }
          }
        });
    },
  };

  // If there is ajax command
  if (Drupal.AjaxCommands) {
    Drupal.AjaxCommands.prototype.toastMessageCommand = function (
      ajax,
      response,
      status
    ) {
      toastr.options = response.options;
      printMessage(response.type, response.message);
    };
  }

  /**
   * @type: type of message.
   * @message : the actual message
   * Prints message as toast.
   * The color of message is based on the type.
   */
  function printMessage(type, message) {
    if (type == "status") {
      toastr.success(message);
    } else if (type == "error") {
      toastr.error(message);
    } else if (type == "info") {
      toastr.info(message);
    } else {
      toastr.warning(message);
    }
  }
})(jQuery, Drupal, drupalSettings);

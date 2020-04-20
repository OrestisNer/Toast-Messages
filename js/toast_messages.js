(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.toast_messages = {
    attach: function (context, settings) {
      $("body")
        .once()
        .each(function () {
          var checkReadyState = setInterval(() => {
            if (document.readyState === "complete") {
              clearInterval(checkReadyState);
              print(settings);
            }
          }, 100);
        });
    }
  };

  const print = (settings) => {
    if ("toast_messages" in settings) {
      const messages = { ...settings.toast_messages.messages };
      const options = { ...settings.toast_messages.options };
      const library = options.library;
      const path = options.module_path;
      delete options.library;
      delete options.path;

      const keys = Object.keys(messages);

      if (library === "toastr") {
        toastr.options = { ...options };
      }

      //iterate through all messages
      for (let i = 0; i < keys.length; i++) {
        const type = keys[i];
        messages[type].map((message) => {
          if (library === "toastr") {
            printToastrMessage(type, message);
          } else if (library === "vanilla_toasts") {
            printVanillaToastMessage(type, message, options, path);
          }
        });
      }
    }
  };

  const printVanillaToastMessage = (type, message, options, path) => {
    if (type === "status") {
      type = "success";
    }

    VanillaToasts.create({
      title: type.charAt(0).toUpperCase() + type.slice(1),
      text: message,
      type: type, // success, info, warning, error   / optional parameter
      icon: `/${path}/icons/${type}.png`, // optional parameter
      timeout: options.timeout, // hide after 5000ms, // optional paremter
      positionClass: options.positionClass
    });
  };

  /**
   * @type: type of message.
   * @message : the actual message
   * Prints message as toast.
   * The color of message is based on the type.
   */
  const printToastrMessage = (type, message) => {
    if (type == "status") {
      toastr.success(message);
    } else if (type == "error") {
      toastr.error(message);
    } else if (type == "info") {
      toastr.info(message);
    } else {
      toastr.warning(message);
    }
  };

  // If there is ajax command
  if (Drupal.AjaxCommands) {
    Drupal.AjaxCommands.prototype.toastMessageCommand = function (
      ajax,
      response,
      status
    ) {
      const options = { ...response.options };
      const library = options.library;
      const path = options.module_path;
      delete options.path;
      delete options.library;
      if (library === "toastr") {
        toastr.options = { ...options };
        printToastrMessage(response.type, response.message);
      } else if (library === "vanilla_toasts") {
        printVanillaToastMessage(
          response.type,
          response.message,
          options,
          path
        );
      }
    };
  }
})(jQuery, Drupal, drupalSettings);

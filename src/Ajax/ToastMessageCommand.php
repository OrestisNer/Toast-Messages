<?php
/**
 * Ajax Command για την εμφάνιση μηνύματος
 * σε toast.
 */
namespace Drupal\toast_messages\Ajax;

use Drupal\Core\Ajax\CommandInterface;

class ToastMessageCommand implements CommandInterface {

  protected $message;
  protected $type;

  # Constructs
  public function __construct($message, $type) {
    $this->message = $message;
    $this->type = $type;
  }

  # Implements Drupal \Core\Ajax\CommandInterface: render ().
  public function render() {
    return [
      'command' => 'toastMessageCommand',
      'message' => $this->message,
      'type' => $this->type,
      // @todo add Dependency Injection
      'options' => \Drupal::config('toast_messages.settings')->getRawData(),
    ];
  }
}

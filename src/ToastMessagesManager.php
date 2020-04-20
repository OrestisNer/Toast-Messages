<?php

namespace Drupal\toast_messages;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Class ToastMessagesManager.
 */
class ToastMessagesManager {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Messenger\MessengerInterface definition.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new ToastMessagesManager object.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    MessengerInterface $messenger,
    AccountProxyInterface $current_user
  ) {
    $this->configFactory = $config_factory;
    $this->messenger = $messenger;
    $this->currentUser = $current_user;
  }

  /**
   * Undocumented function
   *
   * @param [type] $variables
   * @return void
   */
  public function handleMessages(&$variables) {
    if (!$this->disableForAdmin()) {
      $messages = $this->messenger->all();
      if (!empty($messages)) {
        $this->messenger->deleteAll();
        $variables['#attached']['drupalSettings']['toast_messages'] = [
          'messages' => $messages,
          'options' => $this->getLibrarySettings(),
        ];
      }
    }
    return $variables;
  }

  /**
   * Returns the settings for the selected
   * library. Also, removes the library prefix
   * from the keys.
   *
   * @return array
   */
  public function getLibrarySettings() {
    $settings = $this->configFactory->getEditable('toast_messages.settings');
    $library = $settings->get('library');
    // define library prefix
    $library_prefix = "{$library}_";
    // get all settings
    $data = $settings->getRawData();
    $initial_value = ['library' => $library];

    return array_reduce(array_keys($data), function ($acc, $key) use ($library_prefix, $data) {
      // check if $key has the right prefix
      $is_lib_property = mb_substr($key, 0, strlen($library_prefix)) === $library_prefix;
      // if not exclude this key
      if (!$is_lib_property) {
        return $acc;
      }
      // get value
      $value = $data[$key];
      // remove prefix
      $key = str_replace($library_prefix, "", $key);
      // merge with existing data
      return array_merge($acc, [$key => $value]);

    }, $initial_value);
  }

  /**
   * Returns
   *  TRUE: if user is admin and checkbox Disable For Admin is checked
   *  FALSE: In all other cases
   *
   * @return boolean
   */
  public function disableForAdmin() {
    $settings = $this->configFactory->getEditable('toast_messages.settings');
    return (
      $settings->get('disableForAdmin') &&
      in_array('administrator', $this->currentUser->getRoles())
    );
  }

  /**
   * Attach appropriate libraries based on settings
   *
   * @param array $attachments
   * @return array
   */
  public function loadLibraries(array &$attachments) {
    $settings = $this->configFactory->getEditable('toast_messages.settings');
    $library = $settings->get('library');
    $attachments['#attached']['library'][] = "toast_messages/{$library}";
    $attachments['#attached']['library'][] = 'toast_messages/toast_messages';
    return $attachments;
  }
}

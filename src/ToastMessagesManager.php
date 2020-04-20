<?php

namespace Drupal\toast_messages;

use Drupal\Core\Config\Config;
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
    $settings = $this->configFactory->getEditable('toast_messages.settings');
    if (!$this->disableForAdmin($settings)) {
      $messages = $this->messenger->all();
      if (!empty($messages)) {
        $this->messenger->deleteAll();
        $variables['#attached']['drupalSettings']['toast_messages'] = [
          'messages' => $messages,
          'options' => $this->getLibrarySettings($settings),
        ];
      }
    }
    return $variables;
  }

  /**
   * Returns
   *  TRUE: if user is admin and checkbox Disable For Admin is checked
   *  FALSE: In all other cases
   *
   * @param Drupal\Core\Config\Config $settings
   * @return boolean
   */
  public function disableForAdmin(Config $settings) {
    return (
      $settings->get('disableForAdmin') &&
      in_array('administrator', $this->currentUser->getRoles())
    );
  }
}

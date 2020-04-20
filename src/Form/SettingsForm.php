<?php

namespace Drupal\toast_messages\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'toast_messages.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('toast_messages.settings');

    $form['settings'] = [
      '#type' => 'vertical_tabs',
      '#title' => t('Settings'),
    ];

    $form['general'] = [
      '#type' => 'details',
      '#title' => t('General'),
      '#group' => 'settings',
    ];

    $form['general']['positionClass'] = [
      '#type' => 'select',
      '#title' => $this->t('Position'),
      '#options' => [
        'toast-bottom-full-width' => $this->t('Bottom Full Width'),
        'toast-bottom-right' => $this->t('Bottom Right'),
        'toast-bottom-left' => $this->t('Bottom Left'),
        'toast-top-full-width' => $this->t('Top Full Width'),
        'toast-top-right' => $this->t('Top Right'),
        'toast-top-left' => $this->t('Top Left'),
      ],
      '#default_value' => $config->get('positionClass') ?? 'toast-bottom-full-width',
    ];

    $form['general']['progressBar'] = [
      '#type' => 'select',
      '#title' => $this->t('Progress Bar'),
      '#description' => $this->t('Visually indicate how long before a toast expires.'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $config->get('progressBar') ?? 'true',
    ];

    $form['general']['newestOnTop'] = [
      '#type' => 'select',
      '#title' => $this->t('Newest On Top'),
      '#description' => $this->t('Show newest toast at top.'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $config->get('newestOnTop') ?? 'false',
    ];

    $form['general']['closeButton'] = [
      '#type' => 'select',
      '#title' => $this->t('Close Button'),
      '#description' => $this->t('Optionally enable a close button'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $config->get('closeButton') ?? 'true',
    ];

    $form['general']['preventDuplicates'] = [
      '#type' => 'select',
      '#title' => $this->t('Prevent Dublicates'),
      '#description' => $this->t('Rather than having identical toasts stack, set the preventDuplicates property to true.'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $config->get('preventDuplicates') ?? 'true',
    ];

    $form['general']['disableForAdmin'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable for Administrator(s)'),
      '#description' => $this->t('Disable toastr for administator users. (Good for debugging)'),
      '#default_value' => $config->get('disableForAdmin') ?? 1,
    ];

    $form['show'] = [
      '#type' => 'details',
      '#title' => t('Show'),
      '#group' => 'settings',
    ];

    $form['show']['showMethod'] = [
      '#type' => 'select',
      '#title' => $this->t('Show Animation'),
      '#options' => [
        'slideDown' => $this->t('Slide Down'),
        'slideUp' => $this->t('Slide Up'),
      ],
      '#default_value' => $config->get('showMethod') ?? 'slideDown',
    ];

    $form['show']['showEasing'] = [
      '#type' => 'select',
      '#title' => $this->t('Show Easing'),
      '#options' => [
        'swing' => $this->t('Swing'),
        'linear' => $this->t('Linear'),
      ],
      '#default_value' => $config->get('showEasing') ?? 'swing',
    ];

    $form['hide'] = [
      '#type' => 'details',
      '#title' => t('Hide'),
      '#group' => 'settings',
    ];

    $form['hide']['hideMethod'] = [
      '#type' => 'select',
      '#title' => $this->t('Hide Animation'),
      '#options' => [
        'slideDown' => $this->t('Slide Down'),
        'slideUp' => $this->t('Slide Up'),
      ],
      '#default_value' => $config->get('hideMethod') ?? 'slideUp',
    ];

    $form['hide']['hideEasing'] = [
      '#type' => 'select',
      '#title' => $this->t('Hide Easing'),
      '#options' => [
        'swing' => $this->t('Swing'),
        'linear' => $this->t('Linear'),
      ],
      '#default_value' => $config->get('hideEasing') ?? 'swing',
    ];

    $form['close'] = [
      '#type' => 'details',
      '#title' => t('Close'),
      '#group' => 'settings',
    ];

    $form['close']['closeMethod'] = [
      '#type' => 'select',
      '#title' => $this->t('Close Animation'),
      '#options' => [
        'slideDown' => $this->t('Slide Down'),
        'slideUp' => $this->t('Slide Up'),
      ],
      '#default_value' => $config->get('closeMethod') ?? 'slideUp',
    ];

    $form['close']['closeEasing'] = [
      '#type' => 'select',
      '#title' => $this->t('Close Easing'),
      '#options' => [
        'swing' => $this->t('Swing'),
        'linear' => $this->t('Linear'),
      ],
      '#default_value' => $config->get('closeEasing') ?? 'swing',
    ];

    $form['duration'] = [
      '#type' => 'details',
      '#title' => t('Duration'),
      '#group' => 'settings',
    ];

    $form['duration']['timeOut'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Timeout (ms)'),
      '#description' => $this->t('How long the toast will display without user interaction. Set timeout to 0 to prevent auto hiding.'),
      '#default_value' => $config->get('timeOut') ?? "7000",
    ];

    $form['duration']['extendedTimeOut'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Extended Timeout (ms)'),
      '#description' => $this->t('How long the toast will display after a user hovers over it. Set timeout to 0 to prevent auto hiding.'),
      '#default_value' => $config->get('extendedTimeOut') ?? "6000",
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('toast_messages.settings');
    $config
      ->delete()
      ->set('positionClass', $form_state->getValue('positionClass'))
      ->set('showMethod', $form_state->getValue('showMethod'))
      ->set('showEasing', $form_state->getValue('showEasing'))
      ->set('hideMethod', $form_state->getValue('hideMethod'))
      ->set('hideEasing', $form_state->getValue('hideEasing'))
      ->set('closeMethod', $form_state->getValue('closeMethod'))
      ->set('closeEasing', $form_state->getValue('closeEasing'))
      ->set('closeButton', $form_state->getValue('closeButton'))
      ->set('preventDuplicates', $form_state->getValue('preventDuplicates'))
      ->set('timeOut', $form_state->getValue('timeOut'))
      ->set('extendedTimeOut', $form_state->getValue('extendedTimeOut'))
      ->set('progressBar', $form_state->getValue('progressBar'))
      ->set('disableForAdmin', $form_state->getValue('disableForAdmin'));

    $config->save();
  }

}

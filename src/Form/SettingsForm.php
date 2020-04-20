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

    $form['library'] = [
      '#type' => 'select',
      '#title' => $this->t('Library'),
      '#description' => $this->t('Select the JS Library you want to use for displaying messages'),
      '#options' => [
        'toastr' => $this->t('Toastr'),
        'vanilla_toasts' => $this->t('VanillaToasts'),
      ],
      '#default_value' => $config->get('library'),
    ];

    $form['toastr_settings'] = [
      '#type' => 'vertical_tabs',
      '#title' => t('Toastr Settings'),
    ];

    $form['general'] = [
      '#type' => 'details',
      '#title' => t('General'),
      '#group' => 'toastr_settings',
    ];

    $form['general']['toastr_positionClass'] = [
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
      '#default_value' => $config->get('toastr_positionClass'),
    ];

    $form['general']['toastr_progressBar'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Progress Bar'),
      '#description' => $this->t('Visually indicate how long before a toast expires.'),
      '#default_value' => $config->get('toastr_progressBar'),
    ];

    $form['general']['toastr_newestOnTop'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Newest On Top'),
      '#description' => $this->t('Show newest toast at top.'),
      '#default_value' => $config->get('toastr_newestOnTop'),
    ];

    $form['general']['toastr_closeButton'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Close Button'),
      '#description' => $this->t('Optionally enable a close button'),
      '#default_value' => $config->get('toastr_closeButton'),
    ];

    $form['general']['toastr_preventDuplicates'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Prevent Dublicates'),
      '#description' => $this->t('Rather than having identical toasts stack, set the preventDuplicates property to true.'),
      '#default_value' => $config->get('toastr_preventDuplicates'),
    ];

    $form['show'] = [
      '#type' => 'details',
      '#title' => t('Show'),
      '#group' => 'toastr_settings',
    ];

    $form['show']['toastr_showMethod'] = [
      '#type' => 'select',
      '#title' => $this->t('Show Animation'),
      '#options' => [
        'slideDown' => $this->t('Slide Down'),
        'fadeIn' => $this->t('Fade In'),
        'show' => $this->t('Show'),
      ],
      '#default_value' => $config->get('toastr_showMethod'),
    ];

    $form['show']['toastr_showEasing'] = [
      '#type' => 'select',
      '#title' => $this->t('Show Easing'),
      '#options' => [
        'swing' => $this->t('Swing'),
        'linear' => $this->t('Linear'),
      ],
      '#default_value' => $config->get('toastr_showEasing'),
    ];

    $form['hide'] = [
      '#type' => 'details',
      '#title' => t('Hide'),
      '#group' => 'toastr_settings',
    ];

    $form['hide']['toastr_hideMethod'] = [
      '#type' => 'select',
      '#title' => $this->t('Hide Animation'),
      '#options' => [
        'fadeOut' => $this->t('Fade Out'),
        'slideUp' => $this->t('Slide Up'),
        'hide' => $this->t('Hide'),
      ],
      '#default_value' => $config->get('toastr_hideMethod'),
    ];

    $form['hide']['toastr_hideEasing'] = [
      '#type' => 'select',
      '#title' => $this->t('Hide Easing'),
      '#options' => [
        'swing' => $this->t('Swing'),
        'linear' => $this->t('Linear'),
      ],
      '#default_value' => $config->get('toastr_hideEasing'),
    ];

    $form['close'] = [
      '#type' => 'details',
      '#title' => t('Close'),
      '#group' => 'toastr_settings',
    ];

    $form['close']['toastr_closeMethod'] = [
      '#type' => 'select',
      '#title' => $this->t('Close Animation'),
      '#options' => [
        'fadeOut' => $this->t('Fade Out'),
        'slideUp' => $this->t('Slide Up'),
        'hide' => $this->t('Hide'),
      ],
      '#default_value' => $config->get('toastr_closeMethod'),
    ];

    $form['close']['toastr_closeEasing'] = [
      '#type' => 'select',
      '#title' => $this->t('Close Easing'),
      '#options' => [
        'swing' => $this->t('Swing'),
        'linear' => $this->t('Linear'),
      ],
      '#default_value' => $config->get('toastr_closeEasing'),
    ];

    $form['duration'] = [
      '#type' => 'details',
      '#title' => t('Duration'),
      '#group' => 'toastr_settings',
    ];

    $form['duration']['toastr_timeOut'] = [
      '#type' => 'number',
      '#title' => $this->t('Timeout (ms)'),
      '#description' => $this->t('How long the toast will display without user interaction. Set timeout to 0 to prevent auto hiding.'),
      '#default_value' => $config->get('toastr_timeOut'),
    ];

    $form['duration']['toastr_extendedTimeOut'] = [
      '#type' => 'number',
      '#title' => $this->t('Extended Timeout (ms)'),
      '#description' => $this->t('How long the toast will display after a user hovers over it. Set timeout to 0 to prevent auto hiding.'),
      '#default_value' => $config->get('toastr_extendedTimeOut'),
    ];

    $form['disableForAdmin'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable for Administrator(s)'),
      '#description' => $this->t('Disable toastr for administator users. (Good for debugging)'),
      '#default_value' => $config->get('disableForAdmin') ?? 1,
    ];

    // $form['toastr_settings'] = [
    //   '#type' => 'vertical_tabs',
    //   '#title' => t('Toastr Settings'),
    // ];

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
      ->set('toastr_positionClass', $form_state->getValue('toastr_positionClass'))
      ->set('toastr_showMethod', $form_state->getValue('toastr_showMethod'))
      ->set('toastr_showEasing', $form_state->getValue('toastr_showEasing'))
      ->set('toastr_hideMethod', $form_state->getValue('toastr_hideMethod'))
      ->set('toastr_hideEasing', $form_state->getValue('toastr_hideEasing'))
      ->set('toastr_closeMethod', $form_state->getValue('toastr_closeMethod'))
      ->set('toastr_closeEasing', $form_state->getValue('toastr_closeEasing'))
      ->set('toastr_closeButton', $form_state->getValue('toastr_closeButton'))
      ->set('toastr_preventDuplicates', $form_state->getValue('toastr_preventDuplicates'))
      ->set('toastr_timeOut', $form_state->getValue('toastr_timeOut'))
      ->set('toastr_extendedTimeOut', $form_state->getValue('toastr_extendedTimeOut'))
      ->set('toastr_progressBar', $form_state->getValue('toastr_progressBar'))
      ->set('disableForAdmin', $form_state->getValue('disableForAdmin'));

    $config->save();
  }

}

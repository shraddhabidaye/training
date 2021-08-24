<?php
namespace Drupal\training_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomConfigForm extends ConfigFormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'training_module_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'training_module.settings',
    ];
  }

  /**
  * {@inheritdoc}
  */
public function buildForm(array $form, FormStateInterface $form_state)
 {
  $config = $this->config('training_module.settings');
  $form['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Full Name:'),
    '#required' => TRUE,
  );
  $form['aboutme'] = array(
     '#type' => 'textarea',
     '#title' => $this->t('About Me:'),
     '#default_value' => $config->get('aboutme'),
   );
   $form['number'] = array (
     '#type' => 'tel',
     '#title' => t('Mobile no'),
   );
   return parent::buildForm($form, $form_state);
 }

  /**
   * {@inheritdoc}
   */
public function validateForm(array &$form, FormStateInterface $form_state)
{
    parent::validateForm($form, $form_state);
  }

  /**
    * {@inheritdoc}
    */
   public function submitForm(array &$form, FormStateInterface $form_state) {
     parent::submitForm($form, $form_state);

     $this->config('training_module.settings')
       ->set('aboutme', $form_state->getValue('aboutme'))
       ->save();
   }

}
 ?>

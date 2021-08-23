<?php
/**
 * @file
 * Contains \Drupal\training_module\Form\CustomForm.
 */
namespace Drupal\training_module\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class CustomForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }
  /**
   * {@inheritdoc}
   */
   public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name:'),
      '#required' => TRUE,
    );
    $form['aboutme'] = array(
      '#type' => 'textfield',
      '#title' => t('About Me:'),
      '#required' => TRUE,
    );
    $form['number'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
   }
  /**
    * {@inheritdoc}
    */
     public function validateForm(array &$form, FormStateInterface $form_state) {

       if (strlen($form_state->getValue('number')) < 10)
       {
         $form_state->setErrorByName('number', $this->t('Mobile number is too short.'));
       }
       if (strlen($form_state->getValue('number')) > 10)
       {
         $form_state->setErrorByName('number', $this->t('Mobile number is too long.'));
       }

     }
     /**
      * {@inheritdoc}
      */
     public function submitForm(array &$form, FormStateInterface $form_state) {
       $this->messenger()->addMessage($this->t('@fname ,Your application is being submitted!', array('@fname' => $form_state->getValue('fname'))));
       foreach ($form_state->getValues() as $key => $value) {
        // drupal_set_message($key . ': ' . $value);
        $this->messenger()->addMessage($key . ': ' . $value);
       }
     }
  }

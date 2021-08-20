<?php
/**
 * @file
 * @author
 * Contains \Drupal\training_module\Controller\FormController.
 */
namespace Drupal\training_module\Controller;
/**
 * Provides route responses for the training module.
 */
class FormController {
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function customform() {

    return \Drupal::formBuilder()->getForm('\Drupal\training_module\Form\CustomForm');
  }
}
?>

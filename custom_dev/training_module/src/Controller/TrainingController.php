<?php
/**
 * @file
 * @author
 * Contains \Drupal\training_module\Controller\TrainingController.
 */
namespace Drupal\training_module\Controller;
/**
 * Provides route responses for the training module.
 */
class TrainingController {
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function welcome() {
    $element = array(
      '#markup' => 'Hello world!',
    );
    return $element;
  }
}
?>

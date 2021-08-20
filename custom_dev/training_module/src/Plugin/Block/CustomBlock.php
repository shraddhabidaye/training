<?php
/**
 * @file
 * Contains \Drupal\training_module\Plugin\Block\.
 */
namespace Drupal\training_module\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Custom' Block.
 *
 * @Block(
 *   id = "custom_block",
 *   admin_label = @Translation("Custom Block"),
 *   category = @Translation("Custom Block"),
 * )
 */
class CustomBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => 'This block list is in custom block.',
    );
  }
}

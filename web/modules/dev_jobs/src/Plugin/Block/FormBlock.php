<?php

namespace Drupal\dev_jobs\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "form_block",
 *   admin_label = @Translation("form_block_label"),
 *   category = @Translation("form_block_category"),
 * )
 */
class FormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'form_block',
    ];
  }

}
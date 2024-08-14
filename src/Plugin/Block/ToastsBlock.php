<?php

declare(strict_types=1);

namespace Drupal\server_toasts\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a toasts block block.
 *
 * @Block(
 *   id = "server_toasts_toasts_block",
 *   admin_label = @Translation("Toasts block"),
 *   category = @Translation("Custom"),
 * )
 */
final class ToastsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    /*
     * Create an empty container element to hold the toasts.
     * This render array attaches the necessary javascript and css in the form
     * of a library.
     */
    $build['content'] = [
      '#markup' => '<div id="server-toast-container"></div>',
      '#attached' => [
        'library' => [
          'server_toasts/toasts'
        ],
      ]
    ];
    return $build;
  }

}

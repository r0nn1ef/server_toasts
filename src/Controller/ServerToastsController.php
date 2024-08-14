<?php

declare(strict_types=1);

namespace Drupal\server_toasts\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Returns responses for Server toasts routes.
 */
final class ServerToastsController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * @var \Drupal\server_toasts\Controller\Drupal\Core\Logger\LoggerChannelInterface $logger
   */
  protected \Drupal\Core\Logger\LoggerChannelInterface $logger;
  /**
   * The controller constructor.
   */
  public function __construct(LoggerChannelFactoryInterface $loggerFactory) {
    $this->logger = $loggerFactory->get('server_toasts');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('logger.factory'),
    );
  }

  /**
   * Builds the response.
   */
  public function toast(): StreamedResponse {
    // Create a local variable for the ETM so we can query the database for 'Toast' entities.
    $entityTypeManager = $this->entityTypeManager;
    $response = new StreamedResponse(function() {
      // Should probably inject this somehow.
      $entityTypeManager = \Drupal::entityTypeManager();
      $props = [
        'status' => 1,
      ];
      $toasts = $entityTypeManager->getStorage('server_toast')->loadByProperties($props);
      if ( $toasts ) {
        foreach ( $toasts as $toast ) {
          // You could use ServerToast entity fields as the event "type".
          echo "event: toast" . PHP_EOL;
          // You could use the Drupal renderer to use the theme system to render the toasts.
          $content = '<div class="toast toast-' . $toast->bundle() . ' toast-slide-in">';
          $content .= '<div class="toast-title">' . $toast->label() . '</div>';
          $description = $toast->get('description')->getValue()[0];
          $content .= '<div class="toast-content">' . check_markup($description['value'], $description['format']) . '</div>';
          $content .= '</div>';
          $data = json_encode( (object) ['id' => $toast->id(), 'content' => $content] );
          echo "data: {$data}" . PHP_EOL;
          echo "id: {$toast->id()}" . PHP_EOL;
          echo PHP_EOL;
          ob_flush();
          flush();
        }
      }

    });
    // Response MUST have this content type set.
    $response->headers->set('Content-type', 'text/event-stream');
    // Since we're streaming content responses, don't cache it.
    $response->headers->set('Cache-Control', 'no-cache');
    return $response;
  }

}

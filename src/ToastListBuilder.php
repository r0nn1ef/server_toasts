<?php

declare(strict_types=1);

namespace Drupal\server_toasts;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the toast entity type.
 */
final class ToastListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    $header['bundle'] = $this->t('Type');
    $header['uid'] = $this->t('Author');
    $header['created'] = $this->t('Created');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\server_toasts\ToastInterface $entity */
    $row['label'] = $entity->toLink();
    $row['bundle'] = ucfirst( str_replace('_', ' ', $entity->bundle() ) );
    $username_options = [
      'label' => 'hidden',
      'settings' => ['link' => $entity->get('uid')->entity->isAuthenticated()],
    ];
    $row['uid']['data'] = $entity->get('uid')->view($username_options);
    $row['created']['data'] = $entity->get('created')->view(['label' => 'hidden']);
    $row['status'] = $entity->get('status')->value ? $this->t('Enabled') : $this->t('Disabled');
    return $row + parent::buildRow($entity);
  }

}

<?php

declare(strict_types=1);

namespace Drupal\server_toasts;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of toast type entities.
 *
 * @see \Drupal\server_toasts\Entity\ToastType
 */
final class ToastTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No toast types available. <a href=":link">Add toast type</a>.',
      [':link' => Url::fromRoute('entity.server_toast_type.add_form')->toString()],
    );

    return $build;
  }

}

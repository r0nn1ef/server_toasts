<?php

declare(strict_types=1);

namespace Drupal\server_toasts;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a toast entity type.
 */
interface ToastInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

<?php

declare(strict_types=1);

namespace Drupal\server_toasts\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Toast type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "server_toast_type",
 *   label = @Translation("Toast type"),
 *   label_collection = @Translation("Toast types"),
 *   label_singular = @Translation("toast type"),
 *   label_plural = @Translation("toasts types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count toasts type",
 *     plural = "@count toasts types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\server_toasts\Form\ToastTypeForm",
 *       "edit" = "Drupal\server_toasts\Form\ToastTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\server_toasts\ToastTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer server_toast types",
 *   bundle_of = "server_toast",
 *   config_prefix = "server_toast_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/server_toast_types/add",
 *     "edit-form" = "/admin/structure/server_toast_types/manage/{server_toast_type}",
 *     "delete-form" = "/admin/structure/server_toast_types/manage/{server_toast_type}/delete",
 *     "collection" = "/admin/structure/server_toast_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class ToastType extends ConfigEntityBundleBase {

  /**
   * The machine name of this toast type.
   */
  protected string $id;

  /**
   * The human-readable name of the toast type.
   */
  protected string $label;

}

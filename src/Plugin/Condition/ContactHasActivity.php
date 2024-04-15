<?php

namespace Drupal\civicrm_entity_rules_example\Plugin\Condition;

use Drupal\civicrm_entity\CiviCrmApi;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Core\RulesConditionBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Contact has Activity' condition.
 *
 * @Condition(
 *   id = "civicrm_entity_rules_example_contact_has_activity",
 *   label = @Translation("Contact has Activity"),
 *   category = @Translation("CiviCRM"),
 *   context_definitions = {
 *     "contact_id" = @ContextDefinition("integer",
 *        label = @Translation("Contact ID"),
 *        description = @Translation("The CiviCRM contact id."),
 *        required = TRUE
 *      ),
 *     "activity_type" = @ContextDefinition("integer",
 *       label = @Translation("Activity Type"),
 *       description = @Translation("The activity type id"),
 *       multiple = FALSE,
 *       required = TRUE
 *     ),
 *   }
 * )
 */
class ContactHasActivity extends RulesConditionBase implements ContainerFactoryPluginInterface {

  /**
   * The CiviCRM API service.
   *
   * @var \Drupal\civicrm_entity\CiviCrmApi
   */
  protected $civicrmApi;

  /**
   * Constructs a ContactHasActivity object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\civicrm_entity\CiviCrmApi $civicrm_api
   *   The CiviCRM API service interface.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CiviCrmApi $civicrm_api) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->civicrmApi = $civicrm_api;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('civicrm_entity.api')
    );
  }

  /**
   * Check if contact is in group.
   *
   * @param int $contact_id
   *   The CiviCRM contact to check.
   * @param int $activity_type
   *   The activity type id.
   *
   * @return bool
   *   TRUE if the contact has an activity of that type.
   */
  protected function doEvaluate(int $contact_id, int $activity_type) {
    try {
      if (!empty($contact_id) && is_numeric($contact_id)) {
        $result = $this->civicrmApi->get('Activity', [
          'sequential' => 1,
          'target_contact_id' => (int) $contact_id,
          'activity_type_id' => $activity_type,
        ]);
        if (!empty($result[0]['id'])) {
          return TRUE;
        }
      }
    }
    catch (\CiviCRM_API3_Exception $e) {
      return FALSE;
    }
    return FALSE;
  }

}

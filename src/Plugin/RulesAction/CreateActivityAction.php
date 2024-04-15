<?php

namespace Drupal\civicrm_entity_rules_example\Plugin\RulesAction;

use Drupal\civicrm_entity\CiviCrmApiInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Core\RulesActionBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Create Activity' action.
 *
 * @RulesAction(
 *   id = "civicrm_entity_rules_example_create_activity",
 *   label = @Translation("Create Activity"),
 *   category = @Translation("CiviCRM"),
 *   context_definitions = {
 *      "contact_id" = @ContextDefinition("integer",
 *        label = @Translation("CiviCRM contact ID"),
 *        description = @Translation("The CiviCRM contact ID."),
 *        required = TRUE
 *      ),
 *      "subject" = @ContextDefinition("string",
 *        label = @Translation("Subject"),
 *        description = @Translation("Subject of the Activity"),
 *        assignment_restriction = "input",
 *        default_value = "",
 *        required = TRUE
 *      ),
 *      "activity_type" = @ContextDefinition("integer",
 *        label = @Translation("Activity Type ID"),
 *        description = @Translation("Numeric ID of activity type."),
 *        assignment_restriction = "input",
 *        default_value = FALSE,
 *        required = TRUE,
 *      ),
 *   }
 * )
 */
class CreateActivityAction extends RulesActionBase implements ContainerFactoryPluginInterface {

  /**
   * The CiviCRM API service.
   *
   * @var \Drupal\civicrm_entity\CiviCrmApiInterface
   */
  protected $civicrmApi;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CiviCrmApiInterface $civicrm_api) {
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
   * {@inheritdoc}
   */
  public function doExecute($contact_id, $subject, $activity_type) {
    $this->civicrmApi->save('Activity', [
      'activity_type_id' => $activity_type,
      'target_contact_id' => $contact_id,
      'subject' => $subject,
    ]);
  }

}

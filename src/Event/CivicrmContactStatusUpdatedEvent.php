<?php

namespace Drupal\civicrm_entity_rules_example\Event;

use Drupal\Component\EventDispatcher\Event;

/**
 * Event that is fired custom field is updated.
 *
 * @see civicrm_entity_rules_example_civicrm_custom()
 */
class CivicrmContactStatusUpdatedEvent extends Event {

  const EVENT_NAME = 'civicrm_entity_rules_example_civicrm_contact_status_updated';

  /**
   * The contact id.
   *
   * @var int
   */
  protected $contactId;

  /**
   * The status option value.
   *
   * @var int
   */
  protected $statusOption;

  /**
   * Constructs the object.
   *
   * @param int $contact_id
   *   The contact id.
   * @param int $status_option
   *   The value of Status custom field.
   */
  public function __construct(int $contact_id, int $status_option) {
    $this->contactId = $contact_id;
    $this->statusOption = $status_option;
  }

}

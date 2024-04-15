# CiviCRM Entity Rules Example

## Installation

Install module as per Drupal norms: https://www.drupal.org/docs/extending-drupal/installing-modules

## Create the Rule

## Import sample Reaction Rule configuration

```
langcode: en
status: true
dependencies: {  }
id: create_contact_reviewed_activity_on_status_update
label: 'Create Contact Reviewed Activity on Status Update'
events:
  -
    event_name: civicrm_entity_rules_example_civicrm_contact_status_updated
description: ''
tags: {  }
config_version: '3'
expression:
  id: rules_rule
  uuid: 79b1201f-6bfa-4972-8b3b-a7d5d72480e6
  weight: 0
  conditions:
    id: rules_and
    uuid: 82e27b0e-80aa-40c1-b511-cd38658a26b9
    weight: 0
    conditions:
      -
        id: rules_condition
        uuid: a5cc5a96-4f2e-4f01-9f30-841bae071f14
        weight: -50
        condition_id: rules_data_comparison
        negate: false
        context_values:
          operation: '=='
          value: '2'
        context_mapping:
          data: statusOption
        context_processors:
          operation:
            rules_tokens: {  }
          value:
            rules_tokens: {  }
        provides_mapping: {  }
      -
        id: rules_condition
        uuid: 2c80474e-9d7c-4a91-bbfb-dc8b58a13509
        weight: -49
        condition_id: civicrm_entity_rules_example_contact_has_activity
        negate: true
        context_values:
          activity_type: '72'
        context_mapping:
          contact_id: contactId
        context_processors:
          activity_type:
            rules_tokens: {  }
        provides_mapping: {  }
  actions:
    id: rules_action_set
    uuid: f4beaa75-9838-4e48-9f07-9d5aef6afab3
    weight: 0
    actions:
      -
        id: rules_action
        uuid: fa621d5c-9ad5-4e27-93bc-a6be6a57257f
        weight: 0
        action_id: civicrm_entity_rules_example_create_activity
        context_values:
          subject: 'Contact Reviewed'
          activity_type: '72'
        context_mapping:
          contact_id: contactId
        context_processors:
          subject:
            rules_tokens: {  }
          activity_type:
            rules_tokens: {  }
        provides_mapping: {  }
```

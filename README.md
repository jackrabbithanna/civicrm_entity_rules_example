# CiviCRM Entity Rules Example

## Installation

Install module as per Drupal norms: https://www.drupal.org/docs/extending-drupal/installing-modules

## Provides

This example module provides a custom Rules event, Rules condition, and Rules action.


## "Contact Contact Status updated" Rules event

This event fires when a custom field value is created/updated. The Rule is provided the contactId and the field value.

This event was for illustration purposes only. You would need to update 'custom_status_26' with the column name of your custom field: 
https://github.com/jackrabbithanna/civicrm_entity_rules_example/blob/master/civicrm_entity_rules_example.module#L19

The Event Object: 

The event is created and dispatched in a hook_civicrm_custom() implementation:
https://github.com/jackrabbithanna/civicrm_entity_rules_example/blob/master/civicrm_entity_rules_example.module#L20


## "Contact has Activity" Rules condition

This Rules condition checks if a contact has an Activity of a given type.

Configure the condition to use the contactId passed to the event, and the activity type from the Rules condition configuration.

https://github.com/jackrabbithanna/civicrm_entity_rules_example/blob/master/src/Plugin/Condition/ContactHasActivity.php

## "Create Activity" Rules Action

The Rules Action plugin object: https://github.com/jackrabbithanna/civicrm_entity_rules_example/blob/master/src/Plugin/RulesAction/CreateActivityAction.php

This Rules action uses dependency injection to receive the CiviCRM API service on instantiation.

The Rules Action can be configured to receive the contact id provided by the custom Rules event.

The activity type is set in the action configuration.

## Create the Rule

From the Rules listing page, /admin/config/workflow/rules , click the "Add reaction rule" button.

Choose the "Contact Contact Status updated" event from the "CiviCRM Contact" group.

Add a condition, of type "Contact has Activity" if you only want to create an activity, if one of the type for a contact hasn't been created yet.
For the "Contact ID" field, switch to data selection and select the "contactId" data selector.
For "Activity Type" enter the numeric activity type.
Negate the condition.

Optionally add a condition "Data comparison" for the rule action to happen for a certain custom field value.
For "Data to compare" select "statusOption"

For the "Data Value" enter the value for the custom field you want to trigger the action.

## "Create Activity" Rules action

RulesAction plugin https://github.com/jackrabbithanna/civicrm_entity_rules_example/blob/master/src/Plugin/RulesAction/CreateActivityAction.php

Add the Rules action from the Rule configuration page.

For "CiviCRM contact ID" switch to data selection mode. Select "contactId" for the "Data selector".

Enter a text phrase for the "Subject".

Enter a numeric activity type ID for "Activity Type ID".

## Example Reaction Rule configuration

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

<?php
// This file declares a managed database record of type "Job".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'Cron:Inheritedmembers.rebuild',
    'entity' => 'Job',
    'params' => 
    array (
      'version' => 3,
      'name' => 'Rebuild Inherited Memberships',
      'description' => 'Cycle through parent memberships and trigger rebuilding membership to inherited members.',
      'run_frequency' => 'Weekly',
      'api_entity' => 'Inheritedmembers',
      'api_action' => 'rebuild',
      'parameters' => '',
    ),
  ),
);

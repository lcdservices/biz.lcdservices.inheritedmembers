<?php

/**
 * Inheritedmembers.rebuild API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_inheritedmembers_rebuild_spec(&$spec) {
}

/**
 * Inheritedmembers.rebuild API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_inheritedmembers_rebuild($params) {
  //get all current inheritance/based memberships
  $dao = CRM_Core_DAO::executeQuery("
    SELECT m.id
    FROM civicrm_membership m
    JOIN civicrm_membership_type mt
      ON m.membership_type_id = mt.id
      AND mt.relationship_type_id IS NOT NULL
    JOIN civicrm_membership_status ms
      ON m.status_id = ms.id
      AND ms.is_current_member = 1
    JOIN civicrm_contact c
      ON m.contact_id = c.id
      AND c.is_deleted != 1
    WHERE m.owner_membership_id IS NULL
    ORDER BY m.contact_id, m.id
  ");

  //cycle through and edit/save to trigger relationship inheritance
  $i = 0;
  while ($dao->fetch()) {
    try {
      civicrm_api3('membership', 'create', [
        'id' => $dao->id,
      ]);

      $i++;
    }
    catch (CiviCRM_API3_Exception $e) {
    }
  }

  $returnValues = array(
    'records processed' => $i,
  );
  return civicrm_api3_create_success($returnValues, $params, 'Inheritedmembers', 'rebuild');
}

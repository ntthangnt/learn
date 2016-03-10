<?php

function orange_import_user_form($form, &$form_state) {
  $field_info_instances = field_info_instances();
  $field_instances = field_info_instances('user', 'user');
  echo '<pre>';
  print_R($field_instances);
  die;
  $form['import'] = array(
    '#type' => 'fieldset',
    '#title' => t('Import User'),
    '#weight' => 5,
    '#collapsible' => true,
    '#collapsed' => false,
  );
  $form['import']['csv_file'] = array(
    '#title' => t('Choose a file'),
    '#type' => 'managed_file',
    '#description' => t('Allowed file types: @ext .', array('@ext' => 'csv')),
    '#upload_location' => 'public://imexcel/',
    '#upload_validators' => array(
      'file_validate_extensions' => array('csv'),
    ),
  );
  $form['import']['submit'] = array('#type' => 'submit', '#value' => t('Import'));
  return $form;
}

function orange_import_user_form_submit($form, &$form_state) {
  $file = file_load($form_state['values']['csv_file']);
  if ($file != false) {
    $batch = array(
      'title' => t('Importing'),
      'operations' => array(
        array('read_csv', array($file->uri)), //
        array('insert_content_user', array(10)),
        array('detroy_file', array($file)),
      ),
      'finished' => 'import_user_finished',
      'title' => t('Processing import user'),
      'init_message' => t('Import is starting.'),
      'progress_message' => t('Processed @current out of @total.'),
      'error_message' => t('Import has encountered an error.'),
      'file' => drupal_get_path('module', 'export_import') . '/import.admin.inc',
    );
  }
  batch_set($batch);
}

/*
 * Delete file and session when batch finish
 */

function detroy_file($file) {
  if (isset($_SESSION['import_items'])) {
    unset($_SESSION['import_items']);
  }
  if ($file) {
    file_delete($file, true);
  }
}

/*
 * Read csv and create Session store
 */

function read_csv($file, &$context) {
  $handle = fopen($file, "r");
  $_SESSION['import_items'] = array();
  while (($fileop = fgetcsv($handle, 1000, "\n")) !== false) {
    if (!is_null($fileop[0])) {
      $_SESSION['import_items'][] = $fileop[0];
    }
  }
  return $_SESSION['import_items'];
}

/*
 * insert content from cvs to database
 */

function insert_content_user($limit, &$context) {
  if (empty($context['sandbox'])) {
    $context['sandbox']['progress'] = 1;
    $context['sandbox']['current_index'] = 1;
    $context['sandbox']['max'] = count($_SESSION['import_items']);
  }
  $stop = $context['sandbox']['current_index'] + $limit;
  if ($stop > $context['sandbox']['max'])
    $stop = $context['sandbox']['max'];
  for ($i = $context['sandbox']['current_index']; $i < $stop; $i++) {
    $data = explode(';', $_SESSION['import_items'][$i]);
    orange_import_user($data);
    $context['results'][] = $_SESSION['import_items'][$i];
    $context['sandbox']['progress']++;
    $context['sandbox']['current_index']++;
    $context['message'] = $data[0] . ' : ' . $data[1];
  }
  if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
    $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
  }
}

function orange_import_user($row) {
  $languageCode = isset($arrLanguage[trim($row[11])]) ? $arrLanguage[trim($row[11])] : '';
  if (!empty($row) && ($row[1] !== '' || !empty($row[1]))) {
    try {
      $user = user_load_by_mail($row[1]);
      if (empty($user)) {
        $region = 0;
        if ($row[7]) {
          $region = getStateByCodeAndCountry($row[7], $row[20]);
        }
        $newsletter = 0;
        if ($row[12]) {
          $newsletter = 1;
        }
        $userinfo = array(
          'field_firstname' => array(LANGUAGE_NONE => array(
              0 => array('value' => $row[22]))),
          'field_lastname' => array(LANGUAGE_NONE => array(
              0 => array('value' => $row[24]
            ))),
          'field_section' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_function' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_phone_number' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_mobile' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_job_code' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_entity' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_hr_business_partner' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_plazza_profile_link' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_display_plazza_profile_lin' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_answer_manager' => array(LANGUAGE_NONE => array(
              0 => array('value' => $newsletter)
          )),
          'field_manager_email' => array(LANGUAGE_NONE => array(
              0 => array('value' => date('Y-m-d H:i:s', strtotime($row[15]))
            ))),
          'status' => 1,
          'name' => trim($row[1]),
          'mail' => trim($row[1]),
          'pass' => trim($row[23]),
          'field_country_user' => array(LANGUAGE_NONE => array(
              0 => array('value' => $country->id))),
          'field_region_state' => array(LANGUAGE_NONE => array(
              0 => array('value' => $region))),
          'field_city' => array(LANGUAGE_NONE => array(
              0 => array('value' => $row[16]))),
          'language' => $languageCode,
          'created' => strtotime($row[4]),
          'data' => array('product_favorite' => array()),
        );
        user_save(drupal_anonymous_user(), $userinfo);
      }
      $fields = array(
        'language_code' => $languageCode,
        'email' => $row[1],
        'date_created' => REQUEST_TIME,
      );
      if ($row[12] && $row[12] !== 0) {
        $newletter = db_select('newsletter', 'n')->fields('n', array('email'))->condition('email', trim($row[1]))->execute()->fetchCol();
        if (empty($newletter)) {
          //db_insert('newsletter')->fields($fields)->execute();
          $isInsert = insertNewsletter($fields);
        }
        else {
          $isInsert = updateNewsletter($row[1]);
          /* db_update('newsletter')->fields(array(
            'date_created' => REQUEST_TIME,
            ))->condition('email', trim($row[1]))->execute(); */
        }
      }
    } catch (Exception $e) {
      drupal_set_message($e, 'error');
    }
  }
}
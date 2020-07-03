<?php

namespace Drupal\mydata\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;


class MydataForm extends FormBase {


  public function getFormId() {
    return 'mydata_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('mydata', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
      );
    //print_r($form);die();

    $form['role'] = array(
      '#type' => 'textfield',
      '#title' => t('Role:'),
      '#default_value' => (isset($record['role']) && $_GET['num']) ? $record['role']:'',
      );

    $form['project'] = array(
      '#type' => 'textfield',
      '#title' => t('Project:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['project']) && $_GET['num']) ? $record['project']:'',
      );

    $form['domain'] = array(
      '#type' => 'textfield',
      '#title' => t('Domain:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['domain']) && $_GET['num']) ? $record['domain']:'',
      );

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save'
    ];

 
    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $name=$field['name'];
    $project=$field['project'];
    $role=$field['role'];
    $domain=$field['domain'];
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $uid= $user->get('uid')->value;

           $field  = array(
              'name'   => $name,
              'role' =>  $role,
              'project' =>  $project,
              'domain' => $domain,
              'userid' => $uid,
          );

           $query = \Drupal::database();
           $store=$query ->insert('mydata')
               ->fields($field)
               ->execute();
               //echo $store;
           
           $response = new RedirectResponse("/Drupalwebsite/web/mydata/view/".$uid);
          $response->send();
       }

}

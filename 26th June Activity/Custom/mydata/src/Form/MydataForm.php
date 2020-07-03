<?php

namespace Drupal\mydata\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

// Use for Ajax.
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\mydata\Event\ArticleEvent;
/**
 * Class MydataForm.
 *
 * @package Drupal\mydata\Form
 */
class MydataForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mydata_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('mydata', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

    $vid = 'interest';
        $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
          foreach ($terms as $term) {
           $intrestval[$term->name] = $term->name;
          }


    $form['f_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['fname']) && $_GET['num']) ? $record['name']:'',
      );
    //print_r($form);die();

    $form['l_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#default_value' => (isset($record['lname']) && $_GET['num']) ? $record['lname']:'',
      );

    $form['bio'] = array(
      '#type' => 'textfield',
      '#title' => t('Bio:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['bio']) && $_GET['num']) ? $record['bio']:'',
      );

    $form['gender'] = array (
      '#type' => 'radios',
      '#title' => t('Gender'),
      '#options' => array(
                t('Male'),
                t('Female'))
      );

   /* $form['interest'] = array (
      '#type' => 'textfield',
      '#title' => t('Interest'),
      '#default_value' => (isset($record['interest']) && $_GET['num']) ? $record['interest']:'',
       );*/
        $form['interest'] = array(
        '#type' => 'select',
        '#title' => t('Intrest'),
        '#multiple' => false,
        '#options' => $intrestval,
      );

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save',
        '#ajax' => [
                'callback' => '::setMessage',
            ],
    ];

 
    return $form;
  }

  /**
    * {@inheritdoc}
    */
 /* public function validateForm(array &$form, FormStateInterface $form_state) {

         $name = $form_state->getValue('candidate_name');
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('candidate_name', $this->t('your name must in characters without space'));
          }

          // Confirm that age is numeric.
        if (!intval($form_state->getValue('candidate_age'))) {
             $form_state->setErrorByName('candidate_age', $this->t('Age needs to be a number'));
            }

         /* $number = $form_state->getValue('candidate_age');
          if(!preg_match('/[^A-Za-z]/', $number)) {
             $form_state->setErrorByName('candidate_age', $this->t('your age must in numbers'));
          }*/

         /* if (strlen($form_state->getValue('mobile_number')) < 10 ) {
            $form_state->setErrorByName('mobile_number', $this->t('your mobile number must in 10 digits'));
           }

    parent::validateForm($form, $form_state);
  }
*/
  /**
   * {@inheritdoc}
   */

   public function setMessage(array $form, FormStateInterface $form_state) {
 
        $response = new AjaxResponse();
        $response->addCommand(
            new HtmlCommand(
                '.result_message',
                '<div class="my_message">Submitted title is</div>')
            );
        return $response;
    }
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $fname=$field['f_name'];
    //echo "$name";
    $lname=$field['l_name'];
    $bio=$field['bio'];
    $gender=$field['gender'];
    $interest=$field['interest'];

    /*$insert = array('name' => $name, 'mobilenumber' => $number, 'email' => $email, 'age' => $age, 'gender' => $gender, 'website' => $website);
    db_insert('mydata')
    ->fields($insert)
    ->execute();

    if($insert == TRUE)
    {
      drupal_set_message("your application subimitted successfully");
    }
    else
    {
      drupal_set_message("your application not subimitted ");
    }*/

  /*  if (isset($_GET['num'])) {
          $field  = array(
              'fname'   => $fname,
              'lname' =>  $lname,
              'bio' =>  $bio,
              'gender' => $gender,
              'interest' => $interest,
          );
          $query = \Drupal::database();
          $query->update('mydata')
              ->fields($field)
              ->condition('id', $_GET['num'])
              ->execute();
          drupal_set_message("succesfully updated");
          //$form_state->setRedirect('mydata.display_table_controller_display');

      }

       else
       {*/
           $field  = array(
              'fname'   => $fname,
              'lname' =>  $lname,
              'bio' =>  $bio,
              'gender' => $gender,
              'interest' => $interest,
          );

           $query = \Drupal::database();
           $store=$query ->insert('mydata')
               ->fields($field)
               ->execute();
               echo $store;
           
// How to dispatch an event in Drupal 8?
    $dispatcher = \Drupal::service('event_dispatcher');
    $event = new ArticleEvent($store);
    $dispatcher->dispatch(ArticleEvent::SUBMIT, $event);
    drupal_set_message("succesfully saved");
           //$response = new RedirectResponse("/mydata/hello/table");
          // $response->send();
       }
     //}

}

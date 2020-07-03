<?php

namespace Drupal\mydata\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;


class AdminTableController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'mydata_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }


  public function display() {

$database = \Drupal::database();
$query = $database->query("SELECT u.uid,u.name,u.mail,u.status from users_field_data as u where u.uid > 0 and u.status = 0");
//$query->condition('status', '1');
$result = $query->fetchAll();
//$uids = $query->execute();
//print_r($result);

    //create table header
    $header_table = array(
      'name' => t('Name'),
        'mail' => t('Mail')
    );
//echo $results[0]->name."adf";

        $rows=array();
        
       // print_r($results);
    foreach($result as $key => $object){
      //print the data from table
             $rows[] = array(
                'name' => $object->name,
                'mail' => $object->mail
            );

    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No Data found'),
        ];
        return $form;

  }

}

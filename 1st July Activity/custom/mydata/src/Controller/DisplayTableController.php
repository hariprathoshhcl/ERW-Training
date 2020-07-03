<?php

namespace Drupal\mydata\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;


class DisplayTableController extends ControllerBase {


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


    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/
$current_path = \Drupal::service('path.current')->getPath();
$path_args = explode('/', $current_path);
$userid =$path_args[3];
//echo $userid."fasf";
    //create table header
    $header_table = array(
     'id'=>    t('S.No'),
      'name' => t('Name'),
        'role' => t('Role'),
        'project' => t('Project'),
        'domain' => t('Domain')
    );

//select records from table
    $query = \Drupal::database()->select('mydata', 'm');
      $query->fields('m', ['id','name','role','project','domain'])
      ->condition('userid',$userid);
     // print_r( $query->fields('m', ['id','name','role','project','domain']));
      //echo "fdas";
      $results = $query->execute()->fetchAll();
        $rows=array();
       // print_r($results);
    foreach($results as $data){

      //print the data from table
             $rows[] = array(
            'id' =>$data->id,
                'name' => $data->name,
                'role' => $data->role,
                'project' => $data->project,
                'domain' => $data->domain
            );

    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No Data found'),
        ];
//        echo '<pre>';print_r($form['table']);exit;
        return $form;

  }

}

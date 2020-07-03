<?php

 

namespace Drupal\mydata\Plugin\rest\resource;

 

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

 
  @RestResource(
    id = "mydataapi",
    label = @Translation("Mydata api"),
    uri_paths = {
     "canonical" = "/api/v1/user-list"
  }
 )
 
class Mydatarestapi extends ResourceBase {


  protected $currentUser;


  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->logger = $container->get('logger.factory')->get('mydata');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }


    public function get() {

 

        $database = \Drupal::database();
        $query = $database->query("SELECT * FROM mydata");
        $result = $query->fetchAll();
        $i = 0;
        foreach($result as $row){ 
                foreach($row as  $key => $val){
                        $fetchval[$i][$key]= $val;
                }
            $i++;   
        }
        

        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }

 

        return new ResourceResponse($fetchval, 200);
    }
    
    
    

 

}
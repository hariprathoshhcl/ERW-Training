<?php
namespace Drupal\mydata\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\mydata\Event\ArticleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ArticleEventSubScriber implements EventSubscriberInterface {

  public static function getSubscribedEvents() {
    $events[ArticleEvent::SUBMIT][] = array('doSomeAction', 800);
    return $events;

  }


  public function doSomeAction(ArticleEvent $event) {
       \Drupal::logger('mydata')->notice("mydata event message");
  }


}
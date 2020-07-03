<?php

namespace Drupal\mydata\Event;

use Symfony\Component\EventDispatcher\Event;

class ArticleEvent extends Event {

  const SUBMIT = 'event.submit';
  protected $ID;

  public function __construct($ID)
  {
    $this->ID = $ID;
  }
}
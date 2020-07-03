<?php

namespace Drupal\mydata\Controller;

use Drupal\Core\Controller\ControllerBase;


class MydataController extends ControllerBase {


  public function display() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('This page contain all inforamtion about my data ')
    ];
  }

}

<?php

namespace Drupal\migrate_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DeleteNodeForm extends FormBase {


  public function getFormId() {
    return 'delete_node_form';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['delete_node'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Delete Node'),
    );

    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'article')
      ->sort('created', 'ASC')
      ->execute();

    $batch = array(
      'title' => t('Deleting Node...'),
      'operations' => array(
        array(
          '\Drupal\migrate_training\DeleteNode::deleteNodeExample',
          array($nids)
        ),
      ),
      'finished' => '\Drupal\migrate_training\DeleteNode::deleteNodeExampleFinishedCallback',
    );

    batch_set($batch);
  }

}
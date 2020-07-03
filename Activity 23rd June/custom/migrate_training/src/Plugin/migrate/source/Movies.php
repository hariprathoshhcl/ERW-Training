<?php
namespace Drupal\migrate_training\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

class Movies extends SqlBase {

  public function query() {
    $query = $this->select('movies', 'd')
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  public function fields() {
    $fields = [
      'id' => $this->t('Movie ID'),
      'name' => $this->t('Movie Name'),
      'description' => $this->t('Movie Description'),
      'genres' => $this->t('Movie Genres'),
    ];

    return $fields;
  }

  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'd',
      ],
    ];
  }

  public function prepareRow(Row $row) {
    $genres = $this->select('movies_genres', 'g')
      ->fields('g', ['id'])
      ->condition('movie_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('genres', $genres);
    return parent::prepareRow($row);
  }
}
<?php

namespace Drupal\migrate_training\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
class Genres extends SqlBase {

  public function query() {
    $query = $this->select('movies_genres', 'g')
      ->fields('g', ['id', 'movie_id', 'name']);
    return $query;
  }

  public function fields() {
    $fields = [
      'id' => $this->t('Genre ID'),
      'movie_id' => $this->t('Movie ID'),
      'name' => $this->t('Genre name'),
    ];

    return $fields;
  }
  
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'g',
      ],
    ];
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: victor.unda
 */

namespace Drupal\mainlab_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class MainLabViewController extends ControllerBase {

  /**
   *
   * @package Drupal\mainlab_list\Controller
   * @return array
   */
  public function mainlabviewslist() {

    /**
     * Retrieve and merge two functions. Functions:  retrieveArrayOne() AND retrieveArrayTwo()
     */
    $retrieveData = $this->mergeTwoArrays();
    $content = "<H2></H2>";
    foreach ($retrieveData as $key1 => $finalValues) {

      // If $key1 == 0, display Crop.
      if ($key1 == 0) {
        foreach ($finalValues as $disCrop) {
          $content .= "<details>";
          $content .= '<summary>' . $disCrop . '</summary>';

          /**
           * Object array.
           */
          foreach ($retrieveData as $key2 => $secondlevelCrop) {
            // If $key2 == 1, display Cultivar(title), and the body information.
            if($key2 == 1) {
              foreach ($secondlevelCrop as $secondlevelCrop) {
                $content .= '<p class="dt-body-justify" style="width:80%">';
                if($disCrop == $secondlevelCrop['field_mlfruitandnut_crop']) {
                  $content .= '<div class="media">';
                  $content .= '<div class="media-body">';
                  $content .= '<h4 class="media-heading">'. $secondlevelCrop['title']. '</h4>';

                  $bodySeeValue = $secondlevelCrop['body'];
                  $valueComp = "See ";
                  $FinalValueCompBody = strpos($bodySeeValue, $valueComp);

                  if($FinalValueCompBody === false) {
                    $content .= $secondlevelCrop['body'];
                  } else {

                      // Add Comments
                  }


                  $nidEntity_id = $secondlevelCrop['nid'];
                  $dataTitle = $secondlevelCrop['title'];
                  $str = preg_replace('/\(([^\)]*)\)/', '', $dataTitle);


                  $field_linking = $secondlevelCrop['field_link_the_site'];
                  if(isset($field_linking) || $FinalValueCompBody === False) {


                    $connection = \Drupal::database();
                    $query = $connection->query("SELECT * FROM {node__field_link_the_site} INNER JOIN node_field_data ON node_field_data.title = node__field_link_the_site.field_link_the_site_value WHERE node_field_data.type = node__field_link_the_site.bundle");
                    $resultRecords = $query->fetchAll();


                    foreach ($resultRecords as $obj) {
                      if($nidEntity_id == $obj->entity_id) {

                        $content .= '<a href="/node/' .$obj->nid. '" target="_blank">';
                        $content .= "<b>See: </b>" .$obj->field_link_the_site_value .'</a>';
                        $content .= "<p></p>";
                        $content .= '<a href="#0" class="cd-top js-cd-top">Top</a>';
                      }
                    }

                  } else {
                   
                    $content .= $this->t("<mark>Your field is empty. Please, add the correct name to link a Cultivar/s. " .$secondlevelCrop['body']. "</mark>");

                  }
                  $content .= '<a href="#0" class="cd-top js-cd-top">Top</a>';
                  $content .= '</div>';
                  $content .= '</div>';
                  $content .= '</p>';
                }
              }
            }
          }

          $content .= "</details>";
        }
      }
    }
    $content .= '<a href="#0" class="cd-top js-cd-top">Top</a>';
    return array(
      '#type' => 'markup',
      '#markup' => $content,
      '#attached' => array(
        'library' => array(
          'mainlab_list/mainlab_list', // /mymodule/libraryname My mainlab_list.libraries.yml
        ),
      ),
    );

  }

  /**
   * @return string
   */
  private function retrieveArrayOne() {

    $query = \Drupal::entityQuery('node');
    $query->condition('status',1);
    $query->condition('type','mlfruitandnut');
    $query->sort('title', 'ASC');
    $entity = $query->execute();
    $options = array();

    foreach ($entity as $n) {
      $node = \Drupal\node\Entity\Node::load($n);
      $options[$node->id()] = $node->getTitle();
      $elementA[] = [//
        'nid' => $node->get('nid')->value,
        'title' => $node->get('title')->value,
        'body' => $node->get('body')->value,
        'field_link_the_site' => $node->get('field_link_the_site')->value,
        'field_mlfruitandnut_crop' => $node->get('field_mlfruitandnut_crop')->value,
      ];
    }

    return $elementA;


  }

  /**
   * @return array
   */
  function retrieveArrayTwo() {
    $query = \Drupal::entityQuery('node');
    $query->condition('status',1);
    $query->condition('type','mlfruitandnut');
    $query->sort('field_mlfruitandnut_crop', 'ASC');
    $entity = $query->execute();
    $options = array();
    foreach ($entity as $n) {
      $node = \Drupal\node\Entity\Node::load($n);
      $options[$node->id()] = $node->get('field_mlfruitandnut_crop')->value;
    }

    $arrayUniqueRecord = array_unique($options, SORT_REGULAR);

    return $arrayUniqueRecord;

  }
  /**
   * @return array
   */
  function mergeTwoArrays() {

    $array1 = array($this->retrieveArrayTwo());
    $array2 = array($this->retrieveArrayOne());
    $resultArrays = array_merge($array1, $array2);
    return $resultArrays;
  }

}
# Development

## Introduction

1.- The module Overview has two folders named "assets" and "src".

    + The "assets" folder has CSS, IMG & JS files.
    + The "src" has two folders named "Controller" and "Plugin".
    
 - Under the folder Controller you will find a Class named "MainLabViewController.php".
 
    + The following script shows how two functions are merged. The output or return array is $resultArrays
    
```batch
$retrieveData = $this->mergeTwoArrays();  
  function mergeTwoArrays() {
    $array1 = array($this->retrieveArrayTwo());
    $array2 = array($this->retrieveArrayOne());
    $resultArrays = array_merge($array1, $array2);
    return $resultArrays;
  }   
```
   + This code shows arrays and keys to display CROP, TITLE and CONTENT from each crop and cultivar. 
   
```batch
 $content = "<H2></H2>";
    foreach ($retrieveData as $key1 => $finalValues) {
      
      // If $key1 == 0, display Crop.
      
      if ($key1 == 0) {
        foreach ($finalValues as $disCrop) {
          $content .= "<details>";
          $content .= '<summary>' . $disCrop . '</summary>';

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
```


   + Returns the values crop, body, title and id from the variables field_mlfruitandnut_crop, field_link_the_site, and nid.
```batch

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

```   
   + Returns the crop values from the variable field_mlfruitandnut_crop. It is a unique value.
   

```batch

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

```

   + The routing is the path which returns some sort of content. For instance, for this module we have a path: '/mainlab_list'.  
   See [image](https://github.com/Viktoru/Overview/blob/master/ScreenShot3.png)
```batch

mainlab_list.content:
  path: '/mainlab_list'
  defaults:
    _controller: '\Drupal\mainlab_list\Controller\MainLabViewController::mainlabviewslist'
    _title: 'Data Overview'
  requirements:
    _permission: 'access content'

```
  + Defining a library: Define all of your asset libraries in .libraries.yml file.
  + [Drupal 8 no longer loads JQuery on all pages by default](https://www.drupal.org/docs/8/theming/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-theme). 
  
```batch

mainlab_list:
  version: 1.0
  css:
    theme:
      assets/css/collapsibles.css: {}
      assets/css/style.css: {}

  js:
    assets/js/main.js: {}

  dependencies:
    - core/jquery

```
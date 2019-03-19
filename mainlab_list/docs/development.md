# Development

## Introduction

1.- The module Overview has two folders: assets and src:

    + The assets folder has CSS, IMG & JS files.
    + The src has two folders: Controller and Plugin.
    
 - Under the Controller Class MainLabViewController.php.
 
    + Merge two functions
    
```batch

$retrieveData = $this->mergeTwoArrays();  

/**
   * @return array
   */
  function mergeTwoArrays() {

    $array1 = array($this->retrieveArrayTwo());
    $array2 = array($this->retrieveArrayOne());
    $resultArrays = array_merge($array1, $array2);
    return $resultArrays;
  }
    
    
```
    
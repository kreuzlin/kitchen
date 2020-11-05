<?php
  // Simple page redirect
  function redirect($page,$id = NULL){
    if(isset($id))
    {
      header('location: '.URLROOT.'/'.$page.'/'.$id);
    }
    else{
      header('location: '.URLROOT.'/'.$page);
    }
  }
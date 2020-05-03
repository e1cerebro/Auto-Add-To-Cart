<?php

    function compress_array($array){
      return  implode(",",$array);
    }
    
    function uncompress_array($array){
      return  explode(",",$array);
    }

    function custom_explode($separator, $array){
      return  implode($separator,$array);
    }
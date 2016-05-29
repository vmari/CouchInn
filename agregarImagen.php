<?php 
  define('DESIRED_IMAGE_WIDTH', 800);
  define('DESIRED_IMAGE_HEIGHT', 600);
  
  function resizeIm($input,$output){
    list($source_width, $source_height, $source_type) = getimagesize($input);

    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gdim = imagecreatefromgif($input);
            break;
        case IMAGETYPE_JPEG:
            $source_gdim = imagecreatefromjpeg($input);
            break;
        case IMAGETYPE_PNG:
            $source_gdim = imagecreatefrompng($input);
            break;
    }

    $source_aspect_ratio = $source_width / $source_height;
    $desired_aspect_ratio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;

    if ($source_aspect_ratio > $desired_aspect_ratio) {
        /*
         * Triggered when source image is wider
         */
        $temp_height = DESIRED_IMAGE_HEIGHT;
        $temp_width = ( int ) (DESIRED_IMAGE_HEIGHT * $source_aspect_ratio);
    } else {
        /*
         * Triggered otherwise (i.e. source image is similar or taller)
         */
        $temp_width = DESIRED_IMAGE_WIDTH;
        $temp_height = ( int ) (DESIRED_IMAGE_WIDTH / $source_aspect_ratio);
    }

    /*
     * Resize the image into a temporary GD image
     */

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
        $temp_gdim,
        $source_gdim,
        0, 0,
        0, 0,
        $temp_width, $temp_height,
        $source_width, $source_height
    );

    /*
     * Copy cropped region from temporary image into the desired GD image
     */

    $x0 = ($temp_width - DESIRED_IMAGE_WIDTH) / 2;
    $y0 = ($temp_height - DESIRED_IMAGE_HEIGHT) / 2;
    $desired_gdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
    imagecopy(
        $desired_gdim,
        $temp_gdim,
        0, 0,
        $x0, $y0,
        DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT
    );

    imagejpeg($desired_gdim,$output,90);

  }
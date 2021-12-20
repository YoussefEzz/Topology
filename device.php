<?php
class device {
    public $default;
    public $min;
    public $max;

    function __construct( $default, $min, $max) {
        $this->default = $default;
        $this->min = $min;
        $this->max = $max;
    }
    
}


?>
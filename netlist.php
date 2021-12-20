<?php
class netlist {
  }

class resistor_netlist extends netlist{
    public $t1;
    public $t2;

    public function __construct( $t1, $t2) {
        $this->t1 = $t1;
        $this->t2 = $t2;
      }
}
  
class nmos_netlist extends netlist{
    public $drain;
    public $gate;
    public $source;

    public function __construct($drain, $gate, $source) {
        $this->drain = $drain;
        $this->gate = $gate;
        $this->source = $source;
      }
}
?>
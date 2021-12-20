<?php
class component {
  }

class resistor_component extends component{
    
    public $type;
    public $id;
    public $resistance;   
    public $netlist;

    function __construct($type, $id, $device, $netlist) {

        $this->type = $type;
        $this->id = $id;
        $this->resistance = $device;
        $this->netlist = $netlist;
                
    }
}

class m1_component extends component{
    
    public $type;
    public $id;
    public $m1;   
    public $netlist;

    function __construct($type, $id, $device, $netlist) {

        $this->type = $type;
        $this->id = $id;
        $this->m1 = $device;
        $this->netlist = $netlist;
                
    }
}
?>
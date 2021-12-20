
<?php
include_once 'topology.php';
include_once 'component.php';
include_once 'device.php';
include_once 'netlist.php';

  $topology_list = array();

  function readJSON(string $filename) {
	$myfile = fopen($filename, "r") or die("Unable to open file!");
	
	$json = fread($myfile,filesize($filename));
	//echo($json);

	//decode json as associative array
	$jsonobject = json_decode($json, true);
	
    fclose($myfile);


	$topid = $jsonobject['id'];
	$components_count = count($jsonobject['components']) ;

	$topology = new topology($topid);
	$topology_components = array();
	foreach($jsonobject['components'] as $component)
	{
		$componenttype = $component['type'];
		$componentid = $component['id'];
		

		$devicetype = array_keys($component)[2];
		$default = $component[$devicetype]["default"];
		$min = $component[$devicetype]["min"];
		$max = $component[$devicetype]["max"];
		
		$device = new device($default, $min, $max);
		$netlist;
		$component;
		$netlisttype = $component['netlist'];
		switch ($componenttype)
		{
			case "resistor" : 
				
				$netlist = new resistor_netlist($netlisttype['t1'], $netlisttype['t2']);
				$component = new resistor_component($componenttype, $componentid, $device, $netlist);
				break;
			case "nmos" :
			default:
				$netlist = new nmos_netlist( $netlisttype['drain'], $netlisttype['gate'], $netlisttype['source']);
				$component = new m1_component($componenttype, $componentid, $device, $netlist);
				break;
		}
		
		array_push($topology_components, $component);
	}
	
	$topology->components = $topology_components;	
	array_push($topology_list, $topology);
	return $topology;	
  }

  function writeSON(topology $topology)
  {
		echo json_encode($topology);
		$file = fopen("output.json", "w") or die("Unable to open file!");
		
		fwrite($file, json_encode($topology));
		fclose($file);
  }

  function queryTopologies()
  {
		return $topology_list;
  }

  function deleteTopology($topologyid)
  {
	for ($i = 0; $i < count($topology_list); $i++) {
		if ($topology_list[$i]["id"] == $topologyid)
			unset($topology_list[$i]);
	  }
	
  }
  
  function queryDevices($topologyid)
  {
	for ($i = 0; $i < count($topology_list); $i++) {
		if ($topology_list[$i]["id"] == $topologyid)
			return $topology_list[$i]["components"];
	  }
	
  }

  function queryDevicesWithNetlistNode($topologyid, $NetlistNodeID)
  {
	  $devicelist = array();
	for ($i = 0; $i < count($topology_list); $i++) 
	{
		if ($topology_list[$i]["id"] == $topologyid)
		{
			$topology_components = $topology_list[$i]["components"];
			foreach($topology_components as $component)
			{
				$component_netlist = $component["netlist"];
				if(array_search($NetlistNodeID, $component_netlist))
				{
					array_push($devicelist, $component);
				}
			}
		}			
	}
	  return $devicelist;
	
  }

?>
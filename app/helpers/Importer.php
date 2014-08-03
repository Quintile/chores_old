<?php namespace Helpers;

class Importer {
		
	public static $error = null;

	public static function Import($class, $file, $ignore = array()){

		set_time_limit(0);

		$result = new Results();
		$result->class_type = $class;

		$handle = fopen($file, "r");
	
		if($handle){
			$columns = fgetcsv($handle);
			
			while(($row = fgetcsv($handle)) !== false){
				
				$obj = new $class();
				foreach($columns as $key){
					$ignoreProp = false;

					$value = $row[array_search($key, $columns)];
					if($value == 'NULL')
						$value = NULL;

					//Check to see if property should be ignored
					foreach($ignore as $prop)
					{
						if($prop == $key)
							$ignoreProp = true;
					}

					if($ignoreProp)
						continue;

					if($key == "updated_at" && $value == NULL)
						$obj->$key = $obj->created_at;
					else{
						$obj->$key = $value;
					}
					//Check for rules specified by individual classes
					if(isset($obj->import_override))
						if(array_key_exists($key, $obj->import_override))
							$obj->$key = $obj->import_override[$key];
						
				}		

				try {
					
					$obj->save();
					$result->success_count++;
				}
				catch(\Exception $e){
					self::$error = "There was an error saving one or more rows.";
					$result->failure[$result->fail_count] = self::extractSqlError($e->getMessage());
					$result->fail_count++;
				}
			}
			
			fclose($handle);
		}
		else{
			self::$error = "There was an error opening the file.";

		}

		return $result;
	}

	private static function objHasProperty($obj)
	{

	}

	private static function extractSqlError($string){
		$start_pos = strpos($string, ':') + 1;
		$end_pos = strpos($string, '(SQL');
		$length = $end_pos - $start_pos;
		
		return trim(substr($string, $start_pos, $length));
	}
}

?>
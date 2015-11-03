<script language=php>
	require("config.php");
  class CDatabase
	{
		var $Result=false; // result of last query
		var $lastError=""; // any error.

		function CDatabase($host,$username,$password,$dbname)
		{
			@mysql_connect($host, $username, $password)
				or exit("Could not connect to MySql Server : ".mysql_error());

			mysql_select_db($dbname)
				or exit("Could not select Database - $dbname : ".mysql_error());
		}

		function mysqlQuery($sql)
		{
			$this->mysqlFreeResult(); //frees previous query results if any.
			if ( !($this->Result = mysql_query($sql)) )
				$this->lastError = "Query Failed: $sql Error: " . mysql_error();
			return $this->Result;
		}

		function mysqlFreeResult()
		{
			if($this->Result) @mysql_free_result($this->Result);
			$this->Result=false;
		}

		function mysqlFetchRow($sql)
		{
			$r = mysql_query($sql);
			$row = mysql_fetch_array($r);
			mysql_free_result($r);
			return $row;
		}

		function mysqlFetchValue($field,$table,$cond)
		{
			$sql = sprintf(" SELECT %s FROM %s WHERE %s ",$field,$table,$cond);
			$r = mysql_query($sql);
			$row = mysql_fetch_array($r);
			mysql_free_result($r);
			return $row[$field];
		}

		function mysqlNextRow($sql="")
		{
			if(!$this->Result) $this->Result = $this->mysqlQuery($sql);
			if($this->Result) return mysql_fetch_array($this->Result);
			return false;
		}

		function mysqlEscapeString($str)
		{
			if (get_magic_quotes_gpc()) $str = stripslashes($str);
			$str = mysql_real_escape_string($str);
			return $str;
		}

		function mysqlAddRow($table, $values, $id="id")
		{
			return $this->mysqlAddUpdateRow($table, $values, $id);
		}

		function mysqlUpdateRow($table, $values, $id="id")
		{
			return $this->mysqlAddUpdateRow($table, $values, $id);
		}

		function mysqlAddUpdateRow($table, $values, $id="id")
		{
			if (!$table || !$values) return;

			$key_value = $values[$id];
			if($key_value=="" || $key_value==0) //Key is not specified so add record.
			{
				foreach ($values as $key => $value)
				{
					if ($key != $id)
					{
						$db_fields[] = $key;
						$db_values[] = "'".$this->mysqlEscapeString($value)."'";
					}
				}
				$sql = " INSERT INTO $table (".implode(',', $db_fields).") VALUES(".implode(',', $db_values).") ";
			}
			else // Update record
			{
				foreach ($values as $key => $value)
				{
					if ($key != $id)
						$fields[]= $key."="."'".$this->mysqlEscapeString($value)."'";
				}
				$sql = " UPDATE $table SET ".implode(',', $fields)." WHERE $id='$key_value' ";
			}
			return $this->mysqlQuery($sql);
		}
	}
</script>
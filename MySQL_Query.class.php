<?php
# MySQL_Query.class.php
# by Nicole Ward
# <http://snowwolfegames.com>
# <nikki@snowwolfegames.com>
#
# Copyright © 2009 - 2013 - SnowWolfe Games, LLC

# This file is part of DatabaseAbstractionLayer.
# This script handles mysql database interactions.

# properties:
# $DB_Con
# - protected
# - resource
# - hold the connection to the database
# $Debug
# - protected
# - boolean
# - flag if debugging is on/off
# $Debugging
# - protected
# - object
# - holds the logger object for recording debugging messages
# $Table
# - protected
# - string
# - holds the name of the current table
# $TableAlias
# - protected
# - string
# - holds the alias of the current table
# $JoinTables
# - protected
# - array
# - holds the tables for join queries
# $JoinType
# - protected
# - array
# - holds the types of joins being done
# $JoinTable
# - protected
# - array
# - holds the tables for join queries
# $JoinMethod
# - protected
# - array
# - holds the method the two tables will be joined by
# $JoinStatement
# - protected
# - array
# - holds the statement for joining the tables
# $LockTables
# - protected
# - array
# - holds the list of tables to be locked
# $Columns
# - protected
# - array
# - holds a list of columns
# $Where
# - protected
# - string
# - holds the where information
# $OrderBy
# - protected
# - string
# - holds order by field
# $OrderByDir
# - protected
# - string
# - holds order by direction
# $GroupBy
# - protected
# - string
# - holds group by information
# $Limit
# - protected
# - integer
# - holds limit number
# $Offset
# - protected
# - integer
# - holds offset number
# $InsertValues
# - protected
# - array
# - holds the values for inserts
# $DuplicateKey
# - protected
# - array
# - holds values to update on duplicate key
# $Engine
# - protected
# - string
# - holds the engine type
# $SQL
# - protected
# - string
# - holds the complete sql query
#
# methods:
# __construct()
# -- parameters:
# -- $DB_Con
# 		- resource
# 		- holds the database connection handle
# __clone()
# __destruct()
# -- calls:
# - Logger::CloseLogFile()
# StartDebugging()
# - opens the debugging log up for use
# -- calls:
# 		- Logger::init()
# 		- Logger::OpenLogFile()
# ResetQuery()
# - Resets all the variables for making a query
# SetDebugging()
# - Sets the $Debug variable
# -- parameters:
# -- $Debug
# 		- boolean
# 		- sets debug on (TRUE) or off (FALSE)
# -- calls:
# 		- Sanitize()
# SetQuery()
# - Sets the $SQL variable
# -- parameters:
# -- $QueryType
# 		- string
# 		- holds the type of query to be created
# SetTable()
# - Sets the $Table variable
# -- parameters:
# -- $Table
# 		- string
# 		- holds the name of the table the query will be performed against
# -- $Alias
# 		- string
# 		- holds the alias to use for the table in the query
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetJoinTables()
# - Sets the $JoinTable, $JoinType, $JoinMethod, $JoinStatement variables
# -- parameters:
# -- $JoinTable
# 		- string
# 		- holds the name of tables for creating a join query
# -- $JoinType
# 		- string
# 		- holds the join type for a join query
# -- $JoinMethod
# 		- string
# 		- holds the way the tables will be joined
# -- $JoinStatement
# 		- string
# 		- holds the statement for joining the tables
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetLockTables()
# - Sets the $LockTables variable
# -- parameters:
# -- $LockTables
# 		- array
# 		- holds the names of the tables to be locked
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetColums()
# - Sets the $SelectColumns variable
# -- parameters:
# -- $Columns
# 		- array
# 		- holds the names of the columns to be selected
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetWhere()
# - Sets the $Where variable
# -- parameters:
# -- $Where
# 		- array
# 		- holds the information for creating a where clause
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetOrderBy()
# - Sets the $OrderBy variable
# -- parameters:
# -- $OrderBy
# 		- array
# 		- holds the order by field
# -- $Direction
# 		- array
# 		- holds the order by direction
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetGroupBy()
# - Sets the $GroupBy variable
# -- parameters:
# -- $GroupBy
# 		- string
# 		- holds the field to group by
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetLimit()
# - Sets the $Limit variable
# -- parameters:
# -- $Limit
# 		- integer
# 		- holds the limit number
# -- $Offset
# 		- integer
# 		- holds the offset number
# 		- defaults to null
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetInsertValues()
# - Sets the $InsertValues variable
# -- parameters:
# -- $Values
# 		- array
# 		- holds the values for an insert query
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetDuplicateKey()
# - Sets the $GroupBy variable
# -- parameters:
# -- $DuplicateKey
# 		- array
# 		- holds the field to update on duplicate key
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetEnginey()
# - Sets the $Engine variable
# -- parameters:
# -- $Engine
# 		- string
# 		- holds the engine to use
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# GetSQL()
# - returns:
# - the $SQL variable
# BuildSelectQuery()
# - calls:
# - self::BuildSelectClause()
# - self::BuildTableClause()
# - self::BuildJoinClause()
# - self::BuildWhereCluase()
# - self::BuildOrderByClause()
# - self::BuildLimitClause()
# - Logger::WriteToLog
# BuildUpdateQuery()
# - calls:
# - self::BuildTableClause()
# - self::BuildUpdateClause()
# - self::BuildWhereClause()
# - self::BuildLimitClause()
# - Logger::WriteToLog
# BuildInsertQuery()
# - calls:
# - self::BuildTableClause()
# - self::BuildInsertClause()
# - self::BuildDuplicateKeyClause()
# - Logger::WriteToLog
# BuildDeleteQuery()
# - calls:
# - self::BuildDeleteClause()
# - self::BuildTableClause()
# - self::BuildJoinClause()
# - self::BuildWhereClause()
# - self::BuildLimitClause()
# - Logger::WriteToLog
# BuildAlterQuery()
# - calls:
# - self::BuildTableClause()
# - self::BuildAlterClause()
# - Logger::WriteToLog
# BuildTruncateQuery()
# - calls:
# - self::BuildTableClause()
# - Logger::WriteToLog
# BuildOptimizeQuery()
# calls:
# - Logger::WriteToLog
# BuildShowColumnQuery()
# - calls:
# - Logger::WriteToLog
# BuildShowTablesQuery()
# - calls:
# - Logger::WriteToLog
# BuildCreateTemporaryQuery()
# - calls:
# - self::BuildTableQuery()
# - self::BuildCreateTemporary()
# - self::BuildEngineClause()
# - Logger::WriteToLog
# BuildDropTemporaryQuery()
# - calls:
# - self::BuildTableClause()
# - Logger::WriteToLog
# BuildLockTablesQuery()
# - calls:
# - self::BuildLockTablesClause()
# - Logger::WriteToLog
# BuildUnlockTablesQuery()
# - calls:
# - Logger::WriteToLog
# BuildSelectClause()
# - calls:
# - Logger::WriteToLog
# BuildUpdateClause()
# - calls:
# - MySQL_DB::EscapeString()
# - Logger::WriteToLog
# BuildInsertClause()
# - calls:
# - Logger::WriteToLog
# BuildOnDuplicateKeyClause()
# - calls:
# - Logger::WriteToLog
# BuildDeleteClause()
# - calls:
# - Logger::WriteToLog
# BuildAlterClause()
# - calls:
# - Logger::WriteToLog
# BuildCreateTemporaryClause()
# - calls:
# - Logger::WriteToLog
# BuildTableClause()
# - calls:
# - Logger::WriteToLog
# BuildJoinClause()
# - calls:
# - Logger::WriteToLog
# BuildWhereClause()
# - calls:
# - Logger::WriteToLog
# BuildOrderByClause()
# - calls:
# - Logger::WriteToLog
# BuildLimitClause()
# - calls:
# - Logger::WriteToLog
# BuildLockTablesClause()
# - calls:
# - Logger::WriteToLog
# BuildEngineClause()
# - calls:
# - Logger::WriteToLog




if (0 > version_compare(PHP_VERSION, '5'))
	{
		throw new Exception('This file was generated for PHP 5');
	}

/**
 * include DBInterface
 *
 * @author Nicole Ward, <nikki@snowwolfegames.com>
 */
require_once('QueryInterface.class.php');

/* user defined includes */

/* user defined constants */


final class MySQL_Query
			implements QueryInterface
	{

		protected $DB_Con;
		protected $Debug = FALSE;
		protected $Debugging = NULL;
		protected $Table = NULL;
		protected $TableAlias = NULL;
		protected $JoinTables = NULL;
		protected $JoinType = array();
		protected $JoinTable = array();
		protected $JoinMethod = array();
		protected $JoinStatement = array();
		protected $LockTables = NULL;
		protected $Columns = array();
		protected $Where = array();
		protected $OrderBy = NULL;
		protected $OrderByDir = NULL;
		protected $GroupBy = NULL;
		protected $Limit = NULL;
		protected $Offset = NULL;
		protected $InsertValues = NULL;
		protected $DuplicateKey = NULL;
		protected $Engine = NULL;
		protected $SQL = NULL;


		public function __construct(MySQL_DB $DB_Con)
			{
				$this->DB_Con = $DB_Con;
			} # end __construct()


		public function __clone()
			{
				trigger_error('Clone is not allowed.', E_USER_ERROR);
			} # end __clone()


		public function __destruct()
			{
				$this->Close();
				if ($this->Debug == TRUE)
					{
						$this->Debugging->CloseLogFile();
						unset($this->Debugging);
					}	
			} # end __destruct()


		public function StartDebugging()
			{
				$this->Debugging = new Logger();
				$this->Debugging->init($FileName, $IncludeDate = TRUE, $Priority = 'Medium', $LogType = 'Debugging', $Sendmail = FALSE);
				$this->Debugging->OpenLogFile();
			} # end StartDebugging()


		public function ResetQuery()
			{
				$this->Table = NULL;
				$this->TableAlias = NULL;
				$this->JoinTables = NULL;
				$this->JoinType = array();
				$this->JoinTable = array();
				$this->JoinMethod = array();
				$this->JoinStatement = array();
				$this->LockTables = NULL;
				$this->Columns = array();
				$this->Where = array();
				$this->OrderBy = NULL;
				$this->OrderByDir = NULL;
				$this->GroupBy = NULL;
				$this->Limit = NULL;
				$this->Offset = NULL;
				$this->InsertValues = NULL;
				$this->DuplicateKey = NULL;
				$this->Engine = NULL;
				$this->SQL = NULL;
			} # end ResetQuery()


		public function SetDebug($Debug)
			{
				$this->Debug = Sanitize('boolean', $Debug);

				if ($this->Debug == TRUE)
					{
						$this->StartDebugging();
					}
			}


		public function SetQuery($QueryType)
			{
				switch($QueryType){
					case 'SELECT':
						$this->BuildSelectQuery();
						break;
					case 'DELETE':
						$this->BuildDeleteQuery();
						break;
					case 'UPDATE':
						$this->BuildUpdateQuery();
						break;
					case 'INSERT':
						$this->BuildInsertQuery();
						break;
					case 'ALTER TABLE':
						$this->BuildAlterQuery();
						break;
					case 'TRUNCATE TABLE':
						$this->BuildTruncateQuery();
						break;
					case 'OPTIMIZE TABLE':
						$this->BuildOptimizeQuery();
						break;
					case 'SHOW COLUMNS':
						$this->BuildShowColumnsQuery();
						break;
					case 'SHOW TABLES':
						$this->BuildShowTablesQuery();
						break;
					case 'CREATE TEMPORARY TABLE':
						$this->BuildCreateTemporaryQuery();
						break;
					case 'DROP TEMPORARY TABLE':
						$this->BuildDropTemporaryQuery();
						break;
					case 'LOCK TABLES':
						$this->BuildLockTablesQuery();
						break;
					case 'UNLOCK TABLES':
						$this->BuildUnlockTablesQuery();
						break;
					default:
						throw new DBException('Invalid query type.');
						break;
				}
			} # end SetQuery()


		public function SetTable($Table, $Alias = NULL)
			{
				$this->Table = Sanitize('string', $Table);
				if (isset($Alias))
					{
						$this->TableAlias = Sanitize('string', $Alias);
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Table: '.$this->Table;
						$this->Debugging->WriteToLog();
					}
			} # end SetTable()


		public function SetJoinTable($JoinType, $JoinTable, $JoinMethod, $JoinStatement)
			{
				$this->JoinType[] = Sanitize('string', $JoinType);
				$this->JoinTable[] = Sanitize('string', $JoinTable);
				$this->JoinMethod[] = Sanitize('string', $JoinMethod);
				$this->JoinStatement[] = Sanitize('string', $JoinStatement);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Join tables: '.$this->JoinTablesClause;
						$this->Debugging->WriteToLog();
					}
			} # end SetJoinTable()


		public function SetLockTables(Array $LockTables)
			{
				$this->LockTables = Sanitize('string', $LockTables);
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Lock tables: '.var_export($this->LockTables, true);
						$this->Debugging->WriteToLog();
					}

			} # end SetWhere()


		public function SetColumns(Array $Columns)
			{
				$this->Columns = $Columns;
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Select columns: '.var_export($this->Columns, true);
						$this->Debugging->WriteToLog();
					}
			} # end SetColumns()


		public function SetWhere(Array $Where)
			{
				$this->Where = Sanitize('string', $Where);
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Where arguments: '.var_export($this->Where, true);
						$this->Debugging->WriteToLog();
					}

			} # end SetWhere()


		public function SetOrderBy($OrderBy, $Direction = NULL)
			{
				$this->OrderBy = Sanitize('string', $OrderBy);
				if (!empty($Direction))
					{
						$this->OrderByDir = Sanitize('sort', $Direction);
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Order By: '.$this->OrderBy;
						$this->Debugging->WriteToLog();
					}
			} # end SetOrderBy()


		public function SetGroupBy($GroupBy)
			{
				$this->GroupBy = Sanitize('string', $GroupBy);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Group By: '.$this->GroupBy;
						$this->Debugging->WriteToLog();
					}

			} # end SetGroupBy()


		public function SetLimit($Limit, $Offset = NULL)
			{
				$Limit = Sanitize('int', $Limit);
				if ($Limit !== FALSE)
					{
						$this->Limit = $Limit;
					} else {
						throw new DBException("Invalid limit value.");
					}
				if (isset($Offset))
					{
						$Offset = Sanitize('int', $Offset);
						if ($Offset !== FALSE)
							{
								$this->Offset = $Offset;
							} else {
								throw new DBException("Invalid offset value.");
							}
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Limit: '.$this->Limit;
						$LogData .= (!empty($this->Offset)) ? ' Offset: '.$this->Offset : ' No offset.';
						$this->Debugging->WriteToLog();
					}

			} # end SetLimit()


		public function SetInsertValues(Array $Values)
			{
				$this->InsertValues = Sanitize('string', $Values);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Values: '.$this->InsertValues;
						$this->Debugging->WriteToLog();
					}

			} # end SetValues()


		public function SetDuplicateKey(array $DuplicateKey)
			{
				$this->DuplicateKey = Sanitize('string', $DuplicateKey);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Duplicate Key: '.$this->DuplicateKey;
						$this->Debugging->WriteToLog();
					}

			} # end SetDuplicateKey()


		public function SetEngine($Engine)
			{
				$this->Engine = Sanitize('string', $Engine);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Engine: '.$this->Engine;
						$this->Debugging->WriteToLog();
					}

			} # end SetEngine()


		public function GetSQL()
			{
				return $this->SQL;
			} # end GetSQL()


		public function BuildSelectQuery()
			{
				$this->SQL = "SELECT ";
				$this->SQL .= $this->BuildSelectClause();
				$this->SQL .= $this->BuildTableClause('SELECT');
				if (!empty($this->JoinTables))
					{
						$this->SQL .= $this->BuildJoinClause();
					}
				if (!empty($this->Where))
					{
						$this->SQL .= $this->BuildWhereClause();
					}
				if (!empty($this->OrderBy))
					{
						$this->SQL .= $this->BuildOrderByClause();
					}
				if (!empty($this->Limit))
					{
						$this->SQL .= $this->BuildLimitClause();
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
				
			} # end BuildSelectQuery()


		public function BuildUpdateQuery()
			{
				$this->SQL = "UPDATE ";
				$this->SQL .= $this->BuildTableClause('UPDATE');
				$this->SQL .= $this->BuildUpdateClause();
				if (!empty($this->Where))
					{
						$this->SQL .= $this->BuildWhereClause();
					}
				if (!empty($this->Limit))
					{
						$this->SQL .= $this->BuildLimitClause();
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
				
			} # end BuildUpdateQuery()


		public function BuildInsertQuery()
			{
				# if $this->OnDuplicateKey is an array, update those fields
				# else update = "(INSERT IGNORE)"
				$this->SQL = "INSERT ";
				if ($this->DuplicateKey == 'IGNORE')
					{
						$this->SQL .= 'IGNORE';
					}
				$this->SQL .= $this->BuildTableClause('INSERT');
				$this->SQL .= $this->BuildInsertClause();
				if (is_array($this->DuplicateKey))
					{
						$this->SQL .= $this->BuildOnDuplicateKeyClause();
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
				
			} # end BuildInsertQuery()


		public function BuildDeleteQuery()
			{
				$this->SQL = "DELETE ";
				$this->SQL .= $this->BuildDeleteClause();
				$this->SQL .= $this->BuildTableClause('DELETE');
				if (!empty($this->JoinTables))
					{
						$this->SQL .= $this->BuildJoinClause();
					}
				if (!empty($this->Where))
					{
						$this->SQL .= $this->BuildWhereClause();
					}
				if (!empty($this->Limit))
					{
						$this->SQL .= $this->BuildLimitClause();
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildDeleteQuery()


		public function BuildAlterQuery()
			{
				$this->SQL = "ALTER TABLE ";
				$this->SQL .= $this->BuildTableClause('ALTER');
				$this->SQL .= $this->BuildAlterClause();
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildTruncateQuery()


		public function BuildTruncateQuery()
			{
				$this->SQL = "TRUNCATE TABLE ";
				$this->SQL .= $this->BuildTableClause('TRUNCATE');
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildTruncateQuery()


		public function BuildOptimizeQuery()
			{
				$this->SQL = "OPTIMIZE TABLE ";
				$this->SQL .= $this->BuildTableClause('OPTIMIZE');
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildOptimizeQuery()


		public function BuildShowColumnsQuery()
			{
				$this->SQL = "SHOW COLUMNS FROM ";
				$this->SQL .= $this->BuildTableClause('SHOW_COLUMNS');
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildShowColumnsQuery()


		public function BuildShowTablesQuery()
			{
				$this->SQL = "SHOW TABLES";
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildShowTablesQuery()


		public function BuildCreateTemporaryQuery()
			{
				$this->SQL = "CREATE TEMPORARY TABLE IF NOT EXISTS ";
				$this->SQL .= $this->BuildTableClause('CREATE_TEMPORARY');
				$this->SQL .= $this->BuildCreateTemporaryClause();
				$this->SQL .= $this->BuildEngineClause();
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildCreateTemporaryQuery()


		public function BuildDropTemporaryQuery()
			{
				$this->SQL = "DROP TEMPORARY TABLE IF EXISTS ";
				$this->SQL .= $this->BuildTableClause('DROP_TEMPORARY');
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildDropTemporaryQuery()


		public function BuildLockTablesQuery()
			{
				$this->SQL = "LOCK TABLES ";
				$this->SQL .= $this->BuildLockTablesClause();
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildLockTablesQuery()


		public function BuildUnlockTablesQuery()
			{
				$this->SQL = "UNLOCK TABLES ";
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog();
					}
			} # end BuildUnlockTablesQuery()


		public function BuildSelectClause()
			{
				$SelectClause = '';

				foreach ($this->Columns as $FieldArray)
					{
						if (!empty($FieldArray['SQLFunction']))
							{
								$SelectClause .= $FieldArray['SQLFunction']."(";
								if (!empty($FieldArray['Distinct']))
									{
										$SelectClause .= "DISTINCT ";
									}
								if (!empty($FieldArray['If']))
									{
										$SelectClause .= "IF(`".$FieldArray['Table']."`.`".$FieldArray['Field']."` = ".$FieldArray['If']."))";
									} else {
										$SelectClause .= '`'.$FieldArray['Table']."`.`".$FieldArray['Field'].'`';
										if (isset($FieldArray['FormatLevel']))
											{
												$SelectClause .= ', '.$FieldArray['FormatLevel'].')';
											} elseif (!empty($FieldArray['CastType'])) {
												$SelectClause .= ' AS '.$FieldArray['CastType'].')';
											} else {
												$SelectClause .= ')';
											}
									}
							} else {
								if (!empty($FieldArray['Distinct']))
									{
										$SelectClause .= "DISTINCT ";
									}
								$SelectClause .= '`'.$FieldArray['Table']."`.`".$FieldArray['Field'].'`';
							}

						if (!empty($FieldArray['Maths']))
							{
								$SelectClause .= " ".$FieldArray['Maths'];
							}

						if (!empty($FieldArray['ReturnAs']))
							{
								$SelectClause .= " AS ".$FieldArray['ReturnAs'].", ";
							} else {
								$SelectClause .= ", ";
							}
						# build the FieldNames array for use with binding the results
						$FieldNames[] = $FieldArray['Field'];
					}
				$SelectClause = rtrim($SelectClause, ", ");

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Built select clause. '.$SelectClause;
						$this->Debugging->WriteToLog();
					}
				return $SelectClause;
			} # end BuildSelectClause()


		public function BuildUpdateClause()
			{
				$UpdateClause = 'SET ';

				foreach ($this->Columns as $FieldArray)
					{
						$UpdateClause .= '`'.$FieldArray['Field']."` = ";
						if (isset($FieldArray['Value']))
							{
								$Value = $this->DB_Con->EscapeString($FieldArray['Value']);
								if (is_numeric($Value))
									{
										$UpdateClause  .= $Value.', ';
									} else {
										$UpdateClause  .= "'".$Value."', ";
									}
							} elseif (!empty($FieldArray['Maths'])) {
								$UpdateClause .= '`'.$FieldArray['Field'].'` = `'.$FieldArray['Field'].'` '.$FieldArray['Maths'];
							} else {
								$UpdateClause .= "?, ";
							}
					}
				$UpdateClause = rtrim($UpdateClause, ", ");
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.'';
						$this->Debugging->WriteToLog();
					}
				return $UpdateClause;
			} # end BuildSelectClause()


		public function BuildInsertClause()
			{
				$Fields = '(';
				$Values = '';
				foreach ($this->Columns as $FieldArray)
					{
						$Fields .= '`'.$FieldArray['Field'].'`, ';
					}
				$Fields = rtrim($Fields, ", ");
				$Fields .= ')';
				if (isset($this->Values))
					{
						foreach ($this->Values as $ValuesArray)
							{
								foreach ($ValuesArray as $Value)
									{
										if (is_numeric($FieldArray['Value']))
											{
												$Values .= $this->DB_Con->EscapeString($Value['Value']).', ';
											} else {
												$Values .= "'".$this->DB_Con->EscapeString($Value['Value'])."', ";
											}
									}
								$Values = rtrim($Values, ", ");
								$Values = '('.$Values.'),'.PHP_EOL;
							}
						$Values = rtrim($Values, ",");
					} else {
						foreach ($this->Columns as $FieldArray)
							{
								$Values .= '?, ';
							}
						$Values = rtrim($Values, ", ");
						$Values = '('.$Values.'),';
					}

				$InsertClause = $Fields;
				if (!empty($Values))
					{
						$InsertClause .= ' VALUES '.$Values;
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Insert clause: '.$InsertClause;
						$this->Debugging->WriteToLog();
					}
				return $InsertClause;
			} # end BuildInsertClause()


		public function BuildOnDuplicateKeyClause()
			{
				$DuplicateKeyClause .= "\n"
					."ON DUPLICATE KEY UPDATE ";

				foreach ($this->DuplicateKey as $FieldArray)
					{
						$DuplicateKeyClause .= $FieldArray['Field']." =";
						if (!empty($FieldArray['Maths']))
							{
								$DuplicateKeyClause .= $FieldArray['Field'].$FieldArray['Maths']." VALUES(".$FieldArray['Field']."), ";
							} else {
								$DuplicateKeyClause .= " VALUES(".$FieldArray['Field']."), ";
							}
					}
				$DuplicateKeyClause = rtrim($DuplicateKeyClause, ", ");
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Duplicate key clause: '.$DuplicateKeyClause;
						$this->Debugging->WriteToLog();
					}
				return $DuplicateKeyClause;
			} # end BuildOnDuplicateKeyClause()


		public function BuildDeleteClause()
			{
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Delete clause: '.$DeleteClause;
						$this->Debugging->WriteToLog();
					}
				return $DeleteClause;
			} # end BuildSelectClause()


		public function BuildAlterClause()
			{
				foreach ($this->QueryArr['Action'] as $Action)
					{
						switch ($Action)
							{
								case 'Index':
									foreach ($this->QueryArr['Index'] as $Index)
										{
											$AlterClause .= "\n"
												."ADD INDEX (".$Index."), ";
										}
									break;
								case 'Unique':
									$AlterClause .= "\n"
										."ADD UNIQUE ";
									foreach ($this->QueryArr['UniqueIndex'] as $Index)
										{
											$AlterClause .= $Index.", ";
										}
									break;
								case 'Primary':
									$AlterClause .= "\n"
										."ADD PRIMARY KEY ";
									foreach ($this->QueryArr['UniqueIndex'] as $Index)
										{
											$AlterClause .= $Index.", ";
										}
									break;
							}
					}

				$AlterClause = rtrim($AlterClause, ", ");
# need to add the rest of these http://dev.mysql.com/doc/refman/5.1/en/alter-table.html

				return $AlterClause;
			} # end BuildAlterClause()


		public function BuildCreateTemporaryClause()
			{
				$CreateTemporaryClause = "(";
				foreach ($this->Columns as $FieldArray)
					{
						$CreateTemporaryClause .= $FieldArray['Field'].", ";
					}
				$CreateTemporaryClause = rtrim($CreateTemporaryClause, ", ");
				$CreateTemporaryClause .= ")";

				return $CreateTemporaryClause;
			} # end BuildCreateTemporaryClause()


		public function BuildTableClause($QueryType)
			{
				switch ($QueryType) {
					case 'SELECT':
					case 'DELETE':
						$TableClause = 'FROM `'.$this->Table.'`';
						break;
					case 'INSERT':
						$TableClause = 'INTO `'.$this->Table.'`';
					case 'UPDATE':
					case 'ALTER':
					case 'TRUNCATE':
					case 'OPTIMIZE':
					case 'SHOW_COLUMNS':
					case 'CREATE_TEMPORARY':
						$TableClause = '`'.$this->Table.'`';
						break;
					default:
						throw new DBException("Invalid query type.");
						break;
					}
					
				if (!empty($this->TableAlias))
					{
						$TableClause .= ' AS '.$this->TableAlias;
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Table clause: '.$TableClause;
						$this->Debugging->WriteToLog();
					}
				return $TableClause;
				
			} # end BuildTableClause()


		protected function BuildJoinClause()
			{
				$JoinTablesClause = '';
				foreach ($this->JoinType AS $Key => $Value)
					{
						$JoinTablesClause .= $this->JoinType[$Key].' JOIN '.$this->JoinTable[$Key].' '.$this->JoinMethod[$Key].' '.$this->JoinStatement[$Key];
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Join tables clause: '.$JoinTablesClause;
						$this->Debugging->WriteToLog();
					}
				return $JoinTablesClause;
			} # end BuildJoinClause()


		public function BuildWhereClause()
			{
				$WhereClause = 'WHERE ';
				foreach ($this->Where AS $Arguments)
					{
						if (!empty($Arguments['ClauseOperator']))
							{
								$WhereClause .= ' '.$Arguments['ClauseOperator'].' ';
							}
						$WhereClause .= $Arguments['FirstOperand'].' '.$Arguments['ExpressionOperator'].' ';
						if (!empty($Arguments['SecondOperand']))
							{
								$WhereClause .= $this->DB_Con->EscapeString($Arguments['SecondOperand']);
							} else {
								$WhereClause .= '?';
							}
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Where: '.$WhereClause;
						$this->Debugging->WriteToLog();
					}
				return $WhereClause;
			} # end BuildWhereClause()


		public function BuildOrderByClause()
			{
				if (!empty($this->OrderBy))
					{
						$OrderByClause = "ORDER BY ".$this->OrderBy;
						if (isset($this->OrderByDir))
							{
								$OrderByClause .= ' '.$this->OrderByDir;
							}
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Order By: '.$OrderByClause;
						$this->Debugging->WriteToLog();
					}
				return $OrderByClause;
			} # end BuildOrderByClause()


		public function BuildLimitClause()
			{
				$LimitClause = NULL;
				if (!empty($this->Limit))
					{
						$LimitClause = "LIMIT ";
						if (isset($this->Offset))
							{
								$LimitClause .= $this->Offset.', ';
							}
						$LimitClause .= $this->Limit;
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Limit: '.$LimitClause;
						$this->Debugging->WriteToLog();
					}
				return $LimitClause;
			} # end BuildLimitClause()


		public function BuildLockTablesClause()
			{
				$LockTablesClause = NULL;
				if (!empty($this->LockTables))
					{
						foreach ($this->LockTables as $LocksArray)
							{
								$LockTablesClause .= "
									".$LocksArray['Table']." ";
								if (!empty($LocksArray['TableAlias']))
									{
										$LockTablesClause .= "AS ".$LocksArray['TableAlias']." ";
									}
								$LockTablesClause .= $LocksArray['LockType'].", ";
							}

						$LockTablesClause = rtrim($LockTablesClause, ", ");
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Lock tables: '.$LockTablesClause;
						$this->Debugging->WriteToLog();
					}
				return $LockTablesClause;
			}


		public function BuildEngineClause()
			{
				$EngineClause = NULL;

				if (isset($this->Engine))
					{
						$EngineClause = " ENGINE = ".$this->QueryArr['Engine'];
					}
				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Engine: '.$EngineClause;
						$this->Debugging->WriteToLog();
					}
				return $EngineClause;
			}


	}
?>
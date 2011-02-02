<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     François Zaninotto <francois.zaninotto@symfony-project.com>
 * @version    SVN: $Id$
 */
class sfPropelDatabaseSchema
{
  protected $connection_name = '';
  protected $database        = array();

  public function asArray()
  {
    return array($this->connection_name => $this->database);
  }

  public function loadArray($schema_array)
  {
    $database = array();
    $connection_name = '';
    
    if(isset($schema_array['classes']))
    {
      // New schema syntax
      $schema_array = $this->convertNewToOldYaml($schema_array);
    }

    if (count($schema_array) > 1)
    {
      throw new sfException('A schema.yml must only contain 1 database entry.');
    }

    $tmp = array_keys($schema_array);
    $connection_name = array_shift($tmp);

    if ($connection_name)
    {
      $database = $schema_array[$connection_name];
    }

    $this->connection_name = $connection_name;
    $this->database = $database;
    
    $this->fixYAMLDatabase();
    $this->fixYAMLI18n();
    $this->fixYAMLColumns();
  }
  
  public function loadYAML($file)
  {
    $schema_array = sfYaml::load($file);
    
    if(!isset($schema_array['classes']))
    {
      // Old schema syntax: we convert it 
      $schema_array = $this->convertOldToNewYaml($schema_array);
    }
    
    // the following should be in the pake task, but unfortunately it can't be overridden...
    // so we do it only if in the pake context
    if(class_exists('pakeFinder'))
    {
      // New schema syntax, we should look for custom schemas
      $custom_schema_filename = str_replace(array(getcwd().DIRECTORY_SEPARATOR, 'plugins'.DIRECTORY_SEPARATOR, 'config'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, 'schema.yml'), array('', '', '', '_', 'schema.custom.yml'), $file);
      $dirs = array('config');
      if ($pluginDirs = glob(sfConfig::get('sf_root_dir').'/plugins/*/config'))
      {
        $dirs = array_merge($dirs, $pluginDirs);
      }
      $custom_schemas = pakeFinder::type('file')->name($custom_schema_filename)->in($dirs);
      
      foreach($custom_schemas as $custom_schema)
      {
        if(function_exists('pake_echo_action'))
        {
          pake_echo_action('schema', sprintf('found custom schema %s', $custom_schema));
        }
        $custom_schema_array = sfYaml::load($custom_schema);
        if(!isset($custom_schema_array['classes']))
        {
          // Old schema syntax: we convert it 
          $custom_schema_array = $this->convertOldToNewYaml($custom_schema_array);
        }
        $schema_array = sfToolkit::arrayDeepMerge($schema_array, $custom_schema_array);
      }
    }
    
    $this->loadArray($schema_array);
  }
  
  public function convertOldToNewYaml($schema)
  {
    $new_schema = array();

    $tmp = array_keys($schema);
    $connection_name = array_shift($tmp);
    $new_schema['connection'] = $connection_name;
    
    $classes = array();
    if (!is_array($schema[$connection_name])) {
      trigger_error($schema[$connection_name], E_USER_WARNING);
      $schema[$connection_name] = (array)$schema[$connection_name];
    }
    foreach($schema[$connection_name] as $table => $table_params)
    {
      if($table == '_attributes')
      {
        // Database attributes
        $new_schema = array_merge($new_schema, $table_params);
      }
      else
      {
        // Table
        $phpName = sfInflector::camelize($table);
        if(isset($table_params['_attributes']))
        {
          $table_attributes = $table_params['_attributes'];
          unset($table_params['_attributes']);
          if(isset($table_attributes['phpName']))
          {
            $phpName = $table_attributes['phpName'];
            unset($table_attributes['phpName']);
          }
        }
        else
        {
          $table_attributes = array();
        }
        $classes[$phpName] = $table_attributes;
        $classes[$phpName]['tableName'] = $table;
        $classes[$phpName]['columns'] = array();
        foreach($table_params as $column => $column_params)
        {
          switch($column)
          {
            case '_behaviors':
              $classes[$phpName]['behaviors'] = $column_params;
              break;
            case '_foreignKeys':
              $classes[$phpName]['foreignKeys'] = $column_params;
              break;
            case '_indexes':
              $classes[$phpName]['indexes'] = $column_params;
              break;
            case '_uniques':
              $classes[$phpName]['uniques'] = $column_params;
              break;
            default:
              $classes[$phpName]['columns'][$column] = $column_params;
          }
        }
      }
    }
    
    $new_schema['classes'] = $classes;
    
    return $new_schema;
  }
  
  public function convertNewToOldYaml($schema)
  {
    
    if(isset($schema['connection']))
    {
      $connection_name = $schema['connection'];
      unset($schema['connection']);
    }
    else
    {
      $connection_name = 'propel';
    }
    
    $database = array();
    
    // Tables
    if(isset($schema['classes']))
    {
      $tables = array();
      foreach ($schema['classes'] as $className => $classParams)
      {
        $tableParams = array(); 
        
        // Columns
        if(isset($classParams['columns']))
        {
          $tableParams = array_merge($classParams['columns'], $tableParams);
          unset($classParams['columns']);
        }

        // Indexes and foreign keys
        if(isset($classParams['indexes']))
        {
          $tableParams['_indexes'] = $classParams['indexes'];
          unset($classParams['indexes']);
        }
        if(isset($classParams['uniques']))
        {
          $tableParams['_uniques'] = $classParams['uniques'];
          unset($classParams['uniques']);
        }
        if(isset($classParams['foreignKeys']))
        {
          $tableParams['_foreignKeys'] = $classParams['foreignKeys'];
          unset($classParams['foreignKeys']);
        }
        
        // Behaviors
        if(isset($classParams['behaviors']))
        {
          $tableParams['_behaviors'] = $classParams['behaviors'];
          unset($classParams['behaviors']);
        }
        
        // Table attributes
        $tableAttributes = array();
        if(isset($classParams['tableName']))
        {
          $tableName = $classParams['tableName'];
          unset($classParams['tableName']);
        }
        else
        {
          $tableName = sfInflector::underscore($className);
        }
        
        if(sfInflector::camelize($tableName) != $className)
        {
          $tableAttributes['phpName'] = $className;
        }
        
        if($tableAttributes || $classParams)
        {
          $tableParams['_attributes'] = array_merge($tableAttributes, $classParams);
        }
        
        $tables[$tableName] = $tableParams;
      }
      $database = array_merge($database, $tables);
      unset($schema['classes']);
    }
    
    // Database attributes
    if($schema)
    {
      $database['_attributes'] = $schema;
    }
    
    return array($connection_name => $database);
  }

  public function asXML()
  {
    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    $xml .= "<database name=\"$this->connection_name\"".$this->getAttributesFor($this->database).">\n";

    // tables
    foreach ($this->getChildren($this->database) as $tb_name => $table)
    {
      $xml .= "\n  <table name=\"$tb_name\"".$this->getAttributesFor($table);
      if (isset($table['_behaviors']))
      {
        $xml .= sprintf(" behaviors=\"%s\"", htmlspecialchars(serialize($table['_behaviors'])));
      }
      $xml .= ">\n";

      // columns
      foreach ($this->getChildren($table) as $col_name => $column)
      {
        $xml .= "    <column name=\"$col_name\"".$this->getAttributesForColumn($tb_name, $col_name, $column);
      }

      // indexes
      if (isset($table['_indexes']))
      {
        foreach ($table['_indexes'] as $index_name => $index)
        {
          $xml .= "    <index name=\"$index_name\">\n";
          foreach ($index as $index_column)
          {
            $xml .= "      <index-column name=\"$index_column\" />\n";
          }
          $xml .= "    </index>\n";
        }
      }

      // uniques
      if (isset($table['_uniques']))
      {
        foreach ($table['_uniques'] as $unique_name => $index)
        {
          $xml .= "    <unique name=\"$unique_name\">\n";
          foreach ($index as $unique_column)
          {
            $xml .= "      <unique-column name=\"$unique_column\" />\n";
          }
          $xml .= "    </unique>\n";
        }
      }

      // foreign-keys
      if (isset($table['_foreignKeys']))
      {
        foreach ($table['_foreignKeys'] as $fkey_name => $fkey)
        {
          $xml .= "    <foreign-key foreignTable=\"$fkey[foreignTable]\"";

          // foreign key name
          if (!is_numeric($fkey_name))
          {
            $xml .= " name=\"$fkey_name\"";
          }

          // onDelete
          if (isset($fkey['onDelete']))
          {
            $xml .= " onDelete=\"$fkey[onDelete]\"";
          }

          // onUpdate
          if (isset($fkey['onUpdate']))
          {
            $xml .= " onUpdate=\"$fkey[onUpdate]\"";
          }
          $xml .= ">\n";

          // references
          if (isset($fkey['references']))
          {
            foreach ($fkey['references'] as $reference)
            {
              $xml .= "      <reference local=\"$reference[local]\" foreign=\"$reference[foreign]\" />\n";
            }
          }
          $xml .= "    </foreign-key>\n";
        }
      }
      
      $xml .= "  </table>\n";
    }
    $xml .= "\n</database>\n";

    return $xml;
  }

  protected function fixYAMLDatabase()
  {
    if (!isset($this->database['_attributes']))
    {
      $this->database['_attributes'] = array();
    }

    // conventions for database attributes
    $this->setIfNotSet($this->database['_attributes'], 'defaultIdMethod', 'native');
    $this->setIfNotSet($this->database['_attributes'], 'noXsd', true);
    $this->setIfNotSet($this->database['_attributes'], 'package', 'lib.model');
  }

  protected function fixYAMLI18n()
  {
    foreach ($this->getTables() as $i18n_table => $columns)
    {
      $pos = strpos($i18n_table, '_i18n');

      $has_primary_key = false;
      foreach ($columns as $column => $attributes)
      {
        if (is_array($attributes) && array_key_exists('primaryKey', $attributes))
        {
           $has_primary_key = true;
        }
      }

      if ($pos > 0 && $pos == strlen($i18n_table) - 5 && !$has_primary_key)
      {
        // i18n table without primary key
        $main_table = $this->findTable(substr($i18n_table, 0, $pos));

        if ($main_table)
        {
          // set i18n attributes for main table
          $this->setIfNotSet($this->database[$main_table]['_attributes'], 'isI18N', 1);
          $this->setIfNotSet($this->database[$main_table]['_attributes'], 'i18nTable', $i18n_table);

          // set id and culture columns for i18n table
          $this->setIfNotSet($this->database[$i18n_table], 'id', array(
            'type'             => 'integer',
            'required'         => true, 
            'primaryKey'       => true,
            'foreignTable'     => $main_table,
            'foreignReference' => 'id',
            'onDelete'         => 'cascade'
          ));
          $this->setIfNotSet($this->database[$i18n_table], 'culture', array(
            'isCulture'  => true,
            'type'       => 'varchar',
            'size'       => '7',
            'required'   => true,
            'primaryKey' => true
          ));
        }
        else
        {
          throw new sfException(sprintf('Missing main table for internationalized table "%s".', $i18n_table));
        }
      }
    }
  }

  protected function fixYAMLColumns()
  {
    foreach ($this->getTables() as $table => $columns)
    {
      $has_primary_key = false;
      
      foreach ($columns as $column => $attributes)
      {
        if ($attributes == null)
        {
          // conventions for null attributes
          if ($column == 'created_at' || $column == 'updated_at')
          {
            // timestamp convention
            $this->database[$table][$column]['type']= 'timestamp';
          }

          if ($column == 'id')
          {
            // primary key convention
            $this->database[$table]['id'] = array(
              'type'          => 'integer',
              'required'      => true,
              'primaryKey'    => true,
              'autoIncrement' => true
            );
            $has_primary_key = true;
          }
          
          $pos = strpos($column, '_id');
          if ($pos > 0 && $pos == strlen($column) - 3)
          {
            // foreign key convention
            $foreign_table = $this->findTable(substr($column, 0, $pos));
            if ($foreign_table)
            {
              $this->database[$table][$column] = array(
                'type'             => 'integer',
                'foreignTable'     => $foreign_table,
                'foreignReference' => 'id'
              );
            }
            else
            {
              throw new sfException(sprintf('Unable to resolve foreign table for column "%s"', $column));
            }
          }
          
        }
        else
        {
          if (!is_array($attributes))
          {
            // compact type given as single attribute
            $this->database[$table][$column] = $this->getAttributesFromCompactType($attributes);
          }
          else
          {
            if (isset($attributes['type']))
            {
              // compact type given as value of the type attribute
              $this->database[$table][$column] = array_merge($this->database[$table][$column], $this->getAttributesFromCompactType($attributes['type']));
            }
            if (isset($attributes['primaryKey']))
            {
              $has_primary_key = true;
            }
          }
        }
      }

      if (!$has_primary_key)
      {
        // convention for tables without primary key
        $this->database[$table]['id'] = array(
          'type'          => 'integer',
          'required'      => true,
          'primaryKey'    => true,
          'autoIncrement' => true
        );
      }
    }
  }

  protected function getAttributesFromCompactType($type)
  {
    preg_match('/varchar\(([\d]+)\)/', $type, $matches);
    if (isset($matches[1]))
    {
      return array('type' => 'varchar', 'size' => $matches[1]);
    }
    else
    {
      return array('type' => $type);
    }
  }

  protected function setIfNotSet(&$entry, $key, $value)
  {
    if (!isset($entry[$key]))
    {
      $entry[$key] = $value;
    }
  }

  protected function findTable($table_name)
  {
    // find a table from a phpName or a name
    $table_match = false;
    foreach ($this->getTables() as $tb_name => $table)
    {
      if (
           ($tb_name == $table_name)
           || (isset($table['_attributes']['phpName']) && 
             (
               $table['_attributes']['phpName'] == sfInflector::camelize($table_name) 
               || $table['_attributes']['phpName'] == $table_name
             )
           || (sfInflector::underscore($table_name) == $tb_name)) 
         )
      {
        $table_match = $tb_name;
        break;
      }
    }

    return $table_match;
  }

  protected function getAttributesForColumn($tb_name, $col_name, $column)
  {
    $attributes_string = '';
    if (is_array($column))
    {
      foreach ($column as $key => $value)
      {
        if (!in_array($key, array('foreignClass', 'foreignTable', 'foreignReference', 'onDelete', 'onUpdate', 'index', 'unique', 'sequence')))
        {
          $attributes_string .= " $key=\"".htmlspecialchars($this->getCorrectValueFor($key, $value))."\"";
        }
      }
      $attributes_string .= " />\n";
    }
    else
    {
      throw new sfException('Incorrect settings for column '.$col_name);
    }

    // conventions for foreign key attributes
    if (is_array($column) && (isset($column['foreignTable']) || isset($column['foreignClass'])))
    {
      if (isset($column['foreignTable']))
      {
        $attributes_string .= "    <foreign-key foreignTable=\"$column[foreignTable]\"";
      }
      else
      {
        $foreignTable = $this->findTable($column['foreignClass']);
        if(!$foreignTable)
        {
          // Let's assume that the class given is from another schema
          // We have no access to the other schema's phpNames
          // So our last guess is to try to underscore the class name
          $foreignTable = sfInflector::underscore($column['foreignClass']);
        }
        $attributes_string .= "    <foreign-key foreignTable=\"".$foreignTable."\"";
      }
      
      if (isset($column['onDelete']))
      {
        $attributes_string .= " onDelete=\"$column[onDelete]\"";
      }
      if (isset($column['onUpdate']))
      {
        $attributes_string .= " onUpdate=\"$column[onUpdate]\"";
      }
      $attributes_string .= ">\n";
      $attributes_string .= "      <reference local=\"$col_name\" foreign=\"$column[foreignReference]\" />\n";
      $attributes_string .= "    </foreign-key>\n";
    }

    // conventions for index and unique index attributes
    if (is_array($column) && isset($column['index']))
    {
      if ($column['index'] === 'unique')
      {
        $attributes_string .= "    <unique name=\"${tb_name}_${col_name}_unique\">\n";
        $attributes_string .= "      <unique-column name=\"$col_name\" />\n";
        $attributes_string .= "    </unique>\n";
      }
      else
      {
        $attributes_string .= "    <index name=\"${tb_name}_${col_name}_index\">\n";
        $attributes_string .= "      <index-column name=\"$col_name\" />\n";
        $attributes_string .= "    </index>\n";
      }
    }

    // conventions for sequence name attributes
    // required for databases using sequences for auto-increment columns (e.g. PostgreSQL or Oracle)
    if (is_array($column) && isset($column['sequence'])) 
    {
      $attributes_string .= "    <id-method-parameter value=\"$column[sequence]\" />\n";
    }

    return $attributes_string;
  }

  protected function getAttributesFor($tag)
  {
    if (!isset($tag['_attributes']))
    {
      return '';
    }
    $attributes = $tag['_attributes'];
    $attributes_string = '';
    foreach ($attributes as $key => $value)
    {
      $attributes_string .= ' '.$key.'="'.htmlspecialchars($this->getCorrectValueFor($key, $value)).'"';
    }

    return $attributes_string;
  }

  protected function getCorrectValueFor($key, $value)
  {
    $booleans = array('required', 'primaryKey', 'autoincrement', 'autoIncrement', 'noXsd', 'isI18N', 'isCulture');
    if (in_array($key, $booleans))
    {
      return $value == 1 ? 'true' : 'false';
    }
    else
    {
      return is_null($value) ? 'null' : $value;
    }
  }

  public function getTables()
  {
    return $this->getChildren($this->database);
  }

  public function getChildren($hash)
  {
    foreach ($hash as $key => $value)
    {
      // ignore special children (starting with _)
      if ($key[0] == '_')
      {
        unset($hash[$key]);
      }
    }

    return $hash;
  }

  public function loadXML($file)
  {
    $schema = simplexml_load_file($file);
    $database = array();

    // database
    list($database_name, $database_attributes) = $this->getNameAndAttributes($schema->attributes());
    if ($database_name)
    {
      $this->connection_name = $database_name;
    }
    else
    {
      throw new sfException('The database tag misses a name attribute');
    }
    if ($database_attributes)
    {
      $database['_attributes'] = $database_attributes;
    }

    // tables
    foreach ($schema as $table)
    {
      list($table_name, $table_attributes) = $this->getNameAndAttributes($table->attributes());
      if ($table_name)
      {
        $database[$table_name] = array();
      }
      else
      {
        throw new sfException('A table tag misses the name attribute');
      }
      if ($table_attributes)
      {
        $database[$table_name]['_attributes'] = $table_attributes;
      }

      // columns
      foreach ($table->xpath('column') as $column)
      {
        list($column_name, $column_attributes) = $this->getNameAndAttributes($column->attributes());
        if ($column_name)
        {
          $database[$table_name][$column_name] = $column_attributes;
        }
        else
        {
          throw new sfException('A column tag misses the name attribute');
        }
      }

      // foreign-keys
      $database[$table_name]['_foreign_keys'] = array();
      foreach ($table->xpath('foreign-key') as $foreign_key)
      {
        $foreign_key_table = array();

        // foreign key attributes
        if (isset($foreign_key['foreignTable']))
        {
          $foreign_key_table['foreign_table'] = (string) $foreign_key['foreignTable'];
        }
        else
        {
          throw new sfException('A foreign key misses the foreignTable attribute');
        } 
        if (isset($foreign_key['onDelete']))
        {
          $foreign_key_table['on_delete'] = (string) $foreign_key['onDelete'];
        }
        if (isset($foreign_key['onUpdate']))
        {
          $foreign_key_table['on_update'] = (string) $foreign_key['onUpdate'];
        }

        // foreign key references
        $foreign_key_table['references'] = array();
        foreach ($foreign_key->xpath('reference') as $reference)
        {
          $reference_attributes = array();
          foreach ($reference->attributes() as $reference_attribute_name => $reference_attribute_value)
          {
            $reference_attributes[$reference_attribute_name] = strval($reference_attribute_value);
          }
          $foreign_key_table['references'][] = $reference_attributes;
        }

        if (isset($foreign_key['name']))
        {
          $database[$table_name]['_foreign_keys'][(string)$foreign_key['name']] = $foreign_key_table;
        }
        else
        {
          $database[$table_name]['_foreign_keys'][] = $foreign_key_table;
        }

      }
      $this->removeEmptyKey($database[$table_name], '_foreign_keys');

      // indexes
      $database[$table_name]['_indexes'] = array();
      foreach ($table->xpath('index') as $index)
      {
        $index_keys = array();
        foreach ($index->xpath('index-column') as $index_key)
        {
          $index_keys[] = strval($index_key['name']);
        }
        $database[$table_name]['_indexes'][strval($index['name'])] = $index_keys;
      }
      $this->removeEmptyKey($database[$table_name], '_indexes');

      // unique indexes
      $database[$table_name]['_uniques'] = array();
      foreach ($table->xpath('unique') as $index)
      {
        $unique_keys = array();
        foreach ($index->xpath('unique-column') as $unique_key)
        {
          $unique_keys[] = strval($unique_key['name']);
        }
        $database[$table_name]['_uniques'][strval($index['name'])] = $unique_keys;
      }
      $this->removeEmptyKey($database[$table_name], '_uniques');
    }
    $this->database = $database;
    
    $this->fixXML();
  }

  public function fixXML()
  {
    $this->fixXMLForeignKeys();
    $this->fixXMLIndexes();
    // $this->fixXMLColumns();
  }

  protected function fixXMLForeignKeys()
  {
    foreach ($this->getTables() as $table => $columns)
    {
      if (isset($this->database[$table]['_foreign_keys']))
      {
        $foreign_keys = $this->database[$table]['_foreign_keys'];
        foreach ($foreign_keys as $foreign_key_name => $foreign_key_attributes)
        {
          // Only single foreign keys can be simplified
          if (count($foreign_key_attributes['references']) == 1)
          {
            $reference = $foreign_key_attributes['references'][0];

            // set simple foreign key
            $this->database[$table][$reference['local']]['foreignTable'] = $foreign_key_attributes['foreign_table'];
            $this->database[$table][$reference['local']]['foreignReference'] = $reference['foreign'];
            if (isset($foreign_key_attributes['on_delete']))
            {
              $this->database[$table][$reference['local']]['onDelete'] = $foreign_key_attributes['on_delete'];
            }
            if (isset($foreign_key_attributes['on_update']))
            {
              $this->database[$table][$reference['local']]['onUpdate'] = $foreign_key_attributes['on_update'];
            }

            // remove complex foreign key
            unset($this->database[$table]['_foreign_keys'][$foreign_key_name]);
          }

          $this->removeEmptyKey($this->database[$table], '_foreign_keys');
        }
      }
    }
  }

  protected function fixXMLIndexes()
  {
    foreach ($this->getTables() as $table => $columns)
    {
      if (isset($this->database[$table]['_indexes']))
      {
        $indexes = $this->database[$table]['_indexes'];
        foreach ($indexes as $index => $references)
        {
          // Only single indexes can be simplified
          if (count($references) == 1 && array_key_exists(substr($index, 0, strlen($index) - 6), $columns))
          {
            $reference = $references[0];

            // set simple index
            $this->database[$table][$reference]['index'] = 'true';

            // remove complex index
            unset($this->database[$table]['_indexes'][$index]);
          }
          
          $this->removeEmptyKey($this->database[$table], '_indexes');
        }
      }
      if (isset($this->database[$table]['_uniques']))
      {
        $uniques = $this->database[$table]['_uniques'];
        foreach ($uniques as $index => $references)
        {
          // Only single unique indexes can be simplified
          if (count($references) == 1 && array_key_exists(substr($index, 0, strlen($index) - 7), $columns))
          {
            $reference = $references[0];

            // set simple index
            $this->database[$table][$reference]['index'] = 'unique';

            // remove complex unique index
            unset($this->database[$table]['_uniques'][$index]);
          }

          $this->removeEmptyKey($this->database[$table], '_uniques');
        }
      }
    }
  }

  protected function fixXMLColumns()
  {
    foreach ($this->getTables() as $table => $columns)
    {
      foreach ($columns as $column => $attributes)
      {
        if ($column == 'id' && !array_diff($attributes, array('type' => 'integer', 'required' => 'true', 'primaryKey' => 'true', 'autoIncrement' => 'true')))
        {
          // simplify primary keys
          $this->database[$table]['id'] = null;
        }

        if (($column == 'created_at') || ($column == 'updated_at') && !array_diff($attributes, array('type' => 'timestamp')))
        {
          // simplify timestamps
          $this->database[$table][$column] = null;
        }

        $pos                 = strpos($column, '_id');
        $has_fk_name         = $pos > 0 && $pos == strlen($column) - 3;
        $is_foreign_key      = isset($attributes['type']) && $attributes['type'] == 'integer' && isset($attributes['foreignReference']) && $attributes['foreignReference'] == 'id';
        $has_foreign_table   = isset($attributes['foreignTable']) && array_key_exists($attributes['foreignTable'], $this->getTables());
        $has_other_attribute = isset($attributes['onDelete']);
        if ($has_fk_name && $has_foreign_table && $is_foreign_key && !$has_other_attribute)
        {
          // simplify foreign key
          $this->database[$table][$column] = null;
        }
      }
    }
  }

  public function asYAML()
  {
    return sfYaml::dump(array($this->connection_name => $this->database));
  }

  protected function getNameAndAttributes($hash, $name_attribute = 'name')
  {
    // tag name
    $name = '';
    if (isset($hash[$name_attribute]))
    {
      $name = strval($hash[$name_attribute]);
      unset($hash[$name_attribute]);
    }

    // tag attributes
    $attributes = array();
    foreach ($hash as $attribute => $value)
    {
      $attributes[$attribute] = (string) $value;
    }

    return array($name, $attributes);
  }

  protected function removeEmptyKey(&$hash, $key)
  {
    if (isset($hash[$key]) && !$hash[$key])
    {
      unset($hash[$key]);
    }
  }
}

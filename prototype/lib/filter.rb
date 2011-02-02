# $Id: filter.rb 2579 2008-09-29 10:03:17Z robert $

#
# The filters are functions f(value,row) -> value. Some of the
# functions' behaviours can be configured.
#
# FIX Some of the filters call parse_value() defined in
# run-import. This coupling is unfortunate.
#
# FIX The filters use the logging facility defined in run-import. Make
# it a seperate library?
#
# Author: Kjell-Magne Oierud mailto:kjellm@linpro.no
#

module Filter
  
  #
  # Applyes the given filters to a value.
  #
  # filters might be a single filter or an array of filters.
  #
  def Filter.apply_filters(value, row, *filters)
    Log.write_log('filter', "apply_filters:\tvalue = #{value.pretty_inspect}\trow = #{row.pretty_inspect}\tfilters = #{filters.pretty_inspect}") if $DEBUG
    filters.flatten!
    filters.each do |filter|
      next if filter.nil?
      value = filter.call(value, row)
    end
    Log.write_log('filter', "apply_filters:\treturned value = #{value.pretty_inspect}") if $DEBUG
    return value
  end
  
  def Filter.this_method
    caller[0]=~/`(.*?)'/
    $1
  end




  #
  # Inverts a boolean value
  #
  def Filter.invert(); lambda {|value, row| !value }; end
  
  #
  # Converts a boolean to an integer
  #
  def Filter.boolean_to_integer
    lambda do |value, _|
      case value
      when 't'
        return 1
      when 'f'
        return 0
      when false
        return 0
      when true
        return 1
      else
        raise "#{value} is not a boolean value!"
      end
    end
  end


  #
  # Converts all characters in a string to uppercase characters.
  #
  def Filter.upcase(); lambda {|value, row| value.nil? ? nil : value.upcase} end

  #
  # Converts all characters in a string to downcase characters.
  #
  def Filter.downcase(); lambda {|value, row| value.nil? ? nil : value.downcase} end
  
  #
  # Runs the filters if value is NULL
  #
  def Filter.if_null(filters)
    lambda do |value, row|
      return value unless value.nil?

      return apply_filters(value, row, filters)
    end
  end

  #
  # Runs the filters if value is empty
  #
  def Filter.if_empty(filters)
    lambda do |value,row|
      return value unless value.empty?

      return apply_filters(value, row, filters)
    end
  end

  #
  # Returns the specified value ignoring its input value.
  #
  def Filter.set_value(value)
    lambda do |_,row|
      ReaktorColumn.parse_value(value, nil, row)
    end
  end

  #
  # Return length of string
  #
  def Filter.string_length()
    lambda do |value, _|
      value.length
    end
  end

  #
  # Adds a prefix to a value
  #
  def Filter.add_prefix(str); lambda {|value,row| str + value} end


  #
  # Adds a postfix to a value
  #
  def Filter.add_postfix(str)
    lambda do |value, row|
      value + ReaktorColumn.parse_value(str, value, row).to_s
    end
  end


  #
  # Removes a substring starting at the matching location of 'str'.
  #
  def Filter.truncate_from(str)
    lambda do |value,row|
      value[0..(value.index(str)-1)]
    end
  end

  

  #
  # Sets a specific value if row[col] is true
  #
  def Filter.override_if(col, override_value)
    lambda do |value,row|
      if row[col] # removes '%' prefix
        return override_value
      end
      return value
    end
  end


  #
  # If value is NULL return the specified defalt
  #
  def Filter.default_if_null(default)
    lambda do |value,row|
      value = value.nil? ? ReaktorColumn.parse_value(default, nil, row) : value
      return value
    end
  end
  
  #
  # Print values (for debugging)
  #
  def Filter.print_value(prefix = '')
    lambda do |value, row|
      STDERR.puts "#{prefix}value = #{value.inspect}, row = #{row.inspect}"
      return value
    end
  end
  
  def Filter.replace(pattern, val)
    lambda do |value, row|
      return value.gsub(pattern, val)
    end
  end
  
  #
  # Returns a default value if db value is 0
  #
  def Filter.default_if_zero(default)
    lambda do |value,row|
      STDERR.print "default_if_zero: value: #{value.inspect}"
      value = value == 0 ? ReaktorColumn.parse_value(default, nil, row) : value
      STDERR.puts " - returned: #{value.inspect}"
      return value
    end
  end


  #
  # Converts a textual value to a id using a value domain table.
  # => table: Table name
  # => column: Column name
  #
  def Filter.domain_value_to_id(table, column)
    lambda do |value, row|
      return value if value.nil?

      query = "SELECT id\n   FROM #{table}\n  WHERE #{column} = ?;"
      sth = $dbh_ms.prepare(query)
      begin
        sth.execute(value)
      rescue
        $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        Log.write_log(:error, "domain_value_to_id failed to execute query.\n\tQuery: #{query.pretty_inspect}")
      end
      qrow = sth.fetch()
      if not qrow
        # ERROR: empty row, error output, write to log
        $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        Log.write_log(:error, "domain_value_to_id failed to get id from table. Query return nil row.\n\ttable = \"#{table}\"\n\tcolumn=\"#{column}\"\n\tvalue=\"#{value}\"\n\trow = #{row.pretty_inspect}\n\tQuery: \"#{get_query_string(sth)}\"")
      end
      
      return qrow[0]
    end
  end

  #
  # Get a column value from a database table
  # => database: Database handle
  # => table: Table name
  # => index_column: The name of the column that spesifies the row
  # => value_column: The name of the column that holds the value
  #
  def Filter.get_value_from_db(database, table, index_column, value_column)
    lambda do |value, row|
      return value if value.nil?
      
      query = "SELECT #{value_column}\n\tFrom #{table}\n\tWHERE #{index_column} = ?;"
      sth = database.prepare(query)
      begin
        sth.execute(value)
      rescue
        $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        $stderr.puts $!
        Log.write_log(:error, "get_value_from_db failed to execute query.\n\tQuery: #{query.pretty_inspect}")
      end
      r = sth.fetch
      unless r
        $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        Log.write_log(:error, "get_value_from_db failed to get #{value_column} from table.\n\ttable = \"#{table}\"\n\tindex_column=\"#{index_column}\"\n\tvalue_column=\"#{value_column}\"\n\tvalue=\"#{value}\"\n\tr = #{r.pretty_inspect}\n\trow = #{row.pretty_inspect}\n\tQuery: \"#{get_query_string(sth)}\"")
      end
      
      return r[0]
    end
  end
  
  #
  # Query database for a value
  # Input:  database object and a query string
  # Output: Result string value
  #
  def Filter.get_value_from_query(db, query)
    lambda do |value, row|
      #
      # Replace any occurence of %column_name with actual column values
      #
      q = query.gsub(/%(\w+)/) do |v|
        if row.to_h.key?($1)
          row.to_h[$1]
        else
          v
        end
      end
      
      q.gsub!(/%_/, value.to_s) unless value.nil?
      
      q.gsub!('?', value.to_s) unless value.nil?
      
      Log.write_log(:Filter__get_value_from_query, "Query: \"#{q}\", value = #{value}, row = #{row.inspect}")
      
      #
      # Execute query
      #
      begin
        sth = db.execute(q)
      rescue
        $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        $stderr.puts $!
        Log.write_log(:error, "filter.get_query(db, query) failed to execute query.\n\tQuery: #{q.pretty_inspect}")
        exit 1
      end
      r = sth.fetch
      return '' if r.nil?
      return r[0]
    end
  end

  #
  # Truncates values longer than max_length characters. Replaces last
  # three characters with ellipsis (default), or with delim parameter
  # Input: max length and a delimiter string
  #
  def Filter.truncate(max_length, delim = '...')
    max_length = max_length.to_i
    delim_length = delim.length
    lambda do |value,_|
      value = value.to_s
      if value.length > max_length
        return value[0..(max_length - (delim_length + 1))] + delim
      end
      return value
    end
  end


  #
  # Transforms value by looking up the corresponding value in a hash
  # table
  #
  def Filter.apply_map(map)
    lambda do |value, row|
      return map[value]
    end
  end
  
  #
  # Get the mapped primary key set
  # => old_table: Old table name
  # => old_pk: Old primary key set
  # <= [new table name, new primary key set]
  #
  def Filter.get_new_primary_key_set(old_table, old_pk)
    lambda do |value, row|
      old_pk.each do |key,val|
        old_pk[key] = row[value] if val =~ /%_/ # Replaces %_ with current column value
        old_pk[key] = $1 if val =~ /%(\w+)/ # Replaces %[column name] with corresponding column value
      end
      new_set = KeyMap.get_new_primary_key(old_table, old_pk)
      Log.write_log('keymap', "Mapping table #{[old_table, old_pk].pretty_inspect} to #{new_set.pretty_inspect}")
      return new_set
    end
  end
  
  def Filter.idstore_get(*args)
    lambda do |value, row|
      args.collect! {|arg| ReaktorColumn.parse_value(arg, value, row)}
      IdStore.get(*args)
    end
  end
end

def Filter.log_values(name = :Filter__log_vales, text = '')
  lambda do |value, row|
    Log.write_log(name, "#{text}: value = #{value}, row = #{row.inspect}")
    return value
  end
end
  
######################################################################
# These filters are speciall to Reaktor ,,,


require 'digest/md5'

module Filter

  #
  # Extracts filename from a serialized lisp object.
  #
  def Filter.extract_filename()
    lambda do |value,row|
      return if value.nil? || value == 'NIL'

      filename = (value.match(/:filename "([^"]+)"/))[1]
      Log.write_log('files', "#{filename}")
      return filename
    end
  end

  #
  # Extracts the text from a serialized richtext-simple lisp object
  #
  def Filter.parse_richtext_simple()
    lambda do |value,row|
      return value if value.nil?

      mdata = value.match(/:parsed-text '\("(.+)"\)\)/m)
      return mdata.nil? ? nil : mdata[1]
    end
  end
  
  def Filter.parse_richtext_simple_multiline()
    lambda do |value, row|
      return value if value.nil?
      mdata = value.match(/:parsed-text '\((.+)\)\)/m)
      return mdata.nil? ? nil : mdata[1]
    end
  end

  def Filter.parse_artwork_description()
    lambda do |value, row|
      return value if value.nil?
      #
      # :P => <br />
      #
      value.gsub!(/:P/, %q{"<br />"})
      slist = value.scan(/".+?"/m)
      linkstatus = false
      slist.map! do |l|
        l.gsub!(/\n/, '')
        l.gsub!(/<br>/, "\n")
        if l =~ %r{http://}
          linkstatus = true
          l = %q{<a href=} + l + '>'
        elsif linkstatus
          linkstatus = false
          l = l[1...-1] + '</a>'
        else
          l = l[1...-1]
        end
      end
      return slist.join
    end
  end

  #
  # Writes textual artwork to a file. FIX should probably be renamed.
  #
  def Filter.parse_artwork_data_old()
    lambda do |value,row|
      if value.match(%r{\A \( (?:NIL|T) \s \. \s (.*) \) \z}xms)
        text = $1
        digest = Digest.MD5.hexdigest(text)
        filename = "#{digest}.txt"
        File.open(File.join('data', filename), 'w') do |file|
          file.puts(text)
        end
        return ":filename \"#{filename}\"" # Suitable for
                                           # Filter.extract_filename()
      end
      return value
    end
  end
  
  #
  # Removes eclosing parantesis
  #
  def Filter.trim_lisp_encl_params()
    lambda do |value, _|
      value.gsub(/^\s*\("/,'').gsub(/"\)\s*$/, '')
    end
  end
  
  #
  # Make a valid data from a year
  #
  def Filter.mkdate_from_year()
    lambda do |value, _|
      if value.nil?
        return '1800-01-01'
      else
        return value.to_s + '-01-01'
      end
    end
  end
  
  #
  # Get filename from serialized lips
  #
  def Filter.get_filename_from_lisp()
    lambda do |value, row|
      return value if value.nil?
      return value.split[3][1...-1]
    end
  end
  
  #
  # FIX remove the need for this method ...
  #
  def Filter.fix_encoding
    lambda do |value,row|
      # FIX HACK remove! These characters are destroyed on the way some
      # where. Are stored in postgres as U+0094 and U+0096 and somehow
      # ends up as U+C294 and U+C296 which MySQL can't recognize as legal
      # unicode (And I think MySQL is right here ...). 
      #
      # This is just so that the import doesn't stop and I can continue
      # working.
      # TODO: Solve this problem
      #
      unless value.nil?
        value.gsub!("\xC2\x94", "?")
        value.gsub!("\xC2\x96", "?")
        value.gsub!("\xC3\xA6", "?")
        return value
      end
      
      return value
    end
  end
end

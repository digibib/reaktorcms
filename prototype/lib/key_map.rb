# 
# Maps old primary key sets with new ones
#
 

class KeyMap
  
  @@old_to_new = {}
  @@new_to_old = {}
  
  #
  # Save a key mapping
  # => old_table: Old table name
  # => old_pk: Old primary key set {columnname=>value, ...}
  # => new_table: New table name
  # => new_pk: New primary key set {columnname=>value, ...}
  #
  def self.save(old_table, old_pk, new_table, new_pk)
    @@old_to_new[[old_table, old_pk]] = [new_table, new_pk]
    @@new_to_old[[new_table, new_pk]] = [old_table, old_pk]
  end
  
  #
  # Get new primary key set
  # => old_table: Old table name
  # => old_pk: Old primary key set
  # <= Returns new table and primary key set [new_table, {cn=>value, ...}]
  #
  def self.get_new_primary_key(old_table, old_pk)
    unless @@old_to_new[[old_table, old_pk]]
      raise "Key does not exists: #{old_table.pretty_inspect}, #{old_pk.pretty_inspect}"
    end
  end
  
  #
  # Get old primary key set
  # => new_table: New table name
  # => new_pk: New primary key set
  # <= Returns old table and primary key set [old_table, {cn=>value, ...}]
  #
  def self.get_old_primary_key(new_table, new_pk)
    @@new_to_old[[new_table, new_pk]]
  end
  
  def initialize(old_table, old_pk, new_table, new_pk)
    self.save(old_table, old_pk, new_table, new_pk)
  end
  
  def self.print_all
    puts "Printing all!"
    @@old_to_new.pretty_inspect
  end
end

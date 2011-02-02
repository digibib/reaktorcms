#
# = Synopsis 
#
# Reaktoruser artwork_groups plugin
# This plugin reads data from reaktoruser::artwork_groups and writes all
# permutations for the artworkgroups described by serialized lisp to
# the related_artwork table
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

class ReaktoruserArtworkgroupsPlugin

  @@totals = {
    :permutations => 0, # Total number of permutations
    :groups => 0, # Total number of detected groups
  }
  @@table_name = 'related_artwork'
  @@log_name = 'reaktoruser_artworkgroups_plugin'
  @@report_name = 'report'
  
  def self.log_name
    @@log_name
  end

  def initialize(attr_name, row)
    @reaktor_rows = []
    @user_id = row['id']
    parse_data(row[attr_name]) unless row.nil?
  end
  
  def get_result
    @reaktor_rows
  end
  
  def each
    @reaktor_rows
  end
  
  #
  # Parse data entry
  # => data: data from artwork_groups column in reaktoruser table
  #
  def parse_data(data)
    return nil if data.nil?
    return nil if data.empty?
    return nil if data =~ /NIL/
    
    num_groups = 0;
    num_artworks = 0
    permutations = 0
    data.scan(%r{(\(([^\(\)]*)\))+}).each do |g|
      num_groups += 1
      group = g[1].scan(/\d+/)
      group.each do |a1|
        num_artworks += 1
        group.each do |a2|
          unless a1.to_i == a2.to_i or permutation_exists(a1.to_i, a2.to_i)
            permutations += 1
            @reaktor_rows << ReaktorRow.new(
              :related_artwork,
              [
                ReaktorColumn.new({:name   => :first_artwork, :value  => a1.to_i}),
                ReaktorColumn.new({:name   => :second_artwork, :value => a2.to_i}),
                ReaktorColumn.new({:name   => :created_at, :value => '1970-01-01'}),
                ReaktorColumn.new({:name   => :created_by, :value => @user_id}),
              ]
            )
          end
        end
      end
    end
    @@totals[:groups] += num_groups
    @@totals[:permutations] += permutations
    Log.write_log(@@log_name, "Entry with #{num_groups} groups, #{num_artworks} uniq artworks, stored with #{permutations} permutations ")
    return [num_groups, num_artworks, permutations]
  end
  
  #
  # Check if a permutation allready exists
  # Takes two artwork ids
  #
  def permutation_exists(id1, id2)
    query = %Q{
              SELECT * from #{@@table_name}
              WHERE
                (first_artwork = #{id1} AND second_artwork = #{id2})
                OR
                (first_artwork = #{id2} AND second_artwork = #{id1})
            }
    begin
      tables = $dbh_ms.execute(query).fetch
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not check for permutations from table #{@@table_name}. Message: #{$!}.")
      raise
      exit
    end
    return true if tables
    return nil
  end

  def self.flush_logs
    Log.flush_log(@@log_name)
    Log.flush_log(@@report_name)
  end
  
  def self.write_report
    Log.write_log(@@report_name, "ReaktoruserArtworkgroupsPlugin:")
    Log.write_log(@@report_name, "\t#{@@totals[:permutations]} total number of permutations saved")
    Log.write_log(@@report_name, "\t#{@@totals[:groups]} total number of grops detected")
    Log.flush_log(@@report_name)
  end
end

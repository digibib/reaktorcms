# 
# Create relations between artwork files and tagging
#
# = Default values
# * taggable_model:   ReaktorFile
# * parent_approved:  1
# * parent_user_id:   0
#
 

class ArtworkTopicTaggingPlugin < Plugin
  
  @@totals = {
    :parsed     => 0, # Total number of artwork_topics rows parsed
    :no_files   => 0, # Total number of tagged artworks that has no files
    :tagging    => 0, # Total number of tagging records created
    :max_files  => 0, # Max number of files ascosiated with an artwork
    :artwork    => 0, # Total number of artworks tagged
  }
  @@report_name = 'report'
  @@log_name = 'artwork_topic_tagging_plugin'
  
  #
  # Input: attribute name of the value we are reading and a dbi result set
  # from the artwork_topic table
  #
  def initialize(attr_name, row)
    @attr_name = attr_name
    @row = row
    @artwork_id = row['artwork']
    @topic_id = row['topic']
    @reaktor_rows = []
    @@totals[:parsed] += 1
    import_taggin_for_artwork(@artwork_id, @topic_id)
    import_tagging_for_artwork_files(@artwork_id, @topic_id)
  end
  
  #
  # Returns the list of ReaktorRow objects
  #
  def each
    @reaktor_rows
  end

  #
  # Import tagging for artwork files
  # Input: artwork id and topic id
  #
  def import_tagging_for_artwork_files(artwork_id, topic_id)
    
    query = %Q{
      SELECT r.file_id, a.user_id
      FROM reaktor_artwork_file AS r
      LEFT OUTER JOIN reaktor_artwork AS a ON r.artwork_id = a.id
      WHERE r.artwork_id = #{artwork_id}
    }
    sth = $dbh_ms.execute(query)
    if sth.nil?
      @@totals[:no_files] += 1
    else
      files = 0 # Number of files tagged
      sth.each do |r|
        insert_tagging(topic_id, 'ReaktorFile', r[0], 1, r[1])
        files += 1
      end
      @@totals[:max_files] = files if files > @@totals[:max_files]
    end
  end
  
  #
  # Import tagging records based on artwork_id and topic_id
  #
  def import_taggin_for_artwork(artwork_id, topic_id)
    if user_id = get_user_id_from_artwork(artwork_id)
      insert_tagging(topic_id, 'ReaktorArtwork', artwork_id, 1, user_id)
      @@totals[:artwork] += 1
      parent_id = topic_id
      while parent_id = get_parent_from_topic_id(parent_id)
        insert_tagging(parent_id, 'ReaktorArtwork', artwork_id, 1, user_id)
        @@totals[:artwork] += 1
      end
    end
  end
  
  #
  # Get parent id from topic id
  # Input: topic id
  # Output: parents topic id or nil if not present
  #
  def get_parent_from_topic_id(topic_id)
    query = %Q{
      SELECT parent
      FROM topic
      WHERE id = #{topic_id}
    }
    begin
      sth = $dbh_pg.execute(query)
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not get parent from topic id. Message: #{$!}. Query: #{query}")
      raise
      exit
    end
    return sth.fetch[0]
  end
  
  #
  # Insert record into tagging
  #
  def insert_tagging(tag_id, taggable_model, taggable_id, parent_approved, parent_user_id)
    @@totals[:tagging] += 1
    @reaktor_rows << ReaktorRow.new(
      :tagging,
      [
        ReaktorColumn.new({:name   => :tag_id, :value  => tag_id}),
        ReaktorColumn.new({:name   => :taggable_model, :value  => taggable_model,}),
        ReaktorColumn.new({:name   => :taggable_id, :value  => taggable_id,}),
        ReaktorColumn.new({:name   => :parent_approved, :value  => parent_approved,}),
        ReaktorColumn.new({:name   => :parent_user_id, :value  => parent_user_id,}),
      ]
    )
    Log.write_log(@@log_name, "#{@reaktor_rows.last.inspect}")
  end
  
  #
  # Get user id from artwork
  #
  def get_user_id_from_artwork(artwork_id)
    #
    # Get user id
    #
    query = %Q{
      SELECT creator
      FROM artwork
      WHERE id = #{artwork_id}
    }
    begin
      sth = $dbh_pg.execute(query)
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not get creator from artwork. Message: #{$!}. Query: #{query}")
      raise
      exit
    end
    return nil if sth.nil?
    return sth.fetch[0]
  end
  
  def self.flush_logs
    Log.flush_log(@@report_name)
    Log.flush_log(@@log_name)
  end

  def self.write_report
    Log::write_log(@@report_name, "ArtworkTopicTaggingPlugin:")
    Log::write_log(@@report_name, "\t#{@@totals[:parsed]} number of artwork_topics parsed")
    Log::write_log(@@report_name, "\t#{@@totals[:no_files]} number of artwork that had no files")
    Log::write_log(@@report_name, "\t#{@@totals[:tagging]} number of tagging records created")
    Log::write_log(@@report_name, "\t#{@@totals[:artwork]} number of artworks tagged")
    Log::write_log(@@report_name, "\tMaximum number of files tagged by one artwork_topic relation: #{@@totals[:max_files]}")
    Log::write_log(@@report_name, "\tList of all created tags is saved to #{@@log_name}")
  end
end

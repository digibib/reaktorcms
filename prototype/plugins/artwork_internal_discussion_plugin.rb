#
# = Synopsis 
#
# Artwork internal_discussion plugin
# Handles data from the artwork tables internal_discussion column
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

class ArtworkInternalDiscussionPlugin < Plugin
  
  attr :reaktor_data
  attr :reaktor_rows
  
  @@totals = {
    :parsed => 0, # Total number of artwork rows parsed
    :scanned => 0, # Total number of artwork data scanned (no nil datas)
    :matched => 0, # Total number of records with matches
    :comments => 0, # Total number of comments found
    :unmatched => 0, # Total number of unmatched records
  }
  @@report_name = 'report'
  @@log_name = 'artwork_internal_discussion_plugin'
  @@seconds_1900_1970 = 2208988800
  
  def self.log_name
    @@log_name
  end

  def initialize(attr_name, row)
    @attr_name = attr_name
    @row = row
    @data = row[attr_name]
    @artwork_id = row[:id]
    @reaktor_rows = []
    process
  end
  
  #
  # Returns the list of ReaktorRow objects
  #
  def each
    @reaktor_rows
  end
  
  #
  # Process the data
  def process
    
    @@totals[:parsed] += 1
    return nil unless @data
    return nil if @data.empty?
    
    @@totals[:scanned] += 1
    comments = @@totals[:comments]
    
    scan.each do |comment|
      @reaktor_rows << ReaktorRow.new(
        :sf_comment,
        [
          ReaktorColumn.new(:name => :commentable_model, :value => "ReaktorArtwork"),
          ReaktorColumn.new(:name => :commentable_id, :value => @artwork_id),
          ReaktorColumn.new(:name => :namespace, :value => "administrator"),
          ReaktorColumn.new(:name => :text, :value => comment[:text].to_s),
          ReaktorColumn.new(:name => :author_id, :value => get_user_id(comment[:reaktoruser_id])),
          ReaktorColumn.new(:name => :created_at, :value => get_datetime(convert_timestamp(comment[:timestamp]))),
          ReaktorColumn.new(:name => :title, :value => ''),
        ]
      )
      @@totals[:comments] += 1
    end
    if @row[:under_discussion]
      @reaktor_rows << ReaktorRow.new(
        :history,
        [
          ReaktorColumn.new({
              :name   => :action_id,
              :value  => 8,
          }),
          ReaktorColumn.new({
              :name   => :user_id,
              :value  => 1,
          }),
          ReaktorColumn.new({
              :name   => :object_id,
              :value  =>@artwork_id,
          })
        ]
      )
    end
    if @@totals[:comments] > comments
      @@totals[:matched] += 1 # Record with matches
    else
      @@totals[:unmatched] =+ 1 # Unmatched record
    end
  end
  
  #
  # Get the date on format: yyyy-mm-dd hh:mm:ss from timestamp
  def get_datetime(timestamp)
    t = Time.at(timestamp)
    "%d-%d-%d %d:%d:%d" % [t.year, t.month, t.day, t.hour, t.min, t.sec]
  end
  
  #
  # Get the new user id from IdStore
  # => reaktoruser_id: user id from reaktoruser record
  #
  def get_user_id(reaktoruser_id)
    IdStore.get(:reaktoruser, reaktoruser_id)
  end
  
  #
  # Scans the data from the internal_discussion record column
  # <= A list of comment occurenses
  #
  def scan
    return nil unless @data
    
    comments = []
    
    @data.scan(/(\d+)\s+(\d+)[^']+'[^']+'\(([^\)]+)/m).each do |m|
      comments << {
        :reaktoruser_id => m[0],
        :timestamp      => m[1],
        :text           => m[2],
        # TODO:title ?
      }
      Log.write_log(@@log_name, "#<comment (reaktor_id:#{m[0]}, timestamp:#{m[1]}, text:#{m[2]})>")
    end
    return comments
  end
  
  #
  # Convert from timestamp with epoch 1900-01-01 to timestamp
  # with epoch 1970-01-01
  # => Timestamp with epoch 1900-01-01
  # <= Timestamp with epoch 1970-01-01
  #
  def convert_timestamp(ts)
    return ts.to_i - @@seconds_1900_1970
  end
  
  def self.flush_logs
    Log.flush_log(@@report_name)
    Log.flush_log(@@log_name)
  end

  def self.write_report
    Log::write_log(@@report_name, "ArtworkInternalDiscussionPlugin")
    Log::write_log(@@report_name, "\t#{@@totals[:parsed]} number of artworks parsed")
    Log::write_log(@@report_name, "\t#{@@totals[:scanned]} number of artwork internal_discussion scanned")
    Log::write_log(@@report_name, "\t#{@@totals[:matched]} number of records with matches")
    Log::write_log(@@report_name, "\t#{@@totals[:comments]} number of comments found")
    Log::write_log(@@report_name, "\t#{@@totals[:unmatched]} number of unmatched records")
    Log::write_log(@@report_name, "\tA log of all comments are saved to #{@@log_name}")
  end
end

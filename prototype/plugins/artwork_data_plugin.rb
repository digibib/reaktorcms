#!/usr/bin/env ruby
#
# = Synopsis 
#
# Scans the data filed of the artwork table
# The constant @@data_path must be set or the plugin will fail
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

require 'digest/md5'

class ArtworkDataPlugin < Plugin
  
  attr :reaktor_data
  attr :reaktor_rows
  
  @@totals = {
    :parsed => 0, # Total number of artwork rows parsed
    :scanned => 0, # Total number of artwork data scanned (no nil datas)
    :matched => 0, # Total number of data with matches
    :files => 0, # Total number of files
    :file_size => 0, # Total size of files
    :t_textdata => 0, # Total number of text data marked with T
    :nil_textdata => 0, # Total number of text data marked with NIL
    :unmatched => 0, # Total number of unmatched rows
    :textfiles => 0, # Total number of text data files created
    :screenshots => 0, # Total number of screenshot files to be moved
  }
  @@report_name = 'report'
  @@log_name = 'artwork_data_plugin'
  @@data_path = nil
  
  def self.log_name
    @@log_name
  end
  
  def self.set_data_path(path)
    @@data_path = path
  end
  
  def initialize(attr_name, row)
    if @@data_path.nil?
      STDERR.puts "# Error in #{__FILE__} on line #{__LINE__}. See errorlog."
      Log.write_log(:error, "Required data path has not been set.")
      exit
    end
    @attr_name = attr_name
    @row = row
    @id = row['id'].to_s
    @data = row['data']
    @screenshot = row['screenshot']
    @reaktor_rows = []
    @old_table = 'artwork'
    @file_order = 0

    process
  end
  
  #
  # Returns the list of ReaktorRow objects
  #
  def each
    @reaktor_rows
  end
  
  #
  # Process record
  # Return: List of ReactorRow objects
  #
  def process
    
    @@totals[:parsed] += 1
    return nil unless @data
    
    @@totals[:scanned] += 1
    um = @@totals[:matched]
    
    user_id = @row['creator']
    uploaded_at = get_uploaded_at(@id)
    modified_at = get_modified_at(@id)
    
    thumbnails = scan_for_files(@screenshot)
    thumbnail_used = nil

    ##########################################################################
    # Media files
    ##########################################################################
    scan_for_files(@data).each do |file|
      @file_order += 1
      mimetype_id = get_mimetype_id(file[:mime_type], file[:file_name])
      identifier = get_identifier(file[:mime_type])

      begin
        reaktor_file_id = IdStore.new(file[:file_name], user_id)
      rescue
        Log.write_log('warning', "Could not create new IdStore object for (#{file[:file_name]}, #{user_id}). Message: #{$!}. File will not get processed!")
        next
      end
      
      file[:title] = @row['title'] unless file[:title]
      
      #
      # Change extension for audio and video files
      #
      realpath = file[:file_name]
      reg_ext = /\.\w+$/
      case
      when identifier == 'video'
        realpath = file[:file_name].gsub(reg_ext, '.flv')
      when identifier == 'audio'
        realpath = file[:file_name].gsub(reg_ext, '.mp3')
      end
      @reaktor_rows << ReaktorRow.new(
        :reaktor_file,
        [
          ReaktorColumn.new({:name => :filename,             :value => file[:file_name]}),
          ReaktorColumn.new({:name => :user_id,              :value => user_id}),
          ReaktorColumn.new({:name => :realpath,             :value => realpath}),
          ReaktorColumn.new({:name => :thumbpath,            :value => ''}),
          ReaktorColumn.new({:name => :originalpath,         :value => file[:file_name]}),
          ReaktorColumn.new({:name => :original_mimetype_id, :value => mimetype_id}),
          ReaktorColumn.new({:name => :converted_mimetype_id,:value => mimetype_id}),
          ReaktorColumn.new({:name => :thumbnail_mimetype_id,:value => mimetype_id}),
          ReaktorColumn.new({:name => :uploaded_at,          :value => uploaded_at}),
          ReaktorColumn.new({:name => :modified_at,          :value => modified_at}),
          #ReaktorColumn.new({:name => :reported_at,          :value => '1970-01-01 00:00:00'}),
          ReaktorColumn.new({:name => :reported,             :value => 0}),
          ReaktorColumn.new({:name => :total_reported_ever,  :value => 0}),
          ReaktorColumn.new({:name => :marked_unsuitable,    :value => 0}),
          ReaktorColumn.new({:name => :under_discussion,     :value => 0}),
          ReaktorColumn.new({:name => :identifier,           :value => identifier.to_s}),
          ReaktorColumn.new({:name => :deleted,              :value => 0}),
        ], reaktor_file_id
      )
      @@totals[:matched] += 1
      @@totals[:files] += 1
      @@totals[:file_size] += file[:file_size]
      Log::write_log(@@log_name, "#{file[:file_name]}")
      
      @reaktor_rows << ReaktorRow.new(
        :file_metadata,
        [
          ReaktorColumn.new(:name => :file,                 :value => reaktor_file_id),
          ReaktorColumn.new(:name => :meta_element,         :value => 'description'),
          ReaktorColumn.new(:name => :meta_qualifier,       :value => 'creation'),
          ReaktorColumn.new(
            :name => :meta_value,
            :value => @row[:howto],
            :filters => [
              Filter.parse_richtext_simple,
              Filter.default_if_null(''),
            ]
          ),
        ]
      )
      
      #
      # File title
      #
      @reaktor_rows << ReaktorRow.new(
        :file_metadata,
        [
          ReaktorColumn.new(:name => :file,                 :value => reaktor_file_id),
          ReaktorColumn.new(:name => :meta_element,         :value => 'title'),
          ReaktorColumn.new(:name => :meta_qualifier,       :value => ''),
          ReaktorColumn.new({
              :name   => :meta_value,
              :value  => file[:title],
          }),
        ]
      ) if file[:title]
      
      @reaktor_rows << ReaktorRow.new(
        :file_metadata,
        [
          ReaktorColumn.new(:name => :file,                 :value => reaktor_file_id),
          ReaktorColumn.new(:name => :meta_element,         :value => 'relation'),
          ReaktorColumn.new(:name => :meta_qualifier,       :value => 'references'),
          ReaktorColumn.new(
            :name => :meta_value,
            :value => @row[:howto],
            :filters => [
              Filter.parse_richtext_simple,
              Filter.default_if_null(''),
            ]
          ),
        ]
      )
      
      #
      # Lincense data
      #
      @reaktor_rows << ReaktorRow.new(
        :file_metadata,
        [
          ReaktorColumn.new(:name => :file,                 :value => reaktor_file_id),
          ReaktorColumn.new(:name => :meta_element,         :value => 'license'),
          ReaktorColumn.new(:name => :meta_qualifier,       :value => ''),
          ReaktorColumn.new(
            :name => :meta_value,
            :value => @row[:rights],
            :filters => [
              Filter.apply_map($domain_maps[:artwork__rights]),
            ]
          ),
        ]
      )

      @reaktor_rows << ReaktorRow.new(
        :reaktor_artwork_file,
        [
          ReaktorColumn.new(:name => :artwork_id,           :value => @id),
          ReaktorColumn.new(:name => :file_id,              :value => reaktor_file_id),
          ReaktorColumn.new(:name => :file_order,           :value => @file_order),
        ]
      )
    end

    ##########################################################################
    # Teksts marked with T
    ##########################################################################
    scan_for_t_files(@id, @data).each do |file_name|
      unless thumbnails
        thumbnail_filename = ''
        thumbnail_mime_type_id = 2
      else
        thumbnail_filename = thumbnails[0][:file_name]
        thumbnail_mime_type_id = get_mimetype_id(thumbnails[0][:mime_type], thumbnails[0][:file_name])
        thumbnail_used = true
      end
      
      begin
        reaktor_tfile_id = IdStore.new(file_name, user_id)
      rescue
        Log.write_log('warning', "Could not create new IdStore object for (#{file_name}, #{user_id}). Message: #{$!}. File will not get processed!")
        next
      end

      @reaktor_rows << ReaktorRow.new(
        :reaktor_file,
        [
          ReaktorColumn.new(:name => :filename,             :value => file_name),
          ReaktorColumn.new(:name => :user_id,              :value => user_id),
          ReaktorColumn.new(:name => :realpath,             :value => file_name),
          ReaktorColumn.new(:name => :thumbpath,            :value => thumbnail_filename),
          ReaktorColumn.new(:name => :originalpath,         :value => file_name),
          ReaktorColumn.new(:name => :original_mimetype_id, :value => 9), # text/plain
          ReaktorColumn.new(:name => :converted_mimetype_id,:value => 9), # text/plain
          ReaktorColumn.new(:name => :thumbnail_mimetype_id,:value => thumbnail_mime_type_id),
          ReaktorColumn.new(:name => :uploaded_at,          :value => uploaded_at),
          ReaktorColumn.new(:name => :modified_at,          :value => modified_at),
          #ReaktorColumn.new(:name => :reported_at,          :value => '1970-01-01 00:00:00'),
          ReaktorColumn.new(:name => :reported,             :value => 0),
          ReaktorColumn.new(:name => :total_reported_ever,  :value => 0),
          ReaktorColumn.new(:name => :marked_unsuitable,    :value => 0),
          ReaktorColumn.new(:name => :under_discussion,     :value => 0),
          ReaktorColumn.new(:name => :identifier,           :value => 'text'),
          ReaktorColumn.new(:name => :deleted,              :value => 0),
        ],reaktor_tfile_id
      )

      # TODO: Verify this!
      @reaktor_rows << ReaktorRow.new(
        :reaktor_artwork_file,
        [
          ReaktorColumn.new({:name => :artwork_id,           :value => @id}),
          ReaktorColumn.new({:name => :file_id,              :value => reaktor_tfile_id}),
        ]
      )

      @@totals[:textfiles] += 1
      @@totals[:matched] += 1
      @@totals[:t_textdata] += 1
    end

    ##########################################################################
    # Teksts marked with NIL
    ##########################################################################
    scan_for_nil_files(@id, @data).each do |file_name|
      unless thumbnails
        thumbnail_filename = ''
        thumbnail_mime_type_id = 2
      else
        thumbnail_filename = thumbnails[0][:file_name]
        thumbnail_mime_type_id = get_mimetype_id(thumbnails[0][:mime_type], thumbnails[0][:file_name])
      end
      
      begin
        reaktor_nilfile_id = IdStore.new(file_name, user_id)
      rescue
        Log.write_log('warning', "Could not create new IdStore object for (#{file_name}, #{user_id}). Message: #{$!}. File will not get processed!")
        next
      end

      @reaktor_rows << ReaktorRow.new(
        :reaktor_file,
        [
          ReaktorColumn.new(:name => :filename,             :value => file_name),
          ReaktorColumn.new(:name => :user_id,              :value => user_id),
          ReaktorColumn.new(:name => :realpath,             :value => file_name),
          ReaktorColumn.new(:name => :thumbpath,            :value => thumbnail_filename),
          ReaktorColumn.new(:name => :originalpath,         :value => file_name),
          ReaktorColumn.new(:name => :original_mimetype_id, :value => 9), # text/plain
          ReaktorColumn.new(:name => :converted_mimetype_id,:value => 9), # text/plain
          ReaktorColumn.new(:name => :thumbnail_mimetype_id,:value => thumbnail_mime_type_id),
          ReaktorColumn.new(:name => :uploaded_at,          :value => uploaded_at),
          ReaktorColumn.new(:name => :modified_at,          :value => modified_at),
          #ReaktorColumn.new(:name => :reported_at,          :value => '1970-01-01 00:00:00'),
          ReaktorColumn.new(:name => :reported,             :value => 0),
          ReaktorColumn.new(:name => :total_reported_ever,  :value => 0),
          ReaktorColumn.new(:name => :marked_unsuitable,    :value => 0),
          ReaktorColumn.new(:name => :under_discussion,     :value => 0),
          ReaktorColumn.new(:name => :identifier,           :value => 'text'),
          ReaktorColumn.new(:name => :deleted,              :value => 0),
        ],reaktor_nilfile_id
      )

      @reaktor_rows << ReaktorRow.new(
        :reaktor_artwork_file,
        [
          ReaktorColumn.new({:name => :artwork_id,           :value => @id}),
          ReaktorColumn.new({:name => :file_id,              :value => reaktor_nilfile_id}),
        ]
      )

      @@totals[:textfiles] += 1
      @@totals[:matched] += 1
      @@totals[:nil_textdata] += 1
    end

    if thumbnail_used
      @@totals[:screenshots] += 1
      @@totals[:files] += 1
      @@totals[:file_size] += thumbnails[0][:file_size]
      Log::write_log(@@log_name, "#{thumbnails[0][:file_name]}")
    end
    @@totals[:unmatched] += 1 if um == @@totals[:matched]
  end
  
  #
  # Scan data for artwork-files
  # => data: Textual data contained in the screenshot or data column
  # <= A list of hashes
  #
  def scan_for_files(data)
    return nil unless data
    
    ret = []
    data.scan(/("([^"]+)".*?)?#\.\([^f]*(file::([^\s]+))*[^"]*"([^"]*)"\s*(:filesize\s*(\d+))*/m).each do |m|
      #
      # Set column values
      #
      file = {
        :title      => nil,
        :mime_type  => 'no-type',
        :file_name  => 'no-filename',
        :file_size  => 0,
      }
      file[:title]     = m[1] if m[1]
      file[:mime_type] = m[3] if m[3]
      file[:file_name] = m[4] if m[4]
      file[:file_size] = m[6].to_i if m[6]
      ret << file
    end
    return ret
  end
  
  #
  # Scan data column for texts marked (T
  # Each occurence of a text is stored in a file
  # <= Returns a list of filenames of the created text files
  #
  def scan_for_t_files(artwork_id, data)
    files = []
    data.scan(/\(T \. \("(.*)"\)\)/mu).each do |text|
      d = text[0]
      d.gsub!(/"\s+"/, '')
      d.gsub!(/"\s*:P\s*"/, "\n\n" )
      digest = Digest::MD5.hexdigest(artwork_id)
      file_name = "#{digest}.txt"
      File.open(File.join(@@data_path, file_name), 'w') do |file|
        file.puts(d)
      end
      files << file_name
    end
    return files
  end
  
  #
  # Scan data column for texts marked (NIL
  # Each occurence of a text is stored in a file
  # <= Returns a list of filenames of the created text files
  #
  def scan_for_nil_files(artwork_id, data)
    files = []
    data.scan(/\(NIL \. "(.*)"\)/mu).each do |text|
      digest = Digest::MD5.hexdigest(artwork_id)
      file_name = "#{digest}.txt"
      File.open(File.join(@@data_path, file_name), 'w') do |file|
        file.puts(text[0])
      end
      files << file_name
    end
    return files
  end
  
  #
  # Get the file_mimetype::id from a prototype mime-type and file extension
  #
  def get_mimetype_id(mime_type, file_name = nil)
    if reaktor_file_mime_type = $domain_maps[:artwork__mime_type]
      reaktor_file_mime_type = $domain_maps[:artwork__mime_type][mime_type]
    else
      $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log::write_log('error', "Could not determine mime-type from #{mime_type}")
      exit
    end
    if reaktor_file_mime_type.kind_of?(Hash)
      reaktor_file_mime_type = reaktor_file_mime_type[file_name[/[^\.]+$/]]
    end
    if reaktor_file_mime_type.nil?
      $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log::write_log('error', "No reaktor mime-type found for #{mime_type}")
      exit
    end
    query = %Q{
            SELECT id
            FROM file_mimetype
            WHERE mimetype = '#{reaktor_file_mime_type}'
    }
    unless mimetype_id = $dbh_ms.execute(query).fetch
      $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log::write_log('error', "Could not get file_mimetype id from mime-type: #{reaktor_file_mime_type}")
      exit
    end
    return mimetype_id
  end
  
  #
  # Get corresponding identtifier to a mime-type
  # Input: A string describing the mime-type
  # Output: A string describing the identifier
  #
  def get_identifier(mime_type)
    query = "SELECT identifier FROM file_mimetype WHERE mimetype = '#{mime_type}'"
    if id = $dbh_ms.execute(query).fetch
      identifier = id[0]
    elsif identifier = $domain_maps[:artwork__mime_type_to_identifier][mime_type]
    else
      identifier = 'no-identifier'
      Log::write_log('error', "Could not find identifier for the mime-type #{mime_type}")
    end
    return identifier.to_s
  end
  
  #
  # Get sf_guard_user::id mapped to reaktoruser::id through KeyMap
  # => reaktoruser_id: reaktoruser id
  # <= sf_guard_user id
  #
  def get_user_id(reaktoruser_id)
    user_id = KeyMap::get_new_primary_key(:reaktoruser, {:id => reaktoruser_id})
    if user_id.nil?
      KeyMap::print_all
      user_id = {:sf_guard_user => {:id => 0}}
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log::write_log('error', "Was not able to retrive new id of reaktoruser #{reaktoruser_id}.")
    end
    return user_id[:sf_guard_user][:id]
  end
  
  #
  # Get timestamp string from changelog on this artwork data
  #
  def get_uploaded_at(artwork_id)
    query = %Q{
            SELECT timestamp
            FROM changelog
            WHERE object_type = 'artwork'
              AND action = ':CREATE'
              AND object = #{artwork_id}
    }
    if ts = $dbh_pg.execute(query).fetch
      uploaded_at = ts[0].to_s
    else
      uploaded_at = '1970-01-01 00:00:00'
    end
    return uploaded_at
  end
  
  #
  # Get timestamp string from changelog when this artwork was changed
  #
  def get_modified_at(artwork_id)
    query = %Q{
            SELECT timestamp
            FROM changelog
            WHERE object_type = 'artwork'
              AND action = ':EDIT'
              AND object = #{artwork_id}
    }
    if ts = $dbh_pg.execute(query).fetch
      modified_at = ts[0].to_s
    else
      modified_at = '1970-01-01 00:00:00'
    end
    return modified_at
  end
  
  def self.flush_logs
    Log.flush_log(@@report_name)
    Log.flush_log(@@log_name)
  end

  def self.write_report
    Log::write_log(@@report_name, "ArtworkDataPlugin:")
    Log::write_log(@@report_name, "\t#{@@totals[:parsed]} number of artworks parsed")
    Log::write_log(@@report_name, "\t#{@@totals[:scanned]} number of artwork data scanned")
    Log::write_log(@@report_name, "\t#{@@totals[:matched]} number of matches")
    Log::write_log(@@report_name, "\t#{@@totals[:files]} number of files (#{@@totals[:file_size] / 1024 / 1024} MB) to move")
    Log::write_log(@@report_name, "\t#{@@totals[:t_textdata]} number of text data (marked T)")
    Log::write_log(@@report_name, "\t#{@@totals[:nil_textdata]} number of text data (marked NIL)")
    Log::write_log(@@report_name, "\t#{@@totals[:t_textdata] + @@totals[:nil_textdata]} total number of text data matches")
    Log::write_log(@@report_name, "\t#{@@totals[:matched] - (@@totals[:files] + @@totals[:t_textdata] + @@totals[:nil_textdata] - @@totals[:screenshots])} number of unhandled matches")
    Log::write_log(@@report_name, "\t#{@@totals[:unmatched]} number of unmatched rows")
    Log::write_log(@@report_name, "\t#{@@totals[:textfiles]} number of text files created")
    Log::write_log(@@report_name, "\t#{@@totals[:screenshots]} number of screenshots")
    Log::write_log(@@report_name, "\tList of artwork files to move is saved to #{@@log_name}")
  end
end


#
# = Synopsis 
#
# Reaktoruser image plugin
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id: $
#

class ReaktoruserImagePlugin < Plugin
  
  attr_reader :report_name
  
  @@totals = {
    :parsed => 0, # Total number of rows parsed
    :files => 0, # Total number of files
    :file_size => 0, # Total size of files
  }
  @@log_name = 'reaktoruser_image_plugin'
  @@report_name = 'report'

  def self.report_name
    @@report_name
  end
  
  def self.log_name
    @@log_name
  end
  
  def initialize(attr_name, row)
    return if row.nil?
    @@totals[:parsed] += 1
    @result_column = IGNORE
    file = get_filename(row[attr_name])
    unless file.nil?
      Log.write_log(@@log_name, "#{file[:file_name]}")
      @@totals[:files] += 1
      @@totals[:file_size] += file[:file_size]
      @result_column = [ReaktorColumn.new({:name => :avatar, :value => file[:file_name]}),]
    end
  end
  
  #
  # Return the resulting ReaktorColumn object or IGNORE object
  #
  def each
    @result_column
  end
  
  #
  # Get the first filename from the image column
  # => data: Data from the image column
  #
  def get_filename(data)
    return nil unless data
    
    data.scan(/#\.\([^f]*(file::([^\s]+))*[^"]*"([^"]*)"\s*(:filesize\s*(\d+))*/m).each do |m|
      #
      # Set column values
      #
      file = {
        :mime_type => 'no-type',
        :file_name => 'no-filename',
        :file_size => 0,
      }
      file[:mime_type] = m[1] if m[1]
      file[:file_name] = m[2] if m[2]
      file[:file_size] = m[4].to_i if m[4]
     return file
    end
    return nil
  end
  
  def self.flush_logs
    Log.flush_log(@@log_name)
    Log.flush_log(@@report_name)
  end

  def self.write_report(report = @@report_name)
    Log.write_log(report, "ReaktoruserImagePlugin:")
    Log.write_log(report, "\t#{@@totals[:parsed]} number of image columns parsed")
    Log.write_log(report, "\t#{@@totals[:files]} number of images files (%.2f MB) to move" % (@@totals[:file_size] / 1024 / 1024.0))
    Log.write_log(report, "\tList of avatars to move is saved to #{@@log_name}.log")
  end

end

#
# = Synopsis 
# Configure a symfony installation
#
# = Authors
# * Robert Strind <robert@linpro.no>
#
# = Version
# $Id: $
#
require 'fileutils'

class Symfony
  def initialize(cnf)
    @path = cnf[:path_symfony]
    @db_name = cnf[:to_db_name]
    @db_user = cnf[:to_db_user]
    @db_password = cnf[:to_db_password]
    @debug = cnf[:debug]
  end
  
  #
  # Configure symfony configuration files
  #
  def configure
    configure_databases_yml
    configure_propel_ini
  end
  
  #
  # Perform a symfony clear cache
  #
  def cc
    Dir.chdir(@path) {@output = `symfony cc`}
    puts @output if @debug
  end
  
  #
  # Set file permissions
  #
  def set_permissions
    files = [
      'log', 'content', 'cache', 'web/uploads', 'web/images',
      'apps/reaktor/modules/subreaktors/templates',
      'apps/reaktor/lib/transcode/transcodevideo.sh',
      'apps/reaktor/lib/transcode/transcodeaudio.sh',
    ]
    files.map! {|f| @path + '/' + f}
    FileUtils.chmod_R 0777, files
    if @debug
       puts "Set permissions (0777) on following files/directories:"
       files.each {|f| puts "\t#{f}"}
    end
  end
  
  #
  # Configure the databases.yml file
  #
  def configure_databases_yml
    path = @path + '/config/databases.yml'
    unless File.readable?(path)
      raise "Could not configure databases.yml. File is not writable!"
    end
    fc = open(path).read
    path_backup = path + '.bak'
    unless File.exists?(path_backup)
      FileUtils::mv path, path_backup
      puts "Copied databases.yml to #{path_backup}" if @debug
    end
    fc.gsub!(/database:\s*.+/, "database: #{@db_name}")
    fc.gsub!(/username:\s*.+/, "username: #{@db_user}")
    fc.gsub!(/password:\s*.+/, "password: #{@db_password}")
    open(path, 'w').print fc
    puts "Configured databases.yml" if @debug
  end
  
  #
  # Configure the propel.ini file
  #
  def configure_propel_ini
    path = @path + '/config/propel.ini'
    unless File.readable?(path)
      raise "Could not configure databases.yml. File is not writable!"
    end
    fc = open(path).read
    path_backup = path + '.bak'
    unless File.exists?(path_backup)
      FileUtils::mv path, path_backup
      puts "Copied propel.ini to #{path_backup}" if @debug
    end
    fc.gsub!(/propel.database.createUrl\s*=\s*.+/, "propel.database.createUrl = mysql://#{@db_user}:#{@db_password}@localhost/")
    fc.gsub!(/propel.database.url\s*=\s*.+/, "propel.database.url = mysql://#{@db_user}:#{@db_password}@localhost/#{@db_name}")
    open(path, 'w').print fc
    puts "Configured propel.ini" if @debug
  end
  
end

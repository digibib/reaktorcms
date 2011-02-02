#!/usr/bin/env ruby
#
# = Synopsis 
#
# Used to write logs and reports
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id$
#

class Log
  
  @@log_directory = 'log'
  @@log = {}

  #
  # Set log path
  #
  def self.set_path(path)
    unless File.writable?(path)
      raise "Log path is not writable: #{path}"
    end
    @@log_directory = path
  end

  #
  # Write to a logfine
  # => name: Name of the log. Saved to name.log
  # => message: Message to write
  #
  def self.write_log(name, message)
    if @@log.empty?
      @@log[:log] = Log.new(:log)
    end
    unless @@log[name]
      @@log[name] = Log.new(name)
      @@log[:log].write("Created log: #{@@log[name].path}")
    end
    @@log[name].write(message)
  end

  #
  # Flushes a logfile
  # => name: Name of the logfile to flush
  #
  def self.flush_log(name)
    @@log[name].flush unless @@log[name].nil?
  end

  #
  # Check for existing log
  # => name: Name of the log to check for
  #
  def self.log_exist(name)
    if @@log_handle[name]
      return true
    else
      return nil
    end
  end
  
  #
  # Make a path from log name
  # => name: log name
  #
  def self.make_path(name)
    File.join(@@log_directory, "#{name}.log")
  end
  
  def self.make_regression_path(name)
    File.join(@@log_directory, "#{name}.regression")
  end
  
  #
  # Remove log file
  # => Log name
  #
  def self.remove(name)
    unless @@log[name].nil?
      @@log.delete(name).remove
    else
      path = self.make_path(name)
      File.unlink(path) if File.exist?(path)
    end
  end
  
  #
  # Test regression
  # => name: Name of the log to test
  #
  def self.test_regression(name)
    @@log[name].test_regression unless @@log[name].nil?
  end
  
  attr_reader :path
  
  def initialize(name)
    @name = name
    @path = Log.make_path(name)
    @handle = File.new(@path, 'w')
  end
  
  #
  # Write to log
  # => msg: Message to write
  #
  def write(msg)
    @handle.puts(msg)
  end
  
  #
  # Flush content to logfile
  #
  def flush
    @handle.flush
  end
  
  #
  # Remove logfile
  #
  def remove
    @handle.close
    File.unlink(@path)
  end
  
  def test_regression
    result = `diff #{Log.make_path(@name)} #{Log.make_regression_path(@name)}`
    unless result.empty?
      puts "Regression found in #{Log.make_path(@name)}:"
      puts result
      return true
    end
    return nil
  end
end

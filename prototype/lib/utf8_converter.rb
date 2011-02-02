# 
# To change this template, choose Tools | Templates
# and open the template in the editor.
 

class Utf8_Converter
  
  attr_reader :text
  
  @@map = {
    "\xC2\x96" => '-',
    "\xC2\x94" => '"',
    "\xC3\xA6" => 'æ',
    "\xC3\x86" => 'Æ',
    "\xC3\xB8" => 'ø',
    "\xC3\x98" => 'Ø',
    "\xC3\xA5" => 'å',
    "\xC3\x85" => 'Å',
  }
  def self.convert(text)
    @@map.each {|u,a| text.gsub!(u, a)}
    return text
  end
  
  def initialize(text)
    @text = self.convert(text)
  end
end

if __FILE__ == $0
  puts Utf8_Converter::convert("Hei dette er en \xC2\x96")
  puts Utf8_Converter::convert("Hei dette er en \xC3\x86")
end

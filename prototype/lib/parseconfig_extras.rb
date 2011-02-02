# 
# Add methods to the Parseconfig class
# 
# = Authors
# * Robert Strind <robert@linpro.no>
#

class ParseConfig
  
  #
  # Returns a hash containing all the instance variable values indexed
  # by its instance varaible name with the @ stripped off
  #
  def get_all
    vars = {}
    self.instance_variables.map do |v|
      vars[v[1..-1].to_sym] = self.instance_variable_get(v)
    end
    return vars
  end
end

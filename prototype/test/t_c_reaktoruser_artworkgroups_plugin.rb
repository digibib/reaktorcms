# 
# To change this template, choose Tools | Templates
# and open the template in the editor.
 

$:.unshift File.join(File.dirname(__FILE__),'..','plugins')
$:.unshift File.join(File.dirname(__FILE__),'..','lib')

require 'dbi'
require 'test/unit'
require 'reaktoruser_artworkgroups_plugin'

class TC_ReaktoruserArtworkgroupsPlugin < Test::Unit::TestCase
  
  def setup
    $dbh_pg = DBI.connect("dbi:Pg:reaktor:", "", "") unless $dbh_pg
    ReaktoruserArtworkgroupsPlugin::drop_db_table
  end
  
  def fact(n)
    if n == 0
      1
    else
      n * fact(n-1)
    end
  end
  
  def calc_permutations(items)
    return 0 if items < 2
    (fact(items) / fact(items - 2)) / 2
  end
  
  def test_import_data
    Log.remove(ReaktoruserArtworkgroupsPlugin.log_name)

    query = 'SELECT * FROM reaktoruser'
    sth = $dbh_pg.execute(query)

    while row = sth.fetch
      ReaktoruserArtworkgroupsPlugin.new('artwork_groups', row)
    end

    ReaktoruserArtworkgroupsPlugin.flush_logs
    Log.test_regression(ReaktoruserArtworkgroupsPlugin.log_name)
    ReaktoruserArtworkgroupsPlugin.write_report
  end
  
  def test_permutation_exists
    agp = ReaktoruserArtworkgroupsPlugin.new(:nothing, nil)
    agp.save_permutation(1, 2)
    assert(agp.permutation_exists(1, 2), "Wrong. Permutation 1, 2 does exist")
    assert(agp.permutation_exists(2, 1), "Wrong. Permutation 2, 1 does exist")
  end
  
  def test_parse_data
    data = "((920 908 922 924 926 910 934 914 912 928 916 904 906 918 930 932) (509 391 530 525 515 507 523 511 532 517 513) (607 605 609 662 613 615 617 622 619 611) (876 862 864 866 878 872 868 874 856 858 860 870) (970 978 976 972 996 994 998 980 982 992 988 974 968 984 986 990) (3822 3818 3820 3828 3830 3826) (3834 3832 3836 3838 3840 3842 3844 3846 3848 3850 3852 3854 3856 3858 3860 3862 3864 3866 3868 3870) (3811 3759 3771 3775 3767 3785 3769 3761 3773 3783 3787 3789 3791 3793 3795 3797 3799 3801 3803 3805 38073809 4166 4168) (3940 3938 3948 3977 3952 3975 3973 3971 3954 3969 3956 3967 3958 3965) (3983 3979 3981 3987 3985 3989 3991 3993 3995 3997 3999 4001 4003 4005 4012 4014 4088 4020 4104 4090 4102 4096 4098 4094 4092 4100) (4023 4025 4027 4029 4075 4073 4071 4053 4065 4069 4067 4063 4061 4059 4055 4057 4051 4045 4047 4049 4037 4041 4043 4035 4039 4033 4031) (8854 8856 8852 8850 8848 8846 8844 8842 8840 8838 8836 8834 8831 8825 8823 8821 8819 8817 8806 8803 8801 9910) (11247 11224 11245 11243 11241 11239 1123 11235 11233 11231 11229 11227 11254 11256) (12856 12858 12854 12850 12848 12846 12852))"
    attr_name = :data
    row = {:data => data}
    agp = ReaktoruserArtworkgroupsPlugin.new(attr_name, row)
    assert_equal(14, agp.result[0], "Wrong number of groups")
    assert_equal(224, agp.result[1], "Wrong number of artworks")
    assert_equal(1974, agp.result[2], "Wrong number of permutations")
  end
  
  def test_one_group
    data = "((920 908 922 924 926 910 934 914 912 928 916 904 906 918 930 932))"
    attr_name = :data
    row = {:data => data}
    agp = ReaktoruserArtworkgroupsPlugin.new(attr_name, row)
    assert_equal(1, agp.result[0], "Wrong number of groups")
    assert_equal(16, agp.result[1], "Wrong number of artworks")
    assert_equal(calc_permutations(16), agp.result[2], "Wrong number of permutations")
  end
  
  def test_no_group
    data = "(920 908 922 924 926 910 934 914 912 928 916 904 906 918 930 932)"
    attr_name = :data
    row = {:data => data}
    agp = ReaktoruserArtworkgroupsPlugin.new(attr_name, row)
    assert_equal(1, agp.result[0], "Wrong number of groups")
    assert_equal(16, agp.result[1], "Wrong number of artworks")
    assert_equal(calc_permutations(16), agp.result[2], "Wrong number of permutations")
  end
end

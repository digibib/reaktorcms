#!/usr/bin/env ruby
#
# = Synopsis 
#
# Describes the mapping between the schmaes of the prototype
# vs. reaktor
#
# = Authors
#
# - Kjell-Magne Oierud mailto:kjellm@linpro.no
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id: schema_map.rb 2579 2008-09-29 10:03:17Z robert $
#

=begin
Table overview:

    T article
    T article_formats
    T article_topics
[M] T artwork
    V artwork_by_day
[M] T artwork_formats
    T artwork_help_articles
[M] T artwork_topics
[D] T changelog
[M] T comment
    T comment_complaint
    V denied_works
    S id_seq
    V new_users
    V new_works
    T persdict
    T persmem
    V queued_works
[M] T rating
    T reaktor
[M] T reaktoruser
    T site
    V top20_users
[M] T topic
    T topic_shortlist
    V total_artworks
    V total_users
    T user_help

T = Table
V = View
S = Sequense
[M] = Migrated
[D] = Data used in migration
=end

$schema = []

############################### U S E R #######################################

$schema << PrototypeTableMap.new(:reaktoruser) do
  __id_store__ true
  __default_table__ :sf_guard_user # Default reaktor table to use

  __filter_rows__ <<EOF
CASE type
WHEN 'administrator' THEN
  false
WHEN 'editor' THEN
  name NOT IN ('Asgeir Bjørlykke', 'Copyleft Software AS', 'Ole-Petter Wikene', 'Stian Tyriberget', 'Test', 'Test2', 'Testbruker', 'Thomas Bakketun', 'testbruker', 'Anne-Lena Westrum')
  AND NOT (name = 'Mildrid Liasjø' AND disabled = true)
WHEN 'external' THEN
  (EXISTS    (SELECT * from comment   WHERE creator = reaktoruser.id)
   OR EXISTS (SELECT * from rating    WHERE reaktoruser = reaktoruser.id)
   OR EXISTS (SELECT * from artwork   WHERE creator = reaktoruser.id)
   OR EXISTS (SELECT * FROM changelog WHERE reaktoruser = reaktoruser.id AND action = ':LOGIN'))
  AND nick NOT IN ('asgeir', 'asgeirr', 'Betty', 'Boltorn', 'erdether', 'groa', 'Hufsa', 'Kerman', 'kolofon', 'leo', 'Oter', 'Silva', 'Spøkelseskladden', 'testpost', 'testvesenet', 'theger', 'torbman', 'trinew', 'varja240', 'venkeu', 'zebh', 'CillyBilly')
END
EOF

  _id       ReaktorColumn.new
  _name     ReaktorColumn.new
  _email    ReaktorColumn.new
  _password ReaktorColumn.new
  _salt     ReaktorColumn.new
  _year_of_birth  ReaktorColumn.new({
      :name => :dob,
      :filters => [Filter.mkdate_from_year],
  })
  _in_mailinglist ReaktorColumn.new({:name => :opt_in, :filers =>[
        Filter.boolean_to_integer
      ] })
  _site     ReaktorRow.new(
    :sf_guard_user_group,
    [
      ReaktorColumn.new({
          :name => :user_id,
          :value => '%id'
      }),
      ReaktorColumn.new({
          :name => :group_id,
          :value => '%_',
          :filters => [
            Filter.apply_map($domain_maps[:site_id__sf_guard_group_id]),
            Filter.default_if_null(2)
          ]
      })
    ]
  )
  _email_confirmed IGNORE
  _artwork_groups  ReaktoruserArtworkgroupsPlugin
  _type ReaktorRow.new(
    :sf_guard_user_group,
    [
      ReaktorColumn.new({
          :name => :user_id,
          :value  => '%id'
      }),
      ReaktorColumn.new({
          :name => :group_id,
          :value => '%_',
          :filters => [
            Filter.apply_map($domain_maps[:reaktoruser__type]),
            Filter.domain_value_to_id('sf_guard_group', 'name'),
          ]
      })
    ]
  )

  # Some user types use email as username. They are the only users
  # with no nick. 
  _nick ReaktorColumn.new({
     :name    => :username,
     :filters => [Filter.if_null([Filter.set_value('%email'),
                                  Filter.add_prefix('staff_'),
                                  Filter.truncate_from('@'),
                                  Filter.add_postfix('%site'),
                                  Filter.add_postfix('-'),
                                  Filter.add_postfix('%id'),
                                 ])]
                  
  })

  # Some booleans we need to invert ...
  _disabled ReaktorColumn.new({
    :name    => :is_active, 
    :filters => Filter.invert,
  })
  _public_name ReaktorColumn.new({
    :name    => :name_private,
    :filters => Filter.invert,
  })
  _public_email ReaktorColumn.new({
    :name    => :email_private,
    :filters => Filter.invert,
  })

  # There are no phone numbers in prototype ...
  _telephone ReaktorColumn.new({:name => :phone}) 

  _description ReaktorColumn.new({:filters => Filter.parse_richtext_simple})

  # Convert to ISO encoding
  _sex ReaktorColumn.new({
    :filters => [Filter.apply_map($domain_maps[:reaktoruser__sex]),
                 Filter.default_if_null(0) ]
  })

  _image ReaktorColumn.new({
      :name   => :avatar,
      :filters  => [
        Filter.get_filename_from_lisp,
      ]
  })

  # Our residence list should be equal to the values in the prototype
  _place_of_residence ReaktorColumn.new({
    :name    => :residence_id, 
    :filters => [Filter.domain_value_to_id('residence', 'name'), 
                 Filter.default_if_null(0)]
  })

  #
  # SET
  #
  __set__ [
    ReaktorColumn.new({:name => :is_super_admin, :value => false}), 
    ReaktorColumn.new({:name => :algorithm, :value => 'md5'}), 
    ReaktorColumn.new({
      :name => :created_at,
      :value => Query.new("SELECT timestamp FROM changelog WHERE object_type='reaktoruser' AND object = ? AND action = ':CREATE'"),
    }), 
    ReaktorColumn.new({
      :name => :last_login,
      :value => Query.new("SELECT MAX(timestamp) FROM changelog WHERE object_type='reaktoruser' AND object = ? AND action = ':LOGIN'"),
    }),
    ReaktorColumn.new({
      :name => :is_verified,
      :value => 1,
    }),
    ReaktorColumn.new({
      :name => :show_content,
      :value => 1,
    }),
    ReaktorColumn.new({
      :name => :need_profile_check,
      :value => 1,
    }),
    ReaktorColumn.new({
      :name => :dob_is_derived,
      :value => 1,
    }),
  ] 
end


############################# A R T W O R K ####################################

$schema << PrototypeTableMap.new(:artwork) do
  __id_store__ true
  __default_table__ :reaktor_artwork
#
# For å importere verk med id: 14370 legg tallet til i listen under slik:
# AND id NOT IN (11808, 11562, 6329, 6200, 6195, 7417, 6357, 6346, 14370)
#
# Se track ticket #351
#
  __filter_rows__ <<EOF
id NOT IN (
  SELECT id
  FROM artwork
  WHERE publish_state = ':denied'
  AND id NOT IN (11808, 11562, 6329, 6200, 6195, 7417, 6357, 6346)
)
EOF

  # Check that user has been imported before inserting
  __precondition__ %q{SELECT EXISTS(SELECT * FROM sf_guard_user WHERE id = %creator)}

  _id ReaktorColumn.new
  _type ReaktorColumn.new({
      :name     => :artwork_identifier,
      :filters  => [Filter.apply_map($domain_maps[:artwork__type])],
  })

  _data ArtworkDataPlugin
  
  _screenshot IGNORE # This one is handled together with the data column

  _creator ReaktorColumn.new({:name => :user_id})

  _title ReaktorColumn.new({
      :filters  => [
        Filter.replace('#', 'nr.'),
      ]
  })

  _description ReaktorColumn.new({
    :filters => [
      Filter.parse_artwork_description,
    ]
  })

  _keywords IGNORE
  _howto IGNORE # Taken care of in the ArtworkDataPlugin
  _help IGNORE # Taken care of in the ArtworkDataPlugin

  _editor IGNORE

  #### METADATA

  _rights IGNORE # Handled by ArtworkDataPlugin

  _width ReaktorRow.new(:file_metadata, [
    ReaktorColumn.new({:name => :file, :value => '%id'}), 
    ReaktorColumn.new({:name => :meta_element, :value => 'format'}), 
    ReaktorColumn.new({:name => :meta_qualifier, :value => 'width'}), 
    ReaktorColumn.new({:name => :meta_value, :value => '%_'}),
  ])

  _height ReaktorRow.new(:file_metadata, [
    ReaktorColumn.new({:name => :file, :value => '%id'}), 
    ReaktorColumn.new({:name => :meta_element, :value => 'format'}), 
    ReaktorColumn.new({:name => :meta_qualifier, :value => 'height'}), 
    ReaktorColumn.new({:name => :meta_value, :value => '%_'}),
  ])

  #### END METADATA 

  _site ReaktorColumn.new({
      :name => :team_id,
      :value => '%_',
      :filters => [
        Filter.get_value_from_query($dbh_pg, "SELECT LOWER(title) AS title FROM site WHERE id = ?"),
        Filter.default_if_null('users'),
        Filter.apply_map($domain_maps[:site_title__sf_guard_group_name]),
        Filter.get_value_from_query($dbh_ms, "SELECT id FROM sf_guard_group WHERE name = '?'"),
        Filter.default_if_null(2),
      ]
  })
  
  _publish_state ReaktorColumn.new({
    :name => :status,
    :filters => [
      Filter.apply_map($domain_maps[:artwork__publish_state]),
      Filter.domain_value_to_id('artwork_status', 'name'), # Get id from artwork_status
    ]
  }) 
  _under_discussion ReaktorColumn.new({:filters => [Filter.boolean_to_integer]})

  _internal_discussion ArtworkInternalDiscussionPlugin


  #
  # SET
  #
  __set__ [ 
    #
    # Created at
    #
    ReaktorColumn.new({
        :name => :created_at,
        :value => Query.new("SELECT timestamp FROM changelog WHERE action = ':CREATE' AND object = ?"),
        :filters  => [
          Filter.truncate(19, ''),
        ]
    }),
    #
    # Actioned at
    #
    ReaktorColumn.new({
        :name     => :actioned_at,
        :value    => Query.new("SELECT timestamp FROM changelog WHERE action = ':ACCEPT' AND object = ?"),
        :filters  => [
          Filter.if_null([
              Filter.get_value_from_query($dbh_pg, %Q{SELECT timestamp FROM changelog WHERE action = ':CREATE' AND object = %id}),
          ]),
          Filter.truncate(19, ''),
        ]
    }),
    #
    # Submitted at
    #
    ReaktorColumn.new({
        :name => :submitted_at,
        :value => Query.new("SELECT timestamp FROM changelog WHERE action = ':CREATE' AND object = ?"),
        :filters  => [
          Filter.truncate(19, ''),
        ]
    }),
    #
    # Actioned by
    #
    ReaktorColumn.new({ 
      :name => :actioned_by,
      :value => Query.new("SELECT reaktoruser FROM changelog WHERE action = ':ACCEPT' AND object_type = 'artwork' AND object = ?"),
      :filters => Filter.default_if_null(0),
    }),
    #
    # Average rating
    #
    ReaktorColumn.new({
        :name => :average_rating,
        :value => Query.new("SELECT AVG(rating) FROM rating WHERE artwork = ?"),
    }),
  ]
end



##################### A R T W O R K   R A T I N G S  ##########################

$schema << PrototypeTableMap.new(:rating) do
  __default_table__ :sf_ratings

  # Check that artwork has been imported before inserting
  __precondition__ %q{SELECT EXISTS(SELECT * FROM reaktor_artwork WHERE id = %artwork)}

  _reaktoruser ReaktorColumn.new({:name => :user_id})
  _artwork     ReaktorColumn.new({:name => :ratable_id})

  # The scale for rating seems to be 1..6 in both version -> no
  # conversion needed :)
  _rating      ReaktorColumn.new()

  __set__ [
    ReaktorColumn.new({:name => :ratable_model, :value => 'ReaktorArtwork'}),
    ReaktorColumn.new({:name => :rated_at, :value => '2008-10-01'}),
    ]
end



#################### A R T W O R K   C O M M E N T S  #########################

$schema << PrototypeTableMap.new(:comment) do
  __default_table__ :sf_comment
  # Check that user and artwork has been imported
  __precondition__ %q{
    SELECT (
      EXISTS(SELECT * FROM sf_guard_user WHERE id = %creator)
      AND
      EXISTS(SELECT * FROM reaktor_artwork WHERE id = %artwork)
    )
  }
  __query__ <<EOF
SELECT DISTINCT comment.*
FROM comment
LEFT JOIN comment_complaint ON (comment.id = comment_complaint.comment)
WHERE comment_complaint.state IS NULL OR comment_complaint.state = ':denied';
EOF

  _id      ReaktorColumn.new
  _parent  ReaktorColumn.new({:name => :parent_id})
  _creator ReaktorColumn.new({:name => :author_id})
  _artwork ReaktorColumn.new({:name => :commentable_id})
  _hidden  ReaktorColumn.new({:name => :unsuitable})
  _subject ReaktorColumn.new({:name => :title})
  _body    ReaktorColumn.new({
      :name => :text,
      :filters => [Filter.trim_lisp_encl_params],
  })

  __set__ [
           ReaktorColumn.new({:name => :commentable_model, :value => 'ReaktorArtwork'}),
           ReaktorColumn.new({:name => :namespace, :value => 'frontend'}),
           ReaktorColumn.new({
               :name    => :created_at,
               :value   => Query.new("SELECT MAX(timestamp) FROM changelog WHERE object_type='comment' AND object = ?"),
           })
          ]
end

#################### S U B R E A K T O R #########################
=begin Subreaktors are imported in fixtures
$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :subreaktor
  __filter_rows__ 'parent = 2'
  
  _id                 ReaktorColumn.new
  _parent             IGNORE
  _title              ReaktorColumn.new({
    :name => :reference,
    :value => '%_',
    :filters => [
      Filter.downcase(), # reference must be lower case
      Filter.truncate(15, '') # reference is a VARCHAR(15)
    ]
  })
  _description        IGNORE
  _independant_title  IGNORE
  
  __set__ [
    ReaktorColumn.new({:name => :lokalreaktor, :value => 0}),
    ReaktorColumn.new({:name => :live, :value => 1}),
    ReaktorColumn.new({:name => :subreaktor_order, :value => 0}),
  ]
end
=end

#################### C A T E G O R Y #########################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :category

  __precondition__ %q{
    SELECT NOT EXISTS(
      SELECT *
      FROM category
      WHERE basename = LOWER('%title')
    )
  }

  __query__ <<EOF
SELECT id, title
FROM connectby('topic', 'id', 'parent', '2', 0)
AS t(id2 text, parent2 text, level int)
LEFT OUTER JOIN topic ON (cast(t.id2 as integer) = topic.id)
WHERE id > 2
EOF
  
  _id                 ReaktorColumn.new
  _title              ReaktorColumn.new({
    :name => :basename,
    :value => '%_',
    :filters => [
      Filter.downcase(), # basename must be lower case
    ]
  })
end

#################### C A T E G O R Y   I 1 8 N (no) #######################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :category_i18n

  # Don't import categories that allready exists
  __precondition__ %q{
    SELECT EXISTS(
      SELECT *
      FROM category
      WHERE basename = '%title'
    )
  }

  __query__ <<EOF
SELECT id, title
FROM connectby('topic', 'id', 'parent', '2', 0)
AS t(id2 text, parent2 text, level int)
LEFT OUTER JOIN topic ON (cast(t.id2 as integer) = topic.id)
WHERE id > 2 AND parent > 2
EOF
  
  _id                 ReaktorColumn.new
  _title              ReaktorColumn.new({
    :name => :name,
    :value => '%_',
    :filters => [
      Filter.downcase(), # basename must be lower case
    ]
  })

  __set__ [
    ReaktorColumn.new({
        :name   => :culture,
        :value  => 'no',
    })
  ]
end

#################### C A T E G O R Y   I 1 8 N (nn) #######################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :category_i18n

  # Don't import categories that allready exists
  __precondition__ %q{
    SELECT EXISTS(
      SELECT *
      FROM category
      WHERE basename = '%title'
    )
  }

  __query__ <<EOF
SELECT id, title
FROM connectby('topic', 'id', 'parent', '2', 0)
AS t(id2 text, parent2 text, level int)
LEFT OUTER JOIN topic ON (cast(t.id2 as integer) = topic.id)
WHERE id > 2 AND parent > 2
EOF
  
  _id                 ReaktorColumn.new
  _title              ReaktorColumn.new({
    :name => :name,
    :value => '%_',
    :filters => [
      Filter.downcase(), # basename must be lower case
      Filter.truncate(25, ''), # basename is a VARCHAR(25)
    ]
  })

  __set__ [
    ReaktorColumn.new({
        :name   => :culture,
        :value  => 'nn',
    })
  ]
end

#################### C A T E G O R Y   I 1 8 N (en) #######################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :category_i18n

  # Don't import categories that allready exists
  __precondition__ %q{
    SELECT EXISTS(
      SELECT *
      FROM category
      WHERE basename = '%title'
    )
  }

  __query__ <<EOF
SELECT id, title
FROM connectby('topic', 'id', 'parent', '2', 0)
AS t(id2 text, parent2 text, level int)
LEFT OUTER JOIN topic ON (cast(t.id2 as integer) = topic.id)
WHERE id > 2 AND parent > 2
EOF
  
  _id                 ReaktorColumn.new
  _title              ReaktorColumn.new({
    :name => :name,
    :value => '%_',
    :filters => [
      Filter.downcase(), # basename must be lower case
      Filter.truncate(25, ''), # basename is a VARCHAR(25)
    ]
  })

  __set__ [
    ReaktorColumn.new({
        :name   => :culture,
        :value  => 'en',
    })
  ]
end

#################### T A G #########################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :tag
  __query__ <<EOF
SELECT id, title
FROM connectby('topic', 'id', 'parent', '1', 0)
AS t(id2 text, parent2 text, level int)
LEFT OUTER JOIN topic ON (cast(t.id2 as integer) = topic.id)
WHERE id > 1
EOF
  
  _id     ReaktorColumn.new
  _title  ReaktorColumn.new({
            :name => :name,
            :value => '%_',
            :filters => [Filter.downcase()]
          })
  
  __set__ [
    ReaktorColumn.new({:name => :approved, :value => 1}),
    ReaktorColumn.new({:name => :approved_by, :value => 0}),
    ReaktorColumn.new({:name => :approved_at, :value => '1970-01-01 00:00:00'}),
    ReaktorColumn.new({
        :name => :width,
        :value => '%title',
        :filters => [Filter.string_length()]
    }),
  ]
end

#################### C A T E G O R Y   A R T W O R K #######################

$schema << PrototypeTableMap.new(:artwork_formats) do
  __default_table__ :category_artwork
  __
  __precondition__ %q{SELECT EXISTS(
                        SELECT *
                        FROM reaktor_artwork
                        WHERE id = %artwork
                    )}
  
  _artwork  ReaktorColumn.new({
    :name   => :artwork_id,
    :value  => '%_',
  })
  _topic    ReaktorColumn.new({
    :name   => :category_id,
    :value  => '%_',
    :filters  => [
      Filter.get_value_from_query($dbh_pg, %q{SELECT lower(title) FROM topic WHERE id = %_}),
      Filter.get_value_from_query($dbh_ms, %q{SELECT id FROM category WHERE basename = '?'}),
      Filter.default_if_null('%topic'),
    ]
  })
end

######################### T A G G I N G ##########################

$schema << PrototypeTableMap.new(:artwork_topics) do
  #__default_table__ :tagging # This is handled by the ArtworkTopicTaggingPlugin
  
  # Select only artworks that have a tag set
  __precondition__ %q{SELECT (
                      EXISTS (SELECT * FROM tag WHERE id = %topic)
                      AND
                      EXISTS (SELECT * FROM reaktor_artwork WHERE id = %artwork)
                    )}
  
  _artwork  ArtworkTopicTaggingPlugin
  
  _topic    IGNORE # Handled by the ArtworkTopicTaggingPlugin
end

#################### S U B R E A K T O R   A R T W O R K #####################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :subreaktor_artwork

  __query__ <<EOF
SELECT (cast(keyid as Integer)) AS subreaktor_id, artwork_formats.artwork AS artwork_id
FROM connectby('topic', 'id', 'parent', '2', 0)
AS t(relname TEXT, keyid TEXT, level INT)
LEFT JOIN artwork_formats ON (cast(t.relname as INTEGER)) = artwork_formats.topic
WHERE artwork_formats.artwork IS NOT NULL AND (cast(keyid as Integer)) <> 2
EOF

  __precondition__ %q{
    SELECT EXISTS (
      SELECT * FROM reaktor_artwork WHERE id = %artwork_id
    )
  }

  _subreaktor_id  ReaktorColumn.new({
      :filters  => [
        Filter.apply_map($domain_maps[:topic_id__subreaktor_id]),
      ]
  })
  
  _artwork_id   ReaktorColumn.new
end

################# C A T E G O R Y   S U B R E A K T O R ######################

$schema << PrototypeTableMap.new(:topic) do
  __default_table__ :category_subreaktor

  __query__ <<EOF
SELECT DISTINCT (cast(keyid as Integer)) AS subreaktor_id, artwork_formats.topic AS category_id
FROM connectby('topic', 'id', 'parent', '2', 0)
AS t(relname TEXT, keyid TEXT, level INT)
LEFT JOIN artwork_formats ON (CAST(t.relname as INTEGER)) = artwork_formats.topic
WHERE artwork_formats.topic IS NOT NULL AND (CAST(keyid as Integer)) <> 2
EOF

  __precondition__ %q{
    SELECT EXISTS (
      SELECT * FROM category WHERE id = %category_id
    )
  }
  
  _subreaktor_id  ReaktorColumn.new({
      :filters  => [
        Filter.apply_map($domain_maps[:topic_id__subreaktor_id]),
      ]
  })
  _category_id    ReaktorColumn.new({
    :filters  => [
      Filter.get_value_from_query($dbh_pg, "SELECT lower(title) FROM topic WHERE id = %category_id"),
      Filter.get_value_from_query($dbh_ms, "SELECT id FROM category WHERE basename = '?'"),
      Filter.default_if_null('%_'),
    ],
  })
end

###############################################################################
###################### E N D   O F   S C H E M A   M A P ######################
###############################################################################

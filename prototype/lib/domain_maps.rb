#
# = Synopsis 
#
# Domain maps
# Used to convert strings of data from prototype convension to reaktor convenseion
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

$domain_maps = {
  :artwork__rights => {
    ':contactme'   => 'contact',
    ':educational' => 'non_commersial',
    ':free'        => 'free_use',
    ':none'        => 'no_allow',
  },

  :artwork__publish_state => {
    ':accepted'   => 'Approved',
    ':denied'     => 'Rejected',
    ':queued'     => 'Ready for approval',
  },

  :reaktoruser__sex => {
    'm' => 1,
    'f' => 2,
  },
  
  :artwork__mime_type_to_identifier => {
    'image-jpeg'      => :image,
    'video-asf'       => :video,
    'document-pdf'    => :pdf,
    'video-mp4'       => :video,
    'sound-mp3'       => :audio,
    'image-gif'       => :image,
    'flash'           => :flash_animation,
    'video-quicktime' => :video,
    'image-png'       => :image,
    'sound-midi'      => :audio,
    'file'            => :video, # Only on occurence of a mp4-file
  },
  
  :artwork__mime_type => {
    "image-jpeg"      => "image/jpeg",
    #"video-asf"       => "video/x-ms-asf",
    "video-asf"       => "video/flv", # FIX
    "document-pdf"    => "application/pdf",
    "video-mp4"       => "video/mp4",
    "sound-mp3"       => "audio/mpeg",
    "image-gif"       => "image/gif",
    "video-quicktime" => "video/quicktime",
    "image-png"       => "image/png",
    "sound-midi"      => "audio/midi",
    "flash"           => {
      "flv"           => "video/flv",
      "swf"           => "application/x-shockwave-flash",
    },
    "file"            => "video/mp4",
  },
  
  :artwork__type      => {
    'files'           => 'files',
    'flash'           => 'flash',
    'image'           => 'image',
    'images'          => 'images',
    'pdf'             => 'pdf',
    'sound'           => 'audio',
    'text'            => 'text',
    'video'           => 'video',
  },
  
  :reaktoruser__type => {
    "administrator"   => "admin",
    "editor"          => "staff",
    "external"        => "users",
  },
  
  #
  # Maps site::id and sf_guard_group::id
  #
  :site_id__sf_guard_group_id => {
    3960  => 10,  # musikk_redaksjon
    393   => 8,   # serieteket_redaksjon
    4421  => 11,  # konkurranse_redaksjon
    4     => 7,   # deichman_redaksjon
    1397  => 9,   # trondheim_redaksjon
    nil   => 2,   # When there's no site_id
  },
  #
  # Map site::title to sf_guard_group::name
  # 
  :site_title__sf_guard_group_name => {
    'musikk'      => 'musikk_redaksjon',
    'serieteket'  => 'serieteket_redaksjon',
    'konkurranse' => 'konkurranse_redaksjon',
    'deichman'    => 'deichman_redaksjon',
    'trondheim'   => 'trondheim_redaksjon',
    'users'       => 'users',
  },
  #
  # Maps topic::id and subreaktor::id
  #
  :topic_id__subreaktor_id => {
    80    => 1, # foto
    398   => 2, # tegning
    4380  => 3, # film
    738   => 4, # lyd
    321   => 5, # tegneserier
    311   => 6, # tekst
    4926  => 6, # Dikt
    338   => 3, # Dataanimasjon
    740   => 4, # Intervjuer
    
  },
  
  :artwork_identifier__subreaktor_reference => {
    'image'   => 1,
    'text'    => 6,
    'flash'   => 3,
    'audio'   => 4,
    'video'   => 3,
    'pdf'     => 6,
    'images'  => 1,
    'files'   => 6,
  }
}

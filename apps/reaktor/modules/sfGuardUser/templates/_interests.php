    <ul class="sf_admin_checklist">

<?php
$subReaktors=SubreaktorPeer::getAllReaktors(false,true);

$userInterestsArr=array();
foreach( $sf_guard_user->getUserInterests() as $userInterests)
        $userInterestsArr[]=$userInterests->getSubreaktorId();

foreach($subReaktors as $reaktor) {
    echo '<li>';
    echo '<input '.(in_array($reaktor->getId(),$userInterestsArr)? 'checked' : '').'  type="checkbox" value="'.$reaktor->getId().'" id="associated_interests_'.$reaktor->getId().'" name="associated_interests[]"/><label for="associated_interests_1">'.$reaktor.'</label> ';
    echo '</li>';
}

?>
    </ul>

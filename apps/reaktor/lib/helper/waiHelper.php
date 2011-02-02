<?php
/**
 * Wrapper for symfonys label_for
 *
 * The only difference is that we automatically create the title tags,
 * from the text input, if none given
 * 
 * @see label_for
 * @param mixed $id 
 * @param mixed $label 
 * @param array $options 
 * @return label_for
 */
function wai_label_for($id, $label, $options = array())
{
	if (!isset($options["title"]))
	{
		$options["title"] = $label;
	}
	return label_for($id, $label, $options);
}


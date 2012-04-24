<?php
	$min = $vars['entity']->minlength;
	if (!$min) $min = (int) 6; //set the default

	$strengh = "no";
	if ($vars['entity']->strengh)
		$strengh = $vars['entity']->strengh;
		
	$days = (int) 60;
	if ($vars['entity']->dayslong)
		$days = $vars['entity']->dayslong;

?>
<p>
	<?php echo elgg_echo('passwordchange:length'); ?>
	
	<?php echo elgg_view('input/text', array('internalname' => 'params[minlength]', 'value' => $min)); ?>
</p>
<p>
	<?php echo elgg_echo('passwordchange:dayslong');?>

	<?php echo elgg_view('input/text', array('internalname' => 'params[dayslong]', 'value' => $days)); ?>
</p>
<p><span><?php echo elgg_echo('passwordchange:strengh'); ?></span>
	<?php echo elgg_view('input/radio', array('internalname' => 'params[strengh]','class' => ' ', 'value' => $strengh, 'options' => array("yes","no"))); ?>
</p>
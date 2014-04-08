<?php
$Satellite = new Satellite;
$portrait = $this->get_option('Portrait');
$optionsArray = array(
array(  "name"      => "Width",
        "desc"      => "How wide will your people images be in pixels?",
        "id"        => "width",
        "type"      => "text",
        "value"     => $portrait['width'],
        "std"       => "160"),
array(  "name"      => "Height",
        "desc"      => "How high will your people images be in pixels?",
        "id"        => "height",
        "type"      => "text",
        "value"     => $portrait['height'],
        "std"       => "180"),
array(  "name"      => "Visual Cropping",
        "desc"      => "Would you like to allow visual cropping so your images are always flush to the border?",
        "id"        => "crop",
        "type"      => "checkbox",
        "value"     => $portrait['crop'],
        "std"       => true),
array(  "name"      => "Twitter Bootstrap Styling",
        "desc"      => "Would you like to enable css classes for enhanced mobile styling? This only works when bootstrap is enqueued.",
        "id"        => "bootstrap",
        "type"      => "checkbox",
        "value"     => $portrait['bootstrap'],
        "std"       => true),

    );
?>
<table class="form-table">
	<tbody>
    <?php $Satellite->Form->display($optionsArray, $this->pre . 'Portrait'); ?>
    </tbody>
</table>
<?php

$Satellite = new Satellite();
$portrait = $this->get_option('Portrait');
$crop = $portrait['crop'];
$cssClass = "";
$cssWidth = "width";
if (isset($portrait['bootstrap']) && $portrait['bootstrap']) {
    $cssClass = "col-md-3 col-sm-4 col-xs-6";
    $cssWidth = "max-width";
}

if (!empty($slides)) : ?>
  <div id="portrait-slider">
    <?php foreach($slides as $slide):
    $imagelink = $Satellite->Html->image_url($slide->image);
    list($imagelink,$width,$height) = $Satellite->Image->getImageData($ID,$slide,false,$slide->source);

    $size = $Satellite->Image->imageStretchStyles($width, $height, $portrait['width'], $portrait['height'], $crop);
    $position = "absoluteCenter stretchCenter " .$size;
    ?>
    <div class="portrait-container" style="width: <?php echo(intval($portrait['width']+5));?>px">
        <div class="portrait-slide <?php echo($cssClass);?>" style="<?php echo ($cssWidth);?>: <?php echo($portrait['width']);?>px;height: <?php echo($portrait['height']);?>px">
            <img class="<?php echo($position);?>"src="<?php echo $imagelink; ?>"
                  alt="<?php echo $slide->title; ?>" />
                <span class="prt-caption scale-caption">
                    <p><?php echo $slide->description; ?></p>
                </span>

        </div>
        <p class="prt-person"><?php echo $slide->title; ?></p>

        <p class="prt-position">
            <?php if (isset($slide->alt_text)) {
                echo $slide->alt_text;
            } else { echo ('&nbsp;');}?>
            </p>
    </div>

    <?php endforeach;?>
  </div>
<div class="clearfix"></div>
    
<?php endif;
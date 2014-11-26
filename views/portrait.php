<?php

$Satellite = new Satellite();
$portrait = $this->get_option('Portrait');
$crop = $portrait['crop'];
$cssClass = "";
$containCSS = "";
$cssWidth = "width";
if (isset($portrait['bootstrap']) && $portrait['bootstrap']) {
    $cssClass = $portrait['bootstrap-css'];
    $cssWidth = "max-width";
    $containCSS = "row";
}

if (!empty($slides)) : 
  $Satellite->Gallery->loadData($slides[0]->section);
  /** Font Size is set on the Gallery **/
  $fontSize = $Satellite->Gallery->data->font;

  ?>
  <div id="portrait-slider">
    <?php foreach($slides as $slide):
      
//    $imagelink = $Satellite->Html->image_url($slide->image);
    list($slide->img_url,$width,$height) = $Satellite->Image->getImageData($slide->id,$slide,false,$Satellite->Gallery->data->source);

    $size = $Satellite->Image->imageStretchStyles($width, $height, $portrait['width'], $portrait['height'], $crop);
    $position = "absoluteCenter stretchCenter " .$size;
    ?>
    <div class="portrait-container <?php echo($cssClass);?>" style="<?php echo ($cssWidth);?>: <?php echo($portrait['width']);?>px;height: <?php echo($portrait['height']);?>px">
        <div class="portrait-slide">
            <img class="<?php echo($position);?>"src="<?php echo $slide->img_url; ?>"
                  alt="<?php echo $slide->title; ?>" />
                <span class="prt-caption scale-caption size-<?php echo $fontSize;?>">
                    <p><?php echo $slide->description; ?></p>
                </span>

        </div>
        <p class="prt-person size-<?php echo $fontSize;?>"><?php echo $slide->title; ?></p>

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
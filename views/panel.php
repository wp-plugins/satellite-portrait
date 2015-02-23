<?php

$Satellite = new Satellite();
$panel_cfg = $this->get_option('Panel');
$image_cfg = $this->get_option('Images');
$crop = $panel_cfg['crop'];
$cssClass = "";
$cssWidth = "width";
if (isset($panel_cfg['bootstrap']) && $panel_cfg['bootstrap']) {
    $cssClass = $panel_cfg['bootstrap-css'];
    $cssWidth = "max-width";
    $containCSS = "row";
}

if (!empty($slides)) : 
  $Satellite->Gallery->loadData($slides[0]->section);
  $fontSize = $Satellite->Gallery->data->font;
  ?>
  <div id="portrait-slider">
    <?php foreach($slides as $slide):
//    $imagelink = $Satellite->Html->image_url($slide->image);
    list($slide->img_url,$width,$height) = $Satellite->Image->getImageData($slide->id,$slide,false,$Satellite->Gallery->data->source);

    $size = $Satellite->Image->imageStretchStyles($width, $height, $panel_cfg['width'], $panel_cfg['height'], $crop);
    $position = "absoluteCenter stretchCenter " .$size;
    ?>
    <div class="portrait-container <?php echo($cssClass);?>" style="<?php echo ($cssWidth);?>: <?php echo($panel_cfg['width']);?>px;height: <?php echo($panel_cfg['height']);?>px">
      <a href ="<?php echo($slide->link);?>" class="portrait-slide col-xs-12" 
           style="<?php echo ($cssWidth);?>: <?php echo($panel_cfg['width']);?>px;
                  height: <?php echo($panel_cfg['height']);?>px;
                  background-image: url('<?php echo $slide->img_url; ?>');
                  ">
        <div class="panel-info">
          <h2 class="size-<?php echo $fontSize;?>"><?php echo $slide->title; ?></h2>
          <p class="panel-description">
              <?php echo $slide->description; ?>
          </p>
        </div>

      </a>
    </div>

    <?php endforeach;?>
  </div>
<div class="clearfix"></div>
    
<?php endif;
<?php

$Satellite = new Satellite();
$portrait = $this->get_option('Panel');
$crop = $portrait['crop'];
$cssClass = "";
$cssWidth = "width";
if (isset($portrait['bootstrap']) && $portrait['bootstrap']) {
    $cssClass = "col-sm-6 col-xs-12";
    $cssWidth = "max-width";
}

if (!empty($slides)) : 
  $Satellite->Gallery->loadData($slides[0]->section);
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
      <a href ="<?php echo($slide->link);?>" class="portrait-slide col-xs-12" 
           style="<?php echo ($cssWidth);?>: <?php echo($portrait['width']);?>px;
                  height: <?php echo($portrait['height']);?>px;
                  background-image: url('<?php echo $slide->img_url; ?>');
                  ">
        <div class="upcoming-col">
          <h4 class="white-wrap">Upcoming Collections</h4>
        </div>
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
<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;


$images             = $params->get('sliderimages');
$perSlide           = (int) $params->get('perSlide', 5);
$wbc_control__color = $params->get('controlcolor', 'carousel-dark');
$cssperSlide        = 100 / max(1, $perSlide);

if (is_object($images)) {
    $images = (array) $images;
}

$chunks = array_chunk($images, $perSlide);
$totalSlides = count($chunks);

// Bootstrap Carousel einbinden
HTMLHelper::_('bootstrap.carousel');

$doc = Factory::getDocument();
$wa = $doc->getWebAssetManager();
$wa->registerAndUseStyle('mod_logoslider.style', 'media/mod_wbcbasicslider/css/style.css');
$carouselId =  'imageCarousel' . $module->id;
// Inline-Script für Carousel-Steuerung
$wa->addInlineScript(
    'document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.querySelector("#' . $carouselId . '");
        const slides = carousel.querySelectorAll(".carousel-item");

        if (carousel) {
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel, { interval: 7000 });
            carousel.addEventListener("click", function () {
                bsCarousel.pause();
            });
        }
        // Initial setzen: nur die aktive Folie sichtbar
        slides.forEach(slide => {
          if (slide.classList.contains("active")) {
            slide.setAttribute("aria-hidden", "false");
          } else {
            slide.setAttribute("aria-hidden", "true");
          }
        });
        // Event: Slide wechselt
        carousel.addEventListener("slid.bs.carousel", function () {
          slides.forEach(slide => {
            slide.setAttribute("aria-hidden", slide.classList.contains("active") ? "false" : "true");
          });
        });

    });',
    ['bootstrap.bundle'],
    []
);

?>
<div id="<?php echo $carouselId ?>"
      class="carousel <?php echo $wbc_control__color; ?> slide wbc-basicslider"
      data-bs-ride="carousel"
      role="region"
      aria-roledescription="carousel"
      aria-label="<?php echo Text::_('MOD_WBCBASICSLIDER') ?>"
      aria-live="polite">

  <div class="carousel-inner">
    <?php foreach ($chunks as $i => $chunk): ?>
      <div class="carousel-item <?php echo $i === 0 ? 'active' : '' ?>"
            role="group"
            aria-roledescription="<?= Text::_('MOD_WBCBASICSLIDER_CAROUSEL_CONTAINER') ?>" 
            aria-label="<?php echo ($i+1) ?> von<?php echo $totalSlides ?>" 
            style="--wbc-per-slide:<?php echo $cssperSlide ?>%;">
        <div class="d-flex justify-content-center flex-wrap">
          <?php foreach ($chunk as $image): ?>
            
            <?php $link = ''; ?>
            <?php $target = ''; ?>
            <?php $rel = ''; ?>

            <?php if (!empty($image->slide_link_intern)){ ?>
              <?php $link = $image->slide_link_intern; ?> 
            <?php } else { ?>
              <?php if (!empty($image->slide_link_extern )) { ?>
              <?php $link = $image->slide_link_extern; ?>
              <?php $target = ' target="_blank"'; ?>
              <?php $rel = ' rel="noopener"'; ?>   
              <?php } ?>
            <?php }?>

            <?php $src      = isset($image->slide_image) && !is_array($image->slide_image) ? (string) $image->slide_image : ''; ?>
            <?php $alt      = isset($image->slide_alt) && !is_array($image->slide_alt) ? (string) $image->slide_alt : ''; ?>
            <?php $alt      = trim($alt); ?>
            <?php $caption  = isset($image->slide_caption) && !is_array($image->slide_caption) ? trim((string)$image->slide_caption) : ''; ?>   

            <div class="image-box text-center p-3 wbcslider-content">
              <?php if (!empty($link)): ?>
                <a href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8') ?>" class="wbcslider-link"<?php echo $target ?><?php echo $rel ?>>
                  <?php echo  HTMLHelper::_('image', $src, $alt, ['class' => 'img-fluid', 'loading' => 'lazy', 'width' => '400', 'height' => '200']) ?>
                </a>
              <?php else: ?>
                  <?php echo  HTMLHelper::_('image', $src, $alt, ['class' => 'img-fluid', 'loading' => 'lazy', 'width' => '400', 'height' => '200']) ?>
              <?php endif; ?>
            </div>

          <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div role="group" aria-label="<?php echo Text::_('MOD_WBCBASICSLIDER_CAROUSEL_CONTROLS') ?>"<?php echo $totalSlides === 1 ? ' style="display:none;"' : '' ?>>
    <button class="carousel-control-prev" type="button"
      data-bs-target="#imageCarousel<?= $module->id ?>" data-bs-slide="prev"
      aria-label="<?php echo Text::_('MOD_WBCBASICSLIDER_PREV_SET') ?>">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>

    <button class="carousel-control-next" type="button"
      data-bs-target="#imageCarousel<?= $module->id ?>" data-bs-slide="next"
      aria-label="<?php echo Text::_('MOD_WBCBASICSLIDER_NEXT_SET') ?>">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>

    <div class="carousel-indicators">
      <?php foreach ($chunks as $i => $_): ?>
    <button type="button"
      data-bs-target="#imageCarousel<?= $module->id ?>"
      data-bs-slide-to="<?= $i ?>"
     <?php echo $i === 0 ? 'class="active" aria-current="true"' : '' ?>
      aria-label="<?php echo Text::sprintf('MOD_WBCBASICSLIDER_INDICATOR', $i+1) ?>"></button>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include 'config.php'; ?>

<style>
* {
  box-sizing: border-box;
}

.slide-container img {
  vertical-align: middle;
}

.slide-container {
  position: relative;
}

.imageSlide {
  display: none;
}

.imageSlide img {
    object-fit: cover;
}

.imageSlide img.wide {
    max-width: 100%;
    max-height: <?php echo Config\SlideShow::maxSlideHeight?>;
    height: auto;
}
.imageSlide img.tall {
    max-height: <?php echo Config\SlideShow::maxSlideHeight?>;
    max-width: 100%;
    width: auto;
}

.slide-container .cursor {
  cursor: pointer;
}

.slide-container .prev,
.slide-container .next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
  <?php if (!Config\SlideShow::showNextPreview) { ?>
  display: none;
  <?php } ?>
}

.slide-container .next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

.slide-container .prev:hover,
.slide-container .next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

.slide-container .numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

.slide-container .caption-container {
  text-align: center;
  height: 24px;
  background-color: #121212;
  <?php if (!Config\SlideShow::showCaption) { ?>
  display: none;
  <?php } ?>
}

.slide-container .slides-row {
  <?php if (!Config\SlideShow::showThumbs) { ?>
  display: none;
  <?php } ?>
}

.slide-container .slides-row:after {
  content: "";
  display: table;
  clear: both;
}

.slide-container .column {
  float: left;
  width: 25%;
}

.slide-container .thumbs {
  opacity: 0.6;
}

.slide-container .active,
.slide-container .thumbs:hover {
  opacity: 1;
}
</style>

<div class="slide-container">
<?php
// load data from db
$query = "SELECT sort, imageName, caption FROM mod_slideshow ORDER BY sort ASC";
$result = $webDB->runQuery($query);

if (!$result)
    echo 'ERROR!';

$count = 1;
while ($row = mysqli_fetch_array($result))
{
    echo '<div class="imageSlide">';
    if (Config\SlideShow::showCount)
    {
        echo '<div class="numbertext">'.$count.'/'.$result->num_rows.'</div>';
    }
    echo '<img src="images/'.$row["imageName"].'" style="width:100%">';
    echo '</div>';
    ++$count;
}
?>

  <div class="caption-container">
    <p id="caption"></p>
  </div>
  
  <div class="slides-row">
<?php

// load data from db
$query = "SELECT sort, imageName, caption FROM mod_slideshow ORDER BY sort ASC";
$result = $webDB->runQuery($query);

if (!$result)
    echo 'ERROR!';

$count = 1;
while ($row = mysqli_fetch_array($result))
{
    echo '<div class="column">';
    echo '<img class="thumbs cursor" src="images/'.$row["imageName"].'" style="width:100%" onclick="currentSlide('.$count.')" alt="'.$row["caption"].'">';
    echo '</div>';
    
    ++$count;
}
?>
  </div>
  
  <a class="prev" onclick="plusSlides(-1)">❮</a>
  <a class="next" onclick="plusSlides(1)">❯</a>
  
</div>

<script>
var slideIndex = 0;
showSlides(slideIndex);

var timer = 0;

var timeInMs = <?php echo Config\SlideShow::autoSlideTimeMs ?>

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("imageSlide");
  var dots = document.getElementsByClassName("thumbs");
  var captionText = document.getElementById("caption");
  
  if (n != null)
  {
    if (n > slides.length) {slideIndex = 1}

    if (n < 1) {slideIndex = slides.length}
    
    clearTimeout(timer);
  }
  else
  {
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}  
  }
  
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
  timer = setTimeout(showSlides, timeInMs);
}
</script>

<script>
$(window).on("load", function() {
    $('.imageSlide').find('img').each(function() {
        var imgClass = (this.width / this.height > 1) ? 'wide' : 'tall';
        $(this).addClass(imgClass);
    })
})
</script>

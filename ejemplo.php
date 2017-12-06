<!-- <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">


  <link rel="stylesheet" href="resources/assets/css/jPagesStyle.css">
  <link rel="stylesheet" href="resources/assets/css/jPages.css">

  <script type="text/javascript" src="resources/assets/js/jquery-1.8.2.min.js"></script>
  <script src="resources/assets/js/jPages.js"></script>

  <link rel="stylesheet" href="resources/assets/css/main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script>
  /* when document is ready */
  $(function() {

    /* initiate pugin assigning the desired button labels  */
    $("div.carrusel").jPages({
      containerID : "itemContainer",
      perPage     : 5,
      first       : false,
      previous    : "span.arrowPrev",
      next        : "span.arrowNext",
      last        : false
    });

  });
  </script>

  <style type="text/css">
  .customBtns { position: relative; }
  .arrowPrev, .arrowNext { width:29px; height:29px; position: absolute; top: 55px; cursor: pointer; }
  .arrowPrev { background-image: url('resources/images/back.gif'); left: -45px; }
  .arrowNext { background-image: url('resources/images/next.gif'); right: -40px; }

  .arrowPrev.jp-disabled, .arrowNext.jp-disabled { display: none; }
  </style>

</head>

<body>


  <div id="container" class="clearfix">

    <div id="sidebar">
      <h1 id="header">jPages</h1>
  </div> 

  <div id="contenido" class="defaults">

    <div class="carrusel"></div>

    <div class="customBtns">
      <span class="arrowPrev"></span>
      <span class="arrowNext"></span>
    </div>

    <ul id="itemContainer">
      <li><a href=""><img src="resources/images/img (1).jpg" alt="image"></a></li><li><img src="resources/images/img (2).jpg" alt="image"></li><li><img src="resources/images/img (3).jpg" alt="image"></li><li><img src="resources/images/img (4).jpg" alt="image"></li><li><img src="resources/images/img (5).jpg" alt="image"></li><li><img src="resources/images/img (6).jpg" alt="image"></li><li><img src="resources/images/img (7).jpg" alt="image"></li><li><img src="resources/images/img (8).jpg" alt="image"></li><li><img src="resources/images/img (9).jpg" alt="image"></li><li><img src="resources/images/img (10).jpg" alt="image"></li><li><img src="resources/images/img (11).jpg" alt="image"></li><li><img src="resources/images/img (12).jpg" alt="image"></li><li><img src="resources/images/img (13).jpg" alt="image"></li><li><img src="resources/images/img (14).jpg" alt="image"></li><li><img src="resources/images/img (15).jpg" alt="image"></li><li><img src="resources/images/img (16).jpg" alt="image"></li><li><img src="resources/images/img (17).jpg" alt="image"></li><li><img src="resources/images/img (18).jpg" alt="image"></li><li><img src="resources/images/img (19).jpg" alt="image"></li><li><img src="resources/images/img (20).jpg" alt="image"></li><li><img src="resources/images/img (21).jpg" alt="image"></li><li><img src="resources/images/img (22).jpg" alt="image"></li><li><img src="resources/images/img (23).jpg" alt="image"></li><li><img src="resources/images/img (24).jpg" alt="image"></li><li><img src="resources/images/img (25).jpg" alt="image"></li><li><img src="resources/images/img (26).jpg" alt="image"></li><li><img src="resources/images/img (27).jpg" alt="image"></li><li><img src="resources/images/img (28).jpg" alt="image"></li><li><img src="resources/images/img (29).jpg" alt="image"></li><li><img src="resources/images/img (30).jpg" alt="image"></li><li><img src="resources/images/img (31).jpg" alt="image"></li><li><img src="resources/images/img (32).jpg" alt="image"></li><li><img src="resources/images/img (33).jpg" alt="image"></li><li><img src="resources/images/img (34).jpg" alt="image"></li><li><img src="resources/images/img (35).jpg" alt="image"></li><li><img src="resources/images/img (36).jpg" alt="image"></li><li><img src="resources/images/img (37).jpg" alt="image"></li><li><img src="resources/images/img (38).jpg" alt="image"></li><li><img src="resources/images/img (39).jpg" alt="image"></li><li><img src="resources/images/img (40).jpg" alt="image"></li><li><img src="resources/images/img (41).jpg" alt="image"></li><li><img src="resources/images/img (42).jpg" alt="image"></li><li><img src="resources/images/img (43).jpg" alt="image"></li><li><img src="resources/images/img (44).jpg" alt="image"></li><li><img src="resources/images/img (45).jpg" alt="image"></li><li><img src="resources/images/img (46).jpg" alt="image"></li><li><img src="resources/images/img (47).jpg" alt="image"></li><li><img src="resources/images/img (48).jpg" alt="image"></li><li><img src="resources/images/img (49).jpg" alt="image"></li><li><img src="resources/images/img (50).jpg" alt="image"></li><li><img src="resources/images/img (51).jpg" alt="image"></li><li><img src="resources/images/img (52).jpg" alt="image"></li><li><img src="resources/images/img (53).jpg" alt="image"></li><li><img src="resources/images/img (54).jpg" alt="image"></li><li><img src="resources/images/img (55).jpg" alt="image"></li><li><img src="resources/images/img (56).jpg" alt="image"></li><li><img src="resources/images/img (57).jpg" alt="image"></li><li><img src="resources/images/img (58).jpg" alt="image"></li><li><img src="resources/images/img (59).jpg" alt="image"></li><li><img src="resources/images/img (60).jpg" alt="image"></li><li><img src="resources/images/img (61).jpg" alt="image"></li><li><img src="resources/images/img (62).jpg" alt="image"></li><li><img src="resources/images/img (63).jpg" alt="image"></li><li><img src="resources/images/img (64).jpg" alt="image"></li><li><img src="resources/images/img (65).jpg" alt="image"></li><li><img src="resources/images/img (66).jpg" alt="image"></li><li><img src="resources/images/img (67).jpg" alt="image"></li><li><img src="resources/images/img (68).jpg" alt="image"></li><li><img src="resources/images/img (69).jpg" alt="image"></li><li><img src="resources/images/img (70).jpg" alt="image"></li><li><img src="resources/images/img (71).jpg" alt="image"></li><li><img src="resources/images/img (72).jpg" alt="image"></li><li><img src="resources/images/img (73).jpg" alt="image"></li><li><img src="resources/images/img (74).jpg" alt="image"></li><li><img src="resources/images/img (75).jpg" alt="image"></li><li><img src="resources/images/img (76).jpg" alt="image"></li><li><img src="resources/images/img (77).jpg" alt="image"></li><li><img src="resources/images/img (78).jpg" alt="image"></li><li><img src="resources/images/img (79).jpg" alt="image"></li><li><img src="resources/images/img (80).jpg" alt="image"></li><li><img src="resources/images/img (81).jpg" alt="image"></li><li><img src="resources/images/img (82).jpg" alt="image"></li><li><img src="resources/images/img (83).jpg" alt="image"></li><li><img src="resources/images/img (84).jpg" alt="image"></li><li><img src="resources/images/img (85).jpg" alt="image"></li><li><img src="resources/images/img (86).jpg" alt="image"></li><li><img src="resources/images/img (87).jpg" alt="image"></li><li><img src="resources/images/img (88).jpg" alt="image"></li><li><img src="resources/images/img (89).jpg" alt="image"></li><li><img src="resources/images/img (90).jpg" alt="image"></li><li><img src="resources/images/img (91).jpg" alt="image"></li><li><img src="resources/images/img (92).jpg" alt="image"></li><li><img src="resources/images/img (93).jpg" alt="image"></li><li><img src="resources/images/img (94).jpg" alt="image"></li><li><img src="resources/images/img (95).jpg" alt="image"></li><li><img src="resources/images/img (96).jpg" alt="image"></li><li><img src="resources/images/img (97).jpg" alt="image"></li><li><img src="resources/images/img (98).jpg" alt="image"></li><li><img src="resources/images/img (99).jpg" alt="image"></li><li><img src="resources/images/img (100).jpg" alt="image"></li><li><img src="resources/images/img (101).jpg" alt="image"></li><li><img src="resources/images/img (102).jpg" alt="image"></li><li><img src="resources/images/img (103).jpg" alt="image"></li><li><img src="resources/images/img (104).jpg" alt="image"></li><li><img src="resources/images/img (105).jpg" alt="image"></li><li><img src="resources/images/img (106).jpg" alt="image"></li><li><img src="resources/images/img (107).jpg" alt="image"></li><li><img src="resources/images/img (108).jpg" alt="image"></li><li><img src="resources/images/img (109).jpg" alt="image"></li><li><img src="resources/images/img (110).jpg" alt="image"></li><li><img src="resources/images/img (111).jpg" alt="image"></li><li><img src="resources/images/img (112).jpg" alt="image"></li><li><img src="resources/images/img (113).jpg" alt="image"></li><li><img src="resources/images/img (114).jpg" alt="image"></li><li><img src="resources/images/img (115).jpg" alt="image"></li><li><img src="resources/images/img (116).jpg" alt="image"></li><li><img src="resources/images/img (117).jpg" alt="image"></li><li><img src="resources/images/img (118).jpg" alt="image"></li><li><img src="resources/images/img (119).jpg" alt="image"></li><li><img src="resources/images/img (120).jpg" alt="image"></li><li><img src="resources/images/img (121).jpg" alt="image"></li><li><img src="resources/images/img (122).jpg" alt="image"></li><li><img src="resources/images/img (123).jpg" alt="image"></li><li><img src="resources/images/img (124).jpg" alt="image"></li><li><img src="resources/images/img (125).jpg" alt="image"><li><img src="resources/images/img (126).jpg" alt="image"></li><li><img src="resources/images/img (127).jpg" alt="image"></li><li><img src="resources/images/img (128).jpg" alt="image"></li><li><img src="resources/images/img (129).jpg" alt="image"></li><li><img src="resources/images/img (130).jpg" alt="image"></li><li><img src="resources/images/img (131).jpg" alt="image"></li><li><img src="resources/images/img (132).jpg" alt="image"></li><li><img src="resources/images/img (133).jpg" alt="image"></li><li><img src="resources/images/img (134).jpg" alt="image"></li><li><img src="resources/images/img (135).jpg" alt="image"></li><li><img src="resources/images/img (136).jpg" alt="image"></li><li><img src="resources/images/img (137).jpg" alt="image"></li><li><img src="resources/images/img (138).jpg" alt="image"></li>
    </ul>

  </div>
</div>

</body>

</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
.carousel {
    margin-bottom: 0;
    padding: 0 40px 30px 40px;
}
/* The controlsy */
.carousel-control {
	left: -12px;
    height: 40px;
	width: 40px;
    background: none repeat scroll 0 0 #222222;
    border: 4px solid #FFFFFF;
    border-radius: 23px 23px 23px 23px;
    margin-top: 90px;
}
.carousel-control.right {
	right: -12px;
}
/* The indicators */
.carousel-indicators {
	right: 50%;
	top: auto;
	bottom: -10px;
	margin-right: -19px;
}
/* The colour of the indicators */
.carousel-indicators li {
	background: #cecece;
}
.carousel-indicators .active {
background: #428bca;
}
  
  </style>
  <script>
$(document).ready(function() {
  $('#Carousel').carousel({
      interval: 5000
  })
});
  </script>
</head>
<body>
<div class="col-md-12">
<div id="Carousel" class="carousel slide">
 
<ol class="carousel-indicators">
    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
    <li data-target="#Carousel" data-slide-to="1"></li>
    <li data-target="#Carousel" data-slide-to="2"></li>
</ol>
 
<!-- Carousel items -->
<div class="carousel-inner">
    
<div class="item active">
  <div class="row">
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
  </div><!--.row-->
</div><!--.item-->
 
<div class="item">
  <div class="row">
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
  </div><!--.row-->
</div><!--.item-->
 
<div class="item">
  <div class="row">
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
    <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
  </div><!--.row-->
</div><!--.item-->
 
</div><!--.carousel-inner-->
  <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
  <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
</div><!--.Carousel-->
 
</div>
</body>
</html>

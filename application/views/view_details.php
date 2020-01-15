<?php
if(isset($this->session->username)){
    $username = $this->session->username;
    $name = $this->session->name;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?=base_url()?>images/favicon.ico" >
        <link rel="icon" type="image/gif" href="<?=base_url()?>images/animated_favicon1.gif" >
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>styles/styles.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>styles/header.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>styles/footer.css">
	      <title><?=$display_name?></title>
        <script src="<?=base_url()?>plugins/jquery-2.1.0.min.js"></script>
        <!-- Begin Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- End Bootstrap -->
        <!-- Bootstrap Type Ahead -->
        <script src="<?=base_url()?>plugins/bootstrap3-typeahead.min.js"></script>
        <?php $this->load->view('view_typeahead'); ?>          
        <!-- /Bootstrap Type Ahead -->
	      <!-- Carousel Swipe -->
        <script src="<?=base_url()?>plugins/carousel-swipe.js"></script>
	      <!-- /Carousel Swipe -->
        <script>
         $( document ).ready(function() {
             var maxImgHeight=0;
             $('.details-thumb').mouseover(function(){
                 $('#largeimg').attr("src", $(this).attr("src"));
             });
	           $("#carousel-example-generic").carousel();

             $(".carousel-inner .item img").each(function(){
                 $(this).load(function() {
                     if(this.clientHeight>maxImgHeight){
                         maxImgHeight=this.clientHeight;
                         $('.carousel').css('height',maxImgHeight);
                     }
                 })
             })

             $(window).resize(function() {
                 console.log("as");
                 $(".carousel-inner .item img").each(function(){
                     if(this.clientHeight>maxImgHeight){
                         maxImgHeight=this.clientHeight;
                         $('.carousel').css('height',maxImgHeight);
                         console.log(maxImgHeight);
                     }
                 })                 
             })
             
         });
        </script>
	      <style>
	       .carousel-inner .item img {
	           position:relative;
	           left:50%;
	           transform: translateX(-50%);
	       }
	       .carousel-control.left, .carousel-control.right {
	           background-image: none
	       }
         /*Give a border around carousel indicators*/
         .carousel-indicators li{
             border: 1px solid gray;

         }
	      </style>
        <?php $this->load->view('view_google_analytics'); ?>
    </head>
    <body>
        <div class="container-fluid" style="padding:0px;">
            <?php $this->load->view('page_top.php');?>
	          <!-- Carousel row -->
	          <div class="row visible-xs">
		            <div class="col-md-12">
		                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			                  <!-- Indicators -->
			                  <ol class="carousel-indicators">
			                      <?php if(trim($pic1)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			                      <?php endif; ?>
			                      <?php if(trim($pic2)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
			                      <?php endif; ?>
			                      <?php if(trim($pic3)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
			                      <?php endif; ?>
			                      <?php if(trim($pic4)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="3" class="active"></li>
			                      <?php endif; ?>
			                      <?php if(trim($pic5)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="4" class="active"></li>
			                      <?php endif; ?>
			                      <?php if(trim($pic6)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="5" class="active"></li>
			                      <?php endif; ?>
			                      <?php if(trim($pic7)!=""): ?>
				                        <li data-target="#carousel-example-generic" data-slide-to="6" class="active"></li>
			                      <?php endif; ?>			    

			                  </ol>

			                  <!-- Wrapper for slides -->
			                  <div class="carousel-inner" role="listbox">
			                      <div class="item active">
				                        <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic1?>" alt="">
			                      </div>
			                      <?php if(trim($pic2)!=""): ?>
				                        <div class="item">
				                            <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic2?>" alt="">
				                        </div>
			                      <?php endif; ?>
			                      <?php if(trim($pic3)!=""): ?>
				                        <div class="item">
				                            <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic3?>" alt="">
				                        </div>
			                      <?php endif; ?>
			                      <?php if(trim($pic4)!=""): ?>
				                        <div class="item">
				                            <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic4?>" alt="">
				                        </div>
			                      <?php endif; ?>
			                      <?php if(trim($pic5)!=""): ?>
				                        <div class="item">
				                            <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic5?>" alt="">
				                        </div>
			                      <?php endif; ?>
			                      <?php if(trim($pic6)!=""): ?>
				                        <div class="item">
				                            <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic6?>" alt="">
				                        </div>
			                      <?php endif; ?>
			                      <?php if(trim($pic7)!=""): ?>
				                        <div class="item">
				                            <img class="largeimg" src="<?=base_url()?>images/phones/<?=$pic7?>" alt="">
				                        </div>
			                      <?php endif; ?>			    
			                  </div>

			                  <!-- Controls -->
			                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			                      <span class="sr-only">Previous</span>
			                  </a>
			                  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			                      <span class="sr-only">Next</span>
			                  </a>
		                </div>
		            </div>
	          </div>
	          <!-- /Carousel row -->
            <div class="row"><!-- main body row -->
                <div class="col-md-2 hidden-xs" ><!-- thumbnails col -->
                    <div class="row"><!-- thumbnails inner row -->
                        <?php if(trim($pic1)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic1?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
			                  <?php if(trim($pic2)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic2?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
			                  <?php if(trim($pic3)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic3?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
			                  <?php if(trim($pic4)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic4?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
			                  <?php if(trim($pic5)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic5?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
			                  <?php if(trim($pic6)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic6?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
			                  <?php if(trim($pic7)!=""): ?>
                            <div class="col-md-6 col-sm-3">
				                        <div class="thumbnail">
				                            <img class="details-thumb" src="<?=base_url()?>images/phones/<?=$pic7?>"/>
				                        </div>
                            </div>
			                  <?php endif; ?>
                    </div><!-- /thumbnails inner row -->
                </div><!-- /thumbnails col -->
                <div class="col-md-3 hidden-xs">
                    <img id="largeimg" class="largeimg" src="<?=base_url()?>images/phones/<?=$pic1?>"/>
                </div><!-- /middle col -->
                <div class="col-md-7 col-xs-12">
                    <h3><?=$display_name?></h3>
                    <p>by <b><?=$brand?></b></p>
                    <hr/>
                    <h4 class="price">MVR <?=$price?></h4>
                    <h4 style="margin-bottom:25px;"><a href="tel:7899987"><span class="glyphicon glyphicon-earphone"></span>&nbsp;&nbsp;7899987</a></h4>
                    <h4 class="<?=$in_stock_class?>"><?=$in_stock?></h4>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Internal Storage:</dt>
                        <dd style="text-align:left;"><?=$internal_storage?> GB</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Memory:</dt>
                        <dd style="text-align:left;"><?=$ram?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Colour:</dt>
                        <dd style="text-align:left;"><?=$colour?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Camera:</dt>
                        <dd style="text-align:left;"><?=$camera?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Screen:</dt>
                        <dd style="text-align:left;"><?=$screen?> inches</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Dimension:</dt>
                        <dd style="text-align:left;"><?=$dimension?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt style="text-align:left;">Operating System:</dt>
                        <dd style="text-align:left;"><?=$os_type?> <?=$os?></dd>
                    </dl>
                    <?php if($box_items!=""):?>
                        <dl class="dl-horizontal">
                            <dt style="text-align:left;">Box Items:</dt>
                            <dd style="text-align:left;"><?=$box_items?></dd>
                        </dl>
                    <?php endif;?>
                    <h4 style="margin-top:30px;"><?=$short_summary?></h4>
                    <p><?=$description?></p>


                </div><!-- /right col -->
            </div><!-- /main body row -->
            <div class="row">
                <div class="col-md-12">
                    <br/><br/><br/><br/><br/><br/><br/>
                    <h3>Similar Phones</h3>
                </div>
            </div>
            <div class="row">
                <?php foreach($similarPhones as $similarPhone): ?>
                    <div class='col-lg-3 col-md-4 col-sm-6 col-xs-12'>
                        <div class="thumbnail">
                            <a href='<?=$similarPhone[2]?>'>
                                <img class='similar-phones-img' src='<?=base_url()?>images/phones/<?=$similarPhone[0]?>'/>
                                <div class="caption"><small><?=$similarPhone[1]?></small></div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view('footer.php');?>                    
            </div>
        </div>    
        </div><!--container-flud -->
    </body>
</html>

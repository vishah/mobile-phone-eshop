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
	      <title>My Phone Market</title>
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
        <script>
         $( document ).ready(function() {
             var sliderTblLinksIds = [];
             var sliderTblLinksImgs = [];
             var sliderTblLinksLinks = [];
	           var stopSlider = false;
             
             <?php foreach($banners as $key=>$banner): ?>
             sliderTblLinksIds[<?=$key;?>]=<?=$banner['id']?>;    
             <?php endforeach; ?>
             <?php foreach($banners as $key=>$banner): ?>
             sliderTblLinksImgs[<?=$key;?>]="<?=$banner['banner_pic']?>";
             sliderTblLinksLinks[<?=$key;?>]="<?=$banner['link']?>";                 
             <?php endforeach; ?>

	           var currenIndex=0;
	           var totalLen=sliderTblLinksIds.length;

	           setInterval(
	     	         function(){
		                 if(stopSlider == false){
			                   if(currenIndex==totalLen){
			                       currenIndex=0;
			                   }
			                   currenId = sliderTblLinksIds[currenIndex];
			                   console.log(currenId);

			                   $("#"+currenId).css("background-color", "#EFEFEF");
			                   $("#slider").css("background-image", "url(<?=base_url()?>images/slideshow/"+ sliderTblLinksImgs[currenId-1]);
			                   $("#slideranchor").attr("href", "<?=base_url()?>"+ sliderTblLinksLinks[currenId.id-1]);                 
			                   for (i = 0; i < sliderTblLinksIds.length; i++) {
			                       currId = sliderTblLinksIds[i];
			                       if(currId!=currenId){
				                         $("#"+currId).css("background-color", "#FFFFFF");
			                       }
			                   }
			                   currenIndex = currenIndex+1;
		                 }
		             },5000
	           );
	           
             $(".sliderlink").mouseover(function(){
		             stopSlider = true;
                 $(this).css("background-color", "#EFEFEF");
                 $("#slider").css("background-image", "url(<?=base_url()?>images/slideshow/"+ sliderTblLinksImgs[this.id-1]);
                 $("#slideranchor").attr("href", "<?=base_url()?>"+ sliderTblLinksLinks[this.id-1]);                 
                 for (i = 0; i < sliderTblLinksIds.length; i++) {
                     currId = sliderTblLinksIds[i];
                     if(currId!=this.id){
                         $("#"+currId).css("background-color", "#FFFFFF");
                     }
                 }                 
             });
             $(".sliderlink").mouseout(function(){
		             stopSlider = false;

	           });

             $('.scrollleft').click(function () {
                 $('.slider').animate({
                     scrollLeft: '-=800'
                 });
             });
             $('.scrollright').click(function () {
                 $('.slider').animate({
                     scrollLeft: '+=800'
                 });
             });

         });
        </script>
        <?php $this->load->view('view_google_analytics'); ?>
    </head>
    <body>
        <div class="container-fluid" style="padding:0px;">
            <?php $this->load->view('page_top.php');?>
            <div class="row"><!-- main body row -->
                <div class="col-md-2 hidden-sm hidden-xs">
                    <aside class="sidebar">
                        <dl>
                            <dt>Phones By Brand</dt>
                            <?php foreach($browseByBrand as $brand): ?>
                                <dd><small><a class="sidebar-link" href="<?=base_url()?>catalogue/category/<?=$brand['name']?>"><?=$brand['caption']?></a></small></dd>
                            <?php endforeach; ?>                                                        

                        </dl>
                    </aside>
                    <aside class="sidebar">
                        <dl>
                            <dt>Phones By Price</dt>
                            <?php foreach($browseByPrice as $price): ?>
                                <dd><small><a class="sidebar-link" href="<?=base_url()?>catalogue/category/<?=$price['name']?>"><?=$price['caption']?></a></small></dd>
                            <?php endforeach; ?>
                        </dl>
                    </aside>
                    <aside class="sidebar">
                        <dl>
                            <dt>Phones By Feature</dt>
                            <?php foreach($browseByFeature as $feature): ?>
                                <dd><small><a class="sidebar-link" href="<?=base_url()?>catalogue/category/<?=$feature['name']?>"><?=$feature['caption']?></a></small></dd>
                            <?php endforeach; ?>
                        </dl>
                    </aside>                    
                </div>
                <div class="col-md-10">
                    <div class="row hidden-xs"><!-- slider row -->
                        <div class="col-md-12"><!-- slider col -->
                            <h1>Mobile Phones & Accessories</h1>
                            <a id="slideranchor" href="<?=base_url()?><?=$banners[0]['link']?>">
                                <div id="slider" style="transition:background 2s linear;background-image:url(<?=base_url()?>images/slideshow/<?=$banners[0]['banner_pic']?>)">
                                    <aside>
                                        <table cellspacing="0" cellpadding="5" class="slidertable">
                                            <?php foreach($banners as $banner): ?>  
                                                <tr>
                                                    <td class="sliderlink" id ="<?=$banner['id']?>">
                                                        <a href="<?=base_url()?><?=$banner['link']?>">
                                                            <div class="heading2"><?=$banner['banner_name']?></div>
                                                            <div class="heading3"><?=$banner['banner_description']?></div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </aside>
                                </div>
                            </a>
                        </div><!-- slider col -->
                    </div><!-- /slider row -->

                    <div class="hidden-xs"><!-- slider container row -->
                        <div class="col-md-12"><!-- slider container col -->                        
		                        <h3>Best Sellers</h3>
                            <div class="row">
                                <div class="col-sm-1" style="padding:0px;"><!-- slider left arrow col -->
		                                <img class="scrollleft" style="float:left;width:35px;height:60px;margin-top:55px;cursor:pointer;" src="<?=base_url()?>images/previous.png"/>
                                </div><!-- /slider left arrow col -->
                                <div class="col-sm-10"><!-- slider content col -->
		                                <div class="slider" id="scrollbar">
                                        <?php foreach($bestSellers as $product): ?>
                                            <a href="<?=base_url()?>details/<?=$product['internalReference']?>">
                                                <div class="product">
                                                    <img src="<?=base_url()?>images/phones/<?=$product['thumb']?>"/>
                                                    <div class="title"><?=$product['phoneName']?></div>
                                                    <div class="author"><?=$product['brand']?></div>
                                                    <div class="price">MVR <?=$product['price']?></div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>      
		                                </div>
                                </div><!-- /slider content col -->
                                <div class="col-sm-1"><!-- slider right arrow col -->
		                                <img class="scrollright" style="float:right;width:35px;height:60px;margin-top:55px;cursor:pointer;" src="<?=base_url()?>images/right.png"/>
                                </div><!-- /slider right arrow col -->
                            </div><!-- /slider row -->
                        </div><!-- slider container col -->
                    </div><!-- /slider container row -->
                    <div class="row"><!-- Heading Browse Phones By Brand row -->
                        <div class="col-md-12">
                            <h3>Browse Phones By Brand</h3>
			                  </div>
		                </div><!-- /Heading Browse Phones By Brand row -->
		                <div class="row"><!-- Browse Phones By Brand row -->
                        <?php foreach($browseByBrand as $brand): ?>
			                      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                                <div class="thumbnail main-page-thumb">
				                            <a href="<?=base_url()?>catalogue/category/<?=$brand['name']?>"><img src="<?=base_url()?>images/phones/<?=$brand['thumb']?>"/></a>
				                            <div class="caption"><?=$brand['caption']?></div>
                                </div>
			                      </div>
                        <?php endforeach; ?>
                    </div><!-- /Browse Phones By Brand row -->
                    <div class="row"><!-- Heading Browse Phones By Price row -->
                        <div class="col-md-12">
                            <h3>Browse Phones By Price</h3>
			                  </div>
		                </div>
                    <div class="row"><!-- Browse Phones By Price row -->		    
                        <?php foreach($browseByPrice as $price): ?>
				                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                                <div class="thumbnail main-page-thumb">
					                          <a href="<?=base_url()?>catalogue/category/<?=$price['name']?>"><img src="<?=base_url()?>images/phones/<?=$price['thumb']?>"/></a>
					                          <div class="caption"><?=$price['caption']?></div>
                                </div>
				                    </div>
                        <?php endforeach; ?>
                    </div><!-- /Browse Phones By Price row -->        
                    <div class="row"><!-- Heading Browse Phones By Feature row -->
                        <div class="col-md-12">
                            <h3>Browse Phones By Feature</h3>
			                  </div>
		                </div>
		                <div class="row"><!-- Browse Phones By Feature row -->
                        <?php foreach($browseByFeature as $feature): ?>
			                      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                                <div class="thumbnail main-page-thumb">
                                    <a href="<?=base_url()?>catalogue/category/<?=$feature['name']?>"><img src="<?=base_url()?>images/phones/<?=$feature['thumb']?>"/></a>
                                    <div class="caption"><?=$feature['caption']?></div>
                                </div>
			                      </div>
                        <?php endforeach; ?>
                    </div><!-- /Browse Phones By Feature row -->
                    <?php $this->load->view('footer.php');?>
                </div><!-- /right col -->
            </div><!-- /main body row -->
        </div><!--container-flud -->
    </body>
</html>


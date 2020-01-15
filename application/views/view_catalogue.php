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
	      <title><?=$caption?></title>
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
              var category='<?=(isset($category))?$category:''?>';
              var display_size='<?=isset($display_size)?implode("~",$display_size):'';?>';
              var price='<?=(isset($price))?implode("~",$price):'';?>';
              var cust_review='<?=(isset($cust_review))?implode("~",$cust_review):'';?>';         
              var internal_storage='<?=(isset($internal_storage))?implode("~",$internal_storage):'';?>';
              var search='<?=(isset($search))?$search:'';?>';

              function go(){
              var urlString="<?=base_url()?>catalogue/";
              if(category!=''){
              urlString = urlString + "category/"+category+"/";
              }
              if(price!=''){
              urlString = urlString + "price/"+price+"/";
              }
              if(cust_review!=''){
              urlString = urlString + "cust_review/"+cust_review+"/";
              }             
              if(display_size!=''){
              urlString = urlString + "display_size/"+display_size+"/";
              }
              if(internal_storage!=''){
              urlString = urlString + "internal_storage/"+internal_storage+"/";
              }
              if(search!=''){
              urlString = urlString + "search/" + encodeURIComponent(search) + "/";
              }             
              window.location.href=urlString;
              }

              function gotopageone(){
              page = 1;
              baseUrl='<?=base_url();?>';
              
              $('.book-list').html('');
              for(i=(page*20)-20;i<=(page*20)-1;i++){
              // for(i=0;i<20;i++){
              $('.book-list').html($('.book-list').html() + ' \
              <div class="col-md-2 col-xs-12 col-sm-6"> \
              <div class="thumbnail"> \
              <a href="' + baseUrl + 'details/' + products[i]["internalReference"] + '"> \
			        <img style="height:100px;" src=" ' + products[i]["url"] + '"/> \
			        <div class="caption">' + products[i]['displayName'] +'</br> \
			        <span class="price">MVR ' + products[i]["price"]  + '</span> \
              </div> \
              </a> \
              </div> \
              </div>'
              );
              }
              }
              $( document ).ready(function() {

              $("#paperbackbooks").mouseover(function(){
              $("#booksslide").css("background-image", "url(<?=base_url()?>images/slideshow/1.jpg)");
              }); 

              $("#goodreads").mouseover(function(){
              $("#booksslide").css("background-image", "url(<?=base_url()?>images/slideshow/2.jpg)");
              }); 

              $("#weeklyevent").mouseover(function(){
              $("#booksslide").css("background-image", "url(<?=base_url()?>images/slideshow/3.jpg)");
              }); 

              $("#indiebooks").mouseover(function(){
              $("#booksslide").css("background-image", "url(<?=base_url()?>images/slideshow/4.jpg)");
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
              //refine by display size - sidebar
              $('.display_size').on('change',function(e){
              displaySizeArr=[];
              $("input:checkbox.display_size:checked").each(function(){
              displaySizeArr.push($(this).val());
              });
              display_size = displaySizeArr.join("~");
              console.log(display_size);
              go();
              });
              //refine by display size - mobileview
              $('.mobile-display_size').on('change',function(e){
              displaySizeArr=[];
              $("input:checkbox.mobile-display_size:checked").each(function(){
              displaySizeArr.push($(this).val());
              });
              display_size = displaySizeArr.join("~");
              console.log(display_size);
              go();
              });             
              //refine by internal storage - sidebar
              $('.internal_storage').on('change',function(e){
              internalStorageArr=[];
              $("input:checkbox.internal_storage:checked").each(function(){
              internalStorageArr.push($(this).val());
              console.log($(this).val());
              });
              internal_storage = internalStorageArr.join("~");
              console.log(internal_storage);
              go();                 
              });
              //refine by internal storage - mobileview
              $('.mobile-internal_storage').on('change',function(e){
              internalStorageArr=[];
              $("input:checkbox.mobile-internal_storage:checked").each(function(){
              internalStorageArr.push($(this).val());
              console.log($(this).val());
              });
              internal_storage = internalStorageArr.join("~");
              console.log(internal_storage);
              go();                 
              });             
              //refine by price range - sidebar
              $('.price').on('change',function(e){
              price=$(this).val();
              go();
              });
              //refine by price range - mobileview
              $('.mobile-price').on('change',function(e){
              price=$(this).val();
              go();
              });
              //refine by customer review - sidebar
              $('.cust-review').on('change',function(e){
              cust_review=$(this).val();
              go();
              });             
              //refine by customer review - mobileview
              $('.mobile-cust-review').on('change',function(e){
              cust_review=$(this).val();
              go();
              });
              // Load products into products into products array
              var sortby = "internalReference";
              var products = [];
              <?php foreach($allCatPhones as $key=>$product): ?>
              products[<?=$key?>] = {url:"<?=base_url()?>images/phones/<?=$product['thumb']?>", displayName:"<?=$product['displayName']?>",  price:"<?=$product['price']?>", internalReference:"<?=$product['internalReference']?>", releasedDate:"<?=$product['releasedDate']?>", review:"<?=$product['review']?>"};
              <?php endforeach; ?>
              products = products.sort(function(a,b){
              return a.price - b.price;
              });
              function gotopageone(){
              page = 1;
              baseUrl='<?=base_url();?>';
              
              $('.book-list').html('');
              for(i=(page*20)-20;i<=(page*20)-1;i++){
              // for(i=0;i<20;i++){
              $('.book-list').html($('.book-list').html() + ' \
              <div class="col-md-2 col-xs-12 col-sm-6"> \
              <div class="thumbnail"> \
              <a href="' + baseUrl + 'details/' + products[i]["internalReference"] + '"> \
			        <img style="height:100px;" src=" ' + products[i]["url"] + '"/> \
			        <div class="caption">' + products[i]['displayName'] +'</br> \
			        <span class="price">MVR ' + products[i]["price"]  + '</span> \
              </div> \
              </a> \
              </div> \
              </div>'
              );
              }
              };
              $("#sortPriceLowToHigh").click(function(e){
              products = products.sort(function(a,b){
              return a.price - b.price;
              });
              gotopageone();
              });
              $("#sortPriceHighToLow").click(function(e){
              products = products.sort(function(a,b){
              return b.price - a.price;
              });
              gotopageone();
              });             
              $("#sortReleasedDate").click(function(e){
              products = products.sort(function(a,b){
              return b.releasedDate - a.releasedDate;
              });
              gotopageone();
              });
              $("#sortReview").click(function(e){
              products = products.sort(function(a,b){
              return a.review - b.review;
              });
              gotopageone();
              });              
              
              //pagination             
              $('ul.pagination li a').on('click',function(e){

              e.preventDefault();
              var tag = $(this);
              page = tag.text();
              baseUrl='<?=base_url();?>';
              
              $('.book-list').html('');
              for(i=(page*20)-20;i<=(page*20)-1;i++){
              // for(i=0;i<20;i++){
              $('.book-list').html($('.book-list').html() + ' \
              <div class="col-md-2 col-xs-12 col-sm-6"> \
              <div class="thumbnail"> \
              <a href="' + baseUrl + 'details/' + products[i]["internalReference"] + '"> \
			        <img style="height:100px;" src=" ' + products[i]["url"] + '"/> \
			        <div class="caption">' + products[i]['displayName'] +'</br> \
			        <span class="price">MVR ' + products[i]["price"]  + '</span> \
              </div> \
              </a> \
              </div> \
              </div>'
              );
              }

              });                 




              });
	          </script>
            <?php $this->load->view('view_google_analytics'); ?>
          </head>
          <body>
            <div class="container-fluid" style="padding:0px;">
              <?php $this->load->view('page_top.php');?>
              <div class="row "><!-- main body row -->
                <div class="col-md-2 hidden-sm hidden-xs">
                  <form name="frm_refine_by" id="frm_refine_by" method="post" action="<?=current_url()?>">
                  
                  <h4>Refine by</h4>
                  <aside class="sidebar">
                    <h5><b>Price</b></h5>
                    <div class="radio">
                      <label>
                        <input type="radio" class="price" name="price[]" id="filter-price-1" value="all" <?php if(in_array('all',$price))echo "checked"; ?>>
                        All filter-prices
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="price" name="price[]" id="filter-price-2" value="budget" <?php if(in_array('budget',$price))echo "checked"; ?>>
                        1000-4000 MVR
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="price" name="price[]" id="filter-price-3" value="mid-range" <?php if(in_array('mid-range',$price))echo "checked"; ?>>
                        4000-7000 MVR
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="price" name="price[]" id="filter-price-4" value="high-end" <?php if(in_array('high-end',$price))echo "checked"; ?>>
                        7000-10,000 MVR
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="price" name="price[]" id="filter-price-5" value="top-notch" <?php if(in_array('top-notch',$price))echo "checked"; ?>>
                        10,000 MVR & Above
                      </label>
                    </div>                        
                  </aside>                        
                  <aside class="sidebar">
                    <h5><b>Display Size</b></h5>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="display_size" name="display_size[]" value="lt3.9" <?php if(in_array('lt3.9',$display_size))echo "checked"; ?>>
                        3.9 Inches & Under
                      </label>
                    </div>
                    <div class="checkbox disabled">
                      <label>
                        <input type="checkbox" class="display_size" name="display_size[]" value="4.0-4.4" <?php if(in_array('4.0-4.4',$display_size))echo "checked";?>>
                        4.0 to 4.4 Inches
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="display_size" name="display_size[]" value="4.5-4.9" <?php if(in_array('4.5-4.9',$display_size))echo "checked";?>>
                        4.5 to 4.9 Inches
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="display_size" name="display_size[]" value="5.0-5.4" <?php if(in_array('5.0-5.4',$display_size))echo "checked";?>>
                        5.0 to 5.4 Inches
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="display_size" name="display_size[]" value="gt5.5" <?php if(in_array('gt5.5',$display_size))echo "checked";?>>
                        5.5 Inches & Over
                      </label>
                    </div>
                  </aside>                    
                  <aside class="sidebar">

                    <h5><b>Internal Storage</b></h5>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="internal_storage" name="internal_storage[]" value="4" <?php if(in_array('4',$internal_storage))echo "checked";?>>
                        4GB
                      </label>
                    </div>
                    <div class="checkbox disabled">
                      <label>
                        <input type="checkbox" class="internal_storage" name="internal_storage[]" value="8" <?php if(in_array('8',$internal_storage))echo "checked";?>>
                        8GB
                      </label>
                    </div>
                    <div class="checkbox disabled">
                      <label>
                        <input type="checkbox" class="internal_storage" name="internal_storage[]" value="16" <?php if(in_array('16',$internal_storage))echo "checked";?>>
                        16GB
                      </label>
                    </div>
                    <div class="checkbox disabled">
                      <label>
                        <input type="checkbox" class="internal_storage" name="internal_storage[]" value="32" <?php if(in_array('32',$internal_storage))echo "checked";?>>
                        32GB
                      </label>
                    </div>
                    <div class="checkbox disabled">
                      <label>
                        <input type="checkbox" class="internal_storage" name="internal_storage[]" value="64" <?php if(in_array('64',$internal_storage))echo "checked";?>>
                        64GB
                      </label>
                    </div>
                    <div class="checkbox disabled">
                      <label>
                        <input type="checkbox" class="internal_storage" name="internal_storage[]" value="128" <?php if(in_array('128',$internal_storage))echo "checked";?>>
                        128GB
                      </label>
                    </div>
                  </aside>
                  <aside class="sidebar">
                    <h5><b>Avg. Customer Review</b></h5>
                    <div class="radio">
                      <label>
                        <input type="radio" class="cust-review" name="cust-review[]" id="filter-cust-review-1" value="4" <?php if(in_array('4',$cust_review))echo "checked"; ?>>
                        &#9733;&#9733;&#9733;&#9733;&#9734; & Up
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="cust-review" name="cust-review[]" id="filter-cust-review-2" value="3" <?php if(in_array('3',$cust_review))echo "checked"; ?>>
                        &#9733;&#9733;&#9733;&#9734;&#9734; & Up
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="cust-review" name="cust-review[]" id="filter-cust-review-3" value="2" <?php if(in_array('2',$cust_review))echo "checked"; ?>>
                        &#9733;&#9733;&#9734;&#9734;&#9734; & Up
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="cust-review" name="cust-review[]" id="filter-cust-review-4" value="1" <?php if(in_array('1',$cust_review))echo "checked"; ?>>
                        &#9733;&#9734;&#9734;&#9734;&#9734; & Up
                      </label>
                    </div>
                  </aside>

                </form>
              </div>
              <div class="col-md-10">

		            <section>
		              <h1><?=$caption?></h1>
		            </section>
                
                <?php if($submitted==0): ?>
			          <?php if($this->uri->segment(2)!="search"): ?>
                <div class="row hidden-xs"><!-- slider container row -->
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
			        <?php endif; ?>

			        <?php if($this->uri->segment(2)!="search"): ?>
              <div class="row">
                <div class="col-md-12">
		              <h3>New & Notable</h3>                                
                </div>
              </div>
			        <?php endif; ?>
			        <?php if($this->uri->segment(2)!="search"): ?>
              <div class="row"><!-- new and notable row -->

                <?php foreach($newAndNotable as $product): ?>
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12"><!-- new and notable col -->
                  <div class="thumbnail">
                    <a href="<?=base_url()?>details/<?=$product['internalReference']?>">
                    <img style="background:#E5E5E5;" src="<?=base_url()?>images/phones/<?=$product['thumb']?>"/>
                    <div class="caption">
                      <h4><?=$product['phoneName']?></h4>
                      <p>
                        <?=$product['brand']?></br>
                        <span class="price">MVR <?=$product['price']?></span>
                      </p>
                    </div>
                  </a>
                </div><!-- /thumbnail -->
              </div><!-- new and notable col -->                                         
              <?php endforeach; ?>            
            </div><!-- new and notable row -->
			      <?php endif; ?>
            <?php if($featuredCategories != NULL): ?>
            <div class="row"><!-- featured categories row -->
              <div class="col-md-12"><!-- featured categories col -->                                                                            
		            <h3>Featured Categories in <?=$caption?></h3>

		            <div class="threecol-cat-container">
                  <?php foreach($featuredCategories as $category): ?>
                  <a href="<?=base_url()?>details/<?=$product['internalReference']?>">
			            <div class="threecol-cat">
				            <img src="<?=base_url()?>images/phones/<?=$product['thumb']?>"/>
				            <div class="title"><?=$product['name']?></div>
			            </div>
                </a>
                <?php endforeach; ?>                  
		          </div>

            </div><!-- featured categories col -->
          </div><!-- featured categories row -->
          <?php endif; ?>
          <?php endif; ?>
          <div class="row"><!-- all phones row title -->
            <div class="col-md-12"><!-- all phones col title -->
              <?php if($parent==0): ?>
		          <h3 id="myphonelist"><span style="color:#004B91;">MyPhone</span> <span style="color:gray;">></span> <?=$caption?></h3>
              <?php else: ?>
		          <h3><span style="color:#004B91;"><?=$parent?></span> <span style="color:gray;">></span> <?=$caption?></h3>
              <?php endif; ?>
            </div><!-- /all phones col title -->
          </div><!-- /all phones row title -->
          
          <div class="row"><!-- all phones row sort -->
            <div class="col-md-12"><!-- paginator col -->
              <ul  class="pagination" style="margin:0px !important;">
                <li>
                  <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <?php for($i=1;$i<=ceil(count($allCatPhones)/20);$i++): ?>
                <li><a href="#"><?=$i?></a></li>
                <?php endfor; ?>
                <li>                                    
                  <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
              

              <div class="btn-group" style="vertical-align:top;">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Sort <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a id="sortReleasedDate" href="#myphonelist">Released Date</a></li>
                  <li><a id="sortPriceLowToHigh" href="#myphonelist">Price: Low to High</a></li>
                  <li><a id="sortPriceHighToLow" href="#myphonelist">Price: Hight to Low</a></li>
                  <li><a id="sortReview" href="#myphonelist">Review</a></li>
                </ul>
              </div>
              <button class="btn  hidden-lg hidden-md" type="button" data-toggle="collapse" data-target="#collapseExample" style="vertical-align:top;" aria-expanded="false" aria-controls="collapseExample">
                Filter <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
              </button>
              <div class="collapse" id="collapseExample">
                <div class="well well-sm hidden-lg hidden-md">
                  <h5><b>Price</b></h5>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-price" name="price[]" id="filter-price-1" value="all" <?php if(in_array('all',$price))echo "checked"; ?>>
                      All filter-prices
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-price" name="price[]" id="filter-price-2" value="budget" <?php if(in_array('budget',$price))echo "checked"; ?>>
                      1000-4000 MVR
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-price" name="price[]" id="filter-price-3" value="mid-range" <?php if(in_array('mid-range',$price))echo "checked"; ?>>
                      4000-7000 MVR
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-price" name="price[]" id="filter-price-4" value="high-end" <?php if(in_array('high-end',$price))echo "checked"; ?>>
                      7000-10,000 MVR
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-price" name="price[]" id="filter-price-5" value="top-notch" <?php if(in_array('top-notch',$price))echo "checked"; ?>>
                      10,000 MVR & Above
                    </label>
                  </div>                        

                  <h5><b>Display Size</b></h5>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="mobile-display_size" name="display_size[]" value="lt3.9" <?php if(in_array('lt3.9',$display_size))echo "checked"; ?>>
                      3.9 Inches & Under
                    </label>
                  </div>
                  <div class="checkbox disabled">
                    <label>
                      <input type="checkbox" class="mobile-display_size" name="display_size[]" value="4.0-4.4" <?php if(in_array('4.0-4.4',$display_size))echo "checked";?>>
                      4.0 to 4.4 Inches
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="mobile-display_size" name="display_size[]" value="4.5-4.9" <?php if(in_array('4.5-4.9',$display_size))echo "checked";?>>
                      4.5 to 4.9 Inches
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="mobile-display_size" name="display_size[]" value="5.0-5.4" <?php if(in_array('5.0-5.4',$display_size))echo "checked";?>>
                      5.0 to 5.4 Inches
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="mobile-display_size" name="display_size[]" value="gt5.5" <?php if(in_array('gt5.5',$display_size))echo "checked";?>>
                      5.5 Inches & Over
                    </label>
                  </div>
                  <h5><b>Internal Storage</b></h5>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="mobile-internal_storage" name="internal_storage[]" value="4" <?php if(in_array('4',$internal_storage))echo "checked";?>>
                      4GB
                    </label>
                  </div>
                  <div class="checkbox disabled">
                    <label>
                      <input type="checkbox" class="mobile-internal_storage" name="internal_storage[]" value="8" <?php if(in_array('8',$internal_storage))echo "checked";?>>
                      8GB
                    </label>
                  </div>
                  <div class="checkbox disabled">
                    <label>
                      <input type="checkbox" class="mobile-internal_storage" name="internal_storage[]" value="16" <?php if(in_array('16',$internal_storage))echo "checked";?>>
                      16GB
                    </label>
                  </div>
                  <div class="checkbox disabled">
                    <label>
                      <input type="checkbox" class="mobile-internal_storage" name="internal_storage[]" value="32" <?php if(in_array('32',$internal_storage))echo "checked";?>>
                      32GB
                    </label>
                  </div>
                  <div class="checkbox disabled">
                    <label>
                      <input type="checkbox" class="mobile-internal_storage" name="internal_storage[]" value="64" <?php if(in_array('64',$internal_storage))echo "checked";?>>
                      64GB
                    </label>
                  </div>
                  <div class="checkbox disabled">
                    <label>
                      <input type="checkbox" class="mobile-internal_storage" name="internal_storage[]" value="128" <?php if(in_array('128',$internal_storage))echo "checked";?>>
                      128GB
                    </label>
                  </div>
                  <h5><b>Avg. Customer Review</b></h5>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-cust-review" name="cust-review[]" id="filter-cust-review-1" value="4" <?php if(in_array('4',$cust_review))echo "checked"; ?>>
                      &#9733;&#9733;&#9733;&#9733;&#9734; & Up
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-cust-review" name="cust-review[]" id="filter-cust-review-2" value="3" <?php if(in_array('3',$cust_review))echo "checked"; ?>>
                      &#9733;&#9733;&#9733;&#9734;&#9734; & Up
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-cust-review" name="cust-review[]" id="filter-cust-review-3" value="2" <?php if(in_array('2',$cust_review))echo "checked"; ?>>
                      &#9733;&#9733;&#9734;&#9734;&#9734; & Up
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" class="mobile-cust-review" name="cust-review[]" id="filter-cust-review-4" value="1" <?php if(in_array('1',$cust_review))echo "checked"; ?>>
                      &#9733;&#9734;&#9734;&#9734;&#9734; & Up
                    </label>
                  </div>
                </div>
              </div>                             
            </div>
          </div><!-- /paginator row -->
          
          <div class="row book-list" ><!-- all phones row list -->

            <?php foreach($allCatPhones as $product): ?>
            <div class="col-lg-2 col-md-3 col-xs-12 col-sm-6"><!-- all phones col list -->                         			        <div class="thumbnail">
              <a href="<?=base_url()?>details/<?=$product['internalReference']?>">
				      <img style="height:100px;" src="<?=base_url()?>images/phones/<?=$product['thumb']?>"/>
				      <div class="caption">
                <?=$product['displayName']?></br>
				        <span class="price">MVR <?=$product['price']?></span>
              </div>
            </a>
			    </div><!-- /thumbnail -->
        </div><!-- all phones col -->                                    
        <?php endforeach; ?>

      </div><!-- all phones row -->
      <div class="row"><!-- paginator row -->
        <div class="col-md-12"><!-- paginator col -->
          <nav>
            <ul  class="pagination">
              <li>
                <a href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for($i=1;$i<=ceil(count($allCatPhones)/20);$i++): ?>
              <li><a href="#"><?=$i?></a></li>
              <?php endfor; ?>
              <li>                                    
                <a href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>                            
        </div><!-- /paginator col -->
      </div><!-- /paginator row -->


    </div><!-- /main body col -->
  </div><!-- /main body row -->
  <div class="row">
    <div class="col-md-12">
      <?php $this->load->view('footer.php');?>                    
    </div>
  </div>
</div><!--container-flud -->
</body>
</html>




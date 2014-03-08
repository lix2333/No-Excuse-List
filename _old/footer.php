  </div>
 <div class="footer">
  <div class="row">
	  <div class="small-8 columns">
        <ul class="links">
          <li><a href="http://noexcuselist.com/">Home</a></li>
          <li><a href="http://noexcuselist.com/blog">Blog</a></li>
         <li><a href="http://noexcuselist.com/forum">Forum</a></li>
          <li><a href="http://noexcuselist.com/about">About</a></li>
           <li><a href="http://noexcuselist.com/forum/entry/signin?Target=discussions">Login</a></li>
       </ul>
       <p class="copyright">&copy; 2011&dash;2014 NOEXCUSELIST, Inc. All rights reserved.</p>
    </div>          
    <div class="small-4 columns">
      <ul class="home-social">
          <li><a href="http://www.facebook.com/noexcuselist"><img src="img/fb.png" alt="" title="" /></a></li>
          <li><a href="https://twitter.com/NoExcuseList" ><img src="img/twitter.png" alt="" title="" /></a></li>
          <li><a href="http://pinterest.com/pin/create/button/?url=http://noexcuselist.com/&media=http://noexcuselist.com/%2Fimg%2Flogo.png&description=The best place on the web to learn anything, free."><img src="img/pinterest.png" alt="" title="" /></a></li>
        </ul>
     </div>
  </div>
</div>
 

 
 
 
 
 
 <script src="bower_components/jquery/jquery.js"></script>
    <?php if($title == 'category'){ ?>

    <?php } ?>
    <script src="js/functions.js"></script>
         
       <div id="modal_login" class="reveal-modal" data-reveal="" >
    <h2>Whoa, hold on a second!</h2>
    <p>We're digging the enthusiasm, but you have to login to do that!</p>
<a class="close-reveal-modal">×</a>
</div>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
<script>
    $(document).foundation();
  </script>

  
<script src="js/jquery.masonry.js"></script>

<script>
      $('a.loves')
        .click(
          function(){
			  
            if($('nav.top-bar section.top-bar-section ul.right li:nth-child(20) a').text() == "Login"){
               $('#modal_login').foundation('reveal', 'open');
            } else {
                var id = $(this).attr('href');
                  id = id.replace("#","");
                $.ajax({
                  url: "includes/functions.php",
                  data: {func:'love',id:id},
                  success: function(data){
                    if($('.loves[href=#'+id+']').hasClass('loved')){
                      $('.loves[href=#'+id+']').removeClass('loved');
                    } else {
                      $('.loves[href=#'+id+']').addClass('loved');
                    }
                    $('.loves[href=#'+id+']').html("<span></span>"+data);
                  }
                })
            }
            return false;
          }
        );
</script>
<script>
	var $containter = $('#container');
	$containter.imagesLoaded( function(){
		$containter.masonry({
			itemSelector: '.box',
			isOriginLeft: false


		});	
	});
</script>
</div>
  </body>
</html>

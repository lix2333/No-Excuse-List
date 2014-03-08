 <div class="footer">
  <div class="row">
	  <div class="small-8 columns">
        <ul class="links">
          <li><a href="http://noexcuselist.com/testing/">Home</a></li>
          <li><a href="http://noexcuselist.com/testing/blog">Blog</a></li>
          <li><a href="http://noexcuselist.com/testing/forum">Forum</a></li>
          <li><a href="http://noexcuselist.com/testing/about">About</a></li>
          <li><a href="http://noexcuselist.com/testing/forum/entry/signin?Target=discussions">Login</a></li>
       </ul>
       <p class="copyright">&copy; 2012&dash;2014 NOEXCUSELIST, Inc. All rights reserved.</p>
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
  <script>
  // Love a link
      $('a.love')
        .click(
          function(){
            if($('nav.top-bar section.top-bar-section ul.right li:nth-child(20) a').text() == "Login"){
               // $('#modal_login').foundation('reveal', 'open');
            } else {
                var id = $(this).attr('href');
                  id = id.replace("#","");
                $.ajax({
                  url: "includes/functions.php",
                  data: {func:'love',id:id},
                  success: function(data){
                    if($('.love').hasClass('loved')){
                      $('.love').removeClass('loved');
                    } else {
                      $('.love').addClass('loved');
                    }
                    $('.love[href=#'+id+']').html("<span></span>"+data);
                  }
                })
            }
            return false;
          }
        );
         
  </script>
  
<script src="js/jquery.masonry.js"></script>

<script>
	var $containter = $('#container');
	$containter.imagesLoaded( function(){
		$containter.masonry({
			itemSelector: '.box',
			isOriginLeft: false


		});	
	});
</script>
    <script>
    var h = $(window).height()-24;
    $('iframe').height(h+'px');

    $('a.heart')
      .click(
        function(){
          var href = $('span#login a').attr('href');
          $('span#login').html("Please <a href='"+href+"'>Login</a> to love a link. | ");
          return false;
        }
      )

    $('a.heart')
      .click(
        function(){
          var id = $(this).attr('href');
            id = id.replace("#","");
          $.ajax({
            url: "../includes/functions.php",
            data: {func:'love',id:id},
            success: function(data){
              if($('.heart').hasClass('loved')){
                $('.heart').removeClass('loved');
              } else {
                $('.heart').addClass('loved');
              }
              $('.count').text(data+' | ');
            }
          })
          return false;
        }
      )
  </script>


  </body>
</html>

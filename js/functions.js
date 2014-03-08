$(document).ready(
  function(){
    // Setting up the searchbar functionality to show results
      $('#searchField').focus().select()
        .keyup(
          function(){
            var s = $(this).val();
            if(s != '' && s != 'What would you like to learn today?'){
              $.ajax({
                url: "ajax/search_results.php",
                data: {s:s},
                success: function(data){
                  $('#results').html(data);
                  if(!$('#results').hasClass('down')){
                    $('#results').fadeIn(250).addClass('down');
                    $('#legend').fadeIn(500).delay(1000).animate({opacity: .5},500);
                  }
                }
              })
            } else {
              $('#results').hide().removeClass('down');
            }
          }
        )
        .focus(
          function(){
            var s = $(this).val();
            if(s != '' && s != 'What would you like to learn today?'){
              $('#results').fadeIn();
            }
          }
        )
        .blur(
          function(){
            // $('#results').hide().removeClass('down');
          }
        )

    // When a link is clicked from the search results, add 1 to the database for that link, then send the user to the link
      $('.result')
        .live('click',
          function(){
            var id = $(this).attr('id');
            var link = $(this).attr('rel');
            if(link!=undefined){
              $.ajax({
                url: "includes/functions.php",
                data: {func:'addClick',id:id},
                success: function(){
                  window.location="li/?url="+link;
                }
              })
            }
          });

    
    // When a success or error message is shown, fade out after 5 seconds
      if($('.alert').length > 0){
        $('.alert').delay(5000).fadeOut(250);
      }

    if($('#sortableLinks').length > 0){
      $("#sortableLinks").sortable({
        deactivate: function(event,ui){
          var result = $('#sortableLinks').sortable('toArray');
          $.ajax({
            url: "category.php",
            data: {func:'sortIt',order:result}
          })
        }}).disableSelection();
    }

    /* Add a comment
      $('.commentSubmit')
        .live('click',
          function(){
            var id = $(this).parent().children('input[name=linkID]').val();
            var p = $(this).parent().children('input[name=parentID]').val();
            var type = $(this).parent().children('input[name=type]').val();
            var c = $(this).parent().children('textarea[name=comment]').val();
            var spam = $(this).parent().children('input[name=spamChecker]').val();
            if(spam == ''){
              $.ajax({
                url: "includes/functions.php",
                data: {func:'addComment',id:id,parent:p,comment:c,type:type},
                success: function(data){
                  if($('#noComments').length > 0){
                    $('#noComments').remove();
                  }
                  if(p==0){
                    $('#comments').prepend(data);
                  } else {
                    if($('#comment_'+p).length==0){
                      $('#reply'+p).parent().after("<ul id='comment_"+p+"'></ul>");
                    }
                    $('#comment_'+p).append(data);
                    $('#reply'+p).hide();
                  }
                }
              });
            }

            return false;
          }
        )

      $('.reply')
        .live('click',
          function(){
            var linkID = $(this).attr('id');
            var parentID = $(this).attr('rel');
            var type = $(this).attr('type');
            if($('#reply'+parentID).length == 0){
              $(this).parent().after("<form action='discuss' method='post' class='addComment' id='reply"+parentID+"'>\
                                      <input type='hidden' name='linkID' value='"+linkID+"' />\
                                      <input type='hidden' name='parentID' value='"+parentID+"' />\
                                      <input type='hidden' name='type' value='"+type+"' />\
                                      <input type='text' name='spamChecker' value='' class='spamChecker' />\
                                      <textarea name='comment' class='textarea'></textarea><br />\
                                      <input type='submit' value='Add Comment' class='button small commentSubmit' />\
                                      <input type='button' value='Cancel' class='button small commentCancel' />\
                                    </form>");
              $('#reply'+parentID+' .textarea').focus();
            } else {
              $('#reply'+parentID).show();
            }
            return false;
          })
        $('.commentCancel')
          .live('click',
            function(){
              $(this).parent().hide();
            })

    // Collapse / Expand Threads
      $('.collapse')
        .live('click',
          function(){
            if($(this).parent().parent().parent().hasClass('hideComments')){
              $(this).parent().parent().parent().removeClass('hideComments');
              $(this).text('[-]');
            } else {
              $(this).parent().parent().parent().addClass('hideComments');
              $(this).text('[+]');
            }
            return false;
          })

    // Delete a comment
      $('.deleteComment')
        .live('click',
          function(){
            var id = $(this).attr('rel');
            var comment = $('.comment[rel='+id+']').text();
            $('.comment[rel='+id+']').html("<span class='faded'>[comment deleted]</span>");
            $(this).text('undo').removeClass('deleteComment').addClass('undo').attr('c',comment);
            $.ajax({
              url: "includes/functions.php",
              data: {func:'deleteComment',id:id,t:''}
            })
            return false;
          });
        $('.undo')
          .live('click',
            function(){
              var id = $(this).attr('rel');
              var comment = $(this).attr('c');
              $('.comment[rel='+id+']').text(comment);
              $(this).text('delete').addClass('deleteComment').removeClass('undo').removeAttr('c');
              $.ajax({
                url: "includes/functions.php",
                data: {func:'deleteComment',id:id,t:comment}
              })
              return false;
            })

    // Focus on the title input when .startThread is shown
      if($('.startThread').length>0){
        $('input[name=title]').focus();
      } */

   
    // show the masonry layout if all categories are showing
      if($('.masonry').length > 0){
        $('.masonry').imagesLoaded(
          function(){
            $('.masonry').masonry({
              itemSelector: '.list'
            })
          }
        )
      }
  }
)

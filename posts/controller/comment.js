var thisPost = window.location.href.toString().replace(/http:\/\/blog\.agwconitsha\.org\/posts\/(20[0-9]{2}\/[0-9]{2}\/((([a-zA-Z]+)-?)+)(-[0-9]{2})?)\/?/, "$1"), error = false, replace;
function post () {
	var typedText = $("#new-comment textarea").val();
	$.post('http://blog.agwconitsha.org/posts/controller/make_new_comment.php', {new_comment: typedText, parent_post: thisPost}, function(e) {
		// empty comment box if comment was successfully submitted and hide animation
	$('#new-comment textarea').val("");
	$("#floatingCirclesG").replaceWith(replace).addClass("hide-anim");
	var update = document.createElement('DIV'); // This div is to hold the new parsed comment returned by the php script
   
	update = $(e).load(update); // This line loads it into the dom and the line below updates the comments count header    
	$('#comments h3').html(parseInt($('#comments h3').html(), 10) + 1 + " Responses");
    
	$('#comments').append($(update)); // Attaching the returned comment to the rest of the document
	var lastId = $(update).attr("id"); // Gives the new comment an ID and the line below pushes the window hash to the ID of the attached comment
		
	setTimeout(function() {
		window.location.href = window.location.href.indexOf("#") == -1 ? window.location.href + "#" + lastId: window.location.href.substring(0, window.location.href.indexOf("#")) + "#" + lastId;
		}, 2500);
});
}
function loadingComment () {
	if ($("#new-comment textarea").val().split(" ").length > 3) { // For some weird reason, I have to recheck if the comments count is more than 3 words else, it submits empty forms
		post();
	}
	else $("#new-comment input[type='submit']").attr('disabled', 'disabled');
}

$("textarea").focus(function(){
	$(this).parent().children("input[type='submit']").css("margin-top", 0);
}).parent().delegate("input[type='submit']", "click", function (e){
		e.preventDefault();
	var anim = $("#floatingCirclesG:hidden");
		// Only attempt to submit form If comments length is greater than three words
  
		if ($("#new-comment textarea").val().split(" ").length > 3) {
			$(this).removeAttr('disabled');
      			// If comment submitting function has not finished running, animation should keep on rotating
				$(anim).removeClass('hide-anim'); //Animation is hidden by default so unhide it
				$(this).replaceWith(function(){
          replace = $(this);
        return $(anim);
        });
      loadingComment();
		}
		
		else alert("comment too vague");
	}).attr('disabled', 'disabled');
	
	
// function to update view with new posts automatically
setTimeout(setInterval(function() {
	var comments_length = $('.comments_class').length;
	$.post('update.php', {curr_len: comments_length}, function(returned_len) {
		if (returned_len > comments_length) {
			$.post('update.php', {fetch: (returned_len - comments_length)}, function(fresh_posts) {
				$('#comments').append($(fresh_posts));
				$("title").html("(1) " + $("title").html());
			});
		}
	});
}, 50000), 25000);
var body = $('.articleBody');
for (var i = 0; i < body.length; i++) {
	body[i].innerHTML = body[i].innerHTML.substr(0, 300) + '...';
}
				
$(".more").click(function() {
	var that = $(this);
	$.post("http://blog.agwconitsha.org/users/controller/more.php", {post_url: that.attr("id")}, function(e) {
		$(that.attr("id") + " .articleBody").html(e);
	});
});
				
$(".push a").click(function(e) {
	e.preventDefault();
	var that = $(this);
	$("#floatingCirclesG").toggleClass('hide-anim');
	$(that).replaceWith($("#floatingCirclesG"));
	$("#floatingCirclesG").parent().css({border: 0}).hover(function() {
		$(this).css("background", "none");
	});
					
	$.post("push.php", {push: that.attr('href')}, function (data) {
		if (data = "Front page updated!") {
			$(that).parents(".new-post").hide("bounce", {times: 25}, 4500);
		}
	});
});
				
$(document).ready(function() {
	$(".new-post a[href*='#fancy']").fancybox({
		'hideOnContentClick': false
	});
	$("#fancy_outer").css({"float":"right","position":"static"});
});
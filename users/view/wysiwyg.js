var mainText = document.getElementsByTagName("textarea")[0];
		var selected = mainText.value.substring(mainText.selectionStart, mainText.selectionEnd);
		$('.paragraph').click(function(){
		mainText.value = mainText.value.substring(0,mainText.selectionStart)+"<p>"+selected+ "</p>"+mainText.value.substring(mainText.selectionEnd);
		});
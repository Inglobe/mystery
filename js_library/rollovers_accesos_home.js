$(document).ready(function(){
	$("#btn_01").hover(
		function(){
			$("#btn_01 h3 a").stop().animate({color:"#FFDA73;"}, 200);
			$("#btn_01 img").stop().animate({"width": 122,
            "height": 119,
			"left": 0,
            "top":  -10}, 150);
			$(this).css({backgroundPosition: '0px 0px'});
		},
		function(){
			$("#btn_01 h3 a").stop().animate({color:"#FFFFFF;"}, 200);
			$("#btn_01 img").stop().animate({"width": 93,
            "height": 91,
			"left": 30,
            "top":  5}, 150);
			$(this).css({backgroundPosition: '0px 100px'});
		}
	);
	$("#btn_02").hover(
		function(){
			$("#btn_02 h3 a").stop().animate({color:"#FFDA73;"}, 200);
			$("#btn_02 img").stop().animate({"width": 122,
            "height": 119,
			"left": 0,
            "top":  -10}, 150);
			$(this).css({backgroundPosition: '0px 0px'});
		},
		function(){
			$("#btn_02 h3 a").stop().animate({color:"#FFFFFF;"}, 200);
			$("#btn_02 img").stop().animate({"width": 93,
            "height": 91,
			"left": 30,
            "top":  5}, 150);
			$(this).css({backgroundPosition: '0px 100px'});
		}
	);
	$("#btn_03").hover(
		function(){
			$("#btn_03 h3 a").stop().animate({color:"#FFDA73;"}, 200);
			$("#btn_03 img").stop().animate({"width": 122,
            "height": 119,
			"left": 0,
            "top":  -10}, 150);
			$(this).css({backgroundPosition: '0px 0px'});
		},
		function(){
			$("#btn_03 h3 a").stop().animate({color:"#FFFFFF;"}, 200);
			$("#btn_03 img").stop().animate({"width": 93,
            "height": 91,
			"left": 30,
            "top":  5}, 150);
			$(this).css({backgroundPosition: '0px 100px'});
		}
	);
}); 
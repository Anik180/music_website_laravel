$(window).load(function(){$(".loader").delay(500).fadeOut(),$("#mask").delay(1e3).fadeOut("slow"),$("body").addClass("loaded")}),$(document).ready(function(){$("#slides").superslides({hashchange:!1,animation:"fade",play:1e4}),$("#owl-main-text").length>0&&$("#owl-main-text").owlCarousel({autoPlay:1e4,goToFirst:!0,goToFirstSpeed:2e3,navigation:!1,slideSpeed:700,pagination:!1,transitionStyle:"fadeUp",singleItem:!0}),$(".twitterfeed").length>0&&function(){var e={id:"702067549920485376",domId:"twitter-feed",maxTweets:4,enableLinks:!0,showUser:!0,showTime:!0,dateFunction:"",showRetweet:!1,customCallback:function(e){for(var t=e.length,i=0,a=document.getElementById("twitter-feed"),l='<ul class="slider-twitter">';t>i;)l+='<li class="gallery-cell">'+e[i]+"</li>",i++;l+="</ul>",a.innerHTML=l,$(".slider-twitter").flickity({cellAlign:"left",contain:!0,wrapAround:!0,prevNextButtons:!1})},showInteraction:!1};twitterFetcher.fetch(e)}();var e=$(".jcarouselDates").flickity({cellAlign:"left",wrapAround:!0,contain:!0,prevNextButtons:!1,pageDots:!1,draggable:!1});$(".button-group").on("click",".button",function(){var t=$(this).index();e.flickity("select",t),$(this).addClass("active").siblings().removeClass("active")}),$(".swipebox").swipebox(),$(".playerVideo").length>0&&($(".playerVideo").mb_YTPlayer(),jQuery(".playerVideo").on("YTPPause",function(){jQuery(".play-video").removeClass("playing")}),jQuery(".playerVideo").on("YTPPlay",function(){jQuery(".play-video").addClass("playing")}),jQuery(".play-video").on("click",function(e){jQuery(".play-video").hasClass("playing")?jQuery(".playerVideo").pauseYTP():(jQuery("audio").each(function(e,t){this.pause()}),jQuery(".playerVideo").playYTP()),e.preventDefault()}))}),$(window).load(function(){$(".upevents").isotope({itemSelector:".upevent",masonry:{columnWidth:".upevent"}}),$(".thumbnails").isotope({itemSelector:".thumbnail",masonry:{columnWidth:".thumbnail.small"}})}),jQuery().parallax&&jQuery(".parallax-section").parallax(),$("a[href*=#]").click(function(){if(location.pathname.replace(/^\//,"")===this.pathname.replace(/^\//,"")&&location.hostname===this.hostname){var e=$(this.hash);if((e=e.length&&e||$("[name="+this.hash.slice(1)+"]")).length){var t=e.offset().top;return $("html,body").animate({scrollTop:t-42},1e3),$(".navbar-collapse.in").removeClass("in").addClass("collapse"),!1}}}),$(function(){$(window).bind("scroll",function(){$(window).scrollTop()>=85?$("#jHeader").addClass("overflow"):$("#jHeader").removeClass("overflow"),$(window).scrollTop()>=$(".jIntro").height()/2?$("#jHeader").addClass("fixed"):$("#jHeader").removeClass("fixed")}),$(".disc-tracklist").on("click",function(){alert("CLICK")})}),$("#more-events").click(function(){return $(".upcomming-events-list li.more").slideToggle("slow"),$(this).hide(),!1}),jQuery(".submitMusicForm").hide(),jQuery("#submitClickBtn").click(function(){jQuery(".submitMusicForm").show("slow"),jQuery("#submitClickBtn").hide()});
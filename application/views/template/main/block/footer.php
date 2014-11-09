<footer class="footer">
	
	<a href="/">Home</a>
	&nbsp;|&nbsp;<a href="http://uawebs.net" target="_blank">UA Web Studio</a>
	&nbsp;|&nbsp;Напишите нам&nbsp;<a rel="nofollow" href="mailto:manager@uawebs.net" target="_blank">manager@uawebs.net</a>
	&nbsp;|&nbsp;<a href="https://plus.google.com/+ArtemKolombet/posts?rel=author" target="_blank">Артем Коломбет</a>&#169;
	
	<?php if($tracking->show === true && $tracking->ga === true) { ?>
	
	<div class="google-analytics">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-12093421-3', 'uawebs.net');
		  ga('send', 'pageview');
		
		</script>
	
	</div>
	
	<?php } ?>
	
	<?php if($tracking->show === true && $tracking->ya === true) { ?>
	
	<div class="yandex-metrika">
		<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24857843 = new Ya.Metrika({id:24857843, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24857843" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
	</div>
	
	<?php } ?>
</footer>
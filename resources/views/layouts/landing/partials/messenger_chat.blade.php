 <!-- Load Facebook SDK for JavaScript -->
 <div id="fb-root"></div>
 <script>
     window.fbAsyncInit = function() {
         FB.init({
             xfbml: true,
             version: 'v7.0'
         });
     };
     (function(d, s, id) {
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) return;
         js = d.createElement(s);
         js.id = id;
         js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
         fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
 </script>
 <!-- Your Chat Plugin code -->
 <div class="fb-customerchat" attribution=install_email page_id="547530305729014" theme_color="#ff5ca1">
 </div>
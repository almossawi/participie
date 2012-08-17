			document.write("<div id='fb-root'></div>");
			
	    	// Load the SDK Asynchronously
			(function(d){
				var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement('script'); js.id = id; js.async = true;
				js.src = "//connect.facebook.net/en_US/all.js";
				ref.parentNode.insertBefore(js, ref);
			}(document));

        window.fbAsyncInit = function() {
          FB.init({
            appId      : '310995648970748',
            status     : true, 
            cookie     : true,
            xfbml      : true,
            oauth      : true,
          });
          
        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has auth'd your app and is logged into Facebook
            //alert("user has auth'd your app and is logged into Facebook");
            FB.api('/me', function(me){
              if (me.name) {
                $('#fb-name').html(me.name);
                $('#fb-location').html(me.location.name);
                facebookFillForm();
                
                $('.fb-thumb').attr("src",'https://graph.facebook.com/' + me.id + '/picture');
                $('.fb-thumb').css("border",'3px solid #cccccc');
              }
            }, {scope: 'user_location'})
          } else {
            // user has not auth'd your app, or is not logged into Facebook
            //alert("user has not auth'd your app, or is not logged into Facebook");
          }
        });
        };
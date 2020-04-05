(function (factory) {
    typeof define === 'function' && define.amd ? define('jqueryLazymap', factory) :
    factory();
}((function () { 'use strict';

    /*!
     * https://github.com/ZioTino/jquery.lazymap
     * Simply loads any maps created with Google Maps API when it comes visibile in the viewport.
     * You can check when the map loads by going into the Developer tools inside your browser, search for the Network tab and reload the page.
     */

    window.gmapScriptLoaded = function () {
      $(window).trigger('gmapScriptLoaded');
    };

    (function ($, window) {
      'namespace lazymap';

      $.fn.lazymap = function (options) {
        var $window = $(window),
            $body = $('body'),
            windowHeight = $window.height(),
            windowScrollTop = 0,
            apiScriptLoaded = false,
            apiScriptLoading = false,
            $settings = $.extend({
          zoomAttr: 'data-zoom',
          locationAttr: 'data-locations',
          keepAttributes: ['class'],
          apiKey: '',
          culture: '',
          markerAttr: 'data-marker'
        }, options);

        function debounce(delay, fn) {
          var timer = null;
          return function () {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
              fn.apply(context, args);
            }, delay);
          };
        }

        function throttle(delay, fn) {
          var last, deferTimer;
          return function () {
            var context = this,
                args = arguments,
                now = +new Date();

            if (last && now < last + delay) {
              clearTimeout(deferTimer);
              deferTimer = setTimeout(function () {
                last = now;
                fn.apply(context, args);
              }, delay);
            } else {
              last = now;
              fn.apply(context, args);
            }
          };
        }

        var ret = this.each(function () {
          var obj = this;
          if (this.lazymap || !$(this).hasClass('map')) return;
          obj.lazymap = {
            // latitude: 0,
            // longitude: 0,
            zoom: 0,
            removeData: function (A) {
              var attributes = $.map(A.attributes, function (item) {
                return item.name;
              });
              $.each(attributes, function (i, attr) {
                $.each($settings.keepAttributes, function (i, keepAttr) {
                  if (attr != keepAttr && A.hasAttribute(attr)) {
                    $(A).removeAttr(attr);
                  }
                });
              });
            },
            createMap: function () {
              var O = this;
              windowScrollTop = $window.scrollTop();
              if ($(obj).hasClass('loaded')) return true;
              if ($(obj).offset().top - windowScrollTop > windowHeight * 1) return true;

              if (!apiScriptLoaded && !apiScriptLoading) {
                $body.append('<script async defer src="https://maps.googleapis.com/maps/api/js?key=' + $settings.apiKey + '&callback=gmapScriptLoaded&language=' + $settings.culture + '"></script>');
                apiScriptLoading = true;
              }

              if (!apiScriptLoaded) return true;
              O.zoom = parseInt($(obj).attr($settings.zoomAttr));
              var settingsToParse = $(obj).attr($settings.locationAttr).split("], ");
              var index = 0;
              var values = [];
              settingsToParse.forEach(function (el) {
                if (index + 1 < settingsToParse.length) {
                  el = el + "]";
                }

                values[index] = JSON.parse(el);
                index++;
              });
              var position = new google.maps.LatLng(values[0][0], values[0][1]);
              var map = new google.maps.Map(obj, {
                center: position,
                zoom: O.zoom
              });
              var markerToParse = $(obj).attr($settings.markerAttr).split("], ");
              var marker_index = 0;
              var markers = [];
              markerToParse.forEach(function (el) {
                if (marker_index + 1 < markerToParse.length) {
                  el = el + "]";
                }

                markers[marker_index] = JSON.parse(el);
                marker_index++;
              });
              var marker_idx = 0;
              var green_icon = '../../wp-content/themes/wp-rbf1982-theme/img/map-pins/pin-blue-10.png';
              var blue_icon = '../../wp-content/themes/wp-rbf1982-theme/img/map-pins/pin-green-10.png';
              values.forEach(function (val) {
                var title = markers[marker_idx][0];
                var icon;

                if (marker_idx > 0) {
                  icon = green_icon;
                } else {
                  icon = blue_icon;
                }

                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(val[0], val[1]),
                  map: map,
                  animation: google.maps.Animation.DROP,
                  icon: icon
                });
                var contentString = '<b>' + title.toString() + '</b><br>';
                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });
                marker.addListener('click', function () {
                  infowindow.open(map, marker);
                });
                marker_idx++;
              });
              O.removeData(obj);
              $(obj).addClass("loaded");
            },
            listen: function () {
              var O = this;
              $window.on('gmapScriptLoaded', function () {
                apiScriptLoaded = true;
                O.createMap();
              }).on('load scroll', throttle(250, O.createMap)).on('resize', debounce(250, function () {
                windowHeight = $window.height();
                O.createMap();
              }));
            }
          };
          obj.lazymap.listen();
        });
        return ret.length === 1 ? ret[0] : ret;
      };
    })(jQuery, window);

})));
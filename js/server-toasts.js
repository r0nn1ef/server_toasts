(function (Drupal, once, $, drupalSettings) {

  'use strict';

  Drupal.behaviors.serverToastsBehavior = {
    attach: function (context, settings) {
      $(once('server-toasts-once', '#server-toast-container', context)).each(function () {

        /*
         * Create a callback function for setTimeout that starts the toasts.
         */
        const initToasts = function () {
          if(typeof(EventSource)!=="undefined") {
            const container = document.getElementById('server-toast-container');
            let evtSource = new EventSource('/toasts');
            /*
             * You can add multiple listeners here based on event types.
             * @see ServerToastsController::toast()
             */
            evtSource.addEventListener("toast", (event) => {
              let ls = JSON.parse(localStorage.getItem('Drupal.serverToasts.toasts'));
              if( ls === null || ls === undefined ) {
                ls = [];
              }
              let data = JSON.parse(event.data);
              if ( !ls.includes(event.lastEventId) ) {
                let div = document.createElement('div');
                div.innerHTML = data.content.trim();
                let toast = div.firstChild;
                let el = container.appendChild(toast);
                setTimeout(function(el){
                  $(el).fadeOut(600).slideUp(1000, function(){
                    this.remove();
                  });
                }, 30000, el);
                ls.push(event.lastEventId);
                localStorage.setItem('Drupal.serverToasts.toasts', JSON.stringify(ls));
              }
            });
          } else {
            console.log('Your browser does not support EventSource ... terminating.');
          }
        }

        // Delay toast notifications to 6 seconds after page load.
        setTimeout(initToasts, 6000);

      });
    }
  };
})(Drupal, once, jQuery, drupalSettings);

(function ($) {

  var $btn = $("#lazy-intercom-btn");

  $btn.one("click.ic", function () {
    loadIntercom();
    $(this).find('.lic-chat').hide().end()
      .find('.lic-loader').show()
  });

  function loadIntercom() {
    var w = window;
    var ic = w.Intercom;

    if (typeof ic === "function") {
      ic('reattach_activator');
      ic('update', intercomSettings);
    } else {
      var d = document;
      var i = function () {
        i.c(arguments)
      };
      i.q = [];
      i.c = function (args) {
        i.q.push(args)
      };
      w.Intercom = i;

      function l() {
        var s = d.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://widget.intercom.io/widget/s7o8rm6s';
        var x = d.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      }

      l();
    }

    Intercom('show');

    Intercom('onShow', function () {
      $btn.remove();
    });
  }

  $('a[href*="wp-login.php?action=logout"]').on('click.ic', function () {
    window.Intercom && Intercom('shutdown');
  });

})(jQuery);

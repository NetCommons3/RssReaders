/**
 * @fileoverview Rssreader Javascript
 * @author k_miura@zenk.co.jp (Kosuke Miura)
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * RssReaders Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http, NetCommonsTab)} Controller
 */
NetCommonsApp.controller('RssReaders',
    function($scope, $http, NetCommonsTab) {

      /**
       * tab
       *
       * @type {object}
       */
      $scope.tab = NetCommonsTab.new();

      /**
       * Initialize
       *
       * @param {Object.<string>} rssReaderData
       * @return {void}
       */
      $scope.initialize = function(data) {
        $scope.frameId = data.frameId;
      };

      /**
       * Switching display of the site information
       *
       * @return {void}
       */
      $scope.switchDisplaySiteInfo = function() {
        var element = $('#nc-rss-readers-' +
                        $scope.frameId + ' div.rss-site-info');
        if (element.hasClass('hidden')) {
          element.removeClass('hidden');
        } else {
          element.addClass('hidden');
        }
      };

      /**
       * Get url
       *
       * @return {void}
       */
      $scope.getSiteInfo = function() {
        var element = $('input[name="data[RssReader][url]"]');

        $http.get('/rss_readers/rss_readers/get/' + $scope.frameId + '.json',
            {params: {url: element[0].value}})
          .success(function(data) {
              element = $('input[name="data[RssReader][title]"]');
              if (! angular.isUndefined(element[0]) &&
                      ! angular.isUndefined(data['title'])) {
                element[0].value = data['title'];
              }

              element = $('input[name="data[RssReader][link]"]');
              if (! angular.isUndefined(element[0]) &&
                      ! angular.isUndefined(data['link'])) {
                element[0].value = data['link'];
              }

              element = $('textarea[name="data[RssReader][summary]"]');
              if (! angular.isUndefined(element[0]) &&
                      ! angular.isUndefined(data['summary'])) {
                element[0].value = data['summary'];
              }

              $scope.urlError = '';
            })
          .error(function(data) {
              $scope.urlError =
                  angular.isUndefined(data['error']) ? data['name'] : data['error'];
            });
      };

    });

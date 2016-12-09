/**
 * @fileoverview Rssreader Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * RssReaders Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http)} Controller
 */
NetCommonsApp.controller('RssReaders',
    ['$scope', '$http', 'NC3_URL', function($scope, $http, NC3_URL) {

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
       * URLからデータ取得
       *
       * @return {void}
       */
      $scope.getSiteInfo = function() {
        var element = $('input[name="data[RssReader][url]"]');

        $http.get(NC3_URL + '/rss_readers/rss_readers/get.json',
            {params: {frame_id: $scope.frameId, url: element[0].value}})
            .then(function(response) {
              var data = response.data;
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
            },
            function(response) {
              var data = response.data;
              $scope.urlError =
                  angular.isUndefined(data['error']) ? data['name'] : data['error'];
            });
      };

    }]);

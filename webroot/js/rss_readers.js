/**
 * @fileoverview Rssreader Javascript
 * @author k_miura@zenk.co.jp (Kosuke Miura)
 */


/**
 * RssReader Javascript
 *
 * @param {string} controller name
 * @param {function(scope, http)} Controller
 */
NetCommonsApp.controller('RssReaders',
                         function($scope, $http) {

      /**
       * button of rssreader index
       *
       * @type {{value: boolean}}
       */
      $scope.visibleHeaderBtn = true;

      /**
       * site info of rssreader index
       *
       * @type {{value: boolean}}
       */
      $scope.visibleSiteInformation = true;

      /**
       * visible publish of rssreader index
       *
       * @type {{value: boolean}}
       */
      $scope.visiblePublish = true;

      /**
       * visible container of rssreader index
       *
       * @type {{value: boolean}}
       */
      $scope.visibleContainer = true;

      /**
       * button of get rss info
       *
       * @type {{value: boolean}}
       */
      $scope.getRssInfoBtn = true;

      /**
       * button of loading get rss info
       *
       * @type {{value: boolean}}
       */
      $scope.loadingGetRssInfoBtn = false;

      /**
       * sending
       *
       * @type {{value: boolean}}
       */
      $scope.sending = false;

      /**
       * Initialize
       *
       * @param {Object.<string>} rssReaderData
       * @param {int} frameId
       * @return {void}
       */
      $scope.initialize = function($rssReaderData, $frameId) {
        $scope.rssReaderData = $rssReaderData;
        $scope.frameId = $frameId;
      };

      /**
       * Update RssReader Status
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.updateStatus = function(postStatus) {
        $http({
          method: 'POST',
          url: '/rss_readers/rss_readers/updateStatus',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          transformRequest: function(obj) {
            var str = [];
            for (var p in obj)
              str.push(encodeURIComponent(p) + '=' +
                       encodeURIComponent(obj[p]));
            return str.join('&');
          },
          data: {id: $scope.rssReaderData.RssReader.id, status: postStatus}
        }).success(function(data, status, headers, config) {
          // 成功
          location.reload();
        }).error(function(data, status, headers, config) {
          // 失敗
        });
      };

      /**
       * Show Manage Modal
       *
       * @return {void}
       */
      $scope.showManage = function() {
        $('#nc-rss-readers-manage-modal-' + $scope.frameId).modal('show');
        $scope.url = $scope.rssReaderData.RssReader.url;
        $scope.title = $scope.rssReaderData.RssReader.title;
        $scope.summary = $scope.rssReaderData.RssReader.summary;
        $scope.link = $scope.rssReaderData.RssReader.link;
      };

      /**
       * Save RssReader Data
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.saveRssReader = function(postStatus) {
        $scope.saveRssReaderError = false;
        $scope.sending = true;
        $paramData = $('#form-rss-reader-edit-' + $scope.frameId).serialize();
        $paramData = $paramData + '&' +
                encodeURIComponent('data[RssReader][status]') +
                '=' + encodeURIComponent(postStatus);
        $http({
          method: 'POST',
          url: '/rss_readers/rss_readers/edit',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          data: $paramData
        }).success(function(data, status, headers, config) {
          // 成功
          location.reload();
        }).error(function(data, status, headers, config) {
          // 失敗
          $scope.saveRssReaderError = true;
          $scope.saveRssReaderErrorMessage = data.message;
          $scope.sending = false;
        });
      };

      /**
       * Get RssReader Info
       *
       * @return {void}
       */
      $scope.getRssInfo = function() {
        $scope.getRssInfoBtn = false;
        $scope.loadingGetRssInfoBtn = true;
        $scope.rssReader['data[RssReader][url]'].$valid = true;
        $scope.getRssInfoErrorMessage = '';
        $http({
          method: 'POST',
          url: '/rss_readers/rss_readers/getRssInfo',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          transformRequest: function(obj) {
            var str = [];
            for (var p in obj)
              str.push(encodeURIComponent(p) + '=' +
                       encodeURIComponent(obj[p]));
            return str.join('&');
          },
          data: {url: $scope.url}
        }).success(function(data, status, headers, config) {
          // 成功
          $scope.title = data.data.title;
          $scope.summary = data.data.summary;
          $scope.link = data.data.link;

          $scope.getRssInfoBtn = true;
          $scope.loadingGetRssInfoBtn = false;
        }).error(function(data, status, headers, config) {
          // 失敗
          $scope.getRssInfoBtn = true;
          $scope.loadingGetRssInfoBtn = false;
          $scope.rssReader['data[RssReader][url]'].$valid = false;
          $scope.getRssInfoErrorMessage = data.message;
        });
      };

      /**
       * Save RssReaderFrameSetting Data
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.saveRssReaderFrameSettig = function() {
        $scope.saveRssReaderFrameSuccess = false;
        $scope.saveRssReaderFrameError = false;
        $scope.sending = true;
        $paramData = $('#form-rss-reader-frame-setting-edit' +
                       $scope.frameId).serialize();
        $http({
          method: 'POST',
          url: '/rss_readers/rss_readers/editFrameSetting',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          data: $paramData
        }).success(function(data, status, headers, config) {
          // 成功
          location.reload();
        }).error(function(data, status, headers, config) {
          // 失敗
          $scope.saveRssReaderFrameError = true;
          $scope.saveRssReaderFrameErrorMessage = data.message;
          $scope.sending = false;
        });
      };
    }
);

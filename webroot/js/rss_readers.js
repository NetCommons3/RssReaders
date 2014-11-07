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
                         function($scope, $http, $sce, $modal, $modalStack) {

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
       * @param {Object.<string>} RssReaderFrameSettingData
       * @param {int} frameId
       * @return {void}
       */
      $scope.initialize = function($rssReaderData,
          $rssReaderFrameSettingData, $frameId) {
        $scope.rssReaderData = $rssReaderData;
        $scope.rssReaderFrameSettingData = $rssReaderFrameSettingData;
        $scope.frameId = $frameId;
      };

      /**
       * Update RssReader Status
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.updateStatus = function(postStatus) {
        var paramData = [
          {
            name: 'data[RssReader][id]',
            value: $scope.rssReaderData.RssReader.id
          },
          {
            name: 'data[RssReader][status]',
            value: postStatus
          }
        ];
        // SecuryコンポーネントのToken値を取得する
        $http.get('/rss_readers/rss_readers/get_update_status_token/' +
            $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              // フォームエレメント生成
              var form = $('<div>').html(data);
              // セキュリティキーセット
              paramData.push({
                name: 'data[_Token][key]',
                value: $(form).find('input[name="data[_Token][key]"]').val()
              });
              paramData.push({
                name: 'data[_Token][fields]',
                value: $(form).find('input[name="data[_Token][fields]"]').val()
              });
              paramData.push({
                name: 'data[_Token][unlocked]',
                value: $(form)
                    .find('input[name="data[_Token][unlocked]"]').val()
              });
              // 登録情報をPOST
              $scope.sendPostUpdateStatus(paramData);
            })
            .error(function(data, status) {
            });
      };

      /**
       * send post update status
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.sendPostUpdateStatus = function(postParams) {
        $http.post('/rss_readers/rss_readers/update_status/' +
            $scope.frameId + '/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
            .success(function(data) {
              // 成功
              location.reload();})
            .error(function(data) {
              // 失敗
            });
      };

      /**
       * Change tab
       *
       * @param {number} tab
       * - edit
       * - displayChange
       * @return {void}
       */
      $scope.changeTab = function(tab) {
        //cancel the modal window that is already opened
        $modalStack.dismissAll('canceled');

        var templateUrl = '';
        var controller = '';
        switch (tab) {
          case 'rssReader':
            templateUrl = 'rss_readers/rss_reader_edit/view/' + $scope.frameId,
            controller = 'RssReaders.edit';
            break;
          case 'rssReaderFrameSetting':
            templateUrl = 'rss_readers/rss_reader_frame_settings/edit/' +
                          $scope.frameId,
            controller = 'RssReaderFrameSettings.edit';
            break;
          default:
            return;
        }

        //display the dialog.
        $modal.open({
          templateUrl: templateUrl,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        }).result.then(
            function(result) {},
            function(reason) {
              if (typeof reason.data === 'object') {
              } else if (reason === 'canceled') {
                //キャンセル
                $scope.flash.close();
              }
            }
        );
      };

      /**
       * Show Manage Modal
       *
       * @return {void}
       */
      $scope.showManage = function() {
        $scope.changeTab('rssReader');
      };
    }
);


/**
 *
 * RssReader.edit Javascript
 *
 * @param {string} controller name
 * @param {function(scope, http)} Controller
 */
NetCommonsApp.controller('RssReaders.edit',
                         function($scope, $http, $sce, $modal, $modalStack) {

      /**
       * Initialize
       *
       * @param {Object.<string>} rssReaderData
       * @return {void}
       */
      $scope.initialize = function($rssReaderData) {
        $scope.rssReaderData = $rssReaderData;
      };

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalStack.dismissAll('canceled');
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
        var paramData = $('#form-rss-reader-edit-' +
            $scope.frameId).serializeArray();
        // SecuryコンポーネントのToken値を取得する
        $http.get('/rss_readers/rss_reader_edit/get_edit_token/' +
            $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              // フォームエレメント生成
              var form = $('<div>').html(data);

              // セキュリティキーセット
              paramData.push({
                name: 'data[_Token][key]',
                value: $(form).find('input[name="data[_Token][key]"]').val()
              });
              paramData.push({
                name: 'data[_Token][fields]',
                value: $(form).find('input[name="data[_Token][fields]"]').val()
              });
              paramData.push({
                name: 'data[_Token][unlocked]',
                value: $(form)
                    .find('input[name="data[_Token][unlocked]"]').val()
              });

              // ステータスをセット
              paramData.push({
                name: 'data[RssReader][status]',
                value: postStatus
              });
              // 登録情報をPOST
              $scope.sendPostEdit(paramData);
            })
            .error(function(data, status) {
            });
      };

      /**
       * send post edit
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.sendPostEdit = function(postParams) {
        $http.post('/rss_readers/rss_reader_edit/edit/' +
            $scope.frameId + '/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
            .success(function(data) {
              // 成功
              location.reload();})
            .error(function(data) {
              // 失敗
              $scope.saveRssReaderError = true;
              $scope.saveRssReaderErrorMessage = data.name;
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
        $scope.getRssInfoErrorMessage = '';
        $http.get('/rss_readers/rss_reader_edit/get_rss_info/' +
            $scope.frameId + '/' + Math.random() + '.json' + '?url=' +
            $scope.rssReaderData.RssReader.url,
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
        .success(function(data) {
              // 成功
              $scope.rssReaderData.RssReader.title = data.title;
              $scope.rssReaderData.RssReader.summary = data.summary;
              $scope.rssReaderData.RssReader.link = data.link;
              $scope.getRssInfoBtn = true;
              $scope.loadingGetRssInfoBtn = false;})
        .error(function(data, status) {
              // 失敗
              $scope.getRssInfoBtn = true;
              $scope.loadingGetRssInfoBtn = false;
              $scope.getRssInfoErrorMessage = data.name;
            });
      };
    }
);

NetCommonsApp.controller('RssReaderFrameSettings.edit',
                         function($scope, $http, $sce, $modal, $modalStack) {

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalStack.dismissAll('canceled');
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
        var paramData = $('#form-rss-reader-frame-setting-edit-' +
            $scope.frameId).serializeArray();
        // SecuryコンポーネントのToken値を取得する。
        $http.get('/rss_readers/rss_reader_frame_settings/get_edit_token/' +
            $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              // フォームエレメント生成
              var form = $('<div>').html(data);

              // セキュリティキーセット
              paramData.push({
                name: 'data[_Token][key]',
                value: $(form).find('input[name="data[_Token][key]"]').val()
              });
              paramData.push({
                name: 'data[_Token][fields]',
                value: $(form).find('input[name="data[_Token][fields]"]').val()
              });
              paramData.push({
                name: 'data[_Token][unlocked]',
                value: $(form)
                    .find('input[name="data[_Token][unlocked]"]').val()
              });

              // 登録情報をPOST
              $scope.sendPostEdit(paramData);
            })
            .error(function(data, status) {
            });
      };

      /**
       * send post edit
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.sendPostEdit = function(postParams) {
        $http.post('/rss_readers/rss_reader_frame_settings/edit/' +
            $scope.frameId + '/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              // 成功
              location.reload();})
          .error(function(data) {
              // 失敗
              $scope.saveRssReaderFrameError = true;
              $scope.saveRssReaderFrameErrorMessage = data.message;
              $scope.sending = false;
            });
      };
    }
);

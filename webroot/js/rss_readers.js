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
            templateUrl = 'rss_readers/rss_reader_edit/view/' + $scope.frameId;
            controller = 'RssReaders.edit';
            $scope.openModal(templateUrl, controller);
            break;
          case 'rssReaderFrameSetting':
            templateUrl = 'rss_readers/rss_reader_frame_settings/view/' +
                          $scope.frameId;
            controller = 'RssReaderFrameSettings.edit';
            $scope.openModal(templateUrl, controller);
            break;
          default:
            return;
        }
      };

      /**
       * OPEN MODAL
       *
       * @param {string} templateurl
       * @param {string} controller
       * - edit
       * - displayChange
       * @return {void}
       */
      $scope.openModal = function(templateUrl, controller) {
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
        templateUrl = 'rss_readers/rss_reader_edit/view/' + $scope.frameId;
        controller = 'RssReaders.edit';
        $scope.openModal(templateUrl, controller);
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
       * edit _method
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST',
        data: {}
      };

      /**
       * @param {Object.<string>} rssReaderData
       * @param {Object.<int>} blockId
       * @param {Object.<int>} roomId
       * @param {Object.<int>} languageId
       *
       * @return {void}
       */
      $scope.initialize = function(
          $rssReaderData, $blockId, $roomId, $languageId) {
        $scope.edit.data = {
          RssReader: {
            url: $rssReaderData.RssReader.url,
            title: $rssReaderData.RssReader.title,
            summary: $rssReaderData.RssReader.summary,
            link: $rssReaderData.RssReader.link,
            cache_time: $rssReaderData.RssReader.cache_time,
            id: $rssReaderData.RssReader.id,
            status: ''
          },
          Block: {
            id: $blockId,
            room_id: $roomId,
            language_id: $languageId
          },
          Frame: {
            id: $scope.frameId
          },
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        };
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
       * Update RssReader Status
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.updateStatus = function(postStatus) {
        var paramData = {
          RssReader: {
            id: $scope.data.edit.RssReader.id,
            status: postStatus
          },
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        };
        // SecuryコンポーネントのToken値を取得する
        $http.get('/rss_readers/rss_readers/form/' +
            $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              // フォームエレメント生成
              var form = $('<div>').html(data);

              // セキュリティキーセット
              paramData._Token.key =
                  $(form).find('input[name="data[_Token][key]"]').val();
              paramData._Token.fields =
                  $(form).find('input[name="data[_Token][fields]"]').val();
              paramData._Token.unlocked =
                  $(form).find('input[name="data[_Token][unlocked]"]').val();
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
       * Save RssReader Data
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.saveRssReader = function(postStatus) {
        $scope.saveRssReaderError = false;
        $scope.sending = true;
        // SecuryコンポーネントのToken値を取得する
        $http.get('/rss_readers/rss_reader_edit/form/' +
            $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              // フォームエレメント生成
              var form = $('<div>').html(data);

              // セキュリティキーセット
              $scope.edit.data._Token.key =
                  $(form).find('input[name="data[_Token][key]"]').val();
              $scope.edit.data._Token.fields =
                  $(form).find('input[name="data[_Token][fields]"]').val();
              $scope.edit.data._Token.unlocked =
                  $(form).find('input[name="data[_Token][unlocked]"]').val();

              // ステータスをセット
              $scope.edit.data.RssReader.status = postStatus;

              // 登録情報をPOST
              $scope.sendPostEdit($scope.edit);
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
            $scope.edit.data.RssReader.url,
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
        .success(function(data) {
              // 成功
              $scope.edit.data.RssReader.title = data.title;
              $scope.edit.data.RssReader.summary = data.summary;
              $scope.edit.data.RssReader.link = data.link;
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
       * edit _method
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST',
        data: {}
      };

      /**
       * @param {Object.<string>} rssReaderFrameSettingData
       * @param {Object.<int>} blockId
       * @param {Object.<int>} roomId
       * @param {Object.<int>} languageId
       *
       * @return {void}
       */
      $scope.initialize = function(
          $rssReaderFrameSettingData, $blockId, $roomId, $languageId) {
        $scope.edit.data = {
          RssReaderFrameSetting: {
            display_number_per_page:
                $rssReaderFrameSettingData
                    .RssReaderFrameSetting.display_number_per_page,
            display_site_info:
                $rssReaderFrameSettingData
                    .RssReaderFrameSetting.display_site_info,
            display_summary:
                $rssReaderFrameSettingData
                    .RssReaderFrameSetting.display_summary,
            frame_key:
                $rssReaderFrameSettingData.RssReaderFrameSetting.frame_key,
            id: $rssReaderFrameSettingData.RssReaderFrameSetting.id
          },
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        };
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
       * Save RssReaderFrameSetting Data
       *
       * @param {string} postStatus
       * @return {void}
       */
      $scope.saveRssReaderFrameSettig = function() {
        $scope.saveRssReaderFrameSuccess = false;
        $scope.saveRssReaderFrameError = false;
        $scope.sending = true;
        if ($scope.edit.data.RssReaderFrameSetting.display_site_info) {
          $scope.edit.data.RssReaderFrameSetting.display_site_info = 1;
        } else {
          $scope.edit.data.RssReaderFrameSetting.display_site_info = 0;
        }
        if ($scope.edit.data.RssReaderFrameSetting.display_summary) {
          $scope.edit.data.RssReaderFrameSetting.display_summary = 1;
        } else {
          $scope.edit.data.RssReaderFrameSetting.display_summary = 0;
        }
        // SecuryコンポーネントのToken値を取得する。
        $http.get('/rss_readers/rss_reader_frame_settings/form/' +
            $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              // フォームエレメント生成
              var form = $('<div>').html(data);

              // セキュリティキーセット
              $scope.edit.data._Token.key =
                  $(form).find('input[name="data[_Token][key]"]').val();
              $scope.edit.data._Token.fields =
                  $(form).find('input[name="data[_Token][fields]"]').val();
              $scope.edit.data._Token.unlocked =
                  $(form).find('input[name="data[_Token][unlocked]"]').val();

              // 登録情報をPOST
              $scope.sendPostEdit($scope.edit);
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

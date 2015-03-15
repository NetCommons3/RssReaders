/**
 * @fileoverview Rssreader Javascript
 * @author k_miura@zenk.co.jp (Kosuke Miura)
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * RssReaders Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce, NetCommonsTab)} Controller
 */
NetCommonsApp.controller('RssReaders', function($scope, $sce, NetCommonsTab) {

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
   * Switching display of item summary
   *
   * @return {void}
   */
  $scope.switchDisplaySummary = function(id) {
    var element = $(id);
    if (element.hasClass('hidden')) {
      element.removeClass('hidden');
    } else {
      element.addClass('hidden');
    }
  };

  /**
   * Switching display of the site information
   *
   * @return {void}
   */
  $scope.switchDisplaySiteInfo = function() {
    var element = $('#nc-rss-readers-' + $scope.frameId + ' div.rss-site-info');
    if (element.hasClass('hidden')) {
      element.removeClass('hidden');
    } else {
      element.addClass('hidden');
    }
  };

  /**
   * Get site information
   *
   * @return {void}
   */
  $scope.getSiteInfo = function() {
    var element = $('input[name="data[RssReader][url]"]');
    location.href = '/rss_readers/rss_readers/edit/' + $scope.frameId +
                    '?url=' + encodeURIComponent(element[0].value);
  };
});

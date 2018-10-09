/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.4.7
 *
 * Extension to bootstrap datepicker to use noconflict approach
 * so that the plugin does not conflict with other jquery plugins
 * of similar name
 *
 * Built for Yii Framework 2.0
 * Author: Kartik Visweswaran
 * For more Yii related demos visit http://demos.krajee.com
 */var initDPRemove=function(){},initDPAddon=function(){};!function(t){"use strict";t.fn.kvDatepicker=t.fn.datepicker.noConflict(),initDPRemove=function(e,n){var i,c=t("#"+e),o=c.parent();o.find(".kv-date-remove").on("click.kvdatepicker",function(){n?o.find('input[type="text"]').each(function(){t(this).kvDatepicker("clearDates").trigger("change")}):(o.kvDatepicker("clearDates"),i=o.is("input")?o:o.find('input[type="text"]'),i.trigger("change"))})},initDPAddon=function(e){var n=t("#"+e),i=n.parent(),c=".input-group-addon:not(.kv-date-picker):not(.kv-date-remove),.input-group-text:not(.kv-date-picker):not(.kv-date-remove)";i.find(c).each(function(){var e=t(this);e.on("click.kvdatepicker",function(){i.kvDatepicker("hide")})}),i.find(".input-group-addon.kv-date-picker").on("click.kvdatepicker",function(){n.focus()})}}(window.jQuery);
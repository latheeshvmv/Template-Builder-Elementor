jQuery(document).ready(function($) {
  "use-strict";
  sm = parseInt(tmpenvoDataLoder.sm); //460 - loaded from database
  md = parseInt(tmpenvoDataLoder.md); //720 - loaded from database
  lg = parseInt(tmpenvoDataLoder.lg); //1120 - loaded from database

  var tmpenvoIsBreakPoint = function(bp) {
    var bps = [sm, md, lg],
      w = $(window).width(),
      min, max
    for (var i = 0, l = bps.length; i < l; i++) {
      if (bps[i] === bp) {
        min = bps[i - 1] || 0
        max = bps[i]
        break
      }
    }
    return w > min && w <= max
  }

  function tmpenvoAdjustSize() {
    $('.tmpenvo-background-wrapper').each(function() {

      var tmpenvoData = jQuery.parseJSON($(this).attr('data-tmpenvo'));
      $(this).css('background-image', 'url(' + tmpenvoData.backgroundimage + ')'); // working fine - Tested
      $(this).css('background-attachment', tmpenvoData.backgroundimage_attachment); // working fine - Tested
      $(this).css('background-repeat', tmpenvoData.backgroundimage_repeat); // working fine _Tested
      $(this).css('background-size', tmpenvoData.backgroundimage_size); // working fine _Tested
      if (tmpenvoIsBreakPoint(sm)) {
        var tmpenvoSmallDevice = tmpenvoData.backgroundposition_sm;
        if (tmpenvoSmallDevice == 'initial') {
          tmpenvoGetxsm = tmpenvoData.backgroundposition_sm_x;
          tmpenvoGetysm = tmpenvoData.backgroundposition_sm_y;
          var tmpenvoSmallDevice = tmpenvoGetxsm + ' ' + tmpenvoGetysm;
        } else {

        }
        $(this).css('backgroundPosition', tmpenvoSmallDevice); //get's reveresed
      } else if (tmpenvoIsBreakPoint(md)) {
        var tmpenvoMediumDevice = tmpenvoData.backgroundposition_md;
        if (tmpenvoMediumDevice == 'initial') {
          tmpenvoGetxmd = tmpenvoData.backgroundposition_md_x;
          tmpenvoGetymd = tmpenvoData.backgroundposition_md_y;
          var tmpenvoMediumDevices = tmpenvoGetxmd + ' ' + tmpenvoGetymd;
        }
        $(this).css('backgroundPosition', tmpenvoMediumDevice); //get's reveresed
      } else {
        var tmpenvoLargeDevice = tmpenvoData.backgroundposition_lg;

        if (tmpenvoLargeDevice == 'initial') {
          tmpenvoGetxlg = tmpenvoData.backgroundposition_lg_x;
          tmpenvoGetylg = tmpenvoData.backgroundposition_lg_y;
          var tmpenvoLargeDevice = tmpenvoGetxlg + ' ' + tmpenvoGetylg;
        }
        $(this).css('backgroundPosition', tmpenvoLargeDevice); //get's reveresed
      }

      var tmpenvoData_Hover_enable = $(this).attr('data-ggow-enable_hover');
      if( tmpenvoData_Hover_enable == 'yes' ){
        $(this).on('hover',function() {
          var tmpenvoDataHover = jQuery.parseJSON($(this).attr('data-tmpenvo-hover'));
          $(this).css('background-image', 'url(' + tmpenvoDataHover.backgroundimage_hover + ')'); // working fine - Tested
          $(this).css('background-attachment', tmpenvoDataHover.backgroundimage_attachment_hover); // working fine - Tested
          $(this).css('background-repeat', tmpenvoDataHover.backgroundimage_repeat_hover); // working fine _Tested
          $(this).css('background-size', tmpenvoDataHover.backgroundimage_size_hover); // working fine _Tested
          if (tmpenvoIsBreakPoint(sm)) {
            var tmpenvoSmallDeviceHover = tmpenvoDataHover.backgroundposition_sm_hover;
            if (tmpenvoSmallDeviceHover == 'initial') {
              tmpenvoGetxsmHover = tmpenvoDataHover.backgroundposition_sm_x_hover;
              tmpenvoGetysmHover = tmpenvoDataHover.backgroundposition_sm_y_hover;
              var tmpenvoSmallDeviceHover = tmpenvoGetxsmHover + ' ' + tmpenvoGetysmHover;
            } else {

            }
            $(this).css('backgroundPosition', tmpenvoSmallDeviceHover); //get's reveresed
          } else if (tmpenvoIsBreakPoint(md)) {
            var tmpenvoMediumDeviceHover = tmpenvoDataHover.backgroundposition_md_hover;
            if (tmpenvoMediumDeviceHover == 'initial') {
              tmpenvoGetxmdHover = tmpenvoDataHover.backgroundposition_md_x_hover;
              tmpenvoGetymdHover = tmpenvoDataHover.backgroundposition_md_y_hover;
              var tmpenvoMediumDevicesHover = tmpenvoGetxmdHover + ' ' + tmpenvoGetymdHover;
            }
            $(this).css('backgroundPosition', tmpenvoMediumDeviceHover); //get's reveresed
          } else {
            var tmpenvoLargeDeviceHover = tmpenvoDataHover.backgroundposition_lg_hover;

            if (tmpenvoLargeDeviceHover == 'initial') {
              tmpenvoGetxlgHover = tmpenvoDataHover.backgroundposition_lg_x_hover;
              tmpenvoGetylgHover = tmpenvoDataHover.backgroundposition_lg_y_hover;
              var tmpenvoLargeDeviceHover = tmpenvoGetxlgHover + ' ' + tmpenvoGetylgHover;
            }
            $(this).css('backgroundPosition', tmpenvoLargeDeviceHover); //get's reveresed
          }
        }, function() {

          var tmpenvoData = jQuery.parseJSON($(this).attr('data-tmpenvo'));
          $(this).css('background-image', 'url(' + tmpenvoData.backgroundimage + ')');
          $(this).css('background-attachment', tmpenvoData.backgroundimage_attachment);
          $(this).css('background-repeat', tmpenvoData.backgroundimage_repeat);
          $(this).css('background-size', tmpenvoData.backgroundimage_size);
          if (tmpenvoIsBreakPoint(sm)) {
            var tmpenvoSmallDevice = tmpenvoData.backgroundposition_sm;
            if (tmpenvoSmallDevice == 'initial') {
              tmpenvoGetxsm = tmpenvoData.backgroundposition_sm_x;
              tmpenvoGetysm = tmpenvoData.backgroundposition_sm_y;
              var tmpenvoSmallDevice = tmpenvoGetxsm + ' ' + tmpenvoGetysm;
            } else {

            }
            $(this).css('backgroundPosition', tmpenvoSmallDevice); //get's reveresed
          } else if (tmpenvoIsBreakPoint(md)) {
            var tmpenvoMediumDevice = tmpenvoData.backgroundposition_md;
            if (tmpenvoMediumDevice == 'initial') {
              tmpenvoGetxmd = tmpenvoData.backgroundposition_md_x;
              tmpenvoGetymd = tmpenvoData.backgroundposition_md_y;
              var tmpenvoMediumDevices = tmpenvoGetxmd + ' ' + tmpenvoGetymd;
            }
            $(this).css('backgroundPosition', tmpenvoMediumDevice); //get's reveresed
          } else {
            var tmpenvoLargeDevice = tmpenvoData.backgroundposition_lg;

            if (tmpenvoLargeDevice == 'initial') {
              tmpenvoGetxlg = tmpenvoData.backgroundposition_lg_x;
              tmpenvoGetylg = tmpenvoData.backgroundposition_lg_y;
              var tmpenvoLargeDevice = tmpenvoGetxlg + ' ' + tmpenvoGetylg;
            }
            $(this).css('backgroundPosition', tmpenvoLargeDevice); //get's reveresed
          }

        });
      }
    });
  }
  $(window).on('resize', tmpenvoAdjustSize);
  tmpenvoAdjustSize();

});

/*
 * AeroWindow - jQuery Plugin (v2.0)
 * Copyright 2010, Christian Goldbach
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * 
 * Project Website:
 * http://www.soyos.net/aerowindow-jquery.html
 * http://www.soyos.net
 *
 *
 *
 * Requires Easing Plugin for Window Animations:
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 *
 * Changelog:
 * ~~~~~~~~~~
 * Version 2.0 (2010-06-01)
 * Added more config options:
 * - WindowResizable: 
 * - WindowMaximize    
 * - WindowMinimize    
 * - WindowClosable   
 * - WindowDraggable  
 *
 * Date: 2010-06-01
 */

(function($){
  $.fn.extend({ 
    //plugin name - Aero Window (like Windows7 Style) 
    AeroWindow: function(options) {
    
      //Identify clearly this window ----------------------------------------
      WindowID = $(this).attr('id');
      if (($('body').data(WindowID)) == null) {
        var $WindowAllwaysRegistered = false;
        //Register this Window
        $('body').data( WindowID , 1);
      } else {
        //Window exists
        var $WindowAllwaysRegistered = true;
      }
      //If the window is registered, just show it and set focus ---------------     
      if ($WindowAllwaysRegistered == true) {
        Window = $(this).find(".AeroWindow");
        $(this).find(".AeroWindow").css('display', 'block'); 
        $(".AeroWindow").removeClass('active');
        if (Window.hasClass('AeroWindow')) Window.addClass('active');
        if (($('body').data('AeroWindowMaxZIndex')) == null) {
          $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
        }
        i = $('body').data('AeroWindowMaxZIndex');
        i++;
        Window.css('z-index', i);
        $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index')); 
        return;
      }
    
      //Settings Window and the default values---------------------------------
      var defaults = {
        WindowTitle:        null,
        WindowPositionTop:  60,            /* Posible are pixels or 'center' */
        WindowPositionLeft: 10,            /* Posible are pixels or 'center' */
        WindowWidth:        300,           /* Only pixels */
        WindowHeight:       300,           /* Only pixels */
        WindowMinWidth:     250,           /* Only pixels */
        WindowMinHeight:    0,             /* Only pixels */
        WindowResizable:    true,          /* true, false*/
        WindowMaximize:     true,          /* true, false*/
        WindowMinimize:     true,          /* true, false*/
        WindowClosable:     true,          /* true, false*/
        WindowDraggable:    true,          /* true, false*/
        WindowStatus:       'regular',     /* 'regular', 'maximized', 'minimized' */
        WindowAnimation:    'easeOutElastic'
      };
      
      /*-----------------------------------------------------------------------
      Posible WindowAnimation:
      - easeInQuad
      - easeOutQuad
      - easeInOutQuad
      - easeInCubic
      - easeOutCubic
      - easeInOutCubic
      - easeInQuart
      - easeOutQuart
      - easeInOutQuart
      - easeInQuint
      - easeOutQuint
      - easeInOutQuint
      - easeInSine
      - easeOutSine
      - easeInOutSine
      - easeInExpo
      - easeOutExpo
      - easeInOutExpo
      - easeInCirc
      - easeOutCirc
      - easeInOutCirc
      - easeInElastic
      - easeOutElastic
      - easeInOutElastic
      - easeInBack
      - easeOutBack
      - easeInOutBack
      - easeInBounce
      - easeOutBounce
      - easeInOutBounce      
      -----------------------------------------------------------------------*/
      
      //Assign current element to variable, in this case is UL element
      var options = $.extend(defaults, options);
    
      return this.each(function() {
        var o =options;
        
        //Generate the new Window ---------------------------------------------     
        var WindowContent = $(this).html();
        var WinMinBtn     = (o.WindowMinimize) ? '<a href="#" class="win-min-btn"></a>' : '';
        var WinMaxBtn     = (o.WindowMaximize) ? '<a href="#" class="win-max-btn"></a>' : '';
        var WinCloseBtn   = (o.WindowClosable) ? '<a href="#" class="win-close-btn"></a>' : '';
        
        $(this).html(
          '<table class="AeroWindow" cellpadding="0" cellspacing="0" border="0">' +
          '  <tr>' +
          '    <td class="table-tl"></td>' +
          '    <td class="table-tm"></td>' +
          '    <td class="table-tr"></td>' +
          '  </tr>' +
          '  <tr>' +
          '    <td class="table-lm"></td>' +
          '    <td class="table-mm" align="right">' +
          '      <div class="title"><nobr>'+o.WindowTitle+'</nobr></div>' +
          '      <div class="buttons">' +
                   WinMinBtn +
                   WinMaxBtn +
          '        <a href="#" class="win-reg-btn"></a>' +
                   WinCloseBtn +
          '      </div>' +
          '      <div class="table-mm-container" align="left">' +
          '        <div class="table-mm-content" style="width: '+o.WindowWidth+'px; height: '+o.WindowHeight+'px;">' +
                     WindowContent +
          '        </div>' +
          '      </div>' +
          '    </td>' +
          '    <td class="table-rm"></td>' +
          '  </tr>' +
          '  <tr>' +
          '    <td class="table-bl"></td>' +
          '    <td class="table-bm"></td>' +
          '    <td class="table-br"></td>' +
          '  </tr>' +
          '</table>'
        );
        
        //Display hidden Containers -------------------------------------------
        $(this).css('display', 'block'); 

        //Window Objects ------------------------------------------------------
        var Window          = $(this).find(".AeroWindow");
        var WindowContainer = $(this).find(".table-mm-container");
        var WindowContent   = $(this).find(".table-mm-content");
        var BTNMin          = $(this).find(".win-min-btn");
        var BTNMax          = $(this).find(".win-max-btn");
        var BTNReg          = $(this).find(".win-reg-btn");
        var BTNClose        = $(this).find(".win-close-btn");
    
        //Initial Configuration -----------------------------------------------
        BTNReg.css('display', 'none'); 
        FocusWindow(Window);        
        
        //Set Window Position
        if(o.WindowPositionTop == 'center') {
          //o.WindowPositionTop = ($(window).height()/2) - o.WindowHeight/2 - 37;
          o.WindowPositionTop = ($(window).height()-o.WindowHeight)/2+$(window).scrollTop()
        }
        if(o.WindowPositionLeft == 'center') {
          o.WindowPositionLeft = ($(window).width()/2) - o.WindowWidth/2 - 17;
        }

          switch (o.WindowStatus) {
            case 'regular':
              RegularWindow();
              break;
            case 'maximized':
              MaximizeWindow();
              break;
            case 'minimized':
              MinimizeWindow();
              break;
            default:
              break;
          }
         

        //Window Functions ----------------------------------------------------
        function MaximizeWindow() {
          WindowContainer.css('visibility', 'visible'); 
          BTNMax.css('display', 'none'); 
          BTNReg.css('display', 'block');
          WindowContent.animate({ 
            width: $(window).width()-32, 
            height: $(window).height()-77}, {
            queue: false,
            duration: 800,
            easing: o.WindowAnimation
          });
          //Set new Window Position
          Window.animate({ 
            top: 0, 
            left: 0}, {
            duration: 800,
            easing: o.WindowAnimation
          });
          o.WindowStatus = 'maximized';
          return(false);          
        }
        function MinimizeWindow() {
          BTNReg.css('display', 'block');
          BTNMax.css('display', 'block');
          WindowContainer.css('visibility', 'hidden'); 
          WindowContent.animate({ 
            width: o.WindowMinWidth, 
            height: o.WindowMinHeight}, {
            queue: true,
            duration: 800,
            easing: o.WindowAnimation
          });
          //Set new Window Position
          Window.animate({ 
            top: $(window).height()-77, 
            left: 0}, {
            duration: 800,
            easing: o.WindowAnimation
          });
          o.WindowStatus = 'minimized';
          return(false);
        }
        function RegularWindow() {
          BTNMax.css('display', 'block');
          BTNReg.css('display', 'none');
          WindowContainer.css('visibility', 'visible'); 
          WindowContent.animate({ 
            width: o.WindowWidth, 
            height: o.WindowHeight}, {
            queue: false,
            duration: 800,
            easing: o.WindowAnimation
          });
          //Set new Window Position
          //Error handling, if the left position is negative.
          if ((typeof(o.WindowPositionLeft) == 'string') && (o.WindowPositionLeft.substring(0, 1) == '-')) o.WindowPositionLeft = 0;
          Window.animate({ 
            top: o.WindowPositionTop, 
            left: o.WindowPositionLeft}, {
            duration: 800,
            easing: o.WindowAnimation
          });
          o.WindowStatus = 'regular';
          return(false);          
        }
        function FocusWindow(Window) {
          $(".AeroWindow").removeClass('active');
          if (Window.hasClass('AeroWindow')) Window.addClass('active');
          if (($('body').data('AeroWindowMaxZIndex')) == null) {
            $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          }
          i = $('body').data('AeroWindowMaxZIndex');
          i++;
          Window.css('z-index', i);
          $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
        }
        
        //Attach user events to the Window ------------------------------------
        $(this).dblclick(function() {
          switch (o.WindowStatus) {
            case 'regular':
              MaximizeWindow();
              break;
            case 'maximized':
              RegularWindow();
              break;
            case 'minimized':
              RegularWindow();
              break;
            default:
              break;
          }
        }); 
        //User Interaction - Minimize Button
        BTNMin.click(function () {
          MinimizeWindow();
        });
        //User Interaction - Maximize Button
        BTNMax.click(
          function () {MaximizeWindow();
        });
        //User Interaction - Regular Button
        BTNReg.click(
          function () {RegularWindow();
        });
        //Close Button
        BTNClose.click(function () {
          //Unregister this Window
          Window.css('display', 'none'); 
          //$('body').data( WindowID , null);          
          return(false);          
        });
        
        //Support Dragging ----------------------------------------------------
        if (o.WindowDraggable){
        Window.draggable({
          distance: 3, 
          start: function() {
            FocusWindow(Window);
            $(".AeroWindow").removeClass('active');
            $(this).addClass('active');
            $('body').data( 'AeroWindowMaxZIndex' , $(this).css('z-index'));
          },
          drag: function() {
            WindowTop  = $(this).css('top');
            WindowLeft = $(this).css('left');
            $(this).css({backgroundPosition: '-' +WindowLeft+ ' -' +WindowTop});
          },
          stop: function() {
            //alert(Window.css('top'));
            o.WindowPositionTop  = Window.css('top');
            o.WindowPositionLeft = Window.css('left');
          }
        });
      }
        
        //Support Focus on Window by Click ------------------------------------
        Window.click(function (){
          FocusWindow(Window);
        });

        //Support Window Resizing ---------------------------------------------
        if (o.WindowResizable){
          WindowContent.resizable({
            minHeight: 30,
            minWidth: 200,
            start: function() {
              $(".AeroWindow").removeClass('active');
              Window.addClass('active');
              if (($('body').data('AeroWindowMaxZIndex')) == null) {
                $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
              }
              i = $('body').data('AeroWindowMaxZIndex');
              i++;
              Window.css('z-index', i);
              $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
            }, 
            stop: function() {
              o.WindowWidth  = $(this).css('width');
              o.WindowHeight = $(this).css('height');
            }
          });
        }
      });
    }
  });
})(jQuery);
Code:

This is how you create a new window:

        $.newWindow();
		

API

        $.newWindow({
            id: "",
            title: "",
            width: 200,
            height: 200,
            posx: 50,
            posy: 50,
            content: "",
            onDragBegin : null,
            onDragEnd : null,
            onResizeBegin : null,
            onResizeEnd : null,
            onAjaxContentLoaded : null,
            statusBar: true,
            minimizeButton: true,
            maximizeButton: true,
            closeButton: true,
            draggable: true,
            resizeable: true
        });
        $.updateWindowContent(id,newContent);
        $.updateWindowContentWithAjax(id,url,[cache]);
        $.moveWindow(id, x, y);
        $.resizeWindow(id, width, height);
        $.minimizeWindow(id);
        $.maximizeWindow(id);
        $.closeWindow(id);
        $.closeAllWindows();
		
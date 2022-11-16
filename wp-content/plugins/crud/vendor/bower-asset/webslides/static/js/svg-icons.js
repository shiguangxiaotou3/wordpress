
(function (DOM, elements, c, svgData) {

    /**
    * 创建svg元素
    */
    function createSvgTag(element, c) {
        if (c) {
            var d = c.getAttribute('viewBox'),
                e = DOM.createDocumentFragment(),
                f = c.cloneNode(true);
            if (d){
                element.setAttribute('viewBox', d);
            }
            while (f.childNodes.length){
                e.appendChild(f.childNodes[0]);
            }

            element.appendChild(e);
        }
    }

    /**
     加载svg 数据
    */
    function onloadSvgData() {
        var elements = this;
        var c = DOM.createElement('x');
        var  svgData = elements.s;
        c.innerHTML = elements.responseText;
        elements.onload = function () {
            svgData.splice(0).map(function (a) {
                createSvgTag(
                    a[0],
                    c.querySelector('#' + a[1].replace(/(\W)/g, '\\$1'))
                );
            });
        };
        elements.onload();
    }

    /**
     * 获取当前文件的url路由
     */
    function getUrl() {

        var url = window.location.href;
        if(url.indexOf("file:///") !== -1 ){
            return 'https://file.myfontastic.com/bLfXNBF36ByeujCbT5PohZ/sprites/1477146123.svg';
        }else{
            var js = document.scripts;
            var urlPath;
            for (var x = 0; x < js.length; x++) {
                if (js[x].src.indexOf("svg-icons.js") > -1) {
                    urlPath = js[x].src.substring(0, js[x].src.lastIndexOf("/") + 1);
                }
            }
            return urlPath+"1477146123.svg";
        }
    }

    /**
     * 请求svg数据，遍历DOM
    */
    function createSvg() {
        var document;
        while ((document = elements[0])) {
            var svgTag = document.parentNode,
                h = document.getAttribute('xlink:href').split('#')[1],
                url =  getUrl();
            svgTag.removeChild(document);
            var http = svgData[url] = svgData[url] || new XMLHttpRequest();
            if (!http.s) {
                http.s = [];
                http.open('GET',  url);
                http.onload = onloadSvgData;
                http.send();
            }
            http.s.push([svgTag, h]);
            if (http.readyState === 4){
             http.onload();
            }
        }
        c(createSvg);
    }
    createSvg();
})(
    document,
    document.getElementsByTagName('use'),
    window.requestAnimationFrame || window.setTimeout,
    {}
);
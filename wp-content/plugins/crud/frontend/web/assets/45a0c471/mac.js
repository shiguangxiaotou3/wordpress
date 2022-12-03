jQuery(function ($) {
    $("pre code").each(function(){
        let title =(this.title !== undefined) ? this.title :"";
        let codename ="Text";

        if( $(this).attr("class") !== undefined){
            let className =$(this).attr("class");
            let arr = className.split(" ");
            if(className.indexOf("language-") !== -1){
                for(let i =0;i<=arr.length;i++){
                    if(arr[i].indexOf("language-") !== -1){
                        let language =arr[i].replace("language-","");
                        codename =language.substring(0,1).toUpperCase() +language.toLowerCase().substring(1);
                        break;
                    }
                }
            }else{
                let arr =$(this).attr("class").split(" ");
                let language =arr[arr.length-1];
                codename = language.substring(0,1).toUpperCase() +language.toLowerCase().substring(1)
            }

        }

        let html =`<div class='hljs mac-title' style="display:flex" >
            <div class="left">
                <div class="logo">
                    <div class="item" style='background-color: red'></div>
                    <div class="item" style='background-color: yellow'></div>
                    <div class="item" style='background-color:green'></div>
                </div>
               <div class="language">${codename}</div>
            </div>
            <div class="content">${title}</div>
            <div class="right"><a class="copy" href="javascript:;" style="color: white">复制</a></div>
        </div>`;
        $(this).parent().prepend(html);
        $(this).css('padding-top','0');
        $(this).css('opacity','0.95');
    });
    // 复制代码
    $(".copy").click(function(){
        const code =this.parentNode.parentNode.parentNode.childNodes[1];
        const range = document.createRange();
        range.selectNode(code);
        const selection = window.getSelection();
        if(selection.rangeCount >0){
            selection.removeAllRanges();
        }
        selection.addRange(range);
        document.execCommand('copy');
        alert('复制成功');
        selection.removeAllRanges(range);
    });
});
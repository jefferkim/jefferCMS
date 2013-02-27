function dhscroll(){
    //author:dh20156
    var dh = this;
    this.autoid = null;
    //块1
    this.scrollDOM = null;
    //块2
    this.scrollCDOM = null;
    //展示宽度（和块1宽度一致）
    this.showwidth = 0;
    //每次滚动长度
    this.steplength = 1;
    var oldlength = this.steplength;
    //滚动时间间隔
    this.steptime = 0;
    //停顿时间
    this.resttime = 4600;
    //滚动长度
    this.uvwidth = 0;

    //无缝设置过程
    this.getsw = function() {
    
        var tempw = this.scrollCDOM.offsetWidth;
        var temps = this.scrollCDOM.innerHTML;
        this.scrollCDOM.innerHTML = [temps,temps].join("");
        this.scrollCDOM.style.width = tempw*2+"px";
        if(document.attachEvent){
            this.scrollDOM.attachEvent("onmouseover",dh.pause);
            this.scrollDOM.attachEvent("onmouseout",dh.goon);
        }else{
            this.scrollDOM.addEventListener("mouseover",dh.pause,true);
            this.scrollDOM.addEventListener("mouseout",dh.goon,true);
        }
        this.uvwidth = Math.ceil(this.scrollDOM.scrollWidth / 2);
    }

    //从右到左
    this.scrollleft = function(){
        if(this.autoid!=null){
            window.clearTimeout(this.autoid);
        }
        var uvleft = this.scrollDOM.scrollLeft;
        uvleft += this.steplength;

        this.scrollDOM.scrollLeft = uvleft;

        if(uvleft>=this.uvwidth){
            this.scrollDOM.scrollLeft = 0;
        }

        if(uvleft % this.showwidth == 0){
            this.autoid = window.setTimeout(function(){dh.scrollleft()},dh.resttime);
        }else{
            this.autoid = window.setTimeout(function(){dh.scrollleft()},dh.steptime);
        }
        
    }

    //从左到右
    this.scrollright = function() {
        if (this.autoid != null) {
            window.clearTimeout(this.autoid);
        }
        var uvleft = this.scrollDOM.scrollLeft;
        uvleft -= this.steplength;

        this.scrollDOM.scrollLeft = uvleft;

        if (uvleft <= 0) {
            this.scrollDOM.scrollLeft = this.uvwidth;
            
        }

        if (uvleft % this.showwidth == 0) {
            this.autoid = window.setTimeout(function() { dh.scrollright() }, dh.resttime);
        } else {
            this.autoid = window.setTimeout(function() { dh.scrollright() }, dh.steptime);
        }
    }

    //开始滚动，参数为方向，首屏是否停顿
    this.go = function(direction, rest) {
        if(this.autoid!=null){
            window.clearTimeout(this.autoid);
        }
        if(direction=="left"){
            if(rest){
                this.autoid = window.setTimeout(function(){dh.scrollleft()},5000);
            }else{
                dh.scrollleft();
            }
        }else{
            if(rest){
                this.autoid = window.setTimeout(function(){dh.scrollright()},5000);
            }else{
                dh.scrollright();
            }
        }
    }

    //往右
    this.pre = function(){
            this.scrollright();
    }
    //往左
    this.next = function(){
            this.scrollleft();
    }
    //暂停
    this.pause = function(){
        dh.oldlength = dh.steplength;
        dh.steplength = 0;
    }
    //继续
    this.goon = function(){
        dh.steplength = dh.oldlength;
    }
}
(function(){
    var options = (function(cl) {
        function options (cl) {
            this.winW = $(window).width();//ブラウザ幅
            this.ResizedWinW =null;//ブラウザ幅
            this.cl = $(cl);//class名（entertainかdishesか）
            this.slidebase = this.cl.find(".slider").css({overflow:"hidden",position:"relative"});//.slider
            this.items = this.slidebase.find("li");//各li
            this.itemW = this.items.width();//各liのwidth
            this.itemH = this.items.height();//各liのheight
            this.len = this.items.length;//各liの数
            this.marginR = parseInt(this.items.css("margin-right"),10);//各liのマージンライト  
            this.auto = true;//自動スライドするか否か（デフォルトはtrue）
            this.slideTime = 500;//スライドの時間
            this.repeatTime = 4000;//スライドの時間+停止の時間
            this.num = 1;//係数設定。liの数を現状維持すべき（あるいは増えていた状態から減らすべき）場合→1、cloneで増やすべき場合→2となる。
            this.ulWidth = (this.itemW+this.marginR)*((this.len)*this.num);//各liの親にあたるulのwidth幅。ここでmarginをひいてしまうとカラムオチするからひかない。
            this.cloneItem = this.items.clone();//cloneの生成
            this.zoomRate = 1.1;
        }

        return options;
    })();
        
    var slider = (function(options){   
        function slider (options) {
            this.options = options;
            this.init(options);
        }
        
        //ブラウザ幅によるliの個数判断。
        slider.prototype.init = function(options){
            if (options.ulWidth/options.num-options.winW-options.marginR<(options.itemW)*2){
						//liの数を増やす場合
                if(options.num == 1){//係数が1の場合はクローンを作る。（※2の場合はリサイズ前の時点で既に増えているので、これ以上増やす必要がない）
                    options.num =2;    
                    options.items = options.slidebase.find("li");
                    options.cloneItem = options.items.clone();
                    options.items.parent("ul").append(options.cloneItem);        
                    options.items = options.slidebase.find("li");
                    options.len = options.items.length;
                    options.ulWidth = (options.itemW+options.marginR)*(options.len);
                } 
            } else{//liの数を増やす必要がない場合            
                if(options.num ==2) {//係数が2の場合はリサイズ前の時点でliの数が増えているので、半分に減らす必要がある。
                    options.num =1;
                    options.items = options.slidebase.find("li");
                    for(var k=0;k<options.len/2;k++){
                        $(options.items[k]).remove();                  
                    }
                    options.items = options.slidebase.find("li");
                    options.len = options.items.length;
                    options.ulWidth = (options.itemW+options.marginR)*(options.len);
                }
            } 
            this.build(options);
        }
        
        //ulの構造を定義
        slider.prototype.build = function(options){
            options.items.parent("ul").css({
                position:"absolute",
                width:function(){
                        if(options.cl.hasClass("entertain")){
                            return options.ulWidth;
                        }else if(options.cl.hasClass("dishes")){
                            return options.ulWidth+22;
                        }
                    },
                height:function(){
                    if(options.cl.hasClass("entertain")){
                        return options.itemH;
                    }else if(options.cl.hasClass("dishes")){
                        return options.itemH+34;
                    }  
                }
            });
            this.centering(options);
        }
        
        //ulのセンタリング実施。class名とliの個数によるパターンわけ実施
        slider.prototype.centering = function(options){
            options.items.parent("ul").css({
                    left:function(){    
                        //パターン①                        
                        if((options.cl.hasClass("entertain")&&options.len%2==0)){              
                            if(options.winW>1024){
                                return -((options.ulWidth-options.winW)/2);
                            }else {
                                return -((options.ulWidth-1024)/2);
                            }
                        }else if((options.cl.hasClass("entertain")&&options.len%2==1)){
                            if(options.winW>1024){
                                return -((options.ulWidth-options.winW)/2)+options.itemW/2+options.marginR/2;
                            }else {
                                return -((options.ulWidth-1024)/2)+options.itemW/2+options.marginR/2;
                            }
                        }else if (options.cl.hasClass("dishes")&&options.len%2==0&&options.num==2){
                            if(options.winW>1024){
                                return -((options.ulWidth-options.winW)/2+options.itemW/2);
                            }else {
                                return -((options.ulWidth-1024)/2+options.itemW/2);
                            }
                        }else if (options.cl.hasClass("dishes")&&options.len%2==0&&options.num==1) {
                            if(options.winW>1024){
                                return -((options.ulWidth-options.winW)/2)+options.itemW/2;
                            }else {
                                return -((options.ulWidth-1024)/2)+options.itemW/2;
                            }                        
                        }else if (options.cl.hasClass("dishes")&&options.len%2==1){
                            if(options.winW>1024){
                                return -((options.ulWidth-options.winW)/2);
                            }else {
                                return -((options.ulWidth-1024)/2);
                            }
                        }    
                    }
            });
            if(options.cl.hasClass("dishes")){
                this.addfirst(options);
            }
        }
        
       //liの一番最初に.centerを適用（.dishesにのみ適用）
        slider.prototype.addfirst = function(options){
            $.each(options.items,function(i){
                $(this).removeClass("center");
                $(this).find("img").css({width:options.itemW,height:options.itemH,top:0})
            });
            
            

            options.items.first().addClass("center");
            $(".center img").css({width:options.itemW+22,height:options.itemH+34,top:-17});
            //要素の入れ替え
            if(options.num===1){
                var shifts = options.items.length/2;
                for(var i=shifts;i>0;i--){
                    $(options.items.eq(shifts-i)).remove().prependTo(options.items.parent("ul"));
                }
            }else if(options.num===2){
                var shifts = options.items.length;
                for(var i=0;i<shifts/2;i++){
                   $(options.items.eq(i)).remove().appendTo(options.items.parent("ul"));
                }
            }  
        }    
 
 
        slider.prototype.patapata = function(center){
            //パタパタアニメーションの定義
            var value = {"mexico":"-620px",
                        "china":"-1364px",
                        "malaysia":"-496px",
                        "panama":"-744px",
                        "taiwan":"-992px",
                        "korea":"-1240px",
                        "kenya":"-1612px",
                        "vietnam":"-868px",
                        "spain":"-1488px",
                        "thailand":"-1116px"
                    };
            var country = center.next().attr("country");

            $(".flip").stop(true,true).delay(80).queue(function(){
                $(this).css('background-position','0 -62px').dequeue();
            }).delay(80).queue(function(){
                    $(this).css('background-position','0 -124px').dequeue();
            }).delay(80).queue(function(){
                    $(this).css('background-position','0 -186px').dequeue();
            }).delay(80).queue(function(){
                    $(this).css('background-position','0 -248px').dequeue();
            }).delay(80).queue(function(){
                    $(this).css('background-position','0 -310px').dequeue();
            }).delay(80).queue(function(){
                    $(this).css('background-position','0 -434px').dequeue();
            }).delay(100).queue(function(){
                    $(this).css('background-position','0 '+value[country]).dequeue();
            });
        }
        
        
        
        //スライドの動きを定義。
        slider.prototype.move = function (options){
            var self = this;
            setInterval(function(){
                options.items.parent("ul").animate({"marginLeft":-(options.itemW+options.marginR)},options.slideTime,function(){
                    options.slidebase.find("li").eq(0).remove().appendTo(options.items.parent("ul"));           
                    options.items.parent("ul").css({"marginLeft":0});
                });
                
                //.dishedの時は拡大アニメーションとパタパタアニメーションの定義が必要。
                if(options.cl.hasClass("dishes")){
                    
                    var center = $(".center");
                    center.find("img").animate({width:options.itemW,height:options.itemH,top:0},500,function(){
                        center.removeClass("center");          
                    })
                    center.next().find("img").animate({width:options.itemW+22,height:options.itemH+34,top:-17},500,function(){
                        center.next().addClass("center");               
                    })
                    self.patapata(center)
                }    
            },options.repeatTime);
        };
           
        return slider;
    })();
    
    
    $(function(){
        var optional__d = new options(".slidesWrap");
        var sliders__d = new slider(optional__d);
       
//        自動スライド=trueになっていれば下記実行
        if(optional__d.auto ===true){
            sliders__d.move(optional__d);
        }
        
        //リサイズ時の動きを定義。リサイズ完全終了後にのみ適用
        var timer = false;
        $(window).resize(function(){
            if (timer !== false) {
                clearTimeout(timer);
            }
            timer = setTimeout(function() {
                optional__d.ResizedWinW = $(window).width();                
                if(optional__d.ResizedWinW!=optional__d.winW){
                    optional__d.winW = optional__d.ResizedWinW;
                    sliders__d.init(optional__d);
                    sliders__d.patapata($(".center").prev());
                }
            }, 200);            
        });   
    }); 
    
})();


/**
 * 客户端
 * 这里通过jQuery Ajax来向服务端发送请求和数据
 * 并且把服务器端返回的数据加到对应的div下显示
 */
$(function(){
    var $btn = $("#btn");
    $btn.bind("click",{btn:$btn},function(evdata){
        var bug_type = '';
        $.ajax({
            type:"POST",
            dataType:"json",
            url:$btn.attr('formaction'),
            timeout:80000,     //ajax请求超时时间80秒
            data:{time:"80",domain:$("#your-domain").val()},
            success:function(data){
                //从服务器得到数据，显示数据并继续查询
                if(data.success=="1"){
                    $("#msg").append("<br>"+data.text);
                    evdata.data.btn.click();
                }
                //未从服务器得到数据，继续查询
                if(data.success=="0"){
                    $("#msg").append("<br>"+data.msg);
                    evdata.data.btn.click();
                }
            },
            //Ajax请求超时，继续查询
            error:function(XMLHttpRequest,textStatus,errorThrown){
                if(textStatus=="timeout"){
                    $("#msg").append("<br>超时");
                    evdata.data.btn.click();
                }
            }
        });
    });
});
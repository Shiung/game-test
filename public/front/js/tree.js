    //child點擊
   /* $(document).on('click touchstart', '.child-node', function(event){
        username = $(this).data('username')
        getdata(username,$(this).attr('id'))
    });*/

    var touchtime = 0;
    $(document).on("click touchstart", '.child-node', function() {
        if (touchtime == 0) {
            // set first click
            touchtime = new Date().getTime();
        } else {
            // compare first click to this click and see if they occurred within double click threshold
            if (((new Date().getTime()) - touchtime) < 300) {
                // double click occurred
                username = $(this).data('username')
                getdata(username,$(this).attr('id'))
                touchtime = 0;
            } else {
                // not a double click so set as a new first click
                touchtime = new Date().getTime();
            }
        }
    });
      
    //expand點擊
   /* $(document).on('click touchstart', '.expand', function(event){
        $(this).removeClass('expand');
        $(this).addClass('close-node');
        $(this).parent().siblings().hide();
        $(this).parent().addClass('item-close');
    });*/
    $(document).on("click touchstart", '.expand', function() {
        if (touchtime == 0) {
            // set first click
            touchtime = new Date().getTime();
        } else {
            // compare first click to this click and see if they occurred within double click threshold
            if (((new Date().getTime()) - touchtime) < 300) {
                // double click occurred
                $(this).removeClass('expand');
                $(this).addClass('close-node');
                $(this).parent().siblings().hide();
                $(this).parent().addClass('item-close');
                touchtime = 0;
            } else {
                // not a double click so set as a new first click
                touchtime = new Date().getTime();
            }
        }
    });
      
    //collapse點擊
    /* $(document).on('click touchstart', '.close-node', function(event){
        $(this).removeClass('close-node');
        $(this).addClass('expand');
        $(this).parent().siblings().show();
        $(this).parent().removeClass('item-close');
    });*/
    $(document).on("click touchstart", '.close-node', function() {
        if (touchtime == 0) {
            // set first click
            touchtime = new Date().getTime();
        } else {
            // compare first click to this click and see if they occurred within double click threshold
            if (((new Date().getTime()) - touchtime) < 300) {
                // double click occurred
                $(this).removeClass('close-node');
                $(this).addClass('expand');
                $(this).parent().siblings().show();
                $(this).parent().removeClass('item-close');
                touchtime = 0;
            } else {
                // not a double click so set as a new first click
                touchtime = new Date().getTime();
            }
        }
    });
    //找下線
    function getdata(username,e_id){

        $.ajax({
            url:APP_URL+'/member/tree/search/'+username,
            type : "GET",
            success:function(msg){  
                var data=JSON.parse(msg); 
                reBuild(e_id,data.tree)  
                HoldOn.close();               
            },
            beforeSend:function(){
                HoldOn.open({
                    theme:'sk-cube-grid',
                    message:"<h4>Loading...</h4>"
                });
              },
            error:function(xhr){
                HoldOn.close();        
                swal("Failed","系統發生錯誤，請聯絡客服人員",'error');
            }
        });
    }
    

    //重新建構
    function reBuild(e_id,tree){
        node = $('#'+e_id);
        node_parent = node.parent();
        node.remove();


        parent = tree.parent;
        children = tree.children

        //先製作他的子元素
        children_content = '<div class="hv-item-children">';


        for(var key in children){ 
              child = children[key];
              children_content += '<div class="hv-item-child">';
              if(child['status'] == 0){
                  children_content += '<div class="simple-card node child-node " id="'+child['id']+'" data-username="'+child['username']+'">';
                  children_content += '<p><span style="color:red;">'+child['tree_level_name']+'</span> | '+child['name']+' | <span style="color:red;">'+child['subs_count']+'</span></p>';
                  //children_content += '<p>'+child['name']+'</p>';

                  children_content += '<p>'+child['username']+'</p>';
                  children_content += '<p>'+child['member_number']+'</p>';
                  children_content += '</div>';//simple-card 
                  children_content += '</div>';//hv-item-child
              } else {
                  children_content += '<div class="simple-card node place-node" id="'+child['id']+'"></div>';//simple-card place-node
                  children_content += '</div>';//hv-item-child
              }
        }



        //重新建構

        new_content = '<div class="hv-item">';
        new_content += '<div class="hv-item-parent">';
        new_content += '<div class="simple-card node expand  ">';
        new_content += '<p><span style="color:red;">'+parent['tree_level_name']+'</span> | '+parent['name']+' | <span style="color:red;">'+parent['subs_count']+'</span></p>';
        //new_content += '<p>'+parent['name']+'</p>';

        new_content += '<p>'+parent['username']+'</p>';
        new_content += '<p>'+parent['member_number']+'</p>';
 
        new_content += '</div>';//simple-card expand
        new_content += '</div>';//hv-item-parent
        new_content += children_content;
        new_content += '</div>';//hv-item


        node_parent.html(new_content)
    }
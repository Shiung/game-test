    //child點擊
    $(document).on('click touchstart', '.child-node', function(event){
        username = $(this).data('username')
        getdata(username,$(this).attr('id'))
    });
      
    //expand點擊
    $(document).on('click touchstart', '.expand', function(event){
        $(this).removeClass('expand');
        $(this).addClass('close-node');
        $(this).parent().siblings().hide();
        $(this).parent().addClass('item-close');
    });
      
    //collapse點擊
    $(document).on('click touchstart', '.close-node', function(event){
        $(this).removeClass('close-node');
        $(this).addClass('expand');
        $(this).parent().siblings().show();
        $(this).parent().removeClass('item-close');
    });
      

    

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
                  children_content += '<p>'+child['name']+'</p>';
                  children_content += '<p>'+child['username']+'</p>';
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
        new_content += '<p>'+parent['name']+'</p>';
        new_content += '<p>'+parent['username']+'</p>';
 
        new_content += '</div>';//simple-card expand
        new_content += '</div>';//hv-item-parent
        new_content += children_content;
        new_content += '</div>';//hv-item


        node_parent.html(new_content)
    }
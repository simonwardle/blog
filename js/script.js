$("#delete_article").on("click", function(e) {
    
    e.preventDefault();

    if (confirm("Are you sure?")) {
        var frm= $("<form>");
        frm.attr('method', 'post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo('body');
        frm.submit();
    }

});
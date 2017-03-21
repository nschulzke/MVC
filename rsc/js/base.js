$('#dynamic-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);    // Button that triggered the modal
    var url = button.data('url');           // Extract info from data-* attributes
    var title = button.data('title');
    if (title == undefined)
        title = '';
    
    var modal = $(this);
    
    modal.find('#dynamic-modal-title').html(title);
    $.get(url, { layout: "none" }, function(data) {
        modal.find('#dynamic-modal-body').html(data);
    });
});
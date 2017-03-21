$('#dynamic-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var url = button.data('url')        // Extract info from data-* attributes
    
    var modal = $(this)
    
    $.get(url, { layout: "none" }, function(data) {
        console.log("success!");
        modal.find('#dynamic-modal-body').html(data);
    });
})
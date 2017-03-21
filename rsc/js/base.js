$(function() {
    // Ensure that only 0-9 and - are allowed, truncate after a bad char
    $('input[type=number].integer').change(function() {
        var val = $(this).val().replace(/[^0-9^\-].*/, '');
        $(this).val(val);
    })
    
    // Make sure numbers stay within their min and max
    $('input[type=number]').change(function() {
        var min = $(this).attr('min');
        var max = $(this).attr('max');
        if (min != undefined && parseInt($(this).val()) < min)
            $(this).val(min);
        if (max != undefined && parseInt($(this).val()) > max)
            $(this).val(max);
    })
    
    $('#dynamic-modal').on('show.bs.modal', function (event) {    
        // Get the data from the button
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var title = button.data('title');
        var saveBtn = button.data('saveBtn');
        var closeBtn = button.data('closeBtn');
        var getVars = button.data('getVars');
        // Validate the data
        if (saveBtn == undefined)
            saveBtn = 'Save';
        if (closeBtn == undefined)
            closeBtn = 'Close';

        if (getVars != undefined)
        {
            url += '?'
            for (var i = 0; i < getVars.length; i++)
            {
                url += getVars[i] + '=' + $('#' + getVars[i]).val() + '&';
            }
        }
            console.log(url);

        // Set the HTML based on the button's data
        var modal = $(this);
        modal.find('#dynamic-modal-title').html(title);
        modal.find('#dynamic-modal-close-btn').html(closeBtn);
        modal.find('#dynamic-modal-save-btn').html(saveBtn);

        // Hide or show save-btn based on button data
        if (saveBtn == false)
            modal.find('#dynamic-modal-save-btn').hide();
        else
            modal.find('#dynamic-modal-save-btn').show();

        // Run Ajax query
        $.get(url, { layout: 'none' }, function(data) {
            modal.find('#dynamic-modal-body').html(data);
        });
    });  
})
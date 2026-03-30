jQuery(function ($) {
    var frame;

    $(document).on('click', '.gtf-media-select', function (event) {
        event.preventDefault();

        var $field = $(this).closest('.gtf-media-field');

        if (frame) {
            frame.off('select');
        }

        frame = wp.media({
            title: (window.gtfAdmin && gtfAdmin.mediaTitle) ? gtfAdmin.mediaTitle : 'Fotoğraf seç',
            button: {
                text: (window.gtfAdmin && gtfAdmin.mediaButton) ? gtfAdmin.mediaButton : 'Seç'
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $field.find('.gtf-player-photo-id').val(attachment.id);
            $field.find('.gtf-player-photo-preview').html('<img src="' + attachment.url + '" alt="" />');
            $field.find('.gtf-media-remove').show();
        });

        frame.open();
    });

    $(document).on('click', '.gtf-media-remove', function (event) {
        event.preventDefault();

        var $field = $(this).closest('.gtf-media-field');
        $field.find('.gtf-player-photo-id').val('');
        $field.find('.gtf-player-photo-preview').html('');
        $(this).hide();
    });
});

jQuery(function ($) {
    var frame;

    function updatePreview($field, attachment) {
        $field.find('.gtf-player-photo-id').val(attachment ? attachment.id : '');
        if (attachment) {
            $field.find('.gtf-player-photo-preview').html('<img src="' + attachment.url + '" alt="" />');
            $field.find('.gtf-media-remove').show();
        } else {
            $field.find('.gtf-player-photo-preview').html('<span class="description">Fotoğraf seçilmedi</span>');
            $field.find('.gtf-media-remove').hide();
        }
    }

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
            updatePreview($field, attachment);
        });

        frame.open();
    });

    $(document).on('click', '.gtf-media-remove', function (event) {
        event.preventDefault();

        var $field = $(this).closest('.gtf-media-field');
        updatePreview($field, null);
    });

    $('.gtf-media-field').each(function () {
        var $field = $(this);
        var hasImage = $field.find('.gtf-player-photo-id').val();
        if (!hasImage) {
            updatePreview($field, null);
        }
    });
});
/**
 * Block editor: "Hover image" button in the block toolbar (shown when editing text).
 * Select text, click the button, pick an image. Saves as:
 * <span class="hover-image" data-image="URL" data-image-id="ID">text</span>
 * Clicking the button again on that text removes it.
 * Written without JSX so no build step is needed.
 */
(function (wp) {
    var el = wp.element.createElement;
    var richText = wp.richText;
    var blockEditor = wp.blockEditor;
    var components = wp.components;
    var name = 'commons/hover-image';

    richText.registerFormatType(name, {
        title: 'Hover image',
        tagName: 'span',
        className: 'hover-image',
        attributes: {
            url: 'data-image',
            id: 'data-image-id'
        },
        edit: function (props) {
            var value = props.value;
            var onChange = props.onChange;
            var isActive = props.isActive;

            // BlockControls puts the button directly in the block toolbar,
            // instead of the "More" dropdown where RichTextToolbarButton would hide it.
            return el(blockEditor.BlockControls, null,
                el(components.ToolbarGroup, null,
                    el(blockEditor.MediaUploadCheck, null,
                        el(blockEditor.MediaUpload, {
                            allowedTypes: ['image'],
                            onSelect: function (media) {
                                // Use the medium size (about 300px) since the preview shows at 250px
                                var url = (media.sizes && media.sizes.medium && media.sizes.medium.url) || media.url;
                                onChange(richText.applyFormat(value, {
                                    type: name,
                                    attributes: { url: url, id: String(media.id) }
                                }));
                            },
                            render: function (media) {
                                return el(components.ToolbarButton, {
                                    icon: 'format-image',
                                    label: isActive ? 'Remove hover image' : 'Hover image (select text first)',
                                    isPressed: isActive,
                                    onClick: function () {
                                        if (isActive) {
                                            onChange(richText.removeFormat(value, name));
                                        } else if (!richText.isCollapsed(value)) {
                                            // Only open the media library when some text is selected
                                            media.open();
                                        }
                                    }
                                });
                            }
                        })
                    )
                )
            );
        }
    });
})(window.wp);

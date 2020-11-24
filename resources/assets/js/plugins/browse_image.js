$( document ).ready(function() {

    var browseImage = (function () {

        // -- Settings --
        var settings = {
            inputs : {
                browse: $('#browse'),
            },
            img_preview : $('#img_preview'),
        };


        // -- SETUP functions --
        var _setDefaults = function () {
            _image.setPreview();
        }

        var _bindUIActions = function () {
            settings.inputs.browse.on('change', function(){
                _image.changed();
            });

        };

        var init = function () {
            _bindUIActions();
            _setDefaults();
        }


        // -- Functions --
        var _image = {
            setPreview : function (){
                if(this.getImage() != '') {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // get loaded data and render thumbnail.
                        settings.img_preview.attr('src', e.target.result)
                    };

                    // read the image file as a data URL.
                    reader.readAsDataURL(this.getImage());

                    settings.img_preview.prop('src', this.getImage());
                }
            },
            getImage : function (){
                return settings.inputs.browse.val() !=  '' ? settings.inputs.browse.prop('files')[0] : '';
            },
            changed : function () {
                this.setPreview();
            },
        };

        return {
            init: init,
        }

    })();

    browseImage.init()

});
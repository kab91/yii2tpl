var admin = {
    imageUpload: function(image, json) {
        var $a = $("<a></a>");
        var link = json.filelink;
        $a.attr("href", link.replace("large","full"));
        $a.attr("class", "zoom");
        image.wrap($a);
        this.sync();
    },

    imageUploadError: function(json) {
        alert('Не удалось загрузить картинку: '+json.error)
    }
};
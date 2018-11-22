    function oestile(obj) {
        this.id = obj.attr('id');
        this.data = obj.data();
    }

    oestile.prototype = {
        getData: function(evt) {
            var chps = "id=" + this.id;
            chps = chps + "&value='" + this.id + "'";
            chps = chps + "&type='" + this.data.objet + "'";
            if (evt.length > 0) {
                chps = chps +  "&event='" + evt + "'";
            }
            return chps;
        },
        setData : function (data) {
            this.value = data;
            return true;
        }
    };

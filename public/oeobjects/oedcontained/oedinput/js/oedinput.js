    function oedinput(obj) {
        this.id = obj.attr('id');
        this.type = obj.find("input").attr("type");
        this.data = obj.data();
        this.value = obj.find("input").val();
    }

    oedinput.prototype = {
        getData: function (evt) {
            var chps = "id=" + this.id + "&value='" + this.value + "'";
            if (evt = this.data.evt) {
                var classe  = data['evt-'+evt+'-class'];
                var methode = data['evt-'+evt+'-method'];
                if ((classe.length > 0) && (methode.length > 0)) {
                    chps = chps + "&callback='" + classe + "+" + methode +"'";
                }
            }
            return chps;
        },
        setData : function (data) {
            this.value = data;
            $("#"+this.id+'_'+this.type).val(data).focus();
            return true;
        }
    };

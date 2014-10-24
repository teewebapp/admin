(function ($) {
    var TableOrdered = function(params) {
        var self = this;
        this.element = params.element;
        this.url = params.url;
        this.itens = [];
        this.element.find(params.itens).each(function() {
            if($(this).find(params.up).length > 0)
            {
                var item = new Item(self, {
                    element: $(this),
                    upArrow: $(this).find(params.up),
                    downArrow: $(this).find(params.down)
                });
                self.itens.push(item);
            }
        });
        $.each(this.itens, function(i, item) {
            item.refresh();
        });
    };

    TableOrdered.prototype.getByPosition = function(pos) {
        if(pos >= 0 && pos < this.itens.length) {
            return this.itens[pos];
        }
    };

    TableOrdered.prototype.flip = function(item1, item2) {
        var pos1 = this.getPosition(item1);
        var pos2 = this.getPosition(item2);
        var aux = this.itens[pos1]
        this.itens[pos1] = this.itens[pos2];
        this.itens[pos2] = aux;

        $.post(this.url, {
            'id1': item1.element.data('id'),
            'id2': item2.element.data('id'),
            'order1': pos2,
            'order2': pos1
        });

        item1.element.fadeTo(200, 0.3, function() {
            item1.element.fadeTo(400, 1);

            if(pos1 < pos2)
                item1.element.before(item2.element);
            else
                item1.element.after(item2.element);
            item1.refresh();
            item2.refresh();

        });
        item2.element.fadeTo(200, 0.3, function() {
            item2.element.fadeTo(400, 1);
        });
    };

    TableOrdered.prototype.getPosition = function(item) {
        for(var i = 0; i < this.itens.length; i++) {
            var item2 = this.itens[i];
            if(item2 == item)
            {
                return i;
            }
        }
        return null;
    };

    var Item = function(table, params) {
        this.table = table;
        this.element = params.element;
        this.upArrow = params.upArrow;
        this.downArrow = params.downArrow;
        this.bindEvents();
    };

    Item.prototype.bindEvents = function() {
        var self = this;
        this.upArrow.on('click', function() { self.up(); });
        this.downArrow.on('click', function() { self.down(); });
    };

    Item.prototype.up = function() {
        var pos = this.table.getPosition(this);
        if(pos > 0) {
            var other = this.table.getByPosition(pos - 1);
            this.table.flip(this, other);
        }
    };

    Item.prototype.down = function() {
        var pos = this.table.getPosition(this);
        if(pos < this.table.itens.length - 1) {
            var other = this.table.getByPosition(pos + 1);
            this.table.flip(this, other);
        }
    };

    Item.prototype.refresh = function() {
        var pos = this.table.getPosition(this);
        if(pos > 0)
            this.upArrow.css('visibility', 'visible');
        else
            this.upArrow.css('visibility', 'hidden');
        if(pos < this.table.itens.length - 1)
            this.downArrow.css('visibility', 'visible');
        else
            this.downArrow.css('visibility', 'hidden');
    };

    $.fn.tableOrder = function(params) {
        this.each(function() {
            params.element = $(this);
            var tableOrdered = new TableOrdered(params);
        });
        return this;
    };
}(jQuery));
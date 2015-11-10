// configure namespaces
Ext.ns('Glamme');


/**
 * @class Glamme.Grid
 */
Ext.define('Glamme.Grid', {
    extend: 'Ext.grid.Panel',
    scroll: false,
    viewConfig: {
        style: {overflow: 'auto', overflowX: 'hidden'}
    },
    /**
     * Allow to save columns display (hiding, showing, moving, resizing etc)
     * in cookie on the client side.
     */
    stateful: true,
    /**
     * We use this to load store onRender
     *
     * There is need to have an ability to disable auto loading grid store
     * on render because of company items grids on accordion layout.
     *
     * They are initially hidden, but onRender is before checking hidden,
     * so they all would be loaded even if user doesn't activate them.
     */
    loaded: true,
    loadStoreOnRender: true,
    onRender: function() {
        // call parent
        this.callParent(arguments);

        // load store if needed
        if (this.loadStoreOnRender == true) {
            this.store.load({params: {start: 0, limit: 10}});
        }
    },
    addTooltip: function(value, metadata, record) {
        // to fix bug with printer renderer
        if (!metadata)
            return value;

        metadata.tdAttr = 'data-qtitle="Description"';
        metadata.tdAttr += 'data-qtip="' + record.data.description + '"';

        return value;
    },
    openRightPanel: function() {
        // open right panel if it is closed
        var aTab = Ext.getCmp('main-tabs').getActiveTab().title;

        if (aTab == 'Proximity')
            var rightPanel = Ext.getCmp('rightpanel');
        else
            var rightPanel = Ext.getCmp('rightpanel-users');
//        if (rightPanel.isHidden()) {
            rightPanel.expand();
//        }

        // hide all other forms and elements
        rightPanel.items.each(function(item) {
            if (!item.isHidden()) {
                item.hide();
            }
        });

        return rightPanel;
    },
    closeRightPanel: function() {
        // close right panel if it is open
        var rightPanel = Ext.getCmp('rightpanel');
//        if (!rightPanel.isHidden()) {
            rightPanel.collapse();
//        }

        // hide all other forms and elements
        rightPanel.items.each(function(item) {
            if (!item.isHidden()) {
                item.hide();
                item.clear();
            }
        });

        return rightPanel;
    },
    /**
     * Refreshes grid. It's named "recreate" instead of "refresh" to name it
     * the same as in extend dataview object. In dataview we couldn't use
     * "refresh" because it already exist there.
     *
     * This methid is called on the forms opened by grid.
     */
    recreate: function() {
        this.loaded = true;
        this.getStore().load();
    },
    /**
     * Public method for clearing filters from outside.
     */
    clearFilters: function() {
        this.filters.clearFilters();
    },
    /*
     * General ajax response handler
     */
    handleAjaxResponse: function(result, request) {
        var resultMessage = Ext.JSON.decode(result.responseText);
        if (resultMessage.success == false) {
            // application general error handler
            var type = 'remote';
            var response = {
                raw: {msg: resultMessage.msg, type: resultMessage.type | ''}
            }
            app.errorHandler(null, type, null, null, response, null);
        } else {
            if (resultMessage.msg !=null) {
                Ext.Msg.show({
                        title: 'Info',
                        icon: Ext.MessageBox.INFO,
                        msg: resultMessage.msg,
                        buttons: Ext.Msg.OK
                    });
            }
            this.recreate();
        }
    },
    printGrid: function() {
        Ext.ux.grid.Printer.print(this);
    }
});

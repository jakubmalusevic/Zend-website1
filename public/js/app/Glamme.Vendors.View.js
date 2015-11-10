// configure namespaces
Ext.ns('Glamme', 'Glamme.Vendors');


/**
 * @class Strata.Company.View
 */
Ext.define('Glamme.Vendors.View', {
    extend: 'Glamme.View',
    alias: 'widget.vendor-view',
    storeUrl: 'vendor',
    /**
     * initComponent
     * @protected
     */
    initComponent: function() {

        // hard coded - cannot be changed from outside
        var config = {
            tpl: new Ext.XTemplate(
                    '<tpl for=".">',
                    '<dl>',
                    '<dt>ID:</dt><dd>{id}&nbsp;</dd>',
                    '<dt>Name:</dt><dd>{first_name}&nbsp;</dd>',
                    '<dt>Status:</dt><dd>{status}&nbsp;</dd>',
                    '<dt>Email:</dt><dd>{email}&nbsp;</dd>',
                    '<dt>Phone:</dt><dd>{phone}&nbsp;</dd>',
                    '<dt>Added Date:</dt><dd>{birth_date}&nbsp;</dd>',
                    '</dl>',
                    '</tpl>'
                    ),
            itemSelector: 'dl',
            store: new Ext.data.Store({
                model: 'Glamme.Model.Vendors',
                //id: 'id',
                proxy: {
                    type: 'ajax',
                    url: this.storeUrl,
                    reader: {
                        type: 'json',
                        root: 'data'
                    }
                }
            })
        }; // eo config object

        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));

        // call parent
        this.callParent(arguments);
    }

});

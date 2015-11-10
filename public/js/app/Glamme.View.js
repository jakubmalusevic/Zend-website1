// configure namespaces
Ext.ns('Glamme');


/**
 * @class Strata.View
 */
Ext.define('Glamme.View', {
    extend: 'Ext.view.View',
    onRender: function() {
        // load store
        this.store.load();

        // call parent
        this.callParent(arguments);
    },
    /**
     * Refreshes view. It's named "recreate" instead of "refresh" we 
     * couldn't use "refresh" because it already exist there.
     * 
     * This methid is called on the forms opened by data view.
     */
    recreate: function() {
        this.store.load();
    }

});
// configure namespaces
Ext.ns('Glamme', 'Glamme.Vendors');


/**
 * @class Glamme.Vendor.Grid
 */
Ext.define('Glamme.Vendors.Grid', {
    extend: 'Glamme.Grid',
    alias: 'widget.vendors-grid',
    // defaults which can be changed on lazy loading
    storeUrl: 'vendor',
    urlSuffix: '',
    rowEditEnabled: false,
    /**
     * initComponent
     * @protected
     */
    initComponent: function() {

        // hard coded - cannot be changed from outside
        var config = {
            loadMask: true,
            forceFit: true,
            // prepare store
            store: new Ext.data.Store({
                storeId: 'vendor-grid-store',
                model: 'Glamme.Model.Vendors',
                //id: 'id',
                proxy: {
                    type: 'ajax',
                    url: this.storeUrl + this.urlSuffix,
                    reader: {
                        type: 'json',
                        root: 'results',
                        totalProperty: 'totalCount',
                    }
                    //simpleSortMode: true
                },
                pageSize: 25,
                remoteSort: true,
                remoteGroup: true,
                groupField: 'status',
                sorters: ['id', 'first_name', 'email', 'username', 'status']
            }),
            // column model
            columns:
                    [
                        {header: 'ID', width: 30, sortable: true, dataIndex: 'id', renderer: this.addTooltip},
                        {
                            editor: {
                                allowBlank: false
                            },
                            header: 'First Name', width: 100, sortable: true, dataIndex: 'first_name', renderer: this.addTooltip
                        },
                        {
                            editor: {
                                allowBlank: false
                            },
                            header: 'Last Name', width: 100, sortable: true, dataIndex: 'last_name', renderer: this.addTooltip
                        },
                        {
                            header: 'Email', width: 150, sortable: true, dataIndex: 'email', renderer: this.addTooltip
                        },
                        {
                            header: 'Max Miles', width: 50, sortable: true, dataIndex: 'max_miles', renderer: this.addTooltip
                        },
                        {
                            editor: {
                                xtype: 'combo',
                                name: 'status',
                                valueField: 'id',
                                displayField: 'status',
                                allowBlank: false
                            },
                            header: 'Status', width: 75, sortable: true, dataIndex: 'status', renderer: this.addTooltip
                        }
                    ], 
            // top toolbar
            dockedItems: [{
                    xtype: 'toolbar',
                    dock: 'top',
                    itemId: 'tbar',
                    items: [{
                            hidden: true,
                            text: 'Add',
                            tooltip: 'Add new vendor',
                            iconCls: 'icon-add',
                            handler: Ext.Function.bind(this.loadAddForm, this),
                            itemId: 'addButton'
                        }, {
                            hidden: true,
                            text: 'Edit',
                            tooltip: 'Edit vendor',
                            iconCls: 'icon-edit',
                            handler: Ext.Function.bind(this.loadEditForm, this),
                            itemId: 'editButton',
                            disabled: true
                        }, {
                            hidden: true,
                            text: 'Remove',
                            tooltip: 'Remove selected vendor',
                            iconCls: 'icon-remove',
                            handler: Ext.Function.bind(this.confirmRemove, this),
                            // @todo scope param works the same as Ext.Function.bind
                            // for now im not sure which is better practice
                            //scope: this,
                            itemId: 'removeButton',
                            disabled: true
                        }]
                }],
        }; // eo config object

        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));

        // call parent
        this.callParent(arguments);

        // configure selection model
        this.getSelectionModel().on('selectionchange', this.onSelectChange, this);
    },
    onSelectChange: function(selModel, selections) {
        this.getDockedComponent('tbar').getComponent('removeButton').enable();
        this.getDockedComponent('tbar').getComponent('editButton').enable();
        this.closeRightPanel();
    },
    /**
     * We override it to attach company id
     */
    onRender: function() {

        // its for dynamically showing columns
        // now its always hidden, but code is for later use
        /*if (this.showCompany == true) {
         var id = this.getColumnModel().findColumnIndex('company_name');
         this.getColumnModel().setHidden(id, false);
         }*/

        // add company id param
        this.store.proxy.extraParams['id'] = this.companyId;

        // call parent
        this.callParent(arguments);
    },
    loadAddForm: function() {
        // open right panel
        rightPanel = this.openRightPanel();

        Ext.getCmp('user-combo').store.removeAll();
        Ext.getCmp('user-combo').lastQuery = null;

        // show form in right panel
        var form = Ext.getCmp('user-form');

        // change title
        form.setTitle('Add User');

        // make password field required
        form.getForm().findField('password').allowBlank = false;

        // set grid reference in form object
        form.parent = this;
        form.urlSuffix = this.urlSuffix;

        // show empty form in right panel
        form.clear();
        form.show();

        // fill company id
        form.getForm().findField('companyId').setValue(this.companyId);

        // do layout to make flex working
        form.ownerCt.doLayout();
    },
    loadEditForm: function() {
        // check if row is selected
        if (!this.getSelectionModel().hasSelection()) {
            this.handleMissingSelection();
            return;
        }

        // open right panel
        rightPanel = this.openRightPanel();

        Ext.getCmp('user-combo').store.removeAll();
        Ext.getCmp('user-combo').lastQuery = null;

        // get selected row id
        var userId = this.getSelectionModel().getLastSelected().data.id;

        // show form in right panel
        var form = Ext.getCmp('user-form');

        // change title
        form.setTitle('Edit Vendor');

        // make password fields optional
        form.getForm().findField('password').allowBlank = true;
        form.getForm().findField('password-confirmation').allowBlank = true;

        // set grid reference in form object
        form.parent = this;
        form.urlSuffix = this.urlSuffix;

        // load data to form
        form.show().loadRecord(userId);

        // do layout to make flex working
        form.ownerCt.doLayout();
    },
    loadImportForm: function() {
        // open right panel
        rightPanel = this.openRightPanel();

        // show form in right panel
        var form = Ext.getCmp('user-import-form');

        // set grid reference in form object
        form.parent = this;
        form.urlSuffix = this.urlSuffix;

        // show form
        form.show();

        // do layout to make flex working
        form.ownerCt.doLayout();
    },
    confirmRemove: function() {
        // check if row is selected
        if (!this.getSelectionModel().hasSelection()) {
            this.handleMissingSelection();
            return;
        }

        // get selected row id
        var userId = this.getSelectionModel().getLastSelected().data.id;
        var userName = this.getSelectionModel().getLastSelected().data.name;

        // ask to make sure
        Ext.MessageBox.confirm('Remove User', 'Are you sure you want to remove user "' + userName + '"?', Ext.Function.bind(this.removeUser, this));
    },
    removeUser: function(btn, text) {
        if (btn == 'yes') {
            // get selected row id
            var userId = this.getSelectionModel().getLastSelected().data.id;

            // for reference in request succes method
            var grid = this;

            Ext.Ajax.request({
                url: WEB_SERVICE + '/webservice/user/remove' + this.urlSuffix,
                params: {id: userId},
                method: 'POST',
                success: Ext.Function.bind(this.handleAjaxResponse, this),
                failure: Ext.Function.bind(this.handleAjaxResponse, this)
            });
        }
    },
    handleMissingSelection: function() {
        Ext.Msg.alert('', 'Please select row first.');
        this.getDockedComponent('tbar').getComponent('removeButton').disable();
        this.getDockedComponent('tbar').getComponent('editButton').disable();
    },
    /**
     * We override it to attach company id
     */
    recreate: function() {
        // add company id param
        this.store.proxy.extraParams['id'] = this.companyId;

        // call parent
        this.callParent(arguments);
    }
});

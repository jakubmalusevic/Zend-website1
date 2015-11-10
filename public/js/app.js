Ext.application({
    extend: 'Ext.Component',
    requires: ['Ext.container.Viewport'],
    name: 'Glamme',
    
    initComponent: function() {
        /**
         * Configure Viewport
         */
        var viewport = new Ext.Viewport({
            id: 'id-application-viewport',
            layout: 'border',
            defaults: {
                collapsible: true,
                split: true
            },
            items: [{
                region: 'north',
                xtype: 'toolbar',
                title: 'Glamme',
                split: false,
                items: [
                    { xtype: 'tbfill' },
                    {
                        xtype: 'label',
                        text: 'User: admin',
                    },
                    /*{
                        text: 'Change Password',
                        tooltip: 'Change Password',
                        handler:  Ext.Function.bind(this.loadChangePasswordForm, this),
                    },*/
                    {
                        text: 'Logout',
                        tooltip: 'Logout',
                        handler: function() {
                            window.location.href = 'index/logout';
                        },
                    }
                ]   
            },{
                title: 'Master Admin',
                id: 'tab-masteradmin',
                region: 'center',
                margins: '0 0 0 0',
                xtype: 'grouptabpanel',
                border:'0 0 0 10',
                activeGroup: 0,
                collapsible: false,
                items: [{
                    mainItem: 0,
                    items: [{
                        title: 'Tickets',
                        iconCls: 'x-icon-tickets',
                        tabTip: 'Tickets tabtip',
                        items: [{
                                id: 'vendor-grid-own',
                                xtype: 'vendors-grid',
                                border: false,
                        }]
                    }, 
                    {
                        title: 'Dashboard',
                        tabTip: 'Dashboard tabtip',
                        border: false,
                        items: [{
                                id: 'vendor-grid-own1',
                                html: 'This is test',
                        }]                  
                    }]
                },{
                    mainItem: 1,
                    items: [{
                        title: 'tedfa',
                        iconCls: 'x-icon-tickets',
                        tabTip: 'Tickets tabtip',
                        items: [{
                                id: 'vendor-grid-own3',
                                xtype: 'vendors-grid',
                                border: false,
                        }]
                    }, 
                    {
                        title: 'test',
                        tabTip: 'Dashboard tabtip',
                        border: false,
                        items: [{
                                id: 'vendor-grid-own2',
                                html: 'This is test',
                        }]                  
                    }]
                }] 
            }
            ]
        });
        this.callParent();
    },
    loadChangePasswordForm: function() {       
        var form = Ext.create('Strata.User.ChangePassword.Form');

        // set grid reference in form object
        form.parent = this;                           
        
        var win = Ext.create('Ext.window.Window', {           
            title: 'Change Password',
            width: 300,
            id: 'change-password-window',   
            height: 150,
            minWidth: 300,
            minHeight: 150,
            layout: 'fit',
            plain: true,
            items: form,
            resizable: false, 
            defaultFocus: 'change-password-field',    
            listeners: {
                // enable grid container on close/hide form
                'close': function(win) {
                    
                },
                'hide': function(win) {
                     
                }
            }
        });
        win.show();                                          

        // do layout to make flex working
        form.ownerCt.doLayout();
    },

    appFolder: 'app',

    launch: function() {
        
    }
});
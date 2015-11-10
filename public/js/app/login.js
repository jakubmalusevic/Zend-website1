// configure namespaces
Ext.ns('Glamme', 'Glamme.Login');

/** 
 * @class Glamme.Login.Form
 */

Ext.define('Glamme.Login.Form', {
    extend: 'Ext.form.FormPanel',
    alias: 'widget.login-form',
    fieldDefaults: {
        labelWidth: 80
    },
    frame: true,
    defaultType: 'textfield',
    monitorValid: true,
    /**
     * initComponent
     * @protected
     */
    initComponent: function() {
        // build the form-fields.  Always a good idea to defer form-building to a method so that this class can
        // be over-ridden to provide different form-fields
        this.items = this.buildForm();

        // build form-buttons
        this.buttons = this.buildUI();

        // call parent
        this.callParent();

        // allow to use ENTER to form submission
        this.listeners = {
            afterRender: function(thisForm, options) {
                this.keyNav = Ext.create('Ext.util.KeyNav', this.el, {
                    enter: this.handleSubmit,
                    scope: this
                });
            }
        }
    },
    /**
     * buildform
     * @private
     */
    buildForm: function() {
        return [{
                fieldLabel: 'Username',
                name: 'username',
                itemId: 'username',
                allowBlank: false
            }, {
                fieldLabel: 'Password',
                name: 'pass',
                inputType: 'password',
                allowBlank: false
            }];
    },
    /**
     * buildUI
     * @private
     */
    buildUI: function() {
        return [{
                text: 'Login',
                formBind: true,
                handler: Ext.Function.bind(this.handleSubmit, this)
            }];
    },
    handleSubmit: function() {
        // return false if client side validation fails
        if (!this.getForm().isValid()) {
            return false;
        }

        this.getForm().submit({
            url: 'login',
            method: 'POST',
            waitTitle: 'Processing',
            waitMsg: 'Please wait while we log you in...',
            success: Ext.Function.bind(this.onSuccess, this),
            failure: Ext.Function.bind(this.onFailure, this)
        });
    },
    onSuccess: function() {
        window.location = '../';
    },
    onFailure: function(form, action) {
        if (action.failureType == 'server') {
            obj = Ext.JSON.decode(action.response.responseText);
            Ext.Msg.alert('Login Failed!', obj.errors.reason);
        } else {
            Ext.Msg.alert('Warning!', 'Authentication server is unreachable : ' + action.response.responseText);
        }
        this.getForm().reset();
    }
});

// old code
Ext.onReady(function() {
    Ext.QuickTips.init();

    // This just creates a window to wrap the login form.
    // The login object is passed to the items collection.
    var win = new Ext.Window({
        layout: 'fit',
        width: 300,
        height: 150,
        closable: false,
        resizable: false,
        plain: true,
        border: false,
        title: 'Login',
        defaultFocus: 'username',
        items: [
            {xtype: 'login-form'}
        ]
    });
    win.show();
});
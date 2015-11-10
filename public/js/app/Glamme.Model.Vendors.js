// configure namespaces
Ext.ns('Glamme', 'Glamme.Model');


/**
 * @class Glamme.Model.Vendors
 */
Ext.define('Glamme.Model.Vendors', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id', type: 'int'},
        {name: 'first_name'},
        {name: 'last_name'},
        {name: 'middle_name'},
        {name: 'email'},
        {name: 'username'},
        {name: 'pass'},
        {name: 'address'},
        {name: 'city'},
        {name: 'state'},
        {name: 'zip'},
        {name: 'mobile'},
        {name: 'fax'},
        {name: 'birth_date', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'max_miles', type: 'int'},
        {name: 'areas_expertise'},
        {name: 'application_notes'},
        {name: 'creation_date', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'modification_date', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'status', type: 'int'},
    ]
});
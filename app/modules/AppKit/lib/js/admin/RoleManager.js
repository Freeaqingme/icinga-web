Ext.ns("AppKit.Admin");

AppKit.Admin.RoleManager = Ext.extend(Ext.Container, { 
    initRoleStore: function(cfg) {
        this.roleList = new Ext.data.JsonStore({
            autoDestroy: true,
            storeId: 'roleListStore',
            totalProperty: 'totalCount',
            root: 'roles',
            idProperty: 'id',

            url: cfg.roleProviderURI,
            remoteSort: true,

            baseParams: {
                hideDisabled: false
            },
            proxy: new Ext.data.HttpProxy({
                api: {
                    read: {method: 'GET', url: cfg.roleProviderURI}
                }
            }),
            fields: [
                {name: 'id', type:'int'},
                'name',
                'description',
                {name: 'active', type:'boolean'},
                {name: 'disabled_icon',type:'boolean' , mapping:'active', convert: function(v) {
                    return '<div style="width:16px;height:16px;margin-left:25px" class="'+(v===0? 'icinga-icon-cancel' : 'icinga-icon-accept')+'"></div>';
                }},
                {name: 'created'},
                {name: 'modified'},
                {name: 'parent'}
            ]
        });
    },

    constructor: function(cfg) {

        this.initRoleStore(cfg);
        cfg.items = this.getItems(cfg);

        Ext.Container.prototype.constructor.call(this,cfg);

    },

    layout: 'fit', 
    getItems: function(cfg) {
        var grid = new AppKit.Admin.Components.RoleListingGrid(Ext.apply(cfg,{store: this.roleList}));
        
        return new Ext.Panel({
            layout: 'border',
            border:false,
            defaults: {
                margins: {top: 10, left: 10, bottom: 20}
            },
            items: [{
                region:'center',
                xtype:'panel',
                layout: 'border',
                id:'roleListPanel',

                items: [
                    grid,
                    new AppKit.Admin.Components.RoleInheritanceView(Ext.apply(cfg,{grid:grid,store: this.roleList}))
                ],
                autoScroll:true,
                listeners: {
                    render: function() {
                        this.roleList.load();
                    },
                    scope:this
                }
            },{
                region: 'east',
                xtype: 'panel',
                padding: 5,
                disabled:true,
                split:true,
                id: 'roleEditor',
                autoScroll:true,
                title: _('Edit role'),
                items: new Ext.form.FormPanel({
                    border: false,
                    items: AppKit.Admin.RoleEditForm(cfg)
                }),
                buttons: [
                {   
                    xtype: 'displayfield',
                    id:'progressbar-field',
                    width:200
                },{
                    iconCls: 'icinga-icon-disk',
                    id: 'btn-save-group',
                    text: _('Save'),
                    handler:  function(b) {
                        b.setIconClass('icinga-icon-throbber');
                        b.setText(_("Saving role"));
                        b.setDisabled(false);
                        var _this = this;
                        AppKit.Admin.RoleEditForm.saveRole(
                            cfg.roleProviderURI,
                            function() {
                                Ext.getCmp('progressbar-field').setValue(
                                    "<span style='color:green;margin:4px;'>"+_("Role saved successfully")+"</span>"
                                );
                                b.setIconClass('icinga-icon-disk');
                                b.setText(_("Save"));
                                b.setDisabled(false);
                                _this.roleList.load();
                                Ext.getCmp('roleEditor').setDisabled(true);
                            },
                            function() {
                                Ext.getCmp('progressbar-field').setValue(
                                    "<span style='color:red;margin:4px;'>"+_("Couldn't save role, review your settings")+"</span>"
                                );
                                b.setIconClass('icinga-icon-disk');
                                b.setText(_("Retry"));
                                b.setDisabled(false);
                            }
                        );

                    },
                    scope:this
                }],
                width: '30%'
            }]	
        });
    }
});

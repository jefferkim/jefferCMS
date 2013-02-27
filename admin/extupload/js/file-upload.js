/*!
 * Ext JS Library 3.2.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

Ext.onReady(function(){

    Ext.QuickTips.init();

    var msg = function(title, msg){
        Ext.Msg.show({
            title: title,
            msg: msg,
            minWidth: 200,
            modal: true,
            icon: Ext.Msg.INFO,
            buttons: Ext.Msg.OK
        });
    };


    var fp = new Ext.FormPanel({
        renderTo: 'fi-form',
        fileUpload: true,
        width: 500,
        frame: true,
        title: 'File Upload Form',
        autoHeight: true,
        bodyStyle: 'padding: 10px 10px 0 10px;',
        labelWidth: 56,
        defaults: {
            anchor: '95%',
            allowBlank: false,
            msgTarget: 'side'
        },
        items: [{
            xtype: 'textfield',
            fieldLabel: '图片名称',
			name: 'Pname',
			value: pic_pro_name
        },{
            xtype: 'fileuploadfield',
            id: 'form-file',
            emptyText: '请选择图片...',
            fieldLabel: '图片地址',
            name: 'photo-path',
            buttonText: '',
            buttonCfg: {
                iconCls: 'upload-icon'
            }
        }],
        buttons: [{
            text: '提交',
            handler: function(){
                if(fp.getForm().isValid()){
	                fp.getForm().submit({
	                    url: links,
	                    waitMsg: '图片正在上传...',
	                    success: function(fp, o){
	                        msg('提示信息', '图片"'+o.result.file+'"');
	                    }
	                });
                }
            }
        },{
            text: '重置',
            handler: function(){
                fp.getForm().reset();
            }
        }]
    });

});
/* 
 * Global error handler for icinga-web
 * .
 */

Ext.ns("AppKit.errorHandler");
(function() {
	AppKit.errorHandler = new function() {
		var errorMsg = function(msg,file,line) {
			this.msg = 'No message available';
			this.file = 'No file available';
			this.line = 'No line available';
			this.stack = 'No stacktrace available';
			this.comment = "<span style='color:#ff0000'>No comment</span>";
			this.time = new Date().toLocaleString();
			try {
				this.msg = msg;
				this.file = file;
				this.line = line;

			//	this.stack = printStackTrace({e:msg,guess:false})
			} catch(e) {}
		};

		var errorReport = function() {

			
			this.getHeader = function() {
				return  ";---------------------------------------------------\n"+
					";Icinga Interface Error Report	\n"+
					";---------------------------------------------------\n\n"+
					";Header definitions\n"+
					"CreationTime = '"+((new Date()).toLocaleString() || 'Unknown')+"'\n"+
					"URL = '"+(window.location.href || 'Unknown')+"'\n"+
					"Platform = '"+(navigator.platform || 'Unknown')+"'\n"+
					"User-Agent = '"+(navigator.userAgent || 'Unknown')+"'\n"+
					"\n";
			}
			
			this.text = ''
			this.send = function() {}
			this.show = function() {
				this.update();
				var id = Ext.id('errorProtocol');
				(new Ext.Window({
					title: _('Error report'),
					autoHeight:true,
					id: id,
					width:800,
					constrain:true,
					items: [{
						html: "<div style='height:300px;width:100%;overflow:scroll' class='icinga-codeBox'>"+this.text+"</div>"
					},{
						html: "<div style='width:100%;height:100%;font-size:12px;padding:5px;text-align:center'>If this bug is not already reported, feel free to report it at our <a href='https://dev.icinga.org/projects/icinga-web'>Bugtracker</a> (Don't forget to attach this report).</div>"
					}],
					buttons: [{
						text: _('Close'),
						iconCls: 'icinga-icon-close',
						handler: function() {
							Ext.getCmp(id).close();
						}
					}]
				})).show(document.body);
			}
			this.update = function() {
				this.buildText();
			}
			
			this.buildText = function() {
				this.text = this.getHeader();
				this.text += ";The following errors occured\n";
				var ctr = 1;
				Ext.each(occuredErrors, function(error) {
					var textMsg = "[Error "+(ctr++)+"]\n";
					textMsg += 
						"Message = '"+error.msg+"'\n"+
						"File = '"+error.file+"'\n"+
						"Line = '"+error.line+"'\n"+
						"Time = '"+error.time+"'\n"+
						"Comment = '"+error.comment+"'\n\n";
					this.text += textMsg;
					
				},this);
				this.text += ";EOF";
			}
			
			this.buildText();

		}

		var occuredErrors = [];
		var suspended = false;
		var showErrors = true;
		var handleError = function(msg,file,line) {
			AppKit.log("!");
			var curError = new errorMsg(msg,file,line);
			occuredErrors.push(curError);

			if(showErrors) {
				updateErrorDisplay();
			}

		};
		var bugReportField = null;
		var updateErrorDisplay = function() {
			if(!bugReportField)
				setupErrorDisplay();
			else {
				bugReportField.setText(occuredErrors.length);
				Ext.getCmp('menu-navigation').doLayout();
			}
			
		}

		var setupErrorDisplay = function() {

			var elem = Ext.getCmp('menu-navigation');
			bugReportField = new Ext.Button({
				text: occuredErrors.length,
				iconCls: 'icinga-icon-bug',
				handler: AppKit.errorHandler.showErrorMessageInfoBox
			})
			elem.addItem(bugReportField);
			elem.doLayout();
			
		}

		window.onerror = handleError;

		return {
			clearErrors : function() {
				occuredErrors = [];
				updateErrorDisplay();
			},
			getErrors: function() {
				return occuredErrors;
			},
			setError: function(msg,file,line) {
				this.handleError(msg,file,line);
			},

			suspend: function() {
				window.onerror = function() {};
				suspended = true;
			},

			resume: function() {
				window.onerror = handleError;
				suspended = false;
			},

			isSuspended: function() {
				return suspended
			},

			showErrorMessageInfoBox: function() {
				var data = [];
				var i=0;
				Ext.each(occuredErrors,function(error) {
					data.push([i++,error.msg,error.file,error.line,error.time,error.comment]);
				})
				var dview = new Ext.DataView({
					store:new Ext.data.ArrayStore({
						fields: ['id','msg','file','line','time','comment'],
						idIndex: 0,
						data: data,
						autoDestroy: true
					}),
					tpl: new Ext.XTemplate(
						'<tpl for=".">',
							'<div qtip="Click to comment this bug" class="icinga-bugBox">',
								'<b>Message</b>: {msg}<br/>',
								'<b>File</b>: {file}<br/>',
								'<b>Line</b>: {line}<br/>',
								'<b>Occured</b>: {time}<br/>',
								'<b>Comment</b>: {comment}',
							'</div>',
						'</tpl>'),
					listeners: {
						click: function(dview,index,node,event) {
							var error = dview.getStore().getAt(index);
							Ext.Msg.prompt(
								_("Comment bug"),
								_("Please enter a comment for this bug. This could be"+
								  "<div style='background-color: #ffffff;padding:5px;-moz-border-radius:5px;-webkit-border-radius:5px'><ul style='list-style-type:circle'><li>What did you do when it occured?</li><li>Could you reproduce it? How?</li><li>Did you encounter any problems with the interface when the bug occured</li><li>If it happened after an update: Did the feature work in prior versions?</li></ul></div>"),
								function(btn,text) {
									if(btn != 'ok')
										return false;
									error.set('comment', encodeURI(text));
									dview.refresh();
									occuredErrors[index]["comment"] = encodeURI(text);
								},this,true
							);
						},
						scope:this
					},
					overClass:'xover',
					itemSelector:'div.icinga-bugBox'

				});
				var boxId = Ext.id('box_bug');
				var box = new Ext.Window({
					modal:true,
					height: 400,
					constrain:true,
					width:700,
					title: _('Bug report'),
					layout:'auto',
					id: boxId,
					items: [{
						padding:5,
						html:'<div class="icinga-icon-bug-32" style="padding-left:35px;padding-top:2px;height:32px;overflow:visible"><h2>'+_('Icinga bug report')+'</h2></div>'+
							'<br/>'+_('The following '+occuredErrors.length+' error(s) occured, sorry for that:')
					},{
						layout:'auto',
						xtype:'panel',
						collapsible:true,
						height:250,
						autoScroll:true,
						padding:5,
						items:dview
					}],

					buttons: [/*{
						text: _('Send report to admin'),
						iconCls: 'icinga-icon-application-form',
						handler: function() {new errorReport().send();},
						scope:this
					},*/{
						text: _('Create report for dev.icinga.org'),
						iconCls: 'icinga-icon-information',
						handler: function() {new errorReport().show();},
						scope:this
					},{
						text: _('Clear errors'),
						iconCls: 'icinga-icon-delete',
						handler: function() {
							AppKit.errorHandler.clearErrors()
							Ext.getCmp(boxId).close();
						},
						scope:this
					},{
						text: _('Close'),
						iconCls: 'icinga-icon-cancel',
						handler: function() {
							Ext.getCmp(boxId).close();
						}
					}]
				}).show(document.body);
			}
		}

	}


})();

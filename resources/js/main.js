
function is_string(element) {
    return (typeof element == 'string');
}

var Devo = {
    Core: {
		Pollers: {
			Locks: {},
			Callbacks: {}
		}
	},
    Main: {
        Helpers: {
            Backdrop: {},
            Dialog: {},
            Message: {}
        },
		Login: {}
    },
	Chat: {},
	Admin: {
		Cards: {}
	},
	Play: {},
	Games: {},
	effect_queues: {
		successmessage: 'Devo_successmessage',
		failedmessage: 'Devo_failedmessage'
	},
	debug: false
}

Devo.Core._processCommonAjaxPostEvents = function(options) {
	if (options.remove) {
		if (is_string(options.remove)) {
			if ($(options.remove)) $(options.remove).remove();
		} else {
			options.remove.each(function(s) {if (is_string(s) && $(s)) $(s).remove();else if ($(s)) s.remove();});
		}
	}
	if (options.hide) {
		if (is_string(options.hide)) {
			if ($(options.hide)) $(options.hide).hide();
		} else {
			options.hide.each(function(s) {if (is_string(s) && $(s)) $(s).hide();else if ($(s)) s.hide();});
		}
	}
	if (options.show) {
		if (is_string(options.show)) {
			if ($(options.show)) $(options.show).show();
		} else {
			options.show.each(function(s) {if ($(s)) $(s).show();});
		}
	}
	if (options.enable) {
		if (is_string(options.enable)) {
			if ($(options.enable)) $(options.enable).enable();
		} else {
			options.enable.each(function(s) {if ($(s)) $(s).enable();});
		}
	}
	if (options.disable) {
		if (is_string(options.disable)) {
			if ($(options.disable)) $(options.disable).disable();
		} else {
			options.disable.each(function(s) {if ($(s)) $(s).disable();});
		}
	}
	if (options.reset) {
		if (is_string(options.reset)) {
			if ($(options.reset)) $(options.reset).reset();
		} else {
			options.reset.each(function(s) {if ($(s)) $(s).reset();});
		}
	}
	if (options.clear) {
		if (is_string(options.clear)) {
			if ($(options.clear)) $(options.clear).clear();
		} else {
			options.clear.each(function(s) {if ($(s)) $(s).clear();});
		}
	}
};

Devo.Core._escapeWatcher = function(event) {
	if (Event.KEY_ESC != event.keyCode) return;
	Devo.Main.Helpers.Backdrop.reset();
};

/**
 * Clears all popup messages from the effect queue
 */
Devo.Main.Helpers.Message.clear = function() {
	Effect.Queues.get(Devo.effect_queues.successmessage).each(function(effect) {effect.cancel();});
	Effect.Queues.get(Devo.effect_queues.failedmessage).each(function(effect) {effect.cancel();});
	if ($('dragonevo_successmessage').visible()) {
		$('dragonevo_successmessage').fade({duration: 0.2});
	}
	if ($('dragonevo_failuremessage').visible()) {
		$('dragonevo_failuremessage').fade({duration: 0.2});
	}
};

/**
 * Shows an error popup message
 *
 * @param title string The title to show
 * @param content string Error details
 */
Devo.Main.Helpers.Message.error = function(title, content) {
	$('dragonevo_failuremessage_title').update(title);
	$('dragonevo_failuremessage_content').update(content);
	if ($('dragonevo_successmessage').visible()) {
		Effect.Queues.get(Devo.effect_queues.successmessage).each(function(effect) {effect.cancel();});
		new Effect.Fade('dragonevo_successmessage', {queue: {position: 'end', scope: Devo.effect_queues.successmessage, limit: 2}, duration: 0.2});
	}
	if ($('dragonevo_failuremessage').visible()) {
		Effect.Queues.get(Devo.effect_queues.failedmessage).each(function(effect) {effect.cancel();});
		new Effect.Pulsate('dragonevo_failuremessage', {duration: 1, pulses: 4});
	} else {
		new Effect.Appear('dragonevo_failuremessage', {queue: {position: 'end', scope: Devo.effect_queues.failedmessage, limit: 2}, duration: 0.2});
	}
	new Effect.Fade('dragonevo_failuremessage', {queue: {position: 'end', scope: Devo.effect_queues.failedmessage, limit: 2}, delay: 30, duration: 0.2});
};

/**
 * Shows a "success"-style popup message
 *
 * @param title string The title to show
 * @param content string Message details
 */
Devo.Main.Helpers.Message.success = function(title, content) {
	$('dragonevo_successmessage_title').update(title);
	$('dragonevo_successmessage_content').update(content);
	if (title || content) {
		if ($('dragonevo_failuremessage').visible()) {
			Effect.Queues.get(Devo.effect_queues.failedmessage).each(function(effect) {effect.cancel();});
			new Effect.Fade('dragonevo_failuremessage', {queue: {position: 'end', scope: Devo.effect_queues.failedmessage, limit: 2}, duration: 0.2});
		}
		if ($('dragonevo_successmessage').visible()) {
			Effect.Queues.get(Devo.effect_queues.successmessage).each(function(effect) {effect.cancel();});
			new Effect.Pulsate('dragonevo_successmessage', {duration: 1, pulses: 4});
		} else {
			new Effect.Appear('dragonevo_successmessage', {queue: {position: 'end', scope: Devo.effect_queues.successmessage, limit: 2}, duration: 0.2});
		}
		new Effect.Fade('dragonevo_successmessage', {queue: {position: 'end', scope: Devo.effect_queues.successmessage, limit: 2}, delay: 10, duration: 0.2});
	} else if ($('dragonevo_successmessage').visible()) {
		Effect.Queues.get(Devo.effect_queues.successmessage).each(function(effect) {effect.cancel();});
		new Effect.Fade('dragonevo_successmessage', {queue: {position: 'end', scope: Devo.effect_queues.successmessage, limit: 2}, duration: 0.2});
	}
};

Devo.Main.Helpers.Dialog.show = function(title, content, options) {
	Devo.Main.Helpers.Message.clear();
	$('dialog_title').update(title);
	$('dialog_content').update(content);
	$('dialog_yes').setAttribute('href', 'javascript:void(0)');
	$('dialog_no').setAttribute('href', 'javascript:void(0)');
	$('dialog_yes').stopObserving('click');
	$('dialog_no').stopObserving('click');
	if (options['yes']['click']) {
		$('dialog_yes').observe('click', options['yes']['click']);
	}
	if (options['yes']['href']) {
		$('dialog_yes').setAttribute('href', options['yes']['href']);
	}
	if (options['no']['click']) {
		$('dialog_no').observe('click', options['no']['click']);
	}
	if (options['no']['href']) {
		$('dialog_no').setAttribute('href', options['no']['href']);
	}
	$('dialog_backdrop_content').show();
	$('dialog_backdrop').appear({duration: 0.2});
}

Devo.Main.Helpers.Dialog.dismiss = function() {
	$('dialog_backdrop_content').fade({duration: 0.2});
	$('dialog_backdrop').fade({duration: 0.2});
}

/**
 * Convenience function for running an AJAX call and updating / showing / hiding
 * divs on json feedback
 *
 * Available options:
 *   loading: {} Instructions for the onLoading event
 *   success: {} Instructions for the onSuccess event
 *   failure: {} Instructions for the onComplete event
 *   complete: {} Instructions for the onComplete event
 *
 *   Common options for all on* events:
 *     hide: string/array A list of / element id(s) to hide
 *     reset: string/array A list of / element id(s) to reset
 *     show: string/array A list of / element id(s) to show
 *     clear: string/array A list of / element id(s) to clear
 *     remove: string/array A list of / element id(s) to remove
 *     enable: string/array A list of / element id(s) to enable
 *     disable: string/array A list of / element id(s) to disable
 *     callback: a function to call at the end of the event. For
 *		         success/failure/complete events, the callback
 *		         function retrieves the json object
 *
 *   The loading.indicator element will be toggled off in the onComplete event
 *
 *   Options for the onSuccess event instruction set:
 *     update: either an element id which will receive the value of the
 *             json.content property or an object with instructions:
 *     replace: either an element id which will be replace with the value of the
 *             json.content property or an object with instructions:
 *
 *     Available instructions for the success "update" object:
 *       element: the id of the element to update
 *       insertion: true / false / ommitted. If "true" the element will get the
 *                  content inserted after the existing content, instead of
 *                  the content replacing the existing content
 *       from: if the json return value does not contain a "content" key,
 *			   specify which json key should be used
 *
 * @param url The URL to call
 * @param options An associated array of options
 */
Devo.Main.Helpers.ajax = function(url, options) {
	var params = (options.params) ? options.params : '';
	if (options.form && options.form != undefined) params = Form.serialize(options.form);
	if (options.additional_params) params += options.additional_params;
	var url_method = (options.url_method) ? options.url_method : 'post';

	new Ajax.Request(url, {
		asynchronous: true,
		method: url_method,
		parameters: params,
		evalScripts: true,
		onLoading: function () {
			if (options.loading) {
				if ($(options.loading.indicator)) {
					$(options.loading.indicator).show();
				}
				Devo.Core._processCommonAjaxPostEvents(options.loading);
				if (options.loading.callback) {
					options.loading.callback();
				}
			}
		},
		onSuccess: function (response) {
			var json = response.responseJSON;
			if (json || (options.success && options.success.update)) {
				if (json && json.forward != undefined) {
					document.location = json.forward;
				} else {
					if (options.success && options.success.update) {
						var json_content_element = (is_string(options.success.update) || options.success.update.from == undefined) ? 'content' : options.success.update.from;
						var content = (json) ? json[json_content_element] : response.responseText;
						var update_element = (is_string(options.success.update)) ? options.success.update : options.success.update.element;
						if ($(update_element)) {
							var insertion = (is_string(options.success.update)) ? false : (options.success.update.insertion) ? options.success.update.insertion : false;
							if (insertion) {
								$(update_element).insert(content, 'after');
							} else {
								$(update_element).update(content);
							}
						}
						if (json && json.message) {
							Devo.Main.Helpers.Message.success(json.message);
						}
					} else if (options.success && options.success.replace) {
						var json_content_element = (is_string(options.success.replace) || options.success.replace.from == undefined) ? 'content' : options.success.replace.from;
						var content = (json) ? json[json_content_element] : response.responseText;
						var replace_element = (is_string(options.success.replace)) ? options.success.replace : options.success.replace.element;
						if ($(replace_element)) {
							Element.replace(replace_element, content);
						}
						if (json && json.message) {
							Devo.Main.Helpers.Message.success(json.message);
						}
					} else if (json && (json.title || json.content)) {
						Devo.Main.Helpers.Message.success(json.title, json.content);
					} else if (json && (json.message)) {
						Devo.Main.Helpers.Message.success(json.message);
					}
					if (options.success) {
						Devo.Core._processCommonAjaxPostEvents(options.success);
						if (options.success.callback) {
							options.success.callback(json);
						}
					}
				}
			}
		},
		onFailure: function (response) {
			var json = (response.responseJSON) ? response.responseJSON : undefined;
			if (response.responseJSON) {
				Devo.Main.Helpers.Message.error(json.error, json.message);
			} else {
				if (Devo.debug) {
					$('csp-dbg-content').insert(response.responseText, 'before');
				}
			}
			if (options.failure) {
				Devo.Core._processCommonAjaxPostEvents(options.failure);
				if (options.failure.callback) {
					options.failure.callback(response);
				}
			}
		},
		onComplete: function (response) {
			if (Devo.debug) {
				$('csp-dbg-content').insert(response.responseJSON['csp-debugger'], 'before');
			}
			if (options.loading && options.loading.indicator && $(options.loading.indicator)) $(options.loading.indicator).hide();
			if (options.complete) {
				Devo.Core._processCommonAjaxPostEvents(options.complete);
				if (options.complete.callback) {
					var json = (response.responseJSON) ? response.responseJSON : undefined;
					options.complete.callback(json);
				}
			}
		}
	});
};

Devo.Main.Helpers.Backdrop.show = function(url) {
	$('fullpage_backdrop').appear({duration: 0.2});
	$$('body')[0].setStyle({'overflow': 'hidden'});
	$('fullpage_backdrop_indicator').show();

	if (url != undefined) {
		Devo.Main.Helpers.ajax(url, {
			url_method: 'get',
			loading: {indicator: 'fullpage_backdrop_indicator'},
			success: {
				update: 'fullpage_backdrop_content',
				callback: function () {
					$('fullpage_backdrop_content').appear({duration: 0.2});
					$('fullpage_backdrop_indicator').fade({duration: 0.2});
				}},
			failure: {hide: 'fullpage_backdrop'}
		});
	}
};

Devo.Main.Helpers.Backdrop.reset = function() {
	$$('body')[0].setStyle({'overflow': 'auto'});
	$('fullpage_backdrop').fade({duration: 0.2});
	Devo.Core._resizeWatcher();
};

Devo.Main.Helpers.tabSwitcher = function(element, visibletab) {
	var menu = $(element).up('ul').id;
	$(menu).childElements().each(function(item){item.removeClassName('selected');});
	$(visibletab).addClassName('selected');
	$(menu + '_panes').childElements().each(function(item){item.hide();});
	$(visibletab + '_pane').show();
};

Devo.Main.Login.register = function(url)
{
	Devo.Main.Helpers.ajax(url, {
		form: 'register_form',
		loading: {
			indicator: 'register_indicator',
			hide: 'register_button',
			callback: function() {
				$$('input.required').each(function(field) {
					$(field).setStyle({backgroundColor: ''});
				});
			}
		},
		success: {
			hide: 'register',
			update: {element: 'register_message', from: 'loginmessage'},
			show: 'register2'
		},
		failure: {
			show: 'register_button',
			callback: function(json) {
				json.fields.each(function(field) {
					$(field).setStyle({backgroundColor: '#FBB'});
				});
			}
		}
	});
}

Devo.Core._resizeWatcher = function() {
	if ($('game-table')) {
		var docheight = document.viewport.getHeight();
		//var docwidth = document.viewport.getWidth();
		$('game-table').setStyle({height: docheight - 100 + 'px'});
		var gtl = $('game-table').getLayout();
		var boardheight = gtl.get('height') - gtl.get('padding-top') - gtl.get('padding-bottom');
		var card_slot_height = parseInt((boardheight / 10) * 3) - 9;
		var card_slot_width = parseInt(card_slot_height / 1.6);
		var boardwidth = (card_slot_width * 5) + 100;
		$('game-table').setStyle({width: boardwidth + 'px', marginLeft: 'auto', marginRight: 'auto'});
		$$('.card-slots-container').each(function(element) {
			$(element).setStyle({width: (card_slot_width * 5) + 70 + 'px', height: card_slot_height + 4 + 'px'});
			$(element).select('.card-slot').each(function(card_element) {
				$(card_element).setStyle({height: card_slot_height + 'px', width: card_slot_width + 'px'});
			});
		});
		var play_area_height = boardheight - ((card_slot_height + 20) * 2) - 10;
		$('play-area').setStyle({height: play_area_height + 'px'});
		$('event-slot').setStyle({height: play_area_height - 9 + 'px', width: parseInt((play_area_height - 15) / 1.6) + 'px'});
	}
}

Devo.Core.Pollers.Callbacks.invitePoller = function() {
	if (!Devo.Core.Pollers.Locks.invitepoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_invites',
			form: 'existing_game_invites',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.invitepoller = true;
				}
			},
			success: {
				callback: function(json) {
					if (json.invites) {
						for (var d in json.invites) {
							if (json.invites.hasOwnProperty(d)) {
								var invite = json.invites[d];
								$('existing_game_invites').insert('<input type="hidden" name="invites['+invite.invite_id+']" value="'+invite.invite_id+'">');
								var invite_element = $('__game_invite_template').clone(true);
								invite_element.id = 'game_invite_' + invite.invite_id;
								$(invite_element).insert('<input type="hidden" name="invite_id" value="'+invite.invite_id+'">');
								$(invite_element).down('.player_name').update(invite.player_name);
								$(invite_element).show();
								$('game_invites').insert(invite_element);
							}
						}
						window.setTimeout( function() {
							for (var d in json.invites) {
								if (json.invites.hasOwnProperty(d)) {
									var invite = json.invites[d];
									$('game_invite_' + invite.invite_id).addClassName('visible animated fadeInLeft');
								}
							}
						}, 100);
					}
				}
			},
			complete: {
				callback: function() {
					Devo.Core.Pollers.Locks.invitepoller = false;
				}
			}
		});
	}
};

Devo.Core.Pollers.Callbacks.chatRoomPoller = function() {
	if (!Devo.Core.Pollers.Locks.chatroompoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=chat_lines',
			form: 'chat_rooms_joined',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.chatroompoller = true;
				}
			},
			success: {
				callback: function(json) {
					if (json.chat_lines) {
						for (var d in json.chat_lines) {
							if (json.chat_lines.hasOwnProperty(d)) {
								var room = json.chat_lines[d];
								var room_id = d;
								for (var l in room['lines']) {
									if (room['lines'].hasOwnProperty(l)) {
										var line = room['lines'][l];
										var line_id = line['line_id'];
										if (!$('chat_line_'+line_id)) {
											$('chat_room_'+room_id+'_since').setValue(line_id);
											var chat_line = '<div id="chat_line_'+line_id+'" class="chat_line"><div class="chat_nickname">';
											if (line['user_id'] != Devo.options['user_id']) {
												chat_line += '<div class="tooltip lighter">Username: '+line['user_username']+'<br>Level: '+line['user_level']+'<br><div class="buttons"><button class="button button-silver" onclick="Devo.Play.invite('+line['user_id']+', this);"><img src="/images/spinning_16.gif" style="display: none;">Invite to game</button></div></div>';
											}
											chat_line += line['user_username']+'&nbsp;<span class="chat_timestamp">('+line['posted_formatted_hours']+'<span class="date"> - '+line['posted_formatted_date']+'</span>)</div><div class="chat_line_content">'+line['text']+'</div></div>';
											$('chat_room_'+room_id+'_lines').insert(chat_line);
											$('chat_room_'+room_id+'_lines').scrollTop = $('chat_line_'+line_id).offsetTop;
										}
									}
								}
							}
						}
					}
				}
			},
			complete: {
				callback: function(json) {
					if (json.chat_lines) {
						for (var d in json.chat_lines) {
							if (json.chat_lines.hasOwnProperty(d)) {
								var room_id = d;
								if ($('chat_room_'+room_id+'_loading').visible()) {
									$('chat_room_'+room_id+'_loading').hide();
								}
								$('chat_room_'+room_id+'_num_users').update(json.chat_lines[d]['users']['count']);
							}
						}
					}
					Devo.Core.Pollers.Locks.chatroompoller = false;
				}
			}
		});
	}
};

Devo.Core.Pollers.Callbacks.quickMatchPoller = function() {
	if (!Devo.Core.Pollers.Locks.quickmatchpoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=quickmatch',
			form: 'chat_rooms_joined',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.quickmatchpoller = true;
				}
			},
			complete: {
				callback: function() {
					Devo.Core.Pollers.Locks.quickmatchpoller = false;
				}
			}
		});
	}
};

Devo.Core.Pollers.Callbacks.gameListPoller = function() {
	if (!Devo.Core.Pollers.Locks.gamelistpoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=gamelist',
			form: 'my_ongoing_games_form',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.gamelistpoller = true;
				}
			},
			success: {
				callback: function(json) {
					if (json.games) {
						for (var d in json.games) {
							if (json.games.hasOwnProperty(d)) {
								var game = json.games[d];
								var game_id = d;
								if ($('game_'+game_id+'_opponent_turn')) {
									(game.turn.opponent && game.invitation_confirmed) ? $('game_'+game_id+'_opponent_turn').show() : $('game_'+game_id+'_opponent_turn').hide();
									(game.turn.player && game.invitation_confirmed) ? $('game_'+game_id+'_player_turn').show() : $('game_'+game_id+'_player_turn').hide();
									if (game.invitation_confirmed) {
										$('game_'+game_id+'_invitation_unconfirmed').hide();
										var button = $('game_'+game_id+'_list').down('.button');
										button.removeClassName('disabled');
										button.enable();
									} else {
										$('game_'+game_id+'_invitation_unconfirmed').show();
									}
								}
							}
						}
					}
				}
			},
			complete: {
				callback: function() {
					Devo.Core.Pollers.Locks.gamelistpoller = false;
				}
			}
		});
	}
};

Devo.Core._initializeInvitePoller = function() {
	if ($('existing_game_invites') && $('__game_invite_template')) {
		Devo.Core.Pollers.invitepoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.invitePoller, 15);
		Devo.Core.Pollers.Callbacks.invitePoller();
	}
}

Devo.Core._initializeChatRoomPoller = function() {
	if ($('chat_rooms_joined')) {
		Devo.Core.Pollers.chatroompoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.chatRoomPoller, 3);
		Devo.Core.Pollers.Callbacks.chatRoomPoller();
	}
}

Devo.Core._initializeGameListPoller = function() {
	if ($('my_ongoing_games')) {
		Devo.Core.Pollers.gamelistpoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.gameListPoller, 10);
		Devo.Core.Pollers.Callbacks.gameListPoller();
	}
}

Devo.Core._initializeQuickmatchPoller = function() {
	Devo.Core.Pollers.quickmatchpoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.quickMatchPoller, 5);
}

Devo.Core._destroyQuickmatchPoller = function() {
	Devo.Core.Pollers.quickmatchpoller.stop();
	Devo.Core.Pollers.Locks.quickmatchpoller = undefined;
}

Devo.Core.initialize = function(options) {
	Devo.options = options;
	Devo.Core._initializeInvitePoller();
	Devo.Core._initializeChatRoomPoller();
	Devo.Core._initializeGameListPoller();
	Event.observe(window, 'resize', Devo.Core._resizeWatcher);
	Devo.Core._resizeWatcher();
}

Devo.Admin.Cards.saveAttack = function(form) {
	form = $(form);
	var attack_id = form.down('input[name=attack_id]').getValue();
	var url = form.action;
	var cb = (attack_id) ? {replace: 'admin_card_attack_'+attack_id} : {update: {element: 'admin_card_attacks', insertion: true}};
	cb.callback = Devo.Main.Helpers.Backdrop.reset;
	cb.hide = 'card_no_attacks';
	Devo.Main.Helpers.ajax(url, {
		form: form.id,
		loading: {indicator: 'save_attack_indicator'},
		success: cb
	});
};

Devo.Chat.joinRoom = function(room_id) {
	$('chat_rooms_joined').insert('<input type="hidden" name="rooms['+room_id+']" value="'+room_id+'">');	
	$('chat_rooms_joined').insert('<input id="chat_room_'+room_id+'_since" type="hidden" name="since['+room_id+']" value="">');
};

Devo.Chat.say = function(form) {
	form = $(form);
	var url = form.action;
	var indicator = form.down('img');
	var say_button = $(form.down('input[type=submit]'));
	Devo.Main.Helpers.ajax(url, {
		form: form.id,
		loading: {
			indicator: indicator.id,
			callback: function() {
				say_button.disable();
				say_button.addClassName('disabled');
			}
		},
		success: {
			callback: function() {
				Devo.Core.Pollers.Callbacks.chatRoomPoller();
				form.down('input[type=text]').value = '';
				say_button.enable();
				say_button.removeClassName('disabled');
			}
		}
	});
};

Devo.Play.quickmatch = function() {
	$('quickmatch_overlay').show();
	$('quickmatch_overlay').addClassName('loading');
	window.setTimeout( function() { $('cancel_quickmatch_button').addClassName('animated fadeIn'); }, 5000);
	window.setTimeout( function() { $('cancel_quickmatch_button').removeClassName('animated fadeIn'); }, 7000);
	Devo.Core._initializeQuickmatchPoller();
}

Devo.Play.invite = function(user_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		params: '&for=invite&user_id='+user_id,
		loading: {
			callback: function() {
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				$('my_ongoing_games_none').hide();
				$('my_ongoing_games').insert(json.game);
				window.setTimeout(function() { $('my_ongoing_games').childElements().last().addClassName('animated tada'); }, 100);
				window.setTimeout(function() { $('my_ongoing_games').childElements().last().removeClassName('animated tada'); }, 3000);
			}
		},
		complete: {
			callback: function() {
				$(button).down('img').hide();
			}
		}
	});
}

Devo.Play.cancelQuickmatch = function() {
	$('quickmatch_overlay').hide();
	$('quickmatch_overlay').removeClassName('loading');
	Devo.Core._destroyQuickmatchPoller();
}

Devo.Main.showCardActions = function(card_id) {
	var card = $('card_'+card_id);
	var cards = $$('.card');
	$$('.card_actions').each(function(element) { $(element).hide(); });
	if (card.hasClassName('selected')) {
		card.removeClassName('selected');
		cards.each(function(element) { $(element).removeClassName('faded'); });
	} else {
		cards.each(function(element) { $(element).addClassName('faded'); $(element).removeClassName('selected'); });
		card.removeClassName('faded');
		$('card_'+card_id).addClassName('selected');
		var ca = $('card_'+card_id+'_actions');
		ca.show();
	}
};

Devo.Core.upload = function(fileInputId, fileIndex) {
	// take the file from the input
	var file = document.getElementById(fileInputId).files[fileIndex];
	var reader = new FileReader();
	reader.readAsBinaryString(file); // alternatively you can use readAsDataURL
	reader.onloadend  = function(evt)
	{
			// create XHR instance
			xhr = new XMLHttpRequest();

			// send the file through POST
			xhr.open("POST", 'upload.php', true);

			// make sure we have the sendAsBinary method on all browsers
			XMLHttpRequest.prototype.mySendAsBinary = function(text){
				var data = new ArrayBuffer(text.length);
				var ui8a = new Uint8Array(data, 0);
				for (var i = 0; i < text.length; i++) ui8a[i] = (text.charCodeAt(i) & 0xff);
				var bb = new (window.MozBlobBuilder || window.WebKitBlobBuilder || window.BlobBuilder)();
				bb.append(data);
				var blob = bb.getBlob();
				this.send(blob);
			}

			// let's track upload progress
			var eventSource = xhr.upload || xhr;
			eventSource.addEventListener("progress", function(e) {
				// get percentage of how much of the current file has been sent
				var position = e.position || e.loaded;
				var total = e.totalSize || e.total;
				var percentage = Math.round((position/total)*100);

				// here you should write your own code how you wish to proces this
			});

			// state change observer - we need to know when and if the file was successfully uploaded
			xhr.onreadystatechange = function()
			{
				if(xhr.readyState == 4)
				{
					if(xhr.status == 200)
					{
						// process success
					}else{
						// process error
					}
				}
			};

			// start sending
			xhr.mySendAsBinary(evt.target.result);
	};
};

function is_string(element) {
    return (typeof element == 'string');
}

var Devo = {
    Core: {
		Pollers: {
			Locks: {},
			Callbacks: {}
		},
		Events: {},
		Listeners: {}
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
	Game: {},
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
		}else {
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

Devo.Core.Events.trigger = function(key, options) {
	if (Devo.Core.Listeners[key]) {
		Devo.Core.Listeners[key].each(function(callback) {
			callback(options);
		});
	}
};

Devo.Core.Events.listen = function(key, callback) {
	if (!Devo.Core.Listeners[key]) {
		Devo.Core.Listeners[key] = [];
	}
	Devo.Core.Listeners[key].push(callback);
};

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
					if (json.removed_invites) {
						for (var d in json.removed_invites) {
							if (json.removed_invites.hasOwnProperty(d)) {
								var invite_id = d;
								Devo.Play.removeInvite(invite_id);
							}
						}
					}
					if (json.invites) {
						for (var d in json.invites) {
							if (json.invites.hasOwnProperty(d)) {
								var invite = json.invites[d];
								$('existing_game_invites').insert('<input type="hidden" id="invites_input_'+invite.invite_id+'" name="invites['+invite.invite_id+']" value="'+invite.invite_id+'">');
								var invite_element = $('__game_invite_template').clone(true);
								invite_element.id = 'game_invite_' + invite.invite_id;
								var accept_button = $(invite_element).down('.buttons').down('.button-accept');
								accept_button.observe('click', function(event) {
									var button = Event.element(event);
									Devo.Play.acceptInvite(invite.invite_id, $(button));
								});
								var reject_button = $(invite_element).down('.buttons').down('.button-reject');
								reject_button.observe('click', function(event) {
									var button = Event.element(event);
									Devo.Play.rejectInvite(invite.invite_id, $(button));
								});
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
								var blinking = $('chat_room_'+room_id+'_loading').visible();
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
											if (!blinking && !Devo.Core._infocus) {
												clearInterval(Devo.Core._titleBlinkInterval);
												Devo.options.alternate_title = line['user_username'] + ' says ...';
												Devo.Core._titleBlinkInterval = setInterval(Devo.Core._blinkTitle, 2000);
												blinking = true;
											}
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
										var button_play = $('game_'+game_id+'_list').down('.button-play');
										button_play.removeClassName('disabled');
										button_play.enable();
										var button_cancel = $('game_'+game_id+'_list').down('.button-cancel');
										button_cancel.hide();
									} else if (game.invitation_rejected) {
										$('game_'+game_id+'_invitation_rejected').show();
										$('game_'+game_id+'_invitation_unconfirmed').hide();
										$('game_'+game_id+'_list').addClassName('rejected');
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
	Devo.Core._infocus = true;
	Devo.Core._isOldTitle = true;
	Devo.Core._titleBlinkInterval = undefined;
	Event.observe(window, 'focus', Devo.Core._stopBlinkTitle);
	Event.observe(window, 'blur', function() {Devo.Core._infocus = false;});
	Devo.Core.Events.trigger('devo:core:initialized');
}

Devo.Main.initializeLobby = function() {
	Devo.Core._initializeChatRoomPoller();
	Devo.Core._initializeGameListPoller();
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

Devo.Game.resizeWatcher = function() {
//	if ($('game-table')) {
//		var docheight = document.viewport.getHeight();
//		$('game-table').setStyle({height: docheight - 100 + 'px'});
//		var gtl = $('game-table').getLayout();
//		var boardheight = gtl.get('height') - gtl.get('padding-top') - gtl.get('padding-bottom');
//		var card_slot_height = parseInt((boardheight / 10) * 3) - 9;
//		var card_slot_width = parseInt(card_slot_height / 1.4);
//		var boardwidth = (card_slot_width * 5) + 100;
//		$('game-table').setStyle({width: boardwidth + 'px', marginLeft: 'auto', marginRight: 'auto'});
//		$$('.card-slots-container').each(function(element) {
//			$(element).setStyle({width: (card_slot_width * 5) + 70 + 'px', height: card_slot_height + 4 + 'px'});
//			$(element).select('.card-slot').each(function(card_element) {
//				$(card_element).setStyle({height: card_slot_height + 'px', width: card_slot_width + 'px'});
//			});
//		});
//		var play_area_height = boardheight - ((card_slot_height + 20) * 2) - 10;
//		$('play-area').setStyle({height: play_area_height + 'px'});
//		$('event-slot').setStyle({height: play_area_height - 9 + 'px', width: parseInt((play_area_height - 15) / 1.6) + 'px'});
//	}
}

Devo.Game._initializeResizeWatcher = function() {
	Event.observe(window, 'resize', Devo.Game.resizeWatcher);
	Devo.Game.resizeWatcher();
};

Devo.Core.Pollers.Callbacks.gameDataPoller = function() {
	if (!Devo.Core.Pollers.Locks.gamedatapoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_data&game_id='+Devo.Game._id+'&latest_event_id='+Devo.Game._latest_event_id,
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.gamedatapoller = true;
				}
			},
			success: {
				callback: function(json) {
					Devo.Game.processGameData(json.game.data);
					Devo.Game.processGameEvents(json.game.events);
					Devo.Game.data = json.game.data;
				}
			},
			complete: {
				callback: function() {
					Devo.Core.Pollers.Locks.gamedatapoller = false;
				},
				hide: 'fullpage_backdrop'
			}
		});
	}
};

Devo.Game.processGameData = function(data) {
};

Devo.Game.processGameEvents = function(events) {
	events.each(function(event) {
		Devo.Game._latest_event_id = event.id;
		switch (event.type) {
			case 'player_change':
				Devo.Game.processPlayerChange(event.data);
				break;
		}
		$('game_events').insert(event.event_content);
	});
};

Devo.Game.processPlayerChange = function(data) {
	$('turn-info').childElements().each(function(element) {
		if (element.id == 'player-'+data.player_id+'-turn') {
			// Make the element "visible", but invisible
			window.setTimeout(function() {
				$(element).setStyle({opacity: 0});
				$(element).show();
			}, 1400);

			// Make the element fade in after a very tiny delay
			window.setTimeout(function() {
				$(element).addClassName('fadeIn');
			}, 1500);

			// Remove fade in effect after it is done (1.5s) and make it permanently visible
			window.setTimeout(function() {
				$(element).removeClassName('fadeIn');
				$(element).addClassName('tada');
				$(element).setStyle({opacity: 1});
			}, 3000);
			
			// Remove fade in effect after it is done (1.5s) and make it permanently visible
			window.setTimeout(function() {
				$(element).removeClassName('tada');
			}, 4500);

		} else {
			// Make the element fade out
			$(element).addClassName('fadeOut');

			// Remove the fadeout effect and hide the element after the fadeout effect animation is complete (1.5s)
			window.setTimeout(function() {
				$(element).hide();
				$(element).removeClassName('fadeOut');
			}, 1500);
		}
	});
	if (data.player_id == Devo.options.user_id) {
		Devo.Game.enableTurn();
	} else {
		Devo.Game.disableTurn();
	}
};

Devo.Game.enableTurn = function() {
	var button = $('end-turn-button');
	button.removeClassName('disabled');
	button.addClassName('animated pulse');
	window.setTimeout(function() {button.removeClassName('animated pulse');}, 1500);
	Devo.Game._movable = true;
	Devo.Game._initializeDragDrop();
};

Devo.Game.disableTurn = function() {
	var button = $('end-turn-button');
	button.addClassName('disabled');
	Devo.Game._movable = false;
	Devo.Game._uninitializeDragDrop();
};

Devo.Game._initializeGameDataPoller = function() {
	Devo.Game.data = {};
	Devo.Core.Pollers.gamedatapoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.gameDataPoller, 2);
	Devo.Core.Events.listen('game:data:player_change', Devo.Game.processPlayerChange);
	Devo.Core.Pollers.Callbacks.gameDataPoller();
};

Devo.Game._calculateDropSlots = function(card) {
	if (card.up('#player_hand')) {
		$('player_stuff').addClassName('dragging');
	} else {
		if (!card.hasClassName('is-placed')) {
			$('player_stuff').addClassName('droptarget');
			$('player_stuff').removeClassName('fadeOut');
		} else {
			$('player_slots').addClassName('droptargets');
		}
	}
};

Devo.Game.card_dragstart = function(e) {
	Devo.Game.dropped = undefined;
	this.classList.add('dragging');
	e.dataTransfer.effectAllowed = 'move';
	e.dataTransfer.setData('text/plain', this.id);
	Devo.Game._calculateDropSlots($(this));
	return false;
};

Devo.Game.card_dragover = function(e) { 
	if (e.preventDefault) {
		e.preventDefault();
	}
	e.dataTransfer.dropEffect = 'move';
	return false;
};

Devo.Game.card_dragend = function(e) {
	e.preventDefault();
	$('player_stuff').removeClassName('dragging');
	$('player_stuff').removeClassName('droptarget');
	this.classList.remove('dragging');
	if (Devo.Game.dropped) {
		var jthis = jQuery(this);
		var pthis = $(this);
		var orig_pos = jthis.data('original_position');
		if (!orig_pos) {
			jthis.data({'original_position': pthis.up().id});
		} else if (orig_pos == Devo.Game.dropped) {
			jthis.data({'original_position': undefined});
		}
		var card = pthis.remove();
		$(Devo.Game.dropped).insert(card);
		if (Devo.Game.dropped != 'player_hand' && !pthis.hasClassName('medium')) pthis.addClassName('medium');
		if (Devo.Game.dropped == 'player_hand' && pthis.hasClassName('medium')) pthis.removeClassName('medium');
	}
};

Devo.Game.cardslot_dragover = function(e) {
	e.dataTransfer.dropEffect = 'move';
	var slot = $(this);
	if (this.id == 'player_stuff') {
		slot.addClassName('peek');
		e.preventDefault();
	} else if ((slot.hasClassName('player') && !slot.down('.card')) ||
		(slot.hasClassName('opponent') && slot.down('.card'))) {
		slot.addClassName('drop-hover');
		e.preventDefault();
	}
};

Devo.Game.cardslot_dragleave = function(e) {
	this.classList.remove('drop-hover');
	this.classList.remove('peek');
};

Devo.Game.cardslot_drop = function(e) {
	e.stopPropagation();
	e.preventDefault();
	if (!$(this).hasClassName('drop-hover') && !$(this).hasClassName('droptarget')) {
		return;
	}
	this.classList.remove('drop-hover');
	this.classList.remove('peek');
	Devo.Game.dropped = (this.id == 'player_stuff') ? 'player_hand' : this.id;
};

Devo.Game._initializeCardDragDrop = function(card) {
	card.addEventListener('dragstart', Devo.Game.card_dragstart, false);
	card.addEventListener('dragover', Devo.Game.card_dragover, false);
	card.addEventListener('dragend', Devo.Game.card_dragend, false);
};

Devo.Game._initializeDragDrop = function() {
	var cards = document.querySelectorAll('.player .card');
	[].forEach.call(cards, function(card) {
		Devo.Game._initializeCardDragDrop(card);
	});
	var hand_cards = document.querySelectorAll('#player_hand .card');
	[].forEach.call(hand_cards, function(card) {
		Devo.Game._initializeCardDragDrop(card);
	});
	var cardslots = document.querySelectorAll('.card-slots .card-slot');
	[].forEach.call(cardslots, function(cardslot) {
		cardslot.addEventListener('dragover', Devo.Game.cardslot_dragover, false);
		cardslot.addEventListener('dragleave', Devo.Game.cardslot_dragleave, false);
		cardslot.addEventListener('drop', Devo.Game.cardslot_drop, false);
	});
	var phand = $('player_stuff');
	phand.addEventListener('dragover', Devo.Game.cardslot_dragover, false);
	phand.addEventListener('dragleave', Devo.Game.cardslot_dragleave, false);
	phand.addEventListener('drop', Devo.Game.cardslot_drop, false);
};

Devo.Game._uninitializeDragDrop = function() {
	var cards = document.querySelectorAll('.player .card');
	[].forEach.call(cards, function(card) {
		card.removeEventListener('dragstart', Devo.Game.card_dragstart);
		card.removeEventListener('dragover', Devo.Game.card_dragover);
		card.removeEventListener('dragend', Devo.Game.card_dragend);
	});
	var cardslots = document.querySelectorAll('.card-slots .card-slot');
	[].forEach.call(cardslots, function(cardslot) {
		cardslot.removeEventListener('dragover', Devo.Game.cardslot_dragover);
		cardslot.removeEventListener('dragleave', Devo.Game.cardslot_dragleave);
		cardslot.removeEventListener('drop', Devo.Game.cardslot_drop);
	});
};

Devo.Game._initializeCards = function() {
	Devo.Game._initializeDragDrop();
};

Devo.Core._blinkTitle = function() {
	document.title = Devo.Core._isOldTitle ? Devo.options.title : Devo.options.alternate_title;
	Devo.Core._isOldTitle = !Devo.Core._isOldTitle;
};

Devo.Core._stopBlinkTitle = function() {
	Devo.Core._infocus = true;
	clearInterval(Devo.Core._titleBlinkInterval);
	document.title = Devo.options.title;
};

Devo.Game.initialize = function(options) {
	Devo.Game._id = options.game_id;
	Devo.Game._latest_event_id = options.latest_event_id;
	Devo.Game._movable = options.movable;
	Devo.Game._initializeResizeWatcher();
	Devo.Game._initializeGameDataPoller();
	Devo.Game._initializeCards();
	Devo.Core._initializeChatRoomPoller();
};

Devo.Game.toggleHand = function() {
	$('player_stuff').toggleClassName('visible');
};

Devo.Game.toggleEvents = function() {
	if ($('game_events').hasClassName('visible')) {
		$('game_events').toggleClassName('fadeIn');
		$('game_events').toggleClassName('fadeOut');
		window.setTimeout( function() {
			$('game_events').toggleClassName('visible');
		}, 1500);
	} else {
		$('game_events').toggleClassName('visible');
		window.setTimeout( function() {
			$('game_events').toggleClassName('fadeIn');
			$('game_events').toggleClassName('fadeOut');
		}, 100);
	}
};

Devo.Game.endTurn = function(button) {
	if (!$(button).hasClassName('disabled')) {
		Devo.Main.Helpers.ajax(Devo.options['say_url'], {
			additional_params: '&topic=end_turn&game_id='+Devo.Game._id,
			loading: {
				callback: function() {
					$(button).down('img').show();
					$(button).addClassName('disabled');
				}
			},
			complete: {
				callback: function() {
					$(button).down('img').hide();
				}
			}
		});
	}
};

Devo.Main.showCardActions = function(card_id) {
	var card = $('card_'+card_id);
	var cards = $$('.card');
	$$('.card_actions').each(function(element) {$(element).hide();});
	if (card.hasClassName('selected')) {
		card.removeClassName('selected');
		cards.each(function(element) {$(element).removeClassName('faded');});
	} else {
		cards.each(function(element) {$(element).addClassName('faded');$(element).removeClassName('selected');});
		card.removeClassName('faded');
		$('card_'+card_id).addClassName('selected');
		var ca = $('card_'+card_id+'_actions');
		ca.show();
	}
};

Devo.Play.pickCardToggle = function(card_id) {
	var card = $('card_'+card_id);
	if (card.hasClassName('selected')) {
		$('picked_card_' + card_id).setValue(0);
	} else {
		$('picked_card_' + card_id).setValue(1);
	}
	card.toggleClassName('selected');
	var num_cards = $$('.card.selected').size();
	console.log(num_cards);
	$$('input[type=submit].play-button').each(function(element) {
		(num_cards >= 5) ? $(element).enable() : $(element).disable();
	});
};

Devo.Play.quickmatch = function() {
	$('quickmatch_overlay').show();
	$('quickmatch_overlay').addClassName('loading');
	window.setTimeout( function() {$('cancel_quickmatch_button').addClassName('animated fadeIn');}, 5000);
	window.setTimeout( function() {$('cancel_quickmatch_button').removeClassName('animated fadeIn');}, 7000);
	Devo.Core._initializeQuickmatchPoller();
}

Devo.Play.invite = function(user_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=invite&user_id='+user_id,
		loading: {
			callback: function() {
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				$('my_ongoing_games_none').removeClassName('animated fadeIn');
				$('my_ongoing_games_none').addClassName('animated fadeOut');
				window.setTimeout(function() {$('my_ongoing_games_none').hide();$('my_ongoing_games').insert(json.game);}, 1100);
				window.setTimeout(function() {$('my_ongoing_games').childElements().last().addClassName('animated tada');}, 1200);
				window.setTimeout(function() {$('my_ongoing_games').childElements().last().removeClassName('animated tada');}, 3000);
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

Devo.Play.acceptInvite = function(invite_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=accept_invite&invite_id='+invite_id,
		loading: {
			callback: function() {
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				if (json.accepted == 'removed') {
					Devo.Play.removeInvite(json.invite_id);
				}
			}
		},
		complete: {
			callback: function() {
				$(button).down('img').hide();
			}
		}
	});
};

Devo.Play.rejectInvite = function(invite_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=reject_invite&invite_id='+invite_id,
		loading: {
			callback: function() {
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				if (json.rejected == 'ok') {
					Devo.Play.removeInvite(json.invite_id);
				}
			}
		},
		complete: {
			callback: function() {
				$(button).down('img').hide();
			}
		}
	});
};

Devo.Play.cancelGame = function(game_id) {
	var button_ok = $('game_'+game_id+'_list').down('.button-ok');
	var button = $(button_ok).visible() ? button : $('game_'+game_id+'_list').down('.button-cancel');

	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=cancel_game&game_id='+game_id,
		loading: {
			callback: function() {
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				if (json.cancelled == 'ok') {
					if ($('my_ongoing_games').childElements().size() == 2) {
						window.setTimeout(function() {$('my_ongoing_games_none').show();$('my_ongoing_games_none').removeClassName('animated fadeOut');$('my_ongoing_games_none').addClassName('animated fadeIn');}, 1500);
					}
					$('game_'+json.game_id+'_list').addClassName('animated bounceOut');
					window.setTimeout(function() {$('game_'+json.game_id+'_list').remove();}, 1400);
				}
			}
		},
		complete: {
			callback: function() {
				$(button).down('img').hide();
			}
		}
	});
};

Devo.Play.removeInvite = function(invite_id) {
	$('game_invite_' + invite_id).addClassName('animated fadeOutLeft');
	$('invites_input_' + invite_id).remove();
	window.setTimeout(function() {$('game_invite_' + invite_id).remove();}, 1000);
}

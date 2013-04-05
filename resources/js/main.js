
function is_string(element) {
    return (typeof element == 'string');
}

function ucfirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function eventFire(el, etype){
	if (el.fireEvent) {
		(el.fireEvent('on' + etype));
	} else {
		var evObj = document.createEvent('Events');
		evObj.initEvent(etype, true, false);
		el.dispatchEvent(evObj);
	}
}

function clearSelection() {
    if (window.getSelection) {
        window.getSelection().removeAllRanges();
    } else if (document.selection) {
        document.selection.empty();
    }
}

var Devo = {
    Core: {
		Pollers: {
			Locks: {},
			Callbacks: {}
		},
		Events: {},
		Listeners: {},
		loaders: 0,
		dragging: false,
		bookdraging: false,
		mapX: 0,
		mapY: 0,
		bookX: 0,
		bookY: 0
	},
    Main: {
        Helpers: {
            Backdrop: {},
            Dialog: {},
            Message: {}
        },
		Login: {},
		Profile: {
			Friends: {
				loaded: false,
				users: []
			}
		}
    },
	Chat: {
		loaded: {},
		Bubbles: []
	},
	Notifications: {
		Messages: []
	},
	Admin: {
		Cards: {},
		Users: {}
	},
	Play: {},
	Market: {
		Effects: {}
	},
	Games: {
		invites_loaded: false
	},
	Game: {
		Effects: {},
		Events: []
	},
	Tutorial: {
		Stories: {}
	},
	effect_queues: {
		successmessage: 'Devo_successmessage',
		failedmessage: 'Devo_failedmessage'
	},
	attack_types: {
		10: 'air',
		11: 'dark',
		12: 'earth',
		13: 'fire',
		14: 'freeze',
		15: 'melee',
		16: 'poison',
		17: 'ranged'
	},
	debug: false
}

Devo.Chat.emoticons = {
	'Angel': ['"(^_^)"', 'O:)', 'O:-)', ],
	'Ambivalent': ['(-_-)', '(◒_◒)', '-_-', ':-|', ':|'],
	'Grin': ['^^', '(^^)', '(^-^)', '^-^'],
	'Crazy': ['(⊙◡⊙)', '%-)', '%-)', '%)'],
	'Nerd': ['B-)', 'B-|', 'B)', 'B|'],
	'Naughty': ['(･ω･)', ':-3', '&gt;:-)', '&gt;:)', '&gt;:-&gt;'],
	'Yum': [':-d', ':d'],
	'ThumbsUp': ['(^_^)d', '(Y)', '(y)'],
	'ThumbsDown': ['(-_-)p', '(N)', '(n)'],
	'Blush': ['(^_^*)', '^_^*', '(n///n)', ':{'],
	'Confused': ['(@_@)', '@_@', ':-S', ':S', '(.O.)'],
	'Gasp': ['0_o', '(0_o)', '=-o', ':-O'],
	'Heart': ['(♥_♥)', '&lt;3'],
	'Hot': ['(^_^)V', '^_^V', '8)', '8-)'],
	'Smile': ['(^_^)', '^_^', ':)', 'c",)', ':-)', ':))', '=)'],
	'Laugh': ['(^o^)', '^o^', '(^O^)', '^O^', '(^0^)', '^0^', ':D', ':-D', 'XD'],
	'Tongue': [':-P', ':P', ':p', ':-p'],
	'Innoncent': ['⚫_⚫', '(⚫_⚫)', '*_*', '(*_*)'],
	'Angry': ['(ò_ó)', '&gt;:o', ':-E'],
	'Crying': ['(T_T)', 'T_T', ':\\\'-(', ':\\\'(', ':\\\'('],
	'Wink': ['(~_^)', '~_^', ';-)', ';)', '*)'],
	'Kiss': ['(^3^)', ':-*', ':*'],
	'LargeGasp': ['(O_O)', '0_0', ':-O', '(°⋄°)', '=O'],
	'Money-mouth': ['($_$)', '$-)', ':$', ':-$'],
	'ohnoes': ['(&gt;_&lt;)', 'D:', '&gt;_&lt;'],
	'Pirate': ['P-)'],
	'Sarcastic': ['(õ_ó)', 'õ_ó', 'o_-', '(o_-)', ';/', '(¬_¬)', '¬_¬', '(>_>)', '>_>', ':-/', ':\\'],
	'Sealed': ['(-.-)', ':-X', ':X', ':x'],
	'Sick': ['(+_+)', '+_+', '(X_X)', '(x_x)', 'X_X', 'x_x', ':[['],
	'Frown': ['(._.)', ':-(', ':('],
	'Sweat': ['(^^\')', '^^"', '^^\'', ':!', ':-!'],
	'Undecided': ['(=_=)', '=_=', ':|'],
	'VeryAngry': [':-@', ':@']
}

Devo.Core._processCommonAjaxPostEvents = function(options) {
	if (options.remove) {
		if (is_string(options.remove)) {
			if ($(options.remove)) $(options.remove).remove();
		}else {
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
		}else {
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

Devo.Main.Helpers.popup = function(element) {
	var visible = $(element) && $(element).hasClassName('button-pressed');
	$$('.button-pressed').each(function(popup) {
		$(popup).removeClassName('button-pressed');
	});
	if (!visible && $(element)) {
		$(element).addClassName('button-pressed');
	}
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
								$(update_element).insert(content);
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
				var stop = false;
				if (json.upgrade && json.upgrade == true) {
					stop = true;
					$('upgrade-overlay').show();
				} else {
					if (json.desync && json.desync == true) {
						stop = true;
						$('desync-overlay').show();
						$('desync-message').insert({bottom: '<br><span class="desync-error">'+json.error+'</span>'});
					} else {
						Devo.Main.Helpers.Message.error(json.error, json.message);
					}
				}
				if (stop) {
					Devo.Core._stop();
				}
			} else {
				if (Devo.debug) {
					$('csp-dbg-content').insert({bottom: response.responseText});
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
				$('csp-dbg-content').insert({bottom: response.responseJSON['csp-debugger']});
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

Devo.Core._stop = function() {
	Devo.Core.destroyGameListPoller();
	Devo.Core.destroyInvitePoller();
	Devo.Core.destroyFriendsPoller();
	Devo.Core.destroyChatRoomPoller();
	Devo.Core.destroyQuickmatchPoller();
	Devo.Game.destroyGame();
}

Devo.Main.Helpers.loading = function() {
	Devo.Core.loaders++;
	if (!$('fullpage_backdrop').visible()) {
		$('loading-details').update('');
		$('loading').show();
		if ($('gamemenu-container') && $('ui') && $('ui').visible()) $('gamemenu-container').hide();
		$('fullpage_backdrop').appear({duration: 0.2});
//		$$('body')[0].setStyle({'overflow': 'hidden'});
	}
}

Devo.Main.Helpers.finishLoading = function() {
	if (Devo.Core.loaders > 0) {
		Devo.Core.loaders--;
		if (Devo.Core.loaders == 0) {
			window.setTimeout(function() {
//				$$('body')[0].setStyle({'overflow': 'auto'});
				$('fullpage_backdrop').fade({duration: 0.2});
				Devo.Main._resizeWatcher();
			}, 1000);
		}
	}
}

Devo.Main.Helpers.Backdrop.show = function(url) {
	if (url != undefined) {
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(url, {
			url_method: 'get',
			loading: {indicator: 'loading'},
			success: {
				update: 'fullpage_backdrop_content'
			}
		});
	}
};

Devo.Main.Helpers.Backdrop.reset = function() {
	$$('body')[0].setStyle({'overflow': 'auto'});
	$('fullpage_backdrop').fade({duration: 0.2});
	Devo.Main._resizeWatcher();
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

Devo.Main.Profile.reloadFriendsList = function() {
	Devo.Core.destroyFriendsPoller();
};

Devo.Main.Profile.show = function(user_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=profile_info&user_id='+user_id,
		loading: {
			callback: function() {
				if ($(button)) $(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				$('loading').hide();
				$('fullpage_backdrop_content').update(json.profile_info);
				$('fullpage_backdrop').show();
			}
		},
		complete: {
			callback: function() {
				if ($(button)) $(button).down('img').hide();
			}
		}
	});
};

Devo.Main.Profile.save = function(form) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=saveprofile',
		form: form,
		loading: {
			indicator: 'save_profile_indicator'
		},
		success: {
			callback: function(json) {
				Devo.Main.Helpers.Backdrop.reset();
				var c_name = $('profile_edit_charactername').getValue();
				if ($('profile-user-charactername')) {
					$('profile-user-charactername').update(c_name);
				}
				Devo.options['charactername'] = c_name;
			}
		}
	});
	
}

Devo.Main.Profile.addFriend = function(user_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=add_friend&user_id=' + user_id,
		loading: {
			callback: function() {
				var parent = $(button).up();
				if (parent.hasClassName('userfriend-list-item')) {
					parent.select('button').each(function(b) {
						$(b).disable();
					});
				} else {
					$(button).disable();
				}
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				$(button).down('img').hide();
				var parent = $(button).up();
				if (parent.hasClassName('userfriend-list-item')) {
					parent.down('div').remove();
					parent.select('button').each(function(b) {
						$(b).remove();
					});
					$('offline-friends').insert(parent.remove());
				}
				$$('.userinfo-'+user_id).each(function(popup) {
					popup.addclassname('user-friends');
				});
			}
		}
	});
}

Devo.Main.Profile.removeFriend = function(userfriend_id, button, usermode) {
	var p = (usermode != undefined) ? 'user_id' : 'userfriend_id';
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=remove_userfriend&' + p + '=' + userfriend_id,
		loading: {
			callback: function() {
				var parent = $(button).up();
				if (parent.hasClassName('userfriend-list-item')) {
					parent.select('button').each(function(b) {
						$(b).disable();
					});
				} else {
					$(button).disable();
				}
				$(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				$(button).down('img').hide();
				$$('.userfriend-list-item').each(function(uli) {
					if (uli.dataset.userId == json.user_id) uli.remove();
				});
				$$('.userinfo-'+json.user_id).each(function(popup) {
					popup.removeClassName('user-friends');
				});
			}
		}
	});
}

Devo.Main.Profile.inviteUser = function() {
	if (!$('invite_email_button').hasClassName('disabled')) {
		Devo.Main.Helpers.ajax(Devo.options['say_url'], {
			additional_params: '&topic=invite_user&invite_email=' + $('invite_email_input').getValue(),
			loading: {
				callback: function() {
					$('invite_email_button').addClassName('disabled');
				}
			},
			complete: {
				callback: function() {
					$('invite_email_button').removeClassName('disabled');
					$('invite_email').hide();
				}
			}
		});
	}
}

Devo.Main.Profile.inviteUserGame = function() {
	if (!$('invite_game_email_button').hasClassName('disabled')) {
		Devo.Main.Helpers.ajax(Devo.options['say_url'], {
			additional_params: '&topic=invite_user&invite_email=' + $('invite_game_email_input').getValue() + '&invite_game=1',
			loading: {
				callback: function() {
					$('invite_game_email_button').addClassName('disabled');
				}
			},
			complete: {
				callback: function() {
					$('invite_game_email_button').removeClassName('disabled');
					Devo.Main.Helpers.Backdrop.reset();
				}
			}
		});
	}
}

Devo.Main.Profile.pickAvatar = function(avatar) {
	var selected_avatar = $('avatar_preview_'+avatar);
	if (selected_avatar.hasClassName('selected')) return;

	$('character-avatar-container').select('.avatar_preview.selected').each(function(avatar_preview) {
		avatar_preview.removeClassName('selected');
	});
	$('character-avatar-container').select('.avatar_preview').each(function(avatar_preview) {
		avatar_preview.addClassName('unselected');
	});
	selected_avatar.removeClassName('unselected');
	selected_avatar.addClassName('selected');
	$('avatar_input').setValue(avatar);
	$('avatar-player').setStyle({backgroundImage: "url('/images/avatars/avatar_"+avatar+".png')"});
	$('character_avatar_button').enable();
}

Devo.Main.Profile.pickRace = function(race) {
	var card = $('race_'+race+'_div');
	var is_selected = card.hasClassName('selected');
	$('character_continue_button').disable();
	$$('.card').each(function(element) {
		if (element.id != card.id) {
			(is_selected) ? element.removeClassName('unselected') : element.addClassName('unselected');
		}
	});
	if (!is_selected) {
		card.addClassName('selected');
		$('race_input').setValue(race);
		$('character_continue_button').enable();
		$('character_continue_button').show();
	} else {
		card.removeClassName('selected');
	}
};

Devo.Main.Profile.completeCharacterSetup = function(form) {
	if (!$('character_continue_button') || !$('character_continue_button').disabled) {
		$('profile-character-setup').hide();
		Devo.Main.Helpers.loading();
		var f = (form != undefined) ? form : $('character-setup-form');
		var url = f.action;
		Devo.Main.Helpers.ajax(url, {
			form: f.id,
			success: {
				callback: function(json) {
					if (json.character_setup == 'step_2_ok') {
						Devo.Main.initializeLobby();
						Devo.Main.loadProfileCards();
						$('play-menu-setup').hide();
					} else {
						Devo.Main.loadProfile();
						$('play-menu-setup').hide();
					}
				}
			},
			complete: {
				callback: function() {
					Devo.Main.Helpers.finishLoading();
				}
			}
		});
	}
}

Devo.Main.Profile.getXp = function() {
	return parseInt(Devo._user_xp);
}

Devo.Main.Profile.setXp = function(amount) {
	Devo._user_xp = parseInt(amount);
	$('user-xp-amount').update(parseInt(amount));
	$('user-xp').dataset.xp = parseInt(amount);
}

Devo.Main.Profile.getLevel = function() {
	return parseInt(Devo._user_level);
}

Devo.Main.Profile.setLevel = function(level) {
	Devo._user_level = parseInt(level);
	$('user-level-amount').update(parseInt(level));
	$('user-level').dataset.level = parseInt(level);
}

Devo.Main.Profile.toggleSkillTraining = function(skill_id) {
	if ($('levelup_button').visible() && !$('skill_'+skill_id).hasClassName('trained')) {
		var skill = $('skill_'+skill_id);
		var allowed = true;

		if (Devo.Main.Profile.getLevel() < parseInt(skill.dataset.requiredLevel)) {
			skill.down('.requires-level').addClassName('animated bounceIn');
			window.setTimeout(function() {
				skill.down('.requires-level').removeClassName('animated bounceIn');
			}, 1500);
			allowed = false;
		}
		if (Devo.Main.Profile.getXp() < parseInt(skill.dataset.xpCost)) {
			skill.down('.xp-cost').addClassName('animated bounceIn');
			window.setTimeout(function() {
				skill.down('.xp-cost').removeClassName('animated bounceIn');
			}, 1500);
			allowed = false;
		}

		if (!allowed) return;

		var prev = skill.previous();
		if (!prev || prev.hasClassName('trained')) {
			$$('.skill.training').each(function(element) {
				if (element.id != 'skill_'+skill_id) element.removeClassName('training');
			});
			$('skill_'+skill_id).toggleClassName('training');
			$('selected_skill').setValue(skill_id);
		}
	}
	if ($$('.skill.training').size() > 0) {
		$('levelup_button').removeClassName('disabled');
	} else {
		$('levelup_button').addClassName('disabled');
		$('selected_skill').setValue('');
	}
};

Devo.Main.Profile.trainSelectedSkill = function() {
	if (!$('levelup_button').hasClassName('disabled')) {
		Devo.Main.Helpers.ajax(Devo.options['say_url'], {
			additional_params: '&topic=train_skill&selected_skill=' + $('selected_skill').getValue(),
			loading: {
				callback: function() {
					$('levelup_button').addClassName('disabled');
					$('training_indicator').show();
				}
			},
			success: {
				callback: function(json) {
					if (json['levelup']) $('levelup_button').removeClassName('disabled');
					$$('.skill.training').each(function(element) {
						element.removeClassName('training');
					});
					if (json['skill_trained']) {
						var skill = $('skill_'+json['skill_trained']);
						skill.addClassName('trained');
					}
					Devo.Main.Profile.setLevel(json.level);
					Devo.Main.Profile.setXp(json.xp);
				}
			},
			complete: {
				callback: function() {
					$('training_indicator').hide();
				}
			}
		});
	}
};

Devo.Main.saveSettings = function() {
	var settings = Form.serialize('options_form');
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: settings,
		loading: {indicator: 'options_waiting'},
		success: {
			hide: 'settings-overlay',
			callback: function() {
				if ($('options_background_music_enabled').checked && !Devo.Game._music) {
					Devo.Game._initializeMusic();
				} else if ($('options_background_music_disabled').checked) {
					Devo.Game._uninitializeMusic();
				}
				var bc = $('board-container');
				if ($('options_low_graphics_enabled').checked && bc) {
					bc.removeClassName('effect-3d');
				} else if ($('options_low_graphics_disabled').checked && bc) {
					bc.addClassName('effect-3d');
				}
				Devo.options.candrag = $('options_drag_drop_enabled').checked;
				if ($('options_drag_drop_enabled').checked && Devo.Game._movable) {
					Devo.Game._uninitializeClickableCardMover();
					Devo.Game._initializeDragDrop();
				} else if ($('options_drag_drop_disabled').checked && Devo.Game._movable) {
					Devo.Game._uninitializeDragDrop();
					Devo.Game._initializeClickableCardMover();
				}
				$$('.chat_room_container').each(function(container) {
					var chat_lines = $('chat_room_'+container.dataset.roomId+'_lines');
					if ($('options_system_chat_messages_disabled').checked && !container.hasClassName('no_system_chat')) {
						container.addClassName('no_system_chat');
						chat_lines.scrollTop = chat_lines.scrollHeight;
					} else if ($('options_system_chat_messages_enabled').checked) {
						container.removeClassName('no_system_chat');
						chat_lines.scrollTop = chat_lines.scrollHeight;
					}
				});
			}
		}
	});
}

Devo.Core.Pollers.Callbacks.invitePoller = function() {
	if (!Devo.Core.Pollers.Locks.invitepoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_invites',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.invitepoller = true;
				}
			},
			success: {
				callback: function(json) {
					var game_invites = [];
					if (Devo.Games.invites == undefined) Devo.Games.invites = [];
					if (json.invites) {
						var invites = [];
						var no_invites_visible = ($('no_invites')) ? $('no_invites').visible() : false;
						for (var d in json.invites) {
							if (json.invites.hasOwnProperty(d)) {
								var invite = json.invites[d];
								var invite_id = parseInt(invite.invite_id);
								if (Devo.Games.invites_loaded == false || Devo.Games.invites.indexOf(invite_id) == '-1') {
									if ($('game_invites')) {
										if ($('game_invite_'+invite_id) == null) {
											var invite_element = $('__game_invite_template').clone(true);
											invite_element.id = 'game_invite_' + invite_id;
											$('game_invites').insert(invite_element);
											var accept_button = $(invite_element).down('.button-accept');
											accept_button.observe('click', function(event) {
												var button = Event.element(event);
												Devo.Play.acceptInvite(invite_id, $(button));
											});
											var reject_button = $(invite_element).down('.button-reject');
											reject_button.observe('click', function(event) {
												var button = Event.element(event);
												Devo.Play.rejectInvite(invite_id, $(button));
											});
											$(invite_element).down('.player_name').update(invite.player_name);
											if (no_invites_visible) {
												$('no_invites').removeClassName('animated fadeIn');
												$('no_invites').addClassName('animated fadeOut');
												window.setTimeout(function() {
													$('no_invites').hide();
												}, 1100);
											}
											invites.push(invite_element.id);
										}
									} else if (Devo.Games.invites_loaded) {
										if (Devo.Games.invites.indexOf(invite_id) == '-1') {
											Devo.Notifications.add('Choose an action now, or visit the lobby later', {
												title: invite.player_name + ' invited you to a game',
												buttons: [
													{
														click: "Devo.Play.acceptInvite("+invite_id+", $(this));$(this).up('.notification').hide();",
														title: '<img src="/images/spinning_16.gif" style="display: none;">Accept'
													},
													{
														click: "Devo.Play.rejectInvite("+invite_id+", $(this));$(this).up('.notification').hide();",
														title: '<img src="/images/spinning_16.gif" style="display: none;">Reject'
													}
												],
												timeout: 10
											});
										}
									}
								}
								game_invites.push(parseInt(invite.invite_id));
							}
						}
						if (invites.size() > 0) {
							invites.each(function(invite) {
								window.setTimeout(function() {
									$(invite).show();
									$(invite).addClassName('animated bounceIn');
									window.setTimeout(function() {
										$(invite).removeClassName('animated bounceIn');
									}, 1500);
								}, 1200);
							});
						}
					} else {
						window.setTimeout(function() {
							$('no_invites').show();
							$('no_invites').removeClassName('animated fadeOut');
							$('no_invites').addClassName('animated fadeIn');
						}, 1000);
					}
					Devo.Games.invites.each(function(invite_id) {
						if (game_invites.indexOf(invite_id) == '-1') {
							Devo.Play.removeInvite(invite_id);
						}
					});
					Devo.Games.invites = game_invites;
					Devo.Games.invites_loaded = true;
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

Devo.Core.Pollers.Callbacks.friendsPoller = function() {
	if (!Devo.Core.Pollers.Locks.friendspoller) {
		var params = '&for=online_friends';
		if ($('online-friends')) params += '&detailed=true';
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: params,
			url_method: 'get',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.friendspoller = true;
				}
			},
			success: {
				callback: function(json) {
					var friends = [];
					if (json.online_friends) {
						for (var d in json.online_friends) {
							if (json.online_friends.hasOwnProperty(d)) {
								var u = json.online_friends[d];
								friends[parseInt(u.user_id)] = json.online_friends[d];
							}
						}
					}
					if (Devo.Main.Profile.Friends.loaded == false) {
						Devo.Main.Profile.Friends.loaded = true;
					} else {
						Devo.Main.Profile.Friends.online_users.each(function(user) {
							if (user != undefined) {
								if (friends[user.user_id] == undefined) Devo.Notifications.add(user.charactername + ' went offline');
							}
						});
						friends.each(function(user) {
							if (user != undefined) {
								if (Devo.Main.Profile.Friends.online_users[user.user_id] == undefined) Devo.Notifications.add(user.charactername + ' just came online');
							}
						});
					}
					Devo.Main.Profile.Friends.online_users = friends;
					if ($('friends-list-container')) {
						$('offline-friends').childElements().each(function(userfriend) {
							if (friends[userfriend.dataset.userId] != undefined) {
								userfriend.down('img').src = '/images/user-online.png';
								$('online-friends').insert(userfriend.remove());
							}
						});
						$('online-friends').childElements().each(function(userfriend) {
							if (friends[userfriend.dataset.userId] == undefined) {
								userfriend.down('img').src = '/images/user-offline.png';
								$('offline-friends').insert(userfriend.remove());
							}
						});
						$('friends-loading-indicator').hide();
					}
					if ($('friend-requests')) {
						$('friend-requests').update(json.friend_requests);
					}
				}
			},
			complete: {
				callback: function() {
					Devo.Core.Pollers.Locks.friendspoller = false;
				}
			}
		});
	}
};

Devo.Core.Pollers.Callbacks.chatLinesPoller = function() {
	if (!Devo.Core.Pollers.Locks.chatlinespoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=chat_lines',
			form: 'chat_rooms_joined',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.chatlinespoller = true;
				}
			},
			success: {
				callback: function(json) {
					if (json.chat_lines) {
						var needs_users_refresh = false;
						for (var d in json.chat_lines) {
							if (json.chat_lines.hasOwnProperty(d)) {
								var room = json.chat_lines[d];
								var room_id = d;
								var visible = $('chat_'+room_id+'_container').visible();
								var blinking = $('chat_room_'+room_id+'_loading').visible();
								for (var l in room['lines']) {
									if (room['lines'].hasOwnProperty(l)) {
										var line = room['lines'][l];
										var line_id = line['line_id'];
										if (!$('chat_line_'+line_id)) {
											if (!$('chat_room_'+room_id+'_user_'+user_id)) {
												needs_users_refresh = true;
											}
											var user_id = parseInt(line['user_id']);
											if (line_id > $('chat_room_'+room_id+'_since').getValue()) {
												$('chat_room_'+room_id+'_since').setValue(line_id);
											}
											var mentioned = (user_id > 0 && user_id != Devo.Game.getUserId() && (line['text'].indexOf(Devo.options['username']) != '-1' || line['text'].indexOf(Devo.options['charactername']) != '-1')) ? true : false;
											var chat_line = '<div id="chat_line_'+line_id+'" class="chat_line';
											if (user_id == 0) chat_line += ' system';
											if (mentioned == true) chat_line += ' mentioned';
											chat_line += '"><div class="chat_nickname" onclick="$(\'chat_line_'+line_id+'\').toggleClassName(\'selected\');">';
											if (user_id != Devo.options['user_id'] && user_id != 0) {
												chat_line += Devo.Chat.getUserPopupHtml(user_id, line['user']);
											}
											chat_line += (line['user']['charactername']) ? line['user']['charactername'] : line['user']['username'];
											chat_line += '&nbsp;<span class="chat_timestamp">('+line['posted_formatted_hours']+'<span class="date"> - '+line['posted_formatted_date']+'</span>)</div><div class="chat_line_content">'+Devo.Chat.emotify(line['text'])+'</div></div>';
											$('chat_room_'+room_id+'_lines').insert(chat_line);
											$('chat_room_'+room_id+'_lines').scrollTop = $('chat_line_'+line_id).offsetTop;
											if (Devo.Chat.loaded['loaded-'+room_id] != undefined && Devo.Chat.loaded['loaded-'+room_id] == true && user_id > 0 && user_id != Devo.Game.getUserId()) {
												if (Devo.Core._infocus && !visible && mentioned) {
													Devo.Notifications.add('Someone just mentioned you in the chat!');
												}
												if (user_id != Devo.options['user_id'] && !$('chat_'+room_id+'_toggler').hasClassName('selected')) {
													$('chat_'+room_id+'_toggler').down('.notify').addClassName('visible');
													if (room_id > 1) {
														Devo.Chat.Bubbles.push({id: line_id, text: line['text']});
														Devo.Chat._initializeBubblePoller();
													}
												}
												if (!blinking && !Devo.Core._infocus && user_id > 0) {
													clearInterval(Devo.Core._titleBlinkInterval);
													Devo.options.alternate_title = ((line['user']['charactername']) ? line['user']['charactername'] : line['user']['username']) + ' says ...';
													Devo.Core._titleBlinkInterval = setInterval(Devo.Core._blinkTitle, 2000);
													blinking = true;
												}
											}
										}
									}
								}
								Devo.Chat.loaded['loaded-'+room_id] = true;
							}
						}
						if (needs_users_refresh) {
							Devo.Core.Pollers.Callbacks.chatUsersPoller();
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
								$('chat_room_'+room_id+'_num_ingame_users').update(json.chat_lines[d]['users']['ingame_count']);
							}
						}
					}
					Devo.Core.Pollers.Locks.chatlinespoller = false;
				}
			}
		});
	}
};

Devo.Chat.getUserPopupHtml = function(user_id, user) {
	var user_line = '<div class="userinfo userinfo-'+user_id;
	if (user['friends'] == true) user_line += ' user-friends';
	user_line += '">';

	if (user['charactername']) {
		user_line += user['charactername'];
	} else {
		user_line += 'Username: '+user['username'];
	}

	user_line += '<div class="rating">#'+user['mp_ranking']+'<br>MP ranking</div>';
	user_line += '<div class="rating">#'+user['sp_ranking']+'<br>SP ranking</div>';

	user_line += '<br>Level '+user['level'];

	if (user['race'] != '') {
		user_line += ' '+user['race'];
	}

	user_line += '<br><div class="buttons button-group">';
	user_line += '<button class="ui_button" onclick="Devo.Main.Profile.show('+user_id+', this);"><img src="/images/spinning_16.gif" style="display: none;">Show profile</button>';
	user_line += '<button class="ui_button" onclick="Devo.Play.invite('+user_id+', this);"><img src="/images/spinning_16.gif" style="display: none;">Challenge</button>';
	user_line += '<button class="ui_button addfriend" ';
	user_line += 'onclick="Devo.Main.Profile.addFriend('+user_id+', this);"><img src="/images/spinning_16.gif" style="display: none;">Add friend</button>';
	user_line += '<button class="ui_button removefriend" ';
	user_line += 'onclick="Devo.Main.Profile.removeFriend('+user_id+', this, true);"><img src="/images/spinning_16.gif" style="display: none;">Unfriend</button>';
	user_line += '</div></div>';

	return user_line;
};

Devo.Core.Pollers.Callbacks.chatUsersPoller = function() {
	if (!Devo.Core.Pollers.Locks.chatuserspoller) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=chat_users',
			form: 'chat_rooms_joined',
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.chatuserspoller = true;
				}
			},
			success: {
				callback: function(json) {
					if (json.chat_users) {
						for (var d in json.chat_users) {
							if (json.chat_users.hasOwnProperty(d)) {
								var room = json.chat_users[d];
								var room_id = d;
								if ($('chat_room_'+room_id+'_users_loading') && $('chat_room_'+room_id+'_users_loading').visible()) $('chat_room_'+room_id+'_users_loading').hide();
								$('chat_room_'+room_id+'_users').childElements().each(function(userdiv) {
									if (!room['users'][userdiv.dataset.userId]) {
										$(userdiv).remove();
									}
								});
								for (var u in room['users']) {
									if (room['users'].hasOwnProperty(u)) {
										var user = room['users'][u];
										var user_id = user['user_id'];
										if (!$('chat_room_'+room_id+'_user_'+user_id)) {
											var user_line = '<div id="chat_room_'+room_id+'_user_'+user_id+'" class="chat_nickname';
											if (user['is_admin']) user_line += ' is_admin';
											if (user_id == Devo.options['user_id']) user_line += ' own';
											user_line += '"';
											if (user_id != Devo.options['user_id']) user_line += ' onclick="$(\'chat_room_'+room_id+'_user_'+user_id+'\').toggleClassName(\'selected\');"';
											user_line += '>';
											user_line += '<div class="chat_avatar" style="background-image: url(\'/images/avatars/'+user['avatar']+'\');"></div>';
											if (user_id != Devo.options['user_id'] && user_id != 0) {
												user_line += Devo.Chat.getUserPopupHtml(user_id, user);
											}
											user_line += (user['charactername']) ? user['charactername'] : user['username']+'</div></div>';
											if (user['is_admin']) {
												$('chat_room_'+room_id+'_users').insert({top: user_line});
											} else {
												$('chat_room_'+room_id+'_users').insert(user_line);
											}
											$('chat_room_'+room_id+'_user_'+user_id).dataset.userId = user_id;
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
					if (json.chat_users) {
						for (var d in json.chat_users) {
							if (json.chat_users.hasOwnProperty(d)) {
								var room_id = d;
								$('chat_room_'+room_id+'_num_users').update(json.chat_users[d]['count']);
								if (room_id == 1 && $('players_online_count')) $('players_online_count').update(json.chat_users[d]['count']);
								$('chat_room_'+room_id+'_num_ingame_users').update(json.chat_users[d]['ingame_count']);
							}
						}
					}
					Devo.Core.Pollers.Locks.chatuserspoller = false;
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
			success: {
				callback: function(json) {
					if (json.options && json.options.game_id) {
						$('quickmatch_overlay').hide();
						$('quickmatch_overlay').removeClassName('loading');
						Devo.Core.destroyQuickmatchPoller();
						Devo.Game.initializeCardPicker(json.options);
					}
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
									(game.turn.opponent && game.invitation_confirmed && game.turn.number > 2) ? $('game_'+game_id+'_opponent_turn').show() : $('game_'+game_id+'_opponent_turn').hide();
									(game.turn.player && game.invitation_confirmed && game.turn.number > 2) ? $('game_'+game_id+'_player_turn').show() : $('game_'+game_id+'_player_turn').hide();
									if (game.turn.number <= 2 && game.invitation_confirmed) {
										$('game_'+game_id+'_info').hide();
										$('game_'+game_id+'_pickandplace').show();
									} else if (game.invitation_confirmed) {
										$('game_'+game_id+'_pickandplace').hide();
										$('game_'+game_id+'_info').show();
										[2,3,4].each(function(phase) {
											(phase == game.turn.phase) ? $('game_'+game_id+'_phase_'+phase).show() : $('game_'+game_id+'_phase_'+phase).hide();
										})
									}
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
	Devo.Core.Pollers.invitepoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.invitePoller, 10);
	Devo.Core.Pollers.Callbacks.invitePoller();
}

Devo.Core.destroyInvitePoller = function() {
	if (Devo.Core.Pollers.invitepoller) Devo.Core.Pollers.invitepoller.stop();
	Devo.Core.Pollers.invitepoller = undefined;
	Devo.Core.Pollers.Locks.invitepoller = undefined;
}

Devo.Core._initializeFriendsPoller = function() {
	Devo.Core.Pollers.friendspoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.friendsPoller, 10);
	Devo.Core.Pollers.Callbacks.friendsPoller();
}

Devo.Core.destroyFriendsPoller = function() {
	if (Devo.Core.Pollers.friendspoller) Devo.Core.Pollers.friendspoller.stop();
	Devo.Core.Pollers.friendspoller = undefined;
	Devo.Core.Pollers.Locks.friendspoller = undefined;
}

Devo.Core._initializeChatRoomPoller = function() {
	if ($('chat_rooms_joined')) {
		if (Devo.Core.Pollers.chatlinespoller == undefined) Devo.Core.Pollers.chatlinespoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.chatLinesPoller, 4);
		if (Devo.Core.Pollers.chatuserspoller == undefined) Devo.Core.Pollers.chatuserspoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.chatUsersPoller, 15);
	}
}

Devo.Core.destroyChatRoomPoller = function() {
	if (Devo.Core.Pollers.chatlinespoller) Devo.Core.Pollers.chatlinespoller.stop();
	Devo.Core.Pollers.chatlinespoller = undefined;
	Devo.Core.Pollers.Locks.chatlinespoller = undefined;
	if (Devo.Core.Pollers.chatuserspoller) Devo.Core.Pollers.chatuserspoller.stop();
	Devo.Core.Pollers.chatuserspoller = undefined;
	Devo.Core.Pollers.Locks.chatuserspoller = undefined;
}

Devo.Core._initializeGameListPoller = function() {
	if (Devo.Core.Pollers.gamelistpoller == undefined) Devo.Core.Pollers.gamelistpoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.gameListPoller, 10);
	Devo.Core.Pollers.Callbacks.gameListPoller();
}

Devo.Core.destroyGameListPoller = function() {
	if (Devo.Core.Pollers.gamelistpoller) Devo.Core.Pollers.gamelistpoller.stop();
	Devo.Core.Pollers.gamelistpoller = undefined;
	Devo.Core.Pollers.Locks.gamelistpoller = undefined;
}

Devo.Core._initializeQuickmatchPoller = function() {
	if (Devo.Core.Pollers.quickmatchpoller == undefined) Devo.Core.Pollers.quickmatchpoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.quickMatchPoller, 3);
}

Devo.Core.destroyQuickmatchPoller = function() {
	if (Devo.Core.Pollers.quickmatchpoller) Devo.Core.Pollers.quickmatchpoller.stop();
	Devo.Core.Pollers.quickmatchpoller = undefined;
	Devo.Core.Pollers.Locks.quickmatchpoller = undefined;
}

Devo.Core.initialize = function(options) {
	Devo.options = options;
	Devo.Core._initializeInvitePoller();
	Devo.Core._initializeNotificationsPoller();
	Devo.Core._initializeGameListPoller();
	Devo.Core._initializeFriendsPoller();
	Devo.Core._infocus = true;
	Devo.Core._isOldTitle = true;
	Devo.Core._titleBlinkInterval = undefined;
	Event.observe(window, 'focus', Devo.Core._stopBlinkTitle);
	Event.observe(window, 'blur', function() {Devo.Core._infocus = false;});
	Event.observe(window, 'hashchange', Devo.Core._checkNav);
	Devo.Core.Events.trigger('devo:core:initialized');
	Devo.Core._checkNav();
}

Devo.Core._checkNav = function() {
	if (window.location.hash) {
		if ($('game-content-container').dataset.location != window.location.hash) {
			var hasharray = window.location.hash.substr(1).split('/');
			switch(hasharray[0]) {
				case '!adventure':
					if (hasharray[1] && parseInt(hasharray[2]) > 0) {
						switch (hasharray[1]) {
							case 'story':
								Devo.Main.loadAdventureUI('story', parseInt(hasharray[2]));
								break;
							case 'chapter':
								Devo.Main.loadAdventureUI('chapter', parseInt(hasharray[2]));
								break;
							case 'quest':
								Devo.Main.loadAdventureUI('quest', parseInt(hasharray[2]));
								break;
							case 'adventure':
								Devo.Main.loadAdventureUI('adventure', parseInt(hasharray[2]));
								break;
						}
					} else {
						Devo.Main.loadAdventureUI();
					}
					break;
				case '!lobby':
					Devo.Main.loadLobby();
					break;
				case '!game':
					if (hasharray[1]) {
						Devo.Main.initializeLobby();
						Devo.Game.initializeGame(parseInt(hasharray[1]));
					}
					break;
				case '!invite':
					if (hasharray[1]) {
						Devo.Play.acceptInvite(hasharray[1]);
					}
					break;
				case '!market':
					if (hasharray[1]) {
						switch (hasharray[1]) {
							case 'buy':
								Devo.Main.loadMarketBuy();
								break;
							case 'sell':
								Devo.Main.loadMarketSell();
								break;
						}
					} else {
						Devo.Main.loadMarketFrontpage();
					}
					break;
				case '!profile':
					if (hasharray[1]) {
						switch (hasharray[1]) {
							case 'cards':
								Devo.Main.initializeLobby();
								Devo.Main.loadProfileCards();
								break;
							case 'skills':
								Devo.Main.initializeLobby();
								Devo.Main.loadProfileSkills();
								break;
						}
					} else {
						Devo.Main.loadProfile();
					}
					break;
			}
			$('game-content-container').dataset.location = window.location.hash;
		}
	}
};

Devo.Main._resizeChat = function() {
	$$('.chat_room_container').each(function(room_container) {
		if (!room_container.visible()) return;
		var room_id = room_container.dataset.roomId;

		var chat_users = $('chat_room_'+room_id+'_users');
		var chat_lines = $('chat_room_'+room_id+'_lines');
		var chat_room = $('chat_room_'+room_id+'_container');
		var chat_form = $('chat_room_'+room_id+'_form_container');
		var chat_button = $('chat_room_'+room_id+'_say_button');
		var chat_input = $('chat_room_'+room_id+'_input');
		var vp_height = document.viewport.getHeight();
		var lobby_chat_width = (Devo.Core._vp_width > 800) ? Devo.Core._vp_width - 320 : Devo.Core._vp_width - 28;
		var lobby_chat_height = vp_height - 120;
		room_container.setStyle({width: lobby_chat_width + 'px', height: lobby_chat_height + 'px'});
		var chat_form_layout = chat_form.getLayout();
		var chat_users_layout = chat_users.getLayout();
		var chat_button_layout = chat_button.getLayout();
		var chat_users_width = (!chat_users.visible()) ? 0 : chat_users_layout.get('width') + chat_users_layout.get('padding-left') + chat_users_layout.get('padding-right');

		var chat_lines_width = lobby_chat_width - chat_users_width - 10;
		var chat_lines_height = lobby_chat_height - 20 - chat_form_layout.get('height');
		var chat_input_width = chat_lines_width - chat_button_layout.get('width') - chat_button_layout.get('padding-left') - chat_button_layout.get('padding-right') - 30;
		chat_lines.setStyle({width: chat_lines_width + 'px', height: chat_lines_height + 'px'});
		chat_form.setStyle({width: chat_lines_width + 'px'});
		if (Devo.Core._vp_width > 600) {
			if (!chat_users.visible()) chat_users.show();
			chat_users.setStyle({height: (chat_lines_height + 5) + 'px'});
		} else {
			chat_users.hide();
		}
		chat_input.setStyle({width: chat_input_width + 'px'});
		chat_room.setStyle({height: (chat_lines_height + chat_form_layout.get('height') - 15) + 'px'});

	});
}

Devo.Main._resizeProfile = function() {
	var profile_container = $('profile-container');
	if (profile_container == undefined) return;

	var left_container = $('left-menu-container');
	if (left_container == undefined) return;

	var left_layout = left_container.getLayout();
	var left_width = left_layout.get('width') + left_layout.get('padding-left') + left_layout.get('padding-right') + left_layout.get('margin-left') + left_layout.get('margin-right');
	profile_container.setStyle({width: (Devo.Core._vp_width - left_width - 20) + 'px'});
}

Devo.Main._resizeShelf = function() {
	var shelf_container = $('profile-cards-container');
	if (shelf_container == undefined) return;

	var left_container = $('left-menu-container');
	if (left_container == undefined) return;

	var top_container = $('top-shelf-menu-container');
	if (top_container == undefined) return;

	var left_layout = left_container.getLayout();
	var left_width = left_layout.get('width') + left_layout.get('padding-left') + left_layout.get('padding-right') + left_layout.get('margin-left') + left_layout.get('margin-right');
	if (Devo.Core._vp_width > 800) {
		shelf_container.setStyle({width: '985px'});
		if (Devo.Core._vp_width > 985 + left_width) {
			left_container.show();
			top_container.hide();
		} else {
			top_container.show();
			left_container.hide();
		}
	} else {
		shelf_container.setStyle({width: Devo.Core._vp_width + 'px'});
	}
}

Devo.Main._resizeSkills = function() {
	var skills_container = $('profile-skills-container');
	if (skills_container == undefined) return;

	var left_container = $('left-menu-container');
	if (left_container == undefined) return;

	var left_layout = left_container.getLayout();
	var left_width = left_layout.get('width') + left_layout.get('padding-left') + left_layout.get('padding-right') + left_layout.get('margin-left') + left_layout.get('margin-right');
	skills_container.setStyle({width: (Devo.Core._vp_width - left_width - 90) + 'px'});
}

Devo.Main._resizeStoryList = function() {
	var story_container = $('available-quests-list');
	if (story_container == undefined) return;

	story_container.setStyle({height: (Devo.Core._vp_height - 200) + 'px'});
}

Devo.Main._resizeMapContainer = function() {
	var map_container = $('adventure-map');
	if (map_container == undefined) return;

	var left_container = $('left-menu-container');
	var left_width = 50;
	if (left_container != undefined) {
		var left_layout = left_container.getLayout();
		left_width = left_layout.get('width') + left_layout.get('padding-left') + left_layout.get('padding-right') + left_layout.get('margin-left') + left_layout.get('margin-right');
	}

	map_container.setStyle({width: (Devo.Core._vp_width - left_width) + 'px', height: (Devo.Core._vp_height) + 'px'});

	var cl = $('adventure-map').getLayout();
	var cw = cl.get('width') + cl.get('padding-left') + cl.get('padding-right');
	var ch = cl.get('height') + cl.get('padding-top') + cl.get('padding-bottom');
	Devo.Core._mapWidth = cw;
	Devo.Core._mapHeight = ch;
}

Devo.Main._resizeCardPicker = function() {
	var cards_container = $('player_stuff');
	if (cards_container == undefined) return;

	if (Devo.Core._vp_width < 985) {
		cards_container.select('.card').each(function(card) {
			card.addClassName('medium');
		});
	} else {
		cards_container.select('.card').each(function(card) {
			card.removeClassName('medium');
		});
	}
}

Devo.Main._resizeWatcher = function() {
	Devo.Core._vp_width = document.viewport.getWidth();
	Devo.Core._vp_height = document.viewport.getHeight();
	Devo.Main._resizeChat();
	Devo.Main._resizeProfile();
	Devo.Main._resizeShelf();
	Devo.Main._resizeSkills();
	Devo.Main._resizeCardPicker();
	Devo.Main._resizeMapContainer();
	Devo.Main._resizeStoryList();
};

Devo.Main._scrollWatcher = function() {
	if ($('pickcards-container')) {
		var y = document.viewport.getScrollOffsets().top;
		if (y > 130) {
			$('pickcards-filter-container').addClassName('fixed');
		} else {
			$('pickcards-filter-container').removeClassName('fixed');
		}
	}
}

Devo.Main.setGameInterfacePart = function(json, cb) {
	$('game-content-container').update(json.interface_content);
	window.setTimeout(function() { 
		if (cb != undefined) cb(json);
		Devo.Main._resizeWatcher();
	}, 150);
}

Devo.Main.showMenu = function() {
	if ($('play-menu-setup').visible()) {

	} else {
		$('play-menu-main').show();
		$('play-menu-play').hide();

		if (Devo.Game._id != undefined) {
			$('play-menu-ingame').show();
			$('play-menu-generic').hide();
			$('close-menu-button').hide();
			$('leave-game-button').show();
		} else {
			$('leave-game-button').hide();
			$('play-menu-generic').show();
			$('play-menu-ingame').hide();
		}
		if ($('profile-container')) {
			$('show-profile-button').hide();
		} else {
			$('show-profile-button').show();
		}
		if ($('market-container')) {
			$('enter-market-button').hide();
		} else {
			$('enter-market-button').show();
		}
		if ($('play-adventure-button')) {
			if ($('adventure-container')) {
				$('play-adventure-button').hide();
			} else {
				$('play-adventure-button').show();
			}
		}
		if (Devo.Core.Pollers.chatlinespoller != undefined) {
			$('enter-lobby-button').hide();
			$('close-menu-button').show();
		} else {
			$('close-menu-button').hide();
			$('enter-lobby-button').show();
		}
		if (!$('lobby-container')) {
			$('enter-lobby-button').show();
		}
	}

	$('gamemenu-container').show();
};

Devo.Game.flee = function() {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=leave&game_id='+Devo.Game._id,
		success: {
			callback: function(json) {
				if (json.leave_game == 'ok') {
					if (Devo.Game._current_turn != undefined) {
						Devo.Game.getStatistics();
					} else {
						Devo.Main.removeGameFromList(Devo.Game._id);
					}
					Devo.Main.Helpers.Dialog.dismiss();
					Devo.Game.destroyGame();
					if (json.is_adventure != undefined && json.is_adventure) {
						Devo.Main.loadAdventureUI('part', json.part_id);
					} else {
						Devo.Main.loadLobbyUI();
					}
				}
			}
		}
	});
};

Devo.Main.initializeLobby = function() {
	if ($('ui').visible()) return;

	Devo.Main.Helpers.loading();
	Devo.Chat.joinRoom(1);
	Devo.Core._initializeChatRoomPoller();
	Event.observe(window, 'resize', Devo.Main._resizeWatcher);
	Event.observe(window, 'scroll', Devo.Main._scrollWatcher);
	Devo.Main._resizeWatcher();
	$('profile_menu_strip').childElements().each(function(element) {
		element.removeClassName('selected');
	});
	$('ui').show();
	window.setTimeout(function() {
		Devo.Main.Helpers.finishLoading();
	}, 2000);
}

Devo.Game._uninitializeGameChat = function(room_id) {
	Devo.Chat.leaveRoom(room_id);
	var toggler = $('chat_'+room_id+'_toggler');
	var container = $('chat_'+room_id+'_container');
	if (container) container.remove();
	if (toggler) {
		toggler.addClassName('animated fadeOutUp');
		window.setTimeout(function() {
				toggler.remove();
		}, 1000);
	}
}

Devo.Game._initializeGameChat = function(room_id) {
	Devo.Game._room_id = room_id;
	if ($('chat_'+room_id+'_toggler')) return;

	var toggler = '<li id="chat_'+room_id+'_toggler" data-room-id="'+room_id+'" onclick="Devo.Game.toggleChat('+room_id+');" class="ui_button">Game chat<span class="notify"> *</span></li>';
	$('profile_menu_strip').insert({bottom: toggler});
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=game_interface&part=chat_room&room_id='+room_id,
		success: {
			callback: function(json) {
				$('ui').insert({top: json.interface_content});
				Devo.Chat.joinRoom(room_id);
			}
		}
	});

}

Devo.Main.loadLobby = function() {
	Devo.Main.initializeLobby();
	$('chat_1_toggler').addClassName('selected');
	Devo.Game.toggleChat(1);
	Devo.Main.loadLobbyUI();
}

Devo.Main.loadLobbyUI = function() {
	if (!$('lobby-container')) {
		$('game-content-container').dataset.location = '#!lobby';
		window.location.hash = "!lobby";
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=lobby',
			success: {
				callback: function(json) {
					$('gamemenu-container').hide();
					Devo.Main.setGameInterfacePart(json);
					Devo.Core.Pollers.Callbacks.invitePoller();
					if (!$('chat_1_container').visible()) {
						$('chat_1_container').hide();
						Devo.Game.toggleChat(1);
					}
				}
			}
		});
	}
}

Devo.Main.loadMarketFrontpage = function() {
	if (!$('market-container')) {
		$('game-content-container').dataset.location = '#!market';
		window.location.hash = "!market";
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=market',
			success: {
				callback: function(json) {
					Devo.Main.initializeLobby();
					Devo.Main.setGameInterfacePart(json, function() {
						$('gamemenu-container').hide();
						if ($('chat_1_container').visible()) Devo.Game.toggleChat(1);
					});
				}
			},
			complete: {
				callback: function() {
					Devo.Main.Helpers.finishLoading();
				}
			}
		});
	}
}

Devo.Main.loadMarketSell = function() {
	if (!$('market-container-sell')) {
		$('game-content-container').dataset.location = '#!market/sell';
		window.location.hash = "!market/sell";
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=market_sell',
			success: {
				callback: function(json) {
					Devo.Main.initializeLobby();
					Devo.Main.setGameInterfacePart(json, function() {
						$('gamemenu-container').hide();
						if ($('chat_1_container').visible()) Devo.Game.toggleChat(1);
					});
				}
			},
			complete: {
				callback: function() {
					Devo.Main.Helpers.finishLoading();
				}
			}
		});
	}
}

Devo.Main.loadMarketBuy = function() {
	if (!$('market-container-buy')) {
		$('game-content-container').dataset.location = '#!market/buy';
		window.location.hash = "!market/buy";
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=market_buy',
			success: {
				callback: function(json) {
					Devo.Main.initializeLobby();
					Devo.Main.setGameInterfacePart(json, function() {
						$('gamemenu-container').hide();
						if ($('chat_1_container').visible()) Devo.Game.toggleChat(1);
						Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
							additional_params: '&for=buy_cards',
							success: {
								callback: function(json) {
									$('shelf-loading').insert({after: json.buycards});
									Devo.Main._default_race_filter = undefined;
									Devo.Main.filterCardsCategory('creature');
									Devo.Main.filterCardsRace('neutrals');
								}
							}
						});
					});
				}
			},
			complete: {
				callback: function() {
					Devo.Main.Helpers.finishLoading();
				}
			}
		});
	}
}

Devo.Main.loadAdventureUI = function(tellable_type, tellable_id) {
	if (!$('adventure-container')) {
		var location = "!adventure";
		if (tellable_type != undefined && tellable_id != undefined) {
				location = "!adventure/"+tellable_type+'/'+tellable_id;
			if (tellable_type == 'quest') {
				tellable_type = 'part';
			}
		}
		$('gamemenu-container').hide();
		$('game-content-container').dataset.location = '#'+location;
		window.location.hash = location;
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=adventure',
			success: {
				callback: function(json) {
					Devo.Main.initializeLobby();
					Devo.Main.setGameInterfacePart(json, function() {
						Devo.Main.Helpers.finishLoading();
						if (tellable_type != undefined && tellable_id != undefined) {
							window.setTimeout(function() {
								eventFire($(tellable_type+'-'+tellable_id+'-map-point'), 'click');
							}, 1500);
						}
						if ($('chat_1_container').visible()) Devo.Game.toggleChat(1);
					});
				}
			}
		});
	}
}

Devo.Main.loadProfile = function() {
	if (!$('profile-container')) {
		$('game-content-container').dataset.location = '#!profile';
		window.location.hash = "!profile";
		Devo.Game.destroyGame();
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=profile',
			success: {
				callback: function(json) {
					Devo.Main.setGameInterfacePart(json, function() {
						Devo.Main.Helpers.finishLoading();
						if ($('profile-character-setup')) {
							$('profile-character-setup').show();
						} else {
							Devo.Main.initializeLobby();
						}
					});
				}
			}
		});
	}
	if ($('gamemenu-container').visible()) $('gamemenu-container').hide();
	if ($('chat_1_container').visible()) Devo.Game.toggleChat(1);
}

Devo.Main.loadProfileCards = function() {
	if (!$('profile-cards-container')) {
		$('game-content-container').dataset.location = '#!profile/cards';
		window.location.hash = "!profile/cards";
		Devo.Game.destroyGame();
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=profile_cards',
			success: {
				callback: function(json) {
					Devo.Main.setGameInterfacePart(json, Devo.Main.Helpers.finishLoading);
				}
			}
		});
	}
}

Devo.Main.loadProfileSkills = function() {
	if (!$('profile-skills-container')) {
		$('game-content-container').dataset.location = '#!profile/skills';
		window.location.hash = "!profile/skills";
		Devo.Game.destroyGame();
		Devo.Main.Helpers.loading();
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_interface&part=profile_skills',
			success: {
				callback: function(json) {
					Devo.Main.setGameInterfacePart(json, Devo.Main.Helpers.finishLoading);
				}
			}
		});
	}
}

Devo.Admin.Users.resetCards = function(user_id) {
	var form = $('users_form');
	var url = form.action;
	Devo.Main.Helpers.ajax(url, {
		additional_params: '&topic=reset_user_cards&user_id=' + user_id,
		loading: {indicator: 'user_'+user_id+'_indicator'},
		success: {
			callback: function() { Devo.Main.Helpers.popup(); }
		}
	});
};

Devo.Admin.Users.resetCharacter = function(user_id) {
	var form = $('users_form');
	var url = form.action;
	Devo.Main.Helpers.ajax(url, {
		additional_params: '&topic=reset_user_character&user_id=' + user_id,
		loading: {indicator: 'user_'+user_id+'_indicator'},
		success: {
			callback: function() { Devo.Main.Helpers.popup(); }
		}
	});
};

Devo.Admin.Users.forgotPassword = function(user_id, url, userinfo) {
	Devo.Main.Helpers.ajax(url, {
		additional_params: '&userinfo=' + userinfo,
		loading: {indicator: 'user_'+user_id+'_indicator'},
		success: {
			callback: function() { Devo.Main.Helpers.popup(); }
		}
	});
};

Devo.Admin.Users.removeCards = function(user_id) {
	var form = $('users_form');
	var url = form.action;
	Devo.Main.Helpers.ajax(url, {
		additional_params: '&topic=remove_user_cards&user_id=' + user_id,
		loading: {indicator: 'user_'+user_id+'_indicator'},
		success: {
			callback: function() { Devo.Main.Helpers.popup(); }
		}
	});
};

Devo.Admin.Users.generatePotionPack = function(user_id) {
	var form = $('users_form');
	var url = form.action;
	Devo.Main.Helpers.ajax(url, {
		additional_params: '&topic=user_new_potion_pack&user_id=' + user_id,
		loading: {indicator: 'user_'+user_id+'_indicator'},
		success: {
			callback: function() { Devo.Main.Helpers.popup(); }
		}
	});
};

Devo.Admin.Users.generateStarterPack = function(user_id, faction) {
	var form = $('users_form');
	var url = form.action;
	Devo.Main.Helpers.ajax(url, {
		additional_params: '&topic=user_new_starter_pack&user_id=' + user_id + '&faction=' + faction,
		loading: {indicator: 'user_'+user_id+'_indicator'},
		success: {
			callback: function() { Devo.Main.Helpers.popup(); }
		}
	});
};

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

Devo.Admin.removeCardReward = function(reward_id) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=remove_card_reward&reward_id='+reward_id,
		loading: {
			callback: function() {
				var button = $('card_reward_'+reward_id).down('.button');
				$(button).down('img').show();
				$(button).addClassName('disabled');
			}
		},
		success: {
			remove: 'card_reward_'+reward_id
		}
	});
};

Devo.Admin.addCardReward = function(card_id, tellable_type, tellable_id) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=add_card_reward&card_id='+card_id+'&tellable_type='+tellable_type+'&tellable_id='+tellable_id,
		loading: {
			callback: function() {
				var button = $('add_reward_'+card_id);
				$(button).down('img').show();
				$(button).addClassName('disabled');
			}
		},
		success: {
			callback: function(json) {
				$('tellable_card_rewards').insert(json.reward);
				Devo.Main.Helpers.Backdrop.reset();
			}
		}
	});
};

Devo.Admin.removeCardOpponent = function(opponent_id) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=remove_card_opponent&opponent_id='+opponent_id,
		loading: {
			callback: function() {
				var button = $('card_opponent_'+opponent_id).down('.button');
				$(button).down('img').show();
				$(button).addClassName('disabled');
			}
		},
		success: {
			remove: 'card_opponent_'+opponent_id
		}
	});
};

Devo.Admin.addCardOpponent = function(form) {
	Devo.Main.Helpers.ajax(Devo.options['say_url']+'&topic=add_card_opponent', {
		form: form,
		loading: {
			callback: function() {
				Devo.Main.Helpers.loading();
			}
		},
		success: {
			callback: function(json) {
				Devo.Main.Helpers.finishLoading();
				$('tellable_card_opponents').insert(json.opponent);
			}
		}
	});
};

Devo.Chat.joinRoom = function(room_id) {
	$('chat_rooms_joined').insert('<input type="hidden" name="rooms['+room_id+']" value="'+room_id+'" id="chat_room_'+room_id+'_joined">');
	$('chat_rooms_joined').insert('<input id="chat_room_'+room_id+'_since" type="hidden" name="since['+room_id+']" value="">');
};

Devo.Chat.leaveRoom = function(room_id) {
	if ($('chat_room_'+room_id+'_joined')) $('chat_room_'+room_id+'_joined').remove();
	if ($('chat_room_'+room_id+'_since')) $('chat_room_'+room_id+'_since').remove();
};

Devo.Chat.say = function(form) {
	form = $(form);
	if (form.down('input[type=text]').value != '') {
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
					form.down('input[type=text]').value = '';
				}
			},
			success: {
				callback: function() {
					Devo.Core.Pollers.Callbacks.chatLinesPoller();
					say_button.enable();
					say_button.removeClassName('disabled');
				}
			}
		});
	}
};

Devo.Chat.emotify = function(text) {
	for (var image in Devo.Chat.emoticons) {
		var regex = Devo.Chat.emoticons[image];
		regex.each(function(r) {
			text = text.gsub(r, '<img src="/images/smileys/'+image+'.png">');
		});
	}
	if (text.slice(0, 3) == '/me') {
		text = '<span class="chat_action">&#9758;</span> ' + text.slice(3);
	}

	return text + ' ';
}

Devo.Core.Pollers.Callbacks.gameDataPoller = function() {
	if (!Devo.Core.Pollers.Locks.gamedatapoller && Devo.Game.Events.size() <= 2) {
		Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
			additional_params: '&for=game_data&game_id='+Devo.Game._id+'&latest_event_id='+Devo.Game._latest_event_id,
			loading: {
				callback: function() {
					Devo.Core.Pollers.Locks.gamedatapoller = true;
				}
			},
			success: {
				callback: function(json) {
					if (json.game.events.size() > 0) {
						Devo.Game.processGameEvents(json.game.events);
						Devo.Game._initializeEventPlaybackPoller();
					}
					Devo.Game.data = json.game.data;
					if (!$('ui').hasClassName('in-play')) $('ui').addClassName('in-play');
					if (!$('board-container').hasClassName('in-play')) $('board-container').addClassName('in-play');
				}
			},
			complete: {
				callback: function() {
					Devo.Core.Pollers.Locks.gamedatapoller = false;
				}
			}
		});
	}
};

Devo.Notifications.add = function(message, options) {
	Devo.Notifications.Messages.push({message: message, options: options});
};

Devo.Notifications.remove = function(tstamp) {
	if ($('notification-'+tstamp).hasClassName('hovered')) {
		window.setTimeout(function() {
			Devo.Notifications.remove(tstamp);
		}, 6500);
	} else {
		$('notification-'+tstamp).remove();
		Devo.Core.Pollers.Locks.notificationspoller = false;
	}
};

Devo.Core.Pollers.Callbacks.notificationsPoller = function() {
	if (!Devo.Core.Pollers.Locks.notificationspoller && Devo.Notifications.Messages.size() > 0) {
		Devo.Core.Pollers.Locks.notificationspoller = true;
		var nc = $('notifications-container');
		var line = Devo.Notifications.Messages.shift();
		var d = new Date();
		var tstamp = d.getTime();
		var timeout = (line['options'] && line['options']['timeout']) ? parseInt(parseInt(line['options']['timeout']) * 1000) : 6500;
		var notification = '<div class="notification" id="notification-'+tstamp+'">';
		if (line['options'] && line['options']['title']) notification += '<div class="title">'+line['options']['title']+'</div>';
		notification += line['message'];
		if (line['options'] && line['options']['buttons']) {
			notification += '<div class="buttons button-group">';
			line['options']['buttons'].each(function(button) {
				notification += '<a href="javascript:void(0);" class="ui_button" onclick="'+button['click']+'">'+button['title']+'</a>';
			});
			notification += '</div>';
		}
		notification += '</div>';
		nc.insert(notification);
		window.setTimeout(function() {
			$('notification-'+tstamp).observe('mouseover', function() { $('notification-'+tstamp).addClassName('hovered'); });
			$('notification-'+tstamp).observe('mouseout', function() { $('notification-'+tstamp).removeClassName('hovered'); });
		}, 200);
		window.setTimeout(function() {
			Devo.Notifications.remove(tstamp);
		}, timeout);
	}
};

Devo.Core.Pollers.Callbacks.bubblePoller = function() {
	if (!Devo.Core.Pollers.Locks.bubblepoller && Devo.Chat.Bubbles.size() > 0) {
		var avatar = $('avatar-opponent');

		if (!avatar) {
			Devo.Core.Pollers.Locks.bubblepoller = false;
			Devo.Chat.destroyBubblePoller();
			return;
		}

		Devo.Core.Pollers.Locks.bubblepoller = true;
		var line = Devo.Chat.Bubbles.shift();
		var bubble = '<div class="tooltip bubble active" id="bubble-'+line['id']+'"><div class="bubble_content">'+Devo.Chat.emotify(line['text'])+'</div></div>';
		avatar.insert(bubble);
		window.setTimeout(function() {
			$('bubble-'+line['id']).remove();
			Devo.Core.Pollers.Locks.bubblepoller = false;
		}, 6500);
	} else if (Devo.Chat.Bubbles.size() == 0) {
		Devo.Core.Pollers.bubblepoller = null;
	}
};

Devo.Core.Pollers.Callbacks.eventPlaybackPoller = function() {
	if (!Devo.Core.Pollers.Locks.eventplaybackpoller && Devo.Game.Events.size() > 0) {
		Devo.Core.Pollers.Locks.eventplaybackpoller = true;
		var event = Devo.Game.Events.shift();
		Devo.Game._current_event = event;
		if (!$('event_' + event.id + '_container') && event.type != 'player_change' && (event.current_turn > 2 || Devo.Game._current_turn > 2)) {
			$('game_event_contents').insert(event.event_content);
			$('last-event').update($('event_' + event.id + '_container').innerHTML);
			$('game_events').scrollTop = $('game_events').scrollHeight;
			window.setTimeout(function() {
				if (!$('last-event')) return;
				$('last-event').removeClassName('fadeOut');
				$('last-event').addClassName('fadeIn');
				window.setTimeout(function() {
					if (!$('last-event')) return;
					$('last-event').removeClassName('fadeIn');
					$('last-event').addClassName('fadeOut');
				}, 5000);
			}, 100);
		}
		switch (event.type) {
			case 'player_change':
				Devo.Game.processPlayerChange(event.data);
				break;
			case 'thinking':
				Devo.Game.processThinking(event.data);
				break;
			case 'phase_change':
				Devo.Game.processPhaseChange(event.data, event.id);
				break;
			case 'card_moved_off_slot':
				Devo.Game.processCardMovedOffSlot(event.data);
				break;
			case 'card_moved_onto_slot':
				Devo.Game.processCardMovedOntoSlot(event.data);
				break;
			case 'replenish':
				Devo.Game.processReplenish(event.data);
				break;
			case 'attack':
				Devo.Game.processAttack(event.data);
				break;
			case 'end_attack':
				Devo.Game.processEndAttack(event.data);
				break;
			case 'damage':
				Devo.Game.processDamage(event.data);
				break;
			case 'player_online':
				Devo.Game.processUserOnline(event.data);
				break;
			case 'player_offline':
				Devo.Game.processUserOffline(event.data);
				break;
			case 'restore_health':
				Devo.Game.processRestoreHealth(event.data);
				break;
			case 'restore_energy':
				Devo.Game.processRestoreEnergy(event.data);
				break;
			case 'apply_effect':
				Devo.Game.processApplyEffect(event.data);
				break;
			case 'remove_effect':
				Devo.Game.processRemoveEffect(event.data);
				break;
			case 'steal_gold':
				Devo.Game.processStealGold(event.data);
				break;
			case 'generate_gold':
				Devo.Game.processGenerateGold(event.data);
				break;
			case 'steal_ep':
				Devo.Game.processStealEP(event.data);
				break;
			case 'card_removed':
				Devo.Game.processCardRemoved(event.data);
				break;
			case 'game_over':
				Devo.Game.processGameOver(event.data);
				break;
			default:
				Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}
	} else if (Devo.Game.Events.size() == 0) {
		Devo.Core.Pollers.eventplaybackpoller = null;
	}
}

Devo.Game.destroyGameDataPoller = function() {
	Devo.Game.data = {};
	if (Devo.Core.Pollers.gamedatapoller) {
		Devo.Core.Pollers.gamedatapoller.stop();
		Devo.Core.Pollers.gamedatapoller = undefined;
	}
}

Devo.Game._initializeGameDataPoller = function() {
	Devo.Game.data = {};
	Devo.Core.Pollers.gamedatapoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.gameDataPoller, 2);
};

Devo.Game.destroyEventPlaybackPoller = function() {
	Devo.Game.Events = [];
	if (Devo.Core.Pollers.eventplaybackpoller) {
		Devo.Core.Pollers.eventplaybackpoller.stop();
		Devo.Core.Pollers.eventplaybackpoller = undefined;
	}
};

Devo.Game._initializeEventPlaybackPoller = function() {
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	Devo.Core.Pollers.eventplaybackpoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.eventPlaybackPoller, 0.2);
};

Devo.Chat.destroyBubblePoller = function() {
	Devo.Chat.Bubbles = [];
	if (Devo.Core.Pollers.bubblepoller) {
		Devo.Core.Pollers.bubblepoller.stop();
		Devo.Core.Pollers.bubblepoller = undefined;
	}
};

Devo.Chat._initializeBubblePoller = function() {
	if (Devo.Core.Pollers.bubblepoller == null || Devo.Core.Pollers.bubblepoller == undefined) {
		Devo.Core.Pollers.bubblepoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.bubblePoller, 0.2);
	}
};

Devo.Chat.destroyNotificationsPoller = function() {
	Devo.Notifications.Messages = [];
	if (Devo.Core.Pollers.notificationspoller) {
		Devo.Core.Pollers.notificationspoller.stop();
		Devo.Core.Pollers.notificationspoller = undefined;
	}
};

Devo.Core._initializeNotificationsPoller = function() {
	if (Devo.Core.Pollers.notificationspoller == null || Devo.Core.Pollers.notificationspoller == undefined) {
		Devo.Core.Pollers.notificationspoller = new PeriodicalExecuter(Devo.Core.Pollers.Callbacks.notificationsPoller, 1);
	}
};

Devo.Game._initializeCards = function() {
	$$('.card.creature').each(function(card) {
		Devo.Game.updateCardAttackAvailability(card);
	});
	if (Devo.Game._movable) {
		if (!Devo.options.candrag) {
			Devo.Game._initializeClickableCardMover();
		} else {
			Devo.Game._initializeDragDrop();
		}
	} else if (Devo.Game._actions && Devo.Game._actions_remaining > 0) {
		Devo.Game._initializeActions();
	}
	Devo.Game._initializePotions();
};

Devo.Game._initializeCardDragDrop = function(card) {
	card.addEventListener('dragstart', Devo.Game.card_dragstart, false);
	card.addEventListener('dragover', Devo.Game.card_dragover, false);
	card.addEventListener('dragend', Devo.Game.card_dragend, false);
	$(card).addClassName('movable');
};

Devo.Game.card_clickmovestart = function(event) {
	var card = $(this);
	card.addClassName('moving');
	Devo.Game._calculateDropSlots(card);
	var pa = $('play-area');
	pa.addEventListener('click', Devo.Game.cardslot_clickend, false);
	pa.addClassName('cancelmove');
	if (!card.hasClassName('placed')) {
		$('player_stuff').addEventListener('click', Devo.Game.cardslot_clickmove, false);
	}
	$('player-slots').select('.card-slot').each(function(slot) {
		var hovered = false;
		if (card.hasClassName('creature') && slot.hasClassName('creature-slot')) {
			if (slot.hasClassName('player') && !slot.down('.card')) {
				hovered = true;
				slot.addClassName('drop-hover');
			}
		} else if (card.hasClassName('item') && slot.hasClassName('creature-slot')) {
			hovered = true;
		} else if (card.hasClassName('item') && slot.hasClassName('item-slot')) {
			var parent_slot = slot.up('.card-slot');
			var slot_card = parent_slot.down('.card.creature');
			var existing_attack_items = parent_slot.select('.item-attack').size();
			var existing_defend_items = parent_slot.select('.item-defend').size();
			var eq_both = false;
			if (slot_card) {
				slot_card.down('.attacks').childElements().each(function(attack) {
					if (attack.dataset.requiresEquippableBoth != undefined) eq_both = true;
				});
				if ((slot_card.hasClassName('class-civilian') && card.dataset.equippableByCivilian == 'true') ||
				(slot_card.hasClassName('class-magic') && card.dataset.equippableByMagic == 'true') ||
				(slot_card.hasClassName('class-military') && card.dataset.equippableByMilitary == 'true') ||
				(slot_card.hasClassName('class-physical') && card.dataset.equippableByPhysical == 'true') ||
				(slot_card.hasClassName('class-ranged') && card.dataset.equippableByRanged == 'true')) {
					if (!(existing_attack_items + existing_defend_items == 0 && slot.dataset.itemSlotNo == 2)) {
						if (((card.hasClassName('item-attack') && existing_attack_items == 0) || eq_both) ||
							(card.hasClassName('item-defend') && existing_defend_items == 0)) {
							hovered = true;
							slot.addClassName('drop-hover');
							parent_slot.removeClassName('drop-denied');
						}
					}
				}
			}
		}
		if (hovered == false) {
			slot.addClassName('drop-denied');
		}
		if (slot.hasClassName('drop-hover')) {
			slot.addEventListener('click', Devo.Game.cardslot_clickmove, false);
		}
	});
	event.preventDefault();
	event.stopPropagation();
};

Devo.Game.cardslot_clickend = function() {
	var card = $$('.card.moving')[0];
	if (card) $(card).removeClassName('moving');
	var pa = $('play-area');
	pa.removeEventListener('click', Devo.Game.cardslot_clickend);
	pa.removeClassName('cancelmove');
	$('player_stuff').removeEventListener('click', Devo.Game.cardslot_clickmove);
	$('player-slots').removeClassName('droptargets');
	$('player_stuff').removeClassName('droptarget');
	$('player_stuff').removeClassName('dragging');
	$('player-slots').select('.card-slot').each(function(slot) {
		slot.removeClassName('drop-hover');
		slot.removeClassName('drop-denied');
		slot.removeEventListener('click', Devo.Game.cardslot_clickmove);
	});
};

Devo.Game.cardslot_clickmove = function(event) {
	if (!$(this).hasClassName('drop-hover') && !$(this).hasClassName('droptarget')) {
		Devo.Game.cardslot_clickend();
		return;
	}
	var card = $$('.card.moving')[0];
	var dropped = (this.id == 'player_stuff') ? $('player_hand') : $(this);
	if (Devo.Game.getCardSlot(card)) {
		[1,2].each(function(cc) {
			var islot = $(Devo.Game.getCardSlot(card).id+'-item-slot-'+cc);
			if (islot) {
				var icard = islot.down('.card.equippable_item');
				if (icard) Devo.Game._movecard(icard, $(dropped.id+'-item-slot-'+cc));
			}
		});
	}
	Devo.Game._movecard(card, dropped);
	Devo.Game.cardslot_clickend();
};

Devo.Game._initializeCardMover = function(card) {
	card.addEventListener('click', Devo.Game.card_clickmovestart, false);
	$(card).addClassName('movable_click');
};

Devo.Game._initializeClickableCardMover = function() {
	if (Devo.Game._movable == true) {
		var selector_classes_slots = '.player .card.creature, .player .card.equippable_item';
		var selector_classes_hand = '#player_hand .card.creature, #player_hand .card.equippable_item';
		$$(selector_classes_slots).each(function(card) {
			if (!$(card).hasClassName('effect-stun')) {
				card.dataset.originalPosition = $(card).up().id;
				Devo.Game._initializeCardMover(card);
			}
		});
		$$(selector_classes_hand).each(function(card) {
			Devo.Game._initializeCardMover(card);
		});
	}
};

Devo.Game._initializeDragDrop = function() {
	if (Devo.Game._movable == true) {
		var selector_classes_slots = '.player .card.creature, .player .card.equippable_item';
		var selector_classes_hand = '#player_hand .card.creature, #player_hand .card.equippable_item';
		$$(selector_classes_slots).each(function(card) {
			if (!$(card).hasClassName('effect-stun')) {
				card.dataset.originalPosition = $(card).up().id;
				Devo.Game._initializeCardDragDrop(card);
			}
		});
		$$(selector_classes_hand).each(function(card) {
			Devo.Game._initializeCardDragDrop(card);
		});
		$$('#player-slots .card-slot').each(function(cardslot) {
			var card = $(cardslot).down('.card');
			if (!card || !$(card).hasClassName('effect-stun')) {
				cardslot.addEventListener('dragover', Devo.Game.cardslot_dragover, false);
				cardslot.addEventListener('dragleave', Devo.Game.cardslot_dragleave, false);
				cardslot.addEventListener('drop', Devo.Game.cardslot_drop, false);
			}
		});
		var phand = $('player_stuff');
		phand.addEventListener('dragover', Devo.Game.cardslot_dragover, false);
		phand.addEventListener('dragleave', Devo.Game.cardslot_dragleave, false);
		phand.addEventListener('drop', Devo.Game.cardslot_drop, false);
	}
};

Devo.Game._uninitializeDragDrop = function() {
	var cards = document.querySelectorAll('.player .card');
	[].forEach.call(cards, function(card) {
		card.removeEventListener('dragstart', Devo.Game.card_dragstart);
		card.removeEventListener('dragover', Devo.Game.card_dragover);
		card.removeEventListener('dragend', Devo.Game.card_dragend);
		$(card).removeClassName('movable');
	});
	var cardslots = document.querySelectorAll('.card-slots .card-slot');
	[].forEach.call(cardslots, function(cardslot) {
		cardslot.removeEventListener('dragover', Devo.Game.cardslot_dragover);
		cardslot.removeEventListener('dragleave', Devo.Game.cardslot_dragleave);
		cardslot.removeEventListener('drop', Devo.Game.cardslot_drop);
	});
};

Devo.Game._uninitializeClickableCardMover = function() {
	var cards = document.querySelectorAll('.player .card');
	[].forEach.call(cards, function(card) {
		card.removeEventListener('click', Devo.Game.card_clickmovestart);
		$(card).removeClassName('movable_click');
	});
};

Devo.Game._initializeCardActions = function(card) {
	if (card.hasClassName('creature')) card.observe('click', Devo.Game.toggleActionCard);
	card.down('.attacks').childElements().each(function(attack) {
		if (!$(attack).hasClassName('disabled')) {
			$(attack).observe('click', Devo.Game.initiateAttack);
		}
	});
};

Devo.Game._initializeActions = function() {
	$$('.player .card.creature.placed').each(function(card) {
		if (!$(card).hasClassName('effect-stun')) {
			Devo.Game._initializeCardActions($(card));
		}
	});
	$('player-slots').addClassName('actionable');
	$('player_stuff').addClassName('actionable');
};

Devo.Game._initializePotions = function() {
	$$('.card.potion_item').each(function(card) {
		var p_card = $(card).previous();
		if (p_card && p_card.dataset.originalCardId != $(card).dataset.originalCardId) p_card.addClassName('split');
		$(card).down('.attacks').childElements().each(function(attack) {
			$(attack).observe('click', Devo.Game.initiateAttack);
		});
	});
};

Devo.Game._uninitializeActions = function() {
	$$('.player .card.placed').each(function(card) {
		$(card).stopObserving('click', Devo.Game.toggleActionCard);
		if ($(card).hasClassName('creature')) {
			$(card).down('.attacks').childElements().each(function(attack) {
				$(attack).stopObserving('click', Devo.Game.initiateAttack);
			});
		}
	});
	if ($('player-slots')) $('player-slots').removeClassName('actionable');
	if ($('player_stuff')) $('player_stuff').removeClassName('actionable');
};

Devo.Game.getCard = function(card_id, cb) {
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=card&game_id='+Devo.Game._id+'&card_id='+card_id,
		success: {
			callback: cb
		}
	});
}

Devo.Game.Effects.cardAppear = function(card) {
	if (!card.hasClassName('medium')) card.addClassName('medium');
	window.setTimeout(function() {
		card.show();
		card.addClassName('animated fadeInDownBig');
		window.setTimeout(function() {
			card.writeAttribute('style', '');
			card.removeClassName('animated fadeInDownBig');
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}, 1200);
	}, 100);
};

Devo.Game.Effects.cardFade = function(card) {
	window.setTimeout(function() {
		card.writeAttribute('style', '');
		var fadeclass = (card.hasClassName('player')) ? 'fadeOutDownBig' : 'fadeOutUpBig';
		card.addClassName('animated '+fadeclass);
		window.setTimeout(function() {
			card.hide();
			card.removeClassName('animated '+fadeclass);
			card.removeClassName('medium');
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}, 1200);
	}, 100);
};

Devo.Game.Effects.useGold = function(cost, classname) {
	var gga = (classname == 'player') ? $('game-gold-amount') : $('game-gold-amount-opponent');
	var gg = (classname == 'player') ? $('game-gold') : $('game-gold-opponent');
	var gold = parseInt(gga.innerHTML);
	gg.dataset.amount = cost.to;

	if (gold != cost.to) {
		gga.update(gold+'<div class="negative fadeOutUp diff animated">'+cost.diff+'</div>');
		window.setTimeout(function() {
			gga.update(cost.to);
			$$('.card.'+classname).each(function(c) {
				Devo.Game.updateCardAttackAvailability(c);
			});
		}, 1000);
	}
}

Devo.Game.Effects.stolenGold = function(cost, classname) {
	var gga = (classname == 'player') ? $('game-gold-amount') : $('game-gold-amount-opponent');
	var gg = (classname == 'player') ? $('game-gold') : $('game-gold-opponent');
	var gold = parseInt(gga.innerHTML);

	cost.to = parseInt(gg.dataset.amount) - parseInt(cost.diff);
	gg.dataset.amount = cost.to;

	if (gold != cost.to) {
		gga.update(gold+'<div class="negative fadeOutUp diff animated">'+cost.diff+'</div>');
		window.setTimeout(function() {
			gga.update(cost.to);
			$$('.card.'+classname).each(function(c) {
				Devo.Game.updateCardAttackAvailability(c);
			});
		}, 1000);
	}
}

Devo.Game.Effects.getGold = function(cost, classname) {
	var gga = (classname == 'player') ? $('game-gold-amount') : $('game-gold-amount-opponent');
	var gg = (classname == 'player') ? $('game-gold') : $('game-gold-opponent');
	var gold = parseInt(gga.innerHTML);
	cost.to = parseInt(gg.dataset.amount) + parseInt(cost.diff);
	gg.dataset.amount = cost.to;

	if (gold != cost.to) {
		gga.update(gold+'<div class="fadeInDown diff animated">'+cost.diff+'</div>');
		window.setTimeout(function() {
			gga.update(cost.to);
			$$('.card.'+classname).each(function(c) {
				Devo.Game.updateCardAttackAvailability(c);
			});
		}, 1000);
	}
}

Devo.Game.Effects.useEP = function(card, cost) {
	var ep_elm = card.down('.ep');
	var ep = parseInt(ep_elm.innerHTML);
	card.dataset.ep = cost.to;
	if (ep != cost.to) {
		ep_elm.update(ep+'<div class="negative fadeOutUp diff animated">'+cost.diff+'</div>');
		window.setTimeout(function() {
			ep_elm.update(cost.to);
			if ($(card).hasClassName('player')) {
				Devo.Game.updateCardAttackAvailability(card);
			}
		}, 1000);
	}
}

Devo.Game.Effects.getEP = function(card, cost) {
	var ep_elm = card.down('.ep');
	var ep = parseInt(ep_elm.innerHTML);
	card.dataset.ep = cost.to;
	if (ep != cost.to) {
		card.addClassName('restore_properties restore_ep');
		ep_elm.update(ep+'<div class="fadeDownIn diff animated">'+cost.diff+'</div>');
		window.setTimeout(function() {
			ep_elm.update(cost.to);
			card.removeClassName('restore_properties restore_ep');
			Devo.Game.updateCardAttackAvailability(card);
		}, 1000);
	}
}

Devo.Game.Effects.getHP = function(card, cost) {
	var hp_elm = card.down('.hp');
	var hp = parseInt(hp_elm.innerHTML);
	card.dataset.hp = cost.to;
	if (hp != cost.to) {
		card.addClassName('restore_properties restore_health');
		hp_elm.update(hp+'<div class="fadeDownIn diff animated">'+cost.diff+'</div>');
		window.setTimeout(function() {
			card.removeClassName('restore_properties restore_health');
			hp_elm.update(cost.to);
		}, 1000);
	}
}

Devo.Game.Effects.damage = function(card, cost) {
	if (card) {
		var hp_elm = card.down('.hp');
		var hp = parseInt(hp_elm.innerHTML);
		card.dataset.hp = cost.to;
		if (hp != cost.to) {
			hp_elm.update(cost.from+'<div class="negative fadeOutUp diff animated">'+cost.diff+'</div>');
			window.setTimeout(function() {
				hp_elm.update(cost.to);
			}, 1000);
		}
	}
}

Devo.Game.isCardSlotEquippedWithItemClass = function(slot, equippable_class) {
	var item_cards = slot.select('.equippable-item-class-'+equippable_class);
	return (item_cards.size() > 0) ? true : false;
}

Devo.Game.updateCardAttackAvailability = function(card) {
	if (!card.hasClassName('creature')) return;
	var ep = parseInt(card.dataset.ep);
	var is_player_card = card.hasClassName('player');
	var gold = (is_player_card) ? Devo.Game.getGoldAmount() : Devo.Game.getGoldAmountOpponent();
	var user_level = (is_player_card) ? Devo.Game.getUserLevel() : Devo.Game.getUserLevelOpponent();
	var slot = Devo.Game.getCardSlot(card);
	card.down('.attacks').childElements().each(function(attack) {
		var available = true;
		if (parseInt(attack.dataset.costEp) > ep) available = false;
		if (parseInt(attack.dataset.costGold) > gold) available = false;
		if (parseInt(attack.dataset.requiresLevel) > 0 && parseInt(attack.dataset.requiresLevel) > user_level) available = false;
		var eq_1 = parseInt(attack.dataset.requiresEquippableClassOne);
		var eq_2 = parseInt(attack.dataset.requiresEquippableClassTwo);
		var eq_both = (attack.dataset.requiresEquippableBoth != undefined);
		if (eq_1 > 0) {
			if (card.dataset.slotNo == 0) {
				available = false;
			} else {
				var has_eq_1 = Devo.Game.isCardSlotEquippedWithItemClass(slot, eq_1);
				var has_eq_2 = (eq_2 > 0) ? Devo.Game.isCardSlotEquippedWithItemClass(slot, eq_2) : false;
				if (eq_both) {
					if (!has_eq_1 || !has_eq_2) available = false;
				} else {
					if (!has_eq_1 && !has_eq_2) available = false;
				}
			}
		}
		if (!available) {
			attack.addClassName('disabled');
			if (is_player_card) attack.stopObserving('click', Devo.Game.initiateAttack);
		} else {
			var pct = 0;
			var bonus = attack.down('.attack_bonus');
			if (slot != null && attack.dataset.isStealAttack == undefined && attack.dataset.isForageAttack == undefined) {
				var eq_cc = 1;
				slot.select('.equippable_item').each(function(eq_card) {
					if (eq_cc == 1 || eq_both || slot.select('.item-defend').size() > 0) {
						var attack_type = Devo.attack_types[parseInt(attack.dataset.attackType)];
						var increase_val = parseInt(eq_card.dataset['increases'+ucfirst(attack_type)+'Attack']);
						var decrease_val = parseInt(eq_card.dataset['decreases'+ucfirst(attack_type)+'Attack']);
						if (increase_val > 0) pct += increase_val;
						if (decrease_val > 0) pct -= decrease_val;
						eq_cc++;
					}
				});
				if (pct != 0) {
					bonus.update((pct > 0) ? '+'+pct+'%' : pct+'%');
					if (pct > 0) {
						bonus.addClassName('positive');
						bonus.removeClassName('negative');
					} else {
						bonus.addClassName('negative');
						bonus.removeClassName('positive');
					}
					bonus.show();
				} else {
					bonus.hide();
				}
			} else {
				bonus.hide();
			}
			if (attack.hasClassName('disabled')) {
				attack.removeClassName('disabled');
				if (is_player_card) attack.observe('click', Devo.Game.initiateAttack);
			}
		}
	});
};

Devo.Game.getGoldAmount = function() {
	return parseInt($('game-gold').dataset.amount);
};
Devo.Game.getGoldAmountOpponent = function() {
	return parseInt($('game-gold-opponent').dataset.amount);
};

Devo.Game.getUserId = function() {
	return Devo.options.user_id;
}
Devo.Game.getUserLevel = function() {
	return parseInt(Devo.Game._user_level);
}
Devo.Game.getUserLevelOpponent = function() {
	return parseInt(Devo.Game._user_level_opponent);
}

Devo.Game.processGameEvents = function(events, persist) {
	events.each(function(event) {
		if (persist == undefined || persist == true) {
			Devo.Game._latest_event_id = event.id;
		}
		Devo.Game.Events.push(event);
	});
};

Devo.Game.processCardRemoved = function(data) {
	var card = $('card_' + data.card_id);
	if (card) {
		var is_placed = (card.hasClassName('placed') || !card.hasClassName('player'));

		if (is_placed) {
			var fadeclass = (is_placed) ? ((card.hasClassName('player')) ? 'fadeOutDown' : 'fadeOutUp') : 'fadeOut';
			var initial_timeout = (card.hasClassName('placed')) ? 1000 : 1;
			var slot = Devo.Game.getCardSlot(card);
			$(slot).removeClassName('targetted');
			$(slot).stopObserving('click', Devo.Game.performAttack);
			slot.dataset.cardId = 0;
			card.addClassName('animated flip');
			window.setTimeout(function() {
				card.removeClassName('flip');
				card.addClassName(fadeclass);
				window.setTimeout(function() {
					card.removeClassName(fadeclass);
					card.remove();
					Devo.Core.Pollers.Locks.eventplaybackpoller = false;
				}, 1000);
			}, initial_timeout);
		} else {
			if (card.up().childElements().size() == 2) $('player_no_potions').show();
			card.remove();
			$('player_potions').removeClassName('animating');
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}
	} else {
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}
};

Devo.Game.processDamage = function(data) {
	var play_area = $('play-area');
	var card = $('card_' + data.attacking_card_id);
	var attacked_card = $('card_' + data.attacked_card_id);
	var attacked_class = (attacked_card.hasClassName('player')) ? 'player' : 'opponent';
	var initial_timeout = (data.damage_type == 'repeat' && data.damage_type != 'effect') ? 1 : 500;
	var is_in_play_area = (attacked_card.up().id == 'play-area');
	var sword_clash = $('sword-clash');

	if (!is_in_play_area && play_area.select('.card.'+attacked_class).size() > 0) {
		play_area.select('.card.'+attacked_class).each(function(card_to_return) {
			if (card_to_return.id != card.id) {
				Devo.Game._returnCardFromPlayArea(card_to_return);
			}
		});
	}
	if (!is_in_play_area && Devo.Game.is_attack == true) {
		Devo.Game._addCardToPlayArea(attacked_card);
	}
	window.setTimeout(function() {
		if (data.damage_type != 'repeat' && data.damage_type != 'effect') {
			if (data.bonus_cards) {
				data.bonus_cards.each(function(bc) {
					$('card_' + bc).addClassName('bonus_active bonus_attack');
				});
			}
		}
		if (data.defence_bonus_cards) {
			data.defence_bonus_cards.each(function(dbc) {
				$('card_' + dbc).addClassName('bonus_active bonus_defence');
			});
		}
		if (Devo.Game.is_attack) {
			sword_clash.show();
			sword_clash.addClassName('animated flash');
		}
		window.setTimeout(function() {
			if (data.damage_type != 'repeat' && data.damage_type != 'effect') {
				if (data.bonus_cards) {
					data.bonus_cards.each(function(bc) {
						$('card_' + bc).removeClassName('bonus_active bonus_attack');
					});
				}
			}
			if (data.defence_bonus_cards) {
				data.defence_bonus_cards.each(function(dbc) {
					$('card_' + dbc).removeClassName('bonus_active bonus_defence');
				});
			}
			if (Devo.Game.is_attack) {
				sword_clash.removeClassName('animated flash');
				sword_clash.hide();
			}
			Devo.Game.Effects.damage(attacked_card, data.hp);
			window.setTimeout(function() {
				if (Devo.Game.is_attack != true) {
					Devo.Game._returnCardFromPlayArea(attacked_card);
				}
				Devo.Core.Pollers.Locks.eventplaybackpoller = false;
			}, 1500);
		}, 1000);
	}, initial_timeout);
};

Devo.Game.processRestoreHealth = function(data) {
	var card = $('card_' + data.attacking_card_id);
	var attacked_card = $('card_' + data.attacked_card_id);
	if (card && data.player_id == Devo.Game.getUserId()) {
		card.addClassName('animated bounce');
	}

	window.setTimeout(function() {
		if (card && data.player_id == Devo.Game.getUserId()) {
			card.removeClassName('animated bounce');
		}
		Devo.Game.Effects.getHP(attacked_card, data.hp);
		window.setTimeout(function() {
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}, 1000);
	}, 1000);
};

Devo.Game.processRestoreEnergy = function(data) {
	var card = $('card_' + data.attacking_card_id);
	var attacked_card = $('card_' + data.attacked_card_id);
	if (data.player_id == Devo.Game.getUserId()) {
		card.addClassName('animated bounce');
	}

	window.setTimeout(function() {
		if (data.player_id == Devo.Game.getUserId()) {
			card.removeClassName('animated bounce');
		}
		Devo.Game.Effects.getEP(attacked_card, data.ep);
		window.setTimeout(function() {
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}, 1000);
	}, 1000);
};

Devo.Game.processApplyEffect = function(data) {
	if ($('card_' + data.attacked_card_id)) {
		$('card_' + data.attacked_card_id).addClassName('effect-'+data.effect);
	}
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
};

Devo.Game.processUserOffline = function(data) {
	if ($('player-'+data.changed_player_id+'-name')) $('player-'+data.changed_player_id+'-name').addClassName('offline');
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
};

Devo.Game.processUserOnline = function(data) {
	if ($('player-'+data.changed_player_id+'-name')) $('player-'+data.changed_player_id+'-name').removeClassName('offline');
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
};

Devo.Game.processThinking = function(data) {
	window.setTimeout(function() {
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}, parseInt(data.duration));
};

Devo.Game.processRemoveEffect = function(data) {
	var card = $('card_' + data.attacked_card_id);
	if (card) {
		var is_stunned = card.hasClassName('effect-stun');
		card.addClassName('restore_properties restore_ep');
		window.setTimeout(function() {
			card.removeClassName('restore_properties restore_ep');
			Devo.Game.updateCardAttackAvailability(card);
			card.removeClassName('effect-'+data.effect);
			if (Devo.Game._actions && is_stunned && card.hasClassName('player') && !card.hasClassName('effect-stun')) {
				Devo.Game._initializeCardActions(card);
			}
		}, 1000);
	}
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
};

Devo.Game.processStealGold = function(data) {
	if (data.player_id == Devo.Game.getUserId()) {
		Devo.Game.Effects.stolenGold(data.amount, 'opponent');
		window.setTimeout(function() {
			Devo.Game.Effects.getGold(data.amount, 'player');
		}, 1000);
	} else {
		Devo.Game.Effects.stolenGold(data.amount, 'player');
		window.setTimeout(function() {
			Devo.Game.Effects.getGold(data.amount, 'opponent');
		}, 1000);
	}
	window.setTimeout(function() {
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}, 2000);
};

Devo.Game.processGenerateGold = function(data) {
	if (data.player_id == Devo.Game.getUserId()) {
		Devo.Game.Effects.getGold(data.amount, 'player');
	} else {
		Devo.Game.Effects.getGold(data.amount, 'opponent');
	}
	window.setTimeout(function() {
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}, 1000);
};

Devo.Game.processStealEP = function(data) {
	var card = $('card_' + data.attacking_card_id);
	var attacked_card = $('card_' + data.attacked_card_id);

	card.addClassName('animated bounce');
	window.setTimeout(function() {
		card.removeClassName('animated bounce');
		attacked_card.addClassName('animated flash');
		window.setTimeout(function() {
			attacked_card.removeClassName('animated flash');
			Devo.Game.Effects.useEP(attacked_card, data.amount);
			window.setTimeout(function() {
				Devo.Core.Pollers.Locks.eventplaybackpoller = false;
			}, 1000);
		}, 1000);
	}, 1000);
};

Devo.Game.processAttack = function(data) {
	Devo.Game.is_attack = true;
	$('opponent-slots-container').addClassName('battling');
	$('player-slots-container').addClassName('battling');
	var card = $('card_' + data.attacking_card_id);
	var is_player = (data.player_id == Devo.Game.getUserId());
	var goldclass = (is_player) ? 'player' : 'opponent';
	Devo.Game._addCardToPlayArea(card);

	if (data.cost && data.cost.gold) Devo.Game.Effects.useGold(data.cost.gold, goldclass);

	if (is_player) {
		Devo.Game._actions_remaining = data.remaining_actions;
		$('phase-3-actions-remaining').update(data.remaining_actions);
		if (Devo.Game._actions_remaining == 0) {
			Devo.Game._uninitializeActions();
			Devo.Game.enableEndActionsTimer();
		}
	}
	if (data.cost && data.cost.ep) Devo.Game.Effects.useEP(card, data.cost.ep);
	if (data.cost && data.cost.hp) Devo.Game.Effects.damage(card, data.cost.hp);
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
}

Devo.Game._addCardToPlayArea = function(card) {
	if (card.up('#play-area')) return;
	if (card.hasClassName('potion_item')) return;
	var card_slot = Devo.Game.getCardSlot(card);
	var play_area = $('play-area');
	
	var c = card.remove();
	c.removeClassName('medium');
	play_area.insert(c);
	
	card_slot.select('.item-slot').each(function(p_slot) {
		if (p_slot.dataset.cardId && $('card_'+p_slot.dataset.cardId)) {
			play_area.insert($('card_'+p_slot.dataset.cardId).remove());
		}
	});
}

Devo.Game.getCardSlot = function(card) {
	var slot = (card.hasClassName('player')) ? $('player-slot-'+card.dataset.slotNo) : $('opponent-slot-'+card.dataset.slotNo);
	if (!card.hasClassName('creature') && slot) {
		slot.select('.card-slot').each(function(item_slot) {
			if (item_slot.dataset.cardId == card.dataset.cardId) {
				slot = item_slot;
			}
		});
	}

	return slot;
};

Devo.Game._returnCardFromPlayArea = function(card) {
	var card_slot = Devo.Game.getCardSlot(card);
	var c = card.remove();
	c.addClassName('medium');
	card_slot.insert({top: c});

	card_slot.select('.item-slot').each(function(p_slot) {
		if (p_slot.dataset.cardId && $('card_'+p_slot.dataset.cardId)) {
			p_slot.insert($('card_'+p_slot.dataset.cardId).remove());
		}
	});
}

Devo.Game.processEndAttack = function(data) {
	var sword_clash = $('sword-clash');
	sword_clash.removeClassName('animated flash');
	sword_clash.hide();
	if (parseInt(data.recursive) == 0) {
		Devo.Game.is_attack = false;
		$('board-cover').hide();
		$('opponent-slots-container').removeClassName('battling');
		$('player-slots-container').removeClassName('battling');
	}
	$('play-area').select('.card.creature').each(function(card) {
		if (card.dataset.cardId != data.attacking_card_id || parseInt(data.recursive) == 0) {
			Devo.Game._returnCardFromPlayArea(card);
		}
	});
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
}

Devo.Game.processReplenish = function(data) {
	data.card_updates.each(function(card) {
		var c = $('card_'+card.card_id);
		if (c) {
			if (card.hp) {
				if (card.hp.to < card.hp.from) Devo.Game.Effects.damage(c, card.hp);
				if (card.hp.to > card.hp.from) Devo.Game.Effects.getHP(c, card.hp);
			}
			if (card.ep) {
				if (card.ep.to < card.ep.from) Devo.Game.Effects.useEP(c, card.ep);
				if (card.ep.to > card.ep.from) Devo.Game.Effects.getEP(c, card.ep);
			}
		}
	});
	var gga = (data.player_id == Devo.Game.getUserId()) ? $('game-gold-amount') : $('game-gold-amount-opponent');
	var gg = (data.player_id == Devo.Game.getUserId()) ? $('game-gold') : $('game-gold-opponent');
	var cardclasses = (data.player_id == Devo.Game.getUserId()) ? '.card.player' : '.card.opponent';
	var classname = (data.gold.diff < 0) ? 'negative fadeOutUp' : 'positive fadeInDown';
	gga.update(data.gold.from+'<div class="'+classname+' diff animated">'+data.gold.diff+'</div>');
	window.setTimeout(function() {
		gga.update(data.gold.to);
		gg.dataset.amount = data.gold.to;
		$$(cardclasses).each(function(c) {
			Devo.Game.updateCardAttackAvailability(c);
		});
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}, 1000);
};

Devo.Game.processGameOver = function(data) {
	$('gameover-overlay').setStyle({opacity: 0});
	$('gameover-overlay').show();
	$('gameover-overlay').select('.winning').each(function(element) {
		$(element).hide();
	});
	window.setTimeout(function() {
		$('gameover-overlay').addClassName('animated fadeIn');
		$('winning_player_' + data.winning_player_id).show();
		window.setTimeout(function() {
			$('winning_player_' + data.winning_player_id).addClassName('animated tada');
			Devo.Game.getStatistics();
		}, 1000);
	}, 100);
	Devo.Game.destroyGameDataPoller();
	Devo.Game.destroyEventPlaybackPoller();
};

Devo.Game.processResolve = function(data) {
	$$('.card.flipped').each(function(card) {
		$(card).addClassName('animated flipOutY');
		window.setTimeout(function() {
			$(card).removeClassName('flipped');
			$(card).removeClassName('flipOutY');
			$(card).addClassName('flipInY');
			window.setTimeout(function() {
				$(card).removeClassName('flipInY');
				$(card).removeClassName('animated');
			}, 1000);
		}, 1000);
	});
};

Devo.Game.processPlayerChange = function(data) {
	Devo.Game._current_turn = data.current_turn;
	if (data.current_turn > 2) {
		if (data.current_turn == 3) {
			$('place_cards').addClassName('fadeOut');
			$('end-phase-2-button').down('.place-cards-content').hide();
			$('end-phase-2-button').down('.end-phase-content').show();
			window.setTimeout(function() {
				$('place_cards').hide();
				$('end-phase-2-button').hide();
			}, 1000);
			if (data.player_id != Devo.Game.getUserId()) {
				$('end-phase-4-button').addClassName('disabled');
				$('end-phase-4-button').show();
			}
		}
		var initial_timeout = (data.current_turn == 3) ? 2000 : 1000;
		$$('.avatar').each(function(avatar) {
			$(avatar).removeClassName('current-turn');
		});
		$('turn-info').childElements().each(function(element) {
			if (element.id == 'player-'+data.player_id+'-turn') {
				// Make the element "visible", but invisible
				window.setTimeout(function() {
					$(element).setStyle({opacity: 0});
					$(element).show();

					// Make the element fade in after a very tiny delay
					window.setTimeout(function() {
						var avatar = (data.player_id == Devo.Game.getUserId()) ? 'avatar-player' : 'avatar-opponent';
						$(avatar).addClassName('current-turn');
						$(element).addClassName('fadeIn');

						// Remove fade in effect after it is done (1.5s) and make it permanently visible
						window.setTimeout(function() {
							$(element).removeClassName('fadeIn');
							$(element).addClassName('tada');
							$(element).setStyle({opacity: 1});

							// Remove fade in effect after it is done (1.5s) and make it permanently visible
							window.setTimeout(function() {
								$(element).removeClassName('tada');
								if (data.player_id == Devo.Game.getUserId()) {
									Devo.Game.enableTurn();
								} else {
									Devo.Game.disableTurn();
								}
							}, 1000);
						}, 1000);
					}, 1000);
				}, initial_timeout);
			} else if (element.id != 'place_cards' && data.current_turn > 3) {
				// Make the element fade out
				$(element).addClassName('fadeOut');

				// Remove the fadeout effect and hide the element after the fadeout effect animation is complete (1.5s)
				window.setTimeout(function() {
					$(element).hide();
					$(element).removeClassName('fadeOut');
				}, 1000);
			}
		});
	} else {
		if (data.player_id == Devo.Game.getUserId()) {
			Devo.Game.enableTurn();
		} else {
			Devo.Game.disableTurn();
		}
	}
};

Devo.Game.processCardMovedOntoSlot = function(data) {
	if (data.current_turn <= 2) {
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}
	var card = $('card_'+data.card_id);
	var slot_no = data.slot;
	var id = (data.player_id == Devo.Game.getUserId()) ? 'player-slot-'+slot_no : 'opponent-slot-'+slot_no;
	if (data['is-item-1']) id += '-item-slot-1';
	if (data['is-item-2']) id += '-item-slot-2';
	var slot = $(id);
	if (card) {
		if ((card).dataset.slotNo != slot_no) {
			card.hide();
			card.setStyle({opacity: 0});
			card = card.remove();
			slot.insert({top: card});
			Devo.Game.Effects.cardAppear(card);
		} else {
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}
	} else if(slot_no > 0) {
		Devo.Game.getCard(data.card_id, function(json) {
			slot.insert({top: json.card});
			card = $('card_'+data.card_id);
			card.setStyle({opacity: 0});
			if (data.turn_number <= 2) card.removeClassName('flipped');
			Devo.Game.updateCardAttackAvailability(card);
			Devo.Game.Effects.cardAppear(card);
		});
	}
};

Devo.Game.processCardMovedOffSlot = function(data) {
	var card = $('card_'+data.card_id);
	var slot_no = data.slot;
	if (card) {
		if ((card).dataset.slotNo == slot_no) {
			Devo.Game.Effects.cardFade(card);
		} else {
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}
	}
};

Devo.Game.getCards = function() {
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&game_id='+Devo.Game._id+'&for=get_cards',
		success: {
			callback: function(json) {
				if (json.game.events.size() > 0) {
					json.game.events.each(function(event) {
						Devo.Game.Events.push(event);
					});
				}
			}
		}
	});
}

Devo.Game.processPhaseChange = function(data, event_id) {
	Devo.Game._current_turn = data.current_turn;
	Devo.Game._initialized_phase_change = false;
	if (data.new_phase == 4 && Devo.Game._current_turn == 2) {
		Devo.Game.getCards();
	}
	if (data.player_id == Devo.Game.getUserId() && Devo.Game._current_turn > 2) {
//		if (data.new_phase == 2 && Devo.Game._current_turn <= 2 && Devo.Game._movable == false) {
//			$('end-phase-2-button').removeClassName('disabled');
//			Devo.Game.endPhase($('end-phase-2-button'));
//			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
//			return;
//		}
		var new_phase_button = $('end-phase-'+data.new_phase+'-button');
		if (data.old_phase != 4) {
			var old_phase_button = $('end-phase-'+data.old_phase+'-button');
			old_phase_button.addClassName('animated fadeOut');
			if (data.old_phase == 3) {
				$('phase-3-actions').addClassName('animated fadeOut');
			}
		}
		window.setTimeout(function() {
			if (data.old_phase != 4) {
				$(old_phase_button).down('img').hide();
				old_phase_button.hide();
				if (data.old_phase == 3) {
					$('phase-3-actions').hide();
				}
				if (data.current_turn > 2) {
					new_phase_button.setStyle({opacity: 0});
					new_phase_button.removeClassName('disabled');
					new_phase_button.down('img').hide();
					new_phase_button.show();
					if (data.new_phase == 3) {
						$('phase-3-actions').setStyle({opacity: 0});
						$('phase-3-actions').show();
					}
				}
			}
			window.setTimeout(function() {
				if (data.old_phase != 4) {
					old_phase_button.removeClassName('animated fadeOut');
					new_phase_button.addClassName('animated fadeIn');
					if (data.current_turn > 2 || data.new_phase == 2) {
						if (data.new_phase == 3) {
							$('phase-3-actions').removeClassName('animated fadeOut');
							$('phase-3-actions').addClassName('animated fadeIn');
						}
						window.setTimeout(function() {
							new_phase_button.removeClassName('animated fadeIn');
							new_phase_button.writeAttribute('style', '');
							if (data.new_phase == 3) {
								$('phase-3-actions').removeClassName('animated fadeIn');
								$('phase-3-actions').writeAttribute('style', '');
							}
						}, 1000);
					}
					switch (data.new_phase) {
						case 2:
							if (data.current_turn > 2) {
								Devo.Game._uninitializeActions();
								window.setTimeout(function() {
									Devo.Game._movable = true;
									if (!Devo.options.candrag) {
										Devo.Game._initializeClickableCardMover();
									} else {
										Devo.Game._initializeDragDrop();
									}
									Devo.Core.Pollers.Locks.eventplaybackpoller = false;
								}, 1000);
							} else {
								Devo.Game._movable = true;
								if (!Devo.options.candrag) {
									Devo.Game._initializeClickableCardMover();
								} else {
									Devo.Game._initializeDragDrop();
								}
								Devo.Core.Pollers.Locks.eventplaybackpoller = false;
							}
							break;
						case 3:
							Devo.Game._movable = false;
							if (data.current_turn > 2) {
								Devo.Game._actions = true;
								Devo.Game._actions_remaining = 2;
								$('phase-3-actions-remaining').update(2);
							}
							Devo.Game._uninitializeDragDrop();
							Devo.Game._uninitializeClickableCardMover();
							if (data.current_turn > 2) Devo.Game._initializeActions();
							Devo.Core.Pollers.Locks.eventplaybackpoller = false;
							break;
						case 4:
							Devo.Game._actions = false;
							$('phase-3-actions-remaining').update(0);
							Devo.Game._actions_remaining = 0;
							if (data.current_turn > 2) Devo.Game._uninitializeActions();
							Devo.Core.Pollers.Locks.eventplaybackpoller = false;
							break;
						default:
							Devo.Core.Pollers.Locks.eventplaybackpoller = false;
					}
				} else {
					Devo.Core.Pollers.Locks.eventplaybackpoller = false;
				}
			}, 100);
		}, 1000);
	} else {
		if (data.new_phase == 4) {
			Devo.Game.processResolve(data);
		}
		Devo.Core.Pollers.Locks.eventplaybackpoller = false;
	}
};

Devo.Game.enableTurn = function() {
	var p4_button = $('end-phase-4-button');
	if (!p4_button) return;
	
	p4_button.addClassName('animated fadeOut');
	if (Devo.Game._current_turn > 2) {
		var p1_button = $('end-phase-1-button');
	}
	window.setTimeout(function() {
		p4_button.hide();
		p4_button.removeClassName('animated fadeOut');
		if (Devo.Game._current_turn > 2) {
			$(p1_button).down('img').hide();
			p1_button.removeClassName('disabled');
			p1_button.show();
			window.setTimeout(function() {
				$$('#player-slots .card').each(function(card) {
					if (!$(card).hasClassName('placed')) $(card).addClassName('placed');
				});
				Devo.Core.Pollers.Locks.eventplaybackpoller = false;
			}, 1000);
		} else {
			Devo.Core.Pollers.Locks.eventplaybackpoller = false;
		}
	}, 1000);
};

Devo.Game.disableTurn = function() {
	var button = $('end-phase-4-button');
	button.addClassName('disabled');
	$(button).down('img').hide();
	Devo.Game.clearCountdown();
	Devo.Core.Pollers.Locks.eventplaybackpoller = false;
};

Devo.Game._calculateDropSlots = function(card) {
	$('player-slots').addClassName('droptargets');
	if (card.up('#player_hand')) {
		$('player_stuff').addClassName('dragging');
	} else {
		if (card.hasClassName('creature')) {
			if (!card.hasClassName('placed')) {
				$('player_stuff').addClassName('droptarget');
				$('player_stuff').removeClassName('fadeOut');
			}
		} else {
			$('player_stuff').addClassName('droptarget');
			$('player_stuff').removeClassName('fadeOut');
		}
	}
};

Devo.Game.card_dragstart = function(e) {
	Devo.Game.dropped = undefined;
	Devo.Game.dragged = this.id;
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

Devo.Game._movecard = function(card, target) {
	var orig_pos = card.dataset.originalPosition;
	if (!orig_pos) {
		card.dataset.originalPosition = card.up().id;
	} else {
		$(orig_pos).dataset.cardId = 0;
	}
	var prev_slot = card.up();
	prev_slot.dataset.cardId = 0;
	if (card.hasClassName('equippable_item') && target.id != 'player_hand') {
		var e_card = target.down('.card.equippable_item');
		if (e_card) {
			if (card.dataset.slotNo) {
				e_card.dataset.slotNo = card.dataset.slotNo;
			} else {
				e_card.dataset.slotNo = 0;
			}
			prev_slot.dataset.cardId = e_card.dataset.cardId;
			var o_card = e_card.remove();
		} else {
			var o_card = card.remove();
		}
		if (o_card != undefined) {
			if (prev_slot.id == 'player_hand') {
				prev_slot.insert({bottom: o_card});
				o_card.removeClassName('medium');
			} else {
				prev_slot.insert({top: o_card});
			}
		}
	}
	var card = card.remove();
	target.insert({top: card});
	card.dataset.slotNo = target.dataset.slotNo;
	if (target.id != 'player_hand') {
		if (!card.hasClassName('medium')) {
			card.addClassName('medium');
		}
		if (card.hasClassName('item')) {
			var parent_slot = target.up('.card-slot');
			parent_slot.removeClassName('drop-denied');
			parent_slot.removeClassName('drop-hover');
			parent_slot.select('.card.creature').each(function(card) {
				Devo.Game.updateCardAttackAvailability(card);
			});
		}
		target.dataset.cardId = card.dataset.cardId;
		if ($('player_hand').childElements().size() == 0) {
			$('player_stuff').removeClassName('visible');
		}
	}
	if (target.id == 'player_hand' && card.hasClassName('medium')) card.removeClassName('medium');
	clearSelection();
};

Devo.Game.card_dragend = function(e) {
	e.preventDefault();
	$('player_stuff').removeClassName('dragging');
	$('player_stuff').removeClassName('droptarget');
	$('player-slots').removeClassName('droptargets');
	this.classList.remove('dragging');
	this.classList.remove('medium');
	if (Devo.Game.dropped) {
		var card = $(this);
		var dropped = $(Devo.Game.dropped);
		if (Devo.Game.getCardSlot(card)) {
			[1,2].each(function(cc) {
				var islot = $(Devo.Game.getCardSlot(card).id+'-item-slot-'+cc);
				if (islot) {
					var icard = islot.down('.card.equippable_item');
					if (icard) Devo.Game._movecard(icard, $(dropped.id+'-item-slot-'+cc));
				}
			})
		}
		Devo.Game._movecard(card, dropped);
	}
};

Devo.Game.cardslot_dragover = function(e) {
	e.dataTransfer.dropEffect = 'move';
	var card_id = Devo.Game.dragged;
	var slot = $(this);
	var card = $(card_id);
	var hovered = false;
	if (card.hasClassName('creature') && slot.hasClassName('creature-slot')) {
		if (this.id == 'player_stuff') {
			if (card.hasClassName('placed')) {
				slot.addClassName('denied');
				hovered = true;
			} else {
				hovered = true;
				slot.addClassName('peek');
				e.preventDefault();
			}
		} else if (slot.hasClassName('player') && !slot.down('.card')) {
			hovered = true;
			slot.addClassName('drop-hover');
			e.preventDefault();
		}
	} else if (card.hasClassName('item') && slot.hasClassName('creature-slot')) {
		hovered = true;
	} else if (card.hasClassName('item') && slot.hasClassName('item-slot')) {
		if (this.id == 'player_stuff') {
			hovered = true;
			slot.addClassName('peek');
			e.preventDefault();
		} else {
			var parent_slot = slot.up('.card-slot');
			var slot_card = parent_slot.down('.card.creature');
			var existing_attack_items = parent_slot.select('.item-attack').size();
			var existing_defend_items = parent_slot.select('.item-defend').size();
			var eq_both = false;
			if (slot_card) {
				slot_card.down('.attacks').childElements().each(function(attack) {
					if (attack.dataset.requiresEquippableBoth != undefined) eq_both = true;
				});
				if ((slot_card.hasClassName('class-civilian') && card.dataset.equippableByCivilian == 'true') ||
				(slot_card.hasClassName('class-magic') && card.dataset.equippableByMagic == 'true') ||
				(slot_card.hasClassName('class-military') && card.dataset.equippableByMilitary == 'true') ||
				(slot_card.hasClassName('class-physical') && card.dataset.equippableByPhysical == 'true') ||
				(slot_card.hasClassName('class-ranged') && card.dataset.equippableByRanged == 'true')) {
					if (!(existing_attack_items + existing_defend_items == 0 && slot.dataset.itemSlotNo == 2)) {
						if (((card.hasClassName('item-attack') && existing_attack_items == 0) || eq_both) ||
							(card.hasClassName('item-defend') && existing_defend_items == 0)) {
							hovered = true;
							slot.addClassName('drop-hover');
							parent_slot.removeClassName('drop-denied');
							e.preventDefault();
						}
					}
				}
			}
		}
	}
	if (hovered == false) {
		slot.addClassName('drop-denied');
	}
};

Devo.Game.cardslot_dragleave = function(e) {
	this.classList.remove('drop-hover');
	this.classList.remove('drop-denied');
	this.classList.remove('peek');
	this.classList.remove('denied');
};

Devo.Game.cardslot_drop = function(e) {
	e.stopPropagation();
	e.preventDefault();
	this.classList.remove('drop-denied');
	this.classList.remove('peek');
	if (!$(this).hasClassName('drop-hover') && !$(this).hasClassName('droptarget')) {
		return;
	}
	this.classList.remove('drop-hover');
	Devo.Game.dropped = (this.id == 'player_stuff') ? 'player_hand' : this.id;
};

Devo.Game.toggleActionCard = function(event) {
	if (this.up('.card-slot').hasClassName('targetted') || this.hasClassName('effect-stun')) return;
	if (!this.hasClassName('selected')) {
		$('player-slots').select('.card').each(function(card) {
			if (!$(card).hasClassName('medium') && card.id != this.id) {
				$(card).removeClassName('selected');
				$(card).addClassName('medium');
			}
		});
		this.addClassName('selected');
		this.removeClassName('medium');
	} else {
		this.addClassName('medium');
		this.removeClassName('selected');
	}
}

Devo.Game.checkAttackAvailability = function(card, attack) {
	var ga = (card.hasClassName('player')) ? Devo.Game.getGoldAmount() : Devo.Game.getGoldAmountOpponent();
	if (card.hasClassName('creature')) {
		return (card.hasClassName('placed') && ga >= parseInt(attack.dataset.costGold) && parseInt(card.dataset.ep) >= parseInt(attack.dataset.costEp)) ? true : false;
	} else {
		return attack.hasClassName('potion');
	}
}

Devo.Game.enableEndActionsTimer = function() {
	if (!$('game-countdown').visible()) {
		$('game-countdown').removeClassName('enabled');
		$('game-countdown').show();
		window.setTimeout(function() {
			$('game-countdown').addClassName('enabled');
			$('game-countdown').dataset.timeoutId = window.setTimeout(function() {
				if ($('end-phase-3-button').visible()) {
					Devo.Game.endPhase($('end-phase-3-button'));
				}
			}, 5000);
		}, 100);
	}
};

Devo.Game.performAttack = function(event) {
	var attacked_card_id = (this.hasClassName('game-gold')) ? 0 : this.down('.card.creature').dataset.cardId;
	var attack = $(Devo.Game._currentattack);
	var card = $(attack).up('.card');
	if (Devo.Game.checkAttackAvailability(card, attack)) {
		event.stopPropagation();
		Devo.Game.unhighlightTargets();
		if (card.hasClassName('creature')) {
			$('board-cover').show();
			Devo.Game._addCardToPlayArea(card);
			Devo.Game.Effects.useGold({from: Devo.Game.getGoldAmount(), diff: parseInt(attack.dataset.costGold), to: Devo.Game.getGoldAmount() - parseInt(attack.dataset.costGold)}, 'player');
			Devo.Game.Effects.useEP(card, {from: parseInt(card.dataset.ep), diff: parseInt(attack.dataset.costEp), to: parseInt(card.dataset.ep) - parseInt(attack.dataset.costEp)});
		} else if (card.hasClassName('potion_item')) {
			$('player_potions').removeClassName('visible');
		}
		var extraparams = (card.hasClassName('creature')) ? '&topic=attack&attack_id='+attack.dataset.attackId : '&topic=potion';
		Devo.Main.Helpers.ajax(Devo.options['say_url'], {
			additional_params: '&game_id='+Devo.Game._id+extraparams+'&attacked_card_id='+attacked_card_id+'&card_id='+card.dataset.cardId,
			failure: {
				callback: function(json) {
					Devo.Game.Effects.getGold({from: Devo.Game.getGoldAmount(), diff: parseInt(attack.dataset.costGold), to: Devo.Game.getGoldAmount() + parseInt(attack.dataset.costGold)}, 'player');
					Devo.Game.Effects.getEP(card, {from: parseInt(card.dataset.ep), diff: parseInt(attack.dataset.costEp), to: parseInt(card.dataset.ep) + parseInt(attack.dataset.costEp)});
				}
			},
			success: {
				callback: function(json) {
					if (json && json.deleted == 1) {
						card.remove();
					}
				}
			}
		});
	} else {
		Devo.Game.updateCardAttackAvailability(card);
	}
};

Devo.Game.highlightTargets = function(attack) {
	if ($('end-phase-3-button').visible()) $('end-phase-3-button').addClassName('disabled');
	attack.addClassName('attacking');
	if (attack.hasClassName('potion')) $('player_potions').addClassName('active');
	var selector = '';
	if (attack.dataset.isStealAttack != undefined) {
		$('game-gold-opponent').addClassName('targetted');
		$('game-gold-opponent').observe('click', Devo.Game.performAttack);
	} else if (attack.dataset.isForageAttack != undefined) {
		$('game-gold').addClassName('targetted');
		$('game-gold').observe('click', Devo.Game.performAttack);
	} else {
		if (attack.hasClassName('potion')) {
			selector = '#player-slots';
		} else {
			selector = (attack.dataset.isBonusAttack != undefined) ? '#player-slots' : '#opponent-slots';
		}

		$$(selector).each(function(sel) {
			$(sel).select('.card-slot.creature-slot').each(function(slot) {
				if (slot.down('.card')) {
					$(slot).addClassName('targetted');
					$(slot).observe('click', Devo.Game.performAttack);
				}
			});
		});
	}
};

Devo.Game.unhighlightTargets = function() {
	if (Devo.Game._currentattack) {
		$('end-phase-3-button').removeClassName('disabled');
		$$('.card-slot, .game-gold').each(function(slot) {
			$(slot).removeClassName('targetted');
			$(slot).stopObserving('click', Devo.Game.performAttack);
		});
		$$('.card.player').each(function(card) {
			$(card).select('.attack').each(function(a) {
				$(a).removeClassName('temp_disabled');
			});
		});
		$(Devo.Game._currentattack).removeClassName('attacking');
		if ($(Devo.Game._currentattack).hasClassName('potion')) $('player_potions').removeClassName('active');
		Devo.Game._currentattack = null;
	}
};

Devo.Game._escapeWatcher = function(event) {
	if (Event.KEY_ESC != event.keyCode) return;
	Devo.Game.unhighlightTargets();
};

Devo.Game.initiateAttack = function(event) {
	if (Devo.Game._currentattack && Devo.Game._currentattack == this.id) {
		Devo.Game.unhighlightTargets();
		event.stopPropagation();
	} else if (!this.hasClassName('temp_disabled')) {
		event.stopPropagation();
		Devo.Game._currentattack = this.id;
		Devo.Game.highlightTargets(this);
		$$('.card.player').each(function(card) {
			if (card.hasClassName('selected')) {
				card.removeClassName('selected');
				card.addClassName('medium');
			}
			$(card).select('.attack').each(function(a) {
				if (a.id != Devo.Game._currentattack) {
					$(a).addClassName('temp_disabled');
				}
			});
		});
	}
}

Devo.Core._blinkTitle = function() {
	document.title = Devo.Core._isOldTitle ? Devo.options.title : Devo.options.alternate_title;
	Devo.Core._isOldTitle = !Devo.Core._isOldTitle;
};

Devo.Core._stopBlinkTitle = function() {
	Devo.Core._infocus = true;
	clearInterval(Devo.Core._titleBlinkInterval);
	document.title = Devo.options.title;
};

Devo.Game._initializeMusic = function() {
    var myAudio = document.createElement('audio'); 
    
    if (myAudio.canPlayType) {
       var canPlayMp3 = !!myAudio.canPlayType && "" != myAudio.canPlayType('audio/mpeg');
       var canPlayOgg = !!myAudio.canPlayType && "" != myAudio.canPlayType('audio/ogg; codecs="vorbis"');
    }
	Devo.Game._music = new Audio("/sounds/bgm." + ((canPlayMp3) ? 'mp3' : 'ogg'));
	Devo.Game._music.volume = 0.1;
	Devo.Game._music.loop = true;
	Devo.Game._music.play();
};

Devo.Game._uninitializeMusic = function() {
	if (Devo.Game._music && Devo.Game._music.play) {
		Devo.Game._music.pause();
	}
	Devo.Game._music = null;
}

Devo.Core.detectFullScreenSupport = function() {
	var docElm = document.documentElement;
	if (docElm.requestFullscreen) return true;
	if (docElm.mozRequestFullScreen) return true;
	if (docElm.webkitRequestFullScreen) return true;
	
	return false;
}

Devo.Core.toggleFullscreen = function() {
	var docElm = document.documentElement;
	if (docElm.requestFullscreen) {
		(document.fullScreen) ? document.cancelFullscreen() : docElm.requestFullscreen();
	}
	else if (docElm.mozRequestFullScreen) {
		(document.mozFullScreen) ? document.mozCancelFullScreen() : docElm.mozRequestFullScreen();
	}
	else if (docElm.webkitRequestFullScreen) {
		(document.webkitIsFullScreen) ? document.webkitCancelFullScreen() : docElm.webkitRequestFullScreen();
	}
};

Devo.Game.destroyOpponentAvatar = function() {
	var avatar = $('avatar-opponent');
	avatar.setStyle({backgroundImage: ""});
	avatar.hide();
}

Devo.Game.loadOpponentAvatar = function(game_id) {
	var avatar = $('avatar-opponent');
	if (avatar.visible()) return;

	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=opponent_avatar&game_id='+game_id,
		success: {
			callback: function(json) {
				avatar.setStyle({backgroundImage: "url('"+json.avatar_url+"')"});
				avatar.show();
				avatar.stopObserving('click');
				avatar.observe('click', function() { Devo.Main.Profile.show(json.opponent_id); });
			}
		}
	});
}

Devo.Game.loadGameTopMenu = function(game_id, cb) {
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=game_topmenu&game_id='+game_id,
		success: {
			callback: function(json) {
				if ($('ingame-menu-top')) $('ingame-menu-top').remove();
				$('board-container').insert({top: json.menu});
				cb();
			}
		}
	});
};

Devo.Game.initializeCardPicker = function(options) {
	var game_id = options.game_id;
	$('game-content-container').dataset.location = '#!game/'+game_id;
	window.location.hash = "!game/"+game_id;
	Devo.Main.Helpers.loading();
	Devo.Main.initializeLobby();
	Devo.Game._id = game_id;
	Devo.Game._min_creature_cards = options.min_creature_cards;
	Devo.Game._max_creature_cards = options.max_creature_cards;
	Devo.Game._min_item_cards = options.min_item_cards;
	Devo.Game._max_item_cards = options.max_item_cards;
	Devo.Game._min_cards = options.min_cards;
	Devo.Game._max_cards = options.max_cards;
	if ($('chat_1_container').visible()) {
		Devo.Game.toggleChat(1);
	}
	if (options.room_id > 0) {
		Devo.Game._initializeGameChat(options.room_id);
	}
	$('profile-menu-strip').addClassName('in-game');
	Devo.Game.loadOpponentAvatar(game_id);
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=game_interface&part=cardpicker&game_id='+game_id,
		success: {
			callback: function(json) {
				if (json.is_started == 1) {
					Devo.Game.initializeGame(game_id);
					Devo.Main.Helpers.finishLoading();
				} else {
					Devo.Main.setGameInterfacePart(json, Devo.Main.Helpers.finishLoading);
				}
			}
		}
	});
};

Devo.Game.initializeGame = function(game_id) {
	$('game-content-container').dataset.location = '#!game/'+game_id;
	window.location.hash = "!game/"+game_id;
	Devo.Main.Helpers.loading();
	if ($('chat_1_container').visible()) {
		Devo.Game.toggleChat(1);
	}
	$('profile-menu-strip').addClassName('in-game');
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=game_interface&part=board&game_id='+game_id,
		success: {
			callback: function(json) {
				if (json.state && json.state == 'no_cards') {
					Devo.Game.loadOpponentAvatar(game_id);
					Devo.Game.initializeCardPicker(json.options);
					Devo.Main.Helpers.finishLoading();
				} else if (json.options) {
					Devo.Game.loadOpponentAvatar(game_id);
					Devo.Main.setGameInterfacePart(json, function() {
						Devo.Game._initialize(json.options);
						Devo.Main.Helpers.finishLoading();
					});
				} else {
					Devo.Main.loadLobby();
					Devo.Main.Helpers.finishLoading();
				}
			}
		}
	});
};

Devo.Game.destroyGame = function() {
	Devo.Main.Helpers.loading();
	Devo.Game._id = undefined;
	Devo.Game._latest_event_id = undefined;
	Devo.Game._current_turn = undefined;
	Devo.Game._current_phase = undefined;
	Devo.Game._current_player_id = undefined;
	Devo.Game._movable = undefined;
	Devo.Game._actions = undefined;
	Devo.Game._actions_remaining = undefined;
	Devo.Game._music_enabled = undefined;
	Devo.Game.destroyGameDataPoller();
	Devo.Game.destroyEventPlaybackPoller();
	Devo.Chat.destroyBubblePoller();
	Devo.Game._uninitializeDragDrop();
	Devo.Game._uninitializeClickableCardMover();
	Devo.Game._uninitializeActions();
	Devo.Game._uninitializeMusic();
	if (Devo.Game._room_id > 0) {
		Devo.Game._uninitializeGameChat(Devo.Game._room_id);
	}
	Devo.Game.destroyOpponentAvatar();
	$('profile-menu-strip').removeClassName('in-game');
	$('ui').removeClassName('in-play');
	if ($('ingame-menu-top')) $('ingame-menu-top').remove();
	Devo.Main.Helpers.finishLoading();
}

Devo.Game._initialize = function(options) {
	Devo.Game._id = options.game_id;
	Devo.Game.loadGameTopMenu(options.game_id, function() {
		$('toggle-hand-button').observe('click', Devo.Game.toggleHand);
		$('toggle-potions-button').observe('click', Devo.Game.togglePotions);
		Devo.Game._room_id = options.room_id;
		if (options.room_id > 0) {
			Devo.Game._initializeGameChat(options.room_id);
		}
		Devo.Game._latest_event_id = options.latest_event_id;
		Devo.Game._current_turn = options.current_turn;
		Devo.Game._current_phase = options.current_phase;
		Devo.Game._current_player_id = options.current_player_id;
		Devo.Game._movable = (options.movable == 'true');
		Devo.Game._actions = options.actions;
		Devo.Game._user_level = options.user_level;
		Devo.Game._user_level_opponent = options.user_level_opponent;
		Devo.Game._actions_remaining = options.actions_remaining;
		Devo.Game._music_enabled = (options.music_enabled == 'true');
		Devo.Game._initializeGameDataPoller();
		Devo.Game._initializeCards();
		Devo.Core._initializeChatRoomPoller();
		Devo.Game._initialized_phase_change = false;
		if (Devo.Game._music_enabled) {
			Devo.Game._initializeMusic();
		}
		if (Devo.Game._current_player_id == Devo.Game.getUserId()) {
			$('avatar-player').addClassName('current-turn');
		} else {
			$('avatar-opponent').addClassName('current-turn');
		}
		if (Devo.Game._current_player_id == Devo.Game.getUserId() && Devo.Game._current_turn > 2) {
			if (Devo.Game._current_phase == 3 && Devo.Game._actions_remaining == 0) {
				Devo.Game.enableEndActionsTimer();
			} else if (Devo.Game._current_phase == 4) {
				Devo.Game.enableEndTurnTimer();
			}
		}
		document.observe('keydown', Devo.Game._escapeWatcher);
		document.body.addEventListener('touchmove', function(event) {event.preventDefault();}, false);
	});
};

Devo.Game.toggleHand = function() {
	$('player_stuff').toggleClassName('visible');
	$('player_potions').removeClassName('visible');
};

Devo.Game.togglePotions = function() {
	$('player_stuff').removeClassName('visible');
	$('player_potions').toggleClassName('visible');
};

Devo.Game.toggleEvents = function() {
	if ($('game_events')) {
		if ($('game_events').hasClassName('visible')) {
			$('game_events').toggleClassName('fadeIn');
			$('game_events').toggleClassName('fadeOut');
			window.setTimeout( function() {
				$('game_events').toggleClassName('visible');
			}, 1000);
		} else {
			$('game_events').toggleClassName('visible');
			window.setTimeout( function() {
				$('game_events').toggleClassName('fadeIn');
				$('game_events').toggleClassName('fadeOut');
			}, 100);
		}
	}
};

Devo.Game.clearCountdown = function() {
	var tid = $('game-countdown').dataset.timeoutId;
	if (tid) {
		window.clearTimeout(tid);
		$('game-countdown').hide();
		$('game-countdown').removeClassName('enabled');
		$('game-countdown').removeClassName('slow');
	}
	if (Devo.Game._endTurnExecuter != undefined && Devo.Game._endTurnExecuter.stop) {
		Devo.Game._endTurnExecuter.stop();
	}
};

Devo.Game.enableEndTurnTimer = function() {
	$('game-countdown').show();
	window.setTimeout(function() {
		$('game-countdown').addClassName('enabled');
		$('game-countdown').addClassName('slow');
		$('game-countdown').dataset.timeoutId = window.setTimeout(function() {
			Devo.Game._endTurnExecuter = new PeriodicalExecuter(function(pe) {
				if (!$('end-phase-4-button')) {
					pe.stop();
				}
				if ($('end-phase-4-button').visible()) {
					Devo.Game.endPhase($('end-phase-4-button'));
					pe.stop();
				}
			}, 0.3);
		}, 10000);
	}, 100);
};

Devo.Game.endPhase = function(button) {
	if (!$(button).hasClassName('disabled') || override == true) {
		Devo.Game._initialized_phase_change = true;
		Devo.Game.clearCountdown();
		Devo.Core.Pollers.Locks.gamedatapoller = false;
		var params = '&topic=end_phase&game_id='+Devo.Game._id;
		if (Devo.Game._movable) {
			Devo.Game._uninitializeDragDrop();
			Devo.Game._uninitializeClickableCardMover();
			for (var cc = 1; cc <= 5; cc++) {
				var p = $('player-slot-'+cc);
				var pi1 = $('player-slot-'+cc+'-item-slot-1');
				var pi2 = $('player-slot-'+cc+'-item-slot-2');
				params += '&slots['+cc+'][card_id]='+p.dataset.cardId+'&slots['+cc+'][powerupcard1_id]='+pi1.dataset.cardId+'&slots['+cc+'][powerupcard2_id]='+pi2.dataset.cardId;
			}
			if (Devo.Game._current_turn <= 2) {
				$('end-phase-2-button').down('.place-cards-content').update('Waiting...');
			}
			$('player_stuff').removeClassName('visible');
		} else if (Devo.Game._actions) {
			$('player-slots').select('.card.player').each(function(card) {
				if (!$(card).hasClassName('medium')) $(card).addClassName('medium');
			});
			if (Devo.Game._current_turn > 2) {
				Devo.Game.enableEndTurnTimer();
			}
		}
		Devo.Main.Helpers.ajax(Devo.options['say_url'], {
			additional_params: params,
			loading: {
				callback: function() {
					$(button).down('img').show();
					$(button).addClassName('disabled');
				}
			}
		});
	}
};

Devo.Game.getStatistics = function() {
	if ($('game_statistics_indicator') == undefined) return;
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=game_stats&game_id='+Devo.Game._id,
		loading: {indicator: 'game_statistics_indicator'},
		success: {
			callback: function(json) {
				$('statistics_hp').update(json.stats.hp);
				$('statistics_cards').update(json.stats.cards);
				if (json.stats.gold != undefined) $('statistics_gold').update(json.stats.gold);
				if (json.stats.xp != undefined) $('statistics_xp').update(json.stats.xp);
				if (json.stats.scenario != undefined) {
					$('goto-lobby-button').hide();
					$('goto-adventure-button').show();
				} else {
					$('goto-lobby-button').show();
					$('goto-adventure-button').hide();
				}
				$('goto-buttons-container').show();
				$('game_statistics').show();
			}
		}
	});
};

Devo.Main.showCardDetails = function(card_id, check_actions) {
	var card = $('card_'+card_id);
	var cards = $$('.card');
	$$('.card_details').each(function(element) {$(element).hide();});
	if (card.hasClassName('selected')) {
		card.removeClassName('selected');
		cards.each(function(element) {$(element).removeClassName('faded');});
	} else {
		cards.each(function(element) {$(element).addClassName('faded');$(element).removeClassName('selected');});
		card.removeClassName('faded');
		$('card_'+card_id).addClassName('selected');
		var ca = $('card_'+card_id+'_details');
		ca.show();
	}
};

Devo.Play.pickCardToggle = function(card_id) {
	var card = $('card_'+card_id);
	var faction = card.dataset.faction;
	if (card.hasClassName('creature') && faction != 'world') {
		$$('.card.creature').each(function(c_card) {
			if (c_card.dataset.faction != faction && c_card.dataset.faction != 'world') {
				$('picked_card_' + c_card.dataset.cardId).setValue(0);
				c_card.removeClassName('selected');
			}
		});
	}
	var num_creature_cards = $$('.card.creature.selected').size();
	var num_item_cards = $$('.card.item.selected').size();
	var num_cards = num_creature_cards + num_item_cards;
	if (card.hasClassName('selected')) {
		$('picked_card_' + card_id).setValue(0);
		card.toggleClassName('selected');
	} else {
		if (((card.hasClassName('creature') && num_creature_cards < Devo.Game._max_creature_cards) ||
			(card.hasClassName('item') && num_item_cards < Devo.Game._max_item_cards)) &&
			num_cards < Devo.Game._max_cards) {
			$('picked_card_' + card_id).setValue(1);
			card.toggleClassName('selected');
		}
	}
	window.setTimeout(function() {
		var num_creature_cards = $$('.card.creature.selected').size();
		var num_item_cards = $$('.card.item.selected').size();
		var num_cards = num_creature_cards + num_item_cards;
		$$('input[type=submit].play-button').each(function(element) {
			$(element).disable();
			if (num_creature_cards >= Devo.Game._min_creature_cards &&
				num_creature_cards <= Devo.Game._max_creature_cards &&
				num_item_cards >= Devo.Game._min_item_cards &&
				num_item_cards <= Devo.Game._max_item_cards &&
				num_cards >= Devo.Game._min_cards &&
				num_cards <= Devo.Game._max_cards) {
				$(element).enable();
			}
		});
		$('picked-all-cards').update(num_cards);
		$('picked-creature-cards').update(num_creature_cards);
		$('picked-item-cards').update(num_item_cards);
	}, 200);
};

Devo.Play.quickmatch = function() {
	$('quickmatch_overlay').show();
	$('quickmatch_overlay').addClassName('loading');
	$('cancel_quickmatch_button').setStyle({opacity: 0});
	window.setTimeout(function() {
		$('cancel_quickmatch_button').addClassName('animated fadeIn');
		window.setTimeout(function() {
			$('cancel_quickmatch_button').setStyle({opacity: 1});
			$('cancel_quickmatch_button').removeClassName('animated fadeIn');
		}, 2000);
	}, 5000);
	Devo.Core._initializeQuickmatchPoller();
}

Devo.Play.training = function(level) {
	Devo.Main.Helpers.loading();
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=training&level='+level,
		success: {
			callback: function(json) {
				if (json.options && json.options.game_id) {
					Devo.Game.initializeCardPicker(json.options);
				}
			}
		},
		complete: {
			callback: function(json) {
				Devo.Main.Helpers.finishLoading();
			}
		}
	});
}

Devo.Main.filterCards = function(card_class) {
	$('card-category-button').dataset.selectedFilter = card_class;
	$$('.shelf').each(function(shelf) {
		shelf.select('.card').each(function(card) {
			if (card.hasClassName(card_class)) {
				card.up('li').show();
			} else {
				card.up('li').hide();
			}
		});
	});
	var race_button = $('card-race-button');
	var itemclass_button = $('card-itemclass-button');
	race_button.hide();
	itemclass_button.hide();
	if (card_class == 'creature') {
		var race_popup = $('card-race-popup');
		var first_race = (Devo.Main._default_race_filter != undefined) ? Devo.Main._default_race_filter : race_popup.down('ul').childElements()[0].down('a').dataset.filter;
		var visible_cards = Devo.Main.filterCardsRace(first_race);
		if (visible_cards == 0) {
			var second_race = race_popup.down('ul').childElements()[1].down('a').dataset.filter;
			visible_cards = Devo.Main.filterCardsRace(second_race);
		}
		race_button.show();
	} else if (card_class == 'equippable_item') {
		var itemclass_popup = $('card-itemclass-popup');
		var first_itemclass = (Devo.Main._default_itemclass_filter != undefined) ? Devo.Main._default_itemclass_filter : itemclass_popup.down('ul').childElements()[0].down('a').dataset.filter;
		var visible_cards = Devo.Main.filterCardsItemClass(first_itemclass);
		if (visible_cards == 0) {
			var second_itemclass = itemclass_popup.down('ul').childElements()[1].down('a').dataset.filter;
			visible_cards = Devo.Main.filterCardsItemClass(second_itemclass);
		}
		itemclass_button.show();
	} else {
		Devo.Main.Helpers.popup();
	}
	$$('.shelf-filter .button').each(function(button) {
		if (button.dataset.filter == card_class) {
			button.addClassName('button-pressed');
		} else {
			button.removeClassName('button-pressed');
		}
	});
}

Devo.Market.getUserGold = function() {
	return parseInt(Devo._user_gold);
};

Devo.Market.checkCardActions = function(card) {
	var card_id = card.dataset.cardId;
	if ($('card_'+card_id+'_details')) {
		if ($('buy_card_'+card_id)) {
			if (card.dataset.cost > Devo.Market.getUserGold()) {
				$('buy_card_'+card_id).hide();
			} else {
				$('buy_card_'+card_id).show();
			}
		}
	}
};

Devo.Market.dontBuy = function() {
	$('buy-popup').hide();
}

Devo.Market.dismissBuyComplete = function() {
	$('buy-complete').hide();
}

Devo.Market.dismissSellComplete = function() {
	$('user-top-details').insert({top: $('user-gold').remove()});
	$('sell-complete').hide();
}

Devo.Market.Effects.useGold = function(cost) {
	var gg = $('user-gold-amount');
	var ggb = $('user-gold-amount-buy');
	var gold = parseInt(gg.innerHTML);
	$('user-gold').dataset.amount = cost.to;
	Devo._user_gold = cost.to;
	$$('.card').each(function(card) {
		if (card.visible()) {
			Devo.Market.checkCardActions(card);
		}
	});

	if (gold != cost.to) {
		ggb.update(gold+'<div class="negative fadeOutUp diff animated">'+cost.diff+'</div>');
		gg.update(cost.to);
		window.setTimeout(function() {
			ggb.update(cost.to);
		}, 1000);
	}
}

Devo.Market.Effects.getGold = function(cost) {
	var gg = $('user-gold-amount');
	var ggb = $('user-gold-amount-buy');
	var gold = parseInt(gg.innerHTML);
	$('user-gold').dataset.amount = cost.to;
	Devo._user_gold = cost.to;

	if (gold != cost.to) {
		ggb.update(gold+'<div class="positive fadeInDown diff animated">'+cost.diff+'</div>');
		gg.update(cost.to);
		window.setTimeout(function() {
			ggb.update(cost.to);
		}, 1000);
	}
}

Devo.Market.buy = function() {
	var card_id = $('buy-popup').dataset.cardId;
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=buy_card&card_id='+card_id,
		loading: {
			callback: function() {
				$$('buy-buttons').each(Element.hide);
				$('buy-indicator').show();
			}
		},
		success: {
			callback: function(json) {
				$('buy-complete').select('.card').each(function (existing_card) {
					existing_card.remove();
				});
				$('buy-popup').select('.card').each(function (existing_card) {
					$('buy-complete-description').insert({before: existing_card.remove()});
				});
				$('buy-complete').show();
				$('buy-popup').hide();
				window.setTimeout(function() {
					Devo.Market.Effects.useGold(json.cost);
				}, 500);
			}
		},
		complete: {
			callback: function() {
				$('buy-indicator').hide();
			}
		}
	});
};

Devo.Market.sell = function() {
	var card_id = $('sell-popup').dataset.cardId;
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=sell_card&card_id='+card_id,
		loading: {
			callback: function() {
				$('sell-popup').select('buy-button').each(Element.hide);
				$('sell-indicator').show();
			}
		},
		success: {
			callback: function(json) {
				$('sell-complete').select('.card').each(function (existing_card) {
					existing_card.remove();
				});
				Devo.Main.showCardDetails(card_id, true);
				$('card_'+card_id).remove();
				$('card_'+card_id+'_details').remove();
				$('sell-complete-description').insert({top: $('user-gold').remove()});
				$('sell-popup').select('.card').each(function (existing_card) {
					$('sell-complete-description').insert({before: existing_card.remove()});
				});
				$('sell-complete').show();
				$('sell-popup').hide();
				window.setTimeout(function() {
					Devo.Market.Effects.getGold(json.cost);
				}, 500);
			}
		},
		complete: {
			callback: function() {
				$('sell-indicator').hide();
			}
		}
	});
};

Devo.Market.toggleBuy = function(card_id) {
	var card = $('card_' + card_id);
	var cost = card.dataset.cost;
	var card_clone = card.clone(true);
	card_clone.id = card.id + '_clone';
	card_clone.removeClassName('medium');
	$('buy-popup').select('.card').each(function (existing_card) {
		existing_card.remove();
	});
	$('buy-popup').dataset.cardId = card_id;
	$('market-buy-disclaimer').insert({before: card_clone});
	$('buy-popup-cost').update(cost);
	$('buy-popup-cost').dataset.cost = cost;
	$$('buy-buttons').each(Element.show);
	$('buy-popup').show();
}

Devo.Market.toggleSell = function(card_id) {
	var card = $('card_' + card_id);
	var cost = card.dataset.cost;
	var card_clone = card.clone(true);
	card_clone.id = card.id + '_clone';
	card_clone.removeClassName('medium');
	$('sell-popup').select('.card').each(function (existing_card) {
		existing_card.remove();
	});
	$('sell-popup').dataset.cardId = card_id;
	$('sell-disclaimer').insert({before: card_clone});
	$('sell-popup-cost').update('<img src="/images/spinning_16.gif">');
	$('sell-popup').dataset.cost = 0;
	$('sell-popup').select('buy-button').each(function(b) {
		b.show();
		b.disable();
	});
	Devo.Market.getPrice(card_id);
	$('sell-popup').show();
}

Devo.Market.getPrice = function(card_id) {
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=card_price&card_id='+card_id,
		success: {
			callback: function(json) {
				$('sell-popup-cost').update(json.cost);
				$('sell-popup').dataset.cost = parseInt(json.cost);
			}
		}
	});
};

Devo.Main.Profile.getLevelupCard = function() {
	var card_id = $('levelup-popup').dataset.cardId;
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		additional_params: '&for=levelledup_card&card_id='+card_id,
		loading: {
			indicator: 'levelup-indicator'
		},
		success: {
			callback: function(json) {
				if (json.card) $('card_'+card_id+'_clone').insert({after: json.card});
				if (json.xp_card && json.xp_attacks) {
					var xpc = parseInt(json.xp_card);
					var xpa = parseInt(json.xp_attacks);
					var xp = parseInt(json.user_xp);
					$('levelup-cost-both').update(xpc + xpa);
					(xp < xpc + xpa) ? $('levelup-both-button').addClassName('disabled') : $('levelup-both-button').removeClassName('disabled');
					$('levelup-cost-attacks').update(xpa);
					(xp < xpa) ? $('levelup-attacks-button').addClassName('disabled') : $('levelup-attacks-button').removeClassName('disabled');
					$('levelup-cost-card').update(xpc);
					(xp < xpc) ? $('levelup-card-button').addClassName('disabled') : $('levelup-card-button').removeClassName('disabled');
				}
			}
		}
	});
};

Devo.Main.Profile.levelUp = function(mode) {
	var card_id = $('levelup-popup').dataset.cardId;
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		additional_params: '&topic=levelup_card&card_id='+card_id+'&mode='+mode,
		loading: {
			indicator: 'levelup-indicator',
			callback: function() {
				$('levelup-popup').down('.levelup-buttons').hide();
			}
		},
		success: {
			callback: function(json) {
				if (json.levelup == 'ok') {
					$('card_'+card_id+'_clone').remove();
					$('card_'+card_id+'_levelup').remove();
					$('levelup-popup').down('.pointer').remove();
					$('levelup-disclaimer').insert({after: json.card_clone});
					window.setTimeout(function() {
						var card = $('card_'+card_id+'_clone');
						card.addClassName('restore_properties restore_health');
						$('levelup-popup').down('.levelup-complete').show();
					}, 100);
					var card_container = $('card_'+card_id+'_container');
					card_container.update(json.card);
					Devo.Main.Profile.setLevel(json.level);
					Devo.Main.Profile.setXp(json.xp);
				}
			}
		}
	});
};

Devo.Main.Profile.toggleLevelup = function(card_id) {
	var card = $('card_' + card_id);
	var card_clone = card.clone(true);
	card_clone.id = card.id + '_clone';
	card_clone.removeClassName('medium');
	card_clone.addClassName('cloned');
	$('levelup-popup').select('.card,.pointer').each(function (existing_card) {
		existing_card.remove();
	});
	$('levelup-popup').dataset.cardId = card_id;
	$('levelup-disclaimer').insert({after: '<img src="/images/glyph-levelup-gold.png" class="pointer">'});
	$('levelup-disclaimer').insert({after: card_clone});
	$('levelup-popup').down('.levelup-complete').hide();
	$('levelup-popup').down('.levelup-buttons').show();
	$('levelup-popup').show();
	Devo.Main.Profile.getLevelupCard();
}

Devo.Main.Profile.dontLevelUp = function() {
	$('levelup-popup').hide();
}

Devo.Main.filterCardsRace = function(race) {
	var race_button = $('card-race-button');
	var visible_cards = 0;
	var card_type = $('card-category-button').dataset.selectedFilter;
	$('shelf-loading').show();
	$$('.shelf').each(function(shelf) {
		shelf.select('.card').each(function(card) {
			if (card.hasClassName(card_type) && card.hasClassName(race)) {
				card.up('li').show();
				visible_cards++;
				if ($('market-container')) Devo.Market.checkCardActions(card);
			} else {
				card.up('li').hide();
			}
		});
	});
	var race_popup = $('card-race-popup');
	race_popup.down('ul').childElements().each(function(list_item) {
		var link = list_item.down('a');
		if (link.dataset.filter == race) {
			race_button.update(link.innerHTML + '<span class="dropdown-triangle">&#9660;</span>');
		}
	})
	Devo.Main._default_race_filter = race;
	Devo.Main.Helpers.popup();
	$('shelf-loading').hide();
	return visible_cards;
}

Devo.Main.filterCardsItemClass = function(itemclass) {
	var itemclass_button = $('card-itemclass-button');
	var itemclass_popup = $('card-itemclass-popup');
	var visible_cards = 0;
	$('shelf-loading').show();
	var card_type = $('card-category-button').dataset.selectedFilter;
	$$('.shelf').each(function(shelf) {
		shelf.select('.card').each(function(card) {
			if (card.hasClassName(card_type) && card.hasClassName('equippable-item-class-'+itemclass)) {
				card.up('li').show();
				visible_cards++;
			} else {
				card.up('li').hide();
			}
		});
	});
	itemclass_popup.down('ul').childElements().each(function(list_item) {
		var link = list_item.down('a');
		if (link.dataset.filter == itemclass) {
			itemclass_button.update(link.innerHTML + '<span class="dropdown-triangle">&#9660;</span>');
		}
	})
	Devo.Main._default_itemclass_filter = itemclass;
	Devo.Main.Helpers.popup();
	$('shelf-loading').hide();
	return visible_cards;
}

Devo.Main.filterCardsCategory = function(card_class) {
	var button = $('card-category-button');
	var popup = $('card-category-popup');
	var race_button = $('card-race-button');
	var itemclass_button = $('card-itemclass-button');
	$('shelf-loading').show();
	button.removeClassName('last');
	popup.down('ul').childElements().each(function(list_item) {
		var link = list_item.down('a');
		if (link.dataset.filter == card_class) {
			button.update(link.innerHTML + '<span class="dropdown-triangle">&#9660;</span>');
		}
	});
	button.dataset.selectedFilter = card_class;
	$$('.shelf').each(function(shelf) {
		shelf.select('.card').each(function(card) {
			if (card.hasClassName(card_class)) {
				card.up('li').show();
			} else {
				card.up('li').hide();
			}
		});
	});
	race_button.hide();
	itemclass_button.hide();
	if (card_class == 'creature') {
		var race_popup = $('card-race-popup');
		var first_race = (Devo.Main._default_race_filter != undefined) ? Devo.Main._default_race_filter : race_popup.down('ul').childElements()[0].down('a').dataset.filter;
		Devo.Main.filterCardsRace(first_race);
		race_button.show();
	} else if (card_class == 'equippable_item') {
		var itemclass_popup = $('card-itemclass-popup');
		var first_itemclass = (Devo.Main._default_itemclass_filter != undefined) ? Devo.Main._default_itemclass_filter : itemclass_popup.down('ul').childElements()[0].down('a').dataset.filter;
		Devo.Main.filterCardsItemClass(first_itemclass);
		itemclass_button.show();
	} else {
		button.addClassName('last');
		Devo.Main.Helpers.popup();
	}
	$('shelf-loading').hide();
}

Devo.Game.pickCards = function() {
	var cards = Form.serialize('card-picker-form');
	var url = $('card-picker-form').action;
	Devo.Main.Helpers.loading();
	Devo.Main.Helpers.ajax(url, {
		additional_params: cards,
		success: {
			callback: function(json) {
				if (json.is_started == 1) {
					Devo.Game.initializeGame(json.game_id);
				} else {
					Devo.Game.initializeCardPicker(json.options);
				}
			}
		},
		complete: {
			callback: function(json) {
				Devo.Main.Helpers.finishLoading();
			}
		}
	});
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
				if ($('my_ongoing_games') != undefined) {
					$('my_ongoing_games_none').removeClassName('animated fadeIn');
					$('my_ongoing_games_none').addClassName('animated fadeOut');
					window.setTimeout(function() {$('my_ongoing_games_none').hide();$('my_ongoing_games').insert(json.game);}, 1100);
					window.setTimeout(function() {$('my_ongoing_games').childElements().last().addClassName('animated tada');}, 1200);
					window.setTimeout(function() {$('my_ongoing_games').childElements().last().removeClassName('animated tada');}, 3000);
				} else {
					Devo.Main.Helpers.Backdrop.reset();
				}
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
	Devo.Core.destroyQuickmatchPoller();
	Devo.Main.showMenu();
}

Devo.Play.acceptInvite = function(invite_id, button) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=accept_invite&invite_id='+invite_id,
		loading: {
			callback: function() {
				if (button != undefined && $(button)) $(button).down('img').show();
			}
		},
		success: {
			callback: function(json) {
				if (json.accepted == 'removed') {
					Devo.Play.removeInvite(json.invite_id);
				} else if (json.options && json.options.game_id) {
					Devo.Game.initializeCardPicker(json.options);
					Devo.Play.removeInvite(invite_id);
				}
			}
		},
		complete: {
			callback: function() {
				if (button != undefined && $(button)) $(button).down('img').hide();
				Devo.Play.removeInvite(invite_id);
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
		complete: {
			callback: function() {
				$(button).down('img').hide();
				Devo.Play.removeInvite(invite_id);
			}
		}
	});
};

Devo.Main.setVersion = function() {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=set_version'
	});
	$('changelog-overlay').hide();
};

Devo.Main.levelUpProfile = function() {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=levelup_profile',
		success: {
			callback: function(json) {
				Devo.Main.Profile.setLevel(json.level);
				Devo.Main.Profile.setXp(json.xp);
				$$('.next-level-xp').each(function(element) { element.update(json.next_level_xp) } );
				if (parseInt(json.next_level_xp) > parseInt(json.xp)) {
					$('no-levelup-profile-button-container').show();
					$('levelup-profile-button-container').hide();
				} else {
					$('levelup-profile-button-container').show();
					$('no-levelup-profile-button-container').hide();
				}
			}
		}
	});
	$('levelup-overlay').hide();
};

Devo.Main.removeGameFromList = function(game_id) {
	if ($('my_ongoing_games')) {
		if ($('my_ongoing_games').childElements().size() == 2) {
			window.setTimeout(function() {$('my_ongoing_games_none').show();$('my_ongoing_games_none').removeClassName('animated fadeOut');$('my_ongoing_games_none').addClassName('animated fadeIn');}, 1000);
		}
		$('game_'+game_id+'_list').addClassName('animated bounceOut');
		window.setTimeout(function() {$('game_'+game_id+'_list').remove();}, 900);
	}
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
					Devo.Main.removeGameFromList(game_id);
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
	if ($('game_invite_' + invite_id)) {
		$('game_invite_' + invite_id).addClassName('animated bounceOut');
		window.setTimeout(function() {
			$('game_invite_' + invite_id).remove();
			if ($('game_invites').childElements().size() == 0) {
				window.setTimeout(function() {
					$('no_invites').show();
					$('no_invites').removeClassName('animated fadeOut');
					$('no_invites').addClassName('animated fadeIn');
				}, 1000);
			}
		}, 1000);
	}
}

Devo.Game.toggleChat = function(room_id) {
	$$('.chat_room_container').each(function(container) {
		if (container.id != 'chat_'+room_id+'_container') container.hide();
	});
	$('chat_'+room_id+'_container').toggle();
	$('profile_menu_strip').childElements().each(function(element) {
		element.removeClassName('selected');
	});
	if ($('chat_'+room_id+'_container').visible()) {
		$$('.content').each(function(content_container) {
			content_container.addClassName('unfocussed');
		});
		Devo.Main._resizeWatcher();
		$('chat_room_'+room_id+'_lines').scrollTop = $('chat_room_'+room_id+'_lines').scrollHeight;
		$('chat_'+room_id+'_toggler').addClassName('selected');
		$('chat_'+room_id+'_toggler').down('.notify').removeClassName('visible');
		$('chat_room_'+room_id+'_input').focus();
	} else {
		$$('.content').each(function(content_container) {
			content_container.removeClassName('unfocussed');
		});
	}
};

Devo.Tutorial.highlightArea = function(top, left, width, height, blocked, seethrough) {
	var backdrop_class = (seethrough != undefined && seethrough == true) ? 'seethrough' : 'dark';
	var d1 = '<div class="fullpage_backdrop '+backdrop_class+' tutorial" style="top: 0; left: 0; width: '+left+'px;"></div>';
	var d2_width = Devo.Core._vp_width - left - width;
	var d2 = '<div class="fullpage_backdrop '+backdrop_class+' tutorial" style="top: 0; left: '+(left+width)+'px; width: '+d2_width+'px;"></div>';
	var d3 = '<div class="fullpage_backdrop '+backdrop_class+' tutorial" style="top: 0; left: '+left+'px; width: '+width+'px; height: '+top+'px"></div>';
	var vp_height = document.viewport.getHeight();
	var d4_height = vp_height - top - height;
	var d4 = '<div class="fullpage_backdrop '+backdrop_class+' tutorial" style="top: '+(top+height)+'px; left: '+left+'px; width: '+width+'px; height: '+d4_height+'px"></div>';
	if (blocked == true) {
		var d_overlay = '<div class="tutorial block_overlay" style="top: '+top+'px; left: '+left+'px; width: '+width+'px; height: '+height+'px;"></div>';
		$('fullscreen-container').insert(d_overlay);
	}
	$('fullscreen-container').insert(d1);
	$('fullscreen-container').insert(d2);
	$('fullscreen-container').insert(d3);
	$('fullscreen-container').insert(d4);
	Devo.Tutorial.positionMessage(top, left, width, height);
};
Devo.Tutorial.highlightElement = function(element, blocked, seethrough) {
	element = $(element);
	var el = element.getLayout();
	var os = element.cumulativeOffset();
	var width = el.get('width') + el.get('padding-left') + el.get('padding-right');
	var height = el.get('height') + el.get('padding-top') + el.get('padding-bottom');
	Devo.Tutorial.highlightArea(os.top, os.left, width, height, blocked, seethrough);
};
Devo.Tutorial.positionMessage = function(top, left, width, height) {
	var tm = $('tutorial-message');
	['above', 'below', 'left', 'right'].each(function(pos) { tm.removeClassName(pos); });
	if (top + left + width + height == 0) {
		tm.addClassName('full');
		tm.setStyle({top: '', left: ''});
	} else {
		tm.removeClassName('full');
		var step = parseInt($('tutorial-message').dataset.tutorialStep);
		var key = $('tutorial-message').dataset.tutorialKey;
		var td = Devo.Tutorial.Stories[key][step];
		tm.addClassName(td.messagePosition);
		var tl = tm.getLayout();
		var twidth = tl.get('width') + tl.get('padding-left') + tl.get('padding-right');
		switch (td.messagePosition) {
			case 'right':
				tm.setStyle({top: top + 'px', left: (left + width + 15)+'px'});
				break;
			case 'left':
				var tl = tm.getLayout();
				var width = tl.get('width') + tl.get('padding-left') + tl.get('padding-right');
				tm.setStyle({top: top + 'px', left: (left - width - 15)+'px'});
				break;
			case 'below':
				tm.setStyle({top: (top + height + 15)+'px', left: ((left - parseInt(twidth / 2)) + width / 2) + 'px'});
				break;
			case 'above':
				var tl = tm.getLayout();
				var th = tl.get('height') + tl.get('padding-top') + tl.get('padding-bottom');
				tm.setStyle({top: (top - th - 15)+'px', left: ((left - parseInt(twidth / 2)) + width / 2) + 'px'});
				break;
			case 'center':
				var tl = tm.getLayout();
				var th = tl.get('height') + tl.get('padding-top') + tl.get('padding-bottom');
				tm.setStyle({top: (top + (height / 2) - (th / 2))+'px', left: ((left - parseInt(twidth / 2)) + width / 2) + 'px'});
				break;
		}
	}
	tm.show();
};
Devo.Tutorial.resetHighlight = function() {
	$$('.tutorial').each(Element.remove);
};
Devo.Tutorial.disable = function() {
	var key = $('tutorial-message').dataset.tutorialKey;
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=disable_tutorial&key='+key
	});
	$('tutorial-next-button').stopObserving('click');
	Devo.Tutorial.resetHighlight();
	$('tutorial-message').hide();
};
Devo.Tutorial.enable = function(key) {
	Devo.Main.Helpers.ajax(Devo.options['say_url'], {
		params: '&topic=enable_tutorial&key='+key
	});
};
Devo.Tutorial.playNextStep = function() {
	Devo.Tutorial.resetHighlight();
	var tm = $('tutorial-message');
	var step = parseInt(tm.dataset.tutorialStep);
	var key = tm.dataset.tutorialKey;
	step++;
	$('tutorial-current-step').update(step);
	tm.dataset.tutorialStep = step;
	var tutorialData = Devo.Tutorial.Stories[key][step];
	if (tutorialData != undefined) {
		$('tutorial-message-container').update(tutorialData.message);
		var tbn = tm.down('.tutorial-buttons').down('.button-next');
		var tb = tm.down('.tutorial-buttons').down('.button-disable');
		if (tutorialData.button != undefined) {
			tbn.update(tutorialData.button);
			tbn.show();
			if (step > 1) {
				tb.hide();
			} else {
				tb.show();
			}
		} else {
			tbn.hide();
			tb.hide();
		}
		['small', 'medium', 'large'].each(function(cn) { tm.removeClassName(cn); });
		tm.addClassName(tutorialData.messageSize);
		if (tutorialData.highlight != undefined) {
			var tdh = tutorialData.highlight;
			if (tdh.element != undefined) {
				var seethrough = (tdh.seethrough != undefined) ? tdh.seethrough : false;
				Devo.Tutorial.highlightElement(tdh.element, tdh.blocked, seethrough);
			} else {
				Devo.Tutorial.highlightArea(tdh.top, tdh.left, tdh.width, tdh.height, tdh.blocked);
			}
		} else {
			Devo.Tutorial.highlightArea(0, 0, 0, 0, true);
		}
		if (tutorialData.cb) {
			tutorialData.cb(tutorialData);
		}
	} else {
		Devo.Tutorial.disable();
	}
};
Devo.Tutorial.start = function(key) {
	var tutorial = Devo.Tutorial.Stories[key];
	var ts = 0;
	for (var d in tutorial) {
		ts++;
	}
	$('tutorial-message').dataset.tutorialKey = key;
	$('tutorial-message').dataset.tutorialStep = 0;
	$('tutorial-message').dataset.tutorialSteps = ts;
	$('tutorial-total-steps').update(ts);
	$('tutorial-next-button').stopObserving('click');
	$('tutorial-next-button').observe('click', Devo.Tutorial.playNextStep);
	Devo.Tutorial.playNextStep();
}

Devo.Main.mapDrag = function(event) {
	var x = event.pointerX();
	var y = event.pointerY();
	var bgx = (x > Devo.Core._initialX) ? Devo.Core.mapX + (x - Devo.Core._initialX) : Devo.Core.mapX + (x - Devo.Core._initialX);
	var bgy = (y > Devo.Core._initialY) ? Devo.Core.mapY + (y - Devo.Core._initialY) : Devo.Core.mapY + (y - Devo.Core._initialY);
	Devo.Main.mapMove(bgx, bgy);
}
Devo.Main.mapMove = function(x, y) {
	var xmax = 2481;
	var ymax = 1754;
	var xmin = 0;
	var ymin = 0;
	var ami = $('adventure-map-image');
	switch (true) {
		case ami.hasClassName('zoom-level-1'):
			xmin = -245;
			xmax = 2225;
			ymin = -175;
			ymax = 1574;
			break;
		case ami.hasClassName('zoom-level-2'):
			xmin = -120;
			xmax = 2345;
			ymin = -85;
			ymax = 1668;
			break;
		case ami.hasClassName('zoom-level-4'):
			xmin = 120;
			xmax = 2607;
			ymin = 85;
			ymax = 1840;
			break;
		case ami.hasClassName('zoom-level-5'):
			xmin = 245;
			xmax = 2727;
			ymin = 175;
			ymax = 1924;
			break;
	}
	if (x > xmin) x = xmin;
	if (x < -xmax+Devo.Core._mapWidth) x = -xmax+Devo.Core._mapWidth;
	if (y > ymin) y = ymin;
	if (y < -ymax+Devo.Core._mapHeight) y = -ymax+Devo.Core._mapHeight;
	ami.dataset.coordX = x;
	ami.dataset.coordY = y;
	ami.setStyle({left: x + 'px', top: y + 'px'});
}
Devo.Main.mapFocus = function(x, y) {
	x = parseInt(x + (Devo.Core._mapWidth / 2));
	y = parseInt(y + (Devo.Core._mapHeight / 2));
	Devo.Main.mapMove(x, y);
};
Devo.Main.startMapDrag = function(event) {
	Devo.Core._dragging = true;
	Devo.Core._initialX = event.pointerX();
	Devo.Core._initialY = event.pointerY();
	var os = $('adventure-map-image').positionedOffset();
	Devo.Core.mapX = os.left;
	Devo.Core.mapY = os.top;
	document.observe('mousemove', Devo.Main.mapDrag);
	event.preventDefault();
	return false;
}
Devo.Main.stopMapDrag = function(event) {
	Devo.Core._dragging = false;
	document.stopObserving('mousemove', Devo.Main.mapDrag);
}
Devo.Main.filterQuests = function(faction) {
	var button = $('quest-category-button');
	var popup = $('quest-category-popup');
	popup.down('ul').childElements().each(function(list_item) {
		var link = list_item.down('a');
		if (link.dataset.filter == faction) {
			button.update('Selected faction: ' + link.innerHTML + '<span class="dropdown-triangle">&#9660;</span>');
		}
	});
	button.removeClassName('button-pressed');
	button.dataset.selectedFilter = faction;
	Devo.Main.clearMapSelections();
	Devo.Main.filterQuestType($('quest-type-button').dataset.selectedFilter);
	Devo.Main.mapFocus(Devo.Core._mapLocations[faction].x, Devo.Core._mapLocations[faction].y);
}
Devo.Main.filterQuestType = function(quest_type) {
	var button = $('quest-type-button');
	var popup = $('quest-type-popup');
	popup.down('ul').childElements().each(function(list_item) {
		var link = list_item.down('a');
		if (link.dataset.filter == quest_type) {
			button.update('Quest type: ' + link.innerHTML + '<span class="dropdown-triangle">&#9660;</span>');
		}
	});
	button.removeClassName('button-pressed');
	button.dataset.selectedFilter = quest_type;
	var faction = $('quest-category-button').dataset.selectedFilter;
	var has_quests = false;
	$('available-quests-list').childElements().each(function(quest) {
		if (quest.dataset.tellableType == quest_type && quest.hasClassName('applies-'+faction)) {
			has_quests = true;
			quest.show();
		} else {
			quest.hide();
		}
	});
	['story', 'adventure'].each(function(qt) { (qt == quest_type && !has_quests) ? $('available-quests-lists-none-'+qt).show() : $('available-quests-lists-none-'+qt).hide(); });
	$('adventure-map-image').select('.map-point-container').each(function(quest) {
		if (quest.dataset.tellableType == quest_type && quest.hasClassName('applies-'+faction)) {
			quest.show();
		} else {
			quest.hide();
		}
	});
	Devo.Main.clearMapSelections();
}
Devo.Main.highlightTellable = function(event) {
	Devo.Main.clearMapSelections();
	var tellable = $(this);
	Devo.Main.mapFocus(-tellable.dataset.coordX, -tellable.dataset.coordY);
	var tellableId = tellable.dataset.tellableType+'-'+tellable.dataset.tellableId;
	$(tellableId+'-map-points-container').addClassName('selected');
	var tp = $(tellableId+'-map-point');
	eventFire(tp, 'click');
};
Devo.Game.initializeTellable = function() {
	var tellableType = $('adventure-book').dataset.tellableType;
	$('adventure-start-title').update($('tellable-header').innerHTML);
	$('adventure-start-fullstory').update($('tellable-fullstory').innerHTML);
	$('adventure-start-container').show();
};
Devo.Game.startTellable = function() {
	var part_id = $('adventure-book').dataset.tellableId;
	Devo.Main.Helpers.ajax(Devo.options['say_url']+'&topic=start_part&part_id='+part_id, {
		form: 'adventure-start-form',
		loading: {
			callback: function() {
				$('adventure-start-container').hide();
				Devo.Main.Helpers.loading();
			}
		},
		success: {
			callback: function(json) {
				Devo.Main.Helpers.finishLoading();
				if (json.options && json.options.game_id) {
					Devo.Game.initializeGame(parseInt(json.options.game_id));
				}
			}
		}
	});

}
Devo.Main.selectStory = function(event) {
	var story_id = $(this).dataset.tellableId;
	var location = '!adventure/story/'+story_id;
	$('game-content-container').dataset.location = '#'+location;
	window.location.hash = location;
	$(this).up().toggleClassName('selected');
	$(this).up().select('.map-point.part').each(function(el) {
		el.removeClassName('selected');
	});
	$(this).addClassName('selected');
	Devo.Main.showBook(this);
	event.stopPropagation();
};
Devo.Main.selectChapter = function(event) {
	var chapter_id = $(this).dataset.tellableId;
	var location = '!adventure/chapter/'+chapter_id;
	$('game-content-container').dataset.location = '#'+location;
	window.location.hash = location;
	var cid = $(this).dataset.tellableId;
	$(this).up().addClassName('selected');
	$(this).up().select('.map-point.part').each(function(el) {
		el.removeClassName('selected');
	});
	$(this).up().select('.map-point.story, .map-point.adventure').each(function(elm) { elm.addClassName('selected'); });
	Devo.Main.showBook($('chapter-'+cid+'-map-point'));
	event.stopPropagation();
};
Devo.Main.selectPart = function(event) {
	var part_id = $(this).dataset.tellableId;
	var location = '!adventure/quest/'+part_id;
	$('game-content-container').dataset.location = '#'+location;
	window.location.hash = location;
	var cid = $(this).dataset.tellableId;
	$(this).up().addClassName('selected');
	$(this).up().select('.map-point.part').each(function(el) {
		el.removeClassName('selected');
	});
	$(this).up().select('.map-point.story, .map-point.adventure').each(function(elm) { elm.addClassName('selected'); });
	Devo.Main.showBook($('part-'+cid+'-map-point'));
	event.stopPropagation();
};
Devo.Main.selectAdventure = function(event) {
	var adventure_id = $(this).dataset.tellableId;
	var location = '!adventure/adventure/'+adventure_id;
	$('game-content-container').dataset.location = '#'+location;
	window.location.hash = location;
	Devo.Main.clearMapSelections(event);
	$(this).addClassName('selected');
	Devo.Main.showBook(this);
	event.stopPropagation();
};
Devo.Main.loadTellableAttempts = function(td) {
	$('tellable-attempts').hide();
	$('tellable-no-attempts').hide();
	$('tellable-attempts-list').hide();
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		params: '&for=tellable_attempts&tellable_type='+td.tellableType+'&tellable_id='+td.tellableId,
		success: {
			callback: function(json) {
				$('tellable-attempts-list').update('');
				if (json.attempts && json.attempts.size() > 0) {
					json.attempts.each(function(attempt) {
						var a_elm = '<div class="attempt"><span class="attempt-time">'+attempt.time+'</span> ';
						switch (td.tellableType) {
							case 'part':
								a_elm += (attempt.winning) ? 'You completed this quest' : 'You failed to complete this quest';
								break;
							default:
								a_elm += 'You completed this '+td.tellableType;
								break;
						}
						a_elm += '</div>';
						$('tellable-attempts-list').insert(a_elm);
					});
					$('tellable-attempts-list').show();
				} else {
					$('tellable-no-attempts').show();
				}
				$('tellable-attempts').show();
				if (td.tellableType == 'part') {
					var stb = $('start-tellable-button');
					stb.stopObserving('click');
					if (parseInt(json.current_attempt) > 0) {
						stb.observe('click', function() { Devo.Game.initializeGame(parseInt(json.current_attempt)); });
						stb.update('Continue quest');
					} else {
						stb.update('Start quest');
						stb.observe('click', Devo.Game.initializeTellable);
					}
					if (parseInt(td.requiredLevel) > Devo.Game.getUserLevel()) {
						$('tellable-required-level').update(td.requiredLevel);
						$('tellable-level-too-low').show();
						stb.hide();
					} else {
						if (td.unavailable != undefined) {
							$('tellable-unavailable-message').show();
							$('start-tellable-button').disable();
							$('start-tellable-button').addClassName('disabled');
						} else {
							$('tellable-unavailable-message').hide();
							$('start-tellable-button').enable();
							$('start-tellable-button').removeClassName('disabled');
						}
						stb.show();
					}
				}
			}
		}
	});
};
Devo.Main.loadCardRewards = function(td) {
	$('tellable-card-rewards').hide();
	$('tellable-card-reward-cards').update('');
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		params: '&for=tellable_card_rewards&tellable_type='+td.tellableType+'&tellable_id='+td.tellableId,
		success: {
			callback: function(json) {
				if (json.cards) {
					var cc = 0;
					json.cards.each(function(card) {
						cc++;
						$('tellable-card-reward-cards').insert(card);
					});
					if (cc > 2) {
						$('tellable-card-reward-cards').select('.card').each(function(c) {
							c.addClassName('tiny');
							c.removeClassName('medium');
						})
					}
					$('tellable-card-rewards').show();
				}
			}
		}
	});
};
Devo.Main.loadCardOpponents = function(td) {
	$('tellable-card-opponent-cards').hide();
	$('tellable-card-opponent-cards-none').hide();
	$('tellable-card-opponent-cards').update('');
	Devo.Main.Helpers.ajax(Devo.options['ask_url'], {
		params: '&for=tellable_card_opponents&tellable_type='+td.tellableType+'&tellable_id='+td.tellableId,
		success: {
			callback: function(json) {
				if (json.cards) {
					var cc = 0;
					json.cards.each(function(card) {
						$('tellable-card-opponent-cards').insert(card);
						cc++;
					});
					if (cc == 1) {
						$('tellable-card-opponent-cards').select('.card').each(function(c) {
							c.removeClassName('medium');
							c.removeClassName('tiny');
						})
					} else if (cc <= 4) {
						$('tellable-card-opponent-cards').select('.card').each(function(c) {
							c.addClassName('medium');
							c.removeClassName('tiny');
						})
					}
					$('tellable-card-opponent-cards').show();
					$('tellable-card-opponents').show();
				}
			}
		}
	});
};
Devo.Main.showBook = function(tellable) {
	$('tellable-header').update(tellable.dataset.title);
	if (tellable.hasClassName('completed')) $('tellable-header').insert('<img src="/images/icon_ok_alternate.png">');
	$('tellable-fullstory').update(tellable.dataset.fullstory);
	var trg = $('tellable-gold-reward');
	if (parseInt(tellable.dataset.rewardGold) > 0) {
		trg.down('span').update(parseInt(tellable.dataset.rewardGold));
		trg.show();
	} else {
		trg.hide();
	}
	var trx = $('tellable-xp-reward');
	if (parseInt(tellable.dataset.rewardXp) > 0) {
		trx.down('span').update(parseInt(tellable.dataset.rewardXp));
		trx.show();
	} else {
		trx.hide();
	}
	if (tellable.dataset.cardRewards != undefined) {
		Devo.Main.loadCardRewards(tellable.dataset);
	} else {
		$('tellable-card-rewards').hide();
	}
	if (tellable.dataset.cardOpponents != undefined) {
		Devo.Main.loadCardOpponents(tellable.dataset);
	} else {
		$('tellable-card-opponent-cards').hide();
		$('tellable-card-opponent-cards-none').show();
		$('tellable-card-opponents').hide();
	}
	$$('.page-flip').each(function(elm) { elm.removeClassName('selected'); });
	$$('.bookmark-flip').each(function(elm) { elm.removeClassName('selected'); });
	$('page-1').addClassName('selected');
	$('page-1-flip').addClassName('selected');
	$('tellable-card-opponents').removeClassName('selected');
	$('adventure-book').show();
	$('adventure-book').dataset.tellableType = tellable.dataset.tellableType;
	$('adventure-book').dataset.tellableId = tellable.dataset.tellableId;
	$$('.tellable-reward-tellable-type').each(function(elm) {
		elm.update((tellable.dataset.tellableType != 'part') ? tellable.dataset.tellableType : 'quest');
	});
	$$('.map-point.part').each(function(mp) { mp.removeClassName('hovering'); mp.removeClassName('chapter-hovering'); });
	$$('.bookmark-flip.back').each(Element.remove);
	if (tellable.dataset.parentType != undefined) {
		var flip_1 = '<div class="bookmark-flip back" id="bookmark-flip-back-1">Back to '+tellable.dataset.parentType+'</div>';
		var parent_elm = $(tellable.dataset.parentType+'-'+tellable.dataset.parentId+'-map-point');
		$('bookmark-flips-back').insert({top: flip_1});
		$('bookmark-flip-back-1').observe('click', function() {
			eventFire(parent_elm, 'click');
		});
		if (parent_elm.dataset.parentType != undefined) {
			var parent_elm_2 = $(parent_elm.dataset.parentType+'-'+parent_elm.dataset.parentId+'-map-point');
			var flip_2 = '<div class="bookmark-flip back" id="bookmark-flip-back-2">Back to '+parent_elm.dataset.parentType+'</div>';
			$('bookmark-flips-back').insert({top: flip_2});
			$('bookmark-flip-back-2').observe('click', function() {
				eventFire(parent_elm_2, 'click');
			});
		}
	}
	if (tellable.dataset.tellableType != 'part') {
		var child_class = '';
		['story', 'chapter', 'adventure'].each(function(st) {
			if (st == tellable.dataset.tellableType) {
				$(st+'-explanation').show();
				switch (st) {
					case 'story':
						$('tellable-chapters').show();
						$('tellable-parts').hide();
						child_class = 'chapter';
						break;
					case 'adventure':
					case 'chapter':
						$('tellable-chapters').hide();
						$('tellable-parts').show();
						child_class = 'part';
						break;
				}
			} else {
				$(st+'-explanation').hide();
			}
		});
		$('start-tellable-button').hide();
		$('tellable-children').show();
		$('tellable-children-list').update('');
		tellable.up().select('.map-point.'+child_class).each(function(ct) {
			if (ct.dataset.parentType == tellable.dataset.tellableType && ct.dataset.parentId == tellable.dataset.tellableId) {
				var celm = '';
				celm += '<div class="tellable-child" id="tellable-child-'+ct.dataset.tellableId+'" ';
				celm += 'data-tellable-id="'+ct.dataset.tellableId+'">';
				celm += '<h6>'+ct.dataset.title;
				if (ct.hasClassName('completed')) celm += '<img src="/images/icon_ok_alternate.png">';
				celm += '</h6>';
				if (ct.dataset.requiredLevel > 0) {
					celm += '<div class="requires-level">Minimum level '+ct.dataset.requiredLevel+'</div><br>';
				}
				celm += ct.dataset.excerpt+'</div>';
				$('tellable-children-list').insert(celm);
				window.setTimeout(function() {
					if (ct.dataset.tellableType == 'chapter') {
						$('tellable-child-'+ct.dataset.tellableId).observe('click', Devo.Main.selectChapter);
						$('tellable-child-'+ct.dataset.tellableId).observe('mouseover', function() {
							$$('.map-point.part').each(function(mp) {
								(mp.dataset.parentType == 'chapter' && mp.dataset.parentId == ct.dataset.tellableId && !mp.hasClassName('completed')) ? mp.addClassName('chapter-hovering') : mp.removeClassName('chapter-hovering');
							});
						});
					} else {
						$('tellable-child-'+ct.dataset.tellableId).observe('click', Devo.Main.selectPart);
						$('tellable-child-'+ct.dataset.tellableId).observe('mouseover', function() {
							$$('.map-point.part').each(function(mp) { mp.removeClassName('hovering'); });
							$(ct.dataset.tellableType+'-'+ct.dataset.tellableId+'-map-point').addClassName('hovering');
						});
					}
					$('tellable-child-'+ct.dataset.tellableId).observe('mouseout', function() {
						$$('.map-point.part').each(function(mp) { mp.removeClassName('hovering'); });
					});
				}, 500);
			}
		});
	} else {
		['story', 'chapter', 'adventure'].each(function(st) {
			$(st+'-explanation').hide();
		});
		Devo.Main.mapFocus(-tellable.dataset.coordX, -tellable.dataset.coordY);
		$('tellable-children').hide();
	}
	Devo.Main.loadTellableAttempts(tellable.dataset);
};
Devo.Main.mapSetZoom = function(zoom) {
	var ami = $('adventure-map-image');
	[1, 2, 3, 4, 5].each(function(zl) {
		if (zl != zoom) {
			ami.removeClassName('zoom-level-'+zl);
		} else {
			ami.addClassName('zoom-level-'+zoom);
		}
		ami.dataset.zoomLevel = zoom;
		Devo.Main._resizeMapContainer();
		window.setTimeout(function() {
			Devo.Main.mapMove(parseInt(ami.dataset.coordX), parseInt(ami.dataset.coordX));
		}, 410);
	});
};
Devo.Main.mapZoomIn = function() {
	var zoom = parseInt($('adventure-map-image').dataset.zoomLevel);
	if (zoom < 5) {
		Devo.Main.mapSetZoom(zoom + 1);
	}
};
Devo.Main.mapZoomOut = function() {
	var zoom = parseInt($('adventure-map-image').dataset.zoomLevel);
	if (zoom > 1) {
		Devo.Main.mapSetZoom(zoom - 1);
	}
};
Devo.Main.clearMapSelections = function(event) {
	$$('.map-point-container, .map-point').each(function(element) { element.removeClassName('selected'); });
	$('adventure-book').hide();
};
Devo.Main.selecteAdventurePage = function(selected_page, flip) {
	$('bookmark-flips').childElements().each(function(elm) {
		elm.removeClassName('selected');
	});
	$(flip).addClassName('selected');
	$('adventure-book').select('.page-flip').each(function(elm) {
		elm.removeClassName('selected');
	});
	$(selected_page).addClassName('selected');
}
Devo.Main.bookDrag = function(event) {
	var x = event.pointerX();
	var y = event.pointerY();
	var bgx = (x > Devo.Core._initialBookX) ? Devo.Core.bookX + (x - Devo.Core._initialBookX) : Devo.Core.bookX + (x - Devo.Core._initialBookX);
	var bgy = (y > Devo.Core._initialBookY) ? Devo.Core.bookY + (y - Devo.Core._initialBookY) : Devo.Core.bookY + (y - Devo.Core._initialBookY);
	bgy = (bgy > Devo.Core._vp_height - Devo.Core.bookHeight - 100) ? Devo.Core._vp_height - Devo.Core.bookHeight - 100 : bgy;
	bgx = (bgx > Devo.Core._vp_width - Devo.Core.bookWidth - 60) ? Devo.Core._vp_width - Devo.Core.bookWidth - 60 : bgx;
	bgy = (bgy < 40) ? 40 : bgy;
	bgx = (bgx < 60) ? 60 : bgx;
	$('adventure-book').setStyle({left: bgx + 'px', top: bgy + 'px'});
}
Devo.Main.startBookDrag = function(event) {
	Devo.Core._bookdragging = true;
	var os = $('adventure-book').positionedOffset();
	var ol = $('adventure-book').getLayout();
	var x = event.pointerX();
	var y = event.pointerY();
	Devo.Core._initialBookX = x;
	Devo.Core._initialBookY = y;
	Devo.Core.bookX = os.left;
	Devo.Core.bookY = os.top;
	Devo.Core.bookWidth = ol.get('width') - ol.get('padding-left') - ol.get('padding-right');
	Devo.Core.bookHeight = ol.get('height') - ol.get('padding-top') - ol.get('padding-bottom');
	document.observe('mousemove', Devo.Main.bookDrag);
	event.preventDefault();
	event.stopPropagation();
	return false;
}
Devo.Main.stopBookDrag = function(event) {
	Devo.Core._bookdragging = false;
	event.stopPropagation();
	document.stopObserving('mousemove', Devo.Main.bookDrag);
}
Devo.Admin.placePointOnMap = function(element) {
	$('adventure-map').addClassName('placing');
	document.stopObserving('mousemove', Devo.Main.mapDrag);
	$('adventure-map').stopObserving('mousedown', Devo.Main.startMapDrag);
	$('adventure-map').stopObserving('mouseup', Devo.Main.stopMapDrag);
	$('adventure-map').observe('click', function(event) {
		var x = event.pointerX();
		var y = event.pointerY();
		var cos = $('adventure-map-image').cumulativeOffset();
		x += -cos.left;
		y += -cos.top;
		$(element).setStyle({left: x + 'px', top: y + 'px'})
		$(element).next().setStyle({left: x + 'px', top: y + 'px'})
		$(element).show();
		$('tellable_coordinates').setValue(x+','+y);
		$('adventure-map').stopObserving('click');
		$('adventure-map').removeClassName('placing');
		$('adventure-map').observe('mousedown', Devo.Main.startMapDrag);
		$('adventure-map').observe('mouseup', Devo.Main.stopMapDrag);
	});
};

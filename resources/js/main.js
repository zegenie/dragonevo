
function is_string(element) {
    return (typeof element == 'string');
}

var Devo = {
    Core: {},
    Main: {
        Helpers: {
            Backdrop: {},
            Dialog: {},
            Message: {}
        },
		Login: {}
    },
	effect_queues: {
		successmessage: 'Devo_successmessage',
		failedmessage: 'Devo_failedmessage'
	}
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
				if (Devo.debug) {
					$('tbg___DEBUGINFO___indicator').show();
				}
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
				Devo.Main.Helpers.Message.error(response.responseText);
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
				$('tbg___DEBUGINFO___indicator').hide();
				var d = new Date(),
					d_id = response.getHeader('x-tbg-debugid');

				Devo.Core.AjaxCalls.push({location: url, time: d, debug_id: d_id});
				Devo.updateDebugInfo();
			}
			$(options.loading.indicator).hide();
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

Devo.Main.Login.login = function(url) {
	Devo.Main.Helpers.ajax(url, {
		form: 'login_form',
		loading: {
			indicator: 'login_indicator',
			hide: 'login_button'
		},
		failure: {
			show: 'login_button',
		}
	});
}

Devo.Core._resizeWatcher = function() {
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

Devo.Core.initialize = function() {
	Event.observe(window, 'resize', Devo.Core._resizeWatcher);
	Devo.Core._resizeWatcher();
}
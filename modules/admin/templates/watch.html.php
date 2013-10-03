<?php

$csp_response->setTitle('Monitor games');
$csp_response->addJavascript('/js/when/when.js');
$csp_response->addJavascript('/js/autobahn.js');

?>
<div class="content left">
    <?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
    <h1>
        <div style="float: right;">
            <img src="/images/user-online.png" id="watchdog-online" style="display: none;">
            <img src="/images/user-offline.png" id="watchdog-offline" style="display: none;">
            <img src="/images/spinning_32.gif" id="watchdog-waiting">
        </div>
        <?php echo __('Monitor ongoing games'); ?>
    </h1>
    <div id="games_container" style="font-family: Open Sans; font-size: 1.1em;">
    </div>
</div>
<script>
    Devo.Core.Events.listen('devo:core:offline', function(options) {
        $('watchdog-waiting').hide();
        $('watchdog-offline').show();
        window.setTimeout(function() {
            $('fullpage_backdrop').hide();
        }, 1000);
    });
    Devo.Core.Events.listen('devo:core:initialized', function(options) {
        $('watchdog-waiting').hide();
        $('watchdog-online').show();
        Devo.connection.subscribe('SysAdmin', function(topic, data) {
            switch (data.type) {
                case 'game_save':
                    if (!$('game-'+data.id)) {
                        var elm = '<div id="game-'+data.id+'"><h5>Game '+data.id+'</h5><div id="game-'+data.id+'-data"></div></div>';
                        $('games_container').insert(elm);
                    }
                    window.setTimeout(function() {
                        var info = '';
                        info += "<strong>State: </strong>";
                        switch (data.data.state) {
                            case <?php echo \application\entities\Game::STATE_INITIATED; ?>:
                                info += "Initiated";
                                break;
                            case <?php echo \application\entities\Game::STATE_ONGOING; ?>:
                                info += "In progress";
                                break;
                            case <?php echo \application\entities\Game::STATE_COMPLETED; ?>:
                                info += "Completed";
                                break;
                        }
                        info += "<br>";
                        info += "<strong>Player id: </strong>"+data.data.player_id+"<br>";
                        info += "<strong>Player ready: </strong>"+((data.data.player_ready == true) ? 'yes' : 'no')+"<br>";
                        info += "<strong>Opponent id: </strong>"+data.data.opponent_id+"<br>";
                        info += "<strong>Opponent ready: </strong>"+((data.data.opponent_ready == true) ? 'yes' : 'no')+"<br>";
                        info += "<strong>Current player id: </strong>"+data.data.current_player_id+"<br>";
                        info += "<strong>Current phase: </strong>";
                        switch (data.data.current_phase) {
                            case <?php echo \application\entities\Game::PHASE_PLACE_CARDS; ?>:
                                info += "Place cards";
                                break;
                            case <?php echo \application\entities\Game::PHASE_MOVE; ?>:
                                info += "Move";
                                break;
                            case <?php echo \application\entities\Game::PHASE_ACTION; ?>:
                                info += "Action";
                                break;
                            case <?php echo \application\entities\Game::PHASE_RESOLUTION; ?>:
                                info += "Resolution";
                                break;
                            case <?php echo \application\entities\Game::PHASE_REPLENISH; ?>:
                                info += '<span style="color: #F33;">Replenish</span>';
                                break;
                        }
                        info += "<br>";
                        info += "<strong>Current player actions: </strong>"+data.data.current_player_actions+"<br>";
                        $('game-'+data.id+'-data').update(info);
                    }, 50);
                    break;
                case 'game_event':
                    break;
            }
        });
    });
</script>

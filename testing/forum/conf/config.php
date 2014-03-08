<?php if (!defined('APPLICATION')) exit();

// Conversations
$Configuration['Conversations']['Version'] = '2.0.18.4';

// Database
$Configuration['Database']['Name'] = 'theoriginal_nel';
$Configuration['Database']['Host'] = 'localhost';
$Configuration['Database']['User'] = 'theoriginal_nel';
$Configuration['Database']['Password'] = 'cEW2aWrA';

// EnabledApplications
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledPlugins
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['VanillaStats'] = TRUE;
$Configuration['EnabledPlugins']['BotStop'] = TRUE;

// Garden
$Configuration['Garden']['Errors']['MasterView'] = 'deverror.master.php';
$Configuration['Garden']['Debug'] = TRUE;
$Configuration['Garden']['Title'] = 'noexcuselist';
$Configuration['Garden']['Cookie']['Salt'] = 'E43BGY175Z';
$Configuration['Garden']['Cookie']['Domain'] = '';
$Configuration['Garden']['Registration']['ConfirmEmail'] = '1';
$Configuration['Garden']['Registration']['Method'] = 'Approval';
$Configuration['Garden']['Registration']['ConfirmEmailRole'] = '8';
$Configuration['Garden']['Registration']['CaptchaPrivateKey'] = '6Lc3OOMSAAAAAIf16qZvfGXDU6vq67kSeuHZY_9M';
$Configuration['Garden']['Registration']['CaptchaPublicKey'] = '6Lc3OOMSAAAAAGcDTodd-bRjwFHTW-ux5g0tKlVb';
$Configuration['Garden']['Registration']['InviteExpiration'] = '-1 week';
$Configuration['Garden']['Registration']['InviteRoles'] = 'a:5:{i:3;s:1:"0";i:4;s:1:"0";i:8;s:1:"0";i:16;s:1:"0";i:32;s:1:"0";}';
$Configuration['Garden']['Email']['SupportName'] = 'noexcuselist';
$Configuration['Garden']['Version'] = '2.0.18.4';
$Configuration['Garden']['RewriteUrls'] = TRUE;
$Configuration['Garden']['CanProcessImages'] = TRUE;
$Configuration['Garden']['Installed'] = TRUE;
$Configuration['Garden']['Theme'] = 'nel';
$Configuration['Garden']['InstallationID'] = '5467-D8607007-78A49926';
$Configuration['Garden']['InstallationSecret'] = '890f029076a0787bb7b176bf2ac9017139a5fa44';

// Modules
$Configuration['Modules']['Vanilla']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';
$Configuration['Modules']['Conversations']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Discussion'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Registration'] = '1';
$Configuration['Plugins']['GettingStarted']['Profile'] = '1';
$Configuration['Plugins']['BotStop']['Question'] = "What are the first two letters of this website's name? (lowercase)";
$Configuration['Plugins']['BotStop']['Answer1'] = 'no';
$Configuration['Plugins']['BotStop']['Answer2'] = 'no';

// Routes
$Configuration['Routes']['DefaultController'] = 'a:2:{i:0;s:11:"discussions";i:1;s:8:"Internal";}';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.0.18.4';
$Configuration['Vanilla']['Discussion']['SpamCount'] = '2';
$Configuration['Vanilla']['Discussion']['SpamTime'] = '60';
$Configuration['Vanilla']['Discussion']['SpamLock'] = '600';
$Configuration['Vanilla']['Comment']['SpamCount'] = '5';
$Configuration['Vanilla']['Comment']['SpamTime'] = '60';
$Configuration['Vanilla']['Comment']['SpamLock'] = '120';
$Configuration['Vanilla']['Comment']['MaxLength'] = '8000';

// Last edited by noexcuselist (156.77.111.22)2013-11-15 05:26:31
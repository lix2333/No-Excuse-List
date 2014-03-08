<?php
	session_start();
	echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<?php $base_url='http://noexcuselist.com/'; ?>
<head>
   <?php $this->RenderAsset('Head'); ?>
	 <link href='<?php echo "{$base_url}css/main.css"; ?>' rel='stylesheet' type='text/css' />
</head>
<body id="<?php echo $BodyIdentifier; ?>" class="<?php echo $this->CssClass; ?>">
	<div id='mainHeader'>
		<a href='<?php echo $base_url; ?>' id='logo'></a>
		<div id='mainNav'>
			<?php
				$Session = Gdn::Session();
				if($Session->IsValid()){
					$pages = array("home","forum");
				} else {
					unset($_SESSION['username']);
					unset($_SESSION['user_id']);
					unset($_SESSION['logoutURL']);
					unset($_SESSION['superuser']);
					$pages = array("home","about","blog","forum");
				}
				foreach($pages as $p){
					$pretty = ucfirst($p);
					if($p == "home"){
						$p = "";
					}
					if($p == "login"){
						$p = "forum/entry/signin?Target=entry%2Fregister";
					}
					echo "<li><a href='$base_url{$p}'>$pretty</a></li>";
				}

				// vanilla login/logout
				if ($this->Menu) {
					if ($Session->IsValid()) {
						$Name = $Session->User->Name;
						$_SESSION['username'] = $Name;
						$_SESSION['user_id'] = $Session->User->UserID;
						// check if user is an admin
						$Session = Gdn::Session();
						$UserModel = Gdn::UserModel();
						$Roles = $UserModel->GetRoles($Session->UserID);
						$RoleNames = ConsolidateArrayValuesByKey($Roles, 'Name');
						if(in_array('Administrator', $RoleNames)) {
							$_SESSION['superuser']=true;
						} else {
							unset($_SESSION['superuser']);
						}
						$CountNotifications = $Session->User->CountNotifications;
						if (is_numeric($CountNotifications) && $CountNotifications > 0)
							$Name .= ' <span class="Alert">'.$CountNotifications.'</span>';
						if (urlencode($Session->User->Name) == $Session->User->Name)
							$ProfileSlug = $Session->User->Name;
						else
							$ProfileSlug = $Session->UserID.'/'.urlencode($Session->User->Name);
						echo "<li><a href='{$base_url}forum/profile/".$Session->User->Name."'>Account</a></li>
									<li><a href='{$base_url}forum".SignOutUrl()."'>Logout</a></li>";
						$_SESSION['logoutURL'] = SignOutUrl();
					} else {
						echo "<li><a href='{$base_url}forum/entry/signin?Target=discussions'>Login</a></li>";
					}
				}
			?>
		</div>
		<div id='social'>
			<a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php echo $base_url?>" class="fb_share_button" onclick="return fbs_click()" target="_blank"></a>
			<script>
				function fbs_click() {
					u=location.href;t=document.title;
					window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
			</script>
			<a href="https://twitter.com/share?url=<?php echo $base_url ?>" id='twitter_button' target="_blank"></a>
			<a href="http://plus.google.com/share?url=<?php echo $base_url; ?>" id='google_plus' target="_blank"></a>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo $base_url; ?>&media=<?php echo $base_url; ?>%2Fimg%2Flogo.png&description=The best place on the web to learn anything, free." class="pin-it-button" target="_blank"></a>
		</div>
		<h2 id='tagline'>The best place on the web to learn anything, <span class='red'>free.</span></h2>
	</div><!-- mainHeader -->

	<div id="container">
				<div id='subLinks'>
					 <?php
						 $Session = Gdn::Session();
						 if(stristr($BodyIdentifier,'dashboard_profile')){
							// if on the account options, show alternate menu
							?>
								<a href='<?php echo $base_url; ?>forum/profile/<?php echo $_SESSION['username']; ?>' id='current'>Settings</a>
								<a href='<?php echo $base_url; ?>loves'>Loves</a>
								<?php if(isset($_SESSION['superuser'])){ ?>
									<a href='<?php echo $base_url; ?>link-management' <?php if($title=='link management'){echo "id='current'";}; ?>>Link Management</a>
								<?php } ?>
							<?php
						 } else {
							if ($this->Menu) {
								$this->Menu->AddLink('Dashboard', T('Dashboard'), '/dashboard/settings', array('Garden.Settings.Manage'));
								// $this->Menu->AddLink('Dashboard', T('Users'), '/user/browse', array('Garden.Users.Add', 'Garden.Users.Edit', 'Garden.Users.Delete'));
								// $this->Menu->AddLink('Activity', T('Activity'), '/activity');
									if ($Session->IsValid()) {
										$Name = $Session->User->Name;
										$CountNotifications = $Session->User->CountNotifications;
										if (is_numeric($CountNotifications) && $CountNotifications > 0)
											$Name .= ' <span class="Alert">'.$CountNotifications.'</span>';

													 if (urlencode($Session->User->Name) == $Session->User->Name)
															$ProfileSlug = $Session->User->Name;
													 else
															$ProfileSlug = $Session->UserID.'/'.urlencode($Session->User->Name);
										// $this->Menu->AddLink('User', $Name, '/profile/'.$ProfileSlug, array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
										// $this->Menu->AddLink('SignOut', T('Sign Out'), SignOutUrl(), FALSE, array('class' => 'NonTab SignOut'));
									} else {
										$Attribs = array();
										if (SignInPopup() && strpos(Gdn::Request()->Url(), 'entry') === FALSE)
											$Attribs['class'] = 'SignInPopup';

										// $this->Menu->AddLink('Entry', T('Sign In'), SignInUrl($this->SelfUrl), FALSE, array('class' => 'NonTab'), $Attribs);
									}
								echo $this->Menu->ToString();
							}
						 }
					 ?>
					 <!-- div class="Search">
						 <?php
							 $Form = Gdn::Factory('Form');
							 $Form->InputPrefix = '';
							 echo
								 $Form->Open(array('action' => Url('/search'), 'method' => 'get')),
								 $Form->TextBox('Search'),
								 $Form->Button('Go', array('Name' => '')),
								 $Form->Close();
						 ?>
					 </div><!-- .search -->
				</div><!-- #subLinks -->


		 <div id="Body">
				<div id="Content"><?php $this->RenderAsset('Content'); ?></div>
				<div id="Panel"><?php $this->RenderAsset('Panel'); ?></div>
		 </div><!-- #body -->


		 <div id="Foot">
				<?php
					$this->RenderAsset('Foot');
					echo Wrap(Anchor(T('Powered by Vanilla'), C('Garden.VanillaUrl')), 'div');
				?>
		 </div><!-- #foot -->
	</div><!-- #frame -->
	<?php $this->FireEvent('AfterBody'); ?>
</body>
</html>

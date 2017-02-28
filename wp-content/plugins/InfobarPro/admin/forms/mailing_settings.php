<?php

function nb_sub_mailsettings() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    $current_service = get_option('mailing_service_in_use');
    $saved_value = get_option('bar_service_database');
    ?>
    <div  id="of_container" class="wrap">
        <form id="infoapiform" action="" method="post">
            <div id="infobar_header">
                <div class="infobar_logo">
                    <h2><?php _e('InfoBar Mailing List', 'infobar'); ?> </h2>
                </div>
                <div class="clear"></div>
            </div>
            <div id="main">
                <div id="of-nav">
                    <ul>
                        <li><a  class="mailchimp" href="#pn_mailchimp" title="MailChimp"></a></li>
                        <li><a class="aweber" href="#pn_aweber" title="Aweber"></a></li>
                        <li><a class="icontact" href="#pn_icontact" title="iContact"></a></li>
                        <li><a  class="constantcontact"  href="#pn_constantcontact" title="Constant Contact"></a></li>
                        <li><a href="#pn_getresponse" class="getresponse" title="Get Response"></a></li>
                        <li><a href="#pn_campaignmonitor" class="campaignmonitor" title="Compaign Monitor"></a></li>
                        <li><a href="#pn_optin" title="optin">Opt-in to Email</a></li>
                    </ul>
                </div> 
                <div id="content">
                    <!---- mailchimp ---->
                    <div id="pn_mailchimp" class="group" >
                        <h2> Mail Chimp</h2>
                        <div class="help-content">
                            <p><?php _e('You can create the API Keys Under the Account Link->API Keys', 'infobar'); ?> </p>
                            <p><img src="<?php echo plugins_url('../../css/images/mailchimp-api.png', __FILE__) ?>"/> </p>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Enter Your Api Key', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="mc_apikey"  id="mc_apikey" value="<?php
                                    if (!empty($current_service) && $current_service == 'mc') {
                                        echo base64_decode($saved_value['mc_apikey']);
                                    } else {
                                        _e('Enter Your Api Key', 'infobar');
                                    }
                                    ?> " />
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Please Select a Mailing List', 'infobar'); ?> </h3>
                            <div class="option">
                                <div class="controls">
                                    <a href="javascript:void(0);" alt='mc_apikey' class="mc_getlist getlist button-secondary action">
                                        <span><?php _e('Get Mailing List', 'infobar'); ?></span></a>
                                    <span class="mailing-ajax-loading"><?php _e('loading.', 'infobar'); ?></span>
                                    <div class="mc_mailing_list"></div>
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <br />
                    </div>
                    <!------ Aweber ---->
                    <div id="pn_aweber" class="group" >
                        <h2> Aweber </h2>
                        <input type="hidden" name="aw_tokensecret" id="aw_tokensecret" value="<?php
                        if (isset($_COOKIE['aweberTokenSecret'])) {
                            echo $_COOKIE['aweberTokenSecret'];
                        } elseif (!empty($current_service) && $current_service == 'aw') {
                            echo base64_decode($saved_value['aw_secret_token']);
                        } else {
                            echo 'none';
                        }
                        ?>" />
                        <input type="hidden" name="aw_accesstoken" id="aw_accesstoken"  value="<?php
                        if (isset($_COOKIE['aweberToken'])) {
                            echo $_COOKIE['aweberToken'];
                        } elseif (!empty($current_service) && $current_service == 'aw') {
                            echo base64_decode($saved_value['aw_access_token']);
                        } else {
                            echo "none";
                        }
                        ?>" />
                        <div class="section section-text ">
                            <?php if ($current_service == 'aw' || (isset($_COOKIE['aweberToken'])) || (isset($_COOKIE['aweberTokenSecret']))) { ?>
                                <h3 class="heading"> <?php _e('Get Aweber  Mailing List', 'infobar'); ?></h3>
                                <div class="option">
                                    <div class="controls">	
                                        <a href="javascript:void(0);"  class="aw_getlist getlist button-secondary action"><span><?php _e('Get Mailing List', 'infobar'); ?></span></a>
                                        <span class="mailing-ajax-loading"><?php _e('loading.', 'infobar'); ?></span>
                                        <div class="aw_mailing_list"></div>
                                    </div>
                                </div>
                            <?php } else {
                                ?>
                                <br>
                                <h3 class="heading"><?php _e('Connect To Aweber', 'infobar'); ?></h3>
                                <div class="option">
                                    <div class="controls">	
                                        <a href="<?php echo plugins_url('api/aweber/connect.php', __FILE__) . '?redirect=http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="button-secondary action"><?php _e('Connect To Aweber', 'infobar'); ?></a>
                                    </div>
                                    <div class="explain"><?php _e('Click on button to connect the aweber account', 'infobar'); ?> </div>
                                    <div class="clear"> </div>
                                </div>
                            <?php } ?>
                        </div>
                        <br />
                    </div>
                    <!------  iContact ----->
                    <div id="pn_icontact"  class="group" >
                        <h2>iContact</h2>
                        <div class="help-content">
                            <h3 class="header"><?php _e('Usage', 'infobar'); ?></h3>
                            <p><?php _e('Navigate to Link', 'infobar'); ?> : https://app.icontact.com/icp/core/externallogin</p>
                            <p><?php _e('Use the AppID', 'infobar'); ?> <strong>(jgCQvpmWc9JNMb91bf4IGB7xIyGgjBnJ)</strong>, <?php _e('register the plugin to your account with a password to access it.', 'infobar'); ?></p>
                            <p><img src="<?php echo plugins_url('../../css/images/icontact-api.png', __FILE__) ?>"/> </p>
                        </div>
                        <input type="hidden" name="ic_apikey"  value="jgCQvpmWc9JNMb91bf4IGB7xIyGgjBnJ" id="ic_apikey" />
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('iContact Application Password', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="ic_password" id="ic_password" value="<?php
                                    if (!empty($current_service) && $current_service == 'ic') {
                                        echo base64_decode($saved_value['ic_password']);
                                    } else {
                                        _e("Enter your icontact password", 'infobar');
                                    }
                                    ?>"/>
                                </div>
                                <div class="explain"><?php _e('Enter your iContact application password ', 'infobar'); ?></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('iContact Username', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="ic_username" id="ic_username" value="<?php
                                    if (!empty($current_service) && $current_service == 'ic') {
                                        echo base64_decode($saved_value['ic_username']);
                                    } else {
                                        _e("Enter Your Username", 'infobar');
                                    }
                                    ?>" />
                                </div>
                                <div class="explain"><?php _e('Enter your iContact application Username ', 'infobar'); ?></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('iContact Application AppID', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="ic_apikey" id="ic_apikey" value="<?php
                                    if (!empty($current_service) && $current_service == 'ic') {
                                        echo base64_decode($saved_value['ic_apikey']);
                                    } else {
                                        _e("Your App-ID", 'infobar');
                                    }
                                    ?>"/>
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Please Select a Mailing List:', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <a href="javascript:void(0);" alt='ic_apikey' class="ic_getlist getlist button-secondary"><span><?php _e('Get Mailing List', 'infobar'); ?></span></a><span class="mailing-ajax-loading"><?php _e('loading.', 'infobar'); ?></span>
                                    <div class="ic_mailing_list"></div>					
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                    </div>
                    <!------ ConstantContact ----->
                    <div id="pn_constantcontact"  class="group">
                        <h2><?php _e('Constant Contact', 'infobar'); ?></h2>                       
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Constant Contact Username', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="cc_username" id="cc_username" value="<?php
                                    if (!empty($current_service) && $current_service == 'cc') {
                                        echo base64_decode($saved_value['cc_username']);
                                    } else {
                                        _e("Enter your Username", 'infobar');
                                    }
                                    ?>" />
                                </div>
                                <div class="explain"><?php _e('Enter your Constant Contact application Username ', 'infobar'); ?></div>
                                <div class="clear"> </div>
                            </div>
                        </div>	                        
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Constant Contact Password', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="cc_password"  id="cc_password" value="<?php
                                    if (!empty($current_service) && $current_service == 'cc') {
                                        echo base64_decode($saved_value['cc_password']);
                                    } else {
                                        _e("Enter your Password", 'infobar');
                                    }
                                    ?>" />
                                </div>
                                <div class="explain"><?php _e('Enter your Constant Contact application Password', 'infobar'); ?></div>
                                <div class="clear"> </div>
                            </div>
                        </div>                        
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Please Select a Mailing List:', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <a href="javascript:void(0);" alt='cc_apikey' class="cc_getlist getlist button-secondary"><span><?php _e('Get Mailing List', 'infobar'); ?></span></a><span class="mailing-ajax-loading"><?php _e('loading.', 'infobar'); ?></span>
                                    <div class="cc_mailing_list"></div>					
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                    </div>
                    <!------- getresponse ----->
                    <div id="pn_getresponse" class="group">
                        <h2><?php _e('Get Response', 'infobar'); ?></h2>
                        <div class="help-content">
                            <p><?php _e('You can create the API Key under the My Account Link', 'infobar'); ?></p>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Enter get Respose Api Key', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="gr_apikey"  id="gr_apikey" value="<?php
                                    if (!empty($current_service) && $current_service == 'gr') {
                                        echo base64_decode($saved_value['gr_apikey']);
                                    } else {
                                        _e("Enter Your Api Key", 'infobar');
                                    }
                                    ?>" />
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Please Select a Mailing List:', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <a href="#" alt='gr_apikey' class="gr_getlist getlist button-secondary action">
                                        <span><?php _e('Get Mailing List', 'infobar'); ?></span></a>
                                    <span class="mailing-ajax-loading"><?php _e('loading.', 'infobar'); ?></span>
                                    <div class="gr_mailing_list"></div>
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <br />
                    </div>
                    <!----- campainmonitor ---->
                    <div id="pn_campaignmonitor" class="group">
                        <h2><?php _e('Campaign Monitor', 'infobar'); ?></h2>
                        <div class="help-content">
                            <h3 class="heading"><?php _e('Campaign Monitor Api Key', 'infobar'); ?></h3>
                            <p>
                                <?php _e('The API Key can be found undet the account setting.', 'infobar'); ?>
                            </p>
                            <p><img src="<?php echo plugins_url('../../css/images/cm-apikey.jpg', __FILE__) ?>"/> </p>

                            <h3 class="heading"><?php _e('Campaign Monitor ClientId', 'infobar'); ?></h3>
                            <p>
                                <?php _e('The ClientId can be generated from the Client Setting in the clients overview area.', 'infobar'); ?>
                            </p>
                            <p><img src="<?php echo plugins_url('../../css/images/cm-clientid.jpg', __FILE__) ?>"/> </p>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Campaign Monitor ClientId', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">

                                    <input type="text" name="cm_clientid" id="cm_clientid" value="<?php
                                    if (!empty($current_service) && $current_service == 'cm') {
                                        echo base64_decode($saved_value['cm_clientid']);
                                    } else {
                                        _e("Enter  Client Id", 'infobar');
                                    }
                                    ?>" />
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Enter Campaign Monitor Api Key', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="cm_apikey"  id="cm_apikey" value="<?php
                                    if (!empty($current_service) && $current_service == 'cm') {
                                        echo base64_decode($saved_value['cm_apikey']);
                                    } else {
                                        _e("Enter Your Api Key", 'infobar');
                                    }
                                    ?>" />
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Please Select a Mailing List:', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <a href="#"  class="cm_getlist getlist button-secondary action">
                                        <span><?php _e('Get Mailing List', 'infobar'); ?></span></a>

                                    <span class="mailing-ajax-loading"><?php _e('loading.', 'infobar'); ?></span>

                                    <div class="cm_mailing_list"></div>
                                </div>
                                <div class="explain"></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                        <br />
                    </div>
                    <!---- Email  ----->
                    <div id="pn_optin" class="group">
                        <h2>Optin To Email</h2>
                        <div class="section section-text ">
                            <h3 class="heading"><?php _e('Enter Email Address', 'infobar'); ?></h3>
                            <div class="option">
                                <div class="controls">
                                    <input type="text" name="email_email" size="100"  id="email_email" value="<?php echo get_option('infoemail_address') ?>" />
                                </div>
                                <div class="explain"><?php _e('Enter a email address to which you want to send the contact details', 'infobar'); ?></div>
                                <div class="clear"> </div>
                            </div>
                        </div>
                    </div> 
                </div> <!--content-->
                <div class="clear"></div>
            </div> <!--main-->
            <div class="save_bar_top">
                <input id="submit" class="apisubmit button-primary" type="submit" value="<?php _e('Save Changes', 'infobar'); ?>" name="submit">
            </div>
            <div class="clear"></div>
        </form>
    </div><!--of_container-->
    <?php
    if (isset($_POST['submit'])) {
        $lists_id = isset($_POST['listsid']) ? $_POST['listsid'] : NULL;
        $list_id = base64_encode($lists_id);
        update_option('mailing_listid', $list_id);
        if (isset($_POST['email_email'])) {
            $email_address = $_POST['email_email'];
            if (!empty($email_address)) {
                update_option('infoemail_address', $email_address);
                update_option('mailing_service_in_use', 'email');
            }
        }
    }
}
?>
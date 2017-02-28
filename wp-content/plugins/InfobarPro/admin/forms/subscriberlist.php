<?php

function nb_sub_subscriberlist() {
    global $wpdb;
    $list_table_name = $wpdb->prefix . "nb_subscriber_list";
    $query_result = $wpdb->get_results("SELECT * FROM " . $list_table_name);
    ?>
    <div class="infobar_list_wrapper">
        <table class="infobar_subscriber_list">
            <h2> <?php _e('Subscriber List', 'infobar'); ?> </h2>
            <thead class="infobar_subscriber_heading">
                <tr class="display_header">
                    <td width="20px"><h3>ID </h3></td>
                    <td width="60px"><h3><?php _e('Name', 'infobar'); ?></h3></td>
                    <td width="60px"><h3><?php _e('Email', 'infobar'); ?></h3></td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($query_result as $key) {
                    ?>
                    <tr class="fgcf_entries">
                        <td class="infobar_id" ><?php echo $key->id; ?></td> 
                        <td class="infobar_name"><?php echo $key->name; ?></td> 
                        <td class="infobar_email"><?php echo $key->email; ?></td>                  
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <div class="choose_your_need" id="your_requirement">
            <form action="" method="post" class="db_status_form">
                <h3><?php _e('Do you want your leads to store in database?', 'infobar'); ?>  </h3>  			 
                <?php
                global $wpdb;
                $v = get_option('dbStatus');
                $dbs = isset($_POST['dbstatusvalue']) ? $_POST['dbstatusvalue'] : null;
                if ($v == "" || $v == 'ystore' || $dbs == "ystore") {
                    ?>	                         
                    <input type="radio" name="dbstatusvalue" class="stored_yes" value="ystore" checked="check"> <?php _e('Yes', 'infobar'); ?> 
                    <input type="radio" name="dbstatusvalue" class="stored_no" value="nstore" ><?php _e('No', 'infobar'); ?>  </br> </br>                         
                <?php } else {
                    ?>
                    <input type="radio" name="dbstatusvalue" class="stored_yes" value="ystore" > <?php _e('Yes', 'infobar'); ?>  
                    <input type="radio" name="dbstatusvalue" class="stored_no" value="nstore"  checked="check"><?php _e('No', 'infobar'); ?>  </br> </br>         
                    <?php
                }
                ?>
                <input type="submit" class="button-primary db_store"  name="db_status" value="<?php _e('Save', 'infobar'); ?> ">
            </form>
            <form action="" method="post" class="download_form">                          
                <h3> <?php _e('Download List in File', 'infobar'); ?> </h3>                 
                <input type="radio" name="filetype" value="csv" checked="check">CSV<br>
                <input type="radio" name="filetype" value="word">Word<br>
                <input type="radio" name="filetype" value="pdf">PDF<br> <br>
                <input type="submit" class="button-primary"  name="download" value="<?php _e('Downlaod', 'infobar'); ?> ">
            </form>
        </div>
    </div>    


    <?php
}

if (isset($_POST['download'])) {
    $filetype = $_POST['filetype'];

    if ($filetype == 'csv') {
        header("Content-type: application/x-msdownload", true, 200);
        header("Content-Disposition: attachment; filename=subscriberlist.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        _e('Subscriber List', 'infobar');
        echo "\n";
        global $wpdb;
        $infobar_table_name = $wpdb->prefix . "nb_subscriber_list";
        $query = $wpdb->get_results("SELECT * FROM " . $infobar_table_name);
        foreach ($query as $row) {
            echo $row->id;
            echo "\x20\x20";
            echo $row->name;
            echo "\x20\x20";
            echo $row->email;
            echo "\n";
        }

        exit();
        unset($_POST);
    }
    if ($filetype == 'word') {
        header("Content-type: application/x-msdownload", true, 200);
        header("Content-Disposition: attachment; filename=subscriberlist.doc");
        header("Pragma: no-cache");
        header("Expires: 0");

        _e('Subscriber List', 'infobar');
        echo "\n";
        global $wpdb;
        $infobar_table_name = $wpdb->prefix . "nb_subscriber_list";
        $query = $wpdb->get_results("SELECT * FROM " . $infobar_table_name);
        foreach ($query as $row) {
            echo $row->id;
            echo "\x20\x20";
            echo $row->name;
            echo "\x20\x20";
            echo $row->email;
            echo "\n";
        }
        exit();
        unset($_POST);
    }

    if ($filetype == 'pdf') {
        header("Content-type: application/x-msdownload", true, 200);
        header("Content-Disposition: attachment; filename=subscriberlist.pdf");
        header("Pragma: no-cache");
        header("Expires: 0");

        _e('Subscriber List', 'infobar');
        echo "\n";
        global $wpdb;
        $infobar_table_name = $wpdb->prefix . "nb_subscriber_list";
        $query = $wpdb->get_results("SELECT * FROM " . $infobar_table_name);
        foreach ($query as $row) {
            echo $row->id;
            echo "\x20\x20";
            echo $row->name;
            echo "\x20\x20";
            echo $row->email;
            echo "\n";
        }
        exit();
        unset($_POST);
    }
}


if (isset($_POST['db_status'])) {
    $dbstatus = $_POST['dbstatusvalue'];
    update_option('dbStatus', $dbstatus);
    /* $page = $_SERVER['PHP_SELF'];
      $sec = "10";
      header("Refresh: $sec; url=$page"); */
}
?>
<?php
return array(
        'DEFAULT_CHARSET'       => 'utf-8', //
        //'DEFAULT_THEME' => 'my_theme',

        'APP_GROUP_LIST' => 'Home,Admin,DataManager,Test', // enable app group. there is no Space between group names
        'DEFAULT_GROUP' => 'Home', // default group
        //'APP_GROUP_MODE' => 1, //
        //'APP_GROUP_PATH' => 'Modules', //

        // template config
        'TMPL_VAR_IDENTIFY' => '', // 'array' or 'obj'
        'TMPL_FILE_DEPR' => '/' , // the separator used in template file between Module name and Action name
        'TMPL_TEMPLATE_SUFFIX' => '.php',
        'TMPL_PARSE_STRING' => array(
                '__PUBLIC__' => __ROOT__ ,
        ),
        'URL_HTML_SUFFIX' => '.html',
        'TMPL_PATH' => 'app/Tpl/',

        //
        'DEFAULT_FILTER' => 'htmlspecialchars',

        /* DB setting */
        'DB_TYPE'               => 'mysql',     //
        'DB_HOST'               => 'localhost', //
        'DB_NAME'               => 'test',          //
        'DB_USER'               => 'root',      //
        'DB_PWD'                => '',          //
        'DB_PORT'               => '',        //
        'DB_PREFIX'             => '',    //
        'DB_SQL_LOG'            => true, //

        'LOAD_EXT_CONFIG' => 'thirdParty', //
        'APP_AUTOLOAD_PATH' => '@.Pintag,@.Pinlib,@.ORG', //
        'LOAD_EXT_FILE'=>'AppTools',

 // session
 //'SESSION_TYPE' => 'DB',

);


/* EOF */

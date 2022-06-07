package com.rzkwsnj.stugate.config;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        Config.java
 * @package     Student Payment Validation System
 * @author      rzkwsnj <drg.rizkiwisnuaji@gmail.com>
 * @copyright   2022 rzkwsnj. All Rights Reserved.
 * @license     https://opensource.org/licenses/MIT
 * @version     Release: @1.0.0@
 * @framework   http://php.net
 *
 *
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 * This file may not be redistributed in whole or significant part.
 **/

public class Config
{
    public static String STUGATE_NODE = "STUGATE_APP";
    public static final String ROOT_URL = "http://127.0.0.1/stugate/"; //For retrofit base url must end with /
    public final static String STUGATE_DB_NAME = "Stugate.db";
    public static final String REST_API_VER = "v1.0";
    public static final String BASE_URL = ROOT_URL + "api/" + REST_API_VER + "/"; //For retrofit base url must end with /
    public static final String STUGATE_IMAGE_URL = ROOT_URL + "uploads/images/student_images/";
    public static final String FROM = "from";
    public static final String IS_USER_LOGIN = "is_user_login";
    public static final String USER_ID = "id";
    public static final String USER_NAME = "name";
    public static final String USER_EMAIL = "email";
    public static final String USER_PHONE = "cell";
    public static final String USER_ROLE = "user_type";
    public static final String SUCCESS = "success";
    public static final String FAILURE = "failure";
    public static final String POST_EMAIL = "email";
    public static final String POST_PASSWORD = "password";
    public static final String POST_CODE = "code";
}

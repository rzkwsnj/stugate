package com.rzkwsnj.stugate.models;

import com.google.gson.annotations.SerializedName;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        AuthLogin.java
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

public class AuthLogin {

    @SerializedName("id")
    private String id;

    @SerializedName("name")
    private String name;

    @SerializedName("cell")
    private String cell;

    @SerializedName("email")
    private String email;

    @SerializedName("password")
    private String password;

    @SerializedName("user_status")
    private String userStatus;

    @SerializedName("user_type")
    private String userType;

    @SerializedName("value")
    private String value;

    @SerializedName("message")
    private String message;

    public String getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getCell() {
        return cell;
    }

    public String getEmail() {
        return email;
    }

    public String getPassword() {
        return password;
    }

    public String getUserStatus() {
        return userStatus;
    }

    public String getUserType() {
        return userType;
    }

    public String getValue() {
        return value;
    }

    public String getMessage() {
        return message;
    }
}

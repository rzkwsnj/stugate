package com.rzkwsnj.stugate.sessions;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

import com.rzkwsnj.stugate.activities.LoginActivity;
import com.rzkwsnj.stugate.config.Config;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        SessionHelper.java
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

public class SessionHelper {
    public static final String PREFER_NAME = Config.STUGATE_NODE;
    final int PRIVATE_MODE = 0;
    SharedPreferences pref;
    SharedPreferences.Editor editor;
    Context _context;

    public SessionHelper(Context context) {
        try {
            this._context = context;
            pref = _context.getSharedPreferences(PREFER_NAME, PRIVATE_MODE);
            editor = pref.edit();
        } catch (Exception ignored) {

        }
    }

    public String getData(String id) {
        return pref.getString(id, "");
    }

    public void setData(String id, String val) {
        editor.putString(id, val);
        editor.commit();
    }

    public void setBoolean(String id, boolean val) {
        editor.putBoolean(id, val);
        editor.commit();
    }

    public boolean getBoolean(String id) {
        return pref.getBoolean(id, false);
    }

    public void createUserLoginSession(String id, String name, String email, String cell, String role) {
        editor.putBoolean(Config.IS_USER_LOGIN, true);
        editor.putString(Config.USER_ID, id);
        editor.putString(Config.USER_NAME, name);
        editor.putString(Config.USER_EMAIL, email);
        editor.putString(Config.USER_PHONE, cell);
        editor.putString(Config.USER_ROLE, role); //user_type
        editor.commit();
    }

    public void logoutUser(Activity activity) {
        editor.clear();
        editor.commit();

        new SessionHelper(_context).setBoolean("is_first_time", true);

        Intent i = new Intent(activity, LoginActivity.class);
        i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
        i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        i.putExtra(Config.FROM, "");
        activity.startActivity(i);
        activity.finish();
    }
}

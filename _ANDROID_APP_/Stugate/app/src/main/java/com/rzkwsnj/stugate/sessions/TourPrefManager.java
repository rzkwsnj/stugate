package com.rzkwsnj.stugate.sessions;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        TourPrefManager.java
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

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.SharedPreferences;

public class TourPrefManager {
    // Shared preferences file name
    private static final String PREF_NAME = "app-tour";
    private static final String IS_FIRST_TIME_LAUNCH = "IsFirstTimeLaunch";
    private final SharedPreferences pref;
    private final SharedPreferences.Editor editor;

    @SuppressLint("CommitPrefEdits")
    public TourPrefManager(Context context) {
        // shared pref mode
        int PRIVATE_MODE = 0;
        pref = context.getSharedPreferences(PREF_NAME, PRIVATE_MODE);
        editor = pref.edit();
    }

    public boolean isFirstTimeLaunch() {
        return pref.getBoolean(IS_FIRST_TIME_LAUNCH, true);
    }

    public void setFirstTimeLaunch(boolean isFirstTime) {
        editor.putBoolean(IS_FIRST_TIME_LAUNCH, isFirstTime);
        editor.commit();
    }

}

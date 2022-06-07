package com.rzkwsnj.stugate.activities;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.provider.Settings;
import android.util.Log;
import android.view.WindowManager;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.rzkwsnj.stugate.R;
import com.rzkwsnj.stugate.config.Config;
import com.rzkwsnj.stugate.helpers.AppUtilities;
import com.rzkwsnj.stugate.sessions.SessionHelper;

import java.util.HashMap;
import java.util.Map;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        SplashActivity.java
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

@SuppressLint("CustomSplashScreen")
public class SplashActivity
        extends AppCompatActivity {

    private static final int PERMISSION_REQUEST_CODE = 1240;
    @SuppressLint("StaticFieldLeak")
    public static SessionHelper session;
    // List all permission for the app
    String[] appPermission = {
            Manifest.permission.CAMERA,
            Manifest.permission.WRITE_EXTERNAL_STORAGE,
            Manifest.permission.INTERNET
    };

    @SuppressLint("SourceLockedOrientationActivity")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_splash);

        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);

        session = new SessionHelper(SplashActivity.this);
        if (AppUtilities.checkAndRequestPermission(this, appPermission, PERMISSION_REQUEST_CODE)) {
            initApp();
        }

    }

    private void initApp() {
        Thread splashTread = new Thread() {
            public void run() {
                try {
                    synchronized (this) {
                        wait(1000);
                    }
                } catch (InterruptedException e) {
                    e.printStackTrace();

                } finally {
                    if (session.getBoolean(Config.IS_USER_LOGIN)) {

                        Intent intent = new Intent(SplashActivity.this, MainActivity.class);
                        startActivity(intent);
                        finish();

                    } else {

                        runOnUiThread(() -> {
                            // TODO
                            Intent intent = new Intent(SplashActivity.this, TourActivity.class);
                            startActivity(intent);
                            finish();
                        });
                    }
                }
            }
        };
        splashTread.start();
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == PERMISSION_REQUEST_CODE) {
            HashMap<String, Integer> permissionResults = new HashMap<>();
            int deniedCount = 0;

            for (int i = 0; i < grantResults.length; i++) {
                if (grantResults[i] == PackageManager.PERMISSION_DENIED) {
                    permissionResults.put(permissions[i], grantResults[i]);
                    deniedCount++;
                }
            }

            if (deniedCount == 0) {

                initApp();

            } else {

                for (Map.Entry<String, Integer> entry : permissionResults.entrySet()) {
                    String permName = entry.getKey();
                    int permResult = entry.getValue();

                    if (ActivityCompat.shouldShowRequestPermissionRationale(this, permName)) {
                        AppUtilities.showDialog(
                                this, "", "This app need permissions !", "yes, Grant Permissions",
                                (dialogInterface, i) -> {
                                    dialogInterface.dismiss();
                                    AppUtilities.checkAndRequestPermission(SplashActivity.this, appPermission, PERMISSION_REQUEST_CODE);
                                },
                                "No, Exit App",
                                (dialogInterface, i) -> {
                                    dialogInterface.dismiss();
                                    finish();
                                }, false);
                    } else {
                        AppUtilities.showDialog(
                                this, "", "You've denied some permissions !", "Go to settings",
                                (dialogInterface, i) -> {
                                    dialogInterface.dismiss();
                                    Intent intent = new Intent(Settings.ACTION_APPLICATION_DETAILS_SETTINGS, Uri.fromParts("package", getPackageName(), null));
                                    intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    startActivity(intent);
                                    finish();
                                },
                                "No, Exit App",
                                (dialogInterface, i) -> {
                                    dialogInterface.dismiss();
                                    finish();
                                }, false);
                        break;
                    }
                }

            }

        }
    }

    @Override
    public void onStart() {
        super.onStart();

        if (!AppUtilities.hasConnection(this)) {
            AppUtilities.showAlertView(
                    this,
                    R.string.network_error,
                    R.string.no_network_connection);
            return;
        }

        Log.i("Info", "ON START");

    }

    @Override
    public void onResume() {
        super.onResume();

        if (!AppUtilities.hasConnection(this)) {
            AppUtilities.showAlertView(
                    this,
                    R.string.network_error,
                    R.string.no_network_connection);
            return;
        }

        Log.i("Info", "ON RESUME");

    }

    @Override
    public void onBackPressed() {
        if (getSupportFragmentManager().getBackStackEntryCount() > 0) {
            getSupportFragmentManager().popBackStack();
        } else {
            finish();
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        System.gc();
    }

}


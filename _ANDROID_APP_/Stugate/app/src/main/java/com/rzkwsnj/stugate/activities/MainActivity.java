package com.rzkwsnj.stugate.activities;

import static android.net.ConnectivityManager.CONNECTIVITY_ACTION;
import static com.gitonway.lee.niftymodaldialogeffects.lib.Effectstype.Slidetop;

import android.annotation.SuppressLint;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.ActivityInfo;
import android.media.MediaPlayer;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.app.ActivityCompat;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.gitonway.lee.niftymodaldialogeffects.lib.NiftyDialogBuilder;
import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.navigation.NavigationView;
import com.rzkwsnj.stugate.R;
import com.rzkwsnj.stugate.config.Config;
import com.rzkwsnj.stugate.helpers.ApiClient;
import com.rzkwsnj.stugate.helpers.ApiInterface;
import com.rzkwsnj.stugate.helpers.AppUtilities;
import com.rzkwsnj.stugate.models.Data;
import com.rzkwsnj.stugate.sessions.SessionHelper;

import java.util.Objects;

import es.dmoral.toasty.Toasty;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        MainActivity.java
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

public class MainActivity
        extends AppCompatActivity
        implements ActivityCompat.OnRequestPermissionsResultCallback,
        NavigationView.OnNavigationItemSelectedListener, View.OnClickListener {

    private static final String TAG = "MainActivity";
    private static final String LOG_TAG = "CheckNetworkStatus";
    @SuppressLint("StaticFieldLeak")
    public static SessionHelper session;
    private static ProgressDialog loading;
    TextView txtUserName, txtUserRole;
    Button btnCloseBottomSheet;
    LinearLayout layoutBottomSheet;
    BottomSheetBehavior sheetBehavior;
    Dialog dialog;
    boolean doubleBackToExitPressedOnce = false;
    private TextView txtStatus, txtName, txtCode, txtContent;
    private ImageView imgData;
    private ProgressBar progressBarImage;
    private DrawerLayout appDrawerLayout;
    private boolean isConnected = false;

    @SuppressLint({"SourceLockedOrientationActivity", "SetTextI18n"})
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
        this.setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR_PORTRAIT);

        // APP TOOLBAR
        Toolbar appToolbar = findViewById(R.id.toolbar);
        setSupportActionBar(appToolbar);
        Objects.requireNonNull(getSupportActionBar()).setDisplayShowTitleEnabled(false);
        assert appToolbar != null;
        appToolbar.setTitle("");
        appToolbar.setSubtitle("");

        // APP DRAWER
        appDrawerLayout = findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle appDrawerToggle = new ActionBarDrawerToggle(
                this,
                appDrawerLayout,
                appToolbar,
                R.string.navigation_drawer_open,
                R.string.navigation_drawer_close
        );
        assert appDrawerLayout != null;
        appDrawerLayout.addDrawerListener(appDrawerToggle);
        appDrawerToggle.syncState();

        // APP NAVIGATION VIEW
        NavigationView appNavigationView = findViewById(R.id.nav_view);
        assert appNavigationView != null;
        appNavigationView.setNavigationItemSelectedListener(this);

        IntentFilter filter = new IntentFilter(CONNECTIVITY_ACTION);
        NetworkChangeReceiver receiver = new NetworkChangeReceiver();
        registerReceiver(receiver, filter);

        // USER DATA
        session = new SessionHelper(MainActivity.this);
        txtUserName = findViewById(R.id.txt_user_name);
        txtUserRole = findViewById(R.id.txt_user_role);
        if (session.getBoolean(Config.IS_USER_LOGIN)) {
            txtUserName.setText("Hi, " + session.getData(Config.USER_NAME));
            txtUserRole.setText(session.getData(Config.USER_ROLE));
        }

        // APP BOTTOM SHEET
        layoutBottomSheet = findViewById(R.id.bottom_sheet);
        btnCloseBottomSheet = findViewById(R.id.btnCloseBottomSheet);
        sheetBehavior = BottomSheetBehavior.from(layoutBottomSheet);
        txtStatus = findViewById(R.id.txtStatus);
        txtName = findViewById(R.id.txtName);
        txtCode = findViewById(R.id.txtCode);
        txtContent = findViewById(R.id.txtContent);
        imgData = findViewById(R.id.imgData);
        progressBarImage = findViewById(R.id.progress_header);

        layoutBottomSheet.setVisibility(View.INVISIBLE);
        btnCloseBottomSheet.setOnClickListener(this);

        sheetBehavior.setBottomSheetCallback(new BottomSheetBehavior.BottomSheetCallback() {
            @SuppressLint("SetTextI18n")
            @Override
            public void onStateChanged(@NonNull View bottomSheet, int newState) {
                switch (newState) {
                    case BottomSheetBehavior.STATE_HIDDEN:
                    case BottomSheetBehavior.STATE_DRAGGING:
                    case BottomSheetBehavior.STATE_SETTLING:
                    case BottomSheetBehavior.STATE_HALF_EXPANDED:
                        break;
                    case BottomSheetBehavior.STATE_EXPANDED: {
                        btnCloseBottomSheet.setText("Close Sheet");
                    }
                    break;
                    case BottomSheetBehavior.STATE_COLLAPSED: {
                        btnCloseBottomSheet.setText("Expand Sheet");
                    }
                    break;
                }
            }

            @Override
            public void onSlide(@NonNull View bottomSheet, float slideOffset) {

            }
        });

        findViewById(R.id.btnScanData).setOnClickListener(this);

        if (savedInstanceState == null) {

            Log.i("Info", "Dashboard");

        }

        // If a notification message is tapped, any data accompanying the notification
        // message is available in the intent extras. In this sample the launcher
        // intent is fired when the notification is tapped, so any accompanying data would
        // be handled here. If you want a different intent fired, set the click_action
        // field of the notification message to the desired intent. The launcher intent
        // is used when no click_action is specified.
        //
        // Handle possible data accompanying notification message.
        // [START handle_data_extras]
        if (getIntent().getExtras() != null) {
            for (String key : getIntent().getExtras().keySet()) {
                String value = getIntent().getExtras().getString(key);
                Log.i(TAG, "Key: " + key + " Value: " + value);
            }
        }
        // [END handle_data_extras]

    }

    @Override
    public void onClick(View v) {
        int i = v.getId();
        if (i == R.id.btnScanData) {
            Intent intent = new Intent(getApplicationContext(), ScanQRActivity.class);
            startActivityForResult(intent, 101);
            layoutBottomSheet.setVisibility(View.INVISIBLE);
        }

        if (i == R.id.btnCloseBottomSheet) {
            if (sheetBehavior.getState() != BottomSheetBehavior.STATE_COLLAPSED) {
                sheetBehavior.setState(BottomSheetBehavior.STATE_COLLAPSED);
                layoutBottomSheet.setVisibility(View.INVISIBLE);
            }
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (resultCode == 101) {
            final MediaPlayer mp = MediaPlayer.create(this, R.raw.beep);
            mp.start();

            loading = new ProgressDialog(this);
            loading.setCancelable(false);
            loading.setMessage(getString(R.string.please_wait));
            loading.show();

            mp.stop();

            ApiInterface apiInterface = ApiClient.getApiClient().create(ApiInterface.class);

            Call<Data> call = apiInterface.getdata(data.getStringExtra("RESP_CODE"));
            call.enqueue(new Callback<Data>() {
                @SuppressLint("SetTextI18n")
                @Override
                public void onResponse(@NonNull Call<Data> call, @NonNull Response<Data> response) {

                    if (response.body() != null && response.isSuccessful() && response.body().getValue().equals(Config.SUCCESS)) {
                        String value = response.body().getValue();
                        String message = response.body().getMessage();
                        String name = response.body().getStudentName();
                        String code = response.body().getStudentCode();
                        String department = response.body().getStudentDepartment();
                        String level = response.body().getStudentLevel();
                        String image = response.body().getStudentImage();
                        String status = response.body().getStudentStatus();
                        String sessionPaid = response.body().getStudentSessionPaid();

                        if (value.equals(Config.SUCCESS)) {
                            loading.dismiss();
                            layoutBottomSheet.setVisibility(View.VISIBLE);
                            txtStatus.setText(status);
                            if (status.equals("PAID")) {
                                txtStatus.setTextColor(getResources().getColor(R.color.green));
                            } else {
                                txtStatus.setTextColor(getResources().getColor(R.color.colorPrimary));
                            }
                            txtName.setText(name);
                            txtCode.setText(department + " / " + level);
                            txtContent.setText(sessionPaid + " Academic Session");
                            progressBarImage.setVisibility(View.VISIBLE);
                            Glide.with(getApplicationContext())
                                    .load(Config.STUGATE_IMAGE_URL + image)
                                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                                    .error(R.drawable.qrcodeiphoneicon)
                                    .fallback(R.drawable.qrcodeiphoneicon)
                                    .skipMemoryCache(true) //2
                                    .fitCenter()
                                    .into(imgData);
                            progressBarImage.setVisibility(View.GONE);
                            Log.e("RESPONSE CODE", "" + data.getStringExtra("RESP_CODE"));

                        } else {

                            loading.dismiss();
                            dialog = new Dialog(MainActivity.this);
                            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                            dialog.setContentView(R.layout.content_code_not_found);
                            dialog.setCanceledOnTouchOutside(false);

                            Button back = dialog.findViewById(R.id.back);
                            back.setOnClickListener(v -> dialog.dismiss());

                            dialog.show();

                        }

                    } else {

                        loading.dismiss();
                        Toasty.error(MainActivity.this, "Something went wrong !", Toast.LENGTH_LONG).show();
                    }
                }

                @Override
                public void onFailure(@NonNull Call<Data> call, @NonNull Throwable t) {

                    loading.dismiss();
                    Toasty.error(MainActivity.this, Objects.requireNonNull(t.getLocalizedMessage()), Toast.LENGTH_LONG).show();

                }
            });

        }

    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem menuItem) {
        // Handle navigation view item clicks here.
        int id = menuItem.getItemId();

        if (id == R.id.nav_dashboard) {

            Log.i("Info", "Dashboard with ID : " + id);

        } else if (id == R.id.nav_about) {

            Log.i("Info", "About App with ID : " + id);

            dialog = new Dialog(MainActivity.this);
            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            dialog.setContentView(R.layout.content_about);
            dialog.setCanceledOnTouchOutside(false);

            Button back = dialog.findViewById(R.id.back);
            back.setOnClickListener(v -> dialog.dismiss());

            dialog.show();

        } else if (id == R.id.nav_term_condition) {

            Log.i("Info", "Terms & Conditions with ID : " + id);

            dialog = new Dialog(MainActivity.this);
            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            dialog.setContentView(R.layout.content_tc);
            dialog.setCanceledOnTouchOutside(false);

            Button back = dialog.findViewById(R.id.back);
            back.setOnClickListener(v -> dialog.dismiss());

            dialog.show();

        } else if (id == R.id.nav_logout) {

            NiftyDialogBuilder dialogBuilder = NiftyDialogBuilder.getInstance(MainActivity.this);
            dialogBuilder
                    .withTitle(getString(R.string.title_alert_confirm_logout))
                    .withMessage(R.string.msg_alert_confirm_logout)
                    .withEffect(Slidetop)
                    .withDialogColor("#ff0000") //use color code for dialog
                    .withButton1Text(getString(R.string.action_yes))
                    .withButton2Text(getString(R.string.cancel))
                    .setButton1Click(v12 -> {
                        session.logoutUser(MainActivity.this);
                        dialogBuilder.dismiss();
                    })
                    .setButton2Click(v1 -> dialogBuilder.dismiss())
                    .show();

        }

        appDrawerLayout = findViewById(R.id.drawer_layout);

        assert appDrawerLayout != null;
        appDrawerLayout.closeDrawer(GravityCompat.START);

        return true;
    }

    @Override
    public void onBackPressed() {
        layoutBottomSheet.setVisibility(View.INVISIBLE);
        appDrawerLayout = findViewById(R.id.drawer_layout);
        assert appDrawerLayout != null;

        if (appDrawerLayout.isDrawerOpen(GravityCompat.START)) {

            appDrawerLayout.closeDrawer(GravityCompat.START);

        } else {

            if (doubleBackToExitPressedOnce) {
                super.onBackPressed();
                return;
            }

            this.doubleBackToExitPressedOnce = true;
            Toast.makeText(this, "Please click BACK again to exit", Toast.LENGTH_SHORT).show();

            new Handler().postDelayed(new Runnable() {

                @Override
                public void run() {
                    doubleBackToExitPressedOnce = false;
                }
            }, 2000);

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
    public void onStop() {

        super.onStop();

        Log.i("Info", "ON STOP");

    }

    @Override
    public void onDestroy() {
        super.onDestroy();

        Log.i("Info", "ON DESTROY");
    }

    public class NetworkChangeReceiver extends BroadcastReceiver {

        @Override
        public void onReceive(final Context context, final Intent intent) {

            Log.v(LOG_TAG, "Received notification about network status");
            isNetworkAvailable(context);

        }


        private void isNetworkAvailable(Context context) {
            ConnectivityManager connectivity = (ConnectivityManager)
                    context.getSystemService(Context.CONNECTIVITY_SERVICE);
            if (connectivity != null) {
                NetworkInfo[] info = connectivity.getAllNetworkInfo();
                if (info != null) {
                    for (NetworkInfo networkInfo : info) {
                        if (networkInfo.getState() == NetworkInfo.State.CONNECTED) {
                            if (!isConnected) {
                                Log.v(LOG_TAG, "Now you are connected to Internet!");
                                isConnected = true;
                                //do your processing here ---
                                //if you need to post any data to the server or get status
                                //update from the server
                            }
                            return;
                        }
                    }
                }
            }
            Log.v(LOG_TAG, "You are not connected to Internet!");
            // TODO: Alert Dialog !
            isConnected = false;
        }
    }

}

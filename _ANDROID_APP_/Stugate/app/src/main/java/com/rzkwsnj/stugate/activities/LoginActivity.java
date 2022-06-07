package com.rzkwsnj.stugate.activities;

import static android.net.ConnectivityManager.CONNECTIVITY_ACTION;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.ActivityInfo;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.util.Log;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.rzkwsnj.stugate.BuildConfig;
import com.rzkwsnj.stugate.R;
import com.rzkwsnj.stugate.config.Config;
import com.rzkwsnj.stugate.helpers.ApiClient;
import com.rzkwsnj.stugate.helpers.ApiInterface;
import com.rzkwsnj.stugate.helpers.AppUtilities;
import com.rzkwsnj.stugate.models.AuthLogin;
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
 * @file        LoginActivity.java
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

public class LoginActivity
        extends AppCompatActivity {

    public static final String TAG = LoginActivity.class.getSimpleName();
    private static final String LOG_TAG = "CheckNetworkStatus";
    //for double back press to exit
    private static final int TIME_DELAY = 2000;
    private static long backPressed;
    private static ProgressDialog loading;
    SessionHelper session;
    EditText etxtEmail, etxtPassword;
    TextView txtLogin, txtVersion;
    private boolean isConnected = false;

    @SuppressLint({"SetTextI18n", "SourceLockedOrientationActivity"})
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
        this.setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_SENSOR_PORTRAIT);
        IntentFilter filter = new IntentFilter(CONNECTIVITY_ACTION);
        NetworkChangeReceiver receiver = new NetworkChangeReceiver();
        registerReceiver(receiver, filter);
        session = new SessionHelper(getApplicationContext());

        etxtEmail = findViewById(R.id.etxt_email);
        etxtPassword = findViewById(R.id.etxt_password);
        txtLogin = findViewById(R.id.txt_login);
        txtVersion = findViewById(R.id.txt_version);

        txtVersion.setText(getResources().getString(R.string.app_name) + " Ver." + BuildConfig.VERSION_NAME);

        txtLogin.setOnClickListener(v -> {
            String emailIn = etxtEmail.getText().toString().trim();
            String passwordIn = etxtPassword.getText().toString().trim();

            if (!emailIn.contains("@") || !emailIn.contains(".")) {
                etxtEmail.setError(getString(R.string.error_invalid_email));
                etxtEmail.requestFocus();
            } else if (passwordIn.isEmpty()) {
                etxtPassword.setError(getString(R.string.prompt_password));
                etxtPassword.requestFocus();
            } else {


                if (AppUtilities.hasConnection(LoginActivity.this)) {
                    stugateLoginWithEmailPassword(emailIn, passwordIn);
                } else {
                    Toast.makeText(this, R.string.no_network_connection, Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    private void stugateLoginWithEmailPassword(String email, String password) {

        loading = new ProgressDialog(this);
        loading.setCancelable(false);
        loading.setMessage(getString(R.string.please_wait));
        loading.show();

        ApiInterface apiInterface = ApiClient.getApiClient().create(ApiInterface.class);

        Call<AuthLogin> call = apiInterface.login(email, password);
        call.enqueue(new Callback<AuthLogin>() {
            @Override
            public void onResponse(@NonNull Call<AuthLogin> call, @NonNull Response<AuthLogin> response) {

                if (response.body() != null && response.isSuccessful() && response.body().getValue().equals(Config.SUCCESS)) {
                    String value = response.body().getValue();
                    String message = response.body().getMessage();
                    String id = response.body().getId();
                    String name = response.body().getName();
                    String cell = response.body().getCell();
                    String email = response.body().getEmail();
                    String password = response.body().getPassword();
                    String status = response.body().getUserStatus();
                    String role = response.body().getUserType();

                    if (value.equals(Config.SUCCESS)) {
                        loading.dismiss();


                        session.createUserLoginSession(
                                id,
                                name,
                                email,
                                cell,
                                role
                        );

                        Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                        startActivity(intent);
                        finish();

                    } else {

                        loading.dismiss();
                        Toasty.error(LoginActivity.this, message, Toast.LENGTH_LONG).show();

                    }

                } else {

                    loading.dismiss();
                    Toasty.error(LoginActivity.this, "Something went wrong !", Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onFailure(@NonNull Call<AuthLogin> call, @NonNull Throwable t) {

                loading.dismiss();
                Toasty.error(LoginActivity.this, Objects.requireNonNull(t.getLocalizedMessage()), Toast.LENGTH_LONG).show();

            }
        });

    }

    @Override
    public void onBackPressed() {
        if (backPressed + TIME_DELAY > System.currentTimeMillis()) {

            finishAffinity();

        } else {
            Toast.makeText(this, "Please click BACK again to exit", Toast.LENGTH_SHORT).show();
        }
        backPressed = System.currentTimeMillis();
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
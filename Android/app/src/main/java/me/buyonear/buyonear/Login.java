package me.buyonear.buyonear;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.Signature;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.HandlerThread;
import android.os.Looper;
import android.os.Message;
import android.os.StrictMode;
import android.preference.PreferenceManager;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.telephony.TelephonyManager;
import android.util.Base64;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import  com.facebook.FacebookSdk;
import com.facebook.login.LoginResult;
import com.facebook.login.widget.LoginButton;

/*
import com.example.ikechukwu.trolley.model.internet.JSONTest;
import com.example.ikechukwu.trolley.model.internet.LoginAttempt;
*/
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import me.buyonear.buyonear.internet.LoginAttempt;


public class Login extends AppCompatActivity {

    private Handler uiHandler;

    private EditText loginText;
    private EditText passwordText;
    private Button loginButton;
    private LoginButton facebookButton;

    private String name;
    private String handle;
    private String loginTime;
    private boolean loggedIn = false;
    private String deviceID;
    private SharedPreferences settings;
    private SharedPreferences.Editor editor;

    private static final String LOGGED_IN = "logged in";
    private static final String DRIVER_HANDLE = "handle";
    private static final String DRIVER_NAME = "name";
    private static final String TIME_LOGGED = "time_logged";

    private CallbackManager callbackManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        FacebookSdk.sdkInitialize(getApplicationContext());
        callbackManager = CallbackManager.Factory.create();

        settings = PreferenceManager.getDefaultSharedPreferences(this);
        editor = settings.edit();
        if (preferencesCheckOut()) {

            Intent intent = new Intent(Login.this, LandingPage.class);
            intent.putExtra("Handle", settings.getString(DRIVER_HANDLE, "-1"));
            intent.putExtra("Name", settings.getString(DRIVER_NAME, "-1"));
            intent.putExtra("Time Logged", settings.getString(TIME_LOGGED, "-1"));

            startActivity(intent);
        }

        getSupportActionBar().hide();
        setContentView(R.layout.activity_login);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        loginText = (EditText) findViewById(R.id.login_handle);
        passwordText = (EditText) findViewById(R.id.login_password);
        loginButton = (Button) findViewById(R.id.login_button);
        facebookButton = (LoginButton)findViewById(R.id.facebook_button);

        uiHandler = new Handler();

        loginButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                Thread loginThread = new Thread(new Runnable() {

                    @Override
                    public void run() {

                        uiHandler.post(new Runnable() {
                            @Override
                            public void run() {

                                login();
                            }
                        });

                    }
                });
                loginThread.start();


            }
        });

        facebookButton.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {

            @Override
            public void onSuccess(LoginResult loginResult) {

                Log.e("FB CALLBACK", "Success logging in");
                fbLogin(loginResult.getAccessToken().getUserId(), loginResult.getAccessToken().getToken());
            }

            @Override
            public void onCancel() {

            }

            @Override
            public void onError(FacebookException e) {

            }
        });

        try {
            PackageInfo info = getPackageManager().getPackageInfo(
                    "me.buyonear.buyonear", PackageManager.GET_SIGNATURES);
            for (Signature signature : info.signatures) {
                MessageDigest md = MessageDigest.getInstance("SHA");
                md.update(signature.toByteArray());
                Log.i("KeyHash:",
                        Base64.encodeToString(md.digest(), Base64.DEFAULT));
            }
        } catch (PackageManager.NameNotFoundException e) {

        } catch (NoSuchAlgorithmException e) {

        }
    }

    private boolean preferencesCheckOut() {

        return settings.getBoolean(LOGGED_IN, false) &&
                settings.getString(DRIVER_NAME, null) != null &&
                settings.getString(DRIVER_HANDLE, null) != null;
    }

    private void fbLogin(String userId, String token) {

        String handle = loginText.getText().toString().trim();
        String password = passwordText.getText().toString().trim();


        if (handle.isEmpty() || password.isEmpty()) {
            Toast.makeText(Login.this, "Enter all fields", Toast.LENGTH_SHORT).show();
        }
        /*
        FBLoginAttempt attempt = new FBLoginAttempt(Login.this);
        String serverResult = attempt.doInBackground(handle, password, deviceID);
        attempt.onPostExecute(serverResult);

        if (loggedIn) {

            Intent intent = new Intent(Login.this, LandingPage.class);
            intent.putExtra("Handle", Login.this.handle);
            intent.putExtra("Time logged", Login.this.loginTime);

            startActivity(intent);
            finish();
        } else {

            Toast.makeText(Login.this, "Invalid login details", Toast.LENGTH_LONG).show();
        }*/
    }

    private void login() {

        String handle = loginText.getText().toString().trim();
        String password = passwordText.getText().toString().trim();


        if (handle.isEmpty() || password.isEmpty()) {
            Toast.makeText(Login.this, "Enter all fields", Toast.LENGTH_SHORT).show();
        }
        LoginAttempt attempt = new LoginAttempt(Login.this);
        String serverResult = attempt.doInBackground(handle, password, deviceID);
        attempt.onPostExecute(serverResult);

        if (loggedIn) {

            Intent intent = new Intent(Login.this, LandingPage.class);
            intent.putExtra("Handle", Login.this.handle);
            intent.putExtra("Name", Login.this.name);
            intent.putExtra("Time logged", Login.this.loginTime);

            startActivity(intent);
            finish();
        } else {

            Toast.makeText(Login.this, "Invalid login details", Toast.LENGTH_LONG).show();
        }
    }

    public void setInfo (String name, String handle, String loginTime) {

        this.name = name;
        this.handle = handle;
        this.loginTime = loginTime;
        this.loggedIn = true;

        editor.putBoolean(LOGGED_IN, true);
        editor.putString(DRIVER_NAME, this.name);
        editor.putString(DRIVER_HANDLE, this.handle);
        editor.putString(TIME_LOGGED, this.loginTime);

        editor.commit();
    }



    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_login, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}

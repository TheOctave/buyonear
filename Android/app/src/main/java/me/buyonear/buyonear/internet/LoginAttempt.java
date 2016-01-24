package me.buyonear.buyonear.internet;

import android.util.Log;

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

import me.buyonear.buyonear.Login;

/**
 * Created by Ikechukwu on 6/23/2015.
 */
public class LoginAttempt {
    private String loginLink = "http://192.168.56.1//jumbotron/register";
//    private String loginLink = "http://172.20.10.4/backtrolley/login";
//    private String loginLink = "http://192.168.1.101/backtrolley/login";
    private Login loginActivity;

    public LoginAttempt(Login activity) {

        this.loginActivity = activity;
    }

    public String doInBackground(String... params) {

        try {
            String handle = params[0];
            String password = params[1];

            Log.e("DEBUG", "TRYING TO CONNECT TO DATABASE");

            String data = URLEncoder.encode("handle", "UTF-8") + "=" + URLEncoder.encode(handle, "UTF-8") + "&"
                    + URLEncoder.encode("password", "UTF-8") + "=" + URLEncoder.encode(password, "UTF-8");

            URL url = new URL(loginLink);
            URLConnection conn = url.openConnection();

            conn.setDoOutput(true);
            OutputStreamWriter out = new OutputStreamWriter(conn.getOutputStream());

            out.write(data);
            out.flush();

            BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            StringBuilder sb = new StringBuilder("");
            String line = null;

            while ((line = br.readLine()) != null) {

                sb.append(line);
            }

            return sb.toString();
        } catch (UnsupportedEncodingException e) {
            Log.e("Login error", e.getMessage());
            return e.getMessage();
        } catch (MalformedURLException e) {
            Log.e("Login error", e.getMessage());
            return e.getMessage();
        } catch (IOException e) {
            Log.e("Login error", e.getMessage());
            return e.getMessage();
        }
    }

    public void onPostExecute (String result) {

        Log.e("Signin", result);
        if (JSONTest.isJSONValid(result)) {

            try {
                JSONObject jsonObject = new JSONObject(result);
                if (jsonObject.getString("status").equals("success")) {

                    String user = jsonObject.getString("user");
                    String name = jsonObject.getString("name");
                    String time = jsonObject.getString("time");

                    loginActivity.setInfo(name, user, time);
                    Log.e("Login onPostExecute", "Login Test passed");
                } else {

                    Log.e("Login onPostExecute", "Invalid login details");
                }
            } catch (JSONException e) {

                Log.e("Login onPostExecute", e.getMessage());
            } catch (NullPointerException e) {

            }
        } else {

            Log.e("Login onPostExecute", "Failed JSON TEST");
        }
    }
}

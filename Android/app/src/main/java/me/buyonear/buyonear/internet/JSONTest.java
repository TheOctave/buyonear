package me.buyonear.buyonear.internet;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by Ikechukwu on 6/24/2015.
 */
public class JSONTest {

    public static boolean isJSONValid(String text) {

        try {

            new JSONObject(text);
        } catch (JSONException e) {

            try {

                new JSONArray(text);
            } catch (JSONException ex) {

                return false;
            }
        }

        return true;
    }
}

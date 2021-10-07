package com.example.blog;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class LoginActivity extends AppCompatActivity {
    EditText ed1,ed2;
    String username,password,name;
    String logout_token,csrf_token,cookie;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        ed1 = (EditText) findViewById(R.id.username);
        ed2 = (EditText) findViewById(R.id.password);
    }

    private class LoginProcess extends AsyncTask<String, Integer, String> {
        @Override
        protected String doInBackground(String... strings) {

            username = ed1.getText().toString().trim();
            password = ed2.getText().toString().trim();
            if (username == "" || password == "") {
                Toast.makeText(LoginActivity.this, "Please fill the required fields", Toast.LENGTH_LONG).show();
            }
            else {

                String url = "https://dev-team-shivaji.pantheonsite.io/user/login?_format=json";

                RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
                JSONObject jsonobject = new JSONObject();

                try {
                    jsonobject.put("name", username);
                    jsonobject.put("pass", password);
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.POST, url, jsonobject, new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {

                        Log.e("Rest Response", response.toString());

                        try {
                            String json = response.toString();
                            JSONObject obj = new JSONObject(json);
                            name= obj.getJSONObject("current_user").getString("name");//(current user)

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        Toast.makeText(LoginActivity.this, "Welcome "+name, Toast.LENGTH_LONG).show();

                        try {
                            logout_token = response.getString("logout_token");
                            csrf_token = response.getString("csrf_token");
                            Log.i("token", logout_token);
                            Log.i("csrf_token", csrf_token);

                            Intent intent = new Intent(LoginActivity.this, ListActivity.class);
                            //pass the session_id and session_name to ListActivity

                            intent.putExtra("csrf_token", csrf_token);
                            intent.putExtra("logout_token", logout_token);
                            intent.putExtra("cookie", cookie);
                            intent.putExtra("credentials",username+":"+password);

                            startActivity(intent);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }


                    }
                }, new Response.ErrorListener() {

                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("Rest Response", error.toString());

                        Toast.makeText(LoginActivity.this, error.toString(), Toast.LENGTH_LONG).show();
                    }
                }) {
                    @Override
                    public Map<String, String> getHeaders() throws AuthFailureError {
                        Map<String, String> headers = new HashMap<>();
                        headers.put("Content-Type", "application/json");

                        return headers;
                    }

                    @Override
                    protected Response<JSONObject> parseNetworkResponse(NetworkResponse response) {
                        Log.e("msg:","parsed method");
                        Log.i("response", response.headers.toString());
                        Map<String, String> responseHeaders = response.headers;
                        String rawCookies = responseHeaders.get("Set-Cookie");
                        Log.i("cookies", rawCookies);

                        String[] temp = rawCookies.split(";");
                        for (String ar1 : temp) {
                            // ar1.contains(CookieName)
                            String[] temp1 = ar1.split("=");
                            String CookieValue = temp1[1];
                            Log.i("cookie value", CookieValue);
                            Log.i("cookie name", temp1[0]);
                            cookie = temp1[0] + CookieValue;
                            Log.i("cookie", cookie);
                            break;

                        }

                        return super.parseNetworkResponse(response);

                    }


                };

                requestQueue.add(jsonObjReq);
            }

            return "finished";
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            Log.e("msg:","onPost method");

        }
    }

    public void onLogin(View v) {
        new LoginProcess().execute();
    }

    public void onRegister(View v){

        Intent intent = new Intent(this, RegisterActivity.class);
        startActivity(intent);
    }


}

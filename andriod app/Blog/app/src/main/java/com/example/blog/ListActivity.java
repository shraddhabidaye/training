package com.example.blog;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class ListActivity extends AppCompatActivity {

    String cookie,csrf_token,logout_token,credentials;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list);
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            cookie = extras.getString("cookie");
            Log.i("cookie",cookie);

            csrf_token = extras.getString("csrf_token");
            logout_token =extras.getString("logout_token");
            credentials = extras.getString("credentials");
            Log.i("csrf",csrf_token);
            Log.i("logout",logout_token);
            Log.i("credentials",credentials);
        }
    }

    public void onClick(View v){
        TextView textView = findViewById(R.id.name);
        //get the ListView UI element
        ListView lst = (ListView)  findViewById(R.id.ListView1);

        //create the ArrayList to store the titles of nodes
        ArrayList<String> listItems=new ArrayList<String>();


        String URL = "https://dev-team-shivaji.pantheonsite.io/api/blog_list?_format=json";
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        JsonObjectRequest objectRequest = new JsonObjectRequest(Request.Method.GET, URL, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        Log.e("Rest Response", response.toString());
                        try {
                            JSONArray arrayResult = response.getJSONArray("response");
                            for(int i=0;i<arrayResult.length();i++)
                            {
                                listItems.add(arrayResult.getJSONObject(i).getString("title").toString());

                            }
                            ArrayAdapter ad= new ArrayAdapter(ListActivity.this, android.R.layout.simple_list_item_1,listItems);

                            //give adapter to ListView UI element to render
                            lst.setAdapter(ad);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("Rest Response", error.toString());
                        Toast.makeText(ListActivity.this, error.toString(), Toast.LENGTH_SHORT).show();

                    }
                })
        {

            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> headers = new HashMap<>();

                headers.put("X-CSRF-Token",csrf_token);
                headers.put("Content-Type", "application/json");
                headers.put("Cookie", cookie);
                String auth = "Basic "+ Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);
                headers.put("Authorization", auth);
                return headers;
            }

        };

        requestQueue.add(objectRequest);


    }
    public void newBlogClick(View v){
        //create intent to start AddArticle activity
        Intent intent = new Intent(this, CreateBlogActivity.class);
        intent.putExtra("cookie",cookie);
        intent.putExtra("csrf_token",csrf_token);
        intent.putExtra("logout_token",logout_token);
        intent.putExtra("credentials",credentials);

        //start the AddArticle activity
        startActivity(intent);
    }
    public void onLogout(View v)
   {
        String URL = "https://dev-team-shivaji.pantheonsite.io/user/logout?_format=json&token="+logout_token.toString();
        Log.i("url:",URL);
        RequestQueue requestQueue1 = Volley.newRequestQueue(this);
        JsonObjectRequest objectRequest1 = new JsonObjectRequest(Request.Method.POST, URL, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        Log.e("Rest Response", response.toString());

                        Intent intent = new Intent(ListActivity.this, LoginActivity.class);

                        startActivity(intent);

                    }

                },
                new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e("Error",error.toString());

            }
        })
        {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> headers = new HashMap<>();

                headers.put("X-CSRF-Token",csrf_token);
                headers.put("Content-Type", "application/json");
                String auth = "Basic "+ Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);
                headers.put("Authorization", auth);
                headers.put("Cookie", cookie);


                return headers;
            }


        };
        requestQueue1.add(objectRequest1);
        Intent intent = new Intent(ListActivity.this,LoginActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }

    public interface Authenticator{

    }
}
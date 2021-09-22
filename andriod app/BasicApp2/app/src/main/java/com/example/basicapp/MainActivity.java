package com.example.basicapp;

import android.content.Intent;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }
    public void onClick(View v){
        TextView textView = findViewById(R.id.textView2);
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
                        ArrayAdapter ad= new ArrayAdapter(MainActivity.this, android.R.layout.simple_list_item_1,listItems);

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
                    textView.setText(error.toString());

                }
            })
            {

                @Override
                public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> headers = new HashMap<>();
                String credentials = "admin:admin";
                String auth = "Basic "
                        + Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);
                headers.put("Content-Type", "application/json");
                headers.put("Authorization", auth);
                return headers;
            }

         };

        requestQueue.add(objectRequest);


    }
    public void newBlogClick(View v){
        //create intent to start AddArticle activity
        Intent intent = new Intent(this, RegisterActivity.class);

        //start the AddArticle activity
        startActivity(intent);
    }
}
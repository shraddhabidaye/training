package com.example.basicapp;

import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        TextView textView = (TextView) findViewById(R.id.textView2);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        String URL="https://dev-team-shivaji.pantheonsite.io/api/blog_list?_format=json";
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        JsonObjectRequest objectRequest = new JsonObjectRequest(
                Request.Method.GET,
                URL,
                null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        Log.e("Rest Response",response.toString());
                        textView.setText(response.toString());

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("Rest Response",error.toString());
                       // textView.setText(error.toString());

                    }
                }


        );

        requestQueue.add(objectRequest);


    }
}
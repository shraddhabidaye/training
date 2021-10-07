package com.example.blog;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

public class CreateBlogActivity extends AppCompatActivity implements AdapterView.OnItemSelectedListener {
    String category,image,cookie,csrf_token,logout_token,credentials;
    Spinner spinner;
    EditText ed5;
    ImageView img;
    Bitmap bitmap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_blog);
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            cookie = extras.getString("cookie");
            Log.i("cookie",cookie);

            csrf_token = extras.getString("csrf_token");
            logout_token = extras.getString("logout_token");
            credentials = extras.getString("credentials");
            Log.i("csrf",csrf_token);
            Log.i("logout",logout_token);

        }
        img=(ImageView)findViewById(R.id.imageView1);
        spinner = findViewById(R.id.spinner1);
        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,
                R.array.blogCategory, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);
        spinner.setOnItemSelectedListener(this);

    }
    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        String text = parent.getItemAtPosition(position).toString();
        if(text.equals("Study")){
            category = "4";
        }
        if(text.equals("Travel")){
            category = "3";
        }
        if(text.equals("Political")){
            category = "2";
        }if(text.equals("Food")){
            category = "1";
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> parent) {

    }

    public void onSelectClick(View v)
    {
        if (ContextCompat.checkSelfPermission(CreateBlogActivity.this,
                Manifest.permission.READ_EXTERNAL_STORAGE)!= PackageManager.PERMISSION_GRANTED)
        {
            // when permission is nor granted
            // request permission
            ActivityCompat.requestPermissions(CreateBlogActivity.this
                    , new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},100);

        }
        else
        {
            // when permission
            // is granted
            // create method
            selectImage();
        }
    }
    public void selectImage()
    {
        //imageView.setImageBitmap(null);
        // Initialize intent
        Intent intent=new Intent(Intent.ACTION_PICK);
        // set type
        intent.setType("image/*");
        // start activity result
        startActivityForResult(Intent.createChooser(intent,"Select Image"),100);

    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);

        // check condition
        if (requestCode==100 && grantResults[0]==PackageManager.PERMISSION_GRANTED)
        {
            // when permission
            // is granted
            // call method
            selectImage();
        }
        else
        {
            // when permission is denied
            Toast.makeText(this, "Permission Denied", Toast.LENGTH_SHORT).show();
        }
    }

    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        // check condition
        if (requestCode==100 && resultCode==  RESULT_OK && data!=null)
        {
            // when result is ok
            // initialize uri
            Uri uri=data.getData();
            // Initialize bitmap
            try {
                InputStream inputStream=getContentResolver().openInputStream(uri);
                bitmap= BitmapFactory.decodeStream(inputStream);
                img.setImageBitmap(bitmap);

                ByteArrayOutputStream byteArrayOutputStream=new ByteArrayOutputStream();
                bitmap.compress(Bitmap.CompressFormat.JPEG,100,byteArrayOutputStream);
                byte[] bytesofimage=byteArrayOutputStream.toByteArray();
                image=android.util.Base64.encodeToString(bytesofimage, Base64.DEFAULT);



            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }
    public void onSaveClick(View v) throws JSONException {
        EditText ed1,ed2,ed3,ed4;
        ed1 = (EditText)findViewById(R.id.title);
        ed2 = (EditText)findViewById(R.id.body);
        ed3 = (EditText)findViewById(R.id.email);


        String title = ed1.getText().toString().trim();
        String body = ed2.getText().toString();
        String email = ed3.getText().toString();
        String filename , timeStamp = new SimpleDateFormat("yyyy-MM-dd_HH:mm:ss").format(new Date());
        filename =  timeStamp + "_.jpg";


        String url = "https://dev-team-shivaji.pantheonsite.io/api/create_blog?_format=json";

        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        JSONObject jsonobject = new JSONObject();

        jsonobject.put("title", title);
        jsonobject.put("body", body);
        jsonobject.put("email", email);
        jsonobject.put("category", category);
        jsonobject.put("image_filename",filename);
        jsonobject.put("image",image);

        // StringRequest stringRequest = new StringRequest(Request.Method.POST, url,new Response.Listener<String>() {
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.POST,url,jsonobject, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response)
            {

                img.setImageResource(R.drawable.ic_launcher_foreground);
                Log.e("Rest Response", response.toString());
                Toast.makeText(CreateBlogActivity.this,response.toString(), Toast.LENGTH_LONG).show();

            }
        },new Response.ErrorListener(){

            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e("Rest Response", error.toString());

                Toast.makeText(CreateBlogActivity.this,error.toString(), Toast.LENGTH_LONG).show();
            }
        })
        {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> headers = new HashMap<>();

                headers.put("X-CSRF-Token",csrf_token);
                headers.put("Content-Type", "application/json");
                headers.put("Cookie",cookie);
                String auth = "Basic "+ Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);
                headers.put("Authorization", auth);

                return headers;
            }

        };
        requestQueue.add(jsonObjReq);

    }

    public void onLogOutClick(View v)
    {
        String URL = "https://dev-team-shivaji.pantheonsite.io/user/logout?_format=json"+"&token="+logout_token;
        Log.i("url:",URL);
        RequestQueue requestQueue1 = Volley.newRequestQueue(this);
        JsonObjectRequest objectRequest1 = new JsonObjectRequest(Request.Method.POST, URL, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        Log.e("Rest Response", "Logged out");

                        Intent intent = new Intent(CreateBlogActivity.this, LoginActivity.class);

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

                //  headers.put("X-CSRF-Token",csrf_token);
                headers.put("Content-Type", "application/json");
                // headers.put("Cookie", cookie);
                return headers;
            }

        };
        requestQueue1.add(objectRequest1);
        Intent intent = new Intent(CreateBlogActivity.this,LoginActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);

    }

}
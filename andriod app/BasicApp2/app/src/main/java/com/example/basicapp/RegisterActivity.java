package com.example.basicapp;

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
import android.provider.MediaStore;
import android.text.Editable;
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
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.HashMap;
import java.util.Locale;
import java.util.Map;

public class RegisterActivity extends AppCompatActivity implements AdapterView.OnItemSelectedListener {
    String category,image;
    //ImageView imageView;
    Spinner spinner;
    EditText ed5;
    ImageView img;
    Bitmap bitmap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        img=(ImageView)findViewById(R.id.imageView);
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
        if (ContextCompat.checkSelfPermission(RegisterActivity.this,
                Manifest.permission.READ_EXTERNAL_STORAGE)!= PackageManager.PERMISSION_GRANTED)
        {
            // when permission is nor granted
            // request permission
            ActivityCompat.requestPermissions(RegisterActivity.this
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
        startActivityForResult(Intent.createChooser(intent,"Select Image"),1);

    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull  String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);

        // check condition
        if (requestCode==1 && grantResults[0]==PackageManager.PERMISSION_GRANTED)
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
        if (requestCode==1 && resultCode==RESULT_OK && data!=null)
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

//
//                Bitmap bitmap= MediaStore.Images.Media.getBitmap(getContentResolver(),uri);
//                // initialize byte stream
//                ByteArrayOutputStream stream=new ByteArrayOutputStream();
//                // compress Bitmap
//                bitmap.compress(Bitmap.CompressFormat.JPEG,100,stream);
//                // Initialize byte array
//                byte[] bytes=stream.toByteArray();
//                // get base64 encoded string
//                image= Base64.encodeToString(bytes,Base64.DEFAULT);
//                ed5 = findViewById(R.id.editText5);
////               System.out.println(image);


            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    public void onSaveClick(View v) throws JSONException {
        EditText ed1,ed2,ed3,ed4;
        ed1 = (EditText)findViewById(R.id.editText1);
        ed2 = (EditText)findViewById(R.id.editText2);
        ed3 = (EditText)findViewById(R.id.editText3);
        ed4 = (EditText)findViewById(R.id.editText4);

        String title = ed1.getText().toString().trim();
        String body = ed2.getText().toString();
        String email = ed3.getText().toString();
        String image_filename = ed4.getText().toString();


        String url = "https://dev-team-shivaji.pantheonsite.io/api/create_blog?_format=json";

        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        JSONObject jsonobject = new JSONObject();

        jsonobject.put("title", title);
        jsonobject.put("body", body);
        jsonobject.put("email", email);
        jsonobject.put("category", category);
        jsonobject.put("image_file",image_filename);
        jsonobject.put("image",image);

       // StringRequest stringRequest = new StringRequest(Request.Method.POST, url,new Response.Listener<String>() {
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.POST,url,jsonobject, new Response.Listener<JSONObject>() {
        @Override
            public void onResponse(JSONObject response)
            {

                img.setImageResource(R.drawable.ic_launcher_foreground);
                Log.e("Rest Response", response.toString());
                Toast.makeText(RegisterActivity.this,response.toString(), Toast.LENGTH_LONG).show();

            }
        },new Response.ErrorListener(){

            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e("Rest Response", error.toString());

                Toast.makeText(RegisterActivity.this,error.toString(), Toast.LENGTH_LONG).show();
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

//            @Override
//            protected Map<String, String > getParams() {
//
//                Map<String, String> params = new HashMap<String, String>();
//                params.put("title", title);
//                params.put("body", body);
//                params.put("email", email);
//                params.put("category",category);
//              //  params.put("image",image );
//               // params.put("image_filename", image_filename);
//
//                return params;
//            }




        };
        requestQueue.add(jsonObjReq);

    }


}
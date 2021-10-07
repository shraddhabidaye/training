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
import android.widget.EditText;
import android.widget.ImageView;
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

public class RegisterActivity extends AppCompatActivity {

    EditText ed1,ed2;
    ImageView img;
    Bitmap bitmap;
    String username,mail,image;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        ed1 = (EditText)findViewById(R.id.editTextTextPersonName);
        ed2 = (EditText)findViewById(R.id.editTextTextPersonName2);
        img=(ImageView)findViewById(R.id.imageView);

    }

    public void onUploadClick(View v)
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
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
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


            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    public void onRegisterClick(View v) throws JSONException {
        username = ed1.getText().toString();
        mail = ed2.getText().toString();
        String filename , timeStamp = new SimpleDateFormat("yyyy-MM-dd_HH:mm:ss").format(new Date());
       filename =  timeStamp + "_.jpg";

        String url = "https://dev-team-shivaji.pantheonsite.io/api/register?_format=json";

        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        JSONObject jsonobject = new JSONObject();

        jsonobject.put("name", username);
        jsonobject.put("mail", mail);
        jsonobject.put("image",image);
        jsonobject.put("image_filename",filename);
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
                headers.put("Content-Type", "application/json");

                return headers;
            }

        };
        requestQueue.add(jsonObjReq);

    }
    public void onLogin(View v)
    {
        Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);

        startActivity(intent);

    }


}
package com.cassiano.sketcher;

import android.app.Activity;
import android.content.SharedPreferences;
import android.os.AsyncTask;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Cassiano on 11/16/2014.
 */
public class DataManagement {
    public static final String PREFS_NAME = "SketcherPreferences";

    public static String CreateUser() throws IOException {
        HttpClient httpclient = new DefaultHttpClient();
        // specify the URL you want to post to
        HttpPost httppost = new HttpPost("http://creativetree.esy.es/php/system.php");
        //HttpResponse response = null;
        String response = null;
        try {
            List nameValuePairs = new ArrayList();
            nameValuePairs.add(new BasicNameValuePair("function", "CreateUser"));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler=new BasicResponseHandler();
            response = httpclient.execute(httppost,responseHandler);

        } catch (ClientProtocolException e) {
            // process execption
        } catch (IOException e) {
            e.printStackTrace();
        }
        //return GetResult(response);
        //if(response.getStatusLine().getStatusCode()==200)
           return response;

        //else{
          // return null;
        //}
    }

    /***
     * This method will post the file
     * @param data
     * @param title
     * @param comment
     * @return
     * @throws IOException
     */
    public static String UploadImage(String user_code, String data, String title, String comment, String category) throws IOException {
        HttpClient httpclient = new DefaultHttpClient();
        // specify the URL you want to post to
        HttpPost httppost = new HttpPost("http://creativetree.esy.es/php/system.php");
        //HttpResponse response = null;
        String response = null;
        try {
            List nameValuePairs = new ArrayList();
            nameValuePairs.add(new BasicNameValuePair("function", "AddImage"));
            nameValuePairs.add(new BasicNameValuePair("data", data));
            nameValuePairs.add(new BasicNameValuePair("title", title));
            nameValuePairs.add(new BasicNameValuePair("comment", comment));
            nameValuePairs.add(new BasicNameValuePair("author", user_code));
            nameValuePairs.add(new BasicNameValuePair("category", category));

            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler=new BasicResponseHandler();
            response = httpclient.execute(httppost,responseHandler);

        } catch (ClientProtocolException e) {
            // process execption
        } catch (IOException e) {
            e.printStackTrace();
        }
        //return GetResult(response);
        //if(response.getStatusLine().getStatusCode()==200)
        return response;

        //else{
        // return null;
        //}
    }

}

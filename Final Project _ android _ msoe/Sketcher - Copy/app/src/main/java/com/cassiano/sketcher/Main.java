package com.cassiano.sketcher;

import android.app.Activity;
import android.app.Fragment;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.JavascriptInterface;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageButton;
import android.widget.RelativeLayout;
import android.widget.Toast;

import java.io.IOException;


public class Main extends Activity {
    LoadingFragment loadingFragment=null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_main);
        //Loading user code


        //Loading webpage
        WebView webview = (WebView) findViewById(R.id.webView);
        webview.getSettings().setJavaScriptEnabled(true);
        webview.setWebViewClient(new WebViewClient());

        String summary = "<html><body>Loading data...</body></html>";
        webview.loadData(summary, "text/html", "utf-8");
        String listImages = "http://creativetree.esy.es/php/listImages.php";
        webview.loadUrl(listImages);
        //if(webview.)
        //ShowLoading();
    }

    public void OnClickNext(View view){
        //
        SharedPreferences settings = getSharedPreferences(DataManagement.PREFS_NAME, Activity.MODE_PRIVATE);
        String user_code = settings.getString("user_code", null);
        Log.v("Main","Current User code: "+user_code);
        SketcherDriver.setUser_code(user_code);
        if(user_code==null){
            //Create new User;
            new CreateUserTask().execute();
            ShowLoading();
            Log.v("Main","Creating User");
        }
        else{
            Log.v("Main","User exists");
            //Load Drawing Activity
            StartDrawing();
        }
        //boolean silent = settings.getBoolean("silentMode", false);


    }

    public void StartDrawing(){
        Intent intent = new Intent(this, MyActivity.class);
        startActivity(intent);
    }


    private void ShowLoading(){
       loadingFragment = loadingFragment.newInstance();
       getFragmentManager().beginTransaction().add(findViewById(R.id.rootMain).getId(),loadingFragment).commit();
    }

    private void RemoveLoading(){
        if(loadingFragment!=null)
            getFragmentManager().beginTransaction().remove(loadingFragment).commit();
    }

    private class CreateUserTask extends AsyncTask<Object,Integer,String> {
        @Override
        protected String doInBackground(Object[] objects) {
            // TODO Auto-generated method stub
            //postData(params[0]);
            try {
                return DataManagement.CreateUser();
            } catch (IOException e) {
                e.printStackTrace();
            }
            //ShowLoading();
            return null;
        }

        protected void onPostExecute(String result){
            Log.v("PHP Result",result);
            if(result!="ERROR"){
                SharedPreferences settings = getSharedPreferences(DataManagement.PREFS_NAME, Activity.MODE_PRIVATE);
                SharedPreferences.Editor editor = settings.edit();
                editor.putString("user_code", result);
                editor.commit();

                Log.v("Main","user code updated: " + result);
                //editor.remove("user_code"); //USED TO CLEAR THE user_code
                StartDrawing();

            }
            else{
                Log.e("Error","Error on the php page");
            }
            RemoveLoading();

        }

        protected void onProgressUpdate(Integer... progress){
            //pb.setProgress(progress[0]);
          //  if(loading==false){
             //   ShowLoading();
           // }

        }

    }

    //handling web requests
    public class WebAppInterface {
        Context mContext;

        /** Instantiate the interface and set the context */
        WebAppInterface(Context c) {
            mContext = c;
        }

        /** Show a toast from the web page */
        @JavascriptInterface
        public void showToast(String toast) {
            Toast.makeText(mContext, toast, Toast.LENGTH_SHORT).show();
        }
    }

    public void RefreshView (View view){
        WebView webview = (WebView) findViewById(R.id.webView);
        webview.getSettings().setJavaScriptEnabled(true);
        webview.setWebViewClient(new WebViewClient());
        String listImages = "http://creativetree.esy.es/php/listImages.php";
        webview.loadUrl(listImages);
    }
}

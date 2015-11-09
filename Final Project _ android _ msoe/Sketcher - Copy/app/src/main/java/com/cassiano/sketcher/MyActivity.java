package com.cassiano.sketcher;

import android.app.Activity;
import android.content.SharedPreferences;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Toast;

import java.io.IOException;


public class MyActivity extends Activity {
    // Add fragmentView
    // getFragmentManager().beginTransaction().add(ll.getId(), TestFragment.newInstance("I am frag 2"), "someTag2").commit();
    private int windowState = 0;
    //buttons
    ImageButton btnSettings;
    DrawingView drawing;
    CommentFragment commentFragment;
    LoadingFragment loadingFragment;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        requestWindowFeature(Window.FEATURE_NO_TITLE);

        setContentView(R.layout.activity_my);
        btnSettings = (ImageButton) findViewById(R.id.btn_config);
        btnSettings.setFocusable(false);
        drawing = (DrawingView) findViewById(R.id.drawing);
        //btnSettings.setFocusableInTouchMode(false);
    }

    private MenuSettings menuSettings;

    public void onClickSetup(View view){
        //etFragmentManager().beginTransaction().add(ll.getId(), TestFragment.newInstance("I am frag 2"), "someTag2").commit();
        if(SketcherDriver.windowState==0) {
           menuSettings = MenuSettings.newInstance(this,"aa", "bb");
           getFragmentManager().beginTransaction().add(findViewById(R.id.root).getId(), menuSettings).commit();
           SketcherDriver.windowState=1;
            //btnSettings.setBackground(getResources().getDrawable(R.drawable.button_blue_pressed));

           // btnSettings.setScaleType(ImageView.ScaleType.FIT_CENTER);
           // int padding = getResources().getDimensionPixelOffset(R.dimen.button_padding);
            //btnSettings.setPadding(padding,padding,padding,padding);

        }

        else{
            getFragmentManager().beginTransaction().remove(menuSettings).commit();
            SketcherDriver.windowState=0;

           // btnSettings.setBackground(getResources().getDrawable(R.drawable.button_blue_style));

           // btnSettings.setScaleType(ImageView.ScaleType.FIT_CENTER);
           // int padding = getResources().getDimensionPixelOffset(R.dimen.button_padding);
            //btnSettings.setPadding(padding,padding,padding,padding);

        }

    }

    public void RemoveSettingsWindow(){
        getFragmentManager().beginTransaction().remove(menuSettings).commit();
        SketcherDriver.windowState=0;
        //btnSettings.setBackground(getResources().getDrawable(R.drawable.button_blue_style));
        //btnSettings.setScaleType(ImageView.ScaleType.FIT_CENTER);
        //int padding = getResources().getDimensionPixelOffset(R.dimen.button_padding);
        //btnSettings.setPadding(padding,padding,padding,padding);

    }

    public void UpdatePen(int selected_pen){
        SketcherDriver.setSelectedPen(selected_pen);
        drawing.UpdatePen(selected_pen);
    }

    public void OnClickComment(View view){
        commentFragment = CommentFragment.newInstance(this);
        getFragmentManager().beginTransaction().add(findViewById(R.id.root).getId(),commentFragment).commit();
    }

   public void RemoveCommentWindow(){
       if(commentFragment!=null)
            getFragmentManager().beginTransaction().remove(commentFragment).commit();
   }

    //Loading
    private void ShowLoading(){
        loadingFragment = loadingFragment.newInstance();
        getFragmentManager().beginTransaction().add(findViewById(R.id.root).getId(),loadingFragment).commit();
    }

    private void RemoveLoading(){
        if(loadingFragment!=null)
            getFragmentManager().beginTransaction().remove(loadingFragment).commit();
    }


    /***
     * This method will be called by the comment window (CommentFragment.java)
     * @param title - defined in the commment window
     * @param comment - defined in the commment window
     */
    public void ShareImage(String title, String comment, String category){
        String enconded = drawing.getEncodedBitmap();
        RemoveCommentWindow();
        ShowLoading();

        new UploadImage().execute(SketcherDriver.getUser_code(),enconded,title,comment, category);
    }

    public void FinishDraw(){
        Toast.makeText(getApplicationContext(),"Image uploaded with success",Toast.LENGTH_SHORT).show();
    }
    private class UploadImage extends AsyncTask<String,Integer,String> {
        @Override
        protected String doInBackground(String... params) {
            // TODO Auto-generated method stub
            //postData(params[0]);
            try {
                return DataManagement.UploadImage(params[0],params[1],params[2],params[3],params[4]);
            } catch (IOException e) {
                e.printStackTrace();
            }
            //ShowLoading();
            return null;
        }

        protected void onPostExecute(String result){
            Log.v("PHP Result", result);
           /* if(result!="ERROR"){
                SharedPreferences settings = getSharedPreferences(DataManagement.PREFS_NAME, Activity.MODE_PRIVATE);
                SharedPreferences.Editor editor = settings.edit();
                editor.putString("user_code", result);
                editor.commit();

                Log.v("Main","user code updated: " + result);
                //editor.remove("user_code"); //USED TO CLEAR THE user_code
                //StartDrawing();

            }
            else{
                Log.e("Error","Error on the php page");
            }
           // RemoveLoading();
            */
            RemoveLoading();
            FinishDraw();
        }

        protected void onProgressUpdate(Integer... progress){
        }

    }
}

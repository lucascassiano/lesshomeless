package com.cassiano.sketcher;

import android.app.Activity;
import android.graphics.Color;
import android.os.Bundle;
import android.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.SeekBar;


/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link MenuSettings.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link MenuSettings#newInstance} factory method to
 * create an instance of this fragment.
 *
 */
public class MenuSettings extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private static MyActivity parent;

    //RGB Colors bars
    private SeekBar redBar;
    private SeekBar greenBar;
    private SeekBar blueBar;
    private ImageView colorPreview;

    private SeekBar sizeBar;

    //Colors
    private int red=0;
    private int green=0;
    private int blue=0;

    //penSize
    private int penSize=1;

    //Tools
    private ImageButton tool0;
    private ImageButton tool1;
    private ImageButton tool2;
    private ImageButton tool3;

    //Selected tool
    private int selectedTool =0;

    //private OnFragmentInteractionListener mListener;

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment MenuSettings.
     */
    // TODO: Rename and change types and number of parameters
    public static MenuSettings newInstance(MyActivity p, String param1, String param2) {
        MenuSettings fragment = new MenuSettings();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        parent = p;
        return fragment;
    }
    public MenuSettings() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }


    }

    private void switchTool(ImageButton t,boolean enable){
        if(enable){
            t.setBackground(getResources().getDrawable(R.drawable.button_square_blue));
            t.setScaleType(ImageView.ScaleType.FIT_CENTER);
            int padding = getResources().getDimensionPixelOffset(R.dimen.button_padding);
            t.setPadding(padding,padding,padding,padding);
        }
        else {
            t.setBackground(getResources().getDrawable(R.drawable.button_square_blue_desabled));
            t.setScaleType(ImageView.ScaleType.FIT_CENTER);
            int padding = getResources().getDimensionPixelOffset(R.dimen.button_padding);
            t.setPadding(padding, padding, padding, padding);
        }
     }

    public void setTool(int tool){
        switch (tool){
            case 0:
                switchTool(tool0,true);
                switchTool(tool1,false);
                switchTool(tool2,false);
                switchTool(tool3,false);
                break;
            case 1:
                switchTool(tool0,false);
                switchTool(tool1,true);
                switchTool(tool2,false);
                switchTool(tool3,false);
                break;
            case 2:
                switchTool(tool0,false);
                switchTool(tool1,false);
                switchTool(tool2,true);
                switchTool(tool3,false);
                break;
            case 3:
                switchTool(tool0,false);
                switchTool(tool1,false);
                switchTool(tool2,false);
                switchTool(tool3,true);
                break;
        }

        selectedTool = tool;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View root =inflater.inflate(R.layout.fragment_menu_settings, container, false);

        //tools
        tool0 = (ImageButton) root.findViewById(R.id.tool0);
        tool1 = (ImageButton) root.findViewById(R.id.tool1);
        tool2 = (ImageButton) root.findViewById(R.id.tool2);
        tool3 = (ImageButton) root.findViewById(R.id.tool3);
        setTool(0);
        tool0.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                setTool(0);
            }
        });
        tool1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                setTool(1);
            }
        });
        tool2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                setTool(2);
            }
        });
        tool3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                setTool(3);
            }
        });

        redBar = (SeekBar) root.findViewById(R.id.seekBarRed);
        greenBar = (SeekBar) root.findViewById(R.id.seekBarGreen);
        blueBar = (SeekBar) root.findViewById(R.id.seekBarBlue);
        colorPreview = (ImageView) root.findViewById(R.id.colorPreview);

        sizeBar = (SeekBar) root.findViewById(R.id.seekBar);
        sizeBar.setMax(50);

       // redBar.getProgressDrawable().setColorFilter(new PorterDuffColorFilter(Color.RED, PorterDuff.Mode.ADD));
        //Change color
        loadSettings();
        redBar.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int i, boolean b){
                red = i;
                Log.v("Red","value: "+i);
                colorPreview.setBackgroundColor(Color.rgb(red, green, blue));
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {

            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {

            }
        });

        greenBar.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int i, boolean b){
                green = i;
                Log.v("green","value: "+i);
                colorPreview.setBackgroundColor(Color.rgb(red,green,blue));
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {

            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {

            }
        });

        blueBar.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int i, boolean b){
                blue = i;
                Log.v("blue","value: "+i);
                colorPreview.setBackgroundColor(Color.rgb(red,green,blue));
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {

            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {

            }
        });

        sizeBar.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int i, boolean b) {
                penSize = i;

            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {

            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {

            }
        });


        Button btn = (Button) root.findViewById(R.id.buttonOk);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                OnClickOk(view);
            }
        });

        return root;
    }

    private void loadSettings(){
        this.red=SketcherDriver.getPenRed();
        this.green = SketcherDriver.getPenGreen();
        this.blue = SketcherDriver.getPenBlue();
        this.penSize = SketcherDriver.getPenSize();
        redBar.setProgress(red);
        greenBar.setProgress(green);
        blueBar.setProgress(blue);
        sizeBar.setProgress(penSize);
        setTool(SketcherDriver.getSelectedPen());
    }

    public void OnClickOk(View view){
        saveSettings();
        this.parent.UpdatePen(selectedTool);
        this.parent.RemoveSettingsWindow();

    }

    private void saveSettings(){
        SketcherDriver.setPenRed(red);
        SketcherDriver.setPenGreen(green);
        SketcherDriver.setPenBlue(blue);
        SketcherDriver.setPenSize(penSize);

    }
    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
    }

    @Override
    public void onDetach() {
        super.onDetach();
    }

    /**
     * This interface must be implemented by activities that contain this
     * fragment to allow an interaction in this fragment to be communicated
     * to the activity and potentially other fragments contained in that
     * activity.
     * <p>
     * See the Android Training lesson <a href=
     * "http://developer.android.com/training/basics/fragments/communicating.html"
     * >Communicating with Other Fragments</a> for more information.
     */
    /*
    public interface OnFragmentInteractionListener {
        //TODO: Update argument type and name

        public void onFragmentInteraction(Uri uri);
    }
    */
}
